<div class="box">
  <h2>Product edition</h2>
  <div class="box-content">
    <form method="post" action="#" id="edit-product" class="regular">
      <fieldset>
        <legend>Product information</legend>
        <div class="logo">
          <img alt="picture" width="96" height="96" mXattribut="src:plogo"/>
        </div>
        <div class="info">
          <label for="name">Name</label><mx:formField id="name"/>
          <label for="manufacturer">Manufacturer</label><mx:formField id="manufacturer"/>
          <label for="category">Category</label><mx:select id="category"/>
          <label for="type">Type</label><mx:select id="type"/>
          <label for="price">Price</label><mx:formField id="price"/>
          <label for="description">Description</label><mx:formField id="description"/>
        </div>
      </fieldset>
      <fieldset>
        <legend>Product details</legend>
        <p>Use this section to provide specific information about that product such as available colors, its materials or any other information that a customer could need.</p>
        <p>Examples:</p>
        <ul>
          <li>Color: Blue</li>
          <li>Color: Black</li>
          <li>Material: Carbon</li>
          <li>Material: PVC</li>
          <li>Material: PPSU</li>
          <li>Life span: 10 years</li>
          <li>Guarantee: 3 years</li>
          <li>...</li>
        </ul>
        <table cellspacing="0" cellpadding="0" id="product-details">
          <thead>
            <tr>
              <td>Type</td>
              <td>Value</td>
            </tr>
          </thead>
          <tbody>
            <mx:bloc id="detail">
              <tr>
                <td><mx:formField id="type" /></td>
                <td><mx:formField id="name" /></td>
              </tr>
            </mx:bloc id="detail">
          </tbody>
        </table>
      </fieldset>
      <fieldset>
        <legend>Offer</legend>
        <div class="logo">
          <img alt="picture" width="96" height="96" mXattribut="src:ologo"/>
          <label for="onlyImage">Display Only Image</label><input type="checkbox" name="onlyImage" mXattribut="value:onlyImage"/>
        </div>
        <div class="info">
          <label for="discountPrice">Discount Price</label><mx:formField id="discountPrice"/>
          <label for="startTime">Start Time</label><mx:formField id="startTime"/>
          <label for="endTime">End Time</label><mx:formField id="endTime"/>
        </div>
      </fieldset>
      <div class="fieldset">
        <mx:hidden id="productId" />
        <div id="update-product" class="submit-button right">
          <div class="top"></div>
          <div class="content">Save</div>
        </div>
        <div id="cancel" class="cancel-button right">
          <div class="top"></div>
          <div class="content">Cancel</div>
        </div>
      </div>
    </form>
  </div>
</div>
