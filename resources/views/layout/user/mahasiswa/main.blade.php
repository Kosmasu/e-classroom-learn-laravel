@extends('layout.skeleton')

@section('body')
  @include('layout.user.mahasiswa.navbar')
  <main class="pt-4">
    @yield('content')
  </main>
@endsection
