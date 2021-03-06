Библиотека для помощи в склонении личных имен.
Из входных данных требуется само слово, чем это слово является: фамилией или именем, а также пол.
										

## Установка
Склонируйте проект.  
Для удобства работы в проекте настроены контейнеры с php, nginx, composer.  
Для запуска проекта необходимо запустить docker-compose  
```bash
docker-compose up [-d]
```

При запуске докера composer создаст дамп для автозагрузки классов.  
Document root сервера настроен на папку public.
Файл public/index.php доступен по адресу localhost.

Для работы без докера требуется PHP >= 7.4

### Использование
По пути 'public/index.php' находится пример использования класса.

Метод setGender позволяет задать пол, а методы name/surname - провести работу над именем и фамилией соответственно.

В папке app находятся классы приложения.
Класс Declension - основной класс-обработчик. Классы Gender и GrammarCase предоставляют доступ к универсальным
константам для единых значений при дальнейшем расширении приложения.  
rules.json - файл с правилами. В файле в репозитории реализованы 9 примеров правил с комментариями.

Формат файла - surname/name - главные блоки для фамилии и имени соответственно. Regular - 
это секция обычных правил. Предполагается создание exception блока, где можно будет вводить нестандартные слова и правила.

Поле gender отвечает за пол, к которому применимо правило и принимает три возможных значения:
1. all - любой пол
2. male - мужской пол
3. female - женский пол

Поле match отвечает за окончание, которое нужно найти.

Поле replacement показывает на необходимые добавления окончания в разных падежах. Если необходимо заменить часть букв
в слове (например, в женской фамилии, которая оканчивается на ая, необходимо заменить 2 последние буквы и после этого дописать ещё 2), 
то можно ставить знак тире -. Каждый такой знак означает одну букву, например, --ой.

