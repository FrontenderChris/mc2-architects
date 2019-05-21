<?php
namespace Modulatte\Pages\Http\Controllers;

use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Seo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modulatte\Pages\Models\Page;
use Modulatte\Pages\Http\Requests\SavePageRequest;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pages = Page::whereNull('parent_id')->where('form', '!=', '_projects')->where('slug', '!=', 'projects')->get();

        return view('pages::page.index', compact('pages'));
    }

    /**
     * @param string $form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($form)
    {
        $forms = pageForms();
        if (!in_array($form, $forms))
            abort(404);

        return view('pages::page.create', compact('form'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $model = Page::with('seo', 'image')->findOrFail($id);
        $form = $model->form;

        return view('pages::page.edit', compact('model', 'form'));
    }

    /**
     * @param SavePageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SavePageRequest $request)
    {

        $data = $request->all();
        $data['is_dynamic'] = 1;

        $page = Page::create($data);
        Seo::saveSeo($page, $data);
        $this->saveImages($page, $data);

        if(request('categories')) {
            storeProjectCategories(request('categories'),$page);
        }

        if ($request->has('redirectBack'))
            return redirect()->route('admin.pages.edit', $page->id)->with('success-msg', 'Page successfully created.');

        return redirect()->route('admin.pages.index');
    }

    /**
     * @param $id
     * @param SavePageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, SavePageRequest $request)
    {
        $page = Page::findOrFail($id);
        $data = $request->all();
        $page->update($data);
        Seo::saveSeo($page, $data);
        $this->saveImages($page, $data);

        if(request('categories')) {
            storeProjectCategories(request('categories'),$page);
        }

        return redirect()->route('admin.pages.index');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id, Request $request)
    {
        $model = Page::findOrFail($id);

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
        if ($request->has('pages')) {
            $i = 1;
            foreach ($request->get('pages') as $id)
            {
                $model = Page::find($id);
                $model->sort_order = $i;
                $model->save();
                $i++;
            }

        }

        return ['status' => 'success'];
    }

    /**
     * @param $id
     * @return array
     */
    public function toggleVisibility($id)
    {
        $page = Page::findOrFail($id);

        if ($page->is_enabled)
            $page->is_enabled = 0;
        else
            $page->is_enabled = 1;

        $page->save();

        return ['status' => 'success', 'data' => $page];
    }

    /**
     * @param Page $model
     * @param $data
     */
    protected function saveImages(Page $model, $data)
    {
        if (!empty($data['image']['file'])) {
            Image::saveCroppedImage(
                $model,
                $data['image']['file']
            );
        }

        if (!empty($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $title => $file) {
                Image::saveCroppedImage(
                    $model,
                    $file,
                    ['title' => (!is_numeric($title) ? $title : $file)]
                );
            }
        }
    }
}
