var addProduct = function() {
//  var v = $("input[name=productName]").val();
//  if (v == "") {
//    alert("You must enter a product name before adding a product item.");
//  } else {
//    
//  }
  editProduct();
};

var addDetailLine = function() {
  var select = document.createElement('select');
  
  var td = document.createElement('td');
    $(td).append();
}

var editProduct = function() {
  $.get("/product/edit", {}, function(xml) {
    $("#corps").html(xml);
    initPictureChangeButton();
    $("#edit-detail-types").click(editDetailTypeList);
    $("input[name=detailName]").keypress(function(e) { if (e.keyCode == 13) { addNewDetailTypeLine(); return false; }});
    $("input[name=detailName]").blur(addNewDetailTypeLine);
    $("#update-product").click(updateProduct);
    $("#cancel").click(refreshProducts);
  });
};

var updateProduct = function() {
  var params = {};
  params["picture"]      = $("input[name=hpicture]").val();
  params["name"]         = $("input[name=name]").val();
  params["manufacturer"] = $("input[name=manufacturer]").val();
  params["shop"]         = $("select[name=shop]").val();
  params["category"]     = $("select[name=category]").val();
  params["type"]         = $("select[name=type]").val();
  params["price"]        = $("input[name=price]").val();
  params["description"]  = $("textarea[name=description]").val();
  var details = "";
  $("#product-details input").each(function() {
    if ($(this).val() != "") {
      var v = $(this).parent('td').prev('td').children('select').val();
      if (details != "") {
        details += "||";
      }
      details += v + ";" + $(this).val();
    }
  });
  params["details"] = details;
  $.post("/product/update", params, function(xml) {
    var result = $(xml).find('result').text() == "1";
    if (result) {
      refreshProducts();
    } else {
      alert(xml);
    }
  });
};

var addNewDetailTypeLine = function() {
  if ($("#product-details tbody tr:last input").val() != "") {
    var tr = $("#product-details tbody tr:last").clone();
    $("#product-details tbody").append(tr);
    $("#product-details tbody tr:last input").val('');
    $("#product-details tbody tr:last input").keypress(function(e) { if (e.keyCode == 13) { addNewDetailTypeLine(); return false; }});
    $("#product-details tbody tr:last input").blur(addNewDetailTypeLine);
  }
};

var editDetailTypeList = function() {
  $.get("/product/edit-detail-types", function(xml) {
    $("body").append(xml);
    $("#popup").css('left', '-1000px');
    $("#lock-background").fadeIn('normal', function() {
      var height = $("#popup").innerHeight();
      var top = (parseInt($("body").innerHeight(), 10) - height - 60) / 2;
      $("#popup").css('top', top + 'px');
      var left = (parseInt($("body").innerWidth(), 10) - 780 - 10) / 2;
      $("#popup").animate({'left':left + 'px'});
    });
    $("#popup #type-values span").each(function() {
      $(this).click(function() {removeDetailType($(this));});
    });
    $("#popup #submit-new-type").click(addDetailType);
    $("#popup input[name=newType]").keypress(function(e) {if (e.keyCode == 13) {addDetailType();return false;}});
    $("#popup #submit-close").click(function() {
      $("#lock-background").fadeOut('normal', function() {
        var select = document.createElement('select');
            select.setAttribute('name', 'detailType');
        $("#type-values span").each(function() {
          var opt = document.createElement('option');
              opt.setAttribute('value', $(this).text());
              opt.appendChild(document.createTextNode( $(this).text() ));
          select.appendChild(opt);
        });
        $(select).replaceAll("select[name=detailType]");
        $("#lock-background").remove();
        
      });
    });
  });  
};

var addDetailType = function() {
  var v = $("input[name=newType]").val().toLowerCase();
  if (v == "") return;
  if (v.length > 12) {
    alert("Type is too long. Twelve characters max.");
    return;
  }
  var ok = true;
  $("#type-values span").each(function() {
    if ($(this).text().toLowerCase() == v) {
      ok = false;
    }
  });
  if (!ok) {
    alert("This type is already in the list.");
  } else {
    $.post("/product/add-detail-type", {"type":v}, function(xml) {
      var result = $(xml).find('result').text() == "1";
      if (result) {
        var span = document.createElement('span');
            span.appendChild(document.createTextNode(v));
          $(span).click(function() {removeDetailType($(this));});
        $("#type-values").append("\n");
        $("#type-values").append(span);
        $("input[name=newType]").val('');
      } else {
        alert("Failed to save the type.");
      }
    });
  }
};

var removeDetailType = function(elt) {
  var v = $(elt).text();
  $.post("/product/remove-detail-type", {"type":v}, function(xml) {
    var result = $(xml).find('result').text() == "1";
    if (result) {
      $(elt).remove();
    } else {
      alert("Failed to remove the type");
    }
  });
}

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

var initPictureChangeButton = function() {
  var a = document.createElement("a");
      a.setAttribute("href", "#logo");
      a.appendChild(document.createTextNode("Change picture"));
    $(a).click(askPicture);
    $(a).hide();
  $(".logo").append(a);
  $(".logo").hover(
    function() {$(a).show();},
    function() {$(a).hide();}
  );
};

var askPicture = function() {
  $.post("/product/logo", function(xml) {
    $("body").append(xml);
    $("#popup form").ajaxForm({success: function(xml) {
      var result = $(xml).find('result').text() == "1";
      var path   = $(xml).find('path').text();
      if (result) {
        $("#lock-background").fadeOut('normal', function() {$("#lock-background").remove();});
        $("input[name=hpicture]").val(path);
        $(".logo img").attr('src', 'http://static.shop.zap.com/' + path);
      }
    }});
    $("#popup").css('left', '-1000px');
    $("#lock-background").fadeIn('normal', function() {
      var height = $("#popup").innerHeight();
      var top = (parseInt($("body").innerHeight(), 10) - height - 60) / 2;
      $("#popup").css('top', top + 'px');
      var left = (parseInt($("body").innerWidth(), 10) - 780 - 10) / 2;
      $("#popup").animate({'left':left + 'px'});
    });
    $("#popup .cancel-button").click(function() {$("#lock-background").fadeOut('normal', function() {$("#lock-background").remove();});});
    $("#popup .submit-button").click(function() {$("#popup form").submit();});
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
  $("#list-products tbody td:nth-child(2) a").click(function() {editProduct($(this));});
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