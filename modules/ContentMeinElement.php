<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package Calendar
 * @link    http://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace MeinNamespace;


class ContentMeinElement extends \ContentElement
{

    protected $strTemplate = 'ce_template';

    /**
     * Generate the module
     */
    public function generate()
    {
        // hier wird compile automatisch aufgerufen
        return parent::generate();
    }



    protected function compile()
    {

        // $objTemplate = new \FrontendTemplate($strTemplate);
        // $objDB = \Database:getInstance()->prepare()->execute();
        // $objTemplate->title = "Titel"

    }



}


