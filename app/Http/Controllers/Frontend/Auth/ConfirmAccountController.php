<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Frontend\Auth\UserRepository;

/**
 * Class ConfirmAccountController.
 */
class ConfirmAccountController extends Controller
{
	/**
	 * @var UserRepository
	 */
	protected $user;

	/**
	 * ConfirmAccountController constructor.
	 *
	 * @param UserRepository $user
	 */
	public function __construct(UserRepository $user)
	{
		$this->user = $user;
	}

	/**
	 * @param $token
	 *
	 * @return mixed
	 */
	public function confirm($token)
	{
		$this->user->confirm($token);

		return redirect()->route('frontend.auth.login')->withFlashSuccess(__('exceptions.frontend.auth.confirmation.success'));
	}

	/**
	 * @param $user
	 *
	 * @return mixed
	 */
	public function sendConfirmationEmail(User $user)
	{
		$user->notify(new UserNeedsConfirmation($user->confirmation_code));

		return redirect()->route('frontend.auth.login')->withFlashSuccess(__('exceptions.frontend.auth.confirmation.resent'));
	}
}
