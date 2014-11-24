<?php
/**
 * User: Tomasz Kunicki
 * Date: 14.11.2014
 */
namespace Behat\ClipboardExtension\Context\Reader\Transform;

use Behat\ClipboardExtension\Clipboard\ClipboardInterface;

/**
 * Class ClipboardSubscriber
 * @package Behat\ClipboardExtension\Clipboard\Context\Reader
 */
class ClipboardTransform implements ClipboardTransformInterface
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
     * @param mixed $data
     * @return mixed
     */
    public function transform($data)
    {
        return $this->transformValue($data);
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    private function transformValue($data)
    {
        return $this->clipboard->get($data);
    }
}
