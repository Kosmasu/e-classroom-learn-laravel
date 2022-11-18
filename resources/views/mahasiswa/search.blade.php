@extends('layout.mahasiswa.main')

@section('content')
<div class="container mx-auto">
  <h1 class="text-2xl font-semibold text-center">Search</h1>
  <div class="w-full flex justify-center">
    <form class="w-1/3 flex space-x-2">
      <input class="w-3/4 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="search" value="{{ "" }}">

      <button class="w-1/4 px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" href="{{ route('dosen.search') }}">Search</button>
    </form>
  </div>
  <div>
    <h1 class="text-lg font-semibold">Mahasiswa</h1>
    @forelse ($listMahasiswa as $item)
      <div>
        {{ $item->mhs_nama }} - <a class="text-blue-500 hover:text-blue-600 hover:underline"
        href="{{ route('mahasiswa.detail.mahasiswa', ['id'=>$item->mhs_nrp]) }}">Detail</a>
      </div>
    @empty
      <p>Tidak ketemu mahasiswa</p>
    @endforelse
  </div>
  <hr>
  <div>
    <h1 class="text-lg font-semibold">Dosen</h1>
    @forelse ($listDosen as $item)
      <div>
        {{ $item->dsn_nama }} - <a class="text-blue-500 hover:text-blue-600 hover:underline"
        href="{{ route('mahasiswa.detail.dosen', ['id'=>$item->dsn_username]) }}">Detail</a>
      </div>
    @empty
      <p>Tidak ketemu Dosen</p>
    @endforelse
  </div>
</div>
@endsection
