<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Auth;

use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_pegawai');
        $this->page = 'pegawai/pengguna';
    }

    public function index()
    {
        $this->data['title'] = 'Profil '.Auth::user()->name;
        $this->data[ 'link' ] = '/pegawai/pengguna/update';
        $this->page = 'pegawai/pengguna';
        $this->view = 'pegawai/pengguna/index';
        $this->data['load'] = User::find(Auth::user()->id);
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function update(Request $request)
    {
        $this->data['title'] = 'Profil '.Auth::user()->name;

        $this->buat_notif('Update '.strtolower($this->data['title']), 'mdi-account-edit', 'success');

        $rows = User::find(Auth::user()->id);
        if($request->password == true) {
            $rows->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $request->level,
                'update_at' => now()
             ]);
        } else {
            $rows->update([
                'name' => $request->name,
                'email' => $request->email,
                'level' => $request->level,
                'update_at' => now()
             ]);
        }

        return redirect($this->page);

    }

}
