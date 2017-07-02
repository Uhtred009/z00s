<?php

namespace Olymbytes\Z00s\Http\Controllers;

use Illuminate\Http\Request;
use Olymbytes\Z00s\LoginProxy;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Olymbytes\Z00s\Http\Requests\LoginRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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



<?php

namespace IsaTrack\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
