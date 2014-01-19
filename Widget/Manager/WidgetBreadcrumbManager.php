<?php

namespace Victoire\Widget\BreadcrumbBundle\Widget\Manager;


use Victoire\Widget\BreadcrumbBundle\Form\WidgetBreadcrumbType;
use Victoire\Widget\BreadcrumbBundle\Entity\WidgetBreadcrumb;

class WidgetBreadcrumbManager
{
protected $container;

    /**
     * constructor
     *
     * @param ServiceContainer $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * create a new WidgetBreadcrumb
     * @param Page   $page
     * @param string $slot
     *
     * @return $widget
     */
    public function newWidget($page, $slot)
    {
        $widget = new WidgetBreadcrumb();
        $widget->setPage($page);
        $widget->setslot($slot);

        return $widget;
    }
    /**
     * render the WidgetBreadcrumb
     * @param Widget $widget
     *
     * @return widget show
     */
    public function render($widget)
    {
        return $this->container->get('victoire_templating')->render(
            "VictoireWidgetBreadcrumbBundle::show.html.twig",
            array(
                "widget" => $widget
            )
        );
    }

    /**
     * render WidgetBreadcrumb form
     * @param Form           $form
     * @param WidgetBreadcrumb $widget
     * @param BusinessEntity $entity
     * @return form
     */
    public function renderForm($form, $widget, $entity = null)
    {

        return $this->container->get('victoire_templating')->render(
            "VictoireWidgetBreadcrumbBundle::edit.html.twig",
            array(
                "widget" => $widget,
                'form'   => $form->createView(),
                'id'     => $widget->getId(),
                'entity' => $entity
            )
        );
    }

    /**
     * create a form with given widget
     * @param WidgetBreadcrumb $widget
     * @param string         $entityName
     * @param string         $namespace
     * @return $form
     */
    public function buildForm($widget, $entityName = null, $namespace = null)
    {
        $form = $this->container->get('form.factory')->create(new WidgetBreadcrumbType($entityName, $namespace), $widget);

        return $form;
    }

    /**
     * create form new for WidgetBreadcrumb
     * @param Form           $form
     * @param WidgetBreadcrumb $widget
     * @param string         $slot
     * @param Page           $page
     * @param string         $entity
     *
     * @return new form
     */
    public function renderNewForm($form, $widget, $slot, $page, $entity = null)
    {

        return $this->container->get('victoire_templating')->render(
            "VictoireWidgetBreadcrumbBundle::new.html.twig",
            array(
                "widget"          => $widget,
                'form'            => $form->createView(),
                "slot"            => $slot,
                "entity"          => $entity,
                "renderContainer" => true,
                "page"            => $page
            )
        );
    }
}
