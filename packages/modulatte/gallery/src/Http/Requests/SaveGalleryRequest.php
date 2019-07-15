<?php
namespace Modulatte\Gallery\Http\Requests;

use App\Http\Requests\Admin\AdminRequest;

class SaveGalleryRequest extends AdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * If you create a SaveSectionRequest request in the App/Http/Requests/Admin
     * namespace it will automatically override this request.
     * @return array
     */
    public function rules()
    {
        $overwrite = 'App\Http\Requests\Admin\SaveGalleryRequest';
        if (class_exists($overwrite)) {
            $rules = (new $overwrite)->rules();
        } else {
            $rules = [
                'title' => 'max:100',
                'caption' => '',
                'url' => '',
            ];

            if ($this->isMethod('POST')) {
                $rules['image.file'] = 'required';
            }
        }

        return $rules;
    }
}
