<div class="row">
<div class="col-xl-3 col-md-3 __top-slider-cate m-0 p-0">
    @php($categories=\App\Model\Category::with(['childes.childes'])->where('position', 0)->priority()->paginate(11))
            <ul class="navbar-nav mega-nav pr-2 pl-2  d-none d-xl-block __mega-nav">
                <li class="nav-item {{!request()->is('/')?'dropdown':''}}">
                    <a class="nav-link dropdown-toggle {{Session::get('direction') === "rtl" ? 'pr-0' : 'pl-0'}}"
                       href="#" data-toggle="dropdown" style="{{request()->is('/')?'pointer-events: none':''}}">
                        <i class="czi-menu align-middle mt-n1 {{Session::get('direction') === "rtl" ? 'mr-2' : 'mr-2'}}"></i>
                        <span
                            style="margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 30px !important;margin-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 30px">
                            {{ \App\CPU\translate('categories')}}
                        </span>
                    </a>
                    @if(request()->is('/'))
                        <ul class="dropdown-menu __dropdown-menu" style="{{Session::get('direction') === "rtl" ? 'margin-right: 1px!important;text-align: right;' : 'margin-left: 1px!important;text-align: left;'}}padding-bottom: 0px!important;">
                            @foreach($categories as $key=>$category)
                                @if($key<8)
                                    <li class="dropdown">
                                        <a class="dropdown-item flex-between"
                                           <?php if ($category->childes->count() > 0) echo "data-toggle='dropdown'"?> href="javascript:"
                                           onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">
                                            <div class="d-flex">
                                                <img
                                                    src="{{asset("storage/app/public/category/$category->icon")}}"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    class="__img-18">
                                                <span
                                                    class="w-0 flex-grow-1 {{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$category['name']}}</span>
                                            </div>
                                            @if ($category->childes->count() > 0)
                                                <div>
                                                    <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} __inline-15"></i>
                                                </div>
                                            @endif
                                        </a>
                                        @if($category->childes->count()>0)
                                            <ul class="dropdown-menu"
                                                style="right: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                @foreach($category['childes'] as $subCategory)
                                                    <li class="dropdown">
                                                        <a class="dropdown-item flex-between"
                                                           <?php if ($subCategory->childes->count() > 0) echo "data-toggle='dropdown'"?> href="javascript:"
                                                           onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">
                                                            <div>
                                                                <span
                                                                    class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$subCategory['name']}}</span>
                                                            </div>
                                                            @if ($subCategory->childes->count() > 0)
                                                                <div>
                                                                    <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} __inline-15"></i>
                                                                </div>
                                                            @endif
                                                        </a>
                                                        @if($subCategory->childes->count()>0)
                                                            <ul class="dropdown-menu __r-100"
                                                                style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                                @foreach($subCategory['childes'] as $subSubCategory)
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                           href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">{{$subSubCategory['name']}}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                    @else
                        <ul class="dropdown-menu __dropdown-menu-2"
                            style="right: 0; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            @foreach($categories as $category)
                                <li class="dropdown">
                                    <a class="dropdown-item flex-between <?php if ($category->childes->count() > 0) echo "data-toggle='dropdown"?> "
                                       <?php if ($category->childes->count() > 0) echo "data-toggle='dropdown'"?> href="javascript:"
                                       onclick="location.href='{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}'">
                                        <div class="d-flex">
                                            <img src="{{asset("storage/app/public/category/$category->icon")}}"
                                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                 class="__img-18">
                                            <span
                                                class="w-0 flex-grow-1 {{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$category['name']}}</span>
                                        </div>
                                        @if ($category->childes->count() > 0)
                                            <div>
                                                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} __inline-15"></i>
                                            </div>
                                        @endif
                                    </a>
                                    @if($category->childes->count()>0)
                                        <ul class="dropdown-menu __r-100"
                                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                            @foreach($category['childes'] as $subCategory)
                                                <li class="dropdown">
                                                    <a class="dropdown-item flex-between <?php if ($subCategory->childes->count() > 0) echo "data-toggle='dropdown"?> "
                                                       <?php if ($subCategory->childes->count() > 0) echo "data-toggle='dropdown'"?> href="javascript:"
                                                       onclick="location.href='{{route('products',['id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}'">
                                                        <div>
                                                            <span
                                                                class="{{Session::get('direction') === "rtl" ? 'pr-3' : 'pl-3'}}">{{$subCategory['name']}}</span>
                                                        </div>
                                                        @if ($subCategory->childes->count() > 0)
                                                            <div>
                                                                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} __inline-15"></i>
                                                            </div>
                                                        @endif
                                                    </a>
                                                    @if($subCategory->childes->count()>0)
                                                        <ul class="dropdown-menu __r-100"
                                                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                                                            @foreach($subCategory['childes'] as $subSubCategory)
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                       href="{{route('products',['id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">{{$subSubCategory['name']}}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                            <li class="dropdown">
                                <a class="dropdown-item d-block text-center" href="{{route('categories')}}"
                                style="color: {{$web_config['primary_color']}} !important;">
                                    {{\App\CPU\translate('view_more')}}

                                    <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} __text-8px" style="background:none !important;color:{{$web_config['primary_color']}} !important;"></i>
                                </a>
                            </li>
                        </ul>
                    @endif
                </li>
            </ul>
</div>

<div class="col-xl-9 col-md-9 __top-slider-images">
    @php($main_banner=\App\Model\Banner::where('banner_type','Main Banner')->where('published',1)->orderBy('id','desc')->get())
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($main_banner as $key=>$banner)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}"
                        class="{{$key==0?'active':''}}">
                    </li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($main_banner as $key=>$banner)
                    <div class="carousel-item {{$key==0?'active':''}}">
                        <a href="{{$banner['url']}}">
                            <img class="d-block w-100 __slide-img"
                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}"
                                 alt="">
                        </a>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
               data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true" ></span>
                <span class="sr-only">{{\App\CPU\translate('Previous')}}</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
               data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">{{\App\CPU\translate('Next')}}</span>
            </a>
        </div>
</div>
  </div>
<script>
    $(function () {
        $('.list-group-item').on('click', function () {
            $('.glyphicon', this)
                .toggleClass('glyphicon-chevron-right')
                .toggleClass('glyphicon-chevron-down');
        });
    });
</script>
