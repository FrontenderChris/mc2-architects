<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Admin\SaveRedirectRequest;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $redirects = Redirect::all();

        return view('redirects.index', compact('redirects'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('redirects.create');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $model = Redirect::findOrFail($id);

        return view('redirects.edit', compact('model'));
    }

    /**
     * @param SaveRedirectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveRedirectRequest $request)
    {
        $data = [];
        $data['redirect_from'] = $this->filter($request->get('redirect_from'));
        $data['redirect_to'] = $this->filter($request->get('redirect_to'));
        Redirect::create($data);

        return redirect()->route('admin.redirects.index');
    }

    /**
     * @param $id
     * @param SaveRedirectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, SaveRedirectRequest $request)
    {
        $model = Redirect::findOrFail($id);
        $data = [];
        $data['redirect_from'] = $this->filter($request->get('redirect_from'));
        $data['redirect_to'] = $this->filter($request->get('redirect_to'));
        $model->update($data);

        return redirect()->route('admin.redirects.index');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id, Request $request)
    {
        $model = Redirect::findOrFail($id);

        if ($request->ajax()) {
            $model->delete();

            return response(['msg' => 'Item deleted.', 'status' => 'success']);
        }

        return response(['msg' => 'Failed to delete this item.', 'status' => 'failed']);
    }

    /**
     * @param $id
     * @return array
     */
    public function toggleVisibility($id)
    {
        $model = Redirect::findOrFail($id);

        if ($model->is_enabled)
            $model->is_enabled = 0;
        else
            $model->is_enabled = 1;

        $model->save();

        return ['status' => 'success', 'data' => $model];
    }

    /**
     * @param $string
     * @return string
     */
    public function filter($string)
    {
        if (strpos($string, '/') === 0)
            return substr($string, 1);

        return $string;
    }
}
