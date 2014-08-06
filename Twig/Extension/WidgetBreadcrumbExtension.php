<?php

namespace Victoire\Widget\BreadcrumbBundle\Twig\Extension;

use Victoire\Bundle\CoreBundle\Template\TemplateMapper;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Victoire\Widget\BreadcrumbBundle\Breadcrumb\Builder\BreadcrumbBuilder;

/**
 * PageExtension extends Twig with view capabilities.
 */
class WidgetBreadcrumbExtension extends \Twig_Extension
{
    protected $breadcrumbBuilder = null;

    /**
     * Constructor
     *
     * @param TemplateMapper    $templating
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
     * @param View   $view   The current view
     * @param Entity $entity The current entity
     *
     * @return string the widget actions (buttons edit, move and delete)
     */
    public function cmsBreadcrumb(Widget $widget, $view, $entity)
    {
        //the twig template might not have access to the current view
        if ($view === null) {
            //so we use the view of the widget
            $view = $widget->getView();
        }

        $builder = $this->breadcrumbBuilder;
        $breadcrumbs = $builder->build($view, $entity);

        return $this->templating->render(
            'VictoireWidgetBreadcrumbBundle:Breadcrumb:show.html.twig',
            array('breadcrumbs' => $breadcrumbs)
        );
    }
}
