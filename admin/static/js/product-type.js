var addProductType = function() {
  var n = $("input[name=typeName]").val();
  $.post(rootUrl + "product-type/update", {name:n}, function(xml) {
    var result = $(xml).find('result').text() == '1' ? true : false;
    if (result)
      refreshProductTypes();
    else
      alert("The operation failed!");
  });
};

var editProductType = function(productType) {
  var txt = $(productType).text();
  var input = document.createElement('input');
      input.setAttribute('name', 'typeNewName');
      input.setAttribute('type', 'text');
      input.setAttribute('value', txt);
      input.setAttribute('old', txt);
    $(input).keypress(function(e) {if (e.keyCode == 13) {doEditProductType($(this));return false;}});
    $(input).blur(function() { doEditProductType($(this)); });
  $(productType).parent('td').addClass('editing');
  $(productType).replaceWith(input);
  $(input).focus();
};

var doEditProductType = function(input) {
  var id   = $(input).parent('td').prev('td').children('input').val();
  var name = $(input).val();
  var oldValue = $(input).attr('old');
  
  var param = {"id":id, "name":name};
  $.post(rootUrl + "product-type/update", param, function(xml) {
    var result = $(xml).find('result').text() == '1' ? true : false;
    var txt = oldValue;
    if (result) {
      txt = name;
    } else {
      alert("Product type can't be updated.");
    }
    var a = document.createElement('a');
        a.setAttribute('href', '#');
        a.appendChild(document.createTextNode(txt));
      $(a).click(function() {editProductType($(this));});
    $(input).parent('td').removeClass('editing');
    $(input).replaceWith(a);
  });
};

var deleteProductTypes = function() {
  var arr = getCheckedLines();
  if (arr[0] == "") {
    alert("You need to select at least one productType to delete it.");
  } else if (confirm("Are you sure you want to delete the following productTypes:\n" + arr[1])) {
    $.post(rootUrl + "/product-type/delete", {pids:arr[0]}, function(xml) {
      var result = $(xml).find('result').text() == arr[2] ? true : false;
      if (result)
        refreshProductTypes();
      else
        alert("Impossible to delete productTypes.");
    });
  }
};

var filterProductType = function(filter) {
  refreshProductTypes(null, filter, "", function() {
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

var refreshProductTypes = function(page, filter, action, callback) {
  if (page == null)
    page = $("a.current.other-page").text();
  if(filter == null)
    filter = $("input[name=filter]").val();
  if (filter == defaultProductTypeFilterText)
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
  changeProductType(rootUrl + "/product-type/view", filter, start, limit, callback);
};

var changeProductType = function(link, filter, start, limit, callback) {
  if (link   == null) link   = rootUrl + "/product-type/view";
  if (filter == null) filter = "";
  if (start  == null) start  = 0;
  if (limit  == null) limit  = 15;
  var param = {'filter': filter, 'start':start, 'limit':limit};
  $.post(link, param, function(xml) {
    $("#corps").html(xml);
    parseProductType();
    if (typeof(callback) === 'function') {
      callback();
    }
  });
};

var parseProductType = function() {
  $("#submit-type").click(addProductType);
  $("#create-type").submit(function() {addProductType();return false;});
  $("#create-type input").keypress(function(e) {if (e.keyCode == 13) {addProductType();return false;}});
  $("#list-types thead input:checkbox").click(checkAllLines);
  $("#list-types tbody input:checkbox").click(function() {checkLine($(this));});
  $("#list-types tbody td:nth-child(2) a").click(function() { editProductType($(this)); });
  $("a[href=#remove]").click(deleteProductTypes);
  $("select[name=limit]").change(function() {refreshProductTypes();});
  $("a.other-page").click(function() {refreshProductTypes($(this).text());});
  $("a[href=#first-page]").click(function() {refreshProductTypes(null, null, "first");});
  $("a[href=#prev-page]").click(function() {refreshProductTypes(null, null, "prev");});
  $("a[href=#next-page]").click(function() {refreshProductTypes(null, null, "next");});
  $("a[href=#last-page]").click(function() {refreshProductTypes(null, null, "last");});
  setUpFilter(defaultProductTypeFilterText, filterProductType);
};