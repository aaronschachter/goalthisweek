<div class="user-bar">
  <div class="profile-picture">
    <?php print theme('user_picture', array('account' => $goal_user)); ?>
  </div>
  <h4>
  <?php if (arg(0) == 'user'): ?>
  <?php print $username; ?>
  <?php else: ?>
  <?php print l($username, 'user/' . $uid); ?>
  <?php endif; ?>
  </h4>
  <div class="username"><?php print $goal_user->name; ?></div>
  <div class="goal-dates"><?php print $privacy; ?></div>
  <?php print theme('goalthisweek_user_profile_links', array('goal_user' => $goal_user)); ?>
</div>