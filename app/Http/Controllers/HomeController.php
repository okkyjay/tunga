<?php

namespace App\Http\Controllers;

use App\Jobs\JsonJob;
use App\Traits\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class HomeController extends Controller
{
    use Helper;
    public function store(): string
    {
        $path = url('challenge.json');

        $explode = explode('.', $path);
        $extension = $explode[count($explode) - 1];
        $content = null;
        $items = null;

        if ($extension == 'json'){
            $content = file_get_contents('./challenge.json');
            $items =  collect(json_decode($content))->sortByDesc('date_of_birth');
        }elseif ($extension == 'csv'){

        }elseif ($extension == 'xml'){
            $xmlString = file_get_contents('./challenge.xml');
            $xmlObject = simplexml_load_string($xmlString);
            $content = json_encode($xmlObject);
            $raw = json_encode(json_decode($content, true)['row']);
            $items =  collect(json_decode($raw))->sortByDesc('date_of_birth');
        }

        $items = $items->filter( function ($item){
            return $this->filterCollectionData($item);
        });

        $items = json_decode(json_encode($items->toArray()), true);
        $items = array_chunk($items, 500);
        $batch  = Bus::batch([])->dispatch();
        foreach($items as $item){
            $batch->add(new JsonJob($item));
        }
        //Artisan::call('queue:work --tries=3');
        return back()->with(['success' => 'Jobs running....']);
    }
}
