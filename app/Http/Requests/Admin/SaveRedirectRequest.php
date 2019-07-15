<?php

namespace App\Http\Requests\Admin;

class SaveRedirectRequest extends AdminRequest
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
        $rules = [
            'redirect_from' => 'required|max:255,unique:redirects,redirect_from',
            'redirect_to' => 'required|max:255',
            'is_enabled' => 'boolean',
        ];

        $rules['redirect_from'] = $this->excludeSlug($rules['redirect_from']);

        return $rules;
    }
}
