<?php

namespace Dboyz\PS\Admin\Meta;

/**
 * The admin class
 */
class Meta
{

	/**
	 * Initialize the class
	 */
	function __construct()
	{
		add_action('show_user_profile', [$this, 'dboyzprofile_edit_action']);
		add_action('edit_user_profile', [$this, 'dboyzprofile_edit_action']);
		add_action('user_new_form', [$this, 'dboyzprofile_edit_action']);
		add_action('personal_options_update', [$this, 'dboyzextra_profile_fields']);
		add_action('edit_user_profile_update', [$this, 'dboyzextra_profile_fields']);
		add_action('user_register', [$this, 'dboyzextra_profile_fields']);
		add_filter('sanitize_user', [$this, 'dboyzdisable_departments_username']);
		add_filter('parent_file', [$this, 'dboyzchange_parent_file']);
	}

	function dboyzprofile_edit_action($user)
	{
		$dboyzstatus = get_user_meta($user->ID, 'dboyzstatus');
		if ('add-new-user' == $user) {
			$uid = 0;
		} else {
			$uid = $user->ID;
		}
?>
		<table class="form-table">
			<tr>
				<th>
					<label for="code"><?php _e('Custom Meta'); ?></label>
				</th>
				<td>
					<input type="text" name="code" id="code" value="<?php echo esc_attr(get_the_author_meta('code', $uid)); ?>" class="regular-text" />
				</td>
			</tr>
		</table>
		<table class="form-table">
			<tr>
				<th>
					<label for="user_facebook"><?php _e('Facebook'); ?></label>
				</th>
				<td>
					<input type="text" name="user_facebook" id="user_facebook" value="<?php echo esc_attr(get_the_author_meta('user_facebook', $uid)); ?>" class="regular-text" />
				</td>
			</tr>
		</table>
		<table class="form-table">
			<tr>
				<th>
					<label for="user_twitter"><?php _e('Twitter'); ?></label>
				</th>
				<td>
					<input type="text" name="user_twitter" id="user_twitter" value="<?php echo esc_attr(get_the_author_meta('user_twitter', $uid)); ?>" class="regular-text" />
				</td>
			</tr>
		</table>
		<table class="form-table">
			<tr>
				<th>
					<label for="user_instagram"><?php _e('Instagram'); ?></label>
				</th>
				<td>
					<input type="text" name="user_instagram" id="user_instagram" value="<?php echo esc_attr(get_the_author_meta('user_instagram', $uid)); ?>" class="regular-text" />
				</td>
			</tr>
		</table>

		<table class="form-table">
			<tr>
				<th>
					<label for="code"><?php _e('Image'); ?></label>
				</th>
				<td>
					<div id="dboyzprofile_image_div">
						<input id="dboyzprofile_image" type="hidden" name="dboyzprofile_image" value="<?php echo esc_attr(get_the_author_meta('dboyzprofile_image', $uid)); ?>">
						<?php
						$img_data_id = get_the_author_meta('dboyzprofile_image', $uid);
						if ($img_data_id != '') {
							echo wp_get_attachment_image($img_data_id, 'thumbnail');
						} else { ?>
							<img id="<?php echo esc_attr(get_the_author_meta('dboyzprofile_image', $uid)); ?>" class="cl_mb_placeholder" src="" alt="<?php echo esc_attr(get_the_author_meta('imd_id', $uid)); ?>">

						<?php } ?>

						<div class="button_control">
							<button id="<?php echo esc_attr(get_the_author_meta('dboyzprofile_image', $uid)); ?>" type="button" class="mb_img_upload_btn"><?php echo esc_html__('Upload Images', 'crazy-listing'); ?></button>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<?php

		$tax = get_taxonomy('types');
		$designation = get_taxonomy('designation');
		$section = get_taxonomy('section');
		/* Make sure the user can assign terms of the types taxonomy before proceeding. */
		if (!current_user_can($tax->cap->assign_terms))
			return;
		if (!current_user_can($designation->cap->assign_terms))
			return;
		if (!current_user_can($section->cap->assign_terms))
			return;
		/* Get the terms of the 'types' taxonomy. */
		$terms = get_terms('types', array('hide_empty' => false));
		$termsdes = get_terms('designation', array('hide_empty' => false));
		$termssec = get_terms('section', array('hide_empty' => false));
		?>

		<h3><?php _e('Section'); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="section"><?php _e('Allocated Section'); ?></label></th>
				<td><?php
					if (!empty($terms)) {
						echo $this->dboyzcustom_form_field('section', $termssec, $uid, "dropdown");
					} else {
						_e('There are no Section available.');
					}
					?></td>
			</tr>
		</table>


		<h3><?php _e('Types'); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="types"><?php _e('Allocated Types'); ?></label></th>
				<td><?php
					if (!empty($terms)) {
						echo $this->dboyzcustom_form_field('types', $terms, $uid);
					} else {
						_e('There are no types available.');
					}
					?></td>
			</tr>
		</table>
		<h3><?php _e('Designation'); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="designation"><?php _e('Allocated Designation'); ?></label></th>
				<td><?php
					if (!empty($termsdes)) {
						echo $this->dboyzcustom_form_field('designation', $termsdes, $uid, "dropdown");
					} else {
						_e('There are no Designation available.');
					}
					?></td>
			</tr>
		</table>
		<h3><?php _e('Status'); ?></h3>
		<table class="form-table">
			<tr>
				<th>
					<label for="dboyzstatus"><?php _e('Status'); ?></label>
				</th>
				<td>
					<select name="dboyzstatus" id="dboyzstatus">
						<option value="0" <?php if (isset($dboyzstatus[0])) {
												selected($dboyzstatus[0], 0);
											} ?>>Inactive</option>
						<option value="1" <?php if (isset($dboyzstatus[0])) {
												selected($dboyzstatus[0], 1);
											} ?>>Active</option>
					</select>

				</td>
			</tr>
		</table>

		<?php
	}

	function dboyzextra_profile_fields($user_id)
	{
		$tax = get_taxonomy('types');
		$taxdes = get_taxonomy('designation');
		$taxsec = get_taxonomy('section');
		if (!current_user_can('edit_user', $user_id) && current_user_can($tax->cap->assign_terms) && current_user_can($taxdes->cap->assign_terms) && current_user_can($taxsec->cap->assign_terms))
			return false;
		update_user_meta($user_id, 'code', $_POST['code']);
		update_user_meta($user_id, 'dboyzprofile_image', $_POST['dboyzprofile_image']);
		update_user_meta($user_id, 'user_facebook', $_POST['user_facebook']);
		update_user_meta($user_id, 'user_twitter', $_POST['user_twitter']);
		update_user_meta($user_id, 'user_instagram', $_POST['user_instagram']);
		update_user_meta($user_id, 'dboyzstatus', $_POST['dboyzstatus']);

		$term = $_POST['types'];
		$terms = is_array($term) ? $term : (int) $term;
		wp_set_object_terms($user_id, $terms, 'types', false);
		clean_object_term_cache($user_id, 'types');

		$termd = $_POST['designation'];
		$termsd = is_array($termd) ? $termd : (int) $termd;
		wp_set_object_terms($user_id, $termsd, 'designation', false);
		clean_object_term_cache($user_id, 'designation');

		$termd = $_POST['section'];
		$termsd = is_array($termd) ? $termd : (int) $termd;
		wp_set_object_terms($user_id, $termsd, 'section', false);
		clean_object_term_cache($user_id, 'section');
	}

	function dboyzcustom_form_field($name, $options, $userId, $type = 'checkbox')
	{
		global $pagenow;
		switch ($type) {
			case 'checkbox':
				foreach ($options as $term) :
		?>
					<label for="<?php echo $name ?>-<?php echo esc_attr($term->slug); ?>">
						<input type="checkbox" name="<?php echo $name ?>[]" id="<?php echo $name ?>-<?php echo esc_attr($term->slug); ?>" value="<?php echo $term->slug; ?>" <?php if ($pagenow !== 'user-new.php') checked(true, is_object_in_term($userId, $name, $term->slug)); ?>>
						<?php echo $term->name; ?>
					</label><br />
<?php
				endforeach;
				break;
			case 'dropdown':
				$selectTerms = [];
				foreach ($options as $term) {
					$selectTerms[$term->term_id] = $term->name;
				}

				// get all terms linked with the user
				$usrTerms = get_the_terms($userId, $name);
				$usrTerms = wp_get_object_terms($userId, $name, array('fields' => 'all_with_object_id'));

				$usrTermsArr = [];
				if (!empty($usrTerms)) {
					foreach ($usrTerms as $term) {
						$usrTermsArr[] = (int) $term->term_id;
					}
				}

				// Dropdown
				echo "<select name='{$name}'>";
				echo "<option value=''>-Select-</option>";
				foreach ($selectTerms as $options_value => $options_label) {
					$selected = (in_array($options_value, array_values($usrTermsArr))) ? " selected='selected'" : "";
					echo "<option value='{$options_value}' {$selected}>{$options_label}</option>";
				}
				echo "</select>";
				break;
		}
	}
	function dboyzdisable_departments_username($username)
	{
		if ('types' === $username) {
			$username = '';
		}
		if ('designation' === $username) {
			$username = '';
		}
		if ('section' === $username) {
			$username = '';
		}

		return $username;
	}
	function dboyzchange_parent_file($parent_file)
	{
		global $submenu_file;
		if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'types' && $submenu_file == 'edit-tags.php?taxonomy=types') {
			$parent_file = 'users.php';
		}
		if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'designation' && $submenu_file == 'edit-tags.php?taxonomy=designation') {
			$parent_file = 'users.php';
		}
		if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'designation' && $submenu_file == 'edit-tags.php?taxonomy=section') {
			$parent_file = 'users.php';
		}

		return $parent_file;
	}
}
