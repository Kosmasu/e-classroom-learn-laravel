<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Foreach_;

class DosenValid implements Rule
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
      $listDosen = Session::get('listDosen') ?? [];
      foreach ($listDosen as $dosen) {
        if ($dosen["username"] == $value) {
          return true; break;
        }
      }
      return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
      return ':attribute tidak valid!';
    }
}
