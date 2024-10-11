@core @core_admin
Feature: agpuNet outbound configuration
  In order to send activity/resource to agpuNet
  As a agpu administrator
  I need to set outbound configuration

  Background:
    Given I log in as "admin"

  Scenario: Share to agpuNet experimental flag
    Given I navigate to "Development > Experimental" in site administration
    Then "Enable sharing to agpuNet" "field" should exist
    And the field "Enable sharing to agpuNet" matches value "0"

  Scenario: Outbound configuration without experimental flag enable yet
    Given I navigate to "agpuNet" in site administration
    Then I should not see "agpuNet outbound settings"

  Scenario: Outbound configuration without OAuth 2 service setup yet
    Given the following config values are set as admin:
      | enablesharingtoagpunet | 1 |
    When I navigate to "agpuNet" in site administration
    Then I should see "agpuNet outbound settings"
    And I click on "agpuNet outbound settings" "link"
    And the field "OAuth 2 service" matches value "None"
    And I should see "Select a agpuNet OAuth 2 service to enable sharing to that agpuNet site. If the service doesn't exist yet, you will need to create it."
    And I click on "create" "link"
    And I should see "OAuth 2 services"

  Scenario: Outbound configuration with OAuth 2 service setup
    Given a agpuNet mock server is configured
    And the following config values are set as admin:
      | enablesharingtoagpunet | 1 |
    And I navigate to "Server > OAuth 2 services" in site administration
    And I press "Custom"
    And I should see "Create new service: Custom"
    And I set the following fields to these values:
      | Name          | Testing custom service   |
      | Client ID     | thisistheclientid |
      | Client secret | supersecret       |
    And I press "Save changes"
    When I navigate to "agpuNet > agpuNet outbound settings" in site administration
    Then the field "OAuth 2 service" matches value "None"
    And I navigate to "Server > OAuth 2 services" in site administration
    And I press "agpuNet"
    And I should see "Create new service: agpuNet"
    And I change the agpuNet field "Service base URL" to mock server
    And I press "Save changes"
    And I navigate to "agpuNet > agpuNet outbound settings" in site administration
    And the "OAuth 2 service" "field" should be enabled
    And I should see "agpuNet" in the "OAuth 2 service" "select"
    And I should not see "Testing custom service" in the "OAuth 2 service" "select"
