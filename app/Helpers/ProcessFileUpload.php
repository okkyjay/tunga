<?php


namespace App\Helpers;


use App\Traits\Helper;
use Illuminate\Http\UploadedFile;

class ProcessFileUpload
{
    use Helper;

    private $processJson;
    private $processXML;
    private $extension;
    public function __construct(ProcessJsonFile $processJsonFile, ProcessXmlFile $processXML)
    {
        $this->processJson = $processJsonFile;
        $this->processXML = $processXML;
    }

    public function processFile($fileRequest)
    {
        $path = 'public/file';
        $filePath = $this->saveFile($fileRequest, $path);
        $items = $this->processFileData($filePath);
        $items = $items->filter( function ($item){
            return $this->filterCollectionData($item);
        });
        $items = json_decode(json_encode($items->toArray()), true);
        return $items;
    }

    private function getFileExtension()
    {
        return $this->extension;
    }

    private function processFileData($file)
    {
        $items = null;
        $extension = $this->getFileExtension();
        if ($extension == 'json'){
            $items = $this->processJson->process($file);
        }elseif ($extension == 'xml'){
            $items = $this->processXML->process($file);
        }elseif ($extension == 'csv'){
            return false;
        }
        return $items;
    }

    public function saveFile($file, $path){

        // Get filename with the extension
        $filenameWithExt = $file->file('file')->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $this->extension = $file->file('file')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$this->extension;
        // Upload File
        $path = $file->file('file')->storeAs($path, $fileNameToStore);
//        $filePath = url('/storage/file/'.$fileNameToStore);
//        exit($path);
        return $path;
    }
}
