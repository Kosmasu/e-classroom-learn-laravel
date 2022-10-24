@extends('layout.admin.main')

@section('content')
<div>
  <h1 class="text-center text-2xl font-semibold">
    Edit Mata Kuliah
  </h1>
</div>
<div class="w-1/3 flex-shrink-0">
  <form action="{{ route('admin.doEditMataKuliah') }}" method="POST">
    @csrf
    <div class="space-y-1">
      <div class="flex flex-col">
        <label class="w-full px-1" for="nama_mata_kuliah">Kode Mata Kuliah: {{ $mataKuliah["kode"] }}</label>
        <input type="hidden" name="id" value="{{ $mataKuliah ['kode'] }}">
      </div>
      <div class="flex flex-col">
        <label class="w-full px-1" for="nama_mata_kuliah">Nama Mata Kuliah</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="nama_mata_kuliah" id="nama_mata_kuliah" placeholder="Nama Mata Kuliah" value="{{ $mataKuliah['nama'] }}">
      </div>
      <div class="flex flex-col">
        <label class="w-full px-1" for="minimal_semester">Minimal Semester</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="minimal_semester" id="minimal_semester" placeholder="Minimal Semester" value="{{ $mataKuliah['minimal_semester'] }}">
      </div>
      <div>
        <label class="w-full px-1" for="sks">SKS</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="number" name="sks" id="sks" placeholder="SKS" value="{{ $mataKuliah['sks'] }}">
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
        <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Edit">
      </div>
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

@endsection
