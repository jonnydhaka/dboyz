<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;

class Events extends Widget_Base
{

    public function get_name()
    {
        return 'events';
    }

    public function get_title()
    {
        return esc_html__('Events', 'dboyz');
    }

    public function get_icon()
    {
        return 'eicon-post';
    }

    public function get_categories()
    {
        return ['dboyz'];
    }

    // public function get_script_depends()
    // {

    //     // $settings =  \Elementor\Base_Control::get_settings('volunteer_design_list');
    //     // echo '<pre>';
    //     // print_r($settings);
    //     // echo '</pre>';

    //     // $volunteer_design_list = $settings['volunteer_design_list'];
    //     // if($volunteer_design_list == 'style-two') : 
    //     return ['owl-lib-loveus', 'owl-slider-loveus'];
    //     // endif;
    //     // return ['owl-lib-loveus'];
    // }
    // public function get_style_depends()
    // {
    //     //     $settings = $this->get_settings();
    //     //     $volunteer_design_list = $settings['volunteer_design_list'];
    //     //     if($volunteer_design_list == 'style-two') : 
    //     return ['owl-carousel-loveus-me'];
    //     //     endif;
    //     //     return [];
    // }

    private function get_category_list()
    {
        $options  = array();
        //$taxonomy = 'tribe_events';
        $taxonomy = 'tribe_events_cat';
        if (!empty($taxonomy)) {
            $terms = get_terms(
                array(
                    'parent'     => 0,
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                )
            );
            if (!empty($terms)) {
                foreach ($terms as $term) {
                    if (isset($term)) {
                        $options[''] = 'Select';
                        if (isset($term->slug) && isset($term->name)) {
                            $options[$term->slug] = $term->name;
                        }
                    }
                }
            }
        }
        return $options;
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'event_design_area',
            [
                'label' => esc_html__('event design area', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'event_design_list',
            [
                'label' => esc_html__('event design list', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'style-none',
                'options' => [
                    'style-none'  => esc_html__('One', 'plugin-domain'),
                    'style-two'  => esc_html__('Two', 'plugin-domain'),
                    'style-three'  => esc_html__('Three', 'plugin-domain'),
                    'style-four'  => esc_html__('Four', 'plugin-domain'),
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'contact_us_info_header',
            [
                'label' => esc_html__('Contact Us info header', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_program',
            [
                'label' => esc_html__('Content', 'plugin-domain'),
            ]
        );


        $this->add_control(
            'category_slug',
            [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__('Category', 'plugin-domain'),
                'options' => $this->get_category_list()
            ]
        );


        $this->add_control(
            'number',
            [
                'label' => esc_html__('Number of Post', 'plugin-domain'),
                'type' => Controls_Manager::TEXT,
                'default' => 6
            ]
        );

        /*$this->add_control(
                'order_by', [
            'label' => esc_html__('Order By', 'plugin-domain'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date' => esc_html__('Date', 'plugin-domain'),
                'ID' => esc_html__('ID', 'plugin-domain'),
                'author' => esc_html__('Author', 'plugin-domain'),
                'title' => esc_html__('Title', 'plugin-domain'),
                'modified' => esc_html__('Modified', 'plugin-domain'),
                'rand' => esc_html__('Random', 'plugin-domain'),
                'comment_count' => esc_html__('Comment count', 'plugin-domain'),
                'menu_order' => esc_html__('Menu order', 'plugin-domain')
            ]
                ]
        ); */

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'plugin-domain'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => esc_html__('DESC', 'plugin-domain'),
                    'asc' => esc_html__('ASC', 'plugin-domain')
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings();
        $event_design_list = $settings['event_design_list'];
        $number_of_post = (int) $settings['number'];
        //$order_by = $settings['order_by'];
        $order = $settings['order'];
        $category_slug = $settings['category_slug'];
        global $post;

        if (!empty($category_slug)) {
            $qparam = array(
                'posts_per_page' => $number_of_post,
                'order'          => $settings['order'],
                'tax_query' => array(
                    array(
                        'taxonomy' => 'tribe_events_cat',
                        'field' => 'slug',
                        'terms' => $category_slug
                    )
                )
            );
        } else {
            $qparam = array(
                'posts_per_page' => $number_of_post,
                'order'          => $settings['order'],
            );
        }

        $get_posts = function_exists('tribe_get_events') ? tribe_get_events($qparam) : '';

        if (function_exists('tribe_get_events')) :
?>
            <?php if ($event_design_list == 'style-four') : ?>

                <section class="events-section">
                    <div class="auto-container">

                        <div class="row clearfix">
                            <?php
                            $i = 0;
                            foreach ($get_posts as $post) {
                                setup_postdata($post);

                                $bebio_pmeta_image = get_post_meta(get_the_ID(), 'loveus_metabox_event_meta_image', TRUE);
                                $bebio_image_src = wp_get_attachment_image_src($bebio_pmeta_image, 'full');
                                $i++;
                            ?>
                                <!-- Event Block -->
                                <?php
                                if ($i % 2 == 0) {
                                    $animate_class = 'fadeInRight';
                                } else {
                                    $animate_class = 'fadeInLeft';
                                }
                                ?>

                                <!--Event Block-->
                                <div class="event-block-three style-two col-lg-4 col-md-6 col-sm-12">
                                    <div class="inner-box wow fadeInUp" data-wow-delay="0ms">
                                        <div class="image-box 2">
                                            <figure class="image"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($bebio_image_src); ?>" alt="<?php echo esc_attr('Alt'); ?>"></a></figure>
                                        </div>
                                        <div class="lower-content">
                                            <div class="date">
                                                <?php
                                                echo tribe_get_start_date(get_the_ID(), false, 'j');
                                                ?>

                                                <span class="month">
                                                    <?php
                                                    echo tribe_get_start_date(get_the_ID(), false, 'M');
                                                    ?>
                                                </span>

                                                </span>
                                            </div>
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <ul class="info clearfix">
                                                <li><span class="icon far fa-clock"></span> <?php echo tribe_get_start_date($post->ID, false, 'g:i'); ?> - <?php echo tribe_get_end_date($post->ID, false, 'g:i'); ?></li>
                                                <li><span class="icon fa fa-map-marker-alt"></span> <?php echo tribe_get_venue() ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            wp_reset_postdata(); ?>

                        </div>

                    </div>
                </section>
                <!--End Event Section -->
            <?php endif; ?>
            <?php if ($event_design_list == 'style-none') : ?>
                <!--Events Section-->

                <section class="events-section">
                    <div class="auto-container">

                        <div class="row clearfix">
                            <?php
                            $i = 0;
                            foreach ($get_posts as $post) {
                                setup_postdata($post);
                                $bebio_pmeta_image = get_post_meta(get_the_ID(), 'loveus_metabox_event_meta_image', TRUE);
                                $bebio_image_src = get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail');
                                $i++;
                            ?>
                                <!-- Event Block -->
                                <?php
                                if ($i % 2 == 0) {
                                    $animate_class = 'fadeInRight';
                                } else {
                                    $animate_class = 'fadeInLeft';
                                }
                                ?>
                                <!--Event Block-->
                                <div class="event-block-three col-lg-4 col-md-6 col-sm-12">
                                    <?php
                                    $time_format = get_option('time_format', Tribe__Date_Utils::TIMEFORMAT);
                                    $time_range_separator = tribe_get_option('timeRangeSeparator', ' - ');
                                    $start_time = tribe_get_start_date(null, false, $time_format);
                                    $end_time = tribe_get_end_date(null, false, $time_format);
                                    $time_formatted = null;
                                    if ($start_time == $end_time) {
                                        $time_formatted = esc_html($start_time);
                                    } else {
                                        $time_formatted = esc_html($start_time . $time_range_separator . $end_time);
                                    }
                                    ?>
                                    <div class="inner-box wow fadeInUp" data-wow-delay="0ms">
                                        <div class="image-box 3">
                                            <figure class="image"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($bebio_image_src); ?>" alt="<?php echo esc_attr('Alt'); ?>"></a></figure>
                                            <div class="date">
                                                <?php
                                                echo tribe_get_start_date(get_the_ID(), false, 'j');
                                                ?>

                                                <span class="month">
                                                    <?php
                                                    echo tribe_get_start_date(get_the_ID(), false, 'M');
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="lower-content">
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <ul class="info clearfix">
                                                <li><span class="icon far fa-clock"></span><?php echo esc_html__($start_time . ' - ' . $end_time, 'loveus'); ?></li>
                                                <li><span class="icon fa fa-map-marker-alt"></span> <?php echo tribe_get_venue() ?></li>
                                            </ul>
                                            <div class="link-box"><a href="<?php the_permalink(); ?>" class="theme-btn btn-style-two"><span class="btn-title">Read More</span></a></div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            wp_reset_postdata(); ?>

                        </div>

                    </div>
                </section>
                <!--End Event Section -->
            <?php endif; ?>
            <?php if ($event_design_list == 'style-two') : ?>
                <!--Upcoming Events Section-->
                <section class="upcoming-events">
                    <div class="circle-three"></div>
                    <div class="circle-four"></div>

                    <div class="auto-container">

                        <div class="events-box wow fadeInUp" data-wow-delay="0ms">
                            <?php
                            $i = 0;
                            foreach ($get_posts as $post) {
                                setup_postdata($post);
                                $bebio_pmeta_image = get_post_meta(get_the_ID(), 'loveus_metabox_event_meta_image', TRUE);
                                $bebio_image_src = get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail');
                                $i++;
                            ?>
                                <!-- Event Block -->
                                <?php
                                if ($i % 2 == 0) {
                                    $animate_class = 'fadeInRight';
                                } else {
                                    $animate_class = 'fadeInLeft';
                                }
                                ?>
                                <div class="event-block-two">
                                    <div class="inner-box">
                                        <div class="row clearfix">
                                            <div class="title-column col-lg-6 col-md-12 col-sm-12">
                                                <div class="inner">
                                                    <div class="image-box 4">
                                                        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($bebio_image_src); ?>" alt="<?php echo esc_attr('Alt'); ?>"></a>
                                                    </div>
                                                    <div class="title">
                                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-column col-lg-6 col-md-12 col-sm-12">
                                                <div class="inner">
                                                    <div class="clearfix">
                                                        <ul class="info clearfix">
                                                            <li><span class="icon far fa-clock"></span> <?php echo tribe_get_start_date($post->ID, false, 'g:i'); ?> - <?php echo tribe_get_end_date($post->ID, false, 'g:i'); ?></li>
                                                            <li><span class="icon fa fa-map-marker-alt"></span> <?php echo tribe_get_venue() ?></li>
                                                        </ul>
                                                        <div class="link-box"><a href="<?php the_permalink(); ?>" class="theme-btn btn-style-one"><span class="btn-title">Read More</span></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            wp_reset_postdata(); ?>

                        </div>

                    </div>
                </section>
            <?php endif; ?>
            <?php if ($event_design_list == 'style-three') : ?>
                <!--Upcoming Events Section-->
                <section class="upcoming-events">
                    <div class="circle-one"></div>
                    <div class="circle-two"></div>

                    <div class="auto-container">

                        <div class="carousel-box">

                            <div class="single-item-carousel love-carousel owl-theme owl-carousel" data-options='{"loop": false, "margin": 10, "autoheight":false, "lazyload":true, "nav": true, "dots": true, "autoplay": true, "autoplayTimeout": 6000, "smartSpeed": 300, "responsive":{ "0" :{ "items": "1" }, "768" :{ "items" : "1" } , "1000":{ "items" : "1" }}}'>
                                <?php
                                $i = 0;
                                foreach ($get_posts as $post) {
                                    setup_postdata($post);
                                    $bebio_pmeta_image = get_post_meta(get_the_ID(), 'loveus_metabox_event_meta_image', TRUE);
                                    $bebio_image_src = get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail');
                                    $i++;
                                ?>
                                    <!-- Event Block -->
                                    <?php
                                    if ($i % 2 == 0) {
                                        $animate_class = 'fadeInRight';
                                    } else {
                                        $animate_class = 'fadeInLeft';
                                    }
                                    ?>
                                    <!--Slide-->
                                    <div class="slide-item">
                                        <div class="event-block">
                                            <div class="inner-box clearfix">
                                                <div class="image-column">
                                                    <div class="image-box 1"><img src="<?php echo esc_url($bebio_image_src[0]); ?>" alt="<?php echo esc_attr('Alt'); ?>"></div>
                                                    <div class="bg-image-layer" style="background-image: url('<?php echo esc_url($bebio_image_src); ?>');"></div>
                                                    <a href="<?php the_permalink(); ?>" class="over-link"></a>
                                                </div>
                                                <div class="text-column">
                                                    <div class="inner">
                                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                        <ul class="info clearfix">
                                                            <li><span class="icon far fa-clock"></span>
                                                                <?php echo tribe_events_event_schedule_details(); ?></li>
                                                            <li><span class="icon fa fa-map-marker-alt"></span> <?php echo tribe_get_venue() ?></li>
                                                        </ul>
                                                        <div class="text"><?php if (get_option('rss_use_excerpt')) {
                                                                                the_excerpt();
                                                                            } else {
                                                                                the_excerpt();
                                                                            } ?></div>
                                                        <div class="link-box"><a href="<?php the_permalink(); ?>" class="theme-btn btn-style-one"><span class="btn-title">Read More</span></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                wp_reset_postdata(); ?>
                            </div>

                        </div>

                    </div>
                </section>
            <?php endif; ?>
        <?php endif; ?>


<?php
    }

    protected function content_template()
    {
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Events());
