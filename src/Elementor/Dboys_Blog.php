<?php


use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;
use \Elementor\Repeater;
use Elementor\Core\Schemes;

class Dboys_Blog extends Widget_Base
{
	public function get_name()
	{
		return 'dboyz_blog';
	}

	public function get_title()
	{
		return esc_html__('Dboyz Blog', 'dboyz');
	}

	public function get_icon()
	{
		return 'eicon-post';
	}

	public function get_categories()
	{
		return ['dboyz'];
	}

	private function get_blog_categories()
	{
		$options  = array();
		$taxonomy = 'category';
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
			'general',
			array(
				'label' => esc_html__('General', 'homepro'),
			)
		);

		$this->add_control(
			'category_id',
			array(
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label'       => esc_html__('Category', 'homepro-core'),
				'options'     => $this->get_blog_categories(),
				'multiple'    => true,
				'label_block' => true,
			)
		);
		$this->add_control(
			'posts_per_page',
			array(
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => esc_html__('posts per page', 'homepro-core'),
				'default'    => 2,
			)
		);
		$this->add_control(
			'order_by',
			array(
				'label'   => esc_html__('Order By', 'homepro-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'          => esc_html__('Date', 'homepro-core'),
					'ID'            => esc_html__('ID', 'homepro-core'),
					'author'        => esc_html__('Author', 'homepro-core'),
					'title'         => esc_html__('Title', 'homepro-core'),
					'modified'      => esc_html__('Modified', 'homepro-core'),
					'rand'          => esc_html__('Random', 'homepro-core'),
					'comment_count' => esc_html__('Comment count', 'homepro-core'),
					'menu_order'    => esc_html__('Menu order', 'homepro-core'),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__('Order', 'homepro-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => array(
					'desc' => esc_html__('DESC', 'homepro-core'),
					'asc'  => esc_html__('ASC', 'homepro-core'),
				),
			)
		);

		$this->end_controls_section();
	}
	protected function render()
	{
		$settings     = $this->get_settings_for_display();
		// $sub_title    = $settings['sub_title'];
		// $title        = $settings['title'];

		if ($settings['category_id']) {
			$category_arr = implode(', ', $settings['category_id']);
		} else {
			$category_arr = '';
		}
		$posts_per_page = $settings['posts_per_page'];
		$order_by       = $settings['order_by'];
		$order          = $settings['order'];
		$pg_num         = get_query_var('paged') ? get_query_var('paged') : 1;
		$args           = array(
			'post_type'      => array('post'),
			'post_status'    => array('publish'),
			'nopaging'       => false,
			'paged'          => $pg_num,
			'posts_per_page' => $posts_per_page,
			'category_name'  => $category_arr,
			'orderby'        => $order_by,
			'order'          => $order,
		);
		$query = new \WP_Query($args);
?>
		<!--Start Blog Style1 Area-->
		<section class="blog-style1-area">
			<div class="container">
				<div class="row text-right-rtl">
					<?php
					if ($query->have_posts()) {
						while ($query->have_posts()) {
							$query->the_post();
					?>
							<div class="sec-title text-center">
								<div><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></div>
							</div>
							<div class="image-box 4">
								<div class="single-blog-style1">
									<div class="img-holder">
										<div class="inner">
											<?php the_post_thumbnail('medium'); ?>
										</div>
									</div>
									<!-- <div class="text-holder">
										<div class="date-box">
											<div class="border-box"></div>
											<h5><?php echo get_the_date('M j, Y'); ?></h5>
										</div>
										<h3 class="blog-title">
											<a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a>
										</h3>
										<ul class="meta-info">
										
											<li><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html_e('10 mins Read', 'homepro'); ?></a></li>
										</ul>
									</div> -->
								</div>
							</div>
							<!--End Single blog Style1-->
					<?php
						}
						wp_reset_postdata();
					}
					?>
				</div>
			</div>
		</section>
		<!--End Blog Style1 Area-->
<?php

	}
}
Plugin::instance()->widgets_manager->register_widget_type(new Dboys_Blog());
