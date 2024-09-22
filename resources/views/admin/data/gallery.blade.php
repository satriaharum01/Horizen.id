@extends('template.master')
@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-add pull-right" data-toggle="modal" data-target="#compose"><i class="mdi mdi-plus"></i> Tambah Data</button>
        <h3 class="card-title">{{$title}}</h3>
        <div class="table-responsive pt-5">
          <table class="display table table-bordered table-hover" id="data-width" width="100%">
            <thead class="text-center">
              <tr>
                <th width="7%">No</th>
                <th>Nama Barang</th>
                <th width="25%">Foto Utama</th>
                <th width="10%">Aksi</th>
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

 
<!-- ============ MODAL DATA =============== -->
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
                      <label class="col-sm-4">Nama Barang</label>
                      <div class="col-sm-8">
                        <select name="id_barang" id="id_barang" class="form-control p-0" required>
                          <option value="0" selected disabled>-- Pilih Barang</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">status</label>
                      <div class="col-sm-8">
                        <select name="status" class="form-control p-0" required>
                          <option value="Primary">Foto Utama</option>
                          <option value="Normal">Foto Pendukung</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group row">
                        <label class="col-md-6">Foto</label>
                        <img class="col-md-5" style="width:14rem;height:5rem;" src="" alt="Foto" name="gambar_profil" id="output">
                    </div>
                  <div class="form-group row">
                      <label class="col-sm-4"></label>
                      <div class="col-sm-8">
                            <input type="file" name="gambar" accept="image/*" onchange="loadFile(event)">
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
                    data: 'nama'
                },
                {
                    data: 'foto',
                    className: 'text-center', render: function(data){
                      return '<img style="max-width:10rem;max-height:10rem;min-width:5rem;min-height:5rem;" src="{{asset("images/product_images")}}/'+data+'" alt="Foto">';
                    }
                },
                {
                    data: 'id',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-info btn-eye" data-id="' + data + '"><i class="fa fa-eye"></i> </button>';
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
    });

    //Button Trigger
    $("body").on("click",".btn-add",function(){
        kosongkan();
        jQuery("#compose-form").attr("action",'<?=url($page);?>/save');
        jQuery("#compose .modal-title").html("Tambah <?=$title;?>");
        jQuery("#compose").modal("toggle");  
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
                    jQuery("#compose-form select[name=id_barang]").val(row.id_barang);
                    jQuery("#compose-form select[name=status]").val(row.status);
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
      jQuery("#compose-form select[name=id_barang]").val("");
      jQuery("#compose-form select[name=status]").val("");
    }
    
    $("body").on("click",".btn-eye",function(){
        var id = jQuery(this).attr("data-id");
        window.location.href = "{{url($page.'/detail')}}/" + id ;
    });
    
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
          URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
@endSection