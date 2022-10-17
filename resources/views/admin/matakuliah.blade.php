@extends('layout.admin.main')

@section('content')
<div>
  <h1 class="text-center text-2xl font-semibold">
    Master Mata Kuliah
  </h1>
</div>
<div class="w-1/3 flex-shrink-0">
  <form action="{{ route('admin.doCreateMataKuliah') }}" method="POST">
    @csrf
    <div class="space-y-1">
      <div class="flex flex-col">
        <label class="w-full px-1" for="nama_mata_kuliah">Nama Mata Kuliah</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="nama_mata_kuliah" id="nama_mata_kuliah" placeholder="Nama Mata Kuliah">
      </div>
      <div class="flex flex-col">
        <label class="w-full px-1" for="minimal_semester">Minimal Semester</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="minimal_semester" id="minimal_semester" placeholder="Minimal Semester">
      </div>
      <div>
        <label class="w-full px-1" for="jurusan">Jurusan</label>
        <select class="w-full mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="jurusan" id="jurusan">
          <option selected disabled>Jurusan</option>
          @foreach (Session::get("listJurusan") ?? [] as $jurusan)
            <option value="{{ $jurusan["id"] }}">{{ $jurusan["nama"] }}</option>
          @endforeach
        </select>
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
</div>
<div class="mt-4 flex-grow">
  <div class="w-full rounded lg:rounded-lg shadow lg:shadow-lg overflow-hidden border border-gray-900 mt-8">
    <table class="table-auto min-w-full px-2 py-1">
      <thead>
        <tr class="bg-navy-primary text-gray-200">
          <th class="px-2 py-1">#</th>
          <th class="px-2 py-1">Kode</th>
          <th class="px-2 py-1">Nama Mata Kuliah</th>
          <th class="px-2 py-1">Minimal Semester</th>
          <th class="px-2 py-1">Jurusan</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @php
          $ctr = 0;
          $listJurusan = Session::get('listJurusan') ?? []
        @endphp
        @forelse (Session::get("listMataKuliah") ?? [] as $mataKuliah)
          @php
            $ctr++;
            $jurusan = [];
            foreach ($listJurusan as $item) {
              if ($item['id'] == $mataKuliah['jurusan_id']) $jurusan = $item;
            }
          @endphp
          <tr class="odd:bg-slate-300 even:bg-slate-200">
            <td class="px-2 py-1 text-center">{{ $ctr }}</td>
            <td class="px-2 py-1 text-center">{{ $mataKuliah["kode"] }}</td>
            <td class="px-2 py-1">{{ $mataKuliah["nama"] }}</td>
            <td class="px-2 py-1 text-center">{{ $mataKuliah["minimal_semester"] }}</td>
            <td class="px-2 py-1">{{ $jurusan["nama"] }}</td>
            <td class="text-center">
              <button class="px-2 py-1 hover:text-red-600 active:text-red-500">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-xl text-center font-semibold py-4" colspan="5">Tidak ada mata kuliah...</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
