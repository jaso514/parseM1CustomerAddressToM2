<?php
$m2Header = [
    'email',
    '_website',
    '_store',
    'confirmation',
    'created_at',
    'created_in',
    'disable_auto_group_change',
    'dob',
    'firstname',
    'gender',
    'group_id',
    'lastname',
    'middlename',
    'password_hash',
    'prefix',
    'rp_token',
    'rp_token_created_at',
    'store_id',
    'suffix',
    'taxvat',
    'website_id',
    'password',
    '_address_city',
    '_address_company',
    '_address_country_id',
    '_address_firstname',
    '_address_lastname',
    '_address_middlename',
    '_address_postcode',
    '_address_prefix',
    '_address_region',
    '_address_street',
    '_address_suffix',
    '_address_telephone',
    '_address_vat_id',
    '_address_default_billing_',
    '_address_default_shipping_',
];

// $x = preg_match('/^[_a-z][a-z0-9_]*$/', '_address_vat_id');
// var_dump($x);
// die('12');

$row = 1;
$headers = [];
if (($handle = fopen("customerAddress.csv", "r")) !== FALSE) {
    $output = fopen('output.csv', 'w');

    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $m2Row = [];
        $email = filter_var($data[0], FILTER_SANITIZE_STRING);
        if ($row===1) {
            $headers = $data;
            $m2Row = $m2Header;
        } else {
            $posCity = array_search('_address_city', $headers);
            if (empty($data[$posCity])) {
                continue;
            }
            foreach ($m2Header as $i => $col) {
                $pos = array_search($col, $headers);
                if ($pos!==false) {
                    // if the email is empty but not theother data
                    // that could be the other address data, then, 
                    // use the previous data row
                    $val = filter_var($data[$pos], FILTER_SANITIZE_STRING);
                    // if (empty($email)) {
                    //     if (empty($val)) {
                    //         $m2Row[] = $previousRow[$pos];
                    //     } else {
                    //         $m2Row[] = $val;
                    //     }
                    // } else {
                        // echo "\n ps: $pos/$col";
                        $m2Row[] = $val;
                    // }
                }
            }
            if (!empty($email)) {
                $previousRow = $data;
            }
            // echo "\n " . count($data);
            // echo " " . count($m2Row);
            // die;
        }
        fputcsv($output, $m2Row);
        $row++;
    }
    fclose($handle);
    fclose($output);
}