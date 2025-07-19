<?php

namespace App\Jobs;

use App\Services\ThesisService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadThesisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $thesisService;

    public function __construct($data, ThesisService $thesisService)
    {
        $this->data = $data;
        $this->thesisService = $thesisService;
    }

    public function handle(): void
    {
        try {
            $this->thesisService->storeThesis($this->data);
        } catch (Exception $ex) {
            \log($ex->getMessage());
        }
    }
}
