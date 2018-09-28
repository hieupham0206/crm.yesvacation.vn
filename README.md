### Yêu cầu

1. [Git](https://git-scm.com/downloads)
2. PHP >= 7.1.3
3. [Node LTS](https://nodejs.org/)
4. [Composer](https://getcomposer.org/)
5. [Yarn](https://yarnpkg.com/en/docs/install) 

### Cài đặt

#### Bước 1

1. Clone source từ gitlab, cài đặt thư viện.

```
git clone http://username:password@gitlab.cloudteam.vn/path/source.git
cd source
composer install 
yarn install
```

#### Bước 2

1. Tạo database DB_NAME.

1. Copy file .env từ env/.env.dev
```
cp env/.env.dev .env
```

1. Cập nhật .env
```
DB_DATABASE=DB_NAME
DB_USERNAME=root
DB_PASSWORD=
```

1. Chạy lệnh migrate và seed database.
```
php artisan migrate:fresh --seed | yarn run mfs
```

#### Bước 3

```
php artisan serve | yarn run server
```

### Code

1. Để build js và css, chạy lệnh:

#### Local

```bash
yarn run dev | yarn run watch
```

#### Production

```bash
yarn run prod
```

1. Clean composer autoload

```bash
composer dump-autoload —classmap-authoritative | yarn run dump
```

## Thư viện

### Backend
1. [Ziggy](https://github.com/tightenco/ziggy)
1. [Laravel Permission](https://github.com/spatie/laravel-permission)
1. [Laravel ActivityLog](https://github.com/spatie/laravel-activitylog)
1. [Laravel Excel](https://github.com/Maatwebsite/Laravel-Excel) và [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet)

### Frontend
1. [axios](https://github.com/axios/axios)
1. [datatables](https://datatables.net/)
1. [bootbox](http://bootboxjs.com/)
1. [lodash](https://lodash.com/docs/)
1. [numeral](http://numeraljs.com/)
1. [highcharts](https://github.com/highcharts/highcharts)
1. [jquery](https://jquery.com/)
1. [jquery.alphanum](https://github.com/KevinSheedy/jquery.alphanum)