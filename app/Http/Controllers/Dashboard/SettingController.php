<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
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
        $request->validate([
            'nama_instansi' => 'required',
            'alamta_instansi' => 'required',
            'email' => 'required',
            'no_telp' => 'required',
            'laman_web' => 'required',
            'kode_pos' => 'required',
            'faks' => 'required'
        ]);
        Setting::create($request->all());
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
            'faks' => 'required'
        ]);
        $setting->update($request->all());
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
