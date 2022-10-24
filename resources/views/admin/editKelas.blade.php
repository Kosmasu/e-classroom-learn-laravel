@extends('layout.admin.main')

@section('content')
<div>
  <h1 class="text-center text-2xl font-semibold">
    Edit Kelas
  </h1>
</div>
<div class="w-1/3 flex-shrink-0">
  <form action="{{ route('admin.doEditKelas') }}" method="POST">
    @csrf
    <div class="space-y-1">
      <div class="flex flex-col">
        <label class="w-full px-1" for="nama_mata_kuliah">Id Kelas: {{ $kelas["id"] }}</label>
        <input type="hidden" name="id" value="{{ $kelas ['id'] }}">
      </div>
      <div>
        <label class="w-full px-1" for="mata_kuliah">Mata Kuliah</label>
        <select class="w-full mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="mata_kuliah" id="mata_kuliah">
          <option selected disabled>Mata Kuliah</option>
          @foreach (Session::get("listMataKuliah") ?? [] as $item)
            <option {{ $item["kode"] == $kelas["mata_kuliah"] ? "selected" : "" }} value="{{ $item["kode"] }}">{{ $item["nama"] }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex flex-col">
        <label class="w-full px-1" for="jadwal">Jadwal Kelas</label>
        <div class="w-full space-x-1 flex">
          <select class="w-1/2 mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="jadwal_hari" id="jadwal_hari">
            <option disabled>Hari</option>
            <option {{ $kelas["jadwal_hari"] == "Senin" ? "selected" : "" }} value="Senin">Senin</option>
            <option {{ $kelas["jadwal_hari"] == "Selasa" ? "selected" : "" }} value="Selasa">Selasa</option>
            <option {{ $kelas["jadwal_hari"] == "Rabu" ? "selected" : "" }} value="Rabu">Rabu</option>
            <option {{ $kelas["jadwal_hari"] == "Kamis" ? "selected" : "" }} value="Kamis">Kamis</option>
            <option {{ $kelas["jadwal_hari"] == "Jumat" ? "selected" : "" }} value="Jumat">Jumat</option>
          </select>
          <input class="w-1/2  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="time" name="jadwal_jam" id="jadwal_jam" placeholder="Jadwal Kelas" value="{{ $kelas["jadwal_jam"] }}">
        </div>
      </div>
      <div>
        <label class="w-full px-1" for="periode">Periode</label>
        <select class="w-full mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" name="periode" id="periode">
          <option selected disabled>Periode</option>
          @foreach (Session::get("listPeriode") ?? [] as $item)
            <option {{ $item["id"] == $kelas["periode"] ? "selected" : "" }} value="{{ $item["id"] }}">{{ $item["tahun_awal"] . '/' . $item["tahun_akhir"] }}</option>
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
        <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="Edit">
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

@endsection
