<?php

namespace App\Http\Requests;

use App\AcademicYear;
use App\Rating;
use App\Rules\RatingDone;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreRating extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $dataToValidate = DB::connection('mysql')
            ->table('criteria as a')
            ->join('categories as b', 'a.category_id', 'b.category_id')
            ->select('a.criterion_id')
            ->where('b.ay_code', $this->ay_code)->get();

        $temp = array();
        for($i =0; $i < sizeof($dataToValidate); $i++){
            $temp += ['critid_'.$dataToValidate[$i]->criterion_id => 'required'];
        }
        $temp += ['schedule_code' => new RatingDone];


        return $temp;
    }
}
