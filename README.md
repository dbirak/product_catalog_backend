# Instalacja
- Należy utworzyć nową bazę MySQL `catalog` z kodowaniem `uff8mb4_polish_ci`
- Należy sklonować repozytorium
- Zmienić nazwę pliku `.env.exapmle` na `.env`
- Wykonać komendy:
  - `composer install --no-interaction`
  - `php artisan storage:link`
  - `php artisan migrate:refresh --seed`
  - `php artisan serve`

# Ważne informacje
- Przed wrzuceniem aplikacji na serwer należy zmienić ustawienia CORS, aby tylko frontend mógł komunikować się z backend'em. Domyślne ustawienia pliku `config/cors.php` 

![image](https://github.com/dbirak/product_catalog_backend/assets/41111309/5a400f56-c127-4b2b-8bbd-9472a60e06f6)

- Należy również zmienić i dostosować ustawienia pliku `.env` aby prawidłowo łączył się z bazą danych. Domyślne ustawienia:

![image](https://github.com/dbirak/product_catalog_backend/assets/41111309/9d536d08-e0ac-47d7-bf1e-9aaa103e896d)

- Przed instalacją można zmienić domyślne dane logowania do panelu admina w pliku `database/seeders/UserSeeder.php`. Domyślne dane logowania:

    - email: `kowal@gmail.com`
    - hasło: `kowal12@`

![image](https://github.com/dbirak/product_catalog_backend/assets/41111309/f6c1934e-c285-4e3f-b534-71c01877ee0f)
