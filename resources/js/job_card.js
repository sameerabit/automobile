const { constrainPoint } = require("@fullcalendar/core");

            $(function() {
                $('#timesheet').hide();
                $('#vehicle_id').select2();

                $('#yes').click(function(){
                    startJobCard();
                    $('#modal-confirm').modal('hide');
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
                

                var employees;

                function startJobCard(){
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
                }

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

                clients = [];

                jsGrid.validators.time = {
                    message: "Please enter a valid time estimation",
                    validator: function(value, item) {
                        return /^[1-9]+[0-9]*$/.test(value);
                    }
                }

                function updateTimeEvents(taskId,time,state) {
                    return $.ajax({
                        type: "PUT",
                        headers: {
                            "X-CSRF-TOKEN": $('input[name=_token]').val()
                        },
                        data: {
                            time: time,
                            state:state
                        },
                        url: '/job-card-detail/'+taskId+'/update-time',
                        success: function(response) {
                            return response;
                        },
                        error: function(response) {
    
                        },
                        dataType: 'json'
                    });
                }

                function getJobDetail(job_detail_id) {
                    return $.ajax({
                        type: "GET",
                        headers: {
                            "X-CSRF-TOKEN": $('input[name=_token]').val()
                        },
                        url: '/job-card-detail/'+job_detail_id+'/json',
                        success: function(response) {
                          return response;
                        },
                        error: function(response) {
    
                        },
                        dataType: 'json'
                    });
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
                                width: 200,
                                validate: "required",
                                title: "Job Description"
                            },
                            {
                                name: "estimation_time",
                                type: "number",
                                validate: {
                                    validator: "range",
                                    message: function(value, item) {
                                        return "Value should be greater than or equal to 0";
                                    },
                                    param: [0, 1000]
                                },
                                sorting: false,
                                title: "Est. Time (h)",
                                width: 75
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
                                            console.log(timer);
                                            $.when(getJobDetail(item.id)).done(function(res){
                                                timeArr = res.time.split(":");
                                                timer.start(
                                                    {startValues: 
                                                        {
                                                            days:parseInt(res.days),
                                                            hours:parseInt(timeArr[0]),
                                                            minutes:parseInt(timeArr[1]),
                                                            seconds: parseInt(timeArr[2])
                                                        }});
                                            });
                                            updateTimeEvents(item.id, Date.now(), 'start' );
                                            timer.addEventListener('secondsUpdated', function (e) {
                                                $('#time_'+item.id).html(timer.getTimeValues().days+" "+timer.getTimeValues().toString());
                                            });
                                            e.stopPropagation();
                                    });
                                    var $pauseButton = $("<button>")
                                        // .attr('disabled',"true")
                                        .text('Pause')
                                        .addClass('btn btn-sm btn-warning')
                                        .click(function(e) {
                                            timer.pause();
                                            updateTimeEvents(item.id, Date.now(), 'pause' );
                                            e.stopPropagation();
                                    });
                                    var $finishButton = $("<button>")
                                        .text('Reset')
                                        .addClass('btn btn-sm btn-danger')
                                        .click(function(e) {
                                            console.log(timer);
                                            timer.stop();
                                            updateTimeEvents(item.id, Date.now(), 'stop' );
                                            e.stopPropagation();
                                    });
                                    return  $result.add($startButton)
                                            .add($finishButton)
                                            .add($pauseButton);

                                }
                            },
                            {
                                name: 'time',
                                width: 80,
                                itemTemplate: function(value, item) {
                                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
                                    time = value ? value : '';
                                    dateDiffInt =  Date.now() - time;
                                    seconds = Math.floor(dateDiffInt/1000);
                                    minutes = Math.floor(seconds/60);
                                    hours = Math.floor(minutes/60);
                                    days = Math.floor(hours/24);
                                    time = days+" "+ hours + ":" + minutes + ":" + seconds%minutes;
                                    var $time = $("<p class='font-weight-bold' id='time_"+item.id+"'>"+ time +"</p>");
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
                                if($('#job_card_id').val()){
                                    var deferred = $.Deferred();
                                    filter["type"] = 1;
                                    $.ajax({
                                        type: "GET",
                                        url: "/job-cards/"+$('#job_card_id').val()+"/details",
                                        data: filter,
                                        success: function(response) {
                                            deferred.resolve(response);
                                            var timer = new easytimer.Timer();
                                            response.forEach(function(row){
                                                timeArr = row.time.split(":");
                                                dateDiffInt =  Date.now() - row.time;
                                                console.log(dateDiffInt);
                                                seconds = Math.floor(dateDiffInt/1000);
                                                minutes = Math.floor(seconds/60);
                                                hours = Math.floor(minutes/60);
                                                days = Math.floor(hours/24);
                                                if(row.state == "start") {
                                                    timer.start(
                                                        {
                                                            startValues:{
                                                                days:parseInt(days),
                                                                hours:parseInt(hours),
                                                                minutes:parseInt(minutes),
                                                                seconds: parseInt(seconds%minutes)
                                                            }
                                                        }
                                                    );
                                                }
                                                timer.addEventListener('secondsUpdated', function (e) {
                                                    $('#time_'+row.id).html(timer.getTimeValues().days+" "+timer.getTimeValues().toString());
                                                });
                                            });
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
