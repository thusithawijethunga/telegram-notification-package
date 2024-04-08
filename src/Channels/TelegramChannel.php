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

            $response = Http::post(config('telegram.api_url'), [
                'appkey'        => config('telegram.appkey'),
                'authkey'       => config('telegram.authkey'),
                'template_id'   => $notification->templateId(),
                'variables'     => $message->variables(),
            ]);

            $responseData = $response->json();

            // Check if the response contains an error message
            if (isset($responseData['error'])) {
                // Log the error message
                \Log::error('TelegramChannel Error: ' . $responseData['error']);
                // You can throw a custom exception or return a specific response
                throw new \Exception($responseData['error']);
            }

            \Log::info('TelegramChannel:', $responseData);

            return $responseData;

        } catch (RequestException $e) {
            // Handle HTTP request errors (e.g., connection errors)
            \Log::error('TelegramChannel: HTTP Request Error - ' . $e->getMessage());
            // You can also throw a custom exception or return a specific response
            throw new \Exception('Failed to send Telegram notification: HTTP Request Error');
        }
    }
}
