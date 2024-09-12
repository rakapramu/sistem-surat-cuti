<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\DivisiHead;
use App\Models\User;
use Illuminate\Http\Request;

class DivisiHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = DivisiHead::get();
        return view('dashboard.divisi-head.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisi = Divisi::get();
        return view('dashboard.divisi-head.create', compact('divisi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required',
            'pangkat' => 'required',
            'jabatan' => 'required',
            'divisi_id' => 'required|exists:divisis,id',
            'level' => 'required|integer|in:1,2',
        ]);

        try {
            // Buat user baru (atasan)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'pangkat' => $request->pangkat,
                'jabatan' => $request->jabatan,
                'nip' => $request->nip,
                'password' => $request->nip,
                'role' => 'atasan',
                'divisi_id' => $request->divisi_id,
            ]);

            // Cek apakah level atasan untuk divisi tersebut sudah ada
            $existingHead = DivisiHead::where('divisi_id', $request->divisi_id)
                ->where('level', $request->level)
                ->first();

            if ($existingHead) {
                return back()->withErrors(['Atasan untuk level ini sudah ada.']);
            }

            // Simpan data atasan ke tabel division_heads
            DivisiHead::create([
                'divisi_id' => $request->divisi_id,
                'level' => $request->level,
                'user_id' => $user->id,
            ]);

            return redirect()->route('divisi-head.index')->with('success', 'Atasan dan user berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DivisiHead $divisiHead)
    {
        return view('dashboard.divisi-head.edit', compact('divisiHead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DivisiHead $divisiHead)
    {
        $divisi = Divisi::get();
        return view('dashboard.divisi-head.edit', compact('divisiHead', 'divisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DivisiHead $divisiHead)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|sometimes',
            'nip' => 'required',
            'pangkat' => 'required',
            'jabatan' => 'required',
            'divisi_id' => 'required|exists:divisis,id',
            'level' => 'required|integer|in:1,2',
        ]);

        try {
            // update user
            $user = User::find($divisiHead->user_id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'pangkat' => $request->pangkat,
                'jabatan' => $request->jabatan,
                'nip' => $request->nip,
                'divisi_id' => $request->divisi_id,
            ]);

            $divisiHead->update([
                'level' => $request->level,
                'divisi_id' => $request->divisi_id,
                'user_id' => $divisiHead->user_id,
            ]);
            return redirect()->route('divisi-head.index')->with('success', 'Atasan dan user berhasil diupdate.');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DivisiHead $divisiHead)
    {
        $divisiHead->delete();
        return redirect()->route('divisi-head.index');
    }
}
