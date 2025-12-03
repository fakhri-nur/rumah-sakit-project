<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Proses login
     */
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'dokter') {
                return redirect()->route('dokter.dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->with('error', 'Email atau kata sandi salah')->withInput();
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }

    /**
     * Proses registrasi/sign-up
     */
    public function signUp(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user'
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Contoh halaman users untuk admin (opsional)
     */
    public function index()
{
    $users = User::orderByRaw("
        CASE
            WHEN role = 'admin' THEN 1
            WHEN role = 'dokter' THEN 2
            WHEN role = 'user' THEN 3
            ELSE 4
        END
    ")->get();

    return view('admin.users.index', compact('users'));
}

    /**
     * Halaman index untuk dokter (hanya menampilkan dokter)
     */
    public function indexDokter()
    {
        $users = User::where('role', 'dokter')->get();

        return view('dokter.index', compact('users'));
    }


    /**
     * Tampilkan form untuk membuat user baru
     */
    public function create()
    {
        return view('admin.users.create');
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

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

            return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat!');
        }

    /**
     * DataTables untuk users
     */
    public function datatables(Request $request)
{
    $users = User::orderByRaw("
        CASE
            WHEN role = 'admin' THEN 1
            WHEN role = 'dokter' THEN 2
            WHEN role = 'user' THEN 3
            ELSE 4
        END
    ")->select(['id', 'name', 'email', 'role', 'created_at']);

    return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('role_badge', function ($user) {
            $badgeClass = match ($user->role) {
                'admin' => 'badge bg-danger',
                'dokter' => 'badge bg-primary',
                default => 'badge bg-secondary',
            };
            return '<span class="' . $badgeClass . '">' . ucfirst($user->role) . '</span>';
        })
        ->addColumn('action', function ($user) {
            return '
                <a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-sm btn-warning">Edit</a>
                <form action="' . route('admin.users.delete', $user->id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button>
                </form>
            ';
        })
        ->rawColumns(['role_badge', 'action'])
        ->make(true);
}

    /**
     * Tampilkan form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
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
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate!');
    }

    /**
     * Hapus user (soft delete)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Tampilkan users yang dihapus (trash)
     */
    public function trash()
    {
        $users = User::onlyTrashed()->get();
        return view('admin.users.trash', compact('users'));
    }

    /**
     * Restore user dari trash
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.trash')->with('success', 'User berhasil direstore!');
    }

    /**
     * Hapus user secara permanen
     */
    public function deletePermanent($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('admin.users.trash')->with('success', 'User berhasil dihapus permanen!');
    }

    /**
     * Export users ke Excel
     */
    public function export()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }
}
