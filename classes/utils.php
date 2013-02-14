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
  } //End class
} //End if
?>
