# WK-SM-v2
Web Kiosk Server Manager

## Сборка контейнера php-fpm / Nginx 

1. Собираем контейнер `php-fpm / Nginx`
	Пример сборки можно глянуть [тут](https://www.youtube.com/watch?v=Yl7uVEMBLgA&list=PL3D9-9G1ETEpy8DQHrapim_OWjRUoRyOb&ab_channel=%D0%A1%D0%B0%D1%88%D0%BE%D0%BA%D0%93%D0%BE%D1%80%D1%88%D0%BE%D0%BA) , или качнуть с github > [мой вариант](https://github.com/kukarow/WKC_v2/blob/dev/docker/docker-compose.yml) или  [Александра Яковлева](https://github.com/alejandro-yakovlev/symfony-docker)
Обратите внимание что `.env.dist` находятся переменные окружения , файл нужно переименовать в `.env` и поместить рядом.

подымаем - 

```bash
docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env build
```

это та тот случай если возникнет ошибка по типу - 

>```bash
>Добрый день!
>
>При билде проекта docker-compose выдавал ошибку
>
`ERROR: The Compose file '././docker/docker-compose.yml' is invalid because: services.postgres.ports contains an invalid type, it should be a number, or an object services.nginx.ports contains an invalid type, it should be a number, or an object`

>Проблема была решена с помощью аргумента --env-file:

```
`docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env build`
```

[линк на источник](https://github.com/alejandro-yakovlev/symfony-docker/issues/1)

----
2. и так с учётом ошибки  собираем контейнеры 
```bash
```bash
docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env build

```

а теперь их подымаем - 

```bash

```bash
docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env up


## Установка Symfony 

Установка будет проходить с контейнера `php-fpm.`

МЫ можем провалится в контейнер с помощю команд описанных в файле `makefile`  используя `make app_bash`    если возникнут какието проблемы или ошибки  по типу 

`ERROR: The Compose file '././docker/docker-compose.yml' is invalid because: services.postgres.ports contains an invalid type, it should be a number, or an object services.nginx.ports contains an invalid type, it should be a number, or an object`

при том что все контейнеры запущены , то можем залесть в контейнер дедовским методом -  

`phpstorm -> Services` и там уже ищем нужный нам контейнер в который мы хотим залезть , в нашем случае это php-fpm/

Если что это все находится там не далеко гдей  и терминал...

и так , залазим в контейнер - и ставим symfony 
```bash
composer create-project symfony/skeleton:"6.2.*" my_project_directory
```

`my_project_directory` - переименовуем на свой вкус  и лад.

## Настройка БД

Начнем с установки Doctrine (можно глянуть [тут](https://ru.symfony.com.ua/doc/current/doctrine.html))
```
composer require symfony/orm-pack
```

+ видяшку можно [глянуть ](https://www.youtube.com/watch?v=RIQQsWSh2g0&list=PL3D9-9G1ETEpy8DQHrapim_OWjRUoRyOb&index=5&ab_channel=%D0%A1%D0%B0%D1%88%D0%BE%D0%BA%D0%93%D0%BE%D1%80%D1%88%D0%BE%D0%BA)

настраиваем postgres
## Установка API Platform и EasyAdmin

```
$ composer require api admin
```

или глянуть на [офф сайте ](https://symfony.com/doc/6.2/the-fast-track/ru/9-backend.html)

## Создание контроллера для главной страницы

```bash
$ php bin/console make:controller

Choose a name for your controller class (e.g. BravePizzaController):
> HomeController

created: src/Controller/HomeController.php
created: templates/home/index.html.twig
```

```bash
$ nano src/Controller/HomeController.php
```

```php
# src/Controller/HomeController.php

# меняем роут
/**
 * @Route("/", name="app_home")
 */
```


последнее что сделано 
```
php bin/console make:admin:dashboard
```

Дальше создадим первую таблицу -

создадим пользователя -
```bash
php bin/console make:user

```
```bash
 The name of the security user class (e.g. User) [User]:
 > User

 Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
 > yes

 Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
 > email

 Will this app need to hash/check user passwords? Choose No if passwords are not needed or will be checked/hashed by some other system (e.g. a single sign-on server).

 Does this app need to hash/check user passwords? (yes/no) [yes]:
 > yes
```

[источник](https://symfony.com/doc/current/security.html)

---

```
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
```

Создадим CRUD

```
symfony console make:admin:crud
```

добавляем маршрут

```
# config/routes.yaml
dashboard:
    path: /admin
    controller: App\Controller\Admin\DashboardController::index

# ...


## Создадим сущности 

Для соединения с сервером ДЕ :

---

>имя сущности `GetToken`
>поля -
>
`serverDe `
`login`
`password`


---

>имя сущности `GetData`
>поля -
>
`authorizationServer `
`login`
`password` 
`token`


---

**Для позиционирование кабинета :**

>Поля для позиционирования кабинета и выдачи контента в зависимости от данных указанных в `venID` ,`mac`


>имя сущности `virtualRoom`
>поля -
>
>
>`venID` - является уникальным для каждого кабинета.
>
>`mac` - выполняется привязка к виртуальному кабинету.
>
>`status` -`string`  статус  `online` / `offline`
>
>`client address` - `ip` адрес клиента (подтягуется автоматически или указуется принудительно)
>
>`dataRoom` - данные которые выданы данному кабинету.
>
>`video` - контент который нужно выдавать клиенту в случай отсутствия доктора  в кабинете.
>
>`userDesc` - `bool` (выводим инфу, описание врача или нет) 
>
>`userName` - `bool` (выводим или нет ФИО)"Дука Володимир Анатолійович" 
>
>`userPhoto` - `bool` (выводим фото врача или нет)
>
>`userSpeciality` - bool (выводить или нет специализацию врача)
>
`venueName` - `bool` (выводить или нет номер кабинета )
>
>`turnOFFin` - выключить клиента (указываем время)
>
>`turnONin` - включить клиента (указываем время)


>`turnOFFin` - выключить клиента (указываем время)
>`turnONin` - включить клиента (указываем время)
>
>Данная функция будет зависеть от клиента и от поддержки клиентом функции `rtcwake –m`. 
>
>Допускается управление клиентскими машинами средствами `Ansible Semaphore`




>Пример приходящих данных от ДЕ:
>```json
>{
>scheduleStatus: "В процесі"
>userDesc: ""
>userLogin: "v.duka"
>userName: "Дука Володимир Анатолійович"
>userPhoto: "http://10.34.13.254/MediaCache/UserPhoto/UserPhotov.duka.jpg"
>userSpeciality: ""
>venueID: 15
>venueName: "Перев'язувальна 114"
>}
>
>```


```
php bin/console make:migration
```

If everything worked, you should see something like this:

```
SUCCESS!

Next: Review the new migration "migrations/Version20211116204726.php"
Then: Run the migration with php bin/console doctrine:migrations:migrate
```

If you open this file, it contains the SQL needed to update your database! To run that SQL, execute your migrations:

```
$ php bin/console doctrine:migrations:migrate
```

[источник](https://symfony.com/doc/current/doctrine.html)

## ## [Генерация формы входа](https://symfony.com/doc/5.2/security/form_login_setup.html#generating-the-login-form "Постоянная ссылка на этот заголовок")


Просмотрим пути -
`php bin/console debug:router`


Создание мощной формы входа можно запустить с помощью `make:auth`команды из [MakerBundle](https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html) . В зависимости от вашей настройки вам могут быть заданы разные вопросы, и ваш сгенерированный код может немного отличаться:

```
$ php bin/console make:auth

What style of authentication do you want? [Empty authenticator]:
 [0] Empty authenticator
 [1] Login form authenticator
> 1

The class name of the authenticator to create (e.g. AppCustomAuthenticator):
> LoginFormAuthenticator

Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
> SecurityController

Do you want to generate a '/logout' URL? (yes/no) [yes]:
> yes

 created: src/Security/LoginFormAuthenticator.php
 updated: config/packages/security.yaml
 created: src/Controller/SecurityController.php
 created: templates/security/login.html.twig
```

[пример](https://www.youtube.com/watch?v=M-ehiNixBvM&list=PLqhuffi3fiMOA4dBrBHAhfNGlxfA9MCJh&ab_channel=OverSeasMedia)
тайм код 2.00

>[!warning]
>Ознакомится с данной командой !!!
>Обновляем внесеные изменения в бд(но это не точно)
>
>```php
>php bin/console doctrine:schema:update --force
>```
>[пример](https://www.youtube.com/watch?v=M-ehiNixBvM&list=PLqhuffi3fiMOA4dBrBHAhfNGlxfA9MCJh&ab_channel=OverSeasMedia)
тайм код 2.00

---



>[!Warning]
>Обнаружен момент с правами доступа к файлам на изменение.
>`security.yaml symfony clean readonly status`
>
>**Лекарство**
>`sudo chown -R $(whoami) config/packages/security.yaml
`

>[!info]
>Поверхносно * [глянуть](https://symfony.com.ua/doc/current/security.html)

Для получения пароля для админа , генерируем его следующей командой -

```
php bin/console security:encode-password

```

>[!info]
>ввел пароль `10242048`
>в ответ увидите что-то похожее -
> ---
  `Key             Value `  
  >                                                         
 >---
 >
  `Hasher used     Symfony\Component\PasswordHasher\Hasher\MigratingPasswordHasher`
  >  
 `Password hash`    `$2y$13$8QsF6kQDKNy/MV/NuD6IIO6kE1u3BZFIoxivjn8Jmm/Log.POOtqy`   
  >  
 >--- 
 >


Копируем сгенереный код , и добавляем в БД.

Должно получится что-то типа такого -

```sql
symfony.public> INSERT INTO public."user" (id, email, roles, password) VALUES (1, 'kukarowwwww@gmail.com', '["ROLE_USER"]', '$2y$13$8QsF6kQDKNy/MV/NuD6IIO6kE1u3BZFIoxivjn8Jmm/Log.POOtqy')
[2023-08-16 17:19:47] 1 row affected in 10 ms
symfony.public> SELECT t.*
                FROM public."user" t
                ORDER BY email
                LIMIT 501
[2023-08-16 17:19:47] 1 row retrieved starting from 1 in 21 ms (execution: 4 ms, fetching: 17 ms)
```


Истественно* команды выполняем с контейнера .
детали смотрим на [канале с тайм кодом 4:00](https://youtu.be/M-ehiNixBvM?list=PLqhuffi3fiMOA4dBrBHAhfNGlxfA9MCJh&t=240) и [офф сайте](https://symfony.com/doc/4.1/security.html)

[ Setting up or Fixing File Permissions](https://symfony.com/doc/current/setup/file_permissions.html)

Проверим пути -
```
php bin/console debug:router
```

```
 api_genid                                      ANY      ANY      ANY    /api/.well-known/genid/{id}          
  api_entrypoint                                 ANY      ANY      ANY    /api/{index}.{_format}               
  api_doc                                        ANY      ANY      ANY    /api/docs.{_format}                  
  api_jsonld_context                             ANY      ANY      ANY    /api/contexts/{shortName}.{_format}  
  _api_/virtual_rooms/{id}{._format}_get         GET      ANY      ANY    /api/virtual_rooms/{id}.{_format}    
  _api_/virtual_rooms{._format}_get_collection   GET      ANY      ANY    /api/virtual_rooms.{_format}         
  _api_/virtual_rooms{._format}_post             POST     ANY      ANY    /api/virtual_rooms.{_format}         
  _api_/virtual_rooms/{id}{._format}_put         PUT      ANY      ANY    /api/virtual_rooms/{id}.{_format}    
  _api_/virtual_rooms/{id}{._format}_patch       PATCH    ANY      ANY    /api/virtual_rooms/{id}.{_format}    
  _api_/virtual_rooms/{id}{._format}_delete      DELETE   ANY      ANY    /api/virtual_rooms/{id}.{_format}    
  _preview_error                                 ANY      ANY      ANY    /_error/{code}.{_format}             
  admin                                          ANY      ANY      ANY    /admin                               
  app_login                                      ANY      ANY      ANY    /login                               
  app_logout                                     ANY      ANY      ANY    /logout                              
  dashboard                                      ANY      ANY      ANY    /admin          
```

---

security.yaml

```
access_control:  
    # - { path: ^/admin, roles: ROLE_ADMIN }  
    # - { path: ^/profile, roles: ROLE_USER }
```
Вносим изменения -
```
access_control:  
     - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }  
     - { path: ^/, roles: IS_AUTHENTICATED_FULLY }
```
`Уточнить статус проекта/security.yaml`

---


## Админ панель


```php


namespace App\Controller\Admin;  
use App\Entity\GetToken;  
use App\Entity\GetData;  
use App\Entity\VirtualRoom;  
  
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;  
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;  
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;  
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Routing\Annotation\Route;  
  
class DashboardController extends AbstractDashboardController  
{

#[Route('/admin', name: 'admin')]  
public function index(): Response  
{  
   // return parent::index();  
   return $this->render('admin/dashboard.html.twig');  
  
	}
}
```

Создаем `admin/dashboard.html.twig` . Полный путь `templates/admin/dashboard.html.twig`

если нет директории `admin` - создайте.
если проблемы с правами - используйте:
```
sudo chown -R $(whoami) templates/
```

В файле `admin/dashboard.html.twig`

```php
//-
{% extends "@EasyAdmin/page/content.html.twig" %}
//-
```


Для вывода наших сущностей и работе с ними в админ панели , начнем с
```
php bin/console make:admin:crud

```
Укажем с какой хотим сущностью будем работать -

```
bash-5.1# php bin/console make:admin:crud

 Which Doctrine entity are you going to manage with this CRUD controller?:
  [0] App\Entity\GetData
  [1] App\Entity\GetToken
  [2] App\Entity\User
  [3] App\Entity\VirtualRoom
 > 3

```

Создаем контроллер для сущности `VirtualRoom`

и быстренько подключаем новый контроллер

```php
<?php  
  
namespace App\Controller\Admin;  
use App\Entity\GetToken;  
use App\Entity\GetData;  
use App\Entity\VirtualRoom;  
  
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;  
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;  
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;  
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Routing\Annotation\Route;  
  
class DashboardController extends AbstractDashboardController  
{  
  
  
    #[Route('/admin', name: 'admin')]  
    public function index(): Response  
    {  
       // return parent::index();  
         return $this->render('admin/dashboard.html.twig');  
  
    }  
  
    public function configureDashboard(): Dashboard  
    {  
        return Dashboard::new()  
            ->setTitle('Www');  
        //->setTitle('ACME Corp.');  
    }  
  
    public function configureMenuItems(): iterable  
    {  
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');  
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);  
        // yield MenuItem::linkToCrud('The Users', 'fas fa-list', EntityClass::class);       // yield MenuItem::linkToCrud('VirtualRoom', 'fas fa-list', VirtualRoom::class);  
        // yield MenuItem::linkToDashboard('VirtualRoom', 'fa fa-home');         yield MenuItem::linkToCrud('VirtualRoom', 'fa fa-file-text', VirtualRoom::class);  
  
  
        return [  
            MenuItem::linkToCrud('VirtualRoom', 'fa fa-file-text', VirtualRoom::class),  
       //     MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),  
  
     //       MenuItem::section('VirtualRoom'),      //      MenuItem::linkToCrud('VirtualRoom', 'fa fa-tags', VirtualRoom::class),         //   MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', BlogPost::class),  
         //   MenuItem::section('Users'),          //  MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),           // MenuItem::linkToCrud('Users', 'fa fa-user', User::class),        ];  
    }  
}
```

** Кастумизируем `GetTokenCrudController` ** 

```php

namespace App\Controller\Admin;  
  
use App\Entity\GetToken;  
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;  
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;  
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;  
  
class GetTokenCrudController extends AbstractCrudController  
{  
    public static function getEntityFqcn(): string  
    {  
        return GetToken::class;  
    }  
  
    public function configureCrud(Crud $crud): Crud  
    {  
        return $crud  
            ->setEntityLabelInSingular('Налаштування')  
            ->setEntityLabelInPlural('Параметри для отримання ключа')  
            ->setPageTitle('index', 'Налаштування з сервером ДЕ, для отримання токена')  
  
        ->setPaginatorPageSize(10);  
    }  
    public function configureFields(string $pageName): iterable  
    {  
        return [  
            IdField::new('id')->hideOnForm(),  
           // IdField::new('serverDe','lol'),  
  
            TextField::new('serverDe','Адресса сервера')->hideOnDetail(),  
  
           // DateTimeField::new('srverDe','Адресса сервера dthhjdghjdgfhjdf')->onlyOnDetail(),  
            TextField::new('login','Логін'),  
            TextField::new('password','Пароль'),  
           // TextEditorField::new('Login'),  
        ];  
    }  
  
}
```

**Кастумизируем `GetDataCrudController` **

```php
<?php  
  
namespace App\Controller\Admin;  
  
use App\Entity\GetData;  
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;  
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;  
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;  
  
class GetDataCrudController extends AbstractCrudController  
{  
    public static function getEntityFqcn(): string  
    {  
        return GetData::class;  
    }  
    public function configureCrud(Crud $crud): Crud  
    {  
        return $crud  
            ->setEntityLabelInSingular('Налаштування')  
            ->setEntityLabelInPlural('Параметри для отримання данних')  
            ->setPageTitle('index', 'Налаштування з сервером ДЕ, для отримання данних')  
  
            ->setPaginatorPageSize(10);  
    }  
  
    public function configureFields(string $pageName): iterable  
    {  
        return [  
            IdField::new('id')->hideOnForm(),  
            TextField::new('authorizationServer','Сервер авторизації'),  
            TextField::new('login','Логін'),  
            TextField::new('password','Пароль'),  
            TextField::new('token','Токен')  
           // TextEditorField::new('description'),  
        ];  
    }  
  
}
```

**Кастумизируем `VirtualRoomCrudController` **

```php
namespace App\Controller\Admin;  
  
use App\Entity\VirtualRoom;  
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;  
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;  
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;  
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;  
  
class VirtualRoomCrudController extends AbstractCrudController  
{  
    public static function getEntityFqcn(): string  
    {  
        return VirtualRoom::class;  
    }  
  
    public function configureCrud(Crud $crud): Crud  
    {  
        return $crud  
            ->setEntityLabelInSingular('Кабінет')  
            ->setEntityLabelInPlural('Параметри для налаштування кабінета')  
            ->setPageTitle('index', 'Параметри віртуальних кабінетів')  
  
            ->setPaginatorPageSize(20);  
    }  
    public function configureFields(string $pageName): iterable  
    {  
        return [  
           // IdField::new('id')->hideOnForm(),  
            FormField::addTab('Налаштування кабінета','wrench'),  
  
            //IdField::new('id','ID')->hideOnIndex(),  
            //TextField::new('id','ID'),            TextField::new('venID','VenID'),  
            TextField::new('mac','MAC'),  
            TextField::new('status','Статус'),  
            TextField::new('clientAddress','IP адреса'),  
            TextField::new('dataRoom','Данні кабінета'),  
  
  
            FormField::addTab('Відображення інформації','info'),  
            BooleanField::new('userDesc','Відображати опис лікаря?')->hideOnIndex(),  
            BooleanField::new('userName','Відображати П.І.Б ?')->hideOnIndex(),  
            BooleanField::new('userPhoto','Відображати фото ?')->hideOnIndex(),  
            BooleanField::new('userSpeciality','Відображати спеціалізацію лікаря ?')->hideOnIndex(),  
            BooleanField::new('venueName','Відображати номер кабінета ?')->hideOnIndex(),  
  
            FormField::addTab('Налаштування живлення','plug'),  
            TimeField::new('turnOFFin','Час увімкненя клієнта')->hideOnIndex(),  
            TimeField::new('turnONin','Час вимкнення клієнта')->hideOnIndex(),  
  
            FormField::addTab('Відео контент','video'),  
            TextField::new('video','Відео')->hideOnIndex(),  
            //TextEditorField::new('description'),  
        ];  
    }  
  
}
```
>[!warning]
>Обратить внимание на какой-то там косяк , php ругается на 
>`use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;`
>
При использовании `TimeField`  и`DataTimeField`  -ругается .
>
>Добавлено в  `php-fpm/Dockerfilee`
```
# Install intl extension  
RUN apk add --no-cache \  
    icu-dev \  
    && docker-php-ext-install -j$(nproc) intl \  
    && docker-php-ext-enable intl \  
    && rm -rf /tmp/*  
  
RUN apk add --update linux-headers
```
>[!tip]
>>[Конфиг тянул для правки c github](https://gist.github.com/evansims/280d63378c9f422f7b5d72e6d16f3806)
>>Все равно ругается . `php intl`

---

Обратите внимание на - 
```
TimeField::new('turnOFFin','Час увімкненя клієнта')->hideOnIndex(),  
TimeField::new('turnONin','Час вимкнення клієнта')->hideOnIndex(),
```

[https://symfony.com/bundles/EasyAdminBundle](https://symfony.com/bundles/EasyAdminBundle/current/fields/DateTimeField.html)
[https://symfony.com/bundles/EasyAdminBundle](https://symfony.com/bundles/EasyAdminBundle/current/fields/TimeField.html)

---


Для сборки админ панели или ознакомления , можно глянуть французов-
[вариант 1.](https://www.youtube.com/watch?v=LVK0VQGtJR8&ab_channel=D%C3%A9veloppeurMuscl%C3%A9)
[вариант 2.](https://www.youtube.com/watch?v=6T8d1HFDaBk&ab_channel=D%C3%A9veloppeurMuscl%C3%A9)
[вариант 3.](https://www.youtube.com/watch?v=ze6XJTACo1s&ab_channel=Pentiminax)

---

[вариант 4.](https://www.youtube.com/watch?v=BbbZOdsMMg0&list=PLrVW8QdFhIiA1da1zOhnhmAMqYoeyGKxV&index=4&ab_channel=DavidEntraide)
[вариант 5.](https://www.youtube.com/@developpeur.muscle/videos)
[вариант 6.  глянуть желательно](https://www.youtube.com/watch?v=4dmsUalc5Ds&ab_channel=YoanDev)

>[!tip]
>По иконкам - гугл -> `fa fa home` и в итоге линки на [https://fontawesome.com/](https://fontawesome.com/icons/house?f=classic&s=solid)


## Добавление полей в сущность 

Добавим необходимые поля в сущность `VirtualRoom`

`background` - задний фон
`docFree` - доктор свободен (картинка)
`docBusy` - доктор занят (картинка)
`wait` -  подождите (картинка)

````
$ php bin/console make:entity
````

```bash

bash-5.1# php bin/console make:entity

 Class name of the entity to create or update (e.g. AgreeablePizza):
 > virtualRoom

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > background

 Field type (enter ? to see all types) [string]:
 > string

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/VirtualRoom.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > docFree

 Field type (enter ? to see all types) [string]:
 > string

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/VirtualRoom.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > docBusy

 Field type (enter ? to see all types) [string]:
 > string

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/VirtualRoom.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > wait

 Field type (enter ? to see all types) [string]:
 > string

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/VirtualRoom.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 

```

обновим базу -

````
php bin/console make:migration
````
```
php bin/console doctrine:migrations:migrate
```

В случай ошибки по типу 

```bash
In Connection.php line 70:
                                                                                     
  SQLSTATE[42P07]: Duplicate table: 7 ERROR:  relation "user_id_seq" already exists  
                                                                                     

```

Лекарство - 


Use `doctrine:schema:update` with the `--complete` parameter to fully sync the database with your entities.

```php
app/console doctrine:schema:update --force --complete
```

or

```php
app/console doctrine:schema:update --dump-sql --complete
```

`php bin/console doctrine:schema:update --force --complete`

`php bin/console doctrine:schema:update --dump-sql --complete`

На выходе имеем примерно следующий вид -
```php
<?php  
  
namespace App\Entity;  
  
use ApiPlatform\Metadata\ApiResource;  
use App\Repository\VirtualRoomRepository;  
use Doctrine\ORM\Mapping as ORM;  
  
#[ORM\Entity(repositoryClass: VirtualRoomRepository::class)]  
#[ApiResource]  
class VirtualRoom  
{  
    #[ORM\Id]  
    #[ORM\GeneratedValue]  
    #[ORM\Column]  
    private ?int $id = null;  
  
    #[ORM\Column(length: 255)]  
    private ?string $venID = null;  
  
    #[ORM\Column(length: 255)]  
    private ?string $mac = null;  
  
    #[ORM\Column(length: 255, nullable: true)]  
    private ?string $status = null;  
  
    #[ORM\Column(length: 255, nullable: true)]  
    private ?string $clientAddress = null;  
  
    #[ORM\Column(length: 255, nullable: true)]  
    private ?string $dataRoom = null;  
  
    #[ORM\Column(length: 255, nullable: true)]  
    private ?string $video = null;  
  
    #[ORM\Column]  
    private ?bool $userDesc = null;  
  
    #[ORM\Column]  
    private ?bool $userName = null;  
  
    #[ORM\Column]  
    private ?bool $userPhoto = null;  
  
    #[ORM\Column]  
    private ?bool $userSpeciality = null;  
  
    #[ORM\Column]  
    private ?bool $venueName = null;  
  
    #[ORM\Column(length: 20)]  
    private ?string $turnOFFin = null;  
  
    #[ORM\Column(length: 20)]  
    private ?string $turnONin = null;  
  
    #[ORM\Column(length: 255)]  
    private ?string $background = null;  
  
    #[ORM\Column(length: 255)]  
    private ?string $docFree = null;  
  
    #[ORM\Column(length: 255)]  
    private ?string $docBusy = null;  
  
    #[ORM\Column(length: 255)]  
    private ?string $wait = null;  
  
    public function getId(): ?int  
    {  
        return $this->id;  
    }  
  
    public function getVenID(): ?string  
    {  
        return $this->venID;  
    }  
  
    public function setVenID(string $venID): static  
    {  
        $this->venID = $venID;  
  
        return $this;  
    }  
  
    public function getMac(): ?string  
    {  
        return $this->mac;  
    }  
  
    public function setMac(string $mac): static  
    {  
        $this->mac = $mac;  
  
        return $this;  
    }  
  
    public function getStatus(): ?string  
    {  
        return $this->status;  
    }  
  
    public function setStatus(?string $status): static  
    {  
        $this->status = $status;  
  
        return $this;  
    }  
  
    public function getClientAddress(): ?string  
    {  
        return $this->clientAddress;  
    }  
  
    public function setClientAddress(?string $clientAddress): static  
    {  
        $this->clientAddress = $clientAddress;  
  
        return $this;  
    }  
  
    public function getDataRoom(): ?string  
    {  
        return $this->dataRoom;  
    }  
  
    public function setDataRoom(?string $dataRoom): static  
    {  
        $this->dataRoom = $dataRoom;  
  
        return $this;  
    }  
  
    public function getVideo(): ?string  
    {  
        return $this->video;  
    }  
  
    public function setVideo(?string $video): static  
    {  
        $this->video = $video;  
  
        return $this;  
    }  
  
    public function isUserDesc(): ?bool  
    {  
        return $this->userDesc;  
    }  
  
    public function setUserDesc(bool $userDesc): static  
    {  
        $this->userDesc = $userDesc;  
  
        return $this;  
    }  
  
    public function isUserName(): ?bool  
    {  
        return $this->userName;  
    }  
  
    public function setUserName(bool $userName): static  
    {  
        $this->userName = $userName;  
  
        return $this;  
    }  
  
    public function isUserPhoto(): ?bool  
    {  
        return $this->userPhoto;  
    }  
  
    public function setUserPhoto(bool $userPhoto): static  
    {  
        $this->userPhoto = $userPhoto;  
  
        return $this;  
    }  
  
    public function isUserSpeciality(): ?bool  
    {  
        return $this->userSpeciality;  
    }  
  
    public function setUserSpeciality(bool $userSpeciality): static  
    {  
        $this->userSpeciality = $userSpeciality;  
  
        return $this;  
    }  
  
    public function isVenueName(): ?bool  
    {  
        return $this->venueName;  
    }  
  
    public function setVenueName(bool $venueName): static  
    {  
        $this->venueName = $venueName;  
  
        return $this;  
    }  
  
    public function getTurnOFFin(): ?string  
    {  
        return $this->turnOFFin;  
    }  
  
    public function setTurnOFFin(string $turnOFFin): static  
    {  
        $this->turnOFFin = $turnOFFin;  
  
        return $this;  
    }  
  
    public function getTurnONin(): ?string  
    {  
        return $this->turnONin;  
    }  
  
    public function setTurnONin(string $turnONin): static  
    {  
        $this->turnONin = $turnONin;  
  
        return $this;  
    }  
    public function getBackground(): ?string  
    {  
        return $this->background;  
    }  
    public function setBackground(string $background): static  
    {  
        $this->background = $background;  
  
        return $this;  
    }  
  
    public function getDocFree(): ?string  
    {  
        return $this->docFree;  
    }  
  
    public function setDocFree(string $docFree): static  
    {  
        $this->docFree = $docFree;  
  
        return $this;  
    }  
  
    public function getDocBusy(): ?string  
    {  
        return $this->docBusy;  
    }  
  
    public function setDocBusy(string $docBusy): static  
    {  
        $this->docBusy = $docBusy;  
  
        return $this;  
    }  
  
    public function getWait(): ?string  
    {  
        return $this->wait;  
    }  
  
    public function setWait(string $wait): static  
    {  
        $this->wait = $wait;  
  
        return $this;  
    }  
}
```


Добавляем слежующие поля в класс `VirtualRoomCrudController`
```php
FormField::addTab('Налаштування сторінки клієнта','image'),  
ImageField::new('background','зображення заднього фону')->setUploadDir(uploadDirPath: 'uploads/images/'),  
ImageField::new('docFree', 'зображенння - лікар вільний')->setUploadDir(uploadDirPath: 'uploads/images/')->hideOnIndex(),  
ImageField::new('docBusy', 'зображення - лікар зайнятий')->setUploadDir(uploadDirPath: 'uploads/images/')->hideOnIndex(),  
ImageField::new('wait','зображення - статус зачекайте')->setUploadDir(uploadDirPath: 'uploads/images/')->hideOnIndex(),
```
>[!tip]
>После загрузки фото в созданые поля возможна ошибка 
>```
># You cannot guess the extension as the Mime component is not installed. Try >running "composer require symfony/mime".
>```
>Значит лечим установкой `composer require symfony/mime`

## Правка отображения image. (ImageField)

[## [Field Types](https://symfony.com/bundles/EasyAdminBundle/current/fields.html#field-types "Permalink to this headline")](## [Field Types](https://symfony.com/bundles/EasyAdminBundle/current/fields.html#field-types "Permalink to this headline"))

[# Поле изображения EasyAdmin](https://symfony.com/bundles/EasyAdminBundle/current/fields/ImageField.html)

Внесем изменения в класс `VirtualRoomCrudController`

интересует поле `background`

```php

// --


public function configureFields(string $pageName): iterable  
{  
    return array(  


         // --


        //TextEditorField::new('description'),  
        FormField::addTab('Налаштування сторінки клієнта','image'),  
  
        ImageField::new('background','зображення заднього фону')  
            ->setBasePath('uploads/images/')  
            ->setUploadDir(uploadDirPath: 'public/uploads/images/')  
            ->setSortable(false)  
            ->setFormTypeOption('required',false),  
  
        ImageField::new('docFree', 'зображенння - лікар вільний')  
            ->setBasePath('uploads/images/')  
            ->setUploadDir(uploadDirPath: 'public/uploads/images/')  
            ->setSortable(false)  
            ->setFormTypeOption('required' ,false),  
        ImageField::new('docBusy', 'зображення - лікар зайнятий')  
            ->setBasePath('uploads/images/')  
            ->setUploadDir(uploadDirPath: 'public/uploads/images/')  
            ->setSortable(false)  
            ->setFormTypeOption('required' ,false),  
        ImageField::new('wait','зображення - статус зачекайте')  
            ->setBasePath('uploads/images/')  
            ->setUploadDir(uploadDirPath: 'public/uploads/images/')  
            ->setSortable(false)  
            ->setFormTypeOption('required' ,false),  
  
    );  
}
```


Коректное отображение изображений в админ панели восстановленно. 

В вот  в режиме редактирования кабинета пока что изображение не отображается , мы к этому параметру вернемся немного пожее.

>[!tip]
>**Информация бралась с источников :**
>
>---
[### **The imageFile image field must define the directory**](https://devbrains.tn/tutorials/the-imagefile-image-field-must-define-the-directory)
>
>---
[### **Upload Image with Vich Bundle**](https://devbrains.tn/tutorials/upload-image-with-vich-bundle)
>
>---
[# Upload Fields](https://symfonycasts.com/screencast/easyadminbundle/upload)
>
>---
[## [Field Types]](https://symfony.com/bundles/EasyAdminBundle/current/fields.html#field-types "Permalink to this headline")
>
>---
[vichuploader symfony 6](https://www.google.com/search?q=vichuploader+symfony+6&sca_esv=559110719)
>
>---
[# How To Upload Files Using API Platform & VichUploader | Symfony](https://www.youtube.com/watch?v=E8hdiWtLKLU&ab_channel=DevBrains)
>
>---
[# Upload d'images avec VichUploader et EasyAdmin 4](https://www.youtube.com/watch?v=SlF9Wxyx0O8&ab_channel=LucasLuk)
>
>---
[# Gagner du temps avec EasyAdmin - Un projet Symfony de A à Z - FreeReads #06](https://www.youtube.com/watch?v=4dmsUalc5Ds&t=1478s&ab_channel=YoanDev)



## Добавление полей в сущность `virtual_Room` 

Для полей `user_desc`  и `user_speciality` в сущности `virtual_Room`

для ограничения выводящего текста необходимо добавить 2 поля -

`userDescMaxLengthText` - можно и в базе ограничить количество символов , но для удобства заказчика данный параметр вынесем в админ панель.
`userSpecialityMaxLengthText` -можно и в базе ограничить количество символов , но для удобства заказчика данный параметр вынесем в админ панель.

Выполним добавление полей - 

````
$ php bin/console make:entity
````

```
 Class name of the entity to create or update (e.g. GentlePuppy):
 > virtualRoom

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > userDescMaxLengthTex

 Field type (enter ? to see all types) [string]:
 > string

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/VirtualRoom.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > userSpecialityMaxLengthText

 Field type (enter ? to see all types) [string]:
 > string

 Field length [255]:
 > 

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/VirtualRoom.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

```

обновим базу -

````
php bin/console make:migration
````
```
php bin/console doctrine:migrations:migrate
```


Тутже ругань  по типу - 


```
[notice] Migrating up to DoctrineMigrations\Version20230824140423
[error] Migration DoctrineMigrations\Version20230824140423 failed during Execution. Error: "An exception occurred while executing a query: SQLSTATE[23502]: Not null violation: 7 ERROR:  column "background" of relation "virtual_room" contains null values"
[critical] Error thrown while running command "doctrine:migrations:migrate". Message: "An exception occurred while executing a query: SQLSTATE[23502]: Not null violation: 7 ERROR:  column "background" of relation "virtual_room" contains null values"

In ExceptionConverter.php line 47:
                                                                                                                                                              
  An exception occurred while executing a query: SQLSTATE[23502]: Not null violation: 7 ERROR:  column "background" of relation "virtual_room" contains null  
   values                                                                                                                                                     
                                                                                                                                                              

In Exception.php line 28:
                                                                                                                      
  SQLSTATE[23502]: Not null violation: 7 ERROR:  column "background" of relation "virtual_room" contains null values  
                                                                                                                      

In Connection.php line 70:
                                                                                                                      
  SQLSTATE[23502]: Not null violation: 7 ERROR:  column "background" of relation "virtual_room" contains null values  
                                                                                                                      
```


А в миграциях вот такая штука - 
```php

public function up(Schema $schema): void  
{  
    // this up() migration is auto-generated, please modify it to your needs  
    $this->addSql('ALTER TABLE virtual_room ADD user_desc_max_length_tex VARCHAR(255)  NULL');  
    $this->addSql('ALTER TABLE virtual_room ADD user_speciality_max_length_text VARCHAR(255) NULL');  
    $this->addSql('ALTER TABLE virtual_room ALTER background SET NOT NULL');  
    $this->addSql('ALTER TABLE virtual_room ALTER doc_free SET NOT NULL');  
    $this->addSql('ALTER TABLE virtual_room ALTER doc_busy SET NOT NULL');  
    $this->addSql('ALTER TABLE virtual_room ALTER wait SET NOT NULL');  
}
```


поправим миграцию немного -

```php
public function up(Schema $schema): void  
{  
    // this up() migration is auto-generated, please modify it to your needs  
    $this->addSql('ALTER TABLE virtual_room ADD user_desc_max_length_tex VARCHAR(255)  NULL');  
    $this->addSql('ALTER TABLE virtual_room ADD user_speciality_max_length_text VARCHAR(255) NULL');  
 //   $this->addSql('ALTER TABLE virtual_room ALTER background SET NOT NULL');  
 //   $this->addSql('ALTER TABLE virtual_room ALTER doc_free SET NOT NULL'); //   $this->addSql('ALTER TABLE virtual_room ALTER doc_busy SET NOT NULL'); //   $this->addSql('ALTER TABLE virtual_room ALTER wait SET NOT NULL');}
```
>[!tip]
>Черт его знает правильно или нет , но пока вроде работает .


Добавим наши новые поля в админ панель - 
```php

public function configureFields(string $pageName): iterable  
{  
    return array(  

//--

        FormField::addTab('Відображення інформації','info'),  
        BooleanField::new('userDesc','Відображати опис лікаря?')->hideOnIndex(),  
        TextField::new('userDescMaxLengthTex','Яку кількість символів відображати в описі лікаря?')->hideOnIndex(),  
        BooleanField::new('userName','Відображати П.І.Б ?')->hideOnIndex(),  
        BooleanField::new('userPhoto','Відображати фото ?')->hideOnIndex(),  
        BooleanField::new('userSpeciality','Відображати спеціалізацію лікаря ?')->hideOnIndex(),  
        TextField::new('userSpecialityMaxLengthText','Яку кількість символів відображати в спеціалізації лікаря ?')->hideOnIndex(),  
        BooleanField::new('venueName','Відображати номер кабінета ?')->hideOnIndex(),  
  
//--

  
    );  
}

## Подымаем RebbitMQ

Пока по простому , для теста подымем  .

Значит в наш старый `**docker-compose.yml**`
добавим следующий блок - 

```
services:
  rabbitmq:
    image: rabbitmq:3.10.7-management
    ports:
      - 15672:15672
```
И попытаемся запустить - 

`docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env up`


в итоге получим доступ по адресу `http://127.0.0.1:15672/#/`

Теперь можем авторизоваться в веб-интерфейсе. Логин и пароль по умолчанию — `guest/guest`

>[!Tip]
>Источники:
> [Просто и все на пальцах https://habr.com/](https://habr.com/ru/companies/southbridge/articles/704208/)
>
>---
> [Поинтересней и немного боли https://hub.docker.com/](https://hub.docker.com/r/bitnami/rabbitmq)
> 

## Подымаем Ansible Semaphore

Для теста в наш `docker-compose.yml` добавляем :

```
#Ansible Semaphore: Awesome Open Source Ansible GUI  
  mysql:  
    restart: unless-stopped  
    ports:  
      - 3306:3306  
    image: mysql:8.0  
    hostname: mysql  
    volumes:  
      - semaphore-mysql:/var/lib/mysql  
    environment:  
      MYSQL_RANDOM_ROOT_PASSWORD: 'yes'  
      MYSQL_DATABASE: semaphore  
      MYSQL_USER: semaphore  
      MYSQL_PASSWORD: 'semaphore'  
  
  semaphore:  
    restart: unless-stopped  
    ports:  
      - 3000:3000  
    image: semaphoreui/semaphore:latest  
    environment:  
      SEMAPHORE_DB_USER: semaphore  
      SEMAPHORE_DB_PASS: 'semaphore'  
      SEMAPHORE_DB_HOST: mysql # for postgres, change to: postgres  
      SEMAPHORE_DB_PORT: 3306 # change to 5432 for postgres  
      SEMAPHORE_DB_DIALECT: mysql  
      SEMAPHORE_DB: semaphore  
      SEMAPHORE_PLAYBOOK_PATH: /tmp/semaphore/  
      SEMAPHORE_ADMIN_PASSWORD: changeme  
      SEMAPHORE_ADMIN_NAME: admin  
      SEMAPHORE_ADMIN_EMAIL: admin@example.com  
      SEMAPHORE_ADMIN: admin  
      SEMAPHORE_ACCESS_KEY_ENCRYPTION: gs72mPntFATGJs9qK0pQ0rKtfidlexiMjYCH9gWKhTU=  
      SEMAPHORE_LDAP_ACTIVATED: 'no' # if you wish to use ldap, set to: 'yes'  
      SEMAPHORE_LDAP_HOST: dc01.local.example.com  
      SEMAPHORE_LDAP_PORT: '636'  
      SEMAPHORE_LDAP_NEEDTLS: 'yes'  
      SEMAPHORE_LDAP_DN_BIND: 'uid=bind_user,cn=users,cn=accounts,dc=local,dc=shiftsystems,dc=net'  
      SEMAPHORE_LDAP_PASSWORD: 'ldap_bind_account_password'  
      SEMAPHORE_LDAP_DN_SEARCH: 'dc=local,dc=example,dc=com'  
      SEMAPHORE_LDAP_SEARCH_FILTER: "(u0026(uid=%s)(memberOf=cn=ipausers,cn=groups,cn=accounts,dc=local,dc=example,dc=com))"  
    depends_on:  
      - mysql # for postgres, change to: postgres  
  
  
  
volumes:  
  db_data:  
  semaphore-mysql: # to use postgres, switch to: semaphore-postgres
```


И попытаемся запустить - 

`docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env up`

И стучимся на `http://127.0.0.1:3000/` 

Забыл логин и пароль , но вроде это он 
```
SEMAPHORE_ADMIN_PASSWORD: changeme 
SEMAPHORE_ADMIN_NAME: admin
```
Если не он, то искать в куске свеже добавленном в  `docker-compose.yml`

>[!Tip]
>[Пример брался с https://www.virtualizationhowto.com/](https://www.virtualizationhowto.com/2023/06/ansible-semaphore-awesome-open-source-ansible-gui/)
>
>---
>[Также можно глянуть https://hub.docker.com/](https://hub.docker.com/r/semaphoreui/semaphore)
>
>---
[Офф сайт https://docs.ansible-semaphore.com/](https://docs.ansible-semaphore.com/administration-guide/installation)
>
>---
>
[https://computingforgeeks.com/](https://computingforgeeks.com/run-semaphore-ansible-in-docker/)
>
>---
>
[Хард кор на https://github.com/](https://github.com/playniuniu/docker-ansible-semaphore/blob/master/docker-compose.yml)

>[!Warning]
>Удалил все образы и пересобрал контейнеры.
>Желательно проверить .

## Подымаем **Portainer**

Для теста в наш `docker-compose.yml` добавляем :↴

```bash

version: '3'

services:
  portainer:
    image: portainer/portainer-ce:latest
    container_name: portainer
    restart: unless-stopped
    security_opt:
      - no-new-privileges:true
    volumes:
      - /etc/localtime:/etc/localtime:ro
      - /var/run/docker.sock:/var/run/docker.sock:ro
      - ./portainer-data:/data
    ports:
- 9000:9000
```

И попытаемся запустить - 

`docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env up`

Примерный адрес `http://127.0.0.1:9000/#!/init/admin`
логин - `admin`
пароль - `110.220.0.20`

можно поднять с приставкой `-d` то-есть -
`docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env up -d`

>[!Tip]
>Источники использовал [https://bobcares.com/](https://bobcares.com/blog/install-portainer-docker-compose/)
>---
>Глянуть [https://earthly.dev/](https://earthly.dev/blog/portainer-for-docker-container-management/)
>Глянуть [https://www.smarthomebeginner.com/](https://www.smarthomebeginner.com/portainer-docker-compose-guide/)
>---

[[Остановить.Удалить все Docker контейнеры. images]]

## Подымаем **SSL** `certbot`/ `Lets Encrypt`

После настройки `NGINX` мы можем получить сертификаты. Для этого мы воспользуемся контейнером certbot и запустим его с набором параметров.
Для теста в наш `docker-compose.yml` добавляем :


```yaml
  certbot:
    image: certbot/certbot
    container_name: certbot
    volumes: 
      - ./certbot/conf:/etc/letsencrypt
      - ./certbot/www:/var/www/certbot
    command: certonly --webroot -w /var/www/certbot --force-renewal --email {email} -d {domain} --agree-tos
```

Пример настройки `NGINX` и `certbot`
```
version: '3'

services:
  webserver:
    image: nginx:latest
    ports:
      - 80:80
      - 443:443
    restart: always
    volumes:
      - ./nginx/conf/:/etc/nginx/conf.d/:ro
      - ./certbot/www:/var/www/certbot/:ro
      - ./certbot/conf/:/etc/nginx/ssl/:ro
  certbot:
    image: certbot/certbot:latest
    volumes:
      - ./certbot/www/:/var/www/certbot/:rw
      - ./certbot/conf/:/etc/letsencrypt/:rw
```
При попытке сборки билда -
```
docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env build
```
Скорей всего будет ошибка связана с правами доступа по тупу :
```
PermissionError: [Errno 13] Permission denied: '/home/kukarow/PhpstormProjects/WKSM/docker/portainer-data/certs'
[12950] Failed to execute script docker-compose

```
**Лекарство** для ново созданной директории `/portainer-data/certs`

`sudo chown -R $(whoami) docker/portainer-data/certs`

Во избежании проблем для выдачи прав каждому файлу  в директории `/portainer-data/`

Лучше будет -

`sudo chown -R $(whoami) docker/portainer-data/`

Дальше собираем `build`и запускаем -
```
docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env build
```
собрали.
и запускаем -

```
docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env up
```

>[!warning]
>Обратите внимание , что после поднятия контейнеров , у нас упал `aesyAdmin`и`Symfony` Другими словами , у нас отвалилось все что висело на `http://127.0.0.1:888/`
>Ето дело поправим при настройке `NGINX`

Теперь у нас есть два сервиса: один для nginx и один для Certbot. Вы могли заметить, что они заявили об одном и том же объеме. Это сделано для того, чтобы они могли общаться друг с другом.

Certbot запишет свои файлы `./certbot/www/`, а nginx будет предоставлять их по порту `80`каждому пользователю, запрашивающему файлы `/.well-know/acme-challenge/`. Вот как Certbot может аутентифицировать наш сервер.

Обратите внимание, что для Certbot мы использовали `:rw`термин «чтение и запись» в конце объявления тома. Если вы этого не сделаете, он не сможет выполнить запись в папку, и аутентификация не удастся.

Теперь вы можете проверить, что все работает, запустив `docker compose run --rm  certbot certonly --webroot --webroot-path doker/certbot/ --dry-run -d example.org`. Вы должны получить сообщение об успехе, например «Пробный прогон прошел успешно».

Теперь, когда мы можем создавать сертификаты для сервера, мы хотим использовать их в nginx для обработки безопасных соединений с браузерами конечных пользователей.

Certbot создаст сертификаты в `/etc/letsencrypt/`папке. Тот же принцип, что и для веб-корня: мы будем использовать тома для совместного использования файлов между контейнерами.

>[!tip]
>**Лекарство** для ново созданной директории  `docker/certbot/`
>
`sudo chown -R $(whoami) docker/certbot/`
>
>Во избежании проблем для выдачи прав каждому файлу  в директории `docker/certbot/`
>
>Лучше будет -
>
>`sudo chown -R $(whoami) docker/certbot/`

Теперь Nginx должен иметь доступ к папке, в которой Certbot создает сертификаты.

Однако сейчас эта папка пуста. Перезапустите Certbot без `--dry-run`флага, чтобы заполнить папку сертификатами:

```
$ docker compose run --rm  certbot certonly --webroot --webroot-path /var/www/certbot/ -d example.org
```

Поскольку у нас есть эти сертификаты, осталось настроить `443`nginx.

```
server {
    listen 80;
    listen [::]:80;

    server_name example.org www.example.org;
    server_tokens off;

    location /.well-known/acme-challenge/ {
        root /var/www/certbot;
    }

    location / {
        return 301 https://example.org$request_uri;
    }
}

server {
    listen 443 default_server ssl http2;
    listen [::]:443 ssl http2;

    server_name example.org;

    ssl_certificate /etc/nginx/ssl/live/example.org/fullchain.pem;
    ssl_certificate_key /etc/nginx/ssl/live/example.org/privkey.pem;
    
    location / {
    	# ...
    }
}
```
>[!tip]
>обратите внимание на `server_name example.org www.example.org;`
>желательно заменить `www.example.org` . Но пока нам нужно протестировать на роботоспособность. 


---
Посмотреть открытые порты с помощью команды ss

Команда Linux ss предоставляет подробную информацию об открытых портах и прослушиваемых сокетах. Она извлекает информацию из ядра Linux и она более популярна, чем команда netstat, которая уже устарела.

Чтобы отобразить прослушиваемые TCP-соединения, выполните команду  
`$ ss -tl`

 l — показывает прослушиваемые сокеты  
t — означает порт TCP  
Чтобы посмотреть прослушиваемые UDP-соединения, введите команду  
`$ ss -lu`

u — означает порт UDP.  
Или для того, чтобы отобразить tcp и udp одновременно, введите имя процесса  
`$ ss -lntup`  
p — выдает список имен процессов, которые открыли сокеты.  
Чтобы вывести все соединения между сокетами, просто используйте команду ss в ее формате по умолчанию  
`$ ss`
>[!Warning]
>### Ознакомится 
>### Приоритет **↴**
>### [https-using-nginx-certbot-docker/](https://mindsers.blog/post/https-using-nginx-certbot-docker/)
>---
>### Второстепенно ###↴
>### [# Setup SSL with Docker, NGINX and Lets Encrypt](https://www.programonaut.com/setup-ssl-with-docker-nginx-and-lets-encrypt/)
>---
>### [# How to setup SSL with Docker](https://www.linkedin.com/pulse/how-setup-ssl-docker-dhiraj-patra)
>---
>---
>#### [# Получаем и настраиваем бесплатный SSL сертификат | HTTPS | Let's Encrypt | certbot](https://www.youtube.com/watch?v=0LDkecAwvuQ&ab_channel=Self-hostedGuide%5BbyUnixHost%5D)
>---
>#### [# Сайт c SSL на Docker Compose за 5 минут // SmmHub #11](https://www.youtube.com/watch?v=HXQ2eLwvoxY)
>---
>#### [# How To Set Up SSL Certificate For Your Docker-Compose Environment With A .pfx File](https://akintola-lonlon.medium.com/how-to-set-up-ssl-certificate-for-your-docker-compose-environment-with-a-pfx-file-46177442460)
>---
>#### [# Webapp + Nginx and SSL in Docker Compose](https://medium.com/geekculture/webapp-nginx-and-ssl-in-docker-compose-6d02bdbe8fa0)
>---
>### Дополнение `ssl tls docker compose github`  ↷
>### [GitHub k8s](https://github.com/temporalio/docker-compose/blob/main/docker-compose-tls.yml)
>---
>### [GitHub - Docker](https://github.com/HewlettPackard/squest/blob/master/tls.docker-compose.yml)
>---
>### [Оптимальная настройка TLS/SSL в Nginx](https://www.youtube.com/watch?v=toR1zWWLmwo&ab_channel=%D0%9F%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D0%B0%D0%A1%D0%B0%D0%B9%D1%82%D0%BE%D0%B2%3A%3A%D0%9C%D0%B5%D1%82%D0%BE%D0%B4%D0%9B%D0%B0%D0%B1)

----

>[!tip]
>### Symfony 
>---
>---
>### [# Tutoriel API Platform : Envoi de fichiers](https://www.youtube.com/watch?v=fhdD7K5nZSA&ab_channel=Grafikart.fr)
>---
>---
>
>### [# 17 - Upload et gestion d'images multiples (Symfony 6)](https://www.youtube.com/watch?v=axbLC9PqzfE&ab_channel=NouvelleTechno)
>
>---
>---

## Подымаем Elasticsearch and Kibana

Сначала в  файл .env, чтобы перегруппировать переменные среды. Содержимое этого файла следующее:

```php
# Version of Elastic products  
STACK_VERSION=8.4.0# Port to expose Elasticsearch HTTP API to the host  
ES_PORT=9200# Port to expose Kibana to the host  
KIBANA_PORT=5601
```

Здесь мы обязательно указываем версию продуктов Elastic, которые мы хотим использовать, а также порты, на которых будут доступны Elasticsearch и Kibana.
Поскольку в этом первом руководстве безопасность не активирована для максимального упрощения, нам не нужно будет указывать пароли для наших клиентов.

Теперь перейдем к файлу docker-compose.yml:
```yml
version: '3.8'services:  
  elasticsearch:  
    image: docker.elastic.co/elasticsearch/elasticsearch:${STACK_VERSION}  
    container_name: elasticsearch  
    volumes:  
      - elasticsearch-data:/usr/share/elasticsearch/data  
    ports:  
      - ${ES_PORT}:9200  
    restart: always  
    environment:  
      - xpack.security.enabled=false  
      - discovery.type=single-node  
    ulimits:  
      memlock:  
        soft: -1  
        hard: -1  kibana:  
    depends_on:  
      - elasticsearch  
    image: docker.elastic.co/kibana/kibana:${STACK_VERSION}  
    container_name: kibana  
    volumes:  
      - kibana-data:/usr/share/kibana/data  
    ports:  
     - ${KIBANA_PORT}:5601  
    restart: always  
    environment:  
      - ELASTICSEARCH_HOSTS=http://elasticsearch:9200volumes:  
  elasticsearch-data:  
    driver: local  
  kibana-data:  
    driver: local
```

Open a browser when the deployment has started and visit Kibana by going to [http://localhost:5601](http://localhost:5601/), where you may load, test data and communicate with your cluster.


**ПРОЖОРЛИВАЯ ШТУКА 16гб рамы +**

---
#### [исходный материал](https://blog.devgenius.io/elasticsearch-and-kibana-installation-using-docker-compose-886c4823495e) 
In the [last article](https://medium.com/@mhdabdel151/run-elasticsearch-and-kibana-as-docker-containers-c5f5f5460afd), we saw how to run Elasticsearch and Kibana as Docker containers. The method was certainly not very complicated but required a lot of commands. Today, we are going to focus on **orchestration** in order to centralize everything thanks to **docker-compose**.

For those who don’t know what it is, **Docker Compose** is a tool written in Python, that allows you to describe, in a _YAML_ file, several containers as a set of services. It will then allow you to orchestrate your containers, and thus simplify your deployments on different environments.

If you used _Docker for Mac_ or _Docker for Windows_, you already have the latest version of Docker Compose installed in your system. On a Linux workstation, you will have to download it then install it with this command line:
```
sudo curl -L "https://github.com/docker/compose/releases/download/1.23.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/bin/docker-compose && sudo chmod +x /usr/bin/docker-compose
```
Once installed, you can check the version of Docker Compose using the following command:
```
docker-compose --version
```
You can learn more about docker-compose [_here_](https://docs.docker.com/compose/).

First, in an empty directory, we will create an _.env_ file in order to regroup our environment variables. The content of this file is as follows:

```
# Version of Elastic products  
STACK_VERSION=8.4.0# Port to expose Elasticsearch HTTP API to the host  
ES_PORT=9200# Port to expose Kibana to the host  
KIBANA_PORT=5601
```
Here, we make sure to mention the _version_ of elastic products we want to use as well as the _ports_ on which Elasticsearch and Kibana will be exposed.  
Since for this first tutorial **security is not activated** in order to simplify as much as possible, we will not need to specify passwords for our clients.

Now let’s go to the _docker-compose.yml_ file:

```yaml
version: '3.8'services:  
  elasticsearch:  
    image: docker.elastic.co/elasticsearch/elasticsearch:${STACK_VERSION}  
    container_name: elasticsearch  
    volumes:  
      - elasticsearch-data:/usr/share/elasticsearch/data  
    ports:  
      - ${ES_PORT}:9200  
    restart: always  
    environment:  
      - xpack.security.enabled=false  
      - discovery.type=single-node  
    ulimits:  
      memlock:  
        soft: -1  
        hard: -1  kibana:  
    depends_on:  
      - elasticsearch  
    image: docker.elastic.co/kibana/kibana:${STACK_VERSION}  
    container_name: kibana  
    volumes:  
      - kibana-data:/usr/share/kibana/data  
    ports:  
     - ${KIBANA_PORT}:5601  
    restart: always  
    environment:  
      - ELASTICSEARCH_HOSTS=http://elasticsearch:9200volumes:  
  elasticsearch-data:  
    driver: local  
  kibana-data:  
    driver: local
```
Here, we are running a _single node_ Elasticsearch version _8.4.0_ cluster with the security _disabled_. The name of our container is _elasticsearch_ and if there is a crash or any problem, the container will _always restart_. We also need to specify a volume to persist data (You can modify the ports in the _.env_ file).

Same for Kibana, we specify a name for the container (_kibana_), we fill in the _ELASTICSEARCH_HOSTS_ as an environment variable in order to connect Kibana to Elasticsearch. It is also important to specify the _depends_on_ property in order to start the container only if the Elasticsearch container is launched.

Now, create and launch the Kibana instance and one-node Elasticsearch cluster by running the following command:
```
docker-compose up -d
```
The first time this command is run it may take a long time depending on your internet connection, as it will download the Elasticsearch and Kibana images specified in our file from the [docker hub](https://hub.docker.com/). You can check that your containers have been created and are running by the command:
```
docker ps
```
Open a browser when the deployment has started and visit Kibana by going to [http://localhost:5601](http://localhost:5601/), where you may load, test data and communicate with your cluster.

To stop the cluster, nothing could be simpler, run the following command:
```
docker-compose down
```

To delete the containers as well as the volumes you just have to add _-v_ to the previous command.

There are still a lot of things we could talk about here like how to redo this same configuration with the _security enabled._ Unfortunately, we can’t cover everything in one article but don’t worry, others are on the way 😁.

That’s it for today, feel free to check the [official documentation](https://www.elastic.co/guide/en/elasticsearch/reference/current/docker.html#docker-compose-file) on the subject for more details and configurations. Thanks for reading, if you have questions or comments regarding this article, please feel free to leave a comment below.

I’ll see you next time for more posts 🚀.

Abdoul-Bagui M.


## Подымаем grafana/prometheus

использовал инфу [этого типа на гитхабе](https://github.com/curityio/grafana/blob/master/docker-compose.yml)

Наблюдается проблема с правами доступа , значит используем -
`sudo chown -R $(whoami) docker/portainer-data/`
адрес по вкусу.

+ почитать [тут](https://www.bogotobogo.com/DevOps/Docker/Docker_Prometheus_Grafana.php) 

##### На выходе имеем -
```yml
version: "3.8"  
  
services:  
  php-fpm:  
    container_name: php-fpm  
    build:  
      context: ./../  
      dockerfile: ./docker/php-fpm/Dockerfile  
      args:  
        - PUID=${PUID}  
        - PGID=${PGID}  
     #   - INSTALL_XDEBUG=${INSTALL_XDEBUG}  
    #   environment:    #     PHP_IDE_CONFIG: "serverName=Docker"    volumes:  
      #- /var/www/vendor/  
      - ./../:/var/www/  
  
  nginx:  
    container_name: nginx  
    build:  
      context: ./nginx  
    ports:  
       - ${NGINX_HOST_HTTP_PORT}:80  
    #   - ${NGINX_HOST_HTTPS_PORT}:443  
    #   - "80:80"   #    - "443:443" #   restart: always    volumes:  
      - ..:/var/www:rw  
 #     - ./nginx/conf/:/etc/nginx/conf.d/:rw  
 #     - ./certbot/www:/var/www/certbot/:rw #     - ./certbot/conf/:/etc/nginx/ssl/:rw    depends_on:  
      - php-fpm  
  #certbot SSL  
#  certbot:  
#     image: certbot/certbot  
#     container_name: certbot  
#     volumes:  
#       - ./certbot/www/:/var/www/certbot/:rw  
#       - ./certbot/conf/:/etc/letsencrypt/:rw  
#db  
  postgres:  
    container_name: postgres  
    build:  
      context: ./postgres  
    ports:  
      - ${POSTGRES_PORT}:5432  
    environment:  
      POSTGRES_DB: ${POSTGRES_DB}  
      POSTGRES_USER: ${POSTGRES_USER}  
      POSTGRES_PASSWORD: ${POSTGRES_PASSWORD}  
    volumes:  
      - db_data:/var/lib/postgresql/data:rw  
  rabbitmq:  
    image: rabbitmq:3.10.7-management  
    ports:  
      - 15672:15672  
  
#Ansible Semaphore: Awesome Open Source Ansible GUI  
  mysql:  
    restart: unless-stopped  
    ports:  
      - 3306:3306  
    image: mysql:8.0  
    hostname: mysql  
    volumes:  
      - semaphore-mysql:/var/lib/mysql  
    environment:  
      MYSQL_RANDOM_ROOT_PASSWORD: 'yes'  
      MYSQL_DATABASE: semaphore  
      MYSQL_USER: semaphore  
      MYSQL_PASSWORD: 'semaphore'  
  
  semaphore:  
    restart: unless-stopped  
    ports:  
      - 3000:3000  
    image: semaphoreui/semaphore:latest  
    environment:  
      SEMAPHORE_DB_USER: semaphore  
      SEMAPHORE_DB_PASS: 'semaphore'  
      SEMAPHORE_DB_HOST: mysql # for postgres, change to: postgres  
      SEMAPHORE_DB_PORT: 3306 # change to 5432 for postgres  
      SEMAPHORE_DB_DIALECT: mysql  
      SEMAPHORE_DB: semaphore  
      SEMAPHORE_PLAYBOOK_PATH: /tmp/semaphore/  
      SEMAPHORE_ADMIN_PASSWORD: changeme  
      SEMAPHORE_ADMIN_NAME: admin  
      SEMAPHORE_ADMIN_EMAIL: admin@example.com  
      SEMAPHORE_ADMIN: admin  
      SEMAPHORE_ACCESS_KEY_ENCRYPTION: gs72mPntFATGJs9qK0pQ0rKtfidlexiMjYCH9gWKhTU=  
      SEMAPHORE_LDAP_ACTIVATED: 'no' # if you wish to use ldap, set to: 'yes'  
      SEMAPHORE_LDAP_HOST: dc01.local.example.com  
      SEMAPHORE_LDAP_PORT: '636'  
      SEMAPHORE_LDAP_NEEDTLS: 'yes'  
      SEMAPHORE_LDAP_DN_BIND: 'uid=bind_user,cn=users,cn=accounts,dc=local,dc=shiftsystems,dc=net'  
      SEMAPHORE_LDAP_PASSWORD: 'ldap_bind_account_password'  
      SEMAPHORE_LDAP_DN_SEARCH: 'dc=local,dc=example,dc=com'  
      SEMAPHORE_LDAP_SEARCH_FILTER: "(u0026(uid=%s)(memberOf=cn=ipausers,cn=groups,cn=accounts,dc=local,dc=example,dc=com))"  
    depends_on:  
      - mysql # for postgres, change to: postgres  
  
  #Elasticsearch and Kibana#  elasticsearch:  
#    image: docker.elastic.co/elasticsearch/elasticsearch:${STACK_VERSION}  
#    container_name: elasticsearch  
#    volumes:  
#      - elasticsearch-data:/usr/share/elasticsearch/data  
#    ports:  
#      - ${ES_PORT}:9200  
#    restart: always  
#    environment:  
#      - xpack.security.enabled=false  
#      - discovery.type=single-node  
#    ulimits:  
#      memlock:  
#        soft: -1  
#        hard: -1  
  
#  kibana:  
#      depends_on:  
#        - elasticsearch  
#      image: docker.elastic.co/kibana/kibana:${STACK_VERSION}  
#      container_name: kibana  
#      volumes:  
#        - kibana-data:/usr/share/kibana/data  
#      ports:  
#        - ${KIBANA_PORT}:5601  
#      restart: always  
#      environment:  
#        - ELASTICSEARCH_HOSTS=http://elasticsearch:9200  
  
#grafana prometheus  
  curity:  
    container_name: idsvr  
    environment:  
      PASSWORD: "Password1"  
      POSTGRES_USER: "postgres"  
      POSTGRES_PASSWORD: "Password1"  
    image: curity.azurecr.io/curity/idsvr:latest  
    ports:  
      - "6749:6749"  
      - "4466:4466"  
      - "8443:8443"  
    volumes:  
      - ./config/idsvr/license.json:/opt/idsvr/etc/init/license/license.json  
      - ./config/idsvr/basic_config.xml:/opt/idsvr/etc/init/basic_config.xml  
      - ./config/idsvr/example_config.xml:/opt/idsvr/etc/init/example_config.xml  
    links:  
      - curity-data  
    networks:  
      demonetwork:  
        aliases:  
          - idsvr  
  
  curity-data:  
    container_name: database  
    image: postgres:14.5  
    ports:  
      - 5432:5432  
    volumes:  
      - ./config/postgresql/data:/var/lib/postgresql/data  
      - ./config/postgresql/create-database.sql:/docker-entrypoint-initdb.d/create-database.sql  
    environment:  
      POSTGRES_USER: "postgres"  
      POSTGRES_PASSWORD: "Password1"  
      POSTGRES_DB: "idsvr"  
    networks:  
      demonetwork:  
        aliases:  
          - database  
  
  prometheus:  
    container_name: prometheus  
    image: prom/prometheus  
    ports:  
      - "9090:9090"  
    volumes:  
      - ./config/prometheus/prometheus.yml:/etc/prometheus/prometheus.yml  
    links:  
      - curity  
    networks:  
      demonetwork:  
        aliases:  
          - prometheus  
  
  grafana:  
    container_name: grafana  
    image: grafana/grafana-oss  
    ports:  
      - "3200:3200"  
    environment:  
      - GF_PATHS_CONFIG=/etc/grafana/custom.ini  
    volumes:  
      - ./config/grafana/custom.ini:/etc/grafana/custom.ini  
      - ./config/grafana/provisioning/:/etc/grafana/provisioning/  
      - type: bind  
        source: ./config/grafana/dashboard.json  
        target: /var/lib/grafana/dashboards/curity/idsvr-dashboard.json  
    links:  
      - prometheus  
    networks:  
      demonetwork:  
        aliases:  
          - grafana  
  
  
  
  #mysql-workbench  
  mysql-workbench:  
    image: lscr.io/linuxserver/mysql-workbench:latest  
    container_name: mysql-workbench  
    environment:  
      - PUID=1000  
      - PGID=1000  
      - TZ=Etc/UTC  
    volumes:  
      - /path/to/config:/config  
    ports:  
      - 5600:5600  
      - 5601:5601  
    cap_add:  
      - IPC_LOCK  
    restart: unless-stopped  
  
  portainer:  
    image: portainer/portainer-ce:latest  
    container_name: portainer  
    restart: unless-stopped  
    security_opt:  
      - no-new-privileges:true  
    volumes:  
      - /etc/localtime:/etc/localtime:ro  
      - /var/run/docker.sock:/var/run/docker.sock:ro  
      - ./portainer-data:/data  
    ports:  
      - 9000:9000  
  
# grafana - prometheus  
networks:  
  demonetwork:  
    name: metrics-demo-net  
  
volumes:  
  db_data:  
  semaphore-mysql: # to use postgres, switch to: semaphore-postgres  
# volumes Elasticsearch and Kibana  
#  elasticsearch-data:  
#    driver: local  
#  kibana-data:  
#    driver: local  
  
#mysql-workbench-data:  
  mysql-workbench-data:
```

>[!tip]
>Поднялся `prometheus`
>не поднялись `idsvr` and `grafana`
>Предположение - забиты порты - перепроверить 
>и до поднять все остальное .
>---
>Обратить внимание [curityio/grafana/blob](https://github.com/curityio/grafana/blob/master/docker-compose.yml)




