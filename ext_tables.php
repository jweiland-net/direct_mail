<?php
/**
 *
 * @package TYPO3
 * @subpackage tx_directmail
 * @version $Id$
 */

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::addStaticFile($_EXTKEY,'static/boundaries/','Direct Mail Content Boundaries');
t3lib_extMgm::addStaticFile($_EXTKEY,'static/plaintext/', 'Direct Mail Plain text');

/**
 * Setting up the direct mail module
 */

 	// tt_content modified
t3lib_div::loadTCA('tt_content');
$tt_content_cols = Array(
	'module_sys_dmail_category' => Array(
		'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_category.category',
		'exclude' => '1',
		'config' => Array (
			'type' => 'select',
			'foreign_table' => 'sys_dmail_category',
			'foreign_table_where' => 'AND sys_dmail_category.pid IN (###PAGE_TSCONFIG_IDLIST###) ORDER BY sys_dmail_category.uid',
			'size' => 5,
			'minitems' => 0,
			'maxitems' => 30,
			'MM' => 'sys_dmail_ttcontent_category_mm',
			)
		),
);
t3lib_extMgm::addTCAcolumns('tt_content',$tt_content_cols);
t3lib_extMgm::addToAllTCATypes('tt_content','module_sys_dmail_category;;;;1-1-1');

	// tt_address modified
$tempCols = Array(
	'module_sys_dmail_category' => Array(
		'label' => 'LLL:EXT:direct_mail/locallang_tca.php:module_sys_dmail_group.category',
		'exclude' => '1',
		'config' => Array (
			'type' => 'select',
			'foreign_table' => 'sys_dmail_category',
			'foreign_table_where' => 'AND sys_dmail_category.pid IN (###PAGE_TSCONFIG_IDLIST###) ORDER BY sys_dmail_category.uid',
			'size' => 5,
			'minitems' => 0,
			'maxitems' => 30,
			'MM' => 'sys_dmail_ttaddress_category_mm',
			)
		),
	'module_sys_dmail_html' => Array(
		'label'=>'LLL:EXT:direct_mail/locallang_tca.php:module_sys_dmail_group.htmlemail',
		'exclude' => '1',
		'config'=>Array(
			'type'=>'check'
			)
		)
	);

t3lib_div::loadTCA('tt_address');
t3lib_extMgm::addTCAcolumns('tt_address',$tempCols);
t3lib_extMgm::addToAllTCATypes('tt_address','--div--;Direct mail,module_sys_dmail_category;;;;1-1-1,module_sys_dmail_html');
$TCA['tt_address']['feInterface']['fe_admin_fieldList'].=',module_sys_dmail_category,module_sys_dmail_html';

	// fe_users modified
$tempCols = Array(
	'module_sys_dmail_category' => Array(
		'label' => 'LLL:EXT:direct_mail/locallang_tca.php:module_sys_dmail_group.category',
		'exclude' => '1',
		'config' => Array (
			'type' => 'select',
			'foreign_table' => 'sys_dmail_category',
			'foreign_table_where' => 'AND sys_dmail_category.pid IN (###PAGE_TSCONFIG_IDLIST###) ORDER BY sys_dmail_category.uid',
			'size' => 5,
			'minitems' => 0,
			'maxitems' => 30,
			'MM' => 'sys_dmail_feuser_category_mm',
			)
		),
	'module_sys_dmail_html' => Array(
		'label'=>'LLL:EXT:direct_mail/locallang_tca.php:module_sys_dmail_group.htmlemail',
		'exclude' => '1',
		'config'=>Array(
			'type'=>'check'
			)
		)
	);

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempCols);
$TCA['fe_users']['feInterface']['fe_admin_fieldList'].=',module_sys_dmail_category,module_sys_dmail_html';
t3lib_extMgm::addToAllTCATypes('fe_users','--div--;Direct mail,module_sys_dmail_category;;;;1-1-1,module_sys_dmail_html');

// ******************************************************************
// Categories
// ******************************************************************
$TCA["sys_dmail_category"] = Array (
	"ctrl" => Array (
		"title" => "LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_category",
		"label" => "category",
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"sortby" => "sorting",
		"delete" => "deleted",
		"enablecolumns" => Array (
			"disabled" => "hidden",
			),
		"dynamicConfigFile" => t3lib_extMgm::extPath('direct_mail')."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath('direct_mail')."icon_tx_directmail_category.gif",
		),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, category",
		)
	);


// ******************************************************************
// sys_dmail
// ******************************************************************
$TCA['sys_dmail'] = Array (
	'ctrl' => Array (
		'label' => 'subject',
		'default_sortby' => 'ORDER BY tstamp DESC',
		'tstamp' => 'tstamp',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
		'title' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail',
		'delete' => 'deleted',
		'iconfile' => 'mail.gif',
		'type' => 'type',
		'useColumnsForDefaultValues' => 'from_email,from_name,replyto_email,replyto_name,organisation,priority,encoding,charset,sendOptions,type'
	),
	'interface' => Array (
		'showRecordFieldList' => 'type,plainParams,HTMLParams,subject,from_name,from_email,replyto_name,replyto_email,organisation,attachment,priority,encoding,charset,sendOptions,issent,renderedsize,use_domain,use_rdct,long_link_mode,authcode_fieldList'
	),
	'columns' => Array (
		'subject' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.subject',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'max' => '120',
				'eval' => 'trim,required'
			)
		),
		'page' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.page',
			'exclude' => '1',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => '1',
				'maxitems' => 1,
				'minitems' => 0
			)
		),
		'from_email' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.from_email',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'max' => '80',
				'eval' => 'trim,required'
			)
		),
		'from_name' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.from_name',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'trim',
				'max' => '80'
			)
		),
		'replyto_email' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.replyto_email',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'trim',
				'max' => '80'
			)
		),
		'replyto_name' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.replyto_name',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'trim',
				'max' => '80'
			)
		),
		'return_path' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.return_path',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'trim',
				'max' => '80'
			)
		),
		'organisation' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.organisation',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'trim',
				'max' => '80'
			)
		),
		'encoding' => Array (
			'label' =>  'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.transfer_encoding',
			'exclude' => '1',
			'config' => Array(
				'type' => 'select',
				'items' => Array(
					Array('quoted-printable','quoted-printable'),
					Array('base64','base64'),
					Array('8bit','8bit'),
					),
				'default' => 'quoted-printable'
			)
		),
		'charset' => Array (
			'label' =>  'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.charset',
			'exclude' => '1',
			'config' => Array(
				'type' => 'input',
				'size' => '15',
				'max' => '20',
				'eval' => 'trim',
				'default' => 'iso-8859-1'
			)
		),
		'priority' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.priority',
			'exclude' => '1',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.priority.I.0', '5'),
					Array('LLL:EXT:lang/locallang_general.php:LGL.normal', '3'),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.priority.I.2', '1')
				),
				'default' => '3'
			)
		),
		'sendOptions' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.sendOptions',
			'exclude' => '1',
			'config' => Array (
				'type' => 'check',
				'items' => Array (
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.sendOptions.I.0', ''),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.sendOptions.I.1', '')
				),
				'cols' => '2',
				'default' => '3'
			)
		),
		'HTMLParams' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.HTMLParams',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '15',
				'max' => '80',
				'eval' => 'trim',
				'default' => ''
			)
		),
		'plainParams' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.plainParams',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '15',
				'max' => '80',
				'eval' => 'trim',
				'default' => '&type=99'
			)
		),
		'issent' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.issent',
			'exclude' => '1',
			'config' => Array (
				'type' => 'none'
			)
		),
		'use_domain' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.use_domain',
			'exclude' => '1',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'sys_domain',
				'size' => '1',
				'maxitems' => 1,
				'minitems' => 0
			)
		),		
		'use_rdct' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.use_rdct',
			'exclude' => '1',
			'config' => Array (
				'type' => 'check',
				'default' => '0'
			)
		),
		'long_link_rdct_url' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.long_link_rdct_url',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '15',
				'max' => '80',
				'eval' => 'trim',
				'default' => ''
			)
		),
		'long_link_mode' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.long_link_mode',
			'exclude' => '1',
			'config' => Array (
				'type' => 'check'
			)
		),
		'authcode_fieldList' => Array(
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.authcode_fieldList',
			'exclude' => '1',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'eval' => 'trim',
				'max' => '80',
				'default' => 'uid,name,email,password'
			)
		),
		'renderedsize' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.renderedsize',
			'exclude' => '1',
			'config' => Array (
				'type' => 'none'
			)
		),
		'attachment' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.attachment',
			'exclude' => '1',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',	// Must be empty for disallowed to work.
				'disallowed' => 'php,php3',
				'max_size' => '500',
				'uploadfolder' => 'uploads/dmail_att',
				'show_thumbs' => '0',
				'size' => '3',
				'maxitems' => '5',
				'minitems' => '0'
			)
		),
		'type' => Array (
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.type',
			'exclude' => '1',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.type.I.0', '0'),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.type.I.1', '1')
				),
				'default' => '0'
			)
		)
	),
	'types' => Array (
		'0' => Array('showitem' => 'type;;;;1-1-1, page, plainParams, HTMLParams, --div--, subject;;;;3-3-3, from_email, from_name, replyto_email, replyto_name, return_path, organisation, attachment;;;;4-4-4, priority;;;;5-5-5,encoding, charset, sendOptions, use_domain, use_rdct, long_link_mode, authcode_fieldList'),
		'1' => Array('showitem' => 'type;;;;1-1-1,
			plainParams;LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.plainParams.ALT.1,
			HTMLParams;LLL:EXT:direct_mail/locallang_tca.php:sys_dmail.HTMLParams.ALT.1,
			--div--, subject;;;;3-3-3, from_email, from_name, replyto_email, replyto_name, return_path, organisation, attachment;;;;4-4-4, priority;;;;5-5-5, encoding, charset, sendOptions, use_domain, use_rdct, long_link_mode, authcode_fieldList')
	)
);

// ******************************************************************
// sys_dmail_group
// ******************************************************************
$TCA['sys_dmail_group'] = Array (
	'ctrl' => Array (
		'label' => 'title',
		'default_sortby' => 'ORDER BY title',
		'tstamp' => 'tstamp',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
		'title' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group',
		'delete' => 'deleted',
		'iconfile' => 'mailgroup.gif',
		'type' => 'type'
	),
	'interface' => Array (
		'showRecordFieldList' => 'type,title,description'
	),
	'columns' => Array (
		'title' => Array (
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.title',
			'config' => Array (
				'type' => 'input',
				'size' => '30',
				'max' => '120',
				'eval' => 'trim,required'
			)
		),
		'description' => Array (
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.description',
			'config' => Array (
				'type' => 'text',
				'cols' => '40',
				'rows' => '3'
			)
		),
		'type' => Array (
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.type',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.type.I.0', '0'),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.type.I.1', '1'),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.type.I.2', '2'),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.type.I.3', '3'),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.type.I.4', '4')
				),
				'default' => '0'
			)
		),
		'static_list' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.static_list',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tt_address,fe_users,fe_groups',
				'MM' => 'sys_dmail_group_mm',
				'size' => '20',
				'maxitems' => '100000',
				'minitems' => '0',
				'show_thumbs' => '1'
			)
		),
		'pages' => Array (
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.startingpoint',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
					'allowed' => 'pages',
				'size' => '3',
				'maxitems' => '22',
				'minitems' => '0',
				'show_thumbs' => '1'
			)
		),
		'mail_groups' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.mail_groups',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
					'allowed' => 'sys_dmail_group',
				'size' => '3',
				'maxitems' => '22',
				'minitems' => '0',
				'show_thumbs' => '1'
			)
		),
		'recursive' => Array (
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.recursive',
			'config' => Array (
				'type' => 'check'
			)
		),
		'whichtables' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.whichtables',
			'config' => Array (
				'type' => 'check',
				'items' => Array (
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.whichtables.I.0', ''),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.whichtables.I.1', ''),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.whichtables.I.2', ''),
				),
				'cols' => 3,
				'default' => 1
			)
		),
		'list' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.list',
			'config' => Array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '10'
			)
		),
		'csv' => Array (
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.type',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.csv.I.0', '0'),
					Array('LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.csv.I.1', '1')
				),
				'default' => '0'
			)
		),
		'select_categories' => Array (
			'label' => 'LLL:EXT:direct_mail/locallang_tca.php:sys_dmail_group.select_categories',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_dmail_category',
				'foreign_table_where' => 'AND sys_dmail_category.pid=###CURRENT_PID### ORDER BY sys_dmail_category.uid',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 30,
				'MM' => 'sys_dmail_group_category_mm',
            )
			)

	),
	'types' => Array (
		'0' => Array('showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description, --div--,pages;;;;5-5-5,recursive,whichtables,select_categories'),
		'1' => Array('showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description, --div--,list;;;;5-5-5,csv'),
		'2' => Array('showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description, --div--,static_list;;;;5-5-5'),
		'3' => Array('showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description'),
		'4' => Array('showitem' => 'type;;;;1-1-1, title;;;;3-3-3, description, --div--,mail_groups;;;;5-5-5')
	)
);


t3lib_extMgm::addLLrefForTCAdescr('sys_dmail','EXT:direct_mail/locallang_csh_sysdmail.php');
t3lib_extMgm::addLLrefForTCAdescr('sys_dmail_group','EXT:direct_mail/locallang_csh_sysdmailg.php');

if (TYPO3_MODE=="BE")   {
  t3lib_extMgm::addModule("web","txdirectmailM1","",t3lib_extMgm::extPath('direct_mail')."mod/");
}

?>