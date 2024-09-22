@extends('template.master')
@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title">{{$title}}</h3>
        <form action="#" method="POST" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          <div class="modal-body"> 
            <div class="form-group row">
                <label class="col-sm-4">Kode Transaksi</label>
                <div class="col-sm-8">
                    <input type="text" name="kode" class="form-control" value="{{$kode ?? ''}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Tanggal</label>
                <div class="col-sm-8">
                    <input type="date" name="tanggal" class="form-control" value="{{$load->tanggal ?? ''}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4">Pelanggan</label>
                <div class="col-sm-8">
                  <select name="id_user" id="id_user" class="form-control p-0 px-2 select-2-form" style="width:100%;">
                    <option value="0" selected disabled>-- Pilih Pembeli</option>
                  </select>  
                </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="modal-body">
              <div class="form-group">
                  <button type="button" class="btn btn-primary btn-add" style="float: right;">
                    <i class="fa fa-plus"></i> Tambah Barang 
                  </button>
                  <label>Barang</label>
              </div>
        
              <div class="form-group">
                <div class="table-responsive pt-5">
                  <table id="pembelian" class="table table-striped table-bordered" width="100%" name="detail">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Nama Barang</th>
                            <th style="text-align:center;">Harga</th>
                            <th style="text-align:center;" width="10%">Qty</th>
                            <th style="text-align:center;" width="20%">Total</th>
                            <th style="text-align:center;" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="text-align:left;">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary btn-pesan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

 
<!-- ============ MODAL DATA  =============== -->
<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="max-width:70% !important;" role="document">
      <div class="modal-content">
          <div class="justify-content-center modal-header">
              <center><b>
              <h4 class="modal-title" id="exampleModalLabel">Pilih Barang</h4></b></center>    
          </div>
          <div class="modal-body"> 
            <table class="table table-striped table-bordered" id="data-width" style="width: 100%">
                <thead >
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Stok</th>
                        <th width="15%" class="text-center">#</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                </tbody>
            </table>
          </div>
      </div>
  </div>
</div>
<!--- END MODAL DATA --->
@endsection

@section('custom_script')


<script>
    var id_user = '{{$load->id_user ?? 0}}';
    var keranjang = new Array();
    var tmp;
    var total;
    var price;
    var table;
    var zero;

    $(function() {
      
      $.ajax({
            url: "{{ url('/admin/pengguna/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    if(id_user == row.id)
                    {
                        var slct = 'selected';
                    }
                    if(row.level === 'Pembeli')
                    {
                        $('#id_user').append('<option value="' + row.id + '" '+slct+'>' + row.name + ' </option>');
                    }
                })
            }
        });

        table = $('#data-width').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url("admin/data/barang/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama', className: 'text-left'
                },
                {
                    data: 'harga', render: function(data){
                        return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
                    }
                },
                {
                    data: 'stok', render: function(data){
                      if(data > 0)
                      {
                        zero = ''
                      }else{
                        zero = 'disabled';
                      }
                      return data;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button '+zero+' type="button" class="btn btn-sm btn-primary btn-qty" data-id="' + data + '"><i class="ti-plus"></i> Pilih</button>';
                    }
                },
            ]
        });
        
        @if(isset($detail))
        @foreach($detail as $row)
        $.ajax({
            url: "{{ url('/admin/penjualan/pilih/'.$row->id)}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                addKeranjang(dataResult);
            }
        });
        @endforeach
        @endif
    });
    
    //Button Trigger
    $("body").on("click", ".btn-add", function() {
        jQuery("#compose").modal("toggle");
    })
    $("body").on("click", ".btn-qty", function() {
        var id = jQuery(this).attr("data-id");
        $.ajax({
            url: "{{ url('/admin/data/barang/pilih')}}/" + id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                addKeranjang(dataResult);
            }
        });

        jQuery("#compose").modal("hide");
    })

    $("body").on('change', '.change-qty', function() {
        var before = keranjang;
        var qty = parseInt(jQuery(this).val());
        var id = jQuery(this).attr("data-id");

        before[id]["qty"] = qty;

        if (qty <= 0) {
            delete before[id];
        }
        keranjang = before;

        refreshtable(keranjang);
    })

    function addKeranjang(data) {
        var before = keranjang;
        var qty = 1;

        if (before[data.id]) {
            qty = before[data.id]["qty"] + 1;
        } else {
            before[data.id] = data;
        }
        if(before[data.id]["qty"])
        {
            before[data.id]["qty"] = before[data.id]["qty"];
        }else{
            before[data.id]["qty"] = qty;
        }
        keranjang = before;

        refreshtable(keranjang);
    }

    function deletekeranjang(id) {
        delete keranjang[id];

        refreshtable(keranjang);
    }

    function refreshtable(data) {
        var html1 = "";
        total = 0;
        data.forEach(function(item, index) {
            price = item.harga;
            html1 += '<tr><td>' + item.nama + '</td><td><div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(price)+'</span></div></td><td class="text-center"><input type="number" style="width:52px" value="' + item.qty + '" class="change-qty" data-id="' + item.id + '"/></td></td><td><div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(price*item.qty )+'</span></div></td><td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="deletekeranjang(' + item.id + ')"><i class="fa fa-times"></i></button></td></tr>';
            total = (total + (price * item.qty));
        })

        console.log(keranjang);
        jQuery("#pembelian tbody").html(html1);
        jQuery('.total').html("Rp " + total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
    }

    $("body").on("click", ".btn-pesan", function() {
        var kode = $("input[name=kode]").val();
        var tanggal = $("input[name=tanggal]").val();
        var id_user = $("select[name=id_user]").val();
        var url = "{{ url($link) }}";


        Swal.fire({
            title: 'Simpan Data ?',
            text: "Simpan Transaksi Saat Ini ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Data Diproses!',
                    '',
                    'success'
                );
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        kode: kode,
                        tanggal: tanggal,
                        id_user: id_user,
                        cart: keranjang
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.message) //Message come from controller
                            window.location.href = "{{url('/admin/penjualan/')}}";
                        } else {
                            alert("Error")
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        });
    })
</script>
@endSection