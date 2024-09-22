<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class KategoriController extends Controller
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

        $this->data[ 'title' ] = 'Kategori Barang';
        $this->page = '/admin/data/kategori';
        $this->view = 'admin/data/kategori';
        $this->data['page'] = $this->page;
    }

    /*
     * Index Function
    */
    public function index()
    {
        return view($this->view, $this->data);
    }

    public function json()
    {
        $data = Kategori::select('*')
            ->orderBy('nama', 'ASC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $rows = Kategori::find($id);

        $rows->update([
            'nama' => $request->nama
        ]);

        $this->buat_notif('Update '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');
        return redirect($this->page);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'nama' => 'required|min:3'
         ]);

        $data = [
            'nama' => $request->nama
        ];

        Kategori::create($data);


        $this->buat_notif('Tambah '.strtolower($this->data['title']), 'mdi-plus', 'primary');
        return redirect($this->page);
    }

    public function destroy($id)
    {
        $this->buat_notif('Hapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');
        $rows = Kategori::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }

    public function find($id)
    {
        $data = Kategori::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }

}
