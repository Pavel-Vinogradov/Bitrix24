# Описание

Пакет предоставляет набор компонентов постоянно необходимых в работе и упрощающих разработку

#### Tizix\Bitrix24Laravel\\*


1. Для работы сервиса в системе, требуется его подключить в `config/app.php`
```php
'providers' => [
    // ...
    Tizix\Bitrix24Laravel\Providers\BitrixServiceProvider::class,
]
