<?php

namespace Modulatte\Categories\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Seo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modulatte\Categories\Models\Category;
use Modulatte\Categories\Http\Requests\SaveCategoryRequest;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->has('search'))
            return $this->search($request->get('search'));

        $categories = Category::getParentsOnly();
        return view('categories::admin.category.index', compact('categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $category = new Category;

        return view('categories::admin.category.create', compact('category'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $model = Category::with('seo', 'image')->findOrFail($id);

        return view('categories::admin.category.edit', compact('model'));
    }

    /**
     * @param SaveCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveCategoryRequest $request)
    {
        $data = $request->all();
        $category = Category::create($data);
        $this->saveImages($category, $data);
        Seo::saveSeo($category, $data);

        return redirect()->route('admin.categories.index');
    }

    /**
     * @param $id
     * @param SaveCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, SaveCategoryRequest $request)
    {
        $category = Category::findOrFail($id);
        $data = $request->all();
        $category->update($data);
        $this->saveImages($category, $data);
        Seo::saveSeo($category, $data);

        return redirect()->route('admin.categories.index');
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateParent($id, Request $request)
    {
        $category = Category::findOrFail($id);
        $data = $request->all();
        $category->update($data);

        return ['status' => 'success'];
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id, Request $request)
    {
        $category = Category::findOrFail($id);

        if ($request->ajax()) {
            $category->delete();

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
        if ($request->has('categories')) {
            $i = 1;
            foreach ($request->get('categories') as $id)
            {
                $model = Category::find($id);
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
        $category = Category::findOrFail($id);

        if ($category->is_enabled)
            $category->is_enabled = 0;
        else
            $category->is_enabled = 1;

        $category->save();

        return ['status' => 'success', 'data' => $category];
    }

    /**
     * @param Category $model
     * @return Category|\Illuminate\Database\Eloquent\Model
     */
    protected function saveImages(Category $model, $data)
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

    /**
     * @param $search
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function search($search)
    {
        $search = trim($search);
        $query = '%' . $search . '%';
        $categories = Category::where('title', 'LIKE', $query)
            ->orWhere('data', 'LIKE', $query)
            ->paginate(config('app.pagination'));

        return view('categories::admin.category.index', compact('categories', 'search'));
    }
}
