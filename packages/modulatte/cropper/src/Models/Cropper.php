<?php

namespace Modulatte\Cropper\Models;

class Cropper
{
    private $src;
    private $data;
    private $dst;
    private $type;
    private $extension;
    private $msg;
    private $filename;
    private $newWidth;
    private $newHeight;

    function __construct($src, $data, $file, $newWidth, $newHeight)
    {
        $this->filename = date('YmdHis');
        $this->checkFolders();
        $this->setSrc($src);
        $this->setData($data);
        $this->setFile($file);
        $this->setDimensions($newWidth, $newHeight);
        $this->crop($this->src, $this->dst, $this->data, $this->newWidth, $this->newHeight);
    }

    protected function setSrc($src)
    {
        if (!empty($src)) {
            $type = exif_imagetype($src);

            if ($type) {
                $this->src = $src;
                $this->type = $type;
                $this->extension = image_type_to_extension($type);
                $this->setDst();
            }
        }
    }

    protected function setData($data)
    {
        if (!empty($data)) {
            $this->data = json_decode(stripslashes($data));
        }
    }

    protected function setDimensions($newWidth, $newHeight)
    {
        $this->newWidth = $newWidth;
        $this->newHeight = $newHeight;
    }

    protected function setFile($file)
    {
        $errorCode = $file['error'];

        if ($errorCode === UPLOAD_ERR_OK) {
            $type = exif_imagetype($file['tmp_name']);

            if ($type) {
                $extension = image_type_to_extension($type);
                $src = $this->getOriginalPath() . $this->filename . '.original' . $extension;

                if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {
                    if (file_exists($src)) {
                        unlink($src);
                    }

                    $result = move_uploaded_file($file['tmp_name'], $src);

                    if ($result) {
                        $this->src = $src;
                        $this->type = $type;
                        $this->extension = $extension;
                        $this->setDst();
                    } else {
                        $this->msg = 'Failed to save file';
                    }
                } else {
                    $this->msg = 'Please upload image with the following types: JPG, PNG, GIF';
                }
            } else {
                $this->msg = 'Please upload image file';
            }
        } else {
            $this->msg = $this->codeToMessage($errorCode);
        }
    }

    protected function setDst()
    {
        $this->dst = $this->getPath() . $this->filename . $this->getExtension();
    }

    /**
     * @return mixed
     */
    protected function getExtension()
    {
        if (config('cropper.keepOriginalExtension') && in_array($this->extension, ['.png', '.jpg', '.jpeg']))
            return $this->extension;
        else
            return '.' . config('cropper.defaultExtension');
    }

    protected function checkFolders()
    {
        if (!is_dir($this->getPath()))
            mkdir($this->getPath());

        if (!is_dir($this->getOriginalPath()))
            mkdir($this->getOriginalPath());
    }

    protected function crop($src, $dst, $data, $newWidth, $newHeight)
    {
        if (empty($newWidth) || empty($newHeight)) {
            $this->msg = 'New width and new height variables must be set to crop an image.';
            return;
        }

        if (!empty($src) && !empty($dst) && !empty($data)) {
            switch ($this->type) {
                case IMAGETYPE_GIF:
                    $src_img = imagecreatefromgif($src);
                    break;

                case IMAGETYPE_JPEG:
                    $src_img = imagecreatefromjpeg($src);
                    break;

                case IMAGETYPE_PNG:
                    $src_img = imagecreatefrompng($src);
                    break;
            }

            if (empty($src_img)) {
                $this->msg = "Failed to read the image file";
                return;
            }

            $size = getimagesize($src);
            $size_w = $size[0]; // natural width
            $size_h = $size[1]; // natural height

            $src_img_w = $size_w;
            $src_img_h = $size_h;

            $degrees = $data->rotate;

            // Rotate the source image
            if (is_numeric($degrees) && $degrees != 0) {
                // PHP's degrees is opposite to CSS's degrees
                $new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );

                imagedestroy($src_img);
                $src_img = $new_img;

                $deg = abs($degrees) % 180;
                $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

                $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
                $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

                // Fix rotated image miss 1px issue when degrees < 0
                $src_img_w -= 1;
                $src_img_h -= 1;
            }

            $tmp_img_w = $data->width;
            $tmp_img_h = $data->height;
            $dst_img_w = $newWidth;
            $dst_img_h = $newHeight;

            $src_x = $data->x;
            $src_y = $data->y;

            if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
                $src_x = $src_w = $dst_x = $dst_w = 0;
            } else if ($src_x <= 0) {
                $dst_x = -$src_x;
                $src_x = 0;
                $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
            } else if ($src_x <= $src_img_w) {
                $dst_x = 0;
                $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
            }

            if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
                $src_y = $src_h = $dst_y = $dst_h = 0;
            } else if ($src_y <= 0) {
                $dst_y = -$src_y;
                $src_y = 0;
                $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
            } else if ($src_y <= $src_img_h) {
                $dst_y = 0;
                $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
            }

            /*
             * Vertical working - horizontal not yet working - removed due to lack of time
             *
            // If the image was flipped either horizontally or vertically (or both)
            if ($this->data->scaleX < 0) {
                $src_x = $src_w -1;
                $src_w = -$src_w;
            } elseif ($this->data->scaleY < 0) {
                $src_y = $src_h -1;
                $src_h = -$src_h;
            }*/

            // Scale to destination position and size
            $ratio = $tmp_img_w / $dst_img_w;
            $dst_x /= $ratio;
            $dst_y /= $ratio;
            $dst_w /= $ratio;
            $dst_h /= $ratio;

            $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

            // Add transparent background to destination image
            imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
            imagesavealpha($dst_img, true);

            $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
            $msg = "Failed to save the cropped image file";

            if ($result) {
                if (config('cropper.keepOriginalExtension') && $this->type == IMAGETYPE_PNG) {
                    $quality = min((config('cropper.quality') / 10), 9);
                    if (!imagepng($dst_img, $dst, $quality)) {
                        $this->msg = $msg;
                    }
                } else {
                    if (!imagejpeg($dst_img, $dst, config('cropper.quality'))) {
                        $this->msg = $msg;
                    }
                }
            } else {
                $this->msg = $msg;
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }

    protected function codeToMessage($code)
    {
        $errors = array(
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
        );

        if (array_key_exists($code, $errors)) {
            return $errors[$code];
        }

        return 'Unknown upload error';
    }

    protected function getPath()
    {
        return storage_path('app/images/');
    }

    protected function getOriginalPath()
    {
        return storage_path('app/images/originals/');
    }

    public function getSrc($absolute = false)
    {
        return route('images.view', $this->getFilename(), $absolute);
    }

    public function getFilename()
    {
        return $this->filename . $this->getExtension();
    }

    public function getResult()
    {
        return !empty($this->data) ? $this->dst : $this->src;
    }

    public function getMsg()
    {
        return $this->msg;
    }
}
