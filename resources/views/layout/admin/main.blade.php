@extends('layout.skeleton')

@section('body')
  @php
    $urls = explode('/', URL::current());
    $urls = array_splice($urls, 3);
  @endphp
  <div class="flex flex-row">
    <div class="flex-shrink-0">
      @include('layout.admin.sidebar')
    </div>
    <main class="w-full p-8">
      <div>
        <ul class="flex flex-row space-x-2 text-lg text-slate-600">
          @for ($i = 0; $i < count($urls); $i++)
            @php
              $preUrl = ''
            @endphp
            @for ($j = 0; $j < $i; $j++)
              @php
                $preUrl = $preUrl . $urls[$i] . '/'
              @endphp
            @endfor
            <li class="hover:underline capitalize {{ $i == count($urls) - 1 ? 'text-slate-700 font-semibold' : '' }} "><a href="{{ url($preUrl . $urls[$i] . '/') }}">{{$urls[$i]}}</a></li>
            {!! $i != count($urls) - 1 ? '<span>/</span>' : '' !!}
          @endfor
        </ul>
      </div>
      @yield('content')
    </main>
  </div>
@endsection
