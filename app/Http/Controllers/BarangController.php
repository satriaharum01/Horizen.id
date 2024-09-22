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

class BarangController extends Controller
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

        $this->data['title'] = 'Data Barang';
        $this->page = '/admin/data/barang';
        $this->view = 'admin/data/barang';
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
            'harga' => $request->harga,
            'id_kategori' => $request->id_kategori
        ];

        Barang::create($data);

        $this->buat_notif('Tambah data Barang', 'mdi-plus', 'primary');
        return redirect($this->page);
    }


    public function update(Request $request, $id)
    {
        $data = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'id_kategori' => $request->id_kategori
        ];

        $rows = Barang::find($id);
        $rows->update($data);

        $this->buat_notif('Update data Barang', 'mdi-pencil-box-outline', 'success');
        return redirect($this->page);
    }



    public function destroy($id)
    {
        $rows = Barang::findOrFail($id);
        $rows->delete();

        $this->buat_notif('Hapus data Barang', 'mdi-delete', 'danger');
        return redirect($this->page);
    }

    public function json()
    {
        $data = Barang::select('*')
            ->get();

        foreach ($data as $row) {
            $row->kategori = $row->cari_kategori->nama;
            $inbarang = BarangMasuk::select('*')->where('id_barang', $row->id)->sum('qty');
            $outbarang = PenjualanDetail::select('*')->where('id_barang', $row->id)->sum('qty');
            $row->stok = $inbarang - $outbarang;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Barang::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }

    public function pilih($id)
    {
        $data = Barang::find($id);

        return json_encode($data);
    }
}
