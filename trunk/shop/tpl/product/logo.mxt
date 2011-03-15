<div id="lock-background">
  <div id="popup">
    <h1>Change picture</h1>
    <p>Choose a file on your computer to upload and use as a regular picture for your product.</p>
    <form action="/product/update-logo" method="post" enctype="multipart/form-data">
      <fieldset>
        <legend>File to upload</legend>
        <label for="path">Path</label><input type="file" name="logo" id="path"/>
      </fieldset>
    </form>
    <div id="buttons">
      <div class="cancel-button">
        <div class="top"></div>
        <div class="content">Cancel</div>
      </div>
        <div class="submit-button">
        <div class="top"></div>
        <div class="content">Apply</div>
      </div>
    </div>
  </div>
</div>