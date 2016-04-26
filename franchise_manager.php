<?php
/*
Plugin Name: ZeePress Franchise Manager
Plugin URI: http://zeepress.com/wordpress-plugins
Description: A Wordpress plugin for Franchise Management
Version: 0.1
Author: Marketing In Color
Author URI: http://www.marketingincolor.com
License: GPL2

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
			require_once(sprintf("%s/post-types/location.php", dirname(__FILE__)));
			$Post_Type_Template = new Post_Type_Template();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
		} // END public function __construct

		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			/* Create New Role for Franchisees (slightly similar to Author) */
			$new_role = array(
			    'delete_posts' => false,
				'delete_published_posts' => false,
				'edit_posts' => true,
				'edit_published_posts' => false,
				'publish_posts' => false,
				'read' => true,
				'upload_files ' => true,
                'edit_franchises' => true,
                'manage_franchises' => false,
                'create_franchises' => true,
                'delete_franchises' => true,
                'edit_locations' => true,
                'manage_locations' => false,
                'create_locations' => true,
                'delete_locations' => true
			);
			add_role('franchisee', 'Franchisee', $new_role);

            $roles_object = new WP_Roles();
            $roles_object->add_cap('administrator', 'edit_franchises');
            $roles_object->add_cap('administrator', 'create_franchises');
            $roles_object->add_cap('administrator', 'manage_franchises');
            $roles_object->add_cap('administrator', 'delete_franchises');
            $roles_object->add_cap('administrator', 'read_franchises');
            $roles_object->add_cap('administrator', 'edit_locations');
            $roles_object->add_cap('administrator', 'create_locations');
            $roles_object->add_cap('administrator', 'manage_locations');
            $roles_object->add_cap('administrator', 'delete_locations');
            $roles_object->add_cap('administrator', 'read_locations');

		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			/* Remove Role for Franchisees */
			remove_role('franchisee');

            $roles_object = new WP_Roles();
            $roles_object->remove_cap('administrator', 'edit_franchises');
            $roles_object->remove_cap('administrator', 'create_franchises');
            $roles_object->remove_cap('administrator', 'manage_franchises');
            $roles_object->remove_cap('administrator', 'delete_franchises');
            $roles_object->remove_cap('administrator', 'read_franchises');
            $roles_object->remove_cap('administrator', 'edit_locations');
            $roles_object->remove_cap('administrator', 'create_locations');
            $roles_object->remove_cap('administrator', 'manage_locations');
            $roles_object->remove_cap('administrator', 'delete_locations');
            $roles_object->remove_cap('administrator', 'read_locations');
			
		} // END public static function deactivate

		// Add the settings link to the plugins page
		function plugin_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=franchise-manager">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}
		
	} // END class Franchise_Manager
} // END if(!class_exists('Franchise_Manager'))

if(class_exists('Franchise_Manager'))
{
	// Install and uninstall hooks
	register_activation_hook(__FILE__, array('Franchise_Manager', 'activate'));
	register_deactivation_hook(__FILE__, array('Franchise_Manager', 'deactivate'));

	// instantiate the plugin class
	$franchise_manager = new Franchise_Manager();

}

/**
 * Remove the slug from published post permalinks for Post Type
 */
function fm_remove_cpt_slug( $post_link, $post ) {
    if ( ! in_array( $post->post_type, array( 'location' ) ) || 'publish' != $post->post_status )
        return $post_link;

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    return $post_link;
}
add_filter( 'post_type_link', 'fm_remove_cpt_slug', 10, 2 );
/**
 * Bypass request for custom Post Type
 */
function fm_parse_request_bypass( $query ) {
    if ( ! $query->is_main_query() )
        return;

    if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) )
        return;

    if ( ! empty( $query->query['name'] ) )
        $query->set( 'post_type', array( 'post', 'location', 'page' ) );
}
add_action( 'pre_get_posts', 'fm_parse_request_bypass' );


add_filter( 'map_meta_cap', 'fm_custom_map_meta_cap', 10, 4 );
function fm_custom_map_meta_cap( $caps, $cap, $user_id, $args ) {
    /* If editing, deleting, or reading a location, get the post and post type object. */
    if ( 'edit_location' == $cap || 'delete_location' == $cap || 'read_location' == $cap ) {
        $post = get_post( $args[0] );
        $post_type = get_post_type_object( $post->post_type );
        /* Set an empty array for the caps. */
        $caps = array();
    }
    /* If editing a franchise, assign the required capability. */
    if ( 'edit_location' == $cap ) {
        if ( $user_id == $post->post_author )
            $caps[] = $post_type->cap->edit_posts;
        else
            $caps[] = $post_type->cap->edit_others_posts;
    }
    /* If deleting a franchise, assign the required capability. */
    elseif ( 'delete_location' == $cap ) {
        if ( $user_id == $post->post_author )
            $caps[] = $post_type->cap->delete_posts;
        else
            $caps[] = $post_type->cap->delete_others_posts;
    }
    /* If reading a private franchise, assign the required capability. */
    elseif ( 'read_location' == $cap ) {

        if ( 'private' != $post->post_status )
            $caps[] = 'read';
        elseif ( $user_id == $post->post_author )
            $caps[] = 'read';
        else
            $caps[] = $post_type->cap->read_private_posts;
    }
    /* Return the capabilities required by the user. */
    return $caps;
}

//Add Plugin Specific Meta Fields to User Profile Page
add_action('show_user_profile', 'fm_user_profile_edit_action');
add_action('edit_user_profile', 'fm_user_profile_edit_action');

function fm_user_profile_edit_action($user) {
    require_once(sprintf("%s/includes/franchise_user_meta.php", dirname(__FILE__)));
}
//Allow Update of  Meta Fields on User Profile Page
add_action( 'personal_options_update', 'fm_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'fm_save_extra_profile_fields' );

function fm_save_extra_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'address1', $_POST['address1'] );
    update_user_meta( $user_id, 'address2', $_POST['address2'] );
    update_user_meta( $user_id, 'city', $_POST['city'] );
    update_user_meta( $user_id, 'state', $_POST['state'] );
    update_user_meta( $user_id, 'zip', $_POST['zip'] );
}

//Remove Dashboard Profile Options
function admin_del_options() {
    global $_wp_admin_css_colors;
    $_wp_admin_css_colors = 0;
}
add_action('admin_head', 'admin_del_options');

// Remove Unused Contact Methods
function drop_unused_contactmethod( $contactmethods ) {
    unset($contactmethods['aim']);
    unset($contactmethods['jabber']);
    unset($contactmethods['yim']);
    return $contactmethods;
}
add_filter('user_contactmethods','drop_unused_contactmethod',10,1);
