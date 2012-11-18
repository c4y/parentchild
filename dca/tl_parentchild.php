<?php 


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
        'enableVersioning'            => true,
        'onload_callback' => array
        (
            array('tl_parentchild', 'checkPermission'),
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


class tl_parentchild extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * Check permissions to edit table tl_parentchild
     */
    public function checkPermission()
    {

        if ($this->User->isAdmin)
        {
            return;
        }

        // Set root IDs
        if (!is_array($this->User->parentchild) || empty($this->User->parentchild))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->parentchild;
        }

        $GLOBALS['TL_DCA']['tl_parentchild']['list']['sorting']['root'] = $root;

        // Check permissions to add archives
        if (!$this->User->hasAccess('create', 'parentchildp'))
        {
            $GLOBALS['TL_DCA']['tl_parentchild']['config']['closed'] = true;
        }

        // Check current action
        switch (Input::get('act'))
        {
            case 'create':
            case 'select':
                // Allow
                break;

            case 'edit':
                // Dynamically add the record to the user profile
                if (!in_array(Input::get('id'), $root))
                {
                    $arrNew = $this->Session->get('new_records');

                    if (is_array($arrNew['tl_parentchild']) && in_array(Input::get('id'), $arrNew['tl_parentchild']))
                    {
                        // Add permissions on user level
                        if ($this->User->inherit == 'custom' || !$this->User->groups[0])
                        {
                            $objUser = $this->Database->prepare("SELECT parentchild, parentchildp FROM tl_user WHERE id=?")
                                ->limit(1)
                                ->execute($this->User->id);

                            $arrParentchildp = deserialize($objUser->parentchildp);

                            if (is_array($arrParentchildp) && in_array('create', $arrParentchildp))
                            {
                                $arrParentchild = deserialize($objUser->parentchild);
                                $arrParentchild[] = Input::get('id');

                                $this->Database->prepare("UPDATE tl_user SET parentchild=? WHERE id=?")
                                    ->execute(serialize($arrParentchild), $this->User->id);
                            }
                        }

                        // Add permissions on group level
                        elseif ($this->User->groups[0] > 0)
                        {
                            $objGroup = $this->Database->prepare("SELECT parentchild, parentchildp FROM tl_user_group WHERE id=?")
                                ->limit(1)
                                ->execute($this->User->groups[0]);

                            $arrParentchildp = deserialize($objGroup->parentchildp);

                            if (is_array($arrParentchildp) && in_array('create', $arrParentchildp))
                            {
                                $arrParentchild = deserialize($objGroup->parentchild);
                                $arrParentchild[] = Input::get('id');

                                $this->Database->prepare("UPDATE tl_user_group SET parentchild=? WHERE id=?")
                                    ->execute(serialize($arrParentchild), $this->User->groups[0]);
                            }
                        }

                        // Add new element to the user object
                        $root[] = Input::get('id');
                        $this->User->parentchild = $root;
                    }
                }
            // No break;

            case 'copy':
            case 'delete':
            case 'show':
                if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'parentchildp')))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' parentchild  ID "'.Input::get('id').'"', 'tl_parentchild checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
                $session = $this->Session->getData();
                if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'parentchildp'))
                {
                    $session['CURRENT']['IDS'] = array();
                }
                else
                {
                    $session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
                }
                $this->Session->setData($session);
                break;

            default:
                if (strlen(Input::get('act')))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' parentchild ', 'tl_parentchild checkPermission', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;
        }
    }

}