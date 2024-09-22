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

class PegawaiMutasiController extends Controller
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
        $this->middleware('is_pegawai');
        $this->data[ 'title' ] = 'Data Mutasi Barang';
        $this->data[ 'link' ] = '/pegawai/mutasi';
        $this->page = '/pegawai/mutasi';
        $this->data['page'] = $this->page;
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('pegawai/mutasi/index', $this->data);
    }

    public function cetak(Request $request)
    {
        $this->data['title'] = 'Cetak Laporan Mutasi Barang - '. env('APP_NAME');
        $this->page = '/pegawai/mutasi/print';
        $this->data['page'] = $this->page;
        $this->data['periode'] = $request->periode;
        $this->data['load'] = $this->load_periode($request->periode);
        $this->view = 'pegawai/mutasi/print';

        return view($this->view, $this->data);
    }

    public function json($periode = 0)
    {
        $data = Barang::select('*')
            ->get();

        if($periode == 0) {
            $data = array();
        } else {

            $year = substr($periode, 0, 4);
            $bulan = substr($periode, 5, 2);
            //Intro Periode
            $start = $year.'-'.$bulan.'-00';
            $end = $year.'-'.$bulan.'-31';

            foreach ($data as $row) {
                $row->nama_barang = $row->nama;
                $row->kategori = $row->cari_kategori->nama;
                $inbarang = BarangMasuk::select('*')->where('tanggal', '<=', $start)->where('id_barang', $row->id)->sum('qty');
                $outbarang = PenjualanDetail::select('*')->where('tanggal', '<=', $start)->where('id_barang', $row->id)->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.id_penjualan')->sum('qty');
                $inbarangperiode = BarangMasuk::select('*')->where('tanggal', '>=', $start)->where('tanggal', '<=', $end)->where('id_barang', $row->id)->sum('qty');
                $outbarangperiode = PenjualanDetail::select('*')->where('tanggal', '>=', $start)->where('tanggal', '<=', $end)->where('id_barang', $row->id)->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.id_penjualan')->sum('qty');
                $row->qty_awal = $inbarang - $outbarang;
                $row->qty_masuk = $inbarangperiode;
                $row->qty_keluar = $outbarangperiode;
                $row->qty_akhir = $row->qty_awal+ $inbarangperiode - $outbarangperiode;
            }
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pilih($id)
    {
        $data = PenjualanDetail::find($id);
        if(!empty($data)) {
            $data->id = $data->id_barang;
            $data->nama = $data->cari_barang->nama;
            return json_encode($data);
        }

    }

    public function load_periode($periode = 0)
    {
        $data = Barang::select('*')
            ->get();

        if($periode == 0) {
            $data = array();
        } else {

            $year = substr($periode, 0, 4);
            $bulan = substr($periode, 5, 2);
            //Intro Periode
            $start = $year.'-'.$bulan.'-00';
            $end = $year.'-'.$bulan.'-31';

            foreach ($data as $row) {
                $row->nama_barang = $row->nama;
                $row->kategori = $row->cari_kategori->nama;
                $inbarang = BarangMasuk::select('*')->where('tanggal', '<=', $start)->where('id_barang', $row->id)->sum('qty');
                $outbarang = PenjualanDetail::select('*')->where('tanggal', '<=', $start)->where('id_barang', $row->id)->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.id_penjualan')->sum('qty');
                $inbarangperiode = BarangMasuk::select('*')->where('tanggal', '>=', $start)->where('tanggal', '<=', $end)->where('id_barang', $row->id)->sum('qty');
                $outbarangperiode = PenjualanDetail::select('*')->where('tanggal', '>=', $start)->where('tanggal', '<=', $end)->where('id_barang', $row->id)->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.id_penjualan')->sum('qty');
                $row->qty_awal = $inbarang - $outbarang;
                $row->qty_masuk = $inbarangperiode;
                $row->qty_keluar = $outbarangperiode;
                $row->qty_akhir = $row->qty_awal + $inbarangperiode - $outbarangperiode;
            }
        }

        return $data;
    }
}
