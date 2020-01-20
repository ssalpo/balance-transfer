# Установка
	Веб сервер конфигурируется до папки /public в корне приложения
	Запускаем composer install
	Копируем .env.example на .env в корне приложения
	Устанавливаем в файле .env APP_DEBUG=true для тестирования приложения
	так же настраиваем насстройки подключения к БД
		DB_HOST=127.0.0.1
		DB_PORT=3306
		DB_DATABASE=wallet_transaction
		DB_USERNAME=user
		DB_PASSWORD=user_password
	Запускаем в корне приложения php artisan key:generate
	Далее php artisan migrate --seed для применения миграций
	
# Базовые api для работы
	POST /api/auth - для авторизациии
	GET  /api/balance - возращает информации о балансе текущего пользователя
	POST /api/transfer - перевод условных единиц от одного пользователя к другому
	GET  /api/transactions - выводит все транзакции текущего пользователя
	GET  /api/transactions/{id} - выводит информации о конкретной транзакции по ID

#Примеры:

Для работы по базовым API запросам необдимо сначала авторизироваться и получить токен

	curl -XPOST -H "Content-type: application/json" -d '{"email":"gosha@gmail.com","password":"secret"}' 'http://localhost:8080/api/auth'

	Параметры: {"email":"gosha@gmail.com","password":"secret"}
    Ответ: {"name":"Gosha","email":"gosha@gmail.com","api_token":"$2y$10$x8bzzbuATXOzI7PidxkB3.AiB8z.4eVfUOs3G3cisVHI3Q///XrX6"} , берем api_token для отправки остальных запросов.

Перевод платежа другому пользователю:

	curl -XPOST -H "Content-type: application/json" -d '{"receiver_id":"2","amount":"15"}' 'http://localhost:8080/api/transfer?api_token=$2y$10$x8bzzbuATXOzI7PidxkB3.AiB8z.4eVfUOs3G3cisVHI3Q///XrX6'
	
	Принимаемые параметры:
		по ID пользователя - {"receiver_id":"2","amount":"15"}
		по email пользователя - {"email":"nick@gmail.com","amount":"15"}

Запрос на получение баланса:

	curl -XGET -H "Content-type: application/json" 'http://localhost:8080/api/balance?api_token=$2y$10$x8bzzbuATXOzI7PidxkB3.AiB8z.4eVfUOs3G3cisVHI3Q///XrX6'

Запрос на получение списка всех транзакций пользователя:

	curl -XGET -H "Content-type: application/json" 'http://localhost:8080/api/transactions?api_token=$2y$10$x8bzzbuATXOzI7PidxkB3.AiB8z.4eVfUOs3G3cisVHI3Q///XrX6'

Запрос на получение информации о конкретной транзакции  пользователя:
	
	curl -XGET -H "Content-type: application/json" 'http://localhost:8080/api/transactions/1?api_token=$2y$10$x8bzzbuATXOzI7PidxkB3.AiB8z.4eVfUOs3G3cisVHI3Q///XrX6'

# Другие API для тестовых целей

	POST /api/test/transactions          - возвращает все существующие транзакции
	GET  /api/test/delete/{userId}/user  - удаляет пользователя из БД
	POST /api/test/store/user            - добавляет нового пользователя


Возвращает список всех транзакций приложения:
	
	curl -XGET -H "Content-type: application/json" 'http://localhost:8080/api/test/transactions'

Удаление пользователя из БД

	curl -XPOST -H "Content-type: application/json" 'http://localhost:8080/api/test/delete/1/user'

Добавление нового пользователя

	curl -XPOST -H "Content-type: application/json" -d '{"name":"Sanjar","email":"ssalpo@site.me", "password":"secret"}' 'http://localhost:8080/api/test/store/user'
