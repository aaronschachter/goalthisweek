<?php
global $user;
$user = user_load($user->uid);
$account_id = arg(1);
// If this is my profile and i haven't confirmed my account yet, direct to home path
if ($user->uid == $account_id && $user->field_account_confirmed[LANGUAGE_NONE][0]['value'] != 1) {
  drupal_goto('home');
}
print goalthisweek_get_profile($account_id);
?>
