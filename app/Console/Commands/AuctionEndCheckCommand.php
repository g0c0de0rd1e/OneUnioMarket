<?php

namespace App\Console\Commands;

use App\Traits\SendMail;
use Illuminate\Console\Command;
use Modules\AuctionProducts\Entities\Auction;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Entities\EmailTemplate;
use Modules\UserActivityLog\Traits\LogActivity;

class AuctionEndCheckCommand extends Command
{
    use SendMail;
    
    protected $signature = 'command:auctionendcheck';

    protected $description = 'Check if auction ends or not';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $cur_date = date('Y-m-d');
        $auctions = Auction::where('auction_end_date','<',$cur_date)->where('is_send',0)->get();

        foreach($auctions as $key => $auction){
            $tamplate = EmailTemplate::where('type_id', 45)->where('is_active', 1)->first();
            $subject= $tamplate->subject;
            $body = $tamplate->value;
            
            $general_setting = DB::table('general_settings')->select('mail_signature','mail_footer','site_title')->first();

            $url = '<a href="'.route('auctionproducts.auction-product').'" class="btn btn-primary btn-lg">Watch Auction</a>';

            $array['subject'] = $subject;
            $array['from'] = env('MAIL_USERNAME');
            $array['content'] = $body;

            $array['content'] = str_replace('{EMAIL_SIGNATURE}',$general_setting->mail_signature,$array['content']);
            $array['content'] = str_replace('{EMAIL_FOOTER}',$general_setting->mail_footer,$array['content']);
            $array['content'] = str_replace('{VERIFICATION_LINK}',$url,$array['content']);
            $array["content"] = str_replace("{USER_FIRST_NAME}", $auction->seller->first_name, $array["content"]);
            $array["content"] = str_replace("{WEBSITE_NAME}", $general_setting->site_title, $array["content"]);
            $mailPath = '\App\Mail\AuctionEndMail';
            $template = '/backEnd/template';
            $this->sendMailWithTemplate($auction->seller->email,$array,$mailPath,$template);
               
            $auction->update([
                'is_send' => 1
            ]);
            // if bidder award system is automatic then below code will run
            if($auction->bidder_award_system==0){
                $max_bidder = $auction->auction_bid->sortByDesc('bid_amount')->first();
                if($max_bidder->is_send==0){
                    $tamplate = EmailTemplate::where('type_id', 44)->where('is_active', 1)->first();
                    $subject= $tamplate->subject;
                    $body = $tamplate->value;
             
                    $url = '<a href="'.route('auctionproducts.get.awarded.user.confirmation',[$max_bidder->auction_id,$max_bidder->id]).'" class="btn btn-primary btn-lg">Confirm Order</a>';
                    $array['subject'] = $subject;
                    $array['from'] = env('MAIL_USERNAME');
                    $array['content'] = $body;
             
                    $array['content'] = str_replace('{USER_FIRST_NAME}',$max_bidder->customer_name,$array['content']);
                    $array['content'] = str_replace('{VERIFICATION_LINK}',$url,$array['content']);
                    $array['content'] = str_replace('{EMAIL_SIGNATURE}',$general_setting->mail_signature,$array['content']);
                    $array['content'] = str_replace('{EMAIL_FOOTER}',$general_setting->mail_footer,$array['content']);
                    $array["content"] = str_replace("{WEBSITE_NAME}", $general_setting->site_title, $array["content"]);
                    $mailPath = '\App\Mail\AuctionBidderAwardMail';
                    $template = '/backEnd/template';
                    $this->sendMailWithTemplate($max_bidder->customer_email,$array,$mailPath,$template);
                    
                    $max_bidder->update([
                        'is_send' => 1
                    ]);
                }
            }
        }
        return true;
    }
}
