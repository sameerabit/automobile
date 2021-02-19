<div>
        <div class="modal fade" id="modal-confirm">
                <div class="modal-dialog">
                  <div class="modal-content bg-primary">
                    <div class="modal-header">
                      <h4 class="modal-title">Are you sure you want to proceed?</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                      <p>Please Note: This action cannot be reversed.</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                      <button id="yes" type="button" class="btn btn-danger">Yes</button>
                    </div>
                  </div>
                </div>
        </div>
        @push('scripts')
   <script>
     
      $(function(){

          var form;
          $(document).on('click','.confirm-btn',function(event){
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
            form = $(this).closest('form');
          });
          
      });
    
   </script>
@endpush
</div>
