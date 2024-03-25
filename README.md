# Apróhirdetés alkalmazás backend

TODO: frontend repo linkje.

## Telepítés lépései

- Csomagok telepítése
  
  ```sh
  composer install
  ```

- .env állomány létrehozása
  
  ```sh
  cp .env.example .env
  ```

- App kulcs generálása
  
  ```sh
  php artisan key:generate
  ```

- Public storage linkelése
  
  ```sh
  php artisan storage:link
  ```

- Migrációk futtatása

  ```sh
  php artisan migrate
  ```

- Seedelés (opcionális)

  ```sh
  php artisan db:seed
  ```

- Futtatás (local)
  
  ```sh
  php artisan serve
  ```
