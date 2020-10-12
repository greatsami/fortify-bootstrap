# Fortify Bootstrap

## Introduction

Authentication scaffolding with Bootstrap 4. 

### Installation

You have to install [Laravel Fortify](https://github.com/laravel/fortity), and complete all setup without add blades calling in App\Providers\FortifyServiceProvider.php.

After installation completed please add session migration using:
(to activate TwoFactorAuthentication method)

```bash
php artisan session:table
```


To get started, install package using composer:

```bash
composer require greatsami/fortify-bootstrap
```

Next, Run install artisan command to publish bootstrap scraffolding to application

```bash
php artisan fortify:bootstrap
npm install && npm run dev
```

This command will update package.json with Bootstrap dependencies, update resources/sass and resources/js, and resources/views with authentication views like login, register, reset passsword request, layouts files etc.

## Build With

[Laravel](https://github.com/laravel/laravel)  
[Laravel Fortify](https://github.com/laravel/fortity)  
[Bootstrap](http://getbootstrap.com)

## Useful Links

[Official Laravel Ui Package](https://github.com/laravel/ui)

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)
