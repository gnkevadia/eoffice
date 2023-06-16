@extends('admin.layouts.default')


@section('title', 'Edit '.VIEW_INFO['title'])

@section('content_header')
<style>
    .box {
        color: black;
        display: none;
    }

    #dltImg {
        display: none;
    }

    #attachment {
        display: none;
    }

    .inputadd {
        display: flex;
    }

    .delete_img {
        position: absolute;
        top: -3px;
        right: 42px;
        font-weight: 900;
    }

    #addfields {
        font-weight: 900;
    }

    .delete_input {
        font-weight: 900;
    }

    .test {
        width: 154px;
        border: solid black 1px;
        text-align: center;
        height: 89px;
    }
</style>
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/menu') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Edit {{ VIEW_INFO['title'] }} Details</a>

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
                            Edit {{ VIEW_INFO['title'] }}
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form enctype="multipart/form-data" id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/edit/'.$data->id) }}" class="kt-form" method="post">
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
                            <select class="form-control" id="Project" name="Project">
                                <option value="" data-id="0">-Select Project-</option>
                                @foreach ($project as $value)
                                <option value="{{$value->id}}" {{($value->id == $data->project ? 'selected' : '')}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Features<span class="required">*</span></label>
                            <select class="form-control" id="features" name="features">
                                <option value="" data-id="0">-Select Features-</option>
                                @foreach ($features as $value)
                                <option value="{{$value->id}}" {{($value->id == $data->features ? 'selected' : '')}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Task<span class="required">*</span></label>
                            <input type="text" id="task" name="task" data-toggle="tooltip" title="Enter Task" class="form-control" placeholder="Enter task" value="{{$data->task}}">
                        </div>
                        <div class="form-group">
                            <label>Description<span class="required">*</span></label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description">{{$data->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Attachment<span class="required">*</span></label>
                            <div class="row" id="addfield">
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-success mr-3 mt-2 addMultipleImages" id="addfields">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($data->task_images as $image)
                            <?php
                            $ext = pathinfo($image->images, PATHINFO_EXTENSION);
                            if ($ext == 'pdf') { ?>
                                <div class="col-lg-2 col-md-4 my-3 ml-3 mb-4" style="left:0;right:0;display:inline-block;margin:0;padding:3px">
                                    <div class="test">
                                        <img src="{{url('images/profile_image')}}/pdf.jpg" height="80" alt="" onclick="window.open('{{url('images/task')}}/{{$image->images}}','_blank')" style="padding-top: 4px;">
                                        <input id="dltImg" type="text" name="remainimg[]" value="{{$image->id}}">
                                        <button type="button" class="mt-2 btn btn-danger btn-sm delete_img">x</button>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-lg-2 col-md-4 my-3 ml-3 mb-4" style="left:0;right:0;display:inline-block;margin:0;padding:3px">
                                    <div class="test">
                                        <img src="{{url('images/task/').'/'.$image->images}}" alt="" width="150">
                                        <input id="dltImg" type="text" name="remainimg[]" value="{{$image->id}}">
                                        <button type="button" class="mt-2 btn btn-danger btn-sm delete_img">x</button>
                                    </div>
                                </div>
                            <?php }
                            ?>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Priority<span class="required">*</span></label>
                            <select class="form-control" id="priority" name="priority">
                                <option value="" data-id="0">-Select Priority-</option>
                                @foreach ($priority as $value)
                                <option value="{{$value->id}}" {{($value->id == $data->priority ? 'selected' : '')}}>{{$value->priority}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Assignee<span class="required">*</span></label>
                            <select class="form-control" id="assignee" name="assignee">
                                <option value="" data-id="0">-Select Assignee-</option>
                                @foreach ($users as $value)
                                <option value="{{$value->id}}" {{($value->id == $data->assignee ? 'selected' : '')}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Date<span class="required">*</span></label>
                            <input type="date" id="start_date" name="start_date" data-toggle="tooltip" title="Enter Start Date" class="form-control" placeholder="Enter Start Date" value="<?php if (isset($data->start_date)) {
                                                                                                                                                                                                echo date('Y-m-d', strtotime($data->start_date));
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo old('start_date');
                                                                                                                                                                                            } ?>">
                        </div>

                        <div class="form-group">
                            <label>End Date<span class="required">*</span></label>
                            <input type="date" id="end_date" name="end_date" data-toggle="tooltip" title="Enter End Date" class="form-control" placeholder="Enter End Date" value="<?php if (isset($data->end_date)) {
                                                                                                                                                                                        echo date('Y-m-d', strtotime($data->end_date));
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo old('end_date');
                                                                                                                                                                                    } ?>">
                        </div>

                        <div class="form-group">
                            <label for="exampleSelect1">Cycle<span class="required">*</span></label>
                            <select class="form-control" id="cycle" name="cycle">
                                <option value="" data-id="0">-Select Cycle-</option>
                                <option {{($data->cycle == 1 ? 'selected' : '')}} value="1">1</option>
                                <option {{($data->cycle == 2 ? 'selected' : '')}} value="2">2</option>
                                <option {{($data->cycle == 3 ? 'selected' : '')}} value="3">3</option>
                                <option {{($data->cycle == 4 ? 'selected' : '')}} value="4">4</option>
                                <option {{($data->cycle == 5 ? 'selected' : '')}} value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Status<span class="required">*</span></label>
                            <select class="form-control" id="status" name="status">
                                <option {{($data->status == 1 ? 'selected' : '')}} value="1">Active</option>
                                <option {{($data->status == 0 ? 'selected' : '')}} value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" id="reset" class="btn btn-secondary">Reset</button>
                                <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success" id="back">Cancel</button></a>
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
        // $("#btnadd").on("click", function() {
        //     counter++;
        //     // alert('111');
        //     // $("#addfield").append('<div id="file' + counter + '"><input type="file" class="form-control mt-2" name="License_image[]" multiple> <div class="text-right">   <button type="button" class="mt-2 btn btn-danger remove_btn"  id=' + counter + '>-</button></div></div>');
        //     $("#addfield").append('<div id="file' + counter + '"><div class="row"><div class="col-lg-11 col-sm-10 col-10"><input type="file" class="form-control mt-2" name="file[]" ></div> <div class="col-lg-1 col-sm-1 col-1">   <button type="button" class="mt-2 btn btn-danger float-right mr-3 remove_btn"  id=' + counter + '>-</button></div></div></div>');
        // });
        $(".addMultipleImages").click(function() {
            console.log(counter);
            if (counter >= 2) {
                if ($('#attachment' + (counter - 1)).val()) {
                    if ($('#attachment' + (counter - 1))[0].files[0].name != null) {
                        $("#addfield").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2 delete_input"  style="text-align:center">x</button></div>');
                        $('#attachment' + counter).click();
                        counter++;

                    }
                }
                if ($('.testing').length == 0) {
                    $("#addfield").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2 delete_input" style="text-align:center">x</button></div>');
                    $('#attachment' + counter).click();
                    counter++;
                }
            } else {
                $("#addfield").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2 delete_input" style="text-align:center">x</button></div>');
                // $('#attachment' + counter).trigger('click');
                $(this).parent().siblings('.inputadd').children('#attachment' + counter).trigger('click');
                counter++;
            }
        });
        $(document).on("click", ".remove_btn", function() {
            let row_id = $(this).attr('id');
            $('#file' + row_id + '').remove();
        })
        $(document).on("click", ".delete_img", function() {
            $(this).parent().remove();
        });
        $(document).on("click", ".delete_input", function() {
            $(this).parent().remove();
        });
    });
</script>
@stop