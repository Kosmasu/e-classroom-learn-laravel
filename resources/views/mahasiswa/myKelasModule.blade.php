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
  <div class="mt-8">
    <h1 class="text-2xl font-semibold">Module</h1>
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
  <div class="w-full rounded lg:rounded-lg shadow lg:shadow-lg overflow-hidden border border-gray-900">
    <table class="table-auto min-w-full px-2 py-1">
      <thead>
        <tr class="bg-navy-primary text-gray-200">
          <th class="px-2 py-1">#</th>
          <th class="px-2 py-1">Nama</th>
          <th class="px-2 py-1">Jenis</th>
          <th class="px-2 py-1">Keterangan</th>
          <th class="px-2 py-1">Deadline</th>
          <th class="px-2 py-1">Status</th>
          <th class="px-2 py-1">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($listModule as $key => $item)
          <tr class="odd:bg-slate-300 even:bg-slate-200">
            <td class="px-2 py-1 text-center">{{ $key + 1 }}</td>
            <td class="px-2 py-1">{{ $item->mod_nama }}</td>
            <td class="px-2 py-1">{{ $item->mod_jenis }}</td>
            <td class="px-2 py-1">{{ $item->mod_keterangan }}</td>
            <td class="px-2 py-1">{{ $item->mod_deadline }}</td>
            <td class="px-2 py-1">{{ $item->mod_status }}</td>
            <td class="px-2 py-1 text-center">
              @if ($item->mod_status == "Aktif")
                <form action="{{ route('mahasiswa.myKelas.kumpulModule', ["id" => $id, "mod_id" => $item->mod_id ])}}" method="GET">
                  <input type="hidden" name="mod_id" value="{{ $item->mod_id }}">
                  <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Kumpul">
                </form>
              @else
                Telat
              @endif
            </td>
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
@endsection
