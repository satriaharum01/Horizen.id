@extends('template.master')
@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-add pull-right" data-toggle="modal" data-target="#compose"><i class="mdi mdi-plus"></i> Tambah Data</button>
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
                <th width="20%">Tanggal</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
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
<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="justify-content-center modal-header">
              <center><b>
              <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4></b></center>    
          </div>
          <form action="#" method="POST" id="compose-form" class="form-horizontal" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                  <div class="form-group row">
                      <label class="col-sm-4">Tanggal</label>
                      <div class="col-sm-8">
                        <input type="date" name="tanggal" class="form-control">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Nama Barang</label>
                      <div class="col-sm-8">
                        <select name="id_barang" id="id_barang" class="form-control p-0 select-2-control" style="width:100%;" required>
                          <option value="0" selected disabled>-- Pilih Barang</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Supplier</label>
                      <div class="col-sm-8">
                        <select name="id_supplier" id="id_supplier" class="form-control p-0 select-2-control" style="width:100%;" required>
                          <option value="0" selected disabled>-- Pilih Supplier</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Jumlah</label>
                      <div class="col-sm-8">
                        <input type="number" name="qty" class="form-control">
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
              </div>
          </form>
      </div>
  </div>
</div>
<!--- END MODAL DATA --->
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
                    data: 'tanggal',
                    className: 'text-center'
                },
                {
                    data: 'barang',
                    className: 'text-center'
                },
                {
                    data: 'supplier',
                    className: 'text-center'
                },
                {
                    data: 'qty',
                    className: 'text-center', render: function(data){
                      return data + ' pcs';
                    }
                },
                {
                    data: 'id',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="data" href="<?= url($page.'/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> </a> \
					              <form id="delete-form-' + data + '-data" action="<?= url($page.'/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });

        $.ajax({
            url: "{{ url('/admin/data/barang/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    $('#id_barang').append('<option value="' + row.id + '">' + row.nama + ' </option>');
                })
            }
        });

        $.ajax({
            url: "{{ url('/admin/supplier/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    $('#id_supplier').append('<option value="' + row.id + '">' + row.nama + ' </option>');
                })
            }
        });
    });

    //Button Trigger
    $("body").on("click",".btn-add",function(){
        kosongkan();
        jQuery("#compose-form").attr("action",'<?=url($page);?>/save');
        jQuery("#compose .modal-title").html("Tambah <?=$title;?>");
        jQuery("#compose").modal("toggle");  
    });

    $("body").on("click",".btn-print",function(){
        jQuery("#compose-form-print").attr("action",'<?=url($page);?>/print');
        jQuery("#compose-print .modal-title").html("Cetak <?=$title;?>");
        jQuery("#compose-print").modal("toggle");  
    });

    $("body").on("click",".btn-edit",function(){
        var id = jQuery(this).attr("data-id");
                    
        $.ajax({
            url: "<?=url($page);?>/find/"+id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (dataResult) { 
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData,function(index,row){
                    jQuery("#compose-form input[name=tanggal]").val(row.tanggal);
                    jQuery("#compose-form select[name=id_barang]").select2().val(''+row.id_barang+'').trigger("change");
                    jQuery("#compose-form select[name=id_supplier]").select2().val(''+row.id_supplier+'').trigger("change");
                    jQuery("#compose-form input[name=qty]").val(row.qty);
                })
            }
        });
        jQuery("#compose-form").attr("action",'<?=url($page);?>/update/'+id);
        jQuery("#compose .modal-title").html("Update <?=$title?>");
        jQuery("#compose").modal("toggle");
    });
    
    $("body").on("click",".btn-simpan",function(){
        Swal.fire(
            'Data Disimpan!',
            '',
            'success'
            )
    });
        
    function kosongkan()
    {
      jQuery("#compose-form input[name=tanggal]").val("");
       jQuery("#compose-form select[name=id_barang]").select2().val('0').trigger("change");
       jQuery("#compose-form select[name=id_supplier]").select2().val('0').trigger("change");
      jQuery("#compose-form input[name=qty]").val("");
    }
    
    $("body").on("change","#periode",function(){
        var periode = $("#periode").val();
        table.ajax.url('{{url("$page/json")}}/' + periode).load();
    })
</script>
@endSection