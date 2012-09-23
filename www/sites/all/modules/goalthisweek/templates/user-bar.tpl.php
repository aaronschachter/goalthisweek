<div class="user-bar clearfix">
  <span class="goal-dates pull-right"><?php print $privacy; ?></span>
  <h4>
  <?php if (arg(0) == 'user'): ?>
  <?php print $username; ?>
  <?php else: ?>
  <?php print l($username, 'user/' . $uid); ?>
  <?php endif; ?>
  </h4>
</div>