@extends('System.Layouts.Master')
@section('title')
Contract
@endsection
@section('css')
@endsection
@section('content')
<div class="app-body">
    <div class="col-lg-12 col-xl-12">
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">USDM WALLET</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/smart/red_1.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="USDTWallet">N/A</span></h3>
							<p>$1</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">ETH WALLET</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/smart/red_2.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="ethBalance">N/A</span></h3>
							<p>${{$rate['ETH']}}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">REDBOX WALLET</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/logo/logRedbox-02.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="RBDWallet">N/A</span></h3>
							<p>${{$rate['RBD']}}</p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">ENERGY POOL</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/smart/red_4.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="PoolMining">N/A</span></h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">MAX OUT</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/smart/red_5.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="MaxOut">N/A</span></h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">INTEREST</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/smart/red_6.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="Profit">N/A</span></h3>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">TOTAL INVESTMENT</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/smart/red_6.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="TotalInvestment">N/A</span></h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">GUARANTY FUND</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/smart/red_2.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="RESERVEPOOL">N/A</span></h3>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="box">
					<div class="pricingTableSmart">
						<div class="pricingTable-header">
							<h3 class="title">BURN FUND</h3>
						</div>
						<div class="price-value">
							<div class="value">
								<img src="system/images/logo/logRedbox-02.png">
							</div>
						</div>
						<div class="pricing-content">
							<h3><span class="counter-value" id="BurnWallet">N/A</span></h3>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
        
@endsection
@section('script')
  <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.34/dist/web3.min.js"></script>
  <script src="../js/custom.js?v={{time()}}"></script>
  <script>
	  rateCoin = {'ETH': {{ $rate['ETH'] }}, 'RBD': {{ $rate['RBD'] }}, 'USDT': 1};
  </script>
@endsection