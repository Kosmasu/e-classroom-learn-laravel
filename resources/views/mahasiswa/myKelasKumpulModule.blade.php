@extends('layout.mahasiswa.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">My Kelas</h1>
  </div>
  <div class="flex space-x-2">
    <a href="{{ route('mahasiswa.myKelas.detail', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Detail</a>
    <a href="{{ route('mahasiswa.myKelas.absensi', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Absensi</a>
    <a href="{{ route('mahasiswa.myKelas.konfirmasiLeave', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Leave</a>
    <a href="{{ route('mahasiswa.myKelas.module', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Module</a>
  </div>
  <div class="mt-8">
    <h1 class="text-2xl font-semibold">Kumpul Modul</h1>
  </div>
  <div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Nama Modul:</div>
      <div class="w-3/4 text-left">{{ $module->mod_nama }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Jenis:</div>
      <div class="w-3/4 text-left">{{ $module->mod_jenis }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Keterangan:</div>
      <div class="w-3/4 text-left">{{ $module->mod_keterangan }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Deadline:</div>
      <div class="w-3/4 text-left">{{ $module->mod_deadline }}</div>
    </div>
    <form action="{{ route('mahasiswa.myKelas.doKumpulModule', ['id' => $id]) }}" method="POST">
      @csrf
      <input type="hidden" name="kel_id" value="{{ $id }}">
      <input type="hidden" name="mod_id" value="{{ $mod_id }}">
      <div class="space-y-1">
        <div class="flex flex-col">
          <label class="w-full px-1" for="jawaban">Jawaban</label>
          <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="jawaban" id="jawaban" placeholder="Jawaban" value="{{ $jawaban }}">
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
        <div class="w-full flex justify-end">
          <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Submit">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
