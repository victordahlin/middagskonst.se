<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DateTime;
use Request;

class ProfileController extends Controller
{
    private $fiveWeeks, $tenWeeks, $client, $extraProducts, $dinnerProducts, $alternativeProducts;

    /**
     * Default constructor
     */
    public function __construct()
    {
        // $this->client = \App\BudbeeOrders::getClient();

        // // Receive five weeks
        // $this->fiveWeeks = \App\BudbeeOrders::getXWeeks($this->client, 10);
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
        if (true) {
            // if (Auth::check()) {
            // $user = \App\User::find(Auth::id());
            $user = \App\User::find(1);
            $today = new DateTime();
            $dayFormat = $today->format('Y-m-d');
            $weeks = array(
                $dayFormat,
                date('Y-m-d', strtotime($dayFormat . ' + 5 days')),
                date('Y-m-d', strtotime($dayFormat . ' + 10 days')),
                date('Y-m-d', strtotime($dayFormat . ' + 15 days')),
                date('Y-m-d', strtotime($dayFormat . ' + 20 days')),
            );
            // $weeks = \App\BudbeeOrders::getXWeeksFromStartDate($this->fiveWeeks, $user->startDate);
            $alternativeBags = \App\Products::getAlternativeBags();
            $skip = $user->skipDate;

            if (!$user->active) {
                $skip = ['No', 'No', 'No', 'No', 'No'];
            } else {

                if (strcmp($user->interval, "everySecondWeek") == 0) {
                    // $weeks = \App\BudbeeOrders::getEveryOtherWeekFromStartDate($this->client, $user->startDate);
                }

                $skip = \App\User::profileSkipDates($skip, $weeks);
            }

            // Convert date to week numbers
            $weekNumbers = [];
            foreach ($weeks as $week) {
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
                'skipWeeks' => array(),
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
                'telephoneNumber' => $user->telephoneNumber
            );

            // Get current date
            $timeDate = \App\User::getTime();
            $days = abs(\App\User::getCurrentDay($weeks));

            if ($days <= 3 || $days == 4 && $timeDate >= "21:00") {
                // Only display error if user de-activate JS
                $error = '';
                if (Request::input('displayPHPerror') == true) {
                    $error = 'Din order är nu på väg och kan ej avbeställas';
                }


                /**
                 * delivery.blade.php
                 * 
                 * Days to be skipped
                 * 
                 * <td><input type="checkbox" name="weeks[]" 
                 * value="{{ $data['fiveWeeks'][$i] }}" 
                 * class="col-md-3 skipDate" @if($data['skipWeeks'][$i] !="No" ) checked @endif></td>
                 */

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
        // var_dump(Request::all());

        // $user = \App\User::find(Auth::id());
        $user = \App\User::find(1);
        $email = Request::input('email');
        $street = Request::input('street');
        $postalCode = Request::input('postalCode');
        $city = Request::input('city');
        $telephoneNumber = Request::input('telephoneNumber');
        $dinnerProduct = Request::input('dinnerProduct');
        $dinnerProductAlternative = Request::input('dinnerProductAlternative');
        $subscription = Request::input('subscription');
        $weeks = Request::input('weeks');

        // Update user fields in the database
        if (!empty($user_email)) {
            $user->email = $email;
        }

        if (!empty($street)) {
            $user->street = $street;
        }

        if (!empty($postalCode)) {
            $isPostalRight = "123456";
            // $isPostalRight = \App\BudbeeOrders::checkPostalCode();

            if ($isPostalRight) {
                $user->postalCode = $postalCode;
            }
        }

        if (!empty($city)) {
            $user->city = $city;
            // $isCityRight = \App\BudbeeOrders::checkCity();

            // if($isCityRight){
            //     $user->city = $city;
            // }
        }

        // Phone number must be at least 10 digits
        if (!empty($telephoneNumber)) {
            if (strlen($telephoneNumber) > 10) {
                $user->telephoneNumber = $telephoneNumber;
            }
        }

        // Customer allowed to change bags between wed until sun before 21
        $jd = cal_to_jd(CAL_GREGORIAN, date("m"), date("d"), date("Y"));
        $day = (jddayofweek($jd, 1));
        $days_of_week = date('N', strtotime($day));
        $timeIsValid = false;

        if (time() < strtotime("21:00:00")) {
            $timeIsValid = true;
        }

        if ($days_of_week > 2 && $days_of_week < 8 || ($days_of_week == 7 && $timeIsValid)) {
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
        if ($user->active) {
            if (count($weeks) > 0) {
                $user->skipDate = implode(', ', $weeks);
            } else {
                $user->skipDate = '';
            }
        }

        // Handle if user account should be active or not
        if (strcmp($subscription, "off") == 0) {
            $user->active = false;
            $user->interval = $subscription;
        }

        if (strcmp($subscription, "eachWeek") == 0 || strcmp($subscription, "everySecondWeek") == 0) {
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
        // $user = \App\User::find(Auth::id());
        $user = \App\User::find(1);

        $product = \App\Products::find($user->dinnerProduct);

        // Display current bags and if user want any of the alternative
        // show them instead in the page addons
        if (!empty($user->dinnerProductAlternative)) {
            $product = \App\Products::find($user->dinnerProductAlternative);
        }

        return view('page.addons')
            ->with('extraProducts', $this->extraProducts)
            ->with('dinnerProduct', $product);
    }
}
