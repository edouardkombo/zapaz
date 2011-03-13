
var deleteUsers = function() {
 var arr = getCheckedLines();
  if (arr[0] == "") {
    alert("You need to select at least one user to delete it.");
  } else if (confirm("Are you sure you want to delete the following users:\n" + arr[1])) {
    $.post("/user/delete", {pids:arr[0]}, function(xml) {
      var result = $(xml).find('result').text() == arr[2] ? true : false;
      if (result)
        refreshUsers();
      else
        alert("Impossible to delete users.");
    });
  }
};


var filterUser = function(filter) {
 refreshUsers(null, filter, "", function() {
    if (lastFilterValue != filter) {
      lastFilterValue = filter;
      var input = $("input[email=filter]");
      $(input).focus();
      var txt = $(input).val();
      $(input).val('');
      $(input).val(txt);
    }
  });
};

var refreshUsers = function(page, filter, action, callback) {
if (page == null)
    page = $("a.current.other-page").text();
  if(filter == null)
    filter = $("input[name=filter]").val();
  if (filter == defaultUserFilterText)
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
  changeUser("/user/view", filter, start, limit, callback);
};

var changeUser = function(link, filter, start, limit, callback) {
  if (link   == null) link   = "/user/view";
  if (filter == null) filter = "";
  if (start  == null) start  = 0;
  if (limit  == null) limit  = 15;
  var param = {'filter': filter, 'start':start, 'limit':limit};
  $.post(link, param, function(xml) {
    $("#corps").html(xml);
    parseUser();
    if (typeof(callback) === 'function') {
      callback();
    }
  }); 
};

var parseUser = function() {
  $("#list-users thead input:checkbox").click(checkAllLines);
  $("#list-users tbody input:checkbox").click(function() {checkLine($(this));});
  $("a[href=#remove]").click(deleteUsers);
  $("select[name=limit]").change(function() {refreshUsers();});
  $("a.other-page").click(function() {refreshShops($(this).text());});
  $("a[href=#first-page]").click(function() {refreshUsers(null, null, "first");});
  $("a[href=#prev-page]").click(function() {refreshUsers(null, null, "prev");});
  $("a[href=#next-page]").click(function() {refreshUsers(null, null, "next");});
  $("a[href=#last-page]").click(function() {refreshUsers(null, null, "last");});
  $("a[rev=external]").each(function() { $(this).attr('target', '_blank'); });
  setUpFilter(defaultUserFilterText, filterUser);  
};