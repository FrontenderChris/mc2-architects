<?php

namespace App\Http\Requests\Admin;

use App\Models\Settings;

class SaveSettingsRequest extends AdminRequest
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
        $rules = [];

        $settings = Settings::all();
        foreach ($settings as $setting) {
            if (empty($setting->validation))
                continue;

            if ($setting->widget != Settings::WIDGET_FILE || ($setting->widget == Settings::WIDGET_FILE && !$setting->image)) {
                $rules[$setting->key] = $setting->validation;
            }
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [];

        foreach (Settings::all() as $setting) {
            if (!empty($setting->validation)) {
                $attributes[$setting->key] = $setting->label;
            }
        }

        return $attributes;
    }

}
