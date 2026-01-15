<?php
// echo extension_loaded('oci8') ? 'OCI8 LOADED<br>' : 'OCI8 NOT LOADED<br>';
// echo function_exists('oci_connect') ? 'oci_connect OK' : 'oci_connect MISSING';

$conn = oci_connect('Inventaris', 'admin', 'localhost:1521/XE');
var_dump($conn);
