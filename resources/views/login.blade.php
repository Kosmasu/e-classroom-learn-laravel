@extends('layout.skeleton')

@section('body')
  <div class="h-screen flex justify-center items-center bg-slate-400">
    <div class="p-8 rounded lg:rounded-lg shadow lg:shadow-lg w-80 bg-navy-primary text-gray-200">
      <div>
        <h1 class="text-3xl font-bold text-center">Login</h1>
      </div>
      <div class="flex flex-col mt-4">
        <label class="w-full px-1 mt-2" for="username">Username</label>
        <input class="w-full mt-1 rounded px-1 py-1 bg-gray-200" type="text" name="username" id="username" placeholder="Username">
        <label class="w-full px-1 mt-2" for="password">Password</label>
        <input class="w-full mt-1 rounded px-2 py-1 bg-gray-200"  type="password" name="password" id="password" placeholder="Password">
        {{-- <div class="flex justify-end"> --}}
        <button class="w-full px-2 py-1 mt-4 bg-gray-200 rounded text-gray-900 font-medium hover:bg-gray-300 active:bg-gray-400 ">Submit</button>
        {{-- </div> --}}
      </div>
      <div class="mt-1">
        <p class="text-xs">
          Don't have an account? register
          <a class="text-yellow-primary hover:underline" href="{{ url('/register') }}">here</a>
        </p>
      </div>
    </div>
  </div>
@endsection
