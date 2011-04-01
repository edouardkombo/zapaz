function isRFC822ValidEmail(sEmail) {
  var sQtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
  var sDtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
  var sAtom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
  var sQuotedPair = '\\x5c[\\x00-\\x7f]';
  var sDomainLiteral = '\\x5b(' + sDtext + '|' + sQuotedPair + ')*\\x5d';
  var sQuotedString = '\\x22(' + sQtext + '|' + sQuotedPair + ')*\\x22';
  var sDomain_ref = sAtom;
  var sSubDomain = '(' + sDomain_ref + '|' + sDomainLiteral + ')';
  var sWord = '(' + sAtom + '|' + sQuotedString + ')';
  var sDomain = sSubDomain + '(\\x2e' + sSubDomain + ')*';
  var sLocalPart = sWord + '(\\x2e' + sWord + ')*';
  var sAddrSpec = sLocalPart + '\\x40' + sDomain; // complete RFC822 email address spec
  var sValidEmail = '^' + sAddrSpec + '$'; // as whole string
  
  var reValidEmail = new RegExp(sValidEmail);
  
  if (reValidEmail.test(sEmail)) {
    return true;
  }
  
  return false;
}

var assertField = function(p, v, test) {
  var i = $("input[name="+v+"]");
  if (test(p[v])) {
    if ($(i).hasClass('red')) {
      $(i).removeClass('red');
    }
  } else {
    if (!$(i).hasClass('red')) {
      $(i).addClass('red');
    }
  }
};

var stringNotEmpty = function(v) {return v != "";};
var isDouble       = function(v) {return !isNaN(parseFloat(v));};
var isEmail        = function(v) { return v != "" && isRFC822ValidEmail(v); }

var updateShop = function() {
  var params = getFormValues("#ishop");
  params["id"]         = $("input[name=currentShopId]").val();
  params["logo"]       = $("input[name=hlogo]").val();
  params["keywords"]   = $("input[name=keywords]").val();
  params["currencyId"] = $("select[name=currency] option:selected").val();
  params["countryId"]  = $("select[name=country] option:selected").val();
  var keywords = "";
  $("#keywords span").each(function() {
    keywords += $(this).text() + ";";
  });
  params["keywords"] = keywords;
  assertField(params, "name", stringNotEmpty);
  assertField(params, "email", isEmail);
  assertField(params, "latitude", isDouble);
  assertField(params, "longitude", isDouble);
  assertField(params, "address0", stringNotEmpty);
  assertField(params, "zipCode", stringNotEmpty);
  assertField(params, "city", stringNotEmpty);
  if ($("input.red").length == 0) {
    $.post("/shop/update", params, function(xml) {
      var result = $(xml).find("result").text() == "1";
      var id = $(xml).find('id').text();
      $("input[name=currentShopId]").val(id);
      if (result) {
        alert("Data has been saved!");
      } else {
        alert("Impossible to update shop's information.");
      }
    });
  }
};

var initLogoChangeButton = function() {
  var a = document.createElement("a");
      a.setAttribute("href", "#logo");
      a.appendChild(document.createTextNode("Change logo"));
    $(a).click(askLogo);
    $(a).hide();
  $(".logo").append(a);
  $(".logo").hover(
    function() {$(a).show();},
    function() {$(a).hide();}
  );
};

var askLogo = function() {
  $.post("/shop/logo", function(xml) {
    showPopup(xml, function() {
      $("#popup form").ajaxForm({ success: function(xml) {
        var result = $(xml).find('result').text() == "1";
        var path   = $(xml).find('path').text();
        if (result) {
          hidePopup();
          $("input[name=hlogo]").val(path);
          $(".logo img").attr('src', 'http://static.shop.zap.com/' + path);
        }
      }});
      $("#popup #apply").click(function() { $("#popup form").submit(); });
    });
  });
};

var addKeyword = function() {
  var txt = $("input[name=word]").val();
  if (txt != "") {
    var found = false;
    $("#keywords").find("span").each(function() {
      if ($(this).text() == txt) {
        found = true;
      }
    });
    if (found) {
      alert("This word is already in the list.");
    } else {
      var span = document.createElement("span");
          span.appendChild(document.createTextNode(txt));
        $(span).click(function() { $(this).remove(); });
      $("#keywords").append("\n");
      $("#keywords").append(span);
      $("input[name=word]").val('');
    }
  }
};

var hideStateField = function() {
  $("input[name=state]").hide();
  $("input[name=state]").prev('label').hide();
};

var showStateField = function() {
  $("input[name=state]").show();
  $("input[name=state]").prev('label').show();
};

var refreshShop = function() {
  changeShop();
};

var changeShop = function() {
  var shopId = $("input[name=currentShopId]").val();
  $.post("/shop/view", {'shopId':shopId}, function(xml) {
    $("#corps").html(xml);
    parseShop();
  });
};

var parseShop = function() {
  hideStateField();
  initLogoChangeButton();
  $("#submit-shop").click(updateShop);
  $("#submit-word").click(addKeyword);
  $("input[name=word]").keypress(function(e) { if (e.keyCode == 13) addKeyword(); });
  $("input[name=latitude]").attr('disabled', true);
  $("input[name=longitude]").attr('disabled', true);
  $("input[name=state]").attr('disabled', true);
  $("#keywords span").each(function() { $(this).click(function() { $(this).remove(); }); });
  initGoogleMap();
};