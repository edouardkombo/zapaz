var createOffer = function(a) {
    var lineId = $(a).parent('td').parent('tr').find('input[name=check]').val();
    checkOffer(lineId);
    $.get("/offer/create", {id:lineId}, function(xml) {
    showPopup(xml, function() {;     
      $("#popup #type-values span").each(function() {$(this).click(function() {removeDetailType($(this));});});
      initPictureChangeButton();
      $("#popup #submit-offer").click(function() {addOffer(lineId);});
      $("#popup #submit-close").click(function() {
        $("#lock-background").fadeOut('normal', function() {
          $("#lock-background").remove();
        });
      });
    });
  });  
};



/*
 * This function check if this product has another offer
 */

function checkOffer(productId){
  var offerId = hasOffer(productId);
    if(offerId != null){
      if (confirm('Are you sure to delete the current offer')) {
        removeOffer(offerId);
      }
    }
}

/**
 * return the id of the offer if exists
 */
 function hasOffer(pId) {
   var v = pId;
   var offId = null;
   $.post("/product/hasOffer", {id:v}, function(xml) {
    alert(xml);
    var offerId = $(xml).find('offerId').text();
    offId = offerId;  
  });
  return offId;
  }
  
  
var addOffer = function(productId){
  
 var ok = true;
  var date1 = $("input[name=startTime]").val();
  var date2 = $("input[name=endTime]").val();
  
  if(date1==''){
    ok = false;
    alert("Enter a valid Start date");    
  } 
  else if (date2==''){
    ok = false;
    alert("Enter a valid end date");    
  } 
  else if(!compareDates()){
    ok = false;
    alert('Error: EndTime must be greater than StartTime ');
  }
  var params = {};
  params["productId"]  = productId;
  params["price"] = $("input[name=newPrice]").val();
  params["startTime"] = $("input[name=startTime]").val();
  params["endTime"]   = $("input[name=endTime]").val();
  if($("input[name=displayOnlyImage]").attr('checked')){
    params["displayOnlyImage"] = 1;
  }else{params["displayOnlyImage"] = 0;}
  
  if (ok) {
    $.post("/offer/update", params, function(xml) {     
    var result = $(xml).find('result').text() == "1";
    alert(xml);
      if (result) {
        alert("Offer saved");
        refreshProducts();
      } else {
       alert("Failed to save the offer");
      }
    });
  };
};

var removeOffer = function(offerId){
  var v = offerId;
  $.post("/offer/delete", {id:v}, function(xml) {
    var result = $(xml).find('result').text() == "1";
    if (result) {
      refreshProducts();
    } else {
      alert("Failed to remove the offer");
    }
  });
}


function compareDates(){

var start = $("input[name=startTime]").val();
var end = $("input[name=endTime]").val();
var day1,month1,year1,day2,month2,year2;

month1 = start.substring(5, 7) - 1; 
day1 = start.substring(8, 10) - 0;
year1 = start.substring(0, 4) - 0;

month2 = end.substring(5, 7) - 1; 
day2 = end.substring(8, 10) - 0;
year2 = end.substring(0, 4) - 0;


var date1 = new Date(year1,month1,day1);
var date2 = new Date(year2,month2,day2);

if (date1 < date2){ 
  return true;
}
else{return false;}

}
var initPictureChangeButton = function() {
  var a = document.createElement("a");
      a.setAttribute("href", "#commercialImage");
      a.appendChild(document.createTextNode("Upload picture"));
    $(a).click(askPicture);
    $(a).hide();
  $(".commercialImage").append(a);
  $(".commercialImage").hover(
    function() {$(a).show();},
    function() {$(a).hide();}
  );
};



var askPicture = function() {
  $.post("/offer/commercialImage", function(xml) {
    showPopup(xml, function() {
      $("#popup form").ajaxForm({success: function(xml) {
        var result = $(xml).find('result').text() == "1";
        var path   = $(xml).find('path').text();
        if (result) {
          hidePopup(function() {
            $("input[name=hpicture]").val(path);
            $(".commercialImage img").attr('src', 'http://static.shop.zap.com/' + path);
          });
        }
      }});
      $("#popup #apply").click(function() {$("#popup form").submit();});
    });
  });
};