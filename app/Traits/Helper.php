<?php


namespace App\Traits;


use Carbon\Carbon;

trait Helper
{
    public function filterCollectionData($item)
    {
        $age = $date = null;
        if($item->date_of_birth && !is_null($item->date_of_birth)){
            $dob = str_replace('/', '-',$item->date_of_birth);
            $date = Carbon::parse($dob);
            $age = $date->diffInYears(now());
        }
        if(is_null($age) || ($age >= 18 && $age <= 65)){
            $item->date_of_birth = $date;
            return true;
        }
        return false;
    }

    public function prepareForDB($item)
    {
        $item['credit_card'] = json_encode($item['credit_card']);
        $item['date_of_birth'] = isset($item['date_of_birth'])?Carbon::parse($item['date_of_birth'])->format('Y-m-d'):null;
        return $item;
    }
}
