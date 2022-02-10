<?php

namespace App\Http\Controllers;

use App\Jobs\JsonJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class HomeController extends Controller
{
    public function store(): string
    {
        $path = url('challenge.xml');

        $explode = explode('.', $path);
        $extension = $explode[count($explode) - 1];
        $content = null;
        $items = null;

        if ($extension == 'json'){
            $content = file_get_contents('./challenge.json');
            $items =  collect(json_decode($content))->sortByDesc('date_of_birth');
            //exit(var_dump($items));
        }elseif ($extension == 'csv'){

        }elseif ($extension == 'xml'){
            $xmlString = file_get_contents('./challenge.xml');
            $xmlObject = simplexml_load_string($xmlString);
            $content = json_encode($xmlObject);
            $raw = json_encode(json_decode($content, true)['row']);
            $items =  collect(json_decode($raw))->sortByDesc('date_of_birth');
        }

        $batch  = Bus::batch([])->dispatch();
        foreach($items as $item){
            $age = $date = null;
            if(!is_null($item->date_of_birth)){
                $dob = str_replace('/', '-',$item->date_of_birth);
                $date = Carbon::parse($dob);
                $age = $date->diffInYears(now());
            }
            if(is_null($age) || ($age >= 18 && $age <= 65)){
                $item->date_of_birth = $date;
                //dispatch();
                $batch->add(new JsonJob($item));
            }
        }
        return back()->with(['success' => 'Jobs running....']);
    }
}
