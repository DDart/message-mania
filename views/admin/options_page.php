<div class="wrap">
  <h2>Message Mania - <?php _e('Options', 'mmania'); ?></h2>
  
  <?php if($saved): ?>
    <div id="message" class="updated below-h2">
      <p><?php _e('Your preferences have been set.', 'mmania'); ?></p>
    </div>
  <?php endif; ?>
  
  <form action="" method="post">
    <input type="submit" name="mmania_options_save" value="<?php _e('Save Options', 'mmania'); ?>" class="button" />
  </form>
</div>
