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
use File;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class BarangMasukController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $rules = [
        'stat'          => 'required|min_length[3]|max_length[50]',
        'harga'        => 'required|min_length[3]|max_length[50]'
    ];

    public function __construct()
    {
        //Start Controller Function
        $this->middleware('auth');
        $this->middleware('is_admin');
        $this->data['title'] = 'Data Stok Barang ';
        $this->page = '/admin/stok';
        $this->view = 'admin/stok/index';
        $this->data['page'] = $this->page;
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view($this->view, $this->data);
    }

    public function cetak(Request $request)
    {
        $this->data['title'] = 'Cetak Laporan Stok - '. env('APP_NAME');
        $this->page = '/admin/stok/print';
        $this->data['page'] = $this->page;
        $this->data['start'] = $request->start;
        $this->data['end'] = $request->end;
        $this->data['load'] = $this->load_periode($request->start, $request->end);
        $this->view = 'admin/stok/print';

        return view($this->view, $this->data);
    }

    public function store(Request $request)
    {
        $data = [
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'qty' => $request->qty
        ];

        $this->buat_notif('Tambah '.strtolower($this->data['title']), 'mdi-plus', 'primary');

        BarangMasuk::create($data);

        return redirect($this->page);
    }


    public function update(Request $request, $id)
    {
        $this->buat_notif('Update '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');

        $data = [
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'qty' => $request->qty
        ];

        $rows = BarangMasuk::find($id);
        $rows->update($data);

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $this->buat_notif('Hapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');

        $rows = BarangMasuk::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }

    public function json($periode = 0)
    {
        if($periode == 0) {
            $data = BarangMasuk::select('*')
            ->orderBy('tanggal', 'DESC')
            ->get();
        } else {

            $year = substr($periode, 0, 4);
            $bulan = substr($periode, 5, 2);
            //Intro Periode
            $start = $year.'-'.$bulan.'-00';
            $end = $year.'-'.$bulan.'-31';

            $data = BarangMasuk::select('*')
            ->where('tanggal', '>=', $start)->where('tanggal', '<=', $end)
            ->orderBy('tanggal', 'ASC')
            ->get();
        }

        foreach ($data as $row) {
            $row->tanggal = date('d ', strtotime($row->tanggal)) . $this->bulan[date('n', strtotime($row->tanggal))] .  date(' Y', strtotime($row->tanggal));
            $row->barang = $row->cari_barang->nama;
            $row->supplier = $row->cari_supplier->nama;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = BarangMasuk::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }

    public function load_periode($start, $end)
    {
        $data = BarangMasuk::select('*')
            ->where('tanggal', '>=', $start.'-01')
            ->where('tanggal', '<=', $end.'-31')
            ->orderBy('tanggal', 'ASC')
            ->get();

        foreach ($data as $row) {
            $row->tanggal = date('d ', strtotime($row->tanggal)) . $this->bulan[date('n', strtotime($row->tanggal))] .  date(' Y', strtotime($row->tanggal));
            $row->barang = $row->cari_barang->nama;
            $row->supplier = $row->cari_supplier->nama;
        }

        return $data;
    }
}
