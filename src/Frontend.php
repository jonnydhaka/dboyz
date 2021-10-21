<?php

namespace Dboyz\PS;

/**
 * The admin class
 */
class Frontend
{
    function __construct()
    {
        //new Front\Ulist\Ulist();
        add_shortcode('userlisting', array(new Front\Ulist\Ulist(), 'dboyzuser_listing'));
        add_shortcode('userlistingby', array(new Front\Ulistby\Ulistby(), 'dboyzuser_listing'));
        add_action('wp_enqueue_scripts', [$this, 'loadscript']);
        add_action('admin_enqueue_scripts', [$this, 'loadscript']);
        add_filter('query_vars', [$this, 'dboyzquery_vars']);
        add_action('init', [$this, 'wpd_foo_rewrite_rule']);
    }

    function wpd_foo_rewrite_rule()
    {
        //http://localhost/wp-themes/member/user/test2/
        add_rewrite_rule('^user/([^/]+)/?$', 'index.php?pagename=members&user=$matches[1]', 'top');

        add_rewrite_rule('^users/([^/]*)/([^/]*)/?', 'index.php?pagename=search&taxno=$matches[1]&termname=$matches[2]', 'top');
    }

    function dboyzquery_vars($qvars)
    {
        $qvars[] = 'user';
        $qvars[] = 'termname';
        $qvars[] = 'taxno';
        return $qvars;
    }




    public function loadscript()
    {

        wp_enqueue_style('elem-login-style', plugin_dir_url(__DIR__) . 'assets/css/dboyz-login-style.css', '', time());

        if (is_user_logged_in()) {
            $user = wp_get_current_user();

            //if ( in_array( 'dboyzuser', (array) $user->roles ) ) {
            wp_enqueue_media();
            $translation_array = array('accesstoken' =>  get_user_meta($user->ID, "ps_user_token", true));
            wp_enqueue_script('login-script', plugin_dir_url(__DIR__) . 'assets/js/script.js', array('jquery'), '', true);
            wp_localize_script('login-script', 'user_data', $translation_array);
            // }
        }
    }
}
