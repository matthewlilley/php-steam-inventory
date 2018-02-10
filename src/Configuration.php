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

use SteamID\SteamID;
use PHPSteamInventory\Contracts\Configuration as Contract;

/**
 * Configuration.
 *
 * @author Matthew Lilley <hello@matthewlilley.com>
 * @license MIT
 */
class Configuration implements Contract
{
    /**
     * Steamid.
     *
     * @var int|string
     */
    protected $steamid;

    /**
     * Appid.
     *
     * @var int|string
     */
    protected $appid = 730;

    /**
     * Contextid.
     *
     * @var int|string
     */
    protected $contextid = 2;

    /**
     * Language.
     *
     * @var string
     */
    protected $language = 'english';

    /**
     * Count.
     *
     * @var int|string
     */
    protected $count = 75;

    /**
     * Start assetid.
     *
     * @var string|null
     */
    protected $start_assetid;

    /**
     * Proxy.
     *
     * @var string|null
     */
    protected $proxy;

    /**
     * All.
     *
     * @var boolean
     */
    protected $all = false;

    /**
     * Configuration constructor.
     *
     * @param array $options
     * @throws \Exception
     * @return void
     */
    public function __construct(array $options = [])
    {
        if (! isset($options['steamid'])) {
            throw new \Exception('Steamid is not set.');
        }

        $this->setSteamid($options['steamid']);

        if (isset($options['appid'])) {
            $this->setAppid($options['appid']);
        }

        if (isset($options['contextid'])) {
            $this->setContextid($options['contextid']);
        }

        if (isset($options['language'])) {
            $this->setLanguage($options['language']);
        }

        if (isset($options['count'])) {
            if ($options['count'] > 5000 || $this->all()) {
                $this->setCount(5000);
            } else {
                $this->setCount($options['count']);
            }
        }

        if (isset($options['start_assetid'])) {
            $this->setStartAssetid($options['start_assetid']);
        }

        if (isset($options['proxy'])) {
            $this->setProxy($options['proxy']);
        }

        if (isset($options['all'])) {
            $this->setAll($options['all']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSteamid()
    {
        return $this->steamid;
    }

    /**
     * {@inheritdoc}
     */
    public function setSteamid($steamid) : void
    {
        $this->steamid = (new SteamID($steamid))->getSteamID64();
    }

    /**
     * {@inheritdoc}
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppid($appid) : void
    {
        $this->appid = (string) is_numeric($appid) ? $appid : 730;
    }

    /**
     * {@inheritdoc}
     */
    public function getContextid()
    {
        return $this->contextid;
    }

    /**
     * {@inheritdoc}
     */
    public function setContextid($contextid) : void
    {
        $this->contextid = (string) is_numeric($contextid) ? $contextid : 2;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * {@inheritdoc}
     */
    public function setLanguage(string $language) : void
    {
        if (Language::invalid($language)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid language: %s Possible languages: %s',
                    $language,
                    implode(', ', Language::all())
                )
            );
        }

        $this->language = strtolower($language);
    }


    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function setCount($count) : void
    {
        $this->count = (string) is_numeric($count) ? $count : 75;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartAssetid() : ?string
    {
        return $this->start_assetid;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartAssetid($startAssetid) : void
    {
        $this->start_assetid = (string) is_numeric($startAssetid) ? $startAssetid : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getProxy() : ?string
    {
        return $this->proxy;
    }

    /**
     * {@inheritdoc}
     */
    public function setProxy(string $proxy) : void
    {
        $filter = function($ip) use ($proxy) {
            return filter_var($ip, FILTER_VALIDATE_IP) ? $proxy : '';
        };

        $parsed = parse_url($proxy);

        if($parsed === false)
        {
            return;
        }

        switch($parsed) {
            case 'host':
                $this->proxy = $filter($parsed['host']);
                break;
            case 'path':
                $this->proxy = $filter($parsed['path']);
                break;
            default:
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAll() : bool
    {
        return $this->all;
    }

    /**
     * {@inheritdoc}
     */
    public function setAll(bool $all = true) : void
    {
        $this->all = is_bool($all) ? $all : null;
    }
}
