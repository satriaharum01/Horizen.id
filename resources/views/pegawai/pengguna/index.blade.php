@extends('template.master')
@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title">{{$title}}</h3>
        <form action="{{$link}}" method="POST" id="compose-form" class="form-horizontal" enctype="multipart/form-data">
              @csrf
              <div class="modal-body"> 
                  <div class="form-group row">
                      <label class="col-sm-4">Nama Pengguna</label>
                      <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" placeholder="Nama Pengguna" value="{{$load->name}}">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Email</label>
                      <div class="col-sm-8">
                        <input type="email" name="email" class="form-control" placeholder="Email Pengguna" value="{{$load->email}}">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Password</label>
                      <div class="col-sm-8">
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti..">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Hak Akses</label>
                      <div class="col-sm-8">
                        <select name="level" class="form-control p-0" readonly>
                          <option value="{{$load->level}}">{{$load->level}}</option>
                        </select>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>

@endsection