<?php
    function successAlert($msg) {
        return '<div class="alert alert-success js-info-alert" role="alert">' . $msg . '</div>';
    }

    function errorAlert($msg) {
        return '<div class="alert alert-dark js-error-alert" role="alert">' . $msg . '<button class="btn btn-danger js-close-alert-button"><i class="fa fa-times"></i></button></div>';
    }