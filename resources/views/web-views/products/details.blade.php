@extends('layouts.front-end.app')

@section('title',$product['name'])

@push('css_or_js')
    <meta name="description" content="{{$product->slug}}">
    <meta name="keywords" content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    @if($product->added_by=='seller')
        <meta name="author" content="{{ $product->seller->shop?$product->seller->shop->name:$product->seller->f_name}}">
    @elseif($product->added_by=='admin')
        <meta name="author" content="{{$web_config['name']->value}}">
    @endif
    <!-- Viewport-->

    @if($product['meta_image']!=null)
        <meta property="og:image" content="{{asset("storage/app/public/product/meta")}}/{{$product->meta_image}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/product/meta")}}/{{$product->meta_image}}"/>
    @else
        <meta property="og:image" content="{{asset("storage/app/public/product/thumbnail")}}/{{$product->thumbnail}}"/>
        <meta property="twitter:card"
              content="{{asset("storage/app/public/product/thumbnail/")}}/{{$product->thumbnail}}"/>
    @endif

    @if($product['meta_title']!=null)
        <meta property="og:title" content="{{$product->meta_title}}"/>
        <meta property="twitter:title" content="{{$product->meta_title}}"/>
    @else
        <meta property="og:title" content="{{$product->name}}"/>
        <meta property="twitter:title" content="{{$product->name}}"/>
    @endif
    <meta property="og:url" content="{{route('product',[$product->slug])}}">

    @if($product['meta_description']!=null)
        <meta property="twitter:description" content="{!! $product['meta_description'] !!}">
        <meta property="og:description" content="{!! $product['meta_description'] !!}">
    @else
        <meta property="og:description"
              content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
        <meta property="twitter:description"
              content="@foreach(explode(' ',$product['name']) as $keyword) {{$keyword.' , '}} @endforeach">
    @endif
    <meta property="twitter:url" content="{{route('product',[$product->slug])}}">

    <link rel="stylesheet" href="{{asset('public/assets/front-end/css/product-details.css')}}"/>
    <style>
        .btn-number:hover {
            color: {{$web_config['secondary_color']}};

        }

        .for-total-price {
            margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: -30%;
        }

        .feature_header span {
            padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 15px;
        }

        .flash-deals-background-image{
            background: {{$web_config['primary_color']}}10;
        }

        @media (max-width: 768px) {
            .for-total-price {
                padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 30%;
            }

            .product-quantity {
                padding- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 4%;
            }

            .for-margin-bnt-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 7px;
            }

        }

        @media (max-width: 375px) {
            .for-margin-bnt-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 3px;
            }

            .for-discount {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10% !important;
            }

            .for-dicount-div {
                margin-top: -5%;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -7%;
            }

            .product-quantity {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 4%;
            }

        }

        @media (max-width: 500px) {
            .for-dicount-div {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -5%;
            }

            .for-total-price {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: -20%;
            }

            .view-btn-div {
                float: {{Session::get('direction') === "rtl" ? 'left' : 'right'}};
            }

            .for-discount {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7%;
            }
            .for-mobile-capacity {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 7%;
            }
        }
    </style>
    <style>
        thead {
            background: {{$web_config['primary_color']}} !important;
        }
    </style>
@endpush

@section('content')
    <?php
    $overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews);
    $rating = \App\CPU\ProductManager::get_rating($product->reviews);
    $decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings');
    ?>
    <div class="__inline-23">
        <!-- Page Content-->
        <div class="container mt-4 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <!-- General info tab-->
            <div class="row {{Session::get('direction') === "rtl" ? '__dir-rtl' : ''}}">
                <!-- Product gallery-->
                <div class="col-lg-12 col-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="cz-product-gallery">
                                <div class="cz-preview">
                                    @if($product->images!=null && json_decode($product->images)>0)
                                        @if(json_decode($product->colors) && $product->color_image)
                                            @foreach (json_decode($product->color_image) as $key => $photo)
                                                @if($photo->color != null)
                                                    <div class="cz-preview-item d-flex align-items-center justify-content-center {{$key==0?'active':''}}"
                                                         id="image{{$photo->color}}">
                                                        <img class="cz-image-zoom img-responsive w-100 __max-h-323px"
                                                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                             src="{{asset("storage/app/public/product/$photo->image_name")}}"
                                                             data-zoom="{{asset("storage/app/public/product/$photo->image_name")}}"
                                                             alt="Product image" width="">
                                                        <div class="cz-image-zoom-pane"></div>
                                                    </div>
                                                @else
                                                    <div class="cz-preview-item d-flex align-items-center justify-content-center {{$key==0?'active':''}}"
                                                         id="image{{$key}}">
                                                        <img class="cz-image-zoom img-responsive w-100 __max-h-323px"
                                                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                             src="{{asset("storage/app/public/product/$photo->image_name")}}"
                                                             data-zoom="{{asset("storage/app/public/product/$photo->image_name")}}"
                                                             alt="Product image" width="">
                                                        <div class="cz-image-zoom-pane"></div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach (json_decode($product->images) as $key => $photo)
                                                <div class="cz-preview-item d-flex align-items-center justify-content-center {{$key==0?'active':''}}"
                                                     id="image{{$key}}">
                                                    <img class="cz-image-zoom img-responsive w-100 __max-h-323px"
                                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                         src="{{asset("storage/app/public/product/$photo")}}"
                                                         data-zoom="{{asset("storage/app/public/product/$photo")}}"
                                                         alt="Product image" width="">
                                                    <div class="cz-image-zoom-pane"></div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                                <div class="cz">
                                    <div class="table-responsive __max-h-515px" data-simplebar>
                                        <div class="d-flex">
                                            @if($product->images!=null && json_decode($product->images)>0)
                                                @if(json_decode($product->colors) && $product->color_image)
                                                    @foreach (json_decode($product->color_image) as $key => $photo)
                                                        @if($photo->color != null)
                                                            <div class="cz-thumblist">
                                                                <a class="cz-thumblist-item  {{$key==0?'active':''}} d-flex align-items-center justify-content-center"
                                                                   id="preview-img{{$photo->color}}" href="#image{{$photo->color}}">
                                                                    <img
                                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                        src="{{asset("storage/app/public/product/$photo->image_name")}}"
                                                                        alt="Product thumb">
                                                                </a>
                                                            </div>
                                                        @else
                                                            <div class="cz-thumblist">
                                                                <a class="cz-thumblist-item  {{$key==0?'active':''}} d-flex align-items-center justify-content-center"
                                                                   id="preview-img{{$key}}" href="#image{{$key}}">
                                                                    <img
                                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                        src="{{asset("storage/app/public/product/$photo->image_name")}}"
                                                                        alt="Product thumb">
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach (json_decode($product->images) as $key => $photo)
                                                        <div class="cz-thumblist">
                                                            <a class="cz-thumblist-item  {{$key==0?'active':''}} d-flex align-items-center justify-content-center"
                                                               id="preview-img{{$key}}" href="#image{{$key}}">
                                                                <img
                                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                    src="{{asset("storage/app/public/product/$photo")}}"
                                                                    alt="Product thumb">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product details-->
                        <div class="col-lg-6 col-md-6 col-12 mt-md-0 mt-sm-3" style="direction: {{ Session::get('direction') }}">
                            <div class="details __h-100">
                                <span class="mb-2 __inline-24">{{$product->name}}</span>
                               
                                <div class="mb-3">
                                    @if($product->discount > 0)
                                        <strike style="color: #E96A6A;" class="{{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-3'}}">
                                            {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                        </strike>
                                    @endif
                                    <span class="h3 font-weight-normal text-accent ">
                                        {{\App\CPU\Helpers::get_price_range($product) }}
                                    </span>
                                </div>

                                <form id="add-to-cart-form" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <div class="position-relative {{Session::get('direction') === "rtl" ? 'ml-n4' : 'mr-n4'}} mb-2">
                                        @if (count(json_decode($product->colors)) > 0)
                                            <div class="flex-start">
                                                <div class="product-description-label mt-2 text-body">{{\App\CPU\translate('color')}}:
                                                </div>
                                                <div>
                                                    <ul class="list-inline checkbox-color mb-1 flex-start {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}"
                                                        style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0;">
                                                        @foreach (json_decode($product->colors) as $key => $color)
                                                            <div>
                                                                <li>
                                                                    <input type="radio"
                                                                        id="{{ $product->id }}-color-{{ str_replace('#','',$color) }}"
                                                                        name="color" value="{{ $color }}"
                                                                        @if($key == 0) checked @endif>
                                                                    <label style="background: {{ $color }};"
                                                                        for="{{ $product->id }}-color-{{ str_replace('#','',$color) }}"
                                                                        data-toggle="tooltip" onclick="focus_preview_image_by_color('{{ str_replace('#','',$color) }}')">
                                                                    <span class="outline"></span></label>
                                                                </li>
                                                            </div>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                        @php
                                            $qty = 0;
                                            if(!empty($product->variation)){
                                            foreach (json_decode($product->variation) as $key => $variation) {
                                                    $qty += $variation->qty;
                                                }
                                            }
                                        @endphp
                                    </div>
                                    @foreach (json_decode($product->choice_options) as $key => $choice)
                                        <div class="row flex-start mx-0">
                                            <div
                                                class="product-description-label text-body mt-2 {{Session::get('direction') === "rtl" ? 'pl-2' : 'pr-2'}}">{{ $choice->title }}
                                                :
                                            </div>
                                            <div>
                                                <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2 mx-1 flex-start row"
                                                    style="padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0;">
                                                    @foreach ($choice->options as $key => $option)
                                                        <div>
                                                            <li class="for-mobile-capacity">
                                                                <input type="radio"
                                                                    id="{{ $choice->name }}-{{ $option }}"
                                                                    name="{{ $choice->name }}" value="{{ $option }}"
                                                                    @if($key == 0) checked @endif >
                                                                <label class="__text-12px"
                                                                    for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
                                                            </li>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                @endforeach

                                <!-- Quantity + Add to cart -->
                                    <div class="mt-2">
                                        <div class="product-quantity d-flex flex-wrap align-items-center __gap-15">
                                            <div class="d-flex align-items-center">
                                                <div class="product-description-label text-body mt-2">{{\App\CPU\translate('Quantity')}}:</div>
                                                <div
                                                    class="d-flex justify-content-center align-items-center __w-160px"
                                                    style="color: {{$web_config['primary_color']}}">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-number __p-10" type="button"
                                                                data-type="minus" data-field="quantity"
                                                                disabled="disabled" style="color: {{$web_config['primary_color']}}">
                                                            -
                                                        </button>
                                                    </span>
                                                    <input type="text" name="quantity"
                                                        class="form-control input-number text-center cart-qty-field __inline-29"
                                                        placeholder="1" value="{{ $product->minimum_order_qty ?? 1 }}" product-type="{{ $product->product_type }}" min="{{ $product->minimum_order_qty ?? 1 }}" max="100">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-number __p-10" type="button" product-type="{{ $product->product_type }}" data-type="plus"
                                                                data-field="quantity" style="color: {{$web_config['primary_color']}}">
                                                        +
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="chosen_price_div">
                                                <div class="d-flex justify-content-center align-items-center {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}">
                                                    <div class="product-description-label"><strong>{{\App\CPU\translate('total_price')}}</strong> : </div>
                                                    &nbsp; <strong id="chosen_price"></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters d-none mt-2 flex-start d-flex">
                                        <div class="col-12">
                                            @if(($product['product_type'] == 'physical') && ($product['current_stock']<=0))
                                                <h5 class="mt-3 text-danger">{{\App\CPU\translate('out_of_stock')}}</h5>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="__btn-grp mt-2 mb-3">
                                        @if(($product->added_by == 'seller' && ($seller_temporary_close || (isset($product->seller->shop) && $product->seller->shop->vacation_status && $current_date >= $seller_vacation_start_date && $current_date <= $seller_vacation_end_date))) ||
                                         ($product->added_by == 'admin' && ($inhouse_temporary_close || ($inhouse_vacation_status && $current_date >= $inhouse_vacation_start_date && $current_date <= $inhouse_vacation_end_date))))

                                        @else
                                            <button class="btn btn-secondary element-center __iniline-26" onclick="buy_now()" type="button">
                                                <span class="string-limit">{{\App\CPU\translate('buy_now')}}</span>
                                            </button>
                                            <button
                                                class="btn btn--primary element-center btn-gap-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                                onclick="addToCart()" type="button">
                                                <span class="string-limit">{{\App\CPU\translate('add_to_cart')}}</span>
                                            </button>
                                        @endif

                                        @if(($product->added_by == 'seller' && ($seller_temporary_close || (isset($product->seller->shop) && $product->seller->shop->vacation_status && $current_date >= $seller_vacation_start_date && $current_date <= $seller_vacation_end_date))) ||
                                         ($product->added_by == 'admin' && ($inhouse_temporary_close || ($inhouse_vacation_status && $current_date >= $inhouse_vacation_start_date && $current_date <= $inhouse_vacation_end_date))))
                                            <div class="alert alert-danger" role="alert">
                                                {{\App\CPU\translate('this_shop_is_temporary_closed_or_on_vacation._You_cannot_add_product_to_cart_from_this_shop_for_now')}}
                                            </div>
                                        @endif
                                    </div>
                                </form>

                                <div style="text-align:{{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                    class="sharethis-inline-share-buttons"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            Discription
                        </div>
                    </div>

                </div>
               
            </div>
        </div>

        <!-- Product carousel (You may also like)-->
        <div class="container  mb-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="row flex-between">
                <div class="text-capitalize font-bold __text-30px" style="{{Session::get('direction') === "rtl" ? 'margin-right: 5px;' : 'margin-left: 5px;'}}">
                    <span>{{ \App\CPU\translate('similar_products')}}</span>
                </div>

                <div class="view_all d-flex justify-content-center align-items-center">
                    <div>
                        @php($category=json_decode($product['category_ids']))
                        @if($category)
                            <a class="text-capitalize view-all-text" style="color:{{$web_config['primary_color']}} !important;{{Session::get('direction') === "rtl" ? 'margin-left:10px;' : 'margin-right: 8px;'}}"
                            href="{{route('products',['id'=> $category[0]->id,'data_from'=>'category','page'=>1])}}">{{ \App\CPU\translate('view_all')}}
                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 ' : 'right ml-1 mr-n1'}}"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Grid-->

            <!-- Product-->
            <div class="row mt-4">
                @if (count($relatedProducts)>0)
                    @foreach($relatedProducts as $key => $relatedProduct)
                        <div class="col-xl-2 col-sm-3 col-6 mb-4">
                            @include('web-views.partials._single-product',['product'=>$relatedProduct,'decimal_point_settings'=>$decimal_point_settings])
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 >{{\App\CPU\translate('similar')}} {{\App\CPU\translate('product_not_available')}}</h6>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="modal fade rtl" id="show-modal-view" tabindex="-1" role="dialog" aria-labelledby="show-modal-image"
            aria-hidden="true" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body flex justify-content-center">
                        <button class="btn btn-default __inline-33" style="{{Session::get('direction') === "rtl" ? 'left' : 'right'}}: -7px;"
                                data-dismiss="modal">
                            <i class="fa fa-close"></i>
                        </button>
                        <img class="element-center" id="attachment-view" src="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script type="text/javascript">
        cartQuantityInitialize();
        getVariantPrice();
        $('#add-to-cart-form input').on('change', function () {
            getVariantPrice();
        });

        function showInstaImage(link) {
            $("#attachment-view").attr("src", link);
            $('#show-modal-view').modal('toggle')
        }

        function focus_preview_image_by_color(key){
            $('a[href="#image'+key+'"]')[0].click();
        }
    </script>
    <script>
        $( document ).ready(function() {
            load_review();
        });
        let load_review_count = 1;
        function load_review()
        {

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            $.ajax({
                    type: "post",
                    url: '{{route('review-list-product')}}',
                    data:{
                        product_id:{{$product->id}},
                        offset:load_review_count
                    },
                    success: function (data) {
                        $('#product-review-list').append(data.productReview)
                        if(data.not_empty == 0 && load_review_count>2){
                            toastr.info('{{\App\CPU\translate('no more review remain to load')}}', {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            console.log('iff');
                        }
                    }
                });
                load_review_count++
        }
    </script>

    {{-- Messaging with shop seller --}}
    <script>
        $('#contact-seller').on('click', function (e) {
            // $('#seller_details').css('height', '200px');
            $('#seller_details').animate({'height': '276px'});
            $('#msg-option').css('display', 'block');
        });
        $('#sendBtn').on('click', function (e) {
            e.preventDefault();
            let msgValue = $('#msg-option').find('textarea').val();
            let data = {
                message: msgValue,
                shop_id: $('#msg-option').find('textarea').attr('shop-id'),
                seller_id: $('.msg-option').find('.seller_id').attr('seller-id'),
            }
            if (msgValue != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: '{{route('messages_store')}}',
                    data: data,
                    success: function (respons) {
                        console.log('send successfully');
                    }
                });
                $('#chatInputBox').val('');
                $('#msg-option').css('display', 'none');
                $('#contact-seller').find('.contact').attr('disabled', '');
                $('#seller_details').animate({'height': '125px'});
                $('#go_to_chatbox').css('display', 'block');
            } else {
                console.log('say something');
            }
        });
        $('#cancelBtn').on('click', function (e) {
            e.preventDefault();
            $('#seller_details').animate({'height': '114px'});
            $('#msg-option').css('display', 'none');
        });
    </script>

    <script type="text/javascript"
            src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons"
            async="async"></script>
@endpush
