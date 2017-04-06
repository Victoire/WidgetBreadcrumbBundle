<?php

namespace Victoire\Widget\TitleBundle\Tests\Context;

use Knp\FriendlyContexts\Context\RawMinkContext;

class WidgetContext extends RawMinkContext
{
    /**
     * @Then /^I should not be able to follow "(.+)"$/
     */
    public function iShouldNotBeAbleToFollow($text)
    {
        $page = $this->getSession()->getPage();

        $link = $page->find('xpath', sprintf(
            'descendant-or-self::a[normalize-space(.) = "%s"]',
            $text
        ));
        if (null !== $link) {
            $message = sprintf(
                'Link with text "%s" exists.',
                $text
            );
            throw new \Behat\Mink\Exception\ResponseTextException($message, $this->getSession());
        }
    }
}
