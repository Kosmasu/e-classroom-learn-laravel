<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Session;

class NomorTeleponUnik implements Rule
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
      $listMahasiswa = [];
      $listDosen = [];

      $listMahasiswa = Session::get('listMahasiswa') ?? [];
      $listDosen = Session::get('listDosen') ?? [];

      $isUnique = true;
      foreach ($listMahasiswa as $key => $item) {
        if ($item['nomor_telepon'] == $value) {
          $isUnique = false; break;
        }
      }
      foreach ($listDosen as $key => $item) {
        if ($item['nomor_telepon'] == $value) {
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
        return ':attribute harus unik antar dosen dan mahasiswa';
    }
}
