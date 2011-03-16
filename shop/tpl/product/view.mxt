<div class="box">
  <h2>Product list</h2>
  <input title="Name filter" class="filter" type="text" name="nameFilter" mXattribut="value:nameFilter" />
  <input title="Type filter" class="filter" type="text" name="typeFilter" mXattribut="value:typeFilter" />
  <div class="box-content">
    <form method="post" action="#">
      <table id="list-products" class="dataview">
        <thead>

          <tr>
            <td><input type="checkbox" name="checkAll" value="0" /></td>
            <td><a href="#">Name</a></td>
            <td><a href="#">Type</a></td>
            <td><a href="#">Manufacturer</a></td>
            <td><a href="#">Price</a></td>
            <td><a href="#">Description</a></td>
            <td class="status"><a href="#" title="Image">I</a></td>
            <td class="status"><a href="#" title="Has an offer now">O</a></td>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="9">
              <ul class="list-of-actions">
                <li><a href="#remove">Delete</a></li>
              </ul>
              <ul class="list-of-actions right">
                <li>Show :</li>
                <li><mx:select id="limitSelect"/></li>
                <li class="separator">lines</li>
                <li><a href="#first-page" title="First page">&laquo;</a></li>
                <li><a href="#prev-page" title="Previous page">&lsaquo;</a></li>
<mx:bloc id="pageNav">
                <li><a mXattribut="href:pageNumberLink" mXattribut="class:pageNumberClass"><mx:text id="pageNumberText" /></a></li>
</mx:bloc id="pageNav">
                <li><a href="#next-page" title="Next page">&rsaquo;</a></li>
                <li><a href="#last-page" mXattribut="rel:maxPage" title="Last page">&raquo;</a></li>
              </ul>
            </td>
          </tr>
          <tr>
            <td colspan="9" class="right">
              <div id="create-product">
                <mx:formField id="newProduct"/>
                <div id="submit-product" class="submit-button">
                  <div class="top"></div>
                  <div class="content">Add new product</div>
                </div>
              </div>
            </td>
          </tr>
        </tfoot>
        <tbody>
<mx:bloc id="row">
          <tr>
            <td><mx:bloc id="input"><mx:checker id="check" /></mx:bloc id="input"></td>
            <td><a href="#"><mx:text id="name" /></a></td>
            <td><mx:text id="type"/></td>
            <td><mx:text id="manufacturer"/></td>
            <td><mx:text id="price"/></td>
            <td><mx:text id="description"/></td>
            <td><div mXattribut="class:c1"><mx:image id="light1"/></div></td>
            <td><div mXattribut="class:c2"><mx:image id="light2"/></div></td>
          </tr>
</mx:bloc id="row">
        </tbody>
      </table>
    </form>
  </div>
</div>