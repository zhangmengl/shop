@extends('index.layouts.layout')
@section('content')


	<!-- wishlist -->
	<div class="wishlist section">
	
		<div class="container">
			<div class="pages-head">
				<h3>WISHLIST</h3>
			</div>
			<!-- adasda -->
			@foreach($res as $v)
				<div class="content">
					<div class="cart-1">
						<div class="row">
							<div class="col s5">
								<h5>Image</h5>
							</div>
							<div class="col s7" >
								<img src="{{$v['goods_img']}}" alt="">
							</div>
						</div>
						<div class="row">
							<div class="col s5">
								<h5>Name</h5>
							</div>
							<div class="col s7">
								<h5><a href="">{{$v['goods_name']}}</a></h5>
							</div>
						</div>
						<div class="row">
							<div class="col s5">
								<h5>Stock Status</h5>
							</div>
							<div class="col s7">
								<h5>{{$v['goods_score']}}</h5>
							</div>
						</div>
						<div class="row">
							<div class="col s5">
								<h5>Price</h5>
							</div>
							<div class="col s7">
								<h5>${{$v['goods_price']}}</h5>
							</div>
						</div>
						<div class="row">
							<div class="col s5">
								<h5>Action</h5>
							</div>
							<div class="col s7">
								<h5><i class="fa fa-trash"></i></h5>
							</div>
						</div>
						<div class="row">
							<div class="col 12">
								<button class="btn button-default">SEND TO CART</button>
							</div>
						</div>
					</div>
					<div class="divider"></div>
				</div>
				@endforeach
		</div>
		
	</div>
	<!-- end wishlist -->

<script>
    $(document).on("click",".fa-trash",function(){
		var goods_id='{{$v["goods_id"]}}';
		$.ajax({
			type:"get",
			url:"{{url('wish/wishDel')}}",
			data:{goods_id:goods_id},
			dataType:'JSON',
			success:function(res){
				if(res.code==1){
					alert("取消收藏成功！");
					location.href="{{url('/')}}"
				}
		
			}
		});
	})
</script>

	@include("index.layouts.foot")
@endsection