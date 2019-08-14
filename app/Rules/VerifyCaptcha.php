<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;
use ReCaptcha\ReCaptcha;

class VerifyCaptcha implements Rule
{
    private $reCaptcha;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $secretKey = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'; // demo key

        if (!empty($secretKey)) {
            $this->reCaptcha = new ReCaptcha($secretKey);
        }
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
        if ($this->reCaptcha === null) {
            return true; // reCaptcha is not enabled
        }

        $response = $this->reCaptcha->verify($value, Request::ip());

        return $response->isSuccess();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The captcha verification failed.';
    }
}