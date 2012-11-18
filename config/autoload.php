<?php


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'MeinNamespace',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Classes
    'MeinNamespace\ContentMeinElement'                      => 'system/modules/parentchild/modules/ContentMeinElement.php',

));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'meinTemplate'    => 'system/modules/parentchild/templates',
));
