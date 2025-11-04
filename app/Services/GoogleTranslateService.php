<?php

namespace App\Services;

use Google\Cloud\Translate\V2\TranslateClient;

class GoogleTranslateService
{
    protected $translate;

    public function __construct()
    {
        $this->translate = new TranslateClient([
            'key' => env('GOOGLE_TRANSLATE_API_KEY'),
        ]);
    }

    public function translateMultiple($text, $languages)
    {
        $results = [];
        foreach ($languages as $lang) {
            $translation = $this->translate->translate($text, [
                'target' => $lang,
                'source' => 'en',
            ]);
            $results[$lang] = $translation['text'] ?? '';
        }
        return $results;
    }
}
