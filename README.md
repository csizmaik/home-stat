# home-stat README

## Container indítása

Futtatás a project root-ból:

```bash
docker-compose build
docker-compose up -d
docker exec -it -u dev sf4_php composer install -d /home/wwwroot/sf4
```

## Script futtatása

```bash
docker exec -it -u dev sf4_php php /home/wwwroot/sf4/bin/console market-stat:update
```

## Felhasznált lib-ek

__HttpClient:__

https://symfony.com/doc/current/components/http_client.html

__DOM Crawler:__

https://symfony.com/doc/current/components/dom_crawler.html
