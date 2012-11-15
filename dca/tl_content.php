<?php


$GLOBALS['TL_DCA']['tl_content']['palettes']['galleryxt'] = '{title_legend},name,type,headline;{config_legend},galleryxt;{expert_legend:hide},cssID,space';

$GLOBALS['TL_DCA']['tl_content']['fields']['galleryxt'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['galleryxt'],
    'exclude'                 => true,
    'inputType'               => 'radio',
    'foreignKey'              => 'tl_galleryxt.title',
    'eval'                    => array('mandatory'=>true),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);