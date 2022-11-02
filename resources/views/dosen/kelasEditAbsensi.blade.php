@extends('layout.dosen.main')

@section('content')
<div class="container mx-auto">
  <div class="mt-8">
    <h1 class="text-2xl font-semibold text-center">Edit Absensi</h1>
  </div>
  <div>
    <div class="text-lg font-bold">
      <h1>Edit Absensi</h1>
    </div>
    <form action="{{ route('dosen.kelas.doEditAbsensi', ['id' => $id]) }}" method="POST">
      @csrf
      <input type="hidden" name="id" value="{{ $id }}">
      <input type="hidden" name="absensi_id" value="{{ $absensi_id }}">
      <div class="space-y-1">
        <div class="flex flex-col">
          <label class="w-full px-1" for="minggu_ke">Minggu Ke</label>
          <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="number" name="minggu_ke" id="minggu_ke" placeholder="Minggu Ke" value="{{ $absensi->abs_minggu_ke }}">
        </div>
        <div class="flex flex-col">
          <label class="w-full px-1" for="materi">Materi</label>
          <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="materi" id="materi" placeholder="Materi" value="{{ $absensi->abs_materi }}">
        </div>
        <div class="flex flex-col">
          <label class="w-full px-1" for="minggu_ke">Deskripsi</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi" value="{{ $absensi->abs_deskripsi }}">
        </div>
        <div class="space-y-1">
          <div class="flex justify-end space-x-2">
            <div onclick="checkAll()" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Check All</div>
            <div onclick="uncheckAll()" class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer">Uncheck All</div>
          </div>

          <script>
            function checkAll() {
              let listCheckbox = document.getElementsByClassName('checkbox-is-hadir')
              for (let i = 0; i < listCheckbox.length; i++) {
                const element = listCheckbox[i];
                element.checked = true;
              }
              console.log('listCheckbox:',listCheckbox);
            }
            function uncheckAll() {
              let listCheckbox = document.getElementsByClassName('checkbox-is-hadir')
              for (let i = 0; i < listCheckbox.length; i++) {
                const element = listCheckbox[i];
                element.checked = false;
              }
            }
          </script>

          <div class="w-full rounded lg:rounded-lg shadow lg:shadow-lg overflow-hidden border border-gray-900">
            <table class="table-auto min-w-full px-2 py-1">
              <thead>
                <tr class="bg-navy-primary text-gray-200">
                  <th class="px-2 py-1">#</th>
                  <th class="px-2 py-1">NRP</th>
                  <th class="px-2 py-1">Nama</th>
                  <th class="px-2 py-1">Hadir</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($listMahasiswa as $key => $mahasiswa)
                  <tr class="odd:bg-slate-300 even:bg-slate-200">
                    <td class="px-2 py-1 text-center">{{ $key + 1 }}</td>
                    <td class="px-2 py-1 text-center">{{ $mahasiswa->mhs_nrp }}</td>
                    <td class="px-2 py-1">{{ $mahasiswa->mhs_nama }}</td>
                    <td class="px-2 py-1 text-center">
                      <input class="scale-150 checkbox-is-hadir" type="checkbox" name="{{ "listMahasiswa[$key][isHadir]" }}" value="true" {{$mahasiswa->abs_mhs_is_hadir == 1 ? "checked" : ""}}>
                      <input type="hidden" name="{{ "listMahasiswa[$key][nrp]" }}" value="{{ $mahasiswa->mhs_nrp }}">
                      <input type="hidden" name="{{ "listMahasiswa[$key][abs_mhs_id]" }}" value="{{ $mahasiswa->abs_mhs_id }}">
                    </td>
                  </tr>
                  {{-- <tr>
                    <td colspan="4">@dump($mahasiswa)</td>
                  </tr> --}}
                @empty
                  <tr class="odd:bg-slate-300 even:bg-slate-200">
                    <td colspan="4"><h1>Kosong!</h1></td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
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
    <div class="space-y-1 mt-1">
      @foreach ($errors->all() as $error)
        <div class="p-2 bg-red-600 rounded">
          {{ $error }}
        </div>
      @endforeach
    </div>
    @endif
  </div>
</div>
@endsection
