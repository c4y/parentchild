<?php 


/**
 * Table tl_parentchild_elements
 */
$GLOBALS['TL_DCA']['tl_parentchild_elements'] = array
(

	// Config
	'config' => array
	(
        'dataContainer'               => 'Table',
        'ptable'                      => 'tl_parentchild',
        'switchToEdit'                => true,
        'enableVersioning'            => true,
        'onload_callback' => array
        (
            array('tl_parentchild_elements', 'checkPermission'),
        ),
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
            'mode'                    => 4,
            'fields'                  => array('title'),
            'flag'                    => 1,
            'headerFields'            => array('title'),
            'child_record_callback'   => array('tl_parentchild_elements', 'listElements'),
            'child_record_class'      => 'no_padding'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_parentchild_elements']['editmeta'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif',
                'attributes'          => 'class="contextmenu"'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_parentchild_elements']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            )
        )
    ),


    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'foreignKey'              => 'tl_parentchild.title',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_parentchild_elements']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
     ),

    'palettes' => array
    (
        'default'                     => '{type_legend},title',
    )
);



class tl_parentchild_elements extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    public function listElements($arrRow)
    {
        return $arrRow['title'];
    }

    /**
     * Check permissions to edit table tl_news
     */
    public function checkPermission()
    {

        if ($this->User->isAdmin)
        {
            return;
        }

        // Set the root IDs
        if (!is_array($this->User->parentchild) || empty($this->User->parentchild))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->parentchild;
        }

        $id = strlen(Input::get('id')) ? Input::get('id') : CURRENT_ID;

        // Check current action
        switch (Input::get('act'))
        {
            case 'paste':
                // Allow
                break;

            case 'create':
                if (!strlen(Input::get('pid')) || !in_array(Input::get('pid'), $root))
                {
                    $this->log('Not enough permissions to create parentchild elements in parentchild ID "'.Input::get('pid').'"', 'tl_parentchild_elements checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;

            case 'cut':
            case 'copy':
                if (!in_array(Input::get('pid'), $root))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' parentchild item ID "'.$id.'" to parentchild elements ID "'.Input::get('pid').'"', 'tl_parentchild_elements checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
            // NO BREAK STATEMENT HERE

            case 'edit':
            case 'show':
            case 'delete':
            case 'toggle':
            case 'feature':
                $objArchive = $this->Database->prepare("SELECT pid FROM tl_news WHERE id=?")
                    ->limit(1)
                    ->execute($id);

                if ($objArchive->numRows < 1)
                {
                    $this->log('Invalid parentchild ID "'.$id.'"', 'tl_parentchild_elements checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }

                if (!in_array($objArchive->pid, $root))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' parentchild elements ID "'.$id.'" of parentchild ID "'.$objArchive->pid.'"', 'tl_parentchild_elements checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;

            case 'select':
            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'cutAll':
            case 'copyAll':
                if (!in_array($id, $root))
                {
                    $this->log('Not enough permissions to access parentchild ID "'.$id.'"', 'tl_parentchild checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }

                $objArchive = $this->Database->prepare("SELECT id FROM tl_news WHERE pid=?")
                    ->execute($id);

                if ($objArchive->numRows < 1)
                {
                    $this->log('Invalid parentchild ID "'.$id.'"', 'tl_parentchild_elements checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }

                $session = $this->Session->getData();
                $session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objArchive->fetchEach('id'));
                $this->Session->setData($session);
                break;

            default:
                if (strlen(Input::get('act')))
                {
                    $this->log('Invalid command "'.Input::get('act').'"', 'tl_parentchild_elements checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                elseif (!in_array($id, $root))
                {
                    $this->log('Not enough permissions to access parentchild ID ' . $id, 'tl_parentchild_elements checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;
        }
    }
}