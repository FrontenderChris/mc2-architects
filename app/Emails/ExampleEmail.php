<?php
namespace App\Emails;

class ExampleEmail extends Email
{
    /**
     * Get the ID for the email template to be sent from Campaign Monitor
     * @return string
     */
    public function getEmailId()
    {
        return '';
    }

    /**
     * Process your data to be ready for the email
     * ie. Objects into array values etc.
     * @param $data
     * @return array
     */
    public function variables($data = [])
    {
        return $data;
    }
}