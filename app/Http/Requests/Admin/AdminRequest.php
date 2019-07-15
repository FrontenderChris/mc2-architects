<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AdminRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * If this is an update request, exclude the current slug from the unique validation
     * @param $value
     * @return string
     */
    protected function excludeSlug($value)
    {
        if (request()->isMethod('PUT')) {
            $segments = request()->segments();
            $id = intval(end($segments));
            if (!empty($id))
                return $value . ',' . $id;
        }

        return $value;
    }
}
