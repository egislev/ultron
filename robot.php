<?php
/*
 * ULTRON - Automatic Control of JTDX/WSJT-X/MSHV
 *
 * Created by: LU9DCE
 * Copyright: 2023 Eduardo Castillo
 * Contact: castilloeduardo@outlook.com.ar
 * License: Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International
 *
 * Description:
 *
 * ULTRON is a sophisticated software tool designed for remotely or locally
 * controlling programs like JTDX, MSHV, and WSJT-X. It offers seamless
 * operation on both Windows and Linux platforms, supporting both 32-bit and
 * 64-bit versions. The software relies on the latest version of PHP for
 * optimal performance.
 *
 */
error_reporting(0);
date_default_timezone_set("UTC");
$sendcq = "0";
$zz = "   ";
$rxrx = "0";
$dxc = "";
$tdx = "0";
$tempo = "0000";
$tempu = "0000";
$exclu = "";
$mega = "0";
$robot = " -----< ULTRON :";
$decalld = "";
static $iaia;
static $exclu;
static $tropa;
$memoryUsageBytes = memory_get_usage();
$version = "LR-230809";
$portrx = "";
$beep = "play -n synth 1 sine 1200 2>&1 >/dev/null";
$filename = __DIR__ . '/wsjtx_log.adi';
if (! file_exists($filename)) {
    file_put_contents($filename, '');
}
$adix = realpath($filename);
function fg($text, $color)
{
    if ($color == "0") {
        $out = "[30m"; // Black
    }
    if ($color == "1") {
        $out = "[31m"; // Red
    }
    if ($color == "2") {
        $out = "[32m"; // Green
    }
    if ($color == "3") {
        $out = "[33m"; // Yellow
    }
    if ($color == "4") {
        $out = "[34m"; // Blue
    }
    if ($color == "5") {
        $out = "[35m"; // Magenta
    }
    if ($color == "6") {
        $out = "[36m"; // Cyan
    }
    if ($color == "7") {
        $out = "[37m"; // White
    }
    if ($color == "8") {
        $out = "[90m"; // Bright Black (Gray)
    }
    if ($color == "9") {
        $out = "[91m"; // Bright Red
    }
    return chr(27) . "$out" . "$text" . chr(27) . "[0m\n\r";
}
echo "\n\r";
echo fg("##################################################################", 1);
echo " Created by Eduardo Castillo - LU9DCE\n\r";
echo " (C) 2023 - castilloeduardo@outlook.com.ar\n\r";
echo fg("------------------------------------------------------------------", 1);
echo "$robot Preparing :";
echo " Version $version\n\r";
echo " Looking for radio software wait ...";
goto test;
contr:
echo fg("------------------------------------------------------------------", 5);
echo "$robot Ctrl + C to exit\n\r";
echo fg("##################################################################", 1);
echo " -----> Info\n\r";
echo " -----> CQ active (0=NO/1=YES) - N\n\r";
echo " -----> Response time          - NNNN\n\r";
echo " -----> Time that ends         - NNNN\n\r";
echo " -----> Current time           - NNNN\n\r";
echo " -----> Contacts made          - NN\n\r";
echo " -----> Memory usage (MB)      - NNN\n\r";
echo fg("##################################################################", 1);
echo " ADI    : $adix\n\r";
echo " Processing, please wait  : ";
$nombreArchivo = $adix;
$contenido = file_get_contents($nombreArchivo);
$contenido = strtoupper($contenido);
$contenido = str_replace(array("\r\n", "\r", "\n", "\r"), ' ', $contenido);
$registros = explode("<EOR>", $contenido);
$archivoSalida = fopen("mio.adi", "w");
foreach ($registros as $registro) {
    if (!empty($registro)) {
        $appLotwPos = strpos($registro, "<APP_LOTW_EOF>");
        if ($appLotwPos !== false) {
            $registro = substr($registro, $appLotwPos + 14);
            $registro = ltrim($registro);
        }
        if (strpos($registro, "<EOH>") !== false) {
            $registro = substr($registro, strpos($registro, "<EOH>") + 5);
        }
        if ($registro[0] === ' ') {
            $registro = ltrim($registro);
        }
        if (!empty($registro)) {
            $registroCompleto = $registro . "<EOR>\n";
            fwrite($archivoSalida, $registroCompleto);
        }
    }
}
fclose($archivoSalida);
unlink($nombreArchivo);
rename("mio.adi", $nombreArchivo);
echo "[OK]\n\r";
echo " PortRx : $portrx\n\r";
echo fg("##################################################################", 4);
function sendcq()
{
    global $ipft, $portrx, $magic, $ver, $largoid, $id, $time, $snr, $deltat, $deltaf, $lmode, $mode, $ml, $message, $low, $off;
    $fp = stream_socket_client("udp://$ipft:$portrx", $errno, $errstr);
    $msg = "$magic$ver" . "00000004" . "$largoid$id$time$snr$deltat$deltaf$lmode$mode$ml$message$low$off";
    $msg = hex2bin($msg);
    fwrite($fp, $msg);
    fclose($fp);
    return $sendcq = "1";
}
echo " -----> Testing country file : ";
$csvPath =  __DIR__ . '/cty.csv';
if (@filesize($csvPath) === 0) {
    unlink($csvPath);
}
if (!file_exists($csvPath)) {
    echo "Download ";
    $csvData = @file_get_contents('https://www.country-files.com/bigcty/cty.csv');
    if ($csvData !== false) {
        file_put_contents($csvPath, $csvData);
        echo "[OK]\n\r";
    } else {
        echo "[ERROR]\n\r";
        file_put_contents($csvPath, '');
    }
} else {
    echo "[OK]\n\r";
}
function load_cty_array()
{
    $cty_array = array();
    $dirt = __DIR__ . '/cty.csv';
    $handle = fopen($dirt, "r");
    while (($raw_string = fgets($handle)) !== false) {
        $row = str_getcsv($raw_string);
        $array = explode(' ', $row [9]);
        foreach ($array as &$value) {
            $value = str_replace(';', '', $value);
            $cty_array [$value] = $row [1];
        }
    }
    fclose($handle);
    return $cty_array;
}
$cty_array = load_cty_array();
function locate($licrx)
{
    global $cty_array;
    $z = strlen($licrx);
    for($i = $z; $i >= 1; $i --) {
        $licrx = substr($licrx, 0, $i);
        if (isset($cty_array [$licrx])) {
            return $cty_array [$licrx];
        }
    }
    return "??";
}
$regex = '/<([A-Z0-9_]+):(\d+)>([^<\s]+)\s*/';
$contents = '';
$fileHandle = fopen($adix, 'r');
while (($line = fgets($fileHandle)) !== false) {
    $line = strtoupper($line);
    preg_match_all($regex, $line, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        $tag = $match [1];
        $length = ( int ) $match [2];
        $value = substr($match [3], 0, $length);
        if ($tag === 'CALL') {
            $contents .= $value . " ";
        }
    }
}
fclose($fileHandle);
echo "$robot Watchdog = 90s\n\r";
echo "$robot Pls disable watchdog of $soft\n\r";
echo fg("##################################################################", 4);
echo "$robot $ipft port udp 2237\n\r";
echo "$robot forward to 127.0.0.1 port udp 2277\n\r";
echo fg("##################################################################", 1);
echo " -----> Testing LOTW user file : ";
$llw = false;
$csvPath =  __DIR__ . '/lotw-user-activity.csv';
if (@filesize($csvPath) === 0) {
    unlink($csvPath);
}
if (!file_exists($csvPath)) {
    echo "Download ";
    $csvData = @file_get_contents('https://lotw.arrl.org/lotw-user-activity.csv');
    if ($csvData !== false) {
        echo "[OK]\n\r";
        file_put_contents($csvPath, $csvData);
    } else {
        echo "[ERROR]\n\r";
        file_put_contents($csvPath, '');
    }
} else {
    echo "[OK]\n\r";
}
$lotw = '';
if (filesize($csvPath) > 0) {
    $currentDate = new DateTime();
    $fileHandle = fopen($csvPath, 'r');
    while (($line = fgets($fileHandle)) !== false) {
        $columns = explode(',', $line);
        if (count($columns) >= 3) {
            $date = trim($columns [1]);
            $dateTime = DateTime::createFromFormat('Y-m-d', $date);
            $interval = $currentDate->diff($dateTime);
            $monthsDifference = $interval->y * 12 + $interval->m;
            if ($monthsDifference <= 6) {
                $lotw .= trim($columns [0]) . ' ';
            }
        }
    }
    fclose($fileHandle);
    $llw = true;
}
$fme = __DIR__ . '/lotw';
if (file_exists($fme) && $llw !== false) {
    $lotwa = true;
    echo " -----> Call only active LOTW users\n\r";
} else {
    $lotwa = false;
    echo " -----> Call all active users\n\r";
}
echo fg("##################################################################", 1);
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, '0.0.0.0', 2237);
$read = [
        $socket
];
$socketx = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
$write = null;
$except = null;
trama:
socket_select($read, $write, $except, null);
$datas = socket_recvfrom($socket, $buffer, 512, 0, $fromip, $portrx);
$data = $buffer;
socket_sendto($socketx, $data, 512, 0, '127.0.0.1', 2277);
$lee = bin2hex($data);
$type = substr($lee, 16, 8);
if ($sendcq == "1" && $led) {
    shell_exec($ledron);
}
if ($sendcq == "0" && $led) {
    shell_exec($ledroff);
}
if ($type == "00000000") {
    goto tcero;
}
if ($type == "00000001") {
    goto tuno;
}
if ($type == "00000002") {
    goto tdos;
}
if ($type == "00000005") {
    shell_exec($beep);
}
if ($type == "0000000c") {
    goto tdoce;
}
goto trama;
tcero:
$info = strtotime("now");
$memoryUsageMB = round($memoryUsageBytes / 1024 / 1024, 2);
$qq = "$robot $soft = $sendcq-" . substr($tempo, - 4) . "-" . substr($tempu, - 4) . "-" . substr($info, - 4) . "-$mega-$memoryUsageMB";
echo fg($qq, 7);
if ($sendcq == "1" && $info > $tempu) {
    goto dog;
}
$txw = date("i");
if (($txw == "00") || ($txw == "30")) {
    unset($exclu);
}
goto trama;
tuno:
$magic = substr($lee, 0, 8);
$magicd = hexdec($magic);
$ver = substr($lee, 8, 8);
$verd = hexdec($ver);
$type = substr($lee, 16, 8);
$typed = hexdec($type);
$largoid = substr($lee, 24, 8);
$largoidd = hexdec($largoid);
$larg = hexdec($largoid) * 2;
$id = substr($lee, 32, $larg);
$idd = hex2bin($id);
$soft = $idd;
$con = 32 + $larg;
$freq = substr($lee, $con, 16);
$freqd = hexdec($freq);
$con = $con + 16;
$lmode = substr($lee, $con, 8);
$lmoded = hexdec($lmode) * 2;
$con = $con + 8;
$mode = substr($lee, $con, $lmoded);
$moded = hex2bin($mode);
$con = $con + $lmoded;
$ldxcall = substr($lee, $con, 8);
if ($ldxcall == "ffffffff") {
    $ldxcall = "0";
}
$ldxcalld = hexdec($ldxcall) * 2;
$con = $con + 8;
$dxcall = substr($lee, $con, $ldxcalld);
$dxcalld = hex2bin($dxcall);
$con = $con + $ldxcalld;
$lreport = substr($lee, $con, 8);
$lreportd = hexdec($lreport) * 2;
$con = $con + 8;
$report = substr($lee, $con, $lreportd);
$reportd = hex2bin($report);
$con = $con + $lreportd;
$ltxmode = substr($lee, $con, 8);
$ltxmoded = hexdec($ltxmode) * 2;
$con = $con + 8;
$txmode = substr($lee, $con, $ltxmoded);
$txmoded = hex2bin($txmode);
$con = $con + $ltxmoded;
$txenable = substr($lee, $con, 2);
$txenabled = hexdec($txenable);
$con = $con + 2;
$transmitting = substr($lee, $con, 2);
$transmittingd = hexdec($transmitting);
$con = $con + 2;
$decoding = substr($lee, $con, 2);
$decodingd = hexdec($decoding);
$con = $con + 2;
$rxdf = substr($lee, $con, 8);
$rxdfd = hexdec($rxdf);
$con = $con + 8;
$txdf = substr($lee, $con, 8);
$txdfd = hexdec($txdf);
$con = $con + 8;
$ldecall = substr($lee, $con, 8);
$ldecalld = hexdec($ldecall) * 2;
$con = $con + 8;
$decall = substr($lee, $con, $ldecalld);
$decalld = hex2bin($decall);
$con = $con + $ldecalld;
$ldegrid = substr($lee, $con, 8);
$ldegridd = hexdec($ldecall) * 2;
$con = $con + 8;
$degrid = substr($lee, $con, $ldegridd);
$degridd = hex2bin($degrid);
$con = $con + $ldegridd;
$ldxgrid = substr($lee, $con, 8);
if ($ldxgrid == "ffffffff") {
    $ldxgrid = "0";
}
$ldxgridd = hexdec($ldxgrid) * 2;
$con = $con + 8;
$dxgrid = substr($lee, $con, $ldxgridd);
$dxgridd = hex2bin($dxgrid);
$con = $con + $ldxgridd;
$watchdog = substr($lee, $con, 2);
$watchdogd = hexdec($watchdog);
if ($decodingd == "0" && $rxrx > "0") {
    $qq = "$robot " . date("d/m/Y H:i:s") . " >-=-< $rxrx Decodeds";
    echo fg($qq, 6);
    $rxrx = 0;
}
if ($txenabled == "1") {
    $tdx = $tdx + 1;
}
if ($tdx == "2") {
    echo fg("$robot Trasmiting @ $dxc", 9);
}
if ($txenabled == "1" && $sendcq == "0") {
    goto toch;
}
goto trama;
tdos:
$lee = bin2hex($data);
$type = substr($lee, 16, 8);
$magic = substr($lee, 0, 8);
$magicd = hexdec($magic);
$ver = substr($lee, 8, 8);
$verd = hexdec($ver);
$type = substr($lee, 16, 8);
$typed = hexdec($type);
$largoid = substr($lee, 24, 8);
$largoidd = hexdec($largoid);
$larg = hexdec($largoid) * 2;
$id = substr($lee, 32, $larg);
$idd = hex2bin($id);
$soft = $idd;
$con = 32 + $larg;
$newdecode = substr($lee, $con, 2);
$newdecoded = hexdec($newdecode);
$con = $con + 2;
$time = substr($lee, $con, 8);
$mil = hexdec($time);
$seconds = ceil($mil / 1000);
$timed = date("His", $seconds);
$con = $con + 8;
$snr = substr($lee, $con, 8);
$snrd = unpack("l", pack("l", hexdec($snr))) [1];
$con = $con + 8;
$deltat = substr($lee, $con, 16);
// $deltatd = number_format ( round ( unpack ( "d", pack ( "Q", hexdec ( $deltat ) ) ) [1], 1 ), 1 );
$con = $con + 16;
$deltaf = substr($lee, $con, 8);
$deltafd = unpack("l", pack("l", hexdec($deltaf))) [1];
$con = $con + 8;
$lmode = substr($lee, $con, 8);
$lmoded = hexdec($lmode) * 2;
$con = $con + 8;
$mode = substr($lee, $con, $lmoded);
$moded = hex2bin($mode);
$con = $con + $lmoded;
$ml = substr($lee, $con, 8);
$mld = hexdec($ml) * 2;
$con = $con + 8;
$message = substr($lee, $con, $mld);
$messaged = hex2bin($message);
$con = $con + $mld;
$low = substr($lee, $con, 2);
$lowd = hex2bin($low);
$con = $con + 2;
$off = substr($lee, $con, 2);
$offd = hex2bin($off);
goto ptex;
utex:
$rxrx = $rxrx + 1;
$tdx = "0";
goto trama;
tcua:
if ($zz == ">> ") {
    sendcq();
}
$sendcq = "1";
$zz = "   ";
echo fg("$robot I see @ $dxc in $qio", 9);
$tempo = strtotime("now");
$tempu = $tempo + 90;
goto trama;
tcin:
echo fg("$robot Successful contact @ $dxc", 2);
goto trama;
toch:
$fp = stream_socket_client("udp://$ipft:$portrx", $errno, $errstr);
$msg = "$magic$ver" . "00000008" . "$largoid$id" . "00";
$msg = hex2bin($msg);
fwrite($fp, $msg);
fclose($fp);
$sendcq = "0";
$zz = "   ";
$dxc = "";
$tdx = "0";
$tempo = "0000";
$tempu = "0000";
$dxc = "";
echo fg("$robot Halt Tx", 5);
goto trama;
dog:
echo fg("$robot $dxc Not respond to the call", 5);
$exclu [$dxc] = $dxc;
$dxc = "";
goto toch;
ptex:
$mess = rtrim($messaged);
$lin = explode(" ", $mess);
$zz = "   ";
$fg = "8";
if (strpos($lotw, $lin [1]) !== false) {
    $lotd = "[L]";
    $lotdc = "1";
} else {
    $lotd = "[ ]";
    $lotdc = "0";
}
if (sizeof($lin) == 4) {
    unset($lin [1]);
    $lin = array_values($lin);
}
if (isset($iaia [$lin [1]]) && sizeof($lin) == 3 && $lin [1] != $decalld && ($lin [0] == "CQ" || $lin [2] == "73" || $lin [2] == "RR73")) {
    $zz = "-- ";
    $fg = "1";
    goto shsh;
}
$searchfor = $lin [1];
if (strpos($contents, $searchfor) !== false && sizeof($lin) == 3 && $lin [1] != $decalld && ($lin [0] == "CQ" || $lin [2] == "73" || $lin [2] == "RR73")) {
    $zz = "-- ";
    $fg = "1";
    $iaia [$lin [1]] = $lin [1];
}
if (strpos($contents, $searchfor) === false && sizeof($lin) == 3 && $lin [1] != $decalld && ($lin [0] == "CQ" || $lin [2] == "73" || $lin [2] == "RR73")) {
    $zz = "-> ";
    $fg = "7";
}
if ($lotwa === true && strpos($contents, $searchfor) === false && sizeof($lin) == 3 && $lin [1] != $decalld && $sendcq == "0" && $lotdc == "1" && ($lin [0] == "CQ" || $lin [2] == "73" || $lin [2] == "RR73")) {
    $zz = ">> ";
    $fg = "2";
}
if ($lotwa === false && strpos($contents, $searchfor) === false && sizeof($lin) == 3 && $lin [1] != $decalld && $sendcq == "0" && ($lin [0] == "CQ" || $lin [2] == "73" || $lin [2] == "RR73")) {
    $zz = ">> ";
    $fg = "2";
}
if ($snrd <= "-20" && $zz == ">> ") {
    $zz = "Lo ";
    $fg = "3";
}
if (isset($exclu [$lin [1]])) {
    $zz = "XX ";
    $fg = "4";
}
if (strpos($messaged, $dxc) !== false && $sendcq == "1") {
    $fg = "2";
}
shsh:
if (isset($tropa [$lin [1]])) {
    $qio = $tropa [$lin [1]];
} else {
    $qio = locate($lin [1]);
    $tropa [$lin [1]] = $qio;
}
$timed = substr($timed . "                    ", 0, 6);
$snrd = substr($snrd . "                    ", 0, 3);
// $deltatd = substr ( $deltatd . " ", 0, 4 );
$deltafd = substr($deltafd . "                    ", 0, 4);
$moded = substr($moded . "                    ", 0, 4);
$messaged = substr($messaged . "                    ", 0, 18);
$qio = substr($qio . "                    ", 0, 25);
if ($led) {
    shell_exec($ledvon);
}
$qq = "$timed  $snrd  $deltafd $moded$zz$messaged  - $lotd $qio";
if ($led) {
    shell_exec($ledvoff);
}
echo fg($qq, $fg);
if ($lin [0] != $decalld && $lin [0] != "CQ" && $lin [1] == $dxc && ($lin [2] != "73" || $lin [2] != "RR73")) {
    echo fg("$robot Busy?", 4);
    $dxc = "";
    goto toch;
}
if ($lin [0] == $decalld && $lin [2] == "73") {
    echo fg("$robot Qso confirmed successfully", 2);
    $mega = $mega + 1;
    $sendcq = "0";
    $tempo = "0000";
    $tempu = "0000";
    goto toch;
}
if ($lin [0] == $decalld && $lin [2] != "73" && $sendcq == "0") {
    echo fg("$robot Reply? @ $lin[1]", 6);
    $zz = ">> ";
}
if ($zz == ">> " && $sendcq == "0") {
    $dxc = $lin [1];
    goto tcua;
}
goto utex;
test:
$host = '0.0.0.0';
$port = 2237;
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, $host, $port);
while (true) {
    $from = "0.0.0.0";
    $port = 0;
    socket_recvfrom($socket, $buffer, 512, 0, $from, $port);
    $lee = bin2hex($buffer);
    $type = substr($lee, 16, 8);
    if ($type == "0000001") {
        $magic = substr($lee, 0, 8);
        $magicd = hexdec($magic);
        $ver = substr($lee, 8, 8);
        $verd = hexdec($ver);
        $type = substr($lee, 16, 8);
        $typed = hexdec($type);
        $largoid = substr($lee, 24, 8);
        $largoidd = hexdec($largoid);
        $larg = hexdec($largoid) * 2;
        $id = substr($lee, 32, $larg);
        $idd = hex2bin($id);
        $con = 32 + $larg;
        $freq = substr($lee, $con, 16);
        $freqd = hexdec($freq);
        $con = $con + 16;
        $lmode = substr($lee, $con, 8);
        $lmoded = hexdec($lmode) * 2;
        $con = $con + 8;
        $mode = substr($lee, $con, $lmoded);
        $moded = hex2bin($mode);
        $con = $con + $lmoded;
        $ldxcall = substr($lee, $con, 8);
        if ($ldxcall == "ffffffff") {
            $ldxcall = "0";
        }
        $ldxcalld = hexdec($ldxcall) * 2;
        $con = $con + 8;
        $dxcall = substr($lee, $con, $ldxcalld);
        $dxcalld = hex2bin($dxcall);
        $con = $con + $ldxcalld;
        $lreport = substr($lee, $con, 8);
        $lreportd = hexdec($lreport) * 2;
        $con = $con + 8;
        $report = substr($lee, $con, $lreportd);
        $reportd = hex2bin($report);
        $con = $con + $lreportd;
        $ltxmode = substr($lee, $con, 8);
        $ltxmoded = hexdec($ltxmode) * 2;
        $con = $con + 8;
        $txmode = substr($lee, $con, $ltxmoded);
        $txmoded = hex2bin($txmode);
        $con = $con + $ltxmoded;
        $txenable = substr($lee, $con, 2);
        $txenabled = hexdec($txenable);
        $con = $con + 2;
        $transmitting = substr($lee, $con, 2);
        $transmittingd = hexdec($transmitting);
        $con = $con + 2;
        $decoding = substr($lee, $con, 2);
        $decodingd = hexdec($decoding);
        $con = $con + 2;
        $rxdf = substr($lee, $con, 8);
        $rxdfd = hexdec($rxdf);
        $con = $con + 8;
        $txdf = substr($lee, $con, 8);
        $txdfd = hexdec($txdf);
        $con = $con + 8;
        $ldecall = substr($lee, $con, 8);
        $ldecalld = hexdec($ldecall) * 2;
        $con = $con + 8;
        $decall = substr($lee, $con, $ldecalld);
        $decalld = hex2bin($decall);
        $con = $con + $ldecalld;
        $ldegrid = substr($lee, $con, 8);
        $ldegridd = hexdec($ldecall) * 2;
        $con = $con + 8;
        $degrid = substr($lee, $con, $ldegridd);
        $degridd = hex2bin($degrid);
        $con = $con + $ldegridd;
        $ldxgrid = substr($lee, $con, 8);
        if ($ldxgrid == "ffffffff") {
            $ldxgrid = "0";
        }
        $ldxgridd = hexdec($ldxgrid) * 2;
        $con = $con + 8;
        $dxgrid = substr($lee, $con, $ldxgridd);
        $dxgridd = hex2bin($dxgrid);
        $con = $con + $ldxgridd;
        $watchdog = substr($lee, $con, 2);
        $watchdogd = hexdec($watchdog);
        $datamode = $moded;
        $datafreq = substr($freqd, 0, - 3);
        $datacall = $decalld;
        $soft = $idd;
        $datagrid = $degridd;
        $portrx = $port;
        $ipft = $from;
        socket_close($socket);
        echo " [OK]\n\r";
        echo " Soft : $soft\n\r";
        echo " Call : $datacall\n\r";
        echo " Grid : $datagrid\n\r";
        echo " Mode : $datamode\n\r";
        echo " Freq : $datafreq\n\r";
        $isRaspberryPi = false;
        echo fg("------------------------------------------------------------------", 5);
        if (stripos(PHP_OS, 'Linux') !== false) {
            if (is_readable('/sys/firmware/devicetree/base/model')) {
                $model = trim(file_get_contents('/sys/firmware/devicetree/base/model'));
                if (stripos($model, 'Raspberry Pi') !== false) {
                    echo " -----> It's a Raspberry Pi running Linux.\n\r";
                    $isRaspberryPi = true;
                } else {
                    echo " -----> It's Linux, but doesn't seem to be a Raspberry Pi.\n\r";
                }
            } else {
                echo " -----> It's Linux, but couldn't verify if it's a Raspberry Pi.\n\r";
            }
        } else {
            echo " -----> It's not a Linux operating system, probably not a Raspberry Pi.\n\r";
        }
        if ($isRaspberryPi) {
            echo fg("$robot Active sudo without a password.", 3);
            echo fg("$robot LED control will be activated", 2);
            $led = true;
            $command1 = 'sudo sh -c "echo none > /sys/class/leds/ACT/trigger"';
            $command2 = 'sudo sh -c "echo none > /sys/class/leds/PWR/trigger"';
            shell_exec($command1);
            shell_exec($command2);
            $ledvoff = 'sudo sh -c "echo 0 > /sys/class/leds/ACT/brightness"';
            $ledvon = 'sudo sh -c "echo 1 > /sys/class/leds/ACT/brightness"';
            $ledroff = 'sudo sh -c "echo rfkill0 > /sys/class/leds/PWR/trigger"';
            $ledron = 'sudo sh -c "echo heartbeat > /sys/class/leds/PWR/trigger"';
        } else {
            echo fg("$robot LED control will not be activated", 4);
            $led = false;
        }
        goto contr;
    }
}
socket_close($socket);
tdoce:
echo fg("$robot Successful contact @ $dxc", 2);
$datos = hex2bin($lee);
$lineas = explode("\n", $datos);
$linea_encontrada = '';
foreach ($lineas as $linea) {
    if (strpos($linea, '<') === 0 && strpos($linea, '<EOR>') !== false) {
        $linea_encontrada = $linea;
        break;
    }
}
$outputadi = $linea_encontrada;
$outputadi .= "\n";
file_put_contents($adix, $outputadi, FILE_APPEND);
$pattern = '/<CALL:(\d+)>([^<]+)/';
$matches = [ ];
if (preg_match($pattern, $outputadi, $matches)) {
    $length = intval($matches [1]);
    $call = substr($matches [2], 0, $length);
    $dxc = $call;
}
$contents .= $dxc . " ";
goto trama;
/*
[PHP Modules]
calendar
Core
ctype
curl
date
dom
exif
FFI
fileinfo
filter
ftp
gd
gettext
hash
iconv
json
libxml
mbstring
openssl
pcntl
pcre
PDO
Phar
posix
random
readline
Reflection
session
shmop
SimpleXML
sockets
sodium
SPL
standard
sysvmsg
sysvsem
sysvshm
tokenizer
xml
xmlreader
xmlwriter
xsl
Zend OPcache
zip
zlib
*/
