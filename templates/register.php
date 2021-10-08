<?php
/* 
Template Name: Register 
*/

get_header();
global $wpdb, $user_ID;


$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $retrieved_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($retrieved_nonce, 'ps_create_user')) die('Failed security check');


    // Check username is present and not already in use  
    $username = esc_sql($_REQUEST['psusername']);
    if (strpos($username, ' ') !== false) {
        $errors['psusername'] = "Sorry, no spaces allowed in usernames";
    }
    if (empty($username)) {
        $errors['psusername'] = "Please enter a username";
    } elseif (username_exists($username)) {
        $errors['psusername'] = "Username already exists, please try another";
    }

    // Check email address is present and valid  
    $email = esc_sql($_REQUEST['email']);
    if (!is_email($email)) {
        $errors['email'] = "Please enter a valid email";
    } elseif (email_exists($email)) {
        $errors['email'] = "This email address is already in use";
    }

    // Check password is valid  
    if (0 === preg_match("/.{3,}/", $_POST['pspassword'])) {
        $errors['pspassword'] = "Password must be at least six characters";
    }

    // Check password confirmation_matches  
    if (0 !== strcmp($_POST['pspassword'], $_POST['password_confirmation'])) {
        $errors['password_confirmation'] = "Passwords do not match";
    }







    if (0 === count($errors)) {

        $password = $_POST['pspassword'];

        $new_user_id = wp_create_user($username, $password, $email);

        $user = get_user_by('id', $new_user_id);

        //wp_update_user( array ('ID' => $id, 'role' => 'dboyzuser') ) ;
        // Remove role
        $user->remove_role('subscriber');

        // Add role
        $user->add_role('dboyzuser');

        if (isset($_FILES['dboyz_image_upload']) && $_FILES['dboyz_image_upload']['size']) {
            $attach_id = imageupload($_FILES['dboyz_image_upload']);
        }

        update_user_meta($new_user_id, 'user_instagram', $_POST['facebook']);
        update_user_meta($new_user_id, 'user_instagram', $_POST['twitter']);
        update_user_meta($new_user_id, 'user_instagram', $_POST['instagram']);
        update_user_meta($new_user_id, 'dboyzprofile_image',  $attach_id);

        $termd = $_POST['designation'];
        $termsd = is_array($termd) ? $termd : (int) $termd;
        wp_set_object_terms($new_user_id, $termsd, 'designation', false);
        clean_object_term_cache($new_user_id, 'designation');

        $termd = $_POST['section'];
        $termsd = is_array($termd) ? $termd : (int) $termd;
        wp_set_object_terms($new_user_id, $termsd, 'section', false);
        clean_object_term_cache($new_user_id, 'section');

        // You could do all manner of other things here like send an email to the user, etc. I leave that to you.  

        $success = 1;
        // $meta_value=md5("PS-LAX".$new_user_id);
        // add_user_meta( $new_user_id,"ps_user_token", $meta_value  );

        //header( 'Location:' . get_bloginfo('url') . '/login/?success=1&u=' . $username );  

    }
    if (!empty($errors)) {
        print_r($errors);
    } else {
        echo "Successfully Insert Member";
    }
}

$designation = get_taxonomy('designation');
$termsdes = get_terms('designation', array('hide_empty' => false));

$section = get_taxonomy('section');
$termssec = get_terms('section', array('hide_empty' => false));


?>

<!-- Prestashop Dboyz Register -->
<div class="ps-dboyz-page-wrapper">
    <!-- Start Dboyz Ps Login -->
    <section class="dboyz-ps-my-account">
        <div class="container-auto">
            <div class="ps-my-account-content">
                <div class="ps-my-account-box">
                    <div class="ps-my-account-form">
                        <h2>Sign Up</h2>
                        <p>Already have an account? <a class="create-account-btn" href="<?php echo esc_url(get_page_link(get_option("login_page"))); ?>">Login</a></p>
                        <form id="wp_signup_form" class="ps-dboyz-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
                            <?php wp_nonce_field('ps_create_user'); ?>
                            <input id="username" type="hidden" name="username">
                            <input id="password" class="cp-password_stub" type="hidden" name="password">
                            <div class="dboyz-ps-form-fields-wrapper">
                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="username">Username</label>
                                    <input class="dboyz-ps-input-field" type="text" name="psusername" placeholder="Username" id="username" autocomplete="off">
                                </div>
                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="email">Email Address</label>
                                    <input class="dboyz-ps-input-field" type="email" name="email" placeholder="Email Address" id="email">
                                </div>
                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="password">Password</label>
                                    <input class="dboyz-ps-input-field" type="password" name="pspassword" placeholder="Password" id="pspassword" autocomplete="off">
                                </div>
                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="password_confirmation">Confirm Password</label>
                                    <input class="dboyz-ps-input-field" type="password" name="password_confirmation" placeholder="Confirm Password" id="password_confirmation">
                                </div>

                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="username">Facebook</label>
                                    <input class="dboyz-ps-input-field" type="text" name="facebook" placeholder="Facebook Url" id="facebook" autocomplete="off">
                                </div>

                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="username">Twitter</label>
                                    <input class="dboyz-ps-input-field" type="text" name="twitter" placeholder="Twitter Url" id="twitter" autocomplete="off">
                                </div>

                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="username">Instagram</label>
                                    <input class="dboyz-ps-input-field" type="text" name="instagram" placeholder="Instagram Url" id="instagram" autocomplete="off">
                                </div>
                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="dboyz_image_upload">Image</label>
                                    <input type="file" name="dboyz_image_upload" id="dboyz_image_upload" multiple="false" />
                                </div>

                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="dboyz_image_upload">Designation</label>
                                    <?php
                                    echo "<select name='designation'>";
                                    echo "<option value=''>-Select-</option>";
                                    foreach ($termsdes as $options_value) {
                                        echo "<option value='{$options_value->term_id}' >{$options_value->name}</option>";
                                    }
                                    echo "</select>";
                                    ?>
                                </div>


                                <div class="dboyz-ps-field-group">
                                    <label class="dboyz-ps-field-label" for="dboyz_image_upload">Section</label>
                                    <?php
                                    echo "<select name='designation'>";
                                    echo "<option value=''>-Select-</option>";
                                    foreach ($termssec as $options_value) {
                                        echo "<option value='{$options_value->term_id}' >{$options_value->name}</option>";
                                    }
                                    echo "</select>";
                                    ?>
                                </div>

                                <div class="dboyz-ps-field-group">
                                    <input type="submit" id="submitbtn" name="submit" value="Create Account" />
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Dboyz Ps Login -->
</div>


<?php get_footer();
