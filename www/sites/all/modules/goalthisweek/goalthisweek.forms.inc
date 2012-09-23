<?php
/** 
 * Goal due form
 */
function goalthisweek_form_due($form, &$form_state, $nid) {
  if (goalthisweek_is_posting_fb()) {
    $form['post_to_fb'] = array(
      '#type' => 'checkbox', 
      '#title' => FB_POST_DESC,
      '#default_value' => 1,
    );  
  }
  else {
    $form['post_to_fb'] = array(
      '#type' => 'hidden', 
      '#value' => 0,
    );     
  }
  $form['nid'] = array('#type' => 'hidden', '#value' => $nid);
  $form['actions'] = array('#type' => 'actions');
  $form['actions']['did_not_complete'] = array(
    '#type' => 'submit',
    '#value' => t('Did Not Complete'),
    '#submit' => array('goalthisweek_form_due_submit_did_not_complete'),
    '#attributes' => array('class' => array('btn btn-small btn-did-not-complete')),
  );
  $form['actions'] ['completed'] = array(
    '#type' => 'submit',
    '#value' => t('Completed'),
    '#submit' => array('goalthisweek_form_due_submit_complete'),
    '#attributes' => array('class' => array('btn btn-primary btn-completed')),
  );
  return $form;
}

/** 
 * Goal completed form submit
 *
 */
function goalthisweek_form_due_submit_complete($form, &$form_state) {
  $nid = $form_state['values']['nid'];
  $post_to_fb = $form_state['values']['post_to_fb'];
  goalthisweek_set_goal_status($nid, 1, $post_to_fb);
  drupal_set_message(t('Great job!  Keep it up!'));
}

/** 
 * Goal did-not-complete form submit
 *
 */
function goalthisweek_form_due_submit_did_not_complete($form, &$form_state) {
  $nid = $form_state['values']['nid'];
  $post_to_fb = $form_state['values']['post_to_fb'];
  goalthisweek_set_goal_status($nid, 2, $post_to_fb);
  drupal_set_message(t("Aw, it happens. Better luck this week."), 'warning');
}

/**
 * Save node ($nid) with status, and post Open Graph action to FB if $post_to_fb.
 */
function goalthisweek_set_goal_status($nid, $status, $post_to_fb = NULL) {
  
  // Save node's status value.
  $node = node_load($nid);
  $node->field_status['und'][0]['value'] = $status;
  node_save($node);
  
  // Post to Facebook.
  if ($post_to_fb == 1) {
    if ($status == 1) {
      goalthisweek_fb_action($nid, 'complete');
    }
    else {
      goalthisweek_fb_action($nid, 'did_not_complete');
    }
  }
}


/**
 * Return drupal form for creating new goal
 */
function goalthisweek_form_new($form, &$form_state) { 

  $form['title'] = array(
    '#type' => 'textfield', 
    '#title' => t('My Goal This Week is to:'), 
    '#size' => 160, 
    /// @TODO - add tooltip to measurable
    '#description' => t('<b>Tip</b>: Keep it short, sweet, and <a href-#" class="tips-measurable">measurable</a>.'),
    '#maxlength' => 255, 
    '#required' => TRUE,
  );

  $form['actions'] = array('#type' => 'actions');
  if (goalthisweek_is_posting_fb()) {
    $form['actions']['post_to_fb'] = array(
      '#type' => 'checkbox', 
      '#title' => FB_POST_DESC,
      '#default_value' => 1,
    );  
  }  
  else {
    $form['post_to_fb'] = array(
      '#type' => 'hidden', 
      '#value' => 0,
    );    
  }
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Commit',
    '#attributes' => array('class' => array('btn btn-primary')),    
  );
  return $form;
}

/**
 * Submit callback for new goal
 */
function goalthisweek_form_new_submit($form, &$form_state) {
  $title = $form_state['values']['title'];
  $post_to_fb = $form_state['values']['post_to_fb'];
  $node = new stdClass();
  $node->type = 'goal';
  node_object_prepare($node);
  $node->title = $title;
  $node->language = LANGUAGE_NONE;
  $node->field_status['und'][0]['value'] = 0;
  // @todo fix timeszones
  $node->field_duration[LANGUAGE_NONE][0] = array(
    'value' => time(),
    'value2' => time() + (7 * 24 * 60 * 60),
    'timezone' => 'UTC',
    'timezone_db' => 'UTC',
  );
  node_save($node);
  if (isset($post_to_fb) && $post_to_fb) {
    goalthisweek_fb_action($node->nid, 'create');
  }
  drupal_set_message(t("Goal committed.  Report back in a week!"));
}

function goalthisweek_fb_action($nid, $action) {
  $goal_url = 'http://' . GTW_URL . '/goal/' . $nid;
  $facebook = goalthisweek_get_facebook();  
  $user = $facebook->getUser();
  if ($user) {
    try {
      // We have a valid FB session, so we can use 'me'
      $params = array(
        'access_token' => $facebook->getAccessToken(),
        'grant_type' => 'publish_actions',
      );
      $action_id = $facebook->api('/me/goalthisweek:' . $action . '?goal=' . $goal_url, 'POST', $params); 
      watchdog('goalthisweek', 'goalthisweek' . $action . ':' . $action_id); 
    } 
    catch (FacebookApiException $e) {
      watchdog('goalthisweek', 'goalthisweek:' . $action  . '  error: ' . print_r($e, true));
    }
  }
  else {
    watchdog('goalthisweek', 'no getUser() in goalthisweek:' . $action);
  }
}

/**
 * Implements hook_user_profile_form_alter().
 */
function goalthisweek_form_user_profile_form_alter(&$form, &$form_state, $form_id) {
  dsm($form);
  global $user;

  if ($user->uid != 1) {

    $user = user_load($user->uid); 
 
    // If account is not confirmed:
    if (!$user->field_account_confirmed || $user->field_account_confirmed[LANGUAGE_NONE][0]['value'] != 1) {
      
      // check to see if default username from account creationis over 15 chars.  if so, trim it.
      $username_count = strlen($form['account']['name']['#default_value']);
      if ($username_count > 15) {
        $oldname = $form['account']['name']['#default_value'];
        $newname = substr($oldname, 0, 15);
        $form['account']['name']['#default_value'] = $newname;
      }
      $form['#prefix'] = '<h4>Setup</h4><p>Before you post your Goal This Week, please review your Profile Settings.';
      $form['account']['name']['#title'] = t('Profile URL'); 
      $form['account']['name']['#description'] = 'http://goalthisweek.com/<span id="username-preview">[your_profile_url]</span>' . $concat_name . '<p>Max 15 characters. You cannot change your Profile URL once you have set it, so pick a good one!</p>';      
      $form['account']['name']['#rules'] = array(
        array(
          'rule' => 'regexp[/^[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$/]',
          'error' => 'Only letters, numbers, and hyphens allowed.',
        ), 
        array(
          'rule' => 'length[3, 15]',
          'error' => 'Must be between 3-15 characters.',
        ),       
      );      
      $form['field_account_confirmed'][LANGUAGE_NONE]['#title'] = 'I agree to the Terms of Service and Privacy Policy.';
      $form['actions']['submit']['#value'] = t('Create my Profile');
      
    }

    // Else for confirmed account:
    else {
      $form['#prefix'] = '<h4><i class="icon-cog"></i>Profile Settings</h4>';
      // Read-only Profile URL field.
      $form['account']['url']['#title'] = t('Profile URL');
      $form['account']['url']['#type'] = 'item';
      $form['account']['url']['#markup'] = '<div class="controls small">http://goalthisweek.com/' . $user->name . '</div>';
      unset($form['account']['name']);    
      unset($form['field_account_confirmed']);
      $form['actions']['submit']['#value'] = t('Update Settings');
      
    }
    $form['#attributes']['class'][] = 'form-horizontal well';
    $form['field_privacy_profile'][LANGUAGE_NONE]['#title'] = 'Visibility';
    unset($form['account']['fboauth']);
    unset($form['field_post_to_fb']);
    $form['actions']['submit']['#attributes'] = array('class' => array('btn btn-primary pull-right')); 
    $form['#suffix'] = '<div class="account-link-info">' . t('Your Goal This Week account is linked to your Facebook account. ') . l('Info', 'user/' . $user->uid . '/fboauth') . '</div>';
  }  
}




function goalthisweek_form_delete($form, &$form_state) {
  $form['action_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Action ID'), 
  );
  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Delete Action ID'),
    '#attributes' => array('class' => array('btn btn-primary')),
  );
  return $form;
}
  
function goalthisweek_form_delete_submit($form, &$form_state) {
  $action_id = $form_state['values']['action_id'];
  // http://stackoverflow.com/questions/2858748/facebook-api-delete-status -- "Fixed!" comment
  global $user;
  $fb_id = fboauth_fbid_load($user->uid);
  //$action_id = $fb_id . '_' . $action_id;
  // $access_token = $facebook->getAccessToken()
  
  // http://stackoverflow.com/questions/7826108/how-to-solve-this-method-must-be-called-with-an-app-access-token-error
  // was getting error: this method must be called with app access token
  $access_token = GTW_FB_APP_ID . '|' . GTW_FB_APP_SECRET;
  
  $facebook = goalthisweek_get_facebook();
  return $facebook->api('/' . $action_id, 'DELETE', array('grant_type' => 'publish_actions', 'access_token' => $access_token));
}

