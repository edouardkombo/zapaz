<div id="lock-background">
  <div id="popup">
    <h1>Detail Types</h1>
    <p>You can add or remove types below. When adding a type, this one will be automatically saved. Click on the close button when you have finish.</p>
    <form id="detail-types-list" action="/product/update-logo" method="post">
      <div class="fieldset">
        <legend>Values</legend>
        <div id="type-values">
          <mx:bloc id="type">
            <span><mx:text id="value"/></span>
          </mx:bloc id="type">
        </div>
        <div id="submit-new-type" class="button">
          <div class="top"></div>
          <div class="content">Add</div>
        </div>
        <input type="text" value="" name="newType" id="newType"/>
        <label for="newType">New value</label>
      </fieldset>
    </form>
    <div id="close" class="button new-type">
      <div class="top"></div>
      <div class="content">Close</div>
    </div>
  </div>
</div>