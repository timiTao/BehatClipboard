<?php
/**
 * User: Tomasz Kunicki
 * Date: 14.11.2014
 */
namespace Behat\ClipboardExtension\Context\Reader\Transform;

/**
 * Interface ClipboardTransformInterface
 *
 * @package Behat\ClipboardExtension\Clipboard\Context\Reader\Transform
 */
interface ClipboardTransformInterface
{
    /**
     * @param mixed $data
     * @return mixed
     */
    public function transform($data);
}