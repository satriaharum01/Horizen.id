@extends('template.master')
@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-add pull-right"><i class="mdi mdi-plus"></i> Tambah Data</button>
        <button class="btn btn-danger mx-2 btn-print pull-right"><i class="mdi mdi-printer"></i> Cetak</button>
        
        <div class="pull-right row mx-1">
          <label class="mx-2 pt-1">Periode :</label>
          <input type="month" class="form-control col-md-8" name="periode" id="periode">
        </div>
        <h3 class="card-title">{{$title}}</h3>
        <div class="table-responsive pt-5">
          <table class="display table table-bordered table-hover" id="data-width" width="100%">
            <thead class="text-center">
              <tr>
                <th width="7%">No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th width="15%">Pembeli</th>
                <th>Qty</th>
                <th width="15%">Jumlah</th>
                <th width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ============ MODAL DATA  =============== -->
<div class="modal fade" id="compose-print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="justify-content-center modal-header">
              <center><b>
              <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4></b></center>    
          </div>
          <form action="#" method="POST" id="compose-form-print" class="form-horizontal" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                  <div class="form-group row">
                      <label class="col-sm-4">Periode Awal</label>
                      <div class="col-sm-8">
                        <input type="month" name="start" class="form-control">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Periode Akhir</label>
                      <div class="col-sm-8">
                        <input type="month" name="end" class="form-control">
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Cetak</button>
              </div>
          </form>
      </div>
  </div>
</div>
<!--- END MODAL DATA --->
@endsection

@section('custom_script')

<script>
    $(function() {
        table = $('#data-width').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: '{{url("$page/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode',
                    className: 'text-center'
                },
                {
                    data: 'tanggal',
                    className: 'text-center'
                },
                {
                    data: 'user'
                },
                {
                    data: 'qty',
                    className: 'text-center'
                },
                {
                    data: 'jumlah',
                    className: 'text-center', render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                },
                {
                    data: 'id',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> Ubah</button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="data" href="<?= url($page.'/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> </a> \
					    <form id="delete-form-' + data + '-data" action="<?= url($page.'/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>';
                    }
                },
            ]
        });

    });

    $("body").on("click",".btn-add",function(){
        window.location.href = "{{url($page.'/tambah')}}/";
    });

    $("body").on("click",".btn-edit",function(){
        var id = jQuery(this).attr("data-id");
        window.location.href = "{{url($page.'/edit')}}/" + id ;
    });
    
    $("body").on("click",".btn-print",function(){
        jQuery("#compose-form-print").attr("action",'<?=url($page);?>/print');
        jQuery("#compose-print .modal-title").html("Cetak <?=$title;?>");
        jQuery("#compose-print").modal("toggle");  
    });

    $("body").on("change","#periode",function(){
        var periode = $("#periode").val();
        table.ajax.url('{{url("$page/json")}}/' + periode).load();
    })
</script>
@endSection