<?php

/**
 * @file
 * Sample template for HTML Mail test messages.
 */
$mail_parts = explode('|||', $body);
$message = substr(strstr($body, '|||'), 3);
?>
<div class="htmlmail-body">

<h3><a href="http://goalthisweek.com" style="text-decoration:none;">Goal This Week</a></h3>

<p>Hi <?php echo $mail_parts[0]; ?>,</p>
<p>Your Goal Last Week was to:</p>
<h4><?php echo $message ?></h4>
<p>It has expired. :\  Better luck next time. </p>
<p><a href="http://goalthisweek.com">Login and create a new Goal This Week.</a><p>

<p>Rock on,</p>
<p>-- Goal This Week</p>


</div>
