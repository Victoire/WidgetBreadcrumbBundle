<?php
namespace Victoire\Widget\BreadcrumbBundle\Breadcrumb\Builder;

use Knp\Menu\FactoryInterface;
use Victoire\Bundle\PageBundle\Entity\BasePage;
use Victoire\Bundle\PageBundle\Entity\Page;
use Victoire\Bundle\BusinessEntityTemplateBundle\Entity\BusinessEntityTemplatePage;

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
     * @param BasePage $page   The page
     * @param Entity   $entity The current entity
     *
     * @return MenuItem
     * @author lenybernard
     **/
    public function build(BasePage $page, $entity)
    {
        $breadcrumb = $this->factory->createItem('root');

        //if the page is a business entity template
        if ($page instanceof BusinessEntityTemplatePage) {
            //and an entity is provided
            if ($entity !== null) {
                //then we create a fake page for the breadcrumb
                $fakePage = new Page();
                $fakePage->setTitle($entity->getId());
                $fakePage->setSlug($entity->getId());
                $fakePage->setParent($page);
                $page = $fakePage;
            }
        }

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
        $breadcrumb->addChild($page->getSlug())->setLabel($page->getTitle())->setCurrent(true);

        return $breadcrumb;
    }
}
