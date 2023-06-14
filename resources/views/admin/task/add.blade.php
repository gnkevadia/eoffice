@extends('admin.layouts.default')


@section('title', 'Add '.VIEW_INFO['title'])

@section('content_header')
<style>
    .box {
        color: black;
        display: none;
    }

    #attachment {
        display: none;
    }

    .inputadd {
        display: flex;
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
                <form enctype="multipart/form-data" id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/add') }}" class="kt-form" method="post">
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
                                @foreach ($project as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Features<span class="required">*</span></label>
                            <select class="form-control" id="status" name="features">
                                @foreach ($data as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Task<span class="required">*</span></label>
                            <input type="text" id="task" name="task" data-toggle="tooltip" title="Enter Task" class="form-control" placeholder="Enter task" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="form-group">

                            <label for="exampleSelect1">Attachment<span class="required">*</span></label>
                            <div class="row" id="addfild">
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-success mr-3 mt-2 addMultipleImages" id="addfilds">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Pryority<span class="required">*</span></label>
                            <select class="form-control" id="status" name="Pryority">
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Assignee<span class="required">*</span></label>
                            <select class="form-control" id="status" name="assignee">
                                <option value="Name" selected>Name</option>
                                <option value="email">email</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Date<span class="required">*</span></label>
                            <input type="date" id="start_date" name="start_date" data-toggle="tooltip" title="Enter Start Date" class="form-control" placeholder="Enter Start Date" value="{{ old('start_date') }}">
                        </div>

                        <div class="form-group">
                            <label>End Date<span class="required">*</span></label>
                            <input type="date" id="end_date" name="end_date" data-toggle="tooltip" title="Enter End Date" class="form-control" placeholder="Enter End Date" value="{{ old('end_date') }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleSelect1">Cycle<span class="required">*</span></label>
                            <select class="form-control" id="status" name="cycle">
                                <option value="1" selected>AA</option>
                                <option value="0">CC</option>
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
<script src="{{ asset('admin/assets/js/pages/custom/task-validation.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var counter = 1;

        $("#btnadd").on("click", function() {
            counter++;
            // alert('111');
            // $("#addfild").append('<div id="file' + counter + '"><input type="file" class="form-control mt-2" name="License_image[]" multiple> <div class="text-right">   <button type="button" class="mt-2 btn btn-danger remove_btn"  id=' + counter + '>-</button></div></div>');

        });
        $(document).on("click", ".remove_btn", function() {
            let row_id = $(this).attr('id');
            $('#file' + row_id + '').remove();
        })
        $(".addMultipleImages").click(function() {
            console.log(counter);
            if (counter >= 2) {
                if ($('#attachment' + (counter - 1)).val()) {
                    if ($('#attachment' + (counter - 1))[0].files[0].name != null) {
                        $("#addfild").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2" id="delete_img" style="text-align:center">X</button></div>');
                        $('#attachment' + counter).click();
                        counter++;

                    }
                }
                if ($('.testing').length == 0) {
                    $("#addfild").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2" id="delete_img" style="text-align:center">X</button></div>');
                    $('#attachment' + counter).click();
                    counter++;
                }
            } else {
                $("#addfild").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"></p><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2" id="delete_img" style="text-align:center">X</button></div>');
                // $('#attachment' + counter).trigger('click');
                $(this).parent().siblings('.inputadd').children('#attachment' + counter).trigger('click');
                counter++;
            }
        });
        $(document).on("click", "#delete_img", function() {
            $(this).parent().remove();
        });


    });
</script>
@stop