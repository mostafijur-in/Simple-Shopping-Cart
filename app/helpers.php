<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// use Exception;

// use Illuminate\Http\Request;

/** ----------------------------------------------------------------------------------
 * Function: product_img_src
 *
 * @param   string     $img_path
 * @param   string     $size
 *
 * @return  string image url
 * Author: https://gitlab.com/mostafijur-in/
 * ------------------------------------------------------------------------------- */
function product_img_src($img_path = null, $size = "640x480")
{
    if(empty($img_path)) {
        $src   = "https://via.placeholder.com/{$size}.png/?text={$size}";
    } else {
        $src   = asset('storage/' . $img_path);
    }
    return $src;
}


/** ----------------------------------------------------------------------------------
 * Function: user_name
 * @param   int $user_id
 *
 * @return  string User Name
 * Author: https://gitlab.com/mostafijur-in/
 * ------------------------------------------------------------------------------- */
function user_name(int $user_id)
{
    return \App\Models\User::where('id', $user_id)->value('name');
}

/** ----------------------------------------------------------------------------------
 * Function: ol_rupee
 *
 * @param   float   $amount
 * @param   int     $decimal
 *
 * @return  string Amount (rupees) with symbol
 *
 * Author: https://gitlab.com/mostafijur-in/
 * ------------------------------------------------------------------------------- */
function ol_rupee($amount, $decimal = 2)
{
    $rupees    = '&#8377; ' . number_format($amount, $decimal);
    return $rupees;
}


/** ----------------------------------------------------------------------------------
 * Function: localize_date
 *
 * @param   string|int  $date   => Valid date string or Unix TimeStamp
 * @param   string      $format => date format (default: d-m-Y)
 *
 * @return  string Date string
 *
 * Author: https://gitlab.com/mostafijur-in/
 * ------------------------------------------------------------------------------- */
function localize_date($date, string $format = "d-m-Y")
{
    if (empty($date)) {
        return false;
    }
    if (is_numeric($date)) {
        $timestamp  = $date;
    } else {
        $timestamp  = strtotime($date);
    }
    return date($format, $timestamp);
}

/** ----------------------------------------------------------------------------------
 * Function: convert_date
 * @param   string  $date
 * @param   string  $format         - Given date format (d-m-Y)
 * @param   string  $return_format  - Return date in this format (Y-m-d)
 *
 * @return  bool    -> true if valid, else false
 *
 * Author: https://gitlab.com/rahaman-m/
 * ------------------------------------------------------------------------------- */
function convert_date($date, $format = 'd-m-Y', $return_format = 'Y-m-d')
{
    $dateObj    = date_create_from_format($format, $date);
    if (!$dateObj) {
        return false;
    }
    return date_format($dateObj, $return_format);
}

/** ----------------------------------------------------------------------------------
 * Function: isValidDate
 * @param   string  $date
 * @param   string  $format     - Given date format (d-m-Y)
 * @param   string  $separator  - Date format separator (-)
 *
 * @return  bool    -> true if valid, else false
 *
 * Author: https://gitlab.com/rahaman-m/
 * ------------------------------------------------------------------------------- */
function isValidDate($date, $format = 'd-m-Y', $separator = '-', $datetime_separator = ' ')
{
    $result = true;

    // $date1 = explode($datetime_separator, $date);
    $date1 = convert_date($date, $format, 'Y-m-d');
    if (!$date1) {
        return false;
    }
    $date1 = explode($separator, $date1);

    $date2 = date_parse_from_format($format, $date);

    if (intval($date1[2]) !== $date2['day'] || intval($date1[1]) !== $date2['month'] || intval($date1[0]) !== $date2['year']) {
        $result = false;
    } else {
        $dt = new DateTime($date);

        $errors = DateTime::getLastErrors();
        if (!empty($errors['warning_count'])) {
            $result = false;
        }
    }

    return $result;
}

/** ----------------------------------------------------------------------------------
 * Function: isValidPhone
 * @param   string  $phone
 * @param   int     $min_len
 * @param   int     $max_len
 *
 * @return  bool
 *
 * Author: https://gitlab.com/rahaman-m/
 * ------------------------------------------------------------------------------- */
function isValidPhone($phone, $min_len = 10, $max_len = 10)
{
    $numbers = preg_replace("/[^\d]/", "", $phone);
    if (strlen($numbers) < $min_len) {
        return false;
    } elseif (!empty($max_len)) {
        if (strlen($numbers) > $max_len) {
            return false;
        }
    }

    return true;
}

/** ----------------------------------------------------------------------------------
 * Function: isValidEmail
 * @param   string  $email
 *
 * @return  bool
 *
 * Author: https://gitlab.com/rahaman-m/
 * ------------------------------------------------------------------------------- */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/** ----------------------------------------------------------------------------------
 * Function: validPassword
 * @param   string  $pass
 * @param   int     $min_len
 * @param   int     $max_len
 *
 * @return  array   - [true|false, error_message].
 *
 * Author: https://gitlab.com/rahaman-m/
 * ------------------------------------------------------------------------------- */
function validPassword($password, int $min_len = 6, int $max_len = 20)
{
    $errMsg    = '';

    if ((strlen($password) < $min_len) || (strlen($password) > $max_len)) {
        $errMsg    .= 'Password length must be between 6 - 20 characters.';
    } else {

        $uppercase    = preg_match('@[a-zA-Z]@', $password);
        // $lowercase	= preg_match('@[a-z]@', $password);
        $number        = preg_match('@[0-9]@', $password);
        // $spChars	= preg_match('#\W+#', $password);

        if (!$uppercase || !$number) {
            $errMsg    .= 'Password must be the combination letters (a-z) and numbers (0-9), ';
        }
        // if(!$lowercase) {
        // 	$errMsg	.= 'Lowercase letter missing, ';
        // }
        // if(!$number) {
        // 	$errMsg	.= 'At least 1 number (0-9) required, ';
        // }
        // if(!$spChars) {
        // 	$errMsg	.= 'Special character missing (allowed @#$*%), ';
        // }
    }

    if (empty($errMsg)) {
        return [true, ""];
    } else {
        return [false, $errMsg];
    }
}


/** ----------------------------------------------------------------------------------
 * Function: slugify
 * @param   string  $string
 *
 * @return  string   - slug.
 *
 * Author: https://gitlab.com/rahaman-m/
 * ------------------------------------------------------------------------------- */
function slugify($string)
{
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return $slug;
}


/** ----------------------------------------------------------------------------------
 * Function: csvToArray
 * @param   string $filepath        => Absolute path of the csv file
 * @param   string $delimiter       => Column separator used. Default comma (,)
 * @param   string $rows_to_skip    => Skip this number of rows starting from the first one. Default 0
 *
 * @return  array CSV Data as array
 *
 * Author: https://github.com/rahaman-m
 * ------------------------------------------------------------------------------- */
function csvToArray(string $filepath = '', string $delimiter = ',', $rows_to_skip = 0)
{
    if (!file_exists($filepath) || !is_readable($filepath))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filepath, 'r')) !== false) {
        $i = 1;
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if ($i > $rows_to_skip) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }

            $i++;
        }
        fclose($handle);
    }

    return $data;
}

/** ----------------------------------------------------------------------------------
 * Function: data_crypt
 * @param   string $string  => Any string / data to encrypt or decrypt
 * @param   string $action  => e = enctrypt / d = decrypt
 *
 * @return  string Encrypted / Decrypted string
 *
 * Brief: Encrypt / Decrypt a string or data
 * Author: https://github.com/rahaman-m
 * ------------------------------------------------------------------------------- */
function data_crypt($string, $action = 'e')
{
    // you may change these values to your own
    $secret_key     = env('SECRET_KEY', 'EEBE65D23DCFB');   // 128-bit WEP Key
    $secret_iv      = env('SECRET_IV', '2r5u8x/A?D(G+KbP'); // 128-bit Encryption Key
    $encrypt_method = "AES-256-CBC";

    $output = false;
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

/** ----------------------------------------------------------------------------------
 * Function: create_nonce
 * @param   array $data  => data in array format to create nonce
 *
 * @return  string Encrypted nonce
 *
 * Brief: Create encrypted nonce for the given data
 * Author: https://github.com/rahaman-m
 * ------------------------------------------------------------------------------- */
function create_nonce(array $data, $glue = '|')
{
    if (empty($data)) {
        return false;
    }

    // include current user id
    $current_user   = Auth::id();
    $data[]   = $current_user;

    $string   = implode($glue, $data);
    return data_crypt($string);
}

/** ----------------------------------------------------------------------------------
 * Function: verify_nonce
 * @param   string $nonce   => Encrypted nonce
 * @param   array  $data    => Data to verify
 *
 * @return  bool|string     => true if valid, else the error message returns.
 *
 * Brief: Create encrypted nonce for the given data
 * Author: https://github.com/rahaman-m
 * ------------------------------------------------------------------------------- */
function verify_nonce(string $nonce, array $data, $glue = '|')
{
    if (empty($nonce) || empty($data)) {
        return "empty";
    }

    $string     = data_crypt($nonce, 'd');
    $nonceData  = explode($glue, $string);

    if (!is_array($nonceData)) {
        return "not array";
    }

    // include current user id
    $current_user   = Auth::id();
    $data[]   = $current_user;

    if (count($nonceData) !== count($data)) {
        return "count not equal";
    }

    $isValid    = true;
    for ($i = 0; $i < count($data); $i++) {
        if (strcmp($nonceData[$i], $data[$i]) !== 0) {
            $isValid    = "not match - " . $nonceData[$i] . " - " . $data[$i];
        }
    }

    return $isValid;
}
