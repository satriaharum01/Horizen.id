<!DOCTYPE html>
<html>
<head>
  <title>{{env('APP_NAME')}} | {{$title}}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">

  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" >
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}">

  <!-- plugin css -->
  <link rel="stylesheet" href="{{ asset('assets/dist/sweetalert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/@mdi/font/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}">
  <!-- end plugin css -->

  @include('template.css')
</head>
<body data-base-url="{{url('/')}}">

  <div class="container-scroller" id="app">
    @include('template.header')
    <div class="container-fluid page-body-wrapper">
      @include('template.sidebar')
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        @include('template.footer')
      </div>
    </div>
  </div>

    <!-- Password Modal-->
    <div class="modal fade" id="gantiPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row">
                    <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Ganti Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="compose-form" action="{{ route('set.password') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4">Password Baru</label>
                        <div class="col-sm-8">
                          <input type="password" name="password" class="form-control" required>
                          <input type="text" name="current_url" class="form-control" hidden value="{{url()->full()}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white">Simpan</button>
                </div>
                
                </form>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row">
                    <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Akan Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" Untuk Mengakhiri Sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    <a class="btn btn-primary text-white" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
    </div>
  <!-- base js -->
  <script src="{{asset('js/app.js')}}"></script>
  <script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
  <!-- end base js -->

  <!-- plugin js -->
  @yield('plugin-scripts')
  <!-- end plugin js -->

  <!-- common js -->
  <script src="{{asset('assets/js/off-canvas.js')}}"></script>
  <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('assets/js/misc.js')}}"></script>
  <script src="{{asset('assets/js/settings.js')}}"></script>
  <script src="{{asset('assets/js/todolist.js')}}"></script>
  <!-- end common js -->
  @include('template.js')
  @yield('custom_script')
</body>
</html>