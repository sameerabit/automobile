<div>
        <div class="modal fade" id="modal-warning">
                <div class="modal-dialog">
                  <div class="modal-content bg-warning">
                    <div class="modal-header">
                      <h4 class="modal-title">Are you sure you want to delete?</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                      <p>Please Note: This action cannot be reversed.</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                      <button id="delete" type="button" class="btn btn-danger">Delete</button>
                    </div>
                  </div>
                </div>
        </div>
        @push('scripts')
   <script>
     
      $(function(){

          var form;

          $(document).on('click','.delete-btn',function(event){
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
            form = $(this).closest('form');
          });

          $('#delete').click(function(){
                form.submit();
          });
          
      });
    
   </script>
@endpush
</div>
