<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use SimpleXMLElement;
use DateTime;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['agreementRef', 'transactionRef', 'transactionNumber', 'payed', 'userID'];
    public $timestamps = false;

    /**
     * Crerate MD5 hash from all input parameters
     * @param $params
     * @return string
     */
    public static function createHash($params)
    {
        $encryptionKeyDev = '2N84q52325847472895b';
        $encryptionKey = '82T5VeUCmEEPNW9p37Uf';

        //$params = $params.$encryptionKey;
        return md5(trim(implode("", $params).$encryptionKey));
    }

    /**
     * Checking for OK statements in return xml.
     * @param $xml
     * @return array
     */
    public static function checkStatus($xml)
    {
        $returnXml = new SimpleXMLElement($xml);
        $code = strtoupper($returnXml->status->code);
        $errorCode = strtoupper($returnXml->status->errorCode);
        $description = strtoupper($returnXml->status->description);
        $orderRef = strtoupper($returnXml->orderRef);
        $authenticationRequired = strtoupper($returnXml->authenticationRequired);

        return $status = array(
            'code' => $code,
            'errorCode' => $errorCode,
            'description' => $description,
            'redirectUrl' => $returnXml->redirectUrl,
            'orderRef' => $orderRef,
            'authenticationRequired' => $authenticationRequired);
    }

    /**
     * checking complete on return url
     * Parse XML to array with strings
     * @param $params
     * @return array
     */
    public static function complete($params)
    {
        $returnXml = new SimpleXMLElement($params);
        $code = strtoupper($returnXml->status->code);
        $errorCode = strtoupper($returnXml->status->errorCode);
        $description = strtoupper($returnXml->status->description);
        $transactionStatus = strtoupper($returnXml->transactionStatus);
        $transactionRef = (string)strtoupper($returnXml->transactionRef);
        $transactionNumber = (string)strtoupper($returnXml->transactionNumber);
        $orderID = (string)strtoupper($returnXml->orderId);
        $agreementRef = (string)strtoupper($returnXml->agreementRef);

        return $status = array(
            'code' => $code,
            'errorCode' => $errorCode,
            'description' => $description,
            'transactionStatus' => $transactionStatus,
            'transactionRef' => $transactionRef,
            'transactionNumber' => $transactionNumber,
            'orderID' => $orderID,
            'agreementRef' => $agreementRef);
    }

    public static function autopay($params)
    {
        $returnXml = new SimpleXMLElement($params);
        $code = (string)strtoupper($returnXml->status->code);
        $errorCode = (string)strtoupper($returnXml->status->errorCode);
        $description = (string)strtoupper($returnXml->status->description);
        $transactionRef = (string)strtoupper($returnXml->transactionRef);
        $transactionNumber = (string)strtoupper($returnXml->transactionNumber);

        return $status = array(
            'code' => $code,
            'errorCode' => $errorCode,
            'description' => $description,
            'transactionRef' => $transactionRef,
            'transactionNumber' => $transactionNumber);
    }

    /**
     * Update order
     * @param $id
     * @param $agreementRef
     */
    public static function updateOrder($id, $transactionRef, $transactionNumber, $agreementRef)
    {
        $order = Order::find($id);
        $order->payed = true;

        if (!empty($transactionRef)) {
            $order->transactionRef = $transactionRef;
        }
        if (!empty($transactionNumber)) {
            $order->transactionNumber = $transactionNumber;
        }
        if (!empty($agreementRef)) {
            $order->agreementRef = $agreementRef;
        }
        if (!empty($transactionRef) && !empty($transactionNumber)) {
            $order->payed = true;
        }
        $order->save();

        return $order;
    }

    /*
     * Create new order from ID and agreementref
     */
    public static function createOrder($id)
    {
        $order = new \App\Order();
        $order->userID = $id;
        $order->agreementRef = '';
        $order->transactionRef = '';
        $order->transactionNumber = '';
        $order->payed = false;
        $order->save();

        return $order->id;
    }

    /**
     * Send welcome mail to the user with their contact information and
     * delivery address
     * @param $name
     * @param $email
     */
    public static function welcomeMail($user)
    {
        $data = [
            'name' => $user['name'],
            'email' => $user['email'],
            'id' => $user['id'],
            'cellphone' => $user['telephoneNumber'],
            'street' => $user['street'],
            'postalCode' => $user['postalCode'],
            'doorCode' => $user['doorCode'],
            'interval' => $user['interval'],
            'startDate' => $user['startDate']
        ];
        Mail::send('emails.welcome', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name']);
            $message->subject('Välkommen till Middagskonst.se!');
        });
    }

    /**
     * When transaction failed send mail to the user
     * enough money on the account
     */
    public static function transactionFailedMessage($name, $email)
    {
        $data = array('name' => $name, 'email' => $email);
        Mail::send('emails.fail', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name']);
            $message->subject('Transaktion misslyckades!');
        });
    }

    /**
     * Receive list of payed users and create mail with their order
     * @param $payed
     */
    public static function weeklyMail($users)
    {
        $path = str_replace('laravel_files/public','', public_path()).'excel';
        $week = date('W')+1;
        $name = 'Leverans-'.$week;

        // \Excel::create($name, function($excel) use ($users){

        //     $excel->sheet('New sheet', function($sheet) use ($users) {

        //         $extraProductsDB = \App\Products::where('type', '=', 'extra')->get();

        //         foreach($users as $user){
        //             $extraUser = explode(', ',$user->extraProductCurrent);

        //             for($i = 0; $i<sizeof($extraProductsDB); $i++){
        //                 $user['extra'.$i] = $extraUser[$i];
        //             }

        //             // Assume user want standard bag otherwise take alternative
        //             $currentDinner = $user->dinnerProduct;

        //             if(!empty($user->dinnerProductAlternative)){
        //                 $currentDinner = $user->dinnerProductAlternative;
        //             }

        //             // Translate to name
        //             $currentDinner = \App\Products::find($currentDinner);
        //             $user['currentDinner'] = $currentDinner->title;
        //         }

        //         $data = [
        //             'extraProductsDB' => $extraProductsDB,
        //             'users' => $users
        //         ];

        //         $sheet->loadView('page.excel',  $data);

        //     });

        // })->store('xls',$path);

        $data = [
            'path' => $path.'/'.$name.'.xls'
        ];

        if (!empty($users)) {
            $week = date('W');
            Mail::send('emails.blank', ['users' => $users], function ($message) use ($week, $data) {
                $message->to('info@middagskonst.se', 'Weekly Mail')
                    ->subject('Middagskonst - Vecka '.$week.' betalningar')
                    ->attach($data['path'], ['content-type' => 'application/xls']);
            });
        }
    }

    /**
     * Create PDF for completed orders
     * @param $orders
     */
    public static function pdfSubscription($orders, $client)
    {
        foreach($orders as $id){
            $order = \App\Order::find($id);
            $user = \App\User::find($order->userID);

            // Get todays date
            $date = new DateTime();
            $currentDate = $date->format('Y-m-d');

            // Get delivery dates and pick first one
            $deliveryDate = '';
            if($user->interval == 'eachWeek'){
                $deliveryDate = \App\BudbeeOrders::getXWeeks($client, 5)[0];
            } else {
                $deliveryDate = \App\BudbeeOrders::getEveryOtherWeekFromStartDate($client, $user->startDate)[0];
            }

            // Get current dinner to pay
            $currentDinner = $user->dinnerProduct;
            if(!empty($user->dinnerProductAlternative)){
                $currentDinner = $user->dinnerProductAlternative;
            }
            // Convert product id to the real title
            $currentDinner = \App\Products::getProduct($currentDinner);
            $currentDinnerPrice = $currentDinner->price;

            // Quickfix if email is "vinge" charge only 50% and only startDate
            if (strpos($user->email, "@vinge.se") !== false && strcmp($user->startDate, $deliveryDate) == 0) {
                $currentDinnerPrice = $currentDinnerPrice* 0.5;
            }

            // Receipt info
            $company = "Middagskonst AB";
            $org = utf8_decode("Org: 559005-0760");
            $email = "info@middagskonst.se";

            $pdf = new \FPDF('P', 'mm', 'A4');

            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetTextColor(32);

            // Title information
            $pdf->SetFont('Times', 'B', 20);
            $pdf->Cell(0, 5, "Kvitto", 0, 1, 'L');
            $pdf->Line(10, 17, 210 - 10, 17); // 10mm from each edge

            // Logo for MK
            $image1 = "img/MK_Web.png";
            $pdf->Image($image1, 10, 20, 30);

            // Company information
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(0, 5, '', 0, 1, 'R');
            $pdf->Cell(0, 5, $company, 0, 1, 'R');
            $pdf->Cell(0, 5, $org, 0, 1, 'R');
            $pdf->Cell(0, 5, $email, 0, 1, 'R');

            // Date
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(0, 10, '', 0, 1, 'R');
            $pdf->Cell(50, 6, "Datum:", 0, 0, 'L');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(50, 6, "$currentDate", 0, 1, 'L');

            // Transaction number
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(0, 2, '', 0, 1, 'R');
            $pdf->Cell(50, 6, "Ordernummer:", 0, 0, 'L');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(50, 6, $id, 0, 1, 'L');

            // Transaction number
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(0, 2, '', 0, 1, 'R');
            $pdf->Cell(50, 6, "Transaktionsnummer:", 0, 0, 'L');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(50, 6, "$order->transactionNumber", 0, 1, 'L');

            // Customer name
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(0, 2, '', 0, 1, 'R');
            $pdf->Cell(50, 6, "Namn:", 0, 0, 'L');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(50, 6, utf8_decode($user->name), 0, 1, 'L');

            // Delivery address
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(0, 2, '', 0, 1, 'R');
            $pdf->Cell(50, 6, "Levaransaddress:", 0, 0, 'L');
            $pdf->SetFont('Times', '', 12);
            $addr = $user->street.', '.$user->postalCode.', '.$user->city;
            $pdf->Cell(50, 6, utf8_decode($addr), 0, 1, 'L');

            // Products
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(0, 10, '', 0, 1, 'R');
            $pdf->Cell(20, 7, 'Antal', 0, 0, 'C');
            $pdf->Cell(125, 7, 'Produkter', 0, 0, 'C');
            $pdf->Cell(50, 7, 'Pris', 0, 1, 'C');

            $pdf->SetFont('Times', '', 12);
            $pdf->Line(10, 90, 210 - 10, 90); // 10mm from each edge

            // Print dinner product
            $pdf->Cell(20, 7, '1', 0, 0, 'C');
            $pdf->Cell(125, 7, utf8_decode($currentDinner->title), 0, 0, 'C');
            $pdf->Cell(50, 7, $currentDinnerPrice.' kr', 0, 1, 'C');
            $pdf->Line(10, 115, 210 - 10, 115); // 10mm from each edge

            $pdf->Cell(0, 15, '', 0, 1, 'R');
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(170, 6, "Totalt ", 0, 0, 'R');
            $pdf->SetFont('Times', '', 12);

            $pdf->Cell(0, 6,$currentDinnerPrice.' kr', 0, 1, 'R');
            $pdf->Cell(0, 1, '', 0, 1, 'R');
            $pdf->Cell(174, 6, "varv moms:", 0, 0, 'R');
            $moms = number_format((int)$currentDinnerPrice*0.1071, 2, '.', '');
            $pdf->Cell(0, 6, $moms.' kr', 0, 1, '');

            $pdf->SetFont('Times', '', 14);
            $pdf->Cell(0, 30, '', 0, 1, 'L');
            $pdf->Cell(0, 10, utf8_decode('Datum för första leverans: '.$deliveryDate), 0, 1, 'L');
            $pdf->Cell(0, 10, utf8_decode('Datum för debitering av din första Middagspåse: ' . $currentDate), 0, 1, 'L');
            $pdf->Cell(0, 10, utf8_decode("För övriga frågor vänd er till info@middagkonst.se"), 0, 0, 'L');

            // Save file with name and date
            $path = base_path();
            // Remove name 'laravel_files'
            $path = str_replace('laravel_files', '', $path);
            $filename = $path . 'invoice/'.$user->id.'/'.$id.'_'.$currentDate.'.pdf';
            $pdf->Output($filename, 'F');
        }
    }

        /**
     * Create PDF for completed orders
     * @param $orders
     */
    public static function pdfExtraProducts($orderID, $isDinner, $extraData)
    {
        $order = \App\Order::find($orderID);
        $user = \App\User::find($order->userID);
        $dinnerProduct = \App\Products::find($extraData['currentBagID']);

        $date = new DateTime();
        $currentDate = $date->format('Y-m-d');

        // Receipt info
        $company = "Middagskonst AB";
        $org = utf8_decode("Org: 559005-0760");
        $email = "info@middagskonst.se";

        $pdf = new \FPDF('P', 'mm', 'A4');

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetTextColor(32);

        // Title information
        $pdf->SetFont('Times', 'B', 20);
        $pdf->Cell(0, 5, "Kvitto", 0, 1, 'L');
        $pdf->Line(10, 17, 210 - 10, 17); // 10mm from each edge

        // Logo for MK
        $image1 = "img/MK_Web.png";
        $pdf->Image($image1, 10, 20, 30);

        // Company information
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 5, '', 0, 1, 'R');
        $pdf->Cell(0, 5, $company, 0, 1, 'R');
        $pdf->Cell(0, 5, $org, 0, 1, 'R');
        $pdf->Cell(0, 5, $email, 0, 1, 'R');

        // Date
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Datum:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(50, 6, "$currentDate", 0, 1, 'L');

        // Transaction number
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 2, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Ordernummer:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(50, 6, $orderID, 0, 1, 'L');

        // Transaction number
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 2, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Transaktionsnummer:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(50, 6, "$order->transactionNumber", 0, 1, 'L');

        // Customer name
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 2, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Namn:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(50, 6, utf8_decode("$user->name"), 0, 1, 'L');

        // Delivery address
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 2, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Levaransaddress:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $addr = $user->street . ", " . $user->postalCode . ", " . $user->city;
        $pdf->Cell(50, 6, utf8_decode($addr), 0, 1, 'L');

        // Products
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, '', 0, 1, 'R');
        $pdf->Cell(20, 7, 'Antal', 0, 0, 'C');
        $pdf->Cell(125, 7, 'Produkter', 0, 0, 'C');
        $pdf->Cell(50, 7, 'Pris', 0, 1, 'C');
        $pdf->SetFont('Times', '', 12);
        $pdf->Line(10, 90, 210 - 10, 90); // 10mm from each edge

        // Print dinner product
        if ($isDinner) {
            $pdf->Cell(20, 7, utf8_decode($extraData['currentBagAmount']), 0, 0, 'C');
            $pdf->Cell(125, 7, utf8_decode($dinnerProduct->title), 0, 0, 'C');
            $pdf->Cell(50, 7, $dinnerProduct->discount.' kr', 0, 1, 'C');
        }

        // Print for each extra product
        $item = $extraData['extraProductsInput'];
        if (!empty($item)) {
            $amountExtra = 0;
            $extraProducts = Products::getExtra();

            for ($i = 0; $i < sizeof($extraProducts); $i++) {
                if ($item[$i] != 0) {
                    $total = $item[$i] * $extraProducts[$i]->price;

                    $pdf->Cell(20, 7, $item[$i], 0, 0, 'C');
                    $pdf->Cell(125, 7, utf8_decode($extraProducts[$i]->title), 0, 0, 'C');
                    $pdf->Cell(50, 7, $total . ' kr', 0, 1, 'C');
                    $amountExtra++;
                }
            }

            if ($amountExtra > 1 && $isDinner) {
                $pdf->Line(10, 130, 210 - 10, 130); // 10mm from each edge
            }
            if ($amountExtra > 1 && !$isDinner) {
                $pdf->Line(10, 125, 210 - 10, 125); // 10mm from each edge
            } else if ($amountExtra === 1 && !$isDinner) {
                $pdf->Line(10, 115, 210 - 10, 115); // 10mm from each edge
            } else if ($amountExtra === 1 && $isDinner) {
                $pdf->Line(10, 120, 210 - 10, 120); // 10mm from each edge
            }
        }

        $pdf->Cell(0, 15, '', 0, 1, 'R');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(170, 6, "Totalt ", 0, 0, 'R');
        $pdf->SetFont('Times', '', 12);

        $sum = $extraData['extraProductPriceInput'];
        $pdf->Cell(0, 6, $sum." kr", 0, 1, 'R');
        $pdf->Cell(0, 1, '', 0, 1, 'R');
        $pdf->Cell(174, 6, "varv moms:", 0, 0, 'R');
        $moms = number_format((int)$sum*0.1071, 2, '.', '');
        $pdf->Cell(0, 6, $moms.' kr', 0, 1, '');

        $pdf->SetFont('Times', '', 14);
        $pdf->Cell(0, 30, '', 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode('Datum för första leverans: ' . $extraData['deliveryDate']), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode('Datum för debitering: ' . $currentDate), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode("För övriga frågor vänd er till info@middagkonst.se"), 0, 0, 'L');

        // Save file with name and date
        $path = base_path();
        // Remove name 'laravel_files'
        $path = str_replace('laravel_files', '', $path);
        $filename = $path . 'invoice/'.$user->id.'/'.$orderID.'_'.$currentDate.'.pdf';
        $pdf->Output($filename, 'F');
    }

    /**
     * Create PDF for first time use
     * @param $orders
     */
    public static function pdfFirstTime($orderID)
    {
        $order = \App\Order::find($orderID);
        $user = \App\User::find($order->userID);

        $date = new DateTime();
        $currentDate = $date->format('Y-m-d');

        // Receipt info
        $company = "Middagskonst AB";
        $org = utf8_decode("Org: 559005-0760");
        $email = "info@middagskonst.se";

        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetTextColor(32);

        // Title information
        $pdf->SetFont('Times', 'B', 20);
        $pdf->Cell(0, 5, "Kvitto", 0, 1, 'L');
        $pdf->Line(10, 17, 210 - 10, 17); // 10mm from each edge

        // Logo for MK
        $image1 = "img/MK_Web.png";
        $pdf->Image($image1, 10, 20, 30);

        // Company information
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 5, '', 0, 1, 'R');
        $pdf->Cell(0, 5, $company, 0, 1, 'R');
        $pdf->Cell(0, 5, $org, 0, 1, 'R');
        $pdf->Cell(0, 5, $email, 0, 1, 'R');

        // Date
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Datum:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(50, 6, "$currentDate", 0, 1, 'L');

        // Transaction number
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 2, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Ordernummer:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(50, 6, "$orderID", 0, 1, 'L');

        // Transaction number
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 2, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Transaktionsnummer:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(50, 6, "$order->transactionNumber", 0, 1, 'L');

        // Customer name
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 2, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Namn:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(50, 6, utf8_decode($user->name), 0, 1, 'L');

        // Delivery address
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 2, '', 0, 1, 'R');
        $pdf->Cell(50, 6, "Levaransaddress:", 0, 0, 'L');
        $pdf->SetFont('Times', '', 12);
        $addr = $user->street.", ".$user->postalCode.", ".$user->city;
        $pdf->Cell(50, 6, utf8_decode($addr), 0, 1, 'L');

        // Products
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 5, '', 0, 1, 'R');
        $pdf->Cell(20, 7, 'Antal', 0, 0, 'C');
        $pdf->Cell(125, 7, 'Produkter', 0, 0, 'C');
        $pdf->Cell(50, 7, 'Pris', 0, 1, 'C');
        $pdf->SetFont('Times', '', 12);
        $pdf->Line(10, 85, 210 - 10, 85); // 10mm from each edge

        // Print dinner product
        $pdf->Cell(20, 7, '', 0, 0, 'C');
        $pdf->Cell(125, 7, utf8_decode('Ny medlem'), 0, 0, 'C');
        $pdf->Cell(50, 7, '2 kr', 0, 1, 'C');
        $pdf->Line(10, 105, 210 - 10, 105); // 10mm from each edge

        $pdf->Cell(0, 15, '', 0, 1, 'R');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(175, 6, "Totalt  ", 0, 0, 'R');
        $pdf->SetFont('Times', '', 12);

        $sum = 2;
        $pdf->Cell(0, 6, $sum." kr", 0, 1, 'R');

        $pdf->Cell(0, 1, '', 0, 1, 'R');
        $pdf->Cell(181, 6, "varv moms:", 0, 0, 'R');
        $moms = (int)$sum*0.2;
        $pdf->Cell(0, 6, $moms.' kr', 0, 1, '');

        // Get sunday from the start date
        $billingDate = \App\User::getBillingDate($user->startDate);

        // Contact information
        $pdf->SetFont('Times', '', 14);
        $pdf->Cell(0, 30, '', 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode('Datum för första leverans: '.$user->startDate), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode('Datum för första debitering: '.$billingDate), 0, 1, 'L');
        $pdf->Cell(0, 10, utf8_decode("För övriga frågor vänd er till info@middagkonst.se"), 0, 0, 'L');

        // Save file with name and date
        $path = base_path();
        // Remove name 'laravel_files'
        $path = str_replace('laravel_files', '', $path);
        $filename = $path . 'invoice/'.$user->id.'/'.$orderID.'_'.$currentDate.'.pdf';
        $pdf->Output($filename, 'F');
    }
}
