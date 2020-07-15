<?php
use App\Models\LogMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
    define('REDBOX_MAIL', 'do-not-reply@redboxdapp.com');

    if (!function_exists('sendMailBuyTrade')) {
        function sendMailBuyTrade($data, $email)
        {
            Mail::send('Mails.Mail-Buy-Trade', $data, function ($msg) use ($email) {
                $msg->from(REDBOX_MAIL, 'Redbox');
                $msg->to($email)->subject('Congratulations on your successful RBD Token ownership');
            });
            $user = User::where('User_Email', $email)->first();
            LogMail::insertLog($user, 'Send Email Trade Buy', 'Send Email Trade Buy');
        }
    }
    
    if (!function_exists('sendMailActive')) {
        function sendMailActive($data, $email)
        {
            Mail::send('Mails.Mail-Active', $data, function ($msg) use ($email) {
                $msg->from(REDBOX_MAIL, 'Redbox');
                $msg->to($email)->subject('Active Email');
            });
            $user = User::where('User_Email', $email)->first();
            LogMail::insertLog($user, 'Mail Active', 'Send Email Active');
        }
    }

    if (!function_exists('sendForgotPassword')) {
        function sendForgotPassword($data, $email)
        {
            Mail::send('Mails.Mail-Forgot-Password', $data, function ($msg) use ($email) {
                $msg->from(REDBOX_MAIL, 'Redbox');
                $msg->to($email)->subject('Reset Password');
            });
            $user = User::where('User_Email', $email)->first();
            LogMail::insertLog($user, 'Reset Password', 'Send Email Reset Password');
        }
    }

    if (!function_exists('MailConfirmProfileSuccess')) {
        function MailConfirmProfileSuccess($data, $email)
        {
            Mail::send('Mails.Mail-Confirm-Profile-Success', $data, function ($msg) use ($email) {
                $msg->from(REDBOX_MAIL, 'Redbox');
                $msg->to($email)->subject('Profile Verified');
            });
            $user = User::where('User_Email', $email)->first();
            LogMail::insertLog($user, 'Confirm Profile Success', 'Send Email Confirmed Profile Successfull');
        }
    }

    if (!function_exists('MailConfirmProfileError')) {
        function MailConfirmProfileError($data, $email)
        {
            Mail::send('Mails.Mail-Confirm-Profile-Success', $data, function ($msg) use ($email) {
                $msg->from(REDBOX_MAIL, 'Redbox');
                $msg->to($email)->subject('Profile Verified');
            });
            $user = User::where('User_Email', $email)->first();
            LogMail::insertLog($user, 'Confirm Profile Success', 'Send Email Confirmed Profile Successfull');
        }
    }


