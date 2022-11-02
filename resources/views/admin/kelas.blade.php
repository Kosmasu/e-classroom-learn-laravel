@extends('layout.admin.main')

@section('content')
<div>
  <h1 class="text-center text-2xl font-semibold">
    Master Kelas
  </h1>
</div>
<div class="w-1/3 flex-shrink-0">
  <form action="{{ route('admin.doCreateKelas') }}" method="POST">
    @csrf
    <div class="space-y-1">
      <div>
        <label class="w-full px-1" for="mata_kuliah">Mata Kuliah</label>
        <select class="w-full mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="mata_kuliah" id="mata_kuliah">
          <option selected disabled>Mata Kuliah</option>
          @foreach ($listMataKuliah as $item)
            <option value="{{ $item->matkul_id }}">{{ $item->matkul_nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex flex-col">
        <label class="w-full px-1" for="jadwal">Jadwal Kelas</label>
        <div class="w-full space-x-1 flex">
          <select class="w-1/2 mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="jadwal_hari" id="jadwal_hari">
            <option selected disabled>Hari</option>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
          </select>
          <input class="w-1/2  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="time" name="jadwal_jam" id="jadwal_jam" placeholder="Jadwal Kelas">
        </div>
      </div>
      <div>
        <label class="w-full px-1" for="periode">Periode</label>
        <select class="w-full mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="periode" id="periode">
          <option selected disabled>Periode</option>
          @foreach ($listPeriode as $item)
            <option value="{{ $item->per_id }}">{{ $item->per_tahun_awal . '/' . $item->per_tahun_akhir }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="w-full px-1" for="dosen_pengajar">Dosen Pengajar</label>
        <select class="w-full mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="dosen_pengajar" id="dosen_pengajar">
          <option selected disabled>Dosen</option>
          @foreach ($listDosen as $item)
            <option value="{{ $item->dsn_username }}">{{ $item->dsn_nama }}</option>
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
  @if ($errors->any())
  <div class="space-y-1 mt-1 text-gray-100">
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
          <th class="px-2 py-1">Mata Kuliah</th>
          <th class="px-2 py-1">Jadwal</th>
          <th class="px-2 py-1">Periode</th>
          <th class="px-2 py-1">Dosen</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($listKelas as $index => $item)
          <tr class="odd:bg-slate-300 even:bg-slate-200">
            <td class="px-2 py-1 text-center">{{ $index + 1 }}</td>
            <td class="px-2 py-1 text-center">{{ $item->matkul_nama }}</td>
            <td class="px-2 py-1 text-center">{{ $item->kel_jadwal }}</td>
            <td class="px-2 py-1 text-center">{{ $item->per_tahun_awal . '/' . $item->per_tahun_akhir }}</td>
            <td class="px-2 py-1 text-center">{{ $item->dsn_nama }}</td>
            <td class="text-center flex">
              <form action="{{ route('admin.editKelas', ['id' => $item->kel_id]) }}" method="GET">
                <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Edit">
              </form>
              <form action="{{ route('admin.doDeleteKelas', ['id' => $item->kel_id]) }}" method="POST">
                @csrf
                <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Delete">
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
