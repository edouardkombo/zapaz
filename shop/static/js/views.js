var displayShopInfo = function() {
  refreshShop();
  
  $("#menu li").removeClass('current');
  $("#menu li:first").addClass('current');
  
  $("#submenu").empty();
  var a = document.createElement('a');
    $(a).attr('href', '#info');
    $(a).addClass('current');
    $(a).text('Shop Information');
  var li = document.createElement('li');
    $(li).append(a);
  $("#submenu").append(li);
};

var displayProducts = function() {
  if ($("select[name=shops]").val() == "999999") {
    return false;
  }
  var id = $("input[name=currentShopId]").val();
  
  $("#menu li").removeClass('current');
  $("#menu li:last").addClass('current');
  
  $("#submenu").empty();
  $.post("/shop/get-categories", {'shopId':id}, function(xml) {
    var filter = "";
    $(xml).find('c').each(function() {
      if (filter == "") { 
        filter = $(this).text();
      }
      var a = document.createElement('a');
        $(a).attr('href', '#' + $(this).text());
        $(a).text($(this).text());
        $(a).click(function() {
          $("#submenu a").removeClass('current');
          $(this).addClass('current');
          refreshProducts();
        });
      if (filter == $(this).text()) {
        $(a).addClass('current');
      }
      var li = document.createElement('li');
        $(li).append(a);
      $("#submenu").append(li);
    });
    refreshProducts(null, null, filter);
  });
};