@extends('layout.dosen.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">Module Kelas</h1>
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
      <h1>Create Module</h1>
    </div>
    <form action="{{ route('dosen.kelas.doCreateModule', ['id' => $id]) }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $id }}">
      <div class="space-y-1">
        <div class="flex flex-col">
          <label class="w-full px-1" for="mod_nama">Nama</label>
          <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="mod_nama" id="mod_nama" placeholder="Nama">
        </div>
        <div class="flex flex-col">
          <label class="w-full px-1" for="mod_jenis">Jenis</label>
          <div class="w-full space-x-1 flex">
            <select class="w-1/2 mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900 min-w-full" name="mod_jenis" id="mod_jenis">
              <option selected disabled>Jenis</option>
              <option value="Quiz">Quiz</option>
              <option value="Assignment">Assignment</option>
            </select>
          </div>
        </div>
        <div class="flex flex-col">
          <label class="w-full px-1" for="mod_keterangan">Keterangan</label>
          <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="mod_keterangan" id="mod_keterangan" placeholder="Keterangan">
        </div>
        <div class="flex flex-col">
          <label class="w-full px-1" for="mod_deadline">Deadline</label>
          <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="datetime-local" name="mod_deadline" id="mod_deadline" placeholder="Deadline">
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
              <td class="px-2 py-1 text-center flex space-x-1 justify-center">
                <form action="{{ route('dosen.kelas.doSelesaikanModule', ["id" => $id ])}}" method="POST">
                  @csrf
                  <input type="hidden" name="mod_id" value="{{ $item->mod_id }}">
                  <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Selesaikan">
                </form>
                <form action="{{ route('dosen.kelas.detailModule', ["id" => $id, "mod_id" => $item->mod_id ])}}" method="GET">
                  <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Detail">
                </form>
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
</div>
@endsection
