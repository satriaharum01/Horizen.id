<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use File;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class HistoryController extends Controller
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

        $this->data['title'] = 'Log Aktivitas';
        $this->page = '/admin/history';
        $this->view = 'admin/history/index';
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
        Notif::where('status', 'wait')->update(['status' => 'read']);
        $data = Notif::select('*')
            ->get();

        foreach ($data as $row) {
            $row->timestamp = date('d F Y h:i:s', strtotime($row->created_at));
            $row->akun = $row->cari_user->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

}
