<?php
public function custom_err_handler($err_no, $err_str, $err_file, $err_line) {
    $err_type = match ($err_no) {
        E_DEPRECATED, E_USER_DEPRECATED => "Deprecated",
        E_WARNING, E_USER_WARNING => "Warning",
        E_NOTICE, E_USER_NOTICE => "Notice",
        E_ERROR, E_USER_ERROR => "Error",
        E_STRICT => "Strict",
        default => "Unkown"
    };
}    
