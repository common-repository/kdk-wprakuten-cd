<?php
/*
Plugin Name: Rakuten CD search
Plugin URI: http://www.kodokuman.com/
Description: Rakuten CD search plugin
Version: 0.1
Author: Johnathan David
Author URI: http://www.kodokuman.com/
License: GPLv2 or later
*/


function rakuten_media_cd_init () {
	load_plugin_textdomain( 'kdk-wprakuten-cd', false, "kdk-wprakuten-cd/languages/" );
	if (class_exists('RakutenMediaTab')) {
		require_once 'includes/RakutenCDTab.php';
		RakutenMediaTab::getInstance()->addTab(new RakutenCDTab());
	} else {
		//wp-admin/plugin-install.php?tab=search&type=term&s=kdk-wprakuten
		//http://dev.kodokuman.com/wp-admin/plugin-install.php?tab=plugin-information&plugin=kdk-wprakuten&TB_iframe=true&width=600&height=550
		$url = get_admin_url() . "plugin-install.php?tab=search&type=term&s=kdk-wprakuten";
		$param = array (
			'tab' => 'plugin-information',
			'plugin' => 'kdk-wprakuten'
		);
		$url = add_query_arg( $param, $url );
		$url = add_query_arg('TB_iframe', true, $url);
		$a_tag = "<a href=\'{$url}\' class=\'thickbox\'>Rakuten product</a>";
		$msg = __('O Rakuten cd depende do kdk-wprakuten','kdk-wprakuten-cd');
		$error = create_function('', "echo '<div id=\'message\' class=\'error\'><p>{$msg} {$a_tag}</p></div>';");
		add_action('admin_notices', $error);
	}
}


add_action('init', 'rakuten_media_cd_init');