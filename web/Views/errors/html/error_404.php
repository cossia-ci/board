<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style>
.page_404{padding: 40px 0; background: #fff; text-align: center;}
.four_zero_four_bg{background: url(/images/404.gif) no-repeat; height: 400px; background-position: center;}
.four_zero_four_bg h1{font-size: 80px;}
.contant_box_404 h3{font-size: 40px;}
.link_404{color: #fff !important; padding: 10px 20px; background: #39ac31; margin: 20px 0; display: inline-block;}
.contant_box_404{margin-top: -50px;}
</style>
</head>
<body>
<section class="page_404">
<?php if (! empty($message) && $message !== '(null)') : ?>
	<p><?= esc($message) ?></p>
<?php endif ?>
	<div class="container">
		<div class="row"> 
			<div class="col-sm-12 ">
				<div class="col-sm-10 col-sm-offset-1  text-center">
					<div class="four_zero_four_bg">
						<h1 class="text-center ">404</h1>
					</div>
					<div class="contant_box_404">
						<h3>Whoops!</h3>
						<p>Page Not Found</p>
						<a href="/" class="link_404">Go to Home</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</body>
</html>
