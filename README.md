# WishNotes

WishNotes is a Laravel web app for creating themed message boards. On the Christmas tree board, visitors choose an ornament, place it on the tree, and attach a note. The project was built as a group assignment for Semester 3 Web Programming.

## My contribution

I worked on both sides of the app: the PHP/Laravel backend and the Blade frontend. I connected the board interface to the backend so the app could store a note along with its ornament position and draw it in the same spot when the board was reopened.

## How it works

Signed-in users create a Christmas tree, bulletin board, or mailbox and choose who can open it. The dashboard lists their boards and message counts. Anyone with a public board’s link can leave a note. A private board is visible only to its owner. On the tree, visitors can pick one of five ornaments and leave the name field blank.

The app uses PHP and Laravel for the backend, Blade and JavaScript for the interface, and SQLite for boards and messages.

## Run locally

Install PHP 8.2 or newer with SQLite support and Composer. From the repository root:

```sh
composer install
php -r "file_exists('.env') || copy('.env.example', '.env'); file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan key:generate
php artisan migrate
php artisan serve
```

Open `http://127.0.0.1:8000` and register an account. Run `php artisan test` for the board and account checks.

## Screenshots

The [portfolio case study](https://makhdanramadhan-ui.github.io/projects.html#wishnote) shows the earlier coursework interface with sample data. This repository contains the cleaned-up edition. It is intended to run locally, not as a hosted public service.
