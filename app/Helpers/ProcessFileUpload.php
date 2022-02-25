<?php


namespace App\Helpers;


use App\Traits\Helper;
use Illuminate\Http\UploadedFile;

/**
 * Class ProcessFileUpload
 * @package App\Helpers
 */
class ProcessFileUpload
{
    use Helper;

    /**
     * @var FileParser
     */
    private $fileParser;
    /**
     * @var mixed|null
     */
    private $extension;

    /**
     * ProcessFileUpload constructor.
     * @param FileParser $fileParser
     * @param null $extension
     */
    public function __construct(FileParser $fileParser, $extension = null)
    {
        $this->extension = $extension;
        $this->fileParser = $fileParser;
    }

    /**
     * @param $fileRequest
     * @return mixed
     */
    public function processFile($fileRequest)
    {
        $path = 'public/file';
        return $filePath = $this->saveFile($fileRequest, $path);
    }

    /**
     * @return mixed|null
     */
    public function getFileExtension()
    {
        return $this->extension;
    }

    /**
     * @param $file
     * @return false
     */
    public function processFileData($file)
    {
        $extension = $this->getFileExtension();
        return $this->fileParser->processFileBYExtension($file, $extension);
    }

    /**
     * @param $file
     * @param $path
     * @return mixed
     */
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

        return $path;
    }
}
