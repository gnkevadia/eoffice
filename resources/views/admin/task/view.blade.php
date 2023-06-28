@extends('admin.layouts.default')

@section('title', 'Add '.VIEW_INFO['title'])

@section('content_header')
<h3 class="kt-subheader__title">{{ VIEW_INFO['title'] }} Managment</h3>
<span class="kt-subheader__separator kt-hidden"></span>
<div class="kt-subheader__breadcrumbs">
    <a href="{{ url('admin/dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ url('admin/rights') }}" class="kt-subheader__breadcrumbs-link">{{VIEW_INFO['title']}}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="#" class="kt-subheader__breadcrumbs-link">Add {{ VIEW_INFO['title'] }} Details</a>

    <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
</div>
<style>
    .CustButton {
        background-color: #e3dbc5;
        font-size: medium;
        margin: 10px;
        font-weight: 300px;
    }

    .CustdDetails>.row {
        margin-top: 25px;
    }

    .marginSubunder {
        margin-top: 80px;
    }

    .statusWidth {
        border: 1px solid #646c9a;
        width: 200px;
        color: #646c9a;
    }

    .multipleFiles {
        display: none !important;
    }

    #dltImg {
        display: none;
    }

    .delete_img {
        position: absolute;
        top: -7px;
        right: 0;
        font-weight: 900;
    }

    #addfields {
        font-weight: 900;
    }

    .delete_input {
        font-weight: 900;
    }

    .childImage {
        width: 154px;
        border: solid black 1px;
        text-align: center;
        height: 89px;
    }

    .ImagesPdfCss {
        display: flex;
        justify-content: center;
    }

    .childImage {
        position: relative;
    }

    .hideStatus {
        display: none;
    }

    .customBorder {
        margin-left: 2px;
        border-bottom: 1px solid #ebedf2;
    }

    .customMargin {
        margin-top: 50px;
    }

    .detailsMain {
        margin-top: 0px;
        border-right: 1px solid #ebedf2;
        border-left: 1px solid #ebedf2;
        border-top: 1px solid #ebedf2;
    }

    .UserComment {
        display: none;
    }

    /* #general_Comment {
        display: none;
    } */

    .replyDiv {
        display: none;
    }

    .replyComment {
        cursor: pointer;
    }

    /* body {
        margin-top: 20px;
        background: #eee;
    } */

    @media (min-width: 0) {
        .g-mr-15 {
            margin-right: 1.07143rem !important;
        }
    }

    @media (min-width: 0) {
        .g-mt-3 {
            margin-top: 0.21429rem !important;
        }
    }

    .g-height-50 {
        height: 50px;
    }

    .g-width-50 {
        width: 50px !important;
    }

    @media (min-width: 0) {
        .g-pa-30 {
            padding: 2.14286rem !important;
        }
    }

    .g-bg-secondary {
        background-color: #fafafa !important;
    }

    .u-shadow-v18 {
        box-shadow: 0 5px 10px -6px rgba(0, 0, 0, 0.15);
    }

    .g-color-gray-dark-v4 {
        color: #777 !important;
    }

    .g-font-size-12 {
        font-size: 0.85714rem !important;
    }

    .media-comment {
        margin-top: 20px
    }
</style>
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
                            View {{ VIEW_INFO['title'] }}
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->

                <div class="row customBorder">
                    <div class="col-lg-12 ">
                        <h1 class=' mt-1'>{{$data->task}}</h1>
                    </div>
                    <div class="col-lg-12 ">
                        <button type="button" class='btn btn-sm CustButton attachments'>Attachment</button>
                        <button class='btn btn-sm CustButton'>Create subtask</button>
                        <button class='btn btn-sm CustButton'>Etc</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <form enctype="multipart/form-data" action="{{ url( VIEW_INFO['url'].'/view' ) }}/{{$data->id}}" method="post">
                            @csrf
                            <div class="row  d-flex multipleFiles" id="addfield">
                                <div class="col-lg-3  inputadd multipleImage ml-2 mt-2 d-flex ">
                                    <input id="attachment" type="file" class="form-control testing attachment" name="file[]" /> <button type="button" class="btn btn-danger ml-2" id="delete_img" style="text-align:center">x</button>
                                </div>
                                <button type="button" class="btn btn-success mr-3 mt-2 addMultipleImages" id="addfields">+</button>
                            </div>
                            <div class="row customBorder customMargin">
                                <div class="col-lg-12">
                                    <h4>Description</h4>
                                    <p>{{$data->description}}</p>
                                </div>
                            </div>
                            <div class="row marginSubunder customBorder customMargin">
                                <div class="col-lg-12">
                                    <h4>Subtasks</h4>
                                </div>
                            </div>
                            <div class="row customBorder customMargin">
                                <div class="col-lg-12">
                                    <h4>Activity</h4>
                                </div>
                            </div>
                            <div class="row customBorder customMargin">
                                <div class="col-lg-12">
                                    <h4>Attachment</h4>
                                    <div class="row">

                                        @foreach($data->task_images as $image)
                                        <?php
                                        $ext = pathinfo($image->images, PATHINFO_EXTENSION);
                                        if ($ext == 'pdf') { ?>
                                            <div class="col-lg-2 col-md-4 my-3 ml-3 mb-4 ImagesPdfCss">
                                                <div class="childImage">
                                                    <img src="{{url('images/profile_image')}}/pdf.jpg" height="80" alt="" onclick="window.open('{{url('images/task')}}/{{$image->images}}','_blank')" style="padding-top: 4px;">
                                                    <input id="dltImg" type="text" name="remainimg[]" value="{{$image->id}}">
                                                    <button type="button" class="mt-2 btn btn-danger btn-sm delete_img">x</button>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-lg-2 col-md-4 my-3 ml-3 mb-4">
                                                <div class="childImage">
                                                    <img src="{{url('images/task/').'/'.$image->images}}" alt="" width="150">
                                                    <input id="dltImg" type="text" name="remainimg[]" value="{{$image->id}}">
                                                    <button type="button" class="mt-2 btn btn-danger btn-sm delete_img">x</button>
                                                </div>
                                            </div>
                                        <?php }
                                        ?>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary ml-3 mt-4 my-2">save</button>
                        </form>
                        <div class='mt-5 customBorder ml-3 mb-4'>
                            <h5>Comment</h5>
                            <div class='row addAjaxComment'>
                                @foreach($filterArray as $filterItem)
                                <div class="col-md-12">
                                    <div class="media g-mb-30 media-comment commentMain">
                                        <img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" src="{{url('admin/assets/media/users/50x50/')}}/{{$filterItem->user_comment[0]['profile_photo']}}" alt="Image Description">
                                        <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                                            <div class="g-mb-15">
                                                <h5 class="h5 g-color-gray-dark-v1 mb-0">{{$filterItem->user_comment[0]['name']}}</h5>
                                                <span class="g-color-gray-dark-v4 g-font-size-12"><?php echo date('g:i A j F, Y', strtotime($filterItem->user_comment[0]['created_at'])); ?></span>
                                            </div>
                                            <p>{{$filterItem->comment}}</p>

                                            <ul class="list-inline d-sm-flex my-0">
                                                <li class="list-inline-item ml-auto replyComment">
                                                    <!-- <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!"> -->
                                                    <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                                                    Reply
                                                    <!-- </a> -->
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- <h1>reply comm</h1> -->
                                    <div class="replyDiv">
                                        <textarea name="reply_comment" data-id='{{$filterItem->id}}' data-order='{{isset($filterItem->reply_order) ? $filterItem->reply_order : 0 }}' data-toggle="tooltip" title="Enter Reply Comment" class="form-control reply_comment" placeholder="Enter Reply Comment">{{ old('reply_comment') }}</textarea>
                                        <button class='btn btn-sm btn-primary  float-right py-1 px-2 commentreply'>Reply</button>
                                    </div>
                                </div>
                                @foreach($data->commentAndReplys as $comment)
                                @if($comment->parent_id == $filterItem->id)
                                <!---reply -->
                                <div class="col-md-12">
                                    <div class="media g-mb-30 media-comment commentMain">
                                        <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                                            <div class="g-mb-15">
                                                <h5 class="h5 g-color-gray-dark-v1 mb-0">{{$comment->user_comment[0]['name']}}</h5>
                                                <span class="g-color-gray-dark-v4 g-font-size-12"><?php echo date('g:i A j F, Y', strtotime($comment->user_comment[0]['created_at'])); ?></span>
                                            </div>
                                            <p>{{$comment->comment}}</p>

                                            <ul class="list-inline d-sm-flex my-0">
                                                <li class="list-inline-item ml-auto replyComment">
                                                    <!-- <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!"> -->
                                                    <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                                                    Reply
                                                    <!-- </a> -->
                                                </li>
                                            </ul>
                                        </div>
                                        <img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" src="{{url('admin/assets/media/users/50x50/')}}/{{$comment->user_comment[0]['profile_photo']}}" alt="Image Description">

                                    </div>
                                    <!-- <h1>reply comm</h1> -->
                                    <div class="replyDiv">
                                        <textarea name="reply_comment" data-id='{{$comment->id}}' data-order-id='{{$comment->parent_order}}' data-toggle="tooltip" title="Enter Reply Comment" class="form-control reply_comment" placeholder="Enter Reply Comment">{{ old('reply_comment') }}</textarea>
                                        <button class='btn btn-sm btn-primary  float-right py-1 px-2 commentreply'>Reply</button>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endforeach
                            </div>
                            <div class="mt-5">
                                {{$filterItem}}
                                <textarea id="general_Comment" name="general_Comment" data-order='{{isset($filterItem->parent_order) ? $filterItem->parent_order : 0 }}' data-toggle="tooltip" title="Enter General Comment" class="form-control" placeholder="Enter General Comment">{{ old('general_Comment') }}</textarea>
                                <button class='btn btn-sm btn-primary UserComment float-right py-1 px-2'>Comment</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 CustdDetails detailsMain">
                        <h4 class='mt-2'>Details</h4>

                        <div class='row'>
                            <div class="col-lg-3">
                                <h6>manager </h6>
                            </div>
                            <div class="col-lg-2">
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-7">
                                <p>{{$data->managerName}}</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-3">
                                <h6>Hour</h6>
                            </div>
                            <div class="col-lg-2">
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-7">
                                <p>{{$data->hour_task}}</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-3">
                                <h6>Priority</h6>
                            </div>
                            <div class="col-lg-2">
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-7">
                                <p>{{$data->priorityName}}</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-3">
                                <h6>Ticket</h6>
                            </div>
                            <div class="col-lg-2">
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-7">
                                <p>{{$data->ticket}}</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-3">
                                <h6>Status</h6>
                            </div>
                            <div class="col-lg-2">
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-7">
                                <form class='d-flex' action="{{ url( VIEW_INFO['url'].'/status' ) }}/{{$data->id}}" method='post'>
                                    @csrf
                                    <select class="statusWidth" id="status" name="status">
                                        <option value="" data-id="0">-Select Status-</option>
                                        @foreach ($taskstatus as $status)
                                        <option value="{{$status->id}}" {{($status->id == $data->status ? 'selected' : '')}}>{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                    <button type='submit' class='btn btn-primary py-1 px-2 ml-1 btn-sm hideStatus statusUpdate'>save</button>
                                </form>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-3">
                                <h6>Start Date</h6>
                            </div>
                            <div class="col-lg-2">
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-7">
                                <p>{{$data->start_date}}</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-3">
                                <h6>End Date</h6>
                            </div>
                            <div class="col-lg-2">
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-7">
                                <p>{{$data->end_date}}</p>
                            </div>
                        </div>
                    </div>
                </div>


                <!--end::Form-->
            </div>

            <!--end::Portlet-->
        </div>

    </div>
</div>
<!-- Main content -->

@stop

@section('metronic_js')
<!-- <script src="{{ asset('admin/assets/js/ckeditor/ckeditor.js') }}"></script> -->
<script>
    // CKEDITOR.replace('general_notes');

    $(document).ready(function() {
        var counter = 1;
        $(".addMultipleImages").click(function() {
            $("#addfield").prepend(' <div class="col-lg-3 inputadd multipleImage ml-2 mt-2 d-flex"><input id="attachment' + counter + '" type="file" class="form-control testing attachment' + counter + '" name="file[]" /> <button type="button" class="btn btn-danger ml-2" id="delete_img" style="text-align:center">x</button></div>');
            $('#attachment' + counter).trigger('click');
            counter++;

        });
        $(".UserComment").on('click', function() {
            let userComment = $('#general_Comment').val();
            let url = '{{url("addCommnet")}}';
            let ticket = '<?php echo $data->ticket; ?>';
            let parent_order = $(this).siblings('textarea').data('order');
            let imgUrl = '<?php echo Session::get('profile_photo') ?>';
            let userName = '<?php echo Session::get('name') ?>';
            let isComment = true;


            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: url,
                type: 'post',
                data: {
                    'comment': userComment,
                    'ticket': ticket,
                    'isComment': isComment,
                    'parent_order': parent_order
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log("comment datas", data);
                    // if (data == true) {
                    //     $('#general_Comment').val('');
                    // }
                    // // var html = '<div class="py-2"> <div class="d-flex justify-content-between py-1 pt-2"><div><img src="' + imgUrl + '" width="18"><span class="text2">' + userName + '</span></div></div> </div>';
                    // var html = '<div class="col-md-12"><div class="media g-mb-30 media-comment"><img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" src="' + imgUrl + '" alt="Image Description"><div class="media-body u-shadow-v18 g-bg-secondary g-pa-30"><div class="g-mb-15"><h5 class="h5 g-color-gray-dark-v1 mb-0">' + userName + '</h5><span class="g-color-gray-dark-v4 g-font-size-12">' + date + '</span></div><p>' + userComment + '</p><ul class="list-inline d-sm-flex my-0"><li class="list-inline-item ml-auto"><a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!"><i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>Reply</a></li></ul></div></div></div>';

                    // $(".addAjaxComment").append(html);
                }
            });
        });
        $(".replyComment").on('click', function() {
            $(this).closest('.commentMain').siblings('.replyDiv').show();
        });

        $(".commentreply").on('click', function() {
            let comment = $(this).siblings('textarea').val();
            // let comment_id = $(this).siblings('textarea').data('id');
            let parent_id = $(this).siblings('textarea').data('id');
            let reply_order = $(this).siblings('textarea').data('order');
            let commentReply = true;
            let imgUrl = '<?php echo Session::get('profile_photo') ?>';
            let userName = '<?php echo Session::get('name') ?>';
            let ticket = '<?php echo $data->ticket; ?>';
            let url = '{{url("addCommnet")}}';
            $.ajax({
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                url: url,
                type: 'post',
                data: {
                    // 'comment_id': comment_id,
                    'parent_id': parent_id,
                    'commentReply': commentReply,
                    'comment': comment,
                    'ticket': ticket,
                    'reply_order': reply_order
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log("reply data", data);
                    // if (data == true) {
                    //     $('#general_Comment').val('');
                    // }
                    // var html = '<div class="py-2"> <div class="d-flex justify-content-between py-1 pt-2"><div><img src="' + imgUrl + '" width="18"><span class="text2">' + userName + '</span></div></div> </div>';
                    // var html = '<div class="col-md-12"><div class="media g-mb-30 media-comment"><img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" src="' + imgUrl + '" alt="Image Description"><div class="media-body u-shadow-v18 g-bg-secondary g-pa-30"><div class="g-mb-15"><h5 class="h5 g-color-gray-dark-v1 mb-0">' + userName + '</h5><span class="g-color-gray-dark-v4 g-font-size-12"></span></div><p>' + userComment + '</p><ul class="list-inline d-sm-flex my-0"><li class="list-inline-item ml-auto"><a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!"><i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>Reply</a></li></ul></div></div></div>';

                    // $(".addAjaxComment").append(html);
                }
            });
        });
        // $(".replyOfReply").on('click', function() {
        //     let reply = $(this).siblings('textarea').val();
        //     let reply_id = $(this).siblings('textarea').data('id');
        //     let comment_id = $(this).siblings('textarea').data('comment-id');
        //     // console.log('commentreply', reply_id);
        //     let replyOfReply = true;
        //     let imgUrl = '<?php echo Session::get('profile_photo') ?>';
        //     let userName = '<?php echo Session::get('name') ?>';
        //     let ticket = '<?php echo $data->ticket; ?>';
        //     let url = '{{url("addCommnet")}}';
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-Token': '{{ csrf_token() }}',
        //         },
        //         url: url,
        //         type: 'post',
        //         data: {
        //             'reply_id': reply_id,
        //             'replyOfReply': replyOfReply,
        //             'reply': reply,
        //             'comment_id': comment_id,
        //             'ticket': ticket
        //         },
        //         dataType: 'JSON',
        //         success: function(data) {
        //             console.log("datasss", data);
        //             // if (data == true) {
        //             //     $('#general_Comment').val('');
        //             // }
        //             // var html = '<div class="py-2"> <div class="d-flex justify-content-between py-1 pt-2"><div><img src="' + imgUrl + '" width="18"><span class="text2">' + userName + '</span></div></div> </div>';
        //             var html = '<div class="col-md-12"><div class="media g-mb-30 media-comment"><img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" src="' + imgUrl + '" alt="Image Description"><div class="media-body u-shadow-v18 g-bg-secondary g-pa-30"><div class="g-mb-15"><h5 class="h5 g-color-gray-dark-v1 mb-0">' + userName + '</h5><span class="g-color-gray-dark-v4 g-font-size-12">' + date + '</span></div><p>' + userComment + '</p><ul class="list-inline d-sm-flex my-0"><li class="list-inline-item ml-auto"><a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!"><i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>Reply</a></li></ul></div></div></div>';

        //             $(".addAjaxComment").append(html);
        //         }
        //     });
        // });







        $('.statusWidth').change(function() {
            $('.statusUpdate').show();
        });



        $("#general_Comment").keyup(function() {
            $('.UserComment').show();
        });

        $(document).on("click", "#delete_img", function() {
            $(this).parent().remove();
        });
        $(document).on("click", ".attachments", function() {
            $('#attachment').trigger('click');
            $('.multipleFiles').removeClass('multipleFiles');
        });
        $(document).on("click", ".remove_btn", function() {
            let row_id = $(this).attr('id');
            $('#file' + row_id + '').remove();
        })
        $(document).on("click", ".delete_img", function() {
            $(this).parent().parent().remove();
        });
        $(document).on("click", ".delete_input", function() {
            $(this).parent().remove();
        });


    });
</script>
@stop