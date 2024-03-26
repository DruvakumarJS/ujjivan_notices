<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoScriptInjection implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if the value contains any script tags
        // If the value is an array, iterate through each item and check for script tags
        if (is_array($value)) {
            foreach ($value as $notice) {
                if (isset($notice['voice_over']) && strpos(strtolower($notice['voice_over']), '<script') !== false) {
                    return false; // Return false if script tag found in any description
                }

                if (isset($notice['document_id']) && strpos(strtolower($notice['document_id']), '<script') !== false) {
                    return false; // Return false if script tag found in any description
                }
                if (isset($notice['version']) && strpos(strtolower($notice['version']), '<script') !== false) {
                    return false; // Return false if script tag found in any description
                }

                if (isset($notice['description']) && strpos(strtolower($notice['description']), '<script') !== false) {
                    return false; // Return false if script tag found in any description
                }
                if (isset($notice['tittle']) && strpos(strtolower($notice['tittle']), '<script') !== false) {
                    return false; // Return false if script tag found in any description
                }

                
            }
            return true; // Return true if no script tags found in any description
        } else {
            // Check if the single value contains any script tags
            return strpos(strtolower($value), '<script') === false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
         return 'The :attribute cannot contain script tags.';
    }
}
