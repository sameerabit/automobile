
            $(function() {

                $('#vehicle_id').select2();

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
                            console.log(response);
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


                function loadGrid() {
                    $("#mechanicJsGrid").jsGrid({
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
                                title: "Estimation Time",
                                width: 50,
                            },
                            {
                                width: 40,
                                itemTemplate: function(value, item) {
                                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);

                                    var $startButton = $("<button>")
                                        .text('Start')
                                        .addClass('btn btn-sm btn-primary')
                                        .click(function(e) {
                                            console.log(jsGrid.fields.control);
                                            alert("Age: ");
                                            e.stopPropagation();
                                    });
                                    return  $result.add($startButton);

                                }
                            },
                            {
                                width: 40,
                                itemTemplate: function(value, item) {
                                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);

                                    var $pauseButton = $("<button>")
                                        .attr('disabled',"true")
                                        .text('Pause')
                                        .addClass('btn btn-sm btn-warning')
                                        .click(function(e) {
                                            alert("Age: ");
                                            e.stopPropagation();
                                    });

                                    return  $result.add($pauseButton);

                                }
                            },
                            {
                                width: 40,
                                itemTemplate: function(value, item) {
                                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);

                                    var $finishButton = $("<button>")
                                        .text('Finish')
                                        .addClass('btn btn-sm btn-danger')
                                        .click(function(e) {
                                            alert("Age: ");
                                            e.stopPropagation();
                                    });

                                    return  $result.add($finishButton);

                                }
                            },
                            {
                                type: "control",
                                width: 100,

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
                             "job_desc": "Total",
                             estimation_time: 0,
                             control: ''
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
                                    data: data
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
