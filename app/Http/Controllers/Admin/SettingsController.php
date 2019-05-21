<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SaveSettingsRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Settings;

class SettingsController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index()
    {
		Settings::checkSettingsExist();
    	$groups = $this->getSettings();

		return view('settings.index', compact('groups'));
	}

	/**
	 * @param SaveSettingsRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(SaveSettingsRequest $request)
	{
		$data = $request->all();

		foreach ($data as $key => $value) {
			if ($key == '_token')
				continue;

            $setting = Settings::get($key);

            if ($request->hasFile($key)) {
                $value = $this->saveImage($setting, $key);
            }

			$setting->value = $value;
			$setting->save();
		}

		return redirect()->route('admin.settings.index')->with('success-msg', 'Settings have been successfully updated.');
	}

	/**
	 * @return array
	 */
	private function getSettings()
	{
		$settings = Settings::all();
		$data = [];
		foreach ($settings as $setting) {
			$data[$setting->group][$setting->key] = $setting;
		}

		return $data;
	}

    /**
     * @param Settings $model
     * @param $key
     * @return null
     */
    private function saveImage(Settings $model, $key)
    {
		Image::uploadImage($model, $key);

        return null;
    }

}