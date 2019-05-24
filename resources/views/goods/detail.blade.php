@extends('layouts.app')

@section('title', 'Laravel学院')

@section('sidebar')
    @parent
@endsection

@section('content')
	
		<!-- shop single -->
	<div class="pages section">
		<div class="container">
			
			<div class="shop-single">
				<img src="http://www.lab993.com/uploads/goodsimgs/{{$goods->goods_img}}  " alt="" style="width:30%;height:30%;">
				<h5></h5>
				<div class="price">￥{{$goods->self_price}} <span>￥{{$goods->market_price}}</span></div>
				库存：&nbsp;&nbsp;&nbsp;<b>{{$goods->goods_score}}&nbsp;&nbsp;&nbsp;</b>
				数量：&nbsp;&nbsp;&nbsp;<b>{{$goods->goods_num}}&nbsp;&nbsp;&nbsp;</b><br>
				<button type="button" class="btn button-default">{{$goods->goods_name}}</button>
			</div>
			<div class="review">
					<h5>{{$goods->goods_desc}}</h5>
					<div class="review-details">
						<div class="row">
							<div class="col s3">
								<img src="http://www.lab993.com/uploads/goodsimgs/{{$goods->goods_img}}" alt="" class="responsive-img">
							</div>
							<div class="col s9">
								<div class="review-title">
									<span><strong>商品简介：</strong> {{$goods->goods_desc}} <a href=""></a></span>
								</div>
								<p></p>
							</div>
						</div>
					</div>
				</div>	
				<div class="review-form">
					<div class="review-head">
						<h5>Post Review in Below</h5>
						<p>Lorem ipsum dolor sit amet consectetur*</p>
					</div>
					<input type="button" class="btn button-default" id="goods_id" onclick="goods()" value="加入购物车"><a href='/cart/cartadd/{{$goods->goods_id}}'>
				</div>
		</div>
	</div>

@endsection