<?php

namespace App\Http\Controllers;
use Session;
/* It's a controller that handles the logout process. */
class ControladorWebLogout extends Controller
{
    /**
     * It puts an empty string in the session variable "idcliente" and then redirects to the root of
     * the website
     */
    public function logout()
    {
        Session::put("idcliente", "");
        return redirect("/");
    }
}
