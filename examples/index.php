<?php

require_once __DIR__ . '/../vendor/autoload.php';

$config = new PHPSteamInventory\Configuration([
    'steamid' => '76561197969338647',
    'all' => true
]);

$inventory = new PHPSteamInventory\Inventory($config);

print_r($inventory->getItems());