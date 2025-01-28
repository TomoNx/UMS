<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Responses\RegisteredUserResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Fortify::createUsersUsing(CreateNewUser::class);
    Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
    Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
    Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

    RateLimiter::for('login', function(Request $request) {
      $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

      return Limit::perMinute(5)->by($throttleKey);
    });

    RateLimiter::for('two-factor', function(Request $request) {
      return Limit::perMinute(5)->by($request->session()->get('login.id'));
    });

    $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
      public function toResponse($request)
      {
          return redirect()->route('login')
              ->with('success', 'Registrasi berhasil! Silakan login.');
      }
  });


    //Login
    Fortify::loginView(function(Request $request) {
      $pageConfigs = ['myLayout' => 'blank'];
      return view('content.auth.login', ['pageConfigs' => $pageConfigs]);
    });

    //Register
    Fortify::registerView(function(Request $request) {
      $pageConfigs = ['myLayout' => 'blank'];
      return view('content.auth.register', ['pageConfigs' => $pageConfigs]);
    });
  }
}
