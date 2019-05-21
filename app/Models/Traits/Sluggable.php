<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

/**
 * Trait Sluggable
 * @package App\Models\Traits
 */
trait Sluggable
{
    /**
     * @var array
     */
    protected $sluggable = [
        'name' => 'slug',
        'title' => 'slug',
    ];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value);

        if (array_key_exists($key, $this->sluggable)) {
            $field = $this->sluggable[$key];

            $this->$field = Str::slug($value);
        }

        return $this;
    }
}
