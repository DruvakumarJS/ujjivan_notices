<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TranslatedContentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lang;
    public $filePath;

    public function __construct($lang, $filePath)
    {
        $this->lang = $lang;
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->subject("Translated Content - " . strtoupper($this->lang))
                    ->view('emails.translated_content') // Basic view
                    ->attach($this->filePath, [
                        'as' => 'Translated_' . $this->lang . '.html',
                        'mime' => 'text/html',
                    ])
                    ->with(['lang' => $this->lang]);
    }
}
