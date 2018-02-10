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

namespace PHPSteamInventory\Contracts;

/**
 * Configuration.
 *
 * @author Matthew Lilley <hello@matthewlilley.com>
 * @license MIT
 */
interface Configuration
{
    /**
     * Steamid.
     *
     * @return int|string
     */
    public function getSteamid();

    /**
     * Set Steamid.
     *
     * @param  int|string $steamid
     * @throws \Exception
     * @return void
     */
    public function setSteamid($steamid) : void;

    /**
     * Appid.
     *
     * @return int|string
     */
    public function getAppid();

    /**
     * Set Appid.
     *
     * @param  int|string $appid 
     * @return void
     */
    public function setAppid($appid) : void;

    /**
     * Contextid.
     *
     * @return int|string
     */
    public function getContextid();

    /**
     * Set Contextid.
     *
     * @param  int|string $contextid 
     * @return void
     */
    public function setContextid($contextid) : void;

    /**
     * Language.
     *
     * @return string
     */
    public function getLanguage() : string;

    /**
     * Set Language.
     *
     * @param  string $language
     * @throws \InvalidArgumentException
     * @return void
     */
    public function setLanguage(string $language) : void;

    /**
     * Count.
     *
     * @return int|string
     */
    public function getCount();

    /**
     * Set count.
     *
     * @param  int|string $count
     * @return void
     */
    public function setCount($count):  void;

    /**
     * Start assetid.
     *
     * @return string
     */
    public function getStartAssetid() : ?string;

    /**
     * Set start assetid.
     *
     * @param  int|string $startAssetid
     * @throws \Exception
     * @return void
     */
    public function setStartAssetid($startAssetid) : void;

    /**
     * Proxy.
     *
     * @return string
     */
    public function getProxy() : ?string;

    /**
     * Set proxy.
     *
     * @param  string $proxy
     * @return void
     */
    public function setProxy(string $proxy) : void;

    /**
     * All.
     *
     * @return boolean
     */
    public function getAll() : bool;

    /**
     * Set All.
     *
     * @param  boolean $all
     * @return void
     */
    public function setAll(bool $all = true) : void;
}
