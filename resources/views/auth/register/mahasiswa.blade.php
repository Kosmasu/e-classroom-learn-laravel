@extends('layout.skeleton')

@section('body')
  <div class="w-screen h-screen bg-no-repeat bg-cover relative"
    style="background-image: url('{{ asset('images/banner.jpg') }}');">
    <div class="h-screen flex justify-center items-center">
      <span class="w-full h-full bg-black opacity-50 absolute z-0"></span>
      <div class="p-8 rounded lg:rounded-lg shadow lg:shadow-lg w-80 bg-navy-primary text-gray-200 z-10">
        <div>
          <h1 class="text-3xl font-bold text-center">Register Mahasiswa</h1>
        </div>
        <div class="flex flex-col mt-4">
          <label class="w-full px-1 mt-2" for="nrp">NRP</label>
          <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200" type="text" name="nrp" id="nrp"
            placeholder="NRP">
          <label class="w-full px-1 mt-2" for="password">Password</label>
          <input class="w-full mt-1 rounded px-2 py-1 bg-gray-200" type="password" name="password" id="password"
            placeholder="Password">
            <a href="{{ route('auth.login') }}">
              <button class="w-full px-2 py-1 mt-4 bg-gray-200 rounded text-gray-900 font-medium hover:bg-gray-300 active:bg-gray-400">Register</button>
            </a>
        </div>
        <div class="mt-1">
          <p class="text-xs">
            Sudah punya akun? login
            <a class="text-yellow-primary hover:underline" href="{{ route('auth.login') }}">disini</a>
          </p>
          <p class="text-xs">
            Anda dosen? register
            <a class="text-yellow-primary hover:underline" href="{{ route('auth.register.dosen') }}">disini</a>
          </p>
        </div>
      </div>
    </div>
  </div>
@endsection
