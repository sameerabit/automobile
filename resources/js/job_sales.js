
            $(function() {

                $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/products-json',
                    success: function(response) {
                        products = response.items;
                        if (products.length > 0) {
                            loadGrid();
                        }
                    },
                    error: function(response) {

                    },
                    dataType: 'json'
                });

                var SelectField = function(config) {
                    jsGrid.Field.call(this, config);
                };

                SelectField.prototype = new jsGrid.Field({

                    css: "date-field",            // redefine general property 'css'
                    align: "center",              // redefine general property 'align'

                    myCustomProperty: "foo",      // custom property

                    sorter: function(date1, date2) {
                        // return new Date(date1) - new Date(date2);
                    },

                    itemTemplate: function(value) {
                        if(value){
                            return value[0];
                        }
                        return value;
                    },

                    _createSelect: function(selected) {
                        var textField = this.textField;
                        var $result = $("<select>");

                        $.each(this.items, function(_, item) {
                            var value = item[textField];
                            var $opt = $("<option>").text(value).val(item.id);

                            if($.inArray(value, selected) > -1) {
                                $opt.attr("selected", "selected");
                            }

                            $result.append($opt);
                        });

                        return $result;
                    },

                    insertTemplate: function() {
                        var insertControl = this._insertControl = this._createSelect();

                        setTimeout(function() {
                            insertControl.select2({
                                tags: true
                              });
                        });

                        return insertControl;
                    },

                    editTemplate: function(value) {
                        var editControl = this._editControl = this._createSelect(value);

                        setTimeout(function() {
                            editControl.select2({
                                tags: true
                              });
                        });

                        return editControl;
                    },

                    insertValue: function() {
                        return this._insertControl.find("option:selected").map(function() {
                            return this.selected ? ($(this).val() ? $(this).val() : $(this).text())  : null;
                        });
                    },

                    editValue: function() {
                        return this._editControl.find("option:selected").map(function() {
                            return this.selected ? ($(this).val() ? $(this).val() : $(this).text())  : null;
                        });
                    }
                });

                jsGrid.fields.select2 = SelectField;

                    function loadGrid(){
                        $("#itemsSalesJsGrid").jsGrid({
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
                                { name: "product", type: "select2", width: 300, align: "center", items: products, textField: "name" },
                                {
                                    name: "quantity",
                                    type: "number",
                                    sorting: false,
                                    title: "Qty",
                                    width: 100,
                                },
                                {
                                    name: "price",
                                    type: "number",
                                    sorting: false,
                                    title: "Price",
                                    width: 100,
                                },
                                {
                                    name: "return_qty",
                                    type: "number",
                                    sorting: false,
                                    title: "Returned Qty.",
                                    width: 100,
                                },
                                {
                                    type: "control",
                                    width: 100,

                                },
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
                            },
                            controller: {
                                loadData: function(filter) {
                                    if($('#job_card_id').val()){
                                        var deferred = $.Deferred();
                                        filter["type"] = 1;
                                        $.ajax({
                                            type: "GET",
                                            url: "/job-sales/"+$('#job_card_id').val(),
                                            data: filter,
                                            success: function(response) {
                                                deferred.resolve(response);
                                            }
                                        });
                                        return deferred.promise();
                                    }

                                },
                                insertItem: function(item) {
                                    jobCardId = $('#job_card_id').val();

                                    var data = {
                                            product_id : item.product[0],
                                            quantity : item.quantity,
                                            return_qty :  item.return_qty,
                                            price :  item.price,
                                            job_card_id : jobCardId,
                                            type : 1
                                        };
                                    res =  $.ajax({
                                        type: "POST",
                                        headers: {
                                            "X-CSRF-TOKEN": $('input[name=_token]').val()
                                        },
                                        url: "/job-sales",
                                        data: data
                                    });
                                    $("#itemsSalesJsGrid").jsGrid("loadData");
                                    return res;
                                },
                                updateItem: function(item) {
                                    jobCardId = $('#job_card_id').val();
                                    var data = {
                                            product_id : item.product_id,
                                            quantity : item.quantity,
                                            return_qty :  item.return_qty,
                                            price :  item.price,
                                            job_card_id : jobCardId,
                                            type : 1
                                        };
                                     res = $.ajax({
                                        type: "PUT",
                                        headers: {
                                            "X-CSRF-TOKEN": $('input[name=_token]').val()
                                        },
                                        url: "/job-card-detail/"+item.id,
                                        data: data
                                    });
                                    $("#itemsSalesJsGrid").jsGrid("loadData");
                                    return res;

                                },
                                deleteItem: function(item) {
                                    return $.ajax({
                                        type: "DELETE",
                                        headers: {
                                            "X-CSRF-TOKEN": $('input[name=_token]').val()
                                        },
                                        url: "/job-sales/"+item.id,
                                        data: item
                                    });
                                }
                            }
                        });
                    }


            });
