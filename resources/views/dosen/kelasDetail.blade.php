@extends('layout.dosen.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">Detail Kelas</h1>
  </div>
  <div class="flex space-x-2">
    <a href="{{ route('dosen.kelas.detail', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Detail</a>
    <a href="{{ route('dosen.kelas.absensi', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Absensi</a>
    <a href="{{ route('dosen.kelas.mahasiswa', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Mahasiswa</a>
    <a href="{{ route('dosen.kelas.pengumuman', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Pengumuman</a>
    <a href="{{ route('dosen.kelas.module', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Module</a>
  </div>
  <div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Mata Kuliah: </div>
      <div class="w-3/4 text-left">{{ $kelas->matkul_nama }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Jadwal: </div>
      <div class="w-3/4 text-left">{{ $kelas->kel_jadwal }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Periode: </div>
      <div class="w-3/4 text-left">{{ $kelas->per_tahun_awal . '/' . $kelas->per_tahun_akhir }}</div>
    </div>
    <div class="w-full flex space-x-2">
      <div class="w-1/4 text-right">Dosen: </div>
      <div class="w-3/4 text-left">{{ $kelas->dsn_nama }}</div>
    </div>
  </div>
</div>
@endsection
