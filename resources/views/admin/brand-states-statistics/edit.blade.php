@extends('admin.layouts.default')

@section('title', 'Edit ' . VIEW_INFO['title'])

@section('content_header')
    <h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
    <span class="kt-subheader__separator kt-hidden"></span>
    <div class="kt-subheader__breadcrumbs">
        <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="{{ url('admin/brand-states-statistics') }}"
            class="kt-subheader__breadcrumbs-link">{{ VIEW_INFO['title'] }}</a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">Update {{ VIEW_INFO['title'] }} Details</a>

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
                                Update {{ VIEW_INFO['title'] }}
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form id="frmAddEdit" name="frmAddEdit" action="{{ url(VIEW_INFO['url'] . '/edit/' . $data->id) }}"
                        class="form-horizontal" method="post">{{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="{{ $data->id }}">
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
                            @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                            <div class="form-group">
                                <label for="exampleSelect1">Brand<span class="required"><code>*</code></span></label>
                                <select name="brand" id="brand" class="form-control">
                                    <option value="0">No Brand</option>
                                    @if (isset($brand) && !empty($brand))
                                        @foreach ($brand as $key => $val)
                                            <option value="{{ $val['name'] }}"
                                                {{ $data->brand == $val['name'] ? 'selected' : '' }}>{{ $val['name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleSelect1">State<span class="required"><code>*</code></span></label>
                                <select name="states" id="states" class="form-control">
                                    <option value="0">No States</option>
                                    @if (isset($states) && !empty($states))
                                        @foreach ($states as $key => $val)
                                            <option value="{{ $val['states_name'] }}"
                                                {{ $data->states_name == $val['states_name'] ? 'selected' : '' }}>{{ $val['states_name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleSelect1">Total<span class="required"><code>*</code></span></label>
                                <input type="text" id="total" name="total" maxlength="50" data-toggle="tooltip" title="Enter Total" class="form-control" placeholder="Enter Total" @if(isset($data['total'])) value="{{ $data['total'] }}" @endif>
                            </div>
                            <div class="form-group">
                                <label for="exampleSelect1">Status<span class="required"><code>*</code></span></label>
                                <select class="form-control" id="status" name="status">
                                    <option {{ $data->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                    <option {{ $data->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                                </select>
                            </div>


                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" id="reset" class="btn btn-secondary">Reset</button>
                                    <a href="{{ url(VIEW_INFO['url']) }}"><button type="button" class="btn btn-success"
                                            id="back">Cancel</button></a>
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
@stop

@section('metronic_js')
    <script src="{{ asset('admin/assets/js/pages/custom/brand-states-statistics.js') }}"></script>
@stop
