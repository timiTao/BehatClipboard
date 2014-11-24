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
    | value   | key                 | clipboardKey                  | key2      |
    | 421     | keyTest2            | clipboard.keyTest2            | key2Test  |
    | 56789jj | keyTest.test1.test2 | clipboard.keyTest.test1.test2 | key2Test3 |

  Scenario: Table saving data
    Given Clipboard save the table
      | clipboardKey | clipboardValue |
      | test1        | aaa            |
      | test11.22    | bbb            |
    And Clipboard has value "aaa" on key "test1"

  Scenario: Test defaults
    Given Clipboard has value "value1" on key "key1"
    And Clipboard has value "value2" on key "key2.key2"