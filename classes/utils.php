<?php
if(!class_exists("MManiaUtils"))
{
  class MManiaUtils
  {
    //Constructor
    public function MManiaUtils()
    {
      //Uhhh nothing here for now
    }
    
    //Function to filter the output of an <input type="text" /> field
    public static function tb_output($string)
    {
      return esc_attr(stripslashes($string));
    }
    
    //Function to filter the output of an <textarea> field
    public static function ta_output($string)
    {
      return esc_textarea(stripslashes($string));
    }
    
    //Gets the permalink to the page the messages are displayed on
    public static function get_plugin_url()
    {
      $page_id = MManiaDB::get_plugin_page_id();
      
      if($page_id)
        return get_permalink($page_id);
      
      return '';
    }
    
    //Get the delimiter
    public static function get_delim()
    {
      global $wp_rewrite;
      
      if($wp_rewrite->using_permalinks())
        return '?';
      else
        return '&';
    }
  } //End class
} //End if
?>
