<?php

global $wpdb, $user_ID;

$author_info = get_userdata($user->ID);
$image_src = wp_get_attachment_image_src(get_the_author_meta('dboyzprofile_image', $user->ID), 'full');
if (isset($image_src[0])) {
    $img_src = $image_src[0];
} else {
    $img_src = dboyz_PS_URL . '/assets/images/user-icon-placeholder.png';
}
$user_designation = wp_get_object_terms($user->ID, 'designation', array('fields' => 'all_with_object_id'));
$user_section = wp_get_object_terms($user->ID, 'section', array('fields' => 'all_with_object_id'));

$user_blood = wp_get_object_terms($user->ID, 'bloodgroup', array('fields' => 'all_with_object_id'));
if (empty($user_designation)) {
    $designation = "";
} else {
    $designation = $user_designation[0]->name;
}
if (empty($user_blood)) {
    $blood = "";
} else {
    $blood = $user_blood[0]->name;
}
if (get_the_author_meta('phone', $user->ID) != '') {
    $phone = get_the_author_meta('phone', $user->ID);
} else {
    $phone = "---";
}
?>

<!-- <div>
    <div class="fs-2"><?php echo $author_info->first_name . " " . $author_info->last_name; ?></div>
    <div class="fs-6"> <?php echo $designation; ?></div>
    <div class="ebtr-team-image">
        <img src="<?php echo esc_attr($img_src, "dboyz-ps") ?>" alt="team-image">
    </div>
    <p><?php echo $author_info->description; ?></p>
    <div class="row h-line">
        <div class="col">
            <div class="fs-5">Section - <?php echo $user_section[0]->name; ?></div>
        </div>
        <div class="col">
            <div class="fs-5">Blood Group - <?php echo $blood; ?></div>
        </div>
        <div class="col">
            <div class="ebtr-team-box-social">
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
    </div>
</div> -->


<section class="section about-section" id="about">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-lg-6">
                <div class="about-text go-to">
                    <h3 class="dark-color">About Me</h3>
                    <h6 class="theme-color lead"><?php echo $author_info->first_name . " " . $author_info->last_name; ?></h6>
                    <p><?php echo $author_info->description; ?></p>
                    <div class="row about-list">
                        <div class="col-md-6">
                            <div class="media">
                                <label>Section</label>
                                <p><?php echo $user_section[0]->name; ?></p>
                            </div>
                            <div class="media">
                                <label>Occupation</label>
                                <p><?php echo $designation; ?></p>
                            </div>
                            <div class="media">
                                <label>Blood Group</label>
                                <p><?php echo $blood; ?></p>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="media">
                                <label>E-mail</label>
                                <p><?php echo $author_info->user_email; ?></p>
                            </div>
                            <div class="media">
                                <label>Phone</label>
                                <p><?php echo $phone ?></p>
                            </div>
                            <div class="media">
                                <label>Facebook</label>
                                <p>
                                <div class="ebtr-team-box-social">
                                    <div class="ebtr-team-social"><a href="<?php echo get_the_author_meta('user_facebook', $user->ID) ?>"><i class="fab fa fa-facebook"></i></a></div>
                                </div>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-avatar">
                    <img src="<?php echo esc_attr($img_src, "dboyz-ps") ?>" title="" alt="">
                </div>
            </div>
        </div>
        <div class="row h-line counter">
            <div class="col">
                <div class="fs-5">Section - <?php echo $user_section[0]->name; ?></div>
            </div>
            <div class="col">
                <div class="fs-5">Blood Group - <?php echo $blood; ?></div>
            </div>
            <div class="col">
                <div class="ebtr-team-box-social">
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
        </div>
    </div>
</section>