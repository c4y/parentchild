<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   GalleryXT 
 * @author    Oliver Lohoff 
 * @license   LGPL 
 * @copyright Oliver Lohoff 
 */


/**
 * Table tl_parentchild
 */
$GLOBALS['TL_DCA']['tl_parentchild'] = array
(

	// Config
	'config' => array
	(
        'dataContainer'               => 'Table',
        'ctable'                      => array('tl_parentchild_elements'),
        'switchToEdit'                => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('title'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit'
        ),

        'label' => array
        (
            'fields'                  => array('title'),
            'format'                  => '%s'
        ),

        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_parentchild']['edit'],
                'href'                => 'table=tl_parentchild_elements',
                'icon'                => 'edit.gif',
                'attributes'          => 'class="contextmenu"'
            ),
            'editheader' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_parentchild']['editheader'],
                'href'                => 'act=edit',
                'icon'                => 'header.gif',
                'attributes'          => 'class="edit-header"'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_parentchild']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            )
        ),
     ),


	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_parentchild']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
	),

    'palettes' => array
     (
         'default' => '{type_legend},title;'
     )

);
