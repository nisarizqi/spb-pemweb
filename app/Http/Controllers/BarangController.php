<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     private $id_unit;

     public function __construct()
     {
         if (auth()->check()) {
             echo '<script>console.log(authenticated!)</script>';
             $usr = auth()->user();
             $id_unit = DB::table('adminunit')->where('adminunit.id_user', $usr->id)->select('adminunit.id_unit')->first();
             $this->id_unit = $id_unit->id_unit;
         }
     }
     
    
    public function index()
    {
        // $id_unit = DB::table('adminunit')->where('id_user', $id)->select('adminunit.id_unit');
        // $usr = auth()->user();
        // $id_unit = DB::table('adminunit')->where('adminunit.id_user', $usr->id)->select('adminunit.id_unit')->first();
        // $this->id_unit = $id_unit->id_unit;
        $usr = auth()->user();
        $id_unit = DB::table('adminunit')->where('adminunit.id_user', $usr->id)->select('adminunit.id_unit')->first();
        $this->id_unit = $id_unit->id_unit;
        $barang = DB::table('barang')->join('kategori', 'barang.id_kategori', '=', 'kategori.id')->leftJoin('detailbarang', 'detailbarang.id_barang', '=', 'barang.id')->where('barang.id_unit', $this->id_unit)->select('barang.*', 'kategori.nama', 'detailbarang.id as id_detail', 'detailbarang.detail', 'detailbarang.gambar')->get();
        return view('adminunit.barang.index', ['barang' => $barang]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('adminunit.barang.create', ['kategori' => $kategori, 'id_unit' => $this->id_unit]);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usr = auth()->user();
        $id_unit = DB::table('adminunit')->where('adminunit.id_user', $usr->id)->select('adminunit.id_unit')->first();
        $id_unit = $id_unit->id_unit;
        $validateData = $request->validate([
            'nama_barang' => 'required|max:255',
            'merk' => 'required|max:255',
            'serial_number' => 'required|max:255|unique:barang',
            'deskripsi' => 'required|max:255',
            'detail' => 'max:255',
            'gambar' => 'image',
            'kategori' => 'required',
            'status_barang' => 'required',
        ]);

        if ($request->hasFile('gambar')) {
            // Store the uploaded image file
            $gambar = $request->file('gambar')->store('gambar-barang');
        }

        DB::table('barang')->insert([
            'nama_barang' => $validateData['nama_barang'],
            'merk' => $validateData['merk'],
            'serial_number' => $validateData['serial_number'],
            'deskripsi' => $validateData['deskripsi'],
            'status_barang' => $validateData['status_barang'],
            'id_unit' => $id_unit,
            'id_kategori' => $validateData['kategori']
        ]);

        $id_kategori = $request->kategori;

        $conditions = ['nama_barang' => $validateData['nama_barang'], 'serial_number' => $validateData['serial_number'], 'id_unit' => $id_unit, 'id_kategori' => $id_kategori];

        $data = DB::table('barang')->where($conditions)->first();
        // DB::enableQueryLog();
        // $queries = DB::getQueryLog();
        // $que = end($queries);
        // ddd($queries);
        // ddd($data);
        $id = $data->id;

        if($validateData['detail'] || $request->hasFile('gambar')){
            $detail = ['id_barang' => $id];

            if (isset($gambar)) {
                $detail['gambar'] = $gambar;
            }

            if ($validateData['detail'] ) {
                $detail['detail'] = $validateData['detail'] ;
            }

            DB::table('detailbarang')
            ->insert($detail);
        }
        // elseif(!$validateData['detail'] && $validateData['gambar']){
        //     DB::table('detailbarang')->insert([
        //         'gambar' => $validateData['gambar'],
        //         'id_barang' => $id
        //     ]);
        // }elseif($validateData['detail'] && !$validateData['gambar']){
        //     DB::table('detailbarang')->insert([
        //         'detail' => $validateData['detail'],
        //         'id_barang' => $id
        //     ]);
        // }
        
        return redirect('/adminunit/barang');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_barang)
    {
        $usr = auth()->user();
        $id_unit = DB::table('adminunit')->where('adminunit.id_user', $usr->id)->select('adminunit.id_unit')->first();
        $this->id_unit = $id_unit->id_unit;
        $whereClause = ['barang.id_unit' => $this->id_unit, 'barang.id' => $id_barang];
        $barang = DB::table('barang')->join('kategori', 'barang.id_kategori', '=', 'kategori.id')->leftJoin('detailbarang', 'barang.id', '=', 'detailbarang.id_barang')->where($whereClause)->select('barang.*', 'kategori.nama', 'detailbarang.id as id_detail', 'detailbarang.detail', 'detailbarang.gambar')->first();
        $kategori = Kategori::all();
        return view('adminunit.barang.edit', ['barang' => $barang, 'kategori' => $kategori, 'id_unit' => $this->id_unit]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $usr = auth()->user();
        $id_unit = DB::table('adminunit')->where('adminunit.id_user', $usr->id)->select('adminunit.id_unit')->first();
        $id_unit = $id_unit->id_unit;
        
        // Validate the request data
        $validateData = $request->validate([
            'nama_barang' => 'required|max:255',
            'merk' => 'required|max:255',
            'serial_number' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'detail' => 'max:255',
            'kategori' => 'required',
            'status_barang' => 'required',
        ]);
    
        if ($request->hasFile('gambar')) {
            // Store the uploaded image file
            $gambar = $request->file('gambar')->store('gambar-barang');
        }
    
        // Update the 'barang' table using the validated data
        DB::table('barang')
            ->where('id', $request->id_barang)
            ->update([
                'nama_barang' => $validateData['nama_barang'],
                'merk' => $validateData['merk'],
                'serial_number' => $validateData['serial_number'],
                'deskripsi' => $validateData['deskripsi'],
                'status_barang' => $validateData['status_barang'],
                'id_unit' => $id_unit,
                'id_kategori' => $validateData['kategori']
            ]);
    
        // Update the 'detailbarang' table if 'id_detail' is available
        if ($request->id_detail) {
            $detail = [];
            if($validateData['detail']){
                $detail['detail'] = $validateData['detail'];
            }
    
            // Update the 'gambar' field if it's available
            if (isset($gambar)) {
                $detail['gambar'] = $gambar;
            }
    
            if(isset($detail['detail']) || isset($detail['gambar'])){
                DB::table('detailbarang')
                ->where('id', $request->id_detail)
                ->update($detail);
            }
        }else{
            $detail = [];
            if($validateData['detail']){
                $detail['detail'] = $validateData['detail'];
            }
    
            // Update the 'gambar' field if it's available
            if (isset($gambar)) {
                $detail['gambar'] = $gambar;
            }
    
            if(isset($detail['detail']) || isset($detail['gambar'])){
                DB::table('detailbarang')
                ->insert($detail);
            }
        }
        
        return redirect('/adminunit/barang');
    }
    public function hapus($id_barang)
    {
    DB::table('barang')->where('id',$id_barang)->delete();
    return redirect('/adminunit/barang');
    }

    public function getData()
    {
        $usr = auth()->user();
        $id_unit = DB::table('adminunit')->where('adminunit.id_user', $usr->id)->select('adminunit.id_unit')->first();
        $id_unit = $id_unit->id_unit;
        
        $data = DB::table('barang')->where('id_unit', $id_unit)->select('barang.status_barang')->get(); // Retrieve data from the 'data' table

        $available = 0;
        $in_use = 0;
        $broken = 0;

        foreach ($data as $item) {
            if ($item->status_barang === 'available') {
                $available++;
            }else if ($item->status_barang === 'in use') {
                $in_use++;
            }else if ($item->status_barang === 'broken') {
                $broken++;
            }
        }

        $status = [
            'available' => $available,
            'in_use' => $in_use,
            'broken' => $broken,
        ];

        return response()->json($status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        //
    }
}
