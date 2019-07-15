<?php
namespace Modulatte\Sections\Http\Requests;

use App\Http\Requests\Admin\AdminRequest;

class SaveSectionRequest extends AdminRequest
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
        $overwrite = 'App\Http\Requests\Admin\SaveSectionRequest';
        if (class_exists($overwrite)) {
            $rules = (new $overwrite)->rules();
        } else {
            $rules = [
                'page_id' => 'required',
                'title' => 'required|max:100',
                'data' => '',
                'is_enabled' => 'boolean',
            ];

            if ($this->isMethod('POST')) {
                $rules['image.file'] = 'required';
            }
        }

        return $rules;
    }
}
