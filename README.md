# ePOS

## Installation

### Run terminal clone from GitHub repository
```bash
git clone https://github.com/MunyRoth/e-pos-server.git
cd e-pos-server
composer install
cp .env.example .env
```

### Configuration .env

Make sure you are replace your database in .env

### Run terminal
```bash
php artisan key:generate
php artisan migrate --seed
php artisan passport:install
php artisan serve
```
