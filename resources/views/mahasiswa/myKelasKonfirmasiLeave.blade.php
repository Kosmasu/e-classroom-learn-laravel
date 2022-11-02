@extends('layout.mahasiswa.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">Konfirmasi Leave</h1>
    <p class="text-md">Anda tidak akan bisa join kelas ini lagi</p>
  </div>
  <div>
    <form action="{{ route('mahasiswa.myKelas.doLeave') }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $id }}">
      <button type="submit" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Leave</button>
    </form>
  </div>
</div>
@endsection
