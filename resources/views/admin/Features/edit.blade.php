@extends('admin.layouts.default')


@section('title', 'Edit'.VIEW_INFO['title'])

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
                        @if (session()->get('superAdmin'))
                        <div class="form-group">
                            <label>Company<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="company_id" id="company" class="form-control">
                                    <option value="" data-id="0">-Select Company-</option>
                                    @foreach ($companyData as $company)
                                    <option value="{{ $company->id }}" {{($company->id == $data->company_id ? 'selected' : '')}}>{{ $company->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleSelect1">Project<span class="required">*</span></label>
                            <select class="form-control" id="Project" name="Project">
                                <option value="" data-id="0">-Select Project-</option>
                                @foreach ($arrproject as $value)
                                <option value="{{$value->id}}" {{($value->id == $data->project ? 'selected' : '')}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name<span class="required">*</span></label>
                            <input type="text" id="name" name="name" data-toggle="tooltip" title="Enter Name" class="form-control" placeholder="Enter Name" value="{{$data->name}}">
                        </div>
                        <div class="form-group">
                            <label>Description<span class="required">*</span></label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description">{{$data->description}}</textarea>
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
<script src="{{ asset('admin/assets/js/pages/custom/features-validation.js') }}"></script>
@stop