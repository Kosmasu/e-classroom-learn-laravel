@extends('layout.mahasiswa.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">My Kelas</h1>
  </div>
  <div class="flex space-x-2">
    <a href="{{ route('mahasiswa.myKelas.detail', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Detail</a>
    <a href="{{ route('mahasiswa.myKelas.absensi', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Absensi</a>
  </div>
  <div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Mata Kuliah: </div>
      <div class="w-3/4 text-left">{{ $kelas['mata_kuliah'] }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Jadwal: </div>
      <div class="w-3/4 text-left">{{ $kelas['jadwal'] }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Periode: </div>
      <div class="w-3/4 text-left">{{ $kelas['periode'] }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Dosen: </div>
      <div class="w-3/4 text-left">{{ $kelas['dosen'] }}</div>
    </div>
  </div>
</div>
@endsection
