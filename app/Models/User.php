<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Illuminate\Support\Facades\Log;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'city', 'street', 'doorCode', 'postalCode', 'telephoneNumber', 'telephoneNumberDriver', 'additionalInfo', 'interval', 'startDate', 'skipDate','extraProductCurrent','extraProductNext','extraProductPrice', 'dinnerProduct','dinnerProductAlternative','dinnerProductAlternativePrice','dinnerProductPrice','dinnerProductAmount','payexID','active','payed','role'];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // Rules for customer form
    public static $messages = [
        'firstName.required' => 'Ni har glömt att fylla i ert namn.',
        'lastName.required' => 'Ni har glömt att fylla i ert efternamn.',
        'city.required' => 'Ni har glömt att fylla i er ort.',
        'city.alpha' => 'Ort får endast innehålla bokstäver a-ö.',
        'street.required' => 'Ni har glömt att fylla i er gatuadress.',
        'password.required' => 'Ni har glömt att fylla i ett lösenord.',
        'passwordConfirm.required' => 'Ni har glömt att fylla i ett lösenord.',
        'confirmAgreement.required' => 'Ni har glömt att bekräfta villkoren.',
        'postalCode.required' => 'Ni har glömt att fylla i ert postnummer',
        'postalCode.min' => 'Postnummret måste minst vara 5 siffror.',
        'postalCode.numeric' => 'Postnummret får endast innehålla siffor.',
        'telephoneNumber.required' => 'Ni har glömt att fylla i er mobiltelefon.',
        'telephoneNumber.numeric' => 'Mobiltelefonnummer får endast innehålla siffror 0-9',
				'telephoneNumber.max' => 'Mobiltelefonnummer måste vara högst 10 siffror',
        'telephoneNumberDriver.required' => 'Ni har glömt att fylla i mobiltelefon för leverans.',
        'telephoneNumberDriver.numeric' => 'Mobiltelefonnummer för leverans får endast innehålla siffror 0-9',
        'email.required' => 'Ni har glömt att fylla i er e-post.',
        'emailConfirm.required' => 'Ni har glömt att fylla i er e-post.',
        'email.unique' => 'Epostadressen är tyvärr upptagen.',
        'password.min' => 'Lösenordet måste vara minst 5 bokstäver långt.',
        'passwordConfirm.min' => 'Lösenordet måste vara minst 5 bokstäver långt.',
    ];

    public static $rules = [
        'firstName' => 'required',
        'interval' => 'required',
        'lastName' => 'required',
        'firstDelivery' => 'required',
        'street' => 'required',
        'postalCode' => 'required|numeric|min:5',
        'city' => 'required|alpha',
        'telephoneNumber' => 'required|numeric|min:10',
        'telephoneNumberDriver' => 'required|numeric|min:10',
        'email' => 'required|email|unique:users',
        'emailConfirm' => 'required|email',
        'password' => 'required|min:5',
        'passwordConfirm' => 'required|min:5',
        'confirmAgreement' => 'required'];

    public function __construct(){
        date_default_timezone_set('Europe/Stockholm');
    }

    /*
     * Receive weeks and split string to array
     */
    public static function profileSkipDates($skip, $dates)
    {
        $weeks = explode(", ", $skip);
        $results = $dates;
        for ($i = 0; $i < sizeof($dates); $i++) {
            foreach ($weeks as $w) {
                if ($w === $dates[$i]) {
                    $results[$i] = "No";
                }
            }
        }
        return $results;
    }

    /**
     * Open invoice folder and receive all
     * PDFS for user then pass PDF to the view
     * @param $user
     * @return array
     */
    public static function getPDF($user)
    {
        // $path = str_replace('laravel_files', '', base_path()); // Remove name 'laravel_files' from public link
        // $dir = $path . "invoice/".$user->id.'/';
        // $files = scandir($dir);
        $showFiles = array();

        // foreach($files as $file)
        // {
        //     if($file != '.' && $file != '..'){
        //         array_push($showFiles, $file);
        //     }
        // }
        return $showFiles;
    }

    /**
     * Get local time in Stockholm
     * @return array
     */
    public static function getTime()
    {
        // Get current time
        $localtime_assoc = localtime(time(), true);

        $h = (int)$localtime_assoc['tm_hour'];
        $hour = $h < 10 ? "0" . $h : $h;
        $m = (int)$localtime_assoc['tm_min'];
        $minutes = $m < 10 ? "0" . $m : $m;

        return $hour . ':' . $minutes;
    }

    /**
     * Get current date
     * @return mixed
     */
    public static function getCurrentDate(){
        $date = new DateTime();
        return $date->format('Y-m-d');
    }

    /**
     * Get any date forward or backward
     * @param $days
     * @return bool|string
     */
    public static function getAnyDays($days){
        $today = \App\User::getCurrentDate();
        $modifiedDate = strtotime($days." day", strtotime($today));

        return date("Y-m-d", $modifiedDate);
    }

    /**
     * Return current date with time
     * @return string
     */
    public static function getTimeAndDate(){
        return date('Y-m-d h:i:s', time());
    }


    /**
     * Get the day before
     * @return bool|string
     */
    public static function getRegistrationDate(){
        date_default_timezone_set('Europe/Stockholm');

        $today = date('Y-m-d h:i:s');
        $modifiedDate = strtotime("-1 day", strtotime($today));
        return date("Y-m-d h:i:s", $modifiedDate);
    }

    /**
     * Transalate interval to swedish
     */
    public static function intervalClearText($userInterval){
        $interval = '';
        if ($userInterval === 'eachWeek') {
            $interval = 'varje';
        } else {
            $interval = 'varannan';
        }
        return $interval;
    }


    /**
     * Get weeks and create string
     * @param $weeks
     * @return string
     */
    public static function weeksToString($weeks)
    {
        $skip = '';
        $size = sizeof($weeks);
        for ($i = 0; $i < $size; $i++) {
            if (($i + 1) == $size) {
                $skip .= $weeks[$i];
            } else {
                $skip .= $weeks[$i] . ', ';
            }
        }
        return $skip;
    }

    /**
     *  User shall not cancel if date equal and time greater than 21
     */
    public static function getCurrentDay($fiveWeeks)
    {
        // $currentTime = \App\User::getTime();
        // $diff = abs(strtotime($fiveWeeks[0]) - strtotime($currentTime));
        // return floor($diff / (60 * 60 * 24));
        return 0;
    }

    /**
     * Receive current date and increment with two days
     * @param $date
     * @return int
     */
    public static function getBillingDate($date){
        $modifiedDate = strtotime("-4 day", strtotime($date));
        return date("Y-m-d", $modifiedDate);
    }

    /**
     * Create user from form data
     * @param $input
     * @return User
     */
    public static function createUser($input)
    {
        $user = new User();
        $user->name = strip_tags($input['firstName'] . ' ' . $input['lastName']);
        $user->password = Hash::make(strip_tags($input['password']));
        $user->street = strip_tags($input['street']);
        $user->doorCode = strip_tags($input['doorCode']);
        $user->postalCode = strip_tags($input['postalCode']);
        $user->city = strip_tags($input['city']);
        $user->telephoneNumber = strip_tags($input['telephoneNumber']);
        $user->telephoneNumberDriver = strip_tags($input['telephoneNumberDriver']);
        $user->interval = strip_tags($input['interval']);
        $user->email = strip_tags($input['email']);
        $user->dinnerProduct = strip_tags($input['dinnerProduct']);
        $user->dinnerProductPrice = strip_tags($input['dinnerProductPrice']);
        $user->dinnerProductAmount = '1';
        $user->additionalInfo = strip_tags($input['additionalInfo']);
        $user->startDate = strip_tags($input['firstDelivery']);
        $user->active = false;
        $user->role = 'User';
        $user->extraProductNext = '0, 0, 0';
        $user->extraProductCurrent = '0, 0, 0';
        $user->extraProductPrice = 0;
        $user->save();

        return $user;
    }


    /**
     * Clear alternative and extra products for paying customers
     */
    public static function clearExtraAndAlternativeProducts($users)
    {
        foreach ($users as $u) {

            $user = \App\User::find($u->id);
            Log::info($user);

            $user = \App\User::find($u->id);
            $user->extraProductCurrent = '0, 0, 0';
            $user->extraProductNext = '0, 0, 0';
            $user->extraProductPrice = 0;
            $user->dinnerProductAlternative = '';
            $user->dinnerProductAlternativePrice = 0;
            $user->dinnerProductAmount = 1;
            $user->save();
        }
    }

}
