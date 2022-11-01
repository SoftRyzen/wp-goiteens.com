<?php
    if(!defined('ABSPATH')){
    	exit;
	}
    
    class booking_package_database {
        
        public $prefix = null;
        
        public $db_version = null;
        
        public $db_list = array();
        
        public $db_object = array();
        
        public function __construct($prefix, $db_version){
            
            $this->prefix = $prefix;
            $this->db_version = $db_version;
            
            global $wpdb;
			global $jal_db_version;
            $charset_collate = $wpdb->get_charset_collate();
            
            $table_name = $wpdb->prefix.'booking_package_calendarAccount';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"											=> "`key`									INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"name"											=> "`name`									VARCHAR(255) NOT NULL",
					"type"											=> "`type`									VARCHAR(50) DEFAULT 'day'",
					"schedulesSharing"								=> "`schedulesSharing`						INT(11) DEFAULT 0",
					"targetSchedules"								=> "`targetSchedules`						INT(11) DEFAULT 0",
					"cost"											=> "`cost`									INT(11) DEFAULT 0",
					"hotelChargeOnSunday"							=> "`hotelChargeOnSunday`					INT(11) DEFAULT 0",
					"hotelChargeOnMonday"							=> "`hotelChargeOnMonday`					INT(11) DEFAULT 0",
					"hotelChargeOnTuesday"							=> "`hotelChargeOnTuesday`					INT(11) DEFAULT 0",
					"hotelChargeOnWednesday"						=> "`hotelChargeOnWednesday`				INT(11) DEFAULT 0",
					"hotelChargeOnThursday"							=> "`hotelChargeOnThursday`					INT(11) DEFAULT 0",
					"hotelChargeOnFriday"							=> "`hotelChargeOnFriday`					INT(11) DEFAULT 0",
					"hotelChargeOnSaturday"							=> "`hotelChargeOnSaturday`					INT(11) DEFAULT 0",
					"hotelChargeOnDayBeforeNationalHoliday"			=> "`hotelChargeOnDayBeforeNationalHoliday`	INT(11) DEFAULT 0",
					"hotelChargeOnNationalHoliday"					=> "`hotelChargeOnNationalHoliday`			INT(11) DEFAULT 0",
					"maximumNights"									=> "`maximumNights`							INT(11) DEFAULT 0",
					"minimumNights"									=> "`minimumNights`							INT(11) DEFAULT 0",
					"multipleRooms"									=> "`multipleRooms`							INT(11) DEFAULT 0",
					"maxAccountScheduleDay" 						=> "`maxAccountScheduleDay`					INT(11) DEFAULT 30",
					"unavailableDaysFromToday"						=> "`unavailableDaysFromToday`				INT(11) DEFAULT 1",
					"numberOfRoomsAvailable"						=> "`numberOfRoomsAvailable`				INT(11) DEFAULT 1",
					"numberOfPeopleInRoom"							=> "`numberOfPeopleInRoom`					INT(11) DEFAULT 2",
					"includeChildrenInRoom" 						=> "`includeChildrenInRoom`					INT(1) DEFAULT 0",
					"formatNightDay"								=> "`formatNightDay`						INT(1) DEFAULT 0",
					"expressionsCheck"								=> "`expressionsCheck`						INT(1) DEFAULT 0",
					"status"										=> "`status`								VARCHAR(50) DEFAULT NULL",
					"courseTitle"									=> "`courseTitle`							VARCHAR(255) DEFAULT NULL",
					"courseBool"									=> "`courseBool`							INT(1) DEFAULT 0",
					"hasMultipleServices"							=> "`hasMultipleServices`					INT(1) DEFAULT 0",
					"couponsBool"									=> "`couponsBool`							INT(1) DEFAULT 0",
					"guestsBool"									=> "`guestsBool`							INT(1) DEFAULT 0",
					/**
					"minimumGuests"									=> "`minimumGuests`							VARCHAR(255) DEFAULT '{}'",
					"maximumGuests"									=> "`maximumGuests`							VARCHAR(255) DEFAULT '{}'",
					**/
					"limitNumberOfGuests"							=> "`limitNumberOfGuests`					VARCHAR(255) DEFAULT '{}'",
					"created"										=> "`created`								INT(11) DEFAULT NULL",
					"googleCalendarID"								=> "`googleCalendarID`						VARCHAR(255) DEFAULT NULL",
					"idForGoogleWebhook"							=> "`idForGoogleWebhook`					VARCHAR(255) DEFAULT NULL",
					"expirationForGoogleWebhook"					=> "`expirationForGoogleWebhook`			INT(1) DEFAULT 0",
					"uploadDate"									=> "`uploadDate`							INT(11) DEFAULT NULL",
					"enableFixCalendar" 							=> "`enableFixCalendar`						INT(11) DEFAULT 0",
					"yearForFixCalendar"							=> "`yearForFixCalendar`					INT(11) DEFAULT 0",
					"monthForFixCalendar"							=> "`monthForFixCalendar`					INT(11) DEFAULT 0",
					"displayRemainingCapacity"						=> "`displayRemainingCapacity`				INT(11) DEFAULT 0",
					"subscriptionIdForStripe"						=> "`subscriptionIdForStripe`				VARCHAR(255) DEFAULT ''",
					"enableSubscriptionForStripe"					=> "`enableSubscriptionForStripe`			INT(11) DEFAULT 0",
					"termsOfServiceForSubscription" 				=> "`termsOfServiceForSubscription`			VARCHAR(255) DEFAULT ''",
					"enableTermsOfServiceForSubscription"			=> "`enableTermsOfServiceForSubscription`	INT(11) DEFAULT 0",
					"privacyPolicyForSubscription"					=> "`privacyPolicyForSubscription`			VARCHAR(255) DEFAULT ''",
					"enablePrivacyPolicyForSubscription"			=> "`enablePrivacyPolicyForSubscription`	INT(11) DEFAULT 0",
					"displayRemainingCapacityInCalendar"			=> "`displayRemainingCapacityInCalendar`	INT(1) DEFAULT 0",
					"displayThresholdOfRemainingCapacity"			=> "`displayThresholdOfRemainingCapacity`	INT(3) DEFAULT 50",
					"displayRemainingCapacityInCalendarAsNumber"	=> "`displayRemainingCapacityInCalendarAsNumber` INT(1) DEFAULT 0",
					"displayRemainingCapacityHasMoreThenThreshold"	=> "`displayRemainingCapacityHasMoreThenThreshold`	VARCHAR(255) DEFAULT ''",
					"displayRemainingCapacityHasLessThenThreshold"	=> "`displayRemainingCapacityHasLessThenThreshold`	VARCHAR(255) DEFAULT ''",
					"displayRemainingCapacityHas0"					=> "`displayRemainingCapacityHas0`			VARCHAR(255) DEFAULT ''",
					"startOfWeek"									=> "`startOfWeek`							INT(1) DEFAULT 0",
					"ical"											=> "`ical`									INT(1) DEFAULT 0",
					"icalToken"										=> "`icalToken`								VARCHAR(255) DEFAULT '0'",
					"syncPastCustomersForIcal"						=> "`syncPastCustomersForIcal`				INT(10) DEFAULT 7",
					"cancellationOfBooking"							=> "`cancellationOfBooking`					INT(1) DEFAULT 0",
					"displayDetailsOfCanceled"						=> "`displayDetailsOfCanceled`				INT(1) DEFAULT 1",
					"allowCancellationVisitor"						=> "`allowCancellationVisitor`				INT(1) DEFAULT 0",
					"allowCancellationUser"							=> "`allowCancellationUser`					INT(1) DEFAULT 0",
					"refuseCancellationOfBooking"					=> "`refuseCancellationOfBooking`			VARCHAR(20) DEFAULT 'not_refuse'",
					"preparationTime"								=> "`preparationTime`						INT(1) DEFAULT 0",
					"positionPreparationTime"						=> "`positionPreparationTime`				VARCHAR(20) DEFAULT 'before_after'",
					"timezone"										=> "`timezone`								VARCHAR(100) DEFAULT 'none'",
					"flowOfBooking"									=> "`flowOfBooking`							VARCHAR(100) DEFAULT 'calendar'",
					"paymentMethod"									=> "`paymentMethod`							TEXT DEFAULT NULL",
					"email_from"									=> "`email_from`							VARCHAR(255) DEFAULT NULL",
					"email_to"										=> "`email_to`								VARCHAR(255) DEFAULT NULL",
					"email_from_title"								=> "`email_from_title`						VARCHAR(255) DEFAULT NULL",
					"email_to_title"								=> "`email_to_title`						VARCHAR(255) DEFAULT NULL",
					"servicesPage"									=> "`servicesPage`							INT(11) DEFAULT NULL",
					"calenarPage"									=> "`calenarPage`							INT(11) DEFAULT NULL",
					"schedulesPage"									=> "`schedulesPage`							INT(11) DEFAULT NULL",
					"visitorDetailsPage"							=> "`visitorDetailsPage`					INT(11) DEFAULT NULL",
					"confirmDetailsPage"							=> "`confirmDetailsPage`					INT(11) DEFAULT NULL",
					"thanksPage"									=> "`thanksPage`							INT(11) DEFAULT NULL",
					"redirectPage"									=> "`redirectPage`							INT(11) DEFAULT NULL",
					"redirectURL"									=> "`redirectURL`							VARCHAR(255) DEFAULT NULL",
					"redirectMode"									=> "`redirectMode`							VARCHAR(255) DEFAULT 'page'",
					"blockSameTimeBookingByUser"					=> "`blockSameTimeBookingByUser`			INT(1) DEFAULT 0",
					"bookingVerificationCode"						=> "`bookingVerificationCode`				VARCHAR(20) DEFAULT 'false'",
					"bookingVerificationCodeToUser"					=> "`bookingVerificationCodeToUser`			VARCHAR(20) DEFAULT 'false'",
					"bookingReminder"								=> "`bookingReminder`						INT(11) DEFAULT 60",
					"insertConfirmedPage"							=> "`insertConfirmedPage`					INT(1) DEFAULT 0",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_templateSchedule';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"			=> "`key`			INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"	=> "`accountKey`	INT(11) NOT NULL",
					"weekKey"		=> "`weekKey`		INT(11) NOT NULL",
					"hour"			=> "`hour`			INT(11) NOT NULL",
					"min"			=> "`min`			INT(11) NOT NULL",
					"title" 		=> "`title`			VARCHAR(255) DEFAULT NULL",
					"cost"			=> "`cost`			INT DEFAULT NULL",
					"capacity"		=> "`capacity`		INT(11) NOT NULL",
					"deadlineTime"	=> "`deadlineTime`	INT(11) NOT NULL DEFAULT 0",
					"stop"			=> "`stop`			VARCHAR(255) DEFAULT NULL",
					"holiday"		=> "`holiday`		VARCHAR(255) DEFAULT NULL",
					"uploadDate"	=> "`uploadDate`	INT(11) DEFAULT NULL",
				),
			);
			
			          	
			$table_name = $wpdb->prefix.'booking_package_schedule';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"					=> "`key`					INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"			=> "`accountKey`			INT(11) NOT NULL",
					"unixTime"				=> "`unixTime`	    		INT(11) NOT NULL",
					"year"					=> "`year`		        	INT(11) NOT NULL",
					"month" 				=> "`month`		        	INT(11) NOT NULL",
					"day"					=> "`day`		        	INT(11) NOT NULL",
					"weekKey"				=> "`weekKey`		    	INT(11) NOT NULL",
					"hour"					=> "`hour`			    	INT(11) NOT NULL",
					"min"					=> "`min`			    	INT(11) NOT NULL",
					"title" 				=> "`title`			    	VARCHAR(255) DEFAULT NULL",
					"status" 				=> "`status`				VARCHAR(255) DEFAULT 'open'",
					"cost"					=> "`cost`			    	FLOAT DEFAULT NULL",
					"capacity"				=> "`capacity`		    	INT(11) NOT NULL",
					"remainder" 			=> "`remainder`		    	INT(11) NOT NULL",
					"deadlineTime"			=> "`deadlineTime`			INT(11) NOT NULL DEFAULT 0",
					"waitingRemainder"		=> "`waitingRemainder`		INT(11) NOT NULL DEFAULT 0",
					"stop"					=> "`stop`			    	VARCHAR(255) DEFAULT NULL",
					"holiday"				=> "`holiday`		    	VARCHAR(255) DEFAULT NULL",
					"uploadDate"			=> "`uploadDate`	    	INT(11) DEFAULT NULL",
					"expirationDateTrigger"	=> "`expirationDateTrigger` VARCHAR(255) DEFAULT 'dateBooked'",
					"expirationDateStatus"	=> "`expirationDateStatus`	INT(11) DEFAULT 0",
					"expirationDateFrom"	=> "`expirationDateFrom`	INT(11) DEFAULT 0",
					"expirationDateTo"		=> "`expirationDateTo`		INT(11) DEFAULT 0",
				),
			);
		                		        	
			$table_name = $wpdb->prefix.'booking_package_courseData';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"									=> "`key`					INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"							=> "`accountKey`			INT(11) NOT NULL",
					"name"									=> "`name`			    	VARCHAR(255) DEFAULT NULL",
					"description"							=> "`description`			TEXT DEFAULT NULL",
					"time"									=> "`time`			    	INT(11) DEFAULT NULL",
					"cost"									=> "`cost`			    	FLOAT DEFAULT NULL",
					"cost_1"								=> "`cost_1`		    	FLOAT DEFAULT NULL",
					"cost_2"								=> "`cost_2`		    	FLOAT DEFAULT NULL",
					"cost_3"								=> "`cost_3`		    	FLOAT DEFAULT NULL",
					"cost_4"								=> "`cost_4`		    	FLOAT DEFAULT NULL",
					"cost_5"								=> "`cost_5`		    	FLOAT DEFAULT NULL",
					"cost_6"								=> "`cost_6`		    	FLOAT DEFAULT NULL",
					"active"								=> "`active`		    	VARCHAR(255) DEFAULT NULL",
					"target"								=> "`target`				VARCHAR(255) DEFAULT 'visitors_users'", 
					"stopServiceUnderFollowingConditions"	=> "`stopServiceUnderFollowingConditions`	VARCHAR(255) DEFAULT 'doNotStop'", 
					"doNotStopServiceAsException"			=> "`doNotStopServiceAsException`			VARCHAR(255) DEFAULT 'hasNotException'", 
					"stopServiceForDayOfTimes"				=> "`stopServiceForDayOfTimes`				VARCHAR(255) DEFAULT 'timeSlot'", 
					"stopServiceForSpecifiedNumberOfTimes"	=> "`stopServiceForSpecifiedNumberOfTimes`	INT(11) DEFAULT 0", 
					"ranking"								=> "`ranking`		    	INT(11) NOT NULL",
					"selectOptions" 						=> "`selectOptions`			INT(11) DEFAULT 0",
					"options"								=> "`options`				TEXT DEFAULT NULL",
					"timeToProvide" 						=> "`timeToProvide` 		TEXT DEFAULT NULL",
					"expirationDateTrigger"					=> "`expirationDateTrigger` VARCHAR(255) DEFAULT 'dateBooked'",
					"expirationDateStatus"					=> "`expirationDateStatus`	INT(11) DEFAULT 0",
					"expirationDateFrom"					=> "`expirationDateFrom`	INT(11) DEFAULT 0",
					"expirationDateTo"						=> "`expirationDateTo`		INT(11) DEFAULT 0",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_guests';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"				=> "`key`				INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"		=> "`accountKey`		INT(11) NOT NULL",
					"name"				=> "`name`			    VARCHAR(255) DEFAULT NULL",
					"costInServices"	=> "`costInServices`	VARCHAR(255) DEFAULT 'cost_1'",
					"target"			=> "`target`			VARCHAR(255) DEFAULT 'adult'",
					"guestsInCapacity"	=> "`guestsInCapacity`	VARCHAR(255) DEFAULT 'included'",
					"reflectService"	=> "`reflectService`	INT(1) DEFAULT 0",
					"reflectAdditional"	=> "`reflectAdditional`	INT(1) DEFAULT 0",
					"json"				=> "`json`			    TEXT DEFAULT NULL",
					"ranking"			=> "`ranking`		    INT(11) NOT NULL",
					"required"			=> "`required`		    INT(1) DEFAULT 0",
					"description"		=> "`description`			TEXT DEFAULT NULL",
				),
			);
				
			$table_name = $wpdb->prefix.'booking_package_form';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"				=> "`key`				INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"		=> "`accountKey`		INT(11) NOT NULL",
					"data"				=> "`data`			    TEXT DEFAULT NULL",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_emailSetting';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"				=> "`key`				INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"		=> "`accountKey`		INT(11) NOT NULL",
					"mail_id"			=> "`mail_id`			VARCHAR(255) NOT NULL",
					"enable"			=> "`enable`			INT(1) DEFAULT 1",
					"enableSMS"			=> "`enableSMS`			INT(1) DEFAULT 0",
					"format"			=> "`format`			VARCHAR(255) DEFAULT 'text'",
					"subject"			=> "`subject`			VARCHAR(255) DEFAULT NULL",
					"content"			=> "`content`			TEXT DEFAULT NULL",
					"subjectForAdmin"	=> "`subjectForAdmin`	VARCHAR(255) DEFAULT NULL",
					"contentForAdmin"	=> "`contentForAdmin`	TEXT DEFAULT NULL",
					"data"				=> "`data`			    TEXT DEFAULT NULL",
				),
			);
			     	
			$table_name = $wpdb->prefix.'booking_package_userPraivateData';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"							=> "`key`				INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"reserveTime"					=> "`reserveTime`					INT(11) NOT NULL",
					"remainderTime" 				=> "`remainderTime`					INT(11) NULL",
					"remainderBool" 				=> "`remainderBool`					VARCHAR(255) DEFAULT 'false'",
					"maintenanceTime"				=> "`maintenanceTime`				INT(11) DEFAULT 0",
					"permission"					=> "`permission`					VARCHAR(255) DEFAULT 'private'",
					"status"						=> "`status`						VARCHAR(255) DEFAULT NULL",
					"type"							=> "`type`							VARCHAR(255) DEFAULT 'day'",
					"accountKey"					=> "`accountKey`					INT(11) NOT NULL",
					"accountName"					=> "`accountName`					VARCHAR(255) DEFAULT NULL",
					"accountCost"					=> "`accountCost`					INT(11) DEFAULT NULL",
					"checkIn"						=> "`checkIn`						INT(11) DEFAULT 0",
					"checkOut"						=> "`checkOut`						INT(11) DEFAULT 0",
					"scheduleUnixTime"				=> "`scheduleUnixTime`				INT(11) DEFAULT 0",
					"scheduleWeek"					=> "`scheduleWeek`					INT(11) DEFAULT 0",
					"scheduleTitle" 				=> "`scheduleTitle`					VARCHAR(255) DEFAULT NULL",
					"scheduleCost"					=> "`scheduleCost`					INT(11) DEFAULT NULL",
					"scheduleKey"					=> "`scheduleKey`					INT(11) DEFAULT NULL",
					"applicantCount"				=> "`applicantCount`				INT(11) DEFAULT 1",
					"courseKey" 					=> "`courseKey`						VARCHAR(255) DEFAULT NULL",
					"courseTitle"					=> "`courseTitle`					VARCHAR(255) DEFAULT NULL",
					"courseName"					=> "`courseName`					VARCHAR(255) DEFAULT NULL",
					"courseTime"					=> "`courseTime`					INT(11) DEFAULT NULL",
					"courseCost"					=> "`courseCost`					INT(11) DEFAULT NULL",
					"options"						=> "`options`						TEXT DEFAULT NULL",
					"tax"							=> "`tax`							INT(11) DEFAULT 0",
					"payMode"						=> "`payMode`						VARCHAR(255) DEFAULT NULL",
					"payId" 						=> "`payId`							VARCHAR(255) DEFAULT NULL",
					"payName"						=> "`payName`						VARCHAR(255) DEFAULT NULL",
					"payToken"						=> "`payToken`						VARCHAR(255) DEFAULT NULL",
					"currency"						=> "`currency`						VARCHAR(3) DEFAULT 'usd'",
					"praivateData"					=> "`praivateData`					TEXT DEFAULT NULL",
					"emails"						=> "`emails`						TEXT DEFAULT NULL",
					"accommodationDetails"			=> "`accommodationDetails`			TEXT DEFAULT NULL",
					"guests"						=> "`guests`						TEXT DEFAULT NULL",
					"iCalUIDforGoogleCalendar"		=> "`iCalUIDforGoogleCalendar`		VARCHAR(60) DEFAULT NULL",
					"iCalIDforGoogleCalendar"		=> "`iCalIDforGoogleCalendar`		VARCHAR(60) DEFAULT NULL",
					"resultOfGoogleCalendar"		=> "`resultOfGoogleCalendar`		INT(1) DEFAULT NULL",
					"resultModeOfGoogleCalendar"	=> "`resultModeOfGoogleCalendar`	VARCHAR(60) DEFAULT NULL",
					"cancellationToken"				=> "`cancellationToken`				VARCHAR(255) DEFAULT NULL",
					"permalink"						=> "`permalink`						TEXT DEFAULT NULL",
					"preparation"					=> "`preparation`					VARCHAR(255) DEFAULT NULL",
					"taxes"							=> "`taxes`							TEXT DEFAULT NULL",
					"user_id"						=> "`user_id`						INT(11) NULL",
					"user_login"					=> "`user_login`					VARCHAR(100) NULL",
					"couponKey"						=> "`couponKey`						VARCHAR(255) DEFAULT NULL",
					"coupon"						=> "`coupon`						TEXT DEFAULT NULL",
					"bookingReminder"				=> "`bookingReminder`				INT(11) DEFAULT 0",
				),
			);
			
			
			$table_name = $wpdb->prefix.'booking_package_webhook';
			$this->db_list[$table_name] = "CREATE TABLE ".$table_name." (
			                	        	`key`						INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
			                	        	`target`					VARCHAR(20) DEFAULT NULL,
			                	        	`server`					TEXT DEFAULT NULL, 
			                	        	`post`						TEXT DEFAULT NULL, 
			                	        	`json`						TEXT DEFAULT NULL, 
			                	        	`date`						INT(11) NOT NULL
											) $charset_collate;";
			
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "",
				"columns" => array(
					"key"		=> "`key`				INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"target"	=> "`target`					VARCHAR(20) DEFAULT NULL",
					"server"	=> "`server`					TEXT DEFAULT NULL",
					"post"		=> "`post`						TEXT DEFAULT NULL",
					"json"		=> "`json`						TEXT DEFAULT NULL",
					"date"		=> "`date`						INT(11) NOT NULL",
				),
			);
											
			$table_name = $wpdb->prefix.'booking_package_users';
			$this->db_list[$table_name] = "CREATE TABLE ".$table_name." (
			                	        	`key`						INT(11) NOT NULL PRIMARY KEY, 
			                	        	`status`					INT(1) DEFAULT NULL,
			                	        	`firstname`					VARCHAR(100) NOT NULL,
			                	        	`lastname`					VARCHAR(100) NOT NULL,
			                	        	`email`						VARCHAR(100) NOT NULL, 
			                	        	`value`						longtext DEFAULT NULL,
			                	        	`user_activation_key`		VARCHAR(100) DEFAULT '',
			                	        	`subscription_list`			longtext DEFAULT ''
											) $charset_collate;";
			
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "",
				"columns" => array(
					"key"					=> "`key`						INT(11) NOT NULL PRIMARY KEY",
					"user_login"			=> "`user_login`				VARCHAR(100) NOT NULL",
					"status"				=> "`status`					INT(1) DEFAULT NULL",
					"firstname" 			=> "`firstname`					VARCHAR(100) NOT NULL",
					"lastname"				=> "`lastname`					VARCHAR(100) NOT NULL",
					"email" 				=> "`email`						VARCHAR(100) NOT NULL",
					"value" 				=> "`value`						longtext DEFAULT NULL",
					"user_activation_key"	=> "`user_activation_key`		VARCHAR(100) DEFAULT ''",
					"subscription_list" 	=> "`subscription_list`			longtext DEFAULT ''",
					"user_registered"		=> "`user_registered`			VARCHAR(100) DEFAULT 0",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_regular_holidays';
			$this->db_list[$table_name] = "CREATE TABLE ".$table_name." (
			                	        	`key`						INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
			                	        	`accountKey`				VARCHAR(100) NOT NULL, 
			                	        	`day`						INT(2) DEFAULT NULL,
			                	        	`month`						INT(2) NOT NULL,
			                	        	`year`						INT(4) NOT NULL,
			                	        	`unixTime`					VARCHAR(100) NOT NULL, 
			                	        	`status`					VARCHAR(100) NOT NULL, 
			                	        	`update`					VARCHAR(100) DEFAULT ''
											) $charset_collate;";
            
            $this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "",
				"columns" => array(
					"key"			=> "`key`						INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"	=> "`accountKey`				VARCHAR(100) NOT NULL",
					"day"			=> "`day`						INT(1) DEFAULT NULL",
					"month" 		=> "`month`						INT(2) NOT NULL",
					"year"			=> "`year`						INT(4) NOT NULL",
					"unixTime"		=> "`unixTime`					VARCHAR(100) NOT NULL",
					"status"		=> "`status`					VARCHAR(100) NOT NULL",
					"update"		=> "`update`					VARCHAR(100) DEFAULT ''",
				),
			);
			/**
			$table_name = $wpdb->prefix.'booking_package_test';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "",
				"columns" => array(
					"key"			=> "`key`						INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"	=> "`accountKey`				VARCHAR(100) NOT NULL",
					"day"			=> "`day`						INT(1) DEFAULT NULL",
					"month" 		=> "`month`						INT(2) NOT NULL",
					"year"			=> "`year`						INT(4) NOT NULL",
				),
			);
            **/
            
            $table_name = $wpdb->prefix.'booking_package_subscriptions';
            $this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "",
				"columns" => array(
					"key"			=> "`key`					INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"	=> "`accountKey`			VARCHAR(100) NOT NULL",
					"name"			=> "`name`					VARCHAR(255) NOT NULL",
					"subscription" 	=> "`subscription`			VARCHAR(255) NOT NULL",
					"active"		=> "`active`				VARCHAR(255) DEFAULT NULL",
					"ranking"		=> "`ranking`				INT(11) DEFAULT 1",
					"renewal"		=> "`renewal`				INT(11) DEFAULT 1",
					"limit"			=> "`limit`					INT(11) DEFAULT 1",
					"numberOfTimes"	=> "`numberOfTimes`			INT(11) DEFAULT 1",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_taxes';
            $this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "",
				"columns" => array(
					"key"					=> "`key`					INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"			=> "`accountKey`			VARCHAR(100) NOT NULL",
					"name"					=> "`name`					VARCHAR(255) NOT NULL",
					"active"				=> "`active`				VARCHAR(255) DEFAULT NULL",
					"type" 					=> "`type`					VARCHAR(20) DEFAULT 'tax'",
					"tax" 					=> "`tax`					VARCHAR(20) DEFAULT 'tax_inclusive'",
					"method"				=> "`method`				VARCHAR(20) DEFAULT 'addition'",
					"target"				=> "`target`				VARCHAR(20) DEFAULT 'guest'",
					"scope"					=> "`scope`					VARCHAR(20) DEFAULT 'day'",
					"value"					=> "`value`					FLOAT DEFAULT 0",
					"ranking"				=> "`ranking`		    	INT(11) NOT NULL",
					"expirationDateTrigger"	=> "`expirationDateTrigger` VARCHAR(255) DEFAULT 'dateBooked'",
					"expirationDateStatus"	=> "`expirationDateStatus`	INT(11) DEFAULT 0",
					"expirationDateFrom"	=> "`expirationDateFrom`	INT(11) DEFAULT 0",
					"expirationDateTo"		=> "`expirationDateTo`		INT(11) DEFAULT 0",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_optionsForHotel';
            $this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "",
				"columns" => array(
					"key"					=> "`key`					INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"accountKey"			=> "`accountKey`			VARCHAR(100) NOT NULL",
					"name"					=> "`name`					VARCHAR(255) NOT NULL",
					"active"				=> "`active`				VARCHAR(255) DEFAULT NULL",
					"required" 				=> "`required`				INT(1) DEFAULT 0",
					"target" 				=> "`target`				VARCHAR(20) DEFAULT 'guests'",
					"chargeForAdults"		=> "`chargeForAdults`		FLOAT DEFAULT 0",
					"chargeForChildren"		=> "`chargeForChildren`		FLOAT DEFAULT 0",
					"chargeForRoom"			=> "`chargeForRoom`			FLOAT DEFAULT 0",
					"ranking"				=> "`ranking`		    	INT(11) NOT NULL",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_coupons';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"					=> "`key`					INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"id"					=> "`id`					VARCHAR(255) DEFAULT NULL",
					"name"					=> "`name`			    	VARCHAR(255) DEFAULT NULL",
					"active"				=> "`active`				INT(11) DEFAULT 1",
					"status"				=> "`status`				VARCHAR(20) DEFAULT 'active'",
					"value"					=> "`value`					FLOAT DEFAULT 0",
					"accountKey"			=> "`accountKey`			VARCHAR(100) NOT NULL",
					"method"				=> "`method`				VARCHAR(20) DEFAULT 'subtraction'",
					"target"				=> "`target`				VARCHAR(255) DEFAULT 'visitors'",
					"limited"				=> "`limited`				VARCHAR(255) DEFAULT 'unlimited'",
					"expirationDateStatus"	=> "`expirationDateStatus`	INT(11) DEFAULT 0",
					"expirationDateFrom"	=> "`expirationDateFrom`	INT(11) DEFAULT 0",
					"expirationDateTo"		=> "`expirationDateTo`		INT(11) DEFAULT 0",
					"description"			=> "`description`			TEXT DEFAULT NULL",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_blockList';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"					=> "`key`					INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"type"					=> "`type`					VARCHAR(255) DEFAULT 'email'",
					"value"					=> "`value`			    	VARCHAR(255) NOT NULL",
					"date"					=> "`date`					INT(11) NOT NULL",
				),
			);
			
			$table_name = $wpdb->prefix.'booking_package_error';
			$this->db_object[$table_name] = array(
				"table" => $table_name,
				"sql" => "CREATE TABLE ".$table_name." (%s) ".$charset_collate.";",
				"uniqueKey" => "UNIQUE KEY id (`key`)",
				"columns" => array(
					"key"					=> "`key`					INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT",
					"file"					=> "`file`					VARCHAR(255) DEFAULT NULL",
					"url"					=> "`url`			    	VARCHAR(255) NOT NULL",
					"line"					=> "`line`			    	INT(11) NOT NULL",
					"col"					=> "`col`			    	INT(11) NOT NULL",
					"code"					=> "`code`			    	VARCHAR(255) NOT NULL",
					"version"				=> "`version`			   	VARCHAR(255) NOT NULL",
					"browser"				=> "`browser`			   	VARCHAR(255) NOT NULL",
					"message"				=> "`message`			   	TEXT NOT NULL",
					"date"					=> "`date`					INT(11) DEFAULT NULL",
				),
			);
            
        }
        
        public function getTableList(){
        	
        	return $this->db_object;
        	
        }
        
        /**
        public function create(){
            
			foreach ((array) $this->db_list as $key => $sql) {
			    
			    dbDelta($sql);
			    
			}
			
			add_option($this->prefix."db_version", $this->db_version);
			
        }
        **/
        
        public function create(){
        	
        	global $wpdb;
        	$createdTables = array();
			$rows = $wpdb->get_results("SHOW TABLES;", ARRAY_N);
			for ($i = 0; $i < count($rows); $i++) {
				
				array_push($createdTables, $rows[$i][0]);
				
			}
			#var_dump($createdTables);
        	
        	foreach ((array) $this->db_object as $key => $value) {
        		
        		if (array_search($key, $createdTables) === false) {
        			
        			$columns = implode(",", array_values($value['columns']));
        			$sql = sprintf($value['sql'], $columns);
        			#var_dump($sql);
        			dbDelta($sql);
        			
        		} else {
        			
        			$columns = $this->getUncreateColumnsInTable($key, $value['columns']);
        			if(count($columns) > 0){
        				/**
        				$sql = sprintf($value['sql'], implode(",", $columns));
        				var_dump($sql);
        				dbDelta($sql);
        				**/
        				
        				for($i = 0; $i < count($columns); $i++){
        					
        					$sql = sprintf($value['sql'], $columns[$i]);
	        				dbDelta($sql);
        					
        				}
        				
        			}
        			
        		}
        		
        	}
        	
        	add_option($this->prefix."db_version", $this->db_version);
        	
        }
        
        public function getUncreateColumnsInTable($table_name, $columns){
        	
        	global $wpdb;
        	$createdColumns = array();
			$rows = $wpdb->get_results("SHOW COLUMNS FROM `".$table_name."`;", ARRAY_N);
			for($i = 0; $i < count($rows); $i++){
				
				$key = $rows[$i][0];
				array_push($createdColumns, $key);
				if(isset($columns[$key])){
					
					unset($columns[$key]);
					
				}
				
			}
			return array_values($columns);
        	
        }
        
        public function uninstall($delete = true){
        	
        	if ($delete === false) {
        		
        		return false;
        		
        	}
        	
        	global $wpdb;
        	$tableList = $this->getTableList();
        	foreach ((array) $tableList as $key => $value) {
				
				$wpdb->query("DROP TABLE `".$key."`;");
				
			}
			
			delete_option($this->prefix."db_version");
        	
        }
        
    }
?>