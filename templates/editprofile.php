<?php
/* 
Template Name: Edit Profile 
*/

get_header();

/* Get user info. */
global $current_user, $wp_roles;

//wp_get_current_user();
// if (is_user_logged_in()) {
//     echo 'Username: ' . $current_user->user_login . "\n";
//     echo 'User display name: ' . $current_user->display_name . "\n";
// }



$error = array();
/* If profile was saved, update profile. */
if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'update-user') {

    /* Update user password. */
    if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) {
        if ($_POST['pass1'] == $_POST['pass2'])
            wp_update_user(array('ID' => $current_user->ID, 'user_pass' => esc_attr($_POST['pass1'])));
        else
            $error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
    }

    /* Update user information. */

    if (!empty($_POST['email'])) {
        if (!is_email(esc_attr($_POST['email'])))
            $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
        elseif (email_exists(esc_attr($_POST['email'])) != $current_user->id)
            $error[] = __('This email is already used by another user.  try a different one.', 'profile');
        else {
            wp_update_user(array('ID' => $current_user->ID, 'user_email' => esc_attr($_POST['email'])));
        }
    }

    if (!empty($_POST['first-name']))
        update_user_meta($current_user->ID, 'user_facebook', esc_attr($_POST['user_facebook']));
    if (!empty($_POST['user_twitter']))
        update_user_meta($current_user->ID, 'user_twitter', esc_attr($_POST['user_twitter']));
    if (!empty($_POST['user_instagram']))
        update_user_meta($current_user->ID, 'user_instagram', esc_attr($_POST['user_instagram']));

    /* Redirect so the page will show updated info.*/
    /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if (count($error) == 0) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect(get_permalink());
        exit;
    }
}
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>">
            <div class="entry-content entry">
                <?php the_content(); ?>
                <?php if (!is_user_logged_in()) : ?>
                    <p class="warning">
                        <?php _e('You must be logged in to edit your profile.', 'profile'); ?>
                    </p><!-- .warning -->
                <?php else : ?>
                    <?php if (count($error) > 0) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>
                    <form method="post" id="adduser" action="<?php the_permalink(); ?>">
                        <p class="form-username">
                            <label for="first-name"><?php _e('Facebook', 'profile'); ?></label>
                            <input class="text-input" name="first-name" type="text" id="user_facebook" value="<?php the_author_meta('user_facebook', $current_user->ID); ?>" />
                        </p><!-- .form-username -->
                        <p class="form-username">
                            <label for="last-name"><?php _e('Twitter', 'profile'); ?></label>
                            <input class="text-input" name="last-name" type="text" id="user_twitter" value="<?php the_author_meta('user_twitter', $current_user->ID); ?>" />
                        </p><!-- .form-username -->
                        <p class="form-username">
                            <label for="last-name"><?php _e('Instagram', 'profile'); ?></label>
                            <input class="text-input" name="last-name" type="text" id="user_twitter" value="<?php the_author_meta('user_instagram', $current_user->ID); ?>" />
                        </p><!-- .form-username -->
                        <p class="form-email">
                            <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
                            <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta('user_email', $current_user->ID); ?>" />
                        </p><!-- .form-email -->

                        <p class="form-password">
                            <label for="pass1"><?php _e('Password *', 'profile'); ?> </label>
                            <input class="text-input" name="pass1" type="password" id="pass1" />
                        </p><!-- .form-password -->
                        <p class="form-password">
                            <label for="pass2"><?php _e('Repeat Password *', 'profile'); ?></label>
                            <input class="text-input" name="pass2" type="password" id="pass2" />
                        </p><!-- .form-password -->
                        <?php
                        //action hook for plugin and extra fields
                        do_action('edit_user_profile', $current_user);
                        ?>
                        <p class="form-submit">
                            <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'profile'); ?>" />
                            <?php wp_nonce_field('update-user') ?>
                            <input name="action" type="hidden" id="action" value="update-user" />
                        </p><!-- .form-submit -->
                    </form><!-- #adduser -->
                <?php endif; ?>
            </div><!-- .entry-content -->
        </div><!-- .hentry .post -->
    <?php endwhile; ?>
<?php else : ?>
    <p class="no-data">
        <?php _e('Sorry, no page matched your criteria.', 'profile'); ?>
    </p><!-- .no-data -->
<?php endif; ?>


<?php get_footer();
