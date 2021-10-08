<?php

namespace Dboyz\PS\Elementor;

/**
 * The admin class
 */
class Elementor
{

	/**
	 * Initialize the class
	 */
	function __construct()
	{

		add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
		add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
	}
	public function init_widgets()
	{

		include_once __DIR__ . '/events.php';
	}
	function add_elementor_widget_categories($elements_manager)
	{
		$elements_manager->add_category(
			'dboyz',
			[
				'title' => __('Dboyz', 'dboyz-ps'),
				'icon' => 'fa fa-plug',
			]
		);
	}
}
