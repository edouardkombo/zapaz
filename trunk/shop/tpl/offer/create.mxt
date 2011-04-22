<div id="lock-background">
  <div id="popup">
    <h1>Create an Offer</h1>
    <p></p>
    <form id="offer" action="offer/create" method="post">
      <fieldset>
        <mx:hidden id="hidden" />
        <div class="commercialImage">
          <img alt="picture" width="96" height="96" mXattribut="src:ppicture"/>
        </div>
        <div class="right-pane">
          <label>Only image</label><input type="checkbox" name="displayOnlyImage" />
          <label>Offer price</label><input type="text" name="newPrice" value=""/>
          <label>From</label><input type="date" name="startTime" />
          <label>to</label><input type="date" name="endTime" />
        </div>
      </fieldset>
    </form>
    <div id="buttons">
      <div id="submit-offer" class="button"><div class="top"></div><div class="content">Add</div></div>
      <div id="close" class="button"><div class="top"></div><div class="content">Close</div></div>
    </div>
  </div>
</div>