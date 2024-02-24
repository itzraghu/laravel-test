# Steps to run

-   clone repo
-   `composer install`
-   create database, update name in env file and run command `php artisan migrate` then `php artisan db:seed` & `php artisan db:seed --class=ProductSeeder`
-   once table migrated and tables created, run command `php artisan serve` and open http://localhost:8000/sales

| Key      | Value               |
| -------- | ------------------- |
| Username | `sales@coffee.shop` |
| password | `password`          |

---

# Steps to run unit tests

-   Go to root pe project and run command `php artisan test` in terminal
