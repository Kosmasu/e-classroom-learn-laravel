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
          @foreach ($listJurusan as $jurusan)
            <option value="{{ $jurusan->jur_id }}">{{ $jurusan->jur_nama }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="w-full px-1" for="sks">SKS</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="number" name="sks" id="sks" placeholder="SKS">
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
  <div class="space-y-1 mt-1 text-gray-200">
    @foreach ($errors->all() as $error)
      <div class="p-2 bg-red-600 rounded">
        {{ $error }}
      </div>
    @endforeach
  </div>
  @endif
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
        @forelse ($listMataKuliah as $index => $mataKuliah)
          <tr class="odd:bg-slate-300 even:bg-slate-200">
            <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
            <td class="px-2 py-1 text-center">{{ $mataKuliah->matkul_id }}</td>
            <td class="px-2 py-1">{{ $mataKuliah->matkul_nama }}</td>
            <td class="px-2 py-1 text-center">{{ $mataKuliah->matkul_minimal_semester }}</td>
            <td class="px-2 py-1">{{ $mataKuliah->jur_nama }}</td>
            <td class="text-center">
              <form action="{{ route('admin.editMataKuliah', ['id' => $mataKuliah->matkul_id]) }}" method="GET">
                <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Edit">
                <input type="hidden" name="id" value="{{ $mataKuliah->matkul_id }}">
              </form>
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
