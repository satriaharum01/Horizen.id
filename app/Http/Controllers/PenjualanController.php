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

class PenjualanController extends Controller
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
        $this->data[ 'title' ] = 'Data Penjualan';
        $this->data[ 'link' ] = '/admin/penjualan';
        $this->page = '/admin/penjualan';
        $this->data['page'] = $this->page;
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/penjualan/index', $this->data);
    }

    public function cetak(Request $request)
    {
        $this->data['title'] = 'Cetak Laporan Penjualan - '. env('APP_NAME');
        $this->page = '/admin/penjualan/print';
        $this->data['page'] = $this->page;
        $this->data['start'] = $request->start;
        $this->data['end'] = $request->end;
        $this->data['load'] = $this->load_periode($request->start, $request->end);
        $this->view = 'admin/penjualan/print';

        return view($this->view, $this->data);
    }

    public function tambah()
    {
        $jumdat = Penjualan::select('*')->max('id');

        if ($jumdat) {
            $kode    = $jumdat + 1;
            $kodeoto = "HRZ-".str_pad($kode, 4, "0", STR_PAD_LEFT);
        } else {
            $kodeoto = "HRZ-0001";
        }

        $this->data[ 'title' ] = 'Tambah Data Penjualan';
        $this->data[ 'link' ] = '/admin/penjualan/save';
        $this->page = '/admin/penjualan';
        $this->data['page'] = $this->page;
        $this->data['kode'] = $kodeoto;
        return view('admin/penjualan/detail', $this->data);
    }

    public function edit($kode)
    {
        $load = Penjualan::select('*')->where('kode', $kode)->first();
        if(empty($load)) {
            $a = Penjualan::find($kode);
            return redirect()->to('/admin/penjualan/edit/'.$a->kode);
        }

        $bulk = Penjualan::select('id')->where('kode', $kode)->get()->toArray();

        $detail = PenjualanDetail::select('*')->whereIn('id_penjualan', $bulk)->get();

        $this->data[ 'title' ] = 'Edit Data Penjualan - '.$load->kode;
        $this->data[ 'link' ] = '/admin/penjualan/update/'.$load->id;
        $this->page = '/admin/penjualan';
        $this->data['detail'] = $detail;
        $this->data['page'] = $this->page;
        $this->data['load'] = $load;
        $this->data['kode'] = $load->kode;
        return view('admin/penjualan/detail', $this->data);
    }

    public function json($periode = 0)
    {
        if($periode == 0) {
            $data = Penjualan::select('*')
                ->orderBy('tanggal', 'DESC')
                ->get();
        } else {

            $year = substr($periode, 0, 4);
            $bulan = substr($periode, 5, 2);
            //Intro Periode
            $start = $year.'-'.$bulan.'-00';
            $end = $year.'-'.$bulan.'-31';

            $data = Penjualan::select('*')
            ->where('tanggal', '>=', $start)->where('tanggal', '<=', $end)
            ->orderBy('tanggal', 'ASC')
            ->get();
        }


        foreach($data as $row) {
            $row->user = $row->cari_user->name;
            $row->tanggal = date('d ', strtotime($row->tanggal)) . $this->bulan[date('n', strtotime($row->tanggal))] .  date(' Y', strtotime($row->tanggal));
            $row->jumlah = 0;
            $row->qty = 0;
            $detail = PenjualanDetail::select('*')->where('id_penjualan', $row->id)->get();
            foreach($detail as $dow) {
                $row->jumlah += $dow->harga * $dow->qty;
                $row->qty += $dow->qty;
            }
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Penjualan::find($id);

        $data = [
            'tanggal' => $request->tanggal,
            'id_user' => $request->id_user
        ];

        $rows->update($data);

        $penjualan = Penjualan::select('*')->where('kode', $request->kode)->first();
        PenjualanDetail::select('*')->where('id_penjualan', $penjualan->id)->delete();
        $detail = $request->cart;
        //unset($detail[0]);
        $clear = array_filter($detail);

        foreach ($clear as $cart) {
            $data = [
                'id_penjualan' => $penjualan->id,
                'id_barang' => $cart['id'],
                'qty' => $cart['qty'],
                'harga' => $cart['harga']
            ];
            PenjualanDetail::create($data);
        }

        $this->buat_notif('Update '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');
        return response()->json(
            [
                'success' => true,
                'message' => json_encode($clear)
            ]
        );


        return redirect($this->page);
    }

    public function store(Request $request)
    {

        $data = [
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'id_user' => $request->id_user
        ];

        Penjualan::create($data);

        $penjualan = Penjualan::select('*')->where('kode', $request->kode)->first();
        $detail = $request->cart;
        //unset($detail[0]);
        $clear = array_filter($detail);

        foreach ($clear as $cart) {
            $data = [
                'id_penjualan' => $penjualan->id,
                'id_barang' => $cart['id'],
                'qty' => $cart['qty'],
                'harga' => $cart['harga']
            ];
            PenjualanDetail::create($data);
        }

        $this->buat_notif('Tambah '.strtolower($this->data['title']), 'mdi-plus', 'primary');
        return response()->json(
            [
                'success' => true,
                'message' => json_encode($clear)
            ]
        );


        return redirect($this->page);
    }

    public function destroy($id)
    {
        $this->buat_notif('Hapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');

        $rows = Penjualan::findOrFail($id);
        $rows->delete();
        $rows = PenjualanDetail::select('*')->where('id_penjualan', $id)->get();
        $rows->delete();

        return redirect($this->page);
    }

    public function find($id)
    {
        $data = Penjualan::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
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

    public function load_periode($start, $end)
    {
        $data = Penjualan::select('*')
            ->where('tanggal', '>=', $start.'-01')
            ->where('tanggal', '<=', $end.'-31')
            ->orderBy('tanggal', 'ASC')
            ->get();

        foreach($data as $row) {
            $row->user = $row->cari_user->name;
            $row->tanggal = date('d ', strtotime($row->tanggal)) . $this->bulan[date('n', strtotime($row->tanggal))] .  date(' Y', strtotime($row->tanggal));
            $row->jumlah = 0;
            $row->qty = 0;
            $detail = PenjualanDetail::select('*')->where('id_penjualan', $row->id)->get();
            foreach($detail as $dow) {
                $row->jumlah += $dow->harga * $dow->qty;
                $row->qty += $dow->qty;
            }
        }

        return $data;
    }
}
