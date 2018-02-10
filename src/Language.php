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
 * Language.
 *
 * @author Matthew Lilley <hello@matthewlilley.com>
 * @license MIT
 */
final class Language
{
    /**
     * Languages.
     *
     * @var array
     */
    private static $languages = [
        'arabic',
        'bulgarian',
        'schinese',
        'tchinese',
        'czech',
        'danish',
        'dutch',
        'english',
        'finnish',
        'french',
        'german',
        'greek',
        'hungarian',
        'italian',
        'japanese',
        'koreana',
        'nowegian',
        'polish',
        'portuguese',
        'brazilian',
        'romanian',
        'russian',
        'spanish',
        'swedish',
        'thai',
        'turkish',
        'ukrainian'
    ];

    /**
     * All languages.
     *
     * @return array
     */
    public static function all() : array
    {
        return self::$languages;
    }

    /**
     * Invalid language.
     *
     * @param string $language
     * @return boolean
     */
    public static function invalid($language) : bool
    {
        return ! in_array(strtolower($language), self::$languages);
    }
}
