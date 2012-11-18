<?php 


$GLOBALS['TL_PERMISSIONS'][] = 'parentchild';
$GLOBALS['TL_PERMISSIONS'][] = 'parentchildp';

/**
 * BACK END MODULES
 *
 * Back end modules are stored in a global array called "BE_MOD". You can add
 * your own modules by adding them to the array.*/

  array_insert($GLOBALS['BE_MOD']['content'],10, array
      (
         'parentchild' => array
            (
               'tables'       => array('tl_parentchild', 'tl_parentchild_elements'),
               'icon'         => 'system/modules/parentchild/assets/icon.png'
            )
      )
  );


array_insert($GLOBALS['TL_CTE']['media'],5, array(
    'ceMeinElement' => 'ContentMeinElement'
));


