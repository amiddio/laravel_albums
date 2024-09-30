# Music Albums Rest API Application

## Описание

> Приложение предоставляет информацию о музыкальных исполнителях, альбомах и треках. 
> Просмотр и управление контентом построен на RestAPI.

## Стек технологий

> Docker, Nginx, PHP 8.1, Laravel 10, MySql 8

## Сторонние пакеты

* barryvdh/laravel-debugbar
* barryvdh/laravel-ide-helper

## Endpoints

### 1. Типы музыкальных релизов

`GET "/api/v1/release_types"`

> Возвращает список типов музыкальных релизов

![Screenshot_1](/screenshots/Screenshot_01.png)

### 2. Исполнители

`GET "/api/v1/artists"`

> Постраничный вывод всех исполнителей

![Screenshot_1](/screenshots/Screenshot_02.png)

`POST "/api/v1/artists"`

> Добавление исполнителя

![Screenshot_1](/screenshots/Screenshot_03.png)

`PUT "/api/v1/artists/{artist_id}"`

> Обновление исполнителя

![Screenshot_1](/screenshots/Screenshot_04.png)

`DELETE "/api/v1/artists/{artist_id}"`

> Удаление исполнителя

![Screenshot_1](/screenshots/Screenshot_05.png)

`GET "/api/v1/artists/{artist_id}"`

> Полная информация об исполнителе

![Screenshot_1](/screenshots/Screenshot_06.png)

### 3. Альбомы

`GET "/api/v1/albums/{artist_id}/{release_type_id}"`

> Список всех альбомов исполнителя с фильтрацией по типу релиза.
> Другими словами выводит список всех студийных альбомов, концертных, синглов и т.д. конкретного исполнителя.

![Screenshot_1](/screenshots/Screenshot_07.png)

`POST "/api/v1/albums"`

> Добавление альбома

![Screenshot_1](/screenshots/Screenshot_08.png)

`PUT "/api/v1/albums/{album_id}"`

> Обновление альбома

![Screenshot_1](/screenshots/Screenshot_09.png)

`DELETE "/api/v1/albums/{album_id}"`

> Удаление альбома

![Screenshot_1](/screenshots/Screenshot_10.png)

`GET "/api/v1/albums/{album_id}"`

> Подробная информация об альбоме, с списком всех треков

![Screenshot_1](/screenshots/Screenshot_11.png)

### 4. Треки

`POST "/api/v1/tracks"`

> Добавление трека

![Screenshot_1](/screenshots/Screenshot_12.png)

`PUT "/api/v1/tracks/{track_id}"`

> Обновление трека

![Screenshot_1](/screenshots/Screenshot_13.png)

`DELETE "/api/v1/tracks/{track_id}"`

> Удаление трека

![Screenshot_1](/screenshots/Screenshot_14.png)

## Tests

> На данный момент, тестами покрыты основные действия контроллеров

![Screenshot_1](/screenshots/Screenshot_15.png)
