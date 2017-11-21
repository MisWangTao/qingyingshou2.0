<?php
require_once(__DIR__ . "/../common/common.php");

$sql = 
"
truncate contract_list;
truncate contract_label;
truncate contract_payment_plans;
truncate custom_list;
truncate customer_leader;
truncate files;
truncate forecastreceivables;
truncate forecastverification_contract;
truncate news ;
truncate receivable_dissent;
truncate receivables;
truncate responsible_person;
truncate timeaxis;
truncate verification_contract;
truncate verification_paymentplan;
truncate `contract_change` ;
TRUNCATE `contract_payment_plan_change` ;
truncate linkman;
"
Mysql::run_alter($sql);

?>