<?php
    function successAlert($msg) {
        return '<div class="alert alert-success" role="alert">' . $msg . '</div>';
    }

    function errorAlert($msg) {
        return '<div class="alert alert-dark" role="alert">' . $msg . '</div>';
    }