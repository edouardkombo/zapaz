var updateGeoLocation = function(location) {
  $("input[name=latitude]").val(location.lat());
  $("input[name=longitude]").val(location.lng());
  mapMarker.setPosition(location);
  mapOverlay.setCenter(location);
  map.panTo(location);
  updateAddress(location);
};

var updateAddress = function(location) {
  var streetNumber = "";
  var route = "";
  var postalCode = "";
  var city = "";
  var state = "";
  var country = "";
  mapGeocoder.geocode({ 'latLng':location }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        if (results[1]) {
          for (i = 0; i<= 5; i++) {
            var a = results[i].address_components;
            for (j = 0; j < a.length; j++) {
              var t = a[j].types;
              if (t[0] == "street_number") {
                streetNumber = a[j].long_name;
              } else if (t[0] == "route") {
                route = a[j].long_name;
              } else if (t[0] == "postal_code") {
                postalCode = a[j].long_name;
              } else if (t[0] == "locality" && t[1] == "political") {
                city = a[j].long_name;
              } else if (t[0] == "administrative_area_level_1" && t[1] == "political") {
                state = a[j].long_name;
              } else if (t[0] == "country" && t[1] == "political") {
                country = a[j].long_name;
              }
            }
          }
          if (country != "United States") {
            state = "";
          }
          $("input[name=address0]").val(streetNumber + " " + route);
          $("input[name=zipCode]").val(postalCode);
          $("input[name=city]").val(city);
          $("input[name=state]").val(state);
          $("select[name=country] option").each(function() {
            if ($(this).text() == country) {
              $(this).attr('selected', true);
            }
          });
          if (state != "") {
            showStateField();
          } else {
            hideStateField();
          }
        }
    }
  });
};

var initGoogleMap = function() {
  var lat = $("input[name=latitude]").val();  
  var lng = $("input[name=longitude]").val(); 
  var zoom = 5;
  if (lat != 0 && lng != 0) zoom = 15;
  if (lat == 0) lat = 47;
  if (lng == 0) lng = 1;
  var latlng = new google.maps.LatLng(lat, lng);
  var myOptions = {
    zoom: zoom,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById("google-map-canvas"), myOptions);
  google.maps.event.addListener(map, 'click', function(e) {
    updateGeoLocation(e.latLng);
  });
  google.maps.event.addListener(map, 'zoom_changed', function() {
    map.panTo(mapMarker.getPosition());
  });
  mapMarker = new google.maps.Marker({
    position: latlng, 
    map: map,
    clickable: false,
    draggable: true
  });
  google.maps.event.addListener(mapMarker, 'drag', function(e) {
    updateGeoLocation(e.latLng);
  });
  mapOverlay = new google.maps.Circle({
    center: latlng,
    map: map,
    radius: 500,
    fillColor: "#7a00c8",
    fillOpacity: .3,
    strokeColor: "#7a00c8",
    strokeOpacity: .8,
    strokeWeight: 2
  });
  mapGeocoder = new google.maps.Geocoder();
};