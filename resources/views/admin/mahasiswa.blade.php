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
      <tr class="odd:bg-slate-300 even:bg-slate-200">
        <td class="px-2 py-1 text-center">1.</td>
        <td class="px-2 py-1">220116925</td>
        <td class="px-2 py-1">Kenny</td>
        <td class="text-center">
          <button class="px-2 py-1 hover:text-red-600 active:text-red-500">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      </tr>
      <tr class="odd:bg-slate-300 even:bg-slate-200">
        <td class="px-2 py-1 text-center">2.</td>
        <td class="px-2 py-1">220116896</td>
        <td class="px-2 py-1">Victor Shielo</td>
        <td class="text-center">
          <button class="px-2 py-1 hover:text-red-600 active:text-red-500">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      </tr>
      <tr class="odd:bg-slate-300 even:bg-slate-200">
        <td class="px-2 py-1 text-center">3.</td>
        <td class="px-2 py-1">220116882</td>
        <td class="px-2 py-1">Lele</td>
        <td class="text-center">
          <button class="px-2 py-1 hover:text-red-600 active:text-red-500">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>

</div>
@endsection
