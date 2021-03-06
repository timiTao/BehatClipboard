<?php
/**
 * User: Tomasz Kunicki
 * Date: 14.11.2014
 */
namespace Behat\ClipboardExtension\Clipboard;

/**
 * Class ClipboardContainer
 *
 * @package Behat\ClipboardExtension\Clipboard
 */
class ClipboardContainer extends \ArrayObject implements ClipboardInterface
{

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->offsetGet($key);
    }
}
