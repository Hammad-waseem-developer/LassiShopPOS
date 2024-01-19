  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div style="background-color: white; border:0px;" class="modal-content">
        
        <div style="display: flex;
        flex-direction: column;
        align-items: center; padding-top: 20px;" class="modal-body">
            <div class="swal2-icon swal2-warning pulse-warning" style="display: block;">!</div>
            <h2 style="color: #595959;
            font-size: 30px;
            font-weight: 600;
            text-transform: none;
            margin: 0;
            padding: 0;
            line-height: 60px;
            display: block;">Are you sure ?</h2>
            <div class="swal2-content" style="font-size: 18px;
            text-align: center;
            font-weight: 300;
            position: relative;
            float: none;
            margin: 0;
            padding: 0;
            line-height: normal;
            color: #545454;">You wont be able to revert this !</div>
           
        </div>
        <div style="justify-content: center; border-top: 0px; padding: 40px 0px 20px 0px;" class="modal-footer">
            <button type="button" class="swal2-confirm btn btn-primary me-5 btn-ok" onclick="deleteDepartment()">Yes, delete it</button>
            <button data-dismiss="modal" aria-label="Close" type="button" class="swal2-cancel btn btn-danger" style="display: inline-block;">No, cancel!</button>
        </div>
      </div>
    </div>
  </div>