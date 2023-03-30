@extends('layouts.front-end.app')

@section('title',\App\CPU\translate($data['data_from']).' '.\App\CPU\translate('products'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']}}"/>
    <meta property="og:title" content="Products of {{$web_config['name']}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']}}"/>
    <meta property="twitter:title" content="Products of {{$web_config['name']}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <style>
        .for-count-value {

        {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 0.6875 rem;;
        }

        .for-count-value {

        {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 0.6875 rem;
        }

        .for-brand-hover:hover {
            color: {{$web_config['primary_color']}};
        }

        .for-hover-lable:hover {
            color: {{$web_config['primary_color']}}       !important;
        }

        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}      !important;
        }

        .for-shoting {
            padding- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 9px;
        }

        .sidepanel {
        {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0;
        }
        .sidepanel .closebtn {
        {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 25 px;
        }
        @media (max-width: 360px) {
            .for-shoting-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 0% !important;
            }

            .for-mobile {

                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 10% !important;
            }

        }

        @media (max-width: 500px) {
            .for-mobile {

                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 27%;
            }
        }

    </style>
@endpush

@section('content')

@php($decimal_point_settings = \App\CPU\Helpers::get_business_settings('decimal_point_settings'))
    <!-- Page Title-->
    <div class="d-flex w-100 justify-content-center align-items-center mb-3 __min-h-70px __inline-35" style="background:{{$web_config['primary_color']}}10;">

        <div class="text-capitalize container text-center">
            <span class="__text-18px font-semibold">{{\App\CPU\translate(str_replace('_',' ',$data['data_from']))}} {{\App\CPU\translate('products')}} {{ isset($brand_name) ? '('.$brand_name.')' : ''}}</span>
        </div>

    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl __inline-35"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
           

            <!-- Content  -->
            <section class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between __inline-43 __gap-6px p-2">
                    <div class="filter-show-btn btn btn--primary py-1 px-2">
                        <i class="tio-filter"></i>
                    </div>
                    <h1 class="max-sm-order-1">
                        <label id="price-filter-count"> {{$products->total()}} {{\App\CPU\translate('items found')}} </label>
                    </h1>
                    <div class="d-flex align-items-center ml-auto">

                        <div class="w-100">
                            <form id="search-form" action="{{ route('products') }}" method="GET">
                                <input hidden name="data_from" value="{{$data['data_from']}}">
                                <div class=" {{Session::get('direction') === "rtl" ? 'float-left' : 'float-right'}}">
                                    <label class="for-shoting" for="sorting">
                                        <span>{{\App\CPU\translate('sort_by')}}</span>
                                    </label>
                                    <select class="__inline-44"
                                                onchange="filter(this.value)">
                                        <option value="latest">{{\App\CPU\translate('Latest')}}</option>
                                        <option
                                            value="low-high">{{\App\CPU\translate('Low_to_High')}} {{\App\CPU\translate('Price')}} </option>
                                        <option
                                            value="high-low">{{\App\CPU\translate('High_to_Low')}} {{\App\CPU\translate('Price')}}</option>
                                        <option
                                            value="a-z">{{\App\CPU\translate('A_to_Z')}} {{\App\CPU\translate('Order')}}</option>
                                        <option
                                            value="z-a">{{\App\CPU\translate('Z_to_A')}} {{\App\CPU\translate('Order')}}</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if (count($products) > 0)
                    <div class="row mt-3" id="ajax-products">
                        @include('web-views.products._ajax-products',['products'=>$products,'decimal_point_settings'=>$decimal_point_settings])
                    </div>
                @else
                    <div class="text-center pt-5">
                        <h2>{{\App\CPU\translate('No Product Found')}}</h2>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "70%";
            document.getElementById("mySidepanel").style.height = "100vh";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }

        function filter(value) {
            $.get({
                url: '{{url('/')}}/products',
                data: {
                    id: '{{$data['id']}}',
                    name: '{{$data['name']}}',
                    data_from: '{{$data['data_from']}}',
                    min_price: '{{$data['min_price']}}',
                    max_price: '{{$data['max_price']}}',
                    sort_by: value
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        function searchByPrice() {
            let min = $('#min_price').val();
            let max = $('#max_price').val();
            $.get({
                url: '{{url('/')}}/products',
                data: {
                    id: '{{$data['id']}}',
                    name: '{{$data['name']}}',
                    data_from: '{{$data['data_from']}}',
                    sort_by: '{{$data['sort_by']}}',
                    min_price: min,
                    max_price: max,
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                    $('#paginator-ajax').html(response.paginator);
                    console.log(response.total_product);
                    $('#price-filter-count').text(response.total_product + ' {{\App\CPU\translate('items found')}}')
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        $('#searchByFilterValue, #searchByFilterValue-m').change(function () {
            var url = $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });

        $("#search-brand").on("keyup", function () {
            var value = this.value.toLowerCase().trim();
            $("#lista1 div>li").show().filter(function () {
                return $(this).text().toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });
    </script>


@endpush
