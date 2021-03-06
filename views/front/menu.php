
  <div id="mmania_menu">
    <?php echo get_avatar((int)$user_ID, 64); ?>
    <span id="mmania_welcome_message">Welcome cartpauj!</span>
    <br/>
    <span id="mmania_menu_inbox" class="mmania_menu_item">
      <a href="<?php echo self::$plugin_url; ?>#mmania_menu"><?php _e('Inbox', 'mmania'); ?></a>
    </span>
    
    <span id="mmania_menu_compose" class="mmania_menu_item">
      <a href="#" id="mmania_compose_toggle"><?php _e('Compose', 'mmania'); ?></a>
    </span>
    
    <span id="mmania_menu_options" class="mmania_menu_item">
      <a href="<?php echo self::$action_url; ?>options#mmania_menu"><?php _e('Options', 'mmania'); ?></a>
    </span>
    
    <span id="mmania_menu_logout" class="mmania_menu_item">
      <a href="#"><?php _e('Logout', 'mmania'); ?></a>
    </span>
  </div>
  
  <div class="mmania_separator"></div>
  
  <?php if((!isset($_GET['mmania_action']) || empty($_GET['mmania_action'])) || (isset($_GET['mmania_action']) && $_GET['mmania_action'] != 'advanced_compose')): //Don't show this if we're on the advanced compose screen ?>
    <div id="mmania_compose_area">
      <form method="post" action="" id="mmania_compose_form">
        <label for="mmania_compose_recipients" class="mmania_compose_label"><?php _e('Recipients:', 'mmania'); ?></label>
        <input type="text" name="mmania_compose_recipients" id="mmania_compose_recipients" class="mmania_compose_text mmania_auto_input" />
        <div class="mmania_compose_spacer"></div>
        
        <label for="mmania_compose_subject" class="mmania_compose_label"><?php _e('Subject:', 'mmania'); ?></label>
        <input type="text" name="mmania_compose_subject" id="mmania_compose_subject" class="mmania_compose_text" />
        <div class="mmania_compose_spacer"></div>
        
        <label for="mmania_compose_body" class="mmania_compose_label"><?php _e('Message:', 'mmania'); ?></label>
        <textarea name="mmania_compose_body" id="mmania_compose_body"></textarea>
        <div class="mmania_compose_spacer"></div>
        
        <input type="submit" name="mmania_compose_submit" id="mmania_compose_submit" class="mmania_form_button" value="<?php _e('Send', 'mmania'); ?>" />
        <div class="mmania_compose_spacer"></div>
        
        <a href="<?php echo self::$action_url; ?>advanced_compose#mmania_menu" id="mmania_advanced_compose_link"><?php _e('Advanced Compose', 'mmania'); ?></a>
      </form>
    </div>
  <?php endif; ?>
  
  <div class="mmania_separator_large"></div>
  