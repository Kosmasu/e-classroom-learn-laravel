@extends('layout.skeleton')

@section('body')
  <div class="flex flex-row">
    <div class="flex-shrink-0">
      @include('layout.admin.sidebar')
    </div>
    <main class="w-full p-8">
      <x-admin.breadcrumb></x-breadcrumb>
      @yield('content')
    </main>
  </div>
@endsection
