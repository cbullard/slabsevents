<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Socialite;

class LoginService {
  public function sso($sso_type)
  {
      return Socialite::driver($sso_type)->stateless()->redirect()->getTargetUrl();
  }

  public function redirectToProvider($sso_type)
  {
      return [
          'url2' => Socialite::driver($sso_type)->stateless()->redirect()->getTargetUrl(),
      ];
  }
  public function ssoRedirect($sso_type)
  {
      $user = Socialite::driver($sso_type)->user();

      $user = User::firstOrCreate([
          'email' => $user->getEmail()
      ],
      [
          'name' => $user->name,
          'password' => Hash::make(Str::random(24))
      ]);
      Auth::login($user, true);
      return redirect('dashboard');
  }

}