<div id="lock-background">
  <div id="popup">
    <h1>Create an Offer</h1>
    <p></p>
    <form class="offer" action="/offer/create" method="post">
      <fieldset>
       

        <mx:hidden id="hidden" />
        <div class="commercialImage">
          <img alt="picture" width="96" height="96" mXattribut="src:ppicture"/>
        </div>
       
          <label> Display Only Image  </label><input type="checkbox"  name="displayOnlyImage" />
          <label> Offer Price </label><input type="text"  name="newPrice" value=""/>
          <label> StartTime </label><input type="date" name="startTime" />
          <label> EndTime </label><input type="date" name="endTime" />
            
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