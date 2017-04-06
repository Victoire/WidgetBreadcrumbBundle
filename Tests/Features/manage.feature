@mink:selenium2 @alice(Page) @reset-schema
Feature: Manage a Breadcrumb widget

    Background:
        Given I am on "/en/victoire-dcms/template/show/1"

    Scenario: I can create a new Breadcrumb widget
        When I switch to "layout" mode
        Then I should see "New content"
        When I select "Breadcrumb" from the "1" select of "main_content" slot
        Then I should see "Widget (Breadcrumb)"
        And I should see "1" quantum
        And I should see "No settings required. Thank you to click save to create the breadcrumb."
        And I submit the widget
        Then I should see the success message for Widget edit
        When I am on "/en/english-test"
        Then I should see "English test"
        And I should see "Homepage"
        And I should not be able to follow "English Test"
        When I follow "Homepage"
        Then I should be on "/en/"