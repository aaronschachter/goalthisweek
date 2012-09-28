<div class="user-bar clearfix">
  <?php print theme('user_picture', array('account' => $goal_user)); ?>
  <h4>
  <?php if (arg(0) == 'user'): ?>
  <?php print $username; ?>
  <?php else: ?>
  <?php print l($username, 'user/' . $uid); ?>
  <?php endif; ?>
  </h4>
  <div class="goal-dates"><?php print $privacy; ?></div>
</div>