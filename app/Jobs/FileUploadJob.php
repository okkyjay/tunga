<?php

namespace App\Jobs;

use App\Exceptions\User\CreateUserErrorException;
use App\Helpers\ProcessFileUpload;
use App\Http\Requests\User\FileRequest;
use App\Interfaces\User\UserRepositoryInterface;
use App\Traits\Helper;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FileUploadJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Helper;

    /**
     * @var
     */
    private $filePath;



    /**
     * JsonJob constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @param ProcessFileUpload $processFileUpload
     */
    public function handle(ProcessFileUpload $processFileUpload)
    {
         $processFileUpload->processFileData($this->filePath);
    }
}
