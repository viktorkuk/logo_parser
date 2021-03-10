docker-compose -f docker-compose.yml up -d --build

docker-compose run --rm composer install
#docker-compose run --rm artisan migrate
docker-compose run --rm npm install
docker-compose run --rm npm run dev

#chmod +x init-letsencrypt.sh
#sudo ./init-letsencrypt.sh

