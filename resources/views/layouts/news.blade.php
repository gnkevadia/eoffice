<!-- Service start -->
<section class="services bg-light-white pt-95 pb-70 bg">
        <div class="container">
            <div class="row align-items-end  mb-45">
                <div class="col-lg-7 col-md-12 text-center text-lg-left">
                    <div class="fancy-head left-al">
                        <h5 class="line-head mb-15">
                  <span class="line before d-lg-none"></span>
                    Latest
                  <span class="line after"></span>
                    </h5>
                        <h1>News and Updates</h1>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 text-center text-lg-right">
                    <a href="news-and-update" class="btn btn-round-border mb-15 mt-md-20">View All</a>
                </div>
            </div>
            <div class="row">
            @if(isset($arrNews) && !empty($arrNews))
                    @foreach($arrNews as $keypages=>$val)
                <div class="col-lg-4 col-md-6">
                        <div class="service-box type-2 transition-4 text-left relative img-lined mb-30">
                            <div class="service-icon-2 z-5">
                                <img src="{{ asset('images/news/'.$val->media_file) }}" class="transform-center" alt="">
                            </div>
                            <div class="service-text">
                                <h4 class="f-700 mt-20 mb-10">
                                    <a href="{{$val->alias}}">{{ $val->title }}</a>
                                </h4>
                                <a href="{{$val->alias}}" class="btn btn-round mt-10">Learn More</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif                
            </div>
        </div>
    </section>
<!-- Service end-->