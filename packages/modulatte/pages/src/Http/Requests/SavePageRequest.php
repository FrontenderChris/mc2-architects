<?php
namespace Modulatte\Pages\Http\Requests;

use App\Http\Requests\Admin\AdminRequest;

class SavePageRequest extends AdminRequest
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
     * If you create a SavePageRequest request in the App/Http/Requests/Admin
     * namespace it will automatically override this request.
     * @return array
     */
    public function rules()
    {
        $overwrite = 'App\Http\Requests\Admin\SavePageRequest';
        if (class_exists($overwrite)) {
            $rules = (new $overwrite)->rules();
        } else {
            $rules = [
                'parent_id' => 'integer',
                'title' => 'required|max:100',
                'slug' => 'required|max:100|unique:pages,slug',
                'route' => 'max:50',
                'form' => 'max:50',
                'data' => '',
                'sort_order' => 'integer',
                'is_enabled' => 'boolean',
            ];

            $rules['slug'] = $this->excludeSlug($rules['slug']);
        }

        return $rules;
    }
}
