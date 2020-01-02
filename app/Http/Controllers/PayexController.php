<?php 

namespace App\Http\Controllers;

use SoapClient;
use SoapFault;
use SimpleXMLElement;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayexController extends Controller
{
    private $accountNumber, $purchaseOperation, $price, $currency, $vat, $orderID,
        $productNumber, $description, $externalID, $returnUrl, $agreementRef, $cancelUrl,
        $PxAgreement, $priceArgList, $client;

    /**
     * Default constructor and intilize
     * http://middagskonst.se/
     */
    public function __construct()
    {
        date_default_timezone_set('Europe/Stockholm');

        // Account information
        $merchantAccountDev = '60087318';
        $merchantAccount = '73158877';

        // WSDL Files
        $WSDL_ORDER_TEST = 'https://test-external.payex.com/pxorder/pxorder.asmx?WSDL';
        $WSDL_AGREEMENT_TEST = 'https://test-external.payex.com/pxagreement/pxagreement.asmx?WSDL';

        $WSDL_ORDER = 'https://external.payex.com/pxorder/pxorder.asmx?WSDL';
        $WSDL_AGREEMENT = 'https://external.payex.com/pxagreement/pxagreement.asmx?WSDL';

        $this->accountNumber = $merchantAccount; // Merchant account number
        $this->purchaseOperation = 'SALE'; // AUTHORIZATION or SALE
        $this->price = 200; // Product price, in lowest monetary unit = 2 SEK
        $this->currency = 'SEK';
        $this->vat = 1200; // VAT
        $this->orderID = ''; // Local order id
        $this->productNumber = ''; // Local product number
        $this->description = ''; // Product description
        $this->externalID = '';
        $this->returnUrl = 'https://middagskonst.se/bli-kund/complete'; // ReturnURL
        $this->agreementRef = '';
        $this->cancelUrl = 'https://middagskonst.se';
        $this->additionalValues = 'RESPONSIVE=1';
        $this->PxOrderWSDL = $WSDL_ORDER;
        $this->PxAgreement = $WSDL_AGREEMENT;
        $this->clientLanguage = 'sv-SE';
        $this->view = 'CC'; // Payment method PayEx
        $this->priceArgList = '';

        $this->client = \App\BudbeeOrders::getClient();
    }

    /**
     * Receive user and create agreement for user
     * with max amount
     * @return mixed
     */
    public function createAgreement3()
    {
        $id = session('u');

        if (!empty($id)) {
            $PayEx = new SoapClient($this->PxAgreement, array("trace" => 1, "exceptions" => 0));

            $user = \App\User::find($id);

            // Create order for user
            $this->orderID = \App\Order::createOrder($user->id);

            // Set description with product
            $dinnerProduct = \App\Products::getProduct($user->dinnerProduct);
            $this->description = $dinnerProduct->title . ' - ' . $user->name;

            $params = [
                'accountNumber' => $this->accountNumber,
                'merchantRef' => $user->name,
                'description' => 'Middagskonst ' . $user->name,
                'purchaseOperation' => $this->purchaseOperation,
                'maxAmount' => '5000000',    // 50 000 SEK
                'notifyUrl' => '',
                'startDate' => '',
                'stopDate' => ''
            ];

            //create the hash and append the hash to the parameters
            $hash = \App\Order::createHash($params);
            $params['hash'] = $hash;

            // Create XML element and parse agreementRef
            try {
                $response = $PayEx->CreateAgreement3($params);
                $returnXml = new SimpleXMLElement($response->{'CreateAgreement3Result'});
                $this->agreementRef = (string)$returnXml->agreementRef;
                $this->productNumber = $user->dinnerProduct;

                // Update users with agreementRef
                $user->payexID = $this->agreementRef;

                // Update user order with agreementRef
                \App\Order::updateOrder($this->orderID, '', '', $this->agreementRef);

                return $this->initialize();

            } catch (SoapFault $error) {
                echo 'Du kan inte skapa ett nytt konto eftersom:' . '<br>';
                echo "Error: {$error->faultstring}";
            }
        } else {
            echo 'Du har inte skapat en användare och kan därför inte göra ett köp.';
            //return redirect('vilken-matkasse');
        }
    }

    /**
     * TwoPhaseTransaction
     * @return mixed
     */
    function initialize()
    {
        $clientIPAddress = $_SERVER['REMOTE_ADDR'];
        $clientIdentifier = "USERAGENT=" . $_SERVER['HTTP_USER_AGENT'];

        $params = array(
            'accountNumber' => $this->accountNumber,
            'purchaseOperation' => $this->purchaseOperation,
            'price' => $this->price,
            'priceArgList' => $this->priceArgList,
            'currency' => $this->currency,
            'vat' => $this->vat,
            'orderID' => $this->orderID,
            'productNumber' => $this->productNumber,
            'description' => $this->description,
            'clientIPAddress' => $clientIPAddress,
            'clientIdentifier' => $clientIdentifier,
            'additionalValues' => $this->additionalValues,
            'externalID' => $this->externalID,
            'returnUrl' => $this->returnUrl,
            'view' => $this->view,
            'agreementRef' => $this->agreementRef,
            'cancelUrl' => $this->cancelUrl,
            'clientLanguage' => $this->clientLanguage
        );

        return $this->initialize8($params);
    }

    /**
     * The Initialize method call is the backbone of the credit card implementation
     * and all other payment methods. This method is used for setting up the transaction,
     * specifying the price of the transaction and the purchase operation.
     * @return mixed
     */
    function initialize8($params)
    {
        $PayEx = new SoapClient($this->PxOrderWSDL, array("trace" => 1, "exceptions" => 0));

        // Generate hash of all parameters
        $hash = \App\Order::createHash($params);
        // and append the hash to the parameters
        $params['hash'] = $hash;

        try {
            // Defining which initialize version to run, this one is 9.
            $response = $PayEx->Initialize8($params);
            $result = $response->{'Initialize8Result'};
            $status = \App\Order::checkStatus($result);

            // if code & description & errorCode is OK, redirect the user
            if ($status['code'] == "OK" && $status['errorCode'] == "OK" && $status['description'] == "OK") {

                return redirect($status['redirectUrl']);
            } else {
                // if any errors dump them to the screen
                echo 'initilize8 - kan ej skapa pga: ' . '<br/>';
                echo '<pre>';
                print_r($status);
                echo '</pre>';
            }
        } catch (SoapFault $error) {
            echo 'Du kan inte skapa ett nytt konto eftersom:' . '<br>';
            echo "Error: {$error->faultstring}";
        }
    }

    /**
     * Customer returns from the PayEx payment gateway by
     * the returnUrl from initilize method
     * @return mixed
     */
    public function complete()
    {
        // Parse URL and get orderRef parameter
        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parse_str = parse_url($url);
        parse_str($parse_str['query'], $query);

        $orderRef = $query['orderRef'];
        $params = array(
            'accountNumber' => $this->accountNumber,
            'orderRef' => $orderRef
        );

        $PayEx = new SoapClient($this->PxOrderWSDL, array("trace" => 1, "exceptions" => 0));

        //create the hash for all parameters
        $hash = \App\Order::createHash($params);
        //append the hash to the parameters
        $params['hash'] = $hash;

        try {
            //defining which complete
            $response = $PayEx->Complete($params);
            $completeResponse = $response->{'CompleteResult'};
            $result = \App\Order::complete($completeResponse);

            /*
            Transaction statuses
            0=Sale, 1=Initialize, 2=Credit, 3=Authorize, 4=Cancel, 5=Failure, 6=Capture
            */
            if ($result['code'] == "OK" && $result['errorCode'] == "OK" && $result['description'] == "OK") {
                if ($result['transactionStatus'] == '0' || $result['transactionStatus'] == '6') {
                    // Update user order with transactionRef andtransactionNumber
                    $order = \App\Order::updateOrder(
                        $result['orderID'],
                        $result['transactionRef'],
                        $result['transactionNumber'], '');

                    // Update user with the agreementref as payexID
                    $user = \App\User::find($order->userID);
                    $user->payexID = $order->agreementRef;
                    $user->save();

                    return $this->finishOrder($order);
                } // Mail user if the transaction fails?
                else if ($result['transactionStatus'] == '5') {
                    echo 'Order unsuccesful';
                } // status 3 is in this section
                else {
                    echo 'Transaction not completed.';
                }
            }
        } catch (SoapFault $error) {
            echo 'Din order misslyckades att betala och anledningen:' . '<br>';
            echo "Error: {$error->faultstring}";
        }
    }

    /**
     * Check if we have data and show user
     * all the information
     * @return mixed
     */
    public function finishOrder($order)
    {
        $user = \App\User::find($order->userID);
        $user->active = true;
        $user->save();

        // Generate invoice with 2 SEK
        \App\Order::pdfFirstTime($order->id);

        // Transalate interval to swedish
        $interval = \App\User::intervalClearText(($user->interval));

        // Get sunday from the start date
        $billingDate = \App\User::getBillingDate($user->startDate);

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'city' => $user->city,
            'street' => $user->street,
            'doorCode' => $user->doorCode,
            'postalCode' => $user->postalCode,
            'telephoneNumber' => $user->telephoneNumber,
            'additionalInfo' => $user->additionalInfo,
            'startDate' => $user->startDate,
            'billingDate' => $billingDate,
            'orderNumber' => $order->transactionNumber,
            'total' => '2',
            'interval' => $interval
        ];

        // Send welcome mail to the customer
        \App\Order::welcomeMail($data);

        if (!empty($data)) {
            return view('page.checkout')->with('data', $data);
        } else {
            return redirect()->to('vilken-matkasse');
        }
    }

    /**
     * Handles users subscription and make transaction if
     * user is current date and active. If transaction failed
     * then send mail to the user.
     */
    function subscriptionMultipleUsers()
    {
        $PayEx = new SoapClient($this->PxAgreement, array("trace" => 1, "exceptions" => 0));
        $users = \App\User::where('active', '=', true)->get();
        $payedOrderID = [];
        $payedUsers = [];
        $fourDaysForward = \App\User::getAnyDays("+4");

        foreach ($users as $u) {
            $startDate = $u->startDate;

            // Only charge users that have started their subscription or is active
            if ($fourDaysForward >= $startDate) {
                $interval = $u->interval;
                $nextDelivery = \App\BudbeeOrders::getFirstWeek($this->client); // Get first date from 6 weeks
                $skipWeek = explode(", ", $u->skipDate); // Get weeks user not want to have delivery

                // Check if user have different interval
                if (strcmp($interval, 'everySecondWeek') == 0) {
                    $nextDelivery = \App\BudbeeOrders::getEveryOtherWeekFromStartDate($this->client, $u->startDate)[0];
                }

                // Override next delivery if user has not started yet
                if (strcmp($startDate, $fourDaysForward) == 0) {
                    $nextDelivery = $startDate;
                }

                // Create order only users with orders this week
                if ($fourDaysForward >= $nextDelivery && !in_array($fourDaysForward, $skipWeek)) {
                    // Start transaction
                    DB::beginTransaction();

                    // Create order for user
                    $id = \App\Order::createOrder($u->id);

                    // Assume user want standard bag otherwise take alternative
                    $currentDinner = $u->dinnerProduct;
                    $currentDinnerPrice = $u->dinnerProductPrice * 100;

                    if (!empty($u->dinnerProductAlternative)) {
                        $currentDinner = $u->dinnerProductAlternative;
                        $currentDinnerPrice = $u->dinnerProductAlternativePrice;
                    }

                    // Quickfix if email is "vinge" charge only 50% and only startDate
                    if (strpos($u->email, "@vinge.se") !== false && strcmp($startDate, $fourDaysForward) == 0) {
                        $currentDinnerPrice = $currentDinnerPrice * 0.5;
                    }

                    // Get Product name
                    $productName = \App\Products::find($currentDinner)->title;

                    $params = [
                        'accountNumber' => $this->accountNumber,
                        'agreementRef' => $u->payexID,
                        'price' => $currentDinnerPrice,
                        'productNumber' => $currentDinner,
                        'description' => $productName . ' - ' . $u->name,
                        'orderId' => $id,
                        'purchaseOperation' => "SALE",
                        'currency' => "SEK"
                    ];
                    // Generate hash of all parameters
                    $hash = \App\Order::createHash($params);
                    // and append the hash to the parameters
                    $params['hash'] = $hash;

                    try {
                        $response = $PayEx->AutoPay3($params);
                        $autopayResponse = $response->{'AutoPay3Result'};
                        $status = \App\Order::autopay($autopayResponse);

                        // transactionStatus = 0=Sale, 3=Authorize
                        if ($status['code'] == "OK" && $status['errorCode'] == "OK" && $status['description'] == "OK") {
                            // Payment valid then update user
                            $order = \App\Order::updateOrder(
                                $id, $status['transactionRef'],
                                $status['transactionNumber'],
                                $u->payexID);

                            // Add each used to list
                            array_push($payedOrderID, $id);
                            array_push($payedUsers, $u);

                            DB::commit();

                            $u->payed = true;
                            $u->save();

                        } else {
                            // Send mail to the user if failed to purchase
                            \App\Order::transactionFailedMessage($u->name, $u->email);

                            // Remove order if transaction fails
                            DB::rollback();
                        }
                    } catch (SoapFault $error) {
                        echo "Error: {$error->faultstring}";
                    }
                }
            }
        } // end for

        // Send mail for all payed customers
        if (!empty($payedUsers)) {
            \App\Order::weeklyMail($payedUsers);
        }
        return \App\Order::pdfSubscription($payedOrderID, $this->client);
    }

    function subscriptionTryAgainPayment() {
        $PayEx = new SoapClient($this->PxAgreement, array("trace" => 1, "exceptions" => 0));
        $users = \App\User::where('active', '=', true)->get();
        $payedOrderID = [];
        $payedUsers = [];
        $fourDaysForward = \App\User::getAnyDays("+3");

        foreach ($users as $u) {
            $startDate = $u->startDate;

            // Only charge users that have started their subscription or is active
            if ($fourDaysForward >= $startDate && !$u->payed) {
                $interval = $u->interval;
                $nextDelivery = \App\BudbeeOrders::getFirstWeek($this->client); // Get first date from 6 weeks
                $skipWeek = explode(", ", $u->skipDate); // Get weeks user not want to have delivery

                // Check if user have different interval
                if (strcmp($interval, 'everySecondWeek') == 0) {
                    $nextDelivery = \App\BudbeeOrders::getEveryOtherWeekFromStartDate($this->client, $u->startDate)[0];
                }

                // Override next delivery if user has not started yet
                if (strcmp($startDate, $fourDaysForward) == 0) {
                    $nextDelivery = $startDate;
                }

                // Create order only users with orders this week
                if ($fourDaysForward >= $nextDelivery && !in_array($fourDaysForward, $skipWeek)) {
                    // Start transaction
                    DB::beginTransaction();

                    // Create order for user
                    $id = \App\Order::createOrder($u->id);

                    // Assume user want standard bag otherwise take alternative
                    $currentDinner = $u->dinnerProduct;
                    $currentDinnerPrice = $u->dinnerProductPrice * 100;

                    if (!empty($u->dinnerProductAlternative)) {
                        $currentDinner = $u->dinnerProductAlternative;
                        $currentDinnerPrice = $u->dinnerProductAlternativePrice;
                    }

                    // Get Product name
                    $productName = \App\Products::find($currentDinner)->title;

                    $params = [
                        'accountNumber' => $this->accountNumber,
                        'agreementRef' => $u->payexID,
                        'price' => $currentDinnerPrice,
                        'productNumber' => $currentDinner,
                        'description' => $productName . ' - ' . $u->name,
                        'orderId' => $id,
                        'purchaseOperation' => "SALE",
                        'currency' => "SEK"
                    ];
                    // Generate hash of all parameters
                    $hash = \App\Order::createHash($params);
                    // and append the hash to the parameters
                    $params['hash'] = $hash;

                    try {
                        $response = $PayEx->AutoPay3($params);
                        $autopayResponse = $response->{'AutoPay3Result'};
                        $status = \App\Order::autopay($autopayResponse);

                        // transactionStatus = 0=Sale, 3=Authorize
                        if ($status['code'] == "OK" && $status['errorCode'] == "OK" && $status['description'] == "OK") {
                            // Payment valid then update user
                            $order = \App\Order::updateOrder(
                                $id, $status['transactionRef'],
                                $status['transactionNumber'],
                                $u->payexID);

                            // Add each used to list
                            array_push($payedOrderID, $id);
                            array_push($payedUsers, $u);

                            DB::commit();

                            $u->payed = true;
                            $u->save();

                        } else {
                            // Send mail to the user if failed to purchase
                            \App\Order::transactionFailedMessage($u->name, $u->email);

                            // Remove order if transaction fails
                            DB::rollback();
                        }
                    } catch (SoapFault $error) {
                        echo "Error: {$error->faultstring}";
                    }
                }
            }
        } // end for
    }

    /**
     * Handles users subscription and make transaction if
     * user is current date and active. If transaction failed
     * then send mail to the user.
     */
    function payExtraProducts()
    {
        $PayEx = new SoapClient($this->PxAgreement, array("trace" => 1, "exceptions" => 0));
        $user = \App\User::find(Auth::id());

        if ($user->active) {

            // Start transaction
            DB::beginTransaction();

            $orderID = \App\Order::createOrder($user->id);

            // Get price and products to pay for
            $extraProductsInput = Input::get('extra');
            $extraProductPriceInput = strip_tags(Input::get('extraProductPriceInput'));
            $currentBagAmount = (int)strip_tags(Input::get('currentBagAmount'));
            $currentBagID = strip_tags(Input::get('currentBagID'));

            $extraProductsString = implode(', ', $extraProductsInput) . ', ' . $currentBagID;
            $totalPriceExtra = $extraProductPriceInput * 100;

            $params = array(
                'accountNumber' => $this->accountNumber,
                'agreementRef' => $user->payexID,
                'price' => $totalPriceExtra,
                'productNumber' => $extraProductsString,
                'description' => 'MK Prenumeration ' . $user->name,
                'orderId' => $orderID,
                'purchaseOperation' => $this->purchaseOperation,
                'currency' => $this->currency
            );

            //create the hash for all parameters
            $hash = \App\Order::createHash($params);
            //append the hash to the parameters
            $params['hash'] = $hash;

            try {
                $response = $PayEx->AutoPay3($params);
                $autopayResponse = $response->{'AutoPay3Result'};
                $status = \App\Order::autopay($autopayResponse);

                // transactionStatus = 0=Sale, 3=Authorize
                if ($status['code'] == "OK" && $status['errorCode'] == "OK" && $status['description'] == "OK") {
                    // Payment valid then update user
                    \App\Order::updateOrder(
                        $orderID,
                        $status['transactionRef'],
                        $status['transactionNumber'],
                        $user->payexID);

                    // Get current date
                    $currentDate = \App\User::getCurrentDate();

                    // Get delivery dates and pick first one
                    $deliveryDate = $user->startDate;

                    if ($currentDate > $user->startDate) {
                        // User have start the prenumeration and select first date
                        if ($user->interval == 'eachWeek') {
                            $deliveryDate = \App\BudbeeOrders::getXWeeks($this->client, 6)[0];
                        } else {
                            $deliveryDate = \App\BudbeeOrders::getTenWeeks($this->client)[0];
                        }
                    }

                    $data = [
                        'extraProductsInput' => $extraProductsInput,
                        'extraProductPriceInput' => $extraProductPriceInput,
                        'currentBagAmount' => $currentBagAmount,
                        'currentBagID' => $currentBagID,
                        'deliveryDate' => $deliveryDate
                    ];

                    DB::commit();

                    // Create PDF with dinners if not empty
                    if (!empty($currentBagAmount)) {
                        return $this->createPDF($orderID, true, true, $data);
                    } else {
                        return $this->createPDF($orderID, false, true, $data);
                    }
                } // Send mail to the user if failed to purchase
                else {
                    // Send message on profile page and to their mail
                    \App\Order::transactionFailedMessage($user->name, $user->email);

                    // Remove order and send mail to the user about the transaction failed
                    DB::rollback();

                    return redirect()->to('tillaggsprodukter')
                        ->withErrors('Vi kunde inte genomföra ditt köp');
                }
            } catch (SoapFault $error) {
                echo "Error: {$error->faultstring}";
            }
        } // end if
    }

    /**
     * Creates A4 pdf from PayEx order informations
     * @param $orders
     * @param $next
     * @param $isDinner
     * @return mixed
     */
    function createPDF($orderID, $isDinner, $goBack, $extraData)
    {
        \App\Order::pdfExtraProducts($orderID, $isDinner, $extraData);

        // Get user from the order
        $order = \App\Order::find($orderID);
        $user = \App\User::find($order->userID);

        // Append the extra products to the current in DB
        $extraProductsString = \App\Products::addExtra($user, $extraData['extraProductsInput']);

        $totalDinners = (int)$user->dinnerProductAmount + $extraData['currentBagAmount'];

        // Save products to the user in DB
        $user->extraProductCurrent = $extraProductsString;
        $user->dinnerProductAmount = $totalDinners;
        $user->save();

        if ($goBack) {
            // Go back to the addons page with success
            return redirect()->to('tillaggsprodukter')
                ->with('success', 'Tack, ditt köp är nu genomfört. Du hittar kvitton i undermenyn på mina sidor.');
        }
    }

    /**
     * Clear field in database each week for field 'payed'
     */
    function clearPayedUsers() {
        $users = \App\User::where('active', '=', true)->get();

        foreach ($users as $u) {

            echo $u->name . '<br>';

            $u->payed = false;
            $u->save();
        }
    }

    /* Function to test anything */
    function test()
    {
        // TODO
    }

}
