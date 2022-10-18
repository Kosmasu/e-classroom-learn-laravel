@extends('layout.skeleton')

@section('body')
  <div class="w-screen h-screen bg-no-repeat bg-cover relative"
    style="background-image: url('{{ asset('images/banner.jpg') }}');">
    <div class="h-screen flex justify-center items-center">
      <span class="w-full h-full bg-black opacity-50 absolute z-0"></span>
      <div class="p-8 rounded lg:rounded-lg shadow lg:shadow-lg bg-navy-primary text-gray-200 z-10">
        <div>
          <h1 class="text-3xl font-bold text-center">Register Dosen</h1>
        </div>
        <form action="{{ route('auth.register.doDosen') }}" method="POST">
          @csrf
          <div class="flex flex-row mt-4 space-x-3">
            <div class="w-1/2 space-y-1">
              <div>
                <label class="w-full px-1" for="username">Username</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="username" id="username" placeholder="Username">
              </div>
              <div>
                <label class="w-full px-1" for="password">Password</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="password" name="password" id="password" placeholder="Password">
              </div>
              <div>
                <label class="w-full px-1" for="confirm_password">Confirm Password</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
              </div>
              <div>
                <label class="w-full px-1" for="tahun_kelulusan">Tahun Kelulusan</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="date" name="tahun_kelulusan" id="tahun_kelulusan" placeholder="Tahun Kelulusan">
              </div>
              <div>
                <label class="w-full px-1" for="jurusan_kelulusan">Jurusan Kelulusan</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="jurusan_kelulusan" id="jurusan_kelulusan" placeholder="Jurusan Kelulusan">
              </div>
            </div>
            <div class="w-1/2 space-y-1">
              <div>
                <label class="w-full px-1" for="nama_lengkap">Nama Lengkap</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap">
              </div>
              <div>
                <label class="w-full px-1" for="tanggal_lahir">Tanggal Lahir</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="date" name="tanggal_lahir" id="tanggal_lahir" placeholder="Tanggal Lahir">
              </div>
              <div>
                <label class="w-full px-1" for="email">Email</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="email" id="email" placeholder="Email">
              </div>
              <div>
                <label class="w-full px-1" for="nomor_telepon">Nomor Telepon</label>
                <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="nomor_telepon" id="nomor_telepon" placeholder="Nomor Telepon">
              </div>
              <div class="flex items-center px-1">
                <input class="scale-125" type="checkbox" name="konfirmasi_syarat_dan_ketentuan" id="konfirmasi_syarat_dan_ketentuan" value="true">
                <label class="w-full px-1" for="konfirmasi_syarat_dan_ketentuan">Konfirmasi Syarat dan Ketentuan</label>
              </div>
            </div>
          </div>
          @if (Session::has('response'))
            @if (Session::get('response')["status"] == "failed")
              <div class="rounded bg-red-300 text-red-900 text-center text-xl px-2 py-1 mt-2">
                {{ Session::get('response')["message"] }}
              </div>
            @elseif (Session::get('response')["status"] == "success")
              <div class="rounded bg-green-300 text-green-900 text-center text-xl px-2 py-1 mt-2">
                {{ Session::get('response')["message"] }}
              </div>
            @endif
          @endif
          <input class="w-full px-2 py-1 mt-2 bg-gray-200 rounded text-gray-900 font-medium hover:bg-gray-300 active:bg-gray-400" type="submit" value="Register" name="submit">
        </form>
        @if ($errors->any())
        <div class="space-y-1 mt-1">
          @foreach ($errors->all() as $error)
            <div class="p-2 bg-red-600 rounded">
              {{ $error }}
            </div>
          @endforeach
        </div>
        @endif
        <div class="mt-1">
          <p class="text-xs">
            Sudah punya akun? login
            <a class="text-yellow-primary hover:underline" href="{{ route('auth.login') }}">disini</a>
          </p>
          <p class="text-xs">
            Anda mahasiswa? register
            <a class="text-yellow-primary hover:underline" href="{{ route('auth.register.mahasiswa') }}">disini</a>
          </p>
        </div>
      </div>
    </div>
  </div>
@endsection
