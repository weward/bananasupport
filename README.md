# BananaSupport

Laravel 9 + Livewire + Tailwind 


.
---

### Installation

- Modify `.env` values

Install Dependencies 

```
# RUN
composer install
```

Generate security key

```
# RUN
php artisan key:generate
```

Install javscript Dependencies

```
# Run
npm install
```

Migrate Database

```
# RUN
php artisan migrate
```

Seed Admin 

```
# RUN
php artisan db:seed --class=AdminTableSeeder
```


### Admin Login Details

```
Email: info@codingmonkeys.nl
Pass: password
```

### Seed Users

```
php artisan db:seed --class=UsersTableSeeder
```

### Seed Tickets

```
php artisan db:seed --class=TicketsTableSeeder
```