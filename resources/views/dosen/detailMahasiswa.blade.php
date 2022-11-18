@extends('layout.dosen.main')

@section('content')
  <div class="container mx-auto">
    <h1 class="text-2xl font-semibold text-center">Detail Mahasiswa</h1>
    <div class="w-full flex justify-center">
      @dump($mahasiswa)
    </div>
    <p>Sorry ko sudah jenuh 😁😁</p>
  </div>
@endsection
