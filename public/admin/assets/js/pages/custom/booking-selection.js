'use strict';
// Class definition

var KTDatatableDataLocalDemo = function () {
	// Private functions
	// variables
	var datatable;
	// demo initializer
	var init = function () {
		var dataJSONArray;
		$.ajax({
			url: 'booking',
			dataType: 'json',
			type: 'get',
			contentType: 'application/json',
			data: $("#list-form").serialize(),
			success: function (data, textStatus, jQxhr) {
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
							field: 'user_id',
							title: 'User Id',
						}, {
							field: 'cart_id',
							title: 'Cart Id',
						},
						{
							field: 'report_title',
							title: 'Report Title',
						},
						{
							field: 'price',
							title: 'Price',
						}, {
							field: 'status',
							title: 'Status',
							template: function (row) {
								var status = {
									'Active': { 'title': 'Active', 'class': ' kt-badge--success' },
									'Inactive': { 'title': 'Inactive', 'class': ' kt-badge--danger' },
								};
								return '<span class="kt-badge ' + status[row.status].class + ' kt-badge--inline kt-badge--pill">' + status[row.status].title + '</span>';
							},
						}, {
							field: 'order_confirm',
							title: 'Order Confirm',
							template: function (rowsData) {
								if(rowsData.order_confirm == 'Accepted'){
									var order = '<select class="form-control dataSelect" id="dataSelect" disabled><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+1+'" id="1" selected >Accepted</option><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+2+'" id="2">Rejected</option><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+3+'" id="3">InProgress</option></select>';
								} else if(rowsData.order_confirm == 'Rejected'){
									var order = '<select class="form-control dataSelect" id="dataSelect" disabled><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+1+'" id="1" >Accepted</option><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+2+'" id="2" selected>Rejected</option><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+3+'" id="3">InProgress</option></select>';
								}else{
									var order = '<select class="form-control dataSelect" id="dataSelect"><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+1+'" id="1" >Accepted</option><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+2+'" id="2">Rejected</option><option value="'+rowsData.cart_id+'/'+rowsData.user_id+'/'+3+'" id="3" selected>InProgress</option></select>';
								}
								
								return order;
							},
						}, {
							field: 'Actions',
							title: 'Actions',
							sortable: false,
							width: 110,
							overflow: 'visible',
							autoHide: false,
							template: function (row) {
								var roleBasedAction = '';
								if (isViewStatus == true) {
									roleBasedAction += '<a href="' + viewURL + '/' + row.id + '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details"><i class="flaticon-eye"></i></a>'
								}
								if (isDeleteStatus == true) {
									roleBasedAction += '<a href="javascript:;" data-toggle="modal" data-target="#delete_modules" data-id="' + row.id + '"  class="btn btn-sm btn-clean btn-icon btn-icon-md delete_row" title="Edit details"><i class="flaticon-delete"></i></a>'
								}
								return roleBasedAction;
							},
					}],
				});
				
				$('#kt_form_status').on('change', function () {
					datatable.search($(this).val().toLowerCase(), 'Status');
				});

				$('#kt_form_type').on('change', function () {
					datatable.search($(this).val().toLowerCase(), 'Type');
				});

				$('#kt_form_status,#kt_form_type').selectpicker();
				//console.log(datatable.rows('.kt-datatable__row--active').dataSet);
				
				$(document).on('change', '.dataSelect', function () {
					var optionData 	= $(this).val().split('/');
					var cartId 		= optionData[0];
					var userId 		= optionData[1];
					var optionId 	= optionData[2];

					var optionval 	= $(this).children("option:selected").text();
					if (optionId) {
						$.confirm({
							title: 'Are You Sure!',
							content: 'Are You Sure you want to ' + optionval.substr(0, 6) + ' this order.',
							type: 'dark',
							typeAnimated: true,
							buttons: {
								tryAgain: {
									text: 'OK',
									action: function () {
										$.ajax({
											headers: {
												'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
											},
											type: 'POST',
											url: 'booking/toggle',
											data: { optionId: optionId, cartId: cartId, userId: userId },
											success: function (data) {
												window.location.reload();
											}
										});
									}
								},
								close: function () {
								}
							}
						});
					}
				});

				datatable.on(
					'kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',
					function (e) {
						var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes();
						var count = checkedNodes.length;
						$('#kt_datatable_selected_number').html(count);
						if (count > 0) {
							$('#kt_datatable_group_action_form').collapse('show');
						} else {
							$('#kt_datatable_group_action_form').collapse('hide');
						}
					});

				$('#kt_modal_fetch_id').on('show.bs.modal', function (e) {
					var ids = datatable.rows('.kt-datatable__row--active').
						nodes().
						find('.kt-checkbox--single > [type="checkbox"]').
						map(function (i, chk) {
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
				}).on('hide.bs.modal', function (e) {
					$(e.target).find('.kt-datatable_selected_ids').empty();
				});

			},
			error: function (jqXhr, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	};

	return {
		// Public functions
		init: function () {
			// init dmeo
			init();
		},
	};
}();

jQuery(document).ready(function () {
	KTDatatableDataLocalDemo.init();
	$("div.kt-portlet__head-wrapper").hide();
});
