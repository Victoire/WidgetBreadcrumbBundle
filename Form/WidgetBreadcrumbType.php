<?php

namespace Victoire\Widget\BreadcrumbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\EntityProxyFormType;
use Victoire\Bundle\CoreBundle\Form\WidgetType;


/**
 * WidgetBreadcrumb form type
 */
class WidgetBreadcrumbType extends WidgetType
{

    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //choose form mode
        if ($this->entity_name === null) {
            //if no entity is given, we generate the static form
            $builder;

        } else {
            //else, WidgetType class will embed a EntityProxyType for given entity
            parent::buildForm($builder, $options);
        }
    }


    /**
     * bind form to WidgetBreadcrumb entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\Widget\BreadcrumbBundle\Entity\WidgetBreadcrumb',
            'widget'             => 'breadcrumb',
            'translation_domain' => 'victoire'
        ));
    }


    /**
     * get form name
     */
    public function getName()
    {
        return 'appventus_victoirecorebundle_widgetbreadcrumbtype';
    }
}
