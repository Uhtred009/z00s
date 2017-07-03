<?php

namespace Olymbytes\Z00s\Http\Controllers;

use Illuminate\Http\Request;
use Olymbytes\Z00s\Auth\LoginProxy;
use Olymbytes\Z00s\Http\Requests\LoginRequest;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
	public $loginProxy;

	public function __construct(LoginProxy $loginProxy)
	{
		$this->loginProxy = $loginProxy;
	}

    public function login(LoginRequest $request)
    {
    	return $this->loginProxy->attemptLogin($request->email, $request->password);
    }

    public function logout()
    {
        return $this->loginProxy->attemptLogout();
    }

    public function refresh(Request $request)
    {
    	return $this->loginProxy->attemptRefresh($request->refresh_token);
    }
}
