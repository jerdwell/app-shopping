# To install this project run the next commands in terminal
1. php artisan october:env to create .env file
2. in .env file set the database and email data
3. php artisan october:up to migrate an seed all database
4. php artisan october:passwd to change the password default
5. use the next code /** if ($c >= 0) { if (ctype_xdigit($c) && ctype_xdigit($n)) { $data['codeToName'][$c] = $n; } $data['C'][$c] = $width; }**/ in file vendor/dompdf/dompdf/lib/Cpdf.php:2545
6. In production install [supervisor](http://supervisord.org/installing.html) to keep watching queues with command sudo apt-get install supervisor and follow the [next instructions](https://octobercms.com/docs/services/queues#basic-usage)
7. Set QUEUE_DRIVER in .env to database

<p>Proyect developed by Eduardo Navarrete Erdwell</p>

# Composer Dependencies
1. [Library to handle JWT](https://github.com/firebase/php-jwt)

# Frontend Dependencies
1. [Laravel echo to handle websocket in frontend](https://www.npmjs.com/package/laravel-echo)