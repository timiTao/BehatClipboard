<?php
/**
 * User: Tomasz Kunicki
 * Date: 14.11.2014
 */
namespace Behat\ClipboardExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use Behat\ClipboardExtension\Clipboard\ClipboardInterface;
use Behat\ClipboardExtension\Context\ClipboardContextInterface;

/**
 * Class ClipboardInitializer
 *
 * @package Behat\ClipboardExtension\Clipboard\Context\Initializer
 */
class ClipboardInitializer implements ContextInitializer
{
    /**
     * @var ClipboardInterface
     */
    protected $clipboard;

    /**
     * @param ClipboardInterface $clipboard
     */
    function __construct(ClipboardInterface $clipboard)
    {
        $this->clipboard = $clipboard;
    }

    /**
     * Initializes provided context.
     *
     * @param Context $context
     */
    public function initializeContext(Context $context)
    {
        if (!$context instanceof ClipboardContextInterface) {
            return;
        }
        /** @var ClipboardContextInterface $context */

        $context->setClipboard($this->clipboard);
    }
}