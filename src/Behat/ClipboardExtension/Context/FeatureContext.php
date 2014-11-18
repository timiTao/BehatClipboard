<?php
/**
 * User: Tomasz Kunicki
 * Date: 13.11.2014
 */
namespace Behat\ClipboardExtension\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\ClipboardExtension\Clipboard\ClipboardInterface;

/**
 * Class FeatureContext
 * @package Behat\ClipboardExtension\Context
 */
class FeatureContext implements Context, SnippetAcceptingContext, ClipboardContextInterface
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
     * @Then Clipboard save the value :arg1 on key :arg2
     *
     * @param $arg1
     * @param $arg2
     */
    public function clipboardSaveTheValueOnKey($arg1, $arg2)
    {
        $this->clipboard->set($arg2, $arg1);
    }

    /**
     * @Then Clipboard contain key :arg1
     *
     * @param $arg1
     * @throws \RuntimeException
     */
    public function clipboardContainKey($arg1)
    {
        if (!$this->clipboard->has($arg1)) {
            throw new \RuntimeException('Clipboard don\'t have key ' . $arg1);
        }
    }

    /**
     * @Then Clipboard has value :arg1 on key :arg2
     *
     * @param string $arg1
     * @param string $arg2
     * @throws \RuntimeException
     */
    public function clipboardHasValueOnKey($arg1, $arg2)
    {
        if ($arg1 != $this->clipboard->get($arg2)) {
            throw new \RuntimeException('Clipboard don\'t have correct value on key ' . $arg2);
        }
    }

    /**
     * this is test, if arg1 will transform value from key, to value from clipboard
     *
     * @Then Clipboard over key :arg1 have :arg2
     *
     * @param $arg1
     * @param $arg2
     */
    public function clipboardOverKeyHave($arg1, $arg2)
    {
        if ($arg1 != $arg2) {
            throw new \RuntimeException(sprintf('Given values are not the same -> %s != %s', $arg1, $arg2));
        }
    }

    /**
     * @Then Clipboard move value from :arg1 to :arg2
     *
     * @param $arg1
     * @param $arg2
     */
    public function clipboardMoveFromTo($arg1, $arg2)
    {
        $value = $this->clipboard->get($arg1);
        $this->clipboard->set($arg2, $value);
    }
}