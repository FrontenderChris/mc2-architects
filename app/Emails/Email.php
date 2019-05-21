<?php
namespace App\Emails;

use App\Models\Subscriber;
use CS_REST_Transactional_SmartEmail;

/**
 * This class uses the Campaign Monitor Smart Transactional emails to send the email
 * You simply create a class which extends this class referencing the email id (from CM).
 * To send an email you can do:
 * (new ChildClassName)->withData(['yourdata' => 'goeshere'])->sendTo($user);
 * Alternatively you can exclude withData if your email doesn't require any.
 * @package App\Emails
 */
abstract class Email
{
    protected $apiKey;
    protected $data = [];

    /**
     * Email constructor.
     * @param null $apiKey
     */
    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey ?: config('services.campaign_monitor.key');
    }

    /**
     * @param $data
     * @return $this
     */
    public function withData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param Subscriber $subscriber
     * @return \CS_REST_Wrapper_Result
     */
    public function sendTo(Subscriber $subscriber)
    {
        $mailer = $this->newTransaction();

        $data = call_user_func_array(
            [$this, 'variables'],
            $this->data
        );
        $data['unsubscribe_url'] = $subscriber->getUnsubscribeUrl();

        if (!empty($this->apiKey)) {
            $response = $mailer->send([
                'To' => $subscriber->email,
                'Data' => $data,
            ]);

            if (!$response->was_successful())
                \Log::error('Transactional email was not sent to ' . $subscriber->email . '.', ['response' => $response, 'subscriber' => $subscriber]);

            return $response;
        } else {
            \Log::error('Campaign Monitor API key has not been setup - transactional emails unable to be sent.');
        }
    }

    /**
     * @return CS_REST_Transactional_SmartEmail
     */
    protected function newTransaction()
    {
        return new CS_REST_Transactional_SmartEmail(
            $this->getEmailId(),
            ['api_key' => $this->apiKey]
        );
    }

    /**
     * Get the ID for the email template to be sent from Campaign Monitor
     * @return string
     */
    protected abstract function getEmailId();

    /**
     * Process your data to be ready for the email
     * ie. Objects into array values etc.
     * @param $data
     * @return array
     */
    protected abstract function variables($data);
}