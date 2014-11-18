<?php
/**
 * User: Tomasz Kunicki
 * Date: 14.11.2014
 */
namespace Behat\ClipboardExtension\Clipboard;

use Behat\Utils\DotNotation\DotNotation;

/**
 * Class ClipboardContainer
 *
 * @package Behat\ClipboardExtension\Clipboard
 */
class ClipboardContainer implements ClipboardInterface
{
    /**
     * @var DotNotation
     */
    protected $dotNotation;

    /**
     * @param array $parameters
     */
    function __construct($parameters = [])
    {
        $this->dotNotation = new DotNotation($parameters);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->dotNotation->set($key, $value);
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return $this->dotNotation->have($key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->dotNotation->get($key);
    }
}