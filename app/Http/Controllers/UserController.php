<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GoogleSheetLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Lista de usuarios en el dashboard.
     */
    public function index()
    {
        $users = User::with('googleSheetLinks')
                    ->select('id', 'name', 'email')
                    ->get();

        return view('dashboard', compact('users'));
    }

    /**
     * Formulario para crear un usuario.
     */
    public function create()
    {
        return view('users.create-edit');  // Sin $user, modo "crear".
    }

    /**
     * Guarda un nuevo usuario y su enlace.
     */
    public function store(Request $request)
    {
        // Validar: password es requerido al CREAR. Debe coincidir con password_confirmation.
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|confirmed|min:6',  // Se requiere al crear
            'url_sheet' => 'nullable|url',
        ]);

        // Crear usuario
        $user = User::create([
            'id'       => (string) Str::uuid(),
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Hash de la contraseña
        ]);

        // Si se llena url_sheet, crear el enlace en google_sheet_links
        if ($request->filled('url_sheet')) {
            GoogleSheetLink::create([
                'id'        => (string) Str::uuid(),
                'user_id'   => $user->id,
                'url_sheet' => $request->url_sheet,
            ]);
        }

        return redirect()->route('dashboard')
                         ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Formulario para editar un usuario (y su enlace).
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.create-edit', compact('user'));
    }

    /**
     * Actualiza un usuario y su enlace.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validación: password es opcional al EDITAR.
        // Solo cambia si se llena.
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|confirmed|min:6', // no requerido
            'url_sheet' => 'nullable|url',
        ]);

        // Actualizar usuario
        $user->name  = $request->name;
        $user->email = $request->email;

        // Si la password NO viene vacía, la cambiamos
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Manejar el enlace en google_sheet_links
        if ($request->filled('url_sheet')) {
            // Si ya hay un enlace, lo actualizamos
            if ($user->googleSheetLinks()->exists()) {
                $link = $user->googleSheetLinks->first();
                $link->url_sheet = $request->url_sheet;
                $link->save();
            } else {
                // Si no existe, se crea
                GoogleSheetLink::create([
                    'id'        => (string) Str::uuid(),
                    'user_id'   => $user->id,
                    'url_sheet' => $request->url_sheet,
                ]);
            }
        } else {
            // Si está vacío, se elimina si existe
            if ($user->googleSheetLinks()->exists()) {
                $user->googleSheetLinks()->delete();
            }
        }

        return redirect()->route('dashboard')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario y su enlace de Google Sheets.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Eliminar enlace si existe
        if ($user->googleSheetLinks()->exists()) {
            $user->googleSheetLinks()->delete();
        }

        // Eliminar el usuario
        $user->delete();

        return redirect()->route('dashboard')
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}
