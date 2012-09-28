<?php 
global $user; 
if ($node->uid == $user->uid) {
  $ismine = 'btn';
}
else {
  $ismine = '';
}
?>
<div id="the-goal" class="goal-<?php print $node->nid; ?>">

    <div class="goal-dates">
      <?php print format_date($node->date_start, 'short'); ?> - <?php print format_date($node->date_due, 'short'); ?>
   
      
      <?php if (isset($node->title) && !$node->is_due): ?>
      <div><?php print $node->content_goal_status; ?></div>
      <?php elseif (isset($node->title) && $node->is_due): ?>
       <span class="label label-important">Due</span>
      <?php endif; ?>
      
    </div>
    <div class="goal-title well">
    
      <span class="pull-right"><?php print goalthisweek_get_status_icon($node->goal_status) ?></span>
      
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