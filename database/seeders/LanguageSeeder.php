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
                ],
                [
                    'lang' => 'Bengali',
                    'name' => 'বাংলা',
                    'code' =>'bn',
                ],
                [
                    'lang' => 'English',
                    'name' => 'English',
                    'code' =>'en',
                ],
                [
                    'lang' => 'Gujarati',
                    'name' => 'ગુજરાતી',
                    'code' =>'gu',
                ],
                [
                    'lang' => 'Hindi',
                    'name' => 'हिंदी',
                    'code' =>'hi',
                ],
                [
                    'lang' => 'Kannada',
                    'name' => 'ಕನ್ನಡ',
                    'code' =>'kn',
                ],

                [
                    'lang' => 'Khasi',
                    'name' => 'Khasi',
                    'code' =>'kh',
                ],
                [
                    'lang' => 'Malayalam',
                    'name' => 'മലയാളം',
                    'code' =>'ml',
                ],
                [
                    'lang' => 'Marathi',
                    'name' => 'मराठी',
                    'code' =>'mr',
                ],
                [
                    'lang' => 'Oriya/Odia',
                    'name' => 'ଓଡିଆ',
                    'code' =>'or',
                ],
                [
                    'lang' => 'Punjabi',
                    'name' => 'ਪੰਜਾਬੀ',
                    'code' =>'pa',
                ],
                [
                    'lang' => 'Tamil',
                    'name' => 'தமிழ்',
                    'code' =>'ta',
                ],
                [
                    'lang' => 'Telugu',
                    'name' => 'తెలుగు',
                    'code' =>'te',
                ],
                [
                    'lang' => 'Urdu',
                    'name' => 'اردو',
                    'code' =>'ur',
                ],
                
                
            
            ];

             foreach ($languages as $key => $value) {
               $language = Language::create($value);
             }
    }
}
