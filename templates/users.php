<?php
global $wpdb, $user_ID;
$total_authors = $my_users->total_users;
$number = isset($number) ? $number : $total_authors;
$search = isset($search) ? $search : false;
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$total_pages = intval($total_authors / $number) + 1;
$authors = $my_users->get_results(); ?>

<!-- <div class="container">
  <div class="row"> -->
<section id="ebtr-team-section-252" class="ebtr-section-padding">
    <div class="ebtr-container">

        <?php if (!empty($authors)) { ?>

            <?php
            foreach ($authors as $author) {
                $author_info = get_userdata($author->ID);
                $image_src = wp_get_attachment_image_src(get_the_author_meta('dboyzprofile_image', $author->ID), 'thumbnail');
                if (isset($image_src[0])) {
                    $img_src = $image_src[0];
                } else {
                    $img_src = dboyz_PS_URL . '/assets/images/user-icon-placeholder.png';
                }
                $user_designation = wp_get_object_terms($author->ID, 'designation', array('fields' => 'all_with_object_id'));
                $user_section = wp_get_object_terms($author->ID, 'section', array('fields' => 'all_with_object_id'));
                if (empty($user_designation)) {
                    $designation = "Unset";
                } else {
                    $designation = $user_designation[0]->name;
                }

            ?>

                <!-- .ebtr-container-left -->
                <div class="ebtr-container-right">
                    <div class="ebtr-row">
                        <div class="ebtr-team-box-252">
                            <div class="ebtr-team-image">
                                <img src="<?php echo esc_attr($img_src, "dboyz-ps") ?>" alt="team-image">
                            </div>
                            <!-- .ebtr-team-image -->
                            <div class="ebtr-team-text">
                                <h3 class="ebtr-team-name"><a href="<?php echo site_url() . "/user/" . $author_info->user_login ?>"><?php echo $author_info->first_name . " " . $author_info->last_name; ?></a></h3>
                                <p class="ebtr-team-sec"><a href="<?php echo site_url() . "/users/section/" . str_replace(" ", "_", $user_section[0]->name) ?>"><?php echo $user_section[0]->name ?></a></p>
                                <p class="ebtr-team-desig"><a href="<?php echo site_url() . "/users/designation/" . str_replace(" ", "_", $designation) ?>"><?php echo $designation ?></a></p>
                            </div>
                            <!-- .ebtr-team-text -->
                            <div class="ebtr-team-social">
                                <?php
                                if (get_the_author_meta('user_facebook', $author->ID) != '') { ?>
                                    <a href="<?php echo get_the_author_meta('user_facebook', $author->ID) ?>"><i class="fab fa fa-facebook"></i></a>
                                <?php }
                                if (get_the_author_meta('user_twitter', $author->ID) != '') { ?>
                                    <a href="<?php echo get_the_author_meta('user_twitter', $author->ID) ?>"><i class="fab fa fa-twitter"></i></a>
                                <?php }
                                if (get_the_author_meta('user_instagram', $author->ID) != '') { ?>
                                    <a href="<?php echo get_the_author_meta('user_instagram', $author->ID) ?>"><i class="fab fa fa-instagram"></i></a>
                                <?php } ?>

                            </div>
                            <!-- .ebtr-team-social -->
                        </div>
                    </div>
                    <!-- .ebtr-row -->
                </div>
                <!-- .ebtr-container-right -->


                <!-- <div class="col-6">
            <?php
                $author_info = get_userdata($author->ID); ?>
                <div>
                    <?php //echo get_avatar($author->ID, 90); get_author_posts_url($author->ID);
                    ?>
                    <div class="fs-4"><a href="<?php echo get_permalink(get_the_ID()) . "?user=" . $author_info->display_name ?>"><?php echo $author_info->display_name; ?></a> </div>
                    <p><?php echo $author_info->description; ?></p>

                    <?php //get_the_author_meta('dboyzprofile_image', $author->ID);
                    echo wp_get_attachment_image(get_the_author_meta('dboyzprofile_image', $author->ID), 'thumbnail'); ?>

                    <p><a href="<?php echo get_permalink(get_the_ID()) . "?user=" . $author_info->display_name ?> ">Read About - <?php echo $author_info->display_name; ?></a></p>
                </div>
            </div> -->
            <?php
            }
            ?>
    </div>
    <!-- .ebtr-container -->
</section>
<!-- </div>
</div> -->
<?php
        } else { ?>
    <h2>No authors found</h2>
<?php } //endif
        //echo get_permalink(get_the_ID());;
?>
<?php if ($page != 1) { ?>

    <nav id="nav-single" style="clear:both; float:none; margin-top:20px;">
        <h3 class="assistive-text">Post navigation</h3>
        <?php if ($page != 1) { ?>
            <span class="nav-previous"><a rel="prev" href="<?php the_permalink() ?>page/<?php echo $page - 1; ?>/"><span class="meta-nav">←</span> Previous</a></span>
        <?php } ?>

        <?php if ($page < $total_pages) { ?>
            <span class="nav-next"><a rel="next" href="<?php the_permalink() ?>page/<?php echo $page + 1; ?>/">Next <span class="meta-nav">→</span></a></span>
        <?php } ?>
    </nav>
<?php }
