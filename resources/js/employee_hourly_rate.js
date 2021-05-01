
            $(function() {
                // $('#details').hide();
                $('#vehicle_id').select2();

                var employees; 

                $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/employees-json',
                    success: function(response) {
                        employees = response.items;
                        if (employees.length > 0) {
                            loadGrid();
                        } else {
                            alert('Please add at least one employee to the system.');
                        }
                    },
                    error: function(response) {

                    },
                    dataType: 'json'
                });

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

                function loadGrid() {
                    $("#hourlyRateJsGrid").jsGrid({
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
                                name: "employee_id",
                                type: "select",
                                items: employees,
                                valueField: "id",
                                textField: "name",
                                title: "Employee Name",
                                autosearch: true,
                                width: 100,
                            },
                            {
                                name: "rate",
                                type: "number",
                                sorting: false,
                                title: "Hourly Rate (Rs.)",
                                width: 75,
                            },
                            {
                                type: "control",
                                width: 100,
                            }
                        ],
                        onRefreshed: function(args) {
                            var items = args.grid.option("data");
                           
                        },
                        controller: {
                            loadData: function(filter) {
                                
                                    var deferred = $.Deferred();
                                    filter["type"] = 1;
                                    $.ajax({
                                        type: "GET",
                                        url: "/hourly-rates",
                                        data: filter,
                                        success: function(response) {
                                            deferred.resolve(response);
                                        }
                                    });
                                    return deferred.promise();

                            },
                            insertItem: function(item) {
                                res =  $.ajax({
                                    type: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/hourly-rates",
                                    data: item,
                                    success: function(){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Rate added successfully!'
                                        })
                                    }
                                });
                                $("#hourlyRateJsGrid").jsGrid("loadData");
                                return res;
                            },
                            updateItem: function(item) {
                                 res = $.ajax({
                                    type: "PUT",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/hourly-rates/"+item.id,
                                    data: item
                                });
                                $("#hourlyRateJsGrid").jsGrid("loadData");
                                return res;

                            },
                            deleteItem: function(item) {
                                return $.ajax({
                                    type: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/hourly-rates/"+item.id,
                                    data: item
                                });
                            }
                        },
                    });
                    
                }


            });
