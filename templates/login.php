<?php
/* 
Template Name: Login 
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

    $autologin_user = wp_signon($creds, true);
    if (isset($autologin_user->data->ID)) {
        wp_redirect(get_page_link(get_option("success_page")));
    }
}


?>
<!-- Prestashop Dboyz login -->
<div class="ps-dboyz-page-wrapper">
    <!-- Start Dboyz Ps Login -->
    <section class="dboyz-ps-my-account">
        <div class="container-auto">
            <div class="ps-my-account-content">
                <div class="ps-my-account-box">
                    <div class="ps-my-account-form">
                        <h2>Log In</h2>
                        <p>New to Dboyz? <a class="create-account-btn" href="<?php echo esc_url(get_page_link(get_option("register_page")));  ?>">Create an Account</a></p>

                        <!-- Success Message -->
                        <div class="login-message success-message">
                            <p>Success Message</p>
                        </div>
                        <!-- Error Message -->
                        <div class="login-message error-message">
                            <p>Error Massage</p>
                        </div>

                        <form id="wp_signup_form" class="ps-dboyz-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                            <?php wp_nonce_field('ps_user_login'); ?>
                            <input id="username" type="hidden" name="username">
                            <input id="password" class="cp-password_stub" type="hidden" name="password">
                            <div class="dboyz-ps-form-fields-wrapper">
                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="psusername">Username</label>
                                    <input class="dboyz-ps-input-field" type="text" name="psusername" placeholder="Username" id="psusername" autocomplete="off">
                                </div>
                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="pspassword">Password</label>
                                    <input class="dboyz-ps-input-field" type="password" name="pspassword" placeholder="Password" id="pspassword" autocomplete="off">
                                </div>
                                <div class="dboyz-ps-field-group">
                                    <input type="submit" id="submitbtn" name="submit" value="Log In" />
                                </div>
                            </div>
                        </form>
                        <p class="ps-dboyz-note-redirect">
                            <a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Dboyz Ps Login -->

</div>

<?php
if (is_user_logged_in()) {
}
get_footer();
