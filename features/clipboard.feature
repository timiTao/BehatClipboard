@coreTest
@clipboard
Feature: Test base clipboard context
  Scenario Outline: Assert the value "([^"]*)" equals "([^"]*)
    #key is without prefix
    Given Clipboard save the value "<value>" on key "<key>"
    Then Clipboard contain key "<key>"
    And Clipboard has value "<value>" on key "<key>"
    #next step should change clipboardKey to value stored in clipboard
    And Clipboard over key "<clipboardKey>" have "<value>"
    Then Clipboard move value from "<key>" to "<key2>"
    And Clipboard has value "<value>" on key "<key2>"

  Examples:
    | value   | key                 | clipboardKey                   | key2      |
    | 421     | keyTest2            | clipboard(keyTest2)            | key2Test  |
    | 56789jj | keyTest.test1.test2 | clipboard(keyTest.test1.test2) | key2Test3 |

  Scenario: Table saving data
    Given Clipboard save the table
      | clipboardKey | clipboardValue |
      | test1        | aaa            |
      | test11.22    | bbb            |
    And Clipboard has value "aaa" on key "test1"

  Scenario: Test defaults
    Given Clipboard has value "value1" on key "key1"
    And Clipboard has value "value2" on key "key2.key2"

  Scenario: Clipboard replace in tables
    Given Clipboard save the value "testValue" on key "keyInArray"
    Given Clipboard save the table
      | clipboardKey | clipboardValue        |
      | test1        | clipboard(keyInArray) |
    And Clipboard has value "testValue" on key "test1"

  Scenario: Test replace in pyString
    Given Clipboard save on key "testKey" the value:
    """
    testKeyValue
    """
    Then Clipboard save on key "testKey2" the value:
    """
    test clipboard(testKey) test2
    """
    Then Clipboard has value "test testKeyValue test2" on key "testKey2"

  Scenario: Test multiple replace in pyString
    Given Clipboard save the table
      | clipboardKey | clipboardValue |
      | testKey1     | value1         |
      | testKey2     | value2         |
    Then Clipboard save on key "testKey2" the value:
    """
    test clipboard(testKey1) test2 clipboard(testKey2)
    """
    Then Clipboard has value "test value1 test2 value2" on key "testKey2"
