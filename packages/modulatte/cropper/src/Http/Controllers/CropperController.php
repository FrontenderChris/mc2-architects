<?php

namespace Modulatte\Cropper\Http\Controllers;

use Modulatte\Cropper\Models\Cropper;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CropperController extends Controller
{
    /**
     * @param Request $request
     */
    public function crop(Request $request)
    {
        $crop = new Cropper(
            $request->get('avatar_src'),
            $request->get('avatar_data'),
            $_FILES['avatar_file'],
            $request->get('new_width'),
            $request->get('new_height')
        );

        $this->saveImage($crop);

        $response = array(
            'state'  => 200,
            'message' => $crop->getMsg(),
            'result' => $crop->getSrc(),
            'filename' => $crop->getFilename(),
        );

        echo json_encode($response);
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
     * @param Cropper $crop
     * @return Image
     */
    protected function saveImage(Cropper $crop)
    {
        $image = new Image;
        $image->file = $crop->getFilename();
        $image->title = $crop->getFilename();
        $image->save();

        return $image;
    }
}
