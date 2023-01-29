# BananaSupport

Laravel 9 + Livewire + Tailwind 

```

Author: Roland Edward Santos
Email: dev.weward@gmail.com
Bitbucket: https://bitbucket.org/rolandedwardsantos
LinkedIn: https://linkedin.com/roland-edward-santos

```
[Bitbucket Profile](https://bitbucket.org/rolandedwardsantos)

[Add me on LinkedIn](https://linkedin.com/roland-edward-santos)

.
---

# Installation

Modify `.env` values

### Install Dependencies 

```
# RUN
composer install
```

### Generate Security Key

```
# RUN
php artisan key:generate
```

### Install Javascript Dependencies

```
# Run
npm install
```

### Build Assets

```
# Run
npm run build
```

### Migrate Database

```
# RUN
php artisan migrate
```

### Seed Data

Includes Admin seeder and

By default, this will generate 2000 Users, max of 10 tickets per user, and max of 10 comments per ticket.

To modify the limits, edit the `database/seeders/AppInitialSeeder.php` file.

Note: This will generate the Admin Login as well.

```
# RUN
php artisan db:seed --class=AppInitialSeeder
```


### Admin Login Details

```
Url: /admin
Email: info@codingmonkeys.nl
Pass: password
```

### All User Password

```
Password: password
```

## Tests

To run the tests

```
# Run

php artisan test


# Or, run a specific test:
php artisan test --filter NewTicketModal
```


---

# Additional Info

### Additional Features

- Separate Admin and User portals

- Global scope to separate admin and user queries

- Seeder for sample data

- Tests

- Custom UI


### Tech Stack 

- Laravel 9

- Livewire

- Tailwind


---

This app has implemented the required features as detailed in the `Coding Monkeys - Technical Challenge.pdf` file sent by the hiring manager. 

This app is purely a demo application. There are a lot of improvements to be done to produce, at least, an MVP. 
But, I am hoping that this app has given you a glimpse of my skills.

I am hoping that we could eventually work together professionally (hoping soon!) and produce something that is more structured and technical.

Thank you. 

```

Author: Roland Edward Santos
Email: dev.weward@gmail.com
Bitbucket: https://bitbucket.org/rolandedwardsantos
LinkedIn: https://linkedin.com/roland-edward-santos

```

[Bitbucket Profile](https://bitbucket.org/rolandedwardsantos)

[Add me on LinkedIn](https://linkedin.com/roland-edward-santos)
