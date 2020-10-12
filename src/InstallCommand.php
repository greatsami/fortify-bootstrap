<?php


namespace Greatsami\FortifyBootstrap;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fortify:bootstrap {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold Fortify authentication views and routes';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'auth/verify-email.blade.php' => 'auth/verify-email.blade.php',
        'auth/two-factor-challenge.blade.php' => 'auth/two-factor-challenge.blade.php',
        'auth/reset-password.blade.php' => 'auth/reset-password.blade.php',
        'auth/login.blade.php' => 'auth/login.blade.php',
        'auth/register.blade.php' => 'auth/register.blade.php',
        'auth/forgot-password.blade.php' => 'auth/forgot-password.blade.php',
        'auth/confirm-password.blade.php' => 'auth/confirm-password.blade.php',
        'layouts/app.blade.php' => 'layouts/app.blade.php',
        'home.blade.php' => 'home.blade.php',
        'profile.blade.php' => 'profile.blade.php',
        'profile/update-profile-information-form.blade.php' => 'profile/update-profile-information-form.blade.php',
        'profile/update-password-form.blade.php' => 'profile/update-password-form.blade.php',
        'profile/two-factor-authentication-form.blade.php' => 'profile/two-factor-authentication-form.blade.php',
    ];

    /**
     * @var array
     */
    protected $resourceFiles = [
        'sass/_variables.scss' => 'sass/_variables.scss',
        'sass/app.scss' => 'sass/app.scss',
        'js/bootstrap.js' => 'js/bootstrap.js',
        'js/app.js' => 'js/app.js',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->ensureDirectoriesExist();
        $this->exportViews();

        $this->updateRoute();

        $this->exportAssets();
        $this->updatePackage();
        $this->updateWebpackMix();

        $this->info('Bootstrap scaffolding installed successfully.');
        $this->warn('Run "npm install && npm run dev" to compile resources.');
    }

    /**
     * @return void
     */
    protected function ensureDirectoriesExist()
    {
        $directories = [
            $this->getViewPath('layouts'),
            $this->getViewPath('auth'),
            $this->getViewPath('profile'),
            resource_path('sass'),
            resource_path('js'),
        ];

        foreach ($directories as $directory) {
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }
    }

    /**
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = $this->getViewPath($value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(__DIR__.'/../resources/views/'.$key, $view);
        }
    }

    /**
     * @param  string  $path
     * @return string
     */
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }

    /**
     * @return void
     */
    protected function updateRoute()
    {
        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/../routes/web.php'),
            FILE_APPEND
        );
    }

    /**
     * @return void
     */
    protected function exportAssets()
    {
        foreach ($this->resourceFiles as $sourcePath => $destinationPath) {
            copy(__DIR__.'/../resources/'.$sourcePath, resource_path($destinationPath));
        }
    }

    /**
     * @return void
     */
    protected function updatePackage($dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $bootstrapPackages =  [
            'bootstrap' => '^4.5.2',
            'jquery' => '^3.5.1',
            'popper.js' => '^1.16.1',
            'sass' => '^1.27.0',
            'sass-loader' => '^10.0.3',
        ];

        $packages[$configurationKey] = array_merge(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $bootstrapPackages
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * @return void
     */
    protected function updateWebpackMix()
    {
        if (! file_exists(base_path('webpack.mix.js'))) {
            return;
        }

        file_put_contents(
            base_path('webpack.mix.js'),
            file_get_contents(__DIR__.'/../resources/webpack.mix.js'),
        );
    }
}
