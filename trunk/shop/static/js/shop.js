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
  params["logo"] = $("input[name=hlogo]").val();
  params["id"] = $("input[name=id]").val();
  params["currencyId"] = $("select[name=currency] option:selected").val();
  params["countryId"] = $("select[name=country] option:selected").val();
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
  $("#logo").append(a);
  $("#logo").hover(
    function() {$(a).show();},
    function() {$(a).hide();}
  );
};

var askLogo = function() {
  $.post("/shop/logo", function(xml) {
    $("body").append(xml);
    $("#popup form").ajaxForm({ success: function(xml) {
      var result = $(xml).find('result').text() == "1";
      var path   = $(xml).find('path').text();
      if (result) {
        $("#lock-background").fadeOut('normal', function() { $("#lock-background").remove(); });
        $("input[name=hlogo]").val(path);
        $("#logo img").attr('src', 'http://static.shop.zap.com/' + path);
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
    $("#popup .cancel-button").click(function() { $("#lock-background").fadeOut('normal', function() { $("#lock-background").remove(); }); });
    $("#popup .submit-button").click(function() { $("#popup form").submit(); });
  });
};

var changeShop = function() {
  
};

var parseShop = function() {
  initLogoChangeButton();
  $("#submit-shop").click(updateShop);
};