<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

//        $response =  Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify' , [
//            'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
//            'response' => $value,
//            'remoteip' => request()->ip()
//        ]);
//
//        $response->throw();
//
//        $response = $response->json();
//
//        return $response['success'];

        try {
            $client = new Client();
            $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' => [
                    'secret'=> env('GOOGLE_RECAPCHA_SECRET_KEY'),
                    'response' => $value,
                    'remoteip' => request()->ip()
                ]
            ]
            );

            $response =json_decode($response->getBody());

           // dd($response);
            return $response->success;
        }
        catch (\Exception $e) {

            //Todo log an error
            return false;

        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'شما به عنوان ربات تشخیص داده شده اید';
    }
}
