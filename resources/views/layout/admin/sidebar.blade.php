<nav class="w-56 h-screen bg-navy-primary text-gray-200 shadow lg:shadow-lg">
  <div class="p-4 flex flex-col">
    <div class="flex flex-wrap items-center pb-4">
      <img src="{{ asset('images/istts_warna-min.png') }}" alt="stts" class="w-12 h-12">
      <h1 class="pl-2 font-medium text-2xl">E-Classroom</h1>
    </div>
    <div>
      <a href="{{ route('auth.logout') }}">
        <div class="hover:bg-red-600 hover:font-semibold font-medium text-lg rounded px-1 py-2 pl-2
        "><i class="fa-solid fa-right-from-bracket pr-1"></i> Logout</div>
      </a>
    </div>
    <div>
      <a href="{{ route('admin.home') }}">
        <div class="hover:bg-navy-secondary hover:font-semibold font-medium text-lg rounded px-1 py-2 pl-2
        {{ (URL::current() == 'http://127.0.0.1:8000/admin') ? 'bg-navy-secondary font-semibold' : '' }}
        "><i class="fa-solid fa-house pr-1"></i> Home</div>
      </a>
    </div>
    <hr>

    <div>
      <h1 class="text-lg font-medium px-1 py-2 pl-2"><i class="fa-solid fa-book-open pr-1"></i> Master</h1>
      <div class="pl-2">
        <a href="{{ route('admin.mahasiswa') }}">
          <div class="hover:bg-navy-secondary hover:font-medium rounded px-1 py-2 pl-2
          {{ (URL::current() == route('admin.mahasiswa')) ? 'bg-navy-secondary font-medium' : '' }}
          ">Mahasiswa</div>
        </a>
        <a href="{{ route('admin.dosen') }}">
          <div class="hover:bg-navy-secondary hover:font-medium rounded px-1 py-2 pl-2
          {{ (URL::current() == route('admin.dosen')) ? 'bg-navy-secondary font-medium' : '' }}
          ">Dosen</div>
        </a>
        <a href="{{ route('admin.matakuliah') }}">
          <div class="hover:bg-navy-secondary hover:font-medium rounded px-1 py-2 pl-2
          {{ (URL::current() == route('admin.matakuliah')) ? 'bg-navy-secondary font-medium' : '' }}
          ">Mata Kuliah</div>
        </a>
        <a href="{{ route('admin.periode') }}">
          <div class="hover:bg-navy-secondary hover:font-medium rounded px-1 py-2 pl-2
          {{ (URL::current() == route('admin.periode')) ? 'bg-navy-secondary font-medium' : '' }}
          ">Periode</div>
        </a>
        <a href="{{ route('admin.kelas') }}">
          <div class="hover:bg-navy-secondary hover:font-medium rounded px-1 py-2 pl-2
          {{ (URL::current() == route('admin.kelas')) ? 'bg-navy-secondary font-medium' : '' }}
          ">Kelas</div>
        </a>
      </div>
    </div>
    <hr>
  </div>
</nav>
