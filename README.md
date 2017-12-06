# Salão Cadastro



## Instalação

1) Para instalar, basta adicionar o seguinte ao seu  `composer.json`. Em seguida, execute `composer update`:

```json
"minimum-stability": "dev",
```

```json
"manzoli2122/salao-cadastro": "dev-master"
```

2) Abra seu `config/app.php`  e adicione o seguinte ao array  `providers`:

```php
Manzoli2122\Salao\Cadastro\CadastroServiceProvider::class,
```


php artisan vendor:publish ???
