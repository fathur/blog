<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		try
		{
			// Empty table
			User::truncate();

			// Create the user
			$user = Sentry::createUser(array(
				'email'     => 'admin@rantingwaktu.org',
				'password'  => 'administrator',
				
				'activated' => true,
			));
				
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
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			return 'Group was not found.';
		}
	}


}