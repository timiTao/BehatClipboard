<?php
/**
 * User: Tomasz Kunicki
 * Date: 16.12.2014
 */

namespace Behat\ClipboardExtension\Transformer;

use Behat\Behat\Definition\Call\DefinitionCall;
use Behat\Behat\Transformation\Transformer\ArgumentTransformer;
use Behat\ClipboardExtension\Clipboard\ClipboardInterface;
use Behat\ClipboardExtension\Exception\ClipboardException;
use Behat\Gherkin\Node\ArgumentInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Class ClipboardArgumentTransformer
 *
 * @package Behat\ClipboardExtension\Transformer
 */
class ClipboardArgumentTransformer implements ArgumentTransformer
{
    /**
     * @var ClipboardInterface
     */
    protected $clipboard;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param ClipboardInterface $clipboard
     * @param $parameters
     */
    function __construct(ClipboardInterface $clipboard, $parameters)
    {
        $this->clipboard = $clipboard;
        $this->parameters = $parameters;
    }

    /**
     * Checks if transformer supports argument.
     *
     * @param DefinitionCall $definitionCall
     * @param integer|string $argumentIndex
     * @param mixed $argumentValue
     *
     * @return Boolean
     */
    public function supportsDefinitionAndArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        return !is_object($argumentValue) || $argumentValue instanceof ArgumentInterface;
    }

    /**
     * Transforms argument value using transformation and returns a new one.
     *
     * @param DefinitionCall $definitionCall
     * @param integer|string $argumentIndex
     * @param mixed $argumentValue
     *
     * @return mixed
     */
    public function transformArgument(DefinitionCall $definitionCall, $argumentIndex, $argumentValue)
    {
        if ($argumentValue instanceof TableNode) {
            return $this->transformTableNode($argumentValue);
        }
        if ($argumentValue instanceof PyStringNode) {
            return $this->transformPyString($argumentValue);
        }

        if (is_array($argumentValue)) {
            return $argumentValue;
        }

        return $this->transformValue($argumentValue);
    }

    /**
     * @param $argumentValue
     * @return mixed
     *
     * @throws ClipboardException
     */
    protected function transformValue($argumentValue)
    {
        $pattern = sprintf($this->getPattern(), $this->getPrefix());

        if (!preg_match_all($pattern, $argumentValue, $matches)) {
            return $argumentValue;
        }

        $clipboard = $this->clipboard;

        if (count($matches[0]) == 1) {
            $matchedPattern = $matches[0][0];
            $matchedKey = $matches[1][0];
            if (!$clipboard->has($matchedKey)) {
                if ($this->isExceptionMode()) {
                    throw new ClipboardException("Given key don't exists: " . $matchedKey);
                }

                return $argumentValue;
            }

            $newValue = $clipboard->get($matchedKey);

            if (strlen($matchedPattern) == strlen($argumentValue)) {
                return $newValue;
            }

            return str_replace($matchedPattern, $newValue, $argumentValue);
        }


        $clipboardValues = [];
        foreach ($matches[1] as $key => $matchedKey) {
            $clipboardValues[$key] = null;
            if (!$clipboard->has($matchedKey)) {
                if ($this->isExceptionMode()) {
                    throw new ClipboardException("Given key don't exists: " . $matchedKey);
                }
            }
            $clipboardValues[$key] = $clipboard->get($matchedKey);
        }

        $newValue = str_replace($matches[0], $clipboardValues, $argumentValue);

        return $newValue;
    }

    /**
     * @param TableNode $table
     * @return TableNode
     */
    protected function transformTableNode(TableNode $table)
    {
        $tempList = $table->getTable();
        foreach ($tempList as $key => $row) {
            foreach ($row as $columnKey => $column) {
                $newValue = $this->transformValue($column);
                $tempList[$key][$columnKey] = $newValue;
            }
        }

        return new TableNode($tempList);
    }

    /**
     * @param PyStringNode $stringNode
     * @return PyStringNode
     */
    protected function transformPyString(PyStringNode $stringNode)
    {
        $newValue = $this->transformValue($stringNode->getRaw());
        $strings = explode("\n", $newValue);

        return new PyStringNode($strings, $stringNode->getLine());
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

    /**
     * @return bool
     */
    private function isExceptionMode()
    {
        return $this->parameters['exception_mode'];
    }
}
