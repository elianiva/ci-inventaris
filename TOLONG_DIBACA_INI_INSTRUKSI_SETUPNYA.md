# Cara setup

Prasyarat:
  - Composer
  - Database MySQL/MariaDB
  - PHP >= 7.4 | lebih bagus lagi kalo pake PHP 8 soalnya dia punya JIT,
    performanya jauh lebih bagus.
    NOTE: aplikasinya ngga akan bisa jalan kalo versi PHPnya dibawah 7.4
  - Git Bash | kalo udah pake Linux ga perlu ini

Langkah - langkah:
  - Install git bash, bisa diambil disini: https://git-scm.com/downloads
  - Install Composer, bisa diambil disini: https://getcomposer.org
  - Install PHP + MariaDB, bisa pake XAMPP kalo gamau ribet: https://www.apachefriends.org/index.html
  - Rename file `env` jadi `.env`
  - Edit file `.env` bagian ini.

    ```
      CI_ENVIRONMENT = production
      database.default.database = inventaris
      database.default.username = root
      database.default.password =
    ```

    - CI_ENVIRONMENT:
        Ini buat nentuin environment development/production.
        Mode production lebih cepat tapi kalo ada error ngga dikasih tau.
        Mode development lebih lambat tapi errornya jelas banget, dikasih stack tracenya juga.
    - database.default.database: ini nama databasenya
    - database.default.username: ini usernamenya, kalo XAMPP biasanya `root`
    - database.default.password: ini passwordnya, kalo XAMPP biasanya kosong

  - Hidupkan databasenya
  - Buka git bash di root direktori aplikasinya
  - Cek versi PHP dan Composer dulu buat mastiin kalo udah keinstall

    ```
      php --version
      composer --version
    ```

  - Kalo muncul versi dan ngga ada error berarti aman, udah keinstall
  - Aktifkan extension `php-intl` dan `php-gd`. Ini dipake buat `spark` dan `uuid`.
    Detail caranya bisa lihat disini: https://stackoverflow.com/questions/33869521/how-can-i-enable-php-extension-intl, tapi enable `php-intl` + `php-gd`.
  - Jalankan `composer install` buat download dependensinya. Termasuk CodeIgniter / Faker dan lain lain.
  - Jalankan command `./setup m:renew`. Sebenernya ini cuma wrapper buat
    beberapa command `php spark`. Cek aja isinya.
  - Jalankan `php spark serve`, ini buat develop aja sebenernya.
  - Buka browser, pergi ke `http://localhost:8080/`
  - Masukin username `admin`, passwordnya juga `admin`
