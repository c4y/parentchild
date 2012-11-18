<?php


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


