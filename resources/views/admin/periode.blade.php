@extends('layout.admin.main')

@section('content')
<div>
  <h1 class="text-center text-2xl font-semibold">
    Master Periode
  </h1>
</div>
<div class="w-1/3 flex-shrink-0">
  <form action="{{ route('admin.doCreatePeriode') }}" method="POST">
    @csrf
    <div class="space-y-1">
      <div class="flex flex-col">
        <label class="w-full px-1" for="tahun_awal">Tahun Awal Periode</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="number" name="tahun_awal" id="tahun_awal" placeholder="Tahun Awal Periode">
      </div>
      <div class="flex flex-col">
        <label class="w-full px-1" for="tahun_akhir">Tahun Akhir Periode</label>
        <input class="w-full  mt-1 rounded px-1 py-1 bg-gray-50 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="number" name="tahun_akhir" id="tahun_akhir" placeholder="Tahun Akhir Periode">
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
          <th class="px-2 py-1">Tahun Awal</th>
          <th class="px-2 py-1">Tahun Akhir</th>
          <th class="px-2 py-1">Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($listPeriode as $index=>$periode)
          <tr class="odd:bg-slate-300 even:bg-slate-200">
            <td class="px-2 py-1 text-center">{{ $index+1 }}</td>
            <td class="px-2 py-1 text-center">{{ $periode->per_tahun_awal }}</td>
            <td class="px-2 py-1 text-center">{{ $periode->per_tahun_akhir }}</td>
            <td class="px-2 py-1 text-center">
              <form action="{{ route('admin.doSetPeriode') }}" method="GET" onclick="gantiPeriode(event)">
                <input class="scale-150" type="checkbox" name="status" {{ $periode->per_status ? 'checked' : '' }} value="true">
                <input type="hidden" name="id" value="{{ $periode->per_id }}">
              </form>
            </td>
            <td class="text-center">
              <button class="px-2 py-1 hover:text-red-600 active:text-red-500">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-xl text-center font-semibold py-4" colspan="5">Tidak ada periode...</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<script>
  function gantiPeriode(event) {
    event.currentTarget.submit();
  }
</script>

@endsection
