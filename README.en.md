<img src="public/assets/images/CONTROLES.png" width="100%">

***
Developed in Laravel 9!

The **Controles** system was developed to make life easier for IT professionals.

All necessary information within the department is stored here, bringing reliability and agility in decision making.

***
### Functions/Modules
***
#### 1 - Users
- Each system user has:
  - Access level;
  - Responsibility for each Environment/Building;
  - Preventive review due alerts;
  - Software licensing expiration alerts;
  - Complete registration of personal information;

#### 2 - Ambience
- Ambiences have a full inventory of Hardware, Software and more.

#### 3 - Preventive Maintenance
- All ambiences have the possibility to define a preventive maintenance frequency *(recurring and by level of complexity)* .
- The activities that must be carried out are separated by level, each level having its own recurrence;

#### 4 - Software
- License Management;
- Installed Software Inventory:
  - On operational system created (image);
  - In the ambience;

#### 5 - Hardware
- Inventory of:
  - Computers
    - General information
     - Equipment Type, RAM, Hard Drive, Processor, GPU ...
  - Projectors:
    - Ambience infrastructure = HDMI/VGA;
    - Datasheet;
    - General information;
  - Printers;
    - Network information;
    - Lease agreement information;
  - Punch Clock;
  - Turnstiles;

#### 6 - Security
  - One active login per user. Upon device the previous login device will be logged out.
  - 2FA - the user receives a 6-digit code in their email to complete the login.
    - To enable this function, it is necessary to make changes to the ``.env`` file
  - Automatic blocking due to inactivity, this setting is available in the user's profile;
  - User password request to view software license details;

#### 7 - Other Modules
- Dashboard;
  - All information in one place;
- Providers;
  - Informations of your providers of software, hardware and etc;
- Personal Notes;
  - A personal place to create your notes or reminders;
- Bug Reports;
  - A tool to facilitate troubleshooting;
- Extend due date;
  - If necessary, the Administrator can change the due date of the activities without harming the indicators;
- System Log;
  - All due date changes are recorded in the log. *(Other information will be added in the future)*;
- Operating system images created;
  - An inventory for images created from a particular operating system, with software list and image versioning
- Groups and Roles;
  - User access permissions to system modules;

***
### Setting Up
***
#### Web server Setup
1. Install Apache   
    `$ sudo apt update`   
    `$ sudo apt install apache2`

2. Install MySQL Server   
    `$ sudo apt install mysql-server`

3. Install PHP     
    `$ sudo apt install php7.0 libapache2-mod-php7.0 php-mysql7.0`

#### Project/Database Setup
1. Run `git clone https://github.com/gelbcke/controles.git`
2. Create a MySQL database for the project
    * ```mysql -u root -p```   
    * ```create database controles;```

3. Create user and give privileges
    * ```CREATE USER 'controles'@'localhost' IDENTIFIED BY 'your_password_here';```
    * ```GRANT ALL PRIVILEGES ON controles.* TO 'controles'@'localhost';```  
    * ```quit;```

#### Final Setup
1. Go to folder project
   * `cd /var/www/html/controles`
2. From the projects root run
   * `sudo cp .env.example .env`
3. Configure your `.env` file
4. From the projects root folder run
   * `composer install`
   * `php artisan key:generate`
   * `php artisan migrate`
   * `php artisan db:seed`
   * `php artisan optimize`  
   * `composer dump-autoload`

#### Set Folders and Files Permissions
   * ```sudo chmod -R 777 ./```   
   * ```sudo chown -R www-data:www-data ./```   
   * ```sudo find ./ -type f -exec chmod 644 {} \;```   
   * ```sudo find ./ -type d -exec chmod 755 {} \;```
   * ```sudo chgrp -R www-data storage bootstrap/cache```
   * ```sudo chmod -R ug+rwx storage bootstrap/cache```   
   * ```sudo chmod -R 777 ./bootstrap/cache/```

***
### Important Informations
***
#### Credentials from SEED
>- User: admin@controles.com
>- Password: secret

#### Example `.env` file:
```
APP_NAME=Controles
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

2FACTOR_AUTH=false

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=controles
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

#### CRON Tasks
```
* * * * * php /var/www/html/controles/artisan schedule:run
```

***
##### FrontEnd by [Colorlib - Octopus](https://github.com/icdcom/octopus)
