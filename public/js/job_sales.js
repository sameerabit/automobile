/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/job_sales.js":
/*!***********************************!*\
  !*** ./resources/js/job_sales.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var products;
  $.ajax({
    type: "GET",
    headers: {
      "X-CSRF-TOKEN": $('input[name=_token]').val()
    },
    url: '/products-batch-search',
    success: function success(response) {
      products = response.items;

      if (products.length > 0) {
        loadGrid();
      }
    },
    error: function error(response) {},
    dataType: 'json'
  });

  var SelectField = function SelectField(config) {
    jsGrid.Field.call(this, config);
  };

  SelectField.prototype = new jsGrid.Field({
    // css: "form-control",            // redefine general property 'css'
    align: "center",
    // redefine general property 'align'
    myCustomProperty: "foo",
    // custom property
    sorter: function sorter(date1, date2) {// return new Date(date1) - new Date(date2);
    },
    itemTemplate: function itemTemplate(value) {
      return value;
    },
    _createSelect: function _createSelect(selected) {
      var textField = this.textField;
      var $result = $("<select>");
      $.each(this.items, function (_, item) {
        var value = item[textField];
        var $opt = $("<option>").text(value).val(item.id);

        if ($.inArray(value, selected) > -1) {
          $opt.attr("selected", "selected");
        }

        $result.append($opt);
      });
      return $result;
    },
    insertTemplate: function insertTemplate() {
      var insertControl = this._insertControl = this._createSelect();

      var priceField = this._grid.fields[3]; // Attach onchange listener !

      insertControl.change(function (e, x) {
        var selectedValue = $(this).val();
        product = products.find(function (product) {
          return product.id === parseInt(selectedValue);
        });
        var $cntrl = $(".jsgrid-insert-row td:nth-child(4)").children();

        if (product) {
          $cntrl[3].value = product.selling_price;
          $cntrl[2].value = product.quantity;
        }
      });
      setTimeout(function () {
        insertControl.select2({
          tags: true
        });
      });
      return insertControl;
    },
    editTemplate: function editTemplate(value, item) {
      var editControl = this._editControl = this._createSelect(value); // Attach onchange listener !
      // editControl.change(function(){
      //     var selectedValue = $(this).val();
      //     product =  products.find(product => product.id === parseInt(selectedValue));
      //     var $cntrl = $(".jsgrid-insert-row td:nth-child(4)").children();
      //     $cntrl[3].value = product.selling_price;
      //     $cntrl[2].value = product.quantity;
      // });


      console.log(this);
      setTimeout(function () {
        editControl.select2({
          tags: true
        });
      });
      return editControl;
    },
    insertValue: function insertValue() {
      return this._insertControl.find("option:selected").map(function () {
        return this.selected ? $(this).val() ? $(this).val() : $(this).text() : null;
      });
    },
    editValue: function editValue() {
      return this._editControl.find("option:selected").map(function () {
        return this.selected ? $(this).val() ? $(this).val() : $(this).text() : null;
      });
    }
  });
  jsGrid.fields.select2 = SelectField;

  function loadGrid() {
    $("#itemsSalesJsGrid").jsGrid({
      width: "100%",
      height: "400px",
      inserting: true,
      editing: true,
      sorting: true,
      paging: true,
      filtering: false,
      autoload: true,
      invalidNotify: function invalidNotify(args) {
        $.map(args.errors, function (error) {
          toastr.error(error.field.name + ' : ' + error.message);
        });
      },
      fields: [{
        name: "id",
        css: "hide",
        width: 0
      }, {
        name: "product",
        type: "select2",
        width: 300,
        align: "center",
        items: products,
        textField: "name"
      }, {
        name: "quantity",
        type: "number",
        sorting: false,
        title: "Qty",
        width: 100,
        validate: ["required", "stock", {
          validator: "range",
          param: [1, 1000000000],
          message: function message(value, item) {
            if (value <= 0) {
              return "Qty should be a positive number";
            }

            return 'required';
          }
        }]
      }, {
        name: "price",
        type: "number",
        sorting: false,
        title: "Price",
        width: 100,
        validate: {
          validator: "range",
          message: function message(value, item) {
            if (value <= 0) {
              return "Price should be a positive value";
            }
          },
          param: [1, 1000000000]
        }
      }, {
        name: "return_qty",
        type: "number",
        sorting: false,
        title: "Returned Qty.",
        width: 100
      }, {
        type: "control",
        width: 100
      }],
      onRefreshed: function onRefreshed(args) {
        var items = args.grid.option("data");
        var total = {
          "job_desc": "Total",
          estimation_time: 0,
          control: ''
        };
        items.forEach(function (item) {
          total.estimation_time += item.estimation_time;
        });
        var $totalRow = $("<tr>").addClass("total-row");

        args.grid._renderCells($totalRow, total);

        args.grid._content.append($totalRow);
      },
      controller: {
        loadData: function loadData(filter) {
          if ($('#job_card_id').val()) {
            var deferred = $.Deferred();
            filter["type"] = 1;
            $.ajax({
              type: "GET",
              url: "/job-sales/" + $('#job_card_id').val(),
              data: filter,
              success: function success(response) {
                console.log(response);
                deferred.resolve(response);
              }
            });
            return deferred.promise();
          }
        },
        insertItem: function insertItem(item) {
          jobCardId = $('#job_card_id').val();
          var data = {
            product_batch_id: item.product[0],
            quantity: item.quantity,
            return_qty: item.return_qty,
            price: item.price,
            job_card_id: jobCardId,
            type: 1
          };
          res = $.ajax({
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
        updateItem: function updateItem(item) {
          jobCardId = $('#job_card_id').val();
          var data = {
            product_batch_id: item.product_batch_id,
            quantity: item.quantity,
            return_qty: item.return_qty,
            price: item.price,
            job_card_id: jobCardId,
            type: 1
          };
          res = $.ajax({
            type: "PUT",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/job-sales/" + item.id,
            data: data
          });
          $("#itemsSalesJsGrid").jsGrid("loadData");
          return res;
        },
        deleteItem: function deleteItem(item) {
          return $.ajax({
            type: "DELETE",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/job-sales/" + item.id,
            data: item
          });
        }
      }
    });
    jsGrid.validators.stock = {
      message: function message(value, item) {
        return "Qty exceeds than stock. Maximum qty is " + product.quantity;
      },
      validator: function validator(value, item) {
        product = products.find(function (product) {
          return product.id === parseInt(item.product[0]);
        });

        if (product && product.quantity < value) {
          return false;
        }

        return true;
      }
    };
  }
});

/***/ }),

/***/ 4:
/*!*****************************************!*\
  !*** multi ./resources/js/job_sales.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/viraj/BIT/automobile/resources/js/job_sales.js */"./resources/js/job_sales.js");


/***/ })

/******/ });