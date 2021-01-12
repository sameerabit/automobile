
            $(function() {
                // $('#details').hide();
                $('#vehicle_id').select2();
                loadGrid();

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  });
                

                var employees;

                $('#saveRecord').on('click',function(){
                    var date = $('#date').val();
                    var vehicle_id = $('#vehicle_id').val();
                    var company_id = $('#company_id').val();
                    var agent_name = $('#agent_name').val();
                    var phone_1 = $('#phone_1').val();
                    var phone_2 = $('#phone_2').val();

                    $.ajax({
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('input[name=_token]').val()
                        },
                        url: '/insurance-claims',
                        data: {
                            vehicle_id : vehicle_id,
                            date : date,
                            company_id: company_id,
                            agent_name: agent_name,
                            phone_1: phone_1,
                            phone_2: phone_2
                        },
                        success: function(response) {
                            $('#insurance_claim_id').val(response.id);
                            if(response.id){
                                $('#details').show();
                                $('#saveRecord').hide();
                            }
                        },
                        error: function(response) {

                        },
                        dataType: 'json'
                    });
                });


                function loadGrid() {
                    $("#claimsJsGrid").jsGrid({
                        width: "100%",
                        height: "400px",
                        inserting: true,
                        editing: true,
                        sorting: true,
                        paging: true,
                        filtering: false,
                        autoload:   true,
                        fields: [
                            { name: "id", css: "hide", width: 0},
                            {
                                name: "item",
                                type: "text",
                                title: "Item",
                                autosearch: true,
                                width: 100,
                            },
                            {
                                name: "est_cost",
                                type: "number",
                                sorting: false,
                                title: "Est. Cost",
                                width: 75,
                                // validate: {
                                //     validator: "time"
                                // }
                            },
                            {
                                name: "actual_cost",
                                type: "number",
                                sorting: false,
                                title: "Act. Cost",
                                width: 75,
                                // validate: {
                                //     validator: "time"
                                // }
                            },
                            {
                                name: "reason",
                                type: "textarea",
                                width: 300,
                                validate: "required",
                                title: "Reason"
                            },
                            {
                                type: "control",
                                width: 100,
                            }
                        ],
                        onRefreshed: function(args) {
                            var items = args.grid.option("data");
                            var total = {
                                estimation_time: 0
                            };

                            items.forEach(function(item) {
                                total.estimation_time += item.estimation_time;
                            });
                            var $totalRow = $("<tr colspan='4'>").addClass("total-row");

                            args.grid._renderCells($totalRow, total);

                            args.grid._content.append($totalRow);
                        },
                        controller: {
                            loadData: function(filter) {
                                if($('#insurance_claim_id').val()){
                                    var deferred = $.Deferred();
                                    filter["type"] = 1;
                                    $.ajax({
                                        type: "GET",
                                        url: "/insurance_cliam/"+$('#insurance_claim_id').val()+"/details",
                                        data: filter,
                                        success: function(response) {
                                            deferred.resolve(response);
                                        }
                                    });
                                    return deferred.promise();
                                }

                            },
                            insertItem: function(item) {
                                insurance_claim_id = $('#insurance_claim_id').val();
                                var data = {
                                        item : item.item,
                                        reason : item.reason,
                                        est_cost  :  item.est_cost,
                                        actual_cost  :  item.actual_cost,
                                        insurance_claim_id : insurance_claim_id,
                                    };
                                res =  $.ajax({
                                    type: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/insurance-claim-details",
                                    data: data,
                                    success: function(){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Task added successfully!'
                                        })
                                    }
                                });
                                $("#claimJsGrid").jsGrid("loadData");
                                return res;
                            },
                            updateItem: function(item) {
                                 res = $.ajax({
                                    type: "PUT",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/insurance-claim-details/"+item.id,
                                    data: item
                                });
                                $("#claimJsGrid").jsGrid("loadData");
                                return res;

                            },
                            deleteItem: function(item) {
                                return $.ajax({
                                    type: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/insurance-claim-details/"+item.id,
                                    data: item
                                });
                            }
                        },
                    });
                    
                }


            });
