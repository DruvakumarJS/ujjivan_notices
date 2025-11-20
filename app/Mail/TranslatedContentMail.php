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
    public $path;
    public $name;
    public $mode;

    public function __construct($lang, $filePath,$path,$name,$mode)
    {
        $this->lang = $lang;
        $this->filePath = $filePath;
        $this->path=$path;
        $this->name=$name;
        $this->mode=$mode;
    }

    public function build()
    {
        if($this->mode == 'Review'){
           return $this->subject("Translated Content - " . strtoupper($this->lang))
                ->view('emails.translated_content') // Basic view
                ->attach($this->filePath, [
                    'as' => 'Translated_' . $this->lang . '.html',
                    'mime' => 'text/html',
                ])
                ->with(['lang' => $this->lang]);
        }else{
            return $this->subject("Content Rework- " . strtoupper($this->lang))
                ->view('emails.rework');
        
        }
    }
}
