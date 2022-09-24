<nav class="w-56 h-screen bg-navy-primary text-gray-200 shadow lg:shadow-lg">
  <div class="p-4 flex flex-col">
    <div class="flex flex-wrap items-center pb-4">
      <img src="{{ asset('images/istts_warna-min.png') }}" alt="stts" class="w-12 h-12">
      <h1 class="pl-2 font-semibold text-2xl">E-Classroom</h1>
    </div>
    <div>
      <a href="{{ route('admin.home') }}">
        <div class="hover:bg-navy-secondary hover:font-bold font-semibold text-lg rounded px-1 py-2 pl-2
        {{ (URL::current() == 'http://127.0.0.1:8000/admin') ? 'bg-navy-secondary font-bold' : '' }}
        "><i class="fa-solid fa-house pr-1"></i> Home</div>
      </a>
    </div>
    <hr>

    <div>
      <h1 class="text-lg font-semibold px-1 py-2 pl-2"><i class="fa-solid fa-book-open pr-1"></i> Master</h1>
      <div class="pl-2">
        <a href="{{ route('admin.mahasiswa') }}">
          <div class="hover:bg-navy-secondary hover:font-semibold rounded px-1 py-2 pl-2
          {{ (URL::current() == 'http://127.0.0.1:8000/admin/mahasiswa') ? 'bg-navy-secondary font-semibold' : '' }}
          ">Mahasiswa</div>
        </a>
        <a href="{{ route('admin.dosen') }}">
          <div class="hover:bg-navy-secondary hover:font-semibold rounded px-1 py-2 pl-2
          {{ (URL::current() == 'http://127.0.0.1:8000/admin/dosen') ? 'bg-navy-secondary font-semibold' : '' }}
          ">Dosen</div>
        </a>
      </div>
    </div>
    <hr>
  </div>
</nav>
