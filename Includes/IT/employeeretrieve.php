<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/19/2018
 * Time: 9:17 AM
 */

include('../../Content/IT/Employee.php');

$database = new Database();

$db = $database->connect();

$employee = new Employee($db);

$employee_read = $employee->get();

echo $employee_read;