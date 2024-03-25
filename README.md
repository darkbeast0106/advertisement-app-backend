# Apróhirdetés alkalmazás backend

Frontend: [https://github.com/darkbeast0106/advertisement-app-frontend](https://github.com/darkbeast0106/advertisement-app-frontend)

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
