<?php if ($user->uid >0): ?>
<ul class="nav nav-tabs nav-stacked">
<li><?php print l('<i class="icon-cog"></i>  Settings', 'user/' . $user->uid . '/edit', array('html' => TRUE)); ?></li>
 <?php print l('<li><i class="icon-off"></i> Logout', 'user/logout', array('html' => TRUE)); ?></li>
</ul>
<?php endif; ?>