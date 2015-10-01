<?php

class theme_options_page {
	static $args;

	function __construct($args) {
		self::$args = $args;
		add_menu_page($args['page_title'], $args['menu_title'], $args['capability'], $args['slug'], array('theme_options_page', 'create_options_page'), false, $args['position']);
		add_action('admin_init', array('theme_options_page', 'admin_init'));
	}
	
	function create_options_page() {
	?>
	<div class="wrap">
		<h2><?php echo self::$args['page_title']; ?></h2>
		<form action="options.php" method="post">
			<?php 
				settings_fields(self::$args['option_group']);
				do_settings_sections(self::$args['slug']); ?>
 
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
	}
	
	function admin_init() {
		foreach(self::$args['sections'] as $section) {
			add_settings_section($section['id'], $section['title'], $section['text_function'], self::$args['slug']);
			foreach($section['fields'] as $field) {
				register_setting( self::$args['option_group'], $field['name']);
				add_settings_field(
					$field['name'], 
					$field['label'], 
					array('theme_options_page', 'create_input'), 
					self::$args['slug'], 
					$section['id'], 
					array(
						'id' => $field['name'], 
						'type' => $field['type'], 
						'field' => $field
					)
				);
			}
		}
	}
	
	function section_text() {
		echo '<p>Site wide settings.</p>';
	}
	
	function create_input($args) {
		$field = $args['field'];
		
		$type = $field['type'];
		$className = 'theme_option_' . $type;
		if (class_exists($className)) {
			$fld = new $className($field['name'], $field);
			$fld->meta_content();
		}
	}
}

abstract class theme_option_input {
	var $options_name;
	var $field;
	var $label;
	var $name;
	var $value;
	
	function __construct($options_name, $field) {
		$this->options_name = $options_name;
		$this->field = $field;
		$this->name = $this->field['name'];
	}
	
	public function meta_content() {
		$this->label = $this->field['label'];
		$this->value = get_option($this->name);
		$this->output();
	} 
	
	public function output() {
		$value = htmlspecialchars($this->value);
		echo <<<EOS
<input type="hidden" name="{$this->name}" value="$value" />
EOS;
	}
}

class theme_option_text extends theme_option_input {
	
	public function output() {
		$value = htmlspecialchars($this->value);
		echo <<<EOS
	<input type="text" id="$this->name" name="{$this->name}" value="$value" size="60" />
EOS;
	}
}

class theme_option_textarea extends theme_option_input {
	
	public function output() {
		$value = htmlspecialchars($this->value);
		echo <<<EOS
	<textarea id="$this->name" name="{$this->name}" style="width: 450px; height: 100px;resize: none;">$value</textarea>
EOS;
	}
}

class theme_option_html extends theme_option_input {
	
	public function output() {
		wp_editor($this->value, $this->name);
	}
}

class theme_option_checkbox extends theme_option_input {
	
	public function output() {
		$checked = '';
		if ($this->value == 'yes')
			$checked = 'checked="checked"';
		
		echo <<<EOS
	<input type="checkbox" name="$this->name" id="$this->name" value="yes" $checked />
EOS;
	}
}

/* Image here */

/* File here */

class theme_option_dropdown extends theme_option_input {
	
	public function output() {
		$options = "";
		$multiple = false;
		if (isset($this->field['multiple']) && $this->field['multiple']) {
			$multiple = true;
		} else {
			if (isset($this->field['include_empty']) && $this->field['include_empty']) {
				$options .= '<option value=""></option>';
			}
		}
		

		foreach($this->field['options'] as $value => $label) {
			$selected = '';
			if ($value == $this->value || (is_array($this->value) && in_array($value, $this->value))) {
				$selected = 'selected="selected" ';
			}
			$options .= '<option ' . $selected . 'value="' . htmlspecialchars($value) . '">' . htmlspecialchars($label) . '</option>';
		}
		
		$select_multiple = "";
		$name = $this->name;
		if ($multiple) {
			$select_multiple = 'multiple="multiple"';
			$name .= '[]';
		}
		
		echo <<<EOS
	<select name="$name" id="$this->name" $select_multiple>
		$options
	</select>
EOS;
	}
}

class theme_option_dropdown_sql extends theme_option_dropdown {
	public function output() {
		global $wpdb;
		
	    $rows = $wpdb->get_results($this->field['query']);
		
		$options = array();
		foreach($rows as $row) {
			$options[$row->value] = $row->label;
		}
		$this->field['options'] = $options;
		
		
		parent::output();	
	} 
}

class theme_option_dropdown_nextgen_gallery extends theme_option_dropdown_sql {
	public function output() {
		global $wpdb;
		$this->field['query'] = "SELECT `gid` as `value`, `title` as `label` FROM {$wpdb->prefix}ngg_gallery ORDER BY `title`";
		
		parent::output();
	}
}

class theme_option_dropdown_posts extends theme_option_dropdown_sql {
	public function output() {
		global $wpdb;
		if (!empty($this->field['post_type'])) {
			$post_type = $this->field['post_type'];
		} else {
			$post_type = 'post';
		}
		
		$where = '';
		if (isset($this->field['children_only']) && $this->field['children_only']) {
			$where = ' AND post_parent != 0';
		} elseif (isset($this->field['child_of'])) {
			$where = ' AND post_parent = ' . $this->field['child_of']; 
		}
		
		$this->field['query'] = "SELECT `ID` as `value`, `post_title` as `label` FROM {$wpdb->prefix}posts WHERE `post_type` = '$post_type' AND `post_status` = 'publish' $where ORDER BY `post_title`";
		
		parent::output();
	}
}
/*
 * Media
 */
class theme_option_media extends theme_option_input {
	public function output() {
		wp_enqueue_media();
		
		$dimensions = '';
		if ($this->field['width'] && $this->field['height']) {
			$width = $this->field['width'];
			$height = $this->field['height'];
			$dimensions = "($width x $height)";
		}
		
		$style = '';
		if (!$this->value) {
			$style = ' style="display: none;"';
		}
		
			echo <<<EOS
		<img id="image-$this->name" src="$this->value" width="450" />
		<div class="uploader">
			<input type="hidden" name="$this->name" id="$this->name" value="$this->value" $style />
			<input class="button upload" id="button-$this->name" value="Upload" />
			<input class="button remove" id="remove-$this->name" value="Remove" $style />
		</div>
<script>
jQuery(function() {
	  	var _custom_media = true,
	    	_orig_send_attachment = wp.media.editor.send.attachment;
	    	
		jQuery('.uploader .button.remove').click(function(e) {
			var button = jQuery(this);
			var id = button.attr('id').replace('remove-', '');
			jQuery("#"+id).val('');
			jQuery("#image-"+id).attr('src', '').hide();
			jQuery(this).hide();
		});
	  	jQuery('.uploader .button.upload').click(function(e) {
		    var send_attachment_bkp = wp.media.editor.send.attachment;
		    var button = jQuery(this);
		    var id = button.attr('id').replace('button-', '');
		    _custom_media = true;
		    wp.media.editor.send.attachment = function(props, attachment){
	      		if ( _custom_media ) {
	        		jQuery("#"+id).val(attachment.url);
	        		jQuery("#image-"+id).attr('src', attachment.url).show();
	        		jQuery("#remove-"+id).show();
	      		} else {
	        		return _orig_send_attachment.apply( this, [props, attachment] );
	      		};
	    	}
	
		    wp.media.editor.open(button);
		    return false;
	  	});
	
		jQuery('.add_media').on('click', function(){
			_custom_media = false;
	  	});
});

</script>
	
EOS;
	}
}