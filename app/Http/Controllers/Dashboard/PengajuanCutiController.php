<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use App\Models\PengajuanCuti;
use App\Models\Setting;
use Carbon\Carbon;
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
        // if ($request->ajax()) {
        //     $data = PengajuanCuti::with('user', 'jenisCuti')->get();
        //     return DataTables::of($data)
        //         ->make(true);
        // }
        $cutis = PengajuanCuti::with('user', 'jenisCuti')->get();
        return view('dashboard.pengajuan-cuti.report', compact('cutis'));
    }

    public function cetak($id)
    {
        $data = PengajuanCuti::with('user', 'jenisCuti')->where('id', $id)->first();
        $jumlahCutiTahunan = PengajuanCuti::where('user_id', $data->user->id)
            ->whereHas('jenisCuti', function ($query) {
                $query->where('jenis_cuti', 'Cuti Tahunan');
            })
            ->count();

        // Jika cuti tahunan sudah diambil lebih dari 12 kali, tampilkan 0
        $jumlahCutiTahunanTerbatas = $jumlahCutiTahunan >= 12 ? 0 : $jumlahCutiTahunan;
        $setting = Setting::first();


        $tanggalMulai = Carbon::parse($data->tanggal_mulai_cuti);
        $tanggalSelesai = Carbon::parse($data->tanggal_selesai_cuti);
        $jumlahHariCuti = $tanggalMulai->diffInDays($tanggalSelesai) + 1;
        // dd($jumlahHariCuti);

        // Simbol untuk centang dan kosong
        $checked = '√';
        $unchecked = '';

        // Tentukan jenis cuti yang diceklis berdasarkan data yang diambil
        $cuti_tahunan = $data->jenisCuti->jenis_cuti === 'cuti tahunan' ? $checked : $unchecked;
        $cuti_besar = $data->jenisCuti->jenis_cuti === 'cuti besar' ? $checked : $unchecked;
        $cuti_sakit = $data->jenisCuti->jenis_cuti === 'cuti sakit' ? $checked : $unchecked;
        $cuti_melahirkan = $data->jenisCuti->jenis_cuti === 'cuti melahirkan' ? $checked : $unchecked;
        $cuti_alasan_penting = $data->jenisCuti->jenis_cuti === 'cuti karena alasan penting' ? $checked : $unchecked;
        $cuti_luar_negara = $data->jenisCuti->jenis_cuti === 'cuti diluar tanggungan negara' ? $checked : $unchecked;

        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('template-new.docx');
        $phpWord->setValues([
            'nama_instansi' => $setting->nama_instansi,
            'alamat_instansi' => $setting->alamta_instansi,
            'kode_pos' => $setting->kode_pos,
            'no_telp' => $setting->no_telp,
            'faks' => $setting->faks,
            'email' => $setting->email,
            'laman_web' => $setting->laman_web,
            'nama' => $data->user->name,
            'nip' => $data->user->nip,
            'pangkat' => $data->user->pangkat,
            'jabatan' => $data->user->jabatan,
            'alasan_cuti' => $data->alasan_cuti,
            'lama_cuti' => $jumlahHariCuti,
            'tanggal_mulai_cuti' => Carbon::parse($data->tanggal_mulai_cuti)->translatedFormat('j F Y'),
            'tanggal_keluar_surat' => Carbon::now()->translatedFormat('j F Y'),
            'cuti tahunan' => $cuti_tahunan,
            'cuti besar' => $cuti_besar,
            'cuti sakit' => $cuti_sakit, 
            'cuti melahirkan' => $cuti_melahirkan, 
            'cuti alasan penting' => $cuti_alasan_penting, 
            'cuti diluar tangunggan negara' => $cuti_luar_negara,
            'jumlah_cuti_tahunan' => $jumlahCutiTahunanTerbatas,
        ]);
        // Path to save the file
        $filePath = storage_path('app/SuratCuti_' . $data->user->name . '.docx');
        $phpWord->saveAs($filePath);


        // Return response to download the file
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
