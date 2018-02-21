<?php

/*
Plugin Name: Hello Dolly - Copy
Plugin URI: https://www.bbenefield.com
Description: Copy of the infamous Hello Dolly plugin provided by default from WordPress
Author: Brandon Benefield
Author URI: https://www.bbenefield.com
Version: 1.0.0
*/

if (!defined('ABSPATH')) {
    exit();
}

final class BBHelloDolly
{
  public static function create_db_table() {
    global $wpdb;
    $table_name    = $wpdb->prefix.'bb_hello_dolly';
    $table_charset = $wpdb->get_charset_collate();
    $sql           = "CREATE TABLE IF NOT EXISTS $table_name (
                      id tinyint(1) NOT NULL AUTO_INCREMENT,
                      text text NOT NULL,
                      PRIMARY KEY  (id)
                      ) $table_charset;";
            
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta($sql);
  }
  
  public static function delete_db_table() {
    global $wpdb;
    $table_name = $wpdb->prefix.'bb_hello_dolly';
    $sql        = "DROP TABLE IF EXISTS $table_name";
    
    $wpdb->query($sql);
  }
  
  public static function write_to_db($lyrics) {
    global $wpdb;
    $table_name = $wpdb->prefix.'bb_hello_dolly';
    // $san_lyrics = sanitize_textarea_field($lyrics);
    $san_lyrics = esc_html($lyrics);
    $sql        = "SELECT
                   id, text
                   FROM
                   $table_name;";
    $result     = $wpdb->get_results($sql);
    
    if (count($result) === 0) {
      $sql = "INSERT INTO $table_name (
              id, text)
              VALUES (
              NULL, '$san_lyrics');";
      
      $wpdb->query($sql);
    } else {
        $sql = "UPDATE
                $table_name
                SET
                text = '$san_lyrics';";
                
        $wpdb->query($sql);
    }
            
  }
  
  public static function hello_dolly_html() {
    wp_enqueue_style('bb-hello-dolly-css', plugin_dir_url(__FILE__).'assets/style.css');
    
    echo '<div class="hello-dolly-wrapper-home">';
      echo '<h1>Hello Dolly - Copy</h1>';
      
      echo '<p>Here you can go ahead and change the lyrics</p>';
      
      echo '<form action="" class="hello-dolly-form" method="POST">';
        echo '<textarea class="hello-dolly-textarea" name="hello_dolly_textarea"></textarea>';
        echo '<button class="hello-dolly-button" name="hello_dolly_submit" type="submit">Submit</button>';
      echo '</form>';
      
    echo '</div>';
  }
  
  public static function output_lyrics() {
    global $wpdb;
    $table_name = $wpdb->prefix.'bb_hello_dolly';
    $sql = "SELECT
            text
            FROM
            $table_name;";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    
    if ($result) {
      $san_lyrics = explode("\n", sanitize_textarea_field( $result[0]['text'] ) );
      
      echo $san_lyrics[ rand(0, count($san_lyrics) - 1 ) ];
    } else {
        echo 'Woops, I think I forgot the lyrics...\n';
        echo 'Try contacting the <a href="//bbenefield.com/#contact">plugin creator</a>.';
    }
  }

  public static function add_menu_func() {
    add_menu_page('Hello Dolly', 'Hello Dolly', 'manage_options', 'hello_dolly', 'BBHelloDolly::hello_dolly_html');
  }
}
add_action('admin_menu', 'BBHelloDolly::add_menu_func');

// Check if user has submitted new lyrics
if (isset($_POST['hello_dolly_submit']) && isset($_POST['hello_dolly_textarea'])) {
  $hello_dolly_textarea = $_POST['hello_dolly_textarea'];
  $san_textarea = sanitize_textarea_field($hello_dolly_textarea);
  
  BBHelloDolly::write_to_db($san_textarea);
}

// Plugin Activation
register_activation_hook(__FILE__, 'BBHelloDolly::create_db_table');

//Plugin Deactivation
register_deactivation_hook(__FILE__, 'BBHelloDolly::delete_db_table');

// Shortcode
add_shortcode('Hello_Dolly_Copy', 'BBHelloDolly::output_lyrics');
