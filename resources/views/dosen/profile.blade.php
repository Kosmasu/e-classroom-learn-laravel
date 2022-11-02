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
            <input class="bg-inherit border border-gray-900" type="text" name="username" id="username" value="{{ $currentUser->dsn_username }}">
          </div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Password:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="password" id="password" value="{{ $currentUser->dsn_password }}">
          </div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Confirm Password:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="confirm_password" id="confirm_password" value="{{ $currentUser->dsn_password }}">
          </div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Tahun Kelulusan:</div>
          <div class="w-2/3">{{ $currentUser->dsn_tahun_kelulusan }}</div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Jurusan Kelulusan:</div>
          <div class="w-2/3">{{ $currentUser->dsn_jurusan_kelulusan }}</div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Nama Lengkap:</div>
          <div class="w-2/3">{{ $currentUser->dsn_nama }}</div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Tanggal Lahir:</div>
          <div class="w-2/3">{{ $currentUser->dsn_tanggal_lahir }}</div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Email:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="email" id="email" value="{{ $currentUser->dsn_email }}">
          </div>
        </div>
        <div class="flex">
          <div class="w-1/3 text-right pr-2 font-semibold">Nomor Telepon:</div>
          <div class="w-2/3">
            <input class="bg-inherit border border-gray-900" type="text" name="nomor_telepon" id="nomor_telepon" value="{{ $currentUser->dsn_nomor_telepon }}">
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
      @if ($errors->any())
      <div class="space-y-1 mt-1 text-gray-200">
        @foreach ($errors->all() as $error)
          <div class="p-2 bg-red-600 rounded">
            {{ $error }}
          </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>
@endsection
