<?php
/**
 *
 * User: Tomasz Kunicki
 * Date: 20.11.2014
 * Time: 13:31
 */

namespace Behat\ClipboardExtension\Context;

use Behat\ClipboardExtension\Clipboard\ClipboardInterface;

/**
 * Only for use with PHP 5.4
 * Class ClipboardContextAwareTrait
 * @package Behat\ClipboardExtension\Context
 */
class ClipboardContextTrait implements ClipboardContextAwareInterface
{
    /**
     * @var ClipboardInterface
     */
    protected $clipboard;

    /**
     * @param ClipboardInterface $container
     * @return void
     */
    public function setClipboard(ClipboardInterface $container)
    {
        $this->clipboard = $container;
    }

    /**
     * @return ClipboardInterface
     */
    public function getClipboard()
    {
        return $this->clipboard;
    }
}
