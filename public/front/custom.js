// (function ($) {
//     "use strict";

        $(document).on('click','.packagedetails',function(){
            // if(admin_loader == 1)
            //   {
            //   $('.submit-loader').show();
            // }
              $('.jq-loader').show();
              let planName=$(this).attr('data-planName')
              $('#subplanModal').find('.modal-title').html('Subscribe '+ planName + ' Package');
              $('#subplanModal .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
                  if(status == "success")
                  {
                   $('.jq-loader').hide();
                  }
                });
        });

        $(document).on('show.bs.modal','#cancelSubscription', function(e) {
              $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('cancelhref'));
        });

        $(document).on('click','#cancelSubscription .btn-ok', function (e) {
            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                success: function (data) {
                    $('#cancelSubscription').modal('toggle');
                    // table.ajax.reload();   
                    if(data.success==1){
                        toastr.success(data.msg);
                        location.reload();
                    }else{
                        toastr.error(data.msg);
                    }                
                    
                }
            });
            return false;
        });        
