<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Storage;

class ProcessXmlFile
{
    public function process($filePath)
    {
        $path = Storage::disk('local')->get($filePath);
        $xmlObject = simplexml_load_string($path);
        $content = json_encode($xmlObject);
        $raw = json_encode(json_decode($content, true)['row']);
        $items =  collect(json_decode($raw));
        return $items;
    }
}
