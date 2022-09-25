@extends('layout.skeleton')

@section('body')
  @include('layout.dosen.navbar')
  <main class="pt-4">
    @yield('content')
  </main>
@endsection
