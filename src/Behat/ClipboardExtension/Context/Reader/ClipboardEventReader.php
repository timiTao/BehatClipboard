<?php
/**
 * User: Tomasz Kunicki
 * Date: 14.11.2014
 */
namespace Behat\ClipboardExtension\Context\Reader;

use Behat\Behat\Context\Environment\ContextEnvironment;
use Behat\Behat\Context\Reader\ContextReader;
use Behat\Behat\Transformation\Call\RuntimeTransformation;
use Behat\Testwork\Call\Callee;
use Behat\ClipboardExtension\Context\Reader\Transform\ClipboardTransformInterface;

/**
 * Class ClipboardEventReader
 *
 * @package Behat\ClipboardExtension\Clipboard\Context\Reader
 */
class ClipboardEventReader implements ContextReader
{

    /**
     * @var ClipboardTransformInterface
     */
    protected $transform;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param ClipboardTransformInterface $transform
     * @param array $parameters
     */
    function __construct(ClipboardTransformInterface $transform, $parameters)
    {
        $this->transform = $transform;
        $this->parameters = $parameters;
    }

    /**
     * Reads callees from specific environment & context.
     *
     * @param ContextEnvironment $environment
     * @param string $contextClass
     *
     * @return Callee[]
     */
    public function readContextCallees(ContextEnvironment $environment, $contextClass)
    {
        $transform = $this->transform;
        $callable = function ($data) use ($transform) {
            return $transform->transform($data);
        };

        $pattern = sprintf($this->getPattern(), $this->getPrefix());

        return [new RuntimeTransformation($pattern, $callable, '')];
    }

    /**
     * @return string
     */
    private function getPrefix()
    {
        return $this->parameters['prefix'];
    }
    /**
     * @return string
     */
    private function getPattern()
    {
        return $this->parameters['pattern'];
    }
}
