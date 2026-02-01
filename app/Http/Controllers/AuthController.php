<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Le login est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $credentials = $request->only('login', 'password');

        // Vérifier les identifiants
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Vérifier si l'utilisateur est actif
            if (!$user->actif) {
                Auth::logout();
                return back()->with('error', 'Votre compte est désactivé. Contactez l\'administrateur.');
            }

            // Rediriger selon le rôle
            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'login' => 'Les identifiants sont incorrects.',
        ])->onlyInput('login');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous êtes déconnecté.');
    }

    /**
     * Redirection basée sur le rôle
     */
    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'Radmin':
                return redirect()->route('admin.dashboard')->with('success', 'Bienvenue, Administrateur !');
            case 'Rbibliothecaire':
                return redirect()->route('bibliothecaire.dashboard')->with('success', 'Bienvenue, Bibliothécaire !');
            case 'Rlecteur':
                return redirect()->route('lecteur.catalogue')->with('success', 'Bienvenue !');
            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Rôle non reconnu.');
        }
    }

    /**
     * Afficher le formulaire d'inscription (optionnel)
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Traiter l'inscription
     */
    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|string|unique:users,login|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // Au moins une lettre minuscule
                'regex:/[A-Z]/',      // Au moins une lettre majuscule
                'regex:/[0-9]/',      // Au moins un chiffre
                'regex:/[@$!%*#?&]/', // Au moins un caractère spécial
            ],
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
        ], [
            'login.required' => 'Le login est obligatoire.',
            'login.unique' => 'Ce login est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.regex' => 'Le mot de passe doit contenir des lettres, des chiffres et des caractères spéciaux.',
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
        ]);

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'role' => 'Rlecteur', // Par défaut, nouveau utilisateur = lecteur
            'actif' => true,
        ]);

        Auth::login($user);

        return redirect()->route('lecteur.catalogue')->with('success', 'Votre compte a été créé avec succès !');
    }
}
