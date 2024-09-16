<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DivisiHead;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Setting::get();
        return view('dashboard.setting.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.setting.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_instansi' => 'required',
            'alamta_instansi' => 'required',
            'email' => 'required|unique:users',
            'no_telp' => 'required',
            'laman_web' => 'required',
            'kode_pos' => 'required',
            'faks' => 'required',
            'satuan_organisasi' => 'required',
            'nama_pimpinan' => 'required',
            'jabatan_pimpinan' => 'required',
            'nip_jabatan' => 'required',
            'email_setting' => 'required'
        ]);
        $nama_instansi = strtoupper($request->nama_instansi);
        $nama_pimpinan = ucwords($request->nama_pimpinan);
        $jabatan_pimpinan = ucwords($request->jabatan_pimpinan);
        $user = User::create([
            'name' => $nama_pimpinan,
            'email' => $request->email,
            'password' => $request->nip_jabatan,
            'nip' => $request->nip_jabatan,
            'jabatan' => $jabatan_pimpinan,
            'role' => 'atasan'
        ]);
        Setting::create([
            'nama_instansi' => $nama_instansi,
            'alamta_instansi' => $request->alamta_instansi,
            'email' => $request->email_setting,
            'no_telp' => $request->no_telp,
            'laman_web' => $request->laman_web,
            'kode_pos' => $request->kode_pos,
            'faks' => $request->faks,
            'satuan_organisasi' => $request->satuan_organisasi,
            'nama_pimpinan' => $nama_pimpinan,
            'jabatan_pimpinan' => $jabatan_pimpinan,
            'nip_jabatan' => $request->nip_jabatan
        ]);
        return redirect()->route('setting.index');
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
    public function edit(Setting $setting)
    {
        return view('dashboard.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'nama_instansi' => 'required',
            'alamta_instansi' => 'required',
            'email' => 'required',
            'no_telp' => 'required',
            'laman_web' => 'required',
            'kode_pos' => 'required',
            'faks' => 'required',
            'satuan_organisasi' => 'required',
            'nama_pimpinan' => 'required',
            'jabatan_pimpinan' => 'required',
            'nip_jabatan' => 'required'
        ]);
        $nama_instansi = strtoupper($request->nama_instansi);
        $nama_pimpinan = ucwords($request->nama_pimpinan);
        $jabatan_pimpinan = ucwords($request->jabatan_pimpinan);
        $setting->update([
            'nama_instansi' => $nama_instansi,
            'alamta_instansi' => $request->alamta_instansi,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'laman_web' => $request->laman_web,
            'kode_pos' => $request->kode_pos,
            'faks' => $request->faks,
            'satuan_organisasi' => $request->satuan_organisasi,
            'nama_pimpinan' => $nama_pimpinan,
            'jabatan_pimpinan' => $jabatan_pimpinan,
            'nip_jabatan' => $request->nip_jabatan
        ]);
        return redirect()->route('setting.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('setting.index');
    }
}
