<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Response;
use Modulatte\Pages\Models\Page;
use \Sitemap;

class SiteMapController extends Controller
{
    /**
     * @return $this
     */
    public function index()
    {
        $this->addManualPages();
        $this->addPages();

        return (new Response(Sitemap::xmlIndex(), 200))->header('Content-Type', 'text/xml');
    }

    /**
     * @return array
     */
    public function html()
    {
        $data = [];
        $data['pages'] = array_merge(
            $this->addManualPages(false),
            $this->addPages(false)
        );

        return view('pages.sitemap', compact('data'));
    }

    /**
     * @param bool $xml
     * @return array
     */
    private function addManualPages($xml = true)
    {
        $data = [
            'Home' => url('/'),
            'Contact Us' => url('contact-us'),
        ];

        if ($xml) {
            foreach ($data as $url) {
                Sitemap::addSitemap($url);
            }
        }

        return $data;
    }

    /**
     * @param bool $xml
     * @return array
     */
    private function addPages($xml = true)
    {
        $results = Page::all();
        $data = [];

        if ($xml) {
            foreach ($results as $row) {
                Sitemap::addSitemap(url($row->slug), $row->updated_at);
            }
        } else {
            foreach ($results as $row) {
                $data[$row->title] = url($row->slug);
            }

            return $data;
        }
    }
}
