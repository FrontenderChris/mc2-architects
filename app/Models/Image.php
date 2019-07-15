<?php

namespace App\Models;

use App\Helpers\AdminHelper;
use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * App\Models\Image
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $product_variant_id
 * @property string $title
 * @property string $file
 * @property string $url
 * @property string $caption
 * @property boolean $is_main_image
 * @property integer $size
 * @property integer $width
 * @property integer $height
 * @property string $mime_type
 * @property integer $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $imageable_id
 * @property string $imageable_type
 * @property-read \App\Models\Image $imageable
 */
class Image extends Model
{
    const MAX_FILE_SIZE = 4000;
    const STORAGE_DIR = 'images/';

    const TYPE_DEFAULT = 'default'; // Default (fallback) image
    const TYPE_GALLERY_ITEM = 'gallery-item';

    use Sortable;

    protected $casts = [
        'data' => 'array',
    ];
    protected $fillable = [
        'title',
        'file',
        'type',
        'size',
        'caption',
        'url',
        'data',
        'is_main_image',
        'mime_type',
        'sort_order',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function(self $model){
            $model->saveMetaData();
        });

        self::deleting(function(self $model) {
            $model->deleteFile();
        });

        self::saving(function($model) {
            $model->caption = (empty($model->caption) ? null : $model->caption);
            $model->url = (empty($model->url) ? null : $model->url);
            $model->title = (empty($model->title) ? $model->file : $model->title);
        });
    }

    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                   GENERAL METHODS START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * @return string
     */
    public static function getPath()
    {
        return storage_path('app/' . self::STORAGE_DIR);
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getSrc($absolute = false)
    {
        return route('images.view', $this->file, $absolute);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return (!empty($this->url) ? $this->url : '#');
    }

    /**
     * Use this method to upload an image file (not a cropped image)
     *
     * @param $model
     * @param $fileField
     * @param string $relation
     * @param array $params
     * @param bool $deleteOld
     * @return array|string
     */
    public static function uploadImage($model, $fileField, $relation = 'image', $params = [], $deleteOld = true)
    {
        if (!Input::hasFile($fileField))
            return $relation;
        if ($model->$relation && $deleteOld)
            $model->$relation()->delete();

        $file = Input::file($fileField);
        $validate = self::validateFile($file);

        if (!empty($validate) && $validate['status'] == 'success') {
            $filename = self::randomiseFilename($file);

            self::store($file, $filename);
            return ['status' => 'success', 'image' => self::saveParams($model->$relation(), $filename, $params)];
        } else {
            $message = AdminHelper::getErrors($validate['error']);

            \Session::flash('error-msg', $message);
            return['status' => 'error', 'message' => $message];
        }
    }

    /**
     * Use this method to save the cropped image filename against a record ie. blog post etc
     *
     * @param $model
     * @param $filename
     * @param $params
     * @param $relation
     */
    public static function saveCroppedImage($model, $filename, $params = null, $relation = 'image')
    {
        if (!empty($filename) && $image = Image::where('file', $filename)->orderBy('id', 'desc')->first()) {
            if ($model->$relation && !empty($params['title'])) {
                if ($oldImage = $model->$relation()->where('title', '=', $params['title'])->first()) {
                    $oldImage->delete();
                }
            }
            elseif ($model->$relation)
                $model->$relation->delete();

            if (!empty($params)) {
                foreach ($params as $key => $value)
                    $image->$key = $value;
            }

            $model->$relation()->save($image);
        }
    }

    /**
     * @param UploadedFile $file
     * @return array
     */
    public static function validateFile(UploadedFile $file)
    {
        $validator = \Validator::make(
            ['file' => $file],
            ['file' => 'max:' . self::MAX_FILE_SIZE . '|mimes:' . self::getAllowedExtensions()]
        );

        if ($validator->passes())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'error' => $validator->errors()->all()];
    }

    /**
     * @return string
     */
    public static function getAllowedExtensions()
    {
        return 'jpg,jpeg,png,gif';
    }
    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                   PRIVATE METHODS START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * @param $file
     * @return string
     */
    private static function randomiseFilename(UploadedFile $file)
    {
        $ext = $file->getClientOriginalExtension();

        return str_slug(str_replace($ext, '', $file->getClientOriginalName())) . '-' . strtolower(str_random(5)) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * @param $file
     * @param $filename
     */
    private static function store($file, $filename)
    {
        \Storage::disk('local')->put(self::STORAGE_DIR . $filename, \File::get($file));
    }

    /**
     * @param $relation
     * @param $filename
     * @param $params
     * @return mixed
     */
    private static function saveParams($relation, $filename, $params)
    {
        $params['file'] = $filename;
        $params['title'] = (!empty($params['title']) ? $params['title'] : $filename);
        return $relation->save(new Image($params));
    }


    private function saveMetaData()
    {
        $file = self::getPath() . $this->file;
        if (\File::exists($file)) {
            $file = new UploadedFile($file, $this->file);
            list($width, $height) = getimagesize($file);
            $this->width = $width;
            $this->height = $height;
            $this->size = round($file->getSize() / 1024); //kbs
            $this->mime_type = $file->getMimeType();
        }
    }

    private function deleteFile()
    {
        $file = self::getPath() . $this->file;
        if (\File::exists($file) && self::where('file', '=', $this->file)->count() <= 1)
            \File::delete($file);
    }
    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                   RELATIONS START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
