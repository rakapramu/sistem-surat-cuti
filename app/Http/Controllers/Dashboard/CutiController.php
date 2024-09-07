<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = JenisCuti::paginate(10);
        return view('dashboard.cuti.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.cuti.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti' => 'required|unique:jenis_cutis'
        ]);
        JenisCuti::create($request->all());
        return redirect()->route('cuti.index');
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
    public function edit(JenisCuti $cuti)
    {
        return view('dashboard.cuti.edit', compact('cuti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisCuti $cuti)
    {
        $request->validate([
            'jenis_cuti' => 'required|unique:jenis_cutis'
        ]);
        $cuti->update($request->all());
        return redirect()->route('cuti.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisCuti $cuti)
    {
        $cuti->delete();
        return redirect()->route('cuti.index');
    }
}
