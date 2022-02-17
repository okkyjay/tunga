<?php


namespace App\Traits;


use Carbon\Carbon;

trait Helper
{
    public function filterCollectionData($item)
    {
        $age = $date = null;
        if(isset($item['date_of_birth']) && $item['date_of_birth'] && !is_null($item['date_of_birth'])){
            $dob = str_replace('/', '-',$item['date_of_birth']);
            $date = Carbon::parse($dob);
            $age = $date->diffInYears(now());
        }
        if(is_null($age) || ($age >= 18 && $age <= 65)){
            $item['date_of_birth'] = $date;
            return true;
        }
        return false;
    }

    public function prepareForDB($item)
    {
        if (isset($item['credit_card/type']) || isset($item['credit_card/number']) || isset($item['credit_card/expirationDate']) || isset($item['credit_card/name'])){
            $item['credit_card'] = [
                'type' => $item['credit_card/type']??'',
                'number' => $item['credit_card/number']??'',
                'name' => $item['credit_card/name']??'',
                'expirationDate' => $item['credit_card/expirationDate']??'',
            ];
            unset($item['credit_card/type']);
            unset($item['credit_card/number']);
            unset($item['credit_card/name']);
            unset($item['credit_card/expirationDate']);
        }

        $item['credit_card'] = json_encode($item['credit_card']);
        if (isset($item['date_of_birth']) && $item['date_of_birth']){
            $item['date_of_birth'] = str_replace('/', '-',$item['date_of_birth']);
        }
        if (isset($item['interest']) && is_array($item['interest'])){
            $item['interest'] = json_encode($item['interest']);
        }
        $item['date_of_birth'] = isset($item['date_of_birth'])?Carbon::parse($item['date_of_birth'])->format('Y-m-d'):null;
        return $item;
    }
}
