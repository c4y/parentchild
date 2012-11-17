<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');


/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_user_group']['palettes']['default'] = str_replace('fop;', 'fop;{parentchild_legend},parentchild, parentchildp;', $GLOBALS['TL_DCA']['tl_user_group']['palettes']['default']);

/**
 * Add fields to tl_user_group
 */

$GLOBALS['TL_DCA']['tl_user_group']['fields']['parentchildp'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_user']['parentchildp'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'options'                 => array('create', 'delete'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('multiple'=>true)  ,
    'sql'                     => 'blob NULL'
);

/**
 * Add fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user_group']['fields']['parentchild'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_user_group']['parentchild'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'foreignKey'              => 'tl_parentchild.title',
    'eval'                    => array('multiple'=>true)   ,
    'sql'                     => 'blob NULL'
);