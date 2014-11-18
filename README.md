[![License](https://poser.pugx.org/timitao/behatclipboard/license.svg)](https://packagist.org/packages/timitao/behatclipboard)
[![Total Downloads](https://poser.pugx.org/timitao/behatclipboard/downloads.svg)](https://packagist.org/packages/timitao/behatclipboard)

BehatClipboard
==============

BehatClipboard is an integration layer between Behat 3.0+ and it provides:

* Additional service for Behat ``Clipboard``,
* base ``Behat\ClipboardExtension\Context\FeatureContext`` context which provides base
  step definitions for your contexts,
* allow to share data between contexts - all,
* auto translation by adding event in system,
* allow to use keys, in scenarios - and will be replaced.

Actual version is early access and still have some minor bugs.

Purpose of this is that, I'm testing REST API. In return I get JSON that want call universal way.
I'm saving last respond to clipboard and freely call this by ``clipboard.last_response.body.KEY.KEY.KEY``

Additionally, other example is universal container for holding data to use later in given scenario.
* register USER 
* save his USER_ID
* login as admin
* for given USER_ID accept
* logout
* log as USER

## Flow

System generate a container that hold data. We could save there and read inside context. 
Clipboard will we shared between all that implement interface;

Extension add event for transform data in scenario with given ``prefix`` and ``pattern``. 
In default, it will look for example: ``clipboard.test1``, where ``test1`` is key from clipboard 
and replace in scenario before execute step. The transform not depend on given context.

    Given Clipboard save the value "10" on key "test1"
    #in next step clipboard.test1 will be transformed to 10, and send to step
    And Clipboard over key "clipboard.test1" have "10" 

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
$> php composer.phar require timitao/behatclipboard='*'
```

or composer.json

    "require": {
        "timitao/behatclipboard": "*"
    },
    
## Action

Base context allow:
* save value on key to clipboard
* check containing KEY by clipboard
* copy from KEY1 to KEY2

## Extra

Additionally, it assist dotNotification.

If you save array on ``[test=>[test2=>15]]`` in scenario, you could call this by 
* ``clipboard.test`` to get ``[test2=>15]``
* ``clipboard.test.test2`` to get ``15``

## Configuration

Actually used configuration:
* ``prefix`` - prefix for recognise data in scenario to replace. Default: ``clipboard``
* ``pattern`` - pattern that will be complete with prefix and looking data to transform from clipboard. Default: ``/^%s\.([a-zA-Z0-9_\.]+)/``

## Contributors

* Tomasz Kunicki [TimiTao](http://github.com/timiTao) [lead developer]