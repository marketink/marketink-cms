<?php

namespace App\Jobs;

use App\Services\NotifyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumber;
    protected $message;
    /**
     * Create a new job instance.
     */
    public function __construct($phoneNumber, $message)
    {
        Log::alert($phoneNumber);
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sms = new NotifyService();
        $sms->sendSmsPattern($this->phoneNumber, $this->message);
    }
}
