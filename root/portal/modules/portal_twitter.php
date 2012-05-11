<?php
/**
*
* @package Board3 Portal v2 - Twitter
* @copyright (c) Board3 Group ( www.board3.de )
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package Twitter
*/
class portal_twitter_module
{
	/**
	* Allowed columns: Just sum up your options (Exp: left + right = 10)
	* top		1
	* left		2
	* center	4
	* right		8
	* bottom	16
	*/
	public $columns = 10;

	/**
	* Default modulename
	*/
	public $name = 'PORTAL_TWITTER';

	/**
	* Default module-image:
	* file must be in "{T_THEME_PATH}/images/portal/"
	*/
	public $image_src = 'portal_twitter.png';

	/**
	* module-language file
	* file must be in "language/{$user->lang}/mods/portal/"
	*/
	public $language = 'portal_twitter_module';
	
	/**
	* custom acp template
	* file must be in "adm/style/portal/"
	*/
	public $custom_acp_tpl = '';
	
	/**
	* hide module name in ACP configuration page
	*/
	public $hide_name = false;

	public function get_template_side($module_id)
	{
		global $config, $template;

		$template->assign_vars(array(
			'TWITTER_USER'			=> $config['board3_twitter_user_' . $module_id],
		));
		
		// return false if user hasn't been entered yet
		return (!empty($config['board3_twitter_user_' . $module_id])) ? 'twitter_side.html' : false;
	}

	public function get_template_acp($module_id)
	{
		return array(
			'title'	=> 'ACP_PORTAL_TWITTER',
			'vars'	=> array(
				'legend1'								=> 'ACP_PORTAL_TWITTER',
				'board3_twitter_user_' . $module_id	=> array('lang' => 'ACP_PORTAL_TWITTER_USER',		'validate' => 'string',	'type' => 'text:10:200',	'explain' => true),
			),
		);
	}

	/**
	* API functions
	*/
	public function install($module_id)
	{
		set_config('board3_twitter_user_' . $module_id, '');

		return true;
	}

	public function uninstall($module_id)
	{
		global $db;

		$del_config = array(
			'board3_twitter_user_' . $module_id,
		);
		$sql = 'DELETE FROM ' . CONFIG_TABLE . '
			WHERE ' . $db->sql_in_set('config_name', $del_config);
		return $db->sql_query($sql);
	}
}
