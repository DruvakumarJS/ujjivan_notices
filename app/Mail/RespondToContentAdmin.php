<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RespondToContentAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lang,$data)
    {
        $this->lang = $lang;
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject("Reviewed Content - " . strtoupper($this->lang))
                    ->view('emails.reviewed_content'); // Basic view
                    
    }
}
