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

class MetodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //Start Controller Function
        $this->middleware('auth');
        $this->middleware('is_admin');
        $this->data[ 'title' ] = 'Metode ABC';
        $this->page = '/admin/metode';
        $this->data['page'] = $this->page;
    }

    /*
     * Index Function
    */
    public function index()
    {
        return view('admin/metode/index', $this->data);
    }

    public function cetak(Request $request)
    {
        $this->data['title'] = 'Cetak Laporan Metode - '. env('APP_NAME');
        $this->page = '/admin/metode';
        $this->data['page'] = $this->page;
        $this->data['periode'] = $request->periode;
        $this->data['load'] = $this->pilih($request->periode);
        $this->view = 'admin/metode/print';

        return view($this->view, $this->data);
    }

    public function pilih($periode)
    {
        $year = substr($periode, 0, 4);
        $bulan = substr($periode, 5, 2);
        //Intro Periode
        $start = $year.'-'.$bulan.'-00';
        $end = $year.'-'.$bulan.'-31';

        //Define Array ABC
        $abc = array();

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
            if($nilai_dasarA <= 80 && $k == 0) {
                $k = 0;
            } else {
                $nilai_dasarB +=  round(($row['nilai_konsumsi'] / $total_nilai_konsumsi) * 100, 2);
                if($nilai_dasarB <= 15 && $k == 0 || $nilai_dasarB <= 15 && $k == 1) {
                    $k = 1;
                    if($persenakumulatif >= 15) {
                        $persenakumulatif = 0;
                    }
                } else {
                    $k = 2;
                    if($persenakumulatif >= 10) {
                        $persenakumulatif = 0;
                    }
                }
            }
            $persenakumulatif += ($row['nilai_konsumsi'] / $total_nilai_konsumsi) * 100;

            $abc[$key]['akumulatif'] = round($persenakumulatif, 2).' %';

            if ($key === array_key_last($abc)) {
                $abc[$key]['akumulatif'] = round($persenakumulatif, 0).' %';
            }
            $abc[$key]['klasifikasi'] = ($this->klasifikasi[$k]);

        }


        return Datatables::of($abc)
            ->addIndexColumn()
            ->make(true);
    }

}
