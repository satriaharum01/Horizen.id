<?php

namespace App\Http\Livewire;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Foto;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class Produk extends Component
{
    use WithPagination;

    public $searchTerm;
    public $selectcat;
    public $currentPage = 1;
    public $title = 'Produk';

    private $bulan = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    );
    public $data = array();

    private $hari = array(
        '1' => 'Senin',
        '2' => 'Selasa',
        '3' => 'Rabu',
        '4' => 'Kamis',
        '5' => "Jum'at",
        '6' => 'Sabtu',
        '7' => 'Minggu'
    );

    public function render()
    {
        $query = '%' . $this->searchTerm . '%';
        $data = Barang::where(function ($sub_query) {
            if($this->selectcat != '') {
                $sub_query->where('id_kategori', $this->selectcat)->where('nama', 'like', '%' . $this->searchTerm . '%');
            } else {
                $sub_query->where('nama', 'like', '%' . $this->searchTerm . '%');
            }
        })->Paginate(12);
        $cat = Kategori::select('*')->get('*');
        foreach($cat as $row) {
            $row->count = Barang::select('*')->where('id_kategori', $row->id)->count();
        }
        foreach($data as $row) {
            $f = Foto::select('*')
            ->where('id_barang', $row->id)
            ->orderBy('status', 'ASC')->first();
            if(!empty($f)) {
                $row->foto = $f->file;
            } else {

                $row->foto = 'default.png';
            }
        }
        $this->data['produk'] = $data;
        $this->data['kategori'] = $cat;
        $this->data['selectcat'] = $this->selectcat;
        $this->data['counter'] = $data->count();
        return view('livewire.produk', $this->data);
    }

    public function setCat($number)
    {
        if($number == 0) {
            $this->selectcat = '';
        } else {
            $this->selectcat = $number;
        }
        return $this->selectcat;
    }

    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }
}
