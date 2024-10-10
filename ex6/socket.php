<?php

function makeWebRequest($host, $port, $contents) {

    $contents = preg_replace('/(\r\n)|\n/', "\r\n", $contents);

    if ($port === 443) {
        $host = 'tls://' . $host;
    }

    try {

        $fp = fsockopen($host, $port, $errno, $errStr, 1);

        if (!is_resource($fp)) {
            return "Error: $errStr ($errno)\n";
        } else {
            stream_set_timeout($fp, 0, 700000);
        }

        fwrite($fp, $contents);

        fflush($fp);

        $response = '';

        while (true) {
            $buffer = fread($fp, 1024);

            $response .= $buffer;

            if (feof($fp) || empty($buffer) && !empty($response)) {
                return $response;
            }

            if (stream_get_meta_data($fp)['timed_out'] && empty($response)) {
                return 'Error: request timed out';
            }
        }

    } finally {
        if (is_resource($fp)) {
            fclose($fp);
        }
    }
}
