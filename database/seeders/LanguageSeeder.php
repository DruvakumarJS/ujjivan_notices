<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;


class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages =
            [
                [
                    'lang' => 'Assamese',
                    'name' => 'অসমীয়া',
                    'code' =>'as',
                    'font' => 'Shree-Ass-001'
                ],
                [
                    'lang' => 'Bengali',
                    'name' => 'বাংলা',
                    'code' =>'bn',
                    'font' => 'SHREE-BAN-0560E'
                ],
                [
                    'lang' => 'English',
                    'name' => 'English',
                    'code' =>'en',
                    'font' => 'Calibri'
                ],
                [
                    'lang' => 'Gujarati',
                    'name' => 'ગુજરાતી',
                    'code' =>'gu',
                    'font' => 'SHREE-GUJ-0768'
                ],
                [
                    'lang' => 'Hindi',
                    'name' => 'हिंदी',
                    'code' =>'hi',
                    'font' => 'SHREE-DEV-0715E'
                ],
                [
                    'lang' => 'Kannada',
                    'name' => 'ಕನ್ನಡ',
                    'code' =>'kn',
                    'font' => 'Shree-Kan-001'
                ],

                [
                    'lang' => 'Khasi',
                    'name' => 'Khasi',
                    'code' =>'kh',
                    'font' => 'Courier'
                ],
                [
                    'lang' => 'Malayalam',
                    'name' => 'മലയാളം',
                    'code' =>'ml',
                    'font' => 'SHREE-MAL-0501'
                ],
                [
                    'lang' => 'Marathi',
                    'name' => 'मराठी',
                    'code' =>'mr',
                    'font' => 'SHREE-DEV-0714'
                ],
                [
                    'lang' => 'Oriya/Odia',
                    'name' => 'ଓଡିଆ',
                    'code' =>'or',
                    'font' => 'SHREE-ORI-0601M'
                ],
                [
                    'lang' => 'Punjabi',
                    'name' => 'ਪੰਜਾਬੀ',
                    'code' =>'pa',
                    'font' => 'Shree-Pun-001'
                ],
                [
                    'lang' => 'Tamil',
                    'name' => 'தமிழ்',
                    'code' =>'ta',
                    'font' => 'TAM-Shree802'
                ],
                [
                    'lang' => 'Telugu',
                    'name' => 'తెలుగు',
                    'code' =>'te',
                    'font' => 'SHREE-TEL-1642'
                ],
                [
                    'lang' => 'Urdu',
                    'name' => 'اردو',
                    'code' =>'ar',
                    'font' => 'Jameel Noori Nastaleeq'
                ],
                
                
            
            ];

             foreach ($languages as $key => $value) {
               $language = Language::create($value);
             }
    }
}
