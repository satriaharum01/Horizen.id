<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
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

class PegawaiSupplierController extends Controller
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

        $this->data['title'] = 'Data Supplier';
        $this->page = '/pegawai/supplier';
        $this->view = 'pegawai/supplier/index';
        $this->data['page'] = $this->page;
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view($this->view, $this->data);
    }

    public function json()
    {
        $data = Supplier::select('*')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Supplier::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }
}
