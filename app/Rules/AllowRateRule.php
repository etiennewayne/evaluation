<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use AllowRate;

class AllowRateRule implements Rule
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
        //
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Rating is not available right now. If you think this is a mistake, please contact Alfonsos Helpline on FB.';
    }
}
