@extends('layout.skeleton')

@section('body')
  <div class="w-screen h-screen bg-no-repeat bg-cover relative"
    style="background-image: url('{{ asset('images/banner.jpg') }}');">
    <div class="h-screen flex justify-center items-center">
      <span class="w-full h-full bg-black opacity-50 absolute z-0"></span>
      <div class="p-8 rounded lg:rounded-lg shadow lg:shadow-lg w-80 bg-navy-primary text-gray-200 z-10">
        <div>
          <h1 class="text-3xl font-bold text-center">Login</h1>
        </div>
        <form action="{{ route('auth.doLogin') }}" method="POST">
          @csrf
          <div class="flex flex-col space-y-1">
            <label class="w-full px-1" for="username">Username</label>
            <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="text" name="username" id="username" placeholder="Username">
            <label class="w-full px-1" for="password">Password</label>
            <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200 text-gray-800 border border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900" type="password" name="password" id="password" placeholder="Password">
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
            </div>
          <input class="w-full px-2 py-1 mt-2 bg-gray-200 rounded text-gray-900 font-medium hover:bg-gray-300 active:bg-gray-400" type="submit" value="Login" name="submit">
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
        <div class="mt-1">
          <p class="text-xs">
            Belum punya akun? register
            <a class="text-yellow-primary hover:underline" href="{{ route('auth.register.mahasiswa') }}">disini</a>
          </p>
        </div>
      </div>
    </div>
  </div>
@endsection
