<?php


class TimThumb_Settings_Page
{

	public static $sections = array();
	public static $fields   = array();

	public static $page     = 'timthumb-settings';


	public function __construct()
	{
		add_action('admin_menu', array($this, 'add_page'));
		add_action('admin_init', array($this, 'register_sections'));
		add_action('admin_init', array($this, 'register_fields'));
		add_action('admin_init', array($this, 'register_settings'));
	}


	public function add_page()
	{
		$page = add_submenu_page(
				$parent_slug = 'options-general.php',
				$page_title  = 'TimThumb',
				$menu_title  = 'TimThumb',
				$capability  = 'manage_options',
				$menu_slug   = self::$page,
				$function    = array($this, 'settings_page')
			);
	}


	public function register_sections()
	{
		foreach(self::$sections as $section_id => $section)
		{
			add_settings_section(
					$id       = $section_id,
					$title    = $section['title'],
					$callback = array($this, 'sections_callback'),
					$page     = self::$page
				);
		}
	}

	public function register_fields()
	{
		foreach(self::$fields as $field_id => $field)
		{
			add_settings_field(
					$id       = $field_id,
					$title    = $field['title'],
					$callback = array($this, 'show_field'),
					$page     = self::$page,
					$section  = $field['section'],
					$args     = array(
							'label_for' => 'timthumb_' . $id,
							'field_id'  => $field_id,
							'field'     => $field,
						)
				);
		}
	}

	public function register_settings()
	{
		register_setting(
				$option_group      = self::$page,
				$option_name       = 'timthumb_options',
				$sanitize_callback = array($this, 'sanitize_settings')
			);
	}


	public function sections_callback() {}

	public function sanitize_settings($settings)
	{
		return $settings;
	}


	public function settings_page()
	{
		?>
		<div class="wrap">
			<div class="icon32" id="icon-options-general"></div>
			<h2>
				<?php _e('TimThumb Settings', 'wp-timthumb'); ?> 
				<small title="<?php echo esc_attr(__('TimThumb version', 'wp-timthumb')); ?>">(<?php echo TIMTHUMB_VERSION; ?>)</small>
			</h2>

			<?php
				if (isset($_POST['reset']) && wp_verify_nonce($_POST['reset'], __FILE__) )
				{
					delete_timthumb_options();
					add_settings_error('general', 'settings_updated', __('Settings saved.'), 'updated');
				}

				settings_errors();
			?> 

			<form action="options.php" method="post"> 
				<?php settings_fields(self::$page); ?> 

				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-1">
					<?php $this->do_settings_sections(self::$page); ?> 
					</div>
				</div>

				<p>
					<input type="button" value="<?php echo esc_attr(__('Reset to default settings')); ?>" class="button-secondary alignright hide-if-no-js" id="timthumb-reset" />
					<?php submit_button(null, 'primary', 'submit', false); ?> 
				</p>

			</form>
		</div>

		<style type="text/css">
		.wrap h2 small { font-size:small; cursor:help; }
		#poststuff h3 { cursor:pointer; }
		#poststuff input.checkbox { float:left; margin:5px 5px 0 0; }
		</style>

		<script type="text/javascript">
		jQuery(function($){
			var confirm_msg = <?php echo json_encode(__('Do you really want to do this ?')); ?>;
			var nonce       = <?php echo json_encode(wp_create_nonce(__FILE__)); ?>;
			$('#timthumb-reset').click(function(){
				if (confirm(confirm_msg))
				{
					$('<form method="post" />')
						.append( $('<input name="reset" />').val(nonce) )
						.appendTo(document.body)
						.submit();
				}
			});

			$('#poststuff .postbox h3, #poststuff .postbox .handlediv').click(function(){
				$(this).parents('.postbox').toggleClass('closed');
			});
		return;

			$('#poststuff .postbox').addClass('closed')
				.first().removeClass('closed');
		});
		</script>
		<?php
	}

	public function do_settings_sections($page)
	{
		global $wp_settings_sections, $wp_settings_fields;

		if ( !isset($wp_settings_sections) || !isset($wp_settings_sections[$page]) )
			return;

		foreach ( (array) $wp_settings_sections[$page] as $section )
		{
			?>
			<div class="postbox">
				<div class="handlediv"><br></div>
				<h3><span><?php echo $section['title']; ?></span></h3>
				<div class="inside">
					<?php
						call_user_func($section['callback'], $section);
						if (isset($wp_settings_fields) && isset($wp_settings_fields[$page]) && isset($wp_settings_fields[$page][$section['id']]) ) :
					?>
					<table class="form-table">
					<?php do_settings_fields($page, $section['id']); ?>
					</table>
					<?php
						endif;
					?>
				</div>
			</div>
			<?php
		}
	}


	public function get_field_value($field_name, $default = false)
	{
		return get_timthumb_option($field_name, $default);
	}

	public function get_field_name($field_name)
	{
		return "timthumb_options[{$field_name}]";
	}

	public function get_field_id($field_id)
	{
		return 'timthumb_' . $field_id;
	}


	public function show_field($args)
	{
		extract($args);

		switch($field['type'])
		{
			case 'boolean':
				$this->_show_field_boolean($field_id, $field);
				break;

			case 'textarea':
				$this->_show_field_textarea($field_id, $field);
				break;

			case 'text':
			case 'numeric':
				$this->_show_field_text($field_id, $field);
				break;

			default:
				return false;
		}

		// Field description
		if (isset($field['desc']) && $field['desc'])
		{
			printf('<p class="description">%s</p>', $field['desc']);
		}
	}

	protected function _show_field_boolean($field_id, $field)
	{
		$value = $this->get_field_value($field_id, $field['default']);

		printf('<input name="%s" type="hidden" value="" />',
				$name = $this->get_field_name($field_id)
			);
		printf('<input name="%s" id="%s" class="%s" type="checkbox" value="1" %s />',
				$name    = $this->get_field_name($field_id),
				$id      = $this->get_field_id($field_id),
				$class   = 'checkbox',
				$checked = checked($value, true, false)
			);
	}

	protected function _show_field_textarea($field_id, $field)
	{
		$value = $this->get_field_value($field_id, $field['default']);

		printf('<textarea name="%s" id="%s" class="%s" rows="%d">%s</textarea>',
				$name  = $this->get_field_name($field_id),
				$id    = $this->get_field_id($field_id),
				$class = 'large-text',
				$rows  = 3,
				$value = esc_textarea($value)
			);
	}

	protected function _show_field_text($field_id, $field)
	{
		$value = $this->get_field_value($field_id, $field['default']);

		switch ($field['type'])
		{
			case 'numeric':
				$class = 'small-text';
				break;

			default:
				$class = 'regular-text';
				break;
		}

		printf('<input name="%s" id="%s" type="text" class="%s" value="%s" />',
				$name  = $this->get_field_name($field_id),
				$id    = $this->get_field_id($field_id),
				$class,
				$value = esc_attr($value)
			);
	}

}


TimThumb_Settings_Page::$sections = $GLOBALS['TimThumb_Settings_Sections'];
TimThumb_Settings_Page::$fields   = $GLOBALS['TimThumb_Settings_Fields'];

$timthumb_options_page = new TimThumb_Settings_Page();


?>