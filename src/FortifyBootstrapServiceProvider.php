<?php


namespace Greatsami\FortifyBootstrap;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyBootstrapServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }

        if (class_exists(Fortify::class)) {
            Fortify::loginView(function () {
                return file_exists(resource_path('views/auth/login.blade.php'))
                    ? view('auth.login')
                    : view('fortify-bootstrap::auth.login');
            });

            Fortify::registerView(function () {
                return file_exists(resource_path('views/auth/register.blade.php'))
                    ? view('auth.register')
                    : view('fortify-bootstrap::auth.register');
            });

            Fortify::requestPasswordResetLinkView(function () {
                return file_exists(resource_path('views/auth/forgot-password.blade.php'))
                    ? view('auth.forgot-password')
                    : view('fortify-bootstrap::auth.forgot-password');
            });

            Fortify::resetPasswordView(function () {
                return file_exists(resource_path('views/auth/reset-password.blade.php'))
                    ? view('auth.reset-password')
                    : view('fortify-bootstrap::auth.reset-password');
            });

            Fortify::verifyEmailView(function () {
                return file_exists(resource_path('views/auth/verify-email.blade.php'))
                    ? view('auth.verify-email')
                    : view('fortify-bootstrap::auth.verify-email');
            });

            Fortify::twoFactorChallengeView(function () {
                return file_exists(resource_path('views/auth/two-factor-challenge.blade.php'))
                    ? view('auth.two-factor-challenge')
                    : view('fortify-bootstrap::auth.two-factor-challenge');
            });

            Fortify::confirmPasswordView(function () {
                return file_exists(resource_path('views/auth/confirm-password.blade.php'))
                    ? view('auth.confirm-password')
                    : view('fortify-bootstrap::auth.confirm-password');
            });

            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'fortify-bootstrap');
        }
    }


}
