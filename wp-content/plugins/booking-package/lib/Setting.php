<?php
    if(!defined('ABSPATH')){
    	exit;
	}
    
    class booking_package_setting {
        
        public $prefix = null;
        
        public $pluginName = null;
        
        public $userRoleName = null;
        
        private $isExtensionsValid = null;
        
        public $guestForDayOfTheWeekRates = 1;
        
        public $member_setting = array(
            'function_for_member' => array('name' => 'User account', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enabled')), 
            'reject_non_membder' => array('name' => 'Reject non-user account bookings', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enabled')), 
            'visitors_registration_for_member' => array('name' => 'User registration from visitors', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enabled')), 
            'check_email_for_member' => array('name' => 'Send the verification code by email when registering and editing', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enabled')), 
            'accept_subscribers_as_users' => array('name' => 'Approve subscriber as users', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enabled')), 
            'accept_contributors_as_users' => array('name' => 'Approve contributors as users', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enabled')), 
            /**
            'accept_authors_as_users' => array('name' => 'Approve authors as users', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enable')), 
            **/
            'user_toolbar' => array('name' => 'Toolbar', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enabled')), 
            /**
            'subject_email_for_member' => array('Subject of email sent when confirming email address' => 'Active', 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'valueList' => array()), 
            'body_email_for_member' => array('Body of email sent when confirming email address' => 'Active', 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXTAREA', 'valueList' => array()), 
            **/
            'lost_password' => array('name' => 'Lost password', 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'CHECK', 'valueList' => array('0' => 'Enabled')), 
        );
        
        public $formInputType = array(
            'id' => array('key' => 'id', 'name' => 'Unique ID', 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', "class" => ""),
            'name' => array('key' => 'name', 'name' => 'Name', 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', "class" => ""),
            'value' => array('key' => 'value', 'name' => 'Value', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', "class" => "hidden_panel"),
            'description' => array('key' => 'description', 'name' => 'Description', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', "class" => ""),
            'active' => array('key' => 'active', 'name' => 'Active', 'value' => 'true', 'inputLimit' => 2, 'inputType' => 'CHECK', 'valueList' => array('true' => 'on'), "class" => ""),
            'required' => array('key' => 'required', 'name' => 'Required', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => 'Yes', 'false' => 'No'), "class" => ""),
            'isName' => array('key' => 'isName', 'name' => 'Is Name', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => 'Yes', 'false' => 'No')),
            'isAddress' => array('key' => 'isAddress', 'name' => 'Is a location in Google Calendar', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => 'Yes', 'false' => 'No'), "class" => ""),
            'isEmail' => array('key' => 'isEmail', 'name' => 'Is Email', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => 'Yes', 'false' => 'No'), "class" => ""),
            'type' => array('key' => 'type', 'name' => 'Type', 'value' => 'TEXT', 'inputLimit' => 1, 'inputType' => 'SELECT', 'valueList' => array('TEXT' => 'TEXT', 'SELECT' => 'SELECT', 'CHECK' => 'CHECK', 'RADIO' => 'RADIO', 'TEXTAREA' => 'TEXTAREA'), "class" => ""),
            'options' => array('key' => 'options', 'name' => 'Options', 'value' => '', 'inputLimit' => 2, 'inputType' => 'OPTION', 'format' => 'jsonString', 'optionsType' => array("number" => array("type" => "TEXT", "value" => "", "target" => "both"))),
        );
        
        public $form = array(
        	array('id' => 'firstname', 'name' => 'First name', 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'true', 'isName' => 'true', 'isAddress' => 'false', 'isEmail' => 'false', 'isTerms' => 'false'),
        	array('id' => 'lastname', 'name' => 'Last name', 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'true', 'isName' => 'true', 'isAddress' => 'false', 'isEmail' => 'false', 'isTerms' => 'false'),
        	array('id' => 'email', 'name' => 'Email', 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'true', 'isName' => 'false', 'isAddress' => 'false', 'isEmail' => 'true', 'isTerms' => 'false'),
        	array('id' => 'phone', 'name' => 'Phone', 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'true', 'isName' => 'false', 'isAddress' => 'false', 'isEmail' => 'false', 'isTerms' => 'false'),
        	array('id' => 'zip', 'name' => 'Zip', 'value' => '', 'type' => 'TEXT', 'options' => '', 'required' => 'false', 'isName' => 'false', 'isAddress' => 'false', 'isEmail' => 'false', 'isTerms' => 'false'),
        	array('id' => 'address', 'name' => 'Address', 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'false', 'isName' => 'false', 'isAddress' => 'true', 'isEmail' => 'false', 'isTerms' => 'false'),
        	array('id' => 'terms', 'name' => 'Terms of Service', 'value' => '', 'type' => 'CHECK', 'active' => 'true', 'options' => 'I agree', 'required' => 'false', 'isName' => 'false', 'isAddress' => 'true', 'isEmail' => 'false', 'isTerms' => 'true'),
        );
        					
        public $email_message = array(
            "mail_new_admin" => array("key" => "mail_new_admin", "subject" => "", "content" => "", 'enable' => '0', 'format' => 'html', 'title' => 'New', 'message' => ''), 
            /** "mail_new_visitor" => array("key" => "mail_new_visitor", "subject" => "", "content" => "", 'enable' => '0', 'format' => 'html', 'title' => ''), **/
            "mail_approved" => array("key" => "mail_approved", "subject" => "", "content" => "", 'enable' => '0', 'format' => 'html', 'title' => 'Approved', 'message' => ''),
            "mail_pending" => array("key" => "mail_pending", "subject" => "", "content" => "", 'enable' => '0', 'format' => 'html', 'title' => 'Pending', 'message' => ''),
            "mail_reminder" => array("key" => "mail_reminder", "subject" => "", "content" => "", 'enable' => '0', 'format' => 'html', 'title' => 'Reminder', 'message' => ''),
            /**"mail_cancel" => array("key" => "mail_cancel", "subject" => "", "content" => "", 'enable' => '0', 'format' => 'html', 'title' => 'Cancellation of booking', 'message' => ''),**/
            "mail_canceled_by_visitor_user" => array("key" => "mail_canceled_by_visitor_user", "subject" => "", "content" => "", 'enable' => '0', 'format' => 'html', 'title' => 'Canceled', 'message' => ''),
            "mail_deleted" => array("key" => "mail_deleted", "subject" => "", "content" => "", 'enable' => '0', 'format' => 'html', 'title' => 'Deleted', 'message' => ''),
        );
        
        public function __construct($prefix, $pluginName, $userRoleName = 'booking_package_user') {
            
            $this->prefix = $prefix;
            $this->pluginName = $pluginName;
            $this->userRoleName = $userRoleName;
            $this->konbini = 0;
            
        }
        
        public function booking_sync() {
        
            $booking_syn = array(
                "iCal" => array(
                    'ical_active' => array('name' => 'Status', 'value' => '0', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('1' => 'Enabled', '0' => 'Disabled')), 
                    'syncPastCustomersForIcal' => array('name' => __('Sync the past customers', $this->pluginName), 'value' => '0', 'inputLimit' => 1, 'inputType' => 'SELECT', 'valueList' => 
                        array(
                            '7' => sprintf(__('Last %s days', $this->pluginName), 7),
                            '14' => sprintf(__('Last %s days', $this->pluginName), 14),
                            '30' => sprintf(__('Last %s days', $this->pluginName), 30),
                            '60' => sprintf(__('Last %s days', $this->pluginName), 60),
                            '90' => sprintf(__('Last %s days', $this->pluginName), 90),
                            '180' => sprintf(__('Last %s days', $this->pluginName), 180),
                            '365' => sprintf(__('Last %s days', $this->pluginName), 365),
                        )
                    ), 
                    'ical_token' => array('name' => 'URL', 'value' => '', 'inputLimit' => 1, 'inputType' => 'CUSTOMIZE'),
                )
            );
            
            return $booking_syn;
            
        }
        
        public function defaultFrom() {
            
            $form = array(
            	array('id' => 'firstname', 'name' => __('First name', $this->pluginName), 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'true', 'isName' => 'true', 'isAddress' => 'false', 'isEmail' => 'false', 'isTerms' => 'false', 'targetCustomers' => 'customersAndUsers'),
            	array('id' => 'lastname', 'name' => __('Last name', $this->pluginName), 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'true', 'isName' => 'true', 'isAddress' => 'false', 'isEmail' => 'false', 'isTerms' => 'false', 'targetCustomers' => 'customersAndUsers'),
            	array('id' => 'email', 'name' => __('Email', $this->pluginName), 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'true', 'isName' => 'false', 'isAddress' => 'false', 'isEmail' => 'true', 'isTerms' => 'false', 'targetCustomers' => 'customersAndUsers'),
            	array('id' => 'phone', 'name' => __('Phone', $this->pluginName), 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'true', 'isName' => 'false', 'isAddress' => 'false', 'isEmail' => 'false', 'isTerms' => 'false', 'targetCustomers' => 'customersAndUsers'),
            	array('id' => 'zip', 'name' => __('Zip', $this->pluginName), 'value' => '', 'type' => 'TEXT', 'active' => '', 'options' => '', 'required' => 'false', 'isName' => 'false', 'isAddress' => 'false', 'isEmail' => 'false', 'isTerms' => 'false', 'targetCustomers' => 'customersAndUsers'),
            	array('id' => 'address', 'name' => __('Address', $this->pluginName), 'value' => '', 'type' => 'TEXT', 'active' => 'true', 'options' => '', 'required' => 'false', 'isName' => 'false', 'isAddress' => 'true', 'isEmail' => 'false', 'isTerms' => 'false', 'targetCustomers' => 'customersAndUsers'),
            	array('id' => 'terms', 'name' => __('Terms of Service', $this->pluginName), 'value' => '', 'type' => 'CHECK', 'active' => 'true', 'options' => __('I agree', $this->pluginName), 'required' => 'false', 'isName' => 'false', 'isAddress' => 'true', 'isEmail' => 'false', 'isTerms' => 'true', 'targetCustomers' => 'customersAndUsers'),
            );
            return $form;
            
        }
        
        public function guestsInputType(){
            
            $guestsInputTypeList = array(
                'name' => array('key' => 'name', 'name' => __('Name', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'target' => 'both'),
                'required' => array('key' => 'required', 'name' => __('Required', $this->pluginName), 'value' => '0', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array(1 => __('Yes', $this->pluginName), 0 => __('No', $this->pluginName)), 'target' => 'both'),
                'description' => array('name' => __('Description', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXTAREA', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => '', 'target' => 'day'),
                'costInServices' => array('key' => 'costInServices', 'name' => __('Select one from standard cost to cost 6 in services', $this->pluginName), 'value' => 'cost_1', 'inputLimit' => 1, 'inputType' => 'SELECT', 'valueList' => array('cost_1' => __(/**'Cost 1'**/ 'Standard cost', $this->pluginName), 'cost_2' => __('Cost 2', $this->pluginName), 'cost_3' => __('Cost 3', $this->pluginName), 'cost_4' => __('Cost 4', $this->pluginName), 'cost_5' => __('Cost 5', $this->pluginName), 'cost_6' => __('Cost 6', $this->pluginName)), 'target' => 'day'),
                'target' => array('key' => 'target', 'name' => __('Target', $this->pluginName), 'value' => 'adult', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('adult' => __('Adult', $this->pluginName), 'children' => __('Children', $this->pluginName)), 'target' => 'hotel'),
                'guestsInCapacity' => array('key' => 'guestsInCapacity', 'name' => __('Include the number of guests in the capacity', $this->pluginName), 'value' => 'adult', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('excluded' => __('Excluded', $this->pluginName), 'included' => __('Included', $this->pluginName)), 'target' => 'day'),
                'reflectService' => array('key' => 'reflectService', 'name' => __('Reflect the number of visitors in the selected service costs', $this->pluginName), 'value' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'valueList' => array(1 => __('Enabled', $this->pluginName), 0 => __('Disabled', $this->pluginName)), 'target' => 'day'),
                'reflectAdditional' => array('key' => 'reflectAdditional', 'name' => __('Reflect the number of visitors in the additional costs', $this->pluginName), 'value' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'valueList' => array(1 => __('Enabled', $this->pluginName), 0 => __('Disabled', $this->pluginName)), 'target' => 'day'),
                'json' => array(
                    'key' => 'json', 
                    'name' => __('Options', $this->pluginName), 
                    'value' => '', 
                    'inputLimit' => 1, 
                    'inputType' => 'EXTRA', 
                    "optionsType" => array(
                        "number" => array("type" => "TEXT", "value" => "", "target" => "both"), 
                        "price" => array("type" => "TEXT", "value" => "", "target" => "hotel"), 
                        
                        "prices" => array(
                            "type" => "dayOfTheWeek", 
                            "target" => "hotel",
                            "options" => array(
                                array("key" => "priceOnMonday", "name" => __('Monday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 0), 
                                array("key" => "priceOnTuesday", "name" => __('Tuesday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 0), 
                                array("key" => "priceOnWednesday", "name" => __('Wednesday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 0), 
                                array("key" => "priceOnThursday", "name" => __('Thursday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 0), 
                                array("key" => "priceOnFriday", "name" => __('Friday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 0), 
                                array("key" => "priceOnSaturday", "name" => __('Saturday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 0), 
                                array("key" => "priceOnSunday", "name" => __('Sunday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 0), 
                                array("key" => "priceOnDayBeforeNationalHoliday", "name" => __('The day Before National holiday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 1), 
                                array("key" => "priceOnNationalHoliday", "name" => __('National holiday', $this->pluginName), "type" => "TEXT", "value" => "0", 'isExtensionsValid' => 1), 
                            ),
                        ),
                        
                        "name" => array("type" => "TEXT", "value" => "", "target" => "both")
                    ), 
                    'titleList' => array(
                        'number' => __('Number of people', $this->pluginName), 
                        'price' => __('Surcharge', $this->pluginName), 
                        'prices' => __('Costs', $this->pluginName), 
                        'name' => __('Title', $this->pluginName)
                    ), 
                    'target' => 'both'
                ),
            );
            
            if ($this->guestForDayOfTheWeekRates === 0) {
                
                unset($guestsInputTypeList['json']['optionsType']['prices']);
                unset($guestsInputTypeList['json']['titleList']['prices']);
                
            } else {
                
                unset($guestsInputTypeList['json']['optionsType']['price']);
                unset($guestsInputTypeList['json']['titleList']['price']);
                
            }
            
            return $guestsInputTypeList;
            
        }
        
        public function couponsInputType(){
            
            $month = array(
                '1' => array('key' => 1, 'name' => __('Jan', $this->pluginName)), 
                '2' => array('key' => 2, 'name' => __('Feb', $this->pluginName)), 
                '3' => array('key' => 3, 'name' => __('Mar', $this->pluginName)), 
                '4' => array('key' => 4, 'name' => __('Apr', $this->pluginName)), 
                '5' => array('key' => 5, 'name' => __('May', $this->pluginName)), 
                '6' => array('key' => 6, 'name' => __('Jun', $this->pluginName)), 
                '7' => array('key' => 7, 'name' => __('Jul', $this->pluginName)), 
                '8' => array('key' => 8, 'name' => __('Aug', $this->pluginName)), 
                '9' => array('key' => 9, 'name' => __('Sep', $this->pluginName)), 
                '10' => array('key' => 10, 'name' => __('Oct', $this->pluginName)), 
                '11' => array('key' => 11, 'name' => __('Nov', $this->pluginName)), 
                '12' => array('key' => 12, 'name' => __('Dec', $this->pluginName)), 
            );
            
            $day = array();
            for ($i = 1; $i <= 31; $i++) {
                
                $day[$i] = array('key' => $i, 'name' => $i);
                
            }
            
            $yearList = array();
            for ($i = 0; $i <= 10; $i++) {
                
                $year = date('Y') + $i;
                $yearList[$year] = array('key' => $year, 'name' => $year);
                
            }
            
            $couponsInputTypeList = array(
                'id' => array('key' => 'id', 'name' => __('Coupon code', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'target' => 'both'),
                'name' => array('key' => 'name', 'name' => __('Name', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'target' => 'both'),
                'active' => array('key' => 'active', 'name' => 'Active', 'value' => 'true', 'inputLimit' => 2, 'inputType' => 'CHECK', 'valueList' => array('1' => 'Enabled'), "class" => ""),
                'description' => array('key' => 'description', 'name' => __('Description', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXTAREA', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'target' => array('key' => 'target', 'name' => __('Target', $this->pluginName), 'value' => 'customers', 'inputLimit' => 1, 'inputType' => 'RADIO', 'target' => 'both', 'valueList' => array('visitors' => __('Customers', $this->pluginName), 'users' => __('Users', $this->pluginName)), "class" => ""),
                'limited' => array('key' => 'limited', 'name' => __('Coupon usage', $this->pluginName), 'value' => 'unlimited', 'inputLimit' => 1, 'inputType' => 'RADIO', 'target' => 'both', 'valueList' => array('unlimited' => __('Offer unlimited coupons', $this->pluginName), 'limited' => __('Offer a limited one-time coupon per users', $this->pluginName)), "class" => ""),
                'expirationDate' => array(
                    'key' => 'expirationDate', 
                    'name' => __('Expiration date', $this->pluginName), 
                    'target' => 'both', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 1, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'expirationDateStatus',
                            'name' => '',
                            'value' => '0',
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array('1' => __('Enabled', $this->pluginName)),
                        ),
                        1 => array(
                            'key' => 'expirationDateFromMonth',
                            'name' => __('From', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $month,
                        ),
                        2 => array(
                            'key' => 'expirationDateFromDay',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $day,
                        ),
                        3 => array(
                            'key' => 'expirationDateFromYear',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $yearList,
                        ),
                        4 => array(
                            'key' => 'expirationDateToMonth',
                            'name' => __('To', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $month,
                        ),
                        5 => array(
                            'key' => 'expirationDateToDay',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $day,
                        ),
                        6 => array(
                            'key' => 'expirationDateToYear',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $yearList,
                        ),
                    ),
                ),
                'method' => array('key' => 'method', 'name' => __('Calculation method', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => array('subtraction' => __('Subtraction', $this->pluginName), 'multiplication' => __('Multiplication', $this->pluginName))),
                'value' => array('key' => 'value', 'name' => __('Value', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
            );
            
            return $couponsInputTypeList;
        }
        
        public function getList(){
            
            $list =  array(
                "General" => array(
                    'site_name' => array('name' => __('Site name', $this->pluginName), 'value' => 'Site name', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'email_to' => array('name' => __('To (Email Address)', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    
                    'email_from' => array('name' => __('From (Email Address)', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'email_title_from' => array('name' => __('From (Email Title)', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    
                    'country' => array('name' => __('Country', $this->pluginName), 'value' => 'US', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'SELECT_GROUP', 'valueList' => array()),
                    'currency' => array('name' => __('Currency', $this->pluginName), 'value' => 'usd', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'SELECT', 'valueList' => 
                        array(
                            'usd' => 'USD - United States of America', 
                            'gbp' => 'GBP - United Kingdom', 
                            'eur' => 'EUR - EU', 
                            'jpy' => 'JPY - 日本円', 
                            'dkk' => 'DKK - Dansk krone', 
                            'cny' => 'CNY - 人民币',
                            'twd' => 'TWD - 台湾元', 
                            'thb' => 'THB - Thai Baht', 
                            'cop' => 'COP - Peso Colombiano', 
                            'cad' => 'CAD - Canadian Dollar', 
                            'aud' => 'AUD - Australian Dollar', 
                            'huf' => 'HUF - Magyar forint', 
                            'php' => 'PHP - Philippine Peso', 
                            'chf' => 'CHF - Swiss franc',
                            'czk' => 'CZK - Koruna česká',
                            'rub' => 'RUB - Российский рубль',
                            'nzd' => 'NZD - New Zealand Dollar',
                            'hrk' => 'HRK - Croatian kuna',
                            'uah' => 'UAH - Українська гривня',
                            'brl' => 'BRL - Real brasileiro',
                            'krw' => 'KRW - 한국 원',
                            'aed' => 'AED - United Arab Emirates',
                            'gtq' => 'GTQ - Guatemalan Quetzal',
                            'mxn' => 'MXN - Peso Mexicano',
                            'ars' => 'ARS - Peso Argentino',
                            'zar' => 'ZAR - South African Rand',
                            'try' => 'TRY - Türk Lirası',
                        )
                    ),
                    'timezone' => array('name' => __('Default Timezone', $this->pluginName), 'value' => 'UTC', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'SELECT_TIMEZONE', 'valueList' => array()),
                    'dateFormat' => array('name' => __('Date format', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'SELECT', 'valueList' => array()),
                    'clock' => array('key' => 'clock', 'name' => __('Time Format', $this->pluginName), 'value' => '24hours', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => 
                        array(
                            '12a.m.p.m' => __('09:00 a.m.', $this->pluginName), 
                            '12ampm' => __('09:00 am', $this->pluginName), 
                            '12AMPM' => __('03:00 PM', $this->pluginName), 
                            '24hours' => __('17:00', $this->pluginName)
                        )
                    ),
                    'positionTimeDate' => array('key' => 'positionTimeDate', 'name' => __('Position of date and time', $this->pluginName), 'value' => 'dateTime', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => 
                        array(
                            'timeDate' => __('Time', $this->pluginName) . ' - ' . __('Date', $this->pluginName), 
                            'dateTime' => __('Date', $this->pluginName) . ' - ' . __('Time', $this->pluginName), 
                        )
                    ),
                    'positionOfWeek' => array('name' => __('Position of the day of the week', $this->pluginName), 'value' => 'before', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'RADIO', 'valueList' => array('before' => __('Before the date', $this->pluginName), 'after' => __('After the date', $this->pluginName))),
                    'automaticApprove' => array('name' => __('Automatically approve of booking', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'CHECK', 'valueList' => array('1' => __('Enabled', $this->pluginName))), 
                    'dataRetentionPeriod' => array('name' => __('Data retention period of customer', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 2, 'inputType' => 'SELECT', 'valueList' => 
                        array(
                            '0' => __('Forever', $this->pluginName), 
                            '30' => sprintf(__('%d days', $this->pluginName), 30), 
                            '90' => sprintf(__('%d days', $this->pluginName), 90), 
                            '180' => sprintf(__('%d days', $this->pluginName), 180), 
                            '365' => sprintf(__('%d year', $this->pluginName), 1), 
                            '730' => sprintf(__('%d years', $this->pluginName), 2), 
                            '1095' => sprintf(__('%d years', $this->pluginName), 3), 
                            '1460' => sprintf(__('%d years', $this->pluginName), 4), 
                            '1825' => sprintf(__('%d years', $this->pluginName), 5), 
                        )
                    ), 
                    'javascriptSyntaxErrorNotification' => array('name' => __('Javascript syntax error notification', $this->pluginName), 'value' => 1, 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'CHECK', 'valueList' => array('1' => __('Automatically notify developers', $this->pluginName))), 
                    
                    'characterCodeOfDownloadFile' => array('name' => __('Character code of download file', $this->pluginName), 'value' => 'UTF-8', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'RADIO', 'valueList' => array('UTF-8' => 'UTF-8', 'EUC-JP' => 'EUC-JP', 'SJIS' => 'SJIS')),
                    'googleAnalytics' => array('name' => __('Tracking ID for the Google analytics', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                ),
                "Design" => array(
                    'autoWindowScroll' => array('name' => __('Automatic scroll to the top on the booking field', $this->pluginName), 'value' => '1', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'CHECK', 'valueList' => array('1' => __('Enabled', $this->pluginName))),
                    'headingPosition' => array('name' => __('Define "position: sticky" for the css (style) in the calendar for visitors', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 0, 'inputLimit' => 2, 'inputType' => 'CHECK', 'valueList' => array('1' => __('Enabled', $this->pluginName))),
                    'fontSize' => array('name' => __('Font size', $this->pluginName), 'value' => '16px', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    #'fontColor' => array('name' => __('Font color', $this->pluginName), 'value' => '#969696', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    'backgroundColor' => array('name' => __('Background color', $this->pluginName), 'value' => '#FFF', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    'calendarBackgroundColorWithSchedule' => array('name' => __('Calendar background color with schedule', $this->pluginName), 'value' => '#FFF', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    'calendarBackgroundColorWithNoSchedule' => array('name' => __('Calendar background color with no schedule', $this->pluginName), 'value' => '#EEE', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    'backgroundColorOfRegularHolidays' => array('name' => __('Background color of closed days', $this->pluginName), 'value' => '#FFD5D5', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    
                    'scheduleAndServiceBackgroundColor' => array('name' => __('Schedule and service background color', $this->pluginName), 'value' => '#FFF', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    'backgroundColorOfSelectedLabel' => array('name' => __('Background color of selected label', $this->pluginName), 'value' => '#EAEDF3', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    'mouseHover' => array('name' => __('Background color when the pointer overlaps a link', $this->pluginName), 'value' => '#EAEDF3', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    'borderColor' => array('name' => __('Border color', $this->pluginName), 'value' => '#ddd', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT', 'js' => 'colorPicker'), 
                    
                ),
                "twilio" => array(
                    'twilio_active' => array('name' => __('Active', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('1' => __('Enabled', $this->pluginName), '0' => __('Disabled', $this->pluginName))), 
                    'twilio_sendingMethod' => array('name' => __('Sending method', $this->pluginName), 'value' => 'phoneNumber', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('phoneNumber' => __('Phone number', $this->pluginName), 'senderID' => __('Alphanumeric Sender ID', $this->pluginName))), 
                    'twilio_sid' => array('name' => __('Account SID', $this->pluginName), 'value' => '', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'twilio_service_sid' => array('name' => __('Messaging Service SID', $this->pluginName), 'value' => '', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'twilio_token' => array('name' => __('Auth token', $this->pluginName), 'value' => '', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'twilio_countryCode' => array('name' => __('Country calling code', $this->pluginName), 'value' => '', 'placeholder' => '+1', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'twilio_number' => array('name' => __('Phone number', $this->pluginName), 'value' => '', 'placeholder' => '+11234567890', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                ),
                "Mailgun" => array(
                    'mailgun_active' => array('name' => __('Active', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('1' => __('Enabled', $this->pluginName), '0' => __('Disabled', $this->pluginName))), 
                    'mailgun_aip_base_url' => array('name' => __('API Base URL', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'mailgun_api_key' => array('name' => __('API Key', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    /**
                    'mailgun_password' => array('name' => __('Password', $this->pluginName), 'value' => '', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT'),
                    **/
                ),
                "Stripe" => array(
                    'stripe_active' => array('name' => __('Active', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('1' => __('Enabled', $this->pluginName), '0' => __('Disabled', $this->pluginName))), 
                    'stripe_public_key' => array('name' => __('Public Key', $this->pluginName), 'value' => '', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'stripe_secret_key' => array('name' => __('Secret Key', $this->pluginName), 'value' => '', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT'),
                    'stripe_capture_method' => array('name' => __('Capture method for payment intent', $this->pluginName), 'value' => 'automatic', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('automatic' => __('Automatic', $this->pluginName), 'manual' => __('Manual', $this->pluginName))), 
                    'stripe_konbini_expiration_date' => array('name' => __('Expiration date for convenience store payments', $this->pluginName), 'value' => '120', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'SELECT', 'valueList' => 
                        array(
                            '30' => sprintf(__('%d minutes', $this->pluginName), 30), 
                            '60' => sprintf(__('%d minutes', $this->pluginName), 60), 
                            '120' => sprintf(__('%d minutes', $this->pluginName), 120), 
                            '180' => sprintf(__('%d minutes', $this->pluginName), 180), 
                            '360' => sprintf(__('%d minutes', $this->pluginName), 360), 
                            '720' => sprintf(__('%d minutes', $this->pluginName), 720), 
                            '1440' => sprintf(__('%d days', $this->pluginName), 1), 
                            '2880' => sprintf(__('%d days', $this->pluginName), 2), 
                            '4320' => sprintf(__('%d days', $this->pluginName), 3), 
                            '5760' => sprintf(__('%d days', $this->pluginName), 4), 
                            '7200' => sprintf(__('%d days', $this->pluginName), 5), 
                            '8640' => sprintf(__('%d days', $this->pluginName), 6), 
                            '10080' => sprintf(__('%d days', $this->pluginName), 7), 
                        ),
                    ), 
                ),
                "PayPal" => array(
                    'paypal_active' => array('name' => __('Active', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('1' => __('Enabled', $this->pluginName), '0' => __('Disabled', $this->pluginName))), 
                    'paypal_live' => array('name' => __('Mode', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('1' => __('Live', $this->pluginName), '0' => __('Test', $this->pluginName))), 
                    'paypal_client_id' => array('name' => __('Client ID', $this->pluginName), 'value' => '', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'paypal_secret_key' => array('name' => __('Secret Key', $this->pluginName), 'value' => '', 'isExtensionsValid' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                ),
                "reCAPTCHA" => array(
                    'googleReCAPTCHA_active' => array('name' => __('Active', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('1' => __('Enabled', $this->pluginName), '0' => __('Disabled', $this->pluginName))), 
                    'googleReCAPTCHA_site_key' => array('name' => __('Site Key', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'googleReCAPTCHA_Secret_key' => array('name' => __('Secret Key', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'),
                    'googleReCAPTCHA_version' => array('name' => __('Version', $this->pluginName), 'value' => 'v2', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('v2' => 'v2', 'v3' => 'v3')), 
                ),
                "hCaptcha" => array(
                    'hCaptcha_active' => array('name' => __('Active', $this->pluginName), 'value' => '0', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('1' => __('Enabled', $this->pluginName), '0' => __('Disabled', $this->pluginName))), 
                    'hCaptcha_site_key' => array('name' => __('Site Key', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'), 
                    'hCaptcha_Secret_key' => array('name' => __('Secret Key', $this->pluginName), 'value' => '', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'TEXT'),
                    'hCaptcha_Theme' => array('name' => __('Theme', $this->pluginName), 'value' => 'light', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('light' => __('Light', $this->pluginName), 'dark' => __('Dark', $this->pluginName))),
                    'hCaptcha_Size' => array('name' => __('Size', $this->pluginName), 'value' => 'normal', 'isExtensionsValid' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('normal' => __('Normal', $this->pluginName), 'compact' => __('Compact', $this->pluginName))),
                    
                ),
            );
            
            $newDataFormatList = array();
            /**
            $dateFormatList = array(
                "m/d/Y / m/Y",
                "m-d-Y / m-Y", 
                "F d, Y / F, Y", 
                "d/m/Y / m/Y", 
                "d-m-Y / m-Y", 
                "d F, Y / F, Y", 
                "Y/m/d / Y/m", 
                "Y-m-d / Y-m", 
                "d.m.Y / m.Y",
                "d.m.Y / F.Y",
                "d.F.Y / F.Y",
                "F d Y / F Y", 
                "d F Y / F Y", 
            );
            **/
            $dateFormatList = array(
                array("format" => "m/d/Y / m/Y", "type" => "number"),
                array("format" => "m-d-Y / m-Y", "type" => "number"),
                array("format" => "% d, Y / %, Y", "type" => "string"),
                array("format" => "d/m/Y / m/Y", "type" => "number"),
                array("format" => "d-m-Y / m-Y", "type" => "number"),
                array("format" => "d %, Y / %, Y", "type" => "string"),
                array("format" => "Y/m/d / Y/m", "type" => "number"),
                array("format" => "Y-m-d / Y-m", "type" => "number"),
                array("format" => "d.m.Y / m.Y", "type" => "number"),
                array("format" => "d.m.Y / %.Y", "type" => "string"),
                array("format" => "d.%.Y / %.Y", "type" => "string"),
                array("format" => "% d Y / % Y", "type" => "string"),
                array("format" => "d % Y / % Y", "type" => "string"),
                array("format" => "d.m.Y / % Y", "type" => "string"),
                array("format" => "d.%.Y / % Y", "type" => "string"),
                array("format" => "Y年m月d日 / Y年m月", "type" => "number"),
            );
            
            $month = __(date('F'), $this->pluginName);
            for ($i = 0; $i < count($dateFormatList); $i++) {
                
                $format = $dateFormatList[$i];
                $date = null;
                if ($format['type'] == 'number') {
                    
                    $date = date($format['format']);
                    
                } else {
                    
                    $date = date($format['format']);
                    $date = str_replace('%', $month, $date);
                    
                }
                
                $dateFormatList[$i] = $date;
                
            }
            
            $list['General']['dateFormat']['valueList'] = $dateFormatList;
            foreach ((array) $list as $listKey => $listValue) {
                
                $category = array();
                foreach ((array) $listValue as $key => $value) {
                    
                    $optionsValue = get_option($this->prefix . $key);
                    if ($optionsValue !== false) {
                        
                        $value['value'] = $optionsValue;
                        
                    }
                    
                    $category[$this->prefix . $key] = $value;
                    
                }
                
                $list[$listKey] = $category;
                
            }
            
            return $list;
            
        }
        
        public function getBookingSyncList($accountKey = false){
            
            $list = array();
            $booking_sync = $this->booking_sync();
            foreach ((array) $booking_sync as $listKey => $listValue) {
                
                $category = array();
                foreach ((array) $listValue as $key => $value) {
                    
                    $optionsValue = get_option($this->prefix.$key);
                    if($optionsValue !== false){
                        
                        $value['value'] = stripslashes($optionsValue);
                        
                    }
                    
                    $category[$this->prefix.$key] = $value;
                    
                }
                
                $list[$listKey] = $category;
                
            }
            
            return $list;
            
        }
        
        public function getMemberSetting($extension = false){
            
            $member_setting = $this->member_setting;
            foreach ((array) $member_setting as $key => $input) {
                
                $defaultValue = $input['value'];
                $value = get_option($this->prefix . $key);
                if ($value !== false) {
                    
                    $member_setting[$key]['value'] = $value;
                    
                } else {
                    
                    add_option($this->prefix . $key, sanitize_text_field($defaultValue));
                    
                }
                
                if ($extension !== true && $input['isExtensionsValid'] == 1) {
                    
                    $member_setting[$key]['value'] = 0;
                    #update_option($this->prefix . $key, "0");
                    
                }
                
            }
            
            return $member_setting;
            
        }
        
        public function getMemberSettingValues(){
            
            $member_setting = $this->member_setting;
            $values = array(
                'function_for_member' => $member_setting['function_for_member']['value'],
                'visitors_registration_for_member' => $member_setting['visitors_registration_for_member']['value'],
                'check_email_for_member' => $member_setting['check_email_for_member']['value'],
                'reject_non_membder' => $member_setting['reject_non_membder']['value'],
                'accept_subscribers_as_users' => $member_setting['accept_subscribers_as_users']['value'],
                'accept_contributors_as_users' => $member_setting['accept_contributors_as_users']['value'],
                /**
                'accept_authors_as_users' => $member_setting['accept_authors_as_users']['value'],
                **/
                'user_toolbar' => $member_setting['user_toolbar']['value'],
                'lost_password' => $member_setting['lost_password']['value'],
            );
            
            foreach ((array) $values as $key => $value) {
                
                $value = get_option($this->prefix.$key, $value);
                $values[$key] = $value;
                
            }
            
            $values['lost_password_url'] = wp_lostpassword_url(get_permalink());
            
            return $values;
            
        }
        
        public function getEmailMessageList($accountKey = 1, $calendarName = null, $calendarAccount = null) {
            
            if (empty($calendarName)) {
                
                $calendarName = 'Your Calendar';
                
            }
            
            $enable = 1;
            $messages = array(
                'mail_new_admin' => array(
                    'enable' => 1, 
                    'subject' => "Booking notification for your visitors [Booking Package]", 
                    'content' => sprintf("Hello,\n\nID: [id] \nFirst name: [firstname] \nLast name: [lastname] \nEmail: [email] \nPhone: [phone] \nAddress: [address] \n\nYou can edit this message anytime in the \"Notifications\" tab on the %s.\n\nThank you for trying Booking Package.", $calendarName), 
                    'subjectForAdmin' => 'Booking notification for you [Booking Package]', 
                    'contentForAdmin' => '',
                ),
                'mail_approved' => array('enable' => 0, 'subject' => "", 'content' => "", 'subjectForAdmin' => '', 'contentForAdmin' => '',),
                'mail_canceled_by_visitor_user' => array('enable' => 0, 'subject' => "", 'content' => "", 'subjectForAdmin' => '', 'contentForAdmin' => '',),
                'mail_deleted' => array('enable' => 0, 'subject' => "", 'content' => "", 'subjectForAdmin' => '', 'contentForAdmin' => '',),
                'mail_pending' => array('enable' => 0, 'subject' => "", 'content' => "", 'subjectForAdmin' => '', 'contentForAdmin' => '',),
                'mail_reminder' => array('enable' => 0, 'subject' => "", 'content' => "", 'subjectForAdmin' => '', 'contentForAdmin' => '',),
            );
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_emailSetting";
            $email_message = $this->email_message;
            foreach ((array) $email_message as $key => $value) {
                
                #var_dump($value);
                $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `mail_id` = %s;", array(intval($accountKey), $value['key']));
                $row = $wpdb->get_row($sql, ARRAY_A);
                if (is_null($row)) {
                    
                    #var_dump($row);
                    $wpdb->insert(
                        $table_name, 
                        array(
                            'accountKey' => intval($accountKey), 
                            'mail_id' => sanitize_text_field($value['key']),
                            'enable' => intval($messages[$key]['enable']),
                            'data' => date('U'),
                            'subject' => sanitize_text_field($messages[$key]['subject']),
                            'content' => htmlspecialchars($messages[$key]['content'], ENT_QUOTES|ENT_HTML5),
                            'subjectForAdmin' => sanitize_text_field($messages[$key]['subjectForAdmin']),
                            'contentForAdmin' => htmlspecialchars($messages[$key]['content'], ENT_QUOTES|ENT_HTML5),
                            'format' => 'text',
                        ), 
                        array('%d', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s')
                    );
                    
                } else {
                    
                    #var_dump($row);
                    $email_message[$key]['enable'] = intval($row['enable']);
                    $email_message[$key]['enableSMS'] = intval($row['enableSMS']);
                    $email_message[$key]['format'] = $row['format'];
                    $email_message[$key]['subjectForAdmin'] = $row['subjectForAdmin'];
                    $email_message[$key]['contentForAdmin'] = htmlspecialchars_decode($row['contentForAdmin'], ENT_QUOTES|ENT_HTML5);
                    if (!is_null($row['subject'])) {
                        
                        $email_message[$key]['subject'] = $row['subject'];
                        
                    }
                    
                    if (!is_null($row['content'])) {
                        
                        $email_message[$key]['content'] = htmlspecialchars_decode($row['content'], ENT_QUOTES|ENT_HTML5);
                        
                    }
                    
                }
                
                #break;
                
            }
            
            #var_dump($email_message);
            $response = array('emailMessageList' => $email_message);
            $response['formData'] = $this->getForm($accountKey, false);
            return $response;
            
        }
        
        public function getEmailMessage($keys = null){
            
            $list = array();
            foreach ((array) $this->email_message as $key => $value) {
                
                $value['key'] = $this->prefix.$key;
                
                if($keys == null || in_array("subject", $keys) === true){
                    
                    $optionsValue = get_option($this->prefix.$key."_subject", "");
                    if($optionsValue !== false){
                        
                        $value['subject'] = $optionsValue;
                        
                    }
                    
                }
                
                if($keys == null || in_array("content", $keys) === true){
                    
                    $optionsValue = get_option($this->prefix.$key."_content", "<div>No message</div>");
                    if($optionsValue !== false){
                        
                        $value['content'] = $optionsValue;
                        
                    }
                    
                }
                
                if($keys == null || in_array("enable", $keys) === true){
                    
                    $optionsValue = get_option($this->prefix.$key."_enable", 1);
                    if($optionsValue !== false){
                        
                        $value['enable'] = $optionsValue;
                        
                    }
                    
                }
                
                if($keys == null || in_array("format", $keys) === true){
                    
                    $optionsValue = get_option($this->prefix.$key."_format", "html");
                    if($optionsValue !== false){
                        
                        $value['format'] = $optionsValue;
                        
                    }
                    
                }
                
                $list[$key] = $value;
            }
            
            return $list;
            
        }
        
        public function getElementForCalendarAccount(){
            
            $calendarAccount = array(
                'name' => array('key' => 'name', 'name' => 'Name', 'target' => 'both', 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'option' => 0),
                'type' => array(
                    'key' => 'type', 
                    'name' => 'Select a type', 
                    'target' => 'hidden',
                    'value' => 'day', 
                    'inputLimit' => 1, 
                    'inputType' => 'RADIO', 
                    'isExtensionsValid' => 0, 
                    'option' => 1, 
                    'optionsList' => array(
                        /**
                        'cost' => 0, 
                        **/
                        'hotelCharges' => 0,
                        'maximumNights' => 0,
                        'minimumNights' => 0,
                        'subscriptionIdForStripe' => 1,
                        'termsOfServiceForSubscription' => 1,
                        /**'enableSubscriptionForStripe' => 1,**/
                        'numberOfRoomsAvailable' => 0, 
                        'numberOfPeopleInRoom' => 0, 
                        'includeChildrenInRoom' => 0, 
                        'expressionsCheck' => 0, 
                        'preparationTime' => 1,
                        'flowOfBooking' => 1,
                        'courseBool' => 1,
                        'guestsBool' => 1,
                        'hasMultipleServices' => 1,
                        'courseTitle' => 1,
                        'displayRemainingCapacity' => 1,
                        'servicesPage' => 1,
                        'schedulesPage' => 1,
                        'minimum_guests' => 1,
                        'maximum_guests' => 1,
                    ), 'valueList' => array(
                        'day' => 'Booking is completed within 24 hours (hair salon, hospital etc.)', 
                        'hotel' => 'Accommodation (hotels, campgrounds, etc.)'
                    )
                ),
                'email_to' => array('key' => 'email_to', 'name' => __('To (Email Address)', $this->pluginName), 'target' => 'both', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'option' => 0),
                'email_from' => array('key' => 'email_from', 'name' => __('From (Email Address)', $this->pluginName), 'target' => 'both', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'option' => 0),
                'email_from_title' => array('key' => 'email_from_title', 'name' => __('From (Email Title)', $this->pluginName), 'target' => 'both', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'option' => 0),
                'status' => array('key' => 'status', 'name' => __('Calendar', $this->pluginName), 'target' => 'both', 'value' => 'open', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array('open' => __('Open', $this->pluginName), 'closed' => __('Closed', $this->pluginName))),

                'calendar_sharing' => array(
                    'key' => 'calendar_sharing', 
                    'name' => __('Schedules sharing', $this->pluginName), 
                    'target' => 'both', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 1, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'schedulesSharing',
                            'name' => '',
                            'value' => null,
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(1 => __('Enabled', $this->pluginName)),
                        ),
                        1 => array(
                            'key' => 'targetSchedules',
                            'name' => __('Target calendar', $this->pluginName) . ': ',
                            'value' => '0',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(),
                        ),
                    ),
                ), 
                
                'timezone' => array('key' => 'timezone', 'name' => __('Timezone', $this->pluginName), 'target' => 'both', 'value' => 'open', 'inputLimit' => 1, 'inputType' => 'SELECT_TIMEZONE', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array()),
                /**
                'clock' => array('key' => 'clock', 'name' => 'Clock', 'value' => '24', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array('12' => __('12 hour am-pm clock', $this->pluginName), '24' => __('24 hour clock', $this->pluginName))),
                **/
                'startOfWeek' => array('key' => 'startOfWeek', 'name' => __('Week Starts On', $this->pluginName), 'target' => 'both', 'disabled' => 0, 'value' => '0', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array('0' => __('Sunday', $this->pluginName), '1' => __('Monday', $this->pluginName), '2' => __('Tuesday', $this->pluginName), '3' => __('Wednesday', $this->pluginName), '4' => __('Thursday', $this->pluginName), '5' => __('Friday', $this->pluginName), '6' => __('Saturday', $this->pluginName))),
                'sendBookingVerificationCode' => array(
                    'key' => 'sendBookingVerificationCode', 
                    'name' => __('Send a booking verification code', $this->pluginName), 
                    'target' => 'both', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 1, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'bookingVerificationCode',
                            'name' => __('For customers', $this->pluginName) . ': ',
                            'value' => '30',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(
                                0 => array('key' => 'emailAndSms', 'name' => __('Enabled', $this->pluginName) . ' - ' . __('Email and SMS', $this->pluginName)), 
                                1 => array('key' => 'email', 'name' => __('Enabled', $this->pluginName) . ' - ' . __('Email', $this->pluginName)), 
                                2 => array('key' => 'sms', 'name' => __('Enabled', $this->pluginName) . ' - ' . __('SMS', $this->pluginName)), 
                                3 => array('key' => 'false', 'name' => __('Disabled', $this->pluginName)), 
                            ),
                        ),
                        1 => array(
                            'key' => 'bookingVerificationCodeToUser',
                            'name' => __('For users', $this->pluginName) . ': ',
                            'value' => '30',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(
                                0 => array('key' => 'emailAndSms', 'name' => __('Enabled', $this->pluginName) . ' - ' . __('Email and SMS', $this->pluginName)), 
                                1 => array('key' => 'email', 'name' => __('Enabled', $this->pluginName) . ' - ' . __('Email', $this->pluginName)), 
                                2 => array('key' => 'sms', 'name' => __('Enabled', $this->pluginName) . ' - ' . __('SMS', $this->pluginName)), 
                                3 => array('key' => 'false', 'name' => __('Disabled', $this->pluginName)), 
                            ),
                        ),
                    ),
                ), 
                
                
                'paymentMethod' => array('key' => 'paymentMethod', 'name' => __('Payment methods', $this->pluginName), 'target' => 'both', 'value' => 'open', 'inputLimit' => 1, 'inputType' => 'CHECK', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array('locally' => __('I will pay locally', $this->pluginName), 'stripe' => __('Pay with Stripe', $this->pluginName), 'paypal' => __('Pay with PayPal', $this->pluginName), 'stripe_konbini' => __('Pay at a convenience store with Stripe', $this->pluginName))),
                
                'subscriptionIdForStripe' => array('key' => 'subscriptionIdForStripe', 'name' => 'Product ID of subscription for Stripe', 'target' => 'both', 'value' => '', 'inputLimit' => 2, 'inputType' => 'SUBSCRIPTION', 'optionKeys' => array('subscriptionIdForStripe' => array('title' => __('Product ID', $this->pluginName), 'inputType' => 'TEXT'), 'enableSubscriptionForStripe' => array('title' => __('Enabled', $this->pluginName), 'inputType' => 'CHECKBOX')), 'isExtensionsValid' => 1, 'option' => 0, 'optionValues' => array("enableSubscriptionForStripe" => "")),
                'termsOfServiceForSubscription' => array('key' => 'termsOfServiceForSubscription', 'name' => 'The terms of service for subscription', 'target' => 'both', 'value' => '', 'inputLimit' => 2, 'inputType' => 'SUBSCRIPTION', 'optionKeys' => array('termsOfServiceForSubscription' => array('title' => 'URI', 'inputType' => 'TEXT'), 'enableTermsOfServiceForSubscription' => array('title' => __('Enabled', $this->pluginName), 'inputType' => 'CHECKBOX')), 'isExtensionsValid' => 1, 'option' => 0, 'optionValues' => array("enableTermsOfServiceForSubscription" => "")),
                'privacyPolicyForSubscription' => array('key' => 'privacyPolicyForSubscription', 'name' => 'The privacy policy for subscription', 'target' => 'both', 'value' => '', 'inputLimit' => 2, 'inputType' => 'SUBSCRIPTION', 'optionKeys' => array('privacyPolicyForSubscription' => array('title' => 'URI', 'inputType' => 'TEXT'), 'enablePrivacyPolicyForSubscription' => array('title' => __('Enabled', $this->pluginName), 'inputType' => 'CHECKBOX')), 'isExtensionsValid' => 1, 'option' => 0, 'optionValues' => array("enablePrivacyPolicyForSubscription" => "")),
                #'subscriptionIdForPayPal' => array('key' => 'subscriptionIdForPayPal', 'name' => 'Subscription ID for PayPal', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'option' => 0),
                
                'hotelCharges' => array(
                    'key' => 'hotelCharges', 
                    'name' => __('Hotel charges', $this->pluginName), 
                    'target' => 'hotel', 
                    'disabled' => 0,
                    'value' => 'false', 
                    'inputLimit' => 1, 
                    'inputType' => 'HOTEL_CHARGES', 
                    'isExtensionsValid' => 0, 
                    'option' => 0, 
                    'valueList' => array(
                        0 => array(
                            'key' => 'hotelChargeOnMonday',
                            'name' => __('Monday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 0, 
                        ), 
                        1 => array(
                            'key' => 'hotelChargeOnTuesday',
                            'name' => __('Tuesday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 0, 
                        ), 
                        2 => array(
                            'key' => 'hotelChargeOnWednesday',
                            'name' => __('Wednesday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 0, 
                        ), 
                        3 => array(
                            'key' => 'hotelChargeOnThursday',
                            'name' => __('Thursday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 0, 
                        ), 
                        4 => array(
                            'key' => 'hotelChargeOnFriday',
                            'name' => __('Friday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 0, 
                        ), 
                        5 => array(
                            'key' => 'hotelChargeOnSaturday',
                            'name' => __('Saturday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 0, 
                        ), 
                        6 => array(
                            'key' => 'hotelChargeOnSunday',
                            'name' => __('Sunday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 0, 
                        ), 
                        7 => array(
                            'key' => 'hotelChargeOnDayBeforeNationalHoliday',
                            'name' => __('The day Before National holiday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 1, 
                        ), 
                        8 => array(
                            'key' => 'hotelChargeOnNationalHoliday',
                            'name' => __('National holiday', $this->pluginName),
                            'value' => 0,
                            'isExtensionsValid' => 1, 
                        ), 
                    ),
                    "message" => '',
                ),
                
                'minimumNights' => array('key' => 'minimumNights', 'name' => __('Minimum nights', $this->pluginName), 'target' => 'hotel', 'disabled' => 0, 'value' => '1', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'option' => 0), 
                'maximumNights' => array('key' => 'maximumNights', 'name' => __('Maximum nights', $this->pluginName), 'target' => 'hotel', 'disabled' => 0, 'value' => '1', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'option' => 0), 
                'numberOfRoomsAvailable' => array('key' => 'numberOfRoomsAvailable', 'name' => 'Number of rooms available', 'target' => 'hotel', 'disabled' => 0, 'value' => '1', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'option' => 0), 
                'numberOfPeopleInRoom' => array('key' => 'numberOfPeopleInRoom', 'name' => 'Maximum number of people staying in one room', 'target' => 'hotel', 'disabled' => 0, 'value' => '2', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'option' => 0), 
                'includeChildrenInRoom' => array('key' => 'includeChildrenInRoom', 'name' => 'Include children in the maximum number of people in the room', 'target' => 'hotel', 'disabled' => 0, 'value' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(1 => 'Include', 0 => 'Exclude')),
                
                'formatNightDay' => array('key' => 'formatNightDay', 'name' => __('Display format of the "Total length of stay"', $this->pluginName), 'target' => 'hotel', 'disabled' => 0, 'value' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(0 => 2 . __('nights', $this->pluginName), 1 => sprintf(__('%s nights %s days', $this->pluginName), '2', '3'))),
                
                'expressionsCheck' => array('key' => 'expressionsCheck', 'name' => __('Display format of the "Arrival and Departure"', $this->pluginName), 'target' => 'hotel', 'disabled' => 0, 'value' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(0 => __('Arrival (Check-in) & Departure (Check-out)', $this->pluginName), 1 => __('Arrival & Departure', $this->pluginName), 2 => __('Check-in & Check-out', $this->pluginName))),
                'multipleRooms' => array('key' => 'multipleRooms', 'name' => __('Allow booking of multiple rooms', $this->pluginName), 'target' => 'hotel', 'disabled' => 0, 'value' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                
                'preparationTime' => array('key' => 'preparationTime', 'name' => __('Preparation time', $this->pluginName), 'target' => 'day', 'value' => '', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 1, 'valueList' => array()),
                'positionPreparationTime' => array('key' => 'positionPreparationTime', 'name' => __('Position of preparation time', $this->pluginName), 'target' => 'day', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'option' => 0, 'valueList' => array('before_after' => __('Before and after booked time', $this->pluginName), 'before' => __('Before booked time', $this->pluginName), 'after' => __('After booked time', $this->pluginName))),
                'flowOfBooking' => array('key' => 'flowOfBooking', 'name' => __('Flow of booking procedure on front-end page', $this->pluginName), 'target' => 'day', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array('calendar' => __('Start by selecting a date', $this->pluginName), 'services' => __('Start by selecting a service', $this->pluginName))),
                'courseBool' => array('key' => 'courseBool', 'name' => __('Service function', $this->pluginName), 'target' => 'day', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                'hasMultipleServices' => array('key' => 'hasMultipleServices', 'name' => __('Selection of multiple services', $this->pluginName), 'target' => 'day', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                'courseTitle' => array('key' => 'courseTitle', 'name' => __('Service name', $this->pluginName), 'target' => 'day', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'option' => 0),
                'guestsBool' => array('key' => 'guestsBool', 'name' => __('Guest function', $this->pluginName), 'target' => 'day', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                
                'minimum_guests' => array(
                    'key' => 'minimum_guests', 
                    'name' => __('Minimum the number of guests per one booking', $this->pluginName), 
                    'target' => 'day', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 1, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'minimumGuests',
                            'name' => '',
                            'value' => null,
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(1 => __('Enabled', $this->pluginName)),
                        ),
                        1 => array(
                            'key' => 'minimumGuestsRequiredNo',
                            'name' => __('Includes "No" selected on "Required" in the Guests', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 1, 
                            'class' => 'multiple_fields_margin_top',
                            'actions' => null,
                            'valueList' => array(1 => __('Included', $this->pluginName)),
                        ),
                        2 => array(
                            'key' => 'minimumGuestsOfValue',
                            'name' => __('Number of guests', $this->pluginName) . ': ',
                            'value' => 0,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 1, 
                            'class' => 'multiple_fields_margin_top',
                            'actions' => null,
                            'valueList' => array(),
                        ),
                    ),
                ), 
                
                'maximum_guests' => array(
                    'key' => 'maximum_guests', 
                    'name' => __('Maximum the number of guests per one booking', $this->pluginName), 
                    'target' => 'day', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 1, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'maximumGuests',
                            'name' => '',
                            'value' => null,
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(1 => __('Enabled', $this->pluginName)),
                        ),
                        1 => array(
                            'key' => 'maximumGuestsRequiredNo',
                            'name' => __('Includes "No" selected on "Required" in the Guests', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 1, 
                            'class' => 'multiple_fields_margin_top',
                            'actions' => null,
                            'valueList' => array(1 => __('Included', $this->pluginName)),
                        ),
                        2 => array(
                            'key' => 'maximumGuestsOfValue',
                            'name' => __('Number of guests', $this->pluginName) . ': ',
                            'value' => 0,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 1, 
                            'class' => 'multiple_fields_margin_top',
                            'actions' => null,
                            'valueList' => array(),
                        ),
                    ),
                ), 
                
                
                'insertConfirmedPage' => array('key' => 'insertConfirmedPage', 'name' => __('Insert a booking confirmed page between the input page and the completed page', $this->pluginName), 'target' => 'both', 'value' => '0', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                'displayRemainingCapacityInCalendar' => array('key' => 'displayRemainingCapacityInCalendar', 'name' => __('Display the remaining capacity as a phrase or symbol in the calendar', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                'displayRemainingCapacityInCalendarAsNumber' => array('key' => 'displayRemainingCapacityInCalendarAsNumber', 'name' => __('Display the remaining capacity as a number instead of symbols in the calendar', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                'displayThresholdOfRemainingCapacity' => array('key' => 'displayThresholdOfRemainingCapacity', 'name' => __('Threshold of remaining capacity', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(90 => '90%', 80 => '80%', 70 => '70%', 60 => '60%', 50 => '50%', 40 => '40%', 30 => '30%', 20 => '20%', 10 => '10%')),
                'displayRemainingCapacityHasMoreThenThreshold' => array('key' => 'displayRemainingCapacityHasMoreThenThreshold', 'name' => __('A phrase or symbol on a day when the remaining capacity has more than threshold', $this->pluginName), 'target' => 'both', 'value' => '', 'inputLimit' => 2, 'inputType' => 'REMAINING_CAPACITY', 'isExtensionsValid' => 0, 'option' => 0, 'format' => 'json', 'valueList' => '', "optionsType" => array("symbol" => array("type" => "TEXT", "value" => ""), "color" => array("type" => "TEXT", "value" => "#969696", "js" => "colorPicker")), 'titleList' => array(), 'message' => __('You can use the web font of <a href="https://material.io/tools/icons/?style=baseline" target="_blank">Material icons</a>.', $this->pluginName)),
                'displayRemainingCapacityHasLessThenThreshold' => array('key' => 'displayRemainingCapacityHasLessThenThreshold', 'name' => __('A phrase or symbol on a day when the remaining capacity has less than threshold', $this->pluginName), 'target' => 'both', 'value' => '', 'inputLimit' => 2, 'inputType' => 'REMAINING_CAPACITY', 'isExtensionsValid' => 0, 'option' => 0, 'format' => 'json', 'valueList' => '', "optionsType" => array("symbol" => array("type" => "TEXT", "value" => ""), "color" => array("type" => "TEXT", "value" => "#969696", "js" => "colorPicker")), 'titleList' => array(), 'message' => __('You can use the web font of <a href="https://material.io/tools/icons/?style=baseline" target="_blank">Material icons</a>.', $this->pluginName)),
                'displayRemainingCapacityHas0' => array('key' => 'displayRemainingCapacityHas0', 'name' => __('A phrase or symbol on a day when remaining capacity has 0%', $this->pluginName), 'target' => 'both', 'value' => 'close', 'inputLimit' => 2, 'inputType' => 'REMAINING_CAPACITY', 'isExtensionsValid' => 0, 'option' => 0, 'format' => 'json', 'valueList' => '', "optionsType" => array("symbol" => array("type" => "TEXT", "value" => ""), "color" => array("type" => "TEXT", "value" => "#969696", "js" => "colorPicker")), 'titleList' => array(), 'message' => __('You can use the web font of <a href="https://material.io/tools/icons/?style=baseline" target="_blank">Material icons</a>.', $this->pluginName)),
                
                #'displayRemainingCapacityHasMoreThenThreshold1' => array('key' => 'displayRemainingCapacityHasMoreThenThreshold1', 'name' => __('A phrase or symbol on a day when the remaining capacity has more than threshold', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'REMAINING_CAPACITY', 'isExtensionsValid' => 0, 'option' => 0, 'format' => 'json', 'valueList' => '', "optionsType" => array("symbol" => array("type" => "TEXT", "value" => ""), "color" => array("type" => "TEXT", "value" => "#969696", "js" => "colorPicker")), 'titleList' => array()),
                #'displayRemainingCapacityHasMoreThenThreshold2' => array('key' => 'displayRemainingCapacityHasMoreThenThreshold2', 'name' => __('A phrase or symbol on a day when the remaining capacity has more than threshold', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'REMAINING_CAPACITY', 'isExtensionsValid' => 0, 'option' => 0, 'format' => 'json', 'valueList' => '', "optionsType" => array("symbol" => array("type" => "TEXT", "value" => ""), "color" => array("type" => "TEXT", "value" => "", "js" => "colorPicker")), 'titleList' => array()),
                #, 'format' => 'json', 'valueList' => '', "optionsType" => array("name" => array("type" => "TEXT", "value" => ""), "cost" => array("type" => "TEXT", "value" => ""), "time" => array("type" => "SELECT", "value" => 0, "start" => 0, "end" => 245, "addition" => 5, 'unit' => __("%s min", $this->pluginName))), 'titleList' => array('name' => __('Name', $this->pluginName), 'cost' => __('Price', $this->pluginName), 'time' => __('Additional time', $this->pluginName))
                
                'displayRemainingCapacity' => array('key' => 'displayRemainingCapacity', 'name' => __('Display remaining capacity in schedule label', $this->pluginName), 'target' => 'both', 'value' => 0, 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                'maxAccountScheduleDay' => array('key' => 'maxAccountScheduleDay', 'name' => 'Public days from today', 'target' => 'both', 'disabled' => 0, 'value' => '0', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'option' => 0),
                'unavailableDaysFromToday' => array('key' => 'unavailableDaysFromToday', 'name' => 'Unavailable days from today', 'target' => 'both', 'disabled' => 0, 'value' => '0', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30')),
                'fixCalendar' => array('key' => 'fixCalendar', 'name' => 'Fixed calendar', 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'FIX_CALENDAR', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(0 => 'month', 1 => 'year')),
                #'googleCalendarID' => array('key' => 'googleCalendarID', 'name' => 'Google Calendar ID', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'option' => 0),
                
                'displayDetailsOfCanceled' => array('key' => 'displayDetailsOfCanceled', 'name' => __('Display details of the canceled visitors and user on the Report & Booking page', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                //'cancellationOfBooking' => array('key' => 'cancellationOfBooking', 'name' => __('Cancellation of booking by visitor and user', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                'blockSameTimeBookingByUser' => array('key' => 'blockSameTimeBookingByUser', 'name' => __('Block multiple booking in the same time slot', $this->pluginName), 'target' => 'day', 'value' => '0', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'option' => 0, 'valueList' => array(1 => 'Enabled', 0 => 'Disabled')),
                /**
                'allowCancellationVisitor' => array('key' => 'allowCancellationVisitor', 'name' => __('Allow cancellation by visitor up to', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 1, 'option' => 0, 
                    'valueList' => array(
                        30 => sprintf(__('%s minutes ago', $this->pluginName), "30"), 
                        60 => sprintf(__('%s hour ago', $this->pluginName), "1"), 
                        120 => sprintf(__('%s hours ago', $this->pluginName), "2"), 
                        240 => sprintf(__('%s hours ago', $this->pluginName), "4"), 
                        480 => sprintf(__('%s hours ago', $this->pluginName), "8"), 
                        720 => sprintf(__('%s hours ago', $this->pluginName), "12"), 
                        1440 => sprintf(__('%s day ago', $this->pluginName), "1"), 
                        2880 => sprintf(__('%s days ago', $this->pluginName), "2"), 
                        4320 => sprintf(__('%s days ago', $this->pluginName), "3"),
                        5760 => sprintf(__('%s days ago', $this->pluginName), "4"),
                        7200 => sprintf(__('%s days ago', $this->pluginName), "5"),
                    )
                ),
                **/
                'bookingReminder' => array('key' => 'bookingReminder', 'name' => __('Booking reminder', $this->pluginName), 'target' => 'both', 'disabled' => 0, 'value' => '0', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 1, 'option' => 0, 
                    'valueList' => array(
                        '60' => sprintf(__('About %d hour ago', $this->pluginName), 1), 
                        '120' => sprintf(__('About %d hours ago', $this->pluginName), 2), 
                        '180' => sprintf(__('About %d hours ago', $this->pluginName), 3), 
                        '240' => sprintf(__('About %d hours ago', $this->pluginName), 4), 
                        '300' => sprintf(__('About %d hours ago', $this->pluginName), 5), 
                        '360' => sprintf(__('About %d hours ago', $this->pluginName), 6), 
                        '420' => sprintf(__('About %d hours ago', $this->pluginName), 7), 
                        '480' => sprintf(__('About %d hours ago', $this->pluginName), 8), 
                        '540' => sprintf(__('About %d hours ago', $this->pluginName), 9), 
                        '600' => sprintf(__('About %d hours ago', $this->pluginName), 10), 
                        '660' => sprintf(__('About %d hours ago', $this->pluginName), 11), 
                        '720' => sprintf(__('About %d hours ago', $this->pluginName), 12), 
                        '1440' => sprintf(__('About %d hours ago', $this->pluginName), 24), 
                        '2160' => sprintf(__('About %d hours ago', $this->pluginName), 36), 
                        '2880' => sprintf(__('About %d hours ago', $this->pluginName), 48), 
                        '3600' => sprintf(__('About %d hours ago', $this->pluginName), 60), 
                        '4320' => sprintf(__('About %d hours ago', $this->pluginName), 72), 
                    )
                ),
                'cancellation_of_booking' => array(
                    'key' => 'cancellation_of_booking', 
                    'name' => __('Cancel a booking by your customer', $this->pluginName), 
                    'target' => 'both', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 1, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'cancellationOfBooking',
                            'name' => '',
                            'value' => null,
                            'inputType' => 'RADIO',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(1 => __('Enabled', $this->pluginName), 0 => __('Disabled', $this->pluginName)),
                        ),
                        1 => array(
                            'key' => 'allowCancellationVisitor',
                            'name' => __('Time', $this->pluginName) . ': ',
                            'value' => '30',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(
                                30 => array('key' => 30, 'name' => sprintf(__('%s minutes ago', $this->pluginName), "30")), 
                                60 => array('key' => 60, 'name' => sprintf(__('%s hour ago', $this->pluginName), "1")), 
                                120 => array('key' => 120, 'name' => sprintf(__('%s hours ago', $this->pluginName), "2")), 
                                240 => array('key' => 240, 'name' => sprintf(__('%s hours ago', $this->pluginName), "4")), 
                                480 => array('key' => 480, 'name' => sprintf(__('%s hours ago', $this->pluginName), "8")), 
                                720 => array('key' => 720, 'name' => sprintf(__('%s hours ago', $this->pluginName), "12")), 
                                1440 => array('key' => 1440, 'name' => sprintf(__('%s day ago', $this->pluginName), "1")), 
                                2880 => array('key' => 2880, 'name' => sprintf(__('%s days ago', $this->pluginName), "2")), 
                                4320 => array('key' => 4320, 'name' => sprintf(__('%s days ago', $this->pluginName), "3")), 
                                5760 => array('key' => 5760, 'name' => sprintf(__('%s days ago', $this->pluginName), "4")), 
                                7200 => array('key' => 7200, 'name' => sprintf(__('%s days ago', $this->pluginName), "5")), 
                                8640 => array('key' => 8640, 'name' => sprintf(__('%s days ago', $this->pluginName), "6")), 
                                10080 => array('key' => 10080, 'name' => sprintf(__('%s days ago', $this->pluginName), "7")), 
                                11520 => array('key' => 11520, 'name' => sprintf(__('%s days ago', $this->pluginName), "8")), 
                                12960 => array('key' => 12960, 'name' => sprintf(__('%s days ago', $this->pluginName), "9")), 
                                14400 => array('key' => 14400, 'name' => sprintf(__('%s days ago', $this->pluginName), "10")), 
                                15840 => array('key' => 15840, 'name' => sprintf(__('%s days ago', $this->pluginName), "11")), 
                                17280 => array('key' => 17280, 'name' => sprintf(__('%s days ago', $this->pluginName), "12")), 
                                18720 => array('key' => 18720, 'name' => sprintf(__('%s days ago', $this->pluginName), "13")), 
                                20160 => array('key' => 20160, 'name' => sprintf(__('%s days ago', $this->pluginName), "14")), 
                            ),
                        ),
                        2 => array(
                            'key' => 'refuseCancellationOfBooking',
                            'name' => __('Status of booking', $this->pluginName) . ': ',
                            'value' => '30',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(
                                0 => array('key' => 'not_refuse', 'name' => __('Pending and Approved', $this->pluginName)), 
                                1 => array('key' => 'pending', 'name' => __('Pending', $this->pluginName)), 
                                2 => array('key' => 'approved', 'name' => __('Approved', $this->pluginName)), 
                            ),
                        ),
                    ),
                ), 
                /**
                'refuseCancellationOfBooking' => array('key' => 'refuseCancellationOfBooking', 'name' => __('Status to approve cancellation of booking', $this->pluginName).":", 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 1, 'option' => 0, 
                    'valueList' => array(
                        'not_refuse' => __('Pending and Approved', $this->pluginName), 
                        'pending' => __('Pending', $this->pluginName), 
                        'approved' => __('Approved', $this->pluginName), 
                    )
                ),
                **/
                
                'servicesPage' => array('key' => 'servicesPage', 'name' => __('Services page for front-end', $this->pluginName), 'target' => 'day', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'message' => __('Add "booking-package" to the name and "front-end" to the value on the Custom Fields in the Pages.', $this->pluginName), 'valueList' => array()),
                'calenarPage' => array('key' => 'calenarPage', 'name' => __('Calendar page for front-end', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'message' => __('Add "booking-package" to the name and "front-end" to the value on the Custom Fields in the Pages.', $this->pluginName), 'valueList' => array()),
                'schedulesPage' => array('key' => 'schedulesPage', 'name' => __('Schedules page for front-end', $this->pluginName), 'target' => 'day', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'message' => __('Add "booking-package" to the name and "front-end" to the value on the Custom Fields in the Pages.', $this->pluginName), 'valueList' => array()),
                'visitorDetailsPage' => array('key' => 'visitorDetailsPage', 'name' => __('Visitor details page for front-end', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'message' => __('Add "booking-package" to the name and "front-end" to the value on the Custom Fields in the Pages.', $this->pluginName), 'valueList' => array()),
                'confirmDetailsPage' => array('key' => 'confirmDetailsPage', 'name' => __('Booking confirmed page for front-end', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'message' => __('Add "booking-package" to the name and "front-end" to the value on the Custom Fields in the Pages.', $this->pluginName), 'valueList' => array()),
                'thanksPage' => array('key' => 'thanksPage', 'name' => __('Booking completed page for front-end', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'message' => __('Add "booking-package" to the name and "front-end" to the value on the Custom Fields in the Pages.', $this->pluginName), 'valueList' => array()),
                #'redirectPage' => array('key' => 'redirectPage', 'name' => __('Redirect to another page without displaying the booking completion page', $this->pluginName), 'target' => 'both', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'option' => 0, 'message' => __('Add "booking-package" to the name and "front-end" to the value on the Custom Fields in the Pages.', $this->pluginName), 'valueList' => array()),
                'redirect_Page' => array(
                    'key' => 'redirect_Page', 
                    'name' => __('Redirect to another page without displaying the booking completion page', $this->pluginName), 
                    'target' => 'both', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 0, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'redirectMode',
                            'name' => '',
                            'value' => 'page',
                            'inputType' => 'RADIO',
                            'isExtensionsValid' => 0, 
                            'actions' => null,
                            'valueList' => array('page' => __('Pages', $this->pluginName), 'url' => __('URL', $this->pluginName)),
                        ),
                        1 => array(
                            'key' => 'redirectPage',
                            'name' => __('Pages', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 0, 
                            'className' => 'multiple_fields_margin_top',
                            'actions' => null,
                            'valueList' => array(1 => __('Enabled', $this->pluginName)),
                            'message' => __('Add "booking-package" to the name and "front-end" to the value on the Custom Fields in the Pages.', $this->pluginName),
                        ),
                        2 => array(
                            'key' => 'redirectURL',
                            'name' => __('URL', $this->pluginName) . ': ',
                            'value' => '',
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 0, 
                            'className' => 'multiple_fields_margin_top',
                            'actions' => null,
                            'valueList' => array(),
                        ),
                    ),
                ),
                
            );
            
            
            return $calendarAccount;
            
        }
        
        public function getCourseData(){
            
            $month = array(
                '1' => array('key' => 1, 'name' => __('Jan', $this->pluginName)), 
                '2' => array('key' => 2, 'name' => __('Feb', $this->pluginName)), 
                '3' => array('key' => 3, 'name' => __('Mar', $this->pluginName)), 
                '4' => array('key' => 4, 'name' => __('Apr', $this->pluginName)), 
                '5' => array('key' => 5, 'name' => __('May', $this->pluginName)), 
                '6' => array('key' => 6, 'name' => __('Jun', $this->pluginName)), 
                '7' => array('key' => 7, 'name' => __('Jul', $this->pluginName)), 
                '8' => array('key' => 8, 'name' => __('Aug', $this->pluginName)), 
                '9' => array('key' => 9, 'name' => __('Sep', $this->pluginName)), 
                '10' => array('key' => 10, 'name' => __('Oct', $this->pluginName)), 
                '11' => array('key' => 11, 'name' => __('Nov', $this->pluginName)), 
                '12' => array('key' => 12, 'name' => __('Dec', $this->pluginName)), 
            );
            
            $day = array();
            for ($i = 1; $i <= 31; $i++) {
                
                $day[$i] = array('key' => $i, 'name' => $i);
                
            }
            
            $yearList = array();
            for ($i = 0; $i <= 10; $i++) {
                
                $year = date('Y') + $i;
                $yearList[$year] = array('key' => $year, 'name' => $year);
                
            }
            
            $addNewCourse =  array(
                'name' => array('name' => __('Name', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'description' => array('name' => __('Description', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXTAREA', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'active' => array('name' => __('Active', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'CHECK', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => array('true' => __('Enabled', $this->pluginName))),
                'target' => array('name' => __('Target', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 0, 'valueList' => array('visitors_users' => __('Customers and Users', $this->pluginName), 'visitors' => __('Customers', $this->pluginName), 'users' => __('Users', $this->pluginName))),
                'stopService' => array(
                    'key' => 'stopService',
                    'name' => __('Stop this service under the following conditions', $this->pluginName), 
                    'value' => '', 
                    'inputLimit' => 1, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 1,
                    'message' => __('If you have selected a value other than the "Disabled", the "Selection of multiple services" will be disabled.', $this->pluginName),
                    'valueList' => array(
                        0 => array(
                            'key' => 'stopServiceUnderFollowingConditions',
                            'name' => /**'Under the following conditions'**/ '',
                            'value' => null,
                            'inputType' => 'RADIO',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(
                                'doNotStop' => __('Disabled', $this->pluginName), 
                                'isNotEqual' => __('The "Capacity" and "Remaining" values of the time slot are not equal.', $this->pluginName), 
                                'isEqual' => __('The "Capacity" and "Remaining" values of the time slot are equal.', $this->pluginName),
                                'specifiedNumberOfTimes' => __('When the specified number of times is reached.', $this->pluginName),
                            ),
                            'className' => 'stopServiceUnderFollowingConditions',
                        ),
                        1 => array(
                            'key' => 'doNotStopServiceAsException',
                            'name' => '',
                            'value' => null,
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array( 
                                'sameServiceIsNotStopped' => __('If the same service was in the time slot, the booking is not stopped.', $this->pluginName), 
                            ),
                            'className' => 'doNotStopServiceAsException',
                        ),
                        2 => array(
                            'key' => 'stopServiceForDayOfTimes',
                            'name' => __('Target', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'RADIO',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array( 
                                'day' => __('Per day.', $this->pluginName), 
                                'timeSlot' => __('Per time slot.', $this->pluginName), 
                            ),
                            'className' => 'stopServiceForDayOfTimes',
                        ),
                        3 => array(
                            'key' => 'stopServiceForSpecifiedNumberOfTimes',
                            'name' => __('Number of times', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(),
                            'className' => 'stopServiceForSpecifiedNumberOfTimes',
                        ),
                    ),
                ),
                'costs' => array(
                    'key' => 'costs', 
                    'name' => __('Costs', $this->pluginName), 
                    'target' => 'day', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 0, 
                    'option' => 0,
                    'message' => '',
                    'valueList' => array(
                        0 => array(
                            'key' => 'cost_1',
                            'name' => __(/**'Cost 1'**/ 'Standard cost', $this->pluginName),
                            'value' => null,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 0, 
                            'actions' => null,
                            'valueList' => array(),
                            'className' => 'costs',
                        ),
                        1 => array(
                            'key' => 'cost_2',
                            'name' => __('Cost 2', $this->pluginName),
                            'value' => null,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(),
                            'className' => 'costs',
                        ),
                        2 => array(
                            'key' => 'cost_3',
                            'name' => __('Cost 3', $this->pluginName),
                            'value' => null,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(),
                            'className' => 'costs',
                        ),
                        3 => array(
                            'key' => 'cost_4',
                            'name' => __('Cost 4', $this->pluginName),
                            'value' => null,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(),
                            'className' => 'costs',
                        ),
                        4 => array(
                            'key' => 'cost_5',
                            'name' => __('Cost 5', $this->pluginName),
                            'value' => null,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(),
                            'className' => 'costs',
                        ),
                        5 => array(
                            'key' => 'cost_6',
                            'name' => __('Cost 6', $this->pluginName),
                            'value' => null,
                            'inputType' => 'TEXT',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array(),
                            'className' => 'costs',
                        ),
                    ),
                ), 
                'expirationDate' => array(
                    'key' => 'expirationDate', 
                    'name' => __('Expiration date', $this->pluginName), 
                    'target' => 'both', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 0, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'expirationDateStatus',
                            'name' => '',
                            'value' => '0',
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 0, 
                            'actions' => null,
                            'valueList' => array('1' => __('Enabled', $this->pluginName)),
                        ),
                        1 => array(
                            'key' => 'expirationDateFromMonth',
                            'name' => __('From:', $this->pluginName) . ' ',
                            'value' => null,
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 0, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $month,
                        ),
                        2 => array(
                            'key' => 'expirationDateFromDay',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 0, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $day,
                        ),
                        3 => array(
                            'key' => 'expirationDateFromYear',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 0, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $yearList,
                        ),
                        4 => array(
                            'key' => 'expirationDateToMonth',
                            'name' => __('To:', $this->pluginName) . ' ',
                            'value' => null,
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 0, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $month,
                        ),
                        5 => array(
                            'key' => 'expirationDateToDay',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 0, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $day,
                        ),
                        6 => array(
                            'key' => 'expirationDateToYear',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 0, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $yearList,
                        ),
                    ),
                ),
                'time' => array('name' => __('Duration time', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => array()),
                'timeToProvide' => array('name' => __('Time to provide service', $this->pluginName), 'value' => '0', 'inputLimit' => 2, 'inputType' => 'TIME_TO_PROVIDE', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => array()),
                'selectOptions' => array('name' => __('Selection of multiple options', $this->pluginName), 'value' => '0', 'inputLimit' => 2, 'inputType' => 'CHECK', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => array('1' => __('Enabled', $this->pluginName))),
                'options' => array(
                    'name' => __('Options', $this->pluginName), 
                    'value' => '', 
                    'inputLimit' => 2, 
                    'inputType' => 'EXTRA', 
                    'isExtensionsValid' => 1, 
                    'isExtensionsValidPanel' => 0, 
                    'format' => 'json', 
                    'valueList' => '', 
                    "optionsType" => array(
                        "name" => array("type" => "TEXT", "value" => "", "target" => "both"), 
                        /** "cost" => array("type" => "TEXT", "value" => "", "target" => "both"), **/
                        "cost_1" => array("type" => "TEXT", "value" => "", "target" => "both"), 
                        "cost_2" => array("type" => "TEXT", "value" => "", "target" => "both"), 
                        "cost_3" => array("type" => "TEXT", "value" => "", "target" => "both"), 
                        "cost_4" => array("type" => "TEXT", "value" => "", "target" => "both"), 
                        "cost_5" => array("type" => "TEXT", "value" => "", "target" => "both"), 
                        "cost_6" => array("type" => "TEXT", "value" => "", "target" => "both"), 
                        "time" => array("type" => "SELECT", "value" => 0, "target" => "both", "start" => 0, "end" => 725, "addition" => 5, 'unit' => __("%s min", $this->pluginName))
                    ), 
                    'titleList' => array('name' => __('Name', $this->pluginName), 
                    /** 'cost' => __('Price', $this->pluginName), **/
                    'cost_1' => __(/**'Cost 1'**/ 'Standard cost', $this->pluginName), 
                    'cost_2' => __('Cost 2', $this->pluginName), 
                    'cost_3' => __('Cost 3', $this->pluginName), 
                    'cost_4' => __('Cost 4', $this->pluginName), 
                    'cost_5' => __('Cost 5', $this->pluginName), 
                    'cost_6' => __('Cost 6', $this->pluginName), 
                    
                    'time' => __('Additional time', $this->pluginName))
                ),
            );
            return $addNewCourse;
            
        }
        
        public function getSubscriptionsData(){
            
            $addSubscriptions = array(
                'subscription' => array('name' => 'Subscription', 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'name' => array('name' => 'Name', 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'active' => array('name' => 'Active', 'value' => '', 'inputLimit' => 2, 'inputType' => 'CHECK', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => array('true' => __('Enabled', $this->pluginName))),
                'renewal' => array('name' => 'Automatic subscription renewal', 'value' => '', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'valueList' => array('0' => __('Invalid', $this->pluginName), '1' => __('Valid', $this->pluginName)), "message" => ''),
                'limit' => array('name' => 'Booking limit', 'value' => '', 'inputLimit' => 1, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'valueList' => array('0' => __('Invalid', $this->pluginName), '1' => __('Valid', $this->pluginName)), "message" => ''),
                'numberOfTimes' => array('name' => 'Number of times users can book by the following deadline', 'value' => '', 'inputLimit' => 1, 'inputType' => 'SELECT', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => array(1 => '1', 2 => '2')),
            );
            
            return $addSubscriptions;
            
        }
        
        public function getTaxesData(){
            
            $month = array(
                '1' => array('key' => 1, 'name' => __('Jan', $this->pluginName)), 
                '2' => array('key' => 2, 'name' => __('Feb', $this->pluginName)), 
                '3' => array('key' => 3, 'name' => __('Mar', $this->pluginName)), 
                '4' => array('key' => 4, 'name' => __('Apr', $this->pluginName)), 
                '5' => array('key' => 5, 'name' => __('May', $this->pluginName)), 
                '6' => array('key' => 6, 'name' => __('Jun', $this->pluginName)), 
                '7' => array('key' => 7, 'name' => __('Jul', $this->pluginName)), 
                '8' => array('key' => 8, 'name' => __('Aug', $this->pluginName)), 
                '9' => array('key' => 9, 'name' => __('Sep', $this->pluginName)), 
                '10' => array('key' => 10, 'name' => __('Oct', $this->pluginName)), 
                '11' => array('key' => 11, 'name' => __('Nov', $this->pluginName)), 
                '12' => array('key' => 12, 'name' => __('Dec', $this->pluginName)), 
            );
            
            $day = array();
            for ($i = 1; $i <= 31; $i++) {
                
                $day[$i] = array('key' => $i, 'name' => $i);
                
            }
            
            $yearList = array();
            for ($i = 0; $i <= 10; $i++) {
                
                $year = date('Y') + $i;
                $yearList[$year] = array('key' => $year, 'name' => $year);
                
            }
            
            $addSubscriptions = array(
                'name' => array('name' => __('Name', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'active' => array('name' => __('Active', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'CHECK', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => array('true' => __('Enabled', $this->pluginName))),
                'type' => array('name' => __('Type', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => array('tax' => __('Tax', $this->pluginName), 'surcharge' => __('Surcharge', $this->pluginName)), 'option' => 1, 'optionsList' => array('tax' => 1)),
                'tax' => array('name' => __('Tax', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => array('tax_exclusive' => __('Tax-exclusive pricing', $this->pluginName), 'tax_inclusive' => __('Tax-inclusive pricing', $this->pluginName))),
                'method' => array('name' => __('Calculation method', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => array('addition' => __('Addition', $this->pluginName), 'multiplication' => __('Multiplication', $this->pluginName))),
                'target' => array('name' => __('Target of tax or surcharge', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => array('room' => __('Per room', $this->pluginName), 'guest' => __('Per guest', $this->pluginName))),
                'scope' => array('name' => __('Range of tax or surcharge', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => array('day' => __('Per day', $this->pluginName), 'booking' => __('Per one booking', $this->pluginName), 'bookingEachGuests' => __('Per one booking for all guests', $this->pluginName))),
                'value' => array('name' => __('Value', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'expirationDate' => array(
                    'key' => 'expirationDate', 
                    'name' => __('Expiration date', $this->pluginName), 
                    'target' => 'both', 
                    'disabled' => 0, 
                    'value' => '1', 
                    'inputLimit' => 2, 
                    'inputType' => 'MULTIPLE_FIELDS', 
                    'isExtensionsValid' => 1, 
                    'option' => 0,
                    'valueList' => array(
                        0 => array(
                            'key' => 'expirationDateStatus',
                            'name' => '',
                            'value' => '0',
                            'inputType' => 'CHECK',
                            'isExtensionsValid' => 1, 
                            'actions' => null,
                            'valueList' => array('1' => __('Enabled', $this->pluginName)),
                        ),
                        1 => array(
                            'key' => 'expirationDateFromMonth',
                            'name' => __('From', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $month,
                        ),
                        2 => array(
                            'key' => 'expirationDateFromDay',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $day,
                        ),
                        3 => array(
                            'key' => 'expirationDateFromYear',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateFrom',
                            'actions' => null,
                            'valueList' => $yearList,
                        ),
                        4 => array(
                            'key' => 'expirationDateToMonth',
                            'name' => __('To', $this->pluginName) . ': ',
                            'value' => null,
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $month,
                        ),
                        5 => array(
                            'key' => 'expirationDateToDay',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $day,
                        ),
                        6 => array(
                            'key' => 'expirationDateToYear',
                            'name' => '',
                            'value' => '',
                            'inputType' => 'SELECT',
                            'isExtensionsValid' => 1, 
                            'className' => 'expirationDateTo',
                            'actions' => null,
                            'valueList' => $yearList,
                        ),
                    ),
                ),
            );
            
            return $addSubscriptions;
            
        }
        
        public function getOptionsForHotelData(){
            
            $addSubscriptions = array(
                'name' => array('name' => __('Name', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'active' => array('name' => __('Active', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'CHECK', 'isExtensionsValid' => 0, 'isExtensionsValidPanel' => 1, 'valueList' => array('true' => __('Enabled', $this->pluginName))),
                'required' => array('key' => 'required', 'name' => 'Required', 'value' => 'true', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""),
                'target' => array('name' => __('Target', $this->pluginName), 'value' => 'guests', 'inputLimit' => 2, 'inputType' => 'RADIO', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => array('guests' => __('Per guest', $this->pluginName), 'room' => __('Per room', $this->pluginName)), 'actions' => null),
                'chargeForAdults' => array('name' => __('Charge for adults', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'chargeForChildren' => array('name' => __('Charge for children', $this->pluginName), 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                'chargeForRoom' => array('name' => __('Charge for room', $this->pluginName), 'value' => '', 'disabled' => 1, 'inputLimit' => 1, 'inputType' => 'TEXT', 'isExtensionsValid' => 1, 'isExtensionsValidPanel' => 1, 'valueList' => ''),
                
            );
            
            return $addSubscriptions;
            
        }
        
        public function getFormInputType(){
            
            $formInputType = array(
                'id' => array('key' => 'id', 'name' => 'Unique ID', 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', "class" => ""),
                'name' => array('key' => 'name', 'name' => 'Name', 'value' => '', 'inputLimit' => 1, 'inputType' => 'TEXT', "class" => ""),
                'value' => array('key' => 'value', 'name' => 'Value', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', "class" => "hidden_panel"),
                
                'groupId' => array('key' => 'groupId', 'name' => 'Group ID', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', "class" => ""),
                #'groupName' => array('key' => 'groupName', 'name' => 'Group name', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', "class" => ""),
                'uri' => array('key' => 'uri', 'name' => 'URI', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', "class" => ""),
                
                'placeholder' => array('key' => 'placeholder', 'name' => __('Placeholder text', $this->pluginName), 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXT', "class" => ""),
                'description' => array('key' => 'description', 'name' => 'Description', 'value' => '', 'inputLimit' => 2, 'inputType' => 'TEXTAREA', "class" => ""),
                'active' => array('key' => 'active', 'name' => 'Active', 'value' => 'true', 'inputLimit' => 2, 'inputType' => 'CHECK', 'valueList' => array('true' => __('On', $this->pluginName)), "class" => ""),
                /** 'required' => array('key' => 'required', 'name' => 'Required', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""), **/
                'required' => array('key' => 'required', 'name' => 'Required', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName) . ' - ' . __('The front-end and the dashboard', $this->pluginName), 'true_frontEnd' => __('Yes', $this->pluginName) . ' - ' . __('The front-end only', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""),
                'isName' => array('key' => 'isName', 'name' => 'Is Name', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""),
                'isEmail' => array('key' => 'isEmail', 'name' => 'Is Email', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""),
                'isSMS' => array('key' => 'isSMS', 'name' => 'Is SMS (Short Message Service)', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""),
                'isAddress' => array('key' => 'isAddress', 'name' => 'Is a location in Google Calendar', 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""),
                'isTerms' => array('key' => 'isTerms', 'name' => __('Is Terms of Service or Privacy Policy', $this->pluginName), 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""),
                'isAutocomplete' => array('key' => 'isAutocomplete', 'name' => __('Save a value of this field as autocomplete on user', $this->pluginName), 'value' => 'false', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('true' => __('Yes', $this->pluginName), 'false' => __('No', $this->pluginName)), "class" => ""),
                'targetCustomers' => array('key' => 'targetCustomers', 'name' => __('Target customers', $this->pluginName), 'value' => 'customers', 'inputLimit' => 1, 'inputType' => 'RADIO', 'valueList' => array('customersAndUsers' => __('Customers and Users', $this->pluginName), 'visitors' => __('Customers', $this->pluginName), 'users' => __('Users', $this->pluginName)), "class" => ""),
                'type' => array('key' => 'type', 'name' => 'Type', 'value' => 'TEXT', 'inputLimit' => 1, 'inputType' => 'SELECT', 'valueList' => array('TEXT' => 'TEXT', 'SELECT' => 'SELECT', 'CHECK' => 'CHECK', 'RADIO' => 'RADIO', 'TEXTAREA' => 'TEXTAREA'), "class" => ""),
                'options' => array('key' => 'options', 'name' => 'Options', 'value' => '', 'inputLimit' => 2, 'inputType' => 'OPTION', 'format' => 'array', "class" => "", "options" => array("name" => "text"), 'format' => 'jsonString', 'optionsType' => array(array("type" => "TEXT", "value" => "", "target" => "both"))),
            );
            return $formInputType;
            
        }
        
        public function updateMemberSetting(){
            
            global $wpdb;
            $isExtensionsValid = $this->getExtensionsValid(false);
            $user_toolbar = intval(get_option($this->prefix . 'user_toolbar', 0));
            if (isset($_POST['user_toolbar']) && intval($_POST['user_toolbar']) != $user_toolbar) {
                
                $bool = 'false';
                if (intval($_POST['user_toolbar']) == 1) {
                    
                    $bool = 'true';
                    
                }
                $table_name = $wpdb->prefix."booking_package_users";
                $sql = $wpdb->prepare("SELECT `key` FROM ".$table_name.";", array());
                $rows = $wpdb->get_results($sql, ARRAY_A);
                for ($i = 0; $i < count($rows); $i++) {
                    
                    $key = intval($rows[$i]['key']);
                    update_user_meta($key, 'show_admin_bar_front', $bool);
                    
                }
                
            }
            
            $member_setting = $this->member_setting;
            foreach ((array) $member_setting as $key => $input) {
                
                if (isset($_POST[$key])) {
                    
                    $value = sanitize_text_field($_POST[$key]);
                    if ($isExtensionsValid !== true && $input['inputType'] == "CHECK") {
                        
                        $value = 0;
                        
                    }
                    
                    if ($input['inputType'] == "TEXTAREA") {
                        
                        $value = sanitize_textarea_field($_POST[$key]);
                        
                    }
                    
                    update_option($this->prefix.$key, $value);
                    $member_setting[$key]["value"] = $value;
                    
                }
                
            }
            
            return $member_setting;
            
        }
        
        public function update($post){
            
            $extentionBool = $this->getExtensionsValid(false);
            $list = $this->getList();
            if (isset($_POST['type']) && $_POST['type'] == "bookingSync") {
                
                $list = $this->getBookingSyncList();
                
            }
            
            
            
            foreach ((array) $list as $listKey => $listValue) {
                /**
                if ($extentionBool === false && $listKey == 'Stripe') {
                    
                    continue;
                    
                }
                **/
                $category = array();
                foreach ((array) $listValue as $key => $value) {
                    
                    if (isset($post[$key]) === true) {
                        
                        $value = "";
                        if (isset($listValue['inputType']) && $listValue['inputType'] == "TEXTAREA") {
                            
                            $value = sanitize_textarea_field($post[$key]);
                            if ($key == 'booking_package_googleCalendar_json') {
                                
                                $value = array();
                                $json = json_decode($post[$key], true);
                                foreach ((array) $json as $jsonKey => $jsonValue) {
                                    
                                    $value[sanitize_text_field($jsonKey)] = sanitize_text_field($jsonValue);
                                    
                                }
                                
                                $value = json_encode($value);
                                
                            }
                            
                        } else {
                            
                            $value = sanitize_text_field(trim($post[$key]));
                            
                        }
                        #$value = sanitize_text_field($post[$key]);
                        
                        if (get_option($key) === false) {
					        
	                        add_option($key, $value);
					        
                        } else {
				            
				            update_option($key, $value);
				            
			            }
                        
                    }
                    
                    $category[$key] = $value;
                    
                }
                
                $list[$listKey] = $category;
                
            }
            
            return $list;
            
        }
        
        public function refreshToken($key, $home = false){
            
            $key = sanitize_text_field($key);
            $token = hash('ripemd160', sanitize_text_field($home));
            if($home === false){
                
                #$timezone = get_option('timezone_string');
                #date_default_timezone_set($timezone);
                $token = hash('ripemd160', date('U'));
                
            }
            
            update_option($key, $token);
            return array('status' => 'success', 'token' => $token, 'key' => $key);
            
        }
        
        public function getForm($accountKey = 1, $originalActive = false){
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_form";
            #$wpdb->query("DROP TABLE IF EXISTS ".$table_name.";");
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
            $row = $wpdb->get_row($sql, ARRAY_A);
            if (is_null($row)) {
                
                $wpdb->insert(
                    $table_name, 
    				array(
    			        'accountKey' => intval($accountKey), 
    			        'data' => json_encode($this->defaultFrom())
    				), 
    				array('%d', '%s')
    	        );
                
                return $this->defaultFrom();
                
            } else {
                
                $form = array();
                $data = json_decode($row['data'], true);
                if (is_array($data)) {
                    
                    foreach ((array) $data as $key => $value) {
                        
                        if (isset($value['active']) === false) {
                            
                            $value['active'] = '';
                            
                        }
                        
                        #$options = json_decode($value['options'], true);
                        if (is_string($value['options']) === true) {
                            
                            $value['options'] = explode(',', $value['options']);
                            
                        }
                        
                        if ($originalActive === true) {
                            
                            $value['originalActive'] = $value['active'];
                            
                        }
                        
                        if (isset($value['isAutocomplete']) === false) {
                            
                            $value['isAutocomplete'] = 'true';
                            
                        }
                        
                        if (isset($value['isSMS']) === false) {
                            
                            $value['isSMS'] = 'false';
                            
                        }
                        
                        if (isset($value['placeholder']) === false) {
                            
                            $value['placeholder'] = '';
                            
                        }
                        
                        array_push($form, $value);
                        
                    }
                    
                }
                
                return $form;
                #return json_decode($row['data'], true);
                
            }
            
        }
        
        /**
        public function getFormList(){
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_form";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
            
        }
        **/
        
        public function getCourseList($accountKey = 1) {
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_courseData";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            $isExtensionsValid = $this->getExtensionsValid(false);
            for ($i = 0; $i < count($rows); $i++) {
                
                $rows[$i]['timeToProvide'] = json_decode($rows[$i]['timeToProvide'], true);
                if (is_null($rows[$i]['timeToProvide']) || is_string($rows[$i]['timeToProvide']) || $rows[$i]['timeToProvide'] === false) {
                    
                    $rows[$i]['timeToProvide'] = array();
                    
                }
                
                $options = json_decode($rows[$i]['options'], true);
                if (is_array($options)) {
                    
                    if (count($options) > 0 && isset($options[0]['cost_1']) === false) {
                        
                        for ($a = 0; $a < count($options); $a++) {
                            
                            $options[$a]['cost_1'] = $options[$a]['cost'];
                            $options[$a]['cost_2'] = $options[$a]['cost'];
                            $options[$a]['cost_3'] = $options[$a]['cost'];
                            $options[$a]['cost_4'] = $options[$a]['cost'];
                            $options[$a]['cost_5'] = $options[$a]['cost'];
                            $options[$a]['cost_6'] = $options[$a]['cost'];
                            
                        }
                        
                    }
                    
                    $rows[$i]['options'] = json_encode($options);
                    
                } else {
                    
                    $rows[$i]['options'] = "[]";
                    
                }
                
                
                if (is_null($rows[$i]['cost_1']) === true) {
                    
                    /**
                    $options = json_decode($rows[$i]['options'], true);
                    for ($a = 0; $a < count($options); $a++) {
                        
                        $options[$a]['cost_1'] = $options[$a]['cost'];
                        $options[$a]['cost_2'] = $options[$a]['cost'];
                        $options[$a]['cost_3'] = $options[$a]['cost'];
                        $options[$a]['cost_4'] = $options[$a]['cost'];
                        $options[$a]['cost_5'] = $options[$a]['cost'];
                        $options[$a]['cost_6'] = $options[$a]['cost'];
                        
                    }
                    
                    $rows[$i]['options'] = $options;
                    **/
                    $options = json_encode($options);
                    $rows[$i]['cost_1'] = $rows[$i]['cost'];
                    $table_name = $wpdb->prefix."booking_package_courseData";
					$wpdb->query("START TRANSACTION");
					$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
					try {
					
						$bool = $wpdb->update(
							$table_name,
							array(
								'cost_1' => intval($rows[$i]['cost']), 
								'cost_2' => intval($rows[$i]['cost']), 
								'cost_3' => intval($rows[$i]['cost']), 
								'cost_4' => intval($rows[$i]['cost']), 
								'cost_5' => intval($rows[$i]['cost']), 
								'cost_6' => intval($rows[$i]['cost']), 
								'options' => $options,
							),
							array('key' => intval($rows[$i]['key'])),
							array(
								'%d', '%d', '%d', '%d', '%d', '%d', '%s', 
							),
							array('%d')
						);
					
						$wpdb->query('COMMIT');
						$wpdb->query('UNLOCK TABLES');
						
					} catch (Exception $e) {
						
						$wpdb->query('ROLLBACK');
						$wpdb->query('UNLOCK TABLES');
						
					}/** finally {
						
						$wpdb->query('UNLOCK TABLES');
						
					}**/
                    
                }
                
                if ($isExtensionsValid === false) {
                    
                    $rows[$i]['options'] = "[]";
                    $rows[$i]['timeToProvide'] = array();
                    $rows[$i]['stopServiceUnderFollowingConditions'] = 'doNotStop';
                    $rows[$i]['cost_2'] = $rows[$i]['cost_1'];
                    $rows[$i]['cost_3'] = $rows[$i]['cost_1'];
                    $rows[$i]['cost_4'] = $rows[$i]['cost_1'];
                    $rows[$i]['cost_5'] = $rows[$i]['cost_1'];
                    $rows[$i]['cost_6'] = $rows[$i]['cost_1'];
                    
                }
                
            }
            /**
            if ($isExtensionsValid === false) {
				
				for($i = 0; $i < count($rows); $i++){
					
					$rows[$i]['options'] = "[]";
					
				}
				
			}
            **/
            return $rows;
            
        }
        
        /**
        public function getAllCourseList(){
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_courseData";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            
            
        }
        **/
        
        public function getCouponsList($accountKey = false) {
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_coupons";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `status` = 'active' AND `accountKey` = %d ORDER BY `key` ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            return $rows;
            
        }
        
        public function addCoupons($accountKey = false) {
            
            global $wpdb;
            $id = strtoupper(uniqid('coupon_'));
            $expirationDate = $this->validExpirationDate();
            $expirationDateStatus = $expirationDate['expirationDateStatus'];
            $expirationDateFrom = $expirationDate['expirationDateFrom'];
            $expirationDateTo = $expirationDate['expirationDateTo'];
            $active = 0;
            if (intval($_POST['active']) == 1) {
                
                $active = 1;
                
            }
            
            $table_name = $wpdb->prefix."booking_package_coupons";
            $wpdb->insert(
                $table_name, 
                array(
                    'accountKey' => intval($accountKey), 
                    'id' => sanitize_text_field($id), 
                    'name' => sanitize_text_field(stripslashes($_POST['name'])), 
                    'target' => sanitize_text_field($_POST['target']),
                    'limited' => sanitize_text_field($_POST['limited']), 
                    'method' => sanitize_text_field($_POST['method']), 
                    'value' => intval($_POST['value']),
                    'expirationDateStatus' => intval($expirationDateStatus),
                    'expirationDateFrom' => intval($expirationDateFrom),
                    'expirationDateTo' => intval($expirationDateTo),
                    'description'       => sanitize_textarea_field(stripslashes($_POST['description'])),
                    'active'    => intval($active),
                ), 
				array('%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%s', '%d')
			);
            
            
            return $this->getCouponsList($accountKey);
            
        }
        
        public function deleteCouponsItem($accountKey = false) {
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_coupons";
            $wpdb->update(
                $table_name,
                array(
                    'status' => 'deleted', 
                ),
                array('key' => intval($_POST['key'])),
                array(),
                array('%d')
            );
            
            
            return $this->getCouponsList($accountKey);
            
        }
        
        public function updateCoupons($accountKey = false) {
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_coupons";
            $sql = $wpdb->prepare(
                "SELECT * FROM ".$table_name." WHERE `status` = 'active' AND `key` = %d ORDER BY `key` ASC;", 
                array(intval($_POST['key']))
            );
            $coupon = $wpdb->get_row($sql, ARRAY_A);
            if (!empty($coupon)) {
                
                if (!empty($_POST['id']) && $_POST['id'] != $coupon['id']) {
                    
                    $sql = $wpdb->prepare(
                        "SELECT * FROM ".$table_name." WHERE `status` = 'active' AND `accountKey` = %d AND `id` = %s;", 
                        array(
                            intval($_POST['key']), 
                            sanitize_text_field($_POST['id'])
                        )
                    );
                    $row = $wpdb->get_row($sql, ARRAY_A);
                    if (!empty($row)) {
                        
                        $_POST['id'] = $coupon['id'];
                        
                    }
                    
                }
                
                $expirationDate = $this->validExpirationDate();
                $expirationDateStatus = $expirationDate['expirationDateStatus'];
                $expirationDateFrom = $expirationDate['expirationDateFrom'];
                $expirationDateTo = $expirationDate['expirationDateTo'];
                $active = 0;
                if (intval($_POST['active']) == 1) {
                    
                    $active = 1;
                    
                }
                
                $wpdb->update(
                $table_name,
                    array(
                        'id' => sanitize_text_field($_POST['id']), 
                        'name' => sanitize_text_field(stripslashes($_POST['name'])), 
                        'target' => sanitize_text_field($_POST['target']),
                        'limited' => sanitize_text_field($_POST['limited']), 
                        'method' => sanitize_text_field($_POST['method']), 
                        'value' => intval($_POST['value']),
                        'expirationDateStatus' => intval($expirationDateStatus),
                        'expirationDateFrom' => intval($expirationDateFrom),
                        'expirationDateTo' => intval($expirationDateTo),
                        'description'       => sanitize_textarea_field(stripslashes($_POST['description'])),
                        'active' => intval($active),
                    ),
                    array('key' => intval($_POST['key'])),
                    array('%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%s', '%d'),
                    array('%d')
                );
                
            }
            
            
            
            return $this->getCouponsList($accountKey);
            
        }
        
        public function getListOfDaysOfWeek() {
            
            $numberKeys = array();
            $guestsList = $this->guestsInputType();
            if (isset($guestsList['json']['optionsType']['prices'])) {
                
                $dayOfWeeks = $guestsList['json']['optionsType']['prices']['options'];
                for ($i = 0; $i < count($dayOfWeeks); $i++) {
                    
                    array_push($numberKeys, $dayOfWeeks[$i]['key']);
                    
                }
                
            }
            
            return $numberKeys;
            
        }
        
        public function getObjectOfDaysOfWeek() {
            
            $numberObject = array();
            $numberKeys = $this->getListOfDaysOfWeek();
            for ($i = 0; $i < count($numberKeys); $i++) {
                
                $numberObject[$numberKeys[$i]] = 0;
                
            }
            
            return $numberObject;
            
        }
        
        public function getGuestsList($accountKey = false, $booking = false) {
            
            global $wpdb;
            $numberKeys = $this->getListOfDaysOfWeek();
            $isExtensionsValid = $this->getExtensionsValid(false);
            $table_name = $wpdb->prefix . "booking_package_guests";
            $sql = $wpdb->prepare("SELECT * FROM " . $table_name . " WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            /**
            if ($booking == true) {
                
                foreach ((array) $rows as $key => $value) {
                    
                    $list = json_decode($value['json'], true);
                    array_unshift($list, array("number" => 0, "price" => 0, "name" => __("Select")));
                    $value['json'] = json_encode($list);
                    #$value['json'] = $list;
                    if ($isExtensionsValid !== true) {
                        
                        $value['costInServices'] = 'cost_1';
                        $value['reflectService'] = '0';
                        $value['reflectAdditional'] = '0';
                        
                    }
                    $rows[$key] = $value;
                    
                }
                
            }
            **/
            
            foreach ((array) $rows as $key => $value) {
                
                $updatePrices = false;
                $list = json_decode($value['json'], true);
                
                /**
                if (isset($list[0]) && isset($numberKeys[0]) && isset($list[0][$numberKeys[0]]) === false) {
                    
                    $updatePrices = true;
                    
                }
                **/
                if ($booking === true) {
                    
                    array_unshift($list, array("number" => 0, "price" => 0, "name" => __("Select")));
                    if ($isExtensionsValid !== true) {
                        
                        $value['costInServices'] = 'cost_1';
                        $value['reflectService'] = '0';
                        $value['reflectAdditional'] = '0';
                        
                    }
                    
                }
                
                for ($i = 0; $i < count($list); $i++) {
                    
                    if (isset($list[$i]['price']) === false) {
                        
                        $list[$i]['price'] = 0;
                        
                    }
                    
                    for ($a = 0; $a < count($numberKeys); $a++) {
                        
                        if (isset($list[$i][$numberKeys[$a]]) === false) {
                            
                            $list[$i][$numberKeys[$a]] = $list[$i]['price'];
                            
                        }
                        
                        if (empty($list[$i][$numberKeys[$a]])) {
                            
                            $list[$i][$numberKeys[$a]] = 0;
                            
                        }
                        
                        if ($isExtensionsValid === false && ($numberKeys[$a] == 'priceOnDayBeforeNationalHoliday' || $numberKeys[$a] == 'priceOnNationalHoliday')) {
                            
                            $list[$i][$numberKeys[$a]] = 0;
                            
                        }
                        
                    }
                    
                }
                
                $value['json'] = json_encode($list);
                $rows[$key] = $value;
                
            }
            
            return $rows;
            
        }
        
        public function updateGuests($accountKey = false){
            
            global $wpdb;
            if ($accountKey != false) {
                /**
                $numberKeys = array(
                    'number',
                    'price',
                    'priceOnMonday',
                    'priceOnTuesday',
                    'priceOnWednesday',
                    'priceOnThursday',
                    'priceOnFriday',
                    'priceOnSaturday',
                    'priceOnSunday',
                    'priceOnDayBeforeNationalHoliday',
                    'priceOnNationalHoliday',
                );
                **/
                $numberKeys = $this->getListOfDaysOfWeek();
                array_unshift($numberKeys, 'number', 'price');
                $json = array();
                if (isset($_POST['json'])) {
                    
                    $jsonList = json_decode(stripslashes($_POST['json']), true);
                    for ($i = 0; $i < count($jsonList); $i++) {
                        
                        $object = array();
                        foreach ((array) $jsonList[$i] as $key => $value) {
                            
                            $object[sanitize_text_field($key)] = sanitize_text_field($value);
                            $isNumber = array_search($key, $numberKeys);
                            if ($isNumber !== false) {
                                
                                $value = $this->getOnlyNumbers($value);
                                $object[sanitize_text_field($key)] = intval($value);
                                
                            }
                            /**
                            if ($key == 'number' || $key == 'price') {
                                
                                $value = $this->getOnlyNumbers($value);
                                $object[sanitize_text_field($key)] = intval($value);
                                
                            }
                            **/
                        }
                        
                        array_push($json, $object);
                        
                    }
                    
                    $guestsInCapacity = 'included';
                    if (isset($_POST['guestsInCapacity'])) {
                        
                        $guestsInCapacity = $_POST['guestsInCapacity'];
                        if (empty($_POST['guestsInCapacity']) === true) {
                            
                            $guestsInCapacity = 'included';
                            
                        }
                        
                    }
                    
                    $reflectService = 0;
                    if (isset($_POST['reflectService'])) {
                        
                        $reflectService = intval($_POST['reflectService']);
                        
                    }
                    
                    $reflectAdditional = 0;
                    if (isset($_POST['reflectAdditional'])) {
                        
                        $reflectAdditional = intval($_POST['reflectAdditional']);
                        
                    }
                    
                    $costInServices = 'cost_1';
                    if (isset($_POST['costInServices']) && $this->getExtensionsValid() === true) {
                        
                        $costInServices = $_POST['costInServices'];
                        
                    }
                    
                    $table_name = $wpdb->prefix."booking_package_guests";
                    $wpdb->update(
                        $table_name,
                        array(
                            'name' => sanitize_text_field(stripslashes($_POST['name'])), 
                            'costInServices' => sanitize_text_field($costInServices),
                            'target' => sanitize_text_field($_POST['target']), 
                            'guestsInCapacity' => sanitize_text_field($guestsInCapacity),
                            'json' => json_encode($json),
                            'required' => intval($_POST['required']),
                            'reflectService' => intval($reflectService),
                            'reflectAdditional' => intval($reflectAdditional),
                            'description'       => sanitize_textarea_field(stripslashes($_POST['description'])),
                        ),
                        array('key' => intval($_POST['key'])),
                        array('%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s'),
                        array('%d')
                    );
                    
                }
                
                #return $json;
                return $this->getGuestsList($accountKey);
                
            }
            
            die();
            
        }
        
        public function addGuests($accountKey = false){
            
            global $wpdb;
            if ($accountKey != false) {
                
                /**
                $numberKeys = array(
                    'number',
                    'price',
                    'priceOnMonday',
                    'priceOnTuesday',
                    'priceOnWednesday',
                    'priceOnThursday',
                    'priceOnFriday',
                    'priceOnSaturday',
                    'priceOnSunday',
                    'priceOnDayBeforeNationalHoliday',
                    'priceOnNationalHoliday',
                );
                **/
                $numberKeys = $this->getListOfDaysOfWeek();
                array_unshift($numberKeys, 'number', 'price');
                $json = array();
                if (isset($_POST['json'])) {
                    
                    $jsonList = json_decode(stripslashes($_POST['json']), true);
                    for ($i = 0; $i < count($jsonList); $i++) {
                        
                        $object = array();
                        foreach ((array) $jsonList[$i] as $key => $value) {
                            
                            $object[sanitize_text_field($key)] = sanitize_text_field($value);
                            $isNumber = array_search($key, $numberKeys);
                            if ($isNumber !== false) {
                                
                                $value = $this->getOnlyNumbers($value);
                                $object[sanitize_text_field($key)] = intval($value);
                                
                            }
                            /**
                            if ($key == 'number' || $key == 'price') {
                                
                                $value = $this->getOnlyNumbers($value);
                                $object[sanitize_text_field($key)] = intval($value);
                                
                            }
                            **/
                            
                        }
                        
                        array_push($json, $object);
                        
                    }
                    
                    $guestsInCapacity = 'included';
                    if (isset($_POST['guestsInCapacity'])) {
                        
                        $guestsInCapacity = $_POST['guestsInCapacity'];
                        if (empty($_POST['guestsInCapacity']) === true) {
                            
                            $guestsInCapacity = 'included';
                            
                        }
                        
                    }
                    
                    $reflectService = 0;
                    if (isset($_POST['reflectService'])) {
                        
                        $reflectService = intval($_POST['reflectService']);
                        
                    }
                    
                    $reflectAdditional = 0;
                    if (isset($_POST['reflectAdditional'])) {
                        
                        $reflectAdditional = intval($_POST['reflectAdditional']);
                        
                    }
                    
                    $costInServices = 'cost_1';
                    if (isset($_POST['costInServices']) && $this->getExtensionsValid() === true) {
                        
                        $costInServices = $_POST['costInServices'];
                        
                    }
                    
                    $table_name = $wpdb->prefix."booking_package_guests";
                    $sql = $wpdb->prepare("SELECT COUNT(*) FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
                    $row = $wpdb->get_row($sql, ARRAY_A);
                    $count = $row['COUNT(*)'] + 1;
                    #var_dump($count);
                    
                    $wpdb->insert(
                        $table_name, 
    					array(
                            'accountKey' => intval($accountKey), 
    			            'name' => sanitize_text_field(stripslashes($_POST['name'])), 
    			            'costInServices' => sanitize_text_field($costInServices),
    			            'target' => sanitize_text_field($_POST['target']), 
    			            'guestsInCapacity' => sanitize_text_field($guestsInCapacity),
    				        'json' => json_encode($json), 
    				        'ranking' => intval($count),
    				        'required' => intval($_POST['required']),
    				        'reflectService' => intval($reflectService),
    				        'reflectAdditional' => intval($reflectAdditional),
    				        'description'       => sanitize_textarea_field(stripslashes($_POST['description'])),
    					), 
    					array('%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%s')
    				);
                    
                }
                
                return $this->getGuestsList($accountKey);
                
            }
            
            die();
            
        }
        
        public function deleteGuestsItem($accountKey = false){
            
            global $wpdb;
            if($accountKey != false){
                
                $table_name = $wpdb->prefix."booking_package_guests";
                $wpdb->delete($table_name, array('key' => intval($_POST['key'])), array('%d'));
                
                return $this->getGuestsList($accountKey);
                
            }
            
            die();
            
        }
        
        public function changeGuestsRank($accountKey = false){
            
            global $wpdb;
            if($accountKey != false){
                
                $table_name = $wpdb->prefix."booking_package_guests";
                $keyList = explode(",", $_POST['keyList']);
                for($i = 0; $i < count($keyList); $i++){
                    
                    $ranking = $i + 1;
                    $wpdb->update(
                        $table_name,
                        array(
                            'ranking' => intval($ranking)
                        ),
                        array('key' => intval($keyList[$i]), 'accountKey' => intval($accountKey)),
                        array('%d'),
                        array('%d', '%d')
                    );
                    
                }
                
                return $this->getGuestsList($accountKey);
                
            }
            
            die();
            
        }
        
        public function validExpirationDate() {
            
            $response = array('expirationDateStatus' => 0, 'expirationDateFrom' => 0, 'expirationDateTo' => 0);
            if (isset($_POST['expirationDateStatus'])) {
                
                if (empty($_POST['expirationDateStatus']) === false) {
                    
                    $response['expirationDateStatus'] = $_POST['expirationDateStatus'];
                    
                }
                $response['expirationDateFrom'] = $_POST['expirationDateFromYear'] . sprintf('%02d', $_POST['expirationDateFromMonth']) . sprintf('%02d', $_POST['expirationDateFromDay']);
                $response['expirationDateTo'] = $_POST['expirationDateToYear'] . sprintf('%02d', $_POST['expirationDateToMonth']) . sprintf('%02d', $_POST['expirationDateToDay']);
                
            }
            
            return $response;
            
        }
        
        public function getBlockEmailLists($schedule) {
            
            global $wpdb;
            $response = array();
            $dateFormat = intval(get_option($this->prefix."dateFormat", 0));
			$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
			
			$table_name = $wpdb->prefix . "booking_package_blockList";
			#$sql = $wpdb->prepare("SELECT * FROM " . $table_name . " ORDER BY date DESC;", array());
			$rows = $wpdb->get_results("SELECT * FROM " . $table_name . " ORDER BY date DESC;", ARRAY_A);
			foreach ((array) $rows as $key => $value) {
			    
			    $value['date'] = $schedule->dateFormat($dateFormat, $positionOfWeek, $value['date'], '', true, true, 'text');
			    array_push($response, $value);
			    
			}
			
            return $response;
            
        }
        
        public function addBlockEmail($email, $schedule) {
            
            global $wpdb;
            $lastKey = null;
            $email = sanitize_text_field(trim($email));
            $dateFormat = intval(get_option($this->prefix."dateFormat", 0));
			$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
			$date = date("U");
			$table_name = $wpdb->prefix . "booking_package_blockList";
            $sql = $wpdb->prepare(
                "SELECT `key` FROM `" . $table_name . "` WHERE `value` = %s;", 
                array($email)
            );
			$row = $wpdb->get_row($sql, ARRAY_A);
			
			if (is_null($row)) {
                
                $wpdb->insert(
                    $table_name, 
                    array(
                        'type' => 'email', 
                        'value' => $email, 
                        'date' => intval($date),
                    ), 
                    array('%s', '%s', '%d')
                );
                $lastKey = $wpdb->insert_id;
                $date = $schedule->dateFormat($dateFormat, $positionOfWeek, $date, '', true, true, 'text');
                $blocskList = $this->getBlockEmailLists($schedule);
                return array('status' => 'success', 'key' => $lastKey, 'email' => $email, 'date' => $date, 'blocskList' => $blocskList);
                
			}
			
			return array('status' => 'error', 'message' => sprintf(__('You have already added the "%s".', $this->pluginName), $email));
			
        }
        
        public function deleteBlockEmail($key, $schedule) {
            
            global $wpdb;
            $table_name = $wpdb->prefix . "booking_package_blockList";
            $wpdb->delete(
    			$table_name, 
    			array(
    				'key' => intval($key)
    			), 
    			array('%d')
    		);
            
            return $this->getBlockEmailLists($schedule);
            
        }
        
        public function addCourse(){
            
            $accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            $expirationDate = $this->validExpirationDate();
            $expirationDateStatus = $expirationDate['expirationDateStatus'];
            $expirationDateFrom = $expirationDate['expirationDateFrom'];
            $expirationDateTo = $expirationDate['expirationDateTo'];
            
            $options = array();
            if (isset($_POST['options'])) {
                
                $jsonList = json_decode(stripslashes($_POST['options']), true);
                for ($i = 0; $i < count($jsonList); $i++) {
                    
                    $object = array();
                    foreach ((array) $jsonList[$i] as $key => $value) {
                        
                        if ($key == 'cost_1' || $key == 'cost_2' || $key == 'cost_3' || $key == 'cost_4' || $key == 'cost_5' || $key == 'cost_6') {
                            
                            if (is_int($value) === false) {
                                
                                $value = $this->getOnlyNumbers($value);
                                
                            }
                            
                        }
                        
                        $object[sanitize_text_field($key)] = sanitize_text_field($value);
                        
                    }
                    array_push($options, $object);
                    
                }
                
                if ($this->getExtensionsValid() === false) {
                    
                    $options = array();
                    
                }
                
            }
            
            $timeToProvide = array();
            if (isset($_POST['timeToProvide'])) {
                
                $jsonList = json_decode(stripslashes($_POST['timeToProvide']), true);
                for ($i = 0; $i < count($jsonList); $i++) {
                    
                    $object = array();
                    foreach ((array) $jsonList[$i] as $key => $value) {
                        
                        $object[sanitize_text_field($key)] = sanitize_text_field($value);
                        
                    }
                    array_push($timeToProvide, $object);
                    
                }
                
                
                if ($this->getExtensionsValid() === false) {
                    
                    $timeToProvide = array();
                    
                }
                
            }
            
            if (!isset($_POST['target'])) {
                
                $_POST['target'] = 'visitors_users';
                
            }
            
            if (!isset($_POST['stopServiceUnderFollowingConditions'])) {
                
                $_POST['stopServiceUnderFollowingConditions'] = 'doNotStop';
                $_POST['stopServiceForDayOfTimes'] = 'timeSlot';
                $_POST['stopServiceForSpecifiedNumberOfTimes'] = 0;
                
            }
            
            if (!isset($_POST['doNotStopServiceAsException']) || empty($_POST['doNotStopServiceAsException'])) {
                
                $_POST['doNotStopServiceAsException'] = 'hasNotException';
                
            }
            
            for ($i = 1; $i <= 6; $i++) {
                
                if (!isset($_POST['cost_' . $i])) {
                    
                    $_POST['cost_' . $i] = 0;
                    
                }
                
                if (is_int($_POST['cost_' . $i]) === false) {
                    
                    $_POST['cost_' . $i] = $this->getOnlyNumbers($_POST['cost_' . $i]);
                    
                }
                
                if ($i > 1 && $this->getExtensionsValid() === false) {
                    
                    $_POST['cost_' . $i] = 0;
                    
                }
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_courseData";
            $wpdb->insert(	
                $table_name, 
                array(
                    'accountKey'            => intval($accountKey), 
                    'name'                  => sanitize_text_field($_POST['name']), 
                    'description'           => sanitize_textarea_field($_POST['description']),
                    'cost_1'                => intval($_POST['cost_1']), 
                    'cost_2'                => intval($_POST['cost_2']), 
                    'cost_3'                => intval($_POST['cost_3']), 
                    'cost_4'                => intval($_POST['cost_4']), 
                    'cost_5'                => intval($_POST['cost_5']), 
                    'cost_6'                => intval($_POST['cost_6']), 
                    'time'                  => intval($_POST['time']), 
                    'ranking'               => intval($_POST['rank']),
                    'active'                => sanitize_text_field($_POST['active']),
                    'target'                => sanitize_text_field($_POST['target']),
                    'selectOptions'         => intval($_POST['selectOptions']),
                    'options'               => json_encode($options),
                    'timeToProvide'         => json_encode($timeToProvide),
                    'expirationDateStatus'  => intval($expirationDateStatus),
                    'expirationDateFrom'    => intval($expirationDateFrom),
                    'expirationDateTo'      => intval($expirationDateTo),
                    'stopServiceUnderFollowingConditions' => sanitize_text_field($_POST['stopServiceUnderFollowingConditions']),
                    'doNotStopServiceAsException' => sanitize_text_field($_POST['doNotStopServiceAsException']),
                    'stopServiceForDayOfTimes' => sanitize_text_field($_POST['stopServiceForDayOfTimes']),
                    'stopServiceForSpecifiedNumberOfTimes'  => intval($_POST['stopServiceForSpecifiedNumberOfTimes']),
                ), 
                array(
                    '%d', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
                    '%d', '%s', '%s', '%d', '%s', '%s', '%d', '%d', '%d', '%s', 
                    '%s', '%s', '%d', 
                )
            );
    		/**
			$sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            return $rows;
            **/
            return $this->getCourseList($accountKey);
            
        }
        
        public function updateCourse(){
            
            $accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            $expirationDate = $this->validExpirationDate();
            $expirationDateStatus = $expirationDate['expirationDateStatus'];
            $expirationDateFrom = $expirationDate['expirationDateFrom'];
            $expirationDateTo = $expirationDate['expirationDateTo'];
            
            $options = array();
            if (isset($_POST['options'])) {
                
                $jsonList = json_decode(stripslashes($_POST['options']), true);
                for ($i = 0; $i < count($jsonList); $i++) {
                    
                    $object = array();
                    foreach ((array) $jsonList[$i] as $key => $value) {
                        
                        if ($key == 'cost_1' || $key == 'cost_2' || $key == 'cost_3' || $key == 'cost_4' || $key == 'cost_5' || $key == 'cost_6') {
                            
                            if (is_int($value) === false) {
                                
                                $value = $this->getOnlyNumbers($value);
                                
                            }
                            
                        }
                        
                        $object[sanitize_text_field($key)] = sanitize_text_field($value);
                        
                    }
                    
                    array_push($options, $object);
                    
                }
                
                if ($this->getExtensionsValid(false) === false) {
                    
                    $options = array();
                    
                }
                
            }
            
            $timeToProvide = array();
            if (isset($_POST['timeToProvide'])) {
                
                $jsonList = json_decode(stripslashes($_POST['timeToProvide']), true);
                for ($i = 0; $i < count($jsonList); $i++) {
                    
                    $object = array();
                    if (is_array($jsonList[$i])) {
                        
                        foreach ((array) $jsonList[$i] as $key => $value) {
                            
                            $object[sanitize_text_field($key)] = sanitize_text_field($value);
                            
                        }
                        
                    }
                    
                    array_push($timeToProvide, $object);
                    
                }
                
                
                if ($this->getExtensionsValid() === false) {
                    
                    $timeToProvide = array();
                    
                }
                
            }
            
            if (!isset($_POST['target'])) {
                
                $_POST['target'] = 'visitors_users';
                
            }
            
            if (!isset($_POST['stopServiceUnderFollowingConditions'])) {
                
                $_POST['stopServiceUnderFollowingConditions'] = 'doNotStop';
                $_POST['stopServiceForDayOfTimes'] = 'timeSlot';
                $_POST['stopServiceForSpecifiedNumberOfTimes'] = 0;
                
            }
            
            if (!isset($_POST['doNotStopServiceAsException']) || empty($_POST['doNotStopServiceAsException'])) {
                
                $_POST['doNotStopServiceAsException'] = 'hasNotException';
                
            }
            
            for ($i = 1; $i <= 6; $i++) {
                
                if (!isset($_POST['cost_' . $i])) {
                    
                    $_POST['cost_' . $i] = 0;
                    
                }
                
                if (is_int($_POST['cost_' . $i]) === false) {
                    
                    $_POST['cost_' . $i] = $this->getOnlyNumbers($_POST['cost_' . $i]);
                    
                }
                
                if ($i > 1 && $this->getExtensionsValid() === false) {
                    
                    $_POST['cost_' . $i] = 0;
                    
                }
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_courseData";
            $wpdb->update(
                $table_name,
                array(
                    'name'                                  => sanitize_text_field(stripslashes($_POST['name'])), 
                    'description'                           => sanitize_textarea_field(stripslashes($_POST['description'])),
                    'time'                                  => intval($_POST['time']), 
                    'cost_1'                                => intval($_POST['cost_1']), 
                    'cost_2'                                => intval($_POST['cost_2']), 
                    'cost_3'                                => intval($_POST['cost_3']), 
                    'cost_4'                                => intval($_POST['cost_4']), 
                    'cost_5'                                => intval($_POST['cost_5']), 
                    'cost_6'                                => intval($_POST['cost_6']), 
                    'active'                                => sanitize_text_field($_POST['active']),
                    'target'                                => sanitize_text_field($_POST['target']),
                    'selectOptions'                         => intval($_POST['selectOptions']),
                    'options'                               => json_encode($options),
                    'timeToProvide'                         => json_encode($timeToProvide),
                    'expirationDateStatus'                  => intval($expirationDateStatus),
                    'expirationDateFrom'                    => intval($expirationDateFrom),
                    'expirationDateTo'                      => intval($expirationDateTo),
                    'stopServiceUnderFollowingConditions'   => sanitize_text_field($_POST['stopServiceUnderFollowingConditions']),
                    'doNotStopServiceAsException'           => sanitize_text_field($_POST['doNotStopServiceAsException']),
                    'stopServiceForDayOfTimes'              => sanitize_text_field($_POST['stopServiceForDayOfTimes']),
                    'stopServiceForSpecifiedNumberOfTimes'  => intval($_POST['stopServiceForSpecifiedNumberOfTimes']),
                ),
                array('key' => intval($_POST['key'])),
                array(
                    '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', 
                    '%s', '%d', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', 
                    '%d', 
                ),
                array('%d')
                );
            /**
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            return $rows;
            **/
            return $this->getCourseList($accountKey);
            
        }
        
        public function copyCourse() {
            
            $accountKey = 1;
            if(isset($_POST['accountKey'])){
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_courseData";
            $tmp_table_name = $table_name."_tmp";
            
            $sql = $wpdb->prepare('SELECT COUNT(`key`) as `count` FROM ' . $table_name . ' WHERE `accountKey` = %d', array(intval($accountKey)));
            $row = $wpdb->get_row($sql, ARRAY_A);
            $ranking = $row['count'] + 1;
            
            $sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `key` = %d;", array(intval($_POST['key'])));
    		$wpdb->query($sql);
    		$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
    		$sql = $wpdb->prepare("UPDATE " . $tmp_table_name . " SET `name` = CONCAT(name, ' Copy'), `ranking` = %d, `active` = '';", array(intval($ranking)));
    		$wpdb->query($sql);
    		#$wpdb->query("UPDATE " . $tmp_table_name . " SET `name` = CONCAT(name, ' Copy'), `active` = '';");
    		$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
    		$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
            
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            return $rows;
            
        }
        
        public function deleteCourse(){
            
            $accountKey = 1;
            if(isset($_POST['accountKey'])){
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_courseData";
            $wpdb->delete($table_name, array('key' => intval($_POST['key'])), array('%d'));
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            return $rows;
            
        }
        
        public function getSubscriptions(){
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_subscriptions";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($_POST['accountKey'])));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            $isExtensionsValid = $this->getExtensionsValid(false);
            if ($isExtensionsValid === false) {
				
				return array();
				
			} else {
			    
			    return $rows;
			    
			}
            
        }
        
        public function addSubscriptions(){
            
            $accountKey = $_POST['accountKey'];
            if ($this->getExtensionsValid() === false) {
                
                return array();
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_subscriptions";
            $wpdb->insert(	$table_name, 
    						array(
    					   		'accountKey'    => intval($accountKey), 
    							'name'          => sanitize_text_field($_POST['name']), 
    							'subscription'  => sanitize_text_field($_POST['subscription']), 
    							'active'        => sanitize_text_field($_POST['active']), 
    							'ranking'       => intval($_POST['rank']),
    							'renewal'       => intval($_POST['renewal']),
    							'limit'         => intval($_POST['limit']),
    							'numberOfTimes' => intval($_POST['numberOfTimes']),
    						), 
    						array('%d', '%s', '%s', '%s', '%d', '%d', '%d', '%d')
    					);
    		
			$sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            return $rows;
            
        }
        
        public function updateSubscriptions(){
            
            $accountKey = $_POST['accountKey'];
            if ($this->getExtensionsValid(false) === false) {
                
                return array();
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_subscriptions";
            $wpdb->update(
                $table_name,
                array(
                    'name' => sanitize_text_field($_POST['name']), 
                    'active' => sanitize_text_field($_POST['active']),
                    'renewal' => intval($_POST['renewal']), 
                    'limit' => intval($_POST['limit']), 
                    'numberOfTimes' => intval($_POST['numberOfTimes']),
                ),
                array('key' => intval($_POST['key'])),
                array('%s', '%s', '%d', '%d', '%d'),
                array('%d')
            );
            
            return $this->getSubscriptions();
            
        }
        
        public function deleteSubscriptions(){
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_subscriptions";
            $wpdb->delete($table_name, array('key' => intval($_POST['key'])), array('%d'));
            return $this->getSubscriptions();
            
        }
        
        public function changeSubscriptionsRank(){
            
            $keyList = explode(",", $_POST['keyList']);
            $indexList = explode(",", $_POST['indexList']);
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_subscriptions";
            for($i = 0; $i < count($keyList); $i++){
                
                $wpdb->update(  $table_name,
                                array('ranking' => intval($indexList[$i])),
                                array('key' => intval($keyList[$i])),
                                array('%d'),
                                array('%d')
                            );
                
            }
            
            return $this->getSubscriptions();
            
        }
        
        public function getTaxes($accountKey) {
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_taxes";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            $isExtensionsValid = $this->getExtensionsValid(false);
            if ($isExtensionsValid === false) {
				
				return array();
				
			} else {
			    
			    return $rows;
			    
			}
            
        }
        
        public function addTaxes($accountKey) {
            
            if ($_POST['type'] == 'surcharge') {
                
                $_POST['tax'] = 'tax_inclusive';
                
            }
            
            $expirationDate = $this->validExpirationDate();
            $expirationDateStatus = $expirationDate['expirationDateStatus'];
            $expirationDateFrom = $expirationDate['expirationDateFrom'];
            $expirationDateTo = $expirationDate['expirationDateTo'];
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_taxes";
            $wpdb->insert(
                $table_name, 
    			array(
                    'accountKey'    => intval($accountKey), 
    				'name'          => sanitize_text_field($_POST['name']),  
    				'ranking'       => intval($_POST['rank']),
    				'active'        => sanitize_text_field($_POST['active']),
    				'type'          => sanitize_text_field($_POST['type']),
    				'tax'          => sanitize_text_field($_POST['tax']),
    				'method'        => sanitize_text_field($_POST['method']),
    				'target'        => sanitize_text_field($_POST['target']),
    				'scope'         => sanitize_text_field($_POST['scope']),
    				'value'         => floatval($_POST['value']),
    				'expirationDateStatus'  => intval($expirationDateStatus),
                    'expirationDateFrom'    => intval($expirationDateFrom),
                    'expirationDateTo'      => intval($expirationDateTo),
    			), 
    			array('%d', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%f', '%d', '%d', '%d')
    		);
    		
            return $this->getTaxes($accountKey);
            
        }
        
        public function updateTaxes($accountKey) {
            
            $expirationDate = $this->validExpirationDate();
            $expirationDateStatus = $expirationDate['expirationDateStatus'];
            $expirationDateFrom = $expirationDate['expirationDateFrom'];
            $expirationDateTo = $expirationDate['expirationDateTo'];
            
            if (!isset($_POST['active']) || strlen($_POST['active']) == 0) {
                
                $_POST['active'] = "false";
                
            }
            
            if ($_POST['type'] == 'surcharge') {
                
                $_POST['tax'] = 'tax_inclusive';
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_taxes";
            $wpdb->update(
                $table_name,
                array(
                    'name'          => sanitize_text_field($_POST['name']),  
    				'active'        => sanitize_text_field($_POST['active']),
    				'type'          => sanitize_text_field($_POST['type']),
    				'tax'          => sanitize_text_field($_POST['tax']),
    				'method'        => sanitize_text_field($_POST['method']),
    				'target'        => sanitize_text_field($_POST['target']),
    				'scope'         => sanitize_text_field($_POST['scope']),
    				'value'         => floatval($_POST['value']),
    				'expirationDateStatus'  => intval($expirationDateStatus),
                    'expirationDateFrom'    => intval($expirationDateFrom),
                    'expirationDateTo'      => intval($expirationDateTo),
                ),
                array('key' => intval($_POST['key'])),
                array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%f', '%d', '%d', '%d'),
                array('%d')
            );
            
            return $this->getTaxes($accountKey);
            
        }
        
        public function deleteTaxes($accountKey){
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_taxes";
            $wpdb->delete($table_name, array('key' => intval($_POST['key'])), array('%d'));
            return $this->getTaxes($accountKey);
            
        }
        
        public function changeTaxesRank($accountKey){
            
            $keyList = explode(",", $_POST['keyList']);
            $indexList = explode(",", $_POST['indexList']);
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_taxes";
            for ($i = 0; $i < count($keyList); $i++) {
                
                $wpdb->update(
                    $table_name,
                    array('ranking' => intval($indexList[$i])),
                    array('key' => intval($keyList[$i])),
                    array('%d'),
                    array('%d')
                );
                
            }
            
            return $this->getTaxes($accountKey);
            
        }
        
        public function getOptionsForHotel($accountKey) {
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_optionsForHotel";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            $isExtensionsValid = $this->getExtensionsValid(false);
            if ($isExtensionsValid === false) {
				
				return array();
				
			} else {
			    
			    return $rows;
			    
			}
            
        }
        
        public function addOptionsForHotel($accountKey) {
            
            if (!isset($_POST['active']) || strlen($_POST['active']) == 0) {
                
                $_POST['active'] = "false";
                
            }
            
            $required = 0;
            if ($_POST['required'] == 'true') {
                
                $required = 1;
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_optionsForHotel";
            $wpdb->insert(
                $table_name, 
    			array(
                    'accountKey'            => intval($accountKey), 
    				'name'                  => sanitize_text_field($_POST['name']),  
    				'ranking'               => intval($_POST['rank']),
    				'active'                => sanitize_text_field($_POST['active']),
    				'required'              => intval($required),
    				'target'                => sanitize_text_field($_POST['target']),
    				'chargeForAdults'       => floatval($_POST['chargeForAdults']),
    				'chargeForChildren'     => floatval($_POST['chargeForChildren']),
    				'chargeForRoom'         => floatval($_POST['chargeForRoom']),
    			), 
    			array('%d', '%s', '%d', '%s', '%d', '%s', '%f', '%f', '%f')
    		);
    		
            return $this->getOptionsForHotel($accountKey);
            
        }
        
        public function updateOptionsForHotel($accountKey) {
            
            if (!isset($_POST['active']) || strlen($_POST['active']) == 0) {
                
                $_POST['active'] = "false";
                
            }
            
            $required = 0;
            if ($_POST['required'] == 'true') {
                
                $required = 1;
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_optionsForHotel";
            $wpdb->update(
                $table_name,
                array(
                    'name'                  => sanitize_text_field($_POST['name']),  
    				'active'                => sanitize_text_field($_POST['active']),
    				'required'              => intval($required),
    				'chargeForAdults'       => floatval($_POST['chargeForAdults']),
    				'chargeForChildren'     => floatval($_POST['chargeForChildren']),
    				'chargeForRoom'         => floatval($_POST['chargeForRoom']),
                ),
                array('key' => intval($_POST['key'])),
                array('%s', '%s', '%d', '%f', '%f', '%f'),
                array('%d')
            );
            
            return $this->getOptionsForHotel($accountKey);
            
        }
        
        public function deleteOptionsForHotel($accountKey){
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_optionsForHotel";
            $wpdb->delete($table_name, array('key' => intval($_POST['key'])), array('%d'));
            return $this->getOptionsForHotel($accountKey);
            
        }
        
        public function changeOptionsForHotelRank($accountKey){
            
            $keyList = explode(",", $_POST['keyList']);
            $indexList = explode(",", $_POST['indexList']);
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_optionsForHotel";
            for ($i = 0; $i < count($keyList); $i++) {
                
                $wpdb->update(
                    $table_name,
                    array('ranking' => intval($indexList[$i])),
                    array('key' => intval($keyList[$i])),
                    array('%d'),
                    array('%d')
                );
                
            }
            
            return $this->getOptionsForHotel($accountKey);
            
        }
        
        public function changeCourseRank(){
            
            $accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            $keyList = explode(",", $_POST['keyList']);
            $indexList = explode(",", $_POST['indexList']);
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_courseData";
            for ($i = 0; $i < count($keyList); $i++) {
                
                $wpdb->update(
                    $table_name,
                    array('ranking' => intval($indexList[$i])),
                    array('key' => intval($keyList[$i])),
                    array('%d'),
                    array('%d')
                );
                
            }
            
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d ORDER BY ranking ASC;", array(intval($accountKey)));
            $rows = $wpdb->get_results($sql, ARRAY_A);
            return $rows;
            
        }
        
        public function addForm(){
            
            $accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            if (isset($_POST['isSMS']) === false) {
                
                $_POST['isSMS'] = 'false';
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_form";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
            $row = $wpdb->get_row($sql, ARRAY_A);
            if (is_null($row)) {
                
                return array('status' => 'error');
                
            } else {
                
                $id = strtolower($_POST['id']);
                $id = preg_replace('/[^0-9a-zA-Z]/', '', $id);
                $id  = preg_replace("/^( )|(　)$/", "", $id );
                #$options = str_replace("\\\"", "\"", sanitize_text_field($_POST['options']));
                #$options = str_replace("\'", "'", $options);
                $options = stripslashes($_POST['options']);
                $options = sanitize_text_field($options);
                $options = json_decode($options, true);
                if (is_null($options) || is_bool($options) === true) {
                    
                    $options = array();
                    
                }
                
                foreach ($options as $key => $value) {
                    
                    if (is_null($value) || empty($value) || $value == 'null') {
                        
                        unset($options[$key]);
                        
                    }
                    
                }
                
                $options = array_values($options);
                
                $data = json_decode($row['data'], true);
                foreach ((array) $data as $key => $value) {
                    
                    if ($value['id'] == $id) {
                        
                        return array("status" => "error", "message" => "An ID with the same name already exists in the form.");
                        
                    }
                    
                }
                
                $item = array(
                    "id"                => $id, 
                    "name"              => sanitize_text_field($_POST["name"]), 
                    "description"       => sanitize_textarea_field($_POST["description"]),
                    "value"             => "", 
                    "uri"               => sanitize_textarea_field($_POST["uri"]),
                    "type"              => sanitize_text_field($_POST["type"]), 
                    "active"            => sanitize_text_field($_POST["active"]), 
                    "options"           => $options, 
                    "required"          => sanitize_text_field($_POST["required"]), 
                    "isName"            => sanitize_text_field($_POST["isName"]),
                    "isEmail"           => sanitize_text_field($_POST["isEmail"]),
                    "isSMS"           => sanitize_text_field($_POST["isSMS"]),
                    "isAddress"         => sanitize_text_field($_POST["isAddress"]),
                    "isTerms"           => sanitize_text_field($_POST["isTerms"]),
                    "isAutocomplete"    => sanitize_text_field($_POST["isAutocomplete"]),
                    "placeholder"        => sanitize_text_field($_POST["placeholder"]),
                );
                
                if (isset($_POST['targetCustomers'])) {
                    
                    $item['targetCustomers'] = sanitize_text_field($_POST["targetCustomers"]);
                    
                }
                
                array_push($data, $item);
                $json = json_encode($data);
                if (defined('JSON_NUMERIC_CHECK')) {
                    
                    $json = json_encode($data, JSON_NUMERIC_CHECK);
                    
                }
                
                $wpdb->update(  
                    $table_name,
                    array('data' => $json),
                    array('key' => intval($row['key'])),
                    array('%s'),
                    array('%d')
                );
                
                #return $data;
                return $this->getForm($accountKey, false);
                
            }
            
        }
        
        public function updateForm(){
            
            $accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            if (isset($_POST['isSMS']) === false) {
                
                $_POST['isSMS'] = 'false';
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_form";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
            $row = $wpdb->get_row($sql, ARRAY_A);
            if (is_null($row)) {
                
                return array('status' => 'error');
                
            } else {
                
                $id = strtolower($_POST['id']);
                $id = preg_replace('/[^0-9a-zA-Z]/', '', $id);
                $id  = preg_replace("/^( )|(　)$/", "", $id );
                $input = array();
                #$options = str_replace("\\\"", "\"", sanitize_text_field($_POST['options']));
                #$options = str_replace("\'", "'", $options);
                $options = stripslashes($_POST['options']);
                $options = sanitize_text_field($options);
                $options = json_decode($options, true);
                if (is_null($options) || is_bool($options) === true) {
                    
                    $options = array();
                    
                }
                
                foreach ($options as $key => $value) {
                    
                    if (is_null($value) || empty($value) || $value == 'null') {
                        
                        unset($options[$key]);
                        
                    }
                    
                }
                
                $options = array_values($options);
                
                $data = json_decode($row['data']);
                #for($i = 0; $i < count($data); $i++){
                foreach ((array) $data as $i => $value) {
                    
                    if (intval($i) == intval($_POST['key']) && $value->id == $id) {
                        
                        $value->name                = sanitize_text_field($_POST['name']);
                        $value->description         = sanitize_textarea_field($_POST['description']);
                        $value->uri                 = sanitize_text_field($_POST['uri']);
                        $value->active              = sanitize_text_field($_POST['active']);
                        $value->type                = sanitize_text_field($_POST['type']);
                        $value->options             = $options;
                        $value->required            = sanitize_text_field($_POST['required']);
                        $value->isName              = sanitize_text_field($_POST['isName']);
                        $value->isAddress           = sanitize_text_field($_POST['isAddress']);
                        $value->isEmail             = sanitize_text_field($_POST['isEmail']);
                        $value->isSMS               = sanitize_text_field($_POST['isSMS']);
                        $value->isTerms             = sanitize_text_field($_POST['isTerms']);
                        $value->isAutocomplete      = sanitize_text_field($_POST['isAutocomplete']);
                        $value->placeholder         = sanitize_text_field($_POST["placeholder"]);
                        if (isset($_POST['targetCustomers'])) {
                            
                            $value->targetCustomers = sanitize_text_field($_POST['targetCustomers']);
                            
                        }
                        #break;
                        
                    }
                    
                    array_push($input, $value);
                    
                }
                
                $json = json_encode($input);
                if (defined('JSON_NUMERIC_CHECK')) {
                    
                    $json = json_encode($input, JSON_NUMERIC_CHECK);
                    
                }
                $wpdb->update(  
                                $table_name,
                                array('data' => $json),
                                array('key' => intval($row['key'])),
                                array('%s'),
                                array('%d')
                            );
                
                return $this->getForm($accountKey, false);
                
            }
            
            
        }
        
        public function deleteFormItem(){
            
            $accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_form";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
            $row = $wpdb->get_row($sql, ARRAY_A);
            if (is_null($row)) {
                
                return array('status' => 'error');
                
            } else {
                
                $data = json_decode($row['data']);
                array_splice($data, intval($_POST['key']), 1);
                $json = json_encode($data);
                if (defined('JSON_NUMERIC_CHECK')) {
                    
                    $json = json_encode($data, JSON_NUMERIC_CHECK);
                    
                }
                $wpdb->update(  
                    $table_name,
                    array('data' => $json),
                    array('key' => intval($row['key'])),
                    array('%s'),
                    array('%d')
                );
                
                #return $data;
                return $this->getForm($accountKey, false);
                
            }
            
        }
        
        public function changeFormRank(){
            
            $accountKey = 1;
            if(isset($_POST['accountKey'])){
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            $keyList = explode(",", $_POST['keyList']);
            $indexList = explode(",", $_POST['indexList']);
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_form";
            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
            $row = $wpdb->get_row($sql, ARRAY_A);
            if(is_null($row)){
                
                return array('status' => 'error');
                
            }else{
                
                $newData = array();
                $data = json_decode($row['data']);
                #for($i = 0; $i < count($data); $i++){
                foreach ((array) $data as $key => $value) {
                    
                    $search = array_search($value->name, $keyList);
                    $index = intval($indexList[$search]);
                    $newData[$index] = $value;
                    
                }
                
                ksort($newData);
                $json = json_encode($newData);
                if (defined('JSON_NUMERIC_CHECK')) {
                    
                    $json = json_encode($newData, JSON_NUMERIC_CHECK);
                    
                }
                $wpdb->update(  
                                $table_name,
                                array('data' => $json),
                                array('key' => intval($row['key'])),
                                array('%s'),
                                array('%d')
                            );
                
                return $newData;
                        
            }
            
            
        }
        
        public function getCss($fileName, $plugin_dir_path) {
            
            if (get_option('_' . $this->pluginName . '_css_v') === false) {
                
                add_option('_' . $this->pluginName . '_css_v', date('U'));
                
            }
            
            $upload_dir = wp_upload_dir();
            $dirname = $upload_dir['basedir'] . '/' . $this->pluginName;
            /**
            if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
                
                $id = get_current_blog_id();
                $dirname .= '/' . $id;
                
            }
            **/
            $css = "";
            if (!file_exists($dirname)) {
            	
            	#wp_mkdir_p($dirname);
            	if (wp_mkdir_p($dirname) === true) {
            	    
            	    $css = file_get_contents($plugin_dir_path . 'css/front_end.css');
            	    file_put_contents($dirname . '/' . $fileName, $css);
            	    
            	} else {
            	    
            	    $css = "There is a problem with directory permissions on wp-content or wp-content/uploads.";
            	    
            	}
            	
            } else {
                
                if (file_exists($dirname . '/' . $fileName)) {
                    
                    $css = file_get_contents($dirname . '/' . $fileName);
                    
                } else {
                    
                    if (wp_mkdir_p($dirname) === true) {
                        
                        $css = file_get_contents($plugin_dir_path . 'css/front_end.css');
            	        file_put_contents($dirname . '/' . $fileName, $css);
                        
                    } else {
                        
                        $css = "There is a problem with directory permissions on wp-content or wp-content/uploads.";
            	        
                    }
                    
                }
                
                
            }
            
            return $css;
            
        }
        
        public function getCssUrl($fileName) {
            
            $upload_dir = wp_upload_dir();
            $dirname = $upload_dir['baseurl'] . '/' . $this->pluginName;
            $parseUrl = parse_url($dirname);
            if ($parseUrl['scheme'] == 'https') {
                
                $dirname = str_replace('https://', '//', $dirname);
                
            } else if ($parseUrl['scheme'] == 'http') {
                
                $dirname = str_replace('http://', '//', $dirname);
                
            }
            
            /**
            if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
                
                $id = get_current_blog_id();
                $dirname .= '/' . $id . '/' . $fileName;
                
            } else {
                
                $dirname .= '/' . $fileName;
                
            }
            **/
            $dirname .= '/' . $fileName;
            return array('dirname' => $dirname, 'v' => get_option('_' . $this->pluginName . '_css_v'));
            
        }
        
        public function updateCss($fileName) {
            
            update_option('_' . $this->pluginName . '_css_v', date('U'));
            $upload_dir = wp_upload_dir();
            $dirname = $upload_dir['basedir'] . '/' . $this->pluginName;
            
            /**
            if (function_exists('get_sites') && class_exists('WP_Site_Query')) {
                
                $id = get_current_blog_id();
                $dirname .= '/' . $id;
                
            }
            **/
            #$value = str_replace("\\\"", "\"", $_POST['value']);
            #$value = str_replace("\'", "'", $value);
            $value = stripslashes($_POST['value']);
            file_put_contents($dirname . '/' . $fileName, $value);
            return array("status" => "success");
            
        }
        
        public function getJavaScript($fileName, $plugin_dir_path) {
            
            if (get_option('_' . $this->pluginName . '_javascript_v') === false) {
                
                add_option('_' . $this->pluginName . '_javascript_v', date('U'));
                
            }
            
            $upload_dir = wp_upload_dir();
            $dirname = $upload_dir['basedir'] . '/' . $this->pluginName;
            $javascript = "";
            if (!file_exists($dirname)) {
            	
            	if (wp_mkdir_p($dirname) === true) {
            	    
            	    $javascript = file_get_contents($plugin_dir_path . 'js/front_end.js');
            	    file_put_contents($dirname . '/' . $fileName, $javascript);
            	    
            	} else {
            	    
            	    $javascript = "//There is a problem with directory permissions on wp-content or wp-content/uploads.";
            	    
            	}
            	
            } else {
                
                if (file_exists($dirname . '/' . $fileName)) {
                    
                    $javascript = file_get_contents($dirname . '/' . $fileName);
                    
                } else {
                    
                    if (wp_mkdir_p($dirname) === true) {
                        
                        $javascript = file_get_contents($plugin_dir_path . 'js/front_end.js');
                        file_put_contents($dirname . '/' . $fileName, $javascript);
                        
                    } else {
                        
                        $javascript = "//There is a problem with directory permissions on wp-content or wp-content/uploads.";
                        
                    }
                    
                }
                
            }
            
            return $javascript;
            
        }
        
        public function getJavaScriptUrl($fileName) {
            
            $upload_dir = wp_upload_dir();
            $dirname = $upload_dir['baseurl'] . '/' . $this->pluginName;
            $parseUrl = parse_url($dirname);
            if ($parseUrl['scheme'] == 'https') {
                
                $dirname = str_replace('https://', '//', $dirname);
                
            } else if ($parseUrl['scheme'] == 'http') {
                
                $dirname = str_replace('http://', '//', $dirname);
                
            }
            $dirname .= '/' . $fileName;
            return array('dirname' => $dirname, 'v' => get_option('_' . $this->pluginName . '_javascript_v'));
            
        }
        
        public function updateJavaScript($fileName) {
            
            update_option('_' . $this->pluginName . '_javascript_v', date('U'));
            $upload_dir = wp_upload_dir();
            $dirname = $upload_dir['basedir'] . '/' . $this->pluginName;
            $value = $_POST['value'];
            #$value = str_replace("\\\\", "\\", $value);
            #$value = str_replace("\\\"", "\"", $value);
            #$value = str_replace("\'", "'", $value);
            $value = stripslashes($value);
            file_put_contents($dirname . '/' . $fileName, $value);
            return array("status" => "success", 'value' => $value);
            
        }
        
        public function updataEmailMessageForCalendarAccount(){
            
            $accountKey = intval($_POST['accountKey']);
            $mail_id = sanitize_text_field($_POST['mail_id']);
            $subject = sanitize_text_field($_POST['subject']);
            $content = sanitize_textarea_field(htmlspecialchars($_POST['content'], ENT_QUOTES|ENT_HTML5));
            #$content = balanceTags(wp_kses_post($_POST['content']));
            $subjectForAdmin = sanitize_text_field($_POST['subjectForAdmin']);
            $contentForAdmin = sanitize_textarea_field(htmlspecialchars($_POST['contentForAdmin'], ENT_QUOTES|ENT_HTML5));
            #$contentForAdmin = balanceTags($_POST['contentForAdmin']);
            $enable = intval($_POST['enableEmail']);
            $enableSMS = intval($_POST['enableSms']);
            $format = sanitize_text_field($_POST['format']);
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_emailSetting";
            $wpdb->update(
                $table_name,
                array('subject' => $subject, 'content' => $content, 'subjectForAdmin' => $subjectForAdmin, 'contentForAdmin' => $contentForAdmin, 'enable' => $enable, 'enableSMS' => $enableSMS, 'format' => $format),
                array('accountKey' => $accountKey, 'mail_id' => $mail_id),
                array('%s', '%s', '%s', '%s', '%d', '%d', '%s'),
                array('%d', '%s')
            );
            
            return $this->getEmailMessageList($accountKey);
            
        }
        
        public function updataEmailMessage($key, $subject, $content, $enable, $format){
            
            $key = sanitize_text_field($key);
            $subject = sanitize_text_field($subject);
            $content = balanceTags(wp_kses_post($content));
            $enable = sanitize_text_field($enable);
            $format = sanitize_text_field($format);
            
            if(get_option($key."_subject") === false){
					    
				add_option($key."_subject", $subject);
				
		    }else{
				
				update_option($key."_subject", $subject);
	            
			 }
			 
			 if(get_option($key."_content") === false){
					    
				add_option($key."_content", $content);
				
		    }else{
				
				update_option($key."_content", $content);
	            
			 }
			 
			 if(get_option($key."_enable") === false){
					    
				add_option($key."_enable", $enable);
				
		    }else{
				
				update_option($key."_enable", $enable);
	            
		    }
		    
		    if(get_option($key."_format") === false){
					    
				add_option($key."_format", $format);
				
		    }else{
				
				update_option($key."_format", $format);
	            
		    }
            
            return $this->getEmailMessage();
            
        }
        
        public function lookingForSubscription($customer_id, $subscription_id, $email){
            
            global $wpdb;
            $url = BOOKING_PACKAGE_EXTENSION_URL;
            $lookingForUrl = site_url();
            /**
            $params = array(
                'mode' => 'error', 
                'subscription_mode' => 'lookingForSubscription',
                'customer_id_for_subscriptions' => $_POST['customer_id_for_subscriptions'],
                'customer_email_for_subscriptions' => trim($_POST['customer_email_for_subscriptions']),
                'subscriptions_id_for_subscriptions' => $_POST['subscriptions_id_for_subscriptions'],
                'url' => $lookingForUrl,
            );
            **/
            $params = array(
                'mode' => 'error', 
                'subscription_mode' => 'lookingForSubscription',
                'customer_id_for_subscriptions' => trim($customer_id),
                'customer_email_for_subscriptions' => trim($email),
                'subscriptions_id_for_subscriptions' => trim($subscription_id),
                'url' => $lookingForUrl,
            );
            
            $args = array(
                'method' => 'POST',
                'body' => $params
            );
            $response = wp_remote_request($url . "lookingForSubscription/", $args);
            $statusCode = wp_remote_retrieve_response_code($response);
            $response = json_decode(wp_remote_retrieve_body($response), true);
            $response['url'] = $url;
            if (intval($statusCode) == 200 && intval($response['status']) == 1) {
                
                unset($response['status']);
                foreach ((array) $response as $key => $value) {
                    
                    if (get_option('_' . $this->prefix . $key) !== false) {
                        
                        update_option('_' . $this->prefix . $key, sanitize_text_field($value));
                        
                    } else {
                        
                        $bool = add_option('_' . $this->prefix . $key, sanitize_text_field($value));
                        
                    }
                    
                }
                
            }
            
            return $response;
            
        }
        
        public function upgradePlan($type){
            
            $response = array('status' => 'error');
            if ($type == 'regist') {
                
                #$values = ['customer_id_for_subscriptions', 'id_for_subscriptions', 'customer_email_for_subscriptions'];
                $values = array('customer_id_for_subscriptions', 'id_for_subscriptions', 'customer_email_for_subscriptions', 'invoice_id_for_subscriptions', 'expiration_date_for_subscriptions');
                for ($i = 0; $i < count($values); $i++) {
                    
                    $key = $values[$i];
                    $value = sanitize_text_field($_GET[$key]);
                    if (get_option('_'.$this->prefix.$key) === false) {
					   
				        add_option('_'.$this->prefix.$key, $value);
				    
		            } else {
				        
				        update_option('_'.$this->prefix.$key, $value);
	                    
                    }
		            
                }
                
                $response['status'] = 'success';
                
            } else if ($type == 'update') {
                
                #$values = ['invoice_id_for_subscriptions', 'expiration_date_for_subscriptions'];
                $values = array('invoice_id_for_subscriptions', 'expiration_date_for_subscriptions');
                for ($i = 0; $i < count($values); $i++) {
                    
                    $key = $values[$i];
                    $value = sanitize_text_field($_POST[$key]);
                    if (get_option('_'.$this->prefix.$key) === false) {
					   
				        add_option('_'.$this->prefix.$key, $value);
				    
		            } else {
				        
				        update_option('_'.$this->prefix.$key, $value);
	                    
                    }
		            
                }
                
                $response['status'] = 'success';
                
            } else if($type == 'get') {
                
                #$values = ['customer_id_for_subscriptions', 'id_for_subscriptions', 'customer_email_for_subscriptions', 'invoice_id_for_subscriptions', 'expiration_date_for_subscriptions'];
                $values = array('customer_id_for_subscriptions', 'id_for_subscriptions', 'customer_email_for_subscriptions', 'invoice_id_for_subscriptions', 'expiration_date_for_subscriptions');
                for ($i = 0; $i < count($values); $i++) {
                    
                    $key = $values[$i];
                    $value = get_option('_' . $this->prefix . $key, 0);
                    if (get_option($this->prefix.$key) !== false) {
                        
                        $value = get_option($this->prefix . $key);
                        delete_option($this->prefix . $key);
                        add_option('_' . $this->prefix . $key, $value);
                        
                    }
                    $response[$key] = $value;
                    
                }
                
                $response['status'] = 'success';
                
            } else if ($type == 'delete') {
                
                $params = array(
                    'mode' => 'error', 
                    'subscription_mode' => 'cancelSubscription',
                    'customer_id' => $_POST['customer_id'],
                    'subscriptions_id' => trim($_POST['subscriptions_id']),
                );
                
                $args = array(
                    'method' => 'POST',
                    'body' => $params
                );
                $response = wp_remote_request(BOOKING_PACKAGE_EXTENSION_URL . "cancelSubscription/", $args);
                $statusCode = wp_remote_retrieve_response_code($response);
                $response = json_decode(wp_remote_retrieve_body($response), true);
                $response['url'] = BOOKING_PACKAGE_EXTENSION_URL;
                if ($statusCode == 200 && $response['status'] == 'success') {
                    
                    $values = array('customer_id_for_subscriptions', 'id_for_subscriptions', 'customer_email_for_subscriptions', 'invoice_id_for_subscriptions', 'expiration_date_for_subscriptions');
                    for ($i = 0; $i < count($values); $i++) {
                        
                        $key = $values[$i];
                        if (get_option('_' . $this->prefix . $key) === false) {
                            
                            add_option('_' . $this->prefix . $key, 0);
                            
                        } else {
                            
                            update_option('_' . $this->prefix . $key, 0);
                            
                        }
                        
                    }
                    
                    $response['status'] = 'success';
                    
                }
                
            }
            
            return $response;
            
        }
        
        private function getExtensionsValid($loadScript = false) {
			
			if (is_null($this->isExtensionsValid)) {
				
				$this->isExtensionsValid = $this->getSiteStatus($loadScript);
				
			}
			
			return $this->isExtensionsValid;
			
		}
        
        public function getSiteStatus($loadScript = true){
            
            $url = BOOKING_PACKAGE_EXTENSION_URL;
            $response = array('status' => 'error');
            $subscriptions = $this->upgradePlan('get');
            if (intval($subscriptions['expiration_date_for_subscriptions']) == 0) {
                
                return false;
                
            }
            
            $expiration_date = intval($subscriptions['expiration_date_for_subscriptions']);
            if ($expiration_date < date('U')) {
                
                $params = array(
                    "subscription_mode" => "updateLicense",
                    "customer_id" => $subscriptions['customer_id_for_subscriptions'], 
                    "subscriptions_id" => $subscriptions['id_for_subscriptions'],
                    "site" => get_site_url(),
                );
                
                $args = array(
                    'method' => 'POST',
                    'body' => $params
                );
                $response = wp_remote_request($url . "updateLicense/", $args);
                $statusCode = wp_remote_retrieve_response_code($response);
                $response = json_decode(wp_remote_retrieve_body($response));
                
                $tmp_path = sys_get_temp_dir();
                #var_dump($response);
                
                if (intval($statusCode) == 200) {
                    
                    if (intval($response->status) == 1) {
                        
                        update_option('_' . $this->prefix . "invoice_id_for_subscriptions", sanitize_text_field($response->invoice_id));
                        $bool = update_option('_' . $this->prefix . "expiration_date_for_subscriptions", sanitize_text_field($response->expiration_date));
                        $subscriptions = $this->upgradePlan('get');
                        
                    } else if (intval($response->status) == 0) {
                        
                        $bool = update_option('_' . $this->prefix . "expiration_date_for_subscriptions", sanitize_text_field('0'));
                        return false;
                        
                    }
                    
                }
                
            }
            
            if ($loadScript === true) {
                
                #$url .= "expiration/extensions.js?token=".hash('ripemd160', $subscriptions['invoice_id_for_subscriptions'])."&customer_id=".$subscriptions['customer_id_for_subscriptions'];
                #wp_enqueue_script('extension_function_js', $url);
                
            }
            
            return true;
            
        }
        
        public function updatePluginSubscription($mode) {
            
            $subscriptions = $this->upgradePlan("get");
			$isExtensionsValid = $this->getSiteStatus(false);
			if ($isExtensionsValid == true) {
                
                if ($mode == 'activation') {
                    
                    $this->lookingForSubscription($subscriptions['customer_id_for_subscriptions'], $subscriptions['id_for_subscriptions'], $subscriptions['customer_email_for_subscriptions']);
                    /**
                    $params = array(
                        'mode' => 'error', 
                        'subscription_mode' => 'lookingForSubscription',
                        'customer_id_for_subscriptions' => $subscriptions['customer_id_for_subscriptions'],
                        'customer_email_for_subscriptions' => $subscriptions['customer_email_for_subscriptions'],
                        'subscriptions_id_for_subscriptions' => $subscriptions['id_for_subscriptions'],
                        'url' => site_url(),
                    );
                    $args = array(
                        'method' => 'POST',
                        'body' => $params
                    );
                    $response = wp_remote_request(BOOKING_PACKAGE_EXTENSION_URL . "lookingForSubscription/", $args);
                    $statusCode = wp_remote_retrieve_response_code($response);
                    $response = json_decode(wp_remote_retrieve_body($response));
                    **/
                    
                } else if ($mode == 'deactivation') {
                    
                    $params = array(
                        "subscription_mode" => "cancelAtPeriodEnd",
                        "customer_id" => $subscriptions['customer_id_for_subscriptions'], 
                        "subscriptions_id" => $subscriptions['id_for_subscriptions'],
                    );
                    $args = array(
                        'method' => 'POST',
                        'body' => $params
                    );
                    $response = wp_remote_request(BOOKING_PACKAGE_EXTENSION_URL . "cancelAtPeriodEnd/", $args);
                    $statusCode = wp_remote_retrieve_response_code($response);
                    $response = json_decode(wp_remote_retrieve_body($response), true);
                    
                }
			    
			}
			
            return $isExtensionsValid;
            
        }
        
        public function payNewSubscriptions(){
            
            $url = BOOKING_PACKAGE_EXTENSION_URL;
            $response = array("status" => "error", "customer_id_for_subscriptions" => $_POST['customer_id_for_subscriptions']);
            $params = array(
                "subscription_mode" => "payNewSubscriptions",
                "customer_id_for_subscriptions" => $_POST['customer_id_for_subscriptions'], 
                "customer_email_for_subscriptions" => $_POST['customer_email_for_subscriptions'],
                "site" => $_POST['site'],
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url."payNewSubscriptions/");
            curl_setopt($ch, CURLOPT_USERPWD, $subscriptions['customer_id_for_subscriptions'].":");
            curl_setopt($ch, CURLOPT_COOKIEJAR, $tmp_path."/".$this->prefix."session.cookie");
            curl_setopt($ch, CURLOPT_COOKIEFILE, $tmp_path."/".$this->prefix."session.cookie");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            
            ob_start();
            $response = curl_exec($ch);
			$response = ob_get_contents();
			ob_end_clean();
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $response = json_decode($response, true);
            if ($response['status'] == 'success') {
                
                foreach ((array) $response as $key => $value) {
                    
                    $_GET[$key] = $value;
                    
                }
                $this->upgradePlan('regist');
                
            }
            
            return $response;
            
        }
        
        public function updateChannelGC($calendarAccountList){
            
            $url_parce = parse_url(get_home_url());
            if($url_parce['scheme'] != 'https'){
                
                return false;
                
            }
            
            $keyList = array();
            $calendarIdList = array();
            for($i = 0; $i < count($calendarAccountList); $i++){
                
                if($calendarAccountList[$i]['expirationForGoogleWebhook'] < date('U')){
                    
                    array_push($keyList, $calendarAccountList[$i]['key']);
                    array_push($calendarIdList, $calendarAccountList[$i]['googleCalendarID']);
                    
                }
                
            }
            
            if(count($calendarIdList) == 0){
                
                return null;
                
            }
            
            $calendarIdList = implode(",", $calendarIdList);
            
            $googleCalendar = array();
    		$bookingSync = $this->getBookingSyncList();
    		$bookingSync = $bookingSync['Google_Calendar'];
    		if(intval($bookingSync['booking_package_googleCalendar_active']['value']) == 1){
    		    
    		    if($this->getExtensionsValid(false) === true){
    		        
    		        $expiration_for_google_webhook = get_option($this->prefix."expiration_for_google_webhook", 0);
    		        $expiration_for_google_webhook -= (1440 * 60) * 2;
    		        #$timezone = get_option('timezone_string');
			        date_default_timezone_set("UTC");
			        if(date('U') < $expiration_for_google_webhook){
			            
			            return false;
			            
			        }
    		        
		            $host = $url_parce["host"];
		            $address = get_home_url()."/?webhook=google";
    		        $id = hash('ripemd160', date('U'));
    		        $timezone = get_option('timezone_string');
    		        $subscriptions = $this->upgradePlan('get');
    		        
    				$customer_id = $subscriptions['customer_id_for_subscriptions'];
    				$params = array(
    					'mode' => 'updateChannel',
    					'customer_id' => $customer_id, 
    					'calendarIdList' => $calendarIdList,
    					/**'calendarId' => $bookingSync['booking_package_calendar_id']['value'], **/
    					'service_account' => $bookingSync['booking_package_googleCalendar_json']['value'],
    					'id' => $id,
    					'token' => 'target='.hash('ripemd160', microtime()),
    					'address' => $address,
    					'timeZone' => get_option('timezone_string')
    				);
    				#var_dump($params);
    				if(isset($bookingSync['booking_package_googleCalendar_json'])){
    				    
    				    $params['calendarId'] = $bookingSync['booking_package_calendar_id']['value'];
    				    
    				}
    				
    				$tmp_path = sys_get_temp_dir();
    				
    				$url = BOOKING_PACKAGE_EXTENSION_URL;
    				$ch = curl_init();
                	curl_setopt($ch, CURLOPT_URL, $url."googleCalendar/");
                	curl_setopt($ch, CURLOPT_COOKIEJAR, $tmp_path."/".$this->prefix."session.cookie");
                	curl_setopt($ch, CURLOPT_COOKIEFILE, $tmp_path."/".$this->prefix."session.cookie");
                	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                	curl_setopt($ch, CURLOPT_POST, 1);
                	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                	
                	ob_start();
                	$response = curl_exec($ch);
                	$response = ob_get_contents();
                	ob_end_clean();
                	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                	curl_close ($ch);
                	$response = json_decode($response, true);
                	#var_dump($response);
                	if($response['status'] != 'error'){
                	    
                	    for($i = 0; $i < count($response); $i++){
                    	    
                    	    $response[$i]['key'] = $keyList[$i];
                    	    
                    	}
                    	
                    	if(isset($response['expiration'])){
                    	    
                    	    $response['expiration'] /= 1000;
                    	    $list = array('id' => 'id_for_google_webhook', 'token' => 'token_for_google_webhook', 'expiration' => 'expiration_for_google_webhook');
                    	    foreach ((array) $list as $key => $value) {
                    	        
                    	        $optionKey = sanitize_text_field($this->prefix.$value);
                    	        $optionValue = sanitize_text_field($response[$key]);
                    	        if(get_option($optionKey) === false){
    					            
    	                            add_option($optionKey, $optionValue);
    					        
                                }else{
    				                
    				                update_option($optionKey, $optionValue);
    				                
    			                }
                    	        
                    	    }
                    	    
                    	}
                	    
                	}else{
                	    
                	    $response = array();
                	    
                	}
                	
                	
                	
                	#var_dump($response);
                	
                	return $response;
    		        
    		    }
    		    
    		}
            
        }
        
        public function listsGC($accountKey, $googleCalendarID, $timeMin){
            
            if(strlen($googleCalendarID) == 0){
                
                return array();
                
            }
            
            
            $eventList = array();
    		$bookingSync = $this->getBookingSyncList($accountKey);
    		$bookingSync = $bookingSync['Google_Calendar'];
    		#var_dump($bookingSync);
    		if(intval($bookingSync['booking_package_googleCalendar_active']['value']) == 1){
    			
    			if($this->getExtensionsValid(false) === true){
    			    
    			    $subscriptions = $this->upgradePlan('get');
    				$customer_id = $subscriptions['customer_id_for_subscriptions'];
    				$params = array(
    								'mode' => 'lists',
    								'timeMin' => $timeMin,
    								'customer_id' => $customer_id, 
    								'calendarId' => $googleCalendarID, 
    								'service_account' => $bookingSync['booking_package_googleCalendar_json']['value'],
    								'timeZone' => get_option('timezone_string')
    							);
    			    
    			    #var_dump($params);
    			    $tmp_path = sys_get_temp_dir();
    			    
    			    $url = BOOKING_PACKAGE_EXTENSION_URL;
    				$ch = curl_init();
                	curl_setopt($ch, CURLOPT_URL, $url."googleCalendar/");
                	#curl_setopt($ch, CURLOPT_USERPWD, $subscriptions['customer_id_for_subscriptions'].":");
                	curl_setopt($ch, CURLOPT_COOKIEJAR, $tmp_path."/".$this->prefix."session.cookie");
                	curl_setopt($ch, CURLOPT_COOKIEFILE, $tmp_path."/".$this->prefix."session.cookie");
                	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                	curl_setopt($ch, CURLOPT_POST, 1);
                	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			        
                	ob_start();
                	$response = curl_exec($ch);
                	$response = ob_get_contents();
                	ob_end_clean();
                	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                	curl_close ($ch);
                	$eventList = json_decode($response);
                	if($eventList->status != 'error'){
                		
                	}
                	
                	return $eventList;
    			    
    			}
    			
    		}
            
        }
        
        public function pushGC($mode, $accountKey, $type, $id, $googleCalendarID, $sql_start_unixTime, $sql_end_unixTime, $form, $iCalID = false){
    		
    		if(strlen($googleCalendarID) == 0){
                
                return array();
                
            }
    		
    		$id = intval($id);
    		$googleCalendar = array();
    		$bookingSync = $this->getBookingSyncList($accountKey);
    		$bookingSync = $bookingSync['Google_Calendar'];
    		if(intval($bookingSync['booking_package_googleCalendar_active']['value']) == 1){
    			
    			if($this->getExtensionsValid(false) === true){
    				
    				if(is_null($sql_end_unixTime)){
    					
    					$sql_end_unixTime = $sql_start_unixTime;
    					
    				}
    				$nameList = array();
    				$addressList = array();
    				for($i = 0; $i < count($form); $i++){
    					
    					if($form[$i]->isName == 'true'){
    						
    						array_push($nameList, $form[$i]->value);
    						
    					}
    					
    					if($form[$i]->isAddress == 'true'){
    						
    						array_push($addressList, $form[$i]->value);
    						
    					}
    					
    				}
    				
    				$subscriptions = $this->upgradePlan('get');
    				$customer_id = $subscriptions['customer_id_for_subscriptions'];
    				$params = array(
    								'mode' => $mode,
    								'customer_id' => $customer_id, 
    								'calendarId' => $googleCalendarID, 
    								'service_account' => $bookingSync['booking_package_googleCalendar_json']['value'],
    								'startTime' => intval($sql_start_unixTime),
    								'endTime' => intval($sql_end_unixTime),
    								'form' => json_encode($form),
    								'timeZone' => get_option('timezone_string'),
    								'type' => $type
    							);
    							
    				if($iCalID !== false){
    				    
    				    $params['iCalID'] = $iCalID;
    				    
    				}
    				
    				#var_dump($params);
    				
    				$tmp_path = sys_get_temp_dir();
    				
    				$url = BOOKING_PACKAGE_EXTENSION_URL;
    				$ch = curl_init();
                	curl_setopt($ch, CURLOPT_URL, $url."googleCalendar/");
                	curl_setopt($ch, CURLOPT_COOKIEJAR, $tmp_path."/".$this->prefix."session.cookie");
                	curl_setopt($ch, CURLOPT_COOKIEFILE, $tmp_path."/".$this->prefix."session.cookie");
                	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                	curl_setopt($ch, CURLOPT_POST, 1);
                	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			        
                	ob_start();
                	$response = curl_exec($ch);
                	$response = ob_get_contents();
                	ob_end_clean();
                	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                	curl_close ($ch);
                	#var_dump($response);
                	$googleCalendar = json_decode($response);
                	if($googleCalendar->status != 'error'){
                		
                	}
                	
                	#var_dump($httpCode);
                	$googleCalendar->responseMode = $mode;
                	if($httpCode >= 400){
                	    
                	    $googleCalendar->responseCode = $httpCode;
                	    $googleCalendar->responseStatus = 0;
                	    
                	}else{
                	    
                	    $googleCalendar->responseStatus = 1;
                	    
                	}
                	
                	return $googleCalendar;
                		
    			}
    			
    		}
    		
    	}
    	
    	public function deleteGC($accountKey, $id, $googleCalendarID){
            
            if(strlen($googleCalendarID) == 0){
                
                return array();
                
            }
            
            if(is_null($id)){
                
                return array("id" => "No ID");
                
            }
            
            $googleCalendar = array();
    		$bookingSync = $this->getBookingSyncList($accountKey);
    		$bookingSync = $bookingSync['Google_Calendar'];
    		if(intval($bookingSync['booking_package_googleCalendar_active']['value']) == 1){
    		    
    		    if($this->getExtensionsValid(false) === true){
    		        
    		        $timezone = get_option('timezone_string');
    		        $subscriptions = $this->upgradePlan('get');
    				$customer_id = $subscriptions['customer_id_for_subscriptions'];
    				$params = array(
    								'mode' => 'delete',
    								'customer_id' => $customer_id, 
    								'calendarId' => $googleCalendarID, 
    								'service_account' => $bookingSync['booking_package_googleCalendar_json']['value'],
    								'id' => $id,
    								'timeZone' => get_option('timezone_string')
    							);
    				#var_dump($params);
    				
    				$tmp_path = sys_get_temp_dir();
    				
    				$url = BOOKING_PACKAGE_EXTENSION_URL;
    				$ch = curl_init();
                	curl_setopt($ch, CURLOPT_URL, $url."googleCalendar/");
                	#curl_setopt($ch, CURLOPT_USERPWD, $subscriptions['customer_id_for_subscriptions'].":");
                	curl_setopt($ch, CURLOPT_COOKIEJAR, $tmp_path."/".$this->prefix."session.cookie");
                	curl_setopt($ch, CURLOPT_COOKIEFILE, $tmp_path."/".$this->prefix."session.cookie");
                	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                	curl_setopt($ch, CURLOPT_POST, 1);
                	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			        
                	ob_start();
                	$response = curl_exec($ch);
                	$response = ob_get_contents();
                	ob_end_clean();
                	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                	curl_close ($ch);
                	$response = json_decode($response, true);
                	
                	return $response;
    		        
    		    }
    		    
    		}
            
        }
        
        public function activation($url, $mode, $version = null, $timezone = null, $site = null){
            
			if (is_null($timezone)) {
                
                $timezone = get_option($this->prefix . 'timezone', null);
                if (is_null($timezone)) {
                    
                    $timezone = get_option('timezone_string', '');
                    if(is_null($timezone) || strlen($timezone) == 0){
                        
                        $timezone = 'UTC';
                        
                    }
                    
                    add_option($this->prefix."timezone", sanitize_text_field($timezone));
                    
                }
                
			}
			
            if (is_null($site)) {
                
                $site = site_url();
                
            }
			
			$id = get_option($this->prefix."activation_id", null);
			$params = array("mode" => $mode, "timeZone" => $timezone, "local" => get_locale(), "site" => $site);
			
			if (!is_null($id) || $id != 0) {
				
				$params['id'] = $id;
				
			}
			
			if (!is_null($version)) {
			    
			    $params['version'] = $version;
			    
			}
			
			$args = array(
                'method' => 'POST',
                'body' => $params
            );
            $response = wp_remote_request($url . "activation/", $args);
            $object = json_decode(wp_remote_retrieve_body($response));
            $statusCode = wp_remote_retrieve_response_code($response);
			
			if (intval($statusCode) == 200 && $mode == 'activation') {
				
				if (get_option($this->prefix."activation_id") === false) {
					
					add_option($this->prefix."activation_id", intval($object->key));
					
				} else {
					
					update_option($this->prefix."activation_id", intval($object->key));
					
				}
				
			}
			
		}
		
		public function updateRolesOfPlugin() {
			
			$manager = $this->prefix . 'manager';
			$editor = $this->prefix . 'editor';
			
			if (is_null(get_role($manager))) {
				
				$roleArray = array('read' => true, 'level_0' => true, 'booking_package_manager' => true);
				$object = add_role($manager, 'Booking Package Manager', $roleArray);
				
			}
			
			if (is_null(get_role($editor))) {
				
				$roleArray = array('read' => true, 'level_0' => true, 'booking_package_editor' => true);
				$object = add_role($editor, 'Booking Package Editor', $roleArray);
				
			}
			
		}
		
		public function deleteRolesOfPlugin() {
			
			$roles = array($this->prefix . 'manager', $this->prefix . 'editor');
			for ($i = 0; $i < count($roles); $i++) {
				
				$role = $roles[$i];
				if (!is_null(get_role($role))) {
					
					$users = get_users(array('role' => $role));
					for ($a = 0; $a < count($users); $a++) {
						
						$user = $users[$a];
						$user->remove_role($role);
						
					}
					remove_role($role);
					
				}
				
			}
			
		}
		
		public function updateRolesOfUser() {
			
			$oldRole = $this->prefix . 'member';
			$newRole = $this->prefix . 'user';
			if (!is_null(get_role($oldRole))) {
				
				$users = get_users(array('role' => $oldRole));
				for ($i = 0; $i < count($users); $i++) {
					
					$user = $users[$i];
					#$user->remove_role($oldRole);
					#$user->add_role($newRole);
					var_dump($user->get_role_caps());
					echo "<br>\n";
					#break;
					
				}
				
				#remove_role($userRole);
				#$roleArray = array('read' => true, 'level_0' => true, 'booking_package' => true);
				#$object = add_role($newRole, 'Booking Package User', $roleArray);
				
			}
			
		}
		
		public function getOnlyNumbers($value) {
		    
		    if (function_exists('mb_convert_kana')) {
                
                $value = mb_convert_kana($value, 'n');
                
            }
            $value = preg_replace('/[^0-9]/', '', $value);
            
            if (empty($value)) {
                
                $value = 0;
                
            }
            
            return $value;
		    
		}
        
    }
    
    
?>