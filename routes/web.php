<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeController@getIndex')->name('getIndex');
Route::get('/test', 'TestController@Test')->name('Test');

Route::get('update-max', 'System\AdminController@updateMaxToken')->name('system.admin.updateMaxToken');
Route::get('close-ito', 'System\AdminController@closeRound')->name('system.admin.closeRound');
Route::group(['middleware' => 'login.register'], function () {
	//Login
    Route::get('login', 'Auth\LoginController@getLogin')->name('getLogin');
    Route::post('login', 'Auth\LoginController@postLogin')->name('postLogin');
    Route::get('loginCheckOTP','Auth\LoginController@postLoginCheckOTP')->name('system.user.postLoginCheckOTP');
    //Register
    Route::get('register', 'Auth\RegisterController@getRegister')->name('getRegister');
    Route::post('register', 'Auth\RegisterController@postRegister')->name('postRegister');
    //Forgot password
    Route::get('forgot-password', 'Auth\ForgotPasswordController@getForgotPassword')->name('getForgotPass');
    Route::post('forgot-password', 'Auth\ForgotPasswordController@postForgotPassword')->name('PostForget');
});

Route::group(['prefix'=>'json']	, function (){
	
	Route::get('confirm-wallet', 'System\JsonController@postConfirmWallet')->name('postConfirmWallet');
	
	Route::get('accounts/{address}', 'System\JsonController@checkAccount')->name('json.checkAccount');
	Route::get('checkAccountByName/{u}', 'System\JsonController@checkAccountByUser')->name('json.checkAccountByUser');
	Route::get('checkAccountByEmail', 'System\JsonController@checkAccountByEmail')->name('json.checkAccountByEmail');
	
	Route::get('send-package', 'System\InvestmentsController@postPackage')->name('json.postPackage');
	Route::get('getHistory', 'System\MoneyController@getHistory')->name('json.getHistory');
	
	Route::post('mining', 'System\MoneyController@postMining')->name('postMining');
	Route::get('exchange/USDT-RBD', 'System\ExchangeController@postExchange')->name('json.postExchange');
	Route::get('check-swap', 'System\ExchangeController@getCheckSwap')->name('json.getCheckSwap');
	
});

// add member người bảo trợ
Route::post('AddMember', 'Auth\RegisterController@postRegisterAddMember')->name('system.user.postRegisterAddMember');
Route::get('login-otp', 'Auth\LoginController@getLoginOTP')->name('getLoginOTP');
Route::post('login-otp', 'Auth\LoginController@postLoginOTP')->name('postLoginOTP');

Route::get('logout', 'Auth\LoginController@getLogout')->name('getLogout');

Route::get('change-password', 'Auth\ForgotPasswordController@getChangePass')->name('getChangePass');
Route::get('active', 'Auth\RegisterController@getActive')->name('getActiveMail');
Route::post('active', 'Auth\RegisterController@postActive')->name('postActiveMail');
Route::get('download/{file}', 'Home\PageController@getDownload')->name('getDownload');

Route::group(['prefix' => 'system', 'middleware' => 'check.login'], function (){
    Route::get('/dashboard', 'System\DashboardController@getDashboard')->name('system.dashboard');
	Route::get('findwallet', 'System\AdminController@getFindWallet')->name('system.admin.getFindWallet');
	//mobile
	Route::get('mobile', 'System\MobileController@getMobile')->name('getMobile');
	//system
	Route::get('change-pass', 'System\UserController@getChangePass')->name('system.getChangePass');
	Route::post('change-pass', 'System\UserController@postChangePass')->name('system.postChangePass');
	Route::get('profile', 'System\UserController@getProfile')->name('system.getProfile');
	Route::post('profile', 'System\UserController@postProfile')->name('system.postProfile');
	Route::post('change-password', 'System\UserController@postChangePass')->name('system.postChangePass');
	// wallet nè
	Route::get('wallet', 'System\WalletController@getWallet')->name('system.wallet');
	Route::get('wallet/deposit', 'System\WalletController@getDeposit')->name('system.getDeposit');
	Route::post('withdraw', 'System\WalletController@postWithdraw')->name('system.postWithdraw')->middleware('throttle:5,1');
	Route::post('transfer', 'System\WalletController@postTransfer')->name('system.postTransfer')->middleware('throttle:5,1');
	Route::get('wallet/transfer', 'System\WalletController@getTransfer')->name('system.getTransfer');
	Route::get('wallet/active', 'System\WalletController@getWalletActive')->name('system.wallet.getWalletActive');
	// end wallet

	Route::get('contract', 'System\SmartContractController@getIndex')->name('system.getSmartContract');

	Route::get('trade', 'System\TradeController@getIndex')->name('system.getTrade');
	Route::post('trade-buy', 'System\TradeController@postTradeBuy')->name('system.postTradeBuy')->middleware('throttle:5,1');
	Route::post('trade-sell', 'System\TradeController@postTradeSell')->name('system.postTradeSell')->middleware('throttle:5,1');

	Route::get('investment', 'System\InvestmentController@getInvestment')->name('system.getInvestment');

	Route::get('exchange', 'System\ExchangeController@getExchange')->name('system.getExchange');
    Route::post('exchange/sell/{base}_{item}','System\ExchangeController@postSellExchange')->name('postSellExchange');
    Route::post('sell/confirm/{base}_{item}','System\ExchangeController@postSellConfirm')->name('postSellConfirm');
    Route::post('exchange/buy/{base}_{item}','System\ExchangeController@postBuyExchange')->name('postBuyExchange');
    Route::post('buy/confirm/{base}_{item}','System\ExchangeController@postBuyConfirm')->name('postBuyConfirm');

	Route::get('wallet/cancel', 'System\WalletController@getCancel')->name('system.wallet.getCancel');

	Route::get('ticket', 'System\TicketController@getTicket')->name('getTicket');
	Route::get('detail-ticket', 'System\TicketController@getDetailTicket')->name('system.getDetailTicket');
	Route::post('ticket', 'System\TicketController@postTicket')->name('postTicket');
	Route::get('ticket-admin', 'System\TicketController@getTicketAdmin')->name('getTicketAdmin');
	Route::post('ticket-reply', 'System\TicketController@postTicketReply')->name('postTicketReply');

	Route::group(['prefix'=>'user'], function (){
		Route::get('add', 'System\UserController@getAdd')->name('system.user.getAdd');
		Route::get('list', 'System\UserController@getList')->name('system.user.getList');
        
		Route::get('tree', 'System\UserController@getTree')->name('system.user.getTree');
        Route::post('change-password', 'Auth\ResetPasswordController@changePassword')->name('system.user.postChangePassword');
        Route::post('auth', 'System\UserController@postAuth')->name('system.user.postAuth');
		Route::post('post-kyc', 'System\UserController@PostKYC')->name('system.user.PostKYC');
		
		Route::post('member-add', 'System\UserController@postMemberAdd')->name('system.user.postMemberAdd');
		Route::get('ajax-change-side-active', 'System\UserController@changeUserSideActivce')->name('changeSideActive');
	});

	Route::group(['prefix'=>'json']	, function (){
		
		Route::get('getAddress', 'System\CoinbaseController@getAddress')->name('system.json.getAddress');
		Route::get('history-wallet', 'System\JsonController@getHistory')->name('system.json.getHistory');
		Route::get('playGame', 'System\JsonController@getPlayGame')->name('system.json.playGame');
		Route::get('changes', 'System\JsonController@getChanges')->name('system.json.getChanges');
		Route::get('percent', 'System\JsonController@getPercent')->name('system.json.getPercent');
		Route::get('balance', 'System\MobileController@getBalance')->name('system.json.getBalance');
		Route::get('member-investment', 'System\JsonController@getInvestmentMember')->name('system.json.getInvestmentMember');
	});

	Route::group(['prefix'=>'history'], function (){
		Route::get('wallet', 'System\HistoryController@getHistoryWallet')->name('system.history.getHistoryWallet');
		Route::get('commission', 'System\HistoryController@getHistoryCommission')->name('system.history.getHistoryCommission');
		Route::get('investment', 'System\HistoryController@getHistoryInvestment')->name('system.history.getHistoryInvestment');
	});



	Route::get('exchange-rate', 'System\WalletController@getExchangeRate')->name('system.getExchangeRate');


	Route::group(['prefix'=>'ajax'], function (){
		Route::post('withdraw', 'System\AjaxController@PostWithdraw')->name('system.ajax.PostWithdraw');
		Route::post('confirm-withdraw', 'System\AjaxController@postConfirmWithdraw')->name('system.ajax.postConfirmWithdraw');
		Route::post('transfer', 'System\AjaxController@PostTransfer')->name('system.ajax.PostTransfer');
		Route::post('confirm-transfer', 'System\AjaxController@postConfirmTransfer')->name('system.ajax.postConfirmTransfer');
		Route::post('exchange', 'System\AjaxController@PostExchange')->name('system.ajax.PostExchange');
		Route::post('member-add', 'System\AjaxController@PostMemberAdd')->name('system.ajax.PostMemberAdd');
		Route::get('get-xu/{user}', 'System\AjaxController@getXu')->name('system.ajax.getXu');
		Route::get('get-history', 'System\AjaxController@getHitory')->name('system.ajax.getHitory');
		Route::get('check-my-bet', 'System\AjaxController@getMyBet')->name('system.ajax.getMyBet');

		Route::get('ajax-user', 'System\UserController@getAjaxUser')->name('system.getAjaxUser');
        Route::get('ajax-sale-user', 'System\UserController@getAjaxSaleUser')->name('system.getAjaxSaleUser');
	});
	Route::group(['prefix'=>'game'], function (){
		Route::get('history', 'System\GameController@getHistory')->name('system.game.getHistory');

	});

	Route::group(['prefix'=>'admin'], function (){

		//Deposit
		Route::get('find-wallet', 'System\AdminController@getFindWallet1')->name('system.admin.getFindWallet1');
		Route::get('deposit', 'System\AdminController@getDeposit')->name('system.admin.getDeposit');
		Route::post('deposit', 'System\AdminController@postDeposit')->name('system.admin.postDeposit');
		Route::post('invest', 'System\AdminController@postInvestAdmin')->name('system.admin.postInvestAdmin');
		// End Deposit

		Route::get('member', 'System\AdminController@getMember')->name('system.admin.getMember');
		Route::get('login/{id}', 'System\AdminController@getLoginByID')->name('system.admin.getLoginByID');
        Route::get('active-mail/{id}', 'System\AdminController@getActiveMail')->name('system.admin.getActiveMail');
        Route::post('edit-mail', 'System\AdminController@getEditMailByID')->name('system.admin.getEditMailByID');
        Route::get('disable-auth/{id}', 'System\AdminController@getDisableAuth')->name('system.admin.getDisableAuth');

        Route::get('update-ito/{id}', 'System\AdminController@getUpdateITO')->name('system.admin.getUpdateITO');

		Route::get('wallet', 'System\AdminController@getWallet')->name('system.admin.getWallet');
		Route::get('investment', 'System\AdminController@getInvestment')->name('system.admin.getInvestment');
		Route::get('withdraw', 'System\AdminController@getWithdraw')->name('system.admin.getWithdraw');
		Route::get('profile', 'System\AdminController@getProfile')->name('system.admin.getProfile');
        Route::post('confirm-profile', 'System\AdminController@confirmProfile')->name('system.admin.confirmProfile');


		Route::group(['prefix' => 'ticket'], function () {
			Route::get('/', 'System\TicketController@getTicket')->name('Ticket');
			Route::post('post-ticket', 'System\TicketController@postTicket')->name('postTicket');
			Route::get('destroy-ticket/{id}', 'System\TicketController@destroyTicket')->name('destroyTicket');
			Route::get('get-ticket-detail/{id}', 'System\TicketController@getTicketDetail')->name('getTicketDetail');
			Route::get('ticket-admin', 'System\TicketController@getTicketAdmin')->name('getTicketAdmin');
			Route::get('update-status/{id}', 'System\TicketController@getStatusTicketAdmin')->name('getStatusTicketAdmin');
		});
		Route::get('percent', 'System\AdminController@getPercent')->name('system.admin.getPercent');
		Route::post('percent', 'System\AdminController@postChangePercent')->name('system.admin.postChangePercent');
		Route::get('price', 'System\AdminController@getPriceToken')->name('system.admin.getPriceToken');
		Route::post('price', 'System\AdminController@postPriceToken')->name('system.admin.postPriceToken');
		Route::post('add-price', 'System\AdminController@postAddPriceToken')->name('system.admin.postAddPriceToken');
		Route::get('wallet/detail/{id}', 'System\AdminController@getWalletDetail')->name('system.admin.getWalletDetail');
		Route::get('json-statistical', 'System\AdminController@getJsonStatistical')->name('system.admin.getJsonStatistical');
		Route::get('detail/{id}', 'System\UserController@getMemberDetail')->name('system.admin.getMemberDetail');
		Route::get('history-game/{id}', 'System\AdminController@getHistoryGame')->name('system.admin.getHistoryGame');
		Route::get('statistical', 'System\AdminController@getStatistical')->name('system.admin.getStatistical');

		Route::post('deposit', 'System\AdminController@postDepositAdmin')->name('system.admin.postDepositAdmin');
		//Log Mail
        Route::get('log-mail', 'System\AdminController@getLogMail')->name('system.admin.getLogMail');
        
        
		//treo thong bao
		Route::get('notification', 'System\NotificationImageController@getNotificationImage')->name('system.admin.getNotificationImage');
		Route::post('up-notification', 'System\NotificationImageController@postImage')->name('system.admin.postImage');
		Route::get('hidden-notification/{id}', 'System\NotificationImageController@getHideNoti')->name('system.admin.getHideNoti');
		Route::get('delete-notification/{id}', 'System\NotificationImageController@getDeleteNoti')->name('system.admin.getDeleteNoti');
	});

});

Route::group(['prefix'=>'cron'], function (){
	

	Route::get('investment-RBD', 'System\CronController@checkInvestmentDPA')->name('cron.checkInvestmentDPA');
	Route::get('investment-ETH', 'System\CronController@checkInvestmentETH')->name('cron.checkInvestmentETH');
	Route::get('interest', 'System\CronController@getProfits')->name('cron.getProfits');

	
	Route::get('deposit', 'Cron\CronController@getDeposit')->name('cron.getDeposit');
	Route::get('deposit-trx', 'Cron\CronController@getDepositTRX')->name('cron.getDepositTRX');
	Route::get('deposit-btc', 'Cron\CronController@getDepositBTC')->name('cron.getDepositBTC');
	Route::get('deposit-eth', 'Cron\CronController@getDepositETH')->name('cron.getDepositETH');

	Route::get('check-transaction', 'Cron\CronController@getTransaction')->name('cron.getTransaction');
	
});
// API rate RBD
Route::get('rate-token', 'System\CoinbaseController@getRateToken')->name('json.ratetoken');