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
  </div>
  <div>
    <div class="text-lg font-bold">
      <h1>Create Pengumuman</h1>
    </div>
    <form action="{{ route('dosen.kelas.doCreatePengumuman', ['id' => $id]) }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $id }}">
      <div class="space-y-1">
        <div class="flex flex-col">
          <label class="w-full px-1" for="deskripsi">Deskripsi</label>
          <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi">
        </div>
        <div class="flex flex-col">
          <label class="w-full px-1" for="link_penting">Link Penting</label>
          <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="link_penting" id="link_penting" placeholder="Link Penting">
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
          <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Create">
        </div>
      </div>
    </form>
    @if ($errors->any())
    <div class="space-y-1 mt-1">
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
