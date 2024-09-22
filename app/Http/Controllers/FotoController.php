<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Foto;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\User;

use File;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class FotoController extends Controller
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

        $this->data[ 'title' ] = 'Gallery Foto Barang';
        $this->data[ 'link' ] = '/admin/data/sertifikat';
        $this->data['path'] = url('images/product_images');
        $this->page = '/admin/data/gallery';
        $this->data['page'] = $this->page;
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('admin/data/gallery', $this->data);
    }

    public function detail($id)
    {
        $load = Barang::find($id);
        $this->data['load'] = $load;
        $this->data[ 'title' ] = 'Gallery Foto '.$load->nama;
        $this->page = '/admin/data/gallery/detail/'.$id;
        $this->data['page'] = $this->page;
        $this->data['link'] = '/admin/data/gallery';
        return view('admin/data/detail/d_gallery', $this->data);
    }

    public function json()
    {
        $data = Barang::select('*')
            ->orderBy('id', 'ASC')
            ->get();

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

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_detail($id)
    {
        $data = Foto::select('*')
            ->where('id_barang', $id)
            ->orderBy('status', 'ASC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {

        $this->buat_notif('Update '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');
        $rows = Foto::find($id);
        $file = $request->file('gambar');
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = 'images-'. $id . $ext;
            $this->image_destroy($filename);
            $file->storeAs('/', $filename, ['disk' => 'image_upload']);
        }
        $data = [
            'status' => $request->status,
            'id_barang' => $request->id_barang,
            'file' => $filename
        ];
        $rows->update($data);

        return redirect($this->page);
    }

    public function update_detail(Request $request, $od, $id)
    {
        $this->buat_notif('Update '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');

        $rows = Foto::find($id);
        $file = $request->file('gambar');
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = 'images-'. $id . $ext;
            $this->image_destroy($filename);
            $file->storeAs('/', $filename, ['disk' => 'image_upload']);
        }
        $data = [
            'status' => $request->status,
            'id_barang' => $request->id_barang,
            'file' => $filename
        ];
        $rows->update($data);

        return redirect(url('/admin/data/gallery/detail/'.$od));
    }
    public function store(Request $request)
    {
        $this->buat_notif('Tambah '.strtolower($this->data['title']), 'mdi-plus', 'primary');

        $file = $request->file('gambar');
        $max = Foto::select('*')->max('id');
        $id = $max + 1;
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = 'images-'. $id . '.jpg';
            $this->image_destroy($filename);
            $file->storeAs('/', $filename, ['disk' => 'image_upload']);
        }
        $data = [
            'status' => $request->status,
            'id_barang' => $request->id_barang,
            'file' => $filename
        ];

        Foto::create($data);

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $this->buat_notif('Hapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');

        $rows = Foto::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }

    public function destroy_detail($od, $id)
    {
        $this->buat_notif('Hapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');

        $rows = Foto::findOrFail($id);
        $rows->delete();

        return redirect(url('/admin/data/gallery/detail/'.$od));
    }

    public function find($id)
    {
        $data = Foto::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }

    public function image_destroy($filename)
    {
        if (File::exists(public_path('/image/product_images/' . $filename . ''))) {
            File::delete(public_path('/image/product_images/' . $filename . ''));
        }
    }
}
