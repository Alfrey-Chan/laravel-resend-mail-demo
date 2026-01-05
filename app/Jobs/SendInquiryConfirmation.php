<?php

namespace App\Jobs;

use App\Models\Inquiry;
use App\Mail\InquiryConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInquiryConfirmation implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Inquiry $inquiry){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        $result = Mail::to("alfreychan@gmail.com") // TODO:: can only send to own emails for now
            ->send(new InquiryConfirmation($this->inquiry));

        Log::info("sending email", ["result" => $result]);
    }
}
