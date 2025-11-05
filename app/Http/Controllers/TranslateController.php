<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleTranslateService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use App\Models\Language;
use Stichoza\GoogleTranslate\GoogleTranslate;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Shared\Html;
use ZipArchive;
use App\Models\TranslationLog;
use Auth;




class TranslateController extends Controller
{
    public function dashboard(Request $request){
      
      if($request->start == ''){
           $start = date('Y-m').'-01 00:00:01';
           $end =date('Y-m-d H:i:s');
      }else{

      }

      $overall_translation = TranslationLog::sum('character_count');
      $overall_instance = TranslationLog::select('id','token')->distinct('token')->count();
      $overall_langs = TranslationLog::select('id','language_code')->distinct('language_code')->count();


      $total_translation = TranslationLog::whereBetween('created_at',[$start, $end])->sum('character_count');
      $total_instance = TranslationLog::select('id','token')->whereBetween('created_at',[$start, $end])->distinct('token')->count();
      $total_langs = TranslationLog::select('id','language_code')->whereBetween('created_at',[$start, $end])->distinct('language_code')->count();

      $Languages = Language::get();

      foreach ($Languages as $key => $value) {
          $characters=TranslationLog::whereBetween('created_at',[$start, $end])->where('language_code',$value->code)->sum('character_count');
          $langNamesArray[]=$value->lang;
          $langCountArray[]=$characters;
      }

      $chartData=['name' => $langNamesArray , 'count' => $langCountArray ];

      return view('translations.dashboard',compact('total_translation','total_instance','total_instance','total_langs','langNamesArray','langCountArray','chartData' ,'overall_translation','overall_instance','overall_langs'));
    }

    public function showForm()
    {
        $languages = Language::whereNotIn('code',['en','kh'])->get();
        return view('translations.formeditor',compact('languages'));
    }

    
    private function sanitizeHtml($html)
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        return $dom->saveHTML();
    }

    /**
     * Return a font that supports the target language.
     */
    private function getFontForLanguage($lang)
    {
        switch ($lang) {
            case 'hi': return 'Noto Sans Devanagari'; // Hindi
            case 'ta': return 'Noto Sans Tamil';       // Tamil
            case 'te': return 'Noto Sans Telugu';      // Telugu
            case 'kn': return 'Noto Sans Kannada';     // Kannada
            case 'ml': return 'Noto Sans Malayalam';   // Malayalam
            case 'bn': return 'Noto Sans Bengali';     // Bengali
            default:   return 'Noto Sans';             // Fallback
        }
    }

    public function translateCKData(Request $request)
    {

        $start = date('Y-m').'-01 00:00:01';
        $end =date('Y-m-d H:i:s');


        $total_translation = TranslationLog::whereBetween('created_at',[$start, $end])->sum('character_count');



        $text = $request->input('text');
        $languages = $request->input('languages');
        $token='RAN'.rand('1111','9999').date('His');

        if (empty($text) || empty($languages)) {
            return "<div class='alert alert-danger'>❌ Please provide text and select at least one language.</div>";
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
        $textNodes = $xpath->query('//text()[normalize-space()]');

        $translatedData = [];
        $totalCharsTranslated = 0;

        foreach ($languages as $lang) {
            $tr = new GoogleTranslate($lang);
            $charCount = 0;


            foreach ($textNodes as $node) {
                $original = $node->nodeValue;
                $node->nodeValue = $tr->translate($original);
               // $node->nodeValue = $translated;

                $charCount += mb_strlen($original, 'UTF-8');
            }
            $translatedData[$lang] = $dom->saveHTML();
           // $translatedData[$lang] = $translatedHtml;

            $totalCount = intval($charCount)+intval($total_translation);

            if($totalCount >=  '2000' ){
               return response()->json([
                    'status' => 'error',
                    'message' => 'You don’t have enough quota to translate this content.'
                ]);
            }
             TranslationLog::create([
                'language_code' => $lang,
               // 'translated_content' => $translatedHtml,
                'userID' => Auth::user()->email,
                'token'=> $token,
                'character_count' => $charCount,
            ]);

             $totalCharsTranslated += $charCount;

            // reset DOM for next language
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $xpath = new \DOMXPath($dom);
            $textNodes = $xpath->query('//text()[normalize-space()]');
        }

        // ✅ Build preview output
        $output = "<div class='card p-3'>";
        $output .= "<h4 class='text-center mb-3'>🌍 Translation Result</h4>";
        $output .= "<h5>Original Content:</h5><div class='content-block border p-2 mb-3'>{$text}</div><hr>";

        foreach ($translatedData as $lang => $translatedHtml) {
            $encodedTranslation = htmlspecialchars($translatedHtml, ENT_QUOTES, 'UTF-8');

            $output .= "<div class='border p-2 mb-3'>
                            <h5>Language: <b>" . strtoupper($lang) . "</b></h5>
                            <div class='content-block'>{$translatedHtml}</div>
                            <form method='POST' action='" . route('download.single') . "' target='_blank'>
                                " . csrf_field() . "
                                <input type='hidden' name='lang' value='{$lang}'>
                                <input type='hidden' name='content' value='{$encodedTranslation}'>
                                <button type='submit' class='btn btn-sm btn-primary mt-2'>⬇️ Download ({$lang})</button>
                            </form>
                         </div>";
        }

        // ✅ Download All button
        $encodedAll = htmlspecialchars(json_encode($translatedData), ENT_QUOTES, 'UTF-8');
        $output .= "
            <form method='POST' action='" . route('download.all') . "' target='_blank'>
                " . csrf_field() . "
                <input type='hidden' name='original' value='" . e($text) . "'>
                <input type='hidden' name='translations' value='{$encodedAll}'>
                <button type='submit' class='btn btn-success mt-3'>⬇️ Download All (HTML)</button>
            </form>

        ";
        $output .= "</div>";

        return $output;
      
    }

    // ✅ Download single language
    public function downloadSingle(Request $request)
    {
        $lang = $request->input('lang');
        $content = html_entity_decode($request->input('content'));

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Translation - ' . strtoupper($lang) . '</title>
        <style>
            body { font-family: Calibri, sans-serif; padding: 20px; background:#f8f9fa; color:#333; }
            h2 { color:#007bff; }
            div.content-block { border:1px solid #ccc; padding:10px; background:#fff; margin-top:20px; }
            table { border-collapse: collapse; width: 100%; }
            table, th, td { border: 1px solid #aaa; padding: 5px; }
        </style></head><body>';

        $html .= "<h2>🌐 Translated Content (" . strtoupper($lang) . ")</h2><div class='content-block'>{$content}</div></body></html>";

        $timestamp = now()->format('Ymd_His');
        $fileName = "translation_{$lang}_{$timestamp}.html";

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");
    }

    // ✅ Download all translations together
    /*public function downloadAll(Request $request)
    {
        $original = $request->input('original');
        $translations = json_decode($request->input('translations'), true);

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>All Translations</title>
        <style>
            body { font-family: Calibri, sans-serif; padding: 20px; background:#f8f9fa; color:#333; }
            h2, h3 { color:#000; }
            div.content-block { border:1px solid #ccc; padding:10px; background:#fff; margin-bottom:20px; }
            table { border-collapse: collapse; width: 100%; }
            table, th, td { border: 1px solid #aaa; padding: 5px; }
        </style></head><body>';

        $html .= "<h2>🌍 All Translations</h2><hr>";
        $html .= "<h3>Original Content:</h3><div class='content-block'>{$original}</div><hr>";

        foreach ($translations as $lang => $translatedHtml) {
            $html .= "<h3>Language: " . strtoupper($lang) . "</h3>";
            $html .= "<div class='content-block'>{$translatedHtml}</div>";
        }

        $html .= "</body></html>";

        $langs = implode('_', array_keys($translations));
        $timestamp = now()->format('Ymd_His');
        $fileName = "translations_{$langs}_{$timestamp}.html";

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");
    }*/

    public function downloadAll(Request $request)
    {
        $translations = json_decode($request->input('translations'), true);

        $zip = new ZipArchive;
        $zipFile = storage_path('app/public/translations_' . now()->format('Ymd_His') . '.zip');

        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($translations as $lang => $translatedHtml) {
                $fileName = "translation_{$lang}.html";
                $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Translation - ' . strtoupper($lang) . '</title>
                <style>
                    body { font-family: Calibri, sans-serif; padding: 20px; background:#f8f9fa; color:#333; }
                    h2 { color:#007bff; }
                    div.content-block { border:1px solid #ccc; padding:10px; background:#fff; margin-top:20px; }
                    table { border-collapse: collapse; width: 100%; }
                    table, th, td { border: 1px solid #aaa; padding: 5px; }
                </style></head><body>';

                $html .= "<h2>🌐 Translated Content (" . strtoupper($lang) . ")</h2>
                          <p><small>Generated on: " . now()->format('d M Y, h:i A') . "</small></p>
                          <div class='content-block'>{$translatedHtml}</div></body></html>";

                $zip->addFromString($fileName, $html);
            }
            $zip->close();
        }

        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    public function downloadDocx(Request $request)
    {
        $lang = $request->input('lang');
        $content = html_entity_decode($request->input('content'), ENT_QUOTES, 'UTF-8');

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Remove unwanted HTML tags and decode
        $plainText = strip_tags($content);
        $section->addText("Language: " . strtoupper($lang), ['bold' => true, 'size' => 14]);
        $section->addTextBreak(1);
        $section->addText($plainText);

        $fileName = 'translation_' . $lang . '_' . now()->format('Ymd_His') . '.docx';

        // Save to temp and return as download
        $tempFile = tempnam(sys_get_temp_dir(), 'docx');
        $phpWord->save($tempFile, 'Word2007');

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }


}

