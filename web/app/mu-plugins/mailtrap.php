<?php
/*
Plugin Name:  Force Mailtrap
Plugin URI:   http://www.4mation.com.au/
Description:  Forces mailtrap on staging and local environments
Version:      1.0.0
Author:       Harlan Wilton
Author URI:   http://www.4mation.com.au/
License:      MIT License
*/
if (is_env_production()) {
    return;
}


$mailtrap_user = env('MAILTRAP_USER');
$mailtrap_pass = env('MAILTRAP_USER');

/**
 * Make sure that they've been defined
 */
if(empty($mailtrap_user) || empty($mailtrap_pass)) {
    return;
}

/**
 * Register our mailtrap override
 */
add_action( 'phpmailer_init', function( PHPMailer $phpmailer ) use($mailtrap_user, $mailtrap_pass) {

    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->Port = 2525; // could be different
    $phpmailer->Username = $mailtrap_user; // if required
    $phpmailer->Password = $mailtrap_pass; // if required
    $phpmailer->SMTPAuth = true; // if required
    $phpmailer->IsSMTP();

}, PHP_INT_MAX);

/**
 * In the event of an email failing - we dump the error
 */
add_action('wp_mail_failed', function($error) {
    pd('Email failed', $error);
});
