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
        <h3 class="card-title">{{$title}}</h3>
        <div class="table-responsive pt-5">
          <table class="display table table-bordered table-hover" id="data-width" width="100%">
            <thead class="text-center">
              <tr>
                <th width="7%">No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Qty Awal</th>
                <th>Qty Masuk</th>
                <th>Qty Keluar</th>
                <th>Qty Akhir</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
            
            <tfoot>
                <tr>
                    <th colspan="3" class="text-center">Total</th>
                    <th class="text-center" id="t_awal">0 Pcs</th>
                    <th class="text-center" id="t_masuk">0 Pcs</th>
                    <th class="text-center" id="t_keluar">0 Pcs</th>
                    <th class="text-center" id="t_akhir">0 Pcs</th>
                </tr>
            </tfoot>
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
  let qty_awal = 0, qty_masuk = 0, qty_keluar = 0, qty_akhir = 0;
    $(function() {
        table = $('#data-width').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthchange: false,
            paging: false,
            ajax: {
                url: '{{url("$page/json/0")}}',
                complete: function(cc){
                    qty_awal = 0;
                    qty_masuk = 0;
                    qty_keluar = 0;
                    qty_akhir = 0;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_barang',
                    className: 'text-center'
                },
                {
                    data: 'kategori',
                    className: 'text-center'
                },
                {
                    data: 'qty_awal',
                    className: 'text-center', render: function(data){
                      qty_awal = qty_awal + data;
                      return data;
                    }
                },
                {
                    data: 'qty_masuk',
                    className: 'text-center', render: function(data){
                      qty_masuk = qty_masuk + data;
                      return data;
                    }
                },
                {
                    data: 'qty_keluar',
                    className: 'text-center', render: function(data){
                      qty_keluar = qty_keluar + data;
                      return data;
                    }
                },
                {
                    data: 'qty_akhir',
                    className: 'text-center', render: function(data){
                      qty_akhir = qty_akhir + data;
                      return data;
                    }
                },
            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api();
        
                // Helper function to remove formatting and parse to float
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };
        
                // Calculate total for each column
                var total_awal = 0;
                var total_masuk = 0;
                var total_keluar = 0;
                var total_akhir = 0;
        
                // Loop through each row and accumulate the values
                api.rows({ page: 'current' }).every(function(rowIdx, tableLoop, rowLoop)        {
                    var rowData = this.data();
                    total_awal += intVal(rowData.qty_awal);
                    total_masuk += intVal(rowData.qty_masuk);
                    total_keluar += intVal(rowData.qty_keluar);
                    total_akhir += intVal(rowData.qty_akhir);
                });
        
                // Update footer with the totals
                $(api.column(3).footer()).html(total_awal);
                $(api.column(4).footer()).html(total_masuk);
                $(api.column(5).footer()).html(total_keluar);
                $(api.column(6).footer()).html(total_akhir);
            }
        });
        
    });
    
    $("body").on("click",".btn-print",function(){
        jQuery("#compose-form-print").attr("action",'<?=url($page);?>/print');
        jQuery("#compose-print .modal-title").html("Cetak <?=$title;?>");
        jQuery("#compose-print").modal("toggle");  
    });

    $("body").on("change","#periode",function(){
        qty_awal = 0, qty_masuk = 0, qty_keluar = 0, qty_akhir = 0;
        table.ajax.reload();
        var periode = $("#periode").val();
        table.ajax.url('{{url("$page/json")}}/' + periode).load();
    })
</script>
@endSection