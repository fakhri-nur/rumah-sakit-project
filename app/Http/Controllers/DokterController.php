<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Iklan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DokterExport;
use Yajra\DataTables\Facades\DataTables;

class DokterController extends Controller
{

    public function dashboard()
    {
        $iklans = Iklan::all();
        $user = Auth::user();
        $dokter = Dokter::where('user_id', $user->id)->first();
        return view('dokter.dashboard', compact('iklans', 'user', 'dokter'));
    }
    /**
     * Tampilkan form edit profil dokter (untuk dokter sendiri)
     */
    public function editProfile()
    {
        $user = Auth::user();
        $dokter = Dokter::where('user_id', $user->id)->first();

        return view('dokter.edit', compact('user', 'dokter'));
    }

    /**
     * Update profil dokter (untuk dokter sendiri)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $dokter = Dokter::where('user_id', $user->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialty' => 'nullable|string|max:255',
        ]);

        // Update tabel users
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->specialty = $request->specialty;
        $user->save();

        // Update tabel dokters
        if ($dokter) {
            if ($request->hasFile('photo')) {
                if ($dokter->photo && \Storage::disk('public')->exists($dokter->photo)) {
                    \Storage::disk('public')->delete($dokter->photo);
                }

                $dokter->photo = $request->file('photo')->store('photos', 'public');
            }

            $dokter->specialty = $request->specialty;
            $dokter->save();
        }


        return redirect()->route('dokter.dashboard')->with('success', 'Profil berhasil diupdate!');
    }

    /**
     * Halaman index untuk dokter (hanya menampilkan dokter)
     */
    public function indexDokter()
    {
        $doctors = User::where('role', 'dokter')->get();

        return view('admin.dokter.index', compact('doctors'));
    }


    /**
     * Tampilkan form untuk membuat user baru
     */
    public function create()
    {
        return view('admin.dokter.create');
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'specialty' => 'nullable|string|max:255',
    ]);

    // UPLOAD FOTO
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('photos', 'public');
    }

    // KE TABEL USERS
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'dokter',
        'specialty' => $request->specialty,
    ]);

    // KE TABEL DOKTERS
    Dokter::create([
        'user_id' => $user->id,
        'photo' => $photoPath,
        'specialty' => $request->specialty,
    ]);

    return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil dibuat!');
}


    // mencari dokter
    public function index(Request $request)
    {
        $query = Dokter::join('users', 'dokters.user_id', '=', 'users.id')
            ->where('users.role', 'dokter')
            ->whereNull('users.deleted_at')
            ->with('user')
            ->select('dokters.*');

        if ($request->search_doctor) {
            $query->where(function($q) use ($request) {
                $q->where('users.name', 'like', '%' . $request->search_doctor . '%')
                ->orWhere('users.specialty', 'like', '%' . $request->search_doctor . '%');
            });
        }

        if ($request->category && $request->category !== 'all') {
            $query->where('users.specialty', $request->category);
        }

        $doctors = $query->get();

        return view('caridok', compact('doctors'));
    }

    // tombol filter spesialisasi
    public function search(Request $request)
    {
        $query = Dokter::join('users', 'dokters.user_id', '=', 'users.id')
            ->where('users.role', 'dokter')
            ->whereNull('users.deleted_at')
            ->with('user')
            ->select('dokters.*');

        if ($request->search_doctor) {
            $query->where('users.name', 'like', "%{$request->search_doctor}%");
        }

        if ($request->category && $request->category !== 'all') {
            $query->where('users.specialty', $request->category);
        }

        $doctors = $query->get();

        return view('caridok', compact('doctors'));
    }
    /**
     * form tabel dokter yang terhubung ke user
     */
    public function edit($id)
{
    $user = User::findOrFail($id);
    $dokter = Dokter::where('user_id', $id)->first();

    return view('admin.dokter.edit', compact('user', 'dokter'));
}


    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialty' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $dokter = Dokter::where('user_id', $id)->first();

        // Update tabel users
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // SET SPESIALISASI DI TABEL USERS
        $user->specialty = $request->specialty;

        // SIMPAN USER
        $user->save();

        // Update tabel dokters
        if ($dokter) {
            if ($request->hasFile('photo')) {
                if ($dokter->photo && \Storage::disk('public')->exists($dokter->photo)) {
                    \Storage::disk('public')->delete($dokter->photo);
                }

                $dokter->photo = $request->file('photo')->store('photos', 'public');
            }

            $dokter->specialty = $request->specialty;
            $dokter->save();
        }

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diupdate!');
    }



    /**
     * Hapus user (soft delete)
     */
    public function destroy($id)
{
    $user = User::findOrFail($id);

    // otomatis dokter ikut terhapus karena FK onDelete('cascade') cascade = mau diapakan data yang terhubung
    $user->delete();

    return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil dihapus!');
}


    /**
     * Tampilkan users yang dihapus (trash)
     */
    public function trash()
{
    $users = User::onlyTrashed()->where('role', 'dokter')->get();
    return view('admin.dokter.trash', compact('users'));
}


    /**
     * Restore user dari trash
     */
    public function restore($id)
{
    $user = User::withTrashed()->findOrFail($id);

    $user->restore(); // otomatis dokter ikut restore

    return redirect()->route('admin.dokter.trash')->with('success', 'Dokter berhasil direstore!');
}


    /**
     * Hapus user secara permanen
     */
    public function deletePermanent($id)
{
    $user = User::withTrashed()->findOrFail($id);

    if ($user->dokter && $user->dokter->photo) {
        \Storage::disk('public')->delete($user->dokter->photo);
    }

    Dokter::where('user_id', $id)->forceDelete();

    $user->forceDelete();

    return redirect()->route('admin.dokter.trash')->with('success', 'Dokter berhasil dihapus permanen!');
}


    /**
     * Export users ke Excel
     */
    public function export()
    {
        return Excel::download(new DokterExport, 'dokter.xlsx');
    }
}
