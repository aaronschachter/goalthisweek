<?php
/*
<p class="intro">Post your Goal This Week.</p>
*/
?>
<div class="gtw-tour">

  <div class="tour-header well clearfix">
    <div class="starfish"></div>
    <h1>Hold yourself accountable.</h1>
    <p><strong>Goal This Week</strong> is a free web app you can use to post 1 goal a week.</p>
  </div>
  
  <?php
  $num_steps = count($node->field_image_tour[LANGUAGE_NONE]);
  $i = 0;
  while ($i < $num_steps) { 
  ?>
  
  <div class="tour-row clearfix">
  
    <div class="pull-right span6 well">
    <?php print render($content['field_image_tour'][$i]) ; ?>
    </div>
    
    <div class="clearfix">
    
    <?php if ($i == 0): ?>
      <div class="alert alert-info">1. Post your Goal This Week.</div>
      <p>You can only post 1 goal per week.</p>
      <p>Once you've committed a goal:</p>
      <ul class="details">
        <li>You can't edit it.</li>
        <li>You can't delete it.</li>
      </ul>

    <?php elseif ($i == 1): ?>
      <div class="alert alert-info">2. Report your Goal This Week.</div>  
      <p>In a week, you'll receive an email with a link to report on your goal:</p>
      <p><strong>Completed</strong> or <strong>Did Not Complete.</strong></p>

    <?php elseif ($i == 2): ?>
      <div class="alert alert-info">3. Post new Goal This Week.</div>  
      <p><a href="#repeat">Repeat.</a></p>
      
    <?php endif; ?>
    
    </div>  
    
    <?php if ($i== 0): ?>
    <div class="well week-goes-by">One week goes by</div>
    <?php endif; ?>
    
  </div>
  <?php 
    $i++;
  }
  ?>
</div>