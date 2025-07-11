<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
public function index()
{
    $users = User::with('bagian')->get();
    $bagians = Bagian::all(); 

    return view('admin.user', compact('users', 'bagians'));
}
    public function create()
    {
        $bagian = Bagian::all();
        return view('admin.user-create', compact('bagian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'bagian_id' => 'required|exists:bagian,id',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'bagian_id' => $request->bagian_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $bagian = Bagian::all();
        return view('admin.user-edit', compact('user', 'bagian'));
    }

    public function update(Request $request, $id)
    {
    $user = User::findOrFail($id);

    $request->validate([
        'bagian_id' => 'required|exists:bagian,id',
        'password' => 'nullable|min:6|confirmed',
    ]);

    $user->bagian_id = $request->bagian_id;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('admin.user')->with('success', 'User berhasil diperbarui');
    }


    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.user')->with('success', 'User berhasil dihapus');
    }
}
