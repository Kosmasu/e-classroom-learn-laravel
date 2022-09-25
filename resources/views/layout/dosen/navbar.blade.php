<nav class="w-screen bg-navy-primary text-gray-200 h-16">
  <div class="w-full flex container h-full">
    <a href="{{ route('dosen.home') }}">
      <div class="flex items-center h-full">
        <img class="w-12 h-12" src="{{ asset('images/istts_warna-min.png') }}" alt="stts">
        <h1 class="pl-2 font-semibold text-2xl">E-Classroom</h1>
      </div>
    </a>
    <a href="{{ route('mahasiswa.profile') }}" class="ml-auto">
      <div class="dropdown inline-block relative flex items-center h-full">
        <div
          class="pl-4 pr-1 py-1 rounded-full bg-gray-200  flex justify-center items-center hover:cursor-pointer hover:bg-gray-300">
          <span class="font-semibold text-navy-primary uppercase">Kenny</span>
          <div
            class="w-10 h-10 ml-2 p-2 rounded-full bg-navy-primary flex justify-center items-center text-navy-primary">
            <i class="text-gray-200 fa-solid fa-user text-xl"></i>
          </div>
        </div>
        <div class="dropdown-content absolute w-32 right-0 bottom-0 translate-y-full shadow rounded bg-navy-primary border hidden">
          <div class="flex flex-col font-semibold">
            <a class="px-3 py-2 hover:bg-navy-secondary" href="{{ route('dosen.home') }}">Home</a>
            <a class="px-3 py-2 hover:bg-navy-secondary" href="{{ route('dosen.profile') }}">Profile</a>
            <a class="px-3 py-2 hover:bg-navy-secondary" href="{{ route('auth.login') }}">Logout</a>
          </div>
        </div>
      </div>
    </a>
  </div>
</nav>

<style>
.dropdown:hover .dropdown-content {
  display: block
}
</style>
