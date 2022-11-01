<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginTerdaftar implements Rule
{
    public $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
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

      $isMahasiswa = false;
      $isDosen = false;
      $isAdmin = $this->request->username == "admin" && $this->request->password == "admin";

      $listMahasiswa = DB::table('mahasiswa')->get();
      $listDosen = DB::table('dosen')->get();

      foreach ($listMahasiswa as $item) {
        if ($this->request->username == $item->mhs_nrp && $this->request->password == $item->mhs_password) {
          $isMahasiswa = true; break;
        }
      }

      foreach ($listDosen as $item) {
        if ($this->request->username == $item->dsn_username && $this->request->password == $item->dsn_password) {
          $isDosen = true; break;
        }
      }

      return $isMahasiswa || $isDosen || $isAdmin;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Username/password salah!';
    }
}
