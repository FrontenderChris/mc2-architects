<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
    {
    	$users = User::orderBy('created_at', 'desc')
    	   ->paginate(10);

    	return view('user.index', compact('users'));
    }

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function create()
    {
    	return view('user.create');
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(Request $request)
    {
		$data = $request->all();

		if (isset($data['user'])) {
			if ($data['user']['password'] != $data['user']['confirm_password']) {
				return redirect()->route('admin.users.create')
								->with('error-msg', 'Passwords do not match.');
			}

			if (User::where('email', '=', $data['user']['email'])->first()) {
				return redirect()->route('admin.users.create')
					->with('error-msg', 'This email address is already in use.');
			}
		} else {
			return redirect()->route('admin.users.create')
								->with('error-msg', 'No post data for user.');
		}

		$data['user']['password'] = Hash::make($data['user']['password']);
		$user = User::create($data['user']);

        if (hasLoginPackage() && !empty($data['role_id'])) {
            $user->role_id = $data['role_id'];
            $user->save();
        }

		return redirect()->route('admin.users.index')
					->with('success-msg', 'New User has been added');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
		$user = User::findOrFail($id);
		return view('user.edit', compact('user'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
    	$user = User::findOrFail($id);
    	$data = $request->all();
    	$user->name = $data['user']['name'];
    	$user->email = $data['user']['email'];
		if (hasLoginPackage() && !empty($data['role_id']))
			$user->role_id = $data['role_id'];

    	if ($data['user']['password'] !="" && $data['user']['confirm_password'] !="") {
    		if ($data['user']['password'] != $data['user']['confirm_password']) {
    			return redirect()->route('admin.users.edit', $user->id)
    					->with('error-msg', 'Passwords do not match.');
    		}
    		$user->password = Hash::make($data['user']['password']);
    	} else {
    		//we don't change the password if user did not place anything
    		unset($data['user']['password']);
    		unset($data['user']['confirm_password']);
    	}
    	$user->save();
    	return redirect()->route('admin.users.edit', $user->id)
    					->with('success-msg', 'User credentials has been updated');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->ajax()) {
            $user->delete();
            return response(['msg' => 'User has been deleted.', 'status' => 'success']);
        }
        return response(['msg' => 'Failed to delete this user.', 'status' => 'failed']);
    }
}