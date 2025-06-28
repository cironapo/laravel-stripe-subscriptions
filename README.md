#Installazione


Installare **inertia**
```bash
php artisan jetstream:install inertia
```

Modificare il file *.env* aggiungendo le creadenziali di Stripe
```bash
STRIPE_KEY=pk_test_51RaZxVC4ftKvdyaHQaGJ4G3kC3p0v9qKOnxbh2IMHTntZZmaSLeHYpivStQV4beFSAa1BJM0bga8czEp4aYJF1rD00VSYBDAtI
STRIPE_SECRET=sk_test_51RaZxVC4ftKvdyaHKONZwCkM9HJM8bFl2qTyQIgAMD9Mzrs7cp1iPZLZBVmVz8brmpX1h7Kk2oHrP2bQnFjGlWiI00L5YqwqpT
```

Pubblicare le risorse del pacchetto **laravel/cashier**
```bash
php artisan vendor:publish --tag="cashier-migrations"
```


Pubblicare le risorse del pacchetto **cironapo/laravel-stripe-subscriptions**
```bash
php artisan vendor:publish --provider="Cironapo\StripeSubscriptions\StripeSubscriptionsServiceProvider"
```



Aggiungere le seguenti righe al file **config/services.php**
```php
 ....
 'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
 ],
 ....

```


Aggiungere il trait **Billable** nel modello **User**
```php
<?php

namespace App\Models;
....
use Laravel\Cashier\Billable;
...

class User extends Authenticatable
{
    ....
    use Billable;
    ....
}
```


Aggiungere la voce di menu **Fatturazione** nella pagina **resources/js/Layouts/AppLayout.vue**
```html
<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
    </NavLink>
    ....
    <NavLink :href="route('billing')" :active="route().current('billing')">
        Fatturazione
    </NavLink>
    ....
</div>
```


Aggiornare il database e svuotare le cache
```bash
php artisan migrate
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
```