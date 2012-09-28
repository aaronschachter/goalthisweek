<?php
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $header_classes: An array of header classes keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $field_classes: An array of classes to apply to each field, indexed by
 *   field id, then row number. This matches the index in $rows.
 * @ingroup views_templates
 *
 * note - if a field is excluded from field in the view, it doesnt appear in the $row array
 */
$result_count = count($rows);
?>
<?php foreach ($rows as $row_count => $row): ?>
<div class="row">
  <div class="span1">
    <?php print $row['picture']; ?> 
  </div> 
  <div class="span2">
    <small><?php print $row['name']; ?></small>
  </div>                   
  <div class="span9">
    <div class="goal-dates"><?php print $row['field_duration']; ?></div>
    <div class="well">
    <?php print $row['title']; ?>
    <span class="pull-right"><?php print goalthisweek_get_status_icon($row['field_status']); ?> </span>
    </div>
  </div>
</div>
<hr>
<?php endforeach; ?>
 
