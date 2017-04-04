[![CircleCI](https://circleci.com/gh/Victoire/WidgetBreadcrumbBundle.svg?style=shield)](https://circleci.com/gh/Victoire/WidgetBreadcrumbBundle)

Victoire Breadcrumb Bundle
============

## What is the purpose of this bundle

This bundles gives you access to the *Breadcrumb Widget*.
With this widget, you can install a breadcrumb on any page.

## Set Up Victoire

If you haven't already, you can follow the steps to set up Victoire *[here](https://github.com/Victoire/victoire/blob/master/doc/setup.md)*

## Install the Bundle

Run the following composer command :

    php composer.phar require victoire/breadcrumb-widget

The breadcrumb bundle handles Bootstrap and Foundation view.

### Reminder

Do not forget to add the bundle in your AppKernel !

    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                ...
                new Victoire\Widget\BreadcrumbBundle\VictoireWidgetBreadcrumbBundle(),
            );

            return $bundles;
        }
    }
