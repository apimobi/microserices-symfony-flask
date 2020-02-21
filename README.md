# test-technique

clone the repository

# config

edit flask/.env with the right api keys

# build project

Dans un terminal :
```
docker-compose build
docker-compose up
```
Dans un autre terminal :
```
docker-compose exec php sh
composer install --prefer-dist
```
# enjoy

go to http://0.0.0.0:8888/address
fill in the form with a postal address and an ip adddress
get the distance between the 2 points

