@extends('layouts.app')

@section('title', 'Laravel学院')

@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- slider -->
    <div class="slider">

        <ul class="slides">
            <li>
                <img src="/img/slide1.jpg" alt="">
                <div class="caption slider-content  center-align">
                    <h2>欢迎来到德莱联盟</h2>
                    <h4>好好看，好好学！</h4>
                    <a href="" class="btn button-default">SHOP NOW</a>
                </div>
            </li>
            <li>
                <img src="/img/slide2.jpg" alt="">
                <div class="caption slider-content center-align">
                    <h2>艾欧尼亚，号角不灭</h2>
                    <h4>为出生之土而战！</h4>
                    <a href="" class="btn button-default">SHOP NOW</a>
                </div>
            </li>
            <li>
                <img src="/img/slide3.jpg" alt="">
                <div class="caption slider-content center-align">
                    <h2>长路漫漫，唯剑作伴</h2>
                    <h4>吾虽浪迹天涯，却又未曾迷失本心</h4>
                    <a href="" class="btn button-default">SHOP NOW</a>
                </div>
            </li>
        </ul>

    </div>
    <!-- end slider -->

    <!-- features -->
    <div class="features section">
        <div class="container">
            <div class="row">
                <div class="col s6">
                    <div class="content">
                        <div class="icon">
                            <i class="fa fa-car"></i>
                        </div>
                        <h6>Free Shipping</h6>
                        <p>Lorem ipsum dolor sit amet consectetur</p>
                    </div>
                </div>
                <div class="col s6">
                    <div class="content">
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <h6>Money Back</h6>
                        <p>Lorem ipsum dolor sit amet consectetur</p>
                    </div>
                </div>
            </div>
            <div class="row margin-bottom-0">
                <div class="col s6">
                    <div class="content">
                        <div class="icon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <h6>Secure Payment</h6>
                        <p>Lorem ipsum dolor sit amet consectetur</p>
                    </div>
                </div>
                <div class="col s6">
                    <div class="content">
                        <div class="icon">
                            <i class="fa fa-support"></i>
                        </div>
                        <h6>24/7 Support</h6>
                        <p>Lorem ipsum dolor sit amet consectetur</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end features -->

    <!-- quote -->
    <div class="section quote">
        <div class="container">
            <h4>FASHION UP TO 50% OFF</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid ducimus illo hic iure eveniet</p>
        </div>
    </div>
    <!-- end quote -->

    <!-- product -->
    <div class="section product">
        <div class="container">
            <div class="section-head">
                <h4>最新商品</h4>
                <div class="divider-top"></div>
                <div class="divider-bottom"></div>
            </div>

            <div class="row">
                @foreach($newInfo as $k=>$v)
                <div class="col s6">
                    <div class="content">
                        <img src="http://www.lab993.com/uploads/goodsimgs/{{$v->goods_img}}" alt="">
                        <h6><a href="">{{$v->goods_name}}</a></h6>
                        <div class="price">
                            ${{$v->self_price}} <span>${{$v->market_price}}</span>
                        </div>
                        <button class="btn button-default click" gid="{{$v->goods_id}}">加入购物车</button>
                    </div>
                    <div class="col s6"><br></div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    <!-- end product -->

    <!-- promo -->
    <div class="promo section">
        <div class="container">
            <div class="content">
                <h4>PRODUCT BUNDLE</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                <button class="btn button-default">SHOP NOW</button>
            </div>
        </div>
    </div>
    <!-- end promo -->

    <!-- product -->
    <div class="section product">
        <div class="container">
            <div class="section-head">
                <h4>网站推荐</h4>
                <div class="divider-top"></div>
                <div class="divider-bottom"></div>
            </div>

            <div class="row">
                @foreach($goodsInfo as $k=>$v)
                <div class="col s6">
                    <div class="content">
                        <img src="http://www.lab993.com/uploads/goodsimgs/{{$v->goods_img}}" alt="">
                        <h6><a href="">{{$v->goods_name}}</a></h6>
                        <div class="price">
                            ${{$v->self_price}} <span>${{$v->market_price}}</span>
                        </div>
                        <button class="btn button-default click" gid="{{$v->goods_id}}">加入购物车</button>
                    </div>
                    <div class="col s6"><br></div>
                </div>
                @endforeach
            </div>

            <div class="pagination-product">
                <ul>
                    <li>{{$goodsInfo->links()}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end product -->

    <!-- loader -->
    <div id="fakeLoader"></div>
    <!-- end loader -->
    <script>
        $(".click").click(function(){
            var _this = $(this);
            var gid = _this.attr('gid');
            $.ajax({
                url:'/cart/cartadd/',
                data:{gid:gid},
                type:'post',
                dateType: 'json',
                async:true,
                success:function(res){
                    if(res.errcode == 0){
                        alert(res.errmsg);
                    }else{
                        alert('error:'+res.errcode);
                    }
                },
                error:function(){
                    alert('出错了');
                }
            })
        })
    </script>
@endsection