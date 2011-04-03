<div id="lock-background">
  <div id="popup">
    <h1>Create an Offer</h1>
    <p></p>
    <form id="detail-types-list" action="/offer/create" method="post">
      <fieldset>
        <label> Current Offer </label><input type="text" name="currentOffer" class="date" placeholder="No offer"/>
        <p> <br />  <br />  </p>
        <label> Offer Price </label><input type="text"  name="newPrice" placeholder="Enter a price" value=""/>
        <label> StartTime </label><input type="date" class="date" name="startTime" />
        <label> EndTime </label><input type="date" class="date" name="endTime" />

      </fieldset>

        <div id="submit-offer" class="button">
          <div class="top"></div>
          <div class="content">Add</div>
        </div>
    </form>
    <div id="close" class="button new-type">
      <div class="top"></div>
      <div class="content">Close</div>
    </div>
  </div>
</div>