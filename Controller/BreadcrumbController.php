<?php

namespace Victoire\Widget\BreadcrumbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Victoire\PageBundle\Entity\BasePage;

/**
 * Display a breadcrumb for a given page
 */
class BreadcrumbController extends Controller
{
    /**
     * @Route("/show")
     * @Template()
     * @ParamConverter("page", class="VictoirePageBundle:BasePage")
     */
    public function showAction(BasePage $page)
    {
        $breadcrumb = $this->get('victoire_cms.widget_breadcrumb_builder');

        return array(
            'breadcrumb' => $breadcrumb->build($page));
    }

}
