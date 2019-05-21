<?php
namespace Modulatte\Categories\Http\Requests;

use Modulatte\Products\Http\Requests\ProductsRequest;

class SaveCategoryRequest extends ProductsRequest
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
     * @return array
     */
    public function rules()
    {
        $overwrite = 'App\Http\Requests\Admin\SaveCategoryRequest';
        if (class_exists($overwrite)) {
            $rules = (new $overwrite)->rules();
        } else {
            $rules = [
                'parent_id' => 'integer',
                'title' => 'required',
                'slug' => 'required|unique:categories,slug',
                'sort_order' => 'integer',
                'is_enabled' => 'boolean',
            ];

            $rules['slug'] = $this->excludeSlug($rules['slug']);

            if ($this->isMethod('POST') && config('categories.hasImage'))
                $rules['image.file'] = 'required';
        }

        return $rules;
    }
}
