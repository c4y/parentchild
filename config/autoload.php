<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package Core
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


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
