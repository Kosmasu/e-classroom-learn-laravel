<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Session;

class UsernameDosenUnik implements Rule
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
      $listDosen = [];

      $listDosen = Session::get('listDosen') ?? [];

      $isUnique = true;
      foreach ($listDosen as $key => $value) {
        if ($value["username"] == $value) {
          $isUnique = false; break;
        }
      }
      return $isUnique;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute harus unik!';
    }
}
