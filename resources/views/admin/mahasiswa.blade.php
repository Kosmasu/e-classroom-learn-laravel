@extends('layout.admin.main')

@section('content')
<div>
  <h1 class="text-center text-2xl font-semibold">
    Master Mahasiswa
  </h1>
</div>

<div class="w-full rounded lg:rounded-lg shadow lg:shadow-lg overflow-hidden border border-gray-900 mt-8">
  <table class="table-auto min-w-full px-2 py-1">
    <thead>
      <tr class="bg-navy-primary text-gray-200">
        <th class="px-2 py-1">No.</th>
        <th class="px-2 py-1">NRP</th>
        <th class="px-2 py-1">Nama</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($listMahasiswa as $key=>$item)
      <tr class="odd:bg-slate-300 even:bg-slate-200">
        <td class="px-2 py-1 text-center">{{ $key + 1 }}</td>
        <td class="px-2 py-1">{{ $item->mhs_nrp }}</td>
        <td class="px-2 py-1">{{ $item->mhs_nama }}</td>
        <td class="text-center">
          <form action="{{ route('admin.doBan') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="mahasiswa">
            <input type="hidden" name="id" value="{{ $item->mhs_nrp }}">
            <input class="px-2 py-1 rounded text-gray-100 font-medium hover:bg-navy-primary active:bg-navy-secondary border border-gray-900 bg-navy-primary hover:cursor-pointer" type="submit" name="submit" value="{{ $item->mhs_status_ban == 1 ? "Unban" : "Ban" }}">
          </form>
        </td>
      </tr>
      @empty
      <tr class="odd:bg-slate-300 even:bg-slate-200">
        <td colspan="4" class="px-2 py-1 text-center">Kosong...</td>
      </tr>
      @endforelse
    </tbody>
  </table>

</div>
@endsection
