<?php
/**
 * User: Tomasz Kunicki
 * Date: 14.11.2014
 */
namespace Behat\ClipboardExtension\Context;

use Behat\ClipboardExtension\Clipboard\ClipboardInterface;

/**
 * Interface ClipboardContextInterface
 *
 * @package Behat\ClipboardExtension\Clipboard
 */
interface ClipboardContextAwareInterface
{
    /**
     * @param ClipboardInterface $container
     * @return void
     */
    public function setClipboard(ClipboardInterface $container);
}
