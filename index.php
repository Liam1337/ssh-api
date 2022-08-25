<?php
/*
     _____     ____
    /      \  |  o | 
   |        |/ ___\| 
   |_________/     
   |_|_| |_|_| v1.1
   
   Made by @Liam1337

   Usage: https://localhost/api.php?pass=yourpassword
   
   Release date of v1.1 25.08.2022
*/

    error_reporting(E_ALL);

    $ip = "1.1.1.1";        // Your server IP | "ip a"
    $port = "22";           // (22 defeault SSH port), Change it if you have changed your ssh port to something else
    $ssh_username = "root"; // server username
    $ssh_pass = "toor";     // server passwd

    function EncodeString($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, "UTF-8"); // UTF-8
    }
 
    $pass = array("ChangeMe!"); // API passwd
 
    if (!isset($_GET["pass"]))
    {
        die("Please submit a password!"); // empty passwd print
    }
 
    $ssh = "service nginx stop && sleep 5 && service nginx start && sleep 5 && service nginx reload";  // Shell command for example "reboot"

    $password = EncodeString($_GET["pass"]); // get passwd from the api url
 
    if (!in_array($password, $pass)){ // checking pw / printing error
        die("Invalid Password!");
    }
 
    $socket = fsockopen($ip, $port); // trying to connect
 
    ($socket ? null : die("Failed to connect!")); // socket issue
 
    fwrite($socket, " \r\n");
   
    sleep(3); // if your server is slow increase the time
   
    fwrite($socket, $ssh_username . "\r\n"); // server username
   
    sleep(3);
   
    fwrite($socket, $ssh_pass . "\r\n"); // user passwd
 
    sleep(9);
 
    fwrite($socket, $ssh); // inject shell
 
    fclose($socket); // close socket
 
    echo "Your command has been successfully sent to the server!"; // output if success
?>
