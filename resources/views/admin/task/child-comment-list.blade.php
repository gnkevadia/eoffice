@if(count((array)$comments))
@foreach($comments as $comment)

<div class="col-md-12">
    <div class="media g-mb-30 media-comment commentMain">
        <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
            <div class="g-mb-15">
            </div>
            <p>{{ $comment->comment }}</p>

            <ul class="list-inline d-sm-flex my-0">
                <li class="list-inline-item ml-auto replyComment">
                    <!-- <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!"> -->
                    <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                    Reply
                    <!-- </a> -->
                </li>
            </ul>
        </div>
        <img class="d-flex g-width-50 g-height-50 rounded-circle g-mt-3 g-mr-15" src="{{url('admin/assets/media/users/50x50/')}}/" alt="Image Description">
    </div>
    <div class="replyDiv">
        <textarea name="reply_comment" data-id='{{$comment->id}}' data-parent='{{$comment->id}}' data-toggle="tooltip" title="Enter Reply Comment" class="form-control reply_comment" placeholder="Enter Reply Comment">{{ old('reply_comment') }}</textarea>
        <button class='btn btn-sm btn-primary  float-right py-1 px-2 commentreply'>Reply</button>
    </div>
</div>

@if(count((array)$comment->replies))

@include('admin/task/child-comment-list',['comments'=>$comment->replies])

@endif
@endforeach
@endif