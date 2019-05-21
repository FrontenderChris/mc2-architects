<?php
namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function subscribe(Request $request)
    {
        $validator = \Validator::make(
            ['email' => $request->get('email')],
            ['email' => 'required|email']
        );

        if ($validator->passes()) {
            $data = $request->all();
            if (!Subscriber::noRelation()->email($request->get('email'))->first())
                Subscriber::create($data);
            return ['status' => 'success'];
        }
        else {
            return ['status' => 'error', 'error' => $validator->errors()->all()];
        }
    }

    /**
     * Id will be encrypted to prevent malicious behaviour
     * @param $email
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unsubscribe($email, $id)
    {
        if ($id = Subscriber::decrypt($id)) {
            if ($subscriber = Subscriber::where('id', '=', $id)->where('email', '=', $email)->first()) {
                $subscriber->delete();

                return view('subscribe.unsubscribe', compact('email'));
            }
        }

        abort(404);
    }
}
