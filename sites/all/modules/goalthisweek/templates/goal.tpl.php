<?php 
global $user; 
if ($node->uid == $user->uid) {
  $ismine = 'btn';
}
else {
  $ismine = '';
}
?>
<div id="the-goal" class="clearfix goal-<?php print $node->nid; ?>">

    <div class="goal-dates left-col">
      <span class="goal-date-range"><?php print format_date($node->date_start, 'short'); ?> - <?php print format_date($node->date_due, 'short'); ?> </span>
      <span class="goal-status-icon"><?php print goalthisweek_get_status_icon($node->goal_status) ?></span>
      
      <?php if (isset($node->title) && !$node->is_due): ?>
      <div><?php print $node->content_goal_status; ?></div>
      <?php elseif (isset($node->title) && $node->is_due): ?>
      <div><span class="label label-important">Due</span></div>
      <?php endif; ?>
      
    </div>
    <div class="goal-title well right-col">
      
        <?php if (isset($node->title)): ?>
        <h4><?php print $node->title; ?></h4>  
        
        <?php if ($node->is_due): ?>
        <!-- due form -->
        <div><?php print $node->content_goal_status; ?></div>
        <?php endif; ?>
      
        <?php else: ?>
        <!-- new goal form -->
        <?php print $node->content_goal_status; ?>
        <?php endif; ?>
        
      </div>
      

    
</div>