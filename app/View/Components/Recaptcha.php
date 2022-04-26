<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Recaptcha extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $clientKey;
    public $hasError;
    public function __construct(bool $hasError)
    {
        $this->clientKey =  env('GOOGLE_RECAPCHA_SITE_KEY');
        $this->hasError = $hasError;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.recaptcha');
    }
}
