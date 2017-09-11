<?php

/**
 * This file is part of cocur/slugify.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocur\Slugify;

use Cocur\Slugify\RuleProvider\DefaultRuleProvider;
use Cocur\Slugify\RuleProvider\RuleProviderInterface;

/**
 * Slugify
 *
 * @package   Cocur\Slugify
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @author    Ivo Bathke <ivo.bathke@gmail.com>
 * @author    Marchenko Alexandr
 * @copyright 2012-2015 Florian Eckerstorfer
 * @license   http://www.opensource.org/licenses/MIT The MIT License
 */
class Slugify implements SlugifyInterface
{
    const LOWERCASE_NUMBERS_DASHES = '/([^A-Za-z0-9]|-)+/';

    /**
     * @var array<string,string>
     */
    protected $rules = [];

    /**
     * @var RuleProviderInterface
     */
    protected $provider;

    /**
     * @var array<string,mixed>
     */
    protected $options = [
        'regexp'    => self::LOWERCASE_NUMBERS_DASHES,
        'lowercase' => true,
        'rulesets'  => [
            'default',
            // Languages are preferred if they appear later, list is ordered by number of
            // websites in that language
            // https://en.wikipedia.org/wiki/Languages_used_on_the_Internet#Content_languages_for_websites
            'burmese',
            'hindi',
            'georgian',
            'norwegian',
            'vietnamese',
            'ukrainian',
            'latvian',
            'finnish',
            'greek',
            'swedish',
            'czech',
            'arabic',
            'turkish',
            'polish',
            'german',
            'russian',
        ],
    ];

    /**
     * @param array                 $options
     * @param RuleProviderInterface $provider
     */
    public function __construct(array $options = [], RuleProviderInterface $provider = null)
    {
        $this->options  = array_merge($this->options, $options);
        $this->provider = $provider ? $provider : new DefaultRuleProvider();

        foreach ($this->options['rulesets'] as $ruleSet) {
            $this->activateRuleSet($ruleSet);
        }
    }

    /**
     * Returns the slug-version of the string.
     *
     * @param string $string    String to slugify
     * @param string $separator Separator
     *
     * @return string Slugified version of the string
     */
    public function slugify($string, $separator = '-')
    {
        $string = strtr($string, $this->rules);
        if ($this->options['lowercase']) {
            $string = mb_strtolower($string);
        }
        $string = preg_replace($this->options['regexp'], $separator, $string);

        return trim($string, $separator);
    }

    /**
     * Adds a custom rule to Slugify.
     *
     * @param string $character   Character
     * @param string $replacement Replacement character
     *
     * @return Slugify
     */
    public function addRule($character, $replacement)
    {
        $this->rules[$character] = $replacement;

        return $this;
    }

    /**
     * Adds multiple rules to Slugify.
     *
     * @param array <string,string> $rules
     *
     * @return Slugify
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $character => $replacement) {
            $this->addRule($character, $replacement);
        }

        return $this;
    }

    /**
     * @param string $ruleSet
     *
     * @return Slugify
     */
    public function activateRuleSet($ruleSet)
    {
        return $this->addRules($this->provider->getRules($ruleSet));
    }

    /**
     * Static method to create new instance of {@see Slugify}.
     *
     * @param array <string,mixed> $options
     *
     * @return Slugify
     */
    public static function create(array $options = [])
    {
        return new static($options);
    }
}