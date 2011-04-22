var showPopup = function(xml, onEndShowCallback, onEndHideCallback) {
  if ($("#lock-background").length == 0) {
    $("body").append(xml);
    $("#lock-background").hide();
    $("#popup").css('left', '-800px');
    $("#lock-background").fadeIn('normal', function() {
      var height = $("#popup").innerHeight();
      var top = (parseInt($("body").innerHeight(), 10) - 10 - height) / 2;
      $("#popup").css('top', top + 'px');
      var left = (parseInt($("body").innerWidth(), 10) - 710 - 10) / 2;
      $("#popup").animate({'left':left + 'px'}, onEndShowCallback);
      $("#popup #close").click(function() {hidePopup(onEndHideCallback);});
    });
  } else {
    $("#popup").replaceWith($(xml).find('#popup'));
    var height = $("#popup").innerHeight();
    var top = (parseInt($("body").innerHeight(), 10) - 10 - height) / 2;
    var left = (parseInt($("body").innerWidth(), 10) - 710 - 10) / 2;
    $("#popup").css('top', top + 'px');
    $("#popup").css('left', left + 'px');
    $("#popup #close").click(function() {hidePopup(onEndHideCallback);});
    if (typeof(onEndShowCallback) === 'function')
      onEndShowCallback();
  }
};

var hidePopup = function(callback) {
  var rightLimit = $("body").innerWidth();
  $("#popup").animate({'left':rightLimit + 'px'}, function() {
    $("#lock-background").fadeOut('normal', function() {
      $("#lock-background").remove();
      if (typeof(callback) === 'function')
        callback();
    });
  });
};

var getFormValues = function(elt) {
  var params = {};
  $(elt).find("input").each(function() {
    params[$(this).attr('name')] = $(this).val();
  });
  $(elt).find("textarea").each(function() {
    params[$(this).attr('name')] = $(this).val();
  });
  return params;
};

var getCheckedLines = function() {
	var ids = "";
	var names = "";
  var count = 0;
	$("input[name=check]:checked").each(function() {
		ids += ";" + $(this).val();
		names += "    " + $(this).parent('td').next('td').children('a').text() + ",\n";
    count++;
	});
  return new Array(ids.substring(1), names, count);
};

var checkLine = function(input) {
	var tr = $(input).parent('td').parent('tr');
	if (!$(input).is(':checked'))
		$(tr).removeClass('current');
	else
		$(tr).addClass('current');
};

var checkAllLines = function() {
	if (!$("thead input:checkbox").is(':checked')) { // Uncheck everything.
		$("tbody input:checkbox").removeAttr('checked');
		$("tbody tr").removeClass('current');
	} else {
		$("tbody input:checkbox").attr('checked', 'checked');
		$("tbody tr").addClass('current');
	}
};

var rebuildLinks = function() {
  $("#corps a").each(function() {
    var lien = $(this).attr('href');
    $(this).attr('href', '#' + lien);
    $(this).click(function() {ajaxLoad($(this).attr('href').substring(1));});
  });
};

$(document).ready(function() {
  updateAll();
  $("select[name=shops]").change(function() {
    var fo = $("select[name=shops] option:first");
    if ($(fo).text() == "") {
      $(fo).remove();
    }
    var v = $(this).val();
    $("input[name=currentShopId]").val(v);
    if (v == 0) {
      // Do nothing
    } else if (v == 999999) {
      $("input[name=currentShopId]").val('0');
      displayShopInfo();
    } else {
      if ($("#menu li.current a").text() == "Products") {
        displayProducts();
      } else {
        displayShopInfo();
      }
    }
  });
  $("#menu li:first a").click(displayShopInfo);
  $("#menu li:last a").click(displayProducts);
});