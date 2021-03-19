<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Schedule;


class RateAllowed implements Rule
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
       $sched =  Schedule::where('SchedCode', $value)->first();

       if($sched){
           if($sched->allow_rate == 1 && $sched->SchedInsCode != ''){
                return true;
           }else{
                return false;
           }
       }
       return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Rating for this course is not allowed.';
    }
}
