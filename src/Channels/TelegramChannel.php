<?php

namespace Promoxp\Telegram\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

class TelegramChannel
{
    public function send($notifiable, Notification $notification)
    {
        try {

            $message = $notification->toTelegram($notifiable);

            if (is_null($message->appkey())) {
                $postData['appkey']         = config('notification-telegram.appkey');
            }

            $postData['authkey']            = config('notification-telegram.authkey');
            $postData['campaign_name']      = $message->campaignName();
            
            if ($message->templateId()) {
                $postData['template_id']    = $message->templateId();
                $postData['variables']      = $message->variables();
            } else {
                $postData['message']        = $message->message();
            }

            if ($message->fileUrl()) {
                $postData['file']           = $message->fileUrl();
            }

            $response = Http::post(config('notification-telegram.api_url'), $postData);

            $responseData = $response->json();

            if($response->getStatusCode()==200){
                return true;
            };
            
            // Check if the response contains an error message
            if (isset($responseData['error'])) {
                // Log the error message
                \Log::error('TelegramChannel Error: ' . $responseData['error']);
                // You can throw a custom exception or return a specific response
                throw new \Exception($responseData['error']);
            }

            return false;

        } catch (RequestException $e) {
            // Handle HTTP request errors (e.g., connection errors)
            \Log::error('TelegramChannel: HTTP Request Error - ' . $e->getMessage());
            // You can also throw a custom exception or return a specific response
            throw new \Exception('Failed to send Telegram notification: HTTP Request Error');
        }
    }
}
