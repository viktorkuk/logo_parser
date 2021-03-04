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

/***/ "./resources/js/click.js":
/*!*******************************!*\
  !*** ./resources/js/click.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("$(document).ready(function () {\n  /*const clicksTable = $('#clicks-table').DataTable( {\n      \"ajax\": {\n          \"url\": \"/api/clicks/\",\n          \"dataSrc\": \"\"\n      },\n       \"columns\": [\n          { \"data\": \"id\" },\n          { \"data\": \"ua\" },\n          { \"data\": \"ip\" },\n          { \"data\": \"ref\" },\n          { \"data\": \"param1\" },\n          { \"data\": \"param2\" },\n          { \"data\": \"error\" },\n          { \"data\": \"bad_domain\" }\n      ]\n  } );\n   const domainTable = $('#domain-table').DataTable( {\n      \"ajax\": {\n          \"url\": \"/api/domains/\",\n          \"dataSrc\": \"\"\n      },\n      \"columns\": [\n          { \"data\": \"id\" },\n          { \"data\": \"name\" },\n          {\n              \"data\": null,\n              \"defaultContent\": '<button type=\"button\" name=\"delete\" class=\"btn btn-danger btn-xs delete\">Delete</button>',\n              \"className\": 'dt-body-right',\n              \"orderable\":false,\n          },\n      ],\n  } );\n   setInterval( function () {\n      clicksTable.ajax.reload(null, false );\n  }, 5000 );*/\n  $(\"#domain-table\").on('click', '.delete', function () {\n    var id = domainTable.row($(this).parents('tr')).data().id;\n\n    if (confirm(\"Are you sure you want to delete this domain?\")) {\n      $.ajax({\n        url: \"/api/domain/\" + id,\n        method: \"DELETE\",\n        success: function success(data) {\n          resetForm();\n          domainTable.ajax.reload(null, false);\n        },\n        error: function error() {\n          resetForm();\n          alert(\"Delete error\");\n        }\n      });\n    } else {\n      return false;\n    }\n  });\n  $('#addDomain').click(function () {\n    $('#domainModal').modal('show');\n    $('#recordForm')[0].reset();\n    $('.modal-title').html(\"<i class='fa fa-plus'></i> Add Domain\");\n    $('#action').val('addRecord');\n    $('#save').val('Add');\n  });\n  $(\"#domainModal\").on('submit', '#domainForm', function (event) {\n    event.preventDefault();\n    $('#save').attr('disabled', 'disabled');\n    var formData = $(this).serialize();\n    $.ajax({\n      url: \"/api/domain\",\n      method: \"POST\",\n      data: formData,\n      success: function success(data) {\n        resetForm();\n        domainTable.ajax.reload(null, false);\n      },\n      error: function error() {\n        resetForm();\n        alert(\"Add error\");\n      }\n    });\n  });\n\n  var resetForm = function resetForm() {\n    $('#domainForm')[0].reset();\n    $('#domainModal').modal('hide');\n    $('#save').attr('disabled', false);\n  };\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvY2xpY2suanM/YTllOCJdLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsIm9uIiwiaWQiLCJkb21haW5UYWJsZSIsInJvdyIsInBhcmVudHMiLCJkYXRhIiwiY29uZmlybSIsImFqYXgiLCJ1cmwiLCJtZXRob2QiLCJzdWNjZXNzIiwicmVzZXRGb3JtIiwicmVsb2FkIiwiZXJyb3IiLCJhbGVydCIsImNsaWNrIiwibW9kYWwiLCJyZXNldCIsImh0bWwiLCJ2YWwiLCJldmVudCIsInByZXZlbnREZWZhdWx0IiwiYXR0ciIsImZvcm1EYXRhIiwic2VyaWFsaXplIl0sIm1hcHBpbmdzIjoiQUFBQUEsQ0FBQyxDQUFDQyxRQUFELENBQUQsQ0FBWUMsS0FBWixDQUFrQixZQUFXO0FBQ3pCO0FBQ0o7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFTSUYsR0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQkcsRUFBbkIsQ0FBc0IsT0FBdEIsRUFBK0IsU0FBL0IsRUFBMEMsWUFBVTtBQUNoRCxRQUFJQyxFQUFFLEdBQUdDLFdBQVcsQ0FBQ0MsR0FBWixDQUFpQk4sQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRTyxPQUFSLENBQWdCLElBQWhCLENBQWpCLEVBQXlDQyxJQUF6QyxHQUFnREosRUFBekQ7O0FBQ0EsUUFBR0ssT0FBTyxDQUFDLDhDQUFELENBQVYsRUFBNEQ7QUFDeERULE9BQUMsQ0FBQ1UsSUFBRixDQUFPO0FBQ0hDLFdBQUcsRUFBQyxpQkFBZVAsRUFEaEI7QUFFSFEsY0FBTSxFQUFDLFFBRko7QUFHSEMsZUFBTyxFQUFDLGlCQUFTTCxJQUFULEVBQWU7QUFDbkJNLG1CQUFTO0FBQ1RULHFCQUFXLENBQUNLLElBQVosQ0FBaUJLLE1BQWpCLENBQXdCLElBQXhCLEVBQThCLEtBQTlCO0FBQ0gsU0FORTtBQU9IQyxhQUFLLEVBQUMsaUJBQVc7QUFDYkYsbUJBQVM7QUFDVEcsZUFBSyxDQUFFLGNBQUYsQ0FBTDtBQUNIO0FBVkUsT0FBUDtBQVlILEtBYkQsTUFhTztBQUNILGFBQU8sS0FBUDtBQUNIO0FBQ0osR0FsQkQ7QUFvQkFqQixHQUFDLENBQUMsWUFBRCxDQUFELENBQWdCa0IsS0FBaEIsQ0FBc0IsWUFBVTtBQUM1QmxCLEtBQUMsQ0FBQyxjQUFELENBQUQsQ0FBa0JtQixLQUFsQixDQUF3QixNQUF4QjtBQUNBbkIsS0FBQyxDQUFDLGFBQUQsQ0FBRCxDQUFpQixDQUFqQixFQUFvQm9CLEtBQXBCO0FBQ0FwQixLQUFDLENBQUMsY0FBRCxDQUFELENBQWtCcUIsSUFBbEIsQ0FBdUIsdUNBQXZCO0FBQ0FyQixLQUFDLENBQUMsU0FBRCxDQUFELENBQWFzQixHQUFiLENBQWlCLFdBQWpCO0FBQ0F0QixLQUFDLENBQUMsT0FBRCxDQUFELENBQVdzQixHQUFYLENBQWUsS0FBZjtBQUNILEdBTkQ7QUFRQXRCLEdBQUMsQ0FBQyxjQUFELENBQUQsQ0FBa0JHLEVBQWxCLENBQXFCLFFBQXJCLEVBQThCLGFBQTlCLEVBQTZDLFVBQVNvQixLQUFULEVBQWU7QUFDeERBLFNBQUssQ0FBQ0MsY0FBTjtBQUNBeEIsS0FBQyxDQUFDLE9BQUQsQ0FBRCxDQUFXeUIsSUFBWCxDQUFnQixVQUFoQixFQUEyQixVQUEzQjtBQUNBLFFBQUlDLFFBQVEsR0FBRzFCLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUTJCLFNBQVIsRUFBZjtBQUNBM0IsS0FBQyxDQUFDVSxJQUFGLENBQU87QUFDSEMsU0FBRyxFQUFDLGFBREQ7QUFFSEMsWUFBTSxFQUFDLE1BRko7QUFHSEosVUFBSSxFQUFDa0IsUUFIRjtBQUlIYixhQUFPLEVBQUMsaUJBQVNMLElBQVQsRUFBYztBQUNsQk0saUJBQVM7QUFDVFQsbUJBQVcsQ0FBQ0ssSUFBWixDQUFpQkssTUFBakIsQ0FBd0IsSUFBeEIsRUFBOEIsS0FBOUI7QUFDSCxPQVBFO0FBUUhDLFdBQUssRUFBQyxpQkFBVztBQUNiRixpQkFBUztBQUNURyxhQUFLLENBQUUsV0FBRixDQUFMO0FBQ0g7QUFYRSxLQUFQO0FBYUgsR0FqQkQ7O0FBbUJBLE1BQU1ILFNBQVMsR0FBRyxTQUFaQSxTQUFZLEdBQVc7QUFDekJkLEtBQUMsQ0FBQyxhQUFELENBQUQsQ0FBaUIsQ0FBakIsRUFBb0JvQixLQUFwQjtBQUNBcEIsS0FBQyxDQUFDLGNBQUQsQ0FBRCxDQUFrQm1CLEtBQWxCLENBQXdCLE1BQXhCO0FBQ0FuQixLQUFDLENBQUMsT0FBRCxDQUFELENBQVd5QixJQUFYLENBQWdCLFVBQWhCLEVBQTRCLEtBQTVCO0FBQ0gsR0FKRDtBQU1ILENBakdEIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2NsaWNrLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgLypjb25zdCBjbGlja3NUYWJsZSA9ICQoJyNjbGlja3MtdGFibGUnKS5EYXRhVGFibGUoIHtcbiAgICAgICAgXCJhamF4XCI6IHtcbiAgICAgICAgICAgIFwidXJsXCI6IFwiL2FwaS9jbGlja3MvXCIsXG4gICAgICAgICAgICBcImRhdGFTcmNcIjogXCJcIlxuICAgICAgICB9LFxuXG4gICAgICAgIFwiY29sdW1uc1wiOiBbXG4gICAgICAgICAgICB7IFwiZGF0YVwiOiBcImlkXCIgfSxcbiAgICAgICAgICAgIHsgXCJkYXRhXCI6IFwidWFcIiB9LFxuICAgICAgICAgICAgeyBcImRhdGFcIjogXCJpcFwiIH0sXG4gICAgICAgICAgICB7IFwiZGF0YVwiOiBcInJlZlwiIH0sXG4gICAgICAgICAgICB7IFwiZGF0YVwiOiBcInBhcmFtMVwiIH0sXG4gICAgICAgICAgICB7IFwiZGF0YVwiOiBcInBhcmFtMlwiIH0sXG4gICAgICAgICAgICB7IFwiZGF0YVwiOiBcImVycm9yXCIgfSxcbiAgICAgICAgICAgIHsgXCJkYXRhXCI6IFwiYmFkX2RvbWFpblwiIH1cbiAgICAgICAgXVxuICAgIH0gKTtcblxuICAgIGNvbnN0IGRvbWFpblRhYmxlID0gJCgnI2RvbWFpbi10YWJsZScpLkRhdGFUYWJsZSgge1xuICAgICAgICBcImFqYXhcIjoge1xuICAgICAgICAgICAgXCJ1cmxcIjogXCIvYXBpL2RvbWFpbnMvXCIsXG4gICAgICAgICAgICBcImRhdGFTcmNcIjogXCJcIlxuICAgICAgICB9LFxuICAgICAgICBcImNvbHVtbnNcIjogW1xuICAgICAgICAgICAgeyBcImRhdGFcIjogXCJpZFwiIH0sXG4gICAgICAgICAgICB7IFwiZGF0YVwiOiBcIm5hbWVcIiB9LFxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIFwiZGF0YVwiOiBudWxsLFxuICAgICAgICAgICAgICAgIFwiZGVmYXVsdENvbnRlbnRcIjogJzxidXR0b24gdHlwZT1cImJ1dHRvblwiIG5hbWU9XCJkZWxldGVcIiBjbGFzcz1cImJ0biBidG4tZGFuZ2VyIGJ0bi14cyBkZWxldGVcIj5EZWxldGU8L2J1dHRvbj4nLFxuICAgICAgICAgICAgICAgIFwiY2xhc3NOYW1lXCI6ICdkdC1ib2R5LXJpZ2h0JyxcbiAgICAgICAgICAgICAgICBcIm9yZGVyYWJsZVwiOmZhbHNlLFxuICAgICAgICAgICAgfSxcbiAgICAgICAgXSxcbiAgICB9ICk7XG5cbiAgICBzZXRJbnRlcnZhbCggZnVuY3Rpb24gKCkge1xuICAgICAgICBjbGlja3NUYWJsZS5hamF4LnJlbG9hZChudWxsLCBmYWxzZSApO1xuICAgIH0sIDUwMDAgKTsqL1xuXG5cblxuXG5cbiAgICAkKFwiI2RvbWFpbi10YWJsZVwiKS5vbignY2xpY2snLCAnLmRlbGV0ZScsIGZ1bmN0aW9uKCl7XG4gICAgICAgIGxldCBpZCA9IGRvbWFpblRhYmxlLnJvdyggJCh0aGlzKS5wYXJlbnRzKCd0cicpICkuZGF0YSgpLmlkO1xuICAgICAgICBpZihjb25maXJtKFwiQXJlIHlvdSBzdXJlIHlvdSB3YW50IHRvIGRlbGV0ZSB0aGlzIGRvbWFpbj9cIikpIHtcbiAgICAgICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICAgICAgdXJsOlwiL2FwaS9kb21haW4vXCIraWQsXG4gICAgICAgICAgICAgICAgbWV0aG9kOlwiREVMRVRFXCIsXG4gICAgICAgICAgICAgICAgc3VjY2VzczpmdW5jdGlvbihkYXRhKSB7XG4gICAgICAgICAgICAgICAgICAgIHJlc2V0Rm9ybSgpO1xuICAgICAgICAgICAgICAgICAgICBkb21haW5UYWJsZS5hamF4LnJlbG9hZChudWxsLCBmYWxzZSApO1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgZXJyb3I6ZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIHJlc2V0Rm9ybSgpO1xuICAgICAgICAgICAgICAgICAgICBhbGVydCggXCJEZWxldGUgZXJyb3JcIiApO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pXG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgICQoJyNhZGREb21haW4nKS5jbGljayhmdW5jdGlvbigpe1xuICAgICAgICAkKCcjZG9tYWluTW9kYWwnKS5tb2RhbCgnc2hvdycpO1xuICAgICAgICAkKCcjcmVjb3JkRm9ybScpWzBdLnJlc2V0KCk7XG4gICAgICAgICQoJy5tb2RhbC10aXRsZScpLmh0bWwoXCI8aSBjbGFzcz0nZmEgZmEtcGx1cyc+PC9pPiBBZGQgRG9tYWluXCIpO1xuICAgICAgICAkKCcjYWN0aW9uJykudmFsKCdhZGRSZWNvcmQnKTtcbiAgICAgICAgJCgnI3NhdmUnKS52YWwoJ0FkZCcpO1xuICAgIH0pO1xuXG4gICAgJChcIiNkb21haW5Nb2RhbFwiKS5vbignc3VibWl0JywnI2RvbWFpbkZvcm0nLCBmdW5jdGlvbihldmVudCl7XG4gICAgICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICQoJyNzYXZlJykuYXR0cignZGlzYWJsZWQnLCdkaXNhYmxlZCcpO1xuICAgICAgICBsZXQgZm9ybURhdGEgPSAkKHRoaXMpLnNlcmlhbGl6ZSgpO1xuICAgICAgICAkLmFqYXgoe1xuICAgICAgICAgICAgdXJsOlwiL2FwaS9kb21haW5cIixcbiAgICAgICAgICAgIG1ldGhvZDpcIlBPU1RcIixcbiAgICAgICAgICAgIGRhdGE6Zm9ybURhdGEsXG4gICAgICAgICAgICBzdWNjZXNzOmZ1bmN0aW9uKGRhdGEpe1xuICAgICAgICAgICAgICAgIHJlc2V0Rm9ybSgpO1xuICAgICAgICAgICAgICAgIGRvbWFpblRhYmxlLmFqYXgucmVsb2FkKG51bGwsIGZhbHNlICk7XG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgZXJyb3I6ZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgcmVzZXRGb3JtKCk7XG4gICAgICAgICAgICAgICAgYWxlcnQoIFwiQWRkIGVycm9yXCIgKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSlcbiAgICB9KTtcblxuICAgIGNvbnN0IHJlc2V0Rm9ybSA9IGZ1bmN0aW9uICgpe1xuICAgICAgICAkKCcjZG9tYWluRm9ybScpWzBdLnJlc2V0KCk7XG4gICAgICAgICQoJyNkb21haW5Nb2RhbCcpLm1vZGFsKCdoaWRlJyk7XG4gICAgICAgICQoJyNzYXZlJykuYXR0cignZGlzYWJsZWQnLCBmYWxzZSk7XG4gICAgfVxuXG59ICk7XG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/click.js\n");

/***/ }),

/***/ 1:
/*!*************************************!*\
  !*** multi ./resources/js/click.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/resources/js/click.js */"./resources/js/click.js");


/***/ })

/******/ });