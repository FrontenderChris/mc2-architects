<?php
namespace Modulatte\Sections\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modulatte\Sections\Http\Requests\SaveSectionRequest;
use Modulatte\Pages\Models\Page;
use Modulatte\Sections\Models\Section;

class SectionController extends Controller
{
    /**
     * @param $form
     * @param $pageId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($form, $pageId)
    {
        $page = Page::findOrFail($pageId);
        $forms = sectionForms();
        if (!in_array($form, $forms))
            abort(404);

        return view('sections::section.create', compact('form', 'page'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $model = Section::with('image')->findOrFail($id);
        $form = $model->form;

        return view('sections::section.edit', compact('model', 'form'));
    }

    /**
     * @param SaveSectionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveSectionRequest $request)
    {
        $data = $request->all();
        $page = Page::findOrFail($data['page_id']);
        $model = Section::create($data);
        $this->saveImages($model, $data);

        if($page->form == '_projects') {
            return redirect()->route('admin.projects.edit', [$page->id, 'section' => 1]);
        }

        return redirect()->route('admin.pages.edit', [$page->id, 'section' => 1]);
    }

    /**
     * @param $id
     * @param SaveSectionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, SaveSectionRequest $request)
    {
        $model = Section::findOrFail($id);
        $data = $request->all();
        $model->update($data);
        $this->saveImages($model, $data);
        
        if($model->form == '_image') {
            return redirect()->route('admin.projects.edit', [$model->page->id, 'section' => 1]);
        }

        return redirect()->route('admin.pages.edit', [$model->page->id, 'section' => 1]);
    }

    /**
     * @param $id
     * @return array
     */
    public function toggleVisibility($id)
    {
        $model = Section::findOrFail($id);

        if ($model->is_enabled)
            $model->is_enabled = 0;
        else
            $model->is_enabled = 1;

        $model->save();

        return ['status' => 'success', 'data' => $model];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function sort(Request $request)
    {
        if ($request->has('sections')) {
            $i = 1;
            foreach ($request->get('sections') as $id)
            {
                $model = Section::find($id);
                $model->sort_order = $i;
                $model->save();
                $i++;
            }

        }

        return ['status' => 'success'];
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id, Request $request)
    {
        $model = Section::findOrFail($id);

        if ($request->ajax()) {
            $model->delete();

            return response(['msg' => 'Item deleted.', 'status' => 'success']);
        }

        return response(['msg' => 'Failed to delete this item.', 'status' => 'failed']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRowHtml($id)
    {
        $model = Section::findOrFail($id);

        return view('sections::section._row', compact('model'));
    }

    /**
     * @param Section $model
     * @param $data
     */
    protected function saveImages(Section $model, $data)
    {
        if (!empty($data['image']['file'])) {
            Image::saveCroppedImage(
                $model,
                $data['image']['file']
            );
        }

        if (!empty($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $title => $file) {
                if (!empty($file)) {
                    Image::saveCroppedImage(
                        $model,
                        $file,
                        ['title' => (!is_numeric($title) ? $title : $file)]
                    );
                }
            }
        }
    }
}
