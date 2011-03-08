var addUser = function() {
};

var editUser = function(user) {

};

var doEditUser = function(input) {
 
};

var deleteUsers = function() {
 
};


var filterUser = function(filter) {

};

var refreshUsers = function(page, filter, action, callback) {

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
  setUpFilter(defaultCategoryFilterText, filterCategory);  
};