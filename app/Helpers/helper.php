<?php

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

const API_SECRET_KEY = 'EH5m5%$+3V$7Ue4j3*Kc5UzA4Mq7TXEt8a!8^AJ#';

function authUser (): ?Authenticatable
{
    return Auth::user();
}

/**
 * @param null $array
 * @return array|bool
 */
//function adminSetting ($array = null)
//{
//    if (!isset($array[0])) {
//        $adminSettings = AdminSetting::get();
//        if ($adminSettings) {
//            $output = [];
//            foreach ($adminSettings as $setting) {
//                $output[$setting->slug] = $setting->value;
//            }
//
//            return $output;
//        }
//
//        return null;
//    } elseif (is_array($array)) {
//        $adminSettings = AdminSetting::whereIn('slug', $array)->get();
//        if ($adminSettings) {
//            $output = [];
//            foreach ($adminSettings as $setting) {
//                $output[$setting->slug] = $setting->value;
//            }
//
//            return $output;
//        }
//
//        return null;
//    } else {
//        $adminSettings = AdminSetting::where(['slug' => $array])->first();
//        if ($adminSettings) {
//            $output = $adminSettings->value;
//
//            return $output;
//        }
//
//        return null;
//    }
//}

/**
 * @param string $message
 * @param string $recipients
 * @throws ConfigurationException
 * @throws TwilioException
 */
function sendSMS (string $message, string $recipients)
{
    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);
    $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
}

/**
 * @param $file
 * @param $destinationPath
 * @param null $oldFile
 * @return bool|string
 */
function uploadFile ($file, $destinationPath, $oldFile = null)
{
    if ($oldFile != null) {
        deleteFile($destinationPath, $oldFile);
    }

    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    $uploaded = Storage::put($destinationPath . $fileName, file_get_contents($file->getRealPath()));
    if ($uploaded == true) {
        $name = $fileName;
        return $name;
    }
    return false;
}

/**
 * @param $destinationPath
 * @param $file
 */
function deleteFile ($destinationPath, $file)
{
    if ($file != null) {
        try {
            Storage::delete($destinationPath . $file);
        } catch (\Exception $e) {

        }
    }
}

/**
 * @param $subject
 * @return false|int
 */
function isPhone ($subject)
{
    return preg_match('/^(01){1}[1-9]{1}[0-9]{8}$/', $subject);
}

/**
 * @param string $input
 * @return string
 */
function strtosnake (string $input): string
{
    $output ='';
    $index = 0;
    for ($i=1; $i<strlen($input); $i++) {
        if ($input[$i]>='A'&&$input[$i]<='Z') {
            $output .= substr($input, $index, $i-$index).'_';
            $index = $i;
        }
    }
    return strtolower($output.substr($input, $index, strlen($input)-$index));
}

/**
 * @param null $input
 * @return array|mixed
 */
function numbersMultipliers ($input = null)
{
    $output = [
        THOUSAND => __('K'),
        MILLION => __('M'),
        BILLION => __('B'),
        TRILLION => __('T'),
        QUADRILLION => __('Q'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param int $input
 * @param int $precision
 * @return float|int|mixed|string
 */
function convertToMultiplier ($input=0, $precision=2){
    if($input>0){
        return $input>=QUADRILLION ? round($input/QUADRILLION, $precision).' '.numbersMultipliers(QUADRILLION) :
            ($input>=TRILLION ? round($input/TRILLION, $precision).' '.numbersMultipliers(TRILLION) :
                ($input>=BILLION ? round($input/BILLION, $precision).' '.numbersMultipliers(BILLION) :
                    ($input>=MILLION ? round($input/MILLION, $precision).' '.numbersMultipliers(MILLION) :
                        ($input>=THOUSAND ? round($input/THOUSAND, $precision).' '.numbersMultipliers(THOUSAND) : round($input, $precision)))));
    }
    return $input;
}

/**
 * @return string
 */
function logoPath ()
{
    return 'public/logo/';
}

/**
 * @return string
 */
function logoViewPath ()
{
    return 'storage/logo/';
}

/**
 * @return string
 */
function documentManualPath ()
{
    return 'public/document-manual/';
}

/**
 * @return string
 */
function documentManualViewPath ()
{
    return '/storage/document-manual/';
}

/**
 * @return string
 */
function timelinePath ()
{
    return 'public/timeline/';
}

/**
 * @return string
 */
function timelineViewPath ()
{
    return '/storage/timeline/';
}

/**
 * @return string
 */
function avatarPath ()
{
    return 'public/avatar/';
}

/**
 * @return string
 */
function avatarViewPath ()
{
    return 'storage/avatar/';
}

/**
 * @param null $input
 * @return string|string[]
 */
function weekDays ($input = null)
{
    $output = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday'
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @return int
 */
function thisDay ()
{
    return Carbon::now()->day;
}

/**
 * @return int
 */
function thisMonth ()
{
    return Carbon::now()->month;
}

/**
 * @return int
 */
function thisYear ()
{
    return Carbon::now()->year;
}

/**
 * @param null $input
 * @return string|string[]
 */
function monthsOfYear ($input = null)
{
    $output = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @param null $year
 * @return int|int[]
 */
function daysOfMonth ($input = null, $year=null)
{
    $year = is_null($year) ? thisYear() : $year;
    $output = [
        1 => 31,
        2 => $year%400==0||($year%4==0&&$year%100!=0) ? 29 : 28,
        3 => 31,
        4 => 30,
        5 => 31,
        6 => 30,
        7 => 31,
        8 => 31,
        9 => 30,
        10 => 31,
        11 => 30,
        12 => 31
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function weekDaysWithLanguage ($input = null)
{
    $output = [
        1 => __('Monday'),
        2 => __('Tuesday'),
        3 => __('Wednesday'),
        4 => __('Thursday'),
        5 => __('Friday'),
        6 => __('Saturday'),
        7 => __('Sunday')
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param int $length
 * @return string
 */
function randomNumber ($length = 10)
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $response = '';
    for ($i = 0; $i < $length; $i++) {
        $y = rand(0, $c);
        $response .= substr($x, $y, 1);
    }

    return $response;
}


/**
 * @param null $input
 * @return string|string[]
 */
function bloodGroups ($input = null)
{
    $bloodGroups = [
        "1" => "A+",
        "2" => "A-",
        "3" => "B+",
        "4" => "B-",
        "5" => "O+",
        "6" => "O-",
        "7" => "AB+",
        "8" => "AB-",
    ];

    if (is_null($input)) {
        return $bloodGroups;
    } else {
        return $bloodGroups[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function userRoles ($input = null)
{
    $output = [
        ADMIN_ROLE => __('Admin'),
        STUDENT_ROLE => __('Student'),
        TEACHER_ROLE => __('Teacher'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function accountTypes ($input = null)
{
    $output = [
        STUDENT_ROLE => __('Student'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array
 */
function genders  ($input = null)
{
    $output = [
        SEX_MALE => __('Male'),
        SEX_FEMALE => __('Female'),
        SEX_OTHER => __('Others'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function connections  ($input = null)
{
    $output = [
        CONNECTION_TYPE_FRIEND => __('Friend'),
        CONNECTION_TYPE_COLLABORATOR => __('Collaborator'),
        CONNECTION_TYPE_MENTOR => __('Mentor'),
        CONNECTION_TYPE_MENTEE => __('Mentee'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function connectionTypes  ($input = null)
{
    $output = [
        CONNECTION_TYPE_ALL => __('All'),
        CONNECTION_TYPE_FRIEND => __('Friend'),
        CONNECTION_TYPE_COLLABORATOR => __('Collaborator'),
        CONNECTION_TYPE_MENTOR => __('Mentor'),
        CONNECTION_TYPE_MENTEE => __('Mentee'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


/**
 * @param null $input
 * @return array|mixed
 */
function connectionStatuses  ($input = null)
{
    $output = [
        STATUS_PENDING => __('Pending'),
        STATUS_INACTIVE => __('Inactive'),
        STATUS_ACTIVE => __('Active'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function talkTypes  ($input = null)
{
    $output = [
        TALK_TYPE_TALKIYON_OFFICIAL => __('Talkiyon Official'),
        TALK_TYPE_PUBLIC => __('Public'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function talkFileTypes  ($input = null)
{
    $output = [
        TALK_FILE_TYPE_IMAGE => __('Image'),
        TALK_FILE_TYPE_DOCUMENT => __('Document'),
        TALK_FILE_TYPE_VIDEO => __('Video'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function talkSecurityTypes  ($input = null)
{
    $output = [
        TALK_SECURITY_TYPE_PUBLIC => __('Public'),
        TALK_SECURITY_TYPE_SPECIFIC => __('Specific'),
        TALK_SECURITY_TYPE_CONNECTION => __('Connection'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function paymentMethods ($input = null)
{
    $output = [
        PAYMENT_METHOD_BKASH => __('Bkash'),
        PAYMENT_METHOD_ROCKET => __('Rocket'),
        PAYMENT_METHOD_NAGAD => __('Nagad'),
        PAYMENT_METHOD_BANK => __('Bank'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function bankTransactionTypes ($input = null)
{
    $output = [
        BANK_TRANSACTION_TYPE_ADDITION => __('Addition'),
        BANK_TRANSACTION_TYPE_WITHDRAWAL => __('Withdrawal'),
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

/**
 * @param null $input
 * @return array|mixed
 */
function feedbackTypes ($input = null)
{
    $output = [
        FEEDBACK_TYPE_SUGGESTION => __('Suggestion'),
        FEEDBACK_TYPE_PROBLEM => __('Problem'),
        FEEDBACK_TYPE_APPRECIATION => __('Appreciation'),

        FEEDBACK_TYPE_OTHERS => __('Others')//Always at last
    ];

    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
