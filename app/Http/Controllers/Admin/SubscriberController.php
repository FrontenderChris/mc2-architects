<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search'))
            return $this->search($request->get('search'));

        $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(config('app.pagination'));

        return view('subscriber.index', compact('subscribers'));
    }

    public function export()
    {
        Excel::create('subscribers-' . time(), function($excel) {
            $excel->sheet('Sheet1', function($sheet) {
                $subscribers = Subscriber::orderBy('created_at', 'desc')->get();
                $data[] = [
                    "Name",
                    "Email",
                    "Phone",
                    "Created",
                ];

                foreach ($subscribers as $subscriber) {
                    $data[] = [
                        $subscriber->name,
                        $subscriber->email,
                        $subscriber->phone,
                        $subscriber->created_at,
                    ];
                }

                $sheet->with($data);
            });
        })->download('csv');
    }

    /**
     * @param $search
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function search($search)
    {
        $subscribers = Subscriber::search($search)->paginate(config('app.pagination'));

        return view('subscriber.index', compact('subscribers', 'search'));
    }
}
