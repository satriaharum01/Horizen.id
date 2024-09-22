<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Foto;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\User;
use Hash;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class PublicController extends Controller
{
    use WithPagination;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('is_admin');
    }
    public $searchTerm;
    public $currentPage = 1;

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['title'] = 'Landing';
        $this->data['page'] = 'Landing';

        $barang = Barang::select('*')->get();
        foreach($barang as $row) {
            $row->qty = PenjualanDetail::select('qty')->where('id_barang', $row->id)->sum('qty');
            $f = Foto::select('*')
            ->where('id_barang', $row->id)
            ->orderBy('status', 'ASC')->first();
            if(!empty($f)) {
                $row->foto = $f->file;
            } else {

                $row->foto = 'default.png';
            }
        }
        $barang = $barang->toArray();
        array_multisort(array_column($barang, 'qty'), SORT_DESC, $barang);

        $this->data['produk'] = array_slice($barang, 0, 8);
        return view('landing.index', $this->data);
    }

    public function produk()
    {
        $this->data['page'] = 'Produk';
        $this->data['produk'] = $this->load_barang();
        return view('landing.produk', $this->data);
    }

    public function detail_produk($id)
    {
        $this->data['page'] = 'Produk';
        $this->data['produk'] = Barang::find($id);
        return view('landing.detail', $this->data);
    }

    public function load_barang()
    {
        $query = '%' . $this->searchTerm . '%';
        $data = Barang::where(function ($sub_query) {
            $sub_query->where('nama', 'like', '%' . $this->searchTerm . '%');
        })->Paginate(20);
        return $data;
    }

    public function daftar(Request $request)
    {
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'level' => $request->level
        ]);

        return redirect(route('login'));
    }
}
