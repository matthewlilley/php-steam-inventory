# PHP Steam Inventory

A framework agnostic and extensible PHP wrapper for the Steam Inventory API https://steamcommunity.com/inventory


## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require matthewlilley/php-steam-inventory
```

## Inventory Example

```php
$config = new \PHPSteamInventory\Configuration([
    'steamid' => '76561197969338647', // required
    'appid' => '730', // default 730
    'contextid' => '2', // default 2
    'language' => 'english', // default english
    'count' => '75', // default 75, max 5000 (also, overwritten to 5000 if all is set to true)
    'start_assetid' => null, // default null
    'proxy' => null, // default null
    'all' => false // default false
]);

$inventory = new \PHPSteamInventory\Inventory($configuration);

$inventory->items; // array of item objects
$inventory->total_inventory_count; // total items count
$inventory->last_assetid; // last assetid (set if there are more items)
$inventory->more_items; // more items (set to true if there are more items)
```

## License

[MIT](https://github.com/MatthewLilley/php-steam-inventory/blob/master/LICENSE)
