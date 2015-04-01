$(document).ready(function() {

$(function(){
 
    $('[data-toggle]').on('click', function(){
      var id = $(this).data("toggle"),
          $object = $(id);

          $object.toggle();
    });
});
});
