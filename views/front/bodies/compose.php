  
  <div id="mmania_advanced_compose_area">
    <form method="post" action="" id="mmania_advanced_compose_form">
      <label for="mmania_compose_recipients" class="mmania_compose_label"><?php _e('Recipients:', 'mmania'); ?></label>
      <input type="text" name="mmania_compose_recipients" id="mmania_compose_recipients" class="mmania_compose_text mmania_auto_input" />
      <div class="mmania_compose_spacer"></div>
      
      <label for="mmania_compose_subject" class="mmania_compose_label"><?php _e('Subject:', 'mmania'); ?></label>
      <input type="text" name="mmania_compose_subject" id="mmania_compose_subject" class="mmania_compose_text" />
      <div class="mmania_compose_spacer"></div>
      
      <label for="mmania_compose_body" class="mmania_compose_label"><?php _e('Message:', 'mmania'); ?></label>
      <br/>
      <?php wp_editor('', 'mmaniaadvancedcompose', array('media_buttons' => (is_super_admin()), 'textarea_rows' => 12)); ?>
      <div class="mmania_compose_spacer"></div>
      
      <input type="submit" name="mmania_compose_submit" id="mmania_compose_submit" class="mmania_form_button" value="<?php _e('Send', 'mmania'); ?>" />
      <div class="mmania_compose_spacer"></div>
    </form>
  </div>
  