<?php

namespace App\Models;

use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Settings
 *
 * @package App\Model
 * @property string $label
 * @property string $key
 * @property string $validation
 * @property string $widget
 * @property string $group
 * @property array $data
 * @property integer $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $value
 */
class Settings extends Model
{
    use Sortable;

    const WIDGET_TEXT = '_text';
    const WIDGET_TEXTAREA = '_textarea';
    const WIDGET_FILE = '_file';
    const WIDGET_SELECT = '_select';

	const GST_INCLUSIVE = 'inclusive';
	const GST_EXCLUSIVE = 'exclusive';

    protected $casts = [
        'data' => 'array',
    ];

	protected $fillable = [
		'key',
		'label',
		'value',
		'validation',
		'widget',
        'group',
	];

    public static function boot()
    {
        parent::boot();

        self::saving(function($model) {
            $model->value = (!empty($model->value) || $model->value === '0' ? trim($model->value) : null);
        });
    }

	#####--------------------------------------------------------------------------------------------------------------#####
	#                                                   GENERAL METHODS START
	#####--------------------------------------------------------------------------------------------------------------#####
    /**
     * If the setting does not exist, it will just return an empty Settings class.
     * @param $key
     * @return \Illuminate\Support\Collection|static
     */
    public static function get($key)
    {
        $setting = self::firstOrNew([
            'key' => $key,
        ]);

        return $setting;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return strpos($this->validation, 'required') !== false;
    }

    /**
     * This will loop through the app/Settings files and ensure all settings
     * are created. If a setting is attempted to be accessed before this function
     * has run, it will simply return an empty class. When the settings index page is
     * requested, non existant settings will be updated with the details from app/Settings.
     */
	public static function checkSettingsExist()
	{
		foreach (self::getSettingsConfig() as $group => $settings) {
            $cnt = 1;
			foreach ($settings as $key => $setting) {
                if ($model = self::where('key', '=', $key)->first())
                    continue;

                $model = self::get($key);
                $model->key = $key;
                $model->value = (!empty($setting['value']) ? $setting['value'] : null);
                $model->label = $setting['label'];
                $model->group = $group;
                $model->validation = (!empty($setting['validation']) ? $setting['validation'] : null);
                $model->widget = (!empty($setting['widget']) ? $setting['widget'] : '_text');
                $model->sort_order = $cnt;
                $model->data = (!empty($setting['data']) ? $setting['data'] : null);
                $model->save();

                $cnt++;
			}
		}
	}

    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                   PRIVATE METHODS START
    #####--------------------------------------------------------------------------------------------------------------#####

	/**
	 * @return array
	 */
	private static function getSettingsConfig()
	{
		$data = [];
		foreach (\File::allFiles(app_path('Settings')) as $partial) {
			$data = array_merge($data, require_once($partial->getPathName()));
		}

		return $data;
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
