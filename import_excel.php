<?php
session_start();
include('connection.php');

require 'phpspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['save_excel_data']))
{
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach($data as $row)
        {
            if($count > 0)
            {
                $country = $row['0'];
                $fname = $row['1'];
                $mname = $row['2'];
                $lname = $row['3'];
                $maturity_suffix = $row['0'];
                $profession = $row['1'];
                $license_number = $row['2'];
                $case_number = $row['3'];
                $action_date = $row['0'];
                $document_name = $row['1'];
                $provider_address = $row['2'];
                $birthdate = $row['1'];
                $provider_sanction = $row['0'];
                $date_processed = $row['1'];
              
                $sqlQuery = "INSERT INTO provider_data (`country`, fname, mname, lname, maturity_suffix,  profession, license_number, 
                document_name, provider_address,  birthdate,   provider_sanction, date_processed)
                    VALUES ('$country', '$fname', '$mname', '$lname', '$maturity_suffix', '$profession' ,'$license_number',  '$document_name', '$provider_address', 
                    '$birthdate', '$provider_sanction', '$date_processed')";
                    $result = mysqli_query($con, $sqlQuery);
                    $msg = true;

            }
            else
            {
                $count = "1";
            }
        }

        if(isset($msg))
        {
            $_SESSION['message'] = "Successfully Imported";
            header('Location: index.php');
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Not Imported";
            header('Location: index.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "Invalid File";
        header('Location: index.php');
        exit(0);
    }
}
?>