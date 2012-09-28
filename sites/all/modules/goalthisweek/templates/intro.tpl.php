<?php 
$node = node_load(117);
$node = node_view($node);
print render($node); 
?>

<?php 

/* homepage SEO */

// meta description
$element = array('#tag' => 'meta', '#attributes' => array(
  'property' => 'description', 'content' => 'Hold yourself accountable by posting your personal or professional goals to Goal This Week.  Goal This Week is a free web app you can use to post one Goal a week, either publicly or privately.',
  ),  
);
drupal_add_html_head($element, 'description');
// meta description
$element = array('#tag' => 'meta', '#attributes' => array(
  'property' => 'keywords', 'content' => 'personal goals, app, website, web service, free app, personal growth, weekly goals, goal this week, private goals, goals on facebook, facebook app, personal performance, hold yourself accountable, accomplishing goals',
  ),  
);
drupal_add_html_head($element, 'keywords');
?>