<?php

namespace App\Rules;

use App\AcademicYear;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RatingDone implements Rule
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
        $student_id = Auth::user()->StudID;
        $ay = AcademicYear::where('active', 1)->first();

        $validate = DB::connection('mysql')->table('ratings')
            ->where('student_id', $student_id)
            ->where('ay_code', $ay->ay_code)
            ->where('schedule_code', $value)
            ->exists();

        if($validate){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You cannot rate twice.';
    }
}
