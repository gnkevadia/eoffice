@extends('admin.layouts.default')


@section('title', 'Edit '.VIEW_INFO['title'])

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
                <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'].'/edit/'.$data->id) }}" class="kt-form" method="post">
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
                                <option {{($data->Project == 1 ? 'selected' : '')}} value="1">1</option>
                                <option {{($data->Project == 0 ? 'selected' : '')}} value="0">2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Module<span class="required">*</span></label>
                            <select class="form-control" id="status" name="module">
                                <option {{($data->module == 1 ? 'selected' : '')}} value="1">Features</option>
                                <option {{($data->module == 0 ? 'selected' : '')}} value="0">Types</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Task<span class="required">*</span></label>
                            <input type="text" id="task" name="task" data-toggle="tooltip" title="Enter Task" class="form-control" placeholder="Enter task" value="{{$data->task}}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description">{{$data->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Attachment<span class="required">*</span></label>
                            <input type="file" id="attachment" name="attachment" data-toggle="tooltip" title="Enter Attachment" class="form-control" placeholder="Enter Attachment" value="{{$data->attachment}}">

                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Pryority<span class="required">*</span></label>
                            <select class="form-control" id="status" name="Pryority">
                                <option {{($data->Pryority == 1 ? 'selected' : '')}} value="1">Yes</option>
                                <option {{($data->Pryority == 0 ? 'selected' : '')}} value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Assignee<span class="required">*</span></label>
                            <select class="form-control" id="status" name="assignee">
                                <option {{($data->assignee == 1 ? 'selected' : '')}} value="1">jatan</option>
                                <option {{($data->assignee == 0 ? 'selected' : '')}} value="0">fenil</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Start Date<span class="required">*</span></label>
                            <input type="date" id="start_date" name="start_date" data-toggle="tooltip" title="Enter Start Date" class="form-control" placeholder="Enter Start Date" value="<?php if (isset($data->start_date)) { echo date('Y-m-d', strtotime($data->start_date)); } else { echo old('start_date'); } ?>">
                        </div>

                        <div class="form-group">
                            <label>End Date<span class="required">*</span></label>
                            <input type="date" id="end_date" name="end_date" data-toggle="tooltip" title="Enter End Date" class="form-control" placeholder="Enter End Date" value="<?php if (isset($data->end_date)) { echo date('Y-m-d', strtotime($data->end_date)); } else { echo old('end_date');} ?>">
                        </div>

                        <div class="form-group">
                            <label for="exampleSelect1">Cycle<span class="required">*</span></label>
                            <select class="form-control" id="status" name="cycle">
                                <option {{($data->cycle == 1 ? 'selected' : '')}} value="1">00</option>
                                <option {{($data->cycle == 0 ? 'selected' : '')}} value="0">11</option>
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
@stop