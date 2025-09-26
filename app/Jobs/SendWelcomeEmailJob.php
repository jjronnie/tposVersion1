<?php

namespace App\Jobs;

use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;



class SendWelcomeEmailJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   protected $user;
   protected $business;

    /**
     * Create a new job instance.
     */
     public function __construct(User $user, Business $business)
    {
        $this->user = $user;
        $this->business = $business;
    }

    /**
     * Execute the job.
     */
     public function handle(): void
    {
        Mail::to($this->user->email)->send(new WelcomeEmail($this->user, $this->business));
    }
}
