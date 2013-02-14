<?php
if(!class_exists("MManiaController"))
{
  class MManiaController
  {
    //Constructor
    public function MManiaController()
    {
      //Uhhh nothing here for now
    }
    
    //Static vars
    public static $plugin_url = '';
    public static $action_url = '';
    
    public static function load_hooks()
    {
      add_action('init', 'MManiaController::load_plugin_urls');
      add_action('admin_init', 'MManiaController::maybe_do_db');
      add_action('admin_menu', 'MManiaController::add_menu_page');
      add_shortcode('MMania', 'MManiaController::front_page');
      add_action('admin_enqueue_scripts', 'MManiaController::enqueue_admin_scripts');
      add_action('wp_enqueue_scripts', 'MManiaController::enqueue_front_scripts');
    }
    
    public static function load_plugin_urls()
    {
      self::$plugin_url = MManiaUtils::get_plugin_url();
      self::$action_url = self::$plugin_url.MManiaUtils::get_delim().'mmania_action=';
    }
    
    //Check if the DB needs to be created/updated
    public static function maybe_do_db()
    {
      global $mmania_db;
      
      $previous_version = get_option($mmania_db->db_version_name, 0);
      
      if($mmania_db->db_version > $previous_version)
      {
        $mmania_db->do_db();
        update_option($mmania_db->db_version_name, $mmania_db->db_version);
      }
    }
    
    //Add the menu page in the dashboard
    public static function add_menu_page()
    {
      add_options_page('Message Mania', 'Message Mania', 'administrator', 'mmania-options', 'MManiaController::admin_options_page');
    }
    
    //Show the admin options page
    public static function admin_options_page()
    {
      global $mmania_db;
      
      $saved = $mmania_db->maybe_save_options();
      
      require(MMANIA_VIEWS_PATH.'/admin/options_page.php');
    }
    
    public static function enqueue_admin_scripts($hook)
    {
      //Let's be responsible human beings and only load our shiz where we need it
      if(strstr($hook, 'mmania') !== false)
      {
        wp_enqueue_style('mmania_admin_css', MMANIA_CSS_URL.'/admin.css');
        wp_enqueue_script('mmania_admin_js', MMANIA_JS_URL.'/admin.js', array('jquery'));
      }
    }
    
    public static function enqueue_front_scripts()
    {
      global $post, $mmania_db, $wp_scripts;
      $ui = $wp_scripts->query('jquery-ui-core');
      $url = "//ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/smoothness/jquery-ui.css";
      
      $inbox_page_id = $mmania_db->get_plugin_page_id();
      
      //Let's be responsible human beings and only load our shiz where we need it
      if(isset($post) && isset($post->ID) && $post->ID == $inbox_page_id)
      {
        wp_enqueue_style('mmania-jquery-ui-smoothness', $url);
        wp_enqueue_style('mmania_inputosaurus_css', MMANIA_CSS_URL.'/inputosaurus.css');
        wp_enqueue_style('mmania_front_css', MMANIA_CSS_URL.'/front.css');
        wp_enqueue_script('mmania_inputosaurus_js', MMANIA_JS_URL.'/inputosaurus.js', array('jquery', 'jquery-ui-widget', 'jquery-ui-autocomplete'));
        wp_enqueue_script('mmania_front_js', MMANIA_JS_URL.'/front.js', array('jquery'));
      }
    }
    
    public static function front_page()
    {
      global $user_ID;
      
      ob_start();
      
      $action = (isset($_GET['mmania_action']) && !empty($_GET['mmania_action']))?$_GET['mmania_action']:false;
      
      switch($action)
      {
        case 'advanced_compose':
          self::show_advanced_compose();
          break;
        default:
          self::show_inbox();
          break;
      }
      
      return ob_get_clean();
    }
    
    public static function show_inbox()
    {
      $body_file = 'inbox.php';
      require(MMANIA_VIEWS_PATH.'/front/template.php');
    }
    
    public static function show_advanced_compose()
    {
      $body_file = 'compose.php';
      require(MMANIA_VIEWS_PATH.'/front/template.php');
    }
  } //End class
} //End if
?>
