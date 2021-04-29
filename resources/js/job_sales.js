
            $(function() {
                var products;
                $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/products-batch-search',
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

                    // css: "form-control",            // redefine general property 'css'
                    align: "center",              // redefine general property 'align'

                    myCustomProperty: "foo",      // custom property

                    sorter: function(date1, date2) {
                        // return new Date(date1) - new Date(date2);
                    },

                    itemTemplate: function(value) {
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
                        var priceField = this._grid.fields[3];

                        // Attach onchange listener !
                        insertControl.change(function (e,x) {
                            var selectedValue = $(this).val();
                            product =  products.find(product => product.id === parseInt(selectedValue));
                            
                            var $cntrl = $(".jsgrid-insert-row td:nth-child(4)").children();
                            if(product){
                                $cntrl[3].value = product.selling_price;
                                $cntrl[2].value = product.quantity;
                            }
                            
                        });

                        setTimeout(function() {
                            insertControl.select2({
                                tags: true
                              });
                        });

                        return insertControl;
                    },

                    editTemplate: function(value,item) {
                        var editControl = this._editControl = this._createSelect(value);
                        // Attach onchange listener !
                        // editControl.change(function(){
                        //     var selectedValue = $(this).val();
                        //     product =  products.find(product => product.id === parseInt(selectedValue));
                            
                        //     var $cntrl = $(".jsgrid-insert-row td:nth-child(4)").children();
                        //     $cntrl[3].value = product.selling_price;
                        //     $cntrl[2].value = product.quantity;
                        // });
                        console.log(this);

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
                            invalidNotify: function(args) {
                                $.map(args.errors, function(error) {
                                    toastr.error(error.field.name+' : '+ error.message)
                                });
                            },
                            fields: [
                                { name: "id", css: "hide", width: 0},
                                { name: "product", type: "select2", width: 300, align: "center", items: products, textField: "name" },
                                {
                                    name: "quantity",
                                    type: "number",
                                    sorting: false,
                                    title: "Qty",
                                    width: 100,
                                    validate: [
                                        "required",
                                        "stock",
                                        {validator: "range",param: [1, 1000000000],
                                        message: function(value, item) {
                                            if(value <= 0){
                                                return "Qty should be a positive number";
                                            }
                                            return 'required';
                                        }
                                    }
                                    ]
                                },
                                {
                                    name: "price",
                                    type: "number",
                                    sorting: false,
                                    title: "Price",
                                    width: 100,
                                    validate: {
                                        validator: "range",
                                        message: function(value, item) {
                                            if(value <= 0){
                                                return "Price should be a positive value";
                                            }
                                        },
                                        param: [1, 1000000000]
                                    }
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
                                                console.log(response);
                                                deferred.resolve(response);
                                            }
                                        });
                                        return deferred.promise();
                                    }

                                },
                                insertItem: function(item) {
                                    jobCardId = $('#job_card_id').val();

                                    var data = {
                                            product_batch_id : item.product[0],
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
                                            product_batch_id : item.product_batch_id,
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
                                        url: "/job-sales/"+item.id,
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

                        jsGrid.validators.stock = {
                            message: function(value, item){
                                return "Qty exceeds than stock. Maximum qty is "+ product.quantity;
                            },
                            validator: function(value, item) {
                                    product =  products.find(product => product.id === parseInt(item.product[0]));
                                    if(product && product.quantity < value){

                                        return false;
                                    }
                                    return true;
                            }
                        }
                    }

            });
