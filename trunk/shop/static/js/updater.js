var cceu = 0;

var updateAll = function() {
  cceu = 0;
  $("select").hide();
  $("#menu").hide();
  updateCategories();
  updateProductTypes();
  updateCurrencies();
};

var updateCategories = function() {
  $.get("/default/get-categories", function(xml) {
    var count = parseInt($(xml).find('count').text(), 10);
    if (count == 0) {
      endUpdate();
    } else {
      var i = 0;
      $(xml).find('category').each(function() {
        var id   = $(this).children('id').text();
        var name = $(this).children('name').text();
        $.post("/default/save-category", {id:id,name:name}, function(x) {
          i++;
          if (i == count) {
            endUpdate();
          }
        });
      });
    }
  });
};

var updateProductTypes = function() {
  $.get("/default/get-product-types", function(xml) {
    var count = parseInt($(xml).find('count').text(), 10);
    if (count == 0) {
      endUpdate();
    } else {
      var i = 0;
      $(xml).find('type').each(function() {
        var id   = $(this).children('id').text();
        var name = $(this).children('name').text();
        $.post("/default/save-product-type", {id:id,name:name}, function(x) {
          i++;
          if (i == count) {
            endUpdate();
          }
        });
      });
    }
  });
};

var updateCurrencies = function() {
  $.get("/default/get-currencies", function(xml) {
    var count = parseInt($(xml).find('count').text(), 10);
    if (count == 0) {
      endUpdate();
    } else {
      var i = 0;
      $(xml).find('currency').each(function() {
        var id   = $(this).children('id').text();
        var name = $(this).children('name').text();
        var symbol = $(this).children('symbol').text();
        $.post("/default/save-currency", {id:id, name:name, symbol:symbol}, function(x) {
          i++;
          if (i == count) {
            endUpdate();
          }
        });
      });
    }
  });
};

var endUpdate = function() {
  cceu++;
  if (cceu == 3) {
    var left = ($(".box-content").innerWidth() - $("#blank p").innerWidth()) / 2;
    $("#blank p").css('left', left + 'px');
    $("img").fadeOut();
    $("#blank p").fadeIn('slow', function() {
      $("select").fadeIn('slow', function() {
        $("#menu").fadeIn('slow');
      });
    });
  }
};