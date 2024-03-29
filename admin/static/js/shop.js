
var deleteShops = function() {
  var arr = getCheckedLines();
  if (arr[0] == "") {
    alert("You need to select at least one shop to delete it.");
  } else if (confirm("Are you sure you want to delete the following shops:\n" + arr[1])) {
    $.post(rootUrl + "/shop/delete", {pids:arr[0]}, function(xml) {
      var result = $(xml).find('result').text() == arr[2] ? true : false;
      if (result)
        refreshShops();
      else
        alert("Impossible to delete shops.");
    });
  }
};


var filterShop = function(filter) {
refreshShops(null, filter, "", function() {
    if (lastFilterValue != filter) {
      lastFilterValue = filter;
      var input = $("input[name=filter]");
      $(input).focus();
      var txt = $(input).val();
      $(input).val('');
      $(input).val(txt);
    }
  });
};

var refreshShops = function(page, filter, action, callback) {
  if (page == null)
    page = $("a.current.other-page").text();
  if(filter == null)
    filter = $("input[name=filter]").val();
  if (filter == defaultShopFilterText)
    filter = '';
  var limit = $("select[name=limit]").val();
  start = (page - 1) * limit;
  if (action == "first") {
    start = 0;
  } else if (action == "prev") {
    start = (page - 2) * limit;
  } else if (action == "next") {
    start = page * limit;
  } else if (action == "last") {
    start = (parseInt($("a[href=#last-page]").attr('rel'), 10) - 1) * limit;
  }
  changeShop(rootUrl + "/shop/view", filter, start, limit, callback);
};

var changeShop = function(link, filter, start, limit, callback) {
  if (link   == null) link   = rootUrl + "/shop/view";
  if (filter == null) filter = "";
  if (start  == null) start  = 0;
  if (limit  == null) limit  = 15;
  var param = {'filter': filter, 'start':start, 'limit':limit};
  $.post(link, param, function(xml) {
    $("#corps").html(xml);
    parseShop();
    if (typeof(callback) === 'function') {
      callback();
    }
  }); 
};

var parseShop = function() {
  $("#list-shops thead input:checkbox").click(checkAllLines);
  $("#list-shops tbody input:checkbox").click(function() {checkLine($(this));});
  $("a[href=#remove]").click(deleteShops);
  $("select[name=limit]").change(function() {refreshShops();});
  $("a.other-page").click(function() {refreshShops($(this).text());});
  $("a[href=#first-page]").click(function() {refreshShops(null, null, "first");});
  $("a[href=#prev-page]").click(function() {refreshShops(null, null, "prev");});
  $("a[href=#next-page]").click(function() {refreshShops(null, null, "next");});
  $("a[href=#last-page]").click(function() {refreshShops(null, null, "last");});
  $("a[rev=external]").each(function() { $(this).attr('target', '_blank'); });
  setUpFilter(defaultShopFilterText, filterShop);  
};