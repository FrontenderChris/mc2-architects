<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * App\Models\Upload
 *
 * @property integer $id
 * @property string $title
 * @property string $filename
 * @property string $caption
 * @property integer $size
 * @property integer $width
 * @property integer $height
 * @property string $mime_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Upload extends Model
{
    const TYPE_IMAGE = 'Image';
    const TYPE_FILE = 'File';
    const STORAGE_DIR = 'uploads/';
    const MAX_FILE_SIZE = 5000;

    protected $fillable = [
        'title',
        'filename',
        'caption',
        'size',
        'width',
        'height',
        'mime_type',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $file = self::getPath() . $model->filename;
            if (File::exists($file) && substr($model->mime_type, 0, 5) == 'image') {
                list($width, $height) = getimagesize($file);
                $model->width = $width;
                $model->height = $height;
            }
        });

        self::deleting(function($model) {
            Storage::delete($model->filename);
        });
    }

    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                   GENERAL METHODS START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * @param bool $absolute
     * @return string
     */
    public function getSrc($absolute = false)
    {
        return route('uploads.view', $this->filename, $absolute);
    }

    /**
     * @param UploadedFile $file
     * @return Upload|bool
     */
    public static function saveImage(UploadedFile $file)
    {
        return self::saveUpload(
            $file,
            self::getAllowedExtensions(self::TYPE_IMAGE)
        );
    }

    /**
     * @param UploadedFile $file
     * @return Upload|bool
     */
    public static function saveFile(UploadedFile $file)
    {
        return self::saveUpload(
            $file,
            self::getAllowedExtensions(self::TYPE_FILE)
        );
    }

    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                   PRIVATE METHODS START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * @return string
     */
    private static function getPath()
    {
        return base_path() . '/storage/app/' . self::STORAGE_DIR;
    }

    /**
     * @param UploadedFile $file
     * @param $extensions
     * @return bool|static
     */
    private static function saveUpload(UploadedFile $file, $extensions)
    {
        $validate = self::validateFile($file, $extensions);

        if ($validate['status'] == 'success') {
            $title = strtolower($file->getClientOriginalName());
            $filename = md5($title . rand()) . '.' . $file->getClientOriginalExtension();

            $data = [
                'title' => $title,
                'filename' => $filename,
                'mime_type' => $file->getClientMimeType(),
                'size' => round($file->getSize() / 1024), //kbs
            ];

            $validate = self::validateData($data);
            if ($validate['status'] == 'success') {
                Storage::disk('local')->put(self::STORAGE_DIR . $filename, File::get($file));
                $upload = self::create($data);
                return ['status' => 'success', 'upload' => $upload];
            }
        }

        return $validate;
    }

    /**
     * @param UploadedFile $file
     * @param $extensions
     * @return array
     */
    private static function validateFile(UploadedFile $file, $extensions)
    {
        $validator = \Validator::make(
            ['file' => $file],
            ['file' => 'max:' . self::MAX_FILE_SIZE . '|mimes:' . $extensions]
        );

        if ($validator->passes())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'error' => $validator->errors()->all()];
    }

    /**
     * @param $data
     * @return array
     */
    private static function validateData($data)
    {
        $validator = \Validator::make(
            $data,
            ['filename' => 'unique:uploads,filename']
        );

        if ($validator->passes())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'error' => $validator->errors()->all()];
    }

    /**
     * @param $type
     * @return string
     */
    private static function getAllowedExtensions($type)
    {
        if ($type == self::TYPE_IMAGE)
            return Image::getAllowedExtensions();
        elseif (class_exists('Modulatte/Products/Models/Download'))
            return Modulatte/Products/Models/Download::getAllowedExtensions();
        else
            return 'pdf,doc,docx,xls,xlsx,csv,rtf,html,zip,mp3,mpga,wma,mpg,flv,avi,jpg,jpeg,png,gif';
    }
}
