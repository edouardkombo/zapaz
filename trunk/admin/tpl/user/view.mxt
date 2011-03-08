<div class="box">
  <h2>User list</h2>
  <input type="text" name="filter" mXattribut="value:filterValue" />
  <div class="box-content">
    <form method="post" action="#">
      <table id="list-users" class="dataview">
        <thead>

          <tr>
            <td><input type="checkbox" name="checkAll" value="0" /></td>
            <td><a href="#">email</a></td>
            <td><a href="#">choices</a></td>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="4">
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
        </tfoot>
        <tbody>
<mx:bloc id="row">
          <tr>
            <td><mx:bloc id="input"><mx:checker id="check" /></mx:bloc id="input"></td>
            <td><a href="#"><mx:text id="userEmail" /></a></td>
            <td><a href="#"><mx:text id="userChoices"/></a></td>
          </tr>
</mx:bloc id="row">
        </tbody>
      </table>
    </form>
  </div>
</div>