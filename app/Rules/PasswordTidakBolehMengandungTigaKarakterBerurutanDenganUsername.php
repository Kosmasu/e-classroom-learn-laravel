<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class PasswordTidakBolehMengandungTigaKarakterBerurutanDenganUsername implements Rule
{
  public $username;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($username)
    {
      $this->username = $username;
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
      for ($i=0; $i < strlen($value) ; $i++) {
        $str = substr($value, $i, 3);
        if (str_contains($this->username, $str)) {
          return false;
        }
      }
      return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute tidak boleh mengandung tiga karakter berurutan dengan username';
    }
}
