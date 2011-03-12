var addProduct = function() {
//  var v = $("input[name=productName]").val();
//  if (v == "") {
//    alert("You must enter a product name before adding a product item.");
//  } else {
//    
//  }
  editProduct();
};

var editProduct = function() {
  $.get("/product/edit", {}, function(xml) {
    $("#corps").html(xml);
  });
};

var deleteProducts = function() {
  var arr = getCheckedLines();
  if (arr[0] == "") {
    alert("You need to select at least one product to delete it.");
  } else if (confirm("Are you sure you want to delete the following products:\n" + arr[1])) {
    $.post("/product/delete", {pids:arr[0]}, function(xml) {
      var result = $(xml).find('result').text() == arr[2] ? true : false;
      if (result)
        refreshProducts();
      else
        alert("Impossible to delete products.");
    });
  }
};

var filterProduct = function(name, filter) {
  refreshCategories(null, filter, "", function() {
    if (lastFilterValue != filter) {
      lastFilterValue = filter;
      var input = $("input[name=" + name + "]");
      $(input).focus();
      var txt = $(input).val();
      $(input).val('');
      $(input).val(txt);
    }
  });
};

var refreshProducts = function(page, nameFilter, categoryFilter, typeFilter, action, callback) {
  if (page == null)
    page = $("a.current.other-page").text();
  
  if(nameFilter == null) nameFilter = $("input[name=nameFilter]").val();
  if (nameFilter == defaultProductNameFilterText) nameFilter = '';
  if(categoryFilter == null) categoryFilter = $("input[name=categoryFilter]").val();
  if (categoryFilter == defaultCategoryFilterText) categoryFilter = '';
  if(typeFilter == null) nameFilter = $("input[name=typeFilter]").val();
  if (typeFilter == defaultTypeFilterText) typeFilter = '';
  
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
  changeProduct("/product/view", nameFilter, categoryFilter, typeFilter, start, limit, callback);
};

var changeProduct = function(link, nameFilter, categoryFilter, typeFilter, start, limit, callback) {
  if (link   == null) link   = "/product/view";
  if (nameFilter == null) nameFilter = "";
  if (categoryFilter == null) categoryFilter = "";
  if (typeFilter == null) typeFilter = "";
  if (start  == null) start  = 0;
  if (limit  == null) limit  = 15;
  var param = {'nameFilter': nameFilter, 'categoryFilter':categoryFilter, 'typeFilter':typeFilter, 'start':start, 'limit':limit};
  $.post(link, param, function(xml) {
    $("#corps").html(xml);
    parseProduct();
    if (typeof(callback) === 'function') {
      callback();
    }
  }); 
};

var parseProduct = function() {
  $("#submit-product").click(addProduct);
  $("#create-product").submit(function() {addProduct();return false;});
  $("#create-product input").keypress(function(e) {if (e.keyCode == 13) {addProduct();return false;}});
  $("#list-products thead input:checkbox").click(checkAllLines);
  $("#list-products tbody input:checkbox").click(function() {checkLine($(this));});
  $("#list-products tbody td:nth-child(2) a").click(function() { editProduct($(this)); });
  $("a[href=#remove]").click(deleteProducts);
  $("select[name=limit]").change(function() {refreshProducts();});
  $("a.other-page").click(function() {refreshProducts($(this).text());});
  $("a[href=#first-page]").click(function() {refreshProducts(null, null, "first");});
  $("a[href=#prev-page]").click(function() {refreshProducts(null, null, "prev");});
  $("a[href=#next-page]").click(function() {refreshProducts(null, null, "next");});
  $("a[href=#last-page]").click(function() {refreshProducts(null, null, "last");});
  setUpFilter("nameFilter", defaultProductNameFilterText, filterProduct);
  setUpFilter("categoryFilter", defaultCategoryFilterText, filterProduct);
  setUpFilter("typeFilter", defaultTypeFilterText, filterProduct);
};