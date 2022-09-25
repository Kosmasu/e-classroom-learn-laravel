@extends('layout.admin.main')

@section('content')
  <div class="w-full rounded lg:rounded-lg shadow lg:shadow-lg overflow-hidden border border-gray-900">
    <table class="table-auto min-w-full px-2 py-1">
      <thead>
        <tr class="bg-navy-primary text-gray-200">
          <th class="px-2 py-1">No.</th>
          <th class="px-2 py-1">Username</th>
          <th class="px-2 py-1">Nama</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr class="odd:bg-slate-300 even:bg-slate-200">
          <td class="px-2 py-1 text-center">1.</td>
          <td class="px-2 py-1">mimi</td>
          <td class="px-2 py-1">Mikhael Setiawan</td>
          <td class="text-center">
            <button class="px-2 py-1 hover:text-red-600 active:text-red-500">
              <i class="fa-solid fa-trash"></i>
            </button>
          </td>
        </tr>
        <tr class="odd:bg-slate-300 even:bg-slate-200">
          <td class="px-2 py-1 text-center">2.</td>
          <td class="px-2 py-1">usernamelagi</td>
          <td class="px-2 py-1">Dosen 2</td>
          <td class="text-center">
            <button class="px-2 py-1 hover:text-red-600 active:text-red-500">
              <i class="fa-solid fa-trash"></i>
            </button>
          </td>
        </tr>
        <tr class="odd:bg-slate-300 even:bg-slate-200">
          <td class="px-2 py-1 text-center">3.</td>
          <td class="px-2 py-1">usernameeeeeeee</td>
          <td class="px-2 py-1">Dosen 3</td>
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
