<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IklanExport;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class IklanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $iklan = Iklan::all();
        return view('admin.iklan.index', compact('iklan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.iklan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('iklan', 'public');
        }

        Iklan::create([
            'nama' => $request->nama,
            'gambar' => $gambarPath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.iklan.index')->with('success', 'Iklan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Iklan $iklan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $iklan = Iklan::findOrFail($id);
        return view('admin.iklan.edit', compact('iklan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $iklan = Iklan::findOrFail($id);

        $gambarPath = $iklan->gambar;
        if ($request->hasFile('gambar')) {
            if ($iklan->gambar && Storage::disk('public')->exists($iklan->gambar)) {
                Storage::disk('public')->delete($iklan->gambar);
            }
            $gambarPath = $request->file('gambar')->store('iklan', 'public');
        }

        $iklan->update([
            'nama' => $request->nama,
            'gambar' => $gambarPath,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.iklan.index')->with('success', 'Iklan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $iklan = Iklan::findOrFail($id);
        $iklan->delete();

        return redirect()->route('admin.iklan.index')->with('success', 'Iklan berhasil dihapus!');
    }

    /**
     * Display trashed iklans.
     */
    public function trash()
    {
        $iklanTrash = Iklan::onlyTrashed()->get();
        return view('admin.iklan.trash', compact('iklanTrash'));
    }

    /**
     * Restore a trashed iklan.
     */
    public function restore($id)
    {
        $iklan = Iklan::withTrashed()->findOrFail($id);
        $iklan->restore();

        return redirect()->route('admin.iklan.trash')->with('success', 'Iklan berhasil dikembalikan!');
    }

    /**
     * Permanently delete a trashed iklan.
     */
    public function deletePermanent($id)
    {
        $iklan = Iklan::withTrashed()->findOrFail($id);

        // Delete image if exists
        if ($iklan->gambar && Storage::disk('public')->exists($iklan->gambar)) {
            Storage::disk('public')->delete($iklan->gambar);
        }

        $iklan->forceDelete();

        return redirect()->route('admin.iklan.trash')->with('success', 'Iklan berhasil dihapus permanen!');
    }

    /**
     * Export iklans to Excel.
     */
    public function export()
    {
        return Excel::download(new IklanExport, 'iklans.xlsx');
    }

    /**
     * DataTables for iklans.
     */
    public function datatables(Request $request)
    {
        $iklans = Iklan::select(['id', 'nama', 'gambar', 'keterangan', 'created_at']);

        return DataTables::of($iklans)
            ->addIndexColumn()
            ->addColumn('gambar', function ($iklan) {
                return $iklan->gambar ? '<img src="' . asset('storage/' . $iklan->gambar) . '" width="50" height="50">' : 'No Image';
            })
            ->addColumn('action', function ($iklan) {
                return '
                    <a href="' . route('admin.iklan.edit', $iklan->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <form action="' . route('admin.iklan.delete', $iklan->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button>
                    </form>
                ';
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}
