<?php
/* 
Template Name: Login 
*/

get_header();
global $wpdb, $user_ID;

$author_info = get_userdata($user->ID);
$image_src = wp_get_attachment_image_src(get_the_author_meta('dboyzprofile_image', $user->ID), 'full');
if (isset($image_src[0])) {
    $img_src = $image_src[0];
} else {
    $img_src = dboyz_PS_URL . '/assets/images/user-icon-placeholder.png';
}
?>

<div>
    <?php //echo get_avatar($user_ID, 90); 
    ?>
    <div class="fs-4"><?php echo $author_info->display_name; ?></div>

    <div class="ebtr-team-image">
        <img src="<?php echo esc_attr($img_src, "dboyz-ps") ?>" alt="team-image">
    </div>
    <?php
    $user_designation = wp_get_object_terms($user->ID, 'designation', array('fields' => 'all_with_object_id'));
    $user_section = wp_get_object_terms($user->ID, 'section', array('fields' => 'all_with_object_id'));

    $term =  $users = get_objects_in_term(2, "types");
    //get_term( 3, 'types');  //get_term_by('name', 'a3', 'types');

    if (empty($user_designation)) {
        $designation = "Unset";
    } else {
        $designation = $user_designation[0]->name;
    }
    ?>
    <div class="fs-4">Section - <?php echo $user_section[0]->name; ?></div>
    <div class="fs-4">Designation - <?php echo $designation; ?></div>
    <p><?php echo $author_info->description; ?></p>
    <div class="ebtr-team-box-252">
        <div class="ebtr-team-social">
            <?php
            if (get_the_author_meta('user_facebook', $user->ID) != '') { ?>
                <a href="<?php echo get_the_author_meta('user_facebook', $user->ID) ?>"><i class="fab fa fa-facebook"></i></a>
            <?php }
            if (get_the_author_meta('user_twitter', $user->ID) != '') { ?>
                <a href="<?php echo get_the_author_meta('user_twitter', $user->ID) ?>"><i class="fab fa fa-twitter"></i></a>
            <?php }
            if (get_the_author_meta('user_instagram', $user->ID) != '') { ?>
                <a href="<?php echo get_the_author_meta('user_instagram', $user->ID) ?>"><i class="fab fa fa-instagram"></i></a>
            <?php } ?>

        </div>
    </div>
</div>
<?php
if (is_user_logged_in()) {
}
get_footer();
