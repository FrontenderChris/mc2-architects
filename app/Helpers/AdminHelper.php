<?php
/**
 * Common functionality to be used within the admin view files
 */

namespace App\Helpers;

class AdminHelper
{
    public static function getAssetsPath()
    {
        return '/cms/';
    }

    public static function getImgSrc($file = null)
    {
        return self::getAssetsPath() . 'images/' . $file;
    }

    public static function getCssSrc($file = null)
    {
        return self::getAssetsPath() . 'css/' . $file;
    }

    public static function getJsSrc($file = null)
    {
        return self::getAssetsPath() . 'js/' . $file;
    }

    public static function isSuperAdmin()
    {
        //todo: This should be extended to proper roles
        return \Auth::check() && \Auth::user()->email == 'admin@brownpaperbag.co.nz';
    }

    /**
     * Returns the max size a post request can be
     */
    public static function getPostMaxSize()
    {
        return (self::returnBytes(ini_get('post_max_size')) / 1024); //kbs
    }

    /**
     * Returns the max size an individual uploaded file can be
     */
    public static function getUploadMaxFilesize()
    {
        return (self::returnBytes(ini_get('upload_max_filesize')) / 1024); //kbs
    }

    /**
     * This method is used to decypher ini_get integer variables
     *
     * @param $val
     * @return int|string
     */
    private static function returnBytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = (int) $val;//fix
        switch($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    /**
     * @param $errorObj
     * @return string
     */
    public static function getErrors($errorObj)
    {
        $errors = '';
        if (!empty($errorObj)) {
            foreach ($errorObj as $error)
                $errors .= $error . "\n";
        }
        else {
            $errors = 'An internal error occurred.';
        }

        return $errors;
    }

    public static function getExtension($mime_type, $includeDot = true)
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ];

        return ($includeDot ? '.' : '') . $extensions[$mime_type];
    }

    public static function getNavigation()
    {
        $data = [];
        foreach (\File::allFiles(app_path('Navigation')) as $partial) {
            $data = array_merge($data, require_once($partial->getPathName()));
        }

        uasort($data, function($a, $b) {
            $a['sort_order'] = (isset($a['sort_order']) ? $a['sort_order'] : 0);
            $b['sort_order'] = (isset($b['sort_order']) ? $b['sort_order'] : 0);
            return $a['sort_order'] - $b['sort_order'];
        });

        return $data;
    }
}