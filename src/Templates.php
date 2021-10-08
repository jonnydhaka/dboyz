<?php

namespace Dboyz\PS;

/**
 * The admin class
 */
class Templates
{

    function __construct()
    {
        add_action('admin_init', [$this, 'psele_login_redirect']);
        add_filter('logout_redirect', [$this, 'js_logout_redirect']);
        add_filter('show_admin_bar', [$this, 'js_hide_admin_bar']);
        add_action('template_include', [$this, 'add_template_include'], 12);
        add_filter("theme_page_templates", [$this, 'add_page_templates'], 10, 4);
        add_action('show_user_profile', [$this, 'custom_user_profile_fields']);
        add_action('edit_user_profile', [$this, 'custom_user_profile_fields']);
        //add_filter('login_redirect', [$this, 'my_login_redirect'], 10, 3);
    }

    public function add_page_templates($page_templates, $wp_theme, $post)
    {


        $page_templates = [
            "dboyzpslogin" => _x('Dboyz PS Login', 'Page Template', 'dboyz-ps'),
            "dboyzpsregister" => _x('Dboyz PS Register', 'Page Template', 'dboyz-ps'),
            "dboyzpsafterlogin" => _x('Dboyz PS After Login', 'Page Template', 'dboyz-ps'),
            "dboyzpsfpass" => _x('Dboyz PS Forget Pass', 'Page Template', 'dboyz-ps'),
            "dboyzpseditprofile" => _x('Dboyz PS Edit Profile', 'Page Template', 'dboyz-ps'),
        ] + $page_templates;

        return $page_templates;
    }

    function add_template_include($template)
    {

        global $post;
        if(!isset($post->ID)){
            return $template;
        }
        $template_path =  get_post_meta($post->ID, '_wp_page_template', true);
        $loginfile = plugin_dir_path(__DIR__) . 'templates/login.php';
        $registerfile = plugin_dir_path(__DIR__) . 'templates/register.php';
        $dboyzpsfpass = plugin_dir_path(__DIR__) . 'templates/forgetpass.php';
        $dboyzpseditprofile = plugin_dir_path(__DIR__) . 'templates/editprofile.php';


        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            if (in_array('dboyzuser', (array) $user->roles)) {
                $dboyzpsfpass = $registerfile = $loginfile = plugin_dir_path(__DIR__) . 'templates/afterlogin.php';
            }
        }
        $afterloginfile = plugin_dir_path(__DIR__) . 'templates/afterlogin.php';



        if ('dboyzpslogin' == $template_path) {
            if (file_exists($loginfile)) {
                $template = $loginfile;
            }
        }
        if ('dboyzpsregister' == $template_path) {
            if (file_exists($registerfile)) {
                $template = $registerfile;
            }
        }
        if ('dboyzpsafterlogin' == $template_path) {
            if (file_exists($afterloginfile)) {
                $template = $afterloginfile;
            }
        }
        if ('dboyzpsfpass' == $template_path) {
            if (file_exists($dboyzpsfpass)) {
                $template = $dboyzpsfpass;
            }
        }
        if ('dboyzpseditprofile' == $template_path) {
            if (file_exists($dboyzpseditprofile)) {
                $template = $dboyzpseditprofile;
            }
        }
        return $template;
    }
    function custom_user_profile_fields($user)
    {
?>
        <table class="form-table">
            <tr>
                <th>
                    <label for="code"><?php _e('User Token'); ?></label>
                </th>
                <td>
                    <input type="text" name="code" id="code" value="<?php echo esc_attr(get_user_meta($user->ID, 'ps_user_token', true)); ?>" class="regular-text" />
                </td>
            </tr>
        </table>
<?php
    }

    function psele_login_redirect()
    {
        $current_user   = wp_get_current_user();
        $role_name      = $current_user->roles[0];
        if ('dboyzuser' === $role_name) {
            add_filter('show_admin_bar', '__return_false');
            wp_redirect(get_page_link(get_option("success_page")));
        }
    }


    function js_hide_admin_bar($show)
    {
        if (!current_user_can('administrator')) {
            return false;
        }

        return $show;
    }

    function js_logout_redirect($url)
    {
        return get_page_link(get_option("login_page"));
    }

    function my_login_redirect($redirect_to, $request, $user)
    {
        $redirect_to =  home_url();

        return $redirect_to;
    }
}
