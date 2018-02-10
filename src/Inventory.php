<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

declare(strict_types=1);

namespace PHPSteamInventory;

use Exception;
use PHPSteamInventory\Contracts\Inventory as InventoryInterface;
use PHPSteamInventory\Contracts\Configuration as ConfigurationInterface;

/**
 * Inventory.
 *
 * @author Matthew Lilley <hello@matthewlilley.com>
 * @license MIT
 */
class Inventory implements InventoryInterface
{
    /**
     * @var string Base steam inventory url.
     */
    const BASE_URL = 'http://steamcommunity.com/inventory/';

    /**
     * Configuration.
     *
     * @var Configuration
     */
    protected $configuration;

    /**
     * Items.
     *
     * @var array
     */
    public $items = [];

    /**
     * Total inventory count.
     *
     * @var int
     */
    public $total_inventory_count;

    /**
     * More items.
     *
     * @var boolean|null
     */
    public $more_items;

    /**
     * Last assetid.
     *
     * @var string|null
     */
    public $last_assetid;

    /**
     * Inventory constructor.
     *
     * @param  ConfigurationInterface|array $configuration
     * @throws Exception
     * @return void
     */
    public function __construct($configuration)
    {
        if (is_array($configuration)) {
            $configuration = $this->createConfigurationFromArray($configuration);
        }
        if (! $configuration instanceof ConfigurationInterface) {
            throw new Exception('No configuration provided.');
        }
        $this->configuration = $configuration;
        $this->init();
    }

    /**
     * {@inheritdoc}
     */
    public function getItems() : array
    {
        return $this->items;
    }

    /**
     * Set items.
     *
     * @param array $assets
     * @param array $descriptions
     * @return void
     */
    public function setItems(array $assets, array $descriptions) : void
    {
        foreach ($assets as $asset) {
            foreach ($descriptions as $description) {
                if ($asset['classid'] === $description['classid']) {
                    $this->items[] = new Item($asset, $description);
                    break;
                }
            }
        }
    }

    /**
     * Create configuration from array.
     *
     * @param  array $configuration
     * @return Configuration
     */
    private function createConfigurationFromArray(array $configuration) : Configuration
    {
        return new Configuration($configuration);
    }

    /**
     * Init.
     *
     * @throws \Exception
     * @return void
     */
    private function init() : void
    {
        if (! $this->configuration->getAll()) {
            $this->parse($this->request());
        } else {
            $this->configuration->setCount(5000);
            $this->parse($this->request());
            for ($i = 0; $i < (int) round($this->total_inventory_count / $this->configuration->getCount(), 0); $i++) {
                $this->configuration->setStartAssetid($this->last_assetid);
                $this->parse($this->request());
            }
        }
    }

    /**
     * Parse.
     *
     * @param $response array
     * @throws \Exception
     * @return void
     */
    private function parse(array $response) : void
    {
        if (! $this->isValidResponse($response)) {
            throw new Exception('Malformed response.');
        }
        $this->total_inventory_count = $response['total_inventory_count'];
        $this->more_items = $response['more_items'] ?? null;
        $this->last_assetid = $response['last_assetid'] ?? null;
        $this->setItems($response['assets'], $response['descriptions']);
    }

    /**
     * Request.
     *
     * @return array
     */
    private function request() : array
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url());
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($proxy = $this->configuration->getProxy()) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
        $response = curl_exec($curl);
        curl_close($curl);

        return $response === false ? [] : json_decode($response, true);
    }

    /**
     * Steam Inventory API Url.
     *
     * @return string
     */
    private function url() : string
    {
        $queryParameters = http_build_query([
            'l' => $this->configuration->getLanguage(),
            'count' => $this->configuration->getCount(),
            'start_assetid' => $this->configuration->getStartAssetid()
        ], '', '&');

        return self::BASE_URL . "{$this->configuration->getSteamid()}/{$this->configuration->getAppid()}/{$this->configuration->getContextid()}?{$queryParameters}";
    }

    /**
     * Determine if the response is valid.
     *
     * @param array $response
     * @return bool
     */
    private function isValidResponse($response) : bool
    {
        return $response['success'] && $response['assets'] && $response['descriptions'];
    }
}
