<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Services\GoogleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public $days;
    public $startDate;
    public $endDate;

    public function __construct(Request $request)
    {
        if ($request->has('weekly')) {
            $this->days = 7;
            $this->startDate = \DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('-7 days')));
            $this->endDate = \DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('-1 days')));
        }
        else {
            $this->days = 30;
            $this->startDate = \DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('-1 months')));
            $this->endDate = \DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('-1 days')));
        }
    }

    public function index(Request $request)
    {
        $configId = config('laravel-analytics.siteId');
        if (empty($configId))
            return view('dashboard.blank');

        $google = new GoogleService($this->startDate, $this->endDate, $this->days);

        $data = [];
        $data['pageViewsVisitors'] = $google->getPageViews();
        $data['trafficSources'] = $google->getTrafficSources();
        $data['deviceCategories'] = $google->getDeviceCategories();
        $data['bounceRate'] = $google->getBounceRate();
        $data['topReferrers'] = $google->getTopReferrers();
        $data['mostVisitedPages'] = $google->getMostVisitedPages();
        $data['newReturningVisitors'] = $google->getNewReturningVisitors();

        $hostName = $google->getHostName();
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        return view('dashboard.index', compact('data', 'hostName', 'request', 'startDate', 'endDate'));
    }
}
