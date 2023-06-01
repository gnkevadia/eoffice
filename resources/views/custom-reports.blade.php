@extends('layouts.default')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================= -->
<!-- nav Tabs -->
@if(!empty(Session::get('email')))
<section class="pb-4">
    <div class="bg-white rounded-5">
        <section class="p-4">
            <div class="container">
                <div class="row align-items-end  mb-45">
                    <div class="col-lg-8 col-md-12 text-center text-lg-left">
                        <div class="fancy-head left-al">
                            <h2>Search & Filter to Customize your Report</h2>
                        </div>
                    </div>
                </div>
            </div>
            <form id="frmCustomReportSearch" name="frmCustomReportSearch" action="/custom-reports" method="post">{{ csrf_field() }}
                <div class="tab-content" id="ex1-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group" id="boot-search-box">
                                    <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Please Enter zip" />
                                    <button class="btn btn-secondary" id="buttonZip"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</section>
<section class="about-us">
    <div class="container">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered" id="tableData" name="tableData">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2"><input type="checkbox" id="checkAll" class="tableCheckbox" /></th>
                            <th scope="col" rowspan="2">Gas Brand</th>
                            <th scope="col" rowspan="2">Zip Code</th>
                            <th scope="col" rowspan="2">No Of Pump</th>
                            <th scope="col" rowspan="2">Unleaded</th>
                            <th scope="col" colspan="3" class="text-center">Types</th>
                        </tr>
                        <tr>
                            <td scope="col"><strong>Midgrede</strong></td>
                            <td scope="col"><strong>Premium</strong></td>
                            <td scope="col"><strong>Diesel</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(@isset($terminal) && !empty($terminal))
                        @foreach($terminal as $key=> $value)
                        <tr>
                            <td scope="row"><input type="checkbox" name="case[]" class="tableCheckbox" id="{{$value->id}}" value="{{$value->id}}" /></td>
                            <td>{{$value->gas_brand}}</td>
                            <td>{{$value->zip_code}}</td>
                            <td>{{$value->nos_of_pump}}</td>
                            <td>{{$value->unleaded}}</td>
                            <td>{{$value->midgrede}}</td>
                            <td>{{$value->premium}}</td>
                            <td>{{$value->diesel}}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                {!! $terminal->withQueryString()->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
</section>
<section class="about-us pt-10 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <button class="btn btn-square-green uppercase blob-small" id="getSelectValue">Add to Your List</button>
            </div>
        </div>
    </div>
</section>
<section class="about-us hideJSection">
    <div class="container">
        <form id="frmCustomReport" name="frmCustomReport" action="/custom-reports" method="post">{{ csrf_field() }}
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered" id="tablehide" name="tablehide">
                        <thead class="theadHide">
                            <tr>
                                <th scope="col" rowspan="2"></th>
                                <th scope="col" rowspan="2">Gas Brand</th>
                                <th scope="col" rowspan="2">Zip Code</th>
                                <th scope="col" rowspan="2">No Of Pump</th>
                                <th scope="col" rowspan="2">Unleaded</th>
                                <th scope="col" colspan="3" class="text-center">Types</th>
                            </tr>
                            <tr>
                                <td scope="col"><strong>Midgrede</strong></td>
                                <td scope="col"><strong>Premium</strong></td>
                                <td scope="col"><strong>Diesel</strong></td>
                            </tr>
                        </thead>
                        <tbody id="tableData2"></tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="about-us pt-10 pb-70 hideSection">
    <div class="container">
        <div class="text-center text-lg-right z-5">
            <button class="btn btn-square-green uppercase blob-small" id="removeSelectValue">Remove From Your
                List</button>
            <button class="btn btn-square-green uppercase blob-small" id="addSelectValue" type="submit" name="submit">Add To Report & Continue</button>
        </div>
    </div>
</section>
@else
<section class="about-us pt-10 pb-70">
    <div class="container">
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="col-xl-8 col-lg-7 text-center text-lg-right z-5">
            <h6>Please login & Register to purchase the product.</h6><br>
            <a href="/log-in" class="btn btn-square-green d-block d-sm-inline-block blob-small wow fadeInUp">@csrf
                <i class="fas fa-sign-in-alt mr-15"></i>LOGIN
            </a>
            <a href="sign-up" class="btn btn-square-green d-block d-sm-inline-block blob-small wow fadeInUp">@csrf
                <i class="fas fa-registered mr-15"></i>REGISTER
            </a>
        </div>
    </div>
</section>
@endif

<!-- nav Tabs -->
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
@endsection
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.theadHide').hide();
        $('.hideSection').hide();

        $("#getSelectValue").click(function() {

            var getSelectArray = new Array();
            $.each($("input[name='case[]']:checked"),
                function() {
                    $('.theadHide').show();
                    $('#tableData2').append('<tr>' + $(this).closest('tr').html() + '</tr>');
                    $('.hideSection').show();
                });
            $(".tableCheckbox").prop("checked", false);
        });

        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#removeSelectValue").click(function() {
            // $('table').has('input[name="case[]"]:checked').remove()
            location.reload(true);
        });

        $("#addSelectValue").click(function() {
            var numberOfChecked = $('input:checkbox:checked').length;
            if (numberOfChecked < 3) {
                alert('please select max 3 checkbox');
            } else {
                $("#frmCustomReport").submit();
            }
        });

        // $('#buttonZip').click(function() {
        //     var zip_code = $("#zip_code").val();
        //     var url = '{{URL::to('/custom-reports/')}}';
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         type:'POST',
        //         url:url,
        //         data:{zip_code:zip_code},
        //         success: function(data) {
        //             $('.displaySearch').html($data);
        //         }
        //     });
        // });
    });
</script>