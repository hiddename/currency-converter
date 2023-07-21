# HOW TO RUN
> docker compose --env-file=./docker/.env up -d
# HOW TO USE
### Refresh rates
Rates are refreshing automatically by cron, but you can do it manually:
```
# refresh all
> docker exec -it cc.app php bin/console app:rate:refresh
# refresh <ecb> provider
> docker exec -it cc.app php bin/console app:rate:refresh --provider-key ecb
# refresh <coindesk_bitcoin_price_index> provider
> docker exec -it cc.app php bin/console app:rate:refresh --provider-key coindesk_bitcoin_price_index
```
### Exchange
```
> docker exec -it cc.app php bin/console app:exchange 1 BTC USD
```
