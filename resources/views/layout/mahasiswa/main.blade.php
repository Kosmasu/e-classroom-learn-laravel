@extends('layout.skeleton')

@section('body')
  @include('layout.mahasiswa.navbar')
  <main class="pt-4">
    @yield('content')
  </main>
@endsection
