<?php

use Hashids\Hashids;

// ReturnType can be int or array
if (!function_exists('hash_id')) {
    function hash_id($id, $dir = "encode", $returnType = 'int'): string|int|array
    {
        $hashids = new Hashids("Church-Manager");

        if ($dir == 'encode') {
            return $hashids->encode($id);
        } else {
            if($returnType == 'array'){
                return $hashids->decode($id);
            }else{
                return $hashids->decode($id)[0];
            }
        }
    }
}

if (!function_exists('report_template')) {
    function report_template(array $report_metadata, array $report_fields, $report_period): string
    {
        return view('templates/report_template', compact('report_metadata', 'report_fields'));
    }
}

if (!function_exists('formatUserDataForExport')) {
    function formatUserDataForExport($user_data)
    {

        if (isset($user_data['first_name'])) {
            $user_data['first_name'] = ucfirst(strtolower($user_data['first_name']));
        }

        if (isset($user_data['last_name'])) {
            $user_data['last_name'] = ucfirst(strtolower($user_data['last_name']));
        }

        return $user_data;
    }
}


if (!function_exists('button_row')) {
    function button_row($feature, $parent_id = null)
    {
        if (auth()->user()->canDo("$feature.create")) {
            return view("templates/button_row", compact('feature', 'parent_id'));
        }
    }
}

if (!function_exists('datatable')) {
    function datatable($table_id, $feature, $columns)
    {
        return view('templates/datatable', ['table_id' => $table_id, 'feature' => $feature, 'columns' => $columns]);
    }
}

if (!function_exists('sanitizeColumns')) {
    function sanitizeColumns($tableName, $columns)
    {
        $sanitizedColumns['headerColumns'] = $columns;
        $sanitizedColumns['queryColumns'] = $columns;

        // $model = new ("\\App\\Models\\".ucfirst($tableName).'Model')();
        $featureLibrary = new \App\Libraries\FeatureLibrary();

        for ($i = 0; $i < count($columns); $i++) {
            if ($columns[$i] == "$tableName.id") {
                $sanitizedColumns['headerColumns'][$i] = 'Action';
            }

            if (str_ends_with($columns[$i], '_id')) {
                // if(count(explode(' as ', $columns[$i])) > 0){
                //     continue;
                // }
                $fieldTable = plural(substr($columns[$i], 0, -3));
                $derived_column_alias = singular($fieldTable) . "_name";

                if (!in_array($derived_column_alias, $sanitizedColumns['headerColumns'])) {
                    $sanitizedColumns['headerColumns'][$i] = $derived_column_alias;
                    $sanitizedColumns['queryColumns'][$i] = $fieldTable . ".".$featureLibrary->getNameField($fieldTable)." as $derived_column_alias";
                } else {
                    unset($sanitizedColumns['headerColumns'][$i]);
                    unset($sanitizedColumns['queryColumns'][$i]);
                }
            }else{
                if ($columns[$i] != $tableName . ".id") {
                    $otherTablesAliases = explode(".", $columns[$i]);
                    if (count($otherTablesAliases) > 1) {
                        $sanitizedColumns['headerColumns'][$i] = singular($otherTablesAliases[0]) . '_' . $otherTablesAliases[1];
                    }
                }
            }

            $explodeColumnAlias = explode(' as ', $columns[$i]);
            if (count($explodeColumnAlias) > 1) {
                $column_alias = $explodeColumnAlias[1];
                if (!in_array($column_alias, $sanitizedColumns['headerColumns'])) {
                    $sanitizedColumns['headerColumns'][$i] = $column_alias;
                    $sanitizedColumns['queryColumns'][$i] = $columns[$i];
                } else {
                    unset($sanitizedColumns['queryColumns'][$i]);
                    unset($sanitizedColumns['headerColumns'][$i]);
                }
            }


        }

        $sanitizedColumns['headerColumns'] = array_values($sanitizedColumns['headerColumns']);
        $sanitizedColumns['queryColumns'] = array_values($sanitizedColumns['queryColumns']);

        return $sanitizedColumns;
    }
}


if(!function_exists('custom_field_row')){
    function custom_field_row($customFieldId){
        $fieldLibrary = new \App\Libraries\FieldLibrary();
        $fieldInfo = $fieldLibrary->getFieldInfoById($customFieldId);
        return "<tr><td>".$fieldInfo['field_name']."</td><td>".$fieldInfo['type']."</td><td>".$fieldInfo['options']."</td></tr>";
    }
}


/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param int $size Size in pixels, defaults to 64px [ 1 - 2048 ]
 * @param string $default_image_type Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
 * @param bool $force_default Force default image always. By default false.
 * @param string $rating Maximum rating (inclusive) [ g | pg | r | x ]
 * @param bool $return_image True to return a complete IMG tag False for just the URL
 * @param array $html_tag_attributes Optional, additional key/value attributes to include in the IMG tag
 *
 * @return string containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */

 if(!function_exists('get_gravatar')){
    function get_gravatar(
        $email,
        $size = 64,
        $default_image_type = 'mp',
        $force_default = false,
        $rating = 'g',
        $return_image = false,
        $html_tag_attributes = []
    ) {
        // Prepare parameters.
        $params = [
            's' => htmlentities( $size ),
            'd' => htmlentities( $default_image_type ),
            'r' => htmlentities( $rating ),
        ];
        if ( $force_default ) {
            $params['f'] = 'y';
        }
     
        // Generate url.
        $base_url = 'https://www.gravatar.com/avatar';
        $hash = hash( 'sha256', strtolower( trim( $email ) ) );
        $query = http_build_query( $params );
        $url = sprintf( '%s/%s?%s', $base_url, $hash, $query );
     
        // Return image tag if necessary.
        if ( $return_image ) {
            $attributes = '';
            foreach ( $html_tag_attributes as $key => $value ) {
                $value = htmlentities( $value, ENT_QUOTES, 'UTF-8' );
                $attributes .= sprintf( '%s="%s" ', $key, $value );
            }
     
            return sprintf( '<img src="%s" %s/>', $url, $attributes );
        }
     
        return $url;
    }
 }

 if(!function_exists('get_user_email_identity')){
    function get_user_email_identity($userId){
        $identityModel = model(CodeIgniter\Shield\Models\UserIdentityModel::class);
        // Get our identities for all users
        $identities = $identityModel->getIdentitiesByUserIds([$userId])[0];
        return $identities->toArray()['secret'];
    }
 }


 // https://packagist.org/packages/gravatarphp/gravatar
 
 if(!function_exists('gravatar')){
    function gravatar($userEmail){
        // Defaults: no default parameter, use HTTPS
        $gravatar = new Gravatar\Gravatar([], true);

        // Returns https://secure.gravatar.com/avatar/EMAIL_HASH
        $imageURL =$gravatar->avatar($userEmail);
        // Returns https://secure.gravatar.com/avatar/EMAIL_HASH
        // The fourth parameter enables validation and will prevent the
        // size parameter from being added to the URL generated.
        $avatar = $gravatar->avatar($userEmail, ['s' => 9001], true, true);

        // Returns https://secure.gravatar.com/EMAIL_HASH
        $profile = $gravatar->profile($userEmail);

        // Returns https://secure.gravatar.com/EMAIL_HASH.vcf
        $vcard = $gravatar->vcard($userEmail);

        // Returns https://secure.gravatar.com/EMAIL_HASH.qr
        $qrCode = $gravatar->qrCode($userEmail);

        return compact('imageURL','avatar','profile','vcard','qrCode');
    }
 }

 if(!function_exists('generateRandomString')){
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
 }

 if(!function_exists('getWeekNumberInMonth')){
    function getWeekNumberInMonth($date) {
        // Create a DateTime object for the given date
        $dateTime = new DateTime($date);
    
        // Get the day of the month
        $dayOfMonth = (int) $dateTime->format('j');
    
        // Get the day of the week for the first day of the month (0 = Sunday, 6 = Saturday)
        $firstDayOfMonth = new DateTime($dateTime->format('Y-m-01'));
        $firstDayOfWeek = (int) $firstDayOfMonth->format('w');
    
        // Calculate the week number
        return (int) ceil(($dayOfMonth + $firstDayOfWeek) / 7);
    }
 }


 function getSundayNumberInMonth($sundayDate) {
    // Create a DateTime object for the given date
    $date = new DateTime($sundayDate);

    // Ensure the given date is a Sunday
    if ($date->format('w') != 0) {
        throw new Exception("The given date is not a Sunday.");
        // $sundayCount = getWeekNumberInMonth($sundayDate);
    }

    // Get the first day of the month
    $firstDayOfMonth = new DateTime($date->format('Y-m-01'));

    // Initialize the Sunday counter
    $sundayCount = 0;

    // Loop through the month up to the given date
    while ($firstDayOfMonth <= $date) {
        // Check if the current day is a Sunday
        if ($firstDayOfMonth->format('w') == 0) {
            $sundayCount++;
        }
        // Move to the next day
        $firstDayOfMonth->modify('+1 day');
    }

    // if($sundayCount == 0){
    //     $sundayCount = getWeekNumberInMonth($sundayDate);
    // }


    return $sundayCount;
}