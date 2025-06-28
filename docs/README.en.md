# Laravel Stripe Subscriptions

A complete Laravel package for integrating Stripe subscriptions with **Laravel Cashier** and **Jetstream (Inertia.js)**. This module provides a complete solution for managing recurring billing, including plan management, subscriptions, invoices, and webhooks.

## 🚀 Features

- **Plan Management**: Flexible configuration of subscription plans with monthly and yearly pricing
- **Subscriptions**: Creation, modification, cancellation, and resumption of subscriptions
- **Billing**: View and download invoices in PDF format
- **Stripe Webhooks**: Automatic handling of Stripe events for real-time synchronization
- **User Interface**: Pre-built Vue.js components for Jetstream with Inertia.js

## 📋 Dependencies

### PHP Dependencies
- **PHP**: ^8.2
- **Laravel Framework**: ^12.0
- **Laravel Jetstream**: ^5.3 (with Inertia.js)
- **Laravel Cashier**: ^15.0 (for Stripe integration)
- **Barryvdh Laravel DomPDF**: ^3.1 (for PDF invoice generation)

### Frontend Dependencies
- **Vue.js**: 3.x (included with Inertia.js)
- **Inertia.js**: For SPA navigation
- **Axios**: For API calls

## 🛠️ Installation

### 1. Install Jetstream with Inertia
```bash
php artisan jetstream:install inertia
```

### 2. Configure Stripe credentials
Add to `.env` file:
```bash
STRIPE_KEY=pk_test_51RaZ......
STRIPE_SECRET=sk_test_51.....
```

### 3. Publish Cashier migrations
```bash
php artisan vendor:publish --tag="cashier-migrations"
```

### 4. Publish package resources
```bash
php artisan vendor:publish --provider="Cironapo\StripeSubscriptions\StripeSubscriptionsServiceProvider"
```

### 5. Configure services
Add to `config/services.php`:
```php
'stripe' => [
    'model' => App\Models\User::class,
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
],
```

### 6. Add Billable trait to User model
```php
<?php

namespace App\Models;

use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable;
    // ... rest of the model
}
```

### 7. Add Billing menu item
In `resources/js/Layouts/AppLayout.vue`:
```html
<NavLink :href="route('billing')" :active="route().current('billing')">
    Billing
</NavLink>
```

### 8. Update database and clear caches
```bash
php artisan migrate
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
```

### 9. Start the project
```bash
npm run dev
php artisan serve
```

## ⚙️ Configuration

The package uses the `config/subscriptions.php` file for plan configuration:

```php
return [
    'billing_page' => 'Subscriptions/Jetstream/BillingPage',
    'company' => 'My company',
    'plans' => [
        [
            'name' => 'Basic',
            'description' => 'Plan description',
            'monthly_id' => 'price_1RdQkdC4ftKvdyaHipLWtN2h',
            'yearly_id' => 'price_1RdQlXC4ftKvdyaHuY9Ah27V',
            'currency' => '€',
            'features' => [
                'Feature 1',
                'Feature 2',
                'Feature 3',
            ],
        ],
        // Other plans...
    ],
];
```

## 📝 Notes

- Make sure to properly configure Stripe webhooks for automatic synchronization
- Plan prices are dynamically retrieved from Stripe
- The package supports both monthly and yearly payments
- Invoices are generated using DomPDF with customizable templates

## 📄 License

MIT License