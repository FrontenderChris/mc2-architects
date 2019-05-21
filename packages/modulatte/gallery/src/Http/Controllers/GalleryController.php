<?php
namespace Modulatte\Gallery\Http\Controllers;

use App\Models\Image;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modulatte\Gallery\Http\Requests\SaveGalleryRequest;

class GalleryController extends Controller
{
    /**
     * @param $class
     * @param $id
     * @param $width
     * @param $height
     * @param $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($class, $id, $width, $height, $route)
    {
        $parent = $this->getModel($class, $id);
        $route = decodeSlashes($route);

        return view('gallery::gallery.create', compact('parent', 'width', 'height', 'route'));
    }

    /**
     * @param $id
     * @param $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, $route)
    {
        $model = Image::findOrFail($id);
        $route = decodeSlashes($route);

        return view('gallery::gallery.edit', compact('model', 'route'));
    }

    /**
     * @param SaveGalleryRequest $request
     * @return array
     */
    public function store(SaveGalleryRequest $request)
    {
        $model = $this->getModel($request->get('class'), $request->get('id'));
        $route = $request->get('route');
        $data = $request->all();

        $image = Image::where('file', $data['image']['file'])->first();
        $image->update($data);
        $model->images()->save($image);

        return redirect($route . '?gallery=1');
    }

    /**
     * @param $id
     * @param SaveGalleryRequest $request
     * @return array
     */
    public function update($id, SaveGalleryRequest $request)
    {
        $model = Image::findOrFail($id);
        $route = $request->get('route');

        $data = $request->all();
        if (isset($data['image']['file']) && empty($data['image']['file']))
            unset($data['image']['file']);

        if (!empty($data['image']['file'])) {
            $this->deleteImage($model);
            $data['file'] = $data['image']['file'];
        }

        $model->update($data);

        return redirect($route . '?gallery=1');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRowHtml($id)
    {
        $model = Image::findOrFail($id);

        return view('gallery::partials._row', compact('model'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id, Request $request)
    {
        $model = Image::findOrFail($id);

        if ($request->ajax()) {
            $model->delete();

            return response(['msg' => 'Item deleted.', 'status' => 'success']);
        }

        return response(['msg' => 'Failed to delete this item.', 'status' => 'failed']);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function sort(Request $request)
    {
        $i = 1;
        foreach ($request->get('gallery') as $id)
        {
            $model = Image::find($id);
            $model->sort_order = $i;
            $model->save();
            $i++;
        }

        return ['status' => 'success'];
    }

    /**
     * @param $class
     * @param $id
     * @return mixed
     */
    protected function getModel($class, $id)
    {
        $className = decodeSlashes($class, '\\');
        $model = $className::with('images')->findOrFail($id);

        return $model;
    }

    /**
     * @param Image $model
     */
    protected function deleteImage(Image $model)
    {
        $file = Image::getPath() . $model->file;
        if (\File::exists($file) && Image::where('file', '=', $model->file)->count() <= 1)
            \File::delete($file);
    }
}