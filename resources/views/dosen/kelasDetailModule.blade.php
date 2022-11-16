@extends('layout.dosen.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">Kelas</h1>
  </div>
  <div class="flex space-x-2">
    <a href="{{ route('dosen.kelas.detail', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Detail</a>
    <a href="{{ route('dosen.kelas.absensi', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Absensi</a>
    <a href="{{ route('dosen.kelas.mahasiswa', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Mahasiswa</a>
    <a href="{{ route('dosen.kelas.pengumuman', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Pengumuman</a>
    <a href="{{ route('dosen.kelas.module', ['id' => $id]) }}" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Module</a>
  </div>
  <div class="mt-8 space-y-1">
    <div class="text-lg font-bold">
      <h1>Detail Module</h1>
    </div>
    @if ($errors->any())
    <div class="space-y-1 mt-1">
      @foreach ($errors->all() as $error)
        <div class="p-2 bg-red-600 rounded">
          {{ $error }}
        </div>
      @endforeach
    </div>
    @endif
    <div class="text-lg font-bold">
      <h1>List Pekerjaan Mahasiswa</h1>
    </div>
    <div class="w-full rounded lg:rounded-lg shadow lg:shadow-lg overflow-hidden border border-gray-900">
      <table class="table-auto min-w-full px-2 py-1">
        <thead>
          <tr class="bg-navy-primary text-gray-200">
            <th class="px-2 py-1">#</th>
            <th class="px-2 py-1">NRP</th>
            <th class="px-2 py-1">Jawaban</th>
            <th class="px-2 py-1">Nilai</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($listMahasiswa as $key => $item)
            <tr class="odd:bg-slate-300 even:bg-slate-200">
              <td class="px-2 py-1 text-center">{{ $key + 1 }}</td>
              <td class="px-2 py-1 text-center">{{ $item->mhs_nrp }}</td>
              <td class="px-2 py-1">{{ $item->mhs_mod_jawaban }}</td>
              <td class="px-2 py-1 text-center">{{ $item->mhs_mod_nilai }}</td>
            </tr>
          @empty
            <tr class="odd:bg-slate-300 even:bg-slate-200">
              <td colspan="7"><h1>Kosong!</h1></td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
