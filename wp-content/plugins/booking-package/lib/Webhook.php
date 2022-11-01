<?php
    if(!defined('ABSPATH')){
    	exit;
	}
	
	class booking_package_webhook {
        
        public $prefix = null;
        
        public $pluginName = null;
        
        public $setting = null;
        
        public $schedule = null;
        
        public function __construct($prefix, $pluginName) {
            
            $this->prefix = $prefix;
            $this->pluginName = $pluginName;
            $this->setting = new booking_package_setting($prefix, $pluginName);
            $this->schedule = new booking_package_schedule($prefix, $pluginName);
            
        }
        
        public function catchWebhook($target, $server, $post, $body = false){
            
            global $wpdb;
            
            /** accountKey **/
            $accountKey = 1;
            
            $timeMin = date('U') - (7 * 24 * 60 * 60);
            $schedule = $this->schedule;
            $setting = $this->setting;
            $list = array();
            $eventList = array();
            $calendarAccountList = array();
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			#$sql = $wpdb->prepare("SELECT `key`,`googleCalendarID` FROM `".$table_name."`;", array());
			$rows = $wpdb->get_results("SELECT `key`,`googleCalendarID` FROM `".$table_name."`;", ARRAY_A);
			foreach($rows as $row){
				
				$calendarAccountList[$row['googleCalendarID']] = $row['key'];
				$list = array_merge($list, $schedule->getUserList($timeMin, $row['key']));
				$eventList = array_merge($eventList, $setting->listsGC($row['key'], $row['googleCalendarID'], $timeMin));
				
			}
            
            
            
            #$eventList = $setting->listsGC($timeMin);
            #var_dump($eventList);
            if(is_null($eventList)){
                
                return null;
                
            }
            
            
            
            $timezone = get_option('timezone_string');
            date_default_timezone_set($timezone);
            
            
			#$list = $schedule->getUserList($timeMin, $accountKey);
			$userLists = array();
			for($i = 0; $i < count($list); $i++){
			    
			    $key = $list[$i]["iCalIDforGoogleCalendar"];
			    $userLists[$key] = $list[$i];
			    
			}
			
			
			#var_dump($calendarAccountList);
			$googleCalendarID = null;
			foreach($eventList as $key => $value){
			    
			    $calendarAccount = array();
			    if(isset($calendarAccountList[$value['googleCalendarID']])){
			        
			        $accountKey = $calendarAccountList[$value['googleCalendarID']];
			        $calendarAccount = $schedule->getCalendarAccount($accountKey);
			        $googleCalendarID = $value['googleCalendarID'];
			        
			    }else{
			        
			        continue;
			        
			    }
			    
			    #print "iCalIDforGoogleCalendar = ".$key."<br>";
			    $iCalIDforGoogleCalendar = $key;
			    $timeStart = date( "U", strtotime($value["timeStart"]));
			    $timeEnd = date( "U", strtotime($value["timeEnd"]));
			    
			    $accommodationDetails = array();
			    
			    if(isset($userLists[$key])){
			        
			        #print "check update<br>";
			        $id = $userLists[$key]['key'];
			        $applicantCount = $userLists[$key]['applicantCount'];
			        $accommodationDetails = json_decode($userLists[$key]['accommodationDetails'], true);
			        $description = $eventList[$key]['description'];
			        $bookingTimeStart = $userLists[$key]["scheduleUnixTime"];
			        $bookingTimeEnd = $userLists[$key]["scheduleUnixTime"] + (intval($userLists[$key]["courseTime"]) * 60);
			        
			        if($calendarAccount['type'] == 'hotel'){
			            
			            #var_dump($value);
			            $bookingTimeStart = $userLists[$key]["checkIn"];
			            $bookingTimeEnd = $userLists[$key]["checkOut"] - (1440 * 60);
			            
			            /**
			            $timeStart = date('U', mktime(0, 0, 0, date('n', $timeStart), date('j', $timeStart), date('Y', $timeStart)));
			            $timeEnd = date('U', mktime(0, 0, 0, date('n', $timeEnd), date('j', $timeEnd), date('Y', $timeEnd))) - (1440 * 60);
			            **/
			            
			            if(!is_null($value['dateStart']) && !is_null($value['dateEnd'])){
			                
			                $dateStartParse = date_parse($value['dateStart']);
			                $dateEndParse = date_parse($value['dateEnd']);
			                $timeStart = date('U', mktime(0, 0, 0, $dateStartParse['month'], $dateStartParse['day'], $dateStartParse['year']));
			                $timeEnd = date('U', mktime(0, 0, 0, $dateEndParse['month'], $dateEndParse['day'], $dateEndParse['year'])) - (1440 * 60);
			                
			            }else{
			                
			                $timeStart = date('U', mktime(0, 0, 0, date('n', $timeStart), date('j', $timeStart), date('Y', $timeStart)));
			                $timeEnd = date('U', mktime(0, 0, 0, date('n', $timeEnd), date('j', $timeEnd), date('Y', $timeEnd))) - (1440 * 60);
			                
			            }
			            
			            if($bookingTimeStart != $timeStart || $bookingTimeEnd != $timeEnd){
                            
                            #print $bookingTimeStart." ".$timeStart." - ".$bookingTimeEnd." ".$timeEnd."<br>";
                            $scheduleResponse = $schedule->serachSchedule($timeStart, $accountKey);
			                if($scheduleResponse['status'] != "error"){
			                    
			                    $accommodationDetails['list'][(string) $timeStart] = $scheduleResponse;
			                    
			                }
			                
                            $scheduleResponse = $schedule->serachSchedule($timeEnd, $accountKey);
                            if($scheduleResponse['status'] != "error"){
                                
                                $accommodationDetails['list'][(string) $timeEnd] = $scheduleResponse;
                            
                            }
                            
                            #$guestsList = $setting->getGuestsList($accountKey, true);
                            $guestsList = $accommodationDetails['guestsList'];
                            #var_dump($guestsList);
                            foreach($guestsList as $guestsKey => $guestsValue){
                                
                                for($i = 0; $i < count($guestsValue['json']); $i++){
                                    
                                    if($guestsValue['json'][$i]['selected'] == 1){
                                        
                                        $accommodationDetails['guestsList'][$guestsValue['key']] = $guestsValue['json'][$i];
                                        
                                    }
                                    
                                }
                                
                            }
                            
                            $accommodationDetails = $schedule->createAccommodationDetails($calendarAccount, $accommodationDetails, $timeStart, $applicantCount, $accommodationDetails);
                            unset($accommodationDetails['list']);
                            #$bookingTimeEnd += 1440 * 60;
                            $timeEnd++;
                            #var_dump($accommodationDetails);
                            #var_dump($userLists[$key]);
                            
			            }
                        
			        }
			        
			        $form = $userLists[$key]["praivateData"];
			        #print "bookingTimeStart = ".$bookingTimeStart."<br>";
			        #print "bookingTimeEnd = ".$bookingTimeEnd."<br>";
			        
			        if(intval($userLists[$key]['resultOfGoogleCalendar']) != 0){
			            
			            $update = $this->prepareFrom("update", $id, $eventList[$key]['name'], $eventList[$key]['address'], $eventList[$key]['description'], json_decode($form, true));
			            if($bookingTimeStart != $timeStart || $bookingTimeEnd != $timeEnd){
			                
                            $response = $schedule->changeBookingTime("update", $id, $userLists[$key]["scheduleKey"], $userLists[$key]["status"], $userLists[$key]['applicantCount'], $timeStart, $timeEnd, $bookingTimeStart, $bookingTimeEnd, $accommodationDetails, $accountKey);
                            if($response['event'] == 'return'){
                                
                                $setting->pushGC('update', $accountKey, $calendarAccount['type'], $id, $googleCalendarID, $bookingTimeStart, $bookingTimeEnd, json_decode($form), $key);
                                
                            }
                            
                        }
                        
                    }
			        
			        unset($userLists[$key]);
			        
			    }else{
			        
			        $googleCalendarIDofVisitor = $schedule->serachGoogleCalendarIdOfVisitor($iCalIDforGoogleCalendar);
			        if($googleCalendarIDofVisitor != false){
			            
			            continue;
			            
			        }
			        
			        if($calendarAccount['type'] == 'hotel'){
			            
			            #var_dump($value);
			            if(!is_null($value['dateStart']) && !is_null($value['dateEnd'])){
			                
			                $dateStartParse = date_parse($value['dateStart']);
			                $dateEndParse = date_parse($value['dateEnd']);
			                $timeStart = date('U', mktime(0, 0, 0, $dateStartParse['month'], $dateStartParse['day'], $dateStartParse['year']));
			                $timeEnd = date('U', mktime(0, 0, 0, $dateEndParse['month'], $dateEndParse['day'], $dateEndParse['year'])) - (1440 * 60);
			                
			            }else{
			                
			                $timeStart = date('U', mktime(0, 0, 0, date('n', $timeStart), date('j', $timeStart), date('Y', $timeStart)));
			                $timeEnd = date('U', mktime(0, 0, 0, date('n', $timeEnd), date('j', $timeEnd), date('Y', $timeEnd))) - (1440 * 60);
			            
			                
			            }
			            
			            
			            $scheduleResponse = $schedule->serachSchedule($timeStart, $accountKey);
			            if($scheduleResponse['status'] != "error"){
                            
			                $accommodationDetails['list'][(string) $timeStart] = $scheduleResponse;
                            
                        }else{
                            
                            $setting->deleteGC($accountKey, $iCalIDforGoogleCalendar, $googleCalendarID);
                            continue;
                            
                        }
                        $scheduleResponse = $schedule->serachSchedule($timeEnd, $accountKey);
                        if($scheduleResponse['status'] != "error"){
                            
                            $accommodationDetails['list'][(string) $timeEnd] = $scheduleResponse;
                            
                        }else{
                            
                            $setting->deleteGC($accountKey, $iCalIDforGoogleCalendar, $googleCalendarID);
                            continue;
                            
                        }
                        
                        $guestsList = $setting->getGuestsList($accountKey, true);
                        foreach($guestsList as $guestsKey => $guestsValue){
                            
                            #$guestsJson = json_decode($guestsValue['json'], true);
                            $accommodationDetails['guestsList'][$guestsValue['key']] = $guestsJson[0];
                            
                        }
                        
                        $accommodationDetails = $schedule->createAccommodationDetails($calendarAccount, $accommodationDetails, $timeStart, $applicantCount, null);
                        unset($accommodationDetails['list']);
                        $schedule->setAccommodationDetails($accommodationDetails);
                        
			            
			        }
			        
			        
			        
			        $bookingSchedule = $schedule->serachSchedule($timeStart, $accountKey);
			        if($bookingSchedule['status'] != 'error' && $bookingSchedule['stop'] == 'false'){
			            
			            $applicantCount = 1;
			            $time = ($timeEnd - $timeStart) / 60;
			            $course = $this->prepareCourses($time, $accountKey);
			            /** $course arrays exchange to $courseKey, $courseName, $courseTime, $courseCost. **/
			            extract($course, EXTR_SKIP);
			            
			            $bool = $schedule->changeBookingTime("insert", null, null, null, $applicantCount, $timeStart, $timeEnd, null, null, $accommodationDetails, $accountKey);
			            if($bool === true){
			                
			                $form = json_encode($setting->getForm($accountKey));
			                $form = $this->prepareFrom("insert", $id, $eventList[$key]['name'], $eventList[$key]['address'], $eventList[$key]['description'], json_decode($form, true));
			                
			                $table_name = $wpdb->prefix."booking_package_schedule";
    		                $sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) ORDER BY `unixTime` ASC ;";
			                $values = array(intval($accountKey), intval($timeStart), intval($timeEnd));
			                if($timeStart == $timeEnd){
				                
				                $sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `unixTime` = %d;";
				                $values = array(intval($accountKey), intval($timeStart));
				                
			                }
			                
			                if($calendarAccount['type'] == 'hotel'){
			                    
			                    $sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) ORDER BY `unixTime` ASC ;";
			                    $values = array(intval($accountKey), intval($timeStart), intval($timeEnd));
			                    
			                }
			                
			                $currency = get_option($this->prefix."currency", 'usd');
			                $status = $schedule->getStatus();
			                $schedule->updateRemainderSeart("increase", $sql, $values, $applicantCount);
			                $lastID = $schedule->insertPrivateData(date('U'), 'google', $status, $bookingSchedule['key'], $bookingSchedule['unixTime'], $bookingSchedule['title'], $bookingSchedule['cost'], $courseKey, $courseName, $courseTime, $courseCost, $form, $currency, null, null, $accountKey, $applicantCount);
			                $schedule->updateICalIDforGoogleCalendar($lastID, $iCalIDforGoogleCalendar);
					        
			            }else{
			                
			                /** Delete events sent from Google Calendar. **/
			                #var_dump("Delete events sent from Google Calendar.");
			                $setting->deleteGC($accountKey, $iCalIDforGoogleCalendar, $googleCalendarID);
			                
			            }
			            
			        }else{
			            
			            $setting->deleteGC($accountKey, $iCalIDforGoogleCalendar, $googleCalendarID);
			            #print "Google Calendar から送られてきたイベントを削除<br>";
			            
			        }
			        
			    }
			    
			    #print "<hr>";
			    
			}
			
			foreach($userLists as $key => $value){
			    
			    $schedule->deleteBookingData($value['key'], false);
			    #var_dump($value);
			    
			}
            
            
        }
        
        public function prepareCourses($time, $accountKey){
            
            $schedule = $this->schedule;
            $response = array('courseKey' => null, 'courseName' => null, 'courseTime' => null, 'courseCost' => null);
            $course = $schedule->serachCourse($accountKey, false, $time);
            if($course['status'] != 'error'){
                
                $response['courseKey'] = $course['key'];
                $response['courseName'] = $course['name'];
                $response['courseTime'] = $course['time'];
                $response['courseCost'] = $course['cost'];
                
            }else if($time != 0){
                
                $response['courseKey'] = "exception";
                $response['courseName'] = $time." min";
                $response['courseTime'] = $time;
                $response['courseCost'] = null;
                
            }
            
            return $response;
            
        }
        
        public function prepareFrom($mode, $id, $name, $address, $description, $form){
            
            $name = preg_replace("/　/", " ", $name);
            $address = preg_replace("/　/", " ", $address);
            $descriptionList = explode('<br>', $description);
            #var_dump($name);
            #var_dump($address);
            
            $nameList = array();
            $addressList = array();
            foreach($form as $key => $value){
                
                if($value['isName'] == 'true' && $value['active'] == 'true'){
                	
                	array_push($nameList, $value['value']);
                	
                }
                
                if($value['isAddress'] == 'true' && $value['active'] == 'true'){
                	
                	array_push($addressList, $value['value']);
                	
                }
                
            }
            
            $update = false;
            if($name != implode(' ', $nameList)){
            	
            	$form = $this->prepareValues($name, 'isName', count($nameList), $form);
            	$update = true;
            	
            }
            
            if($address != implode(' ', $addressList)){
            	
            	$form = $this->prepareValues($address, 'isAddress', count($addressList), $form);
            	$update = true;
            	
            }
            
            if($mode == 'update'){
                
                if($update === true){
            	    
                    $schedule = $this->schedule;
                    $schedule->updatePraivateData($id, $form);
            	    
                }
                
                return $update;
                
            }else{
                
                return $form;
                
            }
            
        }
        
        public function prepareValues($values, $isKey, $count, $form){
        	
			$valueList = explode(' ', $values);
            $i = $count;
            foreach($form as $key => $value){
            	
            	if($value[$isKey] == 'true' && $value['active'] == 'true'){
            		
            		$i--;
            		if($i == 0){
            			
            			$form[$key]['value'] = implode(' ', $valueList);
            			break;
            			
            		}else{
            			
            			$form[$key]['value'] = array_shift($valueList);
            			
            		}
            		
            	}
            	
            }        	
        	
        	return $form;
        	
        }
        
        
    }

?>