<?php

namespace Victoire\Widget\BreadcrumbBundle\Twig\Extension;

use Victoire\Bundle\CoreBundle\Widget\Managers\WidgetManager;
use Victoire\Bundle\CoreBundle\Template\TemplateMapper;
use Victoire\Bundle\PageBundle\Entity\Page;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Victoire\Widget\BreadcrumbBundle\Breadcrumb\Builder\BreadcrumbBuilder;

/**
 * PageExtension extends Twig with page capabilities.
 */
class WidgetBreadcrumbExtension extends \Twig_Extension
{
    protected $breadcrumbBuilder = null;

    /**
     * Constructor
     *
     * @param WidgetManager     $widgetManager
     * @param BreadcrumbBuilder $breadcrumbBuilder
     */
    public function __construct(TemplateMapper $templating, BreadcrumbBuilder $breadcrumbBuilder)
    {
        $this->breadcrumbBuilder = $breadcrumbBuilder;
        $this->templating = $templating;
    }

    /**
     * register twig functions
     *
     * @return array The list of extensions
     */
    public function getFunctions()
    {
        return array(
            'cms_breadcrumb' => new \Twig_Function_Method($this, 'cmsBreadcrumb', array('is_safe' => array('html')))
        );
    }

    /**
     * register twig filters
     *
     * @return array The list of filters
     */
    public function getFilters()
    {
        return array();
    }

    /**
     * get extension name
     *
     * @return string The name
     */
    public function getName()
    {
        return 'cms_widget_breadcrumb';
    }

    /**
     * render actions for a widget
     *
     * @param Widget $widget The widget to render
     * @param Page   $page   The current page
     * @param Entity $entity The current entity
     *
     * @return string the widget actions (buttons edit, move and delete)
     */
    public function cmsBreadcrumb(Widget $widget, $page, $entity)
    {
        //the twig template might not have access to the current page
        if ($page === null) {
            //so we use the page of the widget
            $page = $widget->getPage();
        }

        $builder = $this->breadcrumbBuilder;

        $breadcrumbs = $builder->build($page, $entity);

        return $this->templating->render(
            'VictoireWidgetBreadcrumbBundle:Breadcrumb:show.html.twig',
            array('breadcrumbs' => $breadcrumbs)
        );
    }
}
