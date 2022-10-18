<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
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

      $listMahasiswa = Session::get('listMahasiswa') ?? [];
      $listDosen = Session::get('listDosen') ?? [];

      foreach ($listMahasiswa as $item) {
        if ($this->request->username == $item["nrp"] && $this->request->password == $item["password"]) {
          $isMahasiswa = true; break;
        }
      }

      foreach ($listDosen as $item) {
        if ($this->request->username == $item["username"] && $this->request->password == $item["password"]) {
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
