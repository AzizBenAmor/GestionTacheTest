<h1>how to run the app</h1>
if you use linux use this command to install composer and php <br>
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.2)"<br>
and for windows use this command to install <br>
# Run as administrator...<br>
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4')) <br>
then run your XAMPP or laragon <br>
run these command: <br>
composer install<br>
npm i<br>
npm run dev<br>
php artisan migrate<br>
php artisan db:seed <br>
php artisan serve<br>
and you can connect as an admin using this account :<br>
email: admin@gmail.com<br>
password: 12345678
