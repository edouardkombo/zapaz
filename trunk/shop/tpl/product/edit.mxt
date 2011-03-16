<div class="box">
  <h2>Product edition</h2>
  <div class="box-content">
    <form method="post" action="#" id="edit-product" class="regular">
      <fieldset>
        <legend>Product information</legend>
        <mx:hidden id="hidden" />
        <div class="logo">
          <img alt="picture" width="96" height="96" mXattribut="src:ppicture"/>
        </div>
        <div class="info">
          <label for="name">Name</label><mx:formField id="name"/>
          <label for="manufacturer">Manufacturer</label><mx:formField id="manufacturer"/>
          <label for="shop">Shop</label><mx:select id="shop"/>
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
          <tfoot>
            <tr>
              <td><a href="#edit-types" id="edit-detail-types">Edit List</a></td>
              <td>&nbsp;</td>
            </tr>
          </tfoot>
          <tbody>
            <mx:bloc id="detail">
              <tr>
                <td><mx:select id="type" /></td>
                <td><mx:formField id="name" /></td>
              </tr>
            </mx:bloc id="detail">
          </tbody>
        </table>
      </fieldset>
      <div class="fieldset">
        <div id="update-product" class="submit-button">
          <div class="top"></div>
          <div class="content">Save</div>
        </div>
        <div id="cancel" class="cancel-button">
          <div class="top"></div>
          <div class="content">Cancel</div>
        </div>
      </div>
    </form>
  </div>
</div>
