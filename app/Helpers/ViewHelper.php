<?php
/**
 * Common functionality to be used within the frontend view files
 */

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class ViewHelper
{
    public static function getAssetsPath()
    {
        return '/';
    }

    public static function getImgSrc($file = null)
    {
        return url(self::getAssetsPath() . 'images/' . $file);
    }

    public static function getCssSrc($file = null)
    {
        return self::getAssetsPath() . 'css/' . $file;
    }

    public static function getJsSrc($file = null)
    {
        return self::getAssetsPath() . 'js/' . $file;
    }

    public static function getEmbedUrl($video)
    {
        if (strpos($video, 'vimeo') !== false) {
            $videoId = substr(parse_url($video, PHP_URL_PATH), 1);
            return 'https://player.vimeo.com/video/' . $videoId;
        } elseif (strpos($video, 'youtube') !== false || strpos($video, 'youtu.be') !== false) {
            return 'http://www.youtube.com/embed/' . self::getYouTubeId($video);
        } else {
            return $video;
        }
    }

    private static function getYouTubeId($url)
    {
        $pattern = '#^(?:https?://|//)?(?:www\.|m\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=|watch\?.+&v=))([\w-]{11})(?![\w-])#';
        preg_match($pattern, $url, $matches);
        return (isset($matches[1])) ? $matches[1] : false;
    }

    /**
     * Reference: http://stackoverflow.com/questions/2068344/how-do-i-get-a-youtube-video-thumbnail-from-the-youtube-api
     * @param $video
     * @return string
     */
    public static function getVideoThumbnail($video)
    {
        if (strpos($video, 'youtube') !== false || strpos($video, 'youtu.be') !== false) {
            return 'http://img.youtube.com/vi/' . self::getYouTubeId($video) . '/1.jpg';
        }

        return '/images/vid-thumbnail.png';
    }

    /**
     * @param $phone
     * @return mixed
     */
    public static function stripPhone($phone)
    {
        return preg_replace('/[^0-9\-]/', '', $phone);
    }

    public static function paginatorTo(LengthAwarePaginator $paginator, $limit)
    {
        $half_total_links = floor($limit / 2);
        $to = $paginator->currentPage() + $half_total_links;
        if ($paginator->currentPage() < $half_total_links) {
            $to += $half_total_links - $paginator->currentPage();
        }

        return $to;
    }

    public static function paginatorFrom(LengthAwarePaginator $paginator, $limit)
    {
        $half_total_links = floor($limit / 2);
        $from = $paginator->currentPage() - $half_total_links;
        if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
            $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
        }

        return $from;
    }
}