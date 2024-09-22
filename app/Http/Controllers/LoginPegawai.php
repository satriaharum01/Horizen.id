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

class LoginPegawai extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_pegawai');
        $this->data['title'] = 'Dashboard Pegawai';
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
        return view('pegawai/dashboard/index', $this->data);
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
            $load = PenjualanDetail::select('*')->where('id_penjualan', $row->id)->sum('harga');
            $result = $result + $load;
        }
        return number_format($result);
    }

    public function count_penjualan_bulan_ini()
    {
        $month = date('Y-m');
        $data = Penjualan::select('*')->where('tanggal', '>=', $month.'-00')->where('tanggal', '<=', $month.'-31')->get();
        $result = 0;
        foreach($data as $row) {
            $load = PenjualanDetail::select('*')->where('id_penjualan', $row->id)->sum('harga');
            $result = $result + $load;
        }
        return number_format($result);
    }
}
