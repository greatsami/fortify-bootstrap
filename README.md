# Fortify Bootstrap

## Introduction

Authentication scaffolding with Bootstrap 4. 

### Installation

To get started, install package using composer:

```bash
composer require greatsami/fortify-bootstrap
```

Add FortifyServiceProvider to config/app.php, and do not forgot to publish fortify files.

```php
'providers' => [
    ...
    App\Providers\FortifyServiceProvider::class,
    ...
]
```

```bash
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
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
