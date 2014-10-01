<?php

class AuthenticationController extends \BaseController {

	/**
	 * Variabel untuk menyimpan lokasi dari authenticaation view
	 * @var string
	 */
	private $authView = 'authentication';

	public function getLogin()
	{
		// Melakukan check apakah telah login atau belum.
		// Jika belum login maka menampilkan halaman login.
		// Jika sudah maka redirect ke home
		if (! Sentry::check() ) {
			
			return View::make($this->authView.'.login');

		} else {

			// Redirect to home if authentication successfull
			return Redirect::to('/');
		}
	}

	public function postLogin()
	{
		// Declare the rules for the form validation
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:7',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// Try to log the user in
			Sentry::authenticate(Input::only('email', 'password'), Input::get('remember-me', 0));

			// Get the page we were before
			$redirect = Session::get('loginRedirect', 'account');

			// Unset the page we were before from the session
			Session::forget('loginRedirect');

			// Redirect to the users page
			return Redirect::to($redirect)->with('success', Lang::get('auth/message.signin.success'));
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$this->messageBag->add('email', Lang::get('auth/message.account_not_found'));
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			$this->messageBag->add('email', Lang::get('auth/message.account_not_activated'));
		}
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			$this->messageBag->add('email', Lang::get('auth/message.account_suspended'));
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			$this->messageBag->add('email', Lang::get('auth/message.account_banned'));
		}

		// Ooops.. something went wrong
		return Redirect::back()->withInput()->withErrors($this->messageBag);
	}

	public function getRegister()
	{
		return View::make($this->authView.'.register');
		/*try 
		{
			Sentry::createUser([
				'email'=>'akungbgl@gmail.com',
				'password'=>'plokijuh',
				'activated'=>true
			]);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			return 'User with this login already exists.';
		}*/
	}

	public function postRegister()
	{
		$validator = Validator::make( [
			'email'				=> Input::get('email'),
			'password'			=> Input::get('sandi'),
			'password-confirm'	=> Input::get('sandi-konfirmasi')
		], [
			'email'				=> 'required|email|',
			'password'			=> 'required|min:7',
			'password-confirm'	=> 'required|min:7|same:password'
		]);

		if ($validator->fails()) {
			# fail code here
			$messages = $validator->messages();
			return $messages;
		}

		// Jika validation berhasil maka langsung ke blok try exception berikut
		try {
			
			$user = Sentry::register(array(
				'email' 	=> Input::get('email'),
				'password'  => Input::get('sandi')
			));

			$activationCode = $user->getActivationCode();

			Mail::send('emails.auth.register', [
				'activationURI'	=> URL::route('auth.activate', $activationCode)
			], 
			function ($message) use ($user)
			{
				$message->to( $user->email );
				$message->subject( 'Welcome to Ranting Waktu' );
			});

		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			return 'User with this login already exists.';
		}
	}

	public function getActivate($activationCode)
	{
		//return View::make('auth.activate');
		if (Sentry::check()) {
			# Jika user login maka halaman ini tidak bisa dipakai
			return Redirect::route('home');
		}

		try {
			
			$user = Sentry::getUserProvider()->findByActivationCode( $activationCode );

			if ($user->attemptActivation( $activationCode ))
			{
				Mail::send('emails.'.$this->authView.'.activated', [], function ($message) use ($user)
				{
					$message->to( $user->email );
					$message->subject( 'Aktifasi akun Anda berhasil' );
				});

				return View::make($this->authView.'.login');
			}
			else
			{
				// User activation failed
				return "activation fail";
			}
		} 
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    return 'User was not found.';
		}
		catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
		{
		    return 'User is already activated.';
		}
	}

	// Halaman ini digunakan untuk menampilkan form forgot password
	// yang dimana user harus mengisi email dan menekan tombol submit
	public function getForgot()
	{
		if (Sentry::check()) {
			return Redirect::route('home');
		}


		return View::make($this->authView.'.forgot');
	}

	// Fungsi ini adalah kelanjutan dari fungsi getForgot()
	// Fungsi ini akan memproses email yang diinput
	// dan mengirimkan kode reset ke email tadi
	public function postForgot()
	{
		$validator = Validator::make([
			'email' => Input::get('email')
		], [
			'email' => 'required|email'
		]);

		if ($validator->fails()) {
			return Redirect::route('home');
		}

		try {
			$user = Sentry::getUserProvider()->findByLogin(Input::get('email'));

			Mail::send('emails.'.$this->authView.'.forgot_code', [
				'resetCodeURI'	=> URL::route('auth.forgot.confirm', $user->getResetPasswordCode() )
			], 
			function ($message) use ($user)
			{
				$message->to( $user->email );
				$message->subject( 'Welcome to Ranting Waktu' );
			});

		} catch (Exception $e) {
			
		}
	}

	// fungsi ini memproses link reset code
	// dan menampilkan form untuk mengisi password baru
	public function getForgotConfirm($resetCode)
	{

		if (Sentry::check()) {
			return Redirect::route('home');
		}

		try {
			
			$user = Sentry::getUserProvider()->findByResetPasswordCode($resetCode);			
		
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
		
			return "User not found";
		}

		return View::make($this->authView.'.forgot_confirm')->with('resetCode', $resetCode);
	}

	// fungsi ini kelanjutan dari fungsi getForgotConfirm()
	// dimana password baru yang dimasukkan user akan disimpan
	public function postForgotConfirm($resetCode)
	{
		$validator = Validator::make([
			'password'			=> Input::get('sandi'),
			'password-confirm' 	=> Input::get('sandi-konfirmasi')
		], [
			'password'			=> 'required|min:7',
			'password-confirm'	=> 'required|min:7|same:password'
		]);

		if ($validator->fails()) {

			$messages = $validator->messages();
			return $messages;
		}

		try {
			
			$user = Sentry::getUserProvider()->findByResetPasswordCode( $resetCode );

			if ($user->attemptResetPassword($resetCode, Input::get('sandi')) ) {
				return "success ganti password";
			} else {
				return "Gagal ganti password";
			}
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
			return "Account not found";
		}
	}

	public function getLogout()
	{
		Sentry::logout();
	}
}