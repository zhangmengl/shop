@extends('index.layouts.layout')
@section('content')

    <!-- register -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>REGISTER</h3>
			</div>
			<div class="register">
				<div class="row">
					<form class="col s12" method='post' action="/login/regdo">
						<div class="input-field">
							<input type="text" class="validate" name='name' placeholder="请输入名称" required>
						</div>
                        <div class="input-field">
                            <input type="text" name='tel' placeholder="请输入手机号" class="validate" required>
                        </div>
                        <div class="input-field">
                            <input type="email" name='email' placeholder="请输入邮箱" class="validate" required>
                        </div>
						<div class="input-field">
							<input type="password" name='password' placeholder="请输入密码" class="validate" required>
						</div>
                        <div class="input-field">
                            <input type="password" name='passwords' placeholder="请输入确认密码" class="validate" required>
                        </div>
                        <input type="submit" class="btn button-default" value="REGISTER">
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end register -->

@endsection
