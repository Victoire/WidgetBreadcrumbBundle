Victoire Breadcrumb Bundle
============

Need to add a breadcrumb in a victoire website ?
Get this breadcrumb bundle and so on

First you need to have a valid Symfony2 Victoire edition.
Then you just have to run the following composer command :

    php composer.phar require friendsvictoire/breadcrumb-widget

The breadcrumb bundle handles Bootstrap and Foundation view.


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
