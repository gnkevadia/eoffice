'use strict';
// Class definition

var KTDatatableDataLocalDemo = function() {
	// Private functions
	// variables
	var datatable;
	// demo initializer
	var init = function() {
		var dataJSONArray;
		$.ajax({
			url: 'company',
			dataType: 'json',
			type: 'get',
			contentType: 'application/json',
			data: $("#list-form").serialize(),
			success: function( data, textStatus, jQxhr ){
				dataJSONArray = JSON.parse(JSON.stringify(data.data));
				datatable = $('.kt-datatable').KTDatatable({
					// datasource definition
					data: {
						type: 'local',
						source: dataJSONArray,
						pageSize: 10,
					},
		
					// layout definition
					layout: {
						scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
						// height: 450, // datatable's body's fixed height
						footer: false, // display/hide footer
					},
		
					// column sorting
					sortable: true,
		
					pagination: true,
		
					search: {
						input: $('#generalSearch'),
					},
		
					// columns definition
					columns: [
						{
							field: 'id',
							title: '#',
							sortable: false,
							width: 20,
							type: 'number',
							selector: {class: 'kt-checkbox--solid'},
							textAlign: 'center',
						}, {
							field: 'name',
							title: 'Name',
						}, {
							field: 'department_name',
							title: 'Department',
						}, {
							field: 'description',
							title: 'Description',
						}, {
							field: 'status',
							title: 'Status',
							template: function(row) {
								let statuss = '';
								if(row.status == 1){
									 statuss = 'Active';
								}else{
									statuss = 'Inactive';

								}
								var status = {
									'Active': {'title': 'Active', 'class': ' kt-badge--success'},
									'Inactive': {'title': 'Inactive', 'class': ' kt-badge--danger'},
								};
								return '<span class="kt-badge ' + status[statuss].class + ' kt-badge--inline kt-badge--pill">' + status[statuss].title + '</span>';
							},
						}, {
							field: 'Actions',
							title: 'Actions',
							sortable: false,
							width: 110,
							overflow: 'visible',
							autoHide: false,
							template: function(row) {
								var roleBasedAction = '';
								// if(isViewStatus == true){
								// 	roleBasedAction += '<a href="'+viewURL+'/'+row.id+'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details"><i class="flaticon-eye"></i></a>'
								// }
								// if(isUpdateStatus == true){
									roleBasedAction += '<a href="company/edit/'+row.id+'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details"><i class="la la-edit"></i></a>'
								// }
								// if(isDeleteStatus == true){
									roleBasedAction += '<a href="javascript:;" data-toggle="modal" data-target="#delete_modules" data-id="'+row.id+'"  class="btn btn-sm btn-clean btn-icon btn-icon-md delete_row" title="Edit details"><i class="flaticon-delete"></i></a>'
								// }
								return roleBasedAction;
							},
						}],
				});
		
				$('#kt_form_status').on('change', function() {
					datatable.search($(this).val().toLowerCase(), 'Status');
				});
		
				$('#kt_form_type').on('change', function() {
					datatable.search($(this).val().toLowerCase(), 'Type');
				});
		
				$('#kt_form_status,#kt_form_type').selectpicker();

				datatable.on(
					'kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',
					function(e) {
						var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes();
						var count = checkedNodes.length;
						$('#kt_datatable_selected_number').html(count);
						if (count > 0) {
							$('#kt_datatable_group_action_form').collapse('show');
						} else {
							$('#kt_datatable_group_action_form').collapse('hide');
						}
					});
		
				$('#kt_modal_fetch_id').on('show.bs.modal', function(e) {
					var ids = datatable.rows('.kt-datatable__row--active').
					nodes().
					find('.kt-checkbox--single > [type="checkbox"]').
					map(function(i, chk) {
						return $(chk).val();
					});
					var c = document.createDocumentFragment();
					for (var i = 0; i < ids.length; i++) {
						var li = document.createElement('li');
						li.setAttribute('data-id', ids[i]);
						li.innerHTML = 'Selected record ID: ' + ids[i];
						c.appendChild(li);
					}
					$(e.target).find('.kt-datatable_selected_ids').append(c);
				}).on('hide.bs.modal', function(e) {
					$(e.target).find('.kt-datatable_selected_ids').empty();
				});
				
			},
			error: function( jqXhr, textStatus, errorThrown ){
				console.log( errorThrown );
			}
		});
	};

	// selection
	var selection = function() {
		// init form controls
		//$('#kt_form_status, #kt_form_type').selectpicker();
		
		// event handler on check and uncheck on records
		datatable.on('kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',	function(e) {
			var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes(); // get selected records
			var count = checkedNodes.length; // selected records count

			$('#kt_subheader_group_selected_rows').html(count);
				
			if (count > 0) {
				$('#kt_subheader_search').addClass('kt-hidden');
				$('#kt_subheader_group_actions').removeClass('kt-hidden');
			} else {
				$('#kt_subheader_search').removeClass('kt-hidden');
				$('#kt_subheader_group_actions').addClass('kt-hidden');
			}
		});
	}

	// admin.layouts.toggle
	var selectedFetch = function() {
		// event handler on selected records fetch modal launch
		$('#kt_datatable_records_fetch_modal').on('show.bs.modal', function(e) {
			// show loading dialog
			var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
			loading.show();

			setTimeout(function() {
				loading.hide();
			}, 1000);
			
			// fetch selected IDs
			var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
				return $(chk).val();
			});

			// populate selected IDs
			var c = document.createDocumentFragment();
				
			for (var i = 0; i < ids.length; i++) {
				var li = document.createElement('li');
				li.setAttribute('data-id', ids[i]);
				li.innerHTML = 'Selected record ID: ' + ids[i];
				c.appendChild(li);
			}

			$(e.target).find('#kt_apps_user_fetch_records_selected').append(c);
		}).on('hide.bs.modal', function(e) {
			$(e.target).find('#kt_apps_user_fetch_records_selected').empty();
		});
	};

	// selected records status update
	var selectedStatusUpdate = function() {
		$('#kt_subheader_group_actions_status_change').on('click', "[data-toggle='status-change']", function() {
			var status = $(this).find(".kt-nav__link-text").html();

			// fetch selected IDs
			var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
				return $(chk).val();
			});

			if (ids.length > 0) {
				// learn more: https://sweetalert2.github.io/
				swal.fire({
					buttonsStyling: false,

					html: "Are you sure to update " + ids.length + " selected records status to " + status + " ?",
					type: "info",

					confirmButtonText: "Yes, update!",
					confirmButtonClass: "btn btn-sm btn-bold btn-brand",

					showCancelButton: true,
					cancelButtonText: "No, cancel",
					cancelButtonClass: "btn btn-sm btn-bold btn-default"
				}).then(function(result) {
					if (result.value) {
						swal.fire({
							title: 'Deleted!',
							text: 'Your selected records statuses have been updated!',
							type: 'success',
							buttonsStyling: false,
							confirmButtonText: "OK",
							confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						})
						// result.dismiss can be 'cancel', 'overlay',
						// 'close', and 'timer'
					} else if (result.dismiss === 'cancel') {
						swal.fire({
							title: 'Cancelled',
							text: 'You selected records statuses have not been updated!',
							type: 'error',
							buttonsStyling: false,
							confirmButtonText: "OK",
							confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						});
					}
				});
			}
		});
	}

	// selected records delete
	var selectedDelete = function() {
		$('#kt_subheader_group_actions_delete_all').on('click', function() {
			// fetch selected IDs
			var ids = datatable.rows('.kt-datatable__row--active').nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(i, chk) {
				return $(chk).val();
			});

			if (ids.length > 0) {
				// learn more: https://sweetalert2.github.io/
				swal.fire({
					buttonsStyling: false,

					text: "Are you sure to delete " + ids.length + " selected records ?",
					type: "danger",

					confirmButtonText: "Yes, delete!",
					confirmButtonClass: "btn btn-sm btn-bold btn-danger",

					showCancelButton: true,
					cancelButtonText: "No, cancel",
					cancelButtonClass: "btn btn-sm btn-bold btn-brand"
				}).then(function(result) {
					if (result.value) {
						swal.fire({
							title: 'Deleted!',
							text: 'Your selected records have been deleted! :(',
							type: 'success',
							buttonsStyling: false,
							confirmButtonText: "OK",
							confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						})
						// result.dismiss can be 'cancel', 'overlay',
						// 'close', and 'timer'
					} else if (result.dismiss === 'cancel') {
						swal.fire({
							title: 'Cancelled',
							text: 'You selected records have not been deleted! :)',
							type: 'error',
							buttonsStyling: false,
							confirmButtonText: "OK",
							confirmButtonClass: "btn btn-sm btn-bold btn-brand",
						});
					}
				});
			}
		});		
	}

	return {
		// Public functions
		init: function() {
			// init dmeo
			init();
			//search();
			//selection();
			//selectedFetch();
			//selectedStatusUpdate();
			//selectedDelete();
			//updateTotal();
		},
	};
}();

jQuery(document).ready(function() {
	KTDatatableDataLocalDemo.init();
});