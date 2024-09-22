<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    @if(Auth::user()->level == 'Admin')
    <li class="nav-item {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard')}}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/data/*')) ? 'active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#data"  aria-controls="data">
        <i class="menu-icon mdi mdi-archive"></i>
        <span class="menu-title">Data</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ (request()->is('admin/data/*')) ? 'show' : '' }}" id="data">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ (request()->is('admin/data/kategori')) ? 'active' : '' }}">
            <a class="nav-link" href="{{route('admin.data.kategori')}}">Kategori</a>
          </li>
          <li class="nav-item {{ (request()->is('admin/data/barang')) ? 'active' : '' }}">
            <a class="nav-link" href="{{route('admin.data.barang')}}">Barang</a>
          </li>
          <li class="nav-item {{ (request()->is('admin/data/gallery')) ? 'active' : '' }}">
            <a class="nav-link" href="{{route('admin.data.gallery')}}#">Gallery</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ (request()->is('admin/supplier')) ? 'active' : '' }} {{ (request()->is('admin/supplier/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.supplier')}}">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Supplier</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/stok')) ? 'active' : '' }} {{ (request()->is('admin/stok/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.stok')}}">
        <i class="menu-icon mdi mdi-package-variant-closed"></i>
        <span class="menu-title">Stok Barang</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/penjualan')) ? 'active' : '' }} {{ (request()->is('admin/penjualan/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.penjualan')}}">
        <i class="menu-icon mdi mdi-cash-register"></i>
        <span class="menu-title">Penjualan</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/pengguna')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.pengguna')}}">
        <i class="menu-icon mdi mdi-account-multiple"></i>
        <span class="menu-title">Kelola Akun</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/logs')) ? 'active' : '' }} {{ (request()->is('admin/logs/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.logs')}}">
        <i class="menu-icon mdi mdi-history"></i>
        <span class="menu-title">Log Aktivitas</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/metode')) ? 'active' : '' }} {{ (request()->is('admin/metode/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.metode')}}">
        <i class="menu-icon mdi mdi-chart-areaspline"></i>
        <span class="menu-title">Metode ABC</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/mutasi')) ? 'active' : '' }} {{ (request()->is('admin/mutasi/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('admin.mutasi')}}">
        <i class="menu-icon mdi mdi-chart-bar"></i>
        <span class="menu-title">Mutasi Barang</span>
      </a>
    </li>
    @else
    <li class="nav-item {{ (request()->is('pegawai/dashboard')) ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('pegawai.dashboard')}}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('pegawai/supplier')) ? 'active' : '' }} {{ (request()->is('pegawai/supplier/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('pegawai.supplier')}}">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Supplier</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('pegawai/stok')) ? 'active' : '' }} {{ (request()->is('pegawai/stok/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('pegawai.stok')}}">
        <i class="menu-icon mdi mdi-package-variant-closed"></i>
        <span class="menu-title">Stok Barang</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('pegawai/penjualan')) ? 'active' : '' }} {{ (request()->is('pegawai/penjualan/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('pegawai.penjualan')}}">
        <i class="menu-icon mdi mdi-cash-register"></i>
        <span class="menu-title">Penjualan</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('pegawai/pengguna')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('pegawai.pengguna')}}">
        <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Profil Pengguna</span>
      </a>
    </li>
    <li class="nav-item {{ (request()->is('pegawai/mutasi')) ? 'active' : '' }} {{ (request()->is('pegawai/mutasi/*')) ? 'active' : '' }}">
      <a class="nav-link" href="{{route('pegawai.mutasi')}}">
        <i class="menu-icon mdi mdi-chart-bar"></i>
        <span class="menu-title">Mutasi Barang</span>
      </a>
    </li>
    @endif
  </ul>
</nav>