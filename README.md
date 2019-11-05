## Сборка проекта
1. [Создать](https://github.com/settings/tokens) OAuth токен на GitHub. 
Необходимо это для множественных запросов на сервер GitHub при установке
проекта через `composer` 
1. Разместить полученный токен в файле `Dockerfile` весто `TOKEN_GITHUB` 
1. Выполнить команды из корня проекта 
   ```bash
   docker-compose build
   docker-compose up -d
   docker-compose exec web composer install
   docker-compose exec web php yii migrate --interactive=0   
   ```
   
## API запросы
1. Запросы к API пыполнять по адресу `localhost:8100`
1. GET `/position?id=<int>` получение шахматной позиции по номеру
1. POST `/position/create` создание новой шахматной позиции
1. PUT `/position/update?id=<int>` изменение шахматной позиции по номеру

Формат вода/вывода данных `JSON`
```json
{
    "id":4,
    "name":"Название партии",
    "positions":[
        {"board":"a1","figure":"R","color":"w"},
        {"board":"a2","figure":"p","color":"w"},
        {"board":"b1","figure":"N","color":"w"},
        {"board":"b2","figure":"p","color":"w"},
        {"board":"c1","figure":"B","color":"w"}        
    ]
}
```

Формат ввода аналогичен, кроме передачи `id` номера партии