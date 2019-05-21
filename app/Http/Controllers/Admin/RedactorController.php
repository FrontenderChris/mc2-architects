<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AdminHelper;
use App\Models\Upload;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RedactorController extends Controller
{
    /**
     * @param Request $request
     * @return array|bool
     */
    public function saveImage(Request $request)
    {
        return $this->saveUpload($request, 'saveImage');
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function saveFile(Request $request)
    {
        return $this->saveUpload($request, 'saveFile');
    }

    /**
     * @return array
     */
    public function getImages()
    {
        $data = [];
        $uploads = Upload::where('mime_type', 'LIKE', 'image/%')->get();

        foreach ($uploads as $upload) {
            $data[] = [
                'thumb' => $upload->getSrc(),
                'url' => $upload->getSrc(),
                'title' => $upload->title,
                'id' => $upload->id,
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        $data = [];
        $uploads = Upload::where('mime_type', 'NOT LIKE', 'image/%')->get();

        foreach ($uploads as $upload) {
            $data[] = [
                'title' => $upload->title,
                'name' => $upload->title,
                'url' => $upload->getSrc(),
                'size' => $upload->size . 'kb',
                'id' => $upload->id,
            ];
        }

        return $data;
    }

    /**
     * @param Request $request
     * @param $uploadMethod
     * @return array|bool
     */
    private function saveUpload(Request $request, $uploadMethod)
    {
        if ($request->hasFile('file')) {
            $response = Upload::$uploadMethod($request->file('file'));

            if ($response['status'] == 'success') {
                return [
                    'url' => $response['upload']->getSrc(),
                    'id' => $response['upload']->id,
                ];
            }
            else {
                return ['error' => AdminHelper::getErrors($response['error'])];
            }
        }

        abort(500, 'No upload data was found when accessing RedactorController@saveUpload.');
        return false;
    }
}
