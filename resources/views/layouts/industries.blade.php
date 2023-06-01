<section class="blog-type-2 pt-95 pb-100">
    <div class="container">
        <div class="row align-items-end  mb-45">
            <div class="col-lg-7 col-md-12 text-center text-lg-left">
                <div class="fancy-head left-al">
                    <h5 class="line-head mb-15">
                        <span class="line before d-lg-none"></span>
                        Industries
                        <span class="line after"></span>
                    </h5>
                    <h1>We Serve</h1>
                </div>
            </div>
            <div class="col-lg-5 col-md-12 text-center text-lg-right">
                <a href="industries-list" class="btn btn-round-border mb-15 mt-md-20">View All</a>
            </div>
        </div>
        <div class="row mb-20 mb-sm-00">
            @if(isset($arrIndustries) && !empty($arrIndustries))
                @foreach($arrIndustries as $keypages=>$val)
                <div class="col-md-6">
                    <div class="blog-box relative">
                        <div class="blog-img img-lined mr-40 mr-md-00">
                            <img src="{{ asset('images/industries/'.$val->media_file) }}" alt="" class="w-100">
                        </div>
                        <div class="blog-box-text z-10 bg-green-op-9 shadow-4 mb-sm-30">
                            <h5 class="white f-700 mb-10"><a href="{{$val->alias}}" class="fs-19">{{ $val->title }}</a></h5>
                            <p class="blue mb-10">
                                <span class="line-before transition-4">{{ $val->content }}</span>
                            </p>
                            <a href="{{$val->alias}}" class="text-link-a white fs-13 mb-10 uppercase f-600">Readmore <i class="fas fa-long-arrow-alt-right ml-10"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>