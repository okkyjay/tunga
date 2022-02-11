<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Storage;

class ProcessJsonFile
{
    public function process($filePath)
    {
        $path = Storage::disk('local')->get($filePath);
        return  collect(json_decode($path));
    }
}
