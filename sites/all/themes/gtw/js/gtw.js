(function($) {
Drupal.behaviors.myBehavior = {
  attach: function (context, settings) {
  
    // alerts
    $("#console .close").click(function () {
      $("#console").fadeOut("slow");
      return false;
    });
    // my goals - not logged
    $(".not-logged-in .my-goals").click(function () {
      return false;
    });    
    
    // if username field is visible:
    if ($('input[name="name"]').length > 0){
      // when page first loads, lowercase/no-spaces
      var test= $('input[name="name"]').val();
      test = test.toLowerCase().replace(/ /g, '');
      $('input[name="name"]').val(test);  
      $('#username-preview').html(test);
       
      $('input[name="name"]').keyup(function() {
        var test= $('input[name="name"]').val();
        test = test.toLowerCase().replace(/ /g, '');
        $('input[name="name"]').val(test);
        $('#username-preview').html(test);
      });  
    }   
  }
};
})(jQuery);

jQuery(document).ready(function($) {
  // Code that uses jQuery's $ can follow here.
  // Twitter Bootstrap markup for horizontal forms:
  $('.form-horizontal .form-item').addClass('control-group');
  $('.profile-picture img, .view-web-goals img').addClass('img-polaroid');
  // Labels:
  $('.form-horizontal .form-type-textfield label').addClass('control-label');
  $("label[for='edit-field-privacy-profile-und'], label[for='edit-url']").addClass('control-label');
  $('.form-horizontal .form-type-textfield label').addClass('control-label');
  $('.form-horizontal .form-text').wrap('<div class="controls" />');
  $('.form-horizontal .form-radios').wrap('<div class="controls" />');
});
