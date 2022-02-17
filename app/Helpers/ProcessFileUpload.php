<?php


namespace App\Helpers;


use App\Traits\Helper;
use Illuminate\Http\UploadedFile;

class ProcessFileUpload
{
    use Helper;

    private $fileParser;
    private $extension;

    public function __construct(FileParser $fileParser, $extension = null)
    {
        $this->extension = $extension;
        $this->fileParser = $fileParser;
    }

    public function processFile($fileRequest)
    {
        $path = 'public/file';
        return $filePath = $this->saveFile($fileRequest, $path);
    }

    public function getFileExtension()
    {
        return $this->extension;
    }

    public function processFileData($file)
    {
        $items = null;
        $extension = $this->getFileExtension();
        if (!$extension){
            $f = explode('.', $file);
            $extension = $f[count($f) - 1];
            $this->extension = $extension;
        }
        if ($extension == 'json'){
            return $this->fileParser->json($file);
        }elseif ($extension == 'xml'){
            return $this->fileParser->xml($file);
        }elseif ($extension == 'csv'){
            return $this->fileParser->csv($file);
        }
        return false;
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
