# Laravel Stripe Subscriptions

Un pacchetto Laravel completo per l'integrazione di sottoscrizioni Stripe con **Laravel Cashier** e **Jetstream (Inertia.js)**. Questo modulo fornisce una soluzione completa per la gestione delle fatturazioni ricorrenti, inclusa la gestione dei piani, sottoscrizioni, fatture e webhook.

## 🚀 Caratteristiche

- **Gestione Piani**: Configurazione flessibile dei piani di abbonamento con prezzi mensili e annuali
- **Sottoscrizioni**: Creazione, modifica, cancellazione e ripresa delle sottoscrizioni
- **Fatturazione**: Visualizzazione e download delle fatture in formato PDF
- **Webhook Stripe**: Gestione automatica degli eventi Stripe per sincronizzazione in tempo reale
- **Interfaccia Utente**: Componenti Vue.js predefiniti per Jetstream con Inertia.js


## 📋 Dipendenze

### Dipendenze PHP
- **PHP**: ^8.2
- **Laravel Framework**: ^12.0
- **Laravel Jetstream**: ^5.3 (con Inertia.js)
- **Laravel Cashier**: ^15.0 (per l'integrazione Stripe)
- **Barryvdh Laravel DomPDF**: ^3.1 (per la generazione PDF delle fatture)

### Dipendenze Frontend
- **Vue.js**: 3.x (incluso con Inertia.js)
- **Inertia.js**: Per la navigazione SPA
- **Axios**: Per le chiamate API

## 🛠️ Installazione

### 1. Installare Jetstream con Inertia
```bash
php artisan jetstream:install inertia
```

### 2. Configurare le credenziali Stripe
Aggiungere al file `.env`:
```bash
STRIPE_KEY=pk_test_51RaZ......
STRIPE_SECRET=sk_test_51.....
```

### 3. Pubblicare le migrazioni di Cashier
```bash
php artisan vendor:publish --tag="cashier-migrations"
```

### 4. Pubblicare le risorse del pacchetto
```bash
php artisan vendor:publish --provider="Cironapo\StripeSubscriptions\StripeSubscriptionsServiceProvider"
```

### 5. Configurare i servizi
Aggiungere al file `config/services.php`:
```php
'stripe' => [
    'model' => App\Models\User::class,
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
],
```

### 6. Aggiungere il trait Billable al modello User
```php
<?php

namespace App\Models;

use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable;
    // ... resto del modello
}
```

### 7. Aggiungere la voce di menu Fatturazione
Nel file `resources/js/Layouts/AppLayout.vue`:
```html
<NavLink :href="route('billing')" :active="route().current('billing')">
    Fatturazione
</NavLink>
```

### 8. Aggiornare il database e le cache
```bash
php artisan migrate
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
```

### 9. Avviare il progetto
```bash
npm run dev
php artisan serve
```

## ⚙️ Configurazione

Il pacchetto utilizza il file `config/subscriptions.php` per la configurazione dei piani:

```php
return [
    'billing_page' => 'Subscriptions/Jetstream/BillingPage',
    'company' => 'My company',
    'plans' => [
        [
            'name' => 'Basic',
            'description' => 'Descrizione del piano',
            'monthly_id' => 'price_1RdQkdC4ftKvdyaHipLWtN2h',
            'yearly_id' => 'price_1RdQlXC4ftKvdyaHuY9Ah27V',
            'currency' => '€',
            'features' => [
                'Feature 1',
                'Feature 2',
                'Feature 3',
            ],
        ],
        // Altri piani...
    ],
];
```


## 📝 Note

- Assicurarsi di configurare correttamente i webhook Stripe per la sincronizzazione automatica
- I prezzi dei piani vengono recuperati dinamicamente da Stripe
- Il pacchetto supporta sia pagamenti mensili che annuali
- Le fatture vengono generate utilizzando DomPDF con template personalizzabili

## 📄 Licenza

MIT License