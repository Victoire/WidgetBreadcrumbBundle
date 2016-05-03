<?php

namespace Victoire\Widget\BreadcrumbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetBreadcrumb.
 *
 * @ORM\Table("vic_widget_breadcrumb")
 * @ORM\Entity
 */
class WidgetBreadcrumb extends Widget
{
    /**
     * Generate the cache ID with the path build with parents view name
     * to invalid when a parent name is modified.
     *
     * @return string
     */
    public function generateCacheId()
    {
        $view = $this->getCurrentView();
        $nameChain = $view->getReference()->getName();
        while ($view = $view->getParent()) {
            $nameChain .= '/'.$view->getReference()->getName();
        }

        return sprintf('%s-%s-%s-%s',
            $this->getId(),
            $this->getUpdatedAt()->getTimestamp(),
            md5($nameChain),
            $this->getCurrentView()->getReference()->getId()
        );
    }
}
