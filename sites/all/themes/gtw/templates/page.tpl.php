<?php 
global $user; 
$user = user_load($user->uid); // drupal sux. can't get user fields without a user_load here.
$itsmine = '';
$user_bar = FALSE;
$someone_else = FALSE;
$web = FALSE;
$path = $_GET['q'];

// If this is the tour page:
if (isset($node) && $node->type == 'tour') {
  $user_bar = FALSE;
}

// if its goals:
elseif ($_GET['q'] == 'web') {
  $web = TRUE;
}

// Else if this is my profile:
elseif (arg(0) == 'user' && arg(1) == $user->uid) {
  $itsmine = 'active';
  $goal_user = $user;
  $goal_username = goalthisweek_get_username($user);  
  $goal_uid = $user->uid;
  $goal_privacy = goalthisweek_get_privacy_html($user->field_privacy_profile[LANGUAGE_NONE][0]['value']);  
  $user_bar = TRUE;
}

// Else if this is my Goal:
else if (isset($node) && $node->uid == $user->uid) {
  $itsmine = 'active';
  $goal_user = $user;
  $goal_username = goalthisweek_get_username($user);
  $goal_uid = $user->uid;  
  $user_bar = TRUE;
}

// Else if this is someone else's Goal:
else if (isset($node) && $node->uid != $user->uid) {
  $web = TRUE;
  $goal_user = user_load($node->uid);
  $goal_username = $node->username;
  $goal_uid = $node->uid;
  $user_bar = TRUE;
  $someone_else = TRUE;
}

// Else it's someone's profile.
else if (arg(0) == 'user' && (arg(1) != $user->uid) && is_numeric(arg(1))) {
  // Check the author's privacy settings.
  $author = user_load(arg(1));
  $privacy = $author->field_privacy_profile[LANGUAGE_NONE][0]['value'];
  // If public profile: set goal_user.
  if ($privacy) {
    $web = TRUE;
    $goal_user = $author;
    $goal_username = goalthisweek_get_username($author);
    $goal_uid = $author->uid;
    $user_bar = TRUE;
    $someone_else = TRUE;
  }
  // Else don't display anything.
  else {
    $user_bar = FALSE;
  }
}

$display_top_well = FALSE;
// Top well. (Web, about, thing
if (drupal_is_front_page() || ($path == 'web')) {
  $display_top_well = TRUE;
  if ($user->uid == 0) {
    $top_well = '<i class="icon-globe"></i> <strong>Goal This Week</strong> is a free web app for posting 1 goal a week on the web <span class="or-privately">(or privately).</span> <span class="pull-right learn-more">' . l('Learn more.', 'about') . '</span>';
  }
  else {
    $top_well = '<i class="icon-globe"></i> <span class="goal-dates">Web</span>';
  }
}
?>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <div class="row">
        <div class="brand span3">
          <?php print l('Goal This Week', '<front>', array('html' => 'true')); ?>
        </div>      
        <?php if ($user->uid >0): ?>
        <ul class="links nav primary-links">
          <li class="my-goals first <?php print $itsmine ?> last">
            <?php print l('My Goals', '<front>'); ?>
          </li>
          <li class="<?php if ($web) print 'active' ?>">
            <?php print l('Web', 'web'); ?>
          </li>        
        </ul>
        <?php endif; ?>
        <div id='user-nav' class='pull-right'>
          <?php if ($user->uid >0): ?>
          <?php $nav_title = "<i class='icon-user'></i> " .goalthisweek_get_username($user); ?>
          <?php print theme('ctools_dropdown', array('title' => $nav_title, 'image' => TRUE, 'links' => goalthisweek_user_account_nav(), 'class' => 'user-nav-menu')); ?> 
          <?php else: ?>
          Post your Goal This Week. <?php print fboauth_action_display('connect'); ?> 
          <?php endif; ?>
        </div>
      </div>
    </div>     
  </div>
</div>


<div id='console' class='container alert-messages'>
  <div class='message row'><?php print $messages; ?></div>
</div>


<div id='page'>
  <div class='container'>
    <div id='main-content' class='row'> 
      <?php if ($display_top_well): ?>
      <div class="well"><?php print $top_well; ?></div>
      <?php endif; ?>
      <?php if ($user_bar): ?>
      <?php print theme('goalthisweek_user_bar', array(
        'goal_user' => $goal_user,
        'username' => $goal_username, 
        'uid' => $goal_uid, 
        )); ?>
      <?php $content_class = 'offset3 span9'; ?>
      <?php else: ?>
      <?php $content_class = ''; ?>
      <?php endif; ?> 
      <div id='content' class=' <?php print $content_class; ?> clearfix'><?php print render($page['content']) ?></div>
    </div>
  </div>
</div>

<div id="footer">
  <div class='container'>
    <div class="row well">
      &copy 2013 Goal This Week | <?php print l('About', 'about'); ?> | <a href="http://www.facebook.com/goalthisweek" target="_blank"><img src="<?php print GTW_FB_ICON; ?>"</a> <a href="http://www.twitter.com/goalthisweek" target="_blank"><img src="<?php print GTW_TWITTER_ICON; ?>"></a><span class="pull-right"><?php print l('Terms', 'tos'); ?> | <?php print l('Privacy', 'privacy'); ?></span>
    </div>
  </div>
</div>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=8181344; 
var sc_invisible=1; 
var sc_security="ebd92240"; 
</script>
<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script>
<noscript><div class="statcounter"><a title="tumblr hit
counter" href="http://statcounter.com/tumblr/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/8181344/0/ebd92240/1/"
alt="tumblr hit counter"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->
