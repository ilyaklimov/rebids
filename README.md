A simple bid manager Yandex.Direct with several strategies.

```
php ./bids.php update
```

# config.php

A configuration file for managing bids.

## Accounts
List of accounts.

### Login 
Login in Yanex.Direct.

### Token
Auth token, more details [here](https://tech.yandex.ru/direct/doc/dg/concepts/auth-token-docpage/).

### Campaigns
List of campaigns in the account. The key is the ID of the campaign. The value is the campaign settings.

#### Name
Campaign name

#### PriceMax
The maximum bid on the search, multiplied by 1000000.

#### PricePlusPercent
Bid increase (%).

#### Strategy
Bid management strategy. 

There are two types:

* MAX - always be in the first place of special placement. Otherwise, set the price to PriceDefault.
* SPECIAL - always be in special placement. Otherwise, set the price to PriceDefault.

## Strategies
List of strategies. The key is the name of the strategy. The value is the strategy settings.

## PriceDefault
The value of the bid is set by default.