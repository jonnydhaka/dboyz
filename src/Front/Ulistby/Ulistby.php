<?php

namespace Dboyz\PS\Front\Ulistby;

/**
 * The admin class
 */
class Ulistby
{
    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'loadscript']);
    }

    public function loadscript()
    {
        wp_enqueue_style('bootstrap', dboyz_PS_URL . '/assets/css/bootstrap.min.css', '', time());
        wp_enqueue_script('login-script', 'https://kit.fontawesome.com/139bcc758b.js', array(), '', true);
    }

    function dboyzuser_listing($atts, $content = null)
    {
        global $post;
        extract(shortcode_atts(array(
            "termname" => '',
            "taxno" => ''
        ), $atts));
        if ($termname == "" &&  get_query_var('termname') !== '') {
            $termname = get_query_var('termname');
        }
        if ($taxno == "" &&  get_query_var('taxno') !== '') {
            $taxno = get_query_var('taxno');;
        }
        if ($termname == "" || $taxno == "") {
            return false;
        }
        $termname = str_replace("_", " ", $termname);
        $term = get_term_by('name', esc_attr($termname), $taxno);
        if (empty($term)) {
            return;
        }

        $user = get_objects_in_term($term->term_id, $taxno);
        $userlist = implode(', ', $user);
        $my_users = new \WP_User_Query(array(
            'include' => $userlist,
            'orderby' => 'id',
            'meta_query' => array(
                array(
                    'key' => 'dboyzstatus',
                    'value' => "1",
                    'compare' => '='
                ),
            )
        ));
        //ob_start();

        if ($my_users->total_users > 0) {
            ob_start();
            dboyzget_template("users.php", array("my_users" => $my_users));
            return ob_get_clean();
        } else { ?>
            <h2>No Member found</h2>
<?php }

        //endi


    }
}
