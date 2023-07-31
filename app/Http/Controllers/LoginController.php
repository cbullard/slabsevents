<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Database\Seeders\UserDataSeeder;
use Socialite;
use App\OAuthProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    private LoginService $userService;
    private $userToken;
    
    public function __construct(LoginService $userService)
    {
        $this->userService = $userService;
    }

        /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View('login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($sso_type)
    {
        return [
            'url' => Socialite::driver($sso_type)->stateless()->redirect()->getTargetUrl(),
        ];
    }

    public function sso($sso_type)
    {
        return Socialite::driver($sso_type)->redirect();
    }

    public function ssoRedirect($sso_type)
    {
        $user = Socialite::driver($sso_type)->stateless()->user();
        // dd($user);

        // $user = User::where('email', request('email'))->firstOr(function () {
        //     $account = Account::create([ ]);
        
        //     return User::create([
        //         'account_id' => $account->id,
        //         'email' => request('email'),
        //     ]);
        // });

        $user = User::where('email', $user->getEmail())
            ->firstOr(function () use ($user) {
            $newUser = User::create([
                'email' => $user->getEmail(),
                'name' => $user->name,
                'password' => Hash::make(Str::random(24))
            ]);

            UserDataSeeder::run($newUser->id);

            
            return $newUser;
        });
        dd($user);
        $this->guard()->setToken(
            $this->userToken = $this->guard()->login($user)
        );
        // dd('done');
        return view('oauth/callback', [
            'token' => $this->userToken,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->getPayload()->get('exp') - time(),
        ]);

        // $user = User::firstOrCreate([
        //     'email' => $user->getEmail()
        // ],
        // [
        //     'name' => $user->name,
        //     'password' => Hash::make(Str::random(24))
        // ]);
        // dd(User::query()->withFollowers()->find($user->id));
        // dd($user);
        Auth::login($user, true);
        return redirect('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
