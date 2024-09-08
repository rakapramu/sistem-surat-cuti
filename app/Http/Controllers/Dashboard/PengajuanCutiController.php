<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PengajuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $cutis = JenisCuti::get();
        $cutis = PengajuanCuti::where('user_id', Auth::user()->id)->paginate(10);
        return view('dashboard.pengajuan-cuti.index', compact('cutis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cutis = JenisCuti::get();
        return view('dashboard.pengajuan-cuti.create', compact('cutis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cuti_id' => 'required',
            'tanggal_mulai_cuti' => 'required',
            'tanggal_selesai_cuti' => 'required',
            'alasan_cuti' => 'required'
        ]);
        PengajuanCuti::create([
            'cuti_id' => $request->cuti_id,
            'tanggal_mulai_cuti' => $request->tanggal_mulai_cuti,
            'tanggal_selesai_cuti' => $request->tanggal_selesai_cuti,
            'alasan_cuti' => $request->alasan_cuti,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('pengajuan_cuti.index');
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
    public function edit(PengajuanCuti $pengajuan_cuti)
    {
        $cutis = JenisCuti::get();
        return view('dashboard.pengajuan-cuti.edit', compact('pengajuan_cuti', 'cutis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanCuti $pengajuan_cuti)
    {
        $request->validate([
            'cuti_id' => 'required',
            'tanggal_mulai_cuti' => 'required',
            'tanggal_selesai_cuti' => 'required',
            'alasan_cuti' => 'required'
        ]);
        $pengajuan_cuti->update([
            'cuti_id' => $request->cuti_id,
            'tanggal_mulai_cuti' => $request->tanggal_mulai_cuti,
            'tanggal_selesai_cuti' => $request->tanggal_selesai_cuti,
            'alasan_cuti' => $request->alasan_cuti
        ]);
        return redirect()->route('pengajuan_cuti.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanCuti $pengajuan_cuti)
    {
        $pengajuan_cuti->delete();
        return redirect()->route('pengajuan_cuti.index');
    }

    public function riwayat()
    {
        $cutis = PengajuanCuti::get();
        return view('dashboard.pengajuan-cuti.riwayat', compact('cutis'));
    }
    public function updateStatus(Request $request, PengajuanCuti $pengajuanCuti)
    {
        if ($pengajuanCuti) {
            $pengajuanCuti->status = $request->input('status');
            $pengajuanCuti->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Item not found.'], 404);
    }

    public function report(Request $request)
    {
        if ($request->ajax()) {
            $data = PengajuanCuti::with('user', 'jenisCuti')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('dashboard.pengajuan-cuti.report');
    }
}
