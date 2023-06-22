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

    #delete_img {
        font-weight: 900;
    }

    .addMultipleImages {
        font-weight: 900;
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
                        @if (session()->get('superAdmin'))
                        <div class="form-group">
                            <label>Company<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="company_id" id="company" class="form-control">
                                    <option value="">-Select Company-</option>
                                    @foreach ($companyData as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Department<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="department_id" id="department" class="form-control department">
                                    <option value="">-Select Department-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Manager<span class="required">*</span></label>
                            <select class="form-control manager" id="manager" name="manager">
                                <option value="" selected>-Select Manager-</option>
                            </select>
                        </div>
                        @endif
                        @if (session()->get('sub_admin'))
                        <div class="form-group">
                            <label>Department<span class="required"><code>*</code></span></label>
                            <div>
                                <select name="department_id" id="department" class="form-control department">
                                    <option value="">-Select Department-</option>
                                    @foreach ($arrDepartment as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Manager<span class="required">*</span></label>
                            <select class="form-control manager" id="manager" name="manager">
                                <option value="" selected>-Select Manager-</option>
                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleSelect1">Project<span class="required">*</span></label>
                            <select class="form-control" id="Project" name="Project">
                                <option value="" data-id="0">-Select Project-</option>
                                <!-- @foreach ($arrproject as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Features<span class="required">*</span></label>
                            <select class="form-control" id="features" name="features">
                                <option value="" data-id="0">-Select Features-</option>
                                @foreach ($arrfeatures as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Task<span class="required">*</span></label>
                            <input type="text" id="task" name="task" data-toggle="tooltip" title="Enter Task" class="form-control" placeholder="Enter task" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label>Description<span class="required">*</span></label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="form-group">

                            <label for="exampleSelect1">Attachment<span class="required">*</span></label>
                            <div class="row" id="addfield">
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-success mr-3 mt-2 addMultipleImages" id="addfields">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Priority<span class="required">*</span></label>
                            <select class="form-control" id="priority" name="priority">
                                <option value="" data-id="0">-Select Priority-</option>
                                @foreach ($priority as $value)
                                <option value="{{$value->id}}">{{$value->priority}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Assignee<span class="required">*</span></label>
                            <select class="form-control" id="assignee" name="assignee">
                                <option value="" data-id="0">-Select Assignee-</option>
                                @foreach ($arrusers as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hour of Task<span class="required">*</span></label>
                            <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" id="hour_task" name="hour_task" data-toggle="tooltip" title="Enter Hour of Task" class="form-control" placeholder="Enter Hour of Task" value="{{ old('hour_task') }}">
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
                            <select class="form-control" id="cycle" name="cycle">
                                <option value="" data-id="0">-Select Cycle-</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1">Status<span class="required">*</span></label>
                            <select class="form-control" id="status" name="status">
                                <option value="" data-id="0">-Select Status-</option>
                                @foreach ($taskstatus as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
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

        $("#btnadd").on("click", function() {
            counter++;
            // alert('111');
            // $("#addfield").append('<div id="file' + counter + '"><input type="file" class="form-control mt-2" name="License_image[]" multiple> <div class="text-right">   <button type="button" class="mt-2 btn btn-danger remove_btn"  id=' + counter + '>-</button></div></div>');

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
                        $("#addfield").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2" id="delete_img" style="text-align:center">x</button></div>');
                        $('#attachment' + counter).click();
                        counter++;

                    }
                }
                if ($('.testing').length == 0) {
                    $("#addfield").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2" id="delete_img" style="text-align:center">x</button></div>');
                    $('#attachment' + counter).click();
                    counter++;
                }
            } else {
                $("#addfield").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2"></p><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2" id="delete_img" style="text-align:center">x</button></div>');
                // $('#attachment' + counter).trigger('click');
                $(this).parent().siblings('.inputadd').children('#attachment' + counter).trigger('click');
                counter++;
            }
        });
        $(document).on("click", "#delete_img", function() {
            $(this).parent().remove();
        });


        $("#company").change(function() {
            let id = $(this).val();
            let url = '{{url("getDepartments")}}';
            if (id == null) {
                id = '0';
            }
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: url,
                type: 'post',
                data: {
                    'id': id
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log('data', data);
                    var html = '<option value="">-Select Department-</option>';
                    $.each(data, function(i) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    });
                    $("#department").html(html);
                }
            });
        });

        $(".department").change(function() {
            let id = $(this).val();
            let companyId = $('#company').val();
            let url = '{{url("getManager")}}';
            if (id == null) {
                id = '0';
            }
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: url,
                type: 'post',
                data: {
                    'id': id,
                    'company_id': companyId
                },
                dataType: 'JSON',
                success: function(data) {
                    var html = '<option value="">-Select Manager-</option>';
                    $.each(data, function(i) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    });
                    $(".manager").html(html);
                }
            });
        });

        $(".manager").change(function() {
            let id = $(this).val();
            console.log('manager', id);
            let companyId = $('#company').val();
            let url = '{{url("getProject")}}';
            if (id == null) {
                id = '0';
            }
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: url,
                type: 'post',
                data: {
                    'id': id,
                    'company_id': companyId
                },
                dataType: 'JSON',
                success: function(data) {
                    var html = '<option value="">-Select Project-</option>';
                    $.each(data, function(i) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    });
                    $(".project").html(html);
                }
            });
        });


    });
</script>
@stop