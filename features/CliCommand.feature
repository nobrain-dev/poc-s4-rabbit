Feature: ......

#  Scenario: I can run command with only compulsory options to confirm it's terminal output.
#    Given I run the "say:hello" command with options:
#      | --name    | inanzzz |
#    Then the command output should be "Hello inanzzz."
#
#  Scenario: I can run command with all available options to confirm it's terminal output.
#    Given I run the "say:hello" command with options:
#      | --name    | inanzzz |
#      | --surname | brother |
#    Then the command output should be "Hello inanzzz brother."
#
#  Scenario: I cannot run command with invalid options.
#    Given I run the "say:hello" command with options:
#      | --nickname | inanzzz |
#    Then the command exception should be "InvalidOptionException"

  Scenario: I can run command with only compulsory options to confirm it's terminal output.
    Given I run the blu:object:message command
    Then the command output should be "Generate BluObject event and dispach with custom producer"
