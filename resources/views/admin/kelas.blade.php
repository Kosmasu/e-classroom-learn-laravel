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
          @foreach (Session::get("listMataKuliah") ?? [] as $item)
            <option value="{{ $item["kode"] }}">{{ $item["nama"] }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex flex-col">
        <label class="w-full px-1" for="jadwal">Jadwal Kelas</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="datetime-local" name="jadwal" id="jadwal" placeholder="Jadwal Kelas">
      </div>
      <div>
        <label class="w-full px-1" for="periode">Periode</label>
        <select class="w-full mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="periode" id="periode">
          <option selected disabled>Jurusan</option>
          @foreach (Session::get("listPeriode") ?? [] as $item)
            <option value="{{ $item["id"] }}">{{ $item["tahun_awal"] . '/' . $item["tahun_akhir"] }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="w-full px-1" for="dosen_pengajar">Dosen Pengajar</label>
        <select class="w-full mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="dosen_pengajar" id="dosen_pengajar">
          <option selected disabled>Jurusan</option>
          @foreach (Session::get("listDosen") ?? [] as $item)
            <option value="{{ $item["username"] }}">{{ $item["nama_lengkap"] }}</option>
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
          $listMataKuliah = Session::get('listMataKuliah');
          $listPeriode = Session::get('listPeriode');
          $listDosen = Session::get('listDosen');
        @endphp
        @forelse (Session::get("listKelas") ?? [] as $item)
          @php
            $ctr++;
            $mataKuliah = [];
            foreach ($listMataKuliah as $item2) { if ($item2['kode'] == $item['mata_kuliah']) $mataKuliah = $item2['nama']; }

            $periode = [];
            foreach ($listPeriode as $item2) { if ($item2['id'] == $item['periode']) $periode = $item2["tahun_awal"] . '/' . $item2["tahun_akhir"]; }

            $dosen = [];
            foreach ($listDosen as $item2) { if ($item2['username'] == $item['dosen']) $dosen = $item2["nama_lengkap"]; }
          @endphp
          <tr class="odd:bg-slate-300 even:bg-slate-200">
            <td class="px-2 py-1 text-center">{{ $ctr }}</td>
            <td class="px-2 py-1 text-center">{{ $mataKuliah }}</td>
            <td class="px-2 py-1 text-center">{{ $item["jadwal"] }}</td>
            <td class="px-2 py-1 text-center">{{ $periode }}</td>
            <td class="px-2 py-1 text-center">{{ $dosen }}</td>
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
