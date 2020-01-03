<?php namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Budbee;
use Illuminate\Support\Facades\Input;

class BudbeeOrders extends Model
{
    protected $table = 'budbee_orders';
    protected $fillable = array('userID', 'budbeeID');

    public static $validPostalCode = [
        '11115', '11120', '11121', '11122', '11123', '11124', '11127', '11128', '11129', '11130', '11131', '11134', '11135', '11136', '11137', '11138', '11139', '11140', '11143', '11144', '11145', '11146', '11147', '11148', '11149', '11151', '11152', '11153', '11156', '11157', '11160', '11161', '11164', '11215', '11216', '11217', '11218', '11219', '11220', '11221', '11222', '11223', '11224', '11225', '11226', '11227', '11228', '11229', '11230', '11231', '11232', '11233', '11234', '11235', '11236', '11237', '11238', '11239', '11240', '11241', '11242', '11243', '11244', '11245', '11246', '11247', '11248', '11249', '11250', '11251', '11252', '11253', '11254', '11255', '11256', '11257', '11258', '11259', '11260', '11261', '11262', '11263', '11264', '11265', '11266', '11267', '11269', '11320', '11321', '11322', '11323', '11324', '11325', '11326', '11327', '11328', '11329', '11330', '11331', '11332', '11333', '11334', '11335', '11336', '11337', '11338', '11339', '11340', '11341', '11342', '11343', '11344', '11345', '11346', '11347', '11348', '11349', '11350', '11351', '11352', '11353', '11354', '11355', '11356', '11357', '11358', '11359', '11360', '11361', '11362', '11364', '11365', '11415', '11416', '11417', '11418', '11419', '11420', '11421', '11422', '11423', '11424', '11425', '11426', '11427', '11428', '11429', '11430', '11431', '11432', '11433', '11434', '11435', '11436', '11437', '11438', '11439', '11440', '11441', '11442', '11443', '11444', '11445', '11446', '11447', '11448', '11449', '11450', '11451', '11452', '11453', '11454', '11455', '11456', '11457', '11458', '11459', '11460', '11520', '11521', '11522', '11523', '11524', '11525', '11526', '11527', '11528', '11529', '11530', '11531', '11532', '11533', '11534', '11535', '11536', '11537', '11538', '11539', '11540', '11541', '11542', '11543', '11544', '11545', '11546', '11547', '11550', '11551', '11553', '11556', '11557', '11558', '11559', '11560', '11620', '11621', '11622', '11623', '11624', '11625', '11628', '11629', '11630', '11631', '11632', '11633', '11634', '11635', '11636', '11637', '11638', '11639', '11640', '11641', '11642', '11643', '11644', '11645', '11646', '11647', '11648', '11661', '11662', '11663', '11664', '11665', '11666', '11667', '11668', '11726', '11727', '11728', '11729', '11730', '11731', '11732', '11733', '11734', '11735', '11736', '11737', '11738', '11739', '11740', '11741', '11743', '11750', '11756', '11757', '11758', '11759', '11760', '11761', '11762', '11763', '11764', '11765', '11766', '11767', '11768', '11769', '11775', '11820', '11821', '11822', '11823', '11824', '11825', '11826', '11827', '11828', '11829', '11830', '11842', '11846', '11847', '11848', '11849', '11850', '11851', '11852', '11853', '11854', '11855', '11856', '11857', '11858', '11859', '11860', '11861', '11862', '11863', '11864', '11865', '11866', '11867', '11869', '11872', '12030', '12031', '12032', '12038', '12039', '12040', '12044', '12047', '12048', '12050', '12051', '12052', '12053', '12054', '12055', '12056', '12057', '12058', '12059', '12060', '12061', '12062', '12063', '12064', '12065', '12066', '12067', '12068', '12069', '12070', '12071', '12130', '12131', '12132', '12133', '12134', '12135', '12136', '12137', '12138', '12139', '12140', '12143', '12144', '12145', '12146', '12147', '12148', '12149', '12162', '12163', '12177', '12231', '12232', '12233', '12234', '12237', '12238', '12239', '12262', '12263', '12626', '12628', '12629', '12630', '12631', '12632', '12633', '12634', '12635', '12636', '12637', '12638', '12639', '12640', '12641', '12642', '12647', '12648', '12649', '12650', '12651', '12652', '12653', '12654', '12655', '12675', '12677', '12678', '12679', '12930', '12931', '12932', '12933', '12934', '12935', '12936', '12937', '12938', '12939', '13130', '13131', '13132', '13134', '13135', '13136', '13137', '13138', '13140', '13141', '13148', '13152', '13153', '13154', '13155', '13160', '13161', '13165', '13171', '13172', '16731', '16732', '16733', '16735', '16736', '16737', '16738', '16739', '16740', '16741', '16743', '16744', '16745', '16751', '16752', '16753', '16754', '16755', '16756', '16757', '16758', '16761', '16762', '16763', '16764', '16765', '16766', '16767', '16771', '16772', '16773', '16774', '16775', '16776', '16830', '16831', '16832', '16833', '16834', '16835', '16836', '16837', '16838', '16839', '16840', '16841', '16843', '16844', '16845', '16846', '16847', '16848', '16849', '16850', '16851', '16852', '16853', '16854', '16855', '16856', '16857', '16858', '16859', '16860', '16861', '16862', '16863', '16864', '16865', '16866', '16867', '16868', '16869', '16870', '16871', '16872', '16873', '16874', '16875', '16876', '16930', '16931', '16932', '16933', '16934', '16935', '16936', '16937', '16938', '16939', '16940', '16950', '16951', '16952', '16953', '16954', '16955', '16956', '16957', '16958', '16959', '16960', '16961', '16962', '16963', '16964', '16965', '16966', '16967', '16968', '16969', '16970', '16971', '16972', '16973', '16974', '16979', '17062', '17063', '17065', '17066', '17067', '17068', '17069', '17070', '17071', '17072', '17073', '17074', '17075', '17076', '17077', '17078', '17079', '17141', '17142', '17143', '17144', '17145', '17147', '17148', '17149', '17150', '17151', '17152', '17153', '17154', '17155', '17156', '17157', '17158', '17159', '17160', '17161', '17162', '17163', '17164', '17165', '17166', '17167', '17168', '17169', '17170', '17171', '17172', '17173', '18129', '18130', '18131', '18132', '18133', '18134', '18135', '18136', '18137', '18138', '18139', '18140', '18141', '18142', '18143', '18144', '18145', '18146', '18147', '18148', '18150', '18151', '18155', '18156', '18157', '18158', '18159', '18160', '18161', '18162', '18163', '18164', '18165', '18166', '18167', '18170', '18175', '18190', '18230', '18231', '18232', '18233', '18234', '18235', '18236', '18237', '18238', '18239', '18245', '18246', '18247', '18248', '18249', '18250', '18252', '18253', '18254', '18255', '18256', '18257', '18260', '18261', '18262', '18263', '18264', '18265', '18266', '18267', '18268', '18269', '18270', '18273', '18274', '18275', '18276', '18277', '18278', '18279', '18291', '18330', '18331', '18332', '18333', '18334', '18335', '18336', '18337', '18338', '18339', '18348', '18349', '18350', '18351', '18352', '18353', '18354', '18355', '18356', '18357', '18358', '18359', '18360', '18361', '18362', '18363', '18364', '18365', '18366', '18367', '18368', '18369', '18370', '18371', '18377', '18378', '18379', '18730', '18731', '18732', '18733', '18734', '18735', '18736', '18737', '18738', '18740', '18741', '18742', '18743', '18744', '18745', '18746', '18750', '18751', '18752', '18753', '18754', '18762', '18763', '18764', '18765', '18766', '18767', '18768', '18769', '19133', '19134', '19135', '19136', '19137', '19138', '19139', '19140', '19141', '19142', '19143', '19144', '19145', '19146', '19147', '19148', '19149', '19150', '19160', '19161', '19163', '19164', '19251', '19252', '19253', '19254', '19255', '19256','19257','19258','19259','12956','17230','17231','17232','17233','17234','17235','17236','17237','17238','17239','17240','17241','17262','17263','17264','17265','17266','17267','17268','17269','17270','17271','17272','17273','17274','17275','17276','17277','17278','17279','17441','17442','17443','17444','17445','17446','17447','17448','17449','17450','17451','17452','17453','17454','17455','17456','17457','17458','17459','17460','17461','17462','17463','17464','17465','17466'];

    public static $locality = [
        'stockholm', 'årsta', 'enskededalen', 'johanneshov', 'enskede', 'hägersten', 'nacka', 'bromma', 'solna', 'lidingö', 'danderyd', 'enebyberg', 'djursholm', 'stocksund', 'täby', 'sollentuna','sundbyberg'];

    /*
     * Generate client with Budbee API and send this to the controllers
     */
    public static function getClient()
    {
        // Budbee API information
        $devKey = '7ffde9b5-48ef-4d99-a836-c6dead99c752';
        $devSsecret = '856c973c-d3d3-4d41-8541-819e3f5e0500ec6378af-950c-4082-bd95-f27883eab3ff';

        // Production keys
        $key = '401d3c76-d8a1-4ae8-8cc2-6f0fa2e25543';
        $secret = '19781b8d-2df3-408e-97b2-8ff09285d0ac0335a63d-0387-4179-afae-e739e9f5bc40';

        return new \Budbee\Client($key, $secret, \Budbee\Client::$PRODUCTION);
    }

    /**
     * Receive X weeks from Budbee and only display
     * the dates that have 4 days difference at least
     * @param $client
     * @param $weeks
     * @return array
     */
    public static function getXWeeks($client, $weeks)
    {
        $intervalApi = new Budbee\IntervalApi($client);
        $interval = $intervalApi->getIntervals($weeks);

        $dates = array();
        for ($i = 0; $i < $weeks; $i++) {
            $date = $interval[$i]->delivery->stop->format('Y-m-d');
            $dateDiff = time() - strtotime($date);
            $daysBetween = abs(floor($dateDiff / (60 * 60 * 24)));

            if ($daysBetween >= 4) {
                array_push($dates, $date);
            }
        }
        return $dates;
    }

    public static function getFirstWeek($client){
        $intervalApi = new Budbee\IntervalApi($client);
        $interval = $intervalApi->getIntervals(10);

        return $interval[0]->delivery->stop->format('Y-m-d');
    }

    /**
     * Select only dates that are after the start date for the user
     * @param $weeks
     * @param $startDate
     * @return array
     */
    public static function getXWeeksFromStartDate($weeks, $startDate)
    {
        $dates = [];

        foreach ($weeks as $week) {
            if ($week >= $startDate) {
                array_push($dates, $week);
            }
        }
        return $dates;
    }

    /**
     * Receive 10 weeks and and only display
     * the dates that have 4 days difference at least
     * @param $client
     * @return array
     */
    public static function getEveryOtherWeekFromStartDate($client, $startDate)
    {
        $weeks = 11;
        $intervalApi = new Budbee\IntervalApi($client);
        $interval = $intervalApi->getIntervals($weeks);
        $dates = array();

        // Convert date to week
        $startDateWeek = new DateTime($startDate);
        $startDateWeek = $startDateWeek->format("W");

        // Check if start date is even or odd
        $isEvenWeek = $startDateWeek % 2;

        for ($i = 0; $i < $weeks; $i++) {
            $date = $interval[$i]->delivery->stop->format('Y-m-d');
            $dateDiff = time() - strtotime($date);
            $daysBetween = abs(floor($dateDiff / (60 * 60 * 24)));

            $week = new \DateTime($date);
            $week = $week->format("W");
            $weekEven = $week % 2;

            if ($daysBetween >= 3 && $date >= $startDate) {

                if ($isEvenWeek && $weekEven) {
                    array_push($dates, $date);
                }

                if (!$isEvenWeek && !$weekEven) {
                    array_push($dates, $date);
                }
            }
        }
        return $dates;
    }


    /**
     *  Check if city is valid.
     *  code is valid
     * @return string
     */
    public static function checkCity()
    {
        $userCity = mb_strtolower(Request::input('city'), 'UTF-8');

        if (!empty($userCity)) {
            if (in_array($userCity, BudbeeOrders::$locality)) {
                return true;
            }
        }
        return false;
    }

    /**
     *  Examine user input and return if postal
     *  code is valid
     * @return string
     */
    public static function checkPostalCodeProfile($postalCode)
    {
        if (!empty($postalCode)) {
            // Only NUMBERS
            $postalCodeNumbers = preg_replace('/[^0-9]/', '', $postalCode);

            if (in_array($postalCodeNumbers, BudbeeOrders::$validPostalCode)) {
                return true;
            } // Store the invalid address for later use
            else {
                $invalidPostalcode = new \App\InvalidPostalcodes();
                $invalidPostalcode->postalcode = $postalCodeNumbers;
                $invalidPostalcode->save();

                return false;
            }
        }
    }

    /**
     *  Examine user input and return if postal
     *  code is valid
     * @return string
     */
    public static function checkPostalCode()
    {
        $userPostal = Request::input('postalCode');

        // Only NUMBERS
        $postalCodeNumbers = preg_replace('/[^0-9]/', '', $userPostal);

        if (!empty($userPostal)) {
            if (in_array($postalCodeNumbers, BudbeeOrders::$validPostalCode)) {
                return true;
            } // Store the invalid address for later use
            else {
                $invalidPostalcode = new \App\InvalidPostalcodes();
                $invalidPostalcode->postalcode = $postalCodeNumbers;
                $invalidPostalcode->save();

                return false;
            }
        }
    }

    /**
     * Testing 200 fake users
     * @param $client
     */
    public static function testBudbee200($client)
    {
        $orders = array();
        $intervalApi = new Budbee\IntervalApi($client);
        $user = \App\User::find(4);

        $faker = \Faker\Factory::create('sv_SE');

        for ($i = 0; $i < 123; $i++) {
            // Cart object
            $cart = new Budbee\Model\Cart();
            $cart->cartId = $user->id . uniqid(); // string

            // Assume user want standard bag otherwise take alternative
            $currentDinner = $user->dinnerProduct;
            if (!empty($user->dinnerProductAlternative)) {
                $currentDinner = $user->dinnerProductAlternative;
            }
            // Find the dinner bag
            $currentDinnerProduct = \App\Products::find($currentDinner);

            // Create article from the dinner product
            $dinnerArticle = new Budbee\Model\Article();
            $dinnerArticle->reference = $currentDinnerProduct->reference; // string - article number
            $dinnerArticle->name = $currentDinnerProduct->title; // string - article name
            $dinnerArticle->quantity = $user->dinnerProductAmount; // int
            $dinnerArticle->unitPrice = $currentDinnerProduct->price; // int
            $dinnerArticle->taxRate = 0; // int - VAT rate of article * 100
            $dinnerArticle->discountRate = 0; // int

            // Push back article if not empty otherwise create array
            if (!empty($cart->articles)) {
                array_push($cart->articles, $dinnerArticle);
            } else {
                $cart->articles[] = $dinnerArticle;
            }

            // dimensions - optional
            $dimension = new Budbee\Model\Dimensions();
            $dimension->width = 400; // int cm
            $dimension->length = 170; // int cm
            $dimension->height = 320; // int cm
            $dimension->weight = 2000; // int gram
            $cart->dimensions = $dimension;

            // Contact object - delivery
            $contactDelivery = new Budbee\Model\Contact();
            $contactDelivery->name = $faker->name; // string
            $contactDelivery->referencePerson = ''; // string
            $contactDelivery->telephoneNumber = $faker->phoneNumber; // string
            $contactDelivery->email = $faker->email; // string - optional

            $address = new Budbee\Model\Address();
            $address->street = 'Valhallavägen 22'; // string
            $address->street2 = ''; // string - optional
            $address->postalCode = '11422'; // string
            $address->city = 'Stockholm'; // string
            $address->country = 'SE'; // string

            $contactDelivery->address = $address;
            $contactDelivery->additionalInfo = ''; // string
            $contactDelivery->doorCode = ''; // string
            $contactDelivery->outsideDoor = true; // boolean - optional

            // Order object
            $order = new Budbee\Model\Order();
            $order->interval = $intervalApi->getIntervals(1)[0];
            $order->cart = $cart;
            $order->delivery = $contactDelivery;

            // Merge orders
            array_push($orders, $order);
        }

        //\App\BudbeeOrders::debug($orders);

        // Send orders to Budbee backend
        $orderApi = new Budbee\OrderApi($client);
        $budbeeOrders = $orderApi->createOrder($orders);

        echo 'budbee orders: ' . sizeof($budbeeOrders);
    }


    /**
     * Receive all users and examine if user is still active
     * and want products for the current week. Then for each user
     * create a budbee order.
     * @param $client
     */
    public static function createOrder($client)
    {
        $users = \App\User::where('active', '=', '1')->get();
        $intervalApi = new Budbee\IntervalApi($client);
        $orders = array();
        $payedUsers = array();
        $twoDaysForward = \App\User::getAnyDays("+2"); // 2 days from tuesday to thursday

        foreach ($users as $u) {
            $startDate = $u->startDate;

            // Only charge users that have started their subscription or is active
            if ($twoDaysForward >= $startDate && $u->payed) {
                $interval = $u->interval;
                $nextDelivery = \App\BudbeeOrders::getFirstWeek($client);
                $skipWeek = explode(", ", $u->skipDate); // Get weeks user not want to have delivery

                // Check if user have different interval
                if (strcmp($interval, 'everySecondWeek') == 0) {
                    $nextDelivery = \App\BudbeeOrders::getEveryOtherWeekFromStartDate($client, $u->startDate)[0];
                }

                // Override next delivery if user has not started yet
                if (strcmp($startDate, $twoDaysForward) == 0) {
                    $nextDelivery = $startDate;
                }

                // Create order only users with orders this week
                if ($twoDaysForward >= $nextDelivery && !in_array($twoDaysForward, $skipWeek)) {
                    // Cart object
                   $cart = new Budbee\Model\Cart();
                    $cart->cartId = $u->id.uniqid(); // string

                    // Split string to array with extra products
                    $extra = explode(", ", $u->extraProductCurrent);
                    $extraProducts = \App\Products::getExtra();

                    // Receive all extra products from user
                    for ($i = 0; $i < sizeof($extraProducts); $i++) {
                        // articles - optional
                        // Only create new article if extra product > 0
                        if ($extra[$i] > 0) {
                            $article = new Budbee\Model\Article();
                            $article->reference = $extraProducts[$i]->title; // string - article number
                            $article->name = $extraProducts[$i]->title; // string - article name
                            $article->quantity = $extra[$i]; // int
                            $article->unitPrice = $extraProducts[$i]->price; // int
                            $article->taxRate = 0; // int - VAT rate of article * 100
                            $article->discountRate = 0; // int

                            // Add item to the end of the list
                            $cart->articles[$i] = $article;
                        }
                    }

                    // Assume user want standard bag otherwise take alternative
                    $currentDinner = $u->dinnerProduct;
                    if (!empty($u->dinnerProductAlternative)) {
                        $currentDinner = $u->dinnerProductAlternative;
                    }
                    // Find the dinner bag
                    $currentDinnerProduct = \App\Products::find($currentDinner);

                    // Create article from the dinner product
                    $dinnerArticle = new Budbee\Model\Article();
                    $dinnerArticle->reference = $currentDinnerProduct->title; // string - article number
                    $dinnerArticle->name = $currentDinnerProduct->title; // string - article name
                    $dinnerArticle->quantity = $u->dinnerProductAmount; // int
                    $dinnerArticle->unitPrice = $currentDinnerProduct->price; // int
                    $dinnerArticle->taxRate = 0; // int - VAT rate of article * 100
                    $dinnerArticle->discountRate = 0; // int

                    // Push back article if not empty otherwise create array
                    if (!empty($cart->articles)) {
                        array_push($cart->articles, $dinnerArticle);
                    } else {
                        $cart->articles[] = $dinnerArticle;
                    }

                    // dimensions - optional
                    $dimension = new Budbee\Model\Dimensions();
                    $dimension->width = 400; // int cm
                    $dimension->length = 170; // int cm
                    $dimension->height = 320; // int cm
                    $dimension->weight = 2000; // int gram
                    $cart->dimensions = $dimension;

                    // Contact object - delivery
                    $contactDelivery = new Budbee\Model\Contact();
                    $contactDelivery->name = $u->name; // string
                    $contactDelivery->referencePerson = ''; // string
                    $contactDelivery->telephoneNumber = $u->telephoneNumberDriver; // string
                    $contactDelivery->email = $u->email; // string - optional

                    $address = new Budbee\Model\Address();
                    $address->street = $u->street; // string
                    $address->street2 = ''; // string - optional
                    $address->postalCode = $u->postalCode; // string
                    $address->city = $u->city; // string
                    $address->country = 'SE'; // string

                    $contactDelivery->address = $address;
                    $contactDelivery->additionalInfo = $u->additionalInfo; // string
                    $contactDelivery->doorCode = $u->doorCode; // string
                    $contactDelivery->outsideDoor = true; // boolean - optional

                    // Order object
                    $order = new Budbee\Model\Order();
                    $order->interval = $intervalApi->getIntervals(1)[0];
                    $order->cart = $cart;
                    $order->delivery = $contactDelivery;

                    // Merge orders
                    array_push($orders, $order);
                    // Merge weekly users
                    array_push($payedUsers, $u);
                }
            }
        }

        // Send orders to Budbee backend if not empty
        if(!empty($payedUsers)&&!empty($orders)){
            $orderApi = new Budbee\OrderApi($client);
            $budbeeOrders = $orderApi->createOrder($orders);

            // Create and insert budbee orders
            for ($i = 0; $i < sizeof($budbeeOrders); $i++) {
                $bOrders = new BudbeeOrders();
                $bOrders->userID = $payedUsers[$i]->id;
                $bOrders->budbeeID = $budbeeOrders[$i]->id;
                $bOrders->save();
            }

            // Send mail to Owners with dinners/extra in a excel file.
            \App\Order::weeklyMail($payedUsers);

            // Clear currrent payed user
            \App\User::clearExtraAndAlternativeProducts($payedUsers);
        }
    }


    /**
     * Show all orders from budbee
     */
    public
    static function show($client)
    {
        $orderApi = new Budbee\OrderApi($client);
        \App\BudbeeOrders::debug($orderApi->getOrders());
    }


    /**
     * Prettify print what ever you like
     * @param $x
     */
    public static function debug($x)
    {
        echo "<pre>";
        print_r($x);
        echo "</pre>";
    }

}
