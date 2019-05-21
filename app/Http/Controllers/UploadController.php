<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Upload;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function view($filename)
    {
        $model = Upload::where('filename', $filename)->firstOrFail();
        $file = Storage::disk('local')->get(Upload::STORAGE_DIR . $model->filename);

        return (new Response($file, 200))->header('Content-Type', $model->mime_type)->header('Content-Disposition', 'inline; filename="' . $model->title . '"');
    }

    public function images($filename)
    {
        $model = Image::where('file', $filename)->firstOrFail();
        $file = Storage::disk('local')->get(Image::STORAGE_DIR . $model->file);

        return (new Response($file, 200))->header('Content-Type', $model->mime_type);
    }
}
