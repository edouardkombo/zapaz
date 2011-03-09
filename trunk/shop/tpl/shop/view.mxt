<div class="box">
  <h2>Shop information</h2>
  <div class="box-content">
    <table id="ishop" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <form method="post" action="#">
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
              <div id="submit-shop" class="submit-button">
                <div class="top"></div>
                <div class="content">Apply changes</div>
              </div>
            </fieldset>
          </form>
        </td>
        <td>
          <div id="google-map-canvas"></div>
        </td>
      </tr>
    </table>
  </div>
</div>
