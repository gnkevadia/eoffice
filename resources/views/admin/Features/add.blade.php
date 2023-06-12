@extends('admin.layouts.default')


@section('title', 'Add '.VIEW_INFO['title'])

@section('content_header')
<style>
    .box {
        color: black;
        display: none;
    }
</style>
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/menu') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Add {{ VIEW_INFO['title'] }} Details</a>

    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->

</div>
@stop

@section('content')
<!-- Main content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-md-12">

            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Add {{ VIEW_INFO['title'] }}
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/add') }}" class="kt-form" method="post">
                    {{ csrf_field() }}
                    <div class="kt-portlet__body">
                        <div class="form-group form-group-last">
                            <div class="alert alert-secondary" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                <div class="alert-text">
                                    <code>*</code> indicates a required field.
                                </div>
                            </div>
                        </div>
                        @include('admin.includes.errormessage')
                        <div class="form-group">
                            <label for="exampleSelect1">Project<span class="required">*</span></label>
                            <select class="form-control" id="status" name="Project">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name<span class="required">*</span></label>
                            <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                           <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Pryority<span class="required">*</span></label>
                            <select class="form-control" id="status" name="Pryority">
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Status<span class="required">*</span></label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" id="reset" class="btn btn-danger">Reset</button>
                                <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-warning" id="back">Back</button></a>
                            </div>
                        </div>
                </form>

                <!--end::Form-->
            </div>

            <!--end::Portlet-->
        </div>
    </div>
</div>
<!-- Main content -->
<!-- /.content -->
@stop

@section('metronic_js')
<script src="{{ asset('admin/assets/js/pages/custom/menu.js') }}"></script>
<script>
    $(document).ready(function() {
        $("div.hideDiv").hide();
        $("div.showDiv").show();
        $("div.packageDiv").hide();
        $("div.cmsDiv").hide();
        let url = '{{URL::to(' / admin / menu / optionSelect / ')}}';
        $('#menu_type_id').on('change', function() {
            let selectType = $(this).val();
            let pacakgeId = 1
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: url,
                data: {
                    typeId: selectType,
                    pacakgeId: pacakgeId
                },
                success: function(data) {
                    if (data.length) {
                        data.forEach(el => {
                            $("#parent_id").append(`<option value='${el.id}'> ${el.name}</option>`)
                        })
                    }
                }
            });

            if (selectType == 1) {
                $("div.showdiv").show();
                $("div.hideDiv").hide();
            } else {
                $("div.showdiv").show();
                $("div.hideDiv").show();
            }
        });
        $('input[type=radio][name=open_in_new_tabs]').change(function() {
            if (this.value == 1) {
                let selectRadio = 1;
                $("div.packageDiv").show();
                $("div.cmsDiv").hide();
            } else if (this.value == 2) {
                let selectRadio = 2
                $("div.cmsDiv").show();
                $("div.packageDiv").hide();
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: url,
                data: {
                    selectRadio: selectRadio
                },
                success: function(response) {
                    if (selectRadio == 1) {
                        if (response.length) {
                            response.forEach(el => {
                                $("#packageId").append(`<option value='${el.id}'> ${el.name}</option>`)
                            })
                        }
                    } else {
                        if (response.length) {
                            response.forEach(el => {
                                $("#cmsId").append(`<option value='${el.page_id}'> ${el.page_name}</option>`)
                            })
                        }
                    }
                }
            });
        });
    });
</script>
@stop