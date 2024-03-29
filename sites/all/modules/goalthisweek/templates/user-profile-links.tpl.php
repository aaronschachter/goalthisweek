<?php 
if ($goal_user->field_privacy_profile[LANGUAGE_NONE][0]['value'] == 1) {

  if (isset($goal_user->field_website_url[LANGUAGE_NONE][0]['safe_value'])) {
    $web_url = $goal_user->field_website_url[LANGUAGE_NONE][0]['safe_value'];
    $has_links = TRUE;
  }
  if (isset($goal_user->field_facebook_url[LANGUAGE_NONE][0]['safe_value'])) {  
    $fb_url = $goal_user->field_facebook_url[LANGUAGE_NONE][0]['safe_value'];
    $has_links = TRUE;
  }
  if (isset($goal_user->field_twitter_url[LANGUAGE_NONE][0]['safe_value'])) {
    $twitter_url = $goal_user->field_twitter_url[LANGUAGE_NONE][0]['safe_value'];
    $has_links = TRUE;
  }
  if (isset($goal_user->field_linkedin_url[LANGUAGE_NONE][0]['safe_value'])) {
    $linkedin_url = $goal_user->field_linkedin_url[LANGUAGE_NONE][0]['safe_value'];
    $has_links = TRUE;
  }

}
else {
  $private = TRUE;
}
?>

<?php if (isset($has_links)): ?>

<div class="user-profile-links">

  <?php if (isset($web_url)): ?>
  <a href="http://<?php print $web_url; ?>" class="user-website-url" target="_blank"><?php print $web_url; ?></a>
  <?php endif; ?>

  <div class="user-profile-social-icons">
  
    <?php if (isset($fb_url)): ?>
    <a href="http://facebook.com/<?php print $fb_url; ?>" target="_blank"><img src="<?php print GTW_FB_ICON; ?>"></a>
    <?php endif; ?>
  
    <?php if (isset($twitter_url)): ?>
    <a href="http://twitter.com/<?php print $twitter_url; ?>" target="_blank"><img src="<?php print GTW_TWITTER_ICON; ?>"></a>
    <?php endif; ?>  
  
    <?php if (isset($linkedin_url)): ?>
    <a href="http://linkedin.com/in/<?php print $linkedin_url; ?>" target="_blank"><img src="<?php print GTW_LINKEDIN_ICON; ?>"></a>
    <?php endif; ?>  
    
  </div>
  
</div>

<?php elseif (isset($private)): ?>

<div class="user-profile-links private">
  <i class="icon-lock"></i> <span class="goal-dates">Private</span>
</div>

<?php endif; ?>
