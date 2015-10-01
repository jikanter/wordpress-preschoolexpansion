<?php

/*
 * Copyright (c) 2015 Jordan Kanter. All rights reserved. 
 * Adapted from floodlight design's custom_fields.class.php
 */

class custom_post_type {

  const CLASS_NAME = 'custom_post_type';
  const SLUG = 'custom';
  const POST_NAME_SINGLE = 'Custom Post';
  const POST_TYPE_NAME = 'Custom Posts';
  const META_BOX_NAME = 'Information';

  static $fields;

  public static function load_fields() {
    $class_name = get_called_class();
    $class_name::$fields = array();
  }

  function __construct() {
    $class_name = get_called_class();
    add_action('init', array($class_name, 'create_post_type'));
    add_action('admin_init', array($class_name, 'admin_init'));
    add_action('save_post', array($class_name, 'save'));

    $class_name::load_fields();
  }

  public static function create_post_type() {
    $class_name = get_called_class();
    register_post_type($class_name, array(
        'labels' => array(
            'name' => $class_name::POST_TYPE_NAME,
            'singular_name' => $class_name::POST_NAME_SINGLE,
            'add_new' => 'Add New ' . $class_name::POST_NAME_SINGLE,
            'add_new_item' => 'Add New ' . $class_name::POST_NAME_SINGLE,
            'edit_item' => 'Edit ' . $class_name::POST_NAME_SINGLE,
            'new_item' => 'New ' . $class_name::POST_NAME_SINGLE,
            'view_item' => 'View ' . $class_name::POST_NAME_SINGLE,
            'menu_name' => $class_name::POST_TYPE_NAME
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'revisions', 'page-attributes'),
        'has_archive' => true,
        'hierarchical' => true,
            )
    );
  }

  public static function admin_init() {
    $class_name = get_called_class();
    add_meta_box($class_name . "-meta-content", $class_name::META_BOX_NAME, array($class_name, 'meta_content'), $class_name, "normal", "high");
  }

  public static function meta_content() {
    $class_name = get_called_class();
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), $class_name . '_nonce');

    custom_fields::meta_content($post->ID, $class_name::$fields);
  }

  public static function save($post_id) {
    $class_name = get_called_class();
    if (!isset($_POST[$class_name . '_nonce']) || !wp_verify_nonce($_POST[$class_name . '_nonce'], plugin_basename(__FILE__))) {
      return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      return $post_id;

    custom_fields::save($post_id, $class_name::$fields);

    return $post_id;
  }

  public static function get() {
    global $post;
    $post_id = $post->ID;
  }
  
  public static function asJsonP($callbackName) { 
    return $callbackName . '(' . json_encode($this) . ')';
  }

}

class custom_fields {

  public static function meta_content($post_id, $fields) {
    echo <<<peg
		<table class="form-table">
peg;
    foreach ($fields as $field) {
      $type = $field['type'];
      $className = 'custom_fields_' . $type;
      if (class_exists($className)) {
        $fld = new $className($post_id, $field);
        $fld->meta_content();
      }
    }
    echo <<<peg
		</table>
peg;
  }

  public static function save($post_id, $fields) {
    foreach ($fields as $field) {
      $type = $field['type'];
      $className = 'custom_fields_' . $type;
      if (class_exists($className)) {
        $fld = new $className($post_id, $field);
        $fld->save();
      }
    }
  }

  public static function get_upload_dir($dir) {
    $upload_dir = wp_upload_dir();

    $dir = $upload_dir['path'] . '/' . $dir . '/';
    if (!is_dir($dir)) {
      mkdir($dir);
    }

    return $dir;
  }

  public static function get_image_dir($dir) {
    $upload_dir = wp_upload_dir();

    $dir = $upload_dir['url'] . '/' . $dir . '/';
    return $dir;
  }

  public static function remove_image($upload_dir, $file) {
    $dir = self::get_upload_dir($upload_dir);

    if (file_exists($dir . $file))
      unlink($dir . $file);
    if (file_exists($dir . $file . '-circular.png'))
      unlink($dir . $file . '-circular.png');
  }

  /**
   * Uploads an image and fixes to a specific size.
   * @params	$_FILE	being uploaded
   * @returns	mixed	destination path as success, false on failure
   */
  public static function upload_image_set_both($file, $upload_dir, $max_width, $max_height, $add_circular = false) {
    $quality = 90;

    if (isset($file)) {
      if ($file['error'] == 0) {
        //temp name
        $tmp = $file['tmp_name'];

        $dest = substr(md5(time()), 1, 12) . $file['name'];

        $dir = self::get_upload_dir($upload_dir);

        //calculate new dimensions
        if (list($width, $height, $type) = getimagesize($tmp)) {
          $src_x = 0;
          $src_y = 0;
          $src_w = $width;
          $src_h = $height;

          $width_ratio = $width / $max_width;
          $height_ratio = $height / $max_height;

          if ($width_ratio <= $height_ratio) {
            //use full width
            $image_width = $max_width;

            $dst_x = 0;
            $dst_w = $max_width;
            $dst_h = $height / $width_ratio; //714

            $image_height = $dst_h;
            if ($image_height > $max_height)
              $image_height = $max_height;

            $dst_y = -($dst_h - $image_height) / 2;
          } else {
            //use full height
            $image_height = $max_height;

            $dst_y = 0;
            $dst_h = $max_height;
            $dst_w = $width / $height_ratio; //714

            $image_width = $dst_w;
            if ($image_width > $max_width)
              $image_width = $max_width;

            $dst_x = -($dst_w - $image_width) / 2;
          }

          $image_new = imagecreatetruecolor($image_width, $image_height);

          if ($type == IMAGETYPE_JPEG) {
            $image_tmp = imagecreatefromjpeg($tmp);
            imagecopyresampled($image_new, $image_tmp, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
            imagejpeg($image_new, $dir . $dest, $quality);
          } elseif ($type == IMAGETYPE_PNG) {
            $image_tmp = imagecreatefrompng($tmp);
            imagealphablending($image_new, false);
            imagesavealpha($image_new, true);
            $transparent = imagecolorallocatealpha($image_new, 255, 255, 255, 127);
            imagefilledrectangle($image_new, 0, 0, $image_width, $image_height, $transparent);
            imagecopyresampled($image_new, $image_tmp, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
            imagepng($image_new, $dir . $dest);
          } elseif ($type == IMAGETYPE_GIF) {
            $image_tmp = imagecreatefromgif($tmp);

            $trnprt_indx = imagecolortransparent($image_tmp);

            // If we have a specific transparent color
            if ($trnprt_indx >= 0) {
              // Get the original image's transparent color's RGB values
              $trnprt_color = imagecolorsforindex($image_tmp, $trnprt_indx);
              // Allocate the same color in the new image resource
              $trnprt_indx = imagecolorallocate($image_new, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
              // Completely fill the background of the new image with allocated color.
              imagefill($image_new, 0, 0, $trnprt_indx);
              // Set the background color for new image to transparent
              imagecolortransparent($image_new, $trnprt_indx);
            }


            imagecopyresampled($image_new, $image_tmp, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
            imagegif($image_new, $dir . $dest);
          }

          if ($add_circular) {
            $image_circular = imagecreatetruecolor($image_width, $image_height);
            imagealphablending($image_circular, true);
            imagesavealpha($image_new, true);
            imagecopyresampled($image_circular, $image_new, 0, 0, 0, 0, $image_width, $image_height, $image_width, $image_height);

            $mask = imagecreatetruecolor($image_width, $image_height);
            $mask_transparent = imagecolorallocate($mask, 255, 0, 255);
            imagefilledrectangle($mask, 0, 0, $image_width, $image_height, $mask_transparent);

            $transparent = imagecolorallocate($mask, 255, 0, 0);
            imagecolortransparent($mask, $transparent);
            imagefilledellipse($mask, $image_width / 2, $image_height / 2, $image_width, $image_height, $transparent);


            imagecopymerge($image_circular, $mask, 0, 0, 0, 0, $image_width, $image_height, 100);
            imagecolortransparent($image_circular, $mask_transparent);
            imagepng($image_circular, $dir . $dest . '-circular.png');
          }

          return $dest;
        }
      }
    }

    return false;
  }

  public static function upload_file($file, $upload_dir) {
    if (isset($file)) {
      if ($file['error'] == 0) {
        //temp name
        $tmp = $file['tmp_name'];

        $dest = substr(md5(time()), 1, 12) . $file['name'];

        $dir = self::get_upload_dir($upload_dir);

        move_uploaded_file($tmp, $dir . $dest);

        return $dest;
      }
    }

    return false;
  }

}

/**
 * Generic custom field input class
 */
abstract class custom_fields_input {

  var $post_id;
  var $field;
  var $label;
  var $name;
  var $value;

  function __construct($post_id, $field) {
    $this->post_id = $post_id;
    $this->field = $field;
    $this->name = $this->field['name'];
  }

  public function meta_content() {
    $this->label = $this->field['label'];
    $this->value = get_post_meta($this->post_id, $this->name, true);
    $this->output();
  }

  public function output() {
    $value = htmlspecialchars($this->value);
    echo <<<EOS
<input type="hidden" name="$this->name" value="$value" />
EOS;
  }

  public function save() {
    if (isset($_POST[$this->name]))
      $this->set_value($_POST[$this->name]);
  }

  public function set_value($value) {
    update_post_meta($this->post_id, $this->name, $value);
  }

}

/**
 * Textbox
 */
class custom_fields_text extends custom_fields_input {

  public function output() {
    $value = htmlspecialchars($this->value);
    echo <<<EOS
<tr>
	<th>
		<label for="$this->name">$this->label</label><br />
	</th>
	<td>
		<input type="text" id="$this->name" name="$this->name" value="$value" style="width: 100%" />
	</td>
</tr>
EOS;
  }

}

class custom_fields_textarea extends custom_fields_input {

  public function output() {
    $value = htmlspecialchars($this->value);
    echo <<<EOS
<tr>
	<th>
		<label for="$this->name">$this->label</label><br />
	</th>
	<td>
		<textarea id="$this->name" name="$this->name" style="width: 450px; height: 100px;resize: none;">$value</textarea>
	</td>
</tr>
EOS;
  }

}

/**
 * HTML Area
 */
class custom_fields_html extends custom_fields_input {

  public function output() {
    echo <<<EOS
<tr>
	<th>
		<label for="$this->name">$this->label;</label><br />
	</th>
	<td>
EOS;
    wp_editor($this->value, $this->name);
    echo <<<EOS
	</td>
</tr>
EOS;
  }

}

/**
 * Checkbox
 */
class custom_fields_checkbox extends custom_fields_input {

  public function output() {
    $checked = '';
    if ($this->value == 'yes')
      $checked = 'checked="checked"';

    echo <<<EOS
<tr>
	<th>
		<input type="checkbox" name="$this->name" id="$this->name" value="yes" $checked />
	</th>
	<td>
		<label for="$this->name">$this->label</label>
	</td>
</tr>
EOS;
  }

  public function save() {
    if (isset($_POST[$this->name]))
      $this->set_value($_POST[$this->name]);
    else
      $this->set_value('no');
  }

}

/*
 * Image
 */

class custom_fields_image extends custom_fields_input {

  public function output() {
    if (strlen($this->value) > 0) :
      $image_dir = custom_fields::get_image_dir($this->field['directory']);
      $img = $image_dir . $this->value;
      if (isset($this->field['make_circular']) && $this->field['make_circular']) {
        $img .= "-circular.png";
      }
      $width = $this->field['width'];
      $height = $this->field['height'];
      echo <<<EOS
<tr>
	<th>
		<span class="faux-label">$this->label ($width x $height)</span><br />
	</th>
	<td>
		<input id="delete_$this->name" name="delete_$this->name" type="checkbox" /> <label for="delete_$this->name">Delete</label><br />
		<img src="$img" />
	</td>
</tr>
EOS;
    else:
      $width = $this->field['width'];
      $height = $this->field['height'];
      echo <<<EOS
<tr>
	<th>
		<label for="$this->name">$this->label ($width x $height)</label><br />
	</th>
	<td>
		<input type="file" id="$this->name" name="$this->name" />
		<input type="button" value="Upload" onclick="document.post.enctype = 'multipart/form-data'; document.post.submit();" />
	</td>
</tr>
EOS;
    endif;
  }

  public function save() {
    if (isset($_POST['delete_' . $this->name])) {
      $last_data = get_post_meta($this->post_id, $this->name, true);
      if ($last_data == "")
        $last_data = false;
      if ($last_data !== false) {
        custom_fields::remove_image($this->field['directory'], $last_data);
        update_post_meta($this->post_id, $this->name, "");
      }
    }
    if (isset($_FILES[$this->name])) {
      $file = $_FILES[$this->name];
      $make_circular = (isset($this->field['make_circular'])) ? $this->field['make_circular'] : false;

      $data = custom_fields::upload_image_set_both($file, $this->field['directory'], $this->field['width'], $this->field['height'], $make_circular);
      $wp_upload_dir = wp_upload_dir();
      $directory_used = $wp_upload_dir['url'] . '/' . $this->field['directory'];

      if (strlen($data) > 0) {
        update_post_meta($this->post_id, $this->name, $data);
        update_post_meta($this->post_id, $this->name . '_dir', $directory_used);
      }

      unset($_FILES[$this->name]);
    }
  }

}

/*
 * File
 */

class custom_fields_file extends custom_fields_input {

  public function output() {
    if (strlen($this->value) > 0) :
      $dir = custom_fields::get_image_dir($this->field['directory']);
      $file = $dir . $this->value;
      echo <<<EOS
<tr>
	<th>
		<span class="faux-label">$this->label</span><br />
	</th>
	<td>
		<input id="delete_$this->name" name="delete_$this->name" type="checkbox" /> <label for="delete_$this->name">Delete</label><br />
		<a href="$file" target="_blank">View</a>
	</td>
</tr>
EOS;
    else:
      echo <<<EOS
<tr>
	<th>
		<label for="$this->name">$this->label</label><br />
	</th>
	<td>
		<input type="file" id="$this->name" name="$this->name" />
		<input type="button" value="Upload" onclick="document.post.enctype = 'multipart/form-data'; document.post.submit();" />
	</td>
</tr>
EOS;
    endif;
  }

  public function save() {
    if (isset($_POST['delete_' . $this->name])) {
      $last_data = get_post_meta($this->post_id, $this->name, true);
      if ($last_data == "")
        $last_data = false;
      if ($last_data !== false) {
        custom_fields::remove_image($this->field['directory'], $last_data);
        update_post_meta($this->post_id, $this->name, "");
      }
    }
    if (isset($_FILES[$this->name])) {
      $file = $_FILES[$this->name];
      $data = custom_fields::upload_file($file, $this->field['directory']);

      if (strlen($data) > 0)
        update_post_meta($this->post_id, $this->name, $data);

      unset($_FILES[$this->name]);
    }
  }

}

/**
 * Dropdown
 */
class custom_fields_dropdown extends custom_fields_input {

  public function output() {
    $options = "";
    $multiple = false;
    $style = "";
    if (isset($this->field['multiple']) && $this->field['multiple']) {
      $multiple = true;
      $style = ' style="height: 80px" ';
    }

    if (isset($this->field['include_empty']) && $this->field['include_empty']) {
      $options .= '<option value=""></option>';
    }

    foreach ($this->field['options'] as $value => $label) {
      $selected = '';
      if ($value == $this->value || (is_array($this->value) && in_array($value, $this->value))) {
        $selected = 'selected="selected" ';
      }
      if (strlen($label) > 20) {
        $label = substr($label, 0, 30) . '...';
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
<tr>
	<th>
		<label for="$this->name">$this->label</label><br />
	</th>
	<td>
		<select $style name="$name" id="$this->name" $select_multiple>
			$options
		</select>
	</td>
</tr>
EOS;
  }

  public function save() {
    if (isset($_POST[$this->name]))
      $this->set_value($_POST[$this->name]);
    else
      $this->set_value('');
  }

}

/**
 * Dropdown - SQL
 */
class custom_fields_dropdown_sql extends custom_fields_dropdown {

  public function output() {
    global $wpdb;

    $rows = $wpdb->get_results($this->field['query']);

    $options = array();
    foreach ($rows as $row) {
      $options[$row->value] = $row->label;
    }
    $this->field['options'] = $options;


    parent::output();
  }

}

/**
 * Dropdown - NextGEN Gallery
 */
class custom_fields_dropdown_nextgen_gallery extends custom_fields_dropdown_sql {

  public function output() {
    global $wpdb;
    $this->field['query'] = "SELECT `gid` as `value`, `title` as `label` FROM {$wpdb->prefix}ngg_gallery ORDER BY `title`";

    parent::output();
  }

}

/**
 * Dropdown - Posts
 */
class custom_fields_dropdown_posts extends custom_fields_dropdown_sql {

  public function output() {
    global $wpdb;
    $post_type = $this->field['post_type'];

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

class custom_fields_media extends custom_fields_input {

  public function output() {
    wp_enqueue_media();
    wp_enqueue_script('custom_fields_media', get_bloginfo('template_directory') . '/classes/custom_fields.js');

    $dimensions = '';
    if ($this->field['width'] && $this->field['height']) {
      $width = $this->field['width'];
      $height = $this->field['height'];
      $dimensions = " ($width x $height)";
    }

    $img_url = wp_get_attachment_url($this->value);

    $style = 'style="width: 70px;"';
    if (!$img_url) {
      $style = ' style="display: none; width: 70px;"';
    }

    echo <<<EOS
<tr>
	<th scope="row">$this->label$dimensions</th>
	<td>
		<img id="image-$this->name" src="$img_url" style="max-width: 450px; max-height: 200px" />
		<div class="uploader">
			<input type="hidden" name="$this->name" id="$this->name" value="$this->value" $style />
			<input class="button upload" id="button-$this->name" value="Upload" style="width: 65px;" />
			<input class="button remove" id="remove-$this->name" value="Remove" $style />
		</div>
	</td>
</tr>
EOS;
  }

}

/*
 * Select Orderer
 */

class custom_fields_orderer extends custom_fields_input {

  public function output() {
    wp_enqueue_script('custom_fields_media', get_bloginfo('template_directory') . '/classes/custom_fields.js');
    echo <<<EOS
<script>
jQuery(function() {
	orderer.init('{$this->name}', '{$this->field['target']}');
});
</script>
<tr>
	<th scope="row">$this->label</th>
	<td>
		<table id="$this->name">
			<tbody>
EOS;
    foreach ($this->value as $key => $value) {
      echo <<<EOS
<tr id="$this->name-$key">
	<th></th>
	<td><input type="text" name="{$this->name}[$key]" value="$value" /></td>
</tr>
EOS;
    }
    echo <<<EOS
			</tbody>
		</table>
	</td>
</tr>
EOS;
  }

}