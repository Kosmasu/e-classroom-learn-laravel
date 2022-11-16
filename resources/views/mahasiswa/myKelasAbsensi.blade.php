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
    <div class="w-full rounded lg:rounded-lg shadow lg:shadow-lg overflow-hidden border border-gray-900 mt-4">
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
      <table class="table-auto min-w-full px-2 py-1">
        <thead>
          <tr class="bg-navy-primary text-gray-200">
            <th class="px-2 py-1">#</th>
            <th class="px-2 py-1">Minggu Ke</th>
            <th class="px-2 py-1">Materi</th>
            <th class="px-2 py-1">Deskripsi</th>
            <th class="px-2 py-1">Kehadiran</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($listAbsensi as $key => $absensi)
            <tr class="odd:bg-slate-300 even:bg-slate-200">
              <td class="px-2 py-1 text-center">{{ $key + 1 }}</td>
              <td class="px-2 py-1 text-center">{{ $absensi->abs_minggu_ke }}</td>
              <td class="px-2 py-1 text-center">{{ $absensi->abs_materi }}</td>
              <td class="px-2 py-1 text-center">{{ $absensi->abs_deskripsi }}</td>
              <td class="px-2 py-1 text-center">
                @if($absensi->abs_mhs_is_hadir == 1)
                  <i class="fa-solid fa-check text-green-600"></i>
                @else
                  <i class="fa-solid fa-x text-red-600"></i>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-xl text-center font-semibold py-4" colspan="5">Tidak ada absensi...</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
