<?php
namespace Victoire\Widget\BreadcrumbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\CmsBundle\Entity\Widget;

/**
 * WidgetBreadcrumb
 *
 * @ORM\Table("cms_widget_breadcrumb")
 * @ORM\Entity
 */
class WidgetBreadcrumb extends Widget
{
    use \Victoire\CmsBundle\Entity\Traits\WidgetTrait;

}
