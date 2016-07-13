<?php

namespace Victoire\Widget\BreadcrumbBundle\Breadcrumb\Builder;

use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Victoire\Bundle\CoreBundle\Entity\View;

/**
 * This class generate a breadcrumb for a Victoire CMS view given.
 *
 * ref: victoire_core.widget_breadcrumb_builder
 **/
class BreadcrumbBuilder
{
    protected $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Build a breadcrumb for a Victoire CMS view given.
     *
     * @param View   $view   The view
     * @param object $entity The current entity
     *
     * @return MenuItem
     *
     * @author lenybernard
     **/
    public function build(View $view, $entity)
    {
        $breadcrumb = $this->factory->createItem('root');

        $_view = $view;
        $initialLocale = $view->getCurrentLocale();
        $parents = [];

        //create the list of view with the parents views
        while ($_view->getParent()) {
            /** @var View $_view */
            $_view->setCurrentLocale($initialLocale); //Force locale to current locale
            $_view = $_view->getParent();
            $parents[] = $_view;
        }

        //build the items of the breadcrumb
        foreach (array_reverse($parents) as $key => $_view) {
            $breadcrumb->addChild(
                $key,
                [
                    'route'           => 'victoire_core_page_show',
                    'label'           => $_view->getName(),
                    'routeParameters' => ['url' => $_view->getReference($initialLocale)->getUrl()],
                ]
            )
            ->setCurrent(false);
        }

        //Add the current view
        $slug = $view->getSlug();
        $label = $view->getName();

        $breadcrumb->addChild($slug)->setLabel($label)->setCurrent(true);

        return $breadcrumb;
    }
}
