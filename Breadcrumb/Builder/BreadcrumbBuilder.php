<?php
namespace Victoire\Widget\BreadcrumbBundle\Breadcrumb\Builder;

use Knp\Menu\FactoryInterface;
use Victoire\PageBundle\Entity\BasePage;

/**
 * This class generate a breadcrumb for a Victoire CMS page given
 *
 * @package VictoireWidgetBreadcrumbBundle
 * @author
 **/
class BreadcrumbBuilder
{
    private $factory;

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
            $item = $breadcrumb
                ->addChild($key, array(
                    'route' => 'victoire_cms_page_show',
                    'label' => $_page->getTitle(),
                    'routeParameters' => array(
                        'slug' => $_page->getSlug()
                    )
                ))
                ->setCurrent(false);
        }

        //Add the current page
        $breadcrumb->addChild($page->getSlug())->setLabel($page->getTitle())->setCurrent(true);

        return $breadcrumb;
    }
} // END class BreadcrumbBuilder
