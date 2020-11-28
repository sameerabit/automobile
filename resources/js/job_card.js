
            $(function() {
                $('#timesheet').hide();
                $('#vehicle_id').select2();

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
                    var jobDate = $('#jobDate').val();
                    var vehicle_id = $('#vehicle_id').val();
                    $.ajax({
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('input[name=_token]').val()
                        },
                        url: '/job-cards',
                        data: {
                            vehicle_id : vehicle_id,
                            date : jobDate
                        },
                        success: function(response) {
                            $('#job_card_id').val(response.id);
                            if(response.id){
                                $('#timesheet').show();
                                $('#saveRecord').hide();
                            }
                        },
                        error: function(response) {

                        },
                        dataType: 'json'
                    });
                });

                $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/employees-json',
                    success: function(response) {
                        employees = response.items;
                        console.log(employees);
                        if (employees.length > 0) {
                            loadGrid();
                        }
                    },
                    error: function(response) {

                    },
                    dataType: 'json'
                });

                clients = [];

                jsGrid.validators.time = {
                    message: "Please enter a valid time estimation",
                    validator: function(value, item) {
                        return /^[1-9]+[0-9]*$/.test(value);
                    }
                }


                function loadGrid() {
                    $("#mechanicJsGrid").jsGrid({
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
                                name: "job_desc",
                                type: "textarea",
                                width: 250,
                                validate: "required",
                                title: "Job Description"
                            },
                            {
                                name: "estimation_time",
                                type: "number",
                                sorting: false,
                                title: "Est. Time",
                                width: 75,
                                validate: {
                                    validator: "time"
                                }
                            },
                            {
                                name: "action",
                                width: 130,
                                itemTemplate: function(value, item) {
                                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
                                    var timer = new easytimer.Timer();
                                    var $startButton = $("<button>")
                                        .text('Start')
                                        .addClass('btn btn-sm btn-primary')
                                        .click(function(e) {
                                            console.log(jsGrid.fields.control);
                                            
                                            timer.start();
                                            timer.addEventListener('secondsUpdated', function (e) {
                                                $('#time_'+item.id).html(timer.getTimeValues().toString());
                                            });
                                            e.stopPropagation();
                                    });
                                    var $pauseButton = $("<button>")
                                        // .attr('disabled',"true")
                                        .text('Pause')
                                        .addClass('btn btn-sm btn-warning')
                                        .click(function(e) {
                                            timer.pause();
                                            e.stopPropagation();
                                    });
                                    var $finishButton = $("<button>")
                                        .text('Finish')
                                        .addClass('btn btn-sm btn-danger')
                                        .click(function(e) {
                                            timer.stop();
                                            e.stopPropagation();
                                    });
                                    return  $result.add($startButton)
                                            .add($finishButton)
                                            .add($pauseButton);

                                }
                            },
                            {
                                name: 'time',
                                width: 60,
                                itemTemplate: function(value, item) {
                                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
                                    var $time = $("<p class='font-weight-bold' id='time_"+item.id+"'>");
                                    return  $result.add($time);

                                }
                            },
                            {
                                type: "control",
                                width: 100,

                            }
                        ],
                        onRefreshed: function(args) {
                            var items = args.grid.option("data");
                            console.log(items,212);
                            var total = {
                                estimation_time: 0
                            };

                            items.forEach(function(item) {
                            total.estimation_time += item.estimation_time;
                            });
                            var $totalRow = $("<tr colspan='4'>").addClass("total-row");

                            args.grid._renderCells($totalRow, total);

                            args.grid._content.append($totalRow);
                            console.log(total);
                        },
                        controller: {
                            loadData: function(filter) {
                                if($('#job_card_id').val()){
                                    var deferred = $.Deferred();
                                    filter["type"] = 1;
                                    $.ajax({
                                        type: "GET",
                                        url: "/job-cards/"+$('#job_card_id').val()+"/details",
                                        data: filter,
                                        success: function(response) {
                                            deferred.resolve(response);
                                        }
                                    });
                                    return deferred.promise();
                                }

                            },
                            insertItem: function(item) {
                                $jobCardId = $('#job_card_id').val();

                                var data = {
                                        employee_id : item.employee_id,
                                        job_desc : item.job_desc,
                                        estimation_time :  item.estimation_time,
                                        job_card_id : $('#job_card_id').val(),
                                        type : 1
                                    };
                                res =  $.ajax({
                                    type: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-details",
                                    data: data,
                                    success: function(){
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Task added successfully!'
                                        })
                                    }
                                });
                                $("#mechanicJsGrid").jsGrid("loadData");
                                return res;
                            },
                            updateItem: function(item) {
                                 res = $.ajax({
                                    type: "PUT",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-detail/"+item.id,
                                    data: item
                                });
                                $("#mechanicJsGrid").jsGrid("loadData");
                                return res;

                            },
                            deleteItem: function(item) {
                                return $.ajax({
                                    type: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-detail/"+item.id,
                                    data: item
                                });
                            }
                        },
                    });
                    

                    //tinkering
                    $("#tinkeringJsGrid").jsGrid({
                        width: "100%",
                        height: "400px",
                        inserting: true,
                        editing: true,
                        sorting: true,
                        paging: true,
                        filtering: true,
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
                                width: 200,
                            },
                            {
                                name: "job_desc",
                                type: "textarea",
                                width: 150,
                                validate: "required",
                                title: "Job Description"
                            },
                            {
                                name: "estimation_time",
                                type: "number",
                                sorting: false,
                                title: "Estimation Time"
                            },
                            {
                                type: "control"
                            },
                            // {
                            //     width: 80,
                            //     align:'center',
                            //     headerTemplate: function() {
                            //     return "<th class='jsgrid-header-cell'>Sum</th>";
                            //     },
                            //     itemTemplate: function(value, item) {
                            //     return item.estimation_time;
                            //     }
                            // }
                        ],
                        onRefreshed: function(args) {
                            var items = args.grid.option("data");
                            var total = {
                             employee_id: "Total",
                             "job_desc": "Total",
                             estimation_time: 0
                            };

                            items.forEach(function(item) {
                            total.estimation_time += item.estimation_time;
                            });
                            var $totalRow = $("<tr>").addClass("total-row");

                            args.grid._renderCells($totalRow, total);

                            args.grid._content.append($totalRow);
                            console.log(total);
                        },
                        controller: {
                            loadData: function(filter) {
                                if($('#job_card_id').val()){
                                    var deferred = $.Deferred();
                                    filter["type"] = 2;
                                    $.ajax({
                                        type: "GET",
                                        url: "/job-cards/"+$('#job_card_id').val()+"/details",
                                        data: filter,
                                        success: function(response) {
                                            deferred.resolve(response);
                                        }
                                    });
                                    return deferred.promise();
                                }

                            },
                            insertItem: function(item) {
                                $jobCardId = $('#job_card_id').val();

                                var data = {
                                        employee_id : item.employee_id,
                                        job_desc : item.job_desc,
                                        estimation_time :  item.estimation_time,
                                        job_card_id : $('#job_card_id').val(),
                                        type : 2
                                    };
                                res =  $.ajax({
                                    type: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-details",
                                    data: data
                                });
                                $("#tinkeringJsGrid").jsGrid("loadData");
                                return res;
                            },
                            updateItem: function(item) {
                                 res = $.ajax({
                                    type: "PUT",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-detail/"+item.id,
                                    data: item
                                });
                                $("#tinkeringJsGrid").jsGrid("loadData");
                                return res;

                            },
                            deleteItem: function(item) {
                                return $.ajax({
                                    type: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-detail/"+item.id,
                                    data: item
                                });
                            }
                        },
                    });

                    //service

                    $("#serviceJsGrid").jsGrid({
                        width: "100%",
                        height: "400px",
                        inserting: true,
                        editing: true,
                        sorting: true,
                        paging: true,
                        filtering: true,
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
                                width: 200,
                            },
                            {
                                name: "job_desc",
                                type: "textarea",
                                width: 150,
                                validate: "required",
                                title: "Job Description"
                            },
                            {
                                name: "estimation_time",
                                type: "number",
                                sorting: false,
                                title: "Estimation Time"
                            },
                            {
                                type: "control"
                            },
                            // {
                            //     width: 80,
                            //     align:'center',
                            //     headerTemplate: function() {
                            //     return "<th class='jsgrid-header-cell'>Sum</th>";
                            //     },
                            //     itemTemplate: function(value, item) {
                            //     return item.estimation_time;
                            //     }
                            // }
                        ],
                        onRefreshed: function(args) {
                            var items = args.grid.option("data");
                            var total = {
                             employee_id: "Total",
                             "job_desc": "Total",
                             estimation_time: 0
                            };

                            items.forEach(function(item) {
                            total.estimation_time += item.estimation_time;
                            });
                            var $totalRow = $("<tr>").addClass("total-row");

                            args.grid._renderCells($totalRow, total);

                            args.grid._content.append($totalRow);
                            console.log(total);
                        },
                        controller: {
                            loadData: function(filter) {
                                if($('#job_card_id').val()){
                                    var deferred = $.Deferred();
                                    filter["type"] = 3;
                                    $.ajax({
                                        type: "GET",
                                        url: "/job-cards/"+$('#job_card_id').val()+"/details",
                                        data: filter,
                                        success: function(response) {
                                            deferred.resolve(response);
                                        }
                                    });
                                    return deferred.promise();
                                }

                            },
                            insertItem: function(item) {
                                $jobCardId = $('#job_card_id').val();

                                var data = {
                                        employee_id : item.employee_id,
                                        job_desc : item.job_desc,
                                        estimation_time :  item.estimation_time,
                                        job_card_id : $('#job_card_id').val(),
                                        type : 3
                                    };
                                res =  $.ajax({
                                    type: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-details",
                                    data: data
                                });
                                $("#serviceJsGrid").jsGrid("loadData");
                                return res;
                            },
                            updateItem: function(item) {
                                 res = $.ajax({
                                    type: "PUT",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-detail/"+item.id,
                                    data: item
                                });
                                $("#serviceJsGrid").jsGrid("loadData");
                                return res;

                            },
                            deleteItem: function(item) {
                                return $.ajax({
                                    type: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-detail/"+item.id,
                                    data: item
                                });
                            }
                        },
                    });

                }


            });
