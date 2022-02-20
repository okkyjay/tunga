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
        $extension = $this->getFileExtension();
        return $this->fileParser->processFileBYExtension($file, $extension);
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
