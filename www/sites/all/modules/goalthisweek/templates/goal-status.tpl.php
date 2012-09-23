
<?php if ($node->goal_status == 0): ?>
<span class="label label-info"><?php print $node->time_left; ?> days left</span>

<?php elseif ($node->goal_status == 1): ?>
<span class="label label-success">Completed</span>

<?php elseif ($node->goal_status == 2): ?>
<span class="label">Did not complete</span>

<?php elseif ($node->goal_status == 3): ?>
<span class="label">Expired</span>

<?php endif; ?>

