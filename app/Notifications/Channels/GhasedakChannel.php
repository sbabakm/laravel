<?php

namespace App\Notifications\Channels;
use Illuminate\Notifications\Notification;

class GhasedakChannel
{
    public function send($notifiable , Notification $notifications) {

        if(! method_exists($notifications , 'toGhasedakSms')){
            throw new \Exception('toGhasedakSms not found');
        }
        $data = $notifications->toGhasedakSms($notifiable);
        $message = $data['text'];
        $receptor = $data['number'];
        $apiKey = config('services.ghasedak.key');
        try
        {
            //$message = "تست ارسال وب سرویس قاصدک";
            $lineNumber = "10008566";
            //$receptor = "09127960623";
            $api = new \Ghasedak\GhasedakApi( $apiKey);
            $api->SendSimple($receptor,$message,$lineNumber);
        }
        catch(\Ghasedak\Exceptions\ApiException $e){
            throw $e;
        }
        catch(\Ghasedak\Exceptions\HttpException $e){
            throw $e;
        }


    }
}
