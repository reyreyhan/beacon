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
                if ($row->tolIn == '32:AE:A4:07:0D:66') {
                    $tolMasuk = 'Surabaya';
                } else {
                    $tolMasuk = 'Sidoarjo';
                }
                return $tolMasuk;
            })
            ->addColumn('tolKeluar', function($row){
                if ($row->tolIn == '32:AE:A4:07:0D:66') {
                    $tolKeluar = 'Gresik';
                } else {
                    $tolKeluar = 'Waru';
                }

                return $tolKeluar;
            })
            ->editColumn('price', function ($row) {
                if ($row->tolIn == '32:AE:A4:07:0D:66') {
                    $price = 8000;
                } else {
                    $price = 5000;
                }

                return $price;
            })
            ->addColumn('user', function($row){

                if ($row->beacon == "ac:23:3f:23:5a:e0/" || $row->beacon == "ac:23:3f:23:5a:e0") {
                    $user = 'Titis Jiyan';
                } else if ($row->beacon == "ac:23:3f:24:9f:b5/" || $row->beacon == "ac:23:3f:24:9f:b5") {
                    $user = 'Reyhan Alphard';
                } else {
                    $user = 'Ki Suki';
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
