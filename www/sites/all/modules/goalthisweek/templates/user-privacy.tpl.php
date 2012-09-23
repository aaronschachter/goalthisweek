<?php if ($user->uid >0): ?>
<?php 

$user = user_load($user->uid); 
$privacy = $user->field_privacy_profile[LANGUAGE_NONE][0]['value'];
?>


<p>
<?php if ($privacy): ?>
<i class="icon-lock"></i> Private
<?php else: ?>
<i class="icon-globe"></i> Web
<?php endif; ?>
</p>



<ul class="nav nav-tabs nav-stacked">
<li><?php print l('<i class="icon-cog"></i>  Settings', 'user/' . $user->uid . '/edit', array('html' => TRUE)); ?></li>
 <?php print l('<li><i class="icon-off"></i> Logout', 'user/logout', array('html' => TRUE)); ?></li>
</ul>
<?php endif; ?>