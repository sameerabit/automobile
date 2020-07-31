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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/job_card.js":
/*!**********************************!*\
  !*** ./resources/js/job_card.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $('#vehicle_id').select2();
  var employees;
  $('#saveRecord').on('click', function () {
    var jobDate = $('#jobDate').val();
    var vehicle_id = $('#vehicle_id').val();
    $.ajax({
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('input[name=_token]').val()
      },
      url: '/job-cards',
      data: {
        vehicle_id: vehicle_id,
        date: jobDate
      },
      success: function success(response) {
        $('#job_card_id').val(response.id);
        console.log(response);
      },
      error: function error(response) {},
      dataType: 'json'
    });
  });
  $.ajax({
    type: "GET",
    headers: {
      "X-CSRF-TOKEN": $('input[name=_token]').val()
    },
    url: '/employees-json',
    success: function success(response) {
      employees = response.items;
      console.log(employees);

      if (employees.length > 0) {
        loadGrid();
      }
    },
    error: function error(response) {},
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
      autoload: true,
      fields: [{
        name: "id",
        css: "hide",
        width: 0
      }, {
        name: "employee_id",
        type: "select",
        items: employees,
        valueField: "id",
        textField: "name",
        title: "Employee Name",
        autosearch: true,
        width: 100
      }, {
        name: "job_desc",
        type: "textarea",
        width: 250,
        validate: "required",
        title: "Job Description"
      }, {
        name: "estimation_time",
        type: "number",
        sorting: false,
        title: "Estimation Time",
        width: 50
      }, {
        width: 40,
        itemTemplate: function itemTemplate(value, item) {
          var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
          var $startButton = $("<button>").text('Start').addClass('btn btn-sm btn-primary').click(function (e) {
            console.log(jsGrid.fields.control);
            alert("Age: ");
            e.stopPropagation();
          });
          return $result.add($startButton);
        }
      }, {
        width: 40,
        itemTemplate: function itemTemplate(value, item) {
          var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
          var $pauseButton = $("<button>").attr('disabled', "true").text('Pause').addClass('btn btn-sm btn-warning').click(function (e) {
            alert("Age: ");
            e.stopPropagation();
          });
          return $result.add($pauseButton);
        }
      }, {
        width: 40,
        itemTemplate: function itemTemplate(value, item) {
          var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
          var $finishButton = $("<button>").text('Finish').addClass('btn btn-sm btn-danger').click(function (e) {
            alert("Age: ");
            e.stopPropagation();
          });
          return $result.add($finishButton);
        }
      }, {
        type: "control",
        width: 100
      } // {
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

        console.log(total);
      },
      controller: {
        loadData: function loadData(filter) {
          if ($('#job_card_id').val()) {
            var deferred = $.Deferred();
            filter["type"] = 1;
            $.ajax({
              type: "GET",
              url: "/job-cards/" + $('#job_card_id').val() + "/details",
              data: filter,
              success: function success(response) {
                deferred.resolve(response);
              }
            });
            return deferred.promise();
          }
        },
        insertItem: function insertItem(item) {
          $jobCardId = $('#job_card_id').val();
          var data = {
            employee_id: item.employee_id,
            job_desc: item.job_desc,
            estimation_time: item.estimation_time,
            job_card_id: $('#job_card_id').val(),
            type: 1
          };
          res = $.ajax({
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
        updateItem: function updateItem(item) {
          res = $.ajax({
            type: "PUT",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/job-card-detail/" + item.id,
            data: item
          });
          $("#mechanicJsGrid").jsGrid("loadData");
          return res;
        },
        deleteItem: function deleteItem(item) {
          return $.ajax({
            type: "DELETE",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/job-card-detail/" + item.id,
            data: item
          });
        }
      }
    }); //tinkering

    $("#tinkeringJsGrid").jsGrid({
      width: "100%",
      height: "400px",
      inserting: true,
      editing: true,
      sorting: true,
      paging: true,
      filtering: true,
      autoload: true,
      fields: [{
        name: "id",
        css: "hide",
        width: 0
      }, {
        name: "employee_id",
        type: "select",
        items: employees,
        valueField: "id",
        textField: "name",
        title: "Employee Name",
        autosearch: true,
        width: 200
      }, {
        name: "job_desc",
        type: "textarea",
        width: 150,
        validate: "required",
        title: "Job Description"
      }, {
        name: "estimation_time",
        type: "number",
        sorting: false,
        title: "Estimation Time"
      }, {
        type: "control"
      } // {
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
      onRefreshed: function onRefreshed(args) {
        var items = args.grid.option("data");
        var total = {
          employee_id: "Total",
          "job_desc": "Total",
          estimation_time: 0
        };
        items.forEach(function (item) {
          total.estimation_time += item.estimation_time;
        });
        var $totalRow = $("<tr>").addClass("total-row");

        args.grid._renderCells($totalRow, total);

        args.grid._content.append($totalRow);

        console.log(total);
      },
      controller: {
        loadData: function loadData(filter) {
          if ($('#job_card_id').val()) {
            var deferred = $.Deferred();
            filter["type"] = 2;
            $.ajax({
              type: "GET",
              url: "/job-cards/" + $('#job_card_id').val() + "/details",
              data: filter,
              success: function success(response) {
                deferred.resolve(response);
              }
            });
            return deferred.promise();
          }
        },
        insertItem: function insertItem(item) {
          $jobCardId = $('#job_card_id').val();
          var data = {
            employee_id: item.employee_id,
            job_desc: item.job_desc,
            estimation_time: item.estimation_time,
            job_card_id: $('#job_card_id').val(),
            type: 2
          };
          res = $.ajax({
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
        updateItem: function updateItem(item) {
          res = $.ajax({
            type: "PUT",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/job-card-detail/" + item.id,
            data: item
          });
          $("#tinkeringJsGrid").jsGrid("loadData");
          return res;
        },
        deleteItem: function deleteItem(item) {
          return $.ajax({
            type: "DELETE",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/job-card-detail/" + item.id,
            data: item
          });
        }
      }
    }); //service

    $("#serviceJsGrid").jsGrid({
      width: "100%",
      height: "400px",
      inserting: true,
      editing: true,
      sorting: true,
      paging: true,
      filtering: true,
      autoload: true,
      fields: [{
        name: "id",
        css: "hide",
        width: 0
      }, {
        name: "employee_id",
        type: "select",
        items: employees,
        valueField: "id",
        textField: "name",
        title: "Employee Name",
        autosearch: true,
        width: 200
      }, {
        name: "job_desc",
        type: "textarea",
        width: 150,
        validate: "required",
        title: "Job Description"
      }, {
        name: "estimation_time",
        type: "number",
        sorting: false,
        title: "Estimation Time"
      }, {
        type: "control"
      } // {
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
      onRefreshed: function onRefreshed(args) {
        var items = args.grid.option("data");
        var total = {
          employee_id: "Total",
          "job_desc": "Total",
          estimation_time: 0
        };
        items.forEach(function (item) {
          total.estimation_time += item.estimation_time;
        });
        var $totalRow = $("<tr>").addClass("total-row");

        args.grid._renderCells($totalRow, total);

        args.grid._content.append($totalRow);

        console.log(total);
      },
      controller: {
        loadData: function loadData(filter) {
          if ($('#job_card_id').val()) {
            var deferred = $.Deferred();
            filter["type"] = 3;
            $.ajax({
              type: "GET",
              url: "/job-cards/" + $('#job_card_id').val() + "/details",
              data: filter,
              success: function success(response) {
                deferred.resolve(response);
              }
            });
            return deferred.promise();
          }
        },
        insertItem: function insertItem(item) {
          $jobCardId = $('#job_card_id').val();
          var data = {
            employee_id: item.employee_id,
            job_desc: item.job_desc,
            estimation_time: item.estimation_time,
            job_card_id: $('#job_card_id').val(),
            type: 3
          };
          res = $.ajax({
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
        updateItem: function updateItem(item) {
          res = $.ajax({
            type: "PUT",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/job-card-detail/" + item.id,
            data: item
          });
          $("#serviceJsGrid").jsGrid("loadData");
          return res;
        },
        deleteItem: function deleteItem(item) {
          return $.ajax({
            type: "DELETE",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/job-card-detail/" + item.id,
            data: item
          });
        }
      }
    });
  }
});

/***/ }),

/***/ 1:
/*!****************************************!*\
  !*** multi ./resources/js/job_card.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/viraj/automobile/resources/js/job_card.js */"./resources/js/job_card.js");


/***/ })

/******/ });