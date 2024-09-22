<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a class="navbar-brand brand-logo" href="{{ url('/') }}">
      <img src="{{ url('assets/img/sidebar-logo.png') }}" alt="logo" /> </a>
    <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
      <img src="{{ url('assets/img/mini-logo.png') }}" alt="logo" /> </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav navbar-nav-left header-links">
      <li class="nav-item d-none">
        <a href="#" class="nav-link">Schedule <span class="badge badge-primary ml-1">New</span>
        </a>
      </li>
      <li class="nav-item active d-none">
        <a href="#" class="nav-link">
          <i class="mdi mdi-elevation-rise"></i>Reports</a>
      </li>
      <li class="nav-item d-none">
        <a href="#" class="nav-link">
          <i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
      </li>
      <li class="nav-item dropdown d-none">
        <a class="nav-link dropdown-toggle px-0" id="quickDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> Quick Links </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown pt-3" aria-labelledby="quickDropdown">
          <a href="#" class="dropdown-item">Schedule <span class="badge badge-primary ml-1">New</span></a>
          <a href="#" class="dropdown-item"><i class="mdi mdi-elevation-rise"></i>Reports</a>
          <a href="#" class="dropdown-item"><i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
     @if(Auth::user()->level == 'Admin')
    <li id="alertsDropdown" class="nav-item dropdown" >
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          <span id="badge-counter" class="badge-counter"></span>
        </a>
        <div id="alertsDropdownList" class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown"  style="min-width: 350px;">
          
        </div>
      </li>
      @endif
      <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <span class="profile-text d-none d-md-inline-flex">{{Auth::user()->name}}</span>
          <img class="img-xs rounded-circle" src="{{ url('assets/img/avatar.png') }}" alt="Profile image"> </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <a class="dropdown-item p-0">
            <div class="d-flex border-bottom w-100 justify-content-center">
              <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right" data-toggle="modal" data-target="#gantiPassword">
                <i class="fa fa-key mr-0 text-gray"></i>
              </div>
              <div class="py-3 px-4 d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#logoutModal">
                <i class="fa fa-sign-out mr-0 text-gray"></i>
              </div>
            </div>
          </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu icon-menu"></span>
    </button>
  </div>
</nav>