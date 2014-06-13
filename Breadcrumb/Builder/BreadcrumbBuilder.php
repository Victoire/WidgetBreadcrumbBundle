<?php
namespace Victoire\Widget\BreadcrumbBundle\Breadcrumb\Builder;

use Knp\Menu\FactoryInterface;
use Victoire\Bundle\PageBundle\Entity\BasePage;

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
     * @param BasePage $page The page
     * @return MenuItem
     * @author lenybernard
     **/
    public function build(BasePage $page)
    {
        $breadcrumb = $this->factory->createItem('root');

        $_page = $page;
        $parents = array();
        while ($_page->getParent()) {
            $_page = $_page->getParent();
            $parents[] = $_page;
        }

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
        $breadcrumb->addChild($page->getSlug())->setLabel($page->getTitle())->setCurrent(true);

        return $breadcrumb;
    }
}
