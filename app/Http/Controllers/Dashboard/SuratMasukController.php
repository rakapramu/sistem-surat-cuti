<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PengajuanAtasan;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    public function index()
    {
        // jika keberatan, bisa saya pangkas lagi harganya
        $approvals = PengajuanAtasan::with('leaveRequest', 'leaveRequest.user')
            ->where('user_id', Auth::user()->id)
            ->where('status', 'diproses')
            ->paginate(10);
        return view('dashboard.surat-masuk.index', compact('approvals'));
    }

    public function updateStatus(Request $request, PengajuanAtasan $pengajuanCuti)
    {
        // Update status di PengajuanAtasan
        $pengajuanCuti->update([
            'status' => $request->status,
        ]);

        // Ambil data PengajuanCuti berdasarkan pengajuan_id
        $dataAjuanCuti = PengajuanCuti::where('id', $pengajuanCuti->pengajuan_id)->first();

        if ($dataAjuanCuti) {
            // Hitung jumlah status disetujui (misalnya kode status 3)
            $totalStatusDisetujui = PengajuanAtasan::where('pengajuan_id', $dataAjuanCuti->id)
                ->where('status', 'disetujui') // Asumsi bahwa 3 adalah status disetujui
                ->count();

            // Hitung jumlah status ditolak (misalnya kode status 2)
            $totalStatusDitolak = PengajuanAtasan::where('pengajuan_id', $dataAjuanCuti->id)
                ->where('status', 'ditolak') // Asumsi bahwa 2 adalah status ditolak
                ->count();

            // Hitung total atasan yang terlibat
            $totalAtasan = PengajuanAtasan::where('pengajuan_id', $dataAjuanCuti->id)->count();

            if ($totalStatusDitolak > 0) {
                // Jika ada satu atau lebih atasan yang menolak, ubah status pengajuan cuti menjadi 'ditolak'
                $dataAjuanCuti->update([
                    'status' => 'ditolak',
                ]);
            } elseif ($totalStatusDisetujui === $totalAtasan) {
                // Jika semua atasan menyetujui, ubah status pengajuan cuti menjadi 'disetujui'
                $dataAjuanCuti->update([
                    'status' => 'disetujui',
                ]);
            } else {
                $dataAjuanCuti->update([
                    'status' => 'diproses',
                ]);
            }
        }

        return response('ok', 200);
    }
}
