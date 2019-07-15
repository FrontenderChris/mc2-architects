<?php
namespace App\Services;
/**
 * GoogleService
 *
 * This service uses the spatie/laravel-analytics extention
 * For more information on available methods etc see the URL below
 * https://github.com/spatie/laravel-analytics
 */

use Spatie\LaravelAnalytics\LaravelAnalyticsFacade;

class GoogleService
{
    public $days;
    public $startDate;
    public $endDate;

    public function __construct(\DateTime $startDate, \DateTime $endDate, $days = 30)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->days = $days;
    }

    public function getBounceRate()
    {
        return LaravelAnalyticsFacade::performQuery($this->startDate, $this->endDate, 'ga:bounceRate');
    }

    public function getTopReferrers()
    {
        return LaravelAnalyticsFacade::getTopReferrers($this->days, 5);
    }

    public function getMostVisitedPages()
    {
        return LaravelAnalyticsFacade::getMostVisitedPages($this->days, 5);
    }

    public function getPageViews()
    {
        $response = LaravelAnalyticsFacade::getVisitorsAndPageViews($this->days);
        $data = ['labels' => [], 'visitors' => [], 'pageViews' => []];

        foreach ($response as $row) {
            $data['labels'][] = $row['date']->format('d M');
            $data['visitors'][] = $row['visitors'];
            $data['pageViews'][] = $row['pageViews'];
        }

        return $data;
    }

    public function getTrafficSources()
    {
        $response = LaravelAnalyticsFacade::performQuery($this->startDate, $this->endDate, 'ga:visits', ['dimensions' => 'ga:medium']);
        $data = ['direct' => 0, 'organic' => 0, 'referral' => 0];

        if (!empty($response['rows'])) {
            foreach ($response['rows'] as $row) {
                if ($row[0] == '(none)')
                    $row[0] = 'direct';

                $views = (!empty($row[1]) ? $row[1] : 0);
                $data[$row[0]] = (int)$views;
            }
        }

        return $data;
    }

    public function getHostName()
    {
        $response = LaravelAnalyticsFacade::performQuery($this->startDate, $this->endDate, 'ga:visits', ['dimensions' => 'ga:hostname']);
        $profileRows = $response['rows'];

        if (!empty($profileRows)) {
            // Reorder array to display the profile name with the most views first - this should be the main account
            usort($profileRows, function($a, $b){
                return $b[1] - $a[1];
            });

            if (!empty($profileRows[0][0]))
                return $profileRows[0][0];
        }

        return null;
    }

    public function getDeviceCategories()
    {
        $response = LaravelAnalyticsFacade::performQuery($this->startDate, $this->endDate, 'ga:sessions', ['dimensions' => 'ga:deviceCategory']);
        $data = ['desktop' => 0, 'mobile' => 0, 'tablet' => 0];

        if (!empty($response['rows'])) {
            foreach ($response['rows'] as $row) {
                $data[$row[0]] = $row[1];
                $views = (!empty($row[1]) ? $row[1] : 0);
                $data[$row[0]] = (int)$views;
            }
        }

        return $data;
    }

    public function getNewReturningVisitors()
    {
        $response = LaravelAnalyticsFacade::performQuery($this->startDate, $this->endDate, 'ga:sessions', ['dimensions' => 'ga:userType']);
        $data = [
            'returning' => 0,
            'returning-percentage' => 0,
            'new' => 0,
            'new-percentage' => 0,
        ];

        if (!empty($response['rows'])) {
            $total = $response['totalsForAllResults']['ga:sessions'];
            foreach ($response['rows'] as $row) {
                if ($row[0] == 'Returning Visitor')
                    $key = 'returning';
                else
                    $key = 'new';

                $data[$key] = $row[1];
                if ($total > 0)
                    $data[$key . '-percentage'] = round(($row[1] / $total) * 100);
            }
        }

        return $data;
    }
}
