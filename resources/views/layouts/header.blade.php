@php
$arrPacakge = \App\Library\Common::getCommonPacakgeList();
$arrCategory = \App\Library\Common::fetchCategoryTree();
@endphp
<section class="top-header">
    <div class="container">
        <div class="row d-flex  align-items-center">
            <div class="col-lg-8 col-md-7">
                <div class="left-head-top d-flex">
                    <div class="contact-head logo-2">
                        <a href="{{ url('/') }}">
                            <img src="{{asset('assets/img/logo/logo-2.png') }}" alt="">
                        </a>
                    </div>
                    <div class="language d-none d-md-flex pl-30 align-items-center">
                        <i class="fas fa-globe-americas mr-5"></i>
                        <select class="form-control lan-select" id="sel1">
                            <option>Choose region</option>
                            @if(isset($arrRegions) && !empty($arrRegions))
                                @foreach($arrRegions as $keyRegion=>$valRegion)
                                    <option>{{$valRegion->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4  col-md-5">
                <div class="icon-links icon-links-top d-flex align-items-center">
                    <div class="container">
                        <form class="searchbar" method="post" action="/news-and-update">{{ csrf_field() }}
                            <input id="search" type="search" placeholder="Search here" name="search" class="searchbar-input" onkeyup="buttonUp();" value="">
                            <button id="submit" name="submit" type="submit" class="searchbar-submit">GO</button>
                            <span class="searchbar-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
                        </form>
                    </div>
                    <a href="cart" class="shop-icon d-none d-md-block">
                        <i class="fas fa-shopping-basket black"></i>
                        @if(Session::get('email') != '')
                        <?php $results = DB::table('reports')->where(['reports.deleted' => 0, 'reports.user_id' => Session::get('id')])->get(); ?>
                        <span class="count">{{ count($results) }}</span>
                        @endif
                    </a>
                    <div class="language d-none d-md-flex pl-30 align-items-center">
                        <i class="fas fa-globe-americas mr-5"></i>
                        <select class="form-control lan-select" id="sel1">
                            <option>ENG</option>
                        </select>
                    </div>
                    @if(Session::get('email') != '')
                    <div class="container">
                        <?php 
                        $userEmail = Session::get('email');
                        $profile_photo =  DB::table('users')->where(['email'=> $userEmail])->first();
                        ?>
                        <a href="/user-edit"><img src="/images/profile_image/<?php echo $profile_photo->profile_photo ?>" width="50px;" height="50px"></a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bottom-head transition-4 bg-blue">
    <div class="container ">
        <div class="row align-items-center no-gutters">
            <div class="col-lg-10 text-left p-md-0">
                <div class="menu-links-2">
                    <nav class="main-menu main-menu-2 white">
                        <ul>
                            <?php
                            $results = DB::table('menus')->where(['menus.deleted' => 0])->leftJoin('rights', 'menus.right_id', '=', 'rights.id')->leftJoin('menu_types', 'menu_types.id', '=', 'menus.menu_type_id')->where('menu_types.id', '=', 2)->where('menus.status', '=', 1)->select('menus.*', 'rights.routes')->groupBy('menus.id')->orderBy('menus.parent_id')->orderBy('menus.ordering')->get();

                            if (isset($results) && !empty($results)) {
                                foreach ($results as $keyRes => $valRes) {
                                    $menuCategory['categories'][$valRes->id] = $valRes;
                                    $menuCategory['parent_cats'][$valRes->parent_id][] = $valRes->id;
                                }
                            }
                            function getCategories($parent, $category)
                            {
                                $html = "";
                                if (isset($category['parent_cats'][$parent])) {
                                    if ($parent == 0) {
                                        $html .= "<ul>";
                                    } else {
                                        $html .= "<ul class='submenu'>";
                                    }

                                    foreach ($category['parent_cats'][$parent] as $cat_id) {
                                        if (!isset($category['parent_cats'][$cat_id])) {
                                            $html .= "<li>  <a href='" . $category['categories'][$cat_id]->alias . "'>" . $category['categories'][$cat_id]->name . "</a></li> ";
                                        }
                                        if (isset($category['parent_cats'][$cat_id])) {
                                            $html .= "<li>  <a href='" . $category['categories'][$cat_id]->alias . "'>" . $category['categories'][$cat_id]->name . "</a> ";
                                            $html .= getCategories($cat_id, $category);
                                            $html .= "</li> ";
                                        }
                                    }
                                    $html .= "</ul> ";
                                }
                                return $html;
                            }
                            echo getCategories(0, $menuCategory);
                            ?>
                        </ul>
                    </nav>
                </div>
                <div class="mobile-menu-2"></div>
            </div>
            <div class="col-lg-1 d-lg-block">
                @if(Session::get('email') != '')
                    <a href="/log-out" class="btn btn-round-border green mb-18 mt-md-20 blob-small">Logout</a>
                @else
                    <a href="/log-in" class="btn btn-round-border green mb-18 mt-md-20 blob-small">Login</a>
                @endif
            </div>
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var submitIcon = $('.searchbar-icon');
        var inputBox = $('.searchbar-input');
        var searchbar = $('.searchbar');
        var isOpen = false;
        submitIcon.click(function() {
            if (isOpen == false) {
                searchbar.addClass('searchbar-open');
                inputBox.focus();
                isOpen = true;
            } else {
                searchbar.removeClass('searchbar-open');
                inputBox.focusout();
                isOpen = false;
            }
        });
        submitIcon.mouseup(function() {
            return false;
        });
        searchbar.mouseup(function() {
            return false;
        });
        $(document).mouseup(function() {
            if (isOpen == true) {
                $('.searchbar-icon').css('display', 'block');
                submitIcon.click();
            }
        });
    });

    function buttonUp() {
        var inputVal = $('.searchbar-input').val();
        inputVal = $.trim(inputVal).length;
        if (inputVal !== 0) {
            $('.searchbar-icon').css('display', 'none');
        } else {
            $('.searchbar-input').val('');
            $('.searchbar-icon').css('display', 'block');
        }
    }
</script>
{{-- <script type="text/javascript">
    $(document).ready(function () {
        var url = '{{URL::to('/news-and-update')}}';
$('#submit').on('click', function(){
var searchBlogList = $('#search').val();
$.ajax({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
type:'POST',
url:url,
data:{searchBlogList:searchBlogList},
success:function(data){
console.log(data);
// if(data.length) {
// data.forEach(el => {
// $("#parent_id").append(`<option value='${el.id}'> ${el.name}</option>`)
// })
// }
}
});
})
});
</script> --}}