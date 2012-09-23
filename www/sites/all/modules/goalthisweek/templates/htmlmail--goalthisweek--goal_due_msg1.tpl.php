<?php

/**
 * @file
 * Sample template for HTML Mail test messages.
 */
$mail_parts = explode('|||', $body);
$message = substr(strstr($body, '|||'), 3);
?>
<div class="htmlmail-body">

<h3><a href="http://www.goalthisweek.com" style="text-decoration:none;">Goal This Week</a>: Goal Due</h3>

<p>Hi <?php echo $mail_parts[0]; ?>,</p>

<p>Your Goal This Week was to:</p>

<h4><?php echo $message ?></h4>

<p>Please login to <a href="http://www.goalthisweek.com">Goal This Week</a> to report on your Goal, and to create a new one for this upcoming week.</p>

<p>You have 48 hours to report on your Goal This Week, otherwise it will be set to "Expired".</p> 

<p>Rock on,</p>
<p>-- Goal This Week</p>


</div>
