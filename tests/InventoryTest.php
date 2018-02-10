<?php

namespace PHPSteamInventory\Tests;

use PHPUnit\Framework\TestCase;
use PHPSteamInventory\Inventory;
use PHPSteamInventory\Configuration;

class InventoryTest extends TestCase
{
    public function testInventoryConfigurationWithoutSteamid()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('No steamid provided.');
        new Configuration([]);
    }

    public function testInventoryConfigurationWithInvalidSteamid()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Unknown ID format');
        new Configuration(['steamid' => 'invalid']);
    }

    public function testInventoryConfigurationWithOnlySteamid()
    {
        new Configuration(['steamid' => '76561197969338647']);
    }

    public function testInventory()
    {
        $this->assertTrue($this->inventory()->items > 0);
    }

    private function baseConfigurationOptions()
    {
        return [
            'steamid' => '76561197969338647'
        ];
    }

    private function configuration()
    {
        return new Configuration($this->baseConfigurationOptions());
    }

    private function inventory()
    {
        return new Inventory($this->configuration());
    }
}