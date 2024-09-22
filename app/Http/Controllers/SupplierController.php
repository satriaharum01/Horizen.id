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

class SupplierController extends Controller
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

        $this->data['title'] = 'Data Supplier';
        $this->page = '/admin/supplier';
        $this->view = 'admin/supplier/index';
        $this->data['page'] = $this->page;
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view($this->view, $this->data);
    }

    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama,
        ];

        $this->buat_notif('Tambah '.strtolower($this->data['title']), 'mdi-plus', 'primary');

        Supplier::create($data);

        return redirect($this->page);
    }


    public function update(Request $request, $id)
    {
        $this->buat_notif('Update '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');

        $data = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'id_kategori' => $request->id_kategori
        ];

        $rows = Supplier::find($id);
        $rows->update($data);

        return redirect($this->page);
    }



    public function destroy($id)
    {
        $this->buat_notif('Hapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');

        $rows = Supplier::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
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
