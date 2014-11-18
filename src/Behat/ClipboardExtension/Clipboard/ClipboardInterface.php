<?php
/**
 * User: Tomasz Kunicki
 * Date: 14.11.2014
 */
namespace Behat\ClipboardExtension\Clipboard;

/**
 * Interface ClipboardInterface
 *
 * @package Behat\ClipboardExtension\Clipboard\Clipboard
 */
interface ClipboardInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);

    /**
     * @param string $key
     * @return boolean
     */
    public function has($key);

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);
}