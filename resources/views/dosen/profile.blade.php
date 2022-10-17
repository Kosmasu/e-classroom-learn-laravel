@extends('layout.dosen.main')

@section('content')
  <div class="container mx-auto">
    <h1 class="text-xl font-semibold text-center">Profile</h1>
    <div class="mt-8 text-lg">
      <form action="{{ route('dosen.gantiProfile') }}" method="POST">
        @csrf
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Username:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="username" id="username" value="{{ $currentUser["username"] }}">
          </div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Password:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="password" id="password" value="{{ $currentUser["password"] }}">
          </div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Confirm Password:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="confirm_password" id="confirm_password" value="{{ $currentUser["password"] }}">
          </div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Tahun Kelulusan:</div>
          <div class="w-2/3">{{ $currentUser["tahun_kelulusan"] }}</div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Jurusan Kelulusan:</div>
          <div class="w-2/3">{{ $currentUser["jurusan_kelulusan"] }}</div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Nama Lengkap:</div>
          <div class="w-2/3">{{ $currentUser["nama_lengkap"] }}</div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Tanggal Lahir:</div>
          <div class="w-2/3">{{ $currentUser["tanggal_lahir"] }}</div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Email:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="email" id="email" value="{{ $currentUser["email"] }}">
          </div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Nomor Telepon:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="nomor_telepon" id="nomor_telepon" value="{{ $currentUser["nomor_telepon"] }}">
          </div>
        </div>
        @if (Session::has('response'))
          @if (Session::get('response')["status"] == "failed")
            <div class="rounded bg-red-300 text-red-900 text-center text-lg px-2 py-1">
              {{ Session::get('response')["message"] }}
            </div>
          @elseif (Session::get('response')["status"] == "success")
            <div class="rounded bg-green-300 text-green-900 text-center text-lg px-2 py-1">
              {{ Session::get('response')["message"] }}
            </div>
          @endif
        @endif
        <div class="flex justify-end">
          <input class="px-2 py-1 mt-2 bg-navy-primary rounded text-gray-100 font-medium hover:bg-navy-secondary" type="submit" value="Edit Profile" name="submit">
        </div>
      </form>
    </div>
  </div>
@endsection
