<?php

namespace Dboyz\PS;

/**
 * The admin class
 */
class Taxonomy
{

	/**
	 * Initialize the class
	 */
	function __construct()
	{
		add_action('init',  [$this, 'custom_taxonomy'], 0);
	}

	function custom_taxonomy()
	{
		$labels = array(
			'name'                       => _x('Types', 'Types Name', 'text_domain'),
			'singular_name'              => _x('Type', 'Type Name', 'text_domain'),
			'menu_name'                  => __('Types', 'text_domain'),
			'all_items'                  => __('All Types', 'text_domain'),
			'parent_item'                => __('Parent Type', 'text_domain'),
			'parent_item_colon'          => __('Parent Type:', 'text_domain'),
			'new_item_name'              => __('New Type Name', 'text_domain'),
			'add_new_item'               => __('Add Type', 'text_domain'),
			'edit_item'                  => __('Edit Type', 'text_domain'),
			'update_item'                => __('Update Type', 'text_domain'),
			'view_item'                  => __('View Type', 'text_domain'),
			'separate_items_with_commas' => __('Separate type with commas', 'text_domain'),
			'add_or_remove_items'        => __('Add or remove types', 'text_domain'),
			'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
			'popular_items'              => __('Popular Types', 'text_domain'),
			'search_items'               => __('Search Types', 'text_domain'),
			'not_found'                  => __('Not Found', 'text_domain'),
			'no_terms'                   => __('No types', 'text_domain'),
			'items_list'                 => __('Types list', 'text_domain'),
			'items_list_navigation'      => __('Types list navigation', 'text_domain'),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy('types', 'user', $args);

		$labels = array(
			'name'                       => _x('Designation', 'Designation Name', 'text_domain'),
			'singular_name'              => _x('Designation', 'Designation Name', 'text_domain'),
			'menu_name'                  => __('Designation', 'text_domain'),
			'all_items'                  => __('All Designation', 'text_domain'),
			'parent_item'                => __('Parent Designation', 'text_domain'),
			'parent_item_colon'          => __('Parent Designation:', 'text_domain'),
			'new_item_name'              => __('New Designation Name', 'text_domain'),
			'add_new_item'               => __('Add Designation', 'text_domain'),
			'edit_item'                  => __('Edit Designation', 'text_domain'),
			'update_item'                => __('Update Designation', 'text_domain'),
			'view_item'                  => __('View Designation', 'text_domain'),
			'separate_items_with_commas' => __('Separate type with commas', 'text_domain'),
			'add_or_remove_items'        => __('Add or remove designation', 'text_domain'),
			'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
			'popular_items'              => __('Popular Designation', 'text_domain'),
			'search_items'               => __('Search Designation', 'text_domain'),
			'not_found'                  => __('Not Found', 'text_domain'),
			'no_terms'                   => __('No designation', 'text_domain'),
			'items_list'                 => __('Designation list', 'text_domain'),
			'items_list_navigation'      => __('Designation list navigation', 'text_domain'),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy('designation', 'user', $args);

		$labels = array(
			'name'                       => _x('Section', 'ection Name', 'text_domain'),
			'singular_name'              => _x('Section', 'Section Name', 'text_domain'),
			'menu_name'                  => __('Section', 'text_domain'),
			'all_items'                  => __('All Section', 'text_domain'),
			'parent_item'                => __('Parent Section', 'text_domain'),
			'parent_item_colon'          => __('Parent Section:', 'text_domain'),
			'new_item_name'              => __('New Section Name', 'text_domain'),
			'add_new_item'               => __('Add Section', 'text_domain'),
			'edit_item'                  => __('Edit Section', 'text_domain'),
			'update_item'                => __('Update Section', 'text_domain'),
			'view_item'                  => __('View Section', 'text_domain'),
			'separate_items_with_commas' => __('Separate type with commas', 'text_domain'),
			'add_or_remove_items'        => __('Add or remove section', 'text_domain'),
			'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
			'popular_items'              => __('Popular Section', 'text_domain'),
			'search_items'               => __('Search Section', 'text_domain'),
			'not_found'                  => __('Not Found', 'text_domain'),
			'no_terms'                   => __('No section', 'text_domain'),
			'items_list'                 => __('Section list', 'text_domain'),
			'items_list_navigation'      => __('Section list navigation', 'text_domain'),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy('section', 'user', $args);
	}
}
