<?php
class PNSolsCommon {
    public static function replace_http_2_https($html) {
        if ($_SERVER['HTTPS'] == 'on') {
            $replacment = 'http://'.$_SERVER['SERVER_NAME'];
            $replace = 'https://'.$_SERVER['SERVER_NAME'];
            $htmlWithHTTPSLinks = str_replace($replacment, $replace, $html);
            return $htmlWithHTTPSLinks;
        }
        return $html;
    }
}
?>