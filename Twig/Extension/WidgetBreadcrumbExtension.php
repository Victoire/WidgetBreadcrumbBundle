<?php

namespace Victoire\Widget\BreadcrumbBundle\Twig\Extension;

use Victoire\Bundle\CoreBundle\Menu\MenuManager;
use Victoire\Bundle\CoreBundle\Widget\Managers\WidgetManager;
use Victoire\Bundle\CoreBundle\Template\TemplateMapper;
use Symfony\Component\Security\Core\SecurityContext;
use Victoire\Bundle\PageBundle\Entity\BasePage;
use Victoire\Bundle\BusinessEntityTemplateBundle\Entity\BusinessEntityTemplatePage;
use Victoire\Bundle\CoreBundle\Entity\Widget;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\PageBundle\Entity\Page;
use Victoire\Bundle\CoreBundle\Helper\WidgetHelper;
use Victoire\Bundle\PageBundle\WidgetMap\WidgetMapBuilder;
use Victoire\Bundle\CoreBundle\Handler\WidgetExceptionHandler;
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
     * @param WidgetManager          $widgetManager
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
        return array(
            'hash' => new \Twig_Filter_Method($this, 'hash'),
        );
    }

    /**
     * hash some string with given algorithm
     * @param string $value     The string to hash
     * @param string $algorithm The algorithm we have to use to hash the string
     *
     */
    public function hash($value, $algorithm = "md5")
    {
        try {
            return hash($algorithm, $value);
        } catch (Exception $e) {
            error_log('Please check that the '.$algorithm.' does exists because it failed when trying to run. We are expecting a valid algorithm such as md5 or sha512 etc.');

            return $value;
        }
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
     *
     * @return string the widget actions (buttons edit, move and delete)
     */
    public function cmsBreadcrumb(Page $page)
    {
        $builder = $this->breadcrumbBuilder;

        $breadcrumbs = $builder->build($page);

        return $this->templating->render(
            'VictoireWidgetBreadcrumbBundle:Breadcrumb:show.html.twig',
            array('breadcrumbs' => $breadcrumbs)
        );
    }
}
