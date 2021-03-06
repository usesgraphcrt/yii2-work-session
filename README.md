Yii2-work-session
==========

Модуль предоставляет интерфейс для ведения учета рабочих смен сотрудников, а также организации в целом. Есть возможность планировать график и контролировать рабочие смены.

![work session](https://cloud.githubusercontent.com/assets/8104605/16575746/fd85769c-42a3-11e6-9385-fa5f3b59bb33.png)

Фиксируется начало всей смены, время прихода и ухода каждого сотрудника, рассчитывается время фактического нахождения на рабочем месте.

Установка
---------------------------------

Выполнить команду

```
php composer require pistol88/yii2-work-session "*"
```

Или добавить в composer.json

```
"pistol88/yii2-work-session": "*",
```

И выполнить

```
php composer update
```

Далее, мигрируем базу:

```
php yii migrate --migrationPath=vendor/pistol88/yii2-work-session/migrations
```

Подключение и настройка
---------------------------------

В конфигурационный файл приложения добавить модуль worksess, настроив его

```php
    'modules' => [
        //...
        'worksess' => [
            'class' => 'pistol88\worksess\Module',
            'adminRoles' => ['administrator'],
            //модуль пользователей
            'userModel' => 'common\models\User',
            //Перечень смен
            'shifts' => [
                '07:00' => 'Дневная смена',
                '19:00' => 'Ночная смена',
            ],
            //кол-во часов в смене
            'hoursCount' => 12,
            //callback функция, позвращающая список работников
            'workers' => function() {
                return \common\models\User::findAll(['status' => 2, 'id' => Yii::$app->authManager->getUserIdsByRole(['washer'])]);
            },
        ],
        //...
    ]
``` 

В модели пользователя подключить поведение pistol88\worksess\AttachSession, чтобы получать время работы через $user->getSessionTime($date)

Управление сессиями по роуту: worksess/session/current.

Управление расписанием выхода сотрудников по роуту: worksess/session/current.


Виджеты
---------------------------------
```php
<?php
use pistol88\worksess\widgets\ControlButton;
use pistol88\worksess\widgets\Info;
use pistol88\worksess\widgets\SessionGraph;
?>
```

Информация об общей смене сменой:
```php
<?=Info::widget();?>
```

Информация о смене сотрудника ($worker - модель пользователя):
```php
<?=Info::widget(['for' => $worker]);?>
```

Кнопки переключения старта\остановки общей сессии и сессии отдельного сотрудника (если передано свойство $worker):
```php
<?=ControlButton::widget(['for' => $worker]);?>
```

Вывод визуализации рабочего дня сотрудников
```php
<?=SessionGraph::widget();?>
```

Триггеры
---------------------------------
В момент создания и завершения сессии можно выполнять какие-либо пользовательские сценарии, вынесенные в конфиг:

'components' => [
    'worksess' => [
        'class' => 'pistol88\worksess\Session',
        'on start' => function($event) {
            //Сессия - $event->model;
        },
        'on stop' => function($event) {
            //Сессия - $event->model;
        }
    ],
]