<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DivisiHead;
use App\Models\JenisCuti;
use App\Models\PengajuanAtasan;
use App\Models\PengajuanCuti;
use App\Models\Setting;
use App\Models\User;
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
        // Ambil semua pengajuan cuti milik user yang sedang login
        $cutis = PengajuanCuti::where('user_id', Auth::user()->id)
            ->with('pengajuanAtasan') // Load approval terkait
            ->paginate(10);

        // Update status akhir pengajuan cuti
        foreach ($cutis as $cuti) {
            $approvals = $cuti->pengajuanAtasan;
            $pengajuanAtasan = $approvals;

            // Jika salah satu atasan menolak, set status menjadi 'rejected'
            if ($pengajuanAtasan->where('status', 'ditolak')->count() > 0) {
                $cuti->status = 'ditolak';
            }
            // Jika semua atasan setuju, set status menjadi 'approved'
            elseif ($pengajuanAtasan->where('status', 'disetujui')->count() === 3) {
                $cuti->status = 'disetujui';
            } else {
                // Jika masih ada persetujuan yang pending, tetap 'pending'
                $cuti->status = 'diproses';
            }

            // Simpan perubahan status cuti
            $cuti->save();
        }

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
        $pengajuan = PengajuanCuti::create([
            'cuti_id' => $request->cuti_id,
            'tanggal_mulai_cuti' => $request->tanggal_mulai_cuti,
            'tanggal_selesai_cuti' => $request->tanggal_selesai_cuti,
            'alasan_cuti' => $request->alasan_cuti,
            'user_id' => Auth::user()->id
        ]);
        $divisionId = Auth::user()->divisi_id;
        $divisionHeads = DivisiHead::where('divisi_id', $divisionId)->get();

        $kepalaDinas = Setting::first();
        $dataKepalaDinas = User::where('nip', $kepalaDinas->nip_jabatan)->first();
        PengajuanAtasan::create([
            'pengajuan_id' => $pengajuan->id,
            'user_id' => $dataKepalaDinas->id,  // ID kepala dinas
            'status' => 'diproses',
        ]);

        // Simpan persetujuan untuk setiap atasan di tabel `approvals`
        foreach ($divisionHeads as $head) {
            PengajuanAtasan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id' => $head->user_id,  // ID atasan
                'status' => 'diproses',
            ]);
        }
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
        $jumlahCutiTahunanTerbatas = 0;
        if ($data->jenisCuti->jenis_cuti === 'cuti tahunan') {
            if ($jumlahCutiTahunan >= 12) {
                $jumlahCutiTahunanTerbatas = 0;
            } elseif ($jumlahCutiTahunan === 0) {
                $jumlahCutiTahunanTerbatas = 12;
            } else {
                $jumlahCutiTahunanTerbatas = 12 - $jumlahCutiTahunan;
            }
        }
        $setting = Setting::first();
        $sisaSatu = 0;
        $sisaDua = 0;
        if ($jumlahCutiTahunanTerbatas != 0) {
            $sisaSatu = $jumlahCutiTahunanTerbatas - 1;
            $sisaDua = $sisaSatu - 1;
        }

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

        // create format date now to 10-August-2024
        $date = Carbon::now()->locale('id')->isoFormat('D MMMM YYYY');

        // Ambil data atasan berdasarkan pengajuan_id
        $data_atasan = PengajuanAtasan::where('pengajuan_id', $data->id)->get();

        // Inisialisasi array untuk menyimpan divisi head
        $divisi_heads = [];

        foreach ($data_atasan as $key => $item) {
            // Ambil data DivisiHead berdasarkan user_id dari $item
            $divisi_head = DivisiHead::where('user_id', $item->user_id)->first();

            // Simpan divisi_head ke dalam array dengan user_id sebagai key
            if ($divisi_head) {
                $divisi_heads[$key] = $divisi_head;
            }
        }

        $atasan1 = $divisi_heads[1] ?? null;
        $atasan2 = $divisi_heads[2] ?? null;


        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('template-new-lagi.docx');
        $phpWord->setValues([
            'nama_instansi' => $setting->nama_instansi,
            'date' => $date,
            'alamat_instansi' => $setting->alamta_instansi,
            'satuan_organisasi' => $setting->satuan_organisasi,
            'nama_pimpinan' => $setting->nama_pimpinan,
            'jabatan_pimpinan' => $setting->jabatan_pimpinan,
            'nip_jabatan' => $setting->nip_jabatan,
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
            'atasan1' => $atasan1->user->name,
            'jabatan_atasan1' => $atasan1->user->jabatan,
            'nip_atasan1' => $atasan1->user->nip,
            'atasan2' => $atasan2->user->name,
            'jabatan_atasan2' => $atasan2->user->jabatan,
            'nip_atasan2' => $atasan2->user->nip,
            'sisa_satu' => $sisaSatu,
            'sisa_dua' => $sisaDua,
        ]);
        // Bersihkan karakter yang tidak diizinkan dari nama file
        // $safeFileName = preg_replace('/[^A-Za-z0-9\-]/', '-', str_replace(' ', '-', $data->user->name));

        $safeFileName = explode(' ', $data->user->name)[0];
        // Path file
        $filePath = storage_path('app/SuratCuti_' . $safeFileName . '.docx');
        $phpWord->saveAs($filePath);


        // Return response to download the file
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
