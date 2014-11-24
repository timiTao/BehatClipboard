<?php
/**
 *
 * User: Tomasz Kunicki
 * Date: 24.11.2014
 */

namespace Behat\ClipboardExtension\Clipboard;

/**
 * Class Factory
 * @package Behat\ClipboardExtension\Clipboard
 */
class Factory
{
    /**
     * @return ClipboardInterface
     */
    public function __invoke()
    {
        return new ClipboardContainer();
    }
}