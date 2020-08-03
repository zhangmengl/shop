@extends('index.layouts.layout')
@section('content')
<link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.8.8/skins/default/aliplayer-min.css" />
<script type="text/javascript" charset="utf-8" src="https://g.alicdn.com/de/prismplayer/2.8.8/aliplayer-min.js"></script>

	<!-- side nav right-->
	<div class="side-nav-panel-right">
		<ul id="slide-out-right" class="side-nav side-nav-panel collapsible">
			<li class="profil">
				<img src="img/profile.jpg" alt="">
				<h2>John Doe</h2>
			</li>
			<li><a href="setting.html"><i class="fa fa-cog"></i>Settings</a></li>
			<li><a href="about-us.html"><i class="fa fa-user"></i>About Us</a></li>
			<li><a href="contact.html"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
			<li><a href="login.html"><i class="fa fa-sign-in"></i>Login</a></li>
			<li><a href="register.html"><i class="fa fa-user-plus"></i>Register</a></li>
		</ul>
	</div>
	<!-- end side nav right-->

	<!-- navbar bottom -->
	<div class="navbar-bottom">
		<div class="row">
			<div class="col s2">
				<a href="index.html"><i class="fa fa-home"></i></a>
			</div>
			<div class="col s2">
				<a href="wishlist.html"><i class="fa fa-heart"></i></a>
			</div>
			<div class="col s4">
				<div class="bar-center">
					<a href="#animatedModal" id="cart-menu"><i class="fa fa-shopping-basket"></i></a>
					<span>2</span>
				</div>
			</div>
			<div class="col s2">
				<a href="contact.html"><i class="fa fa-envelope-o"></i></a>
			</div>
			<div class="col s2">
				<a href="#animatedModal2" id="nav-menu"><i class="fa fa-bars"></i></a>
			</div>
		</div>
	</div>
	<!-- end navbar bottom -->
	
	<!-- shop single -->
	<div class="pages section">
		<div class="container">

			<div class="shop-single">
				<img src="{{$data['goods_img']}}" alt="">
				<h5>{{$data['goods_name']}}</h5>
				<div class="price">${{$data['goods_price']}} 
				<p>{{$data['goods_desc']}}</p>
				<button type="button" class="btn button-default" id="btn">加入购物车</button>
				<button type="button" class="btn button-default" id="wish">收藏</button>
			</div>

			<!-- 视频展示 开始 -->
			<div class="prism-player" id="player-con"></div>
            <!-- 视频展示 结束 -->
		
			<div class="review">
					<h5>1 reviews</h5>
					<div class="review-details">
						<div class="row">
							<div class="col s3">
								<img src="img/user-comment.jpg" alt="" class="responsive-img">
							</div>
							<div class="col s9">
								<div class="review-title">
									<span><strong>John Doe</strong> | Juni 5, 2016 at 9:24 am | <a href="">Reply</a></span>
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis accusantium corrupti asperiores et praesentium dolore.</p>
							</div>
						</div>
					</div>
				</div>	
				<div class="review-form">
					<div class="review-head">
						<h5>Post Review in Below</h5>
						<p>Lorem ipsum dolor sit amet consectetur*</p>
					</div>
					<div class="row">
						<form class="col s12 form-details">
							<div class="input-field">
								<input type="text" required class="validate" placeholder="NAME">
							</div>
							<div class="input-field">
								<input type="email" class="validate" placeholder="EMAIL" required>
							</div>
							<div class="input-field">
								<input type="text" class="validate" placeholder="SUBJECT" required>
							</div>
							<div class="input-field">
								<textarea name="textarea-message" id="textarea1" cols="30" rows="10" class="materialize-textarea" class="validate" placeholder="YOUR REVIEW"></textarea>
							</div>
							<div class="form-button">
								<div class="btn button-default">POST REVIEW</div>
							</div>
						</form>
					</div>
				</div>
		</div>
	</div>
	<!-- end shop single -->

	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->
	
	<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="about-us-foot">
				<h6>Mstore</h6>
				<p>is a lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit.</p>
			</div>
			<div class="social-media">
				<a href=""><i class="fa fa-facebook"></i></a>
				<a href=""><i class="fa fa-twitter"></i></a>
				<a href=""><i class="fa fa-google"></i></a>
				<a href=""><i class="fa fa-linkedin"></i></a>
				<a href=""><i class="fa fa-instagram"></i></a>
			</div>
			<div class="copyright">
				<span>© 2017 All Right Reserved</span>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	

</body>
</html>
<script>
    //点击收藏按钮
	$(document).on('click','#wish',function(){
		var goods_id='{{$data["goods_id"]}}';
		$.ajax({
			type:"get",
			url:"{{url('wish/wishDo')}}",
			data:{goods_id:goods_id},
			dataType:'JSON',
			success:function(res){
				if(res.code==00001){
					alert("该商品已收藏，请勿重新收藏！");
				}else{
					alert("您还未登录，请先登录");
					location.href="{{url('login/login')}}"
				}
			}
		});
	})
	//购物车
	$(document).on('click','#btn',function(){
		//购买数量
		var buy_number=1;
		//获取商品id
		var goods_id="{{$data['goods_id']}}";
		$.ajax({
			url:'/addCart',
			type:'post',
			data:{buy_number:buy_number,goods_id:goods_id},
			dataType:'json',
			success:function(res){
				if(res.code==true){
					window.location.href='/cart';
				}else{
					alert(res.font);
				}
			}
		})
	})



</script>


<!-- scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/fakeLoader.min.js"></script>
<script src="js/animatedModal.min.js"></script>
<script src="js/main.js"></script>
<script type="text/javascript" charset="utf-8" src="https://g.alicdn.com/de/prismplayer/2.8.8/aliplayer-min.js"></script>

<script>
    var player = new Aliplayer({
            "id": "player-con",
            "source": "/storage/{!! $goods['m3u8'] !!}",
            "width": "50%",
            "height": "400px",
            "autoplay": true,
            "isLive": false,
            "rePlay": false,
            "playsinline": true,
            "preload": true,
            "controlBarVisibility": "hover",
            "useH5Prism": true
        }, function (player) {
            console.log("The player is created");
        }
    );
</script>

@endsection