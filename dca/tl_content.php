<?php


$GLOBALS['TL_DCA']['tl_content']['palettes']['parentchild'] = '{title_legend},name,type,headline;{config_legend},parentchild;{expert_legend:hide},cssID,space';

$GLOBALS['TL_DCA']['tl_content']['fields']['parentchild'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['parentchild'],
    'exclude'                 => true,
    'inputType'               => 'radio',
    'foreignKey'              => 'tl_parentchild.title',
    'eval'                    => array('mandatory'=>true),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);