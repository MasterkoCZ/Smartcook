<?php
require_once("SmartCookClient.php");

try {
    (new SmartCookClient)
        ->sendRequest("ingredients")
        ->printResponse();
} catch (Exception $e) {
    error_log($e->getMessage());
}