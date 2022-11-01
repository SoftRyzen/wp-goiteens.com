<?php
    if(!defined('ABSPATH')){
    	exit;
	}
    
    class booking_package_HTMLElement {
        
        public $prefix = null;
        
        public $plugin_name = null;
        
        public $accountKey = null;
        
        public function __construct($prefix, $pluginName){
            
            $this->prefix = $prefix;
            $this->plugin_name = $pluginName;
            $this->visitorSubscriptionForStripe = 1;
            
        }
        
        public function setVisitorSubscriptionForStripe($visitorSubscriptionForStripe){
            
            $this->visitorSubscriptionForStripe = $visitorSubscriptionForStripe;
            
        }
        
        public function subscription_form($calendarAccount, $memberSetting){
            
            global $wpdb;
            $pluginName = $this->plugin_name;
            $stripe_active = intval(get_option($this->prefix."stripe_active", 0));
            if($stripe_active == 0 || intval($calendarAccount['enableSubscriptionForStripe']) == 0){
                
                #wp_localize_script('booking_app_js', $this->prefix.'subscriptions', array('status' => 0));
                $html = '<script type="text/javascript">' . "\n";
                $html .= 'var ' . $this->prefix . 'subscriptions = ' . json_encode(array('status' => 0)) . ';' . "\n";
                $html .= '</script>' . "\n";
                return $html;
                
            }
            
            $product = $calendarAccount["subscriptionIdForStripe"];
            $secret = get_option($this->prefix."stripe_secret_key", 0);
            
            $schedule = new booking_package_schedule($this->prefix, $this->plugin_name);
            #$subscription = $schedule->getProductForStripe($secret, $product);
            $subscription = $schedule->getProductForStripe($secret, explode(",", $product));
            
            $items = array();
            if (isset($memberSetting['subscription_list'])) {
                
                $items = $memberSetting['subscription_list'];
                
            }
            
            foreach ((array) $items as $key => $value) {
                
                $item = $items[$key];
                if($subscription['product'] == $key && $subscription['product'] == $product){
                    
                    $plans = $item['items'];
                    for($i = 0; $i < count($plans); $i++){
                        
                        if(array_search($plans[$i]['id'], $subscription['planKeys']) !== false){
                            
                            $subscription['subscribed'] = 1;
                            break;
                            
                        }
                        
                    }
                    
                }
                
            }
            
			$name = null;
			$amount = null;
			if(is_array($subscription)){
			    
			    $name = $subscription['name'];
			    $amount = $subscription['amount'];
			    #wp_localize_script('booking_app_js', $this->prefix.'subscriptions', $subscription);
			    echo '<script type="text/javascript">' . "\n";
                echo 'var ' . $this->prefix . 'subscriptions = ' . json_encode($subscription) . ';' . "\n";
                echo '</script>' . "\n";
			    
			}else{
			    
			    #wp_localize_script('booking_app_js', $this->prefix.'subscriptions', array('status' => 0));
			    echo '<script type="text/javascript">' . "\n";
                echo 'var ' . $this->prefix . 'subscriptions = ' . json_encode(array('status' => 0)) . ';' . "\n";
                echo '</script>' . "\n";
			    
			}
			
            $text = array(
                "Subscription" => 'Subscription',
                "Subscribed_items" => 'Subscribed items',
                "agreeToOur1" => 'By proceeding you agree to our %s.',
                "agreeToOur2" => 'By proceeding you agree to our %s and %s.',
                "termsOfService" => 'Terms of Service',
                "privacyPolicy" => 'Privacy Policy',
                "amount" => '%s per month',
                "Return" => 'Return',
                
            );
            
            $agree = "";
            if(intval($calendarAccount['enableTermsOfServiceForSubscription']) == 1 && intval($calendarAccount['enablePrivacyPolicyForSubscription']) == 0){
                
                $termsOfService = '<a target="_blank" href="'.$calendarAccount['termsOfServiceForSubscription'].'">'.$text['termsOfService'].'</a>';
                $agree = sprintf($text['agreeToOur1'], $termsOfService);
                
            }else if(intval($calendarAccount['enableTermsOfServiceForSubscription']) == 0 && intval($calendarAccount['enablePrivacyPolicyForSubscription']) == 1){
                
                $privacyPolicy = '<a target="_blank" href="'.$calendarAccount['privacyPolicyForSubscription'].'">'.$text['privacyPolicy'].'</a>';
                $agree = sprintf($text['agreeToOur1'], $privacyPolicy);
                
            }else if(intval($calendarAccount['enableTermsOfServiceForSubscription']) == 1 && intval($calendarAccount['enablePrivacyPolicyForSubscription']) == 1){
                
                $termsOfService = '<a target="_blank" href="'.$calendarAccount['termsOfServiceForSubscription'].'">'.$text['termsOfService'].'</a>';
                $privacyPolicy = '<a target="_blank" href="'.$calendarAccount['privacyPolicyForSubscription'].'">'.$text['privacyPolicy'].'</a>';
                $agree = sprintf($text['agreeToOur2'], $termsOfService, $privacyPolicy);
                
            }
            
$html .= <<< EOT

    <div id="booking-package-subscription_form" class="hidden_panel">
        <div class="subscription">{$text["Subscription"]}</div>
        <div id="booking-package-select_subscription">
            <div class="name">$name</div>
            <div id="booking-package-subscription_amount" class="amount" data-amount="$amount">{$text['amount']}</div>
        </div>
        <div id="booking-package-subscription_input_form"></div>
        <div id="booking-package-agree">$agree</div>
    </div>
    
    <div id="booking-package-subscribed_panel" class="hidden_panel">
        <div class="titlePanel subscription">
            <div class="title">{$text["Subscribed_items"]}</div>
            <div id="booking-package-subscribed_return_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important;">close</div>
        </div>
        <div>
            <table>
                <tbody id="booking-package-subscribed_items"></tbody>
            </table>
        </div>
        <div>
            
        </div>
    </div>

EOT;
            
            return $html;
            
        }
        
        public function member_form($user, $member_login_error){
            
            $pluginName = $this->plugin_name;
            $user_login = "";
			$user_email = "";
			if(isset($user['user_login']) && isset($user['user_email'])){
				
				$user_login = $user['user_login'];
				$user_email = $user['user_email'];
				
			}
			
			$hidden_panel = "";
			if($this->visitorSubscriptionForStripe != 1){
			    
			    $hidden_panel = "hidden_panel";
			    
			}
			
			$permalink = get_permalink();
            
			$text = array(
			    'Register For This Site' => __("Register For This Site", $pluginName),
			    'Sign up' => __("Sign up", $pluginName),
			    'Username' => __("Username", $pluginName),
			    'Email' => __("Email", $pluginName),
			    'Password' => __("Password", $pluginName),
			    'Registration confirmation will be emailed to you.' => '',
			    'Register' => __("Register", $pluginName),
			    'Return' => __("Return", $pluginName),
			    'Profile' => __("Profile", $pluginName),
			    'Status' => __("Status", $pluginName),
			    'Approved' => __("Approved", $pluginName),
			    'Change password' => __("Change password", $pluginName),
			    'Update Profile' => __("Update Profile", $pluginName),
			    'Delete' => __("Delete", $pluginName),
			    'Subscribed items' => __("Subscribed items", $pluginName),
		    );
		    
		    if (isset($user['check_email_for_member']) && intval($user['check_email_for_member']) == 0) {
		        
		        $text['Registration confirmation will be emailed to you.'] = '';
		        
		    }
		    
		    $html = '';
			if(is_string($member_login_error)){
				
				$html .= '<div class="member_login_error">'.$member_login_error.'</div>';
				
			}
			
$html .= <<< EOT

    <div id="booking-package-user-form" class="hidden_panel">
        <div>
            <div class="titlePanel">
                <div class="title">{$text["Sign up"]}</div>
                <div id="booking-package-register_user_return_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important;">close</div>
            </div>
            <div class="inputPanel">
                <div>
                    <label>{$text["Username"]}</label>
                    <input type="text" name="booking-package-user_login" id="booking-package-user_login" class="input" value="" size="20">
                </div>
                <div>
                    <label>{$text["Email"]}</label>
                    <input type="text" name="booking-package-user_email" id="booking-package-user_email" class="input" value="" size="20">
                </div>
                <div>
                    <label>{$text["Password"]}</label>
                    <input type="password" name="booking-package-user_pass" id="booking-package-user_pass" class="input" value="" size="20">
                </div>
                <div id="booking-package-user_regist_message">{$text["Registration confirmation will be emailed to you."]}</div>
                <div id="booking-package-user_regist_error_message" class="login_error hidden_panel"></div>
            </div>
            <button id="booking-package-register_user_button">{$text["Register"]}</button>
            <!-- <button id="booking-package-register_user_return_button" class="hidden_panel return_button">{$text["Return"]}</button> -->
        </div>
    </div>
    
    <div id="booking-package-user-edit-form" class="hidden_panel">
        <div>
            <div class="titlePanel">
                <div class="title">{$text["Profile"]}</div>
                <div id="booking-package-edit_user_return_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important">close</div>
            </div>
            <div id="booking-package-tabFrame" class="tabFrame hidden_panel">
                <div class="menuList $hidden_panel">
                    <div id="booking-package-user_profile_tab" class="menuItem active">{$text["Profile"]}</div>
                    <div id="booking-package-user_subscribed_tab" class="menuItem">{$text["Subscribed items"]}</div>
                </div>
            </div>
            <div id="booking-package-user-profile" class="inputPanel">
                <div>
                    <label>{$text["Username"]}</label>
                    <input type="text" name="booking-package-user_edit_login" id="booking-package-user_edit_login" class="input" value="$user_login" size="20" disabled>
                </div>
                <div>
                    <label>{$text["Email"]}</label>
                    <input type="text" name="booking-package-user_edit_email" id="booking-package-user_edit_email" class="input" value="$user_email" size="20">
                </div>
                <div id="booking-package-user_status_field">
                    <label>{$text["Status"]}</label>
                    <label>
                        <input type="checkbox" name="booking-package-user_edit_status" id="booking-package-user_edit_status" class="" value="1">
                        {$text["Approved"]}
                    </label>
                </div>
                <div id="booking-package-edit_password_filed">
                    <label>{$text["Password"]}</label>
                    <button id="booking-package-user_edit_change_password_button" class="change_password_button">{$text["Change password"]}</button>
                    <input type="password" name="booking-package-user_edit_pass" id="booking-package-user_edit_pass" class="input hidden_panel" value="" size="20">
                </div>
            </div>
            <div id="booking-package-user-subscribed" class="inputPanel hidden_panel">
                <table>
                    <tbody id="booking-package-user_subscribed_tbody"></tbody>
                </table>
            </div>
            <div>
                <button id="booking-package-edit_user_button">{$text["Update Profile"]}</button>
                <button id="booking-package-edit_user_delete_button" class="return_button">{$text["Delete"]}</button>
                <!-- <button id="booking-package-edit_user_return_button" class="hidden_panel return_button">{$text["Return"]}</button> -->
                
            </div>
        </div>
    </div>
    <input type="hidden" id="booking-package-permalink" value="$permalink">
            
EOT;
            
            return $html;
            
        }
        
        public function cancelBookingDetailsForVisitor_panel() {
            
            $pluginName = $this->plugin_name;
            $text = array(
			    'Booking details' => __("Booking details", $pluginName),
			    'Return to calendar' => __("Return to calendar", $pluginName),
			    'Cancel this booking' => __("Cancel this booking", $pluginName),
		    );
            
$html = <<< EOT
    <div id="booking-package_myBookingDetailsFroVisitor" class="hidden_panel">
        <div class="titlePanel">
            <div class="title selectedDate">{$text["Booking details"]}</div>
        </div>
        <div class="buttonPanel">
            <div id="myPersonalDetails" class="myPersonalDetails row" style="border-width: 0;"></div>
            <!--
            <button class="returnButton">{$text["Return to calendar"]}</button>
            <button class="cancelButton">{$text["Cancel this booking"]}</button>
            -->
        </div>
    </div>

EOT;
            
            return $html;
            
        }
        
        
        public function myBookingHistory_panel() {
            
            $pluginName = $this->plugin_name;
            $text = array(
			    'Booking history' => __("Booking history", $pluginName),
			    'Return to calendar' => __("Return to calendar", $pluginName),
			    'Cancel this booking' => __("Cancel this booking", $pluginName),
			    'ID' => __("ID", $pluginName),
			    "Booking Date" => __("Booking Date", $pluginName),
			    "Calendar" => __("Calendar", $pluginName),
			    "Status" => __("Status", $pluginName),
            );
            
$html = <<< EOT
    <div id="booking-package_myBookingHistory" class="hidden_panel">
        <div class="titlePanel">
            <div class="title">{$text["Booking history"]}</div>
            <div id="booking-package-bookingHistory_close_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important;">close</div>
        </div>
        <div>
            <table id="booking-package_myBookingHistoryTable">
                <tr data-head="th">
                    <th>{$text["ID"]}</th>
                    <th>{$text["Booking Date"]}</th>
                    <th>{$text["Calendar"]}</th>
                    <th>{$text["Status"]}</th>
                </tr>
            </table>
        </div>
        <div class="buttonPanel">
            
            <button id="booking-package-bookingHistory_returnButton" class="material-icons returnButton" style="font-family: 'Material Icons' !important;">navigate_before</button>
            <button id="booking-package-bookingHistory_nextButton" class="material-icons cancelButton" style="font-family: 'Material Icons' !important;">navigate_next</button>
            
        </div>
    </div>

EOT;
            
            return $html;
            
        }
        
        public function myBookingDetails_panel() {
            
            $pluginName = $this->plugin_name;
            $text = array(
			    'Booking history' => __("Booking history", $pluginName),
			    'Return to calendar' => __("Return to calendar", $pluginName),
			    'Cancel this booking' => __("Cancel this booking", $pluginName),
			    'My booking details' => __("My booking details", $pluginName),
			    'ID' => __("ID", $pluginName),
			    "Booking Date" => __("Booking Date", $pluginName),
			    "Status" => __("Status", $pluginName),
			    "Return" => __("Return", $pluginName),
            );
            
$html = <<< EOT
    <div id="booking-package_myBookingDetails" class="hidden_panel">
        <div class="titlePanel">
            <div class="title">{$text["My booking details"]}</div>
            <div id="booking-package-myBookingDetails_close_button" class="material-icons closeButton" style="font-family: 'Material Icons' !important;">close</div>
        </div>
        <div id="booking-package_myBookingDetails_panel">
            
        </div>
        <div class="buttonPanel">
            
            <button id="booking-package-myBookingDetails_returnButton" class="returnButton">{$text["Return"]}</button>
            <button id="booking-package-cancelThisBooking" class="returnButton">{$text["Cancel this booking"]}</button>
            
        </div>
    </div>

EOT;
            
            return $html;
            
        }
        
    }
    
?>