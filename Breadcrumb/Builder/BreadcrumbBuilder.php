<?php
namespace Victoire\Widget\BreadcrumbBundle\Breadcrumb\Builder;

use Knp\Menu\FactoryInterface;
use Victoire\Bundle\PageBundle\Entity\Page;

/**
 * This class generate a breadcrumb for a Victoire CMS page given
 *
 * @package VictoireWidgetBreadcrumbBundle
 * @author
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
     * Build a breadcrumb for a Victoire CMS page given
     *
     * @param Page   $page   The page
     * @param Entity $entity The current entity
     *
     * @return MenuItem
     * @author lenybernard
     **/
    public function build(Page $page, $entity)
    {
        $breadcrumb = $this->factory->createItem('root');

        $_page = $page;
        $parents = array();

        //create the list of page with the parents pages
        while ($_page->getParent()) {
            $_page = $_page->getParent();
            $parents[] = $_page;
        }

        //build the items of the breadcrumb
        foreach (array_reverse($parents) as $key => $_page) {
            $breadcrumb->addChild($key, array(
                    'route' => 'victoire_core_page_show',
                    'label' => $_page->getTitle(),
                    'routeParameters' => array('url' => $_page->getUrl())
                    )
            )
                ->setCurrent(false);
        }

        //Add the current page
        $slug = $page->getSlug();
        $label = $page->getTitle();

        $breadcrumb->addChild($slug)->setLabel($label)->setCurrent(true);

        return $breadcrumb;
    }
}
