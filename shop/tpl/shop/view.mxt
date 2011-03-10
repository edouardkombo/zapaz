<div class="box">
  <h2>Shop information</h2>
  <div class="box-content">
    <table id="ishop" cellpadding="0" cellspacing="0">
      <tr>
        <td id="ishop-fields">
          <form method="post" action="#">
            <div class="fieldset" id="help-location">
              <h3>Your location</h3>
                <p>To apply your data, you need to provide as precisely as possible your geolocation. This geolocation is used to define an area of influence in which users will be able to access to your advertisements and products information. You can have only one geolocation for now.</p>
                <p>Move on the map to your location and click on the place you are. A draggable pin will appear corresponding to your shop and so your center of influence area. Your influence area is then displayed as a circle. Everybody in that circle has the ability to watch your advertisements, looking for products or basic shop information.</p>
                <p>Based on information fetched from the map. Some of the following fields could be completed if there are not.</p>
            </div>
            <fieldset>
              <legend>Basic</legend>
              <mx:hidden id="hlogo" />
              <div id="logo"><img alt="logo" width="96" height="96" mXattribut="src:logo"/></div>
              <div id="rlogo">
                <label for="name">Name <span class="required">*</span></label><mx:formField id="name" />
                <label for="email">Email <span class="required">*</span></label><mx:formField id="email" />
                <label for="latitude">Latitude <span class="required">*</span></label><mx:formField id="latitude" />
                <label for="longitude">Longitude <span class="required">*</span></label><mx:formField id="longitude" />
                <label for="webServiceUrl">Web Service URL</label><mx:formField id="webServiceUrl" />
                <label for="currency">Currency <span class="required">*</span></label><mx:select id="currency" />
              </div>
            </fieldset>
            <fieldset>
              <legend>Details</legend>
              <label for="address0">Address <span class="required">*</span></label><mx:formField id="address0" />
              <mx:formField id="address1" />
              <mx:formField id="address2" />
              <label for="zipCode">Zip code <span class="required">*</span></label><mx:formField id="zipCode" />
              <label for="city">City <span class="required">*</span></label><mx:formField id="city" />
              <label for="state">State</label><mx:formField id="state" />
              <label for="country">Country <span class="required">*</span></label><mx:select id="country" />
              <label for="phone">Phone</label><mx:formField id="phone" />
            </fieldset>
            <fieldset>
              <legend>Keywords</legend>
              <p>By providing keywords, you help users to find easier what they are interested in an increase the probability to have more visitors becoming customers.</p>
              <p>You really need to fill that section if you don't plan to list your products and offers in that database. Contrariwise, if you plan to insert in a short time information about your products, this section will be automatically completed.</p>
              <div id="keywords"></div>
              <label for="word">Keyword</label><input type="text" name="word" value="" id="word"/>
              <div id="submit-word" class="submit-button">
                <div class="top"></div>
                <div class="content">Add</div>
              </div>
            </fieldset>
            <div class="fieldset">
              <div id="submit-shop" class="submit-button">
                <div class="top"></div>
                <div class="content">Apply changes</div>
              </div>
            </div>
          </form>
        </td>
        <td id="map-fields">
          <div id="google-map-canvas">
            <mx:bloc id="word">
              <span><mx:text id="value"/></span>
            </mx:bloc id="word">
          </div>
        </td>
      </tr>
    </table>
  </div>
</div>
