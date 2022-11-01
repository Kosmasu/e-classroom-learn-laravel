<div>
  <ul class="flex flex-row space-x-2 text-lg text-slate-600">
    @for ($i = 0; $i < count($urls); $i++)
      @php
        $preUrl = '';
      @endphp
      {{-- concate url sebelumnya --}}
      @for ($j = 0; $j < $i; $j++)
        @php
          $preUrl = $preUrl . $urls[$j] . '/';
        @endphp
      @endfor
      <li class="hover:underline capitalize {{ $i == count($urls) - 1 ? 'text-slate-700 font-semibold' : '' }} "><a
          href="{{ url($preUrl . $urls[$i] . '/') }}">{{ $urls[$i] }}</a></li>
      {!! $i != count($urls) - 1 ? '<span>/</span>' : '' !!}
    @endfor
  </ul>
</div>
