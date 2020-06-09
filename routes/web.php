<?php

use Illuminate\Support\Facades\Route;
use App\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    if ($request->ajax()) {
        $data = Transaction::latest()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('tolMasuk', function($row){
                $tolMasuk = 'Sidoarjo';
                return $tolMasuk;
            })
            ->addColumn('tolKeluar', function($row){
                $tolKeluar = 'Waru';
                return $tolKeluar;
            })
            ->addColumn('user', function($row){

                if ($row->beacon == "df:05:94:2a:05:e7/" || $row->beacon == "df:05:94:2a:05:e7") {
                    $user = 'Titis Jiyan';
                } else {
                    $user = 'Reyhan Alphard';
                }

                return $user;
            })
            ->editColumn('created_at', function($row) {
                $row = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d-m-Y H:i:s');
                return $row;
            })
            ->make(true);
    }
    return view('transaction');
})->name('transaction');
