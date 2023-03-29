@extends('layouts.front-end.app')

@section('title', $web_config['name']->value.' '.\App\CPU\translate('Online Shopping').' | '.$web_config['name']->value.' '.\App\CPU\translate(' Ecommerce'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/home.css"/>
    <style>
        .cz-countdown-days {
            border: .5px solid{{$web_config['primary_color']}};
        }

        .btn-scroll-top {
            background: {{$web_config['primary_color']}};
        }

        .__best-selling:hover .ptr,
        .flash_deal_product:hover .flash-product-title {
            color: {{$web_config['primary_color']}};
        }

        .cz-countdown-hours {
            border: .5px solid{{$web_config['primary_color']}};
        }

        .cz-countdown-minutes {
            border: .5px solid{{$web_config['primary_color']}};
        }

        .cz-countdown-seconds {
            border: .5px solid{{$web_config['primary_color']}};
        }

        .flash_deal_product_details .flash-product-price {
            color: {{$web_config['primary_color']}};
        }

        .featured_deal_left {
            background: {{$web_config['primary_color']}} 0% 0% no-repeat padding-box;
        }

        .category_div:hover {
            color: {{$web_config['secondary_color']}};
        }

        .deal_of_the_day {
            background: {{$web_config['secondary_color']}};
        }

        .best-selleing-image {
            background: {{$web_config['primary_color']}}10;
        }

        .top-rated-image {
            background: {{$web_config['primary_color']}}10;
        }

        @media (max-width: 800px) {
            .categories-view-all {
            {{session('direction') === "rtl" ? 'margin-left: 10px;' : 'margin-right: 6px;'}}

            }

            .categories-title {
            {{Session::get('direction') === "rtl" ? 'margin-right: 0px;' : 'margin-left: 6px;'}}

            }

            .seller-list-title {
            {{Session::get('direction') === "rtl" ? 'margin-right: 0px;' : 'margin-left: 10px;'}}

            }

            .seller-list-view-all {
            {{Session::get('direction') === "rtl" ? 'margin-left: 20px;' : 'margin-right: 10px;'}}

            }

            .category-product-view-title {
            {{Session::get('direction') === "rtl" ? 'margin-right: 16px;' : 'margin-left: -8px;'}}

            }

            .category-product-view-all {
            {{Session::get('direction') === "rtl" ? 'margin-left: -7px;' : 'margin-right: 5px;'}}

            }
        }

        @media (min-width: 801px) {
            .categories-view-all {
            {{session('direction') === "rtl" ? 'margin-left: 30px;' : 'margin-right: 27px;'}}

            }

            .categories-title {
            {{Session::get('direction') === "rtl" ? 'margin-right: 25px;' : 'margin-left: 25px;'}}

            }

            .seller-list-title {
            {{Session::get('direction') === "rtl" ? 'margin-right: 6px;' : 'margin-left: 10px;'}}

            }

            .seller-list-view-all {
            {{Session::get('direction') === "rtl" ? 'margin-left: 12px;' : 'margin-right: 10px;'}}

            }

            .seller-card {
            {{Session::get('direction') === "rtl" ? 'padding-left:0px !important;' : 'padding-right:0px !important;'}}

            }

            .category-product-view-title {
            {{Session::get('direction') === "rtl" ? 'margin-right: 10px;' : 'margin-left: -12px;'}}

            }

            .category-product-view-all {
            {{Session::get('direction') === "rtl" ? 'margin-left: -20px;' : 'margin-right: 0px;'}}

            }
        }

        .countdown-card {
            background: {{$web_config['primary_color']}}10;

        }

        .flash-deal-text {
            color: {{$web_config['primary_color']}};
        }

        .countdown-background {
            background: {{$web_config['primary_color']}};
        }

        }
        .czi-arrow-left {
            color: {{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}}10;
        }

        .czi-arrow-right {
            color: {{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}}10;
        }

        .flash-deals-background-image {
            background: {{$web_config['primary_color']}}10;
        }

        .view-all-text {
            color: {{$web_config['secondary_color']}}  !important;
        }

        .feature-product .czi-arrow-left {
            color: {{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}}10
        }

        .feature-product .czi-arrow-right {
            color: {{$web_config['primary_color']}};
            background: {{$web_config['primary_color']}}10;
            font-size: 12px;
        }

        /*  */
    </style>

    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/owl.theme.default.min.css"/>
@endpush

@section('content')
    <div class="container home_slider_container_red">
        @php($decimal_point_settings = !empty(\App\CPU\Helpers::get_business_settings('decimal_point_settings')) ? \App\CPU\Helpers::get_business_settings('decimal_point_settings') : 0)
        <section>
           @include('web-views.partials._home-top-slider')
        </section>

        {{--flash deal--}}
        @php($flash_deals=\App\Model\FlashDeal::with(['products'=>function($query){
                    $query->with('product')->whereHas('product',function($q){
                        $q->active();
                    });
                }])->where(['status'=>1])->where(['deal_type'=>'flash_deal'])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->first())

        @if (isset($flash_deals))
            <section class="overflow-hidden">
                <div class="container">
                    <div
                        class="flash-deal-view-all-web row d-none d-lg-flex justify-content-{{Session::get('direction') === "rtl" ? 'start' : 'end'}}"
                        style="{{Session::get('direction') === "rtl" ? 'margin-left: 2px;' : 'margin-right:2px;'}}">
                        @if (count($flash_deals->products)>0)
                            <a class="text-capitalize view-all-text"
                               href="{{route('flash-deals',[isset($flash_deals)?$flash_deals['id']:0])}}">
                                {{ \App\CPU\translate('view_all')}}
                                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i>
                            </a>
                        @endif
                    </div>
                    <div class="row d-flex {{Session::get('direction') === "rtl" ? 'flex-row-reverse' : 'flex-row'}}">


                        <div class="col-xl-3 col-lg-4 mt-2 countdown-card">
                            <div class="m-2">
                                <div class="flash-deal-text">
                                    <span>{{ \App\CPU\translate('flash deal')}}</span>
                                </div>
                                <div class="text-center text-white">
                                    <div class="countdown-background">
                                <span class="cz-countdown d-flex justify-content-center align-items-center"
                                      data-countdown="{{isset($flash_deals)?date('m/d/Y',strtotime($flash_deals['end_date'])):''}} 11:59:00 PM">
                                    <span class="cz-countdown-days">
                                        <span class="cz-countdown-value"></span>
                                        <span>{{ \App\CPU\translate('day')}}</span>
                                    </span>
                                    <span class="cz-countdown-value p-1">:</span>
                                    <span class="cz-countdown-hours">
                                        <span class="cz-countdown-value"></span>
                                        <span>{{ \App\CPU\translate('hrs')}}</span>
                                    </span>
                                    <span class="cz-countdown-value p-1">:</span>
                                    <span class="cz-countdown-minutes">
                                        <span class="cz-countdown-value"></span>
                                        <span>{{ \App\CPU\translate('min')}}</span>
                                    </span>
                                    <span class="cz-countdown-value p-1">:</span>
                                    <span class="cz-countdown-seconds">
                                        <span class="cz-countdown-value"></span>
                                        <span>{{ \App\CPU\translate('sec')}}</span>
                                    </span>
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flash-deal-view-all-mobile col-lg-12 d-block d-xl-none"
                             style="{{Session::get('direction') === "rtl" ? 'margin-left: 2px;' : 'margin-right:2px;'}}">
                        </div>
                        <div class="col-xl-9 col-lg-8 {{Session::get('direction') === "rtl" ? 'pr-md-4' : 'pl-md-4'}}">
                            <div class="d-lg-none {{Session::get('direction') === "rtl" ? 'text-left' : 'text-right'}}">
                                <a class="mt-2 text-capitalize view-all-text"
                                   href="{{route('flash-deals',[isset($flash_deals)?$flash_deals['id']:0])}}">
                                    {{ \App\CPU\translate('view_all')}}
                                    <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i>
                                </a>
                            </div>
                            <div class="carousel-wrap">
                                <div class="owl-carousel owl-theme mt-2" id="flash-deal-slider">
                                    @foreach($flash_deals->products as $key=>$deal)
                                        @if( $deal->product)
                                            @include('web-views.partials._product-card-1',['product'=>$deal->product,'decimal_point_settings'=>$decimal_point_settings])
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

  

        <!-- Products grid (featured products)-->
        @if ($featured_products->count() > 0 )
            <div class="container mb-4">
                <div class="row __inline-62">
                    <div class="col-md-12">
                        <div class="feature-product-title">
                            {{ \App\CPU\translate('featured_products')}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="feature-product">
                            <div class="carousel-wrap p-1">
                                <div class="owl-carousel owl-theme " id="featured_products_list">
                                    @foreach($featured_products as $product)
                                        <div>
                                            @include('web-views.partials._feature-product',['product'=>$product, 'decimal_point_settings'=>$decimal_point_settings])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--featured deal--}}
        @php($featured_deals=\App\Model\FlashDeal::with(['products'=>function($query_one){
            $query_one->with('product.reviews')->whereHas('product',function($query_two){
                $query_two->active();
            });
        }])
        ->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))
        ->where(['status'=>1])->where(['deal_type'=>'feature_deal'])
        ->first())

 
        {{--Letest Product--}}
        <div class="container">
                    <div class="row">
                        @foreach($latest_products as $product)
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-2 mt-2">
                                    @include('web-views.partials._single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                            </div>
                        @endforeach
                    </div>
        </div>


        @php($main_section_banner = \App\Model\Banner::where('banner_type','Main Section Banner')->where('published',1)->orderBy('id','desc')->latest()->first())
        @if (isset($main_section_banner))
            <div class="container rtl mb-3">
                <div class="row">
                    <div class="col-12 pl-0 pr-0">
                        <a href="{{$main_section_banner->url}}"
                           class="cursor-pointer">
                            <img class="d-block footer_banner_img __inline-63"
                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 src="{{asset('storage/app/public/banner')}}/{{$main_section_banner['photo']}}">
                        </a>
                    </div>
                </div>
            </div>
        @endif


        {{-- Banner  --}}
        <!-- <div class="container rtl py-4 ">
            <div class="row g-3">
                @foreach(\App\Model\Banner::where('banner_type','Footer Banner')->where('published',1)->orderBy('id','desc')->take(2)->get() as $banner)
                    <div class="col-md-6">
                        <a href="{{$banner->url}}" class="d-block">
                            <img class="footer_banner_img"
                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div> -->
        {{-- Categorized product --}}
        @foreach($home_categories as $category)
            <section class="container rtl pb-4">
                <!-- Heading-->
                <div class="__p-20px rounded bg-white">
                    <div class="flex-wrap __gap-6px flex-between pl-xl-4">
                        <div class="category-product-view-title">
                        <span
                            class="for-feature-title {{Session::get('direction') === "rtl" ? 'float-right' : 'float-left'}} font-bold __text-20px text-uppercase"
                            style="{{Session::get('direction') === "rtl" ? 'text-align:right;' : 'text-align:left;'}}">
                                {{Str::limit($category['name'],18)}}
                        </span>
                        </div>
                        <div class="category-product-view-all">
                            <a class="text-capitalize view-all-text "
                               href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">{{ \App\CPU\translate('view_all')}}
                                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i>
                            </a>

                        </div>
                    </div>

                    <div class="row mt-2 justify-content-between g-3">
                        <div class="col-md-3 col-12">
                            <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}"
                               class="cursor-pointer d-block h-100 __cate-product-side-img">
                                <img class="h-100"
                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                     src="{{asset('storage/app/public/category')}}/{{$category['icon']}}">
                            </a>
                        </div>
                        <div class="col-md-9 col-12 ">
                            <div class="row g-2">
                                @foreach($category['products'] as $key=>$product)
                                    @if ($key<4)
                                        <div class="col-md-3 col-sm-4 col-6">
                                            @include('web-views.partials._category-single-product',['product'=>$product,'decimal_point_settings'=>$decimal_point_settings])
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>


                    </div>
                </div>
            </section>
        @endforeach

        {{--delivery type --}}
    </div>
@endsection

@push('script')
    {{-- Owl Carousel --}}
    <script src="{{asset('public/assets/front-end')}}/js/owl.carousel.min.js"></script>

    <script>
        $('#flash-deal-slider').owlCarousel({
            loop: false,
            autoplay: false,
            margin: 20,
            nav: true,
            navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
            dots: false,
            autoplayHoverPause: true,
            '{{session('direction')}}': false,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 1
                },
                360: {
                    items: 1
                },
                375: {
                    items: 1
                },
                540: {
                    items: 2
                },
                //Small
                576: {
                    items: 2
                },
                //Medium
                768: {
                    items: 2
                },
                //Large
                992: {
                    items: 2
                },
                //Extra large
                1200: {
                    items: 2
                },
                //Extra extra large
                1400: {
                    items: 3
                }
            }
        })

        $('#web-feature-deal-slider').owlCarousel({
            loop: false,
            autoplay: true,
            margin: 20,
            nav: false,
            //navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
            dots: false,
            autoplayHoverPause: true,
            '{{session('direction')}}': true,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 1
                },
                360: {
                    items: 1
                },
                375: {
                    items: 1
                },
                540: {
                    items: 2
                },
                //Small
                576: {
                    items: 2
                },
                //Medium
                768: {
                    items: 2
                },
                //Large
                992: {
                    items: 2
                },
                //Extra large
                1200: {
                    items: 2
                },
                //Extra extra large
                1400: {
                    items: 2
                }
            }
        })

        $('#new-arrivals-product').owlCarousel({
            loop: true,
            autoplay: false,
            margin: 20,
            nav: true,
            navText: ["<i class='czi-arrow-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}'></i>", "<i class='czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}'></i>"],
            dots: false,
            autoplayHoverPause: true,
            '{{session('direction')}}': true,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 1
                },
                360: {
                    items: 1
                },
                375: {
                    items: 1
                },
                540: {
                    items: 2
                },
                //Small
                576: {
                    items: 2
                },
                //Medium
                768: {
                    items: 2
                },
                //Large
                992: {
                    items: 2
                },
                //Extra large
                1200: {
                    items: 4
                },
                //Extra extra large
                1400: {
                    items: 4
                }
            }
        })
    </script>
    <script>
        $('#featured_products_list').owlCarousel({
            loop: true,
            autoplay: false,
            margin: 20,
            nav: true,
            navText: ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
            dots: false,
            autoplayHoverPause: true,
            '{{session('direction')}}': false,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 1
                },
                360: {
                    items: 1
                },
                375: {
                    items: 1
                },
                540: {
                    items: 2
                },
                //Small
                576: {
                    items: 2
                },
                //Medium
                768: {
                    items: 3
                },
                //Large
                992: {
                    items: 4
                },
                //Extra large
                1200: {
                    items: 5
                },
                //Extra extra large
                1400: {
                    items: 5
                }
            }
        });
    </script>
    <script>
        $('#brands-slider').owlCarousel({
            loop: false,
            autoplay: false,
            margin: 10,
            nav: false,
            '{{session('direction')}}': true,
            dots: true,
            autoplayHoverPause: true,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 4
                },
                360: {
                    items: 5
                },
                375: {
                    items: 5
                },
                540: {
                    items: 5
                },
                //Small
                576: {
                    items: 6
                },
                //Medium
                768: {
                    items: 7
                },
                //Large
                992: {
                    items: 9
                },
                //Extra large
                1200: {
                    items: 11
                },
                //Extra extra large
                1400: {
                    items: 12
                }
            }
        })
    </script>

    <script>
        $('#category-slider, #top-seller-slider').owlCarousel({
            loop: false,
            autoplay: false,
            margin: 20,
            nav: false,
            // navText: ["<i class='czi-arrow-left'></i>","<i class='czi-arrow-right'></i>"],
            dots: true,
            autoplayHoverPause: true,
            '{{session('direction')}}': true,
            // center: true,
            responsive: {
                //X-Small
                0: {
                    items: 2
                },
                360: {
                    items: 3
                },
                375: {
                    items: 3
                },
                540: {
                    items: 4
                },
                //Small
                576: {
                    items: 5
                },
                //Medium
                768: {
                    items: 6
                },
                //Large
                992: {
                    items: 8
                },
                //Extra large
                1200: {
                    items: 10
                },
                //Extra extra large
                1400: {
                    items: 11
                }
            }
        })
    </script>
@endpush

