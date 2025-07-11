<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('web_user.pengaturan-akun', compact('user'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:256',
        ]);

        $user = Auth::user();

        if ($user->foto && Storage::exists('public/foto/' . $user->foto)) {
            Storage::delete('public/foto/' . $user->foto);
        }

        $file = $request->file('foto');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/foto', $namaFile);

        $user->update(['foto' => $namaFile]);

        return back()->with('status', 'Foto profil berhasil diperbarui.');
    }


    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
    ]);

    $user = Auth::user();
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return back()->with('status', 'Profil berhasil diperbarui.');
}


   public function updatePassword(Request $request)
{
    $request->validate([
        'password_lama' => 'required',
        'password_baru' => 'required|min:6|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password_lama, $user->password)) {
        return back()->withErrors(['password_lama' => 'Password lama tidak sesuai']);
    }

    $user->update([
        'password' =>Hash::make($request->password_baru),
    ]);

    return back()->with('status', 'Password berhasil diperbarui.');
}

}
