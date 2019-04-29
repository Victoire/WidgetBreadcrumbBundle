<?php

namespace Victoire\Widget\BreadcrumbBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\Container;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Victoire\Widget\BreadcrumbBundle\Breadcrumb\Builder\BreadcrumbBuilder;

/**
 * PageExtension extends Twig with view capabilities.
 */
class WidgetBreadcrumbExtension extends \Twig_Extension
{
    protected $container;
    protected $breadcrumbBuilder = null;

    /**
     * Constructor.
     *
     * @param Container         $templating
     * @param BreadcrumbBuilder $breadcrumbBuilder
     */
    public function __construct(Container $container, BreadcrumbBuilder $breadcrumbBuilder)
    {
        $this->breadcrumbBuilder = $breadcrumbBuilder;
        $this->container = $container;
    }

    /**
     * register twig functions.
     *
     * @return array The list of extensions
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cms_breadcrumb', [$this, 'cmsBreadcrumb'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * register twig filters.
     *
     * @return array The list of filters
     */
    public function getFilters()
    {
        return [];
    }

    /**
     * get extension name.
     *
     * @return string The name
     */
    public function getName()
    {
        return 'cms_widget_breadcrumb';
    }

    /**
     * render actions for a widget.
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
            $view = $widget->getWidgetMap()->getView();
        }

        $builder = $this->breadcrumbBuilder;
        $breadcrumbs = $builder->build($view, $entity);

        return $this->container->get('templating')->render(
            'VictoireWidgetBreadcrumbBundle:Breadcrumb:show.html.twig',
            [
                'breadcrumbs' => $breadcrumbs,
                'widget' => $widget
            ]
        );
    }
}
