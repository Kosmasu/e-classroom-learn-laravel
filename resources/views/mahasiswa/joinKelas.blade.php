@extends('layout.mahasiswa.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">List Kelas</h1>
  </div>
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
          <th class="px-2 py-1">Mata Kuliah</th>
          <th class="px-2 py-1">Jadwal</th>
          <th class="px-2 py-1">Periode</th>
          <th class="px-2 py-1">Dosen</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @php
          $ctr = 0;
        @endphp
        @forelse ($listKelas as $item)
          @php
            $ctr++;
          @endphp
          <tr class="odd:bg-slate-300 even:bg-slate-200">
            <td class="px-2 py-1 text-center">{{ $ctr }}</td>
            <td class="px-2 py-1 text-center">{{ $item->matkul_nama }}</td>
            <td class="px-2 py-1 text-center">{{ $item->kel_jadwal }}</td>
            <td class="px-2 py-1 text-center">{{ $item->per_tahun_awal . '/' . $item->per_tahun_akhir }}</td>
            <td class="px-2 py-1 text-center">{{ $item->dsn_nama }}</td>
            <td class="text-center">
              <form action="{{ route('mahasiswa.doJoinKelas') }}" method="POST">
                @csrf
                {{-- @if ($item->joined)
                  <input class="px-2 py-1 rounded text-gray-100 font-medium border border-gray-900 bg-green-600 hover:cursor-not-allowed" type="submit" name="submit" value="Joined" disabled>
                @else --}}
                  <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Join">
                {{-- @endif --}}
                <input type="hidden" name="id" value="{{ $item->kel_id }}">
              </form>
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
