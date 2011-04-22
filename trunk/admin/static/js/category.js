var addCategory = function() {
  var n = $("input[name=categoryName]").val();
  $.post(rootUrl + "category/update", {name:n}, function(xml) {
    var result = $(xml).find('result').text() == '1' ? true : false;
    if (result)
      refreshCategories();
    else
      alert("The operation failed!");
  });
};

var editCategory = function(category) {
  var txt = $(category).text();
  var input = document.createElement('input');
      input.setAttribute('name', 'categoryNewName');
      input.setAttribute('type', 'text');
      input.setAttribute('value', txt);
      input.setAttribute('old', txt);
    $(input).keypress(function(e) {if (e.keyCode == 13) {doEditCategory($(this));return false;}});
    $(input).blur(function() { doEditCategory($(this)); });
  $(category).parent('td').addClass('editing');
  $(category).replaceWith(input);
  $(input).focus();
};

var doEditCategory = function(input) {
  var id   = $(input).parent('td').prev('td').children('input').val();
  var name = $(input).val();
  var oldValue = $(input).attr('old');
  
  var param = {"id":id, "name":name};
  $.post(rootUrl + "category/update", param, function(xml) {
    var result = $(xml).find('result').text() == '1' ? true : false;
    var txt = oldValue;
    if (result) {
      txt = name;
    } else {
      alert("Category can't be updated.");
    }
    var a = document.createElement('a');
        a.setAttribute('href', '#');
        a.appendChild(document.createTextNode(txt));
      $(a).click(function() {editCategory($(this));});
    $(input).parent('td').removeClass('editing');
    $(input).replaceWith(a);
  });
};

var deleteCategories = function() {
  var arr = getCheckedLines();
  if (arr[0] == "") {
    alert("You need to select at least one category to delete it.");
  } else if (confirm("Are you sure you want to delete the following categories:\n" + arr[1])) {
    $.post(rootUrl + "/category/delete", {pids:arr[0]}, function(xml) {
      var result = $(xml).find('result').text() == arr[2] ? true : false;
      if (result)
        refreshCategories();
      else
        alert("Impossible to delete categories.");
    });
  }
};

var filterCategory = function(filter) {
  refreshCategories(null, filter, "", function() {
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

var refreshCategories = function(page, filter, action, callback) {
  if (page == null)
    page = $("a.current.other-page").text();
  if(filter == null)
    filter = $("input[name=filter]").val();
  if (filter == defaultCategoryFilterText)
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
  changeCategory(rootUrl + "/category/view", filter, start, limit, callback);
};

var changeCategory = function(link, filter, start, limit, callback) {
  if (link   == null) link   = rootUrl + "/category/view";
  if (filter == null) filter = "";
  if (start  == null) start  = 0;
  if (limit  == null) limit  = 15;
  var param = {'filter': filter, 'start':start, 'limit':limit};
  $.post(link, param, function(xml) {
    $("#corps").html(xml);
    parseCategory();
    if (typeof(callback) === 'function') {
      callback();
    }
  });
};

var parseCategory = function() {
  $("#submit-category").click(addCategory);
  $("#create-category").submit(function() {addCategory();return false;});
  $("#create-category input").keypress(function(e) {if (e.keyCode == 13) {addCategory();return false;}});
  $("#list-categories thead input:checkbox").click(checkAllLines);
  $("#list-categories tbody input:checkbox").click(function() {checkLine($(this));});
  $("#list-categories tbody td:nth-child(2) a").click(function() { editCategory($(this)); });
  $("a[href=#remove]").click(deleteCategories);
  $("select[name=limit]").change(function() {refreshCategories();});
  $("a.other-page").click(function() {refreshCategories($(this).text());});
  $("a[href=#first-page]").click(function() {refreshCategories(null, null, "first");});
  $("a[href=#prev-page]").click(function() {refreshCategories(null, null, "prev");});
  $("a[href=#next-page]").click(function() {refreshCategories(null, null, "next");});
  $("a[href=#last-page]").click(function() {refreshCategories(null, null, "last");});
  setUpFilter(defaultCategoryFilterText, filterCategory);
};