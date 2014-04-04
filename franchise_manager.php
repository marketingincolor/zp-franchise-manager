<?php
/*
Plugin Name: Franchise Manager
Plugin URI: http://www.marketingincolor.com/web-development/wordpress
Description: A Wordpress plugin for Franchise Management
Version: 0.1
Author: Marketing In Color
Author URI: http://www.marketingincolor.com
License: GPL2
*/
/*
Copyright 2014 Marketing In Color  (email : developer@marketingincolor.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('Franchise_Manager'))
{
	class Franchise_Manager
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// Initialize Settings
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$Franchise_Manager_Settings = new Franchise_Manager_Settings();

			// Register custom post types
			require_once(sprintf("%s/post-types/post_type_template.php", dirname(__FILE__)));
			$Post_Type_Template = new Post_Type_Template();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
		} // END public function __construct

		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			/* Create New Role for Franchisees (currently same as "Author") */
			$new_role = array(
			    'delete_posts' => true,
				'delete_published_posts' => true,
				'edit_posts' => true,
				'edit_published_posts' => true,
				'publish_posts' => true,
				'read' => true,
				'upload_files ' => true
			);
			add_role('franchisee', 'Franchisee', $new_role);

		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			/* Remov Role for Franchisees */
			remove_role('franchisee');
			
		} // END public static function deactivate

		// Add the settings link to the plugins page
		function plugin_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=franchise_manager">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}
		
	} // END class Franchise_Manager
} // END if(!class_exists('Franchise_Manager'))

if(class_exists('Franchise_Manager'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Franchise_Manager', 'activate'));
	register_deactivation_hook(__FILE__, array('Franchise_Manager', 'deactivate'));

	// instantiate the plugin class
	$franchise_manager = new Franchise_Manager();

}
