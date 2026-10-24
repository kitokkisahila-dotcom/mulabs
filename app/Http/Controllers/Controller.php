<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;

abstract class Controller
{
    public function checklogin(){
        if(!Auth::check()){

        
            return redirect()->route('home')->send();
            exit;
        }
    }

    protected function redirectAfterRegistration(Request $request, string $message)
    {
        $returnTo = $request->input('return_to');

        if (is_string($returnTo) && parse_url($returnTo, PHP_URL_HOST) === $request->getHost()) {
            return redirect()->back()
                ->with('success', $message)
                ->with('return_to', $returnTo);
        }

        return redirect()->back()->with('success', $message);
    }


}
