# Задача

Разработать сервис на Laravel 8+, который решает задачу синхронизации данных из БД с Google Таблицей (по одной модели/таблице).

##  Требования https://docs.google.com/spreadsheets/d/1mkXsFxfHRc56Ac0Jm9TMNwG-C3fwwQNheL8D5JBLCCo/edit?usp=sharing

1. Должен быть реализован CRUD интерфейс для 1 модели Eloquent (дизайн и стек фронта на ваше усмотрение)  
2. Одно из полей в модели должно быть поле **status**, тип **enum**, возможные значения **\[Allowed, Prohibited\]**  
3. Должна быть кнопка сгенерировать 1000 текстовых строк (с **равномерным распределением** значений поля статус)  
4. Должна быть кнопка полностью **очистить таблицу**.  
5. Должна быть возможность **через интерфейс** задать URL на документ google sheet (у документа будут права на редактирование любым пользователем)  
6. Система в автоматическом режиме должна выгружать/обновлять данные в указанном документе 1 раз в минуту.   
7. Должны отправляться только строки со статусом **Allowed.** Для выборки используйте **Local Scope**.  
8. Если статус выгрузки изменился с **Allowed** на **Prohibited**, то строка из выгрузки **удаляется**. Если произошло **наоборот** \- строка **добавляется**. При **удалении из БД** строка в таблице **удаляется.**  
9. Пользователь будет писать **комментарии в дополнительном столбце** в google документе (это n+1 столбец по-умолчанию, где n \- кол-во столбцов в выгрузке). Необходимо, чтобы при очередном обновлении данных эти данные не затирались и “не съезжали” относительно своей строки, если записи добавились/удалились.  
10. В таблицу необходимо выводить **все поля** созданной модели.  
11. В системе должна быть реализована консольная команда, которая:  
    1. Получает данные из google таблицы   
    2. Построчно выводит информацию об ИД модели / Комментарии из гугл таблицы в консоль  
    3. При этом в процессе в консоле отображается progressbar процесса  
    4. В команду можно передать параметр **count**, который ограничивает количество выводимых в консоль строк  
12. Должен быть реализован роут **/fetch**, который можно вызвать из браузера.   
    1. При вызове должна быть запущена команда из **п.11**, и консольный вывод должен быть отображен в браузере в виде строки.  
    2. Должна быть возможность вызвать роут с параметром, чтобы задать ограничение на количество выводимых данных (см. **пункт 11d**). Формат такого роута: **/fetch/20**

    

## Требования к оформлению и сдаче задания 

1. Готовый год загружен на github или аналог (с публичным доступом)  
2. Сервис развернут и готов для тестирования. В нем можно зарегистрировать или в описании к проекту есть тестовый логин/пароль. Можно сделать проект вообще без авторизации  
3. Заполнена форма https://docs.google.com/forms/d/e/1FAIpQLSf1A4tXD7wkQHWINaGCYZS2\_1sjP0qqq09sqr69\_KhOTzVoDQ/viewform?usp=header
