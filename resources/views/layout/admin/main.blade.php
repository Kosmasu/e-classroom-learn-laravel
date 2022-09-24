@extends('layout.skeleton')

@section('body')
  <div class="flex flex-row">
    <div class="flex-shrink-0">
      @include('layout.admin.sidebar')
    </div>
    <main class="w-full">
      @yield('content')
    </main>
  </div>
@endsection
