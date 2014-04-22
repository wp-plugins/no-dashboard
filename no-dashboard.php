<?php
    /*
    Plugin Name: No Dashboard
    Plugin URI: http://www.stevenfernandez.co.uk/wordpress-plugins/
    Description: No Dashboard is a simple plugin which removes the wordpress dashboard. No settings page, just activate the plugin and the dashboard with disappear.
    Author: Steven Fernandez
    Version: 1.1.1
    Author URI: http://www.stevenfernandez.co.uk

    === RELEASE NOTES ===
    20-04-2014 - v1.0 - first version
    21-04-2014 - v1.1 - fixed small bug
    21-04-2014 - v1.1.1 - minor info changes
    21-04-2014 - v1.1.2 - Tested on WP version 3.9
    */

global $wp_version;
$exit_msg = 'No Dashboard reqiures WordPress 3.0 or newer';
if (version_compare($wp_version, '3.0', '<')){
    exit ($exit_msg);
}


function no_dashboard () {
    global $current_user, $menu, $submenu;
    get_currentuserinfo();

   // if( ! in_array( 'administrator', $current_user->roles ) ) {
        reset( $menu );
        $page = key( $menu );
        while( ( __( 'Dashboard' ) != $menu[$page][0] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if( __( 'Dashboard' ) == $menu[$page][0] ) {
            unset( $menu[$page] );
        }
        reset($menu);
        $page = key($menu);
        while ( ! $current_user->has_cap( $menu[$page][1] ) && next( $menu ) ) {
            $page = key( $menu );
        }
        if ( preg_match( '#wp-admin/?(index.php)?$#', $_SERVER['REQUEST_URI'] ) &&
            ( 'index.php' != $menu[$page][2] ) ) {
                wp_redirect( get_option( 'siteurl' ) . '/wp-admin/edit.php');
        }
    //}
}
add_action('admin_menu', 'no_dashboard');



?>
