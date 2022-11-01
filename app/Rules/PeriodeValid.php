<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PeriodeValid implements Rule
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
      $listPeriode = DB::table('periode')->get();
      foreach ($listPeriode as $periode) {
        if ($periode->per_id == $value) {
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
