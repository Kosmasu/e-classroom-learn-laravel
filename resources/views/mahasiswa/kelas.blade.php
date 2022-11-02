@extends('layout.mahasiswa.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">List Kelas</h1>
  </div>
  <div class="flex justify-end mt-4">
    <form id="form_ganti_periode" action="{{ route('mahasiswa.gantiPeriode') }}" method="GET">
      <select
        class="rounded px-2 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
        name="kode_periode" id="kode_periode"
        onchange="gantiPeriode(event)">
        @forelse ($listPeriode as $item)
          <option {{ $item->per_id == $kode_periode ? 'selected' : '' }} value="{{ $item->per_id }}">{{ $item->per_tahun_awal . '/' . $item->per_tahun_akhir }}</option>
        @empty
          <option selected disabled>Tidak ada periode!</option>
        @endforelse
      </select>
    </form>

    <script>
      function gantiPeriode(event) {
        document.getElementById('form_ganti_periode').submit();
      }
    </script>
  </div>
  <div class="w-full rounded lg:rounded-lg shadow lg:shadow-lg overflow-hidden border border-gray-900 mt-4">
    <table class="table-auto min-w-full px-2 py-1">
      <thead>
        <tr class="bg-navy-primary text-gray-200">
          <th class="px-2 py-1">#</th>
          <th class="px-2 py-1">Mata Kuliah</th>
          <th class="px-2 py-1">Jadwal</th>
          <th class="px-2 py-1">Periode</th>
          <th class="px-2 py-1">Dosen</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($listKelasMahasiswa as $index => $item)
          <tr class="odd:bg-slate-300 even:bg-slate-200">
            <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
            <td class="px-2 py-1 text-center">{{ $item->matkul_nama }}</td>
            <td class="px-2 py-1 text-center">{{ $item->kel_jadwal }}</td>
            <td class="px-2 py-1 text-center">{{ $item->per_tahun_awal . '/' . $item->per_tahun_akhir }}</td>
            <td class="px-2 py-1 text-center">{{ $item->dsn_nama }}</td>
            <td class="text-center">
              <button class="px-2 py-1 hover:text-red-600 active:text-red-500">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-xl text-center font-semibold py-4" colspan="5">Tidak ada kelas...</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
