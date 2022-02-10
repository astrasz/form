# form



## Getting started

```
$ git clone https://github.com/astrasz/task-symfony
$ cd form
$ composer install
```

After configuring web and mysql server and .env file

```
$ bin/console doctrine:database:create 
$ bin/console make:migration
$ bin/console doctrine:migrations:migrate
$ bin/console doctrine:fixtures:load --force
```
