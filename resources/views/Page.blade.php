<!DOCTYPE html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="en-gb" class="no-js"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
    <!--[if lt IE 9]> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    
	<title>REDBOXDAPP</title> 
	<base href="{{asset('')}}">
	<meta name="description" content="">
	<meta name="author" content="">
    
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->    
	<!--[if lte IE 8]>
		<script type="text/javascript" src="http://explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script>
	<![endif]-->
    
    <!-- **Favicon** -->
    <link href="page/images/logo/logoRedbox-01.png" rel="shortcut icon" type="image/x-icon" />
    
    <!-- **CSS - stylesheets** -->
    <link id="default-css" href="page/style.css?v={{time()}}" rel="stylesheet" media="all" />
    <link href="page/css/animations.css" rel="stylesheet" media="all" />
    <link id="skin-css" href="skins/green/style.css" rel="stylesheet" media="all" />
    <link href="page/css/responsive.css?v={{time()}}" rel="stylesheet" type="text/css" />
    <link href="page/css/shortcode.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="page/css/isotope.css" type="text/css">
    <link href="page/css/prettyPhoto.css" rel="stylesheet" type="text/css" /> 
    <link href="page/css/superfish.css" rel="stylesheet" media="all" />
    <link href="page/css/webfont.css" rel="stylesheet" type="text/css" />
 
    <!-- **Additional - stylesheets** -->
    <link href="page/css/pace-theme-loading-bar.css" rel="stylesheet" media="all" />
    <link id="layer-slider" rel="stylesheet"  href="page/css/layerslider.css" media="all" />
        
    <!-- **Font Awesome** -->
    <link rel="stylesheet" href="page/css/font-awesome.min.css">
    
    <!-- **Google - Fonts** -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    
    <!--[if IE 7]>
    <link rel="stylesheet" href="page/css/font-awesome-ie7.min.css" />
    <![endif]-->
    
    <!-- jQuery -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	
	<style>
		@media only screen and (min-width:768px) and (max-width:959px) {
			#main-menu { width: 65%; }
		}
		@media only screen and (max-width: 767px) and (min-width: 320px)
			#header a.dt-sc-button {
				float: left;
				margin: 10px 0 0;
				width:100%;
				padding: 10px 18px !important;
			}
		}
		.alignleft.border-title{
			color:#fff;
		}
		.container h3 a{
			color:#fff;
			transition: 0.5s;
		}
		.container .dt-sc-ico-content.type6:hover h3 a{
			color:#ff0911;
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
                            <a title="NeoCut" href="index.html">
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
                                    <li class=""><a href="#OPERATION">OPERATION</a></li> 
                                    <li class=""><a href="#MEMBERS">MEMBERS</a></li> 
                                    <li class=""><a href="#ROADMAP">ROADMAP</a></li>     
                                    <!-- <li class="dropdown menu-item-simple-parent"><a href="portfolio.html">Project</a>
                                        <ul class="sub-menu">
                                            <li><a href="portfolio.html">Portfolio</a></li>
                                            <li><a href="portfolio-detail.html">Portfolio Details</a></li>
                                            <li><a href="portfolio-detail-lhs.html">Portfolio Details With LHS</a></li>
                                            <li><a href="portfolio-detail-rhs.html">Portfolio Details With RHS</a></li>
                                        </ul>
                                         <a class="dt-menu-expand">+</a>
                                    </li> -->            
                               </ul>
                            </nav>
               			</div>
              		</div>
             	 </div>             
        	</div>
        </header><!-- End of Header -->
        <div id="main"><!-- Main  -->
            <!-- **Slider Section** -->
            <div id="slider">	

                <div id="layerslider_30" class="ls-wp-container" style="width:100%;height:700px;max-width:1920px;margin:0 auto;margin-bottom: 0px;">
                    <div class="ls-slide" data-ls="slidedelay:10000;transition2d:4;">
                        <img src="page/images/bg/redBG-04.png" class="ls-bg" alt="bg1" />
                        <div class="ls-l" style="top:188px;left:434px;text-align:center; z-index:500;width:300px;padding-left:0px;
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
                            Decentralized Fintech Project To Build A Strong Financial Community
                        </div>
                        
                        <!-- <div class="ls-l" style="top:372px;left:323px;font-weight:300; z-index:3; text-align:center;font-family:'Lato';font-size:17px;line-height:30px;color:#ffffff;white-space: nowrap;" data-ls="offsetxin:0;durationin:2000;delayin:3500;rotatexin:30;">We present you
                                <strong>NEO CUT</strong>
                            an elegant template which can be used by creatives<br>who likes to make a best creative salon template
                        </div><p class="ls-l" style="top:447px;left:475px;text-align:center;width:;height:45px;border-bottom:4px solid #e41111;padding-right:;padding-left:;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:30;durationin:2000;delayin:4500;rotatexin:90;">
                            <span style="background: #000; color: #fff; display:block; font-family: 'Lato', sans-serif; font-size: 22px; font-weight: 300; line-height: 45px; position: relative; text-decoration: none; padding: 0px 20px">Purchase Template</span>
                        </p> -->
                    </div>
                    <div class="ls-slide" data-ls="slidedelay:9000; transition2d: all;">
                        <img src="page/images/bg/redBG-03.png" class="ls-bg" alt="bg1" />
                        <div class="ls-l" style="top:188px;left:434px;text-align:center; z-index:500;width:300px;
						padding-left:0px;font-family:'Lato', 'Open Sans', sans-serif;font-size:30px;line-height:46px;
						color:#ffffff;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:-100;durationin:2000;delayin:1500;
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
                        <div class="ls-l" style="top:275px;left:30px;font-weight:300;z-index:300;background: rgba(0, 0, 0, 0);
						font-family:'Lato';font-size:35px;line-height:80px;color:#ffffff;padding-right:20px;padding-bottom:;padding-left:20px;
						white-space: nowrap;" data-ls="offsetxin:0;durationin:2000;delayin:2500;rotatexin:90;">
                            Decentralized Fintech Project To Build A Strong Financial Community
                        </div>
                        
                        <!--<div class="ls-l" style="top:372px;left:323px;font-weight:300; z-index:3; text-align:center;font-family:'Lato';font-size:17px;line-height:30px;color:#ffffff;white-space: nowrap;" data-ls="offsetxin:0;durationin:2000;delayin:3500;rotatexin:30;">We present you
                                <strong>NEO CUT</strong>
                            an elegant template which can be used by creatives<br>who likes to make a best creative salon template
                        </div> <p class="ls-l" style="top:447px;left:475px;text-align:center;width:;height:45px;border-bottom:4px solid #e41111;padding-right:;padding-left:;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:30;durationin:2000;delayin:4500;rotatexin:90;">
                            <span style="background: #000; color: #fff; display:block; font-family: 'Lato', sans-serif; font-size: 22px; font-weight: 300; line-height: 45px; position: relative; text-decoration: none; padding: 0px 20px">Purchase Template</span>
                        </p> -->
                    </div>
                    <div class="ls-slide" data-ls="slidedelay:9000; transition2d: all;">
                        <img src="page/images/bg/redBG-01.png" class="ls-bg" alt="bg1" />
                        <div class="ls-l" style="top:188px;left:434px;text-align:center; z-index:500;width:300px;
						padding-left:0px;font-family:'Lato', 'Open Sans', sans-serif;font-size:30px;line-height:46px;
						color:#ffffff;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:-100;durationin:2000;delayin:1500;
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
                        <div class="ls-l" style="top:275px;left:20px;font-weight:300;z-index:300;background: rgba(0, 0, 0, 0);font-family:'Lato';
						font-size:35px;line-height:80px;color:#ffffff;padding-right:20px;padding-bottom:;padding-left:20px;white-space: nowrap;" 
						data-ls="offsetxin:0;durationin:2000;delayin:2500;rotatexin:90;">
                            Decentralized Fintech Project To Build A Strong Financial Community
                        </div>
                        
                        <!--<div class="ls-l" style="top:372px;left:323px;font-weight:300; z-index:3; text-align:center;font-family:'Lato';font-size:17px;line-height:30px;color:#ffffff;white-space: nowrap;" data-ls="offsetxin:0;durationin:2000;delayin:3500;rotatexin:30;">We present you
                                <strong>NEO CUT</strong>
                            an elegant template which can be used by creatives<br>who likes to make a best creative salon template
                        </div> <p class="ls-l" style="top:447px;left:475px;text-align:center;width:;height:45px;border-bottom:4px solid #e41111;padding-right:;padding-left:;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:30;durationin:2000;delayin:4500;rotatexin:90;">
                            <span style="background: #000; color: #fff; display:block; font-family: 'Lato', sans-serif; font-size: 22px; font-weight: 300; line-height: 45px; position: relative; text-decoration: none; padding: 0px 20px">Purchase Template</span>
                        </p> -->
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
                <div class="column dt-sc-one-third first animate" data-delay="100" data-animation="animated fadeIn">
                    <div class="dt-sc-ico-content type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
                        <div class="dt-sc-border"></div> 
                        <div class="icon">
                            <img src="page/images/iconlanding/redIcon_3.png" width="50" alt="" title=""> 
                        </div>
                        <h3>
                            <a> Fintech Project</a>
                        </h3>
                        <p><span class="text-red">RED BOX DAPP</span> is a decentralized Fintech project that creates a decentralized fund solution to build a strong financial community together.</p>                                
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
                        <p>With <span class="text-red">Dapp</span> technology, any member is equal in terms of rights and responsibilities for the <span class="text-red">REDBOX</span> community.</p>                                
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
                        <p> Whoever you are or wherever you are, depending on your contribution to the <span class="text-red">RED BOX</span> community, you will get back the proportional value from the community.</p>                                
                    </div>   
                </div>
                <div class="hr-invisible-small"></div>
                <div class="column dt-sc-one-half bd-color first animate" data-delay="100" data-animation="animated fadeIn">
                    <div class="intro-icon-block1 m-b-6">
                        <div class="colum box-info">
                            <div class="w-100 text-right">
                                <h1>RED BOX DAPP CREATES VALUES FOR COMMUNITY</h1>
                            </div>
                            <div class="pull-left w-30">
                                <img src="page/images/logo/logoRedbox-01.png" width="100%">
                            </div>
                            <div class="pull-right w-70">
                                <p class="text-right">Everything is made public transparent and with the open API of <span class="text-red">RED BOX SMART CONTRACT</span>, which will help the community to control, share rights and responsibilities together.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column dt-sc-one-half first animate" data-delay="100" data-animation="animated fadeIn">
                    <div class="intro-icon-block2">
                        <div class="colum">
                            <div class="box-info-conten">
                                <h5>REDBOX RESERVE FUND</h5>
                                <p>The reserve fund and its members will be able to see the fund publicly and must meet fully the community dedication process to withdraw money from the reserve fund.</p>
                            </div>
                        </div>
                    </div>
                    <div class="intro-icon-block2 intro-icon-block23">
                        <div class="colum">
                            <div class="box-info-conten">
                                <h5>REDBOX OPEN FUND</h5>
                                <p>This fund helps decentralized projects and supports the community to develop and raise capital with the criteria set out by RED BOX.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-invisible"></div>
                <div class="hr-invisible none"></div>
             </div>   
               
            <div class="hr-invisible"></div>

            
            <div class="fullwidth-section dt-sc-parallax-section dt-sc-counters">
                <div class="pt_duble_color_line">
                    <span class="second_color">
                        <img src="page/images/iconpage/icon-landingpage-01.png">
                    </span>
                </div>
            	<div class="fullwidth-bg">
                    <!-- <div class="container">                 
                        <div class="hr-invisible"></div>
                        <div class="hr-invisible-very-very-small"></div>
                        <h2 class="border-title aligncenter animate" data-delay="100" data-animation="animated fadeInDown">
                            Our Team
                        </h2>
                        <div class="hr-invisible"></div>                
                        <div class="column dt-sc-one-fourth first animate" data-delay="100" data-animation="animated fadeIn">
                            <div class="dt-sc-team type2">
                                <div class="image">
                                    <img src="http://placehold.it/550x550&text=Team+Image" alt="" title="" />
                                    <div class="team-details-social-icons">
                                        <a class="fa fa-facebook" href="#"> </a>
                                        <a class="fa fa-twitter" href="#"> </a>
                                        <a class="fa fa-linkedin" href="#"> </a>
                                        <a class="fa fa-google-plus" href="#"> </a>
                                    </div>
                                </div>
                                <h5>
                                    <a href="#"> Jim Carry </a>
                                </h5>
                                <h6> Facial Specialist </h6>
                            </div>
                        </div> 
                        <div class="column dt-sc-one-fourth animate" data-delay="300" data-animation="animated fadeIn">
                            <div class="dt-sc-team type2">
                                <div class="image">
                                    <img src="http://placehold.it/550x550&text=Team+Image" alt="" title="" />
                                    <div class="team-details-social-icons">
                                        <a class="fa fa-facebook" href="#"> </a>
                                        <a class="fa fa-twitter" href="#"> </a>
                                        <a class="fa fa-linkedin" href="#"> </a>
                                        <a class="fa fa-google-plus" href="#"> </a>
                                    </div>
                                </div>
                                <h5>
                                    <a href="#"> Mark Vick </a>
                                </h5>
                                <h6> Hair Stylist </h6>
                            </div>
                        </div>
                        <div class="column dt-sc-one-fourth animate" data-delay="500" data-animation="animated fadeIn">
                            <div class="dt-sc-team type2">
                                <div class="image">
                                    <img src="http://placehold.it/550x550&text=Team+Image" alt="" title="" />
                                    <div class="team-details-social-icons">
                                        <a class="fa fa-facebook" href="#"> </a>
                                        <a class="fa fa-twitter" href="#"> </a>
                                        <a class="fa fa-linkedin" href="#"> </a>
                                        <a class="fa fa-google-plus" href="#"> </a>
                                    </div>
                                </div>
                                <h5>
                                    <a href="#"> Lincy Mindo </a>
                                </h5>
                                <h6> Fashion Designer </h6>
                            </div>
                        </div>
                        <div class="column dt-sc-one-fourth animate" data-delay="700" data-animation="animated fadeIn">
                            <div class="dt-sc-team type2">
                                <div class="image">
                                    <img src="http://placehold.it/550x550&text=Team+Image" alt="" title="" />
                                    <div class="team-details-social-icons">
                                        <a class="fa fa-facebook" href="#"> </a>
                                        <a class="fa fa-twitter" href="#"> </a>
                                        <a class="fa fa-linkedin" href="#"> </a>
                                        <a class="fa fa-google-plus" href="#"> </a>
                                    </div>
                                </div>
                                <h5>
                                    <a href="#"> Eliza Rika </a>
                                </h5>
                                <h6> Wedding Specialist </h6>
                            </div>
                        </div>
                        <div class="hr-invisible"></div>                           
                    </div>  -->
                        <div class="hr-invisible"></div>
                    <div class="container" id="EVOLUTION">
                        <h2 class="border-title aligncenter animate" data-delay="100" data-animation="animated fadeInDown">
                            EVOLUTION OF DAPP TECHNOLOGY
                        </h2>
                        <div class="dt-sc-testimonial-carousel-wrapper">
                            <ul class="dt-sc-testimonial-carousel">
                                <li>
                                    <div class="dt-sc-testimonial"> 
                                        <blockquote>
                                            <q> <span class="text-red">REDBOX</span> applies Smart Contracts to create operational systems and ERC20 to create RBD tokens.</q>
                                        </blockquote>
                                    </div>
                                </li>   
                                <li>
                                    <div class="dt-sc-testimonial"> 
                                        <blockquote>
                                            <q> <span class="text-red"> RED BOX TOKEN </span>is considered as the main payment currency for the ecosystems around<span class="text-red"> RED BOX CONTRACT</span>. </q>
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
                                    <p><span>Name:</span> Red Box dapp token.</p>
                                    <p><span>Ticket:</span> RBD.</p>
                                    <p><span>Total supply:</span> 600 million tokens.</p>
                                </div>
                                <div class="list-ticket1">
                                    <p><i class="fa fa-caret-right" aria-hidden="true"></i> 100 million sold ITO creates an initial fund and allocates working capital to create ecosystems around <span class="text-red">Red Box</span>.</p>
                                    <p><i class="fa fa-caret-right" aria-hidden="true"></i> 500 million will be opened under the Smart Contract operating system.</p>
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
                                <p>DAPP stands for Decentralized Applications, it means decentralized or decentralized applications. Dapp was born after Blockchain technology and smart contracts.</p>                                
                            </div>   
                        </div>
                        <div class="column dt-sc-one-fourth animate" data-delay="600" data-animation="animated fadeIn">
                            <div class="dt-sc-ico-content dt-sc-ico-content1 type6 animate animated fadeIn" data-delay="100" data-animation="animated fadeIn">
                                <div class="dt-sc-border dt-sc-border1"></div> 
                                <div class="icon">
                                    <img src="page/images/ic/Redbox_2.png" alt="" title="" width="70"> 
                                </div>
                                <h3>
                                    <a target="_blank" href="#"> REDBOX</a>
                                </h3>
                                <p><span class="text-red">REDBOX</span> follows Dapp based on the MetaMask network directly connected to the ETH smart contract.</p>                                
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
                                <p>With public API so that other ecosystems can connect and develop on the main smart contract that <span class="text-red">Red Box</span> creates.</p>                                
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
                                <p>With decentralized Dapp technology, everyone can actively take full advantage of their potential and capacity as well as control their privacy.</p>                                
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
            <div class="fullwidth-section dt-service-hme" id="OPERATION">
            	<div class="container">
                    <h2 class="border-title aligncenter animate" data-delay="100" data-animation="animated fadeInDown">
                       RED BOX OPERATION
                    </h2>
                    <p class="aligncenter text-title-p">Ref link: 10% RBD that your referral bought.<br>With the amount of RBD, you can exchange for ETH at any time through <span class="text-red">RED BOX's</span> security fund.</p>
                    <div class="hr-invisible-small"></div>
                    <div class="column dt-sc-one-third first animate" data-delay="100" data-animation="animated fadeIn">
                        <div class="intro-icon-block2 bd-box-2">
                            <ul class="table-list">
                                <li><span class="text-1">R1</span> <span class="text-2">10 million at the price of 0.0505</span></li>
                                <li><span class="text-1">R2</span> <span class="text-2">10 million at the price of 0.0510</span></li>
                                <li><span class="text-1">R3</span> <span class="text-2">10 million at the price of 0.0515</span></li>
                                <li><span class="text-1">R4</span> <span class="text-2">10 million at the price of 0.0520</span></li>
                                <li><span class="text-1">R5</span> <span class="text-2">10 million at the price of 0.0525</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="column dt-sc-one-third animate" data-delay="300" data-animation="animated fadeIn">
                        <div class="intro-icon-block2 bd-box-2">
                            <div class="title-number">
                                <img class="img-rpv-table1" src="page/images/RedTicket/Red-Ticket-4.png">
                                <img class="img-rpv-table" src="page/images/RedTicket/Red-Ticket-5.png">
                            </div>
                        </div>
                    </div>
                    <div class="column dt-sc-one-third animate" data-delay="600" data-animation="animated fadeIn">
                        <div class="intro-icon-block2 bd-box-2">
                            <ul class="table-list">
                                <li><span class="text-1">R6</span> <span class="text-2">10 million at the price of 0.0530</span></li>
                                <li><span class="text-1">R7</span> <span class="text-2">10 million at the price of 0.0535</span></li>
                                <li><span class="text-1">R8</span> <span class="text-2">10 million at the price of 0.0540</span></li>
                                <li><span class="text-1">R9</span> <span class="text-2">10 million at the price of 0.0545</span></li>
                                <li><span class="text-1 tx">R10</span> <span class="text-2">10 million at the price of 0.0550</span></li>
                            </ul>
                        </div>
                    </div>      
                </div>
			</div>  
            <div class="container">                 
            <div class="hr-invisible"></div>
            <div class="hr-invisible-very-very-small"></div>              
                <div class="column dt-sc-one-half first animate" data-delay="300" data-animation="animated fadeIn">
                    <div class="intro-icon-block3">
                        <img src="page/images/RedTicket/Red-Ticket-6.png">
                        <p class="text-light">
                            <span class="text-red">RED BOX</span> will open ITO in the first month to call upon the community to believe in the<span class="text-red"> RED BOX</span> project and look forward to owning the first<span class="text-red"> RED BOX coins</span>.
                        </p>
                        <span class="bd-bt"></span>
                    </div>
                </div> 
                <div class="column dt-sc-one-half animate" data-delay="600" data-animation="animated fadeIn">
                    <div class="intro-icon-block3">
                        <img src="page/images/RedTicket/Red-Ticket-7.png">
                        <p class="text-light">
                            With the amount of ETH loaded and to buy 90% ITO will be stored directly into the guarantee contract for<span class="text-red"> RED BOX</span>.
                        </p>
                        <span class="bd-bt"></span>
                    </div>
                </div>
                <div class="hr-invisible"></div>                       
            </div>    
            <div class="hr-invisible"></div> 

            <div class="fullwidth-section dt-sc-parallax-section dt-sc-client-testimonial">
            	<div class="fullwidth-bg">
                    <div class="pt_duble_color_line">
                        <span class="second_color">
                            <img src="page/images/iconpage/icon-landingpage-03.png">
                        </span>
                    </div>

                    <div class="container" id="MEMBERS">
                        <div class="hr-invisible"></div>
                        <h2 class="border-title alignleft border-header-left animate" data-delay="100" data-animation="animated fadeInDown">
                            WHY SHOULD BE A MEMBER OF RED BOX?
                        </h2>
                        <div class="container">
                            <div class="title-style">
                                <p><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> With Dapp technology, you only need a meta mark wallet or Trust wallet to be able to connect to Red Box contract easily and become a member of <span class="text-red">RED BOX</span>.</p>
                                <p><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> With adding of ETH to the contract in different quantities you will have different benefits.</p>
                            </div>
                            <div class="hr-invisible"></div>
                            <div class="column dt-sc-one-fourth first animate" data-delay="300" data-animation="animated bounceIn">
                                <div class="square-rotateA ">
                                    <div class="square-rotate1 square-rotate-1">
                                        <p>Under 500 USD Mining Box 150% Daily USDM 0.5%</p>
                                    </div>
                                </div>  
                            </div>
                            <div class="column dt-sc-one-fourth animate" data-delay="600" data-animation="animated bounceIn">
                                <div class="square-rotateB square-rotate1-mt">
                                    <div class="square-rotate1 square-rotate-2">
                                        <p>501 - 10 000 USD Mining Box 200% Daily USDM 0.5%</p>
                                    </div>
                                </div>   
                            </div>
                            <div class="column dt-sc-one-fourth animate" data-delay="900" data-animation="animated bounceIn">
                                <div class="square-rotateA">
                                    <div class="square-rotate1 square-rotate-1">
                                        <p>10 000 - 100 000 USD Mining Box 250% Daily USDM 0.5%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="column dt-sc-one-fourth animate" data-delay="1200" data-animation="animated bounceIn">
                               <div class="square-rotateB square-rotate1-mt">
                                    <div class="square-rotate1 square-rotate-2">
                                        <p>From 100 001 USD Mining Box 300% Daily USDM 0.5%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hr-invisible"></div>
                        <h2 class="border-title alignright border-header-right animate" data-delay="100" data-animation="animated fadeInDown">
                            COMMISSION BY LEVEL
                        </h2>
                        <div class="container">
                            <div class="hr-invisible"></div>
                            <div class="column dt-sc-one-third first animate  " data-delay="300" data-animation="animated lightSpeedIn">
                                <div class="service-box-img">
                                    <img src="page/images/level/Level1-RedBox.png">
                                    <p>With 2 branches having total revenue of 150000 USD or more, you will go to Red 1.</p>
                                </div>  
                            </div>
                            <div class="column dt-sc-one-third animate  " data-delay="600" data-animation="animated lightSpeedIn">
                                <div class="service-box-img">
                                    <img src="page/images/level/Level2-RedBox.png">
                                    <p>If you have Red 1 with any 2 branches, you will go to Red 2.<br><br></p>
                                </div>
                            </div>
                            <div class="column dt-sc-one-third animate  " data-delay="900" data-animation="animated lightSpeedIn">
                                <div class="service-box-img">
                                    <img src="page/images/level/Level3-RedBox.png">
                                    <p>If you have Red 2 with any 2 branches, you will go to Red 3.<br><br></p>
                                </div>
                            </div>
                            <div class="hr-invisible rpv1"></div>
                            <div class="column dt-sc-two-third">
                                <div class="column dt-sc-one-half first animate   " data-delay="1200" data-animation="animated lightSpeedIn">
                                    <div class="service-box-img">
                                        <img src="page/images/level/Level4-RedBox.png">
                                        <p>If you have Red 3 with any 2 branches, you will go to Red 4.</p>
                                    </div>
                                </div>
                                <div class="column dt-sc-one-half animate   " data-delay="1500" data-animation="animated lightSpeedIn">
                                    <div class="service-box-img">
                                        <img src="page/images/level/Level5-RedBox.png">
                                        <p>If you have Red 4 with any 2 branches, you will go to Red 5.</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="hr-invisible"></div>
                        <h2 class="border-title alignleft border-header-left animate" data-delay="100" data-animation="animated fadeInDown">
                            LINK REF AND NEW MEMBER <br>DEVELOPMENT PROGRAM
                        </h2>
                        <div class="container">
                            <div class="hr-invisible"></div>
                            <div class="column dt-sc-one-fifth first animate" data-delay="300" data-animation="animated bounceInUp">
                                 <div class="">
                                    <div class="counter1 ">
                                        <div class="counter">
                                            <h3>You get 5% from level 2 to level 3 (30% received immediately and 70% added to the Mining Box).</h3>
                                        </div>
                                        <p>Red 1</p>
                                    </div>  
                                </div>
                            </div>
                            <div class="column dt-sc-one-fifth counter-bt animate" data-delay="600" data-animation="animated bounceInDown">
                                 <div class="counter-bt">
                                    <div class="counter1">
                                        <div class="counter">
                                            <h3>You get 5% from level 2 to level 5 (30% received immediately and 70% added to the Mining Box).</h3>
                                        </div>
                                        <p>Red 2</p>
                                    </div>  
                                </div> 
                            </div>
                            <div class="column dt-sc-one-fifth animate" data-delay="900" data-animation="animated bounceInUp">
                                <div class="">
                                    <div class="counter1">
                                        <div class="counter">
                                            <h3>You get 5% from level 2 to level 7  (30% received immediately and 70% added to the Mining Box).</h3>
                                        </div>
                                        <p>Red 3</p>
                                    </div>
                                </div>
                            </div>
                            <div class="column dt-sc-one-fifth  animate" data-delay="1200" data-animation="animated bounceInDown">
                               <div class="counter-bt">
                                   <div class="counter1">
                                        <div class="counter">
                                            <h3>You get 5% from level 2 to level 10 (30% received immediately and 70% added to the Mining Box).</h3>
                                        </div>
                                        <p>Red 4</p>
                                    </div>
                               </div>
                            </div>
                            <div class="column dt-sc-one-fifth animate" data-delay="1500" data-animation="animated bounceInUp">
                                <div class="">
                                    <div class="counter1">
                                        <div class="counter">
                                            <h3>You get 5% from level 2 to level 12 (30% received immediately and 70% added to the Mining Box).</h3>
                                        </div>
                                        <p>Red 5</p>
                                    </div>
                                </div>
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
                                    <p class="description">Gathering personnel and technology researchers for the project.</p>
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
                                    <p class="description">Studying ITO model and developing community fund.<br><br></p>
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
                                    <p class="description">Completing technology and related policies to operate Red Box.</p>
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
                                    <p class="description">Publishing projects and developing RBD, Red Box fund creation projects.</p>
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
                                    <p class="description">Launching the first ecosystem simultaneously negotiating RBD on the exchanges.</p>
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
                                    <p class="description">Launching the second ecosystem and pushing RBD to at least 2 to 5 transaction sieves.</p>
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
                                    <p class="description">Allowing direct funding from Red Box Open Fun for Red Box projects.</p>
                                </div>
                            </a>
                        </div>
                        <div class="timeline animate" data-delay="1600" data-animation="animated fadeInRight">
                            <a href="" class="timeline-content">
                                <div class="timeline-icon">
                                    <img src="page/images/timeline/RedIcon-8.png">
                                </div>
                                <div class="inner-content">
                                    <h3 class="title11">Quater IV / 2020</h3>
                                    <p class="description">Lending ecosystem based on RBD.<br><br></p>
                                </div>
                            </a>
                        </div>
                         <div class="hr-invisible"></div>
                    </div>
                </div>
			</div>
            <footer id="footer">
                <div class="hr-invisible-small"></div>
                <div class="container">
                    <ul class="dt-sc-social-network tooltip-container">
                        <li class="animate animated fadeIn" data-delay="100" data-animation="animated fadeIn"><a href="#" class="fa fa-google-plus tooltip"><span class="tooltip-content">Google+</span></a></li>
                        <li class="animate animated fadeIn" data-delay="300" data-animation="animated fadeIn"><a href="#" class="fa fa-facebook tooltip"><span class="tooltip-content">Facebook</span></a></li>
                        <li class="animate animated fadeIn" data-delay="500" data-animation="animated fadeIn"><a href="#" class="fa fa-twitter tooltip"><span class="tooltip-content">Twitter</span></a></li>
                    </ul>
                    <div class="copyright-content">
                    	<p>
                            © 2019 REDBOX. All Rights Reserved.
                        </p>
                    </div>
                    <div class="hr-invisible-small"></div>
                </div>
            </footer>            
        </div><!-- End of Main --> 
    </div><!-- Inner-Wrapper -->
</div><!-- Wrapper --> 
	
<!-- **jQuery** -->
<script src="page/js/jquery.js"></script>
<script src="page/js/canvas.js"></script>
<script type="text/javascript" src="page/js/jquery-migrate.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="page/js/layerslider.js"></script>

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

<script type="text/javascript" src="page/js/jsplugins.js"></script>
<script type="text/javascript" src="page/js/jquery.sticky.min.js"></script> 
<script type="text/javascript" src="page/js/custom.js"></script>
</body>
</html>