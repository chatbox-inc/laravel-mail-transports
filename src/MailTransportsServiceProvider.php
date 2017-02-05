<?php
namespace Chatbox\Mail;

use Chatbox\Mail\Transports\SlackTransport;
use Chatbox\Mail\Transports\SendGridTransport;
use Chatbox\Mail\Transports\ArrayTransport;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\ServiceProvider;

class MailTransportsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->configure("mail");
        $this->app->register(MailServiceProvider::class);

        $this->app->extend("swift.transport",function(TransportManager $manager){

            $manager->extend("slack",function(){
                $token = env("SLACKMAIL_APIKEY");
                $channel = env("SLACKMAIL_CHANNEL");
                return new SlackTransport($token,$channel);
            });

            $manager->extend("sendgrid",function(){
                if(class_exists(\SendGrid::class)){
                    $sendgrid = new \SendGrid(env("SENDGRID_APIKEY"));
                    return new SendGridTransport($sendgrid);
                }else{
                    throw new \Exception("SendGrid class not found. plz install via `composer install sendgrid/sendgrid`");
                }
            });

            $manager->extend("array",function(){
                return new ArrayTransport();
            });

            return $manager;
        });
    }
}