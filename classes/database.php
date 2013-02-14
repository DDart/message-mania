<?php
if(!class_exists("MManiaDB"))
{
  class MManiaDB
  {
    //Constructor
    public function MManiaDB()
    {
      $this->get_set_options();
    }
    
    //VARS
    public $db_version                = 1;
    public $db_version_name           = 'mmania_db_version';
    public $threads_table_name        = 'mmania_threads';
    public $replies_table_name        = 'mmania_replies';
    public $participants_table_name   = 'mmania_participants';
    public $groups_table_name         = 'mmania_groups';
    public $options                   = array();
    public $options_name              = 'mmania_options';
    public $default_options           = array('show_directory'        => true,
                                              'directory_sort_by'     => 'user_login',
                                              'display_name'          => 'user_login',
                                              'allow_groups'          => true,
                                              'threads_per_page'      => 15,
                                              'replies_per_page'      => 15,
                                              'dir_users_per_page'    => 25,
                                              'replies_sort_order'    => 'ASC');
    
    //Gets the options if they exist, or sets defaults if they don't
    public function get_set_options()
    {
      $saved_options = get_option($this->options_name, array()); //Info saved as serialized arrays in wp_options table
      $this->options = array_merge($this->default_options, $saved_options);
    }
    
    //Check if options POST is set, if so save the options in the DB
    public function maybe_save_options()
    {
      if(isset($_POST['mmania_options_save']) && !empty($_POST['mmania_options_save']))
      {
        foreach($this->default_options as $key => $value)
          if(isset($_POST[$key]) && !empty($_POST[$key]))
            if(is_array($value))
              $this->options[$key] = $_POST[$key];
            elseif(is_bool($value))
              $this->options[$key] = true;
            else
              $this->options[$key] = stripslashes($_POST[$key]);
          else
            if(is_bool($value))
              $this->options[$key] = false;
            elseif(is_array($value))
              $this->options[$key] = array();
            else
              $this->options[$key] = $value;
        
        update_option($this->options_name, $this->options);
        
        return true;
      }
      
      return false;
    }
    
    //Perform DB creation/upgrades
    public function do_db()
    {
      global $wpdb;
      
      //Actually create the tables using dbDelta
      require_once(ABSPATH.'wp-admin/includes/upgrade.php');
      
      $pre = $wpdb->prefix;
      $charset_collate = '';
      
      if($wpdb->has_cap('collation'))
      {
        if(!empty($wpdb->charset))
          $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if(!empty($wpdb->collate))
          $charset_collate .= " COLLATE $wpdb->collate";
      }
      
      if($this->db_version <= 1)
      {
        $threads_table          = "CREATE TABLE ".$pre.$this->threads_table_name."(
                                    `id` int(11) NOT NULL auto_increment,
                                    `subject` text NOT NULL,
                                    `created_ts` int(11) NOT NULL,
                                    PRIMARY KEY (`id`))
                                    {$charset_collate};";
        
        $replies_table          = "CREATE TABLE ".$pre.$this->replies_table_name."(
                                    `id` int(11) NOT NULL auto_increment,
                                    `thread_id` int(11) NOT NULL,
                                    `user_id` int(11) NOT NULL,
                                    `body` text NOT NULL,
                                    `created_ts` int(11) NOT NULL,
                                    PRIMARY KEY (`id`))
                                    {$charset_collate};";
        
        $participants_table     = "CREATE TABLE ".$pre.$this->participants_table_name."(
                                    `id` int(11) NOT NULL auto_increment,
                                    `thread_id` int(11) NOT NULL,
                                    `user_id` int(11) NOT NULL,
                                    `unread` int(1) NOT NULL default '1'
                                    PRIMARY KEY (`id`))
                                    {$charset_collate};";
        
        $groups_table           = "CREATE TABLE ".$pre.$this->groups_table_name."(
                                    `id` int(11) NOT NULL auto_increment,
                                    `user_id` int(11) NOT NULL,
                                    `title` text NOT NULL,
                                    `description` text NULL,
                                    `members` text NULL,
                                    PRIMARY KEY (`id`))
                                    {$charset_collate};";
        
        dbDelta($threads_table);
        dbDelta($replies_table);
        dbDelta($participants_table);
        dbDelta($groups_table);
      }
    }
    
    public function get_plugin_page_id()
    {
      global $wpdb;
      
      return $wpdb->get_var("SELECT `ID`
                              FROM {$wpdb->posts}
                              WHERE `post_content` LIKE '%[MMania]%'");
    }
    
  } //End class
} //End if
?>
