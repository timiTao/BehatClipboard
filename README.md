[![License](https://poser.pugx.org/timitao/behatclipboard/license.svg)](https://packagist.org/packages/timitao/behatclipboard)
[![Latest Stable Version](https://poser.pugx.org/timitao/behatclipboard/v/stable.svg)](https://packagist.org/packages/timitao/behatclipboard)
[![Latest Unstable Version](https://poser.pugx.org/timitao/behatclipboard/v/unstable.svg)](https://packagist.org/packages/timitao/behatclipboard) 
[![Total Downloads](https://poser.pugx.org/timitao/behatclipboard/downloads.svg)](https://packagist.org/packages/timitao/behatclipboard)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/819444f5-acac-4508-bf3f-185cef9dd4ec/mini.png)](https://insight.sensiolabs.com/projects/819444f5-acac-4508-bf3f-185cef9dd4ec)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/timitao/behatclipboard/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/timitao/behatclipboard/?branch=master)
[![Build Status](https://travis-ci.org/timiTao/BehatClipboard.svg?branch=master)](https://travis-ci.org/timiTao/BehatClipboard)


BehatClipboard
==============

BehatClipboard is an integration layer between Behat 3.0+ and it provides:

* Additional service for Behat ``Clipboard``,
* base ``Behat\ClipboardExtension\Context\FeatureContext`` context which provides base
  step definitions for your contexts,
* allow to share data between contexts - all,
* allow to use keys, in scenarios - and will be replaced, in:
** TableNode
** PyString
** Value

Purpose of this is that, I'm testing REST API. In return I get JSON that want call universal way.
I'm saving last respond to clipboard and freely call this by ``clipboard(last_response.body.KEY.KEY.KEY)``

## Flow

System generate a container that hold data. We could save there and read inside context. 
Clipboard will we shared between all context that implement interface ``Behat\ClipboardExtension\Context\ClipboardContextAwareInterface``;

Extension add event for transform data in scenario with given ``prefix`` and ``pattern``.

In default, it will look for example: ``clipboard(test1)``, where ``test1`` is key from clipboard 
and replace in scenario before execute step. The transform not depend on given context.

    Given Clipboard save the value "10" on key "test1"
    #in next step clipboard.test1 will be transformed to 10, and send to step
    And Clipboard over key "clipboard(test1)" have "10" 

Minimum functionality you need to implement in your context is saving to clipboard. Like in ``Behat\ClipboardExtension\Context\FeatureContext``:

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
    
## Installing extension

The easiest way to install is by using [Composer](https://getcomposer.org):

```bash
$> curl -sS https://getcomposer.org/installer | php
$> php composer.phar require timitao/behatclipboard='1.0.*'
```

or composer.json

    "require": {
        "timitao/behatclipboard": "1.0.*"
    },
    
## Action

Base context allow:
* save value on key to clipboard
* check containing KEY by clipboard
* copy from KEY1 to KEY2
* save multi values by TableNode
* save PyString by key

## Examples

Look at this [clipboard.feature](https://github.com/timiTao/BehatClipboard/blob/master/features/clipboard.feature)

## Default

We can define default values for clipboard by:

    extensions:
        Behat\ClipboardExtension\ClipboardExtension:
            defaults:
                key1: value1
                key2.key2 : value2

## Extra

Additionally, it assist dotNotification.

If you save array on ``[test=>[test2=>15]]`` in scenario, you could call this by 
* ``clipboard(test1)`` to get ``[test2=>15]``
* ``clipboard(test.test2)`` to get ``15``

## Configuration

Actually used configuration:
* ``prefix`` - prefix for recognise data in scenario to replace. Default: ``clipboard``
* ``pattern`` - pattern that will be complete with prefix and looking data to transform from clipboard. Default: ``/%s\(([a-zA-Z0-9_\.\-]+)\)/``

## Versioning
 
Staring version ``1.0.0``, will follow [Semantic Versioning v2.0.0](http://semver.org/spec/v2.0.0.html).

## Contributors

* Tomasz Kunicki [TimiTao](http://github.com/timiTao) [lead developer]
