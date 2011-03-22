getFormValues = function(elt) {
  var params = {};
  $(elt).find("input").each(function() {
    params[$(this).attr('name')] = $(this).val();
  });
  $(elt).find("textarea").each(function() {
    params[$(this).attr('name')] = $(this).val();
  });
  return params;
}

getCheckedLines = function() {
	var ids = "";
	var names = "";
  var count = 0;
	$("input[name=check]:checked").each(function() {
		ids += ";" + $(this).val();
		names += "    " + $(this).parent('td').next('td').children('a').text() + ",\n";
    count++;
	});
  return new Array(ids.substring(1), names, count);
}

checkLine = function(input) {
	var tr = $(input).parent('td').parent('tr');
	if (!$(input).is(':checked'))
		$(tr).removeClass('current');
	else
		$(tr).addClass('current');
}

checkAllLines = function() {
	if (!$("thead input:checkbox").is(':checked')) { // Uncheck everything.
		$("tbody input:checkbox").removeAttr('checked');
		$("tbody tr").removeClass('current');
	} else {
		$("tbody input:checkbox").attr('checked', 'checked');
		$("tbody tr").addClass('current');
	}
}

rebuildLinks = function() {
  $("#corps a").each(function() {
    var lien = $(this).attr('href');
    $(this).attr('href', '#' + lien);
    $(this).click(function() {ajaxLoad($(this).attr('href').substring(1));});
  });
}

$(document).ready(function() {
  $("select[name=shops]").change(function() {
    var v = $(this).val();
    $("input[name=currentShopId]").val(v);
    if (v == 0) {
      displayBlank();
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
