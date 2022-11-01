<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
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

      $listMahasiswa = DB::table('mahasiswa')->get();
      $listDosen = DB::table('dosen')->get();

      $isUnique = true;
      foreach ($listMahasiswa as $key => $item) {
        if ($item->mhs_nomor_telepon == $value) {
          $isUnique = false; break;
        }
      }
      foreach ($listDosen as $key => $item) {
        if ($item->dsn_nomor_telepon == $value) {
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
