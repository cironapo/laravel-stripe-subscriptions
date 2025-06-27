#Installazione


Modificare il file .env aggiungendo le creadenziali di Stripe

```bash
STRIPE_KEY=pk_test_51RaZxVC4ftKvdyaHQaGJ4G3kC3p0v9qKOnxbh2IMHTntZZmaSLeHYpivStQV4beFSAa1BJM0bga8czEp4aYJF1rD00VSYBDAtI
STRIPE_SECRET=sk_test_51RaZxVC4ftKvdyaHKONZwCkM9HJM8bFl2qTyQIgAMD9Mzrs7cp1iPZLZBVmVz8brmpX1h7Kk2oHrP2bQnFjGlWiI00L5YqwqpT
```


Pubblicare le risorse del pacchetto **cironapo/laravel-stripe-subscriptions**
```bash
php artisan vendor:publish --provider="Cironapo\StripeSubscriptions\StripeSubscriptionsServiceProvider"
```