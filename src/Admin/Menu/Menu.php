<?php

namespace Dboyz\PS\Admin\Menu;

/**
 * The admin class
 */
class Menu
{

	/**
	 * Initialize the class
	 */
	function __construct()
	{

		add_action('admin_menu', [$this, 'dboyzregister_my_custom_menu_page']);
		add_action("admin_init", [$this, 'dboyzsearch_setting_fields']);

		add_filter('manage_edit-types_columns',  [$this, 'dboyztypes_user_column']);
		add_filter('manage_types_custom_column', [$this, 'dboyzmanage_types_column'], 10, 3);
		add_filter('manage_edit-designation_columns',  [$this, 'dboyztypes_user_column']);
		add_filter('manage_designation_custom_column', [$this, 'dboyzmanage_designation_column'], 10, 3);
		
		add_filter('manage_edit-section_columns',  [$this, 'dboyztypes_user_column']);
		add_filter('manage_section_custom_column', [$this, 'dboyzmanage_section_column'], 10, 3);
	}

	function dboyztypes_user_column($columns)
	{
		unset($columns['posts']);
		$columns['users'] = __('Users');
		return $columns;
	}
	function dboyzmanage_types_column($display, $column, $term_id)
	{

		if ('users' === $column) {
			$term = get_term($term_id, 'types');
			if (isset($term->count)) {
				echo $term->count;
			} else {
				echo "0";
			}
		}
	}
	function dboyzmanage_designation_column($display, $column, $term_id)
	{

		if ('users' === $column) {
			$term = get_term($term_id, 'designation');
			if (isset($term->count)) {
				echo $term->count;
			} else {
				echo "0";
			}
		}
	}
	function dboyzmanage_section_column($display, $column, $term_id)
	{

		if ('users' === $column) {
			$term = get_term($term_id, 'section');
			if (isset($term->count)) {
				echo $term->count;
			} else {
				echo "0";
			}
		}
	}

	function dboyzregister_my_custom_menu_page()
	{
		add_menu_page(
			__('Dboyz', 'textdomain'),
			'Dboyz',
			'manage_options',
			'custompage',
			[$this, 'my_custom_menu_page'],
			plugins_url('myplugin/images/icon.png'),
			6
		);
		$tax = get_taxonomy('types');
		add_users_page(
			esc_attr($tax->labels->menu_name),
			esc_attr($tax->labels->menu_name),
			$tax->cap->manage_terms,
			'edit-tags.php?taxonomy=' . $tax->name
		);
		$tax = get_taxonomy('designation');
		add_users_page(
			esc_attr($tax->labels->menu_name),
			esc_attr($tax->labels->menu_name),
			$tax->cap->manage_terms,
			'edit-tags.php?taxonomy=' . $tax->name
		);

		$tax = get_taxonomy('section');
		add_users_page(
			esc_attr($tax->labels->menu_name),
			esc_attr($tax->labels->menu_name),
			$tax->cap->manage_terms,
			'edit-tags.php?taxonomy=' . $tax->name
		);
	}

	function my_custom_menu_page()
	{
?><div class="wrap">
			<h1>Dboyz Panel</h1>
			<form method="post" action="options.php">
				<?php
				settings_fields("section");
				do_settings_sections("la-setting");
				submit_button();
				?>
			</form>
		</div>
<?php
	}
	function dboyzsearch_setting_fields()
	{
		add_settings_section("section", "Page Setting", null, "la-setting");
		add_settings_field("login_page", "Login Page", [$this, 'la_all_page_return'], "la-setting", "section", "login_page");
		register_setting("section", "login_page");
		add_settings_field("register_page", "Register Page", [$this, 'la_all_page_return'], "la-setting", "section", "register_page");
		register_setting("section", "register_page");
		add_settings_field("forget_page", "Forget Pass Page", [$this, 'la_all_page_return'], "la-setting", "section", "forget_page");
		register_setting("section", "forget_page");
		add_settings_field("success_page", "Success Page", [$this, 'la_all_page_return'], "la-setting", "section", "success_page");
		register_setting("section", "success_page");
		add_settings_field("user_page", "Users Page", [$this, 'la_all_page_return'], "la-setting", "section", "user_page");
		register_setting("section", "user_page");
		add_settings_field("user_search_page", "Users Search Page", [$this, 'la_all_page_return'], "la-setting", "section", "user_search_page");
		register_setting("section", "user_search_page");
	}

	function la_all_page_return($name)
	{
		$allPage = get_pages();
		$str = "<select name='" . $name . "'>";
		$selected = "";
		foreach (get_pages() as $page) {
			if ($page->ID == get_option($name)) {
				$selected = "selected";
			}
			$str .= "<option value='" . $page->ID . "' " . $selected . ">" . $page->post_title . "</option>";
			$selected = "";
		}
		$str .= "</select>";
		echo  $str;
	}
}
