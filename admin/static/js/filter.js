var filterFocus = function(input, defaultText) {
  if ($(input).val() == defaultText) {
    $(input).val("");
    $(input).removeClass('default');
  }
};

var filterBlur = function(input, defaultText) {
  if ($(input).val() == "") {
    $(input).val(defaultText);
    $(input).addClass('default');
  }
};

var setUpFilter = function(defaultText, callback) {
  var input = $("input[name=filter]");
  $(input).each(function() {
    if ($(this).val() == "") {
      $(this).addClass('default');
      $(this).val(defaultText);
    }
    $(this).focus(function() { filterFocus($(this), defaultText); });
    $(this).blur(function() { filterBlur($(this), defaultText); });
    $(this).keyup(function(e) {
      if ((e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 13 || e.keyCode == 8 || e.keyCode == 127) {
        var txt = $(input).val();
        if (typeof(callback) === 'function') {
          callback(txt);
        }
      }
    });
  });
};