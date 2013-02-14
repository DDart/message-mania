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
    
    public static function load_hooks()
    {
      add_action('admin_init', 'MManiaController::maybe_do_db');
      add_action('admin_menu', 'MManiaController::add_menu_page');
      add_shortcode('MMania', 'MManiaController::front_page');
      add_action('admin_enqueue_scripts', 'MManiaController::enqueue_admin_scripts');
      add_action('wp_enqueue_scripts', 'MManiaController::enqueue_front_scripts');
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
      global $post, $mmania_db;
      
      $inbox_page_id = $mmania_db->get_page_id();
      
      //Let's be responsible human beings and only load our shiz where we need it
      if(isset($post) && isset($post->ID) && $post->ID == $inbox_page_id)
      {
        wp_enqueue_style('mmania_front_css', MMANIA_CSS_URL.'/front.css');
        wp_enqueue_script('mmania_front_js', MMANIA_JS_URL.'/front.js', array('jquery'));
      }
    }
    
    public static function front_page()
    {
      ob_start();
      
      $action = (isset($_GET['mmania_action']) && !empty($_GET['mmania_action']))?$_GET['mmania_action']:false;
      
      switch($action)
      {
        default:
          self::show_inbox();
          break;
      }
      
      return ob_get_clean();
    }
    
    public static function show_inbox()
    {
      require(MMANIA_VIEWS_PATH.'/front/inbox.php');
    }
  } //End class
} //End if
?>
