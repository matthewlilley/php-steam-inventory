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

/**
 * Item.
 *
 * @author Matthew Lilley <hello@matthewlilley.com>
 * @license MIT
 */
class Item
{
    /**
     * @var string Base steam image url.
     */
    const BASE_URL = 'https://steamcommunity-a.akamaihd.net/economy/image/';

    /**
     * Appid.
     *
     * @var string
     */
    public $appid;

    /**
     * Context id.
     *
     * @var string
     */
    public $contextid;

    /**
     * Assetid.
     *
     * @var string
     */
    public $assetid;

    /**
     * Classid.
     *
     * @var string
     */
    public $classid;

    /**
     * Instanceid.
     *
     * @var string
     */
    public $instanceid;

    /**
     * Amount.
     *
     * @var string
     */
    public $amount;

    /**
     * Currency.
     *
     * @var string
     */
    public $currency;

    /**
     * Icon url.
     *
     * @var string
     */
    public $icon_url;

    /**
     * Icon url large.
     *
     * @var string
     */
    public $icon_url_large;

    /**
     * Name.
     *
     * @var string
     */
    public $name;

    /**
     * Market hash name.
     *
     * @var string
     */
    public $market_hash_name;

    /**
     * Market name.
     *
     * @var string
     */
    public $market_name;

    /**
     * Name color.
     *
     * @var string|null
     */
    public $name_color;

    /**
     * Background color.
     *
     * @var string|null
     */
    public $background_color;

    /**
     * Type.
     *
     * @var string
     */
    public $type;

    /**
     * Tradable.
     *
     * @var boolean
     */
    public $tradable;

    /**
     * Marketable.
     *
     * @var boolean
     */
    public $marketable;

    /**
     * Commodity.
     *
     * @var boolean
     */
    public $commodity;

    /**
     * Market tradable restriction.
     *
     * @var int
     */
    public $market_tradable_restriction;

    /**
     * Market marketable restriction.
     *
     * @var int|null
     */
    public $market_marketable_restriction;

    /**
     * Actions array.
     *
     * @var array|null
     */
    public $actions;

    /**
     * Market actions array.
     *
     * @var array|null
     */
    public $market_actions;

    /**
     * Descriptions array.
     *
     * @var array
     */
    public $descriptions = [];

    /**
     * Tags array.
     *
     * @var array
     */
    public $tags = [];

    /**
     * Item constructor.
     *
     * @param array $assets
     * @param array $descriptions
     */
    public function __construct(array $assets, array $descriptions)
    {
        $this->appid = $assets['appid'];
        $this->contextid = $assets['contextid'];
        $this->assetid = $assets['assetid'];
        $this->classid = $assets['classid'];
        $this->instanceid = $assets['instanceid'];
        $this->amount = $assets['amount'];
        $this->currency = $descriptions['currency'];
        $this->icon_url = $descriptions['icon_url'];
        if (isset($descriptions['icon_url_large'])) {
            $this->icon_url_large = $descriptions['icon_url_large'];
        }
        $this->name = $descriptions['name'];
        $this->market_hash_name = $descriptions['market_hash_name'];
        $this->market_name = $descriptions['market_name'];
        $this->name_color = $descriptions['name_color'];
        $this->background_color = $descriptions['background_color'];
        $this->type = $descriptions['type'];
        $this->tradable = $descriptions['tradable'];
        $this->marketable = $descriptions['marketable'];
        $this->commodity = $descriptions['commodity'];
        $this->market_tradable_restriction = (isset($descriptions['market_tradable_restriction']) ? intval($descriptions['market_tradable_restriction'], 10) : 0);
        $this->market_marketable_restriction = (isset($descriptions['market_marketable_restriction']) ? intval($descriptions['market_marketable_restriction'], 10) : 0);
        if (isset($descriptions['actions'])) {
            $this->actions = $descriptions['actions'];
        }
        if (isset($descriptions['market_actions'])) {
            $this->market_actions = $descriptions['market_actions'];
        }
        if (isset($descriptions['descriptions'])) {
            $this->setDescriptions($descriptions['descriptions']);
        }
        $this->setTags($descriptions['tags']);
    }

    /**
     * Echo rendered description.
     *
     * @return string
     */
    public function description() : string
    {
        $rendered = '';

        foreach ($this->descriptions as $description) {
            if ($description['value'] === ' ') {
                $rendered .= '<br>';
                continue;
            }
            if ($description['type'] === 'text' || $description['type'] === 'html') {
                if (isset($description['color'])) {
                    $rendered .= "<p style='color:{$description['color']}'>{$description['value']}</p>";
                } else {
                    $rendered .= "<p>{$description['value']} </p>";
                }
            }
        }

        echo $rendered;
    }

    /**
     * Get descriptions.
     *
     * @return array
     */
    public function getDescriptions() : array
    {
        return $this->descriptions;
    }

    /**
     * Set descriptions.
     *
     * @param array $descriptions
     * @return void
     */
    public function setDescriptions(array $descriptions) : void
    {
        $this->descriptions = $descriptions;
    }

    /**
     * Get tags.
     *
     * @return array
     */
    public function getTags() : array
    {
        return $this->tags;
    }

    /**
     * Set tags.
     *
     * @param array $tags
     * @return void
     */
    public function setTags($tags) : void
    {
        $this->tags = $tags;
    }

    /**
     * Tag.
     *
     * @param string $category
     * @return array
     */
    public function getTag(string $category) : array
    {
        if (! $this->tags) {
            return [];
        }

        foreach ($this->tags as $tag) {
            if ($tag->category === $category) {
                return $tag;
            }
        }

        return [];
    }

    /**
     * Image url.
     *
     * @return string
     */
    public function imageUrl() : string
    {
        return self::BASE_URL . "{$this->icon_url}/";
    }

    /**
     * Large image url.
     *
     * @return string
     */
    public function largeImageUrl() : string
    {
        if (! $this->icon_url_large) {
            return $this->imageUrl();
        }

        return self::BASE_URL . "{$this->icon_url_large}/";
    }
}
