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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/insurance_claim.js":
/*!*****************************************!*\
  !*** ./resources/js/insurance_claim.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  // $('#details').hide();
  $('#vehicle_id').select2();
  loadGrid();
  var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: function didOpen(toast) {
      toast.addEventListener('mouseenter', Swal.stopTimer);
      toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
  });
  var employees;
  $('#saveRecord').on('click', function () {
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
        vehicle_id: vehicle_id,
        date: date,
        company_id: company_id,
        agent_name: agent_name,
        phone_1: phone_1,
        phone_2: phone_2
      },
      success: function success(response) {
        $('#insurance_claim_id').val(response.id);

        if (response.id) {
          $('#details').show();
          $('#saveRecord').hide();
        }
      },
      error: function error(response) {},
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
      autoload: true,
      fields: [{
        name: "id",
        css: "hide",
        width: 0
      }, {
        name: "item",
        type: "text",
        title: "Item",
        autosearch: true,
        width: 100
      }, {
        name: "est_cost",
        type: "number",
        sorting: false,
        title: "Est. Cost",
        width: 75 // validate: {
        //     validator: "time"
        // }

      }, {
        name: "actual_cost",
        type: "number",
        sorting: false,
        title: "Act. Cost",
        width: 75 // validate: {
        //     validator: "time"
        // }

      }, {
        name: "reason",
        type: "textarea",
        width: 300,
        validate: "required",
        title: "Reason"
      }, {
        type: "control",
        width: 100
      }],
      onRefreshed: function onRefreshed(args) {
        var items = args.grid.option("data");
        var total = {
          estimation_time: 0
        };
        items.forEach(function (item) {
          total.estimation_time += item.estimation_time;
        });
        var $totalRow = $("<tr colspan='4'>").addClass("total-row");

        args.grid._renderCells($totalRow, total);

        args.grid._content.append($totalRow);
      },
      controller: {
        loadData: function loadData(filter) {
          if ($('#insurance_claim_id').val()) {
            var deferred = $.Deferred();
            filter["type"] = 1;
            $.ajax({
              type: "GET",
              url: "/insurance-claim-details/" + $('#insurance_claim_id').val() + "/details",
              data: filter,
              success: function success(response) {
                deferred.resolve(response);
              }
            });
            return deferred.promise();
          }
        },
        insertItem: function insertItem(item) {
          insurance_claim_id = $('#insurance_claim_id').val();
          var data = {
            item: item.item,
            reason: item.reason,
            est_cost: item.est_cost,
            actual_cost: item.actual_cost,
            insurance_claim_id: insurance_claim_id
          };
          res = $.ajax({
            type: "POST",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/insurance-claim-details",
            data: data,
            success: function success() {
              Toast.fire({
                icon: 'success',
                title: 'Task added successfully!'
              });
            }
          });
          $("#claimJsGrid").jsGrid("loadData");
          return res;
        },
        updateItem: function updateItem(item) {
          res = $.ajax({
            type: "PUT",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/insurance-claim-details/" + item.id,
            data: item
          });
          $("#claimJsGrid").jsGrid("loadData");
          return res;
        },
        deleteItem: function deleteItem(item) {
          return $.ajax({
            type: "DELETE",
            headers: {
              "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: "/insurance-claim-details/" + item.id,
            data: item
          });
        }
      }
    });
  }
});

/***/ }),

/***/ 2:
/*!***********************************************!*\
  !*** multi ./resources/js/insurance_claim.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/viraj/BIT/automobile/resources/js/insurance_claim.js */"./resources/js/insurance_claim.js");


/***/ })

/******/ });