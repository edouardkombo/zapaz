var addUser = function() {
};

var editUser = function(user) {

};

var doEditUser = function(input) {
 
};

var deleteUsers = function() {
 
};


var filterUser = function(filter) {
 refreshUsers(null, filter, "", function() {
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

var changeUser = function() {
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
  $("#submit-user").click(addUser);
  $("#create-user").submit(function() {addUser();return false;});
  $("#create-user input").keypress(function(e) {if (e.keyCode == 13) {addUser();return false;}});
  $("#list-users thead input:checkbox").click(checkAllLines);
  $("#list-users tbody input:checkbox").click(function() {checkLine($(this));});
  $("#list-users tbody td:nth-child(2) a").click(function() { editUser($(this)); });
  $("a[href=#remove]").click(deleteUsers);
  $("select[name=limit]").change(function() {refreshUsers();});
  $("a.other-page").click(function() {refreshShops($(this).text());});
  $("a[href=#first-page]").click(function() {refreshUsers(null, null, "first");});
  $("a[href=#prev-page]").click(function() {refreshUsers(null, null, "prev");});
  $("a[href=#next-page]").click(function() {refreshUsers(null, null, "next");});
  $("a[href=#last-page]").click(function() {refreshUsers(null, null, "last");});
  setUpFilter(defaultUserFilterText, filterUser);  
};