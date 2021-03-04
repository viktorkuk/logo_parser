docker-compose -f docker-compose.yml up -d

docker-compose run --rm composer install
docker-compose run --rm artisan migrate
docker-compose run --rm npm install
docker-compose run --rm npm run dev

