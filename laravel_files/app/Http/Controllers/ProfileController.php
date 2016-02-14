<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;

class ProfileController extends Controller
{
    private $fiveWeeks, $tenWeeks, $client, $extraProducts, $dinnerProducts, $alternativeProducts;

    /**
     * Default constructor
     */
    public function __construct()
    {
        $this->client = \App\BudbeeOrders::getClient();

        // Receive five weeks
        $this->fiveWeeks = \App\BudbeeOrders::getXWeeks($this->client, 10);
        $this->extraProducts = \App\Products::getExtra();
        $this->dinnerProducts = \App\Products::getDinners();
        $this->alternativeProducts = \App\Products::getAlternativeBags();
    }

    /**
     * Redirect user to their page otherwise dashboard
     * Display the specified resources
     * @param  int $id
     * @return Response
     */
    public function show()
    {
        if (Auth::check()) {
            $user = \App\User::find(Auth::id());
            $weeks = \App\BudbeeOrders::getXWeeksFromStartDate($this->fiveWeeks, $user->startDate);
            $alternativeBags = \App\Products::getAlternativeBags();
            $skip = $user->skipDate;

            if(!$user->active){
                $skip = ['No', 'No', 'No', 'No', 'No'];
            } else {

                if(strcmp($user->interval, "everySecondWeek")==0){
                    $weeks = \App\BudbeeOrders::getEveryOtherWeekFromStartDate($this->client, $user->startDate);
                }

                $skip = \App\User::profileSkipDates($skip, $weeks);
            }

            // Convert date to week numbers
            $weekNumbers = [];
            foreach($weeks as $week){
                $dateToWeek = new DateTime($week);
                $dateToWeek = $dateToWeek->format('W');
                array_push($weekNumbers, $dateToWeek);
            }
            $data = array(
                'id' => $user->id,
                'dinnerProduct' => $user->dinnerProduct,
                'dinnerProductsDB' => $this->dinnerProducts,
                'dinnerProductAlternativeDB' => $this->alternativeProducts,
                'dinnerProductAlternative' => $user->dinnerProductAlternative,
                'interval' => $user->interval,
                'skipWeeks' => $skip,
                'fiveWeeks' => $weeks,
                'weekNumbers' => $weekNumbers,
                'files' => \App\User::getPDF($user),
                'name' => $user->name,
                'email' => $user->email,
                'city' => $user->city,
                'street' => $user->street,
                'postalCode' => $user->postalCode,
                'startDate' => $user->startDate,
                'isActive' => $user->active,
                'telephoneNumber' => $user->telephoneNumber);

            // Get current date
            $timeDate = \App\User::getTime();
            $days = abs(\App\User::getCurrentDay($weeks));

            if ($days <= 3 || $days == 4 && $timeDate >= "21:00") {
                // Only display error if user de-activate JS
                $error = '';
                if (Input::get('displayPHPerror') == true) {
                    $error = 'Din order är nu på väg och kan ej avbeställas';
                }
                return view('page.profile')
                    ->with('data', $data)
                    ->with('alternativeBags', $alternativeBags)
                    ->withErrors($error);
            } else {
                return view('page.profile')
                    ->with('data', $data)
                   ->with('alternativeBags', $alternativeBags);
            }
        } // User need to login with credentials
        else {
            return redirect('logga-in');
        }
    }

    /**
     * Get POST data from user in profile and
     * update with received POST fields
     * @return Response
     */
    public function updateProfile()
    {
        var_dump(Input::all());

        $user = \App\User::find(Auth::id());
        $email = Input::get('email');
        $street = Input::get('street');
        $postalCode = Input::get('postalCode');
        $city = Input::get('city');
        $telephoneNumber = Input::get('telephoneNumber');
        $dinnerProduct = Input::get('dinnerProduct');
        $dinnerProductAlternative = Input::get('dinnerProductAlternative');
        $subscription = Input::get('subscription');
        $weeks = Input::get('weeks');

        // Update user fields in the database
        if (!empty($user_email)) {
            $user->email = $email;
        }

        if (!empty($street)) {
            $user->street = $street;
        }

        if (!empty($postalCode)) {
            $isPostalRight = \App\BudbeeOrders::checkPostalCode();

            if($isPostalRight){
                $user->postalCode = $postalCode;
            }
        }

        if (!empty($city)) {
            $user->city = $city;
            $isCityRight = \App\BudbeeOrders::checkCity();

            if($isCityRight){
                $user->city = $city;
            }
        }

        // Phone number must be at least 10 digits
        if (!empty($telephoneNumber)) {
            if(strlen($telephoneNumber)>10){
                $user->telephoneNumber = $telephoneNumber;
            }
        }

        // Customer allowed to change bags between wed until sun before 21
        $jd=cal_to_jd(CAL_GREGORIAN,date("m"),date("d"),date("Y"));
        $day = (jddayofweek($jd,1));
        $days_of_week = date('N', strtotime($day));
        $timeIsValid = false;

        if(time()<strtotime("21:00:00")){
          $timeIsValid = true;
        }

        if($days_of_week > 2 && $days_of_week < 8 || ($days_of_week == 7 && $timeIsValid)) {
          if (!empty($dinnerProduct)) {
              $currentProduct = \App\Products::find($dinnerProduct);

              $user->dinnerProduct = $dinnerProduct;
              $user->dinnerProductPrice =  $currentProduct->price;
          }

          if (!empty($dinnerProductAlternative)) {
              $currentProduct = \App\Products::find($dinnerProductAlternative);

              $user->dinnerProductAlternative = $dinnerProductAlternative;
              $user->dinnerProductAlternativePrice = $currentProduct->price;
          } else {
              $user->dinnerProductAlternative = 0;
              $user->dinnerProductAlternativePrice = 0;
          }
        }

        // Update skip dates
        if($user->active){
            if(count($weeks)>0){
                $user->skipDate = implode(', ', $weeks);
            } else  {
                $user->skipDate = '';
            }
        }

        // Handle if user account should be active or not
        if(strcmp($subscription, "off")==0){
            $user->active = false;
            $user->interval = $subscription;
        }

        if(strcmp($subscription, "eachWeek")==0 || strcmp($subscription, "everySecondWeek")==0){
            $user->active = true;
            $user->interval = $subscription;
        }
        $user->save();

        return $this->show();
    }

    /**
     * Display products on the view
     * @return mixed
     */
    public function getProducts()
    {
        $user = \App\User::find(Auth::id());

        $product = \App\Products::find($user->dinnerProduct);

        // Display current bags and if user want any of the alternative
        // show them instead in the page addons
        if(!empty($user->dinnerProductAlternative)){
            $product = \App\Products::find($user->dinnerProductAlternative);
        }

        return view('page.addons')
            ->with('extraProducts', $this->extraProducts)
            ->with('dinnerProduct', $product);
    }
}
