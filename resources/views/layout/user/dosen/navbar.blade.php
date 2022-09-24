<nav class="w-screen bg-navy-primary text-gray-200 h-16">
  <div class="w-full flex container h-full">
    <a href="{{ route('dosen.home') }}">
      <div class="flex items-center h-full">
        <img class="w-12 h-12" src="{{ asset('images/istts_warna-min.png') }}" alt="">
        <h1 class="pl-2 font-semibold text-2xl">E-Classroom</h1>
      </div>
    </a>
    <a href="{{ route('dosen.profile') }}" class="ml-auto">
      <div class="flex items-center h-full">
        <div
          class="relative pl-4 pr-1 py-1 rounded-full bg-gray-200  flex justify-center items-center hover:cursor-pointer hover:bg-gray-300">
          <span class="font-semibold text-navy-primary uppercase">Dosen</span>
          <div
            class="w-10 h-10 ml-2 p-2 rounded-full bg-navy-primary flex justify-center items-center text-navy-primary">
            <i class="text-gray-200 fa-solid fa-user text-xl"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
</nav>
