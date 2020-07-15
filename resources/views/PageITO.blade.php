
<!DOCTYPE html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="en-gb" class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
		<title>ITO RED BOX DAPP</title> 
		<base href="{{asset('')}}">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="page/images/logo/logoRedbox-01.png" rel="shortcut icon" type="image/x-icon" />
		<!-- **CSS - stylesheets** -->
		<link id="default-css" href="page/style.css?v={{time()}}" rel="stylesheet" media="all" />
		<link href="page/css/animations.css" rel="stylesheet" media="all" />
		
		<link href="page/css/responsive.css?v={{time()}}" rel="stylesheet" type="text/css" />
		<link href="page/css/shortcode.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="page/css/isotope.css" type="text/css">
		<link href="page/css/prettyPhoto.css" rel="stylesheet" type="text/css" /> 
		<link href="page/css/superfish.css" rel="stylesheet" media="all" />
		<link href="page/css/webfont.css" rel="stylesheet" type="text/css" />
		<link href="page/css/pace-theme-loading-bar.css" rel="stylesheet" media="all" />
		<link id="layer-slider" rel="stylesheet"  href="page/css/layerslider.css" media="all" />
		<link rel="stylesheet" href="page/css/font-awesome.min.css">
		<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Montserrat:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
		<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<style>
			.img-width-logo{
				display:inline-block;
				width:50%;
				margin:10px 15px;
				align-self: center;
			}
			.img-width-logo img{
				width:100%;
				max-width:200px;
			}
		</style>
		<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"vaigt1zDGU20kU", domain:"redboxdapp.com",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://certify-js.alexametrics.com/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://certify.alexametrics.com/atrk.gif?account=vaigt1zDGU20kU" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158646467-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-158646467-1');
</script>
		<style>
			a:not([href]):not([tabindex]){
				color:#fff;
			}
		</style>
	</head>
	<body class=" boxed pace-done">
		<canvas class="canvasBG"></canvas>
		<canvas class="canvasBG"></canvas>
		<div id="loader-wrapper"><!-- Loader --> 
			<div id="loading">
				<div id="loading-center">
					<div id="loading-center-absolute">
							<img src="page/images/logo/logoRed2.png" width="300">
						<div class="loader">
							<div class="loading-1"></div>
							<div class="loading-2">Loading...</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- End of Loader -->
		<div class="wrapper"><!-- Wrapper -->
			<div class="inner-wrapper"><!-- Inner-Wrapper -->
				<header id="header" class="dt-sticky-menu type2"><!-- Header -->
					<div class="container">      	                        
						 <div class="main-menu-container">
							<div class="main-menu">
								<div id="logo">
									<a title="NeoCut" href="https://redboxdapp.com/">
										<img class="logo1" title="Redbox" alt="Redbox" src="page/images/logo/logRedbox-02.png" width="60">
										<img class="logo2" title="Redbox" alt="Redbox" src="page/images/logo/logoRed2.png" width="120" style="margin-left: 10px;">
									</a>
								</div>
								<div class="dt-sc-header-shape"><a class="dt-sc-button medium alignright" href="{{ route('getLogin')}}"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></div>
								<div id="primary-menu">
								  <div class="dt-menu-toggle" id="dt-menu-toggle">Menu<span class="dt-menu-toggle-icon"></span></div>
									<nav id="main-menu">
										<ul class="menu">
											<li class="current_page_item menu-item-simple-parent"><a href="#ABOUT">ABOUT</a></li>    
											<li class=""><a href="#EVOLUTION">EVOLUTION</a></li> 
											<li class=""><a href="#ECOSYSTEM">ECOSYSTEM</a></li> 
											<li class=""><a href="#ROADMAP">ROADMAP</a></li>     
											<li class=""><a href="page/project/Redbox-whitepaper.pdf" target="_blank">WHITEPAPER</a></li>     
											<li class=""><a href="http://redboxibet.com/" target="_blank">Ibet</a></li>     
									   </ul>
									</nav>
								</div>
							</div>
						 </div>             
					</div>
				</header><!-- End of Header -->
				<div id="main"><!-- Main  -->
					<div id="slider">	
						<div id="layerslider_30" class="ls-wp-container" style="width:100%;height:700px;max-width:1920px;margin:0 auto;margin-bottom: 0px;">
							<div class="ls-slide" data-ls="slidedelay:10000;transition2d:4;">
								<img src="page/images/bg/redBG-04.png" class="ls-bg" alt="bg1" />
								<div class="ls-l titleSlide" style="top:188px;left:438px;text-align:center; z-index:500;width:300px;padding-left:0px;
								font-family:'Lato', 'Open Sans', sans-serif;font-size:30px;line-height:46px;color:#ffffff;white-space: nowrap;
								background-position: center;" data-ls="offsetxin:0;offsetyin:-100;durationin:2000;delayin:1500;
								transformoriginin:left 50% 0;offsetxout:0;rotateyout:-90;transformoriginout:left 50% 0;">
									<span class="wel">Welcome to RED BOX</span>
									<style type="text/css">
									.wel {
									font-weight:300;
									padding: 5px 0;
									border-bottom: solid 1px #e41111;
									position: relative;
									margin-bottom: 8px;
									}
									
									.wel:after {
									content: '';
									border-bottom: solid 3px #e41111;
									width: 100%;
									position: absolute;
									bottom: -6px;
									left: 0;
									}
									</style>
								</div>
								<div class="ls-l" style="top:275px;left:40px;font-weight:300;z-index:300;background: rgba(0, 0, 0, 0);
								font-family:'Lato';font-size:35px;line-height:80px;color:#ffffff;padding-right:20px;padding-bottom:;
								padding-left:20px;white-space: nowrap;" data-ls="offsetxin:0;durationin:2000;delayin:2500;rotatexin:90;">
									<div class="fontSlide">Decentralized Fintech Project To Build A Strong Financial Community</div>
								</div>
								{{--<div class="ls-l countdowntest" style="top:372px;left:220px;font-weight:300; z-index:3; text-align:center;font-family:'Lato';font-size:17px;line-height:30px;color:#ffffff;white-space: nowrap;" data-ls="offsetxin:0;durationin:2000;delayin:3500;rotatexin:30;">
									<div class="flipper" data-reverse="true" data-datetime="{{date('Y-m-d', strtotime($setting->setting_ito_DateOpen))}} 16:00:00" data-template="dd|HH|ii|ss" data-labels="Days|Hours|Minutes|Seconds" id="myFlipper"></div>
								</div>--}}
							</div>
						</div>
					</div>
					<!-- **Slider Section - End** -->
					<div class="clear"></div>
					<div class="hr-invisible"></div>

					<div class="container" id="ABOUT">
						<h2 class="border-title aligncenter animate" data-delay="100" data-animation="animated fadeInDown">
							ABOUT RED BOX DAPP
						</h2>
						<!--<div class="column dt-sc-one-half first animate" data-delay="100" data-animation="animated fadeIn">
							<div class="intro-about">
								<div class="content-intro">
									<ul>
										<li><p><i class="fa fa-map-marker"></i> Address :</p></li>
										<li><p><i class="fa fa-phone"></i> Phone :</p></li>
										<li><p><i class="fa fa-globe"></i> Website :</p></li>
										<li><p><i class="fa fa-paper-plane"></i> Telegram :</p></li>
										<li><p><i class="fa fa-facebook-square"></i> Facebook :</p></li>
										<li><p><i class="fa fa-twitter"></i> Twitter :</p></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="column dt-sc-one-half first animate" data-delay="100" data-animation="animated fadeIn">
							<div class="intro-about">
								<div class="colum">
									<div class="box-info-conten">
										<h5>RED BOX RESERVE FUND</h5>
										<p><span class="text-red">REDBOX</span> reserve fund is made public to all members of the community. Red Box members who meet the prescribed requirements can withdraw funds from the escrow fund.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="hr-invisible-small"></div>-->
						<div class="column dt-sc-one-third first animate" data-delay="100" data-animation="animated fadeIn">
							<div class="dt-sc-ico-content type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
								<div class="dt-sc-border"></div> 
								<div class="icon">
									<img src="page/images/iconlanding/redIcon_3.png" width="50" alt="" title=""> 
								</div>
								<h3>
									<a> Fintech Project</a>
								</h3>
								<p><span class="text-red">RED BOX DAPP</span> is a decentralized Fintech project, creating a decentralized fund solution to build a strong financial community.</p>                                
							</div>   
						</div>
						<div class="column dt-sc-one-third first animate" data-delay="100" data-animation="animated fadeIn">
							<div class="dt-sc-ico-content type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
								<div class="dt-sc-border"></div> 
								<div class="icon">
									<img src="page/images/iconlanding/redIcon_1.png" width="50" alt="" title=""> 
								</div>
								<h3>
									<a> Dapp Technology</a>
								</h3>
								<p>With Dapp, rights and responsibilities are equal among members of the  <span class="text-red">RED BOX</span> community.</p>                                
							</div>   
						</div>
						<div class="column dt-sc-one-third first animate" data-delay="100" data-animation="animated fadeIn">
							<div class="dt-sc-ico-content type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
								<div class="dt-sc-border"></div> 
								<div class="icon">
									<img src="page/images/iconlanding/redIcon_2.png" width="50" alt="" title=""> 
								</div>
								<h3>
									<a> RED BOX Community</a>
								</h3>
								<p>Whoever or wherever you are, with your contributions to <span class="text-red">RED BOX</span> you will receive commensurate values ​​from the community.</p>                                
							</div>   
						</div>
						<div class="hr-invisible-small"></div>
						<div class="column dt-sc-one-half bd-color first animate" data-delay="100" data-animation="animated fadeIn">
							<div class="intro-icon-block1 m-b-6">
								<div class="colum box-info">
									<div class="w-100 text-right">
										<h1>RED BOX DAPP – GROWING UP COMMUNITY VALUE</h1>
									</div>
									<div class="pull-left w-30">
										<img src="page/images/logo/logoRedbox-01.png" width="100%">
									</div>
									<div class="pull-right w-70">
										<p class="text-right">All information is  made public through the <span class="text-red">RED BOX SMART CONTRACT</span> portal, which allows community members to control and share their rights and responsibilities together.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="column dt-sc-one-half first animate" data-delay="100" data-animation="animated fadeIn">
							<div class="intro-icon-block2">
								<div class="colum">
									<div class="box-info-conten">
										<h5>RED BOX RESERVE FUND</h5>
										<p><span class="text-red">RED BOX</span> reserve fund is made public to all members of the community. RED BOX members who meet the prescribed requirements can withdraw funds from the reserve fund.</p>
									</div>
								</div>
							</div>
							<div class="intro-icon-block2 intro-icon-block23">
								<div class="colum">
									<div class="box-info-conten">
										<h5>RED BOX OPEN FUND</h5>
										<p>Funds for developing a multi-ecosystem support community. Use for raising funds according to <span class="text-red">RED BOX</span> criteria.</p>
									</div>
								</div>
							</div>
							<div class="intro-icon-block2 intro-icon-block23">
								<div class="colum">
									<div class="box-info-conten">
										<h5>RED BOX GLOBAL TRADE FUND</h5>
										<p>The global trading fund is openly transparent to all members. Global trading fund helps investors increase profits through <span class="text-red">RED BOX</span> AI technology.</p>
									</div>
								</div>
							</div>
						</div>
						<div>
							<h2 class="border-title aligncenter animate" data-delay="100" data-animation="animated fadeInDown" style="color:#FFF;font-size:1.5rem">
								RBD is listed on these crypto currency exchanges
							</h2>
							<div class="d-flex" style="max-width: 500px;margin: auto;">
								<div class="img-width-logo text-center">
									<a href="https://coinsbit.io/trade/RBD_USDT" target="_blank"><img src="page/images/logo-coinsbit.png"></a>
								</div>
								<div class="img-width-logo text-center">
									<a href="https://trade.tagz.com/trade/view/rbd_usdt" target="_blank"><img src="page/images/logo_ret.png"></a>
								</div>
							</div>
						</div>
					 </div>   
					<div class="hr-invisible"></div>
					<div class="fullwidth-section dt-sc-parallax-section dt-sc-counters">
						<div class="pt_duble_color_line">
							<span class="second_color">
								<img src="page/images/iconpage/icon-landingpage-01.png">
							</span>
						</div>
						<div class="fullwidth-bg">
							<div class="hr-invisible"></div>
							<div class="container" id="EVOLUTION">
								<h2 class="border-title aligncenter animate" data-delay="100" data-animation="animated fadeInDown">
									EVOLUTION OF DAPP TECHNOLOGY
								</h2>
								<div class="dt-sc-testimonial-carousel-wrapper">
									<ul id="dt-sc-testimonial-carousel" class="dt-sc-testimonial-carousel">
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<q style="font-family:sans-serif"> <span class="text-red">RED BOX</span> applies Smart contact to create a system that works with ERC20 to create RBD tokens.</q>
												</blockquote>
											</div>
										</li>   
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<q style="font-family:sans-serif"> <span class="text-red"> RED BOX TOKEN </span>is considered as the main payment currency in the arounding ecosystems<span class="text-red"> RED BOX CONTRACT</span>. </q>
												</blockquote>
											</div>
										</li>                                                       
									</ul>
								</div>
								<div class="hr-invisible"></div>
							</div>
							<div class="container">
								<div class="column dt-sc-one-half first animate" data-delay="100" data-animation="animated fadeIn">
									<div class="hr-invisible"></div>
									<div class="m-t-7 img-cirle-rps">
										<div class="img-cirle">
											<img src="page/images/RedTicket/Red-Ticket-1.png">
											<img src="page/images/RedTicket/Red-Ticket-3.png">
											<img src="page/images/RedTicket/Red-Ticket-2.png">
										</div>
									</div>
								</div>
								<div class="column dt-sc-one-half animate" data-delay="100" data-animation="animated fadeIn">
								   <div class="description-ticket text-left">
										<div class="list-ticket">
											<p><span>Name:</span> RED BOX DAPP TOKEN.</p>
											<p><span>Ticket:</span> RBD.</p>
											<p><span>Total supply:</span> 600 million tokens.</p>
										</div>
										<div class="list-ticket1">
											<p><i class="fa fa-caret-right" aria-hidden="true"></i> 150 million Tokens sold ITO to  create an initial fund and allocate working capital to create ecosystems around <span class="text-red">RED BOX</span>.</p>
											<p><i class="fa fa-caret-right" aria-hidden="true"></i> 150 million Tokens are traded on international exchanges.</p>
											<p><i class="fa fa-caret-right" aria-hidden="true"></i> 300 million Tokens is operated under Smart Contract operating system and built surrounding ecosystems.</p>
										</div>	
									</div>     
								</div>
								<div class="hr-invisible"></div>
								<div class="column dt-sc-one-fourth first animate" data-delay="300" data-animation="animated fadeIn">
									<div class="dt-sc-ico-content dt-sc-ico-content1 type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
										<div class="dt-sc-border dt-sc-border1"></div> 
										<div class="icon">
											<img src="page/images/ic/Redbox_1.png" alt="" title="" width="70"> 
										</div>
										<h3>
											<a target="_blank" href="#"> DAPP</a>
										</h3>
										<p>DAPP (Decentralized Applications) is a decentralized application. Dapp was created as the continuation of Blockchain technology and smart contract.</p>                                
									</div>   
								</div>
								<div class="column dt-sc-one-fourth animate" data-delay="600" data-animation="animated fadeIn">
									<div class="dt-sc-ico-content dt-sc-ico-content1 type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
										<div class="dt-sc-border dt-sc-border1"></div> 
										<div class="icon">
											<img src="page/images/ic/Redbox_2.png" alt="" title="" width="70"> 
										</div>
										<h3>
											<a target="_blank" href="#"> RED BOX</a>
										</h3>
										<p><span class="text-red">RED BOX</span> applies Dapp application based on MetaMask network directly connected to ETH smart contract.</p>                                
									</div>   
								</div>
								<div class="column dt-sc-one-fourth columnRPS animate" data-delay="900" data-animation="animated fadeIn">
									<div class="dt-sc-ico-content dt-sc-ico-content1 type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
										<div class="dt-sc-border dt-sc-border1"></div> 
										<div class="icon">
											<img src="page/images/ic/Redbox_3.png" alt="" title="" width="70"> 
										</div>
										<h3>
											<a target="_blank" href="#"> API</a>
										</h3>
										<p>With public APIs, other ecosystems can connect and develop on the main smart contract created by <span class="text-red">RED BOX</span>.</p>                                
									</div>   
								</div>
								<div class="column dt-sc-one-fourth animate" data-delay="1200" data-animation="animated fadeIn">
									<div class="dt-sc-ico-content dt-sc-ico-content1 type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
										<div class="dt-sc-border dt-sc-border1"></div> 
										<div class="icon">
											<img src="page/images/ic/Redbox_4.png" alt="" title="" width="70"> 
										</div>
										<h3>
											<a target="_blank" href="#"> Dapp technology</a>
										</h3>
										<p>With decentralized Dapp technology, everyone can actively promote their full potential and capacity as well as control their own privacy.</p>                                
									</div>   
								</div>
								<div class="hr-invisible"></div>
							</div>
						</div>               
					</div>
					<div class="clear"></div>
					<div class="hr-invisible"></div>
					<div class="pt_duble_color_line">
						<span class="second_color">
							<img src="page/images/iconpage/icon-landingpage-02.png">
						</span>
					</div>
					<div class="fullwidth-section dt-service-hme" id="ECOSYSTEM">
						<div class="container" id="POTENTIALITY">
							<h2 class="border-title aligncenter animate animated fadeInDown" data-delay="100" data-animation="animated fadeInDown">
								MULTI-ECOSYSTEM RED BOX
							</h2>
							<h2 class="border-title alignleft border-header-left animate" data-delay="100" data-animation="animated fadeInDown">
								DEPOSIT PORT
							</h2>
							<div class="container">
								<div class="title-style">
									<p><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> The direct deposit gateway called RED BOX IBET Gate allows users to use RBD Token to participate in intellectual betting games in the sbobet system. Besides, it provides AI Score which analyzes and increases the probability of winning up to 85%</p>
								</div>
								<div class="column dt-sc-one-half first animate  " data-delay="600" data-animation="animated lightSpeedIn">
									<div class="service-ecosystem right" style="margin-top:0">
										
									</div>
								</div>
								<div class="column dt-sc-one-half  animate  " data-delay="600" data-animation="animated lightSpeedIn">
									<div class="service-ecosystem right">
										<div class="rotateImage">
											<img src="landingpage/img/ecosystem/ecosystem_1.png">
										</div>
										<div class="borderEcosystem">
											<p>With a certain amount of RBD, punter are offered a betting prediction in a soccer match with a probability of winning up to 80% with AI Score technology.</p>
										</div>
									</div>
								</div>
								<div class="column dt-sc-one-half first animate  " data-delay="600" data-animation="animated lightSpeedIn">
									<div class="service-ecosystem left">
										<div class="rotateImage">
											<img src="landingpage/img/ecosystem/ecosystem_2.png">
										</div>
										<div class="borderEcosystem">
											<p>AI Score will analyze the player's stats, physical strength, odds of the Bookmaker in a football match and provide the Trader with the most appropriate odds with the chance of winning up to 85%.</p>
										</div>
									</div>
								</div>
								<div class="column dt-sc-one-half  animate  " data-delay="600" data-animation="animated lightSpeedIn">
									<div class="service-ecosystem right mt-1280-130">
										<div class="rotateImage">
											<img src="landingpage/img/ecosystem/ecosystem_3.png">
										</div>
										<div class="borderEcosystem">
											<p class="pt-40">RED BOX is a direct partner of Sbobet.</p>
										</div>
									</div> 
								</div>
								<div class="column dt-sc-one-half first animate  " data-delay="600" data-animation="animated lightSpeedIn">
									<div class="service-ecosystem left">
										<div class="rotateImage">
											<img src="landingpage/img/ecosystem/ecosystem_4.png">
										</div>
										<div class="borderEcosystem">
											<p class="pt-25">Traders can use RBD to receive Sbobet accounts and other sports betting accounts.</p>
										</div>
									</div>
								</div>
								<div class="column dt-sc-one-half  animate  " data-delay="600" data-animation="animated lightSpeedIn">
									<div class="service-ecosystem right">
										<div class="rotateImage">
											<img src="landingpage/img/ecosystem/ecosystem_5.png">
										</div>
										<div class="borderEcosystem">
											<p class="pt-25">AI Score can be installed on ibet and use RBD to buy predictive analytics of AI Score for a higher win rate.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="hr-invisible"></div>
							<h2 class="border-title alignright border-header-right animate" data-delay="100" data-animation="animated fadeInDown">
								RED BOX AI MULTI-EXCHANGE TRADING TECHNOLOGY
							</h2>
							<div class="container">
								<div class="hr-invisible"></div>
								<div class="column dt-sc-one-half first animate  " data-delay="300" data-animation="animated lightSpeedIn">
									<div class="service-trade bd">
										<div class="title_number">
											<p>01</p>
										</div>
										<div class="content">
											<p>
												<span class="text-red">RED BOX AI</span> is created with the goal: Whether the trader loses or wins, he can still keep their profits. 
												<span class="text-red">RED BOX AI</span> will read, compare and calculate. Then the system will statistic, ratios and spreads of all
												prices on the top 10 exchanges which have the largest trading volume analyze data continuously in second.
											</p>
										</div>
									</div>
									<div class="service-trade bd">
										<div class="title_number">
											<p>02</p>
										</div>
										<div class="content">
											<p>
												According to the reported data, <span class="text-red">RED BOX AI</span> will make a decision to trade the same amount 
												of money on at least two Exchanges at the same time with both BUY and SELL Comeinand so that when closing the comeinand, 
												no matter which comeinand wins, <span class="text-red">RED BOX AI</span> is also the one who gets profits.
											</p>
										</div>
									</div> 
								</div>
								<div class="column dt-sc-one-half animate  " data-delay="600" data-animation="animated lightSpeedIn">
									<div class="service-trade">
										<img src="page/images/exchange/exchange-redbox.png">
									</div>
								</div>
							</div>
							<div class="hr-invisible-small"></div>
							<div class="container">
								<div class="column">
									<img src="page/images/exchange/trade-1.jpg">
								</div>
							</div>
						</div>
					</div>
					
					<div class="hr-invisible"></div>
					<div class="fullwidth-section dt-sc-parallax-section dt-sc-counters">
						<div class="pt_duble_color_line">
							<span class="second_color">
								<img src="page/images/iconpage/icon-landingpage-01.png">
							</span>
						</div>
						<div class="fullwidth-bg">
							<div class="hr-invisible"></div>
							<div class="container" id="EVOLUTION">
								<h2 class="border-title aligncenter animate" data-delay="100" data-animation="animated fadeInDown">
									POTENTIALITY OF DEVELOPMENT OF RED BOX ADVANTAGES OF RBD

								</h2>
								<div class="dt-sc-testimonial-carousel-wrapper">
									<ul id="dt-sc-testimonial-carousel1" class="dt-sc-testimonial-carousel">
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="server-potential">
														<div class="title">
															<p><span>1</span></p>
														</div>
														<div class="content">
															<h3>Platform</h3>
															<p>RED BOX is developed by many engineers specializing in Smart Contract.</p>
														</div>
													</div>
												</blockquote>
											</div>
										</li>   
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="server-potential">
														<div class="title">
															<p><span>2</span></p>
														</div>
														<div class="content">
															<h3>Expanding ecosystem investment</h3>
															<p>Allow technology teams to raise funds to develop RED BOX open ecosystem and create new ecosystems specifically for the RED BOX community.</p>
														</div>
													</div>
												</blockquote>
											</div>
										</li>       
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="server-potential">
														<div class="title">
															<p><span>3</span></p>
														</div>
														<div class="content">
															<h3>Community of RED BOX</h3>
															<p>There are many people in many countries following the project because of the potentiality of RED BOX.</p>
														</div>
													</div>
												</blockquote>
											</div>
										</li>   
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="server-potential">
														<div class="title">
															<p><span>4</span></p>
														</div>
														<div class="content">
															<h3>Meet the needs of the community</h3>
															<p>With RED BOX development, creating a supply of tokens before running the ecosystem is essential to balance the market.</p>
														</div>
													</div>
												</blockquote>
											</div>
										</li> 
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="server-potential">
														<div class="title">
															<p><span>5</span></p>
														</div>
														<div class="content">
															<h3>Development of the RED BOX</h3>
															<p>With the growth in the number of ecosystems, the RED BOX meets most of the community's concerns such as ecosystems: Sbobet loading port, BO trading platform, inter-exchange tool trade, etc.</p>
														</div>
													</div>
												</blockquote>
											</div>
										</li>   
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="server-potential last">
														<div class="title">
															<p><span>6</span></p>
														</div>
														<div class="content">
															<h3>Provide the token</h3>
															<p>During ITO, RED BOX is able to officially operate at least 2 ecosystems with the aim of proving the outstanding growth of RBD, this is something no project has ever done.</p>
														</div>
													</div>
												</blockquote>
											</div>
										</li>                                                 
									</ul>
								</div>
							</div>
						</div> 
						<div class="fullwidth-bg">
							<div class="hr-invisible-small"></div>
							<div class="container" id="EVOLUTION">
								<h2 class="border-title alignleft border-header-left animate animated fadeInDown" data-delay="100" data-animation="animated fadeInDown">
									ITO ISSUING SCHEDULE
								</h2>
								<div class="clear"></div>
								<div class="column dt-sc-one-half first animate   animated lightSpeedIn" data-delay="300" data-animation="animated lightSpeedIn">
									
									<div class="titleSkew">
										<p>With the potentiality of development and the increasing value of the RBD.</p>
									</div>
									<p>RED BOX will issue ITO in the first 3 months to make the community to believe in the RED BOX project and wish to own the first RED BOX coins.</p>
									<h4 class="titleBG">
										<i class="fa fa-exclamation-triangle pr-10" aria-hidden="true"></i> Note:
									</h4>
									<p><i class="fa fa-caret-right pr-10" aria-hidden="true"></i> From round 1 to round 4, each account is allowed to buy up to $ 1000 and a minimum of $ 100.</p>
									<p><i class="fa fa-caret-right pr-10" aria-hidden="true"></i> By the investor before the end of that round.</p>
									<p><i class="fa fa-caret-right pr-10" aria-hidden="true"></i> Investors can exchange RBD during breaks between rounds.</p>
									<p><i class="fa fa-caret-right" aria-hidden="true"></i> Opening time: 9AM GMT + 00:00 - 4PM UTC +7</p>
									<p><i class="fa fa-caret-right" aria-hidden="true"></i> At the end of ITO, RED BOX officially launched ecosystems that use RBD as the official trading currency, and appeared on 03 international exchanges, confirming the important position and growth rate  when helping investors achieve 200% of investment capital in the first 03 months.</p>
								</div>
								<div class="column dt-sc-one-half animate   animated lightSpeedIn" data-delay="300" data-animation="animated lightSpeedIn">
									<div class="box-image">
										<div class="img-cirle-box">
											<img src="page/images/RedTicket/Red-Ticket-1.png">
										</div>
										<div class="content">
											<p><i class="fa fa-caret-right" aria-hidden="true"></i> RED BOX will issue 150 million for sale.</p>
											<p><i class="fa fa-caret-right" aria-hidden="true"></i> A round will open for 5 days.</p>
											<p><i class="fa fa-caret-right" aria-hidden="true"></i> Starting price: $ 0.0505.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="hr-invisible"></div>  
							<div class="container">
								<div class="dt-sc-testimonial-carousel-wrapper">
									<ul id="round-ito" class="dt-sc-testimonial-carousel">
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 1</span>
															</div>
															<h3 class="title">ISSUE 5 MILLION TOKENS AT PRICE $0.0505</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1:  200,000 Tokens</li>
																<li>Day 2: 500,000 Tokens</li>
																<li>Day 3: 800,000 Tokens</li>
																<li>Day 4: 1,200.000 Tokens</li>
																<li>Day 5: 2,300.000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 01/05/2020 to 01/09/2020</p>
																<p>Time to start: 01/20/2020</p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>     
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 2</span>
															</div>
															<h3 class="title">ISSUE 10 MILLION TOKENS AT PRICE $0.055</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1: 500,000 Tokens</li>
																<li>Day 2: 1,000,000 Tokens</li>
																<li>Day 3: 1,500,000 Tokens</li>
																<li>Day 4: 3,000,000 Tokens</li>
																<li>Day 5: 4,000,000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 01/15/2020 to 01/19/2020</p>
																<p>Time to break: 01/20/2020 to 01/24/2020</p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>    
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 3</span>
															</div>
															<h3 class="title">ISSUE 15 MILLION TOKENS AT PRICE $0.060</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1: 500,000 Tokens</li>
																<li>Day 2: 1,000,000 Tokens</li>
																<li>Day 3: 2,500,000 Tokens</li>
																<li>Day 4: 4,500,000 Tokens</li>
																<li>Day 5: 6,500,000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 01/25/2020 to 01/29/2020</p>
																<p>Time to break: 01/30/2020 – 02/03/2020</p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>     
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 4</span>
															</div>
															<h3 class="title">ISSUE 15 MILLION TOKENS AT PRICE $0.066</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1: 800,000 Tokens</li>
																<li>Day 2: 1,500,000 Tokens</li>
																<li>Day 3: 2,500,000 Tokens</li>
																<li>Day 4: 3,500,000 Tokens</li>
																<li>Day 5: 6,700,000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 02/04/2020 to 02/08/2020</p>
																<p>Time to break: 02/09/2020 to 02/13/2020</p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>     
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 5</span>
															</div>
															<h3 class="title">ISSUE 15 MILLION TOKENS AT PRICE $0.07</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1: 1,000,000 Tokens</li>
																<li>Day 2: 2,000,000 Tokens</li>
																<li>Day 3: 3,000,000 Tokens</li>
																<li>Day 4: 4,000,000 Tokens</li>
																<li>Day 5: 5,000,000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 02/14/2020 to 02/18/2020</p>
																<p>Time to break: 02/19/2020 to 02/23/2020</p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>    
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 6</span>
															</div>
															<h3 class="title">ISSUE 20 MILLION TOKENS AT PRICE $0.077</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1: 1,000,000 Tokens</li>
																<li>Day 2: 2,500,000 Tokens</li>
																<li>Day 3: 3,500,000 Tokens</li>
																<li>Day 4: 5,500,000 Tokens</li>
																<li>Day 5: 7,500,000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 02/24/2020 to 02/28/2020</p>
																<p>Time to break: 02/29/2020 to 03/04/2020</p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>     
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 7</span>
															</div>
															<h3 class="title">ISSUE 20 MILLION TOKENS AT PRICE $0.08</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1: 2,000,000 Tokens</li>
																<li>Day 2: 3,000,000 Tokens</li>
																<li>Day 3: 4,000,000 Tokens</li>
																<li>Day 4: 5,000,000 Tokens</li>
																<li>Day 5: 6,000,000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 03/05/2020 to 03/09/2020</p>
																<p>Time to break: 10/03/2020 to 14/03/2020</p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>     
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 8</span>
															</div>
															<h3 class="title">ISSUE 20 MILLION TOKENS AT PRICE $0.088</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1: 1,500,000 Tokens</li>
																<li>Day 2: 2,000,000 Tokens</li>
																<li>Day 3: 3,500,000 Tokens</li>
																<li>Day 4: 5,500,000 Tokens</li>
																<li>Day 5: 7,500,000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 03/15/2020 to 03/19/2020</p>
																<p>Time to break: 20/03/2020 to 24/03/2020</p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>    
										<li>
											<div class="dt-sc-testimonial"> 
												<blockquote>
													<div class="pricingTable">
														<div class="pricingTable-header">
															<div class="price-value">
																<span class="amount">ROUND 9</span>
															</div>
															<h3 class="title">ISSUE 30 MILLION TOKENS AT PRICE $0.1</h3>
														</div>
														<div class="pricing-content">
															<ul class="inner-content">
																<li>Day 1: 2,000,000 Tokens</li>
																<li>Day 2: 4,000,000 Tokens</li>
																<li>Day 3: 6,000,000 Tokens</li>
																<li>Day 4: 8,000,000 Tokens</li>
																<li>Day 5: 10,000,000 Tokens</li>
															</ul>
															<div class="note">
																<p>Time for sale: 03/25/2020 to 03/29/2020</p>
																<p><br></p>
															</div>
															<div class="pricingTable-signup">
																<a href="landingpage/project/REDBOX ITO FINAL-ENG-new.pdf" target="_blank">See Detail</a>
															</div>
														</div>
													</div>
												</blockquote>
											</div>
										</li>                             
									</ul>
								</div>
							</div>
							<div class="hr-invisible"></div>   
						</div>  
					</div> 
					<div class="clear"></div>
					<div class="hr-invisible"></div>    
					<div class="pt_duble_color_line">
						<span class="second_color">
							<img src="page/images/iconpage/icon-landingpage-04.png">
						</span>
					</div>    
					<div class="container" id="ROADMAP">
						<h2 class="border-title aligncenter animate" data-delay="100" data-animation="animated fadeInDown">
							RED BOX ROADMAP
						</h2>
						<div class="hr-invisible-very-very-small"></div>
						<div class="container">
							<div class="main-timeline">
								<div class="timeline animate" data-delay="200" data-animation="animated fadeInLeft">
									<a href="" class="timeline-content">
										<div class="timeline-icon">
											<img src="page/images/timeline/RedIcon-1.png">
										</div>
										<div class="inner-content">
											<h3 class="title11">Quater I / 2019</h3>
											<p class="description">Technology research, complete the project operating staff.<br><br><br><br></p>
										</div>
									</a>
								</div>
								<div class="timeline animate" data-delay="400" data-animation="animated fadeInRight">
									<a href="" class="timeline-content">
										<div class="timeline-icon">
											<img src="page/images/timeline/RedIcon-2.png">
										</div>
										<div class="inner-content">
											<h3 class="title11">Quater II / 2019</h3>
											<p class="description">Research ITO model and development orientation of ecosystem fund. Initialize the ecosystem.<br><br><br><br></p>
										</div>
									</a>
								</div>
								<div class="timeline animate" data-delay="600" data-animation="animated fadeInLeft">
									<a href="" class="timeline-content">
										<div class="timeline-icon">
											<img src="page/images/timeline/RedIcon-3.png">
										</div>
										<div class="inner-content">
											<h3 class="title11">Quater III / 2019</h3>
											<p class="description">Perfecting technology and related policies to operate RED BOX.<br><br><br><br></p>
										</div>
									</a>
								</div>
								<div class="timeline animate" data-delay="800" data-animation="animated fadeInRight">
									<a href="" class="timeline-content">
										<div class="timeline-icon">
											<img src="page/images/timeline/RedIcon-4.png">
										</div>
										<div class="inner-content">
											<h3 class="title11">Quater IV / 2019</h3>
											<p class="description">Publish the project and issue RBD and develop the RED BOX fund creation project. Operating the RED BOX ecosystem demo.<br><br></p>
										</div>
									</a>
								</div>
								<div class="timeline animate" data-delay="1000" data-animation="animated fadeInLeft">
									<a href="" class="timeline-content">
										<div class="timeline-icon">
											<img src="page/images/timeline/RedIcon-5.png">
										</div>
										<div class="inner-content">
											<h3 class="title11">Quater I / 2020</h3>
											<p class="description">- 05/01/2020: Official opening of ITO sale, create conditions for RBD owners community with the best price.<br>
												- 15/01/2020: Officially operating the first ecosystem called IBET Gate, which allows owners to use RBD to participate in smart betting games on sbobet. Officially launched the Forex and Coin trading platform, which allows the trader to use RBD to trade and increase profits from live trading. Listing RBD on two international exchanges connected from quarter II/2019.<br>
												- 15/03/2020: launching the second ecosystem, RED BOX became the first project in the world to raise funds and develop multiple ecosystems for users.</p>
										</div>
									</a>
								</div>
								<div class="timeline animate" data-delay="1200" data-animation="animated fadeInRight">
									<a href="" class="timeline-content">
										<div class="timeline-icon">
											<img src="page/images/timeline/RedIcon-6.png">
										</div>
										<div class="inner-content">
											<h3 class="title11">Quater II / 2020</h3>
											<p class="description">- Expand funds, corporate with a 3rd partner to use RBD as the officially traded currency.<br>
												- Research the global e-commerce ecosystem, help communities buy purchase directly with RBD.</p>
										</div>
									</a>
								</div>
								<div class="timeline animate" data-delay="1400" data-animation="animated fadeInLeft">
									<a href="" class="timeline-content">
										<div class="timeline-icon">
											<img src="page/images/timeline/RedIcon-7.png">
										</div>
										<div class="inner-content">
											<h3 class="title11">Quater III / 2020</h3>
											<p class="description">Allows direct funding from Open Fun RED BOX for Start-Up projects that use RBD as the official trading currency, while supporting Start-Up technology groups to have more opportunities to develop and help the RED BOX community have the opportunity to experience new and realistic technology platforms.</p>
										</div>
									</a>
								</div>
								<div class="timeline animate" data-delay="1600" data-animation="animated fadeInRight">
									<a href="" class="timeline-content">
										<div class="timeline-icon">
											<img src="page/images/logo/logRedbox-02.png">
										</div>
										<div class="inner-content">
											<h3 class="title11">Quater IV / 2020</h3>
											<p class="description">- RED BOX will launch a consumer ecosystem that will allow you to buy items for 50% of the market price when paying with RBD.<br>
											- Promotion programs allow users to buy a 4-seater car at a price equal to 50% of the market price when paying with RBD.</p>
										</div>
									</a>
								</div>
								 <div class="hr-invisible"></div>
							</div>
						</div>
					</div>
					
					<div class="fullwidth-section dt-sc-parallax-section dt-sc-counters">
						<div class="pt_duble_color_line">
							<span class="second_color">
								<img src="page/images/iconpage/icon-landingpage-01.png">
							</span>
						</div>
						<div class="fullwidth-bg">
							<div class="hr-invisible-small"></div>
							<div class="container" id="EVOLUTION">
								<h2 class="border-title alignleft border-header-left animate animated fadeInDown" data-delay="100" data-animation="animated fadeInDown">
									LEGAL INFORMATION
								</h2>
								<div class="clear"></div>
								<div class="column dt-sc-one-half first animate   animated lightSpeedIn" data-delay="300" data-animation="animated lightSpeedIn">
									<div class="INFORMATION">
										<p class="fz-20"><i class="fa fa-caret-right pr-10" aria-hidden="true"></i> Name: REDBOX INC LIMITED.</p>
										<p class="fz-20"><i class="fa fa-caret-right pr-10" aria-hidden="true"></i> Company Number: 11887452.</p>
										<p class="fz-20"><i class="fa fa-caret-right pr-10" aria-hidden="true"></i> Address: 71 – 75 Shelton Street Covent Garden London England WC2H 9JQ.</p>
									</div>
								</div>
								<div class="column dt-sc-one-half animate   animated lightSpeedIn" data-delay="300" data-animation="animated lightSpeedIn">
									<div class="portfolio-filter">
										<div class="portfolio-box">
											<div  class="portfolio-detail">
												<img src="page/images/redbox1.jpg" alt="information" width="100%">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<footer id="footer">
						<div class="hr-invisible-small"></div>
						<div class="container">
							<ul class="dt-sc-social-network tooltip-container">
								<li class="animate animated fadeIn" data-delay="100" data-animation="animated fadeIn"><a href="https://www.facebook.com/redboxpocofficial/" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li class="animate animated fadeIn" data-delay="300" data-animation="animated fadeIn"><a href="https://twitter.com/RedBoxDapp" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li class="animate animated fadeIn" data-delay="500" data-animation="animated fadeIn"><a href="https://t.me/redboxdapp" target="_blank"><i class="fa fa-telegram"></i></a></li>
								<li class="animate animated fadeIn" data-delay="500" data-animation="animated fadeIn"><a href="https://t.me/redboxofficial" target="_blank"><i class="fa fa-paper-plane-o"></i></a></li>
								<li class="animate animated fadeIn" data-delay="500" data-animation="animated fadeIn"><a href="https://www.youtube.com/channel/UCpJwJmSc2i6j5zNvALro5Vw?view_as=subscriber" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
								<li class="animate animated fadeIn" data-delay="500" data-animation="animated fadeIn"><a href="https://medium.com/@redboxdapp.com" target="_blank"><i class="fa fa-medium"></i></a></li>
								<li class="animate animated fadeIn" data-delay="500" data-animation="animated fadeIn"><a href="https://www.reddit.com/user/redboxdapp" target="_blank"><i class="fa fa-reddit-alien"></i></a></li>
							</ul>
							<div class="copyright-content">
								<p>
									© 2019 RED BOX. All Rights Reserved.
								</p>
							</div>
							<div class="hr-invisible-small"></div>
						</div>
					</footer>            
				</div><!-- End of Main --> 
			</div><!-- Inner-Wrapper -->
		</div><!-- Wrapper --> 
		<!-- **jQuery** -->
		<div class="modal" id="myModal">
			<div class="modal-dialog">
				<div class="modal-content" style="background-color: #fa0b0b;">
					<div class="modal-body" style="padding: 0">
						<button type="button" class="close" data-dismiss="modal" style="padding-right: 10px;text-align: right;color:#fff;opacity:1">&times;</button>
						
						<div class="dt-sc-testimonial-carousel-wrapper">
							<ul id="round-ito-notification" class="dt-sc-testimonial-carousel">
								@foreach($noti_image as $v)
								<li>
									<div class="dt-sc-testimonial"> 
										<blockquote style="margin:0;padding:0">
											<img src="https://redboxdapp.com/public/app/public/{{$v->Url}}" width="100%"> 
										</blockquote>
									</div>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="page/js/jquery.js"></script>
		<script src="page/js/canvas.js"></script>
		<script type="text/javascript" src="page/js/jquery-migrate.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script type="text/javascript" src="page/js/layerslider.js?v=3"></script>
		
		<script>
		@if($noti_image->count() > 0)
			$(document).ready(function () {
				$('#myModal').css("display", "block");
				$('#myModal').addClass('active-modal');
			});
			$(".close").click(function(){
				 $('#myModal').css("display", "none");
			});
			$(window).click(function(e){
				console.log($('#myModal').hasClass('active-modal'));
				if($('#myModal').hasClass('active-modal') == true){
					$('#myModal').css("display", "none");
				}
			});
		@endif
		</script>
		<script type="text/javascript" src="page/js/countdown.js?v={{time()}}"></script>
		<!-- **Slider** -->
		<script data-cfasync="false" type="text/javascript">
			var lsjQuery = jQuery;
		</script>
		<script data-cfasync="false" type="text/javascript">
			lsjQuery(document).ready(function() {
			if(typeof lsjQuery.fn.layerSlider == "undefined") { lsShowNotice('layerslider_30','jquery'); }
			else {
			lsjQuery("#layerslider_30").layerSlider({responsiveUnder: 1170, layersContainer: 1170, startInViewport: false, pauseOnHover: false, forceLoopNum: false, autoPlayVideos: false, skinsPath: 'http://wedesignthemes.com/themes/dummy-super/wp-content/plugins/LayerSlider/static/skins/'})
			}
			});
		</script>	
		<script type="text/javascript">
			$('a[href*=#]').click(function(event){
				$('html, body').animate({
					scrollTop: $( $.attr(this, 'href') ).offset().top
				}, 500);
				event.preventDefault();
			});
			$(document).ready(function() {
				$("#datepicker").datepicker();
			});
			
			
		</script>	
		<script type="text/javascript" src="https://www.jqueryscript.net/demo/Modern-Circular-jQuery-Countdown-Timer-Plugin-Final-Countdown/js/kinetic.js"></script> 
		<script type="text/javascript" src="https://www.jqueryscript.net/demo/Modern-Circular-jQuery-Countdown-Timer-Plugin-Final-Countdown/jquery.final-countdown.js"></script> 
		<script>
			jQuery(function ($) {
				$('#myFlipper').flipper('init');
				$('#modalFlipper').flipper('init');
			});
		</script>
			
		<script type="text/javascript" src="page/js/jsplugins.js"></script>
		<script type="text/javascript" src="page/js/jquery.sticky.min.js"></script> 
		<script type="text/javascript" src="page/js/custom.js?v={{time()}}"></script>
	</body>
</html>