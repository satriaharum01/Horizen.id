@extends('template.master')
@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-danger mx-2 btn-print pull-right"><i class="mdi mdi-printer"></i> Cetak</button>

        <div class="pull-right row mx-1">
          <label class="mx-2 pt-1">Periode :</label>
          <input type="month" class="form-control col-md-8" name="periode" id="periode">
        </div>
        <h2 class="card-title">{{$title}}</h2>
        
        <div class="table-responsive pt-5">
          <table class="display table table-bordered table-hover" id="data-width" width="100%">
            <thead class="text-center bg-primary text-white">
              <tr>
                <th width="7%">No</th>
                <th>Nama Item</th>
                <th>Harga</th>
                <th>Jumlah Barang Keluar</th>
                <th>Nilai Konsumsi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4">Total Nilai Konsumsi</th>
                <th id="total_nilai">0</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <div class="table-responsive pt-5">
          <table class="display table table-bordered table-hover" id="data-width-1" width="100%">
            <thead class="text-center bg-primary text-white">
              <tr>
                <th width="7%">No</th>
                <th>Nama Item</th>
                <th>Persentase</th>
                <th>Persentase Akumulatif</th>
                <th>Klasifikasi</th>
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
                      <label class="col-sm-4">Periode</label>
                      <div class="col-sm-8">
                        <input type="month" name="periode" class="form-control">
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
  var total = 0;
  $(function() {
        table = $('#data-width').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: '{{url("$page/json/2024-00")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    className: 'text-center'
                },
                {
                    data: 'harga',
                    className: 'text-center', render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                },
                {
                    data: 'qty',
                    className: 'text-center'
                },
                {
                    data: 'nilai_konsumsi',
                    className: 'text-center', render: function(data){
                        total += data;
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                },
            ]
        });

        table1 = $('#data-width-1').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: '{{url("$page/json/2024-00")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    className: 'text-center'
                },
                {
                    data: 'persentase',
                    className: 'text-center'
                },
                {
                    data: 'akumulatif',
                    className: 'text-center'
                },
                {
                    data: 'klasifikasi',
                    className: 'text-center'
                },
            ]
        });

      })

  $("body").on("click",".btn-print",function(){
    jQuery("#compose-form-print").attr("action",'<?=url($page);?>/print');
    jQuery("#compose-print .modal-title").html("Cetak <?=$title;?>");
    jQuery("#compose-print").modal("toggle");  
  });

  $("body").on("change","#periode",function(){
   
    var periode = $("#periode").val();
    table.ajax.url('{{url("admin/metode/json/")}}/' + periode).load();
    table1.ajax.url('{{url("admin/metode/json/")}}/' + periode).load();
    $.ajax({
        url: '{{url("admin/metode/json/")}}/'+ periode,
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            total = 0;
            $.each(resultData, function(index, row) {
                total = total + row.nilai_konsumsi;
            })
            
            $('#total_nilai').html('<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(total)+'</span></div>');
        }
    });
  })
</script>
@endsection