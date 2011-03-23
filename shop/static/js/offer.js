var createOffer = function(a) {
  var lineId = $(a).parent('td').parent('tr').find('input[name=check]').val();
  $.get("/offer/create", {id:lineId}, function(xml) {
    $("body").append(xml);
    $("#popup").css('left', '-1000px');
    $("#lock-background").fadeIn('normal', function() {
      var height = $("#popup").innerHeight();
      var top = (parseInt($("body").innerHeight(), 10) - height - 60) / 2;
      $("#popup").css('top', top + 'px');
      var left = (parseInt($("body").innerWidth(), 10) - 780 - 10) / 2;
      $("#popup").animate({'left':left + 'px'});
    });
   
   $("#popup #submit-close").click(function() {
      $("#lock-background").fadeOut('normal', function() {
        $("#lock-background").remove();
      });
    });
  });  
};