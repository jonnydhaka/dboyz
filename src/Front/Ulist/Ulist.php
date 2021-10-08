<?php

namespace Dboyz\PS\Front\Ulist;

/**
 * The admin class
 */
class Ulist
{
    function __construct()
    {
       
        add_action('wp_enqueue_scripts', [$this, 'loadscript']);
    }

    public function loadscript()
    {
        wp_enqueue_style('bootstrap', dboyz_PS_URL . '/assets/css/bootstrap.min.css', '', time());
        //wp_enqueue_style('bootstrap-icons', dboyz_PS_URL . '/assets/font/bootstrap-icons.css', '', time());
        // wp_enqueue_style('fontawesome', dboyz_PS_URL . '/assets/css/fontawesome.min.css', '', time());
        // wp_enqueue_style('fontawesome-solid', dboyz_PS_URL . '/assets/css/solid.min.css', '', time());
        // wp_enqueue_style('regular', dboyz_PS_URL . '/assets/css/regular.min.css', '', time());
        // wp_enqueue_style('regular', dboyz_PS_URL . '/assets/css/brands.min.css', '', time());
        wp_enqueue_script('login-script', 'https://kit.fontawesome.com/139bcc758b.js', array(), '', true);
    }


    function dboyzuser_listing($atts, $content = null)
    {
        global $post;

        extract(shortcode_atts(array(
            "role" => '',
            "number" => '10'
        ), $atts));

        $role = sanitize_text_field($role);
        $number = sanitize_text_field($number);

        // We're outputting a lot of HTML, and the easiest way
        // to do it is with output buffering from PHP.
        ob_start();

        $singleusermode = false;
        $singleuser = get_query_var('user', "");
        $user = get_user_by('login', $singleuser);
        if ($user) {
            dboyzget_template("user.php",array("user"=>$user));
        } else {
            $search = (isset($_GET["as"])) ? sanitize_text_field($_GET["as"]) : false;
            $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $offset = ($page - 1) * $number;
            if ($search) {
                $my_users = new \WP_User_Query(
                    array(
                        'role' => $role,
                        'search' => '*' . $search . '*'
                    )
                );
            } else {

                // $args = array(
                //   'role'    => 'dboyzuser',
                //   'orderby' => 'user_nicename',
                //   'order'   => 'ASC'
                // );
                // $my_users = get_users($args);
                // Generate the query
                $my_users = new \WP_User_Query(
                    array(
                        'role' => 'dboyzuser',
                        'offset' => $offset,
                        'number' => $number,
                        'orderby' => 'id',
                        'meta_query' => array(
                            array(
                                'key' => 'dboyzstatus',
                                'value' => "1",
                                'compare' => '='
                            ),
                        )
                    )
                );
            }
            dboyzget_template("users.php",array("my_users"=>$my_users));
            //include dboyz_PS_PATH . '/templates/users.php';
        }
        // Output the content.
        $output = ob_get_contents();
        ob_end_clean();

        // Return only if we're inside a page. This won't list anything on a post or archive page.

        if (is_page()) return  $output;
    }
}
