<?php
/* 
Template Name: Register 
*/

get_header();
global $wpdb, $user_ID;


$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'ps_user_login')) die('Failed security check');

    $creds = array(
        'user_login'    => $_REQUEST['psusername'],
        'user_password' =>  $_POST['pspassword'],
    );

    $autologin_user = wp_signon($creds, is_ssl());
    if (isset($autologin_user->data->ID)) {
        wp_redirect(get_page_link(get_option("success_page")));
    }
}

?>

<form id="wp_signup_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <?php wp_nonce_field('ps_user_login'); ?>

    <input id="username" style="opacity: 0;position: absolute;" type="text" name="username">
    <input id="password" style="opacity: 0;position: absolute;" class="cp-password_stub" type="password" name="password">
    <label for="username">Username</label>
    <input type="text" name="psusername" id="psusername" autocomplete="off">
    <label for="password">Password</label>
    <input type="password" name="pspassword" id="pspassword" autocomplete="off">

    <a href="<?php echo wp_lostpassword_url(); ?>">Forget Pass</a>
    <input type="submit" id="submitbtn" name="submit" value="Sign In" />

</form>
<?php
if (is_user_logged_in()) {
    echo "<a href='" . wp_logout_url() . "'>LOGOUT</a>";;
}

get_footer();
