<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $fiveWeeks, $client, $extraProducts, $dinnerProducts;

    /**
     * Logout user
     * @return home page
     */
    public function doLogout()
    {
        if (Auth::check()) {
            Auth::logout(); // log the user out of our application
        }
        return redirect(''); // redirect the user to the login screen
    }

    /**
     * Examine user credentials and redirect user
     * @return login | dashboard
     */
    public function doLogin()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'email' => 'required|email',            // email only allowed
            'password' => 'required|alphaNum|min:5',    // only alphanumeric and at least 3 chars
        );

        $messages = [
            'password.required' => 'Ni har glömt att fylla i ett lösenord.',
            'email.required' => 'Ni har glömt att fylla i er e-post.',
            'password.min' => 'Lösenordet måste vara minst 5 bokstäver långt.',
            'password.alpha_num' => 'Lösenordet får endast innehålla bokstäver och siffror',
            'emailConfirm.required' => 'Ni har glömt att fylla i er e-post.'
        ];


        // run the validator rules on the input from the form
        $validator = Validator::make(Request::all(), $rules, $messages);

        // if validator fails, redirect to the form
        if ($validator->fails()) {
            Request::flash();
            return redirect('/logga-in')
                ->withErrors($validator);
        } else {
            // attempt to do the login
            if (Auth::attempt(['email' => Request::input('email'), 'password' => Request::input('password')])) {
                $admin = Auth::user()->role;

                if ($admin == 'Administrator') {
                    return redirect('/dashboard');
                } else {
                    return redirect('/mina-sidor');
                }
            } else {
                // If validation failed then display errors
                return redirect('/logga-in')
                    ->withErrors("Kontrollera att e-postadressen eller lösenordet stämmer");
            }
        }
    }
}
