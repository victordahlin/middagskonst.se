<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private $fiveWeeks, $client, $extraProducts, $dinnerProducts, $option;

    /**
     * Default constructor and init variables.
     */
    public function __construct()
    {
        $this->client = \App\BudbeeOrders::getClient();

        // Receive 6 weeks and if date lower
        $this->fiveWeeks = \App\BudbeeOrders::getXWeeks($this->client, 10);

        // Receive products from DB
        $this->extraProducts = \App\Products::getExtra();
        $this->dinnerProducts = \App\Products::getDinners();
    }

    /**
     * Receive products from DB and send array to the view
     * @return customer | which-bag
     */
    public function customerInformation()
    {
        $this->option = Request::input('option');


        if(!is_null($this->option))
        {
            $texts = \App\HowItWorks::all();

            $data = array(
                'dinnerProduct' => $this->dinnerProducts[$this->option],
                'dinnerProductPrice' => $this->dinnerProducts[$this->option]->price,
                'fiveWeeks' => $this->fiveWeeks,
                'extra'	=> $this->extraProducts
            );
            return view('page.customer')
                ->with('data', $data)
                ->with('texts', $texts);
        }
        else
        {
            return view('page.which-bag');
        }
    }

    /**
     * Receive all user input and examine if
     * all fields are correct
     * @return customer
     */
    public function validateForm()
    {
        $id = strip_tags(Request::input('dinnerProduct'));

        if(!is_null($id))
        {
            $currentDinner = \App\Products::getProduct($id);

            $data = array(
                'dinnerProduct' => $currentDinner,
                'dinnerProductPrice' => $currentDinner->price,
                'fiveWeeks' => $this->fiveWeeks
            );

            $email = strip_tags(Request::input('email'));
            $emailConfirm = strip_tags(Request::input('emailConfirm'));
            $password = strip_tags(Request::input('password'));
            $passwordConfirm = strip_tags(Request::input('passwordConfirm'));
            $texts = \App\HowItWorks::all();

            if(strcmp($email, $emailConfirm) != 0)
            {
                Request::flash();
                return view('page.customer')
                    ->with('data', $data)
                    ->with('texts', $texts)
                    ->withErrors('E-post addresserna stämmer inte med varandra.');
            }
            else if(strcmp($password, $passwordConfirm) != 0)
            {
                Request::flash();
                return view('page.customer')
                    ->with('data', $data)
                    ->with('texts', $texts)
                    ->withErrors('Lösenorden stämmer inte med varandra.');
            }
            else
            {
                //  Examine user credentials from form
                $validator = Validator::make(Request::all(), \App\User::$rules, \App\User::$messages);

                // Redirect to form with errors
                if($validator->fails())
                {
                    Request::flash();
                    return view('page.customer')
                        ->with('data', $data)
                        ->with('texts', $texts)
                        ->withErrors($validator);
                }
                // Everything is OK
                else
                {
                    // Verify postal code and city
                    $responseCity = \App\BudbeeOrders::checkCity();

                    if($responseCity === false){
                        Request::flash();
                        return view('page.customer')
                            ->with('data', $data)
                            ->with('texts', $texts)
                            ->withErrors('Tyvärr kan vi inte ännu leverera till den givna orten, men vi utökar ständigt våra leveransområden. Kontakta oss så ska vi se om vi kan hitta en lösning för er.');
                    }

                    $response = \App\BudbeeOrders::checkPostalCode();
                    if($response === false){
                        Request::flash();
                        return view('page.customer')
                            ->with('data', $data)
                            ->with('texts', $texts)
                            ->withErrors('Tyvärr kan vi inte ännu leverera till den givna postadressen, men vi utökar ständigt
                        våra leveransområden. Kontakta oss så ska vi se om vi kan hitta en lösning för er.');
                    }

                    return $this->createUser();
                }
            }
        }
    }

    /**
     * Create user and pass data to user model
     * and db. Then store user id and products in session.
     * @return kassa
     */
    public function createUser()
    {
        $user = \App\User::createUser(Request::all());

        $path = str_replace('laravel_files', '', base_path()).'invoice/'; // Remove name 'laravel_files' from public link

        // Create path if it not exists
        if (!file_exists($path.$user->id)) {
            mkdir($path.$user->id, 0777, true);
        }

        session(['u' => $user->id]);

        return redirect('bli-kund/betala');
    }

    /**
     * Check if user want to buy any products
     * then continue to summary page otherwise
     * return back with error message
     * @return $this
     */
    public function getSummary()
    {
        if(Auth::user()->interval != 'off'){
            $extraProductInput = Request::input('extra');
            $currentBagAmount = (int)strip_tags(Request::input('currentBagAmount'));
            $totalExtraProducts = 0;
            $currentBag = strip_tags(Request::input('currentBag'));

            // Maximum amount of extra products
            if((int)$currentBagAmount>5 || (int)$extraProductInput[0]>5 || (int)$extraProductInput[1]>5 ||(int)$extraProductInput[1]>5){
                return redirect()->to('tillaggsprodukter')
                    ->withErrors('Du får beställa högst 5 st tilläggsprodukter.');
            }

            // Get amount of selected extra products
            foreach($extraProductInput as $extra){
                if($extra != 0){
                    $totalExtraProducts+=$extra;
                }
            }

            // Get selected bag from DB
            $dinnerProduct = \App\Products::find($currentBag);

            if($totalExtraProducts < 1 && $currentBagAmount < 1){
                return redirect()->to('tillaggsprodukter')
                    ->withErrors('Du har inte valt några produkter ännu.');
            } else {
                return view('addons.summary')
                    ->with('data', Request::all())
                    ->with('extraProductsDB', $this->extraProducts)
                    ->with('dinnerProductDB', $dinnerProduct);
            }
            // User is inactive
        } else {
            return redirect()->to('tillaggsprodukter')
                ->withErrors('Du kan inte beställa några tilläggsprodukter eftersom din prenumeration är pausad.');
        }
    }
}
