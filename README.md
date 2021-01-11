# Project


## Require
+ php 7.xx
+ composer


## Installation
masuk ke folder project install semua library dengan perintah

```bash
composer require
```
siapkan database kosong lalu edit file .env dibagian ini,
jika ada tanda # hilangkan

```bash
database.default.hostname = localhost
database.default.database = coba1
database.default.username = senpai
database.default.password = tuyulliar
database.default.DBDriver = MySQLi

# database.tests.hostname = localhost
# database.tests.database = ci4
# database.tests.username = root
# database.tests.password = root
# database.tests.DBDriver = MySQLi
```

lalu lakukan perintah migrate
```bash
php spark migrate
```

## URL API
list URL API

```bash
localhost/user
localhost/keranjang
localhost/pembayaran
localhost/produk
localhost/transaksi
