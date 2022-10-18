<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinVowel implements Rule
{
    public $min;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($min)
    {
      $this->min = $min;
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
      $vowels = ["a", "i", "u", "e", "o"];
      $counts = count_chars($value . "aiueo", 1);
      $ctrVowel = 0;
      foreach ($vowels as $vowel) {
        $ctrVowel += $counts[ord($vowel)] - 1;
      }
      return $ctrVowel >= $this->min;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute harus memiliki minimal vowel sebanyak ' . $this->min;
    }
}
