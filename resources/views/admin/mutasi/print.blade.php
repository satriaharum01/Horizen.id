<?php
error_reporting(0);
if(!empty($_GET['download'] == 'doc')) {
    header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_laporan_rekam_medis.doc");
}
if(!empty($_GET['download'] == 'xls')) {
    header("Content-Type: application/force-download");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_laporan_rekam_medis.xls");
}
?>
<?php
$tgla = $start;
$tglk = $periode;
$bulan = array(
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
);

$array1 = explode("-", $tgla);
$tahun = $array1[0];
$bulan1 = $array1[1];
$hari = $array1[2];
$bl1 = $bulan[$bulan1];
$tgl1 = $hari . ' ' . $bl1 . ' ' . $tahun;

$no = 1;
$array2 = explode("-", $tglk);
$tahun2 = $array2[0];
$bulan2 = $array2[1];
$hari2 = $array2[2];
$bl2 = $bulan[$bulan2];
$tgl2 =  $bl2 . ' ' . $tahun2;
$total_awal = 0;
$total_masuk = 0;
$total_keluar = 0;
$total_akhir = 0;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
		<title><?= $title;?></title>
		<style>
			body {
				background: rgba(0,0,0,0.2);
			}
			page[size="A4"] {
				background: white;
				height: auto;
				width: 29.7cm;
				display: block;
				margin: 0 auto;
				margin-bottom: 0.5pc;
				box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
				padding-left:2.54cm;
				padding-right:2.54cm;
				padding-top:1.54cm;
				padding-bottom:1.54cm;
			}
			@media print {
				body, page[size="A4"] {
					margin: 0;
					box-shadow: 0;
				}
			}
		</style>
	</head>
	<body>
        <div class="container">
            <br/> 
            <div class="pull-left">
                Cetak Laporan - Preview HTML to PDF [ size paper A4 ]
            </div>
            <div class="pull-right"> 
            <button type="button" class="btn btn-success btn-md" onclick="printDiv('printableArea')">
                <i class="fa fa-print"> </i> Print File
            </button>
            </div>
        </div>
        <br/>
        <div id="printableArea">
            <page size="A4">
				<div class="">
					<div class="panel-body">
						<h4 class="text-center">LAPORAN MUTASI BARANG <br>{{strtoupper(env('APP_NAME'))}}
                        </h4>
                        <br>
                        Periode : {{$tgl2}}
                        <br>
                        <br>
						<div class="row">
						<div class="table-responsive">
                            <table class="table table-bordered" id="datawidth" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                <th class="text-center" width="7%">No</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Qty Awal</th>
                <th class="text-center">Qty Masuk</th>
                <th class="text-center">Qty Keluar</th>
                <th class="text-center">Qty Akhir</th>
              </tr>
                                </thead>
                                <tbody class="text-center">
                                @foreach($load as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td class="text-left">{{$row->nama_barang}}</td>
                                    <td>{{$row->kategori}}</td>
                                    <td>{{$row->qty_awal}}</td>
                                    <td>{{$row->qty_masuk}}</td>
                                    <td>{{$row->qty_keluar}}</td>
                                    <td>{{$row->qty_akhir}}</td>
                                    <?php
                                        $total_awal = $total_awal + $row->qty_awal;
$total_masuk = $total_masuk + $row->qty_masuk;
$total_keluar = $total_keluar + $row->qty_keluar;
$total_akhir = $total_akhir + $row->qty_akhir;
?>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-center">Total</th>
                                        <th class="text-center">{{$total_awal}} Pcs</th>
                                        <th class="text-center">{{$total_masuk}} Pcs</th>
                                        <th class="text-center">{{$total_keluar}} Pcs</th>
                                        <th class="text-center">{{$total_akhir}} Pcs</th>
                                    </tr>
                                </tfoot>
                            </table>
			            </div>
						</div>
					</div>
				</div>
            </page>
        </div>
  </body>
    <!-- jQuery 3 -->
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('assets/bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
    <!-- DataTables -->
    <script src="{{asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <!-- Money Format plugins -->
    <script src="{{asset('assets/js/dashboard-chart-area.js')}}"></script>

  <script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
  </script>
</html>