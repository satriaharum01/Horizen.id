<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Foto;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
        $this->data['title'] = 'Dashboard Admin';
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {

        $this->data['barang'] = $this->count_barang();
        $this->data['barang_masuk'] = $this->count_barang_masuk_bulan_ini();
        $this->data['penjualan'] = $this->count_penjualan();
        $this->data['penjualan_bulan'] = $this->count_penjualan_bulan_ini();
        $this->data['chart'] = $this->graph_area();
        $this->data['abc'] = $this->metode_abc();
        return view('admin/dashboard/index', $this->data);
    }

    public function graph_area()
    {
        $out = array();
        $date = date('Y-');
        for($i = 1; $i <= 12 ; $i++) {
            if($i < 10) {
                $finder = $date.'0'.$i;
            } else {
                $finder = $date.$i;
            }
            $data = Penjualan::select('*')->where('tanggal', '>=', $finder.'-00')->where('tanggal', '<=', $finder.'-31')->get();
            $result = 0;
            foreach($data as $row) {
                $load = PenjualanDetail::select('*')->where('id_penjualan', $row->id)->get();
                foreach($load as $dow) {
                    $result += ($dow->harga);
                }
            }
            $out[] = $result;
        }

        return json_encode($out);
    }

    public function count_barang()
    {
        $data = Barang::select('*')->count();

        return $data;
    }

    public function count_barang_masuk_bulan_ini()
    {
        $month = date('Y-m');
        $data = BarangMasuk::select('*')->where('tanggal', '>=', $month.'-00')->where('tanggal', '<=', $month.'-31')->sum('qty');

        return $data;
    }

    public function count_penjualan()
    {
        $data = Penjualan::select('*')->get();
        $result = 0;
        foreach($data as $row) {
            $load = PenjualanDetail::select('*')->where('id_penjualan', $row->id)->get();
            foreach($load as $dow) {
                $result +=  $dow->harga;
            }
        }
        return number_format($result);
    }

    public function count_penjualan_bulan_ini()
    {
        $month = date('Y-m');
        $data = Penjualan::select('*')->where('tanggal', '>=', $month.'-00')->where('tanggal', '<=', $month.'-31')->get();
        $result = 0;
        foreach($data as $row) {
            $load = PenjualanDetail::select('*')->where('id_penjualan', $row->id)->get();
            foreach($load as $dow) {
                $result +=  $dow->harga;
            }
        }
        return number_format($result);
    }


    public function metode_abc()
    {
        $year = date('Y');
        $bulan = date('m');
        //Intro Periode
        $start = $year.'-'.$bulan.'-00';
        $end = $year.'-'.$bulan.'-31';

        //Define Array ABC
        $abc = array();
        $out = array();
        //Collect Data
        $data = Penjualan::select('*')->where('tanggal', '>=', $start)->where('tanggal', '<=', $end)->get();

        //Perhitungan Metode ABC
        foreach($data as $row) {
            //Collect data detail penjualan

            $detail = PenjualanDetail::select('*')->where('id_penjualan', $row->id)->get();

            //Perhitungan Nilai Konsumsi Setiap Item
            foreach($detail as $low) {
                if(empty($abc[$low->id_barang])) {
                    $abc[$low->id_barang] = $low;
                    $abc[$low->id_barang]['harga'] = $low->cari_barang->harga;
                    $abc[$low->id_barang]['nama'] = $low->cari_barang->nama;
                } else {
                    $abc[$low->id_barang]['qty'] += $low->qty;
                }

                $abc[$low->id_barang]['nilai_konsumsi'] = $abc[$low->id_barang]['qty'] * $abc[$low->id_barang]['harga'];
            }

        }
        //Define Total Nilai Konsumsi
        $total_nilai_konsumsi = array_sum(array_column($abc, 'nilai_konsumsi'));
        $persenakumulatif = 0;
        $nilai_dasarA = 0;
        $nilai_dasarB = 0;
        //Perhitungan Persentase Akumulatif
        array_multisort(array_column($abc, 'nilai_konsumsi'), SORT_DESC, $abc);

        $k = 0;
        foreach($abc as $key => $row) {

            $abc[$key]['persentase'] = round(($row['nilai_konsumsi'] / $total_nilai_konsumsi) * 100, 2).' %';
            $nilai_dasarA = $persenakumulatif +  ($row['nilai_konsumsi'] / $total_nilai_konsumsi) * 100;
            if($nilai_dasarA <= 80) {
                $k = 0;
            } else {
                $nilai_dasarB +=  round(($row['nilai_konsumsi'] / $total_nilai_konsumsi) * 100, 2);
                if($nilai_dasarB <= 15) {
                    $k = 1;
                } else {
                    $k = 2;
                }
            }
            $persenakumulatif += ($row['nilai_konsumsi'] / $total_nilai_konsumsi) * 100;
            
            $abc[$key]['akumulatif'] = round($persenakumulatif,2).' %';

    if ($key === array_key_last($abc)) {
         $abc[$key]['akumulatif'] = round($persenakumulatif,0).' %';
    }
            $abc[$key]['klasifikasi'] = ($this->klasifikasi[$k]);

        }

        $i = 1;
        foreach($abc as $key => $row) {
            $abc[$key]['index'] = $i;
            $i++;
        }

        return $abc;
    }
}
