<?php

namespace App\Http\Controllers;

use App\Charts\AngkatanChart;
use App\Http\Controllers\Controller;
use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AngkatanChart $angkatanChart)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 5;
        if (strlen($katakunci)) {
        $data = mahasiswa::where('nim','like',"%$katakunci%")
                        ->orWhere('nama','like',"%$katakunci%")
                        ->orWhere('angkatan','like',"%$katakunci%")
                        ->orWhere('jurusan','like',"%$katakunci%")
                        ->paginate($jumlahbaris);
        } else {
            $data = mahasiswa::orderBy('nim','desc')->paginate($jumlahbaris);
        }
        return view('mahasiswa.index', [
            'data' => $data,
            'angkatanChart' => $angkatanChart->build()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    Session::flash('nim', $request->nim);
    Session::flash('nama', $request->nama);
    Session::flash('angkatan', $request->angkatan);
    Session::flash('jurusan', $request->jurusan);

    $request->validate([
        'nim' => 'required|numeric|unique:mahasiswa,nim',
        'nama' => 'required',
        'angkatan' => 'required',
        'jurusan' => 'required',
    ], [
        'nim.required' => 'NIM wajib diisi',
        'nim.numeric' => 'NIM wajib dalam angka',
        'nim.unique' => 'NIM yang diisikan sudah ada dalam database',
        'nama.required' => 'Nama wajib diisi',
        'angkatan.required' => 'Angkatan wajib diisi',
        'jurusan.required' => 'Jurusan wajib diisi',
    ]);

    $data = [
        'nim' => $request->nim,
        'nama' => $request->nama,
        'angkatan' => $request->angkatan,
        'jurusan' => $request->jurusan,
    ];
    mahasiswa::create($data);

    return redirect()->route('mahasiswa.index')->with('success', 'Berhasil menambahkan data');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = mahasiswa::where('nim',$id)->first();
        return view('mahasiswa.edit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'=>'required',
            'angkatan'=>'required',
            'jurusan'=>'required',
        ],[
            'nama.required'=>'Nama wajib diisi',
            'angkatan.required'=>'Angkatan wajib diisi',
            'jurusan.required'=>'Jurusan wajib diisi',
        ]);
        $data = [
            'nama'=>$request->nama,
            'angkatan'=>$request->angkatan,
            'jurusan'=>$request->jurusan,
        ];
        mahasiswa::where('nim', $id)->update($data);
        return redirect()->to('mahasiswa')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        mahasiswa::where('nim', $id)->delete();
        return redirect()->to('mahasiswa')->with('success', 'Berhasil melakukan delete data');
    }
}
