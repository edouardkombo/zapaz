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

changePanes = function() {
	var lien = $("#menu .current").attr('href').substring(1);
	switch (lien) {
		case "shop"        : changeShop();        break;
		case "user"        : changeUser();        break;
		case "category"    : changeCategory();    break;
		case "product-type": changeProductType(); break;
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
  var v = window.location.toString().match(/.*?p=(.*)/i);
  if (v != null) {
    v = v[1];
    var iv = v.indexOf("#", 0);
    if (iv > 0) {
      v = v.substr(0, iv);
    }
  }
  var i = 0;
  switch (v) {
		case "user"        : i = 2; parseUser();        break;
		case "category"    : i = 3; parseCategory();    break;
		case "product-type": i = 4; parseProductType(); break;
		case "shop"        :
    default            : i = 1; parseShop();        break;
	}
  $("#menu li:nth-child(" + i + ") a").addClass('current');
});
