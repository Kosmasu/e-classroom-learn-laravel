<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinWord implements Rule
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
      $split = explode(" ", $value);
      $numOfWord = count($split);
      return $numOfWord >= $this->min;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
      return ':attribute harus memiliki minimal kata sebanyak ' . $this->min;
    }
}
