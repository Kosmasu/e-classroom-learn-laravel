@extends('layout.mahasiswa.main')

@section('content')
<div class="container mx-auto">
  <h1 class="text-2xl font-semibold text-center">Ini Home</h1>
  <div class="flex justify-center mt-2 space-x-2">
    <a class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" href="{{ route('mahasiswa.kelas') }}">List Kelas</a>
    <a class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" href="{{ route('mahasiswa.myKelas') }}">My Kelas</a>
    <a class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" href="{{ route('mahasiswa.joinKelas') }}">Join Kelas</a>
  </div>
</div>
@endsection
