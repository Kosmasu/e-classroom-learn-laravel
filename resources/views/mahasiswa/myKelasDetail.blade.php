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
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">Feeds</h1>
  </div>
  <div class="flex flex-col space-y-1">
    @forelse ($listFeed as $item)
      <div class="p-2">
        <h2 class="text-lg font-semibold">{{ $item->title }}</h2>
        <p>
          {{ $item->isi}}
        </p>
      </div>
      <hr>
    @empty
      <h2 class="text-xl font-semibold text-center">Kosong</h2>
    @endforelse
  </div>
</div>
@endsection
