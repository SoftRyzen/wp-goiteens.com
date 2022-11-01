<?php
    if (!defined('ABSPATH')) {
    	exit;
	}
    
    class booking_package_schedule {
        
        public $prefix = null;
        
        public $pluginName = null;
        
        public $phpVersion = 0;
        
        public $automaticApprove = false;
        
        public $targetSchedules = 0;
        
        public $bookingVerificationCode = 0;
        
        public $userRoleName = null;
        
        private $isExtensionsValid = null;
        
        public function __construct($prefix, $pluginName, $userRoleName = 'booking_package_user'){
            
            global $wpdb;
            $this->prefix = $prefix;
            $this->pluginName = $pluginName;
            $this->phpVersion = floatval(phpversion());
            $this->accommodationDetails = null;
            $this->userRoleName = $userRoleName;
            #$this->setting = new booking_package_setting($this->prefix, $this->pluginName);
            
        }
		
		public function getPhpVersion() {
			
			$version = explode('.', phpversion());
			$php = intval($version[0] . $version[1]);
			return $php;
			
		}
		
		public function getTimestamp(){
			
			$timestamp = array(
				'unixTime' => date('U'),
				'F' => __(date('F'), $this->pluginName),
				'm' => date('m'),
				'n' => date('n'),
				'd' => date('d'),
				'j' => date('j'),
				'Y' => date('Y'),
				'date' => date('Ymd'),
			);
			
			return $timestamp;
		}
		
		public function setAccommodationDetails($accommodationDetails){
			
			$this->accommodationDetails = $accommodationDetails;
			
		}
        
		public function getAccommodationDetails(){
			
			return $this->accommodationDetails;
			
		}
		
		public function get_coupons($offset, $number = null) {
			
			
			return array();
			
		}
        
        public function createUser($administrator = 0, $accountKey = null) {
			
			if ($administrator == 0) {
				
				if (!isset($_POST['googleReCaptchaToken'])) {
					
					$_POST['googleReCaptchaToken'] = '';
					
				}
				$result = $this->verifyGoogleReCaptchaToken($_POST['googleReCaptchaToken']);
				if ($result['status'] === false) {
					
					$this->cancelPayment();
					$result['status'] = 'error';
					return $result;
					
				}
				
				if (!isset($_POST['hCaptcha'])) {
					
					$_POST['hCaptcha'] = '';
					
				}
				$result = $this->verifyHCaptcha($_POST['hCaptcha']);
				if ($result['status'] === false) {
					
					$this->cancelPayment();
					$result['status'] = 'error';
					return $result;
					
				}
				
			}
			
			$isExtensionsValid = $this->getExtensionsValid(false);
			if ($isExtensionsValid === false) {
				
				$response['status'] = 'error';
				$response['error_messages'] = __("Member related functions are not available", $this->pluginName);
				return $response;
				
			}
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_users";
			#$activation = intval(get_option($this->prefix."activation_user", 0));
			$activation = 0;
			
			if ($administrator == 0) {
				
				#$this->logout();
				/**
				if ($this->bookingVerificationCode == 0) {
					
					if (intval(get_option($this->prefix."check_email_for_member", 0)) == 0) {
						
						$activation = 1;
						
					}
					
				} else {
					
					$activation = 1;
					
				}
				**/
				$activation = 1;
				
			} else {
				
				$activation = 1;
				
			}
			
			
			$response = array("status" => "success", "activation" => $activation);
			#$user_login = username_exists($_POST['user_login']);
			$user_pass = trim($_POST['user_pass']);
			$userdata = array(
				'user_login' => $_POST['user_login'],
				'user_pass' => $user_pass,
				'user_email' => $_POST['user_email'],
				'role' => $this->userRoleName,
			);
			
			ob_start();
			$user_id = wp_insert_user($userdata);
			ob_get_clean();
			$type = gettype($user_id);
			if (is_wp_error($user_id)) {
				
				$response['status'] = 'error';
				$response['step'] = 1;
				$response['error_messages'] = $user_id->get_error_message();
				
			} else {
				
				if ($administrator == 0) {
					
					$this->logout();
					
				}
				
				update_user_meta($user_id, 'show_admin_bar_front', 'false');
				$hash = wp_hash(sanitize_text_field($_POST['user_email']).sanitize_text_field($_POST['user_login']).date('U'));
				$response['user_id'] = $user_id;
				$this->add_user($user_id, $_POST['user_login'], $_POST['user_email'], $activation, $hash);
				
				if ($activation == 1) {
					
					$userdata = array(
						'user_login' => $_POST['user_login'],
						'user_password' => $user_pass,
						'remember' => true
					);
					
					if ($administrator == 0) {
						
						$user = wp_signon($userdata, true);
						if (is_wp_error($user)) {
							
							$response['status'] = 'error';
							$response['step'] = 2;
							$response['error_messages'] = $user->get_error_message();
							
						}
						
					}
					
				} else {
					
					$uri = $_POST['permalink']."?mode=activation&k=".$hash."&u=".sanitize_text_field($_POST['user_login']);
					$subject = get_option($this->prefix."subject_email_for_member", "No title");
					$body = get_option($this->prefix."body_email_for_member", "No message");
					/**
					if (preg_match('/(\[activation_url\])/', $body, $matches)) {
						
						$body = preg_replace('/(\[activation_url\])/', $uri, $body);
						
					} else {
						
						$body = $uri."\n".$body;
						
					}
					**/
					$body = str_replace('[activation_url]', $uri, $body);
					$this->sendMail(sanitize_text_field($_POST['user_email']), $subject, $body, 'text', $accountKey);
					
				}
				
			}
			
			return $response;
			
        }
		
		public function setActivationUser($user_activation_key, $user_login, $activation = 0){
			
			$user = get_user_by('login', $user_login);
			$id = null;
			if (isset($user->ID)) {
				
				$id = $user->ID;
				
			} else {
				
				return array('status' => 'error', 'mode' => 'notFound', "message" => __("Your information could not be found.", $this->pluginName));
				
			}
			
			global $wpdb;
			$table_name = $wpdb->prefix . "booking_package_users";
			$sql = $wpdb->prepare(
				"SELECT `status` FROM `" . $table_name . "` WHERE `key` = %d AND `user_activation_key` = %s;", 
				array(intval($id), sanitize_text_field($user_activation_key))
			);
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				return array('status' => 'error', 'mode' => 'notFound', "message" => __("Your information could not be found.", $this->pluginName));
				
			} else {
				
				if (intval($row['status']) == 0) {
					
					$bool = $wpdb->update( 
		        		$table_name,
						array(
							'status' => 1, 
						),
						array('key' => intval($id)),
						array('%d'),
						array('%d')
					);
					
					do_action('booking_package_activation_user', $id);
					return array('status' => 'success', 'id' => $id, 'user_login' => $user_login);
					
				} else {
					
					return array('status' => 'error', 'mode' => 'approved', "message" => __("You have already been approved.", $this->pluginName));
					
				}
				
			}
			#var_dump($row);
        	
        }
        
        
        public function updateUser($administrator, $accountKey){
			
			$isExtensionsValid = $this->getExtensionsValid(false);
			if ($isExtensionsValid === false) {
				
				$response['status'] = 'error';
				$response['error_messages'] = __("Member related functions are not available", $this->pluginName);
				return $response;
				
			}
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_users";
			$response = array("status" => "error");
			$userId = 0;
			
			$user = get_user_by('login', sanitize_text_field($_POST['user_login']));
			$response['user'] = $user;
			if ($user === false) {
				
				return $response;
				
			} else {
				
				$userId = $user->ID;
				$userOldEmail = $user->user_email;
				
			}
			
			if (intval($userId) == 0) {
				
				$response['message'] = "error login";
				return $response;
				
			} else {
				
				$login = 0;
				$status = 1;
				$hash = 0;
				$userdata = array('ID' => $userId);
				if (isset($_POST['user_email'])) {
					
					$userdata['user_email'] = $_POST['user_email'];
					$hash = wp_hash(sanitize_text_field($_POST['user_email']).sanitize_text_field($_POST['user_login']).date('U'));
					/**
					if ($userOldEmail != $_POST['user_email']) {
						
						$status = 0;
						
					}
					**/
				} else {
					
					$hash = wp_hash(sanitize_text_field($userOldEmail).sanitize_text_field($_POST['user_login']).date('U'));
					
				}
				
				if (isset($_POST['user_pass'])) {
					
					$login = 1;
					$userdata['user_pass'] = $_POST['user_pass'];
					
				}
				
				$user = wp_update_user($userdata);
				if (is_wp_error($user)) {
					
					$response['message'] = "error update";
					return $response;
					
				} else {
					
					if ($administrator == 1) {
						
						#$status = 1;
						$status = intval($_POST['status']);
						
					}
					
					$bool = $this->update_profile($userId, $_POST['user_email'], $status, $hash);
					
					/**
					if ($status == 0 && $administrator == 0) {
						
						$this->logout();
						
						$uri = $_POST['permalink']."?mode=activation&k=".$hash."&u=".sanitize_text_field($_POST['user_login']);
						$subject = get_option($this->prefix."subject_email_for_member", "No title");
						$body = get_option($this->prefix."body_email_for_member", "No message");
						if (preg_match('/(\[activation_url\])/', $body, $matches)) {
							
							$body = preg_replace('/(\[activation_url\])/', $uri, $body);
							
						} else {
							
							$body = $uri."\n".$body;
							
						}
						$this->sendMail(sanitize_text_field($_POST['user_email']), $subject, $body, 'text', $accountKey);
						
					}
					**/
					
					if ($login == 1) {
						
						$userdata = array(
							'user_login' => $_POST['user_login'],
							'user_password' => $_POST['user_pass'],
							'remember' => true
						);
						
					}
					
					$response['status'] = 'success';
					$response['login'] = $status;
					return $response;
					
				}
        		
        	}
        	
        }
        
        public function update_profile($userId, $email, $status, $hash = null){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_users";
        	$bool = $wpdb->update( 
        		$table_name,
				array(
					'email' => sanitize_text_field($email), 
					'status' => $status,
					'user_activation_key' => $hash,
				),
				array('key' => intval($userId)),
				array('%s', '%d', '%s'),
				array('%d')
			);
			
			do_action('booking_package_update_profile', $userId);
			return $bool;
        	
        }
        
        public function update_email($userId){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_users";
			$user = get_user_by('id', intval($userId));
			$bool = $wpdb->update( 
				$table_name,
				array(
					'email' => sanitize_text_field($user->user_email), 
				),
				array('key' => intval($userId)),
				array('%s'),
				array('%d')
			);
			do_action('booking_package_update_email', $userId);
			
        }
        
        public function get_users($authority, $offset, $number = null, $search = null){
			
			global $wpdb;
			if ($offset < 0) {
				
				$offset = 0;
				
			}
			
			$limit = get_option($this->prefix."read_member_limit");
			if ($limit === false) {
				
				add_option($this->prefix."read_member_limit", intval($number));
				
			} else {
				
				update_option($this->prefix."read_member_limit", intval($number));
				
			}
			
			$role = $this->userRoleName;
			if ($authority == 'subscriber') {
				
				$role = 'subscriber';
				
			} else if ($authority == 'contributor') {
				
				$role = 'contributor';
				
			}
			
        	if (!isset($_POST['keywords'])) {
        		
        		$args = array(
	        		'role' => $role,
	        		'orderby' => 'ID',
	        		'order' => 'ASC',
	        		'offset' => intval($offset),
	        		'number' => intval($number),
	        		'fields' => array('ID', 'user_login', 'user_email', 'user_registered'),
	        	);
	        	
	        	if (!is_null($search)) {
	        		$args['search'] = $search;
	        	}
	        	
	        	$users = get_users($args);
	        	$table_name = $wpdb->prefix."booking_package_users";
	        	foreach ((array) $users as $key => $user) {
	        		
		        	$sql = $wpdb->prepare(
		        		"SELECT `key`, `status`, `user_login`, `subscription_list` FROM `".$table_name."` WHERE `email` = %s;", 
		        		array(sanitize_text_field($user->user_email))
		        	);
					$row = $wpdb->get_row($sql, ARRAY_A);
					if (empty($row)) {
						
						$this->add_user($user->ID, $user->user_login, $user->user_email, 1, null);
						$user->status = '1';
						#continue;
						
					} else {
						
						$user->status = $row['status'];
						
					}
					
					
					#$user->subscription_list = $this->get_subscription_list_of_user($user->ID);
					if (empty($row['user_login']) || empty($row['user_registered'])) {
						
						$bool = $wpdb->update( 
							$table_name,
							array(
								'user_login' => $user->user_login, 
								'user_registered' => $user->user_registered,
							),
							array('key' => intval($row['key'])),
							array('%s', '%s'),
							array('%d')
						);
						
					}
	        		
	        	}
        		
        	} else {
        		
        		$queryList = array();
        		$valueList = array();
        		$keywords = $_POST['keywords'];
        		if (function_exists('mb_convert_kana')) {
        			
        			$keywords = preg_replace('/( |　)/', ' ', mb_convert_kana($keywords, 'a', 'UTF-8'));
        			
        		}
        		
        		$keywords = stripslashes($keywords);
        		$keywords = explode(' ', sanitize_text_field($keywords));
        		for ($i = 0; $i < count($keywords); $i++) {
        			
        			array_push($queryList, "`user_login` LIKE '%%%s%%'");
        			array_push($queryList, "`email` LIKE '%%%s%%'");
        			array_push($queryList, "`value` LIKE '%%%s%%'");
        			array_push($valueList, $keywords[$i]);
        			array_push($valueList, $keywords[$i]);
        			$word = rtrim(ltrim(json_encode($keywords[$i]), '"'), '"');
        			$word = str_replace('\\', '%\\', $word);
        			array_push($valueList, $word);
        			
        		}
        		
        		if (intval($_POST['offset']) < 0) {
        			
        			$_POST['offset'] = 0;
        			
        		}
        		
        		array_push($valueList, intval($_POST['offset']));
        		array_push($valueList, intval($_POST['number']));
        		
        		$table_name = $wpdb->prefix."booking_package_users";
        		#$sql = "SELECT `email`, `status`, `subscription_list` FROM `".$table_name."` WHERE " . implode(" OR ", $queryList) . ";";
        		$sql = $wpdb->prepare(
	        		"SELECT `key` AS `ID`, `user_login`, `email` AS `user_email`, `status`, `subscription_list`, `user_registered` FROM `".$table_name."` WHERE " . implode(' OR ', $queryList) . " LIMIT %d, %d;", 
	        		$valueList
	        	);
	        	
	        	if (isset($_POST['meta']) && intval($_POST['meta']) == 1) {
	        		
	        		$sql = $wpdb->prepare(
		        		"SELECT `key` AS `ID`, `user_login`, `email` AS `user_email`, `status`, `subscription_list`, `user_registered`, `value` FROM `".$table_name."` WHERE " . implode(' OR ', $queryList) . " LIMIT %d, %d;", 
		        		$valueList
		        	);
	        		
	        	}
	        	
	        	$rows = $wpdb->get_results($sql, ARRAY_A);
	        	return $rows;
	        	#return array("sql" => $sql, "row" => $row);
        		
        	}
        	
        	
        	
        	return $users;
        	
        }
        
        public function login($userId, $statusCheck = true) {
			
			$isExtensionsValid = $this->getExtensionsValid(false);
			if ($isExtensionsValid === false) {
				
				return 0;
				
			}
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_users";
			$sql = $wpdb->prepare(
				"SELECT `value`,`status` FROM `".$table_name."` WHERE `key` = %d;", 
				array(intval($userId))
			);
			$row = $wpdb->get_row($sql, ARRAY_A);
			$value = 0;
			
			if (!empty($row) && intval($row['status']) == 1) {
				
				$value = json_decode($row['value'], true);
				#update_user_meta($userId, 'show_admin_bar_front', 'true');
				if (empty($value)) {
					
					$value = array();
					
				}
				
			} else {
				
				$value = 0;
				if ($statusCheck === false && !empty($row)) {
					
					$value = json_decode($row['value'], true);
					#update_user_meta($userId, 'show_admin_bar_front', 'true');
					
				}
				
			}
			
        	return $value;
        	
        }
        
        public function add_user($userId, $user_login, $email, $activation, $hash = null){
			
			if (is_null($hash)) {
				
				$hash = wp_hash(sanitize_text_field($email).sanitize_text_field($userId).date('U'));
				
			}
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_users";
			$wpdb->insert(
				$table_name, 
				array(
					'key' => $userId, 
					'status' => intval($activation),
					'user_login' => sanitize_text_field($user_login),
					'firstname' => "", 
					'lastname' => "", 
					'email' => sanitize_text_field($email),
					'value' => json_encode(array()),
					'user_activation_key' => $hash
				), 
				array('%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s')
			);
			
			do_action('booking_package_add_user', $userId);
        	
        }
        
        public function find_users($userId, $activation, $create = false){
			
			global $wpdb;
			$status = true;
			$table_name = $wpdb->prefix . "booking_package_users";
			$sql = $wpdb->prepare("SELECT `value`,`status` FROM `" . $table_name . "` WHERE `key` = %d;", array(intval($userId)));
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				if ($create === true) {
					
					$user = get_user_by('id', $userId);
					#var_dump($user->user_email);
					$this->add_user($userId, $user->user_login, $user->user_email, $activation);
					
				}
				
			} else {
				
				if (intval($row['status']) == 0) {
					
					$status = false;
					
				}
				
			}
			
			return $status;
        	
        }
        
        public function get_user($userId = null, $statusCheck = true){
			
			$pluginName = $this->pluginName;
			$reality = false;
			$user = null;
			$value = null;
			$setting = new booking_package_setting($this->prefix, $this->pluginName);
			$memberSetting = array_merge($setting->getMemberSettingValues(), array('current_member_id' => 0, 'login' => 0));
			$response = array("status" => 0, "message" => "", "user" => $memberSetting);
			if (is_null($userId)) {
				
				$userId = get_current_user_id();
				$roleName = $this->userRoleName;
				if ($userId != 0) {
					
					$bool = false;
					if (current_user_can($roleName) === true) {
						
						$bool = true;
						
					} else if (current_user_can("subscriber") === true && intval($memberSetting['accept_subscribers_as_users'] == 1)) {
						
						$bool = true;
						$this->find_users($userId, 1, true);
						
					} else if (current_user_can("contributor") === true && intval($memberSetting['accept_contributors_as_users'] == 1)) {
						
						$bool = true;
						$this->find_users($userId, 1, true);
						
					}/** else if (current_user_can("author") === true && intval($memberSetting['accept_authors_as_users'] == 1)) {
						
						$bool = true;
						$this->find_users($userId, 1, true);
						
					}**/
					
					#$capability = current_user_can($roleName);
					if ($bool === true) {
						
						$user = get_user_by('id', intval($userId));
						$value = $this->login($userId);
						if (!is_int($value) && is_array(array_values($value))) {
							
							$reality = true;
							/**
							$memberSetting['user_login'] = $user->user_login;
							$memberSetting['user_email'] = $user->user_email;
							$memberSetting['value'] = $value;
							$memberSetting['current_member_id'] = intval($userId);
							$memberSetting['login'] = 1;
							$memberSetting['subscription_list'] = $this->get_subscription_list_of_user($userId);
							
							$response = array("status" => 1, "user" => $memberSetting);
							**/
							
						} else {
							
							#$response = array("status" => 0, "user" => array_merge($memberSetting, array("status" => 0, "message" => __('Your email address has not been accepted.', $pluginName), "reload" => 1)));
							$response = array("status" => 0, "user" => array_merge($memberSetting, array("status" => 0, "message" => "", "reload" => 1)));
							
						}
						
					} else {
						
						$response = array("status" => 0, "user" => array_merge($memberSetting, array("status" => 0, "message" => "", "reload" => 1)));
						
					}
					
				}
				
			} else {
				
				$user = get_user_by('id', intval($userId));
				$value = $this->login($userId, $statusCheck);
				if (!is_int($value) && is_array($value)) {
					
					$reality = true;
					
				} else {
					
					$response = array("status" => 0, "user" => array_merge($memberSetting, array("status" => 0, "message" => __('Your email address has not been accepted.', $pluginName), "reload" => 1)));
					
				}
        		
        	}
        	
        	if ($reality === true) {
        		
        		$memberSetting['user_login'] = $user->user_login;
				$memberSetting['user_email'] = $user->user_email;
				$memberSetting['value'] = $value;
				$memberSetting['current_member_id'] = intval($userId);
				$memberSetting['login'] = 1;
				$memberSetting['subscription_list'] = $this->get_subscription_list_of_user($userId);
				
				$response = array("status" => 1, "message" => "", "user" => $memberSetting);
        		
        	}
        	
        	return $response;
        	
        }
        
        public function update_subscription_list_of_user($userId, $subscription_list){
			
			#$subscription_list = $user['user']['subscription_list'];
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_users";
			#$sql = $wpdb->prepare("UPDATE `".$table_name."` SET `` = %s WHERE `key` = %d;", array(intval($userId)));
			
			$bool = $wpdb->update( 
				$table_name,
				array(
					'subscription_list' => json_encode($subscription_list), 
				),
				array('key' => intval($userId)),
				array('%s'),
				array('%d')
			);
			
			return $bool;
			
        }
        
        public function get_subscription_list_of_user($userId){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_users";
			$sql = $wpdb->prepare(
				"SELECT `subscription_list`,`status` FROM `".$table_name."` WHERE `key` = %d;", 
				array(intval($userId))
			);
			$row = $wpdb->get_row($sql, ARRAY_A);
			$subscription_list = json_decode($row['subscription_list'], true);
			if (is_null($subscription_list)) {
				
				$subscription_list = array();
				
			} else {
				
				$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
    			$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
				$deleteKey = array();
				foreach ((array) $subscription_list as $key => $value) {
					
					$delete = false;
					if ($value['period_end'] < date('U')) {
						
						$value = $this->update_subscription($value);
						if (is_array($value)) {
							
							$subscription_list[$key] = $value;
							
							if ($value['canceled'] == 1) {
								
								#var_dump($subscription_list[$key]);
								$delete = true;
								array_push($deleteKey, $key);
								unset($subscription_list[$key]);
								
							}
							
							$this->update_subscription_list_of_user($userId, $subscription_list);
							#var_dump($subscription_list[$value]);
							
						} else {
							
							array_push($deleteKey, $key);
							
						}
						
					}
					
					if ($delete === false) {
						
						$subscription_list[$key]['period_start_date'] = $this->dateFormat($dateFormat, $positionOfWeek, $value['period_start'], "", true, true, 'text');
						$subscription_list[$key]['period_end_date'] = $this->dateFormat($dateFormat, $positionOfWeek, $value['period_end'], "", true, true, 'text');
						
					}
					
				}
				
			}
			
        	return $subscription_list;
        	
        }
        
        public function update_subscription($subscription){
			
			global $wpdb;
			$response = array("status" => 1);
			$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
			if ($subscription['payType'] == 'stripe') {
				
				$secret_key = get_option($this->prefix."stripe_secret_key", null);
				$update_subscription = $creditCard->update_subscription($secret_key, $subscription);
				$add_subscription = $this->prepare_subscription($subscription['payType'], $update_subscription, $subscription);
				return $add_subscription;
				
			}
			
			return false;

        }
        
        public function deleteSubscription($productKey = false, $userId = null){
			
			global $wpdb;
			$productKey = sanitize_text_field($productKey);
			$response = array("status" => 1);
			$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
			
			if (is_null($userId)) {
				
				$user = $this->get_user();
				
			} else {
				
				$user = $this->get_user($userId, false);
				
			}
			
        	if(intval($user['status']) == 1){
        		
        		$subscription_list = $user['user']['subscription_list'];
        		if(isset($subscription_list[$productKey])){
        			
        			$secret_key = get_option($this->prefix."stripe_secret_key", null);
        			$response = $creditCard->deleteSubscription($subscription_list[$productKey], $secret_key);
        			if($response['deleted'] === true){
        				
        				#unset($subscription_list[$productKey]);
        				$subscription_list[$productKey]['canceled'] = 1;
        				$bool = $this->update_subscription_list_of_user($user['user']['current_member_id'], $subscription_list);
        				$response['status'] = 1;
        				$response['bool'] = $bool;
        				#$response['user'] = $user;
        				#$response['subscription_list'] = $subscription_list;
        				
        			}else{
        				
        				if($response['code'] == 404){
        					
        					unset($subscription_list[$productKey]);
        					$bool = $this->update_subscription_list_of_user($user['user']['current_member_id'], $subscription_list);
        					$response['bool'] = $bool;
        					
        				}
        				
        				$response['status'] = 0;
        				
        			}
        			return $response;
        			
        		}else{
        			
        			$response = array("status" => 0, "reload" => 1);
        			
        		}
        		
        		return $subscription_list;
        		
        	}else{
        		
        		return $user;
        		
        	}
        	
        }
		
		public function user_login_for_frontend($user_login, $user_password, $remember) {
			
			if (!isset($_POST['googleReCaptchaToken'])) {
				
				$_POST['googleReCaptchaToken'] = '';
				
			}
			$result = $this->verifyGoogleReCaptchaToken($_POST['googleReCaptchaToken']);
			if ($result['status'] === false) {
				
				$this->cancelPayment();
				$result['status'] = 'error';
				return $result;
				
			}
			
			if (!isset($_POST['hCaptcha'])) {
				
				$_POST['hCaptcha'] = '';
				
			}
			$result = $this->verifyHCaptcha($_POST['hCaptcha']);
			if ($result['status'] === false) {
				
				$this->cancelPayment();
				$result['status'] = 'error';
				return $result;
				
			}
			
			$response = array('status' => 'success');
			$creds = array('user_login' => $user_login, 'user_password' => $user_password);
			if (intval($remember) == 1) {
				
				$creds['remember'] = true;
				
			}
			
			$user = wp_signon($creds, true);
			if (is_wp_error($user)) {
				
				$response['status'] = 'error';
				$response['code'] = $user->get_error_code();
				$response['message'] = $user->get_error_message();
				$response['user'] = $user;
				
			} else {
				
				$bool = 'false';
				$user_toolbar = intval(get_option($this->prefix . 'user_toolbar', 0));
				if (intval($user_toolbar) == 1) {
					
					$bool = 'true';
					
				}
				update_user_meta($user->ID, 'show_admin_bar_front', $bool);
				$responseUser = $this->get_user($user->ID, true);
				if ($responseUser['status'] == 0) {
					
					wp_logout();
					$response['status'] = 'error';
					$response['code'] = 'not_approved';
					$response['message'] = __('Your username has not been approved.', $this->pluginName);
					
				}
				
				
			}
			
			return $response;
			
			
        }
        
        public function logout(){
			
			wp_logout();
			return array("status" => "success");
			
        }
        
        public function deleteUser($administrator = 0){
			
			$reality = false;
			$userId = 0;
			if (intval($administrator) == 1) {
				
				$user = get_user_by('login', sanitize_text_field($_POST['user_login']));
				if ($user !== false) {
					
					$reality = true;
					
				}
				$userId = $user->ID;
				
			} else {
			
				$userId = get_current_user_id();
				if ($userId != 0) {
					
					$reality = true;
					
				}
			
			}
			
			if ($reality === true) {
				
				$response = array("status" => "success", "userId" => $userId);
				if (wp_delete_user($userId) === true) {
					
					$this->deleteForPluginUser($userId);
					return $response;
					
				}
				
				$response['status'] = "error";
				return $response;
				
			} else {
				
				$response = array("status" => "error", "userId" => $userId);
				return $response;
				
			}
			
        }
		
		public function deleteForPluginUser($user_id){
			
			global $wpdb;
			$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
			$user = $this->get_user($user_id, false);
			if (isset($user['user']['subscription_list']) && is_null($user['user']['subscription_list']) === false) {
				
				$items = $user['user']['subscription_list'];
				foreach ((array) $items as $key => $value) {
					
					$secret_key = get_option($this->prefix."stripe_secret_key", null);
					$response = $creditCard->deleteSubscription($value, $secret_key);
					
				}
				
			}
			
        	$table_name = $wpdb->prefix."booking_package_users";
        	$wpdb->delete($table_name, array('key' => intval($user_id)), array('%d'));
        	do_action('booking_package_delete_user', $user_id);
        	
        }
        
		public function setUserInformation($form){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_users";
			$setting = new booking_package_setting($this->prefix, $this->pluginName);
			$memberSetting = array_merge($setting->getMemberSettingValues(), array('current_member_id' => 0, 'login' => 0));
			
			$response = array("status" => "success");
			$bool = false;
			$userId = get_current_user_id();
			$roleName = $this->userRoleName;
			if ($userId != 0 && current_user_can($roleName) === true) {
				
				$bool = true;
				
			} else if ($userId != 0 && current_user_can("subscriber") === true && intval($memberSetting['accept_subscribers_as_users'] == 1)) {
				
				$bool = true;
				
			} else if ($userId != 0 && current_user_can("contributor") === true && intval($memberSetting['accept_contributors_as_users'] == 1)) {
				
				$bool = true;
				
			}/** else if ($userId != 0 && current_user_can("author") === true && intval($memberSetting['accept_authors_as_users'] == 1)) {
				
				$bool = true;
				
			}**/
			
			if ($bool === true) {
				
				$sql = $wpdb->prepare("SELECT `value`,`status` FROM `".$table_name."` WHERE `key` = %d;", array(intval($userId)));
				$row = $wpdb->get_row($sql, ARRAY_A);
				if (!is_null($row)) {
					
					$values = json_decode($row['value'], true);
					for ($i = 0; $i < count($form); $i++) {
						
						$type = $form[$i]['type'];
						$formId = $form[$i]['id'];
						$value = $form[$i]['value'];
						$array = array("id" => $formId, "value" => $value);
						if (isset($values[$type])) {
							
							$values[$type][$formId] = $array;
							
						} else {
							
							$values[$type] = array($formId => $array);
							
						}
						
					}
					
					$bool = $wpdb->update( 
						$table_name,
						array(
							'value' => sanitize_text_field(json_encode($values)), 
						),
						array('key' => intval($userId)),
						array('%s'),
						array('%d')
					);
					
					$response['values'] = $values;
					return $response;
					
				} else {
					
					$response["status"] = "error";
					return $response;
					
				}
				
			}
			
			return $response;
			
		}
		
		public function prepare_subscription($payType, $response_subscription, $subscription){
			
			$items = array();
			for($i = 0; $i < count($response_subscription['items']['data']); $i++){
				
				$item = $response_subscription['items']['data'][$i]['plan'];
				array_push($items, $item);
				
			}
			
			$canceled = 0;
			if($response_subscription['status'] == "active"){
				
				$canceled = 0;
				
			}else if($response_subscription['status'] == "canceled"){
				
				$canceled = 1;
				
			}
			
			$add_subscription = array(
				'product' => $subscription['product'],
				'name' => $subscription['name'],
				'customer_id_for_stripe' => $response_subscription['customer'],
				'subscription_id_for_stripe' => $response_subscription['id'],
				'period_start' => $response_subscription['current_period_start'],
				'period_end' => $response_subscription['current_period_end'],
				'booking_count' => null,
				'payType' => sanitize_text_field($payType),
				'canceled' => $canceled,
				'items' => $items,
			);
			
			return $add_subscription;
    		
    	}
    	
    	public function createCustomer(){
    		
    		$response = array("status" => 1);
    		$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
    		$payment_active = 0;
    		$payment_live = 0;
    		$calendarAccount = $this->getCalendarAccount(intval($_POST['calendarAccountKey']));
    		$paymentMethod = explode(",", $calendarAccount['paymentMethod']);
    		$response['calendarAccount'] = $calendarAccount;
    		$user = $this->get_user();
    		$response['user'] = $user;
    		if(intval($user['status']) == 1){
    			
    			if(isset($_POST['payType']) && $_POST['payType'] == 'stripe'){
    				
    				#$payment_active = get_option($this->prefix."stripe_active", "0");
    				$payment_active = 0;
    				if (!is_bool(array_search(strtolower($_POST['payType']), $paymentMethod))) {
    					
    					$payment_active = 1;
    					
    				}
	    			
					$secret_key = get_option($this->prefix."stripe_secret_key", null);
	    			$products = $calendarAccount["subscriptionIdForStripe"];
	    			$products = explode(",", $products);
	    			$subscription = $this->getProductForStripe($secret_key, array($products[0]));
	    			$response['subscription'] = $subscription;
	    			if(is_array($subscription)){
	    				
	    				$stripe = $creditCard->createCustomer($_POST['payType'], $public_key, $secret_key, $_POST['payToken'], $calendarAccount, $subscription, $user['user'], $payment_live, $payment_active);
	    				$response['stripe'] = $stripe;
	    				if(isset($stripe['subscription']['status']) && $stripe['subscription']['status'] == 'active'){
	    					
	    					$response_subscription = $stripe['subscription'];
	    					$subscription_list = $user['user']['subscription_list'];
	    					#$subscription_list['customer_id_for_stripe'] = $response_subscription['customer'];
	    					
	    					$add_subscription = $this->prepare_subscription($_POST['payType'], $response_subscription, $subscription);
	    					
	    					/**
	    					$items = array();
	    					for($i = 0; $i < count($response_subscription['items']['data']); $i++){
	    						
	    						$item = $response_subscription['items']['data'][$i]['plan'];
	    						array_push($items, $item);
	    						
	    					}
	    					
	    					$add_subscription = array(
	    						'product' => $subscription['product'],
	    						'name' => $subscription['name'],
	    						'customer_id_for_stripe' => $response_subscription['customer'],
	    						'subscription_id_for_stripe' => $response_subscription['id'],
	    						'period_start' => $response_subscription['current_period_start'],
	    						'period_end' => $response_subscription['current_period_end'],
	    						'booking_count' => null,
	    						'payType' => sanitize_text_field($_POST['payType']),
	    						'items' => $items,
	    					);
	    					**/
	    					
	    					$subscription_list[$subscription['product']] = $add_subscription;
	    					$user['user']['subscription_list'] = $subscription_list;
	    					$update = $this->update_subscription_list_of_user($user['user']['current_member_id'], $subscription_list);
	    					
	    					$response['update_subscription'] = $update;
	    					$response['user'] = $user;
	    					$response['subscription_list'] = $subscription_list;
	    					
	    				}else{
	    					
	    					$response["status"] = 0;
	    					
	    				}
	    				
	    			}else{
	    				
	    				$response["status"] = 0;
	    				
	    			}
	    			
	    		}else if(isset($_POST['payType']) && $_POST['payType'] == 'paypal'){
	    			
	    			#$payment_active = get_option($this->prefix."paypal_active", "0");
	    			$payment_active = 0;
    				if (!is_bool(array_search(strtolower($_POST['payType']), $paymentMethod))) {
    					
    					$payment_active = 1;
    					
    				}
    				
					$payment_live = get_option($this->prefix."paypal_live", "0");
					$public_key = get_option($this->prefix."paypal_client_id", null);
					$secret_key = get_option($this->prefix."paypal_secret_key", null);
	    			
	    		}
    			
    		}else{
    			
    			$response["status"] = 0;
    			
    		}
    		
    		return $response;
    		
    	}
    	
    	public function getProductForStripe($secret, $products = array()){
    		
    		$subscriptions = array();
    		for($index = 0; $index < count($products); $index++){
    			
    			$product = $products[$index];
				$args = array(
					'method' => 'GET',
					'headers' => array(
						'Authorization' => 'Basic ' . base64_encode($secret . ':')
					)
				);
				$response = wp_remote_request("https://api.stripe.com/v1/plans?limit=100&product=" . $product, $args);
				$object = json_decode(wp_remote_retrieve_body($response));
				$statusCode = wp_remote_retrieve_response_code($response);
				
				/**
    			$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/plans?limit=100&product=".$product);
				curl_setopt($ch, CURLOPT_USERPWD, $secret.":");
				curl_setopt($ch, CURLOPT_POST, 0);
				
				ob_start();
				$response = curl_exec($ch);
				$response = ob_get_contents();
				ob_end_clean();
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close ($ch);
				$response = json_decode($response, true);
				**/
				
				$name = null;
				$currency = 'usd';
				$amount = 0;
				$bool = false;
				$planKeys = array();
				$plans = array();
				for($i = 0; $i < count($response['data']); $i++){
				    
				    $data = $response['data'][$i];
				    if($data['active'] === true){
				        
				        $bool = true;
				        $name = $data['name'];
				        $currency = $data['currency'];
				        $amount += intval($data['amount']);
				        
				        array_push($planKeys, $data['id']);
	    		        array_push($plans, array(
	    		            'id' => $data['id'],
	    			        'name' => $data['name'],
	    			        'label' => $data['name'],
	    			        'amount' => $data['amount'],
	    			        'currency' => $data['currency'],
	    		        ));
				        
				    }
				    
				}
				
				if($bool === true){
					
					$subscription = array('product' => $product, 'name' => $name, 'amount' => $amount, 'currency' => $currency, 'planKeys' => $planKeys, 'plans' => $plans, 'status' => 1, 'subscribed' => 0);
		        	array_push($subscriptions, $subscription);
					
				}
    			
    		}
    		
    		if(count($subscriptions) > 0){
    			
    			return $subscriptions[0];
    			
    		}else{
    			
    			return false;
    			
    		}
    		
    	}
		
		public function updateRegularHolidays() {
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_regular_holidays";
			$sql = $wpdb->prepare(
				"SELECT * FROM ".$table_name." WHERE `accountKey` = %s AND `day` = %d AND `month` = %d AND `year` = %d;", 
				array(
					sanitize_text_field($_POST['accountKey']), 
					intval($_POST['day']),
					intval($_POST['month']),
					intval($_POST['year']),
				)
			);
			
			$unixTime = date('U', mktime(0, 0, 0, intval($_POST['month']), intval($_POST['day']), intval($_POST['year'])));
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (!is_null($row)) {
				
				$bool = $wpdb->update(
					$table_name,
					array(
						'status' => sanitize_text_field($_POST['status']), 
					),
					array(
						'accountKey' => sanitize_text_field($_POST['accountKey']),
						'day' => intval($_POST['day']),
						'month' => intval($_POST['month']),
						'year' => intval($_POST['year']),
					),
					array('%s'),
					array('%s', '%d', '%d', '%d')
				);
			
			} else {
			
				$wpdb->insert(
					$table_name, 
					array(
						'accountKey' => sanitize_text_field($_POST['accountKey']), 
						'day' => intval($_POST['day']), 
						'month' => intval($_POST['month']), 
						'year' => intval($_POST['year']), 
						'unixTime' => sanitize_text_field($unixTime), 
						'status' => sanitize_text_field($_POST['status']), 
						'update' => date('U'), 
					), 
					array('%s', '%d', '%d', '%d', '%s', '%s', '%s')
				);
				
			}
			
			return $this->getRegularHolidays($_POST['month_calendar'], $_POST['year_calendar'], $_POST['accountKey'], get_option('start_of_week', 0));
			
		}
		
		public function confirmRegularHolidays($accountKey, $month, $day, $year) {
			
			$value = false;
			global $wpdb;
			$table_name = $wpdb->prefix . "booking_package_regular_holidays";
			$sql = $wpdb->prepare(
				"SELECT `status` FROM `" . $table_name . "` WHERE `month` = %d AND `day` = %d AND `year` = %d AND (`accountKey` = 'share' || `accountKey` = %s);", 
				array(
					intval($month), 
					intval($day), 
					intval($year), 
					sanitize_text_field($accountKey)
				)
			);
			
			$holidays = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $holidays as $key => $holiday) {
				
				if (intval($holiday['status']) == 1) {
					
					$value = true;
					break;
					
				}
				
			}
			
			return $value;
			
		}
		
		public function getRegularHolidays($month, $year, $accountKey = null, $startOfWeek = 0, $share = false) {
			
			$last_day = date('t', mktime(0, 0, 0, $month, 1, $year));
			$week_start_num = intval(date('w', mktime(0, 0, 0, $month, 1, $year)));
			$week_last_num = intval(date('w', mktime(0, 0, 0, $month, $last_day, $year)));
			$date = array('startDay' => 1, 'lastDay' => $last_day, 'startWeek' => $week_start_num, 'lastWeek' => $week_last_num, 'year' => $year, 'month' => intval($month), 'day' => 1);
			$calendar = array("date" => $date, "calendar" => array());
			
			global $wpdb;
			$table_name = $wpdb->prefix . "booking_package_regular_holidays";
			$calendarList = $this->getCalendarList($month, 1, $year, $startOfWeek);
			
			if (empty($accountKey) === false && $accountKey != 'share' && $accountKey != 'national') {
				
				$calendarAccount = $this->getCalendarAccount($accountKey);
				$startOfWeek = $calendarAccount['startOfWeek'];
				$calendarList = $this->getCalendarList($month, 1, $year, $startOfWeek);
				
			}
			
			$list = array();
			foreach ((array) $calendarList as $key => $value) {
				
				for ($i = $value['startDay']; $i <= $value['lastDay']; $i++) {
					
					$month = $value['month'];
					$year = $value['year'];
					$key = $value['year'].sprintf("%02d%02d", $value['month'], $i);
					$week = date('w', mktime(0, 0, 0, $month, $i, $year));
					$dayArray = array('year' => $value['year'], 'month' => $value['month'], 'day' => $i, 'week' => $week, 'count' => null, 'accountKey' => $accountKey, 'status' => 0);
					$list[$key] = $dayArray;
					
					if ($share === true) {
						
						$sql = $wpdb->prepare(
							"SELECT * FROM ".$table_name." WHERE (`accountKey` = 'share' || `accountKey` = %s) AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY unixTime ASC;",
							/** "SELECT * FROM ".$table_name." WHERE `accountKey` = %s AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY unixTime ASC;", **/
							array(
								sanitize_text_field($accountKey), 
								intval($year), 
								intval($month), 
								intval($i), 
							)
						);
						
					} else {
						
						$sql = $wpdb->prepare(
							"SELECT * FROM ".$table_name." WHERE `accountKey` = %s AND `year` = %d AND `month` = %d AND `day` = %d ORDER BY unixTime ASC;", 
							array(
								sanitize_text_field($accountKey), 
								intval($year), 
								intval($month), 
								intval($i), 
							)
						);
						
					}
					
					$rows = $wpdb->get_results($sql, ARRAY_A);
					foreach ((array) $rows as $holidayKey => $holidayValue) {
						
						if (intval($holidayValue['status']) == 1) {
							
							$list[$key] = $holidayValue;
							break;
							
						}
						
					}
					
				}
				
			}
			
			if ($accountKey == 'national') {
				
				$setting = new booking_package_setting($this->prefix, $this->pluginName);
				$numberKeys = $setting->getListOfDaysOfWeek();
				$list = $this->addPriceKeyByDayOfWeek($list, $numberKeys, true);
				
			}
			
			$calendar['calendarList'] = $calendarList;
			$calendar['calendar'] = $list;
			
			return $calendar;
			
		}
		
		public function addPriceKeyByDayOfWeek($schedules, $numberKeys, $updateNationalHoliday = false) {
			
			foreach ((array) $schedules as $key => $value) {
				
				if (isset($value['week'])) {
					
					$week = intval($value['week']) - 1;
					if ($week < 0) {
						
						$week = 6;
						
					}
					$schedules[$key]['priceKeyByDayOfWeek'] = $numberKeys[$week];
					
				}
				
				if (isset($value['weekKey'])) {
					
					$week = intval($value['weekKey']) - 1;
					if ($week < 0) {
						
						$week = 6;
						
					}
					$schedules[$key]['priceKeyByDayOfWeek'] = $numberKeys[$week];
					
				}
				
				if ($updateNationalHoliday === true) {
					
					if (isset($value['status']) && intval($value['status']) == 1) {
						
						$dayBeforeUnixTime = intval($value['unixTime']) - (1440 * 60);
						$dayBeforeKey = date('Y', $dayBeforeUnixTime) . date('m', $dayBeforeUnixTime) . date('d', $dayBeforeUnixTime);
						$week = date('w', mktime(0, 0, 0, $value['month'], $value['day'], $value['year']));
						$schedules[$key]['week'] = $week;
						$schedules[$key]['priceKeyByDayOfWeek'] = 'priceOnNationalHoliday';
						if (isset($schedules[$dayBeforeKey]) && $schedules[$dayBeforeKey]['priceKeyByDayOfWeek'] != 'priceOnNationalHoliday') {
							
							$schedules[$dayBeforeKey]['priceKeyByDayOfWeek'] = 'priceOnDayBeforeNationalHoliday';
							
						}
						
					}
					
				}
				
			}
			
			return $schedules;
			
		}
        
        public function createFirstCalendar($timeZone){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$sql = "SELECT COUNT(`key`) FROM `".$table_name."`;";
			
			$rows = $wpdb->get_results("SELECT COUNT(`key`) FROM `".$table_name."`;", ARRAY_A);
			foreach ((array) $rows as $row) {
				
				if (intval($row['COUNT(`key`)']) == 0) {
					
					$date = date('U');
					$local = get_locale();
					$startOfWeek = 0;
					if ($local == 'es_ES' || $local == 'en_GB' || $local == 'de_DE' || $local == 'it_IT' || $local == 'nl_NL' || $local == 'da_DK' || $local == 'nb_NO' || $local == 'sv_SE' || $local == 'fr_FR') {
						
						$startOfWeek = 1;
						
					}
					
					$siteName = get_bloginfo('name');
					$email = get_bloginfo('admin_email');
					
					if ($local == 'ja' || $local == 'ja-jp' || $local == 'ja_jp') {
						
						$wpdb->insert(
							$table_name, 
							array(
								'key' => 1, 
								'name' => sanitize_text_field('First Calendar'), 
								'type' => sanitize_text_field('day'), 
								'status' => sanitize_text_field('open'), 
								'created' => sanitize_text_field($date), 
								'uploadDate' => sanitize_text_field($date),
								'displayRemainingCapacityInCalendar' => '1',
								'displayRemainingCapacityHasMoreThenThreshold' => '{"symbol":"panorama_fish_eye","color":"#969696"}',
								'displayRemainingCapacityHasLessThenThreshold' => '{"symbol":"change_history","color":"#f4e800"}',
								'displayRemainingCapacityHas0' => '{"symbol":"close","color":"#e24b00"}',
								'startOfWeek' => $startOfWeek,
								'icalToken' => hash('ripemd160', date('U')),
								'email_to' => sanitize_text_field($email),
								'email_from' => sanitize_text_field($email),
								'email_from_title' => sanitize_text_field('First Calendar'),
								'timezone' => sanitize_text_field($timeZone),
							), 
							array(
								'%d', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', 
								'%d', '%s', '%s', '%s', '%s', '%s', 
							)
						);
						add_option($this->prefix . 'positionTimeDate', 'dateTime');
						add_option($this->prefix . 'positionOfWeek', 'after');
						
					} else {
						
						$wpdb->insert(
							$table_name, 
							array(
								'key' => 1, 
								'name' => sanitize_text_field('First Calendar'), 
								'type' => sanitize_text_field('day'), 
								'status' => sanitize_text_field('open'), 
								'created' => sanitize_text_field($date), 
								'startOfWeek' => $startOfWeek,
								'icalToken' => hash('ripemd160', date('U')),
								'uploadDate' => sanitize_text_field($date),
								'email_to' => sanitize_text_field($email),
								'email_from' => sanitize_text_field($email),
								'email_from_title' => sanitize_text_field('First Calendar'),
								'timezone' => sanitize_text_field($timeZone),
							), 
							array(
								'%d', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', 
								'%s', '%s', 
							)
						);
						
						if ($local == 'en_US' || $local == 'en_GB') {
							
							add_option($this->prefix . 'positionTimeDate', 'timeDate');
							
						}
						add_option($this->prefix . 'positionOfWeek', 'before');
						
					}
					$this->addGuests(1, 'day');
					
					$wpdb->insert(
						$table_name, 
						array(
							'key' => 2, 
							'name' => sanitize_text_field('First Calendar for hotel'), 
							'type' => sanitize_text_field('hotel'), 
							'status' => sanitize_text_field('open'), 
							'created' => sanitize_text_field($date), 
							'uploadDate' => sanitize_text_field($date),
							'numberOfRoomsAvailable' => 5,
							'includeChildrenInRoom' => 1,
							'startOfWeek' => $startOfWeek,
							'icalToken' => hash('ripemd160', date('U')),
							'email_to' => sanitize_text_field($email),
							'email_from' => sanitize_text_field($email),
							'email_from_title' => sanitize_text_field('First Calendar for hotel'),
							'timezone' => sanitize_text_field($timeZone),
						), 
						array(
							'%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', 
							'%s', '%s', '%s', '%s', 
						)
					);
					$this->addGuests(2, 'hotel');
					
				}
				
				break;
				
			}
			
			$this->insertAccountSchedule(date('m'), date('d'), date('Y'));
        	
        }
        
        public function setTimeZoneInCalendarAccount($accountKey) {
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$timezone = get_option($this->prefix . "timezone", null);
			if (is_null($timezone)) {
				
				$timezone = get_option('timezone_string', '');
				if (empty($timezone) || strlen($timezone) == 0) {
					
					$timezone = 'UTC';
					
				}
				
			}
			
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$bool = $wpdb->update(
				$table_name,
				array(
					'timezone' => sanitize_text_field($timezone), 
				),
				array('key' => intval($accountKey)),
				array('%s'),
				array('%d')
			);
			
			return $timezone;
			
        }
        
        public function getCalendarAccountListData($columns = "*") {
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$rows = $wpdb->get_results("SELECT ".$columns." FROM `".$table_name."`;", ARRAY_A);
			foreach ((array) $rows as $key => $row) {
				
				if (isset($row['icalToken']) && intval($row['icalToken']) == 0) {
					
					$this->refreshIcalToken($row['key']);
					
				}
				
				if (isset($row['limitNumberOfGuests'])) {
					
					$limitNumberOfGuests = json_decode($row['limitNumberOfGuests'], true);
					if (empty($limitNumberOfGuests)) {
						
						$limitNumberOfGuests = array(
							'minimumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
							'maximumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
						);
						
					}
					$rows[$key]['limitNumberOfGuests'] = $limitNumberOfGuests;
					
				}
				
				if (isset($row['minimumGuests'])) {
					
					$minimumGuests = json_decode($row['minimumGuests'], true);
					if (empty($minimumGuests) === true) {
						
						$minimumGuests = array('enabled' => 0, 'included' => 0, 'number' => 0);
						
					}
					$rows[$key]['minimumGuests'] = $minimumGuests;
					
				}
				
				if (isset($row['maximumGuests'])) {
					
					$maximumGuests = json_decode($row['maximumGuests'], true);
					if (empty($maximumGuests) === true) {
						
						$maximumGuests = array('enabled' => 0, 'included' => 0, 'number' => 0);
						
					}
					$rows[$key]['maximumGuests'] = $maximumGuests;
					
				}
				
				if (isset($row['timezone']) && $row['timezone'] == 'none') {
					
					$rows[$key]['timezone'] = $this->setTimeZoneInCalendarAccount($row['key']);
					
				}
				
			}
			
			return $rows;
        	
        }
        
        public function getCalendarAccount($accountKey = 1, $isExtensionsValid = null){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array($accountKey));
			$row = $wpdb->get_row($sql, ARRAY_A);
			
			if (is_null($row) === true) {
				
				return false;
				
			}
			
			if (strlen($row['type']) == 0) {
				
				$row['type'] = 'day';
				
			}
			
			if (isset($row['limitNumberOfGuests'])) {
				
				$limitNumberOfGuests = json_decode($row['limitNumberOfGuests'], true);
				if (empty($limitNumberOfGuests)) {
					
					$limitNumberOfGuests = array(
						'minimumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
						'maximumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
					);
					
				}
				$row['limitNumberOfGuests'] = $limitNumberOfGuests;
				
			}
			/**
			if (isset($row['minimumGuests'])) {
				
				$minimumGuests = json_decode($row['minimumGuests'], true);
				if (empty($minimumGuests) === true) {
					
					$minimumGuests = array('enabled' => 0, 'included' => 0, 'number' => 0);
					
				}
				$row['minimumGuests'] = $minimumGuests;
				
			}
			
			if (isset($row['maximumGuests'])) {
				
				$maximumGuests = json_decode($row['maximumGuests'], true);
				if (empty($maximumGuests) === true) {
					
					$maximumGuests = array('enabled' => 0, 'included' => 0, 'number' => 0);
					
				}
				$row['maximumGuests'] = $maximumGuests;
				
			}
			**/
			if ($isExtensionsValid === false && $row['type'] == 'hotel') {
				
				if ($row['hotelChargeOnDayBeforeNationalHoliday'] != 0 || $row['hotelChargeOnNationalHoliday'] != 0) {
					
					$table_name = $wpdb->prefix."booking_package_calendarAccount";
					$wpdb->query("START TRANSACTION");
					$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
					try {
					
						$bool = $wpdb->update(
							$table_name,
							array(
								'hotelChargeOnDayBeforeNationalHoliday' => 0, 
								'hotelChargeOnNationalHoliday' => 0,
							),
							array('key' => intval($accountKey)),
							array(
								'%d', '%d', 
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
				
			}
			
			if (isset($row['timezone']) === true && $row['timezone'] == 'none') {
				
				$row['timezone'] = $this->setTimeZoneInCalendarAccount($accountKey);
				
			}
			
			if (is_null($row['paymentMethod'])) {
				
				$row['paymentMethod'] = $this->setPaymentMethod($accountKey);
				
			}
			
			return $row;
        	
        }
        
        public function setPaymentMethod($accountKey) {
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$paymentMethod = array();
        	if (intval(get_option($this->prefix."stripe_active", 0)) == 1) {
				
				array_push($paymentMethod, "stripe");
				
			}
			
			if (intval(get_option($this->prefix."paypal_active", 0)) == 1) {
				
				array_push($paymentMethod, "paypal");
				
			}
			
			$paymentMethod = implode(",", $paymentMethod);
			$bool = $wpdb->update(
				$table_name,
				array(
					'paymentMethod' => sanitize_text_field($paymentMethod), 
				),
				array('key' => intval($accountKey)),
				array('%s'),
				array('%d')
			);
			
			return $paymentMethod;
        	
        }
        
		public function addCalendarAccount(){
			
			$postList = array('cost' => 0, 'numberOfRoomsAvailable' => 1, 'numberOfPeopleInRoom' => 2, 'includeChildrenInRoom' => 0);
			foreach ((array) $postList as $key => $value) {
				
				if (!isset($_POST[$key])) {
					
					$_POST[$key] = $value;
					
				}
				
			}
			
			$type = "day";
			if (isset($_POST['type'])) {
				
				$type = $_POST['type'];
				
			}
			
			if (!isset($_POST['timezone'])) {
				
				$_POST['timezone'] = "none";
				
			}
			
			if (!isset($_POST['blockSameTimeBookingByUser'])) {
				
				$_POST['blockSameTimeBookingByUser'] = 0;
				
			}
			
			if (!isset($_POST['allowCancellationUser'])) {
				
				$_POST['allowCancellationUser'] = 0;
				
			}
			
			if (!isset($_POST['bookingReminder'])) {
				
				$_POST['bookingReminder'] = 60;
				
			}
			
			if (!isset($_POST['insertConfirmedPage'])) {
				
				$_POST['insertConfirmedPage'] = 0;
				
			}
			
			if (intval($_POST['schedulesSharing']) == 1) {
				
				$targetCalendar = $this->getCalendarAccount($_POST['targetSchedules']);
				if ($targetCalendar === false || $targetCalendar['type'] != $_POST['type']) {
					
					$_POST['schedulesSharing'] = 0;
					$_POST['targetSchedules'] = 0;
					
				} else {
					
					$_POST['timezone'] = $targetCalendar['timezone'];
					
				}
				
			}
			
			if (!isset($_POST['enableSubscriptionForStripe']) || $type == 'hotel') {
				
				$_POST['subscriptionIdForStripe'] = "";
				$_POST['enableSubscriptionForStripe'] = 0;
				$_POST['termsOfServiceForSubscription'] = "";
				$_POST['enableTermsOfServiceForSubscription'] = 0;
				$_POST['privacyPolicyForSubscription'] = "";
				$_POST['enablePrivacyPolicyForSubscription'] = 0;
				
			}
			
			if (!isset($_POST['displayRemainingCapacityInCalendar'])) {
				
				$_POST['displayRemainingCapacityInCalendar'] = 0;
				$_POST['displayThresholdOfRemainingCapacity'] = 50;
				$_POST['displayRemainingCapacityHasMoreThenThreshold'] = "";
				$_POST['displayRemainingCapacityHasLessThenThreshold'] = "";
				$_POST['displayRemainingCapacityHas0'] = "";
				
			}
			
			if (!isset($_POST['cancellationOfBooking'])) {
				
				$_POST['cancellationOfBooking'] = 0;
				$_POST['allowCancellationVisitor'] = 0;
				$_POST['allowCancellationUser'] = 0;
				$_POST['refuseCancellationOfBooking'] = "not_refuse";
				
			}
			
			if (!isset($_POST['preparationTime'])) {
				
				$_POST['preparationTime'] = 0;
				$_POST['positionPreparationTime'] = 'before_after';
				
			}
        	
        	if (!isset($_POST['flowOfBooking'])) {
        		
        		$_POST['flowOfBooking'] = 'calendar';
        		
        	}
        	
        	
        	$servicesPage = null;
        	if (intval($_POST['servicesPage']) != 0) {
        		
        		$servicesPage = intval($_POST['servicesPage']);
        		
        	}
        	
        	$calenarPage = null;
        	if (intval($_POST['calenarPage']) != 0) {
        		
        		$calenarPage = intval($_POST['calenarPage']);
        		
        	}
        	
        	$schedulesPage = null;
        	if (intval($_POST['schedulesPage']) != 0) {
        		
        		$schedulesPage = intval($_POST['schedulesPage']);
        		
        	}
        	
        	$visitorDetailsPage = null;
        	if (intval($_POST['visitorDetailsPage']) != 0) {
        		
        		$visitorDetailsPage = intval($_POST['visitorDetailsPage']);
        		
        	}
        	
        	$confirmDetailsPage = null;
        	if (intval($_POST['confirmDetailsPage']) != 0) {
        		
        		$confirmDetailsPage = intval($_POST['confirmDetailsPage']);
        		
        	}
        	
        	$thanksPage = null;
        	if (intval($_POST['thanksPage']) != 0) {
        		
        		$thanksPage = intval($_POST['thanksPage']);
        		
        	}
        	
        	$redirectPage = null;
        	if (intval($_POST['redirectPage']) != 0) {
        		
        		$redirectPage = intval($_POST['redirectPage']);
        		
        	}
			
			if (!isset($_POST['multipleRooms'])) {
				
				$_POST['multipleRooms'] = 0;
				
			}
			
			if (!isset($_POST['guestsBool'])) {
				
				$_POST['guestsBool'] = 0;
				
			}
			
			if (!isset($_POST['bookingVerificationCode'])) {
				
				$_POST['bookingVerificationCode'] = "false";
				
			}
			
			if (!isset($_POST['bookingVerificationCodeToUser'])) {
				
				$_POST['bookingVerificationCodeToUser'] = "false";
				
			}
			
			$limitNumberOfGuests = array(
				'minimumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
				'maximumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
			);
			
			if (isset($_POST['minimumGuests'])) {
				
				$limitNumberOfGuests['minimumGuests']['enabled'] = intval($_POST['minimumGuests']);
				$limitNumberOfGuests['minimumGuests']['included'] = intval($_POST['minimumGuestsRequiredNo']);
				$limitNumberOfGuests['minimumGuests']['number'] = intval($_POST['minimumGuestsOfValue']);
				
			}
			
			if (isset($_POST['maximumGuests'])) {
				
				$limitNumberOfGuests['maximumGuests']['enabled'] = intval($_POST['maximumGuests']);
				$limitNumberOfGuests['maximumGuests']['included'] = intval($_POST['maximumGuestsRequiredNo']);
				$limitNumberOfGuests['maximumGuests']['number'] = intval($_POST['maximumGuestsOfValue']);
				
			}
			
			/**
			$_POST['displayRemainingCapacityHasMoreThenThreshold'] = str_replace("\\", "", $_POST['displayRemainingCapacityHasMoreThenThreshold']);
			$_POST['displayRemainingCapacityHasLessThenThreshold'] = str_replace("\\", "", $_POST['displayRemainingCapacityHasLessThenThreshold']);
			$_POST['displayRemainingCapacityHas0'] = str_replace("\\", "", $_POST['displayRemainingCapacityHas0']);
			**/
			
			$_POST['displayRemainingCapacityHasMoreThenThreshold'] = stripslashes($_POST['displayRemainingCapacityHasMoreThenThreshold']);
			$_POST['displayRemainingCapacityHasLessThenThreshold'] = stripslashes($_POST['displayRemainingCapacityHasLessThenThreshold']);
			$_POST['displayRemainingCapacityHas0'] = stripslashes($_POST['displayRemainingCapacityHas0']);
			
			$isExtensionsValid = $this->getExtensionsValid(false);
			$hotelCharges = array(
				'hotelChargeOnSunday', 
				'hotelChargeOnMonday', 
				'hotelChargeOnTuesday', 
				'hotelChargeOnWednesday', 
				'hotelChargeOnThursday', 
				'hotelChargeOnFriday', 
				'hotelChargeOnSaturday', 
				'hotelChargeOnDayBeforeNationalHoliday', 
				'hotelChargeOnNationalHoliday',
			);
			
        	for ($i = 0; $i < count($hotelCharges); $i++) {
        		
        		$holidayKey = $hotelCharges[$i];
        		if (isset($_POST[$holidayKey]) === false) {
        			
        			$_POST[$holidayKey] = $_POST['cost'];
        			
        		}
        		/** else {
					
					if (intval($_POST[$holidayKey]) == 0) {
						
						$_POST[$holidayKey] = 0;
						
					}
					
					if (($holidayKey == 'hotelChargeOnDayBeforeNationalHoliday' || $holidayKey == 'hotelChargeOnNationalHoliday') && $isExtensionsValid === false) {
						
						$_POST[$holidayKey] = 0;
						
					}
					
				}
        		**/
        	}
			
			if ($isExtensionsValid == false) {
				
				#$_POST['enableFixCalendar'] = 0;
				$_POST['hasMultipleServices'] = 0;
				$_POST['displayRemainingCapacity'] = 0;
				$_POST['enableSubscriptionForStripe'] = 0;
				$_POST['cancellationOfBooking'] = 0;
				$_POST['allowCancellationVisitor'] = 0;
				$_POST['allowCancellationUser'] = 0;
				$_POST['refuseCancellationOfBooking'] = "not_refuse";
				$_POST['preparationTime'] = 0;
				$_POST['positionPreparationTime'] = 'before_after';
				$_POST['hotelChargeOnDayBeforeNationalHoliday'] = 0;
				$_POST['hotelChargeOnNationalHoliday'] = 0;
				$_POST['maximumNights'] = 0;
				$_POST['minimumNights'] = 0;
				$_POST['schedulesSharing'] = 0;
				$_POST['targetSchedules'] = 0;
				$_POST['blockSameTimeBookingByUser'] = 0;
				$_POST['bookingVerificationCode'] = 'false';
				$_POST['bookingVerificationCodeToUser'] = 'false';
				$_POST['bookingReminder'] = 60;
				$_POST['insertConfirmedPage'] = 0;
				$limitNumberOfGuests = array(
					'minimumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
					'maximumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
				);
				
			} else {
				
				$_POST['maximumNights'] = $this->getOnlyNumbers($_POST['maximumNights']);
				$_POST['minimumNights'] = $this->getOnlyNumbers($_POST['minimumNights']);
				
			}
			
			$_POST['numberOfRoomsAvailable'] = $this->getOnlyNumbers($_POST['numberOfRoomsAvailable']);
			$_POST['numberOfPeopleInRoom'] = $this->getOnlyNumbers($_POST['numberOfPeopleInRoom']);
			$_POST['maxAccountScheduleDay'] = $this->getOnlyNumbers($_POST['maxAccountScheduleDay']);
			
			$date = date('U');
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			
			$wpdb->insert(
				$table_name, 
				array(
					'name' => sanitize_text_field($_POST['name']), 
					'type' => sanitize_text_field($type), 
					'status' => sanitize_text_field($_POST['status']), 
					'courseTitle' => sanitize_text_field($_POST['courseTitle']), 
					'courseBool' => intval($_POST['courseBool']),
					'created' => sanitize_text_field($date), 
					'uploadDate' => sanitize_text_field($date),
					'cost' => intval($_POST['cost']),
					'numberOfRoomsAvailable' => intval($_POST['numberOfRoomsAvailable']),
					'numberOfPeopleInRoom' => intval($_POST['numberOfPeopleInRoom']),
					'includeChildrenInRoom' => intval($_POST['includeChildrenInRoom']),
					'expressionsCheck' => intval($_POST['expressionsCheck']),
					'monthForFixCalendar' => intval($_POST['monthForFixCalendar']),
					'yearForFixCalendar' => intval($_POST['yearForFixCalendar']),
					'enableFixCalendar' => intval($_POST['enableFixCalendar']),
					'displayRemainingCapacity' => intval($_POST['displayRemainingCapacity']),
					'maxAccountScheduleDay' => intval($_POST['maxAccountScheduleDay']),
					'unavailableDaysFromToday' => intval($_POST['unavailableDaysFromToday']),
					'subscriptionIdForStripe' => sanitize_text_field($_POST['subscriptionIdForStripe']),
					'enableSubscriptionForStripe' => intval($_POST['enableSubscriptionForStripe']),
					'termsOfServiceForSubscription' => esc_url($_POST['termsOfServiceForSubscription']),
					'enableTermsOfServiceForSubscription' => intval($_POST['enableTermsOfServiceForSubscription']),
					'privacyPolicyForSubscription' => esc_url($_POST['privacyPolicyForSubscription']),
					'enablePrivacyPolicyForSubscription' => intval($_POST['enablePrivacyPolicyForSubscription']),
					'displayRemainingCapacityInCalendar' => intval($_POST['displayRemainingCapacityInCalendar']),
					'displayThresholdOfRemainingCapacity' => intval($_POST['displayThresholdOfRemainingCapacity']),
					'displayRemainingCapacityHasMoreThenThreshold' => sanitize_text_field($_POST['displayRemainingCapacityHasMoreThenThreshold']),
					'displayRemainingCapacityHasLessThenThreshold' => sanitize_text_field($_POST['displayRemainingCapacityHasLessThenThreshold']),
					'displayRemainingCapacityHas0' => sanitize_text_field($_POST['displayRemainingCapacityHas0']),
					'icalToken' => hash('ripemd160', date('U')),
					'cancellationOfBooking' => intval($_POST['cancellationOfBooking']),
					'allowCancellationVisitor' => intval($_POST['allowCancellationVisitor']),
					'allowCancellationUser' => intval($_POST['allowCancellationUser']),
					'refuseCancellationOfBooking' => sanitize_text_field($_POST['refuseCancellationOfBooking']),
					'preparationTime' => intval($_POST['preparationTime']),
					'positionPreparationTime' => sanitize_text_field($_POST['positionPreparationTime']),
					'displayDetailsOfCanceled' => intval($_POST['displayDetailsOfCanceled']),
					'timezone' => sanitize_text_field($_POST['timezone']),
					'displayRemainingCapacityInCalendarAsNumber' => intval($_POST['displayRemainingCapacityInCalendarAsNumber']),
					'hasMultipleServices' => intval($_POST['hasMultipleServices']),
					'flowOfBooking' => sanitize_text_field($_POST['flowOfBooking']),
					'paymentMethod' => sanitize_text_field($_POST['paymentMethod']),
					'email_from' => sanitize_text_field(trim($_POST['email_from'])),
					'email_to' => sanitize_text_field(trim($_POST['email_to'])),
					'email_from_title' => sanitize_text_field(trim($_POST['email_from_title'])),
					'servicesPage' => $servicesPage,
					'calenarPage' => $calenarPage,
					'schedulesPage' => $schedulesPage,
					'visitorDetailsPage' => $visitorDetailsPage,
					'thanksPage' => $thanksPage, 
					'redirectPage' => $redirectPage,
					'hotelChargeOnSunday' => intval($_POST['hotelChargeOnSunday']),
					'hotelChargeOnMonday' => intval($_POST['hotelChargeOnMonday']),
					'hotelChargeOnTuesday' => intval($_POST['hotelChargeOnTuesday']),
					'hotelChargeOnWednesday' => intval($_POST['hotelChargeOnWednesday']),
					'hotelChargeOnThursday' => intval($_POST['hotelChargeOnThursday']),
					'hotelChargeOnFriday' => intval($_POST['hotelChargeOnFriday']),
					'hotelChargeOnSaturday' => intval($_POST['hotelChargeOnSaturday']),
					'hotelChargeOnDayBeforeNationalHoliday' => intval($_POST['hotelChargeOnDayBeforeNationalHoliday']),
					'hotelChargeOnNationalHoliday' => intval($_POST['hotelChargeOnNationalHoliday']),
					'maximumNights' => intval($_POST['maximumNights']),
					'minimumNights' => intval($_POST['minimumNights']),
					'schedulesSharing' => intval($_POST['schedulesSharing']),
					'targetSchedules' => intval($_POST['targetSchedules']),
					'multipleRooms' => intval($_POST['multipleRooms']),
					'redirectURL' => sanitize_text_field($_POST['redirectURL']),
					'redirectMode' => sanitize_text_field($_POST['redirectMode']),
					'guestsBool' => intval($_POST['guestsBool']),
					'limitNumberOfGuests' => json_encode($limitNumberOfGuests),
					'blockSameTimeBookingByUser' => intval($_POST['blockSameTimeBookingByUser']),
					'bookingVerificationCode' => sanitize_text_field($_POST['bookingVerificationCode']),
					'bookingVerificationCodeToUser' => sanitize_text_field($_POST['bookingVerificationCodeToUser']),
					'bookingReminder' => intval($_POST['bookingReminder']),
					'insertConfirmedPage' => intval($_POST['insertConfirmedPage']),
					'confirmDetailsPage' => $confirmDetailsPage,
					'formatNightDay' => intval($_POST['formatNightDay']),
				), 
				array(
					'%s', '%s', '%s', '%s', '%d', '%s', '%s', '%d', '%d', '%d', 
					'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', 
					'%s', '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s',
					'%d', '%d', '%d', '%s', '%d', '%s', '%d', '%s', '%d', '%d',
					'%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', 
					'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
					'%d', '%d', '%d', '%d', '%d', '%s', '%s', '%d', '%s', '%d',
					'%s', '%s', '%d', '%d', '%d', '%d', 
				)
			);
    		
    		$accountKey = $wpdb->insert_id;
    		$this->addGuests($accountKey, $type);
    		if($type == 'hotel'){
    			
    			$this->insertAccountSchedule(date('m'), date('d'), date('Y'), $accountKey);
    			
    		}
    		
    		do_action('booking_package_add_calendar_account', $accountKey);
    		#return $this->getCalendarAccountListData();
    		return array('getCalendarAccountListData' => $this->getCalendarAccountListData(), 'accountKey' => $accountKey);
        	
        }
        
        public function createCloneCalendar() {
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$tmp_table_name = $table_name."_tmp";
			#$sql = "CREATE TEMPORARY TABLE " . $tmp_table_name . " FROM " . $table_name . " WHERE `key` = %d;";
			$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `key` = %d;", array(intval($_POST['accountKey'])));
			$wpdb->query($sql);
			$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
			$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
			$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
			$accountKey = $wpdb->insert_id;
			
			$targetList = array(
				'schedules' => 'booking_package_templateSchedule', 
				'form' => 'booking_package_form', 
				'services' => 'booking_package_courseData', 
				'guests' => 'booking_package_guests', 
				'taxes' => 'booking_package_taxes', 
				'emails' => 'booking_package_emailSetting', 
				'subscriptions' => 'booking_package_subscriptions'
			);
			
			foreach ((array) $targetList as $key => $table) {
				
				if (isset($_POST[$key]) && intval($_POST[$key]) == 1) {
					
					$table_name = $wpdb->prefix.$table;
					$tmp_table_name = $table_name."_tmp";
					$sql = $wpdb->prepare("CREATE TEMPORARY TABLE " . $tmp_table_name . " SELECT * FROM " . $table_name . " WHERE `accountKey` = %d;", array(intval($_POST['accountKey'])));
					$wpdb->query($sql);
					$wpdb->query("ALTER TABLE " . $tmp_table_name . " drop `key`;");
					$wpdb->query("UPDATE " . $tmp_table_name . " SET `accountKey` = " . $accountKey . ";");
					$wpdb->query("INSERT INTO " . $table_name . " SELECT 0," . $tmp_table_name . ".* FROM " . $tmp_table_name . ";");
					$wpdb->query("DROP TABLE " . $tmp_table_name . ";");
					
				}
				
			}
			
			do_action('booking_package_add_clone_calendar_account', $accountKey);
			return $this->getCalendarAccountListData();

        }
        
        public function getIcalToken($accountKey){
        	
        	$calendarAccount = $this->getCalendarAccount($accountKey);
        	return array("status" => "success", "ical" => $calendarAccount['ical'], "syncPastCustomersForIcal" => $calendarAccount['syncPastCustomersForIcal'], "icalToken" => $calendarAccount['icalToken'], 'home' => get_home_url());
        	
        }
        
        public function updateIcalToken(){
        	
        	if (isset($_POST['accountKey']) && isset($_POST['ical'])) {
        		
        		global $wpdb;
	        	$table_name = $wpdb->prefix . "booking_package_calendarAccount";
	        	$bool = $wpdb->update(
					$table_name,
					array(
						'ical' => intval($_POST['ical']), 
						'syncPastCustomersForIcal' => intval($_POST['syncPastCustomersForIcal']), 
					),
					array('key' => intval($_POST['accountKey'])),
					array('%d', '%d'),
					array('%d')
				);
	            
	            return array('status' => 'success', 'key' => $_POST['accountKey']);
        		
        	} else {
        		
        		return array('status' => 'error', 'key' => $_POST['accountKey']);
        		
        	}
        	
        	
        }
        
        public function refreshIcalToken($key, $home = false){
            
            $key = intval($key);
            $token = hash('ripemd160', date('U').$key);
            global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	$bool = $wpdb->update(
				$table_name,
				array(
					'icalToken' => $token, 
				),
				array('key' => $key),
				array('%s'),
				array('%d')
			);
            
            return array('status' => 'success', 'token' => $token, 'key' => $key);
            
        }
        
        public function updateCalendarAccount(){
			
			$deleteSchedules = false;
			$postList = array('cost' => 0, 'numberOfRoomsAvailable' => 1, 'numberOfPeopleInRoom' => 2, 'includeChildrenInRoom' => 0);
			foreach ((array) $postList as $key => $value) {
				
				if (!isset($_POST[$key])) {
					
					$_POST[$key] = $value;
					
				}
				
			}
			
			if (!isset($_POST['timezone'])) {
				
				$_POST['timezone'] = "none";
				
			}
			
			if (!isset($_POST['blockSameTimeBookingByUser'])) {
				
				$_POST['blockSameTimeBookingByUser'] = 0;
				
			}
			
			if (!isset($_POST['allowCancellationUser'])) {
				
				$_POST['allowCancellationUser'] = 0;
				
			}
			
			if (!isset($_POST['bookingReminder'])) {
				
				$_POST['bookingReminder'] = 60;
				
			}
			
			if (!isset($_POST['insertConfirmedPage'])) {
				
				$_POST['insertConfirmedPage'] = 0;
				
			}
			
			$calendarAccount = $this->getCalendarAccount($_POST['accountKey']);
			$_POST['maxAccountScheduleDay'] = $this->getOnlyNumbers($_POST['maxAccountScheduleDay']);
			if (intval($_POST['maxAccountScheduleDay']) < intval($calendarAccount['maxAccountScheduleDay']) /** && $calendarAccount['type'] == 'hotel'**/) {
				
				$deleteSchedules = true;
				if (isset($_POST['remakeBookingSchedules']) && intval($_POST['remakeBookingSchedules']) == 0) {
					
					$deleteSchedules = false;
					
				}
				
			}
			
			if ($_POST['timezone'] != 'none' && $_POST['timezone'] != $calendarAccount['timezone']) {
				
				$this->updateUnixTimeOnBookingData($_POST['accountKey'], $_POST['timezone']);
				
			}
			
			if (!isset($_POST['enableSubscriptionForStripe'])) {
				
				$_POST['subscriptionIdForStripe'] = "";
				$_POST['enableSubscriptionForStripe'] = 0;
				$_POST['termsOfServiceForSubscription'] = "";
				$_POST['enableTermsOfServiceForSubscription'] = 0;
				$_POST['privacyPolicyForSubscription'] = "";
				$_POST['enablePrivacyPolicyForSubscription'] = 0;
				
			}
			
			if (!isset($_POST['displayRemainingCapacityInCalendar'])) {
				
				$_POST['displayRemainingCapacityInCalendar'] = 0;
				$_POST['displayThresholdOfRemainingCapacity'] = 50;
				$_POST['displayRemainingCapacityHasMoreThenThreshold'] = "";
				$_POST['displayRemainingCapacityHasLessThenThreshold'] = "";
				$_POST['displayRemainingCapacityHas0'] = "";
				
			}
			
			if (!isset($_POST['cancellationOfBooking'])) {
				
				$_POST['cancellationOfBooking'] = 0;
				$_POST['allowCancellationVisitor'] = 0;
				$_POST['allowCancellationUser'] = 0;
				$_POST['refuseCancellationOfBooking'] = "not_refuse";
				
			}
			
			if (!isset($_POST['preparationTime'])) {
				
				$_POST['preparationTime'] = 0;
				$_POST['positionPreparationTime'] = 'before_after';
				
			}
			
			if (!isset($_POST['flowOfBooking'])) {
				
				$_POST['flowOfBooking'] = 'calendar';
				
			}
			
			$servicesPage = null;
			if (intval($_POST['servicesPage']) != 0) {
				
				$servicesPage = intval($_POST['servicesPage']);
				
			}
			
			$calenarPage = null;
			if (intval($_POST['calenarPage']) != 0) {
				
				$calenarPage = intval($_POST['calenarPage']);
				
			}
			
			$schedulesPage = null;
			if (intval($_POST['schedulesPage']) != 0) {
				
				$schedulesPage = intval($_POST['schedulesPage']);
				
			}
			
			$visitorDetailsPage = null;
			if (intval($_POST['visitorDetailsPage']) != 0) {
				
				$visitorDetailsPage = intval($_POST['visitorDetailsPage']);
				
			}
			
			$confirmDetailsPage = null;
			if (intval($_POST['confirmDetailsPage']) != 0) {
				
				$confirmDetailsPage = intval($_POST['confirmDetailsPage']);
				
			}
			
        	$thanksPage = null;
        	if (intval($_POST['thanksPage']) != 0) {
        		
        		$thanksPage = intval($_POST['thanksPage']);
        		
        	}
        	
        	$redirectPage = null;
        	if (intval($_POST['redirectPage']) != 0) {
        		
        		$redirectPage = intval($_POST['redirectPage']);
        		
        	}
			
			if (!isset($_POST['multipleRooms'])) {
				
				$_POST['multipleRooms'] = 0;
				
			}
			
			if (!isset($_POST['guestsBool'])) {
				
				$_POST['guestsBool'] = 0;
				
			}
			
			if (!isset($_POST['bookingVerificationCode'])) {
				
				$_POST['bookingVerificationCode'] = 'false';
				
			}
			
			if (!isset($_POST['bookingVerificationCodeToUser'])) {
				
				$_POST['bookingVerificationCodeToUser'] = 'false';
				
			}
			
			$limitNumberOfGuests = array(
				'minimumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
				'maximumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
			);
			
			if (isset($_POST['minimumGuests'])) {
				
				$limitNumberOfGuests['minimumGuests']['enabled'] = intval($_POST['minimumGuests']);
				$limitNumberOfGuests['minimumGuests']['included'] = intval($_POST['minimumGuestsRequiredNo']);
				$limitNumberOfGuests['minimumGuests']['number'] = intval($_POST['minimumGuestsOfValue']);
				
			}
			
			if (isset($_POST['maximumGuests'])) {
				
				$limitNumberOfGuests['maximumGuests']['enabled'] = intval($_POST['maximumGuests']);
				$limitNumberOfGuests['maximumGuests']['included'] = intval($_POST['maximumGuestsRequiredNo']);
				$limitNumberOfGuests['maximumGuests']['number'] = intval($_POST['maximumGuestsOfValue']);
				
			}
			
			/**
			$_POST['displayRemainingCapacityHasMoreThenThreshold'] = str_replace("\\", "", $_POST['displayRemainingCapacityHasMoreThenThreshold']);
			$_POST['displayRemainingCapacityHasLessThenThreshold'] = str_replace("\\", "", $_POST['displayRemainingCapacityHasLessThenThreshold']);
			$_POST['displayRemainingCapacityHas0'] = str_replace("\\", "", $_POST['displayRemainingCapacityHas0']);
			**/
			
			$_POST['displayRemainingCapacityHasMoreThenThreshold'] = stripslashes($_POST['displayRemainingCapacityHasMoreThenThreshold']);
			$_POST['displayRemainingCapacityHasLessThenThreshold'] = stripslashes($_POST['displayRemainingCapacityHasLessThenThreshold']);
			$_POST['displayRemainingCapacityHas0'] = stripslashes($_POST['displayRemainingCapacityHas0']);
			
			$isExtensionsValid = $this->getExtensionsValid(false);
			$hotelCharges = array(
				'hotelChargeOnSunday', 
				'hotelChargeOnMonday', 
				'hotelChargeOnTuesday', 
				'hotelChargeOnWednesday', 
				'hotelChargeOnThursday', 
				'hotelChargeOnFriday', 
				'hotelChargeOnSaturday', 
				'hotelChargeOnDayBeforeNationalHoliday', 
				'hotelChargeOnNationalHoliday',
			);
			
			for ($i = 0; $i < count($hotelCharges); $i++) {
				
				$holidayKey = $hotelCharges[$i];
				if (isset($_POST[$holidayKey]) === false) {
					
					$_POST[$holidayKey] = $_POST['cost'];
					
				}
				/**else {
					
					if (intval($_POST[$holidayKey]) == 0) {
						
						$_POST[$holidayKey] = 0;
						
					}
					
					if (($holidayKey == 'hotelChargeOnDayBeforeNationalHoliday' || $holidayKey == 'hotelChargeOnNationalHoliday') && $isExtensionsValid === false) {
						
						$_POST[$holidayKey] = 0;
						
					}
					
				}
				**/
				
			}
			
			if ($isExtensionsValid === false) {
				
				#$_POST['enableFixCalendar'] = 0;
				$_POST['hasMultipleServices'] = 0;
				$_POST['displayRemainingCapacity'] = 0;
				$_POST['enableSubscriptionForStripe'] = 0;
				$_POST['cancellationOfBooking'] = 0;
				$_POST['allowCancellationVisitor'] = 0;
				$_POST['allowCancellationUser'] = 0;
				$_POST['refuseCancellationOfBooking'] = "not_refuse";
				$_POST['preparationTime'] = 0;
				$_POST['positionPreparationTime'] = 'before_after';
				$_POST['hotelChargeOnDayBeforeNationalHoliday'] = 0;
				$_POST['hotelChargeOnNationalHoliday'] = 0;
				$_POST['maximumNights'] = 0;
				$_POST['minimumNights'] = 0;
				$_POST['blockSameTimeBookingByUser'] = 0;
				$_POST['bookingVerificationCode'] = 'false';
				$_POST['bookingVerificationCodeToUser'] = 'false';
				$_POST['bookingReminder'] = 60;
				$_POST['insertConfirmedPage'] = 0;
				$limitNumberOfGuests = array(
					'minimumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
					'maximumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
				);
				
			} else {
				
				$_POST['maximumNights'] = $this->getOnlyNumbers($_POST['maximumNights']);
				$_POST['minimumNights'] = $this->getOnlyNumbers($_POST['minimumNights']);
				
			}
			
			$_POST['numberOfRoomsAvailable'] = $this->getOnlyNumbers($_POST['numberOfRoomsAvailable']);
			$_POST['numberOfPeopleInRoom'] = $this->getOnlyNumbers($_POST['numberOfPeopleInRoom']);
			
			$date = date('U');
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$wpdb->query("START TRANSACTION");
			$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
			try {
				
				$bool = $wpdb->update(
					$table_name,
					array(
						'name' => sanitize_text_field($_POST['name']), 
						'status' => sanitize_text_field($_POST['status']), 
						'courseTitle' => sanitize_text_field($_POST['courseTitle']),
						'courseBool' => intval($_POST['courseBool']),
						'uploadDate' => date('U'),
						'cost' => intval($_POST['cost']),
						'numberOfRoomsAvailable' => intval($_POST['numberOfRoomsAvailable']),
						'numberOfPeopleInRoom' => intval($_POST['numberOfPeopleInRoom']),
						'includeChildrenInRoom' => intval($_POST['includeChildrenInRoom']),
						'expressionsCheck' => intval($_POST['expressionsCheck']),
						'monthForFixCalendar' => intval($_POST['monthForFixCalendar']),
						'yearForFixCalendar' => intval($_POST['yearForFixCalendar']),
						'maxAccountScheduleDay' => intval($_POST['maxAccountScheduleDay']),
						'unavailableDaysFromToday' => intval($_POST['unavailableDaysFromToday']),
						'enableFixCalendar' => intval($_POST['enableFixCalendar']),
						'displayRemainingCapacity' => intval($_POST['displayRemainingCapacity']),
						'subscriptionIdForStripe' => sanitize_text_field($_POST['subscriptionIdForStripe']),
						'enableSubscriptionForStripe' => intval($_POST['enableSubscriptionForStripe']),
						'termsOfServiceForSubscription' => esc_url($_POST['termsOfServiceForSubscription']),
						'enableTermsOfServiceForSubscription' => intval($_POST['enableTermsOfServiceForSubscription']),
						'privacyPolicyForSubscription' => esc_url($_POST['privacyPolicyForSubscription']),
						'enablePrivacyPolicyForSubscription' => intval($_POST['enablePrivacyPolicyForSubscription']),
						'displayRemainingCapacityInCalendar' => intval($_POST['displayRemainingCapacityInCalendar']),
						'displayThresholdOfRemainingCapacity' => intval($_POST['displayThresholdOfRemainingCapacity']),
						'displayRemainingCapacityHasMoreThenThreshold' => sanitize_text_field($_POST['displayRemainingCapacityHasMoreThenThreshold']),
						'displayRemainingCapacityHasLessThenThreshold' => sanitize_text_field($_POST['displayRemainingCapacityHasLessThenThreshold']),
						'displayRemainingCapacityHas0' => sanitize_text_field($_POST['displayRemainingCapacityHas0']),
						'startOfWeek' => intval($_POST['startOfWeek']),
						'cancellationOfBooking' => intval($_POST['cancellationOfBooking']),
						'allowCancellationVisitor' => intval($_POST['allowCancellationVisitor']),
						'allowCancellationUser' => intval($_POST['allowCancellationUser']),
						'refuseCancellationOfBooking' => sanitize_text_field($_POST['refuseCancellationOfBooking']),
						'preparationTime' => intval($_POST['preparationTime']),
						'positionPreparationTime' => sanitize_text_field($_POST['positionPreparationTime']),
						'displayDetailsOfCanceled' => intval($_POST['displayDetailsOfCanceled']),
						'displayRemainingCapacityInCalendarAsNumber' => intval($_POST['displayRemainingCapacityInCalendarAsNumber']),
						'hasMultipleServices' => intval($_POST['hasMultipleServices']),
						'flowOfBooking' => sanitize_text_field($_POST['flowOfBooking']),
						'paymentMethod' => sanitize_text_field($_POST['paymentMethod']),
						'email_from' => sanitize_text_field(trim($_POST['email_from'])),
						'email_to' => sanitize_text_field(trim($_POST['email_to'])),
						'email_from_title' => sanitize_text_field(trim($_POST['email_from_title'])),
						'servicesPage' => $servicesPage,
						'calenarPage' => $calenarPage,
						'schedulesPage' => $schedulesPage,
						'visitorDetailsPage' => $visitorDetailsPage,
						'thanksPage' => $thanksPage, 
						'redirectPage' => $redirectPage, 
						'hotelChargeOnSunday' => intval($_POST['hotelChargeOnSunday']),
						'hotelChargeOnMonday' => intval($_POST['hotelChargeOnMonday']),
						'hotelChargeOnTuesday' => intval($_POST['hotelChargeOnTuesday']),
						'hotelChargeOnWednesday' => intval($_POST['hotelChargeOnWednesday']),
						'hotelChargeOnThursday' => intval($_POST['hotelChargeOnThursday']),
						'hotelChargeOnFriday' => intval($_POST['hotelChargeOnFriday']),
						'hotelChargeOnSaturday' => intval($_POST['hotelChargeOnSaturday']),
						'hotelChargeOnDayBeforeNationalHoliday' => intval($_POST['hotelChargeOnDayBeforeNationalHoliday']), 
						'hotelChargeOnNationalHoliday' => intval($_POST['hotelChargeOnNationalHoliday']),
						'maximumNights' => intval($_POST['maximumNights']),
						'minimumNights' => intval($_POST['minimumNights']),
						'multipleRooms' => intval($_POST['multipleRooms']),
						'redirectURL' => sanitize_text_field($_POST['redirectURL']),
						'redirectMode' => sanitize_text_field($_POST['redirectMode']),
						'guestsBool' => intval($_POST['guestsBool']),
						'limitNumberOfGuests' => json_encode($limitNumberOfGuests),
						'blockSameTimeBookingByUser' => intval($_POST['blockSameTimeBookingByUser']),
						'bookingVerificationCode' => sanitize_text_field($_POST['bookingVerificationCode']),
						'bookingVerificationCodeToUser' => sanitize_text_field($_POST['bookingVerificationCodeToUser']),
						'bookingReminder' => intval($_POST['bookingReminder']),
						'insertConfirmedPage' => intval($_POST['insertConfirmedPage']),
						'confirmDetailsPage' => $confirmDetailsPage,
						'formatNightDay' => intval($_POST['formatNightDay']),
					),
					array('key' => intval($_POST['accountKey'])),
					array(
						'%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
						'%d', '%d', '%d', '%d', '%s', '%d', '%s', '%d', '%s', '%d', 
						'%d', '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d',
						'%d', '%s', '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', 
						'%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
						'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
						'%s', '%s', '%d', '%s', '%d', '%s', '%s', '%d', '%d', '%d',
						'%d', 
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
			
			if ($deleteSchedules === true) {
				
				$date = date('U') + (intval($_POST['maxAccountScheduleDay']) * 1440 * 60);
				$_POST['deletePublishedSchedules_from_month'] = date('n', $date);
				$_POST['deletePublishedSchedules_from_day'] = date('j', $date);
				$_POST['deletePublishedSchedules_from_year'] = date('Y', $date);
				$_POST['deletePublishedSchedules_to_month'] = date('n', $date);
				$_POST['deletePublishedSchedules_to_day'] = date('j', $date);
				$_POST['deletePublishedSchedules_to_year'] = date('Y', $date);
				$_POST['period'] = 'period_after';
				$_POST['deletionType'] = 'perfect';
				$_POST['delete_action'] = 'delete';
				$this->deletePublishedSchedules($_POST['accountKey'], $calendarAccount['type']);
				
			}
			
			if ($bool === 1) {
				
				return $this->getCalendarAccountListData();
				
			} else {
				
				return array("status" => $bool);
				
			}
			
        }
        
        public function updateAccountFunction($accountKey, $name, $value) {
        	
        	$date = date('U');
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$wpdb->query("START TRANSACTION");
			$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
			try {
				
				$bool = $wpdb->update(
					$table_name,
					array(
						sanitize_text_field($name) => intval($value),
						'uploadDate' => date('U'),
					),
					array('key' => intval($accountKey)),
					array(
						'%d', '%d'
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
			
			return $this->getCalendarAccountListData();
        	
        }
        
        public function updateUnixTimeOnBookingData($accountKey = null, $timezone = null) {
        	
        	if (is_null($accountKey)) {
        		
        		return false;
        		
        	}
        	
        	#var_dump($timezone);
        	if (date_default_timezone_set($timezone)) {
        		
        		global $wpdb;
	        	$table_name = $wpdb->prefix."booking_package_schedule";
	        	$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `status` = 'open';", array($accountKey));
	        	$rows = $wpdb->get_results($sql, ARRAY_A);
				foreach ((array) $rows as $row) {
					
					$unixTime = date('U', mktime($row['hour'], $row['min'], 0, $row['month'], $row['day'], $row['year']));
					$bool = $wpdb->update( 
		        		$table_name,
						array(
							'unixTime' => intval($unixTime), 
						),
						array('key' => intval($row['key'])),
						array('%d'),
						array('%d')
					);
					
					$table_userPraivateData = $wpdb->prefix."booking_package_userPraivateData";
					$bool = $wpdb->update( 
		        		$table_userPraivateData,
						array(
							'scheduleUnixTime' => intval($unixTime), 
						),
						array('scheduleKey' => intval($row['key'])),
						array('%d'),
						array('%d')
					);
					
				}
				
				return true;
        		
        	}
        	
        	return false;
        	
        }
        
        public function updateCalendarAccountForGoogleWebhook($accountKey, $idForGoogleWebhook, $expirationForGoogleWebhook){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	
        	$bool = $wpdb->update( 
        		$table_name,
				array(
					'idForGoogleWebhook' => sanitize_text_field($idForGoogleWebhook), 
					'expirationForGoogleWebhook' => sanitize_text_field($expirationForGoogleWebhook)
				),
				array('key' => intval($accountKey)),
				array('%s', '%s', '%s'),
				array('%d')
			);
			
        	if($bool === 1){
        		
        		$key = $this->prefix."id_for_google_webhook";
        		if(get_option($key) === false){
        			
        			add_option($key, sanitize_text_field($idForGoogleWebhook));
        			
        		}else{
        			
        			update_option($key, sanitize_text_field($idForGoogleWebhook));
        			
				}
        		
        		return $this->getCalendarAccountListData();
        		
        	}else{
        		
        		return array("status" => $bool);
        		
        	}
        	
        	
        }
        
        
        
        public function lookingForGoogleCalendarId($googleCalendarId = false){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
        	if($googleCalendarId != false){
        		
        		$sql = $wpdb->prepare(
        			"SELECT `key`,`type`,`googleCalendarID`,`idForGoogleWebhook`,`expirationForGoogleWebhook` FROM ".$table_name." WHERE `idForGoogleWebhook` = %s;", 
        			array(sanitize_text_field($googleCalendarId))
        		);
        		$row = $wpdb->get_row($sql, ARRAY_A);
				if(strlen($row['type']) == 0 || is_null($row['type'])){
					
					$row['type'] = 'day';
					
				}
        		
        		return $row;
        		
        	}
        	
        	return null;
        	
        }
        
        public function deleteCalendarAccount(){
			
			global $wpdb;
			
			$response = array();
			$table_name = $wpdb->prefix."booking_package_calendarAccount";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `schedulesSharing` = %d AND `targetSchedules` = %d;", array(1, $_POST['accountKey']));
			$rows = $wpdb->get_results($sql, ARRAY_A);
			if (count($rows) == 0) {
				
				$table_name = $wpdb->prefix."booking_package_form";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_courseData";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_schedule";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_templateSchedule";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_calendarAccount";
				$wpdb->delete($table_name, array('key' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_emailSetting";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_guests";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_taxes";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$table_name = $wpdb->prefix."booking_package_subscriptions";
				$wpdb->delete($table_name, array('accountKey' => intval($_POST['accountKey'])), array('%d'));
				
				$response = $this->getCalendarAccountListData();
				
			} else {
				
				$calendarNameList = array();
				foreach ((array) $rows as $key => $row) {
					
					array_push($calendarNameList, $row['name']);
					
				}
				$calendarName = implode("\n", $calendarNameList);
				$response = array('error' => 1, 'message' => __('If you want to delete this calendar, delete the calendar sharing the schedules.', $this->pluginName) . "\n" . $calendarName);
				
			}
			
			do_action('booking_package_delete_calendar_account', intval($_POST['accountKey']));
			return $response;
			
        }
        
        public function addGuests($accountKey, $type = 'day') {
			
			global $wpdb;
			
			$setting = new booking_package_setting($this->prefix, $this->pluginName);
			$numberKeys = $setting->getListOfDaysOfWeek();
			
			$table_name = $wpdb->prefix . "booking_package_guests";
			if ($type == 'day') {
				
				$guestsList = array(
					0 => array("number" => 1, "price" => 0, "name" => "1 person"),
					1 => array("number" => 2, "price" => 0, "name" => "2 persons"),
					2 => array("number" => 3, "price" => 0, "name" => "3 persons"),
					3 => array("number" => 4, "price" => 0, "name" => "4 persons"),
				);
				
				$wpdb->insert(
					$table_name, 
					array(
						'accountKey' => intval($accountKey), 
						'name' => "Number of participants", 
						'target' => "adult",
						'json' => json_encode($guestsList), 
						'required' => 1,
						'ranking' => 1
					), 
					array('%d', '%s', '%s', '%s', '%d')
				);
				
        	} else {
				
				$guestsList = array(
					0 => array("number" => 1, "price" => 0, "name" => "1 adult"),
					1 => array("number" => 2, "price" => 0, "name" => "2 adults"),
				);
				
				for ($i = 0; $i < count($numberKeys); $i++) {
					
					$guestsList[0][$numberKeys[$i]] = 0;
					$guestsList[1][$numberKeys[$i]] = 0;
					
				}
				
				$wpdb->insert(
					$table_name, 
					array(
						'accountKey' => intval($accountKey), 
						'name' => "Number of adults", 
						'target' => "adult",
						'json' => json_encode($guestsList), 
						'required' => 1,
						'ranking' => 1
					), 
					array('%d', '%s', '%s', '%s', '%d')
				);
				
				$guestsList[0]['name'] = '1 child';
				$guestsList[1]['name'] = '2 children';
				
				$wpdb->insert(
					$table_name, 
					array(
						'accountKey' => intval($accountKey), 
						'name' => "Number of children", 
						'target' => "children",
						'json' => json_encode($guestsList), 
						'required' => 0,
						'ranking' => 2
					), 
					array('%d', '%s', '%s', '%s', '%d')
				);
				
			}
			
        }
        
        public function getAccountSchedule($key) {
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix . "booking_package_schedule";
			$sql = $wpdb->prepare(
				"SELECT * FROM `" . $table_name . "` WHERE `key` = %d;", 
				array(intval($key))
			);
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				return false;
				
			}
			
			return $row;
        	
        }
        
        public function getAccountScheduleData($getDeletedDate = false){
        	
        	global $wpdb;
        	$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
        	
        	$month = intval($_POST['month']);
        	$day = intval($_POST['day']);
        	$year = intval($_POST['year']);
        	
			$last_day = date('t', mktime(0, 0, 0, $month, $day, $year));
			$week_start_num = date('w', mktime(0, 0, 0, $month, $day, $year));
			$week_last_num = date('w', mktime(0, 0, 0, $month, $last_day, $year));
			
			$scheduleData = array();
			$jsonAraay = array('completeFlag' => 'accountScheduleData', 'startDay' => 1, 'lastDay' => intval($last_day), 'startWeek' => intval($week_start_num), 'lastWeek' => intval($week_last_num), 'month' => intval($month), 'year' => intval($year), 'timestamp' => date('U'));
			$scheduleData['date'] = $jsonAraay;
			/**
			$calendarList = array();
			if(intval($week_start_num) != 0){
				
				$lastUnixTime = date('U', mktime(0, 0, 0, $month, 1, $year)) - 1;
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = intval(date('t', $lastUnixTime));
				$startDay = $endDay - intval(date('w', $lastUnixTime));
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array('startDay' => $startDay, 'lastDay' => $endDay, 'startWeek' => intval(date('w', mktime(0, 0, 0, $lastMonth, $startDay, $lastYear))), 'lastWeek' => intval(date('w', $lastUnixTime)), 'year' => $lastYear, 'month' => intval($lastMonth), 'day' => $startDay);
				
			}
			
			$calendarList[intval($year.sprintf('%02d', $month))] = $jsonAraay;
			
			if(intval($week_last_num) != 6){
				
				$lastUnixTime = date('U', mktime(23, 60, 0, $month, $last_day, $year));
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = 7 - intval(date('w', $lastUnixTime));
				$startDay = 1;
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array('startDay' => $startDay, 'lastDay' => $endDay, 'startWeek' => intval(date('w', $lastUnixTime)), 'lastWeek' => 6, 'year' => $lastYear, 'month' => intval($lastMonth), 'day' => $startDay);
				
			}
			**/
			
			$calendarAccount = $this->getCalendarAccount($accountKey);
			$calendarList = $this->getCalendarList($month, $day, $year, $calendarAccount['startOfWeek']);
			
			$list = array();
			$deletedList = array();
			foreach ((array) $calendarList as $key => $value) {
				
				for ($i = $value['startDay']; $i <= $value['lastDay']; $i++) {
					
					$key = $value['year'].sprintf("%02d%02d", $value['month'], $i);
					$week = date('w', mktime(0, 0, 0, $value['month'], $i, $value['year']));
					$dayArray = array('year' => $value['year'], 'month' => $value['month'], 'day' => $i, 'week' => $week, 'count' => null, 'accountKey' => $accountKey, 'status' => 0);
					$list[$key] = $dayArray;
					$deletedList[$key] = $dayArray;
					
				}
				
				$table_name = $wpdb->prefix."booking_package_schedule";
				$sql = $wpdb->prepare(
					"SELECT year,month,day,accountKey,SUM(capacity),SUM(remainder),COUNT(day) FROM `".$table_name."` GROUP BY `year`,`month`,`day`,`holiday`,`accountKey`,`status` HAVING `accountKey` = %d AND `year` = %d AND `month` = %d AND (`day` >= %d AND `day` <= %d) AND `status` = 'open';", 
					array(intval($accountKey), intval($value['year']), intval($value['month']), intval($value['startDay']), intval($value['lastDay']))
				);
				$calendarList[$key]['sql'] = $sql;
				$rows = $wpdb->get_results($sql, ARRAY_A);
				foreach ((array) $rows as $row) {
					
					$key = $row['year'].sprintf("%02d%02d", $row['month'], $row['day']);
					if (isset($list[$key])) {
						
						$list[$key]['status'] = 1;
						
					}
					
				}
				
				if ($getDeletedDate === true) {
					
					$table_name = $wpdb->prefix . 'booking_package_templateSchedule';
					$sql = $wpdb->prepare(
						"SELECT `weekKey` FROM `".$table_name."` GROUP BY `weekKey`, `accountKey` HAVING `accountKey` = %d;", 
						array(intval($accountKey))
					);
					$templateSchedule = array();
					$rows = $wpdb->get_results($sql, ARRAY_A);
					foreach ((array) $rows as $row) {
						
						array_push($templateSchedule, intval($row['weekKey']));
						
					}
					$scheduleData['templateSchedule'] = $templateSchedule;
					
					$table_name = $wpdb->prefix . "booking_package_schedule";
					$sql = $wpdb->prepare(
						"SELECT year,month,day,accountKey,SUM(capacity),SUM(remainder),COUNT(day) FROM `".$table_name."` GROUP BY `year`,`month`,`day`,`holiday`,`accountKey`,`status` HAVING `accountKey` = %d AND `year` = %d AND `month` = %d AND (`day` >= %d AND `day` <= %d) AND `status` = 'deleted';", 
						array(
							intval($accountKey), 
							intval($value['year']), 
							intval($value['month']), 
							intval($value['startDay']), 
							intval($value['lastDay'])
						)
					);
					$rows = $wpdb->get_results($sql, ARRAY_A);
					foreach ((array) $rows as $row) {
						
						$key = $row['year'].sprintf("%02d%02d", $row['month'], $row['day']);
						if (isset($deletedList[$key])) {
							
							$deletedList[$key]['status'] = 1;
							
						}
						
						if (is_bool(array_search(intval($deletedList[$key]['week']), $templateSchedule))) {
							
							$deletedList[$key]['status'] = 0;
							
						}
						
					}
					
				}
				
			}
			
			$scheduleData['calendarList'] = $calendarList;
			$scheduleData['calendar'] = $list;
			$scheduleData['deletedCalendar'] = $deletedList;
			
        	return $scheduleData;
	
        }
        
        public function getRangeOfSchedule($accountKey = false){
			
			if ($accountKey != false) {
				
				global $wpdb;
				
				$account = $this->getCalendarAccount($accountKey);
				$table_name = $wpdb->prefix . "booking_package_schedule";
				$scheduleList = array();
				for ($i = intval($_POST['start']); $i <= intval($_POST['end']); $i++) {
					
					$date = date_parse($i);
					if (!checkdate($date['month'], $date['day'], $date['year'])) {
						
						$date = date_parse($i - 1);
						$unixTime = date('U', mktime(23, 60, 0, $date['month'], $date['day'], $date['year'])) + 1;
						$i = intval(date('Ymd', $unixTime));
						$date = date_parse($i);
						
					}
					
					$sql = $wpdb->prepare(
						"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d AND `status` = 'open' ORDER BY day ASC;", 
						array(
							intval($accountKey), 
							intval($date['year']), 
							intval($date['month']), 
							intval($date['day'])
						)
					);
					$row = $wpdb->get_row($sql);
					if (is_null($row)) {
						
						$unixTime = date('U', mktime(0, 0, 0, intval($date['month']), $date['day'], intval($date['year'])));
						$week = date('w', mktime(0, 0, 0, intval($date['month']), $date['day'], intval($date['year'])));
						$scheduleList[$i] = array(
							"accountKey" => $accountKey, 
							"unixTime" => $unixTime,
							"year" => intval($date['year']), 
							"month" => intval($date['month']), 
							"day" => $date['day'], 
							"weekKey" => $week,
							"hour" => 0,
							"min" => 0,
							"title" => "",
							"stop" => "false",
							"holiday" => "false",
							"existence" => 0,
							"waitingRemainder" => 0,
							"uploadDate" => 0,
							"cost" => $account['cost'],
							"capacity" => $account['numberOfRoomsAvailable'],
							"remainder" => $account['numberOfRoomsAvailable'],
						);
						
					} else {
						
						$row->existence = 1;
						$scheduleList[$i] = $row;
						
					}
					
				}
				
				return $scheduleList;
				
			}
			
			die();
			
        }
        
        public function getPublicSchedule(){
        	
        	$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            $calendar = array();
            
        	global $wpdb;
            $table_name = $wpdb->prefix."booking_package_schedule";
			$sql = $wpdb->prepare(
				"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d AND `status` = 'open' ORDER BY weekKey, hour, min ASC;", 
				array(intval($accountKey), intval($_POST['year']), intval($_POST['month']), intval($_POST['day']))
			);
            $rows = $wpdb->get_results($sql, ARRAY_A);
            /**
            foreach ((array) $rows as $row) {
            	
            	$key = $row['year'].sprintf("%02d%02d", $row['month'], $row['day']);
            	$calendar[$key] = $row;
            	
            }
            **/
            
            return $rows;
        	
        }
        
        public function getTemplateSchedule($weekKey){
        	
        	$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            global $wpdb;
            $table_name = $wpdb->prefix."booking_package_templateSchedule";
			$sql = $wpdb->prepare(
				"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `weekKey` = %d ORDER BY weekKey, hour, min ASC;", 
				array(intval($accountKey), intval($weekKey))
			);
            $rows = $wpdb->get_results($sql, ARRAY_A);
            
            return $rows;
            
        }
        
        public function updateRangeOfSchedule($accountKey = false){
        	
        	if ($accountKey != false && isset($_POST['json'])) {
        		
        		global $wpdb;
        		/**
        		$timezone = get_option('timezone_string');
				date_default_timezone_set($timezone);
				**/
				$updateDate = date('U');
				$account = $this->getCalendarAccount($accountKey);
            	$table_name = $wpdb->prefix."booking_package_schedule";
				$wpdb->query("START TRANSACTION");
				$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
				try {
					
					#$jsonList = json_decode(str_replace("\\", "", $_POST['json']));
					$jsonList = json_decode(stripslashes($_POST['json']));
	            	foreach ((array) $jsonList as $key => $value) {
	            		
	            		
						if ($value->existence == 0) {
							
							$sql = $wpdb->prepare(
								"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d AND `status` = 'open' ORDER BY day ASC;", 
								array(
									intval($accountKey), 
									intval($value->year), 
									intval($value->month), 
									intval($value->day),
								)
							);
							$row = $wpdb->get_row($sql);
							if (is_null($row)) {
								
								$this->insertSchedule(
									$table_name, $accountKey, $value->unixTime, $value->month, $value->day,
									$value->year, $value->weekKey, $value->hour, $value->min, $value->deadlineTime, $value->title,
									$value->cost, $value->capacity, $value->stop, $updateDate
								);
								
							}
							
						} else {
							
							$sql = $wpdb->prepare(
								"SELECT * FROM ".$table_name." WHERE `key` = %d;", 
								array( 
									intval($value->key)
								)
							);
							$row = $wpdb->get_row($sql);
							
							if ($row->capacity != $value->capacity) {
								
								//$value->remainder = $value->capacity - ($row->capacity - $row->remainder);
								/**
								if($row->capacity < $value->capacity){
									
									$value->remainder = $value->remainder + ($value->capacity - $row->capacity);
									
								}else{
									
									$value->remainder = $value->remainder - $value->capacity;
									
								}
								**/
							}
							
							$wpdb->update( 
								$table_name,
								array(
									'cost' => intval($value->cost), 
									'capacity' => intval($value->capacity), 
									'remainder' => intval($value->remainder),
									'stop' => sanitize_text_field($value->stop)
								),
								array('key' => intval($value->key)),
								array('%d', '%d', '%d', '%s'),
								array('%d')
							);
							
						}
						
					}
					
					
					$wpdb->query('COMMIT');
					$wpdb->query('UNLOCK TABLES');
					
				} catch (Exception $e) {
					
					$wpdb->query('ROLLBACK');
					$wpdb->query('UNLOCK TABLES');
					
				}/** finally {
					
					$wpdb->query('UNLOCK TABLES');
					
				}**/
                    
				
            	
            	$_POST['accountKey'] = $accountKey;
            	$_POST['day'] = 1;
            	$response = array();
            	$response['getAccountScheduleData'] = $this->getAccountScheduleData();
            	$response['getRangeOfSchedule'] = $this->getRangeOfSchedule($accountKey);
            	$response['jsonList'] = $jsonList;
            	
            	return $response;
            	
        	}
        	
        	die();
        	
        }
        
        public function updateAccountTemplateSchedule() {
        	
        	$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
            
            global $wpdb;
            $array = array('completeFlag' => 'updateAccountTemplateSchedule');
			$sqlList = array();
			$valueList = array();
			$updateTime = date('U');
			
			$continues = array();
			$schedules = array();
			$scheduleRead = array();
			$i = 0;
            for ($i = 0; $i < $_POST['timeCount']; $i++) {
				
				#$schedule = json_decode(str_replace("\\", "", $_POST['schedule' . $i]), true);
				$schedule = json_decode(stripslashes($_POST['schedule' . $i]), true);
				$deadlineTime = 0;
				if (isset($schedule['deadlineTime'])) {
					
					$deadlineTime = intval($schedule['deadlineTime']);
					
				}
				
				#$unixTime = mktime(intval($schedule['hour']), intval($schedule['min']), 0, intval($_POST['month']), intval($_POST['day0']), intval($_POST['year']));
				
				$table_name = $wpdb->prefix . "booking_package_templateSchedule";
				/**
				$valueArray = array($accountKey, intval($schedule['hour']), intval($schedule['min']), intval($_POST['weekKey']));
				$sql = $wpdb->prepare(
					"SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `hour` = %d AND `min` = %d AND `weekKey` = %d;", 
					$valueArray
				);
				**/
				$row = null;
				if (isset($schedule['scheduleKey'])) {
					
					$sql = $wpdb->prepare(
						"SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d;", 
						array($accountKey, intval($schedule['scheduleKey']))
					);
					$row = $wpdb->get_row($sql, ARRAY_A);
					
				}
				
				if (is_array($row)) {
					
					if ($schedule['delete'] == 'true') {
						
						array_push($sqlList, "DELETE FROM `".$table_name."` WHERE `key` = %d;");
						array_push($valueList, array(intval($row['key'])));
						
					} else {
						
						if ($schedule['delete'] == 'false') {
							
							$sql = "UPDATE ".$table_name." SET `hour` = %d, `min` = %d, `title` = %s, `cost` = %d, `capacity` = %d, `stop` = %s, `deadlineTime` = %d WHERE `key` = %d;";
							$value = array(	
								intval($schedule['hour']), 
								intval($schedule['min']), 
								sanitize_text_field($schedule['title']), 
								intval($schedule['cost']), 
								intval($schedule['capacity']), 
								sanitize_text_field($schedule['stop']), 
								intval($deadlineTime), 
								intval($row['key'])
							);
							
						} else {
							
							$sql = "DELETE FORM ".$table_name." WHERE `key` = %d;";
							$value = array(	
								intval($row['key'])
							);
							
						}
						
						
						array_push($sqlList, $sql);
						array_push($valueList, $value);
						
					}
					
				} else {
					
					if ($schedule['delete'] == 'true' || $schedules[sprintf('%02d', intval($schedule['hour'])) . sprintf('%02d', intval($schedule['min']))]) {
						
						array_push($continues, $schedule);
						continue;
						
					}
					
					$sql = "INSERT INTO ".$table_name." (`accountKey`, `weekKey` ,`hour`, `min`, `title`, `cost`, `capacity`, `stop`, `holiday`, `uploadDate`, `deadlineTime`) VALUES (%d, %d, %d, %d, %s, %d, %d, %s, %s, %d, %d);";
					$value = array(
						intval($accountKey), 
						intval($_POST['weekKey']), 
						intval($schedule['hour']), 
						intval($schedule['min']), 
						sanitize_text_field($schedule['title']), 
						intval($schedule['cost']), 
						intval($schedule['capacity']), 
						sanitize_text_field($schedule['stop']), 
						'false', 
						$updateTime,
						intval($deadlineTime), 
					);
					array_push($sqlList, $sql);
					array_push($valueList, $value);
					
				}
				
				#$schedules[intval($schedule['hour']) . intval($schedule['min'])] = $schedule;
				$schedules[sprintf('%02d', intval($schedule['hour'])) . sprintf('%02d', intval($schedule['min']))] = $schedule;
				
			}
			
			$array['sql'] = $sqlList;
			$array['value'] = $valueList;
			
			for ($i = 0; $i < count($sqlList); $i++) {
				
				$sql = $wpdb->prepare($sqlList[$i], $valueList[$i]);
				$wpdb->query($sql);
				
			}
			
			$year = date('Y');
			$month = date('m');
			$day = date('d');
			#return array('sql' => $sqlList, 'values' => $valueList, 'continues' => $continues);
			$this->insertAccountSchedule($month, $day, $year, $accountKey);
            
        }
        
        public function insertSchedule($table_name, $accountKey, $unixTime, $month, $day, $year, $week, $hour, $min, $deadlineTime, $title, $cost, $capacity, $stop, $uploadDate){
        	
        	global $wpdb;
        	$wpdb->insert(
    			$table_name, 
    			array(
    				'accountKey' => intval($accountKey), 
    				'unixTime' => intval($unixTime), 
    				'year' => intval($year), 
    				'month' => intval($month), 
    				'day' => intval($day), 
    				'weekKey' => intval($week), 
    				'hour' => intval($hour), 
    				'min' => intval($min), 
    				'title' => sanitize_text_field($title), 
    				'cost' => intval($cost), 
    				'capacity' => intval($capacity), 
    				'remainder' => intval($capacity), 
    				'stop' => sanitize_text_field($stop), 
    				'holiday' => 'false', 
    				'uploadDate' => intval($uploadDate),
    				'deadlineTime' => intval($deadlineTime),
    			), 
    			array('%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%d', '%d')
    		);
        	
        	
        }
        
        public function updateHotelCharge($account){
        	
        	global $wpdb;
        	
			if (
				isset($account['hotelChargeOnSunday']) === true &&
				isset($account['hotelChargeOnMonday']) === true &&
				isset($account['hotelChargeOnTuesday']) === true &&
				isset($account['hotelChargeOnWednesday']) === true &&
				isset($account['hotelChargeOnThursday']) === true &&
				isset($account['hotelChargeOnFriday']) === true &&
				isset($account['hotelChargeOnSaturday']) === true &&
				isset($account['hotelChargeOnDayBeforeNationalHoliday']) === true && 
				isset($account['hotelChargeOnNationalHoliday']) === true &&
				intval($account['hotelChargeOnSunday']) == 0 &&
				intval($account['hotelChargeOnMonday']) == 0 &&
				intval($account['hotelChargeOnTuesday']) == 0 &&
				intval($account['hotelChargeOnWednesday']) == 0 &&
				intval($account['hotelChargeOnThursday']) == 0 &&
				intval($account['hotelChargeOnFriday']) == 0 &&
				intval($account['hotelChargeOnSaturday']) == 0 &&
				intval($account['hotelChargeOnDayBeforeNationalHoliday']) == 0 && 
				intval($account['hotelChargeOnNationalHoliday']) == 0
			) {
				
				$table_name = $wpdb->prefix."booking_package_calendarAccount";
				$wpdb->query("START TRANSACTION");
				$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
				try {
					
					$bool = $wpdb->update(
						$table_name,
						array(
							'hotelChargeOnSunday' => intval($account['cost']),
							'hotelChargeOnMonday' => intval($account['cost']),
							'hotelChargeOnTuesday' => intval($account['cost']),
							'hotelChargeOnWednesday' => intval($account['cost']),
							'hotelChargeOnThursday' => intval($account['cost']),
							'hotelChargeOnFriday' => intval($account['cost']),
							'hotelChargeOnSaturday' => intval($account['cost']),
							'hotelChargeOnDayBeforeNationalHoliday' => 0,
							'hotelChargeOnNationalHoliday' => 0,
						),
						array('key' => intval($account['key'])),
						array(
							'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', 
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
				
				$account['hotelChargeOnSunday'] = intval($account['cost']);
				$account['hotelChargeOnMonday'] = intval($account['cost']);
				$account['hotelChargeOnTuesday'] = intval($account['cost']);
				$account['hotelChargeOnWednesday'] = intval($account['cost']);
				$account['hotelChargeOnThursday'] = intval($account['cost']);
				$account['hotelChargeOnFriday'] = intval($account['cost']);
				$account['hotelChargeOnSaturday'] = intval($account['cost']);
				$account['hotelChargeOnDayBeforeNationalHoliday'] = 0;
				$account['hotelChargeOnNatiohotelChargeOnNationalHolidaynalHoliday'] = 0;
				
			} else {
				
				//var_dump($account);
				
			}
			
			return $account;

        }
        
        public function insertAccountSchedule($month, $day, $year, $accountKey = false) {
			
			if ($accountKey === false) {
				
				return false;
				
			}
			
			global $wpdb;
			$uploadDate = date('U');
			$const_unixTime = date('U', mktime(0, 0, 0, $month, $day, $year));
			$maxAccountScheduleDay = intval(get_option($this->prefix.'maxAccountScheduleDay', 7));
			#var_dump($maxAccountScheduleDay);
			
			/** Get Holidays **/
			$nationalHolidays = array();
			$table_name = $wpdb->prefix . 'booking_package_regular_holidays';
			$sql = $wpdb->prepare(
				"SELECT `month`, `day`, `year`, `unixTime` FROM `".$table_name."` WHERE `accountKey` = 'national' AND `status` = 1 AND `unixTime` >= %d;", 
				array(intval($const_unixTime))
			);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $row) {
				
				$nationalHolidays[$row['year'] . sprintf('%02d', $row['month']) . sprintf('%02d', $row['day'])] = $row;
				
			}
			//var_dump($nationalHolidays);
			/** Get Holidays **/
			
			$row = $this->getCalendarAccount($accountKey);
			if ($row === false) {
				
				return false;
				
			}
			$rows = array(intval($row['key']) => $row);
			#$table_name = $wpdb->prefix . "booking_package_calendarAccount";
			#$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `status` = %s;", array("open"));
			#$rows = $wpdb->get_results($sql, ARRAY_A);
			
			$wpdb->query("START TRANSACTION");
			$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE, `" . $wpdb->prefix."booking_package_templateSchedule" . "` WRITE");
			try {
				
				foreach ((array) $rows as $row) {
					
					date_default_timezone_set($row['timezone']);
					$maxAccountScheduleDay = intval($row['maxAccountScheduleDay']);
					$accountKey = $row['key'];
					$accountType = $row['type'];
					if ($accountType == 'hotel') {
						
						$row = $this->updateHotelCharge($row);
						
					}
					
					$calendarAccount = $row;
					$unixTime = $const_unixTime;
					$hotelCharges = array(
						$calendarAccount['hotelChargeOnSunday'], 
						$calendarAccount['hotelChargeOnMonday'], 
						$calendarAccount['hotelChargeOnTuesday'], 
						$calendarAccount['hotelChargeOnWednesday'], 
						$calendarAccount['hotelChargeOnThursday'], 
						$calendarAccount['hotelChargeOnFriday'], 
						$calendarAccount['hotelChargeOnSaturday'], 
					);
					
					for ($i = 0; $i < $maxAccountScheduleDay; $i++) {
						
						$year = date('Y', $unixTime);
						$month = date('m', $unixTime);
						$day = date('d', $unixTime);
						$week = date('w', $unixTime);
						$dayBeforeUnixTime = $unixTime + (1440 * 60);
						$dayBeforeNationalHolidayKey = date('Y', $dayBeforeUnixTime) . date('m', $dayBeforeUnixTime) . date('d', $dayBeforeUnixTime);
						$nationalHolidayKey = $year . sprintf('%02d', $month) . sprintf('%02d', $day);
						#print $year."_".$month."_".$day."<br>\n";
						$unixTime += 1440 * 60;
						
						$table_name = $wpdb->prefix . "booking_package_schedule";
						$sql = "SELECT `key` FROM `".$table_name."` WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d AND (`status` = 'open' OR `status` = 'deleted') LIMIT 0, 1;";
						$valueArray = array(intval($accountKey), intval($year), intval($month), intval($day));
						$row = $wpdb->get_row($wpdb->prepare($sql, $valueArray));
						
						if (is_null($row)) {
							
							if ($calendarAccount['type'] == 'day') {
								
								$table_name = $wpdb->prefix."booking_package_templateSchedule";
								$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `weekKey` = %d ORDER BY `weekKey`, `hour`, `min` ASC;";
								$template_rows = $wpdb->get_results($wpdb->prepare($sql, array(intval($accountKey), intval($week))), ARRAY_A);
								foreach ((array) $template_rows as $template_row) {
									
									$time = date('U', mktime($template_row['hour'], $template_row['min'], 0, $month, $day, $year));
									$table_name = $wpdb->prefix."booking_package_schedule";
									
									$this->insertSchedule(
										$table_name, $accountKey, $time, $month, $day, $year, $week, 
										$template_row['hour'], $template_row['min'], $template_row['deadlineTime'], $template_row['title'],
										$template_row['cost'], $template_row['capacity'], $template_row['stop'],
										$uploadDate
									);
									
								}
							
							} else {
								
								$cost = $calendarAccount['cost'];
								$hotelCharges = array(
									$calendarAccount['hotelChargeOnSunday'], 
									$calendarAccount['hotelChargeOnMonday'], 
									$calendarAccount['hotelChargeOnTuesday'], 
									$calendarAccount['hotelChargeOnWednesday'], 
									$calendarAccount['hotelChargeOnThursday'], 
									$calendarAccount['hotelChargeOnFriday'], 
									$calendarAccount['hotelChargeOnSaturday'], 
								);
								
								if (isset($nationalHolidays[intval($nationalHolidayKey)]) && intval($calendarAccount['hotelChargeOnNationalHoliday']) > 0) {
									
									$cost = $calendarAccount['hotelChargeOnNationalHoliday'];
									
								} else if (isset($nationalHolidays[intval($dayBeforeNationalHolidayKey)]) && intval($calendarAccount['hotelChargeOnDayBeforeNationalHoliday']) > 0) {
									
									$cost = $calendarAccount['hotelChargeOnDayBeforeNationalHoliday'];
									
								} else {
									
									$cost = $hotelCharges[intval($week)];
									
								}
								
								$capacity = $calendarAccount['numberOfRoomsAvailable'];
								$time = date('U', mktime(0, 0, 0, $month, $day, $year));
								$table_name = $wpdb->prefix."booking_package_schedule";
								
								$wpdb->insert(
									$table_name, 
									array(
										'accountKey' => intval($accountKey), 
										'unixTime' => intval($time), 
										'year' => intval($year), 
										'month' => intval($month), 
										'day' => intval($day), 
										'weekKey' => intval($week), 
										'hour' => 0, 
										'min' => 0, 
										'title' => '', 
										'cost' => intval($cost), 
										'capacity' => intval($capacity), 
										'remainder' => intval($capacity), 
										'stop' => 'false', 
										'holiday' => 'false', 
										'uploadDate' => $uploadDate
									), 
									array(
										'%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%d', 
										'%d', '%d', '%s', '%s', '%d'
									)
								);
								
							}
							
						}
						
					}
					
				}
				
				$wpdb->query('COMMIT');
				$wpdb->query('UNLOCK TABLES');
				
			} catch (Exception $e) {
				
				$wpdb->query('ROLLBACK');
				
			}/** finally {
				
				$wpdb->query('UNLOCK TABLES');
				
			}**/
			
			
			
		}
		
		public function updateAccountSchedule(){
			
			$accountKey = 1;
            if (isset($_POST['accountKey'])) {
                
                $accountKey = $_POST['accountKey'];
                
            }
			
			global $wpdb;
			$sql = '';
			$courseTime = 0;
			$maintenanceTime = 0;
			
			$array = array();
			$value_array = array();
			$rpeatList = array();
			$schedules = array();
			$prepareForRpeatReservation = array();
			
			$table_name = $wpdb->prefix."booking_package_courseData";
			$sql = "SELECT `key`,max(`time`) FROM `".$table_name."` WHERE `accountKey` = %d;";
			$row = $wpdb->get_row(
				$wpdb->prepare(
					$sql, 
					array(intval($accountKey))
				), 
				ARRAY_A
			);
			if (is_null($row)) {
				
				$courseTime = 0;
				
			} else {
				
				$courseTime = intval($row["max(`time`)"]);
				
			}
			
			$wpdb->query("START TRANSACTION");
			$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE, `" . $wpdb->prefix."booking_package_userPraivateData" . "` WRITE");
			try {
				
				for ($i = 0; $i < $_POST['timeCount']; $i++) {
					
					$updateBool = false;
					$sql = null;
					$updateArray = array();
					#$schedule = json_decode(str_replace("\\", "", $_POST['schedule' . $i]), true);
					$schedule = json_decode(stripslashes($_POST['schedule' . $i]), true);
					$unixTime = intval(date('U', mktime($schedule['hour'], $schedule['min'], 0, $_POST['month'], $_POST['day'], $_POST['year'])));
					$weekKey = intval(date('w', mktime($schedule['hour'], $schedule['min'], 0, $_POST['month'], $_POST['day'], $_POST['year'])));
					
					$deadlineTime = 0;
					if (isset($schedule['deadlineTime'])) {
						
						$deadlineTime = intval($schedule['deadlineTime']);
						
					}
					
					if (isset($schedule['key'])) {
						
						$table_name = $wpdb->prefix."booking_package_schedule";
						$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d AND `status` = 'open';";
						$row = $wpdb->get_row(
							$wpdb->prepare($sql, array(intval($schedule['key']))), 
							ARRAY_A
						);
						
						if (!is_null($row)) {
							
							$updateBool = true;
							if ($schedule['delete'] == 'true') {
								
								/**
								$sql = "DELETE FROM `".$table_name."` WHERE `capacity` = `remainder` AND `key` = %d;";
								$updateArray = array(intval($schedule['key']));
								**/
								$sql = "UPDATE `".$table_name."` SET `status` = %s WHERE `capacity` = `remainder` AND `key` = %d;";
								$updateArray = array('deleted', intval($schedule['key']));
								
							} else {
								
								$capacity = $schedule['capacity'];
								$remainder = $schedule['remainder'];
								
								$sql = "UPDATE `".$table_name."` SET `unixTime` = %d, `year` = %d, `month` = %d, `day` = %d, ";
								$sql .= "`hour` = %d, `min` = %d, `title` = %s, `capacity` = %d, `remainder` = %d, `stop` = %s, `cost` = %d , `deadlineTime` = %d ";
								$sql .= "WHERE `key` = %d;";
								$updateArray = array(
									$unixTime,
									intval($_POST['year']),
									intval($_POST['month']),
									intval($_POST['day']),
									intval($schedule['hour']),
									intval($schedule['min']),
									sanitize_text_field($schedule['title']),
									intval($capacity),
									intval($remainder),
									sanitize_text_field($schedule['stop']),
									intval(0),
									intval($deadlineTime),
									intval($schedule['key'])
								);
								
							}
							
						}
							
					} else {
						
						$remainder = $schedule['capacity'];
						$remainder = $schedule['remainder'];
						$reserveRemainder = 0;
						
						$table_name = $wpdb->prefix."booking_package_userPraivateData";
						$serch_sql = "SELECT * FROM `".$table_name."` WHERE `scheduleUnixTime` > %d AND `scheduleUnixTime` < %d AND `accountKey` = %d;";
						$valueArray = array(($unixTime - ($courseTime * 60) - ($maintenanceTime * 60)), $unixTime, intval($accountKey));
						#var_dump($valueArray);
						$sql = $wpdb->prepare($serch_sql, $valueArray);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						foreach ((array) $rows as $row) {
							
							$reserveUnixTime = $row['scheduleUnixTime'] + ($row['courseTime'] * 60);
							if($unixTime < $reserveUnixTime){
								$remainder--;
								$reserveRemainder++;
							}
							
						}
						
						if ($remainder < 0) {
							
							$updateBool = false;
							
						} else {
							
							$updateBool = true;
							
						}
						
						if ($updateBool == true) {
							
							if ($schedule['delete'] == 'true') {
								
								continue;
								
							}
							
							$table_name = $wpdb->prefix."booking_package_schedule";
							$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `unixTime` = %d AND `status` = 'open';";
							$row = $wpdb->get_row($wpdb->prepare($sql, array(intval($accountKey), $unixTime)), ARRAY_A);
							if (is_null($row)) {
								
								$sql = "INSERT INTO `".$table_name."` (`accountKey`,`unixTime`,`year`,`month`,`day`, `weekKey`, `hour`,`min`,`title`,`capacity`,`remainder`,`stop`,`holiday`,`cost`,`deadlineTime`) ";
								$sql .= "VALUES (%d, %d, %d, %d, %d, %d, %d, %d, %s, %d, %d, %s, %s, %d, %d);";
								$updateArray = array(
									intval($accountKey),
									$unixTime,
									intval($_POST['year']),
									intval($_POST['month']),
									intval($_POST['day']),
									intval($weekKey),
									intval($schedule['hour']),
									intval($schedule['min']),
									sanitize_text_field($schedule['title']),
									intval($schedule['capacity']),
									intval($remainder),
									sanitize_text_field($schedule['stop']),
									"false",
									intval(0),
									intval($deadlineTime),
								);
								
							}
							
						}
						
					}
					
					if ($updateBool == true && !isset($schedules[$unixTime])) {
						
						array_push($array, $sql);
						array_push($value_array, $updateArray);
						
					}
					
					$schedules[$unixTime] = $schedule;
					
				}
				
				for ($i = 0; $i < count($array); $i++) {
						
					$sql = $wpdb->prepare($array[$i], $value_array[$i]);
					$wpdb->query($sql);
					
				}
				
				$wpdb->query('COMMIT');
				$wpdb->query('UNLOCK TABLES');
				
				
			} catch (Exception $e) {
				
				$wpdb->query('ROLLBACK');
				
			}/** finally {
				
				$wpdb->query('UNLOCK TABLES');
				
			}**/
			
		}
		
		public function deletePerfectPublicSchedule(){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_schedule";
			$sql = $wpdb->prepare(
				"DELETE FROM `".$table_name."` WHERE `year` = %d AND `month` = %d AND `day` = %d AND `accountKey` = %d AND `status` = 'deleted';", 
				array(
					intval($_POST['year']),
					intval($_POST['month']),
					intval($_POST['day']),
					intval($_POST['accountKey']),
				)
			);
			$wpdb->query($sql);
			return $sql;
			
		}
		
		public function deleteOldDaysInSchedules(){
    		
    		global $wpdb;
    		/**
    		$timezone = get_option('timezone_string');
            date_default_timezone_set($timezone);
            **/
            $unixTime = date('U') - (14 * 24 * 3600);
            $unixTime = date('U', mktime(0, 0, 0, date('m', $unixTime), date('d', $unixTime), date('Y', $unixTime)));
            
            $table_name = $wpdb->prefix."booking_package_schedule";
            $sql = $wpdb->prepare("DELETE FROM `".$table_name."` WHERE `unixTime` < %d;", array($unixTime));
            $wpdb->query($sql);
            return $sql;
    		
    	}
    	
    	public function deletePublishedSchedules($accountKey = 1, $type = 'day') {
    		
    		$response = array("status" => "error", "request" => $_POST);
    		if (isset($_POST['deletePublishedSchedules_from_month']) && isset($_POST['deletePublishedSchedules_from_day']) && isset($_POST['deletePublishedSchedules_from_year'])) {
				
				if (
					checkdate($_POST['deletePublishedSchedules_from_month'], $_POST['deletePublishedSchedules_from_day'], $_POST['deletePublishedSchedules_from_year']) === false || 
					checkdate($_POST['deletePublishedSchedules_to_month'], $_POST['deletePublishedSchedules_to_day'], $_POST['deletePublishedSchedules_to_year']) === false
				) {
					
					return $response;
					
				}
				
				$unixTime_from = date('U', mktime(0, 0, 0, $_POST['deletePublishedSchedules_from_month'], $_POST['deletePublishedSchedules_from_day'], $_POST['deletePublishedSchedules_from_year']));
				$unixTime_to = date('U', mktime(23, 59, 0, $_POST['deletePublishedSchedules_to_month'], $_POST['deletePublishedSchedules_to_day'], $_POST['deletePublishedSchedules_to_year']));
				global $wpdb;
				$accountKeys = array($accountKey);
				$calendarAccounts = $this->getCalendarAccountsWithHavingSchedulesSharing($accountKey);
				foreach ($calendarAccounts as $key => $value) {
					
					array_push($accountKeys, $value['key']);
					
				}
				
				$customers = array();
				$schedulesSQL = null;
				$customerSQL = array();
				$schedules_table_name = $wpdb->prefix . "booking_package_schedule";
				$customer_table_name = $wpdb->prefix . "booking_package_userPraivateData";
				if ($_POST['delete_action'] == 'delete') {
					
					if ($_POST['deletionType'] == 'perfect') {
						
						$schedulesSQL = $wpdb->prepare(
							"DELETE FROM `" . $schedules_table_name . "` WHERE `accountKey` = %d;", 
							array($accountKey)
						);
						
						if ($_POST['period'] == 'period_after') {
							
							$schedulesSQL = $wpdb->prepare(
								"DELETE FROM `" . $schedules_table_name . "` WHERE `accountKey` = %d AND `unixTime` > %d;", 
								array($accountKey, intval($unixTime_from))
							);
							
						}
						
						if ($_POST['period'] == 'period_within') {
							
							$schedulesSQL = $wpdb->prepare(
								"DELETE FROM `" . $schedules_table_name . "` WHERE `accountKey` = %d AND (`unixTime` > %d AND `unixTime` < %d);", 
								array($accountKey, intval($unixTime_from), intval($unixTime_to))
							);
							
						}
						
					} else if ($_POST['deletionType'] == 'incomplete') {
						
						$schedulesSQL = $wpdb->prepare(
							"UPDATE `" . $schedules_table_name . "` SET `status` = 'deleted' WHERE `accountKey` = %d;", 
							array($accountKey)
						);
						
						if ($_POST['period'] == 'period_after') {
							
							$schedulesSQL = $wpdb->prepare(
								"UPDATE `" . $schedules_table_name . "` SET `status` = 'deleted' WHERE `accountKey` = %d AND `unixTime` > %d;", 
								array($accountKey, intval($unixTime_from))
							);
							
						}
						
						if ($_POST['period'] == 'period_within') {
							
							$schedulesSQL = $wpdb->prepare(
								"UPDATE `" . $schedules_table_name . "` SET `status` = 'deleted' WHERE `accountKey` = %d AND (`unixTime` > %d AND `unixTime` < %d);", 
								array($accountKey, intval($unixTime_from), intval($unixTime_to))
							);
							
						}
						
					}
					
					for ($i = 0; $i < count($accountKeys); $i++) {
						
						$SQL = $wpdb->prepare(
							"UPDATE `" . $customer_table_name . "` SET `status`= 'canceled' WHERE `accountKey` = %d;", 
							array($accountKeys[$i])
						);
						
						if ($_POST['period'] == 'period_after') {
							
							$SQL = $wpdb->prepare(
								"UPDATE `" . $customer_table_name . "` SET `status`= 'canceled' WHERE `accountKey` = %d AND `scheduleUnixTime` > %d;", 
								array($accountKeys[$i], intval($unixTime_from))
							);
							
							if ($type == 'hotel') {
								
								$SQL = $wpdb->prepare(
									"SELECT `key`, `accountKey`, `cancellationToken`, `checkin`, `checkout` FROM `" . $customer_table_name . "` WHERE `status` != 'canceled' AND `accountKey` = %d AND (`checkin` > %d OR `checkout` > %d);", 
									array($accountKeys[$i], intval($unixTime_from), intval($unixTime_from))
								);
								
							}
							
						} else if ($_POST['period'] == 'period_within') {
							
							$SQL = $wpdb->prepare(
								"UPDATE `" . $customer_table_name . "` SET `status`= 'canceled' WHERE `accountKey` = %d AND (`scheduleUnixTime` > %d AND `scheduleUnixTime` < %d);", 
								array($accountKeys[$i], intval($unixTime_from), intval($unixTime_to))
							);
							
						}
						
						array_push($customerSQL, $SQL);
						
					}
					
					/**
					$customerSQL = $wpdb->prepare(
						"UPDATE `" . $customer_table_name . "` SET `status`= 'canceled' WHERE `accountKey` = %d;", 
						array($accountKey)
					);
					
					if ($_POST['period'] == 'period_after') {
						
						$customerSQL = $wpdb->prepare(
							"UPDATE `" . $customer_table_name . "` SET `status`= 'canceled' WHERE `accountKey` = %d AND `scheduleUnixTime` > %d;", 
							array($accountKey, intval($unixTime_from))
						);
						
						if ($type == 'hotel') {
							
							$customerSQL = $wpdb->prepare(
								"SELECT `key`, `accountKey`, `cancellationToken`, `checkin`, `checkout` FROM `" . $customer_table_name . "` WHERE `status` != 'canceled' AND `accountKey` = %d AND (`checkin` > %d OR `checkout` > %d);", 
								array($accountKey, intval($unixTime_from), intval($unixTime_from))
							);
							
						}
						
					} else if ($_POST['period'] == 'period_within') {
						
						$customerSQL = $wpdb->prepare(
							"UPDATE `" . $customer_table_name . "` SET `status`= 'canceled' WHERE `accountKey` = %d AND (`scheduleUnixTime` > %d AND `scheduleUnixTime` < %d);", 
							array($accountKey, intval($unixTime_from), intval($unixTime_to))
						);
						
					}
					**/
					
					$wpdb->query("START TRANSACTION");
					$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE, `" . $wpdb->prefix."booking_package_userPraivateData" . "` WRITE");
					/**
					if (!is_null($customerSQL)) {
						
						$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE, `" . $wpdb->prefix."booking_package_userPraivateData" . "` WRITE");
						
					} else {
						
						$wpdb->query("LOCK TABLES `" . $wpdb->prefix . "booking_package_schedule" . "` WRITE");
						
					}
					**/
					try {
						
						if ($type == 'day') {
							
							$wpdb->query($schedulesSQL);
							#$wpdb->query($customerSQL);
							for ($i = 0; $i < count($customerSQL); $i++) {
								
								$wpdb->query($customerSQL[$i]);
								
							}
							
						} else if ($type == 'hotel') {
							
							$wpdb->query($schedulesSQL);
							for ($i = 0; $i < count($customerSQL); $i++) {
								
								$rows = $wpdb->get_results($customerSQL[$i], ARRAY_A);
								foreach ((array) $rows as $key => $row) {
									
									array_push($customers, $row);
									
								}
								
							}
							
						}
						
						$wpdb->query('COMMIT');
						$wpdb->query('UNLOCK TABLES');
						
					} catch (Exception $e) {
						
						$wpdb->query('ROLLBACK');
						$wpdb->query('UNLOCK TABLES');
						
					}/** finally {
						
						$wpdb->query('UNLOCK TABLES');
						
					}**/
					
				} else {
					
					$wpdb->query("START TRANSACTION");
					$wpdb->query("LOCK TABLES `" . $wpdb->prefix . "booking_package_schedule" . "` WRITE");
					try {
						
						$schedulesSQL = $wpdb->prepare(
							"UPDATE `" . $schedules_table_name . "` SET `stop` = 'true' WHERE `accountKey` = %d;", 
							array($accountKey)
						);
						
						if ($_POST['period'] == 'period_after') {
							
							$schedulesSQL = $wpdb->prepare(
								"UPDATE `" . $schedules_table_name . "` SET `stop` = 'true' WHERE `accountKey` = %d AND `unixTime` > %d;", 
								array($accountKey, intval($unixTime_from))
							);
							
						}
						
						if ($_POST['period'] == 'period_within') {
							
							$schedulesSQL = $wpdb->prepare(
								"UPDATE `".$schedules_table_name."` SET `stop` = 'true' WHERE `accountKey` = %d AND (`unixTime` > %d AND `unixTime` < %d);", 
								array($accountKey, intval($unixTime_from), intval($unixTime_to))
							);
							
						}
						
						$wpdb->query($schedulesSQL);
						$wpdb->query('COMMIT');
						$wpdb->query('UNLOCK TABLES');
						
					} catch (Exception $e) {
						
						$wpdb->query('ROLLBACK');
						$wpdb->query('UNLOCK TABLES');
						
					}/** finally {
						
						$wpdb->query('UNLOCK TABLES');
						
					}**/
					
				}
				
				for ($i = 0; $i < count($customers); $i++) {
					
					$_POST['sendEmail'] = 0;
					$this->updateStatus($customers[$i]['key'], $customers[$i]['cancellationToken'], 'canceled');
					
				}
				
				$response['schedulesSQL'] = $schedulesSQL;
				$response['customerSQL'] = $customerSQL;
				$response['status'] = 'success';
				
			}
			
			return $response;
			
		}
		
    	public function getReservationUsersData($month, $day, $year){
    		
    		$start = date('U', mktime(0, 0, 0, $month, $day, $year));
    		$end = date('U', mktime(23, 59, 59, $month, $day, $year));
    		
    		$response = array();
    		global $wpdb;
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare(
				"SELECT `key`,`accountKey`,`status`,`scheduleUnixTime`,`courseName`,`praivateData`,`accommodationDetails`, `cancellationToken` FROM `".$table_name."` WHERE `scheduleUnixTime` >= %d AND `scheduleUnixTime` <= %d ORDER BY `scheduleUnixTime` ASC;", 
				array(intval($start), intval($end))
			);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $row) {
				
				if(!isset($response[$row['accountKey']])){
					
					$response[$row['accountKey']] = array();
					
				}
				
				$row['praivateData'] = json_decode($row['praivateData'], true);
				$row['accommodationDetails'] = json_decode($row['accommodationDetails'], true);
				array_push($response[$row['accountKey']], $row);
				
			}
			
			return $response;
			
    	}
    	
    	public function getCalendarList($month, $day, $year, $startOfWeek = 0){
    		
    		#$month = 4;
    		$weeks = array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');
    		$timestamp = date('U');
    		$last_day = date('t', mktime(0, 0, 0, $month, $day, $year));
			#$week_start_num = intval(date('w', mktime(0, 0, 0, $month, 1, $year))) - $startOfWeek;
			#$week_last_num = intval(date('w', mktime(0, 0, 0, $month, $last_day, $year))) - $startOfWeek;
    		$week_start_num = intval(date('w', mktime(0, 0, 0, $month, 1, $year)));
			$week_last_num = intval(date('w', mktime(0, 0, 0, $month, $last_day, $year)));
    		
    		$calendarList = array();
			if(intval($week_start_num) != $startOfWeek){
				
				#$lastUnixTime = date('U', mktime(0, 0, 0, $month, 1, $year)) - 1;
				$lastUnixTime = intval(date('U', mktime(0, 0, 0, $month, 1, $year))) - 60;
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = intval(date('t', $lastUnixTime));
				$startDay = $endDay - intval(date('w', $lastUnixTime)) + $startOfWeek;
				#$startDay = date('j', strtotime("last ".$weeks[$startOfWeek]." of ".date('F', $lastUnixTime)." ".date('Y', $lastUnixTime)));
				for ($i = $endDay; $i > 0; $i--) {
				    
				    if (date('w', mktime(0, 0, 0, date('n', $lastUnixTime), $i, date('Y', $lastUnixTime))) == $startOfWeek) {
				        
				         $startDay = $i;
				         break;
				        
				    }
				    
				}
				
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array(
					'startDay' => $startDay, 
					'lastDay' => $endDay, 
					'startWeek' => intval(date('w', mktime(0, 0, 0, $lastMonth, $startDay, $lastYear))), 
					'lastWeek' => intval(date('w', $lastUnixTime)), 
					'year' => $lastYear, 
					'month' => intval($lastMonth), 
					'day' => $startDay, 
					'timestamp' => $timestamp
				);
				
			}
			
			$calendarList[intval($year.sprintf('%02d', $month))] = array('startDay' => 1, 'lastDay' => $last_day, 'startWeek' => $week_start_num, 'lastWeek' => $week_last_num, 'year' => $year, 'month' => intval($month), 'day' => 1, 'timestamp' => $timestamp);
			
			#if(intval($week_last_num) >= $startOfWeek){
				
				$lastUnixTime = intval(date('U', mktime(23, 60, 0, $month, $last_day, $year)));
				$lastYear = date('Y', $lastUnixTime);
				$lastMonth = date('m', $lastUnixTime);
				$endDay = 7 - intval(date('w', $lastUnixTime)) + $startOfWeek;
				#$endDay = date('j', strtotime("first ".$weeks[$startOfWeek]." of ".date('F', $lastUnixTime)." ".date('Y', $lastUnixTime))) - 1;
				$startOfWeek--;
				if ($startOfWeek < 0) {
					
					$startOfWeek = 6;
					
				}
				
				for ($i = 1; $i <= intval(date('t', $lastUnixTime)); $i++) {
					
					if (date('w', mktime(0, 0, 0, date('n', $lastUnixTime), $i, date('Y', $lastUnixTime))) == $startOfWeek) {
						
						if ($i == 7) {
							
							$endDay = 0;
							
						} else {
							
							$endDay = $i;
							
						}
						
						break;
						
					}
	                
	            }
				
				$startDay = 1;
				$key = intval($lastYear.$lastMonth);
				$calendarList[$key] = array(
					'startDay' => $startDay, 
					'lastDay' => $endDay, 
					'startWeek' => intval(date('w', $lastUnixTime)), 
					'lastWeek' => 6, 
					'year' => $lastYear, 
					'month' => intval($lastMonth), 
					'day' => $startDay, 
					'timestamp' => $timestamp,
				);
				
			#}
			
			return $calendarList;
    		
    	}
		
		public function fixUnixTimeShift($schedule, $timezone) {
			
			global $wpdb;
			date_default_timezone_set($timezone);
			$trueUnixTime = date('U', mktime($schedule['hour'], $schedule['min'], 0, $schedule['month'], $schedule['day'], $schedule['year']));
			if (intval($trueUnixTime) != intval($schedule['unixTime'])) {
				
				$wpdb->query("START TRANSACTION");
				$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE, `" . $wpdb->prefix."booking_package_userPraivateData" . "` WRITE");
				try {
					
					$wpdb->update(
						$wpdb->prefix."booking_package_schedule", 
						array(
							'unixTime' => intval($trueUnixTime),
						),
						array('key' => intval($schedule['key'])),
						array('%d'),
						array('%d')
					);
					
					$wpdb->update(
						$wpdb->prefix."booking_package_userPraivateData", 
						array(
							'scheduleUnixTime' => intval($trueUnixTime),
						),
						array('scheduleKey' => intval($schedule['key'])),
						array('%d'),
						array('%d')
					);
					
					$wpdb->query('COMMIT');
					$wpdb->query('UNLOCK TABLES');
					$schedule['trueUnixTime'] = $trueUnixTime;
					$schedule['fixedUnixTime'] = true;
					$schedule['unixTime'] = $trueUnixTime;
					return $schedule;
					
				} catch (Exception $e) {
					
					$wpdb->query('ROLLBACK');
					$wpdb->query('UNLOCK TABLES');
					$error = json_decode($e->getMessage(), true);
					return $error;
					
				}
				/** finally {
					
					$wpdb->query('UNLOCK TABLES');
					
				}
				**/
				
			} else {
				
				return $schedule;
				
			}
			
		}
		
		public function getCalendarAccountsWithHavingSchedulesSharing($accountKey) {
			
			global $wpdb;
			$table_name = $wpdb->prefix . "booking_package_calendarAccount";
			$sql = $wpdb->prepare(
				"SELECT `key`, `targetSchedules` FROM `" . $table_name . "` WHERE `targetSchedules` = %d AND `schedulesSharing` = 1;", 
				array(intval($accountKey))
			);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			return $rows;
			
		}
    	
    	public function getReservationData($month, $day, $year, $ical = false, $public = false) {
    		
			$accountKey = 1;
			$accountCalendarKey = 1;
			if(isset($_POST['accountKey'])){
				
				$accountKey = $_POST['accountKey'];
				$accountCalendarKey = $_POST['accountKey'];
				
			}
			
			global $wpdb;
			$account = $this->getCalendarAccount($accountKey);
			if (intval($account['schedulesSharing']) == 1) {
				
				$accountCalendarKey = intval($account['targetSchedules']);
				
			}
			
			$reserveData = array();
			$changeMonth = false;
			
			if ($ical === false) {
				
				if (is_null($month) && is_null($day) !== true && is_null($year)) {
					
					$month = date('m');
					$day = date('d');
					$year = date('Y');
					
				}
				
				if ($month != date('m') || $year != date('Y')) {
					
					$day = 1;
					
				} else {
					
					$day = date('d');
					
				}
				
				if ($public !== false) {
					
					#$unavailableDaysFromToday = get_option($this->prefix."unavailableDaysFromToday", 0) * (1440 * 60);
					$unavailableDaysFromToday = intval($account['unavailableDaysFromToday']) * (1440 * 60);
					$unixTime = date('U') + $unavailableDaysFromToday;
					
					//if(date('U', mktime(0, 0, 0, $month, 1, $year)) < $unixTime){
					if (date('U', mktime(0, 0, 0, date('n'), 1, date('Y'))) < $unixTime) {
						
						$changeMonth = true;
						$startMonth = date('m', $unixTime);
						$startDay = date('d', $unixTime);
						$startYear = date('Y', $unixTime);
						
						if (date('U', mktime(0, 0, 0, $month, 1, $year)) < $unixTime) {
							
							$month = date('m', $unixTime);
							$day = date('d', $unixTime);
							$year = date('Y', $unixTime);
							
						}
						
					}
						
				}
				
			}
			
			$nationalHoliday = $this->getRegularHolidays($month, $year, 'national', $account['startOfWeek'], false);
			$regularHoliday = $this->getRegularHolidays($month, $year, $accountKey, $account['startOfWeek'], true);
			
			$last_day = date('t', mktime(0, 0, 0, $month, $day, $year));
			$week_start_num = intval(date('w', mktime(0, 0, 0, $month, 1, $year)));
			$week_last_num = intval(date('w', mktime(0, 0, 0, $month, $last_day, $year)));
			
			$maxDeadlineDay = date('U') + (BOOKING_PACKAGE_MAX_DEADLINE_TIME * 60);
			
			if ($ical === false) {
				
				$arrayValue = array(
					'startDay' => 1, 
					'lastDay' => $last_day, 
					'startWeek' => $week_start_num, 
					'lastWeek' => $week_last_num, 
					'year' => $year, 
					'month' => intval($month), 
					'day' => 1, 
					'timestamp' => date('U'), 
					'today' => intval(date('Ymd')), 
					'maxDeadlineDay' => intval(date('Ymd', date('U') + (BOOKING_PACKAGE_MAX_DEADLINE_TIME * 60))),
					'firstMonth' => intval(date('U', mktime(0, 0, 0, $month, 1, $year))), 
					'endMonth' => intval(date('U', mktime(23, 59, 59, $month, $last_day, $year)))
				);
				$reserveData['date'] = $arrayValue;
				
				$calendarList = $this->getCalendarList($month, $day, $year, $account['startOfWeek']);
				$reserveData['calendarList'] = $calendarList;
				$days = array();
				$reservation = array();
				$reservationForHotel = array();
				$schedule = array();
				$bookedServices = array();
				$schedule_start_day = null;
				if ($public !== false && $changeMonth === true /**$month == date('n')**/) {
					
					$schedule_start_day = intval(date('Ymd', mktime(0, 0, 0, $startMonth, $startDay, $startYear)));
					//$schedule_start_day = intval(date('Ymd', mktime(0, 0, 0, date('n'), date('j'), date('Y'))));
					
				}
				
				$reserveData['schedule_start_day'] = $schedule_start_day;
				
				$visitorList = array();
				$number = 0;
				foreach ((array) $calendarList as $key => $value) {
					
					for ($i = $value['startDay']; $i <= $value['lastDay']; $i++) {
						
						$calendarUnixTime = date('U', mktime(0, 0, 0, $value['month'], $i, $value['year']));
						$week = date('w', mktime(0, 0, 0, $value['month'], $i, $value['year']));
						$scheduleKey = $value['year'] . sprintf("%02d%02d", $value['month'], $i);
						$arrayValue = array('key' => $scheduleKey, 'number' => $number, 'year' => $value['year'], 'month' => $value['month'], 'day' => $i, 'week' => $week, 'select' => 'false');
						$number++;
						$days[$scheduleKey] = $arrayValue;
						
						$table_name = $wpdb->prefix . "booking_package_schedule";
						$sql = $wpdb->prepare(
							"SELECT *, `unixTime` - (`deadlineTime` * 60) as `unixTimeDeadline` FROM `" . $table_name . "` WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` = %d AND `holiday` = 'false' AND `status` = 'open' ORDER BY `unixTime` ASC;", 
							array(intval($accountCalendarKey), intval($value['year']), intval($value['month']), intval($i))
						);
						$key = intval($value['year'].sprintf("%02d%02d", $value['month'], $i));
						$rows = $wpdb->get_results($sql, ARRAY_A);
						foreach ((array) $rows as $scheduleKey => $scheduleData) {
							
							$rows[$scheduleKey] = $this->fixUnixTimeShift($scheduleData, $account['timezone']);
							$rows[$scheduleKey]['ymd'] = $key;
							$rows[$scheduleKey]['priceKeyByDayOfWeek'] = $nationalHoliday['calendar'][$key]['priceKeyByDayOfWeek'];
							
						}
						
						$schedule[$key] = $rows;
						if (isset($regularHoliday['calendar'][$key]) && intval($regularHoliday['calendar'][$key]['status']) == 1) {
							
							if ($account['type'] == "hotel") {
								
								if (isset($rows[0])) {
									
									$schedule[$key][0]['remainder'] = 0;
									
								}
								
							} else {
								
								$schedule[$key] = array();
								
							}
							
						}
						
						if (count($rows) == 0 && $account['type'] == "hotel") {
							
							#$schedule[$key] = array('unixTime' => date('U', mktime(0, 0, 0, $value['month'], $i, $value['year'])), "remainder" => 0);
							$schedule[$key] = array();
							
						}
						
						if (!is_null($schedule_start_day) && intval(date('Ymd', mktime(0, 0, 0, $value['month'], $i, $value['year']))) < $schedule_start_day) {
							
							$schedule[$key] = array();
							
						}
						
						if ($public == false) {
							
							$setting = new booking_package_setting($this->prefix, $this->pluginName);
							$numberKeys = $setting->getListOfDaysOfWeek();
							
							$startUnixTime = date('U', mktime(0, 0, 0, $value['month'], $i, $value['year']));
							$stopUnixTime = $startUnixTime + (1440 * 60);
							
							$targetSchedules = array();
							if ($this->targetSchedules == 1) {
								
								/**
								$table_name = $wpdb->prefix . "booking_package_calendarAccount";
								$sql = $wpdb->prepare(
									"SELECT `key`, `targetSchedules` FROM `" . $table_name . "` WHERE `targetSchedules` = %d AND `schedulesSharing` = 1;", 
									array(intval($accountKey))
								);
								$rows = $wpdb->get_results($sql, ARRAY_A);
								**/
								$rows = $this->getCalendarAccountsWithHavingSchedulesSharing($accountKey);
								if (is_null($rows) === false && count($rows) != 0) {
									
									$deleteList = array();
									for ($row = 0; $row < count($rows); $row++) {
										
										array_push($targetSchedules, '`accountKey` = ' . intval($rows[$row]['key']));
										
									}
									
								}
								
							}
							
							if (count($targetSchedules) > 0) {
								
								$targetSchedules = ' || ' . implode(' || ', $targetSchedules);
								
							} else {
								
								$targetSchedules = '';
								
							}
							
							$reserveData['targetSchedules'] = $targetSchedules;
							
							$visitorStatus = "";
							if (intval($account['displayDetailsOfCanceled']) == 0) {
								
								$visitorStatus = "`status` != 'canceled' AND ";
							}
							
							$table_name = $wpdb->prefix . "booking_package_userPraivateData";
							$sql = $wpdb->prepare(
								"SELECT * FROM `" . $table_name . "` WHERE " . $visitorStatus . " (`accountKey` = %d" . $targetSchedules . ") AND `scheduleUnixTime` >= %d AND `scheduleUnixTime` < %d ORDER BY `scheduleUnixTime` ASC;", 
								array(intval($accountKey), $startUnixTime, $stopUnixTime)
							);
							if ($account['type'] == 'hotel') {
								
								$sql = $wpdb->prepare(
									"SELECT * FROM `" . $table_name . "` WHERE " . $visitorStatus . " `accountKey` = %d AND `checkOut` >= %d AND `checkIn` < %d ORDER BY `scheduleUnixTime` ASC;", 
									array(intval($accountKey), $startUnixTime, $stopUnixTime)
								);
								#$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `checkIn` <= %d AND `checkOut` > %d ORDER BY `scheduleUnixTime` ASC;", array(intval($accountKey), $startUnixTime, $stopUnixTime));
								
							}
							
							$rows = $wpdb->get_results($sql, ARRAY_A);
							if (is_null($rows) === false && count($rows) != 0) {
								
								$deleteList = array();
								for ($row = 0; $row < count($rows); $row++) {
									
									if (!isset($visitorList[$rows[$row]['key']])) {
										
										$visitorList[$rows[$row]['key']] = 1;
										if ($rows[$row]['type'] == 'hotel' && intval($rows[$row]['checkIn']) != $startUnixTime) {
											
											#continue;
											array_push($deleteList, $row);
											
										}
										
									} else {
										
										$visitorList[$rows[$row]['key']]++;
										array_push($deleteList, $row);
										
									}
									
									$response = $this->getVistorsBookedList($rows[$row], $account['type'], $reservationForHotel, $numberKeys);
									$rows[$row] = $response['bookedData'];
									$reservationForHotel = $response['reservationForHotel'];
									
								}
								
								arsort($deleteList);
								for ($deleteKey = 0; $deleteKey < count($deleteList); $deleteKey++) {
									
									unset($rows[$deleteKey]);
									
								}
								
								if (count($rows) > 0) {
									
									$reservation[$key] = $rows;
									
								}
								
							}
							
						}
						
					}
					
					$table_name = $wpdb->prefix . "booking_package_schedule";
					$sql = $wpdb->prepare(
						"SELECT year,month,day,accountKey,SUM(capacity),SUM(remainder),COUNT(day) FROM `".$table_name."` GROUP BY `year`,`month`,`day`,`holiday`,`accountKey`,`status` HAVING `accountKey` = %d AND `year` = %d AND `month` = %d AND `day` >= %d AND `holiday` = 'false' AND `status` = 'open';", 
						array(intval($accountCalendarKey), intval($value['year']), intval($value['month']), intval($day))
					);
					
					if ($account['type'] == 'day' && intval($account['courseBool']) == 1) {
						
						$bookedServices = $this->getBookedServices(
							$bookedServices, 
							date('U', mktime(0, 0, 0, $value['month'], $value['startDay'], $value['year'])), 
							date('U', mktime(23, 59, 0, $value['month'], $value['lastDay'], $value['year'])), 
							$accountKey, 
							$accountCalendarKey
						);
						
						/**
						$table_name = $wpdb->prefix . "booking_package_userPraivateData";
						$sql = $wpdb->prepare(
							"SELECT `accountKey`, `scheduleUnixTime`, `status`, `options` FROM `" . $table_name . "` WHERE (`accountKey` = %d OR `accountKey` = %d) AND (`scheduleUnixTime` >= %d AND `scheduleUnixTime` <= %d) AND (`status` = 'pending' OR `status` = 'approved') ORDER BY `scheduleUnixTime` ASC;", 
							array(
								intval($accountKey), 
								intval($accountCalendarKey), 
								intval(date('U', mktime(0, 0, 0, $value['month'], $value['startDay'], $value['year']))), 
								intval(date('U', mktime(23, 59, 0, $value['month'], $value['lastDay'], $value['year'])))
							)
						);
						$bookedRows = $wpdb->get_results($sql, ARRAY_A);
						foreach ((array) $bookedRows as $bookedKey => $bookedValue) {
							
							$durationTime = 0;
							$dayKey = date('Ymd', $bookedValue['scheduleUnixTime']);
							$timeKey = date('Hi', $bookedValue['scheduleUnixTime']);
							$services = json_decode($bookedValue['options'], true);
							for ($i = 0; $i < count($services); $i++) {
								
								
								$service = $services[$i];
								$durationTime += intval($service['time']);
								$options = $service['options'];
								for ($o = 0; $o < count($options); $o++) {
									
									if (intval($options[$o]['selected']) == 1) {
										
										$durationTime += intval($options[$o]['time']);
										
									}
									
								}
								
								
								if (isset($bookedServices[$dayKey])) {
									
									if (isset($bookedServices[$dayKey][$timeKey])) {
										
										if (isset($bookedServices[$dayKey][$timeKey][$service['key']])) {
											
											$bookedServices[$dayKey][$timeKey][$service['key']]['count']++;
											array_push($bookedServices[$dayKey][$timeKey][$service['key']]['durationTimes'], $durationTime);
											if ($bookedServices[$dayKey][$timeKey][$service['key']]['maximumDurationTime'] < $durationTime) {
												
												$bookedServices[$dayKey][$timeKey][$service['key']]['maximumDurationTime'] = $durationTime;
												
											}
											
										} else {
											
											$bookedServices[$dayKey][$timeKey][$service['key']] = array(
												'count' => 1,
												'maximumDurationTime' => $durationTime,
												'durationTimes' => array($durationTime)
											);
											
										}
										
									} else {
										
										$bookedServices[$dayKey][$timeKey] = array(
											intval($service['key']) => array(
												'count' => 1,
												'maximumDurationTime' => $durationTime,
												'durationTimes' => array($durationTime)
											),
										);
										
									}
									
								} else {
									
									$bookedServices[$dayKey] = array(
										$timeKey => array(
											intval($service['key']) => array(
												'count' => 1,
												'maximumDurationTime' => $durationTime,
												'durationTimes' => array($durationTime)
											),
										),
									);
									
								}
								
							}
							
						}
						**/
						
					}
					
				}
				$reserveData['calendar'] = $days;
				$reserveData['schedule'] = $schedule;
				$reserveData['reservation'] = $reservation;
				$reserveData['reservationForHotel'] = $reservationForHotel;
				$reserveData['regularHoliday'] = $regularHoliday;
				$reserveData['nationalHoliday'] = $nationalHoliday;
				$reserveData['bookedServices'] = $bookedServices;
				
				/**
				if($public == false && $account->type == "hotel"){
					
					
					
				}
				**/
				
			}else{
				
				$startUnixTime = date('U', mktime(0, 0, 0, $month, $day, $year));
				#echo $month.'/'.$day.'/'.$year."\n";
				#var_dump($startUnixTime);
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$sql = $wpdb->prepare(
					"SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `scheduleUnixTime` >= %d ORDER BY `scheduleUnixTime` ASC;", 
					array(intval($accountKey), $startUnixTime)
				);
				
				if (intval($account['displayDetailsOfCanceled']) == 0) {
					
					$sql = $wpdb->prepare(
						"SELECT * FROM `".$table_name."` WHERE `status` != 'canceled' AND `accountKey` = %d AND `scheduleUnixTime` >= %d ORDER BY `scheduleUnixTime` ASC;", 
						array(intval($accountKey), $startUnixTime)
					);
					
				}
				
				$rows = $wpdb->get_results($sql, ARRAY_A);
				if(is_null($rows) === false && count($rows) != 0){
						
					for($row = 0; $row < count($rows); $row++){
						
						$json = json_decode($rows[$row]['praivateData'], true);
						$rows[$row]['praivateData'] = $json;
						$unixTime = $rows[$row]['scheduleUnixTime'];
						$rows[$row]['date'] = array('unixTime' => $unixTime, 'month' => date('m', $unixTime), 'day' => date('d', $unixTime), 'year' => date('Y', $unixTime), 'week' => date('w', $unixTime), 'hour' => date('H', $unixTime), 'min' => date('i', $unixTime), 'timeZone' => date('e', $unixTime));
						
					}
					
					$reserveData = $rows;
					
				}
				
			}
			
			return $reserveData;
			
		}
		
		public function getBookedServices($bookedServices, $start, $end, $accountKey, $accountCalendarKey = null) {
			
			global $wpdb;
			$sql = null;
			$table_name = $wpdb->prefix . "booking_package_userPraivateData";
			if (!is_null($accountCalendarKey)) {
				
				$sql = $wpdb->prepare(
					"SELECT `accountKey`, `scheduleUnixTime`, `status`, `options` FROM `" . $table_name . "` WHERE (`accountKey` = %d OR `accountKey` = %d) AND (`scheduleUnixTime` >= %d AND `scheduleUnixTime` <= %d) AND (`status` = 'pending' OR `status` = 'approved') ORDER BY `scheduleUnixTime` ASC;", 
					array(
						intval($accountKey), 
						intval($accountCalendarKey), 
						intval($start), 
						intval($end)
					)
				);
				
			} else {
				
				$sql = $wpdb->prepare(
					"SELECT `accountKey`, `scheduleUnixTime`, `status`, `options` FROM `" . $table_name . "` WHERE `accountKey` = %d AND (`scheduleUnixTime` >= %d AND `scheduleUnixTime` <= %d) AND (`status` = 'pending' OR `status` = 'approved') ORDER BY `scheduleUnixTime` ASC;", 
					array(
						intval($accountKey), 
						intval($start), 
						intval($end)
					)
				);
				
			}
			
			$bookedRows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $bookedRows as $bookedKey => $bookedValue) {
				
				$durationTime = 0;
				$dayKey = date('Ymd', $bookedValue['scheduleUnixTime']);
				$timeKey = date('Hi', $bookedValue['scheduleUnixTime']);
				$services = json_decode($bookedValue['options'], true);
				for ($i = 0; $i < count($services); $i++) {
					
					
					$service = $services[$i];
					$durationTime += intval($service['time']);
					$options = $service['options'];
					for ($o = 0; $o < count($options); $o++) {
						
						if (intval($options[$o]['selected']) == 1) {
							
							$durationTime += intval($options[$o]['time']);
							
						}
						
					}
					
					
					if (isset($bookedServices[$dayKey])) {
						
						if (isset($bookedServices[$dayKey][$timeKey])) {
							
							if (isset($bookedServices[$dayKey][$timeKey][$service['key']])) {
								
								$bookedServices[$dayKey][$timeKey][$service['key']]['count']++;
								array_push($bookedServices[$dayKey][$timeKey][$service['key']]['durationTimes'], $durationTime);
								if ($bookedServices[$dayKey][$timeKey][$service['key']]['maximumDurationTime'] < $durationTime) {
									
									$bookedServices[$dayKey][$timeKey][$service['key']]['maximumDurationTime'] = $durationTime;
									
								}
								
							} else {
								
								$bookedServices[$dayKey][$timeKey][$service['key']] = array(
									'count' => 1,
									'maximumDurationTime' => $durationTime,
									'durationTimes' => array($durationTime)
								);
								
							}
							
						} else {
							
							$bookedServices[$dayKey][$timeKey] = array(
								intval($service['key']) => array(
									'count' => 1,
									'maximumDurationTime' => $durationTime,
									'durationTimes' => array($durationTime)
								),
							);
							
						}
						
					} else {
						
						$bookedServices[$dayKey] = array(
							$timeKey => array(
								intval($service['key']) => array(
									'count' => 1,
									'maximumDurationTime' => $durationTime,
									'durationTimes' => array($durationTime)
								),
							),
						);
						
					}
					
				}
				
			}
			
			return $bookedServices;
			
		}
		
		
		public function getUsersBookedList($user_id, $offset = 0, $cancel = false) {
			
			global $wpdb;
			
			$setting = new booking_package_setting($this->prefix, $this->pluginName);
			$numberKeys = $setting->getListOfDaysOfWeek();
			
			$limit = 20;
			$table_name = $wpdb->prefix . "booking_package_userPraivateData";
			$sql = $wpdb->prepare(
				"SELECT * FROM `" . $table_name . "` WHERE `user_id` = %d ORDER BY `scheduleUnixTime` DESC, `key` DESC LIMIT %d, %d;", 
				array(intval($user_id), intval($offset), intval($limit))
			);
			
			$rows = $wpdb->get_results($sql, ARRAY_A);
			if(is_null($rows) === false && count($rows) != 0){
				
				$deleteList = array();
				for($row = 0; $row < count($rows); $row++){
					
					$response = $this->getVistorsBookedList($rows[$row], $rows[$row]['type'], array(), $numberKeys);
					if ($cancel === true) {
						
						$response['bookedData']['cancel'] = 0;
						$cancelFlag = $this->verifyCancellation($response['bookedData'], true, $user_id);
						if ($cancelFlag['cancel'] === true) {
							
							$response['bookedData']['cancel'] = 1;
							
						}
						
					}
					$rows[$row] = $response['bookedData'];
					
				}
				
			}
			
			$size = count(array_keys($rows));
			$next = 1;
			if ($size < $limit) {
				
				$next = 0;
				
			}
    		
    		return array('status' => 'success', 'bookedList' => $rows, 'limit' => intval($limit), 'offset' => intval($offset), 'size' => intval($size), 'next' => $next);
    		
    	}
    	
    	public function getVistorsBookedList($bookedData, $type, $reservationForHotel, $numberKeys) {
    		
    		if (empty($bookedData['status'])) {
				
				$bookedData['status'] = 'pending';
				
			}
			
			if (empty($bookedData['guests'])) {
				
				$bookedData['guests'] = array();
				
			} else {
				
				$guests = json_decode($bookedData['guests'], true);
				$bookedData['guests'] = $guests;
				
			}
			
			if (empty($bookedData['coupon'])) {
				
				$bookedData['coupon'] = array();
				
			} else {
				
				$coupon = json_decode($bookedData['coupon'], true);
				$bookedData['coupon'] = $coupon;
				
			}
			
			$json = json_decode($bookedData['praivateData'], true);
			$bookedData['praivateData'] = $json;
			
			$json = json_decode($bookedData['options'], true);
			$bookedData['options'] = $json;
			
			#$bookedData['taxes'] = json_decode($bookedData['taxes'], true);
			$taxes = json_decode($bookedData['taxes'], true);
			if ($taxes === false || is_null($taxes)) {
				
				$bookedData['taxes'] = array();
				
			} else {
				
				$bookedData['taxes'] = $taxes;
				
			}
			
			
			$unixTime = $bookedData['scheduleUnixTime'];
			$bookedData['date'] = array(
				'month' => date('n', $unixTime), 
				'day' => date('d', $unixTime), 
				'year' => date('Y', $unixTime), 
				'week' => date('w', $unixTime), 
				'hour' => date('H', $unixTime), 
				'min' => date('i', $unixTime), 
				'timeZone' => date('e', $unixTime), 
				'checkIn' => 0, 
				'checkOut' => 0,
				'key' => date('Y', $unixTime) . date('m', $unixTime) . date('d', $unixTime)
			);
			
			$timestamp = $bookedData['reserveTime'];
			$bookedData['timestamp'] = array(
				'month' => date('n', $timestamp), 
				'day' => date('d', $timestamp), 
				'year' => date('Y', $timestamp), 
				'week' => date('w', $timestamp), 
				'hour' => date('H', $timestamp), 
				'min' => date('i', $timestamp), 
				'timeZone' => date('e', $timestamp), 
			);
			
			if ($type == "hotel") {
				
				$bookedData['date']['checkIn'] = date('Ymd', $bookedData['checkIn']);
				$bookedData['date']['checkOut'] = date('Ymd', $bookedData['checkOut']);
				$bookedData['date']['checkIn_month'] = date('n', $bookedData['checkIn']);
				$bookedData['date']['checkIn_day'] = date('j', $bookedData['checkIn']);
				$bookedData['date']['checkIn_year'] = date('Y', $bookedData['checkIn']);
				$bookedData['date']['checkIn_week'] = date('w', $bookedData['checkIn']);
				$bookedData['date']['checkOut_month'] = date('n', $bookedData['checkOut']);
				$bookedData['date']['checkOut_day'] = date('j', $bookedData['checkOut']);
				$bookedData['date']['checkOut_year'] = date('Y', $bookedData['checkOut']);
				$bookedData['date']['checkOut_week'] = date('w', $bookedData['checkOut']);
				
				$bookedData['accommodationDetails'] = json_decode($bookedData['accommodationDetails'], true);
				if (isset($bookedData['accommodationDetails']['rooms']) === false) {
					
					$bookedData['accommodationDetails']['rooms'] = null;
					
				}
				if (!isset($bookedData['accommodationDetails']['taxesFee'])) {
					
					$bookedData['accommodationDetails']['taxesFee'] = 0;
					
				}
				
				if (is_null($bookedData['accommodationDetails']['rooms'])) {
					
					$bookedData['accommodationDetails']['applicantCount'] = 1;
					$bookedData['accommodationDetails']['rooms'] = $this->createRooms($bookedData['accommodationDetails']);
					
				} else {
					
					for ($i = 0; $i < count($bookedData['accommodationDetails']['rooms']); $i++) {
						
						$guests = $bookedData['accommodationDetails']['rooms'][$i]['guests'];
						$guestsList = $bookedData['accommodationDetails']['rooms'][$i]['guestsList'];
						foreach ((array) $guestsList as $key => $guest) {
							
							$guests[$key] = $this->updatePricesForGuest(array($guests[$key]), $numberKeys);
							$guestsList[$key]['json'] = $this->updatePricesForGuest($guestsList[$key]['json'], $numberKeys);
							$bookedData['accommodationDetails']['rooms'][$i]['guests'][$key] = $guests[$key][0];
							$bookedData['accommodationDetails']['rooms'][$i]['guestsList'][$key]['json'] = $guestsList[$key]['json'];
							
						}
						
					}
					
				}
				
				
				$time = intval($bookedData['checkIn']);
				while ($time <= intval($bookedData['checkOut'])) {
					
					$dateKey = date('Ymd', $time);
					if (!isset($reservationForHotel[$dateKey])) {
						
						$reservationForHotel[$dateKey] = array();
						
					}
					
					$reservationForHotel[$dateKey][$bookedData['key']] = $bookedData;
					$time += 1440 * 60;
					
				}
				
			} else {
				
				$bookedData = $this->updateVistorService($bookedData);
				$bookedData['test'] = 1;
				
			}
			
			return array('bookedData' => $bookedData, 'reservationForHotel' => $reservationForHotel);
			#return $bookedData;
    		
    	}
    	
    	public function createRooms($accommodationDetails) {
    		
    		#$setting = new booking_package_setting($this->prefix, $this->pluginName);
			#$numberKeys = $setting->getListOfDaysOfWeek();
    		$guests = array();
			$amount = 0;
			foreach ((array) $accommodationDetails['guestsList'] as $key => $guest) {
				
				$guestList = $guest['json'];
				for ($i = 0; $i < count($guestList); $i++) {
					
					$selected = intval($guestList[$i]['selected']);
					unset($guestList[$i]['selected']);
					if ($i == 0) {
						
						$guests[$key] = $guestList[$i];
						
					}
					
					if ($selected == 1) {
						
						$guests[$key] = $guestList[$i];
						$amount += intval($guestList[$i]['price']);
						break;
						
					}
					
				}
				
			}
			
			if (isset($accommodationDetails['adult']) === false) {
				
				$accommodationDetails['adult'] = 0;
				
			}
			
			if (isset($accommodationDetails['children']) === false) {
				
				$accommodationDetails['children'] = 0;
				
			}
			
			$room = array(
				'booking' => true, 
				'requiredGuests' => true, 
				'guests' => $guests, 
				'adult' => $accommodationDetails['adult'], 
				'children' => $accommodationDetails['children'], 
				'person' => $accommodationDetails['adult'] + $accommodationDetails['children'], 
				'amount' => $amount,
				'additionalFee' => $amount, 
				'guestsList' => $accommodationDetails['guestsList'],
				'createdRoor' => 1,
			);
			$rooms = array($room);
			return $rooms;
    		
    	}
    	
    	public function updateVistorService($visitor) {
    		
    		if (empty($visitor['courseKey']) === false) {
    			
    			$service = array(
    				"key" => $visitor['courseKey'],
    				"accountKey" => $visitor['accountKey'],
    				"name" => $visitor['courseName'],
    				"time" => $visitor['courseTime'],
    				"cost" => $visitor['courseCost'],
    				"active" => "true",
    				"service" => 1,
    				"selected" => 1,
    				"options" => array(),
    			);
    			
    			if (count($visitor['options']) > 0) {
    				
    				$service["options"] = $visitor['options'];
    				
    			}
    			
    			$visitor['courseKey'] = null;
    			$visitor['courseName'] = null;
    			$visitor['courseTime'] = null;
    			$visitor['courseCost'] = null;
    			
    			$visitor['options'] = array($service);
    			
    		}
    		
    		if (isset($visitor['options']) === false) {
    			
    			$visitor['options'] = array();
    			
    		}
    		
    		return $visitor;
    		
    	}
    	
    	public function getDownloadCSV(){
    		
    		global $wpdb;
    		$response = array("status" => "success", "csv" => null);
    		$visitorsList = array();
    		$csv = '';
    		$calendarAccount = $this->getCalendarAccount($_POST['accountKey']);
    		date_default_timezone_set($calendarAccount['timezone']);
    		$currency = get_option($this->prefix."currency", 'usd');
    		$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
    		$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
    		
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
    		$startUnixTime = 0;
    		$stopUnixTime = 0;
    		if (isset($_POST['day']) && $_POST['day'] != '') {
    			
    			$startUnixTime = date('U', mktime(0, 0, 0, intval($_POST['month']), intval($_POST['day']), intval($_POST['year'])));
    			$stopUnixTime = date('U', mktime(23, 59, 59, intval($_POST['month']), intval($_POST['day']), intval($_POST['year'])));
    			
    		} else {
    			
    			$lastDay = date('t', mktime(0, 0, 0, intval($_POST['month']), 1, intval($_POST['year'])));
    			$startUnixTime = date('U', mktime(0, 0, 0, intval($_POST['month']), 1, intval($_POST['year'])));
    			$stopUnixTime = date('U', mktime(23, 59, 59, intval($_POST['month']), intval($lastDay), intval($_POST['year'])));
    			
    		}
			$sql = $wpdb->prepare(
				"SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `scheduleUnixTime` >= %d AND `scheduleUnixTime` < %d ORDER BY `key` ASC;", 
				array(intval($_POST['accountKey']), $startUnixTime, $stopUnixTime)
			);
			$response['sql'] = $sql;
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $row) {
				
				$guestsList = array();
				$guests = json_decode($row['guests'], true);
				if (is_null($guests) === false && isset($guests['guests'])) {
					
					$reflectAdditional = intval($guests['reflectAdditional']);
					$reflectAdditionalTitle = $guests['reflectAdditionalTitle'];
					$reflectService = intval($guests['reflectService']);
					$reflectServiceTitle = $guests['reflectServiceTitle'];
					$guestsList = $guests['guests'];
	
				}
				
				$visitor = array(
					"key" => $row['key'],
					"status" => $row['status'],
				);
				
				if ($calendarAccount['type'] == 'day') {
					
					$visitor['scheduleDate'] = $this->dateFormat($dateFormat, $positionOfWeek, $row['scheduleUnixTime'], $row['scheduleTitle'], true, false, 'text');
					$visitor['services'] = array();
					$visitor['guests'] = array();
					$visitor['coupon'] = null;
					$visitor['amount'] = 0;
					
					$coupon = null;
					if (isset($row['coupon']) && !empty($row['coupon'])) {
						
						$coupon = json_decode($row['coupon'], true);
						$visitor['coupon'] = $coupon['name'] . ' (' . $coupon['id'] . ')';
						
					}
					
					#$responseGuests = json_decode($row['guests'], true);
					$responseGuests = $this->jsonDecodeForGuests($row['guests']);
					$selectedOptionsObject = $this->getSelectedOptions($calendarAccount, $row['options'], $responseGuests['guests']);
					$servicesDetails = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $row['applicantCount']);
					$services = $servicesDetails['object'];
					$visitor['amount'] += $servicesDetails['cost'];
					
					#$services = json_decode($row['options'], true);
					foreach ((array) $services as $service) {
						
						array_push($visitor['services'], $service['name']);
						foreach ((array) $service['options'] as $option) {
							
							if (intval($option['selected']) == 1) {
								
								#$amount += intval($option['cost']) * $reflectService;
								array_push($visitor['services'], $option['name']);
								
							}
							
						}
						
					}
					
					$guestsList = array();
					if (is_null($responseGuests) === false && isset($responseGuests['guests'])) {
						
						#$reflectAdditional = intval($responseGuests['reflectAdditional']);
						#$reflectAdditionalTitle = $responseGuests['reflectAdditionalTitle'];
						#$reflectService = intval($responseGuests['reflectService']);
						#$reflectServiceTitle = $responseGuests['reflectServiceTitle'];
						$guestsList = $responseGuests['guests'];
		
					}
					
					for ($i = 0; $i < count($guestsList); $i++) {
						
						$guest = $guestsList[$i];
						$index = intval($guest['index']);
						if ($index > 0) {
							
							array_push($visitor['guests'], $guest['name'].": ".$guest['json'][$index]['name']);
							
						}
						
					}
					
					$visitor['services'] = implode(' ', $visitor['services']);
					$visitor['guests'] = implode(" ", $visitor['guests']);
					$taxes = json_decode($row['taxes'], true);
					foreach ((array) $taxes as $tax) {
						
						if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_exclusive') {
							
							$visitor['amount'] += intval($tax['taxValue']);
							
						} else if ($tax['type'] == 'surcharge') {
							
							$visitor['amount'] += intval($tax['taxValue']);
							
						}
						
					}
					
				} else {
					
					$visitor['checkIn'] = $this->dateFormat($dateFormat, $positionOfWeek, $row['checkIn'], null, false, false, 'text');
					$visitor['checkOut'] = $this->dateFormat($dateFormat, $positionOfWeek, $row['checkOut'], null, false, false, 'text');
					$accommodationDetails = json_decode($row['accommodationDetails'], true);
					$visitor['adults'] = 0;
					$visitor['children'] = 0;
					$visitor['amount'] = intval($accommodationDetails['totalCost']);
					foreach ((array) $accommodationDetails['guestsList'] as $guest) {
						
						foreach ((array) $guest['json'] as $value) {
							
							if (intval($value['selected']) == 1) {
								
								if ($guest['target'] == 'adult') {
									
									$visitor['adults'] += intval($value['number']);
									
								} else {
									
									$visitor['children'] += intval($value['number']);
									
								}
								
							}
							
						}
						
					}
					$visitor['adults'] = 'Adults: ' . $visitor['adults'];
					$visitor['children'] = 'Children: ' . $visitor['children'];
					
				}
				
				$visitor['amount'] = $this->formatCost($visitor['amount'], $currency);
				$praivateData = json_decode($row['praivateData'], true);
				for ($i = 0; $i < count($praivateData); $i++) {
					
					$id = "form_".$praivateData[$i]['id'];
					if (is_string($praivateData[$i]['value'])) {
						
						$visitor[$id] = $praivateData[$i]['value'];
						
					} else if (is_array($praivateData[$i]['value'])) {
						
						$visitor[$id] = implode(' ', $praivateData[$i]['value']);
						
					}
					
				}
				
				array_push($visitorsList, $visitor);
				$csv .= implode(",", $visitor) . "\r\n";
				
			}
			
			$temp = tmpfile();
			$path = stream_get_meta_data($temp)['uri'];
			$fp = fopen($path, 'w');
			foreach ((array) $visitorsList as $key => $value) {
				
				fputcsv($fp, $value);
				
			}
			fseek($fp, 0);
			$csv = file_get_contents($path);
			fclose($temp);
			
			
			$response['rows'] = $rows;
			$response['visitorsList'] = $visitorsList;
			$response['calendarAccount'] = $calendarAccount;
			$response['csv'] = $csv;
			return $response;
			
		}
		
		public function serachCoupons($unixTime, $couponID, $accountKey) {
			
			#$currentDate = intval(date('Ymd'));
			$currentDate = intval(date('Ymd', $unixTime));
			$response = array('status' => 0, 'coupon' => array(), 'currentDate' => $currentDate, 'message' => '');
			global $wpdb;
            $table_name = $wpdb->prefix . "booking_package_coupons";
            $sql = $wpdb->prepare(
                "SELECT * FROM " . $table_name . " WHERE `active` = 1 AND `status` = 'active' AND `accountKey` = %d AND `id` = %s;", 
                array(
                    intval($accountKey), 
                    sanitize_text_field(trim($couponID))
                )
            );
            $coupon = $wpdb->get_row($sql, ARRAY_A);
            if (!empty($coupon)) {
				
				if ($coupon['target'] == 'users') {
					
					$user = $this->get_user();
					if (intval($user['status']) == 1) {
						
						$user_login = $user['user']['user_login'];
						if ($coupon['limited'] == 'limited') {
							
							$table_name = $wpdb->prefix . "booking_package_userPraivateData";
							$sql = $wpdb->prepare(
								"SELECT COUNT(`key`) FROM " . $table_name . " WHERE `user_login` = %s AND `couponKey` = %d;", 
								array(
									sanitize_text_field($user_login),
									intval($coupon['key']), 
								)
							);
							$usedCoupon = $wpdb->get_row($sql, ARRAY_A);
							$response['usedCoupon'] = intval($usedCoupon['COUNT(`key`)']);
							if (intval($usedCoupon['COUNT(`key`)']) > 0) {
								
								$response['message'] = sprintf(__('You have already used the coupon code of "%s".', $this->pluginName), $couponID);
								return $response;
								
							}
							
						}
						
					} else {
						
						$response['message'] = sprintf(__('Not found the coupon code of "%s".', $this->pluginName), $couponID) . " \nCause: 1";
						return $response;
						
					}
					
				}
				
				if (intval($coupon['expirationDateStatus']) == 1) {
					
					$isBooking = $this->validExpirationDate($currentDate, $coupon['expirationDateStatus'], $coupon['expirationDateFrom'], $coupon['expirationDateTo']);
					$response['isBooking'] = $isBooking;
					if ($isBooking === false) {
						
						$response['message'] = sprintf(__('Not found the coupon code of "%s".', $this->pluginName), $couponID) . " \nCause: 2";
						return $response;
						
					}
					
				}
                
                $response['status'] = 1;
                $response['coupon'] = $coupon;
                
            } else {
				
				$response['message'] = sprintf(__('Not found the coupon code of "%s".', $this->pluginName), $couponID) . " \nCause: 3";
				
			}
			
			return $response;
			
		}
		
		public function serachCourse($accountKey, $scheduleKey, $key = false, $bookingYMD = null, $time = false){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_courseData";
			if ($key !== false) {
				
				$sql = $wpdb->prepare(
					"SELECT `key`, `name`, `time`, `cost`, `expirationDateStatus`, `expirationDateFrom`, `expirationDateTo`, `stopServiceUnderFollowingConditions`, `doNotStopServiceAsException`, `stopServiceForDayOfTimes`, `stopServiceForSpecifiedNumberOfTimes` FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d LIMIT 0, 1;", 
					array(intval($accountKey), intval($key))
				);
				
			}
			
			if ($time !== false) {
				
				$sql = $wpdb->prepare(
					"SELECT `key`, `name`, `time`, `cost`, `expirationDateStatus`, `expirationDateFrom`, `expirationDateTo`, `stopServiceUnderFollowingConditions`, `doNotStopServiceAsException`, `stopServiceForDayOfTimes`, `stopServiceForSpecifiedNumberOfTimes` FROM `".$table_name."` WHERE `accountKey` = %d AND `time` = %d LIMIT 0, 1;", 
					array(intval($accountKey), intval($time))
				);
				
			}
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				return array('status' => 'error', 'message' => sprintf(__('%s was not found', $this->pluginName), 'Service'));
				
			} else {
				
				$isExtensionsValid = $this->getExtensionsValid(false);
				if ($isExtensionsValid !== true) {
					
					$row['stopServiceUnderFollowingConditions'] = 'doNotStop';
					
				}
				
				$isBooking = $this->validExpirationDate(intval($bookingYMD), intval($row['expirationDateStatus']), intval($row['expirationDateFrom']), intval($row['expirationDateTo']));
				//if (is_int($bookingYMD) && intval($row['expirationDateStatus']) == 1 && (intval($row['expirationDateFrom']) > $bookingYMD || intval($row['expirationDateTo']) < $bookingYMD)) {
				if ($isBooking === false) {
					
					return array('status' => 'error', 'message' => sprintf(__('%s was not found', $this->pluginName), $row['name']));
					
				}
				
				$invalidService = $this->invalidService($accountKey, $scheduleKey, $row, $bookingYMD);
				if ($invalidService === false) {
					
					return array('status' => 'error', 'message' => sprintf(__('%s was not found', $this->pluginName), $row['name']) . " #2");
					
				}
				
				return $row;
				
			}
			
		}
		
		public function invalidService($accountKey, $scheduleKey, $requestService, $bookingYMD) {
			
			global $wpdb;
			$response = true;
			$hasServices = array();
			$table_name = $wpdb->prefix . "booking_package_userPraivateData";
			$sql = $wpdb->prepare(
				"SELECT `accountKey`, `status`, `options` FROM `" . $table_name . "` WHERE `scheduleKey` = %d AND `status` != 'canceled';", 
				array(intval($scheduleKey))
			);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $row) {
				
				$services = json_decode($row['options'], true);
				for ($i = 0; $i < count($services); $i++) {
					
					$serviceKey = intval($services[$i]['key']);
					if (isset($hasServices[$serviceKey])) {
						
						$hasServices[$serviceKey]++;
						
					} else {
						
						$hasServices[$serviceKey] = 1;
						
					}
					
				}
				
			}
			
			if ($requestService['stopServiceUnderFollowingConditions'] == 'isNotEqual' || $requestService['stopServiceUnderFollowingConditions'] == 'isEqual') {
				
				if ($requestService['stopServiceUnderFollowingConditions'] == 'isNotEqual') {
					
					if (count($rows) != 0) {
						
						$response = false;
						
					}
					
					if ($requestService['doNotStopServiceAsException'] == 'sameServiceIsNotStopped') {
						
						if (isset($hasServices[intval($requestService['key'])])) {
							
							$response = true;
							
						}
						
					}
					
				} else if ($requestService['stopServiceUnderFollowingConditions'] == 'isEqual') {
					
					if (count($rows) == 0) {
						
						$response = false;
						
					}
					
				}
				
			} else if ($requestService['stopServiceUnderFollowingConditions'] == 'specifiedNumberOfTimes') {
				
				if ($requestService['stopServiceForDayOfTimes'] == 'timeSlot') {
					
					if (isset($hasServices[intval($requestService['key'])]) && $hasServices[intval($requestService['key'])] >= intval($requestService['stopServiceForSpecifiedNumberOfTimes'])) {
						
						$response = false;
						
					}
					
				} else if ($requestService['stopServiceForDayOfTimes'] == 'day') {
					
					$accountCalendarKey = null;
					$calendarAccount = $this->getCalendarAccount($accountKey);
					if (intval($calendarAccount['schedulesSharing']) == 1) {
						
						$accountCalendarKey = intval($calendarAccount['targetSchedules']);
						
					}
					
					$schedule = $this->getAccountSchedule($scheduleKey);
					if ($schedule === false) {
						
						return false;
						
					}
					
					$bookedServices = $this->getBookedServices(
						array(), 
						date('U', mktime(0, 0, 0, $schedule['month'], $schedule['day'], $schedule['year'])), 
						date('U', mktime(23, 59, 0, $schedule['month'], $schedule['day'], $schedule['year'])), 
						$accountKey, 
						$accountCalendarKey
					);
					#var_dump($bookedServices);
					
				}
				
			}
			
			/**
			if ($requestService['stopServiceUnderFollowingConditions'] != 'doNotStop') {
				
				$hasServices = array();
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$sql = $wpdb->prepare(
					"SELECT `accountKey`, `status`, `options` FROM `".$table_name."` WHERE `scheduleKey` = %d AND `status` != 'canceled';", 
					array(intval($scheduleKey))
				);
				$rows = $wpdb->get_results($sql, ARRAY_A);
				#var_dump(count($rows));
				foreach ((array) $rows as $row) {
					
					$services = json_decode($row['options'], true);
					for ($i = 0; $i < count($services); $i++) {
						
						$serviceKey = intval($services[$i]['key']);
						if (isset($hasServices[$serviceKey])) {
							
							$hasServices[$serviceKey]++;
							
						} else {
							
							$hasServices[$serviceKey] = 1;
							
						}
						
					}
					
				}
				
				#var_dump($hasServices);
				if ($requestService['stopServiceUnderFollowingConditions'] == 'isNotEqual') {
					
					if (count($rows) != 0) {
						
						$response = false;
						
					}
					
					if ($requestService['doNotStopServiceAsException'] == 'sameServiceIsNotStopped') {
						
						if (isset($hasServices[intval($requestService['key'])])) {
							
							$response = true;
							
						}
						
					}
					
				} else if ($requestService['stopServiceUnderFollowingConditions'] == 'isEqual') {
					
					if (count($rows) == 0) {
						
						$response = false;
						
					}
					
				}
				
			}
			**/
			
			return $response;
			
		}
		
		public function validExpirationDate($bookingYMD, $expirationDateStatus, $expirationDateFrom, $expirationDateTo) {
			
			$isBooking = true;
			//if (is_int($bookingYMD) && intval($expirationDateStatus) == 1 && (intval($expirationDateFrom) > $bookingYMD || intval($expirationDateTo) < $bookingYMD)) {
			if (is_int($bookingYMD) && intval($expirationDateStatus) == 1 && $expirationDateFrom != 0 && $expirationDateTo != 0 && (($expirationDateFrom <= $bookingYMD && $expirationDateTo < $bookingYMD) || ($expirationDateFrom > $bookingYMD && $expirationDateTo >= $bookingYMD))) {
				
				$isBooking = false;
				
			}
			
			return $isBooking;
			
		}
		
		public function getStatus($userDetail = false){
			
			#$this->automaticApprove = boolval(intval(get_option($this->prefix."automaticApprove", 0)));
			$this->automaticApprove = intval(get_option($this->prefix."automaticApprove", 0));
			if ($this->automaticApprove == 0) {
				
				$this->automaticApprove = false;
				
			} else {
				
				$this->automaticApprove = true;
				
			}
			$status = "pending";
			if ($userDetail !== false) {
				
				if (isset($userDetail['status'])) {
					
					return $userDetail['status'];
					
				} else {
					
					if ($this->automaticApprove === true) {
						
						$status = "approved";
						
					}
					
				}
				
			} else {
				
				if ($this->automaticApprove === true) {
					
					$status = "approved";
					
				}
				
			}
			
			return $status;
			
		}
		
		public function serachSchedule($unixTime, $accountKey = 1){
			
			global $wpdb;
			$table_name = $wpdb->prefix."booking_package_schedule";
			$sql = $wpdb->prepare(
				"SELECT `key`,`unixTime`,`title`,`capacity`,`remainder`,`stop` FROM `".$table_name."` WHERE `accountKey` = %d AND `unixTime` = %d AND `status` = 'open' LIMIT 0, 1;", 
				array(intval($accountKey), intval($unixTime))
			);
			$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				return array('status' => 'error');
				
			} else {
				
				return $row;
				
			}
			
		}
		
		public function updatePricesForGuest($guests, $numberKeys) {
			
			for ($a = 0; $a < count($guests); $a++) {
				
				for ($i = 0; $i < count($numberKeys); $i++) {
					
					if (isset($guests[$a][$numberKeys[$i]]) === false) {
						
						$guests[$a][$numberKeys[$i]] = $guests[$a]['price'];
						
					}
					
				}
				
			}
			
			return $guests;
			
		}
		
		public function createAccommodationDetails($originCalendarKey, $calendarAccountKey, $json, $sql_start_unixTime, $applicantCount, $type, $accommodationDetails = null){
			
			global $wpdb;
			$setting = new booking_package_setting($this->prefix, $this->pluginName);
			$numberKeys = $setting->getListOfDaysOfWeek();
			$calendarAccount = $this->getCalendarAccount($calendarAccountKey);
			$accountKey = $calendarAccount['key'];
			$person = 0;
			$nights = 0;
			$additionalFee = 0;
			$totalCost = 0;
			$totalTax = 0;
			if (is_null($accommodationDetails)) {
				
				$accommodationDetails = array("scheduleList" => array(), "guestsList" => array(), 'type' => $calendarAccount['type'], 'taxes' => array(), 'applicantCount' => $applicantCount);
				
			} else {
				
				$unixTimeEnd = $accommodationDetails['checkOut'];
				$nights = $accommodationDetails['nights'];
				$additionalFee = $accommodationDetails['additionalFee'];
				$totalCost = $accommodationDetails['accommodationFee'];
					
			}
			
			if (is_array($json)) {
				
				$jsonList = $json;
				
			} else {
				
				#$jsonList = json_decode(str_replace("\\", "", $json), true);
				$jsonList = json_decode(stripslashes($json), true);
				
			}
			
			if (isset($jsonList['applicantCount'])) {
				
				$accommodationDetails['applicantCount'] = intval($jsonList['applicantCount']);
				$applicantCount = intval($jsonList['applicantCount']);
				
			}
			
			$scheduleList = array_values($jsonList['list']);
			$first = null;
			$last = null;
			if (count($scheduleList) != 0) {
				
				$nights = 0;
				$totalCost = 0;
				$first = reset($scheduleList);
				$last = end($scheduleList);
				$table_name = $wpdb->prefix . "booking_package_schedule";
				$sql = $wpdb->prepare(
					"SELECT `key`,`month`,`day`,`year`, `title`, `stop`,`weekKey`,`unixTime`,`cost`,`remainder` FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) AND `status` = 'open' ORDER BY `unixTime` ASC;", 
					array(intval($accountKey), intval($first['unixTime']), intval($last['unixTime']))
				);
				$rows = $wpdb->get_results($sql, ARRAY_A);
				if (count($rows) != 0 && !is_null($rows)) {
					
					$accommodationDetails['scheduleList'] = array();
					$accommodationDetails['scheduleDetails'] = array();
					$unixTimeList = array();
					$i = 0;
					foreach ((array) $rows as $row) {
						
						array_push($accommodationDetails['scheduleList'], $row['key']);
						$accommodationDetails['scheduleDetails'][$row['unixTime']] = $row;
						$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
						$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
						$date = $this->dateFormat($dateFormat, $positionOfWeek, $row['unixTime'], $row['title'], false, false, 'text');
						if ($type == 'book' && $row['remainder'] <= 0) {
							
							return array("status" => "error", "message" => sprintf(__("There is no vacancy in the room on %s"), $date));
							
						}
						
						if ($this->confirmRegularHolidays($accountKey, $row['month'], $row['day'], $row['year']) === true) {
							
							return array("status" => "error", "message" => __("The schedule you requested has been closed.", $this->pluginName));
							
						}
						
						if ($row['stop'] == 'true') {
							
							return array("status" => "error", "message" => sprintf(__("Booking of %s is suspended."), $date));
								
						}
						
						if ($i != 0) {
							
							$time = ($row['unixTime'] - $unixTime) / 60;
							array_push($unixTimeList, $time);
							$unixTime = $row['unixTime'];
							if ($time < 1440) {
								
								return array("status" => "error", "message" => __("Schedule was not found", $this->pluginName), "sql" => $sql);
								
							}
							
						} else {
							
							$unixTime = $row['unixTime'];
							
						}
						
						$i++;
						$nights++;
						$totalCost += intval($row['cost']) * $applicantCount;
						
					}
					
					ksort($accommodationDetails['scheduleDetails']);
					
					$table_name = $wpdb->prefix . "booking_package_schedule";
					$sql = $wpdb->prepare(
						"SELECT `key`,`month`,`day`,`year`,`weekKey`,`unixTime` FROM `".$table_name."` WHERE `key` = %d AND `status` = 'open';", 
						array(intval($jsonList['checkInKey']))
					);
					$row = $wpdb->get_row($sql, ARRAY_A);
					$checkInUnixTime = $row['unixTime'];
					$accommodationDetails['checkInSchedule'] = $row;
					
					$sql = $wpdb->prepare(
						"SELECT `key`,`month`,`day`,`year`,`weekKey`,`unixTime` FROM `".$table_name."` WHERE `key` = %d AND `status` = 'open';", 
						array(intval($jsonList['checkOutKey']))
					);
					$row = $wpdb->get_row($sql, ARRAY_A);
					$checkOutUnixTime = $row['unixTime'];
					$accommodationDetails['checkOutSchedule'] = $row;
					
					$table_name = $wpdb->prefix . "booking_package_regular_holidays";
					$sql = $wpdb->prepare(
						"SELECT `month`,`day`,`year`,`unixTime`,`status` FROM `" . $table_name . "` WHERE `accountKey` = 'national' AND `status` = 1 AND `unixTime` >= %d AND `unixTime` <= %d ORDER BY `unixTime` ASC;", 
						array(
							intval($checkInUnixTime), 
							intval($checkOutUnixTime), 
						)
					);
					#var_dump($sql);
					$rows = $wpdb->get_results($sql, ARRAY_A);
					$rows = $this->addPriceKeyByDayOfWeek($rows, $numberKeys, true);
					$accommodationDetails['scheduleDetails'] = $this->addPriceKeyByDayOfWeek($accommodationDetails['scheduleDetails'], $numberKeys, false);
					foreach ((array) $rows as $row) {
						
						$key = date('U', mktime(0, 0, 0, intval($row['month']), intval($row['day']), intval($row['year'])));
						$accommodationDetails['scheduleDetails'][$key]['priceKeyByDayOfWeek'] = $row['priceKeyByDayOfWeek'];
						
					}
					
					foreach ((array) $accommodationDetails['scheduleDetails'] as $schedule) {
						
						if ($schedule['priceKeyByDayOfWeek'] == 'priceOnNationalHoliday') {
							
							$dayBeforeUnixTime = intval($schedule['unixTime']) - (1440 * 60);
							#$dayBeforeKey = date('Y', $dayBeforeUnixTime) . date('m', $dayBeforeUnixTime) . date('d', $dayBeforeUnixTime);
							if (isset($accommodationDetails['scheduleDetails'][$dayBeforeUnixTime]) && $accommodationDetails['scheduleDetails'][$dayBeforeUnixTime]['priceKeyByDayOfWeek'] != 'priceOnNationalHoliday') {
								
								$accommodationDetails['scheduleDetails'][$dayBeforeUnixTime]['priceKeyByDayOfWeek'] = 'priceOnDayBeforeNationalHoliday';
								
							}
							
						}
						
					}
					
					$sql_max_unixTime = $sql_start_unixTime;
					for($i = 0; $i < count($unixTimeList); $i++){
						
						$sql_max_unixTime += $unixTimeList[$i] * 60;
						
					}
					
					$accommodationDetails['checkIn'] = intval($sql_start_unixTime);
					$accommodationDetails['checkOut'] = intval($sql_max_unixTime) + (1440 * 60);
					$accommodationDetails['lastUnixTime'] = intval($sql_max_unixTime);
					$accommodationDetails['nights'] = $nights;
					$accommodationDetails['accommodationFee'] = $totalCost;
					$accommodationDetails['sql_max_unixTime'] = $sql_max_unixTime;
					$maintenanceTime = 0;
					$sql_max_unixTime += $maintenanceTime * 60;
					#$sql_max_unixTime = $sql_start_unixTime + ($courseTime * 60) + ($maintenanceTime * 60);
					$table_name = $wpdb->prefix."booking_package_schedule";
					$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
					$valueArray = array(intval($accountKey), intval($sql_start_unixTime), intval($sql_max_unixTime));
					$accommodationDetails['sql'] = $account_sql;
					$accommodationDetails['valueArray'] = $valueArray;
					$jsonList['sql'] = $wpdb->prepare($account_sql, $valueArray);
					
				}
				
			}
			
			$personAmount = 0;
			if (count($jsonList['rooms']) != 0) {
				
				$additionalFee = 0;
				$adult = 0;
				$children = 0;
				$rooms = array();
				foreach ((array) $jsonList['rooms'] as $roomKey => $room) {
					
					$table_name = $wpdb->prefix."booking_package_guests";
					$guestsList = $room['guests'];
					$personAmount += intval($room['personAmount']);
					foreach ((array) $guestsList as $key => $value) {
						
						$guestSql = $wpdb->prepare(
							"SELECT * FROM `".$table_name."` WHERE `key` = %d AND `accountKey` = %d;", 
							array(intval($key), intval($originCalendarKey))
						);
						$guests_row = $wpdb->get_row($guestSql, ARRAY_A);
						$guests = array();
						$selected = false;
						$guestsArray = json_decode($guests_row['json'], true);
						$guestsArray = $this->updatePricesForGuest($guestsArray, $numberKeys);
						for ($i = 0; $i < count($guestsArray); $i++) {
							
							if (intval($value['number']) == intval($guestsArray[$i]['number']) && $value['name'] == $guestsArray[$i]['name']) {
								
								$additionalFee += intval($guestsArray[$i]['price']) * $nights;
								$selected = true;
								$guestsArray[$i]['selected'] = 1;
								$person += intval($guestsArray[$i]['number']);
								if ($guests_row['target'] == 'adult') {
									
									$adult += intval($guestsArray[$i]['number']);
									
								} else {
									
									$children += intval($guestsArray[$i]['number']);
									
								}
								
							} else {
								
								$guestsArray[$i]['selected'] = 0;
								
							}
							
						}
						
						if ($selected === false) {
							
							array_unshift($guestsArray, array("number" => 0, "price" => 0, "name" => "SELECT", "selected" => 1));
							
						} else {
							
							array_unshift($guestsArray, array("number" => 0, "price" => 0, "name" => "SELECT", "selected" => 0));
							
						}
						
						$guestsArray = $this->updatePricesForGuest($guestsArray, $numberKeys);
						$guests_row['json'] = $guestsArray;
						$room['guestsList'][$key] = $guests_row;
						
					}
					
					array_push($rooms, $room);
					
				}
				
				$accommodationDetails['rooms'] = $rooms;
				$accommodationDetails['additionalFee'] = $additionalFee;
				$accommodationDetails['adult'] = intval($adult);
				$accommodationDetails['children'] = intval($children);
				
			} else {
				
				$accommodationDetails['additionalFee'] = 0;
				
			}
			
			if (is_null($jsonList['guestsList'])) {
				
				$jsonList['guestsList'] = array();
				
			}
			
			if (count($jsonList['rooms']) == 0 && count($jsonList['guestsList']) != 0) {
    			
            	$additionalFee = 0;
            	$table_name = $wpdb->prefix."booking_package_guests";
            	$guestsList = $jsonList['guestsList'];
            	foreach ((array) $guestsList as $key => $value) {
            		
            		$guestSql = $wpdb->prepare(
            			"SELECT * FROM `".$table_name."` WHERE `key` = %d AND `accountKey` = %d;", 
            			array(intval($key), intval($originCalendarKey))
            		);
            		$guests_row = $wpdb->get_row($guestSql, ARRAY_A);
            		$guests = array();
            		$guestsArray = json_decode($guests_row['json'], true);
            		for ($i = 0; $i < count($guestsArray); $i++) {
            			
            			if (intval($value['number']) == intval($guestsArray[$i]['number']) && $value['name'] == $guestsArray[$i]['name']) {
            				
            				$additionalFee += intval($guestsArray[$i]['price']) * $nights;
            				$guestsArray[$i]['selected'] = 1;
            				
            			} else {
            				
            				$guestsArray[$i]['selected'] = 0;
            				
            			}
            			
            		}
            		
            		array_unshift($guestsArray, array("number" => 0, "price" => 0, "name" => "SELECT", "selected" => 0));
            		$guests_row['json'] = $guestsArray;
            		$accommodationDetails['guestsList'][$key] = $guests_row;
            		
            	}
            	
    		} else {
    			
    			//$accommodationDetails['additionalFee'] = 0;
    			
    		}
    		
    		if (count($jsonList['taxes']) != 0) {
    			
    			#$totalTax = 0;
    			$taxList = array();
    			$table_name = $wpdb->prefix."booking_package_taxes";
	            $sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `active` = 'true' ORDER BY ranking ASC;", array(intval($originCalendarKey)));
	            $rows = $wpdb->get_results($sql, ARRAY_A);
	            foreach ((array) $rows as $key => $tax) {
	            	
	            	$applicantCountForTax = $applicantCount;
	            	$nightsForTax = $nights;
	            	$taxValue = 0;
		            $value = intval($tax['value']);
		            if ($tax['method'] == 'multiplication') {
		                
		                $value = floatval($tax['value']);
		                
		            }
					
					if (intval($tax['expirationDateStatus']) == 1) {
						
						if ($tax['expirationDateTrigger'] != 'dateBooked') {
							
							
							
						} else {
							
							$count = 0;
							foreach ($accommodationDetails['scheduleDetails'] as $scheduleKey => $schedule) {
								
								$expirationDate = $schedule['year'] . sprintf('%02d%02d', $schedule['month'], $schedule['day']);
								$isTax = $this->validExpirationDate(intval($expirationDate), intval($tax['expirationDateStatus']), intval($tax['expirationDateFrom']), intval($tax['expirationDateTo']));
								if ($isTax === false) {
									
									$count++;
									
								}
								
							}
							
							if ($nightsForTax == $count) {
								
								$applicantCountForTax = 0;
								
							}
							
							$nightsForTax -= $count;
							
						}
						
					}
		            
		            if ($tax['target'] == 'room') {
		                
		                if ($tax['scope'] == 'day') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = ($nightsForTax * $applicantCountForTax) * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * (($accommodationDetails['accommodationFee']) + $accommodationDetails['additionalFee']);
		                        if ($personAmount > 0) {
		                        	
		                        	$taxValue =  ($value / 100) * (($accommodationDetails['accommodationFee']) + $personAmount);
		                        	
		                        }
		                        if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_inclusive') {
		                            
		                            $taxValue = (($accommodationDetails['accommodationFee']) + $accommodationDetails['additionalFee']) * ($value / (100 + $value));
		                            if ($personAmount > 0) {
		                            	
		                            	$taxValue = ($accommodationDetails['accommodationFee'] + $personAmount) * ($value / (100 + $value));
		                            	
		                            }
		                            $taxValue = floor($taxValue);
		                            
		                        }
		                        
		                    }
		                    
		                } else if ($tax['scope'] == 'booking') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = $applicantCountForTax * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * $applicantCountForTax;
		                        
		                    }
		                    
		                } else if ($tax['scope'] == 'bookingEachGuests') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = ($person * $nightsForTax) * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * ($person * $nightsForTax);
		                        
		                    }
		                    
		                }
		                
		            } else if ($tax['target'] == 'guest') {
		                
		                if ($tax['scope'] == 'day') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = ($nightsForTax * $person) * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * ($accommodationDetails['additionalFee'] / $nightsForTax);
		                        if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_inclusive') {
		                            
		                            $taxValue = $accommodationDetails['additionalFee'] * ($value / (100 + $value));
		                            $taxValue = floor($taxValue);
		                            
		                        }
		                        
		                    }
		                    
		                } else if ($tax['scope'] == 'booking') {
		                    
		                    if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = 1 * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * 1;
		                        
		                    }
		                    
		                } else if ($tax['scope'] == 'bookingEachGuests') {
		                	
		                	if ($tax['method'] == 'addition') {
		                        
		                        $taxValue = ($person * $nightsForTax) * $value;
		                        
		                    } else if ($tax['method'] == 'multiplication') {
		                        
		                        $taxValue =  ($value / 100) * ($person * $nightsForTax);
		                        
		                    }
		                	
		                }
		                
		            }
		            
		            $taxValue = intval($taxValue);
		            if ($tax['tax'] == 'tax_exclusive' || ($tax['method'] == "addition" && $tax['type'] == "surcharge")) {
		            	
		            	$totalTax += $taxValue;
		            	
		            }
		            
		            #$taxValue = intval($taxValue);
		            #$totalTax += $taxValue;
		            
		            $tax['taxValue'] = $taxValue;
		            array_push($taxList, $tax);
	            	
	            }
	            
	            $accommodationDetails['taxes'] = $taxList;
	            $accommodationDetails['taxesFee'] = $totalTax;
    			
			} else {
				
				$accommodationDetails['taxes'] = array();
				$accommodationDetails['taxesFee'] = 0;
				
			}
				
            $accommodationDetails['personAmount'] = $personAmount;
            $accommodationDetails['totalCost'] = $totalCost + $additionalFee + $totalTax;
            if ($personAmount > 0) {
            	
            	$accommodationDetails['totalCost'] = $totalCost + $personAmount + $totalTax;
            	
            }
            
			return $accommodationDetails;
			
    	}
    	
    	public function createTaxesDetails($accountKey, $totalCost, $bookingYMD = 0, $applicantCount = null) {
    		
    		global $wpdb;
    		$taxes = array();
    		$isExtensionsValid = $this->getExtensionsValid(false);
    		$table_name = $wpdb->prefix."booking_package_taxes";
			$sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `active` = %s ORDER BY ranking ASC;", array(intval($accountKey), 'true'));
			#var_dump($sql);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			foreach ((array) $rows as $key => $tax) {
				
				if ($isExtensionsValid !== true) {
					
					continue;
					
				}
				
				if ($bookingYMD != 0 && intval($tax['expirationDateStatus']) == 1) {
					
					$isTax = $this->validExpirationDate($bookingYMD, intval($tax['expirationDateStatus']), intval($tax['expirationDateFrom']), intval($tax['expirationDateTo']));
					if ($isTax === false) {
						
						unset($rows[$key]);
						continue;
						
					}
					
				}
				
				
				if ($tax['method'] == 'multiplication') {
					
					$taxValue =  ($tax['value'] / 100) * $totalCost;
					if ($tax['tax'] == 'tax_inclusive') {
						
						$taxValue = $totalCost * (intval($tax['value']) / (100 + intval($tax['value'])));
						$taxValue = floor($taxValue);
						
					}
					$tax['taxValue'] = $taxValue;
					
				} else {
					
					$tax['taxValue'] = intval($tax['value']);
					
				}
				
				array_push($taxes, $tax);
				
			}
			
			return $taxes;
    		
    	}
    	
    	public function getTaxesDetailsForVisitor($bookingID, $totalCost) {
    		
    		global $wpdb;
    		$taxes = array();
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare("SELECT `taxes` FROM ".$table_name." WHERE `key` = %d;", array(intval($bookingID)));
			$row = $wpdb->get_row($sql, ARRAY_A);
			$taxes = json_decode($row['taxes'], true);
			foreach ((array) $taxes as $key => $tax) {
				
				if ($tax['method'] == 'multiplication') {
					
					$taxValue =  ($tax['value'] / 100) * $totalCost;
					if ($tax['tax'] == 'tax_inclusive') {
						
						$taxValue = $totalCost * (intval($tax['value']) / (100 + intval($tax['value'])));
						$taxValue = floor($taxValue);
						
					}
					$taxes[$key]['taxValue'] = $taxValue;
					
				} else {
					
					$taxes[$key]['taxValue'] = intval($tax['value']);
					
				}
				
			}
			
			return $taxes;
    		
    	}
		
		public function intentForStripe() {
			
			global $wpdb;
			$currency = get_option($this->prefix . "currency", 'usd');
			$secret_key = get_option($this->prefix . "stripe_secret_key", null);
			$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
			$response = $creditCard->intentForStripe($secret_key, $_POST['amount'], $currency);
			return $response;
			
		}
		
		public function intentForStripeKonbini() {
			
			global $wpdb;
			$currency = get_option($this->prefix . "currency", 'jpy');
			$secret_key = get_option($this->prefix . "stripe_secret_key", null);
			$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
			$response = $creditCard->intentForStripeKonbini($secret_key, $_POST['amount'], $currency);
			return $response;
			
		}
		
		public function updateIntentForStripe() {
			
			global $wpdb;
			$secret_key = get_option($this->prefix . "stripe_secret_key", null);
			$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
			$response = $creditCard->updateIntentForStripe($secret_key, $_POST['amount'], $_POST['id']);
			return $response;
			
		}
		
		public function blocksEmail($user_id, $emails) {
			
			global $wpdb;
			$response = array('status' => 'success', 'message' => null);
			$table_name = $wpdb->prefix . "booking_package_blockList";
			$isExtensionsValid = $this->getExtensionsValid(false);
			if (intval(get_option($this->prefix . 'blocksEmail', 0)) == 0) {
				
				return $response;
				
			}
			
			if (!is_null($user_id)) {
				
				
				
			}

    		if (is_array($emails)) {
				
				for ($i = 0; $i < count($emails); $i++) {
					
					$email = $emails[$i];
					$sql = $wpdb->prepare(
						"SELECT `key` FROM `" . $table_name . "` WHERE `value` = %s;", 
						array(sanitize_email($email))
					);
					$row = $wpdb->get_row($sql, ARRAY_A);
					if (!is_null($row)) {
						
						$response['status'] = 'error';
						$response['message'] = __('Sorry, we have blocked your booking.', $this->pluginName);
						break;
						
					}
					
				}
				
			}
			
			return $response;
			
		}
		
		public function blockSameTimeBookingByUser($user_id, $calendarAccount, $startUnix, $endUnix, $emails) {
			
			global $wpdb;
			$accountKey = $calendarAccount['key'];
			$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
    		$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
			$response = array('status' => 'success', 'message' => null);
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			
			if (!is_null($user_id)) {
				
				if (!is_null($endUnix)) {
					
					$sql = $wpdb->prepare(
						"SELECT * FROM `".$table_name."` WHERE (`status` = 'pending' OR `status` = 'approved') AND  `user_id` = %d AND `accountKey` = %d AND `scheduleUnixTime` < %d ORDER BY `scheduleUnixTime` DESC;", 
						array(
							intval($user_id),
							intval($accountKey),
							intval($startUnix),
						)
					);
					$row = $wpdb->get_row($sql, ARRAY_A);
					if (!is_null($row)) {
						
						$coupon = null;
						if (isset($row['coupon']) && !empty($row['coupon'])) {
							
							$coupon = json_decode($row['coupon'], true);
							
						}
						#$responseGuests = json_decode($row['guests'], true);
						$responseGuests = $this->jsonDecodeForGuests($row['guests']);
						$servicesDetails = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $row['applicantCount']);
						$bookedUnixTime = $row['scheduleUnixTime'] + ($servicesDetails['time'] * 60);
						if ($startUnix < $bookedUnixTime) {
							
							$startUnix = $row['scheduleUnixTime'];
							
						}
						
					}
					
					$sql = $wpdb->prepare(
						"SELECT * FROM `".$table_name."` WHERE (`status` = 'pending' OR `status` = 'approved') AND  `user_id` = %d AND `accountKey` = %d AND `scheduleUnixTime` >= %d AND `scheduleUnixTime` < %d;", 
						array(
							intval($user_id),
							intval($accountKey),
							intval($startUnix),
							intval($endUnix),
						)
					);
					$response['message'] = sprintf(__('You have already booked between %s and %s.', $this->pluginName), $this->dateFormat($dateFormat, $positionOfWeek, $startUnix, '', true, true, 'text'), $this->dateFormat($dateFormat, $positionOfWeek, $endUnix, '', true, true, 'text'));
					
				} else {
					
					$sql = $wpdb->prepare(
						"SELECT * FROM `".$table_name."` WHERE `user_id` = %d AND `accountKey` = %d AND `scheduleUnixTime` = %d;", 
						array(
							intval($user_id),
							intval($accountKey),
							intval($startUnix),
						)
					);
					$response['message'] = sprintf(__('You have already booked at %s.', $this->pluginName), $this->dateFormat($dateFormat, $positionOfWeek, $startUnix, '', true, true, 'text'));
					
				}
				
				$row = $wpdb->get_row($sql, ARRAY_A);
				if (!is_null($row)) {
					
					$response['status'] = 'error';
					return $response;
					
				}
				
			}
			
			if (is_array($emails)) {
				
				for ($i = 0; $i < count($emails); $i++) {
					
					$email = $emails[$i];
					if (!is_null($endUnix)) {
						
						$sql = $wpdb->prepare(
							"SELECT * FROM `".$table_name."` WHERE (`status` = 'pending' OR `status` = 'approved') AND `emails` LIKE '%\"" . $email . "\"%' AND `accountKey` = %d AND `scheduleUnixTime` < %d ORDER BY `scheduleUnixTime` DESC;", 
							array(
								intval($accountKey),
								intval($startUnix),
							)
						);
						
						$row = $wpdb->get_row($sql, ARRAY_A);
						if (!is_null($row)) {
							
							$coupon = null;
							if (isset($row['coupon']) && !empty($row['coupon'])) {
								
								$coupon = json_decode($row['coupon'], true);
								
							}
							#$responseGuests = json_decode($row['guests'], true);
							$responseGuests = $this->jsonDecodeForGuests($row['guests']);
							$servicesDetails = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $row['applicantCount']);
							$bookedUnixTime = $row['scheduleUnixTime'] + ($servicesDetails['time'] * 60);
							if ($startUnix < $bookedUnixTime) {
								
								$startUnix = $row['scheduleUnixTime'];
								
							}
							
						}
						
						$sql = $wpdb->prepare(
							"SELECT * FROM `".$table_name."` WHERE (`status` = 'pending' OR `status` = 'approved') AND `emails` LIKE '%\"" . $email . "\"%' AND `accountKey` = %d AND `scheduleUnixTime` >= %d AND `scheduleUnixTime` < %d;", 
							array(
								intval($accountKey),
								intval($startUnix),
								intval($endUnix),
							)
						);
						$response['message'] = sprintf(__('You have already booked between %s and %s by %s.', $this->pluginName), $this->dateFormat($dateFormat, $positionOfWeek, $startUnix, '', true, true, 'text'), $this->dateFormat($dateFormat, $positionOfWeek, $endUnix, '', true, true, 'text'), $email);
						
					} else {
						
						$sql = $wpdb->prepare(
							"SELECT * FROM `".$table_name."` WHERE (`status` = 'pending' OR `status` = 'approved') AND `emails` LIKE %s AND `accountKey` = %d AND `scheduleUnixTime` = %d;", 
							array(
								'%"' . $email . '"%',
								intval($accountKey),
								intval($startUnix),
							)
						);
						$response['message'] = sprintf(__('You have already booked at %s by %s.', $this->pluginName), $this->dateFormat($dateFormat, $positionOfWeek, $startUnix, '', true, true, 'text'), $email);
						
					}
					
					
					$row = $wpdb->get_row($sql, ARRAY_A);
					if (!is_null($row)) {
						
						$response['status'] = 'error';
						
					}
					
				}
				
			}
			
			return $response;
			
		}
		
		public function verifyHCaptcha($token) {
			
			$response = array('status' => true, 'message' => null, 'v' => null);
			$hCaptcha_active = get_option($this->prefix . "hCaptcha_active", "0");
			if (intval($hCaptcha_active) == 0) {
				
				return $response;
				
			}
			
			if (empty($token)) {
				
				$response['status'] = false;
				$response['message'] = 'hCaptcha: ' . __('Unknown error.', $this->pluginName);
				return $response;
				
			}
			
			$secretKey = get_option($this->prefix . "hCaptcha_Secret_key", "0");
			$args = array(
                'method' => 'POST',
                'body' => array(
                	'secret' => $secretKey,
                	'response' => $token
                )
            );
            $json = wp_remote_request("https://hcaptcha.com/siteverify", $args);
            $statusCode = wp_remote_retrieve_response_code($json);
            $result = json_decode(wp_remote_retrieve_body($json), true);
			$response['status'] = $result['success'];
			
			/**
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://hcaptcha.com/siteverify");
			curl_setopt($ch, CURLOPT_POST, true );
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
				array(
					'secret' => $secretKey, 
					'response' => $token,
				)
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$json = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($json, true);
			$response['status'] = $result['success'];
			**/
			
			if (isset($result['error-codes'])) {
				
				$response['message'] = $result['error-codes'];
				
			}
			
			return $response;
			
		}
		
		public function verifyGoogleReCaptchaToken($googleReCaptchaToken) {
			
			$response = array('status' => true, 'message' => null, 'v' => null);
			$googleReCAPTCHA_active = get_option($this->prefix . "googleReCAPTCHA_active", "0");
			if (intval($googleReCAPTCHA_active) == 0) {
				
				return $response;
				
			}
			
			if (empty($googleReCaptchaToken)) {
				
				$response['status'] = false;
				$response['message'] = 'reCaptcha: ' . __('Unknown error.', $this->pluginName);
				return $response;
				
			}
			
			$secretKey = get_option($this->prefix . "googleReCAPTCHA_Secret_key", "0");
			$googleReCAPTCHA_v = get_option($this->prefix . "googleReCAPTCHA_version", "v2");
			$response['v'] = 'v3';
			if ($googleReCAPTCHA_v == 'v2') {
				
				$response['v'] = 'v2';
				
			}
			
			$args = array(
                'method' => 'POST',
                'body' => array(
                	'secret' => $secretKey,
                	'response' => $googleReCaptchaToken
                )
            );
            $json = wp_remote_request("https://www.google.com/recaptcha/api/siteverify", $args);
            $statusCode = wp_remote_retrieve_response_code($json);
            $result = json_decode(wp_remote_retrieve_body($json), true);
			$response['reCaptcha'] = $result;
			
			/**
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, true );
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(
				array(
					'secret' => $secretKey, 
					'response' => $googleReCaptchaToken,
				)
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$json = curl_exec($ch);
			curl_close($ch);
			$result = json_decode($json, true);
			$response['reCaptcha'] = $result;
			**/
			
			if ($result['success']) {
				
				$response['status'] = true;
				if ($googleReCAPTCHA_v == 'v3') {
					
					if (floatval($result['score']) < 0.5) {
						
						$response['status'] = false;
						$response['message'] = 'reCaptcha: Your score (' . $result['score'] . ') is too low..';
						
					}
					
				}
				
			} else {
				
				$response['status'] = false;
				$response['message'] = 'reCaptcha: ' . $result['error-codes'][0];
				
			}
			
			return $response;
			
		}
		
		public function sendVerificationCode($administrator = false) {
			
			$bookingVerificationCode = 'false';
			$from = null;
			$user = null;
			$twilio = null;
			$userValues = array();
			$accountKey = 1;
			if (isset($_POST['accountKey'])) {
				
				$accountKey = $_POST['accountKey'];
				
			}
			$calendarAccount = $this->getCalendarAccount($accountKey);
			#$from = $calendarAccount['email_from'];
			if (isset($_POST['user_email']) === false) {
				
				$bookingVerificationCode = $calendarAccount['bookingVerificationCode'];
				$user = $this->get_user();
				if (intval($user['status']) == 1) {
					
					$bookingVerificationCode = $calendarAccount['bookingVerificationCodeToUser'];
					
				}
				
				if (isset($_POST['userId']) === false) {
					
					$_POST['userId'] = null;
					
				}
				
				$response_user = $this->get_user_id($administrator, $_POST['userId']);
				$userValues = $this->getUserValues($accountKey, 'add', $administrator, null, $response_user['user_id']);
				
			} else {
				
				$bookingVerificationCode = 'email';
				$userValues = array(
					'emails' => array($_POST['user_email']),
					'sms' => array(),
				);
				
			}
			
			
			
			$notifications = array();
			$response = array('status' => false, 'message' => null, 'user' => $user, 'userValues' => $userValues, 'bookingVerificationCode' => $bookingVerificationCode);
			
			if ($bookingVerificationCode != 'false') {
				
				$verificationCode = $_SESSION['verificationCode'];
				#setcookie($this->prefix . 'verificationCode', wp_hash($verificationCode));
				$from = $calendarAccount['email_from'];
				if (empty($from)) {
					
					$from = get_option($this->prefix . 'email_from', null);
					
				}
				
				$subject = __('Verification code', $this->pluginName) . ' [' . get_option($this->prefix . 'site_name', 'Booking Package') . ']';
				$body = sprintf(__('Your verification code is: %s', $this->pluginName), $verificationCode) . "\n\n" . get_option($this->prefix . 'site_name', 'Booking Package') . "\n" . $from;
				$email = $userValues['emails'];
				$sms = $userValues['sms'];
				if ($bookingVerificationCode == 'emailAndSms' || $bookingVerificationCode == 'email') {
					
					for ($i = 0; $i < count($email); $i++) {
						
						$this->sendMail($email[$i], $subject, $body, 'text');
						array_push($notifications, $email[$i]);
						
					}
					
				}
				
				if ($bookingVerificationCode == 'emailAndSms' || $bookingVerificationCode == 'sms') {
					
					$twilio = $this->twilioSMS($sms, $body);
					for ($i = 0; $i < count($sms); $i++) {
						
						array_push($notifications, $sms[$i]);
						
					}
					
				}
				
				if (count($notifications) == 0) {
					
					$response['message'] = __("We couldn't send you a verification code.", $this->pluginName);
					
				} else {
					
					$response['status'] = true;
					$response['twilio'] = $twilio;
					$response['notifications'] = implode(', ', $notifications);
					
				}
				
			} else {
				
				$response['message'] = __("We couldn't send you a verification code.", $this->pluginName);
				
			}
			
			return $response;
			
		}
		
		public function checkVerificationCode($administrator = false) {
			
			$response = array('status' => false, 'verificationCode' => $_POST['verificationCode'], 'message' => null);
			if ($_POST['verificationCode'] == $_SESSION['verificationCode']) {
				
				unset($_SESSION['verificationCode']);
				$response['status'] = true;
				
			} else {
				
				$response['message'] = __('The verification code is incorrect.', $this->pluginName);
				
			}
			
			return $response;
			
		}
		
		public function sendBooking($administrator = false) {
			
			$accountKey = 1;
			$accountCalendarKey = 1;
			if (isset($_POST['accountKey'])) {
				
				$accountKey = $_POST['accountKey'];
				$accountCalendarKey = $_POST['accountKey'];
				
			}
			
			if (isset($_POST['userId']) === false) {
				
				$_POST['userId'] = null;
				
			}
			
			$permalink = "";
			if (isset($_POST['permalink'])) {
				
				$permalink = $_POST['permalink'];
				
			}
			
			if ($administrator === false) {
				
				if (!isset($_POST['googleReCaptchaToken'])) {
					
					$_POST['googleReCaptchaToken'] = '';
					
				}
				$result = $this->verifyGoogleReCaptchaToken($_POST['googleReCaptchaToken']);
				if ($result['status'] === false) {
					
					$this->cancelPayment();
					$result['status'] = 'error';
					return $result;
					
				}
				
				if (!isset($_POST['hCaptcha'])) {
					
					$_POST['hCaptcha'] = '';
					
				}
				$result = $this->verifyHCaptcha($_POST['hCaptcha']);
				if ($result['status'] === false) {
					
					$this->cancelPayment();
					$result['status'] = 'error';
					return $result;
					
				}
				
			}
			
			$service = null;
			$coupon = null;
			$maintenanceTime = 0;
			$remainderTime = 0;
			$timestamp = intval(date('U'));
			$sendDate = date('U');
			$totalCost = 0;
			$courseKey = null;
			$jsonList = null;
			$ressponse = array();
			$selectedOptions = array();
			$userInformationValues = array();
			$responseGuests = array();
			$services = array();
			$guests = array();
			$taxes = array();
			$sql_start_unixTime = null;
			$sql_max_unixTime = null;
			$currency = get_option($this->prefix."currency", 'usd');
			$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
			$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
			$courseTime = 0;
			$courseCost = 0;
			$payName = null;
			$payId = null;
			$payResponse = array();
			
			global $wpdb;
			
			$calendarAccount = $this->getCalendarAccount($accountKey);
			if (intval($calendarAccount['schedulesSharing']) == 1) {
				
				$accountCalendarKey = intval($calendarAccount['targetSchedules']);
				
			}
			$paymentMethod = explode(",", $calendarAccount['paymentMethod']);
			$preparation = array("time" => intval($calendarAccount["preparationTime"]), "position" => $calendarAccount["positionPreparationTime"]);
			$response_user = $this->get_user_id($administrator, $_POST['userId']);
			
			if ($calendarAccount['type'] == 'hotel') {
				
				$timestamp = mktime(0, 0, 0, date('m', $timestamp), date('d', $timestamp), date('Y', $timestamp));
				
			}
			
			$userValues = $this->getUserValues($accountKey, 'add', $administrator, null, $response_user['user_id']);
			if (isset($userValues['status']) && $userValues['status'] == 'error') {
				
				$this->cancelPayment();
				#$wpdb->query('ROLLBACK');
				return $userValues;
				
			}
			$form = $userValues['form'];
			$emails = $userValues['emails'];
			
			
			$blocksEmailEesult = $this->blocksEmail($response_user['user_id'], $emails);
			if ($blocksEmailEesult['status'] == 'error') {
				
				$this->cancelPayment();
				return $blocksEmailEesult;
				
			}
			
			
			$visitorBookingDate = 'null';
			$visitorEmail = array();
			$visitorName = array();
			foreach ((array) $form as $key => $value) {
				
				if ($value['isName'] == 'true') {
					
					array_push($visitorName, $value['value']);
					
				}
				
				if ($value['isEmail'] == 'true') {
					
					array_push($visitorEmail, $value['value']);
					
				}
				
			}
    		$visitorEmail = implode(" ", $visitorEmail);
    		$visitorName = implode(" ", $visitorName);
    		
    		$table_name = $wpdb->prefix."booking_package_schedule";
    		$sql = $wpdb->prepare(
    			"SELECT *, `unixTime` - (`deadlineTime` * 60) as `unixTimeDeadline` FROM `".$table_name."` WHERE `key` = %d AND `status` = 'open';", 
    			array(intval($_POST['timeKey']))
    		);
    		$row = $wpdb->get_row($sql, ARRAY_A);
			if (is_null($row)) {
				
				#$wpdb->query('ROLLBACK');
				$public = false;
				if(intval($_POST['public']) == 1){
					
					$public = true;
					
				}
				
				$this->cancelPayment();
				$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
				$response['status'] = 'error';
				$response['message'] = __("Schedule was not found", $this->pluginName);
				return $response;
				
			} else {
				
				if (isset($_POST['couponID'])) {
					
					$couponResponse = $this->serachCoupons($row['unixTime'], $_POST['couponID'], $accountKey);
					if (intval($couponResponse['status']) == 1) {
						
						$coupon = $couponResponse['coupon'];
						
					} else {
						
						$this->cancelPayment();
						return $couponResponse;
						
					}
					
				}
				$row = $this->fixUnixTimeShift($row, $calendarAccount['timezone']);
				$visitorBookingDate = date('r', $row['unixTime']);
				if (isset($row['fixedUnixTime']) && $row['fixedUnixTime'] === true) {
					
					$table_name = $wpdb->prefix."booking_package_schedule";
					$sql = $wpdb->prepare(
						"SELECT `key`, `unixTime`, `hour`, `min`, `month`, `day`, `year` FROM `".$table_name."` WHERE `accountKey` = %d AND `year` = %d AND `month` = %d AND `status` = 'open' ORDER BY `unixTime` ASC;", 
						array(intval($calendarAccount['key']), intval($row['year']), intval($row['month']))
					);
					$schedules = $wpdb->get_results($sql, ARRAY_A);
					foreach ((array) $schedules as $key => $value) {
						
						$value = $this->fixUnixTimeShift($value, $calendarAccount['timezone']);
						
					}
					
				}
				
				if ($this->confirmRegularHolidays($accountKey, $row['month'], $row['day'], $row['year']) === true) {
					
					$this->cancelPayment();
					#$wpdb->query('ROLLBACK');
					$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
					$response['status'] = 'error';
					$response['reload'] = 0;
					$response['message'] = __("The schedule you requested has been closed.", $this->pluginName);
					return $response;
					
				}
				
				/**
				$table_name = $wpdb->prefix . "booking_package_regular_holidays";
				$sql = $wpdb->prepare(
					"SELECT `status` FROM `" . $table_name . "` WHERE `month` = %d AND `day` = %d AND `year` = %d AND (`accountKey` = 'share' || `accountKey` = %s);", 
					array(
						intval($row['month']), 
						intval($row['day']), 
						intval($row['year']), 
						sanitize_text_field($accountKey)
					)
				);
				
				$holiday = $wpdb->get_row($sql, ARRAY_A);
				if (!is_null($holiday) && intval($holiday['status']) == 1) {
					
					$this->cancelPayment();
					#$wpdb->query('ROLLBACK');
					$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
					$response['status'] = 'error';
					$response['reload'] = 0;
					$response['message'] = __("The schedule you requested has been closed.", $this->pluginName);
					return $response;
					
				}
				**/
				if (intval($row['unixTimeDeadline']) < $timestamp && $administrator === false) {
					
					#$wpdb->query('ROLLBACK');
					$public = false;
					if(intval($_POST['public']) == 1){
						
						$public = true;
						
					}
					
					$this->cancelPayment();
					$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
					$response['status'] = 'error';
					$response['reload'] = 0;
					$response['timestamp'] = $timestamp;
					$response['unixTimeDeadline'] = $row['unixTimeDeadline'];
					$response['message'] = __("The schedule you requested has been closed.", $this->pluginName);
					return $response;
					
				}
				
				
				
				$applicantCount = intval($_POST['applicantCount']);
				$startTime = $row['unixTime'];
				$sql_start_unixTime = $row['unixTime'];
				$schedule = $row;
				$scheduleUnixTime = intval($row['unixTime']);
				$scheduleTitle = $row['title'];
				$scheduleCost = intval($row['cost']);
				$totalCost += intval($row['cost']) * $applicantCount;
				$bookingYMD = intval($row['year'] . sprintf('%02d%02d', $row['month'], $row['day']));
				if ($row['unixTime'] == $scheduleUnixTime) {
					
					if ($calendarAccount['type'] == "hotel" && isset($_POST['json'])) {
						
						$accommodationDetails = $this->createAccommodationDetails($accountKey, $accountCalendarKey, $_POST['json'], $sql_start_unixTime, $applicantCount, 'book', null);
						$applicantCount = $accommodationDetails['applicantCount'];
						$taxes = $accommodationDetails['taxes'];
						$totalCost = $accommodationDetails['totalCost'];
						$taxes = $this->createTaxesDetails($accountKey, $totalCost);
						$taxes = $accommodationDetails['taxes'];
						if (isset($accommodationDetails['status']) && $accommodationDetails['status'] == "error") {
							
							$this->cancelPayment();
							#$wpdb->query('ROLLBACK');
							return $accommodationDetails;
							
						} else {
							
							$account_sql = $accommodationDetails['sql'];
							$valueArray = $accommodationDetails['valueArray'];
							$sql_max_unixTime = $accommodationDetails['sql_max_unixTime'];
							unset($accommodationDetails['sql']);
							unset($accommodationDetails['valueArray']);
							unset($accommodationDetails['sql_max_unixTime']);
							$this->setAccommodationDetails($accommodationDetails);
							
						}
						
    				} else {
						
						if (isset($_POST['guests']) && intval($calendarAccount['guestsBool']) == 1) {
							
							$responseGuests = $this->getSelectedGuests($calendarAccount, $_POST['guests'], 'add');
							if ($responseGuests['isGuests'] === true) {
								
								$guests = $responseGuests['guests'];
								$applicantCount = $responseGuests['applicantCount'];
								if ($applicantCount == 0) {
									
									$applicantCount = 1;
									
								}
								
							} else {
								
								$this->cancelPayment();
								$responseGuests['status'] = 'error';
								return $responseGuests;
								
							}
							
						}
						
						if (isset($_POST['courseKey']) || isset($_POST['selectedCourseList'])) {
							
							$servicesDetails = $this->getSelectedServices($calendarAccount, $_POST['selectedCourseList'], $guests, "selectedOptionsList", $coupon, $applicantCount);
							$services = $servicesDetails['object'];
							foreach ((array) $services as $key => $service) {
								
								$row = $this->serachCourse($accountKey, $_POST['timeKey'], $service['key'], $bookingYMD);
								if (isset($row['status']) && $row['status'] == 'error') {
									
									$this->cancelPayment();
									$row['message'] = sprintf($row['message'], $service['name']);
									#$wpdb->query('ROLLBACK');
									return $row;
								
								}
								
								
							}
							
							$courseTime += intval($servicesDetails['time']);
							$courseCost += intval($servicesDetails['cost']);
							#$totalCost += intval($servicesDetails['cost']) * $applicantCount;
							$totalCost += intval($servicesDetails['cost']);
							$sql_max_unixTime = $sql_start_unixTime + ($courseTime * 60) + ($maintenanceTime * 60);
							
							if (intval($calendarAccount['blockSameTimeBookingByUser']) == 1) {
								
								$blockSameTimeBookingByUser = $this->blockSameTimeBookingByUser($response_user['user_id'], $calendarAccount, $sql_start_unixTime, $sql_max_unixTime, $emails);
								if ($blockSameTimeBookingByUser['status'] == 'error') {
									
									$this->cancelPayment();
									return $blockSameTimeBookingByUser;
									
								}
								
							}
							
							$table_name = $wpdb->prefix."booking_package_schedule";
							$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
								
								$sql_start_unixTime -= $preparation['time'] * 60;
								
							}
								
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
								
								$sql_max_unixTime += $preparation['time'] * 60;
								
							}
								
							$valueArray = array(intval($accountCalendarKey), intval($sql_start_unixTime), intval($sql_max_unixTime));
							
						} else {
							
							$sql_max_unixTime = $sql_start_unixTime;
							if (intval($calendarAccount['blockSameTimeBookingByUser']) == 1) {
								
								$blockSameTimeBookingByUser = $this->blockSameTimeBookingByUser($response_user['user_id'], $calendarAccount, $sql_start_unixTime, null, $emails);
								if ($blockSameTimeBookingByUser['status'] == 'error') {
									
									$this->cancelPayment();
									return $blockSameTimeBookingByUser;
									
								}
								
							}
							
							$table_name = $wpdb->prefix."booking_package_schedule";
							$account_sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
								
								$sql_start_unixTime = $startTime - $preparation['time'] * 60;
								
							}
							
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
								
								$sql_max_unixTime = $startTime + $preparation['time'] * 60;
								
							}
							
							$valueArray = array(intval($accountCalendarKey), intval($sql_start_unixTime), intval($sql_max_unixTime));
							
						}
						
						$taxes = $this->createTaxesDetails($accountKey, $totalCost, $bookingYMD);
						$accommodationDetails['taxes'] = $taxes;
						for ($i = 0; $i < count($taxes); $i++) {
							
							$tax = $taxes[$i];
							if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_exclusive') {
								
								$totalCost += $tax['taxValue'];
								
							} else if ($tax['type'] == 'surcharge') {
								
								$totalCost += $tax['taxValue'] * $applicantCount;
								
							}
							
						}
						
					}
					
					$response = apply_filters('booking_package_send_booking', $response_user, $schedule);
					if (empty($response) === false && isset($response['status']) && $response['status'] == 'error') {
						
						$this->cancelPayment();
						return array('status' => $response['status'], 'message' => $response['message']);
						
					}
					
					$souce = array(
            			array("mode" => "increase", "sql" => $account_sql, "values" => $valueArray), 
            		);
            		$increaseSouce = $souce;
					$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
					if (isset($updateSchedule['status']) && $updateSchedule['status'] == 'error') {
						
						$public = false;
						if (intval($_POST['public']) == 1) {
							
							$public = true;
							
						}
						
						$this->cancelPayment();
						$response = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), false, $public);
						$response['status'] = 'error';
						$response['reload'] = 0;
						$response['message'] = $updateSchedule['message'];
						return $response;
						
					}
					$status = $this->getStatus();
					$privateResponse = $this->insertPrivateData($sendDate, $_POST['permission'], $status, $_POST['timeKey'], $scheduleUnixTime, $scheduleTitle, $scheduleCost, $services, $form, $emails, $currency, null, null, $accountKey, $permalink, $preparation, $taxes, $responseGuests, $coupon, $administrator, $applicantCount);
					
					#$privateResponse = $this->insertPrivateData($sendDate, $_POST['permission'], $status, $_POST['timeKey'], $scheduleUnixTime, $scheduleTitle, $scheduleCost, $courseKey, $courseName, $courseTime, $courseCost, $selectedOptions, $form, $currency, $_POST['payType'], $cardToken, $accountKey, $permalink, $preparation, $taxes, $applicantCount);
					$lastID = $privateResponse['lastID'];
					
					/** Stripe and PayPal **/
					$payment_active = 0;
					$payment_mode = 0;
					$payment_live = 0;
					$public_key = null;
					$secret_key = null;
					$cardToken = null;
					if (isset($_POST['payToken'])) {
						
						if ($_POST['payType'] == 'stripe') {
							
							$payment_active = 0;
							if (!is_bool(array_search(strtolower($_POST['payType']), $paymentMethod))) {
								
								$payment_active = 1;
								
							}
							$secret_key = get_option($this->prefix."stripe_secret_key", null);
							
						} else if ($_POST['payType'] == 'paypal') {
							
							$payment_active = 0;
							if (!is_bool(array_search(strtolower($_POST['payType']), $paymentMethod))) {
								
								$payment_active = 1;
								
							}
							$payment_live = get_option($this->prefix."paypal_live", "0");
							$public_key = get_option($this->prefix."paypal_client_id", null);
							$secret_key = get_option($this->prefix."paypal_secret_key", null);
							
						}
						
						$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
						$currency = get_option($this->prefix."currency", "usd");
						$amount = $this->getAmount($lastID, $calendarAccount, $accommodationDetails, $services, $responseGuests, $coupon);
						if (intval($payment_active) == 1 && !empty($secret_key)) {
							
							$payResponse = $creditCard->pay($_POST['payType'], $public_key, $secret_key, $_POST['payToken'], $payment_live, $amount, $currency, $lastID, $visitorName, $visitorEmail, $visitorBookingDate);
							if (isset($payResponse['error'])) {
								
								$wpdb->delete(
									$wpdb->prefix."booking_package_userPraivateData", 
									array(
										'key' => intval($lastID)
									), 
									array('%d')
								);
								
								$souce = array(
									array("mode" => "reduce", "sql" => $account_sql, "values" => $valueArray), 
								);
								
								$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
								$this->cancelPayment();
								if (isset($updateSchedule['status']) && $updateSchedule['status'] == 'error') {
									
									return $updateSchedule;
									
								}
								return array('status' => 'error', 'message' => $payResponse['error'], "totalCost" => $totalCost, "currency" => $currency, "totalCost" => $totalCost);
								
							} else {
								
								$cardToken = $payResponse['cardToken'];
								if ($_POST['payType'] == 'stripe') {
									
									$payId = "stripe";
									$payName = "Stripe";
									
								} else if ($_POST['payType'] == 'paypal') {
									
									$payId = "paypal";
									$payName = "PayPal";
									
								}
								
								$wpdb->update(
									$wpdb->prefix."booking_package_userPraivateData", 
									array(
										'payMode' => 'CreditCard',
										'payId' => $payId,
										'payName' => $payName,
										'payToken' => sanitize_text_field($cardToken),
									),
									array('key' => intval($lastID)),
									array('%s', '%s', '%s', '%s'),
									array('%d')
								);
								
							}
							
						}
						
					}
					/** Stripe and PayPal **/
					
					
					/**
					#$status = "pending";
					if($this->automaticApprove === true){
						
						#$status = "approved";
						$souce = array(
	            			array("mode" => "increase", "sql" => $account_sql, "values" => $valueArray), 
	            		);
						$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
						
					}
					**/
					
					$userInformation = $this->setUserInformation($form);
					if(isset($userInformation['values'])){
						
						$userInformationValues = $userInformation['values'];
						
					}
					
					$cancellationToken = $privateResponse['cancellationToken'];
					$cancellationUri = null;
					if ($administrator === false) {
						
						$cancellationUri = $this->getCancellationUri($permalink, $lastID, $cancellationToken);
						
					}
					
					/**
					if(isset($cardToken) && !is_null($cardToken) && $_POST['payType'] == 'paypal'){
						
						$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
						$payResponse = $creditCard->update($_POST['payType'], $public_key, $secret_key, $_POST['payToken'], $lastID, $payment_live);
						
					}
					**/
					
				}
    			
    		}
			
			$mailBody = null;
			if (intval($_POST['sendEmail']) == 1) {
				
				$email = $this->createEmailMessage($accountKey, array('mail_new_admin'), $form, $accommodationDetails, $selectedOptions, $lastID, $scheduleUnixTime, $sendDate, $cancellationUri, $currency, $services, $payName, $payId, $scheduleTitle, $responseGuests, $coupon);
				
			}
			
			if ($calendarAccount['type'] == 'hotel') {
				
				$sql_max_unixTime += 1440 * 60;
				
			}
			
			#$setting = new booking_package_setting($this->prefix, $this->pluginName);
			#$googleCalendar = $setting->pushGC('insert', $accountKey, $calendarAccount['type'], $lastID, $calendarAccount['googleCalendarID'], $sql_start_unixTime, $sql_max_unixTime, $form);
			#$this->updateQueueForGC($lastID, $googleCalendar);
			
			$iCal = false;
			$public = false;
			if(isset($_POST['public']) && intval($_POST['public']) == 1){
				
				$public = true;
				
			}
			
			$ressponse = $this->getReservationData(intval($_POST['month']), intval($_POST['day']), intval($_POST['year']), $iCal, $public);
			#$ressponse['account'] = $this->getCalendarAccount($accountKey);
			$ressponse['automaticApprove'] = $this->automaticApprove;
			$ressponse['userInformationValues'] = $userInformationValues;
			#$ressponse['payResponse'] = $payResponse;
			#$ressponse['cancellationUri'] = $cancellationUri;
			$ressponse['applicantCount'] = $applicantCount;
			$ressponse['lastID'] = $lastID;
			if (isset($email)) {
				
				#$ressponse['sendEmails'] = $email;
				$ressponse['sendVisitor'] = $email['sendVisitor'];
				if (isset($email['sendControl'])) {
					
					$ressponse['sendControl'] = $email['sendControl'];
					
				}
				
			}
			
			$ressponse['selectedOptions'] = $selectedOptions;
			$ressponse['form'] = $form;
			$ressponse['services'] = $services;
			$ressponse['status'] = "success";
			$ressponse['increaseSouce'] = $increaseSouce;
			$ressponse['response_user'] = $response_user;
			$ressponse['responseGuests'] = $responseGuests;
			
			do_action('booking_package_booking_completed', $lastID);
			
			return $ressponse;
			
		}
		
		public function cancelPayment() {
			
			if (isset($_POST['payType']) && $_POST['payType'] == 'stripe') {
				
				$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
				$secret_key = get_option($this->prefix."stripe_secret_key", null);
				if (empty($secret_key) === false) {
					
					$creditCard->cancelStripe(0, $secret_key, $_POST['payToken']);
					
				}
				
			}
			
		}
		
		public function getCancellationUri($permalink, $id, $token) {
			
			$parse_url = parse_url($permalink);
			if (isset($parse_url['query'])) {
        		
        		$parse_url['query'] .= "&bookingID=".$id."&bookingToken=".$token;
        		
        	} else {
        		
        		$parse_url['query'] = "bookingID=".$id."&bookingToken=".$token;
        		
        	}
        	
        	$permalink = $parse_url['scheme'].'://'.$parse_url['host'];
        	if (isset($parse_url['port'])) {
        		
        		$permalink .= ':'.$parse_url['port'];
        		
        	}
        	
        	if (isset($parse_url['path'])) {
        		
        		$permalink .= $parse_url['path'];
        		
        	}
        	
        	if (isset($parse_url['query'])) {
        		
        		$permalink .= '?'.$parse_url['query'];
        		
        	}
        	
        	if (isset($parse_url['fragment'])) {
        		
        		$permalink .= '#'.$parse_url['fragment'];
        		
        	}
        	
        	return $permalink;
    		
    	}
    	
		public function getSelectedGuests($calendarAccount, $selectedGuestsString, $mode) {
			
			$limitNumberOfGuests = $calendarAccount['limitNumberOfGuests'];
			if (is_array($limitNumberOfGuests) === false) {
				
				$limitNumberOfGuests = json_decode($calendarAccount['limitNumberOfGuests'], true);
				
			}
			
			if (empty($limitNumberOfGuests)) {
				
				$limitNumberOfGuests = array(
					'minimumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
					'maximumGuests' => array('enabled' => 0, 'included' => 0, 'number' => 0),
				);
				
			}
			
			$response = array(
				'isGuests' => false, 
				'guests' => array(), 
				'applicantCount' => 0, 
				'requiredTotalNumberOfGuests' => 0, 
				'unrequiredTotalNumberOfGuests' => 0, 
				'reflectService' => 0, 
				'reflectAdditional' => 0, 
				'reflectServiceTitle' => null, 
				'reflectAdditionalTitle' => null,
				'limitNumberOfGuests' => $limitNumberOfGuests,
			);
			$selectedGuests = null;
			if (is_array($selectedGuestsString)) {
				
				$selectedGuests = $json;
				
			} else {
				
				#$selectedGuests = json_decode(str_replace("\\", "", $selectedGuestsString), true);
				$selectedGuests = json_decode(stripslashes($selectedGuestsString), true);
				
			}
			
			$isExtensionsValid = $this->getExtensionsValid(false);
			global $wpdb;
			$table_name = $wpdb->prefix . "booking_package_guests";
			for ($guestKey = 0; $guestKey < count($selectedGuests); $guestKey++) {
				
				$selectedGuest = $selectedGuests[$guestKey];
				$sql = $wpdb->prepare("SELECT * FROM " . $table_name . " WHERE `key` = %d ORDER BY ranking ASC;", array(intval($selectedGuest['key'])));
				$row = $wpdb->get_row($sql, ARRAY_A);
				if (is_null($row)) {
					
					return $response;
					
				} else {
					
					$list = json_decode($row['json'], true);
					if ($mode == 'add') {
						
						array_unshift($list, array("number" => 0, "price" => 0, "name" => __("Select")));
						
					}
					
					$selected = 0;
					for ($listKey = 0; $listKey < count($list); $listKey++) {
						
						$list[$listKey]['selected'] = 0;
						
					}
					
					$key = intval($selectedGuest['index']);
					if (isset($list[$key]) && isset($selectedGuest['selectedName']) && $list[$key]['name'] == $selectedGuest['selectedName']) {
						
						$row['index'] = $key;
						$row['number'] = intval($list[$key]['number']);
						$selected = 1;
						$list[$key]['selected'] = 1;
						if ($row['guestsInCapacity'] == 'included' && intval($list[$key]['number']) > 0) {
							
							$response['applicantCount'] += intval($list[$key]['number']);
							
						}
						
						if ($isExtensionsValid !== true) {
							
							$row['costInServices'] = 'cost_1';
							$row['reflectService'] = '0';
							$row['reflectAdditional'] = '0';
							
						}
						
						if (intval($row['required']) == 1) {
							
							$response['requiredTotalNumberOfGuests'] += intval($list[$key]['number']);
							
						} else {
							
							$response['unrequiredTotalNumberOfGuests'] += intval($list[$key]['number']);
							
						}
						
						if (intval($row['reflectService']) == 1 && intval($list[$key]['number']) > 0) {
							
							$response['reflectService'] += intval($list[$key]['number']);
							
						}
						
						if (intval($row['reflectAdditional']) == 1 && intval($list[$key]['number']) > 0) {
							
							$response['reflectAdditional'] += intval($list[$key]['number']);
							
						}
						
					}
					
					if ($selected == 0) {
						
						$row['index'] = 0;
						$list[0]['selected'] = 1;
						
					}
					
					$row['json'] = $list;
					
				}
				
				if ($response['reflectService'] == 1) {
					
					$response['reflectServiceTitle'] = $response['reflectService'] . __('person', $this->pluginName);
				
				} else if ($response['reflectService'] > 1) {
					
					$response['reflectServiceTitle'] = $response['reflectService'] . __('people', $this->pluginName);
					
				}
				
				if ($response['reflectAdditional'] == 1) {
					
					$response['reflectAdditionalTitle'] = $response['reflectAdditional'] . __('person', $this->pluginName);
				
				} else if ($response['reflectAdditional'] > 1) {
					
					$response['reflectAdditionalTitle'] = $response['reflectAdditional'] . __('people', $this->pluginName);
					
				}
				
				array_push($response['guests'], $row);
				
			}
			
			if ($response['reflectService'] == 0) {
				
				$response['reflectService'] = 1;
				$response['reflectServiceTitle'] = 1 . __('person', $this->pluginName);
			
			}
			
			if ($response['reflectAdditional'] == 0) {
				
				$response['reflectAdditional'] = 1;
				$response['reflectAdditionalTitle'] = 1 . __('person', $this->pluginName);
			
			}
			
			$response['isGuests'] = true;
			
			$minimumGuests = $limitNumberOfGuests['minimumGuests'];
            if ($minimumGuests['enabled'] == 1 && $minimumGuests['number'] > 0) {
                
                if ($minimumGuests['included'] == 1 && $minimumGuests['number'] > ($response['requiredTotalNumberOfGuests'] + $response['unrequiredTotalNumberOfGuests'])) {
                    
                    $response['isGuests'] = false;
                    $response['message'] = sprintf(__('The total number of people must be %s or more.', $this->pluginName), $minimumGuests['number']);
                    
                } else if ($minimumGuests['number'] > $response['requiredTotalNumberOfGuests']) {
                    
                    $response['isGuests'] = false;
                    $response['message'] = sprintf(__('The required total number of people must be %s or more.', $this->pluginName), $minimumGuests['number']);
                    
                }
                
                if ($response['isGuests'] === false) {
                    
                    return $response;
                    
                }
                
            }
            
            $maximumGuests = $limitNumberOfGuests['maximumGuests'];
            if ($maximumGuests['enabled'] == 1 && $maximumGuests['number'] > 0) {
                
                if ($maximumGuests['included'] == 1 && $maximumGuests['number'] < ($response['requiredTotalNumberOfGuests'] + $response['unrequiredTotalNumberOfGuests'])) {
                    
                    $response['isGuests'] = false;
                    $response['message'] = sprintf(__('The total number of people must be %s or less.', $this->pluginName), $maximumGuests['number']);
                    
                } else if ($maximumGuests['number'] < $response['requiredTotalNumberOfGuests']) {
                    
                    $response['isGuests'] = false;
                    $response['message'] = sprintf(__('The required total number of people must be %s or less.', $this->pluginName), $maximumGuests['number']);
                    
                }
                
            }
			
			return $response;
			
		}
    	
    	public function getSelectedServices($calendarAccount, $selectedServices, $guests, $targetOptions, $coupon = array(), $applicantCount = 1) {
    		
    		$time = 0;
    		$cost = 0;
    		$hasKeys = array(
    			"key" => "int", 
    			"accountKey" => "int", 
    			"name" => "string", 
    			"time" => "int", 
    			"cost" => "int", 
    			"cost_1" => "int", 
    			"cost_2" => "int", 
    			"cost_3" => "int", 
    			"cost_4" => "int", 
    			"cost_5" => "int", 
    			"cost_6" => "int", 
    			"active" => "string", 
    			"options" => "object", 
    			"selectedOptionsList" => "object", 
    			"service" => "int", 
    			"selected" => "int",
    			"stopServiceUnderFollowingConditions" => "string", 
    			"doNotStopServiceAsException" => "string", 
    		);
    		if (isset($selectedServices)) {
    			
    			$jsonList = $selectedServices;
    			
                if (is_string($selectedServices) === true) {
                	
                	#$jsonList = json_decode(str_replace("\\", "", $selectedServices), true);
                	$jsonList = json_decode(stripslashes($selectedServices), true);
                	
                }
                
                $services = array();
                if (is_array($jsonList)) {
					
					for ($i = 0; $i < count($jsonList); $i++) {
						
						$time += intval($jsonList[$i]['time']);
						//$cost += intval($jsonList[$i]['cost']);
						$responseCostInService = $this->getCostsInService($calendarAccount, $jsonList[$i], $guests);
						$cost += $responseCostInService['totalCost'];
						$service = array('options' => array());
						foreach ((array) $hasKeys as $key => $value) {
							
							if (isset($jsonList[$i][$key])) {
								
								if ($value == 'object') {
									
									if ($key == $targetOptions) {
										
										$optionsDetails = $this->getSelectedOptions($calendarAccount, $jsonList[$i][$key], $guests, $applicantCount);
										//var_dump($optionsDetails);
										$service['options'] = $optionsDetails['object'];   
										$time += $optionsDetails['time'];
										$cost += $optionsDetails['cost'];
										
									}
									
								} else {
									
									$service[sanitize_text_field($key)] = sanitize_text_field($jsonList[$i][$key]);
									
								}
								
							}
							
						}
						
						array_push($services, $service);
						
					}
                	
                }
            	
			}
			
			$cost = $this->getDiscountCostByCoupon($coupon, $cost);
			return array("time" => $time, "cost" => $cost, "object" => $services);
			
		}
		
		public function getDiscountCostByCoupon($coupon, $cost) {
			
			if (!empty($coupon) && is_array($coupon) && isset($coupon['key'])) {
				
				if ($coupon['method'] == 'subtraction') {
					
					if ($cost > intval($coupon['value'])) {
						
						$cost -= intval($coupon['value']);
						
					} else {
						
						$cost = 0;
						
					}
					
				} else {
					
					#totalCost -= totalCost - (totalCost * (100 - parseInt(coupon.value)) / 100);
					$cost -= $cost - ($cost * (100 - intval($coupon['value'])) / 100);
					
				}
				
				return intval($cost);
				
			} else {
				
				return $cost;
				
			}
			
		}
		
		public function getCostsInService($calendarAccount, $service, $guests) {
			
			$currency = get_option($this->prefix."currency", 'usd');
			$hasReflectService = false;
			$totalCost = 0;
			$totalCost1 = 0;
			$totalCost2 = 0;
			$hasMultipleCosts = false;
			$isExtensionsValid = $this->getExtensionsValid(false);
			if (isset($service['cost_1']) === false) {
				
				if (isset($service['cost']) === true) {
					
					$service['cost_1'] = $service['cost'];
					$service['cost_2'] = $service['cost'];
					$service['cost_3'] = $service['cost'];
					$service['cost_4'] = $service['cost'];
					$service['cost_5'] = $service['cost'];
					$service['cost_6'] = $service['cost'];
					
				} else {
					
					$service['cost_1'] = 0;
					$service['cost_2'] = 0;
					$service['cost_3'] = 0;
					$service['cost_4'] = 0;
					$service['cost_5'] = 0;
					$service['cost_6'] = 0;
					
				}
				
			}
			
			#$costs = array(intval($service['cost_1']), intval($service['cost_2']), intval($service['cost_3']), intval($service['cost_4']), intval($service['cost_5']), intval($service['cost_6']));
			$costsWithKey = array('cost_1' => intval($service['cost_1']), 'cost_2' => intval($service['cost_2']), 'cost_3' => intval($service['cost_3']), 'cost_4' => intval($service['cost_4']), 'cost_5' => intval($service['cost_5']), 'cost_6' => intval($service['cost_6']));
			$response = array('hasMultipleCosts' => $hasMultipleCosts, 'max' => 0, 'min' => 0, 'costs' => array(), 'costsWithKey' => $costsWithKey, 'totalCost' => 0, 'guests' => null);
			$costs = array();
			if (intval($calendarAccount['guestsBool']) == 1 && is_array($guests)) {
				
				foreach ($guests as $key => $guest) {
					
					if (isset($guest['costInServices']) === false) {
						
						$guest['costInServices'] = 'cost_1';
						
					}
					
					if ($isExtensionsValid !== true) {
						
						$guest['costInServices'] = 'cost_1';
						$guest['reflectService'] = '0';
						$guest['reflectAdditional'] = '0';
						
					}
					
					$costInServices = $guest['costInServices'];
					if ($costsWithKey[$costInServices] != null) {
						
						array_push($costs, $costsWithKey[$costInServices]);
						
					}
					
					$index = intval($guest['index']);
					$option = $guest['json'][$index];
					$number = intval($option['number']);
					$costKey = $guest['costInServices'];
					
					if ($number > 0 && intval($costsWithKey[$costKey]) != 0 && intval($guest['reflectService']) == 1) {
						
						$hasReflectService = true;
						$guests[$key]['content'] = $guest['name'] . ': ' . $this->formatCost($costsWithKey[$costKey], $currency) . ' * ' . $option['name'];
						$totalCost1 += $costsWithKey[$costKey] * $number;
						
					} else if ($number > 0 && intval($costsWithKey[$costKey]) != 0 && intval($guest['reflectService']) == 0) {
						
						$guests[$key]['content'] = $guest['name'] . ': ' . /**$this->formatCost($costsWithKey[$costKey], $currency) . ' * ' .**/ $option['name'];
						if ($totalCost2 == 0) {
							
							$totalCost2 = $costsWithKey['cost_1'];
							
						}
						
					}
					
				}
				
				if ($hasReflectService === true) {
					
					$totalCost2 = 0;
					
				}
				
				$response['costs'] = $costs;
				$response['totalCost'] = $totalCost1 + $totalCost2;
				$response['guests'] = $guests;
				
			} else {
				
				$costs = array($costsWithKey['cost_1']);
				$response['costs'] = $costs;
				$totalCost += $costsWithKey['cost_1'];
				$response['totalCost'] = $totalCost;
				$response['guests'] = $guests;
				
			}
			
			if (is_array($costs) == true && count($costs) > 0) {
				
				$response['max'] = max($costs);
				$response['min'] = min($costs);
				
			} else {
				
				$totalCost += $costsWithKey['cost_1'];
				$response['totalCost'] = $totalCost;
				
			}
			
			if ($response['max'] != $response['min']) {
				
				$response['hasMultipleCosts'] = true;
				
			}
			
			
			return $response;
			
		}
    	
    	public function getSelectedOptions($calendarAccount, $selectedOptions, $guests, $applicantCount = 1){
    		
    		$time = 0;
    		$cost = 0;
    		$options = array();
            if (isset($selectedOptions)) {
                
                $jsonList = $selectedOptions;
                if (is_string($selectedOptions) === true) {
                	
                	#$jsonList = json_decode(str_replace("\\", "", $selectedOptions), true);
                	$jsonList = json_decode(stripslashes($selectedOptions), true);
                	
                }
                
                if (is_array($jsonList)) {
                	
					for ($i = 0; $i < count($jsonList); $i++) {
						
						$object = array();
						foreach ((array) $jsonList[$i] as $key => $value) {
							
							$object[sanitize_text_field($key)] = sanitize_text_field($value);
							
						}
						
						if (intval($object['selected']) == 1) {
							
							$time += intval($object['time']);
							#$cost += intval($object['cost']) * $applicantCount;
							$responseCostInService = $this->getCostsInService($calendarAccount, $object, $guests);
							$cost += $responseCostInService['totalCost'];
							
						}
						
						array_push($options, $object);
						
					}
                	
                }
                
            }
            
            return array("time" => $time, "cost" => $cost, "object" => $options);
			
		}
		
		public function get_user_id($administrator = false, $request_user_id = null) {
			
			$user_id = null;
			$user_login = null;
			if ($administrator === false) {
				
				$user = $this->get_user();
				if (intval($user['status']) == 1) {
					
					$user = $user['user'];
					$user_id = intval($user['current_member_id']);
					$user_login = $user['user_login'];
					
				}
				
			} else if ($administrator === true && isset($request_user_id)) {
				
				$user = $this->get_user(intval($request_user_id), false);
				$user = $user['user'];
				$user_id = intval($user['current_member_id']);
				$user_login = $user['user_login'];
				
			}
			
			return array('user_id' => $user_id, 'user_login' => $user_login);
			
		}
    	
    	public function insertPrivateData($sendDate, $permission, $status, $timeKey, $scheduleUnixTime, $scheduleTitle, $scheduleCost, $services, $form, $emails, $currency, $payType, $cardToken, $accountKey, $permalink, $preparation, $taxes, $guests, $coupon, $administrator, $applicantCount = 1){
    		
    		global $wpdb;
    		
    		$remainderTime = 0;
    		$maintenanceTime = 0;
    		$remainderBool = 'false';
    		$cancellationToken = hash('ripemd160', $timeKey.$scheduleUnixTime.microtime(true));
			if(($sendDate + ($remainderTime * 60)) > $scheduleUnixTime){
				
				$remainderBool = 'true';
				
			}
			
			$courseTitle = get_option($this->prefix."courseName", "Services");
			$numberOfWeek = ceil(date('d', $scheduleUnixTime) / 7);
			
			$payMode = "";
			$payId = "";
			$payName = "";
			if ($cardToken != null) {
				
				$payMode = "CreditCard";
				if($payType == 'stripe'){
					
					$payId = "stripe";
					$payName = "Stripe";
					
				}else if($payType == 'paypal'){
					
					$payId = "paypal";
					$payName = "PayPal";
					
				}
				
			}
			
			$type = "day";
			$checkIn = 0;
			$checkOut = 0;
			$accommodationDetails = $this->getAccommodationDetails();
			if(!is_null($accommodationDetails)){
				
				$type = "hotel";
				$checkIn = $accommodationDetails['checkIn'];
				$checkOut = $accommodationDetails['checkOut'];
				
			}
			
			$response_user = $this->get_user_id($administrator, $_POST['userId']);
			$user_id = $response_user['user_id'];
			$user_login = $response_user['user_login'];
			
			$couponKey = '';
			if (!empty($coupon) && is_array($coupon) && isset($coupon['key'])) {
				
				$couponKey = $coupon['key'];
				$coupon = json_encode($coupon);
				
			} else {
				
				$coupon = '';
				
			}
			
			
			/**
			$user_id = null;
			$user_login = null;
			if ($administrator === false) {
				
				$user = $this->get_user();
				if (intval($user['status']) == 1) {
					
					$user = $user['user'];
					$user_id = intval($user['current_member_id']);
					$user_login = $user['user_login'];
					
				}
				
			} else if ($administrator === true && isset($_POST['userId'])) {
				
				$user = $this->get_user(intval($_POST['userId']), false);
				$user = $user['user'];
				$user_id = intval($user['current_member_id']);
				$user_login = $user['user_login'];
				
			}
			**/
			
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$valueArray = array(
				'reserveTime' => intval($sendDate), 
				'remainderTime' => 0,
				'remainderBool' => $remainderBool, 
				'maintenanceTime' => intval($maintenanceTime),
				'permission' => sanitize_text_field($permission),
				'type' => $type,
				'status' => sanitize_text_field($status),
				'accountKey' => intval($accountKey),
				'accountName' => '',
				'scheduleUnixTime' => intval($scheduleUnixTime),
				'scheduleWeek' => intval($numberOfWeek),
				'scheduleTitle' => sanitize_text_field($scheduleTitle),
				'scheduleKey' => intval($timeKey),
				'scheduleCost' => intval($scheduleCost),
				'applicantCount' => intval($applicantCount),
				'courseTitle' => sanitize_text_field($courseTitle),
				'currency' => sanitize_text_field($currency),
				'payMode' => $payMode,
				'payId' => $payId,
				'payName' => $payName,
				'payToken' => sanitize_text_field($cardToken),
				'praivateData' => json_encode($form),
				'checkIn' => intval($checkIn),
				'checkOut' => intval($checkOut),
				'accommodationDetails' => json_encode($accommodationDetails),
				'options' => json_encode($services),
				'cancellationToken' => $cancellationToken,
				'permalink' => esc_url($permalink),
				'preparation' => json_encode($preparation),
				'taxes' => json_encode($taxes),
				'guests' => json_encode($guests),
				'user_id' => $user_id,
				'user_login' => sanitize_text_field($user_login),
				'couponKey' => sanitize_text_field($couponKey),
				'coupon' => sanitize_text_field($coupon),
				'emails' => json_encode($emails),
			);
    		
			$bool = $wpdb->insert(	$table_name, 
    								$valueArray, 
    								array(	'%d', '%d', '%s', '%d', '%s', '%s', '%s', '%d', '%s', '%d', 
    										'%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', 
    										'%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', 
    										'%s', '%d', '%s', '%s', '%s', '%s', 
    								)
    							);
			#$ressponse['insert'] = $bool;
			$lastID = $wpdb->insert_id;
			
			$user = $this->get_user();
			if (intval($user['status']) == 1) {
				
				$user = $user['user'];
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$bool = $wpdb->update(
    				$table_name,
					array(
						'user_id' => intval($user["current_member_id"]),
						'user_login' => sanitize_text_field($user["user_login"]),
					),
					array('key' => intval($lastID)),
					array('%d', '%s'),
					array('%d')
				);
				
			}
			
			return array("lastID" => $lastID, "cancellationToken" => $cancellationToken, "cancellationUri" => "id=".$lastID."&token=".$cancellationToken);
			#return $lastID;
    		
    	}
    	
    	public function getBookingDetailsOnVisitor($key, $token) {
    		
    		global $wpdb;
    		$table_name = $wpdb->prefix . "booking_package_userPraivateData";
			$sql = "SELECT * FROM `" . $table_name . "` WHERE `key` = %d;";
			$sql = $wpdb->prepare(
				"SELECT * FROM `" . $table_name . "` WHERE `key` = %d AND `cancellationToken` = %s;", 
				array(
					intval($key), 
					sanitize_text_field($token)
				)
			);
			$row = $wpdb->get_row($sql, ARRAY_A);
        	if (is_null($row) === false) {
        		
        		$row['scheduleMonth'] = date('n', $row['scheduleUnixTime']);
        		$row['scheduleDay'] = date('j', $row['scheduleUnixTime']);
        		$row['scheduleYear'] = date('Y', $row['scheduleUnixTime']);
        		$row['scheduleWeek'] = date('w', $row['scheduleUnixTime']);
        		$row['scheduleHour'] = date('H', $row['scheduleUnixTime']);
        		$row['scheduleMin'] = date('i', $row['scheduleUnixTime']);
        		$accommodationDetails = json_decode($row['accommodationDetails'], true);
        		if (isset($accommodationDetails['rooms']) === false) {
        			
        			$accommodationDetails['rooms'] = null;
        			
        		}
        		if ($row['type'] == 'hotel' && is_null($accommodationDetails) === false && is_null($accommodationDetails['rooms'])) {
        			
        			$accommodationDetails['applicantCount'] = 1;
					$accommodationDetails['rooms'] = $this->createRooms($accommodationDetails);
					$row['accommodationDetails'] = json_encode($accommodationDetails);
        			
        		}
        		
        		$row['accommodationDetailsList'] = $this->bookingDetailsForHotel($row['accountKey'], json_decode($row['accommodationDetails'], true), $row['currency'], 'object');
        		$guests = $row['guests'];
        		if (empty($guests) || is_null($guests)) {
        			
        			$guests = array();
        			
        		} else {
        			
        			$guests = json_decode($guests, true);
        			
        		}
        		$row['guests'] = $guests;
        		
        		return array("status" => "success", "details" => $row);
        		
        	} else {
        		
        		return array("status" => "error", "details" => null);
        		
        	}
    		
    	}
    	
		public function verifyCancellation($bookingDetails, $isExtensionsValid = false, $user = 0) {
			
			$response = array("cancel" => false);
			$calendarAccount = $this->getCalendarAccount(intval($bookingDetails['accountKey']));
			if (intval($calendarAccount['cancellationOfBooking']) == 1) {
				
				$unixTime = date('U');
				if ($isExtensionsValid === true) {
					
					$unixTime = $unixTime + (intval($calendarAccount['allowCancellationVisitor']) * 60);
					
				} else {
					
					$calendarAccount['refuseCancellationOfBooking'] = 'not_refuse';
					
				}
				
				if ($unixTime < intval($bookingDetails['scheduleUnixTime'])) {
					
					if ($calendarAccount['refuseCancellationOfBooking'] == 'not_refuse') {
						
						$response['cancel'] = true;
						
					} else if ($bookingDetails['status'] == $calendarAccount['refuseCancellationOfBooking']) {
						
						$response['cancel'] = true;
						
					}
					
				}
				
			}
			
			return $response;
			
		}
		
    	public function cancelBookingData($deleteKey, $token, $status) {
    		
    		global $wpdb;
    		$applicantCount = 1;
    		$response = array("status" => "error", "key" => $deleteKey, "token" => $token, "cancel" => 0, "myBookingDetails" => array());
    		$bookingDetailsOnVisitor = $this->getBookingDetailsOnVisitor($deleteKey, $token);
    		$response = apply_filters('booking_package_update_status', $status, $bookingDetailsOnVisitor['details']);
			if (empty($response) === false && isset($response['status']) && $response['status'] == 'error') {
				
				return array('status' => $response['status']);
				
			}
			$response = array("status" => "error", "key" => $deleteKey, "token" => $token, "cancel" => 0, "myBookingDetails" => array());
    		$myBookingDetails = $bookingDetailsOnVisitor['details'];
    		$_POST['accountKey'] = $myBookingDetails['accountKey'];
    		$verifyCancellation = $this->verifyCancellation($myBookingDetails, true, 0);
    		if ($verifyCancellation['cancel'] === true) {
    			
    			$this->updateStatus($deleteKey, $token, $status);
    			$response['status'] = 'success';
    			$_POST['sendEmail'] = 0;
    			
    		}
    		
    		$response['myBookingDetails'] = $myBookingDetails;
    		$response['accommodationDetails'] = $accommodationDetails;
    		$response['cancel'] = $verifyCancellation['cancel'];
    		
    		return $response;
    		
    	}
    	
		public function deleteBookingData($deleteKey = false, $accountKey = 1, $sendGC = true, $deleteVisitorDetails = true, $sendEmail = 1){
			
			$accountCalendarKey = $accountKey;
			
			global $wpdb;
			$service = null;
			$refound = null;
			$options = array();
			$responseGuests = array();
			$calendarAccount = $this->getCalendarAccount($accountKey);
			if (intval($calendarAccount['schedulesSharing']) == 1) {
				
				$accountCalendarKey = intval($calendarAccount['targetSchedules']);
				
			}
			$paymentMethod = explode(",", $calendarAccount['paymentMethod']);
			if ($deleteKey !== false) {
				
				$currency = 'usd';
				$unixTimeStart = 0;
				$form = null;
				$accommodationDetails = array();
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
				$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array(intval($deleteKey)));
				$row = $wpdb->get_row($sql, ARRAY_A);
				if (is_null($row) === false) {
					
					$coupon = null;
					if (isset($row['coupon']) && !empty($row['coupon'])) {
						
						$coupon = json_decode($row['coupon'], true);
						
					}
					
					$status = $row['status'];
					$unixTimeStart = $row['scheduleUnixTime'];
					$accountKey = $row['accountKey'];
					$iCalIDforGoogleCalendar = $row['iCalIDforGoogleCalendar'];
					$form = json_decode($row['praivateData'], true);
					$table_name = $wpdb->prefix."booking_package_schedule";
					$sql = null;
					$month = date('m', $row['scheduleUnixTime']);
					$year = date('Y', $row['scheduleUnixTime']);
					$applicantCount = $row['applicantCount'];
					$payName = $row['payName'];
					$payId = $row['payId'];
					$payToken = $row['payToken'];
					$scheduleTitle = $row['scheduleTitle'];
					$courseName = $row['courseName'];
					$service = array("name" => $row['courseName'], "price" => $row['courseCost'], "time" => $row["courseTime"]);
					$currency = $row['currency'];
					$options = json_decode($row['options'], true);
					$preparation = json_decode($row['preparation'], true);
					#$responseGuests = json_decode($row['guests'], true);
					$responseGuests = $this->jsonDecodeForGuests($row['guests']);
					$selectedOptionsObject = $this->getSelectedOptions($calendarAccount, $row['options'], $responseGuests['guests']);
					$servicesDetails = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $applicantCount);
					$services = $servicesDetails['object'];
					
					if (empty($responseGuests) === true) {
						
						$responseGuests = array();
						
					}
					
					if ($status != 'canceled') {
						
						if ($calendarAccount['type'] == 'hotel') {
							
							$accommodationDetails = json_decode($row['accommodationDetails'], true);
							$endKey = end($accommodationDetails['scheduleList']);
							$unixTimeStart = $row['scheduleUnixTime'];
							$unixTimeEnd = $accommodationDetails['lastUnixTime'];
							$timestampForUnixTime = $row['reserveTime'];
							$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
							$valueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
							#$sql = $wpdb->prepare($account_sql, $valueArray);
							
						} else {
							
							$accommodationDetails['taxes'] = json_decode($row['taxes'], true);
							$startTime = $row['scheduleUnixTime'];
							$unixTimeStart = $row['scheduleUnixTime'];
							$timestampForUnixTime = $row['reserveTime'];
							
							$hasMultipleServices = 0;
							#$responseGuests = json_decode($row['guests'], true);
							$responseGuests = $this->jsonDecodeForGuests($row['guests']);
							$servicesDetails = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $applicantCount);
							$services = $servicesDetails['object'];
							if (is_array($services)) {
								
								foreach ((array) $services as $service) {
									
									if (isset($service['service']) && intval($service['service']) == 1) {
										
										$hasMultipleServices = 1;
										break;
										
									}
									
								}
								
							}
							
							if ($hasMultipleServices == 1) {
								
								$unixTimeEnd = $row['scheduleUnixTime'] + ($servicesDetails['time'] * 60) + ($row['maintenanceTime'] * 60);
								#return array("status" => "error", "servicesDetails" => $servicesDetails, "unixTimeEnd" => $unixTimeEnd);
								
							} else {
								
								$unixTimeEnd = $row['scheduleUnixTime'] + ($row['courseTime'] * 60) + ($row['maintenanceTime'] * 60) + ($selectedOptionsObject['time'] * 60);
								
							}
							
							$valueArray = array();
	            			if (strlen($row['courseKey']) != 0 || $hasMultipleServices == 1) {
	            				
	            				if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
	        						
	        						$unixTimeStart -= $preparation['time'] * 60;
	        						
	        					}
	        					
	        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
	        						
	        						$unixTimeEnd += $preparation['time'] * 60;
	        						
	        					}
	        					$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) AND `status` = 'open' ORDER BY `unixTime` ASC;";
	            				$valueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
	        					
	            			} else {
	            				
	            				if (isset($preparation['time']) && intval(isset($preparation['time'])) > 0) {
	            					
		        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
		        						
		        						$unixTimeStart = $startTime - ($preparation['time'] * 60);
		        						
		        					}
		        					
		        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
		        						
		        						$unixTimeEnd = $startTime + ($preparation['time'] * 60);
		        						
		        					}
		        					$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
		        					$valueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
	            					
	            				} else {
	            					
	            					$sql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d AND `status` = 'open';";
	            					$valueArray = array(intval($accountCalendarKey), intval($row['scheduleKey']));
	            					
	            				}
	            				
	            			}
	            			
	            		}
						
						/**
						if($row['status'] == 'approved'){
							
							$souce = array(
								array("mode" => "reduce", "sql" => $sql, "values" => $valueArray), 
							);
							$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
							
						}
						**/
						
						$souce = array(
							array("mode" => "reduce", "sql" => $sql, "values" => $valueArray), 
						);
						$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
						if (isset($updateSchedule['status']) && $updateSchedule['status'] == 'error') {
							
							return $updateSchedule;
							
						}
						
            		}
					
					if (isset($_POST['refound']) && intval($_POST['refound']) == 1) {
						
						$payment_active = 0;
						$payment_mode = 0;
						$payment_live = 0;
						$stripe_public_key = null;
						$stripe_secret_key = null;
						if ($payId == 'stripe') {
							
							#$payment_active = get_option($this->prefix."stripe_active", "0");
							$payment_active = 0;
							if (!is_bool(array_search(strtolower($payId), $paymentMethod))) {
								
								$payment_active = 1;
								
							}
							
							$stripe_secret_key = get_option($this->prefix."stripe_secret_key", null);
							
						} else if($payId == 'paypal') {
							
							#$payment_active = get_option($this->prefix."paypal_active", "0");
							$payment_active = 0;
							if (!is_bool(array_search(strtolower($payId), $paymentMethod))) {
								
								$payment_active = 1;
								
							}
							
							$payment_live = get_option($this->prefix."paypal_live", "0");
							$stripe_public_key = get_option($this->prefix."paypal_client_id", null);
							$stripe_secret_key = get_option($this->prefix."paypal_secret_key", null);
							
						}
						
						$currency = get_option($this->prefix."currency", "usd");
						if (intval($payment_active) == 1 && !is_null($stripe_secret_key)) {
							
							$creditCard = new booking_package_CreditCard($this->pluginName, $this->prefix);
							$refound = $creditCard->cancel($payId, $stripe_public_key, $stripe_secret_key, $payment_live, $payToken);
							if (isset($refound['status']) && $refound['status'] == 'error') {
								
								return $refound;
								die();
								
							}
							
						}
						
					}
					
					$mailBody = null;
					if (intval($sendEmail) == 1) {
						
						$email = $this->createEmailMessage($accountKey, array('mail_deleted'), $form, $accommodationDetails, $options, $deleteKey, intval($unixTimeStart), intval($timestampForUnixTime), null, $currency, $services, $payName, $payId, $scheduleTitle, $responseGuests, $coupon);
						
					}
					
					if ($deleteVisitorDetails === true) {
						
						$table_name = $wpdb->prefix."booking_package_userPraivateData";
						$wpdb->delete($table_name, array('key' => intval($deleteKey)), array('%d'));
						
					}
					
					if ($sendGC === true) {
						
						$setting = new booking_package_setting($this->prefix, $this->pluginName);
						$ressponse['delete'] = $setting->deleteGC($accountKey, $iCalIDforGoogleCalendar, $calendarAccount['googleCalendarID']);
						
					}
					
					$ressponse = $this->getReservationData($month, 1, $year);
					$ressponse['status'] = "success";
					$ressponse['refound'] = $refound;
					$ressponse['selectedOptions'] = $selectedOptionsObject;
					$ressponse['sql'] = $sql;
					
					return $ressponse;
					
				} else {
					
					return array('error' => 'ERROR3', 'status' => 'error');
					
				}
				
			}
			
		}
		
    	public function retryToSendToServer(){
    		
    		global $wpdb;
    		#$calendarAccountList = $this->getCalendarAccountListData();
    		$setting = new booking_package_setting($this->prefix, $this->pluginName);
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `resultOfGoogleCalendar` = %d;", array(0));
			$rows = $wpdb->get_results($sql, ARRAY_A);
			if(is_null($rows) === false && count($rows) != 0){
				
				for($row = 0; $row < count($rows); $row++){
					
					
					$form = json_decode($rows[$row]['praivateData'], true);
					$data = $rows[$row];
					$accountKey = $data['accountKey'];
					$key = $data['key'];
					$sql_start_unixTime = $data['scheduleUnixTime'];
					$sql_max_unixTime = $sql_start_unixTime + ($data['courseTime'] * 60) + ($data['maintenanceTime'] * 60);
					#var_dump($data);
					$iCalID = false;
					if(!is_null($data['iCalIDforGoogleCalendar']) && is_string($data['iCalIDforGoogleCalendar'])){
						
						$iCalID = $data['iCalIDforGoogleCalendar'];
						
					}
					
					$calendarAccount = $this->getCalendarAccount($accountKey);
					
					$googleCalendar = $setting->pushGC(
						$data['resultModeOfGoogleCalendar'], 
						$accountKey, 
						$calendarAccount['type'],
						$key, 
						$calendarAccount['googleCalendarID'],
						$sql_start_unixTime, 
						$sql_max_unixTime, 
						$form,
						$iCalID
					);
					
					$this->updateQueueForGC($key, $googleCalendar);
					
				}
				
			}
    		
    	}
    	
    	public function updateQueueForGC($key, $googleCalendar){
    		
    		global $wpdb;
    		if(isset($googleCalendar->responseStatus) && isset($googleCalendar->responseMode)){
    			
    			$valueList = array(
    				'resultOfGoogleCalendar' => intval($googleCalendar->responseStatus), 
    				'resultModeOfGoogleCalendar' => sanitize_text_field($googleCalendar->responseMode)
    			);
    			$formatList = array('%s', '%s');
    			if(isset($googleCalendar->id)){
    				
    				$valueList['iCalIDforGoogleCalendar'] = sanitize_text_field($googleCalendar->id);
    				array_push($formatList, '%s');
    				
    			}
    			
    			$table_name = $wpdb->prefix."booking_package_userPraivateData";
    			$bool = $wpdb->update(  
    				$table_name,
                    /**array('iCalIDforGoogleCalendar' => sanitize_text_field($googleCalendar->id)),**/
					$valueList,
					array('key' => intval($key)),
					$formatList,
					array('%d')
				);
    				
    		}
    		
    	}
		
		public function updateBooking($administrator){
			
			$accountKey = 1;
			$accountCalendarKey = 1;
			if (isset($_POST['accountKey'])) {
				
				$accountKey = $_POST['accountKey'];
				$accountCalendarKey = $_POST['accountKey'];
				
			}
			
			global $wpdb;
			$calendarAccount = $this->getCalendarAccount($accountKey);
			if (intval($calendarAccount['schedulesSharing']) == 1) {
				
				$accountCalendarKey = intval($calendarAccount['targetSchedules']);
				
			}
			
			$response_user = array();
			$selectedOptions = array();
			$resultArray = array();
			$unixTimeStart = 0;
			$unixTimeEnd = 0;
			$maintenanceTime = 0;
			$bookingYMD = null;
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array(intval($_POST['updateKey'])));
			$row = $wpdb->get_row($sql, ARRAY_A);
            if (is_null($row) === false) {
				
				$user_id = null;
				if (is_null($row['user_id']) === false) {
					
					$response_user = $this->get_user_id($administrator, $row['user_id']);
					$user_id = $response_user['user_id'];
					
				}
				
				$coupon = null;
				if (isset($row['coupon']) && !empty($row['coupon'])) {
					
					$coupon = json_decode($row['coupon'], true);
					
				}
				
				$bookingYMD = date('Y', $row['scheduleUnixTime']) . date('m', $row['scheduleUnixTime']) . date('d', $row['scheduleUnixTime']);
				$userValues = $this->getUserValues($accountKey, 'update', $administrator, $row['praivateData'],  $user_id);
				if (isset($userValues['status']) && $userValues['status'] == 'error') {
					
					return $userValues;
					
				}
				$form = $userValues['form'];
				$emails = $userValues['emails'];
				
				if ($calendarAccount['type'] != 'hotel') {
					
					$row = $this->updateVistorService($row);
					
				}
				
				$applicantCount = $row['applicantCount'];
				$preparation = json_decode($row['preparation'], true);
				$iCalIDforGoogleCalendar = $row['iCalIDforGoogleCalendar'];
				$startTime = $row['scheduleUnixTime'];
				$unixTimeStart = $row['scheduleUnixTime'];
				
				#$responseGuests = json_decode($row['guests'], true);
				$responseGuests = $this->jsonDecodeForGuests($row['guests']);
				$servicesDetails = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $applicantCount);
				$services = $servicesDetails['object'];
				$unixTimeEnd = $row['scheduleUnixTime'] + ($servicesDetails['time'] * 60) + ($row['maintenanceTime'] * 60);
				
				if ($calendarAccount['type'] == 'hotel') {
					
					$accountCalendarKey = $calendarAccount['key'];
					if (intval($calendarAccount['schedulesSharing']) == 1) {
						
						$accountCalendarKey = intval($calendarAccount['targetSchedules']);
						
					}
					
					$accommodationDetails = json_decode($row['accommodationDetails'], true);
					$accommodationDetails = $this->createAccommodationDetails($calendarAccount['key'], $accountCalendarKey, $_POST['json'], $unixTimeStart, $applicantCount, 'update', $accommodationDetails);
					if ($accommodationDetails['status'] == "error") {
						
						return $accommodationDetails;
						
					} else {
						
						$account_sql = $accommodationDetails['sql'];
						$valueArray = $accommodationDetails['valueArray'];
						$unixTimeEnd = $accommodationDetails['sql_max_unixTime'];
						unset($accommodationDetails['sql']);
						unset($accommodationDetails['valueArray']);
						unset($accommodationDetails['sql_max_unixTime']);
						$this->setAccommodationDetails($accommodationDetails);
						
					}
					
				}
				
				if (isset($_POST['update_booking_date']) || isset($_POST['update_booking_course'])) {
					
					define("COURSE_KEY", $row['courseKey']);
					
					$table_name = $wpdb->prefix."booking_package_schedule";
					
					$scheduleKey = $row['scheduleKey'];
					$scheduleUnixTime = $row['scheduleUnixTime'];
					$scheduleTitle = $row['scheduleTitle'];
					$scheduleCost = $row['scheduleCost'];
					$scheduleWeek = $row['scheduleWeek'];
					$bookingReminder = intval($row['bookingReminder']);
					
					$courseKey = $row['courseKey'];
					$courseName = $row['courseName'];
					$courseTime = $row['courseTime'];
					$courseCost = $row['courseCost'];
					#$responseGuests = json_decode($row['guests'], true);
					$responseGuests = $this->jsonDecodeForGuests($row['guests']);
					$servicesDetails1 = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $applicantCount);
					$services = $servicesDetails1['object'];
					$courseTime = $servicesDetails1['time'];
					
					$deleteSql = null;
					$deleteValueArray = array();
					$updateSql = null;
					$updateValueArray = array();
					
					if ($calendarAccount['type'] == 'hotel') {
						
						
						
					} else {
						
						$unixTimeStart = $scheduleUnixTime;
						$unixTimeEnd = intval($scheduleUnixTime + ($courseTime * 60) + ($row['maintenanceTime'] * 60));
						#$selectedOptionsObject1 = $this->getSelectedOptions($row['options']);
						#$selectedOptions = $selectedOptionsObject1['object'];
						#$unixTimeEnd += $selectedOptionsObject1['time'] * 60;
						#$selectedOptionsObject1['totalTime'] = $unixTimeEnd;
						$servicesDetails1['unixTimeEnd'] = $unixTimeEnd;
						$deleteValueArray = array();
						if (count($services) > 0) {
							
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
								
								$unixTimeStart -= $preparation['time'] * 60;
								
							}
							
							if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
								
								$unixTimeEnd += $preparation['time'] * 60;
								
							}
							
							$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) AND `status` = 'open' ORDER BY `unixTime` ASC;";
							$deleteValueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
							
						} else {
							
							if (isset($preparation['time']) && intval(isset($preparation['time'])) > 0) {
								
								if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
									
									$unixTimeStart = $startTime - ($preparation['time'] * 60);
									
								}
								
								if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
									
									$unixTimeEnd = $startTime + ($preparation['time'] * 60);
									
								}
								
								$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
								$deleteValueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
								
							} else {
								
								$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d AND `status` = 'open';";
								$deleteValueArray = array(intval($accountCalendarKey), intval($scheduleKey));
								
							}
							
						}
						
						if (isset($_POST['update_booking_date'])) {
							
							$bookingReminder = 0;
							$table_name = $wpdb->prefix."booking_package_schedule";
							$sql = $wpdb->prepare(
								"SELECT * FROM `".$table_name."` WHERE `key` = %d AND `status` = 'open';", 
								array(intval($_POST['update_booking_date']))
							);
							$rowSchedule = $wpdb->get_row($sql, ARRAY_A);
							if (is_null($rowSchedule)) {
								
								return array('status' => 'error', 'error' => '9016');
								
							} else {
								
								$scheduleKey = $rowSchedule['key'];
								$scheduleUnixTime = $rowSchedule['unixTime'];
								$scheduleTitle = $rowSchedule['title'];
								$scheduleCost = $rowSchedule['cost'];
								$scheduleWeek = $rowSchedule['weekKey'];
								
							}
							
						}
						
						$servicesDetails2 = $this->getSelectedServices($calendarAccount, $_POST['options'], $responseGuests['guests'], "options", $coupon, $applicantCount);
						$selectedServices = $servicesDetails2['object'];
						$courseTime = $servicesDetails2['time'];
						foreach ((array) $selectedServices as $service) {
							
							$rowCourse = $this->serachCourse($accountKey, $scheduleKey, $service['key'], $bookingYMD);
							if (isset($rowCourse['status']) && $rowCourse['status'] == 'error') {
								
								return array('status' => 'error', 'error' => '9020', 'servicesDetails2' => $servicesDetails2, 'rowCourse' => $rowCourse, 'accountKey' => $accountKey, 'message' => $rowCourse['message']);
								
							}
							
						}
						
						$preparation = array("time" => intval($calendarAccount["preparationTime"]), "position" => $calendarAccount["positionPreparationTime"]);
						$startTime = $scheduleUnixTime;
						$unixTimeStart = $scheduleUnixTime;
						$unixTimeEnd = intval($scheduleUnixTime + ($courseTime * 60) + ($row['maintenanceTime'] * 60));
						#$selectedOptionsObject2 = $this->getSelectedOptions($_POST['options']);
						#$selectedOptions = $selectedOptionsObject2['object'];
						#$unixTimeEnd += $selectedOptionsObject2['time'] * 60;
						#$selectedOptionsObject2['totalTime'] = $unixTimeEnd;
						$servicesDetails2['unixTimeEnd'] = $unixTimeEnd;
						
						#return array("status" => "error", "servicesDetails" => $servicesDetails2, "unixTimeEnd" => $unixTimeEnd);
						
						$updateValueArray = array();
    					#if(strlen(COURSE_KEY) != 0){
    					if (count($selectedServices) > 0) {
            				
            				if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
        						
        						$unixTimeStart -= $preparation['time'] * 60;
        						
        					}
        					
        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
        						
        						$unixTimeEnd += $preparation['time'] * 60;
        						
        					}
            				
            				$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) AND `status` = 'open' ORDER BY `unixTime` ASC;";
            				$updateValueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
            				
            			} else {
            				
            				if (isset($preparation['time']) && intval(isset($preparation['time'])) > 0) {
            					
	        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'before') {
	        						
	        						$unixTimeStart = $startTime - ($preparation['time'] * 60);
	        						
	        					}
	        					
	        					if (isset($preparation['position']) && $preparation['position'] == 'before_after' || $preparation['position'] == 'after') {
	        						
	        						$unixTimeEnd = $startTime + ($preparation['time'] * 60);
	        						
	        					}
	        					
	        					$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
	        					$updateValueArray = array(intval($accountCalendarKey), intval($unixTimeStart), intval($unixTimeEnd));
            					
            				} else {
            					
            					$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d AND `status` = 'open';";
            					$updateValueArray = array(intval($accountCalendarKey), intval($scheduleKey));
            					
            				}
            				
            			}
    					
    				}
					
					$souce = array(
						array("mode" => "reduce", "sql" => $deleteSql, "values" => $deleteValueArray), 
						array("mode" => "increase", "sql" => $updateSql, "values" => $updateValueArray), 
					);
					
					$updateSchedule = $this->updateRemainderSeart($souce, $applicantCount);
					if (isset($updateSchedule['status']) && $updateSchedule['status'] == 'error') {
						
						return $updateSchedule;
						
					}
					
					$table_name = $wpdb->prefix . "booking_package_userPraivateData";
					$wpdb->query("START TRANSACTION");
					$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
					try {
						
						$bool = $wpdb->update(
							$table_name,
							array(
								'scheduleKey'		=> intval($scheduleKey), 
								'scheduleUnixTime'	=> intval($scheduleUnixTime),
								'scheduleTitle'		=> sanitize_text_field($scheduleTitle), 
								'scheduleCost'		=> intval($scheduleCost), 
								'scheduleWeek'		=> intval($scheduleWeek),
								'courseKey'			=> sanitize_text_field(""), 
								'courseName'		=> sanitize_text_field(""),
								'courseTime'		=> intval(""),
								'courseCost'		=> intval(""),
								'options'			=> json_encode($selectedServices),
								'preparation'		=> json_encode($preparation),
								'emails'			=> json_encode($emails),
								'bookingReminder'	=> intval($bookingReminder),
							),
							array('key' => intval($_POST['updateKey'])),
							array(
								'%d', '%d', '%s', '%d', '%d', '%s', '%s', '%d', '%d', '%s', 
								'%s', '%s', '%d', 
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
				
				
				$checkIn = 0;
				$checkOut = 0;
				$accommodationDetails = $this->getAccommodationDetails();
				if(!is_null($accommodationDetails)){
					
					$checkIn = $accommodationDetails['checkIn'];
					$checkOut = $accommodationDetails['checkOut'];
					
				}
				
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$wpdb->query("START TRANSACTION");
				$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
				try {
					
					$bool = $wpdb->update(
						$table_name,
						array(
							'praivateData' => json_encode($form), 
							'accommodationDetails' => json_encode($accommodationDetails), 
							'checkIn' => intval($checkIn), 
							'checkOut' => intval($checkOut)
						),
						array('key' => intval($_POST['updateKey'])),
						array('%s', '%s', '%d', '%d'),
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
					
			$googleCalendar = array();
    		if(strlen($iCalIDforGoogleCalendar) != 0){
    			
    			if($calendarAccount['type'] == 'hotel'){
    				
    				
    				
    			}
    			/**
    			$setting = new booking_package_setting($this->prefix, $this->pluginName);
    			$googleCalendar = $setting->pushGC('update', $accountKey, $calendarAccount['type'], intval($_POST['updateKey']), $calendarAccount['googleCalendarID'], $unixTimeStart, $unixTimeEnd, $form, $iCalIDforGoogleCalendar);
    			$this->updateQueueForGC(intval($_POST['updateKey']), $googleCalendar);
    			**/
    		}else{
    			
    			$googleCalendar['error'] = "No ID";
    			
    		}
    		
    		$ressponse = $this->getReservationData(intval($_POST['month']), 1, intval($_POST['year']));
    		$ressponse['googleCalendar'] = $googleCalendar;
    		$ressponse['status'] = "success";
    		$ressponse['souce'] = $souce;
    		$ressponse['accommodationDetails'] = $accommodationDetails;
    		$ressponse['servicesDetails1'] = $servicesDetails1;
    		$ressponse['servicesDetails2'] = $servicesDetails2;
    		$ressponse['deleteValueArray'] = $deleteValueArray;
    		$ressponse['updateValueArray'] = $updateValueArray;
    		#$ressponse['COURSE_KEY'] = COURSE_KEY;
    		$ressponse['resultArray'] = $resultArray;
    		$ressponse['updateSchedule'] = $updateSchedule;
    		$ressponse['response_user'] = $response_user;
            
            return $ressponse;
    		
    	}
    	
    	public function serachGoogleCalendarIdOfVisitor($googleCalendarId = false){
        	
        	global $wpdb;
        	$table_name = $wpdb->prefix."booking_package_userPraivateData";
        	if($googleCalendarId != false){
        		
        		$sql = $wpdb->prepare(
        			"SELECT `key`,`iCalIDforGoogleCalendar`,`resultOfGoogleCalendar`,`resultModeOfGoogleCalendar` FROM ".$table_name." WHERE `iCalIDforGoogleCalendar` = %s;", 
        			array(sanitize_text_field($googleCalendarId))
        		);
        		$row = $wpdb->get_row($sql, ARRAY_A);
				
        		return $row;
        		
        	}
        	
        	return false;
        	
        }
    	
    	public function updateICalIDforGoogleCalendar($id, $iCalIDforGoogleCalendar){
    		
    		global $wpdb;
    		$table_name = $wpdb->prefix."booking_package_userPraivateData";
    		$bool = $wpdb->update(  
    								$table_name,
    								array(
    									'iCalIDforGoogleCalendar' => sanitize_text_field($iCalIDforGoogleCalendar),
    									'resultOfGoogleCalendar' => 1
    								),
									array('key' => intval($id)),
									array('%s', '%d'),
									array('%d')
								);
    		
    	}
    	
    	public function updateStatus($bookedKey, $bookedToken, $status = 'pending'){
			
			global $wpdb;
			
			$sendEmail = $_POST['sendEmail'];
			$status = strtolower($status);
			$bookingDetailsOnVisitor = $this->getBookingDetailsOnVisitor($bookedKey, $bookedToken);
			
			$response = apply_filters('booking_package_update_status', $status, $bookingDetailsOnVisitor['details']);
			if (empty($response) === false && isset($response['status']) && $response['status'] == 'error') {
				
				return array('status' => $response['status']);
				
			}
			
			if ($bookingDetailsOnVisitor['status'] == 'error') {
				
				return $bookingDetailsOnVisitor;
				
			}
    		$myBookingDetails = $bookingDetailsOnVisitor['details'];
			if ($status == 'canceled') {
				
				$_POST['sendEmail'] = 0;
				$this->deleteBookingData($bookedKey, $myBookingDetails['accountKey'], false, false, 0);
				
			}
			
			$currency = 'usd';
			$service = null;
			$options = array();
			$responseGuests = array();
			$accommodationDetails = array();
			$iCalIDforGoogleCalendar = null;
			$unixTimeStart = 0;
			$unixTimeEnd = 0;
			$maintenanceTime = 0;
			$form = null;
			$cancellationUri = null;
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = "SELECT * FROM `".$table_name."` WHERE `key` = %d;";
			$sql = $wpdb->prepare("SELECT * FROM `".$table_name."` WHERE `key` = %d;", array(intval($bookedKey)));
			$row = $wpdb->get_row($sql, ARRAY_A);
            if(is_null($row) === false){
            	
            	$accountKey = $row['accountKey'];
            	$calendarAccount = $this->getCalendarAccount($accountKey);
            	if ($calendarAccount['type'] == 'hotel') {
            		
            		$accommodationDetails = json_decode($row['accommodationDetails'], true);
            		
            	} else {
            		
            		$accommodationDetails['taxes'] = json_decode($row['taxes'], true);
            		
            	}
            	
            	$coupon = null;
				if (isset($row['coupon']) && !empty($row['coupon'])) {
					
					$coupon = json_decode($row['coupon'], true);
					
				}
            	
            	$iCalIDforGoogleCalendar = $row['iCalIDforGoogleCalendar'];
				$form = json_decode($row['praivateData'], true);
				$applicantCount = $row['applicantCount'];
				$scheduleTitle = $row['scheduleTitle'];
				$unixTimeStart = $row['scheduleUnixTime'];
				$timestampForUnixTime = $row['reserveTime'];
				$courseName = $row['courseName'];
				$service = array("name" => $row['courseName'], "price" => $row['courseCost'], "time" => $row["courseTime"]);
				$currency = $row['currency'];
				$payName = $row['payName'];
				$payId = $row['payId'];
				$options = json_decode($row['options'], true);
				#$responseGuests = json_decode($row['guests'], true);
				$responseGuests = $this->jsonDecodeForGuests($row['guests']);
				$servicesDetails = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $applicantCount);
				$services = $servicesDetails['object'];
				$account_sql = null;
				$valueArray = array();
				$unixTimeEnd = $row['scheduleUnixTime'] + ($row['courseTime'] * 60) + ($row['maintenanceTime'] * 60);
				
				if (empty($responseGuests) === true) {
					
					$responseGuests = array();
					
				}
				
				if (!empty($row['permalink']) && !empty($row['cancellationToken'])) {
					
					$cancellationUri = $this->getCancellationUri($row['permalink'], $row['key'], $row['cancellationToken']);
					
				}
				
				$table_name = $wpdb->prefix."booking_package_userPraivateData";
				$bool = $wpdb->update(
					$table_name,
					array('status' => sanitize_text_field($status)),
					array('key' => intval($bookedKey)),
					array('%s'),
					array('%d')
				);
            		
            }
            
            $email_id = null;
            if ($status == "pending") {
            	
            	$email_id = 'mail_pending';
            	
            } else if ($status == "approved") {
            	
            	$email_id = 'mail_approved';
            	
            } else if ($status == "canceled") {
            	
            	$email_id = 'mail_canceled_by_visitor_user';
            	$cancellationUri = null;
            	
            }
            
            $mailBody = null;
			#if($enableEmail == 1 && intval($_POST['sendEmail']) == 1){
			if(intval($sendEmail) == 1){
				
				$email = $this->createEmailMessage($accountKey, array($email_id), $form, $accommodationDetails, $options, intval($bookedKey), intval($unixTimeStart), intval($timestampForUnixTime), $cancellationUri, $currency, $services, $payName, $payId, $scheduleTitle, $responseGuests, $coupon);
				
			}
			
			$ressponse = array();
			if(isset($_POST['reload']) && intval($_POST['reload']) == 1){
				
				$ressponse = $this->getReservationData(intval($_POST['month']), 1, intval($_POST['year']));
				
			}
			
			$ressponse['status'] = "success";
			#$ressponse['googleCalendar'] = $googleCalendar;
			$ressponse['services'] = $services;
			$ressponse['status'] = $status;
			$ressponse['sendEmail'] = $sendEmail;
			return $ressponse;
			
		}
    	
    	public function changeBookingTime($mode, $updateKey, $updateScheduleKey, $status, $applicantCount, $newTimeStart, $newTimeEnd, $oldTimeStart, $oldTimeEnd, $accommodationDetails, $accountKey = 1){
    		
    		#var_dump($mode);
    		global $wpdb;
    		$accountCalendarKey = $accountKey;
    		$calendarAccount = $this->getCalendarAccount($accountKey);
    		if (intval($calendarAccount['schedulesSharing']) == 1) {
    			
    			$accountCalendarKey = intval($calendarAccount['targetSchedules']);
    			
    		}
    		$checkIn = 0;
    		$checkOut = 0;
    		$changeBool = true;
    		$scheduleDetail = null;
    		$table_name = $wpdb->prefix."booking_package_schedule";
    		$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
			$updateValue = array(intval($accountCalendarKey), intval($newTimeStart), intval($newTimeEnd));
			if($newTimeStart == $newTimeEnd){
				
				$updateSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `unixTime` = %d AND `status` = 'open';";
				$updateValue = array(intval($accountCalendarKey), intval($newTimeStart));
				
			}
			
			if(isset($accommodationDetails['sql']) && isset($accommodationDetails['valueArray'])){
				
				$updateSql = $accommodationDetails['sql'];
				$updateValue = $accommodationDetails['valueArray'];
				
			}
			
    		$sql = $wpdb->prepare($updateSql, $updateValue);
    		#var_dump($sql);
			$rows = $wpdb->get_results($sql, ARRAY_A);
			
			if (count($rows) == 0 || $rows[0]['unixTime'] != $newTimeStart) {
				
				return array('status' => 'error', 'event' => 'return', 'message' => 'There is no booking schedule.');
				
			}
			
			
			foreach ((array) $rows as $row) {
				
				if (!is_null($oldTimeStart) && !is_null($oldTimeEnd)) {
					
					if ($oldTimeStart != $oldTimeEnd) {
						
						if($oldTimeStart <= $row['unixTime'] && $oldTimeEnd > $row['unixTime']){
							
							$row['remainder'] += $applicantCount;
							
						}
						
					} else {
						
						if ($oldTimeStart == $row['unixTime']) {
							
							$row['remainder'] += $applicantCount;
							
						}
						
					}
					
				}
				
				$row['remainder'] -= $applicantCount;
				#print "key = ".$row['key']." unixTime = ".$row['unixTime']." time = ".$row['hour'].":".$row['min']." capacity = ".$row['capacity']." remainder = ".$row['remainder']."<br>";
				if($row['remainder'] < 0 || $row['stop'] == 'true'){
					
					$changeBool = false;
					return array('status' => 'error', 'event' => 'return', 'message' => 'There is not enough remainder in the capacity.');
					break;
					
				}else{
					
					if(is_null($scheduleDetail)){
						
						$scheduleDetail = $row;
						
					}
					
				}
				
			}
			
			
			
			if($changeBool === true){
				
				$newCourseTime = ($newTimeEnd - $newTimeStart) / 60;
				$oldCourseTime = ($oldTimeEnd - $oldTimeStart) / 60;
				#print "courseTime = ".$newCourseTime."<br>";
				#var_dump($scheduleDetail);
				
				if ($mode == 'update') {
					
					$checkIn = 0;
					$checkOut = 0;
					$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` < %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
					$deleteValue = array(intval($accountCalendarKey), intval($oldTimeStart), intval($oldTimeEnd));
					if ($oldTimeStart == $oldTimeEnd) {
						
						$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND `key` = %d AND `status` = 'open';";
						$deleteValue = array(intval($accountCalendarKey), intval($updateScheduleKey));
						
					}
					
					if (isset($accommodationDetails['sql']) && isset($accommodationDetails['valueArray'])) {
						
						$checkIn = $accommodationDetails['checkIn'];
						$checkOut = $accommodationDetails['checkOut'];
						$deleteSql = "SELECT * FROM `".$table_name."` WHERE `accountKey` = %d AND (`unixTime` >= %d AND `unixTime` <= %d) AND `status` = 'open' ORDER BY `unixTime` ASC ;";
						$deleteValue = array(intval($accountCalendarKey), intval($oldTimeStart), intval($oldTimeEnd));
						unset($accommodationDetails['sql']);
						unset($accommodationDetails['valueArray']);
						
					}
					
					$souce = array(
            			array("mode" => "delete", "sql" => $deleteSql, "values" => $deleteValue), 
            			array("mode" => "increase", "sql" => $updateSql, "values" => $updateValue), 
            		);
					$this->updateRemainderSeart($souce, $applicantCount);
					
					$updateValue = array(
                            			'scheduleUnixTime' => intval($scheduleDetail['unixTime']), 
                            			'scheduleWeek' => intval($scheduleDetail['weekKey']), 
                            			'scheduleTitle' => $scheduleDetail['title'], 
                            			'scheduleCost' => intval($scheduleDetail['cost']), 
                            			'scheduleKey' => intval($scheduleDetail['key']),
                            			'checkIn' => intval($checkIn),
                            			'checkOut' => intval($checkOut),
                            			'accommodationDetails' => json_encode($accommodationDetails)
                            		);
					
					if ($newCourseTime != $oldCourseTime) {
						
						$updateValue['courseKey'] = "exception";
						$updateValue['courseName'] = $newCourseTime." min";
						$updateValue['courseTime'] = intval($newCourseTime);
						
					}
					
					$table_name = $wpdb->prefix."booking_package_userPraivateData";
					$bool = $wpdb->update(  
						$table_name,
						$updateValue,
						array('key' => intval($updateKey)),
						array('%d', '%d', '%s', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%d'),
						array('%d')
					);
					
				} else {
					
					return $changeBool;
					
				}
				
			}
			
		}
		
		public function updatePraivateData($id, $form){
			
			global $wpdb;
			$form = json_encode($form);
			$table_name = $wpdb->prefix."booking_package_userPraivateData";
			$bool = $wpdb->update(
				$table_name,
				array(
					'praivateData' => $form
				),
				array('key' => intval($id)),
				array('%s'),
				array('%d')
			);
			
		}
		
		public function updateRemainderSeart($souce, $applicantCount = 1){
			#var_dump($souce);
			global $wpdb;
			$updateSchedule = array();
			$updateList = array();
			$error = array();
			$rollback = false;
			try {
				
				$wpdb->query("START TRANSACTION");
				$wpdb->query("LOCK TABLES `" . $wpdb->prefix."booking_package_schedule" . "` WRITE");
				
				for ($i = 0; $i < count($souce); $i++) {
					
					$mode = $souce[$i]['mode'];
					$sql = $souce[$i]['sql'];
					$valueArray = $souce[$i]['values'];
					
					if ($mode == "increase") {
						
						$sql = $wpdb->prepare($sql, $valueArray);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						$updateArray = array();
						foreach ((array) $rows as $row) {
							
							$waitingRemainder = 0;
							$remainder = $row['remainder'] - $applicantCount;
							if ($row['stop'] == 'false' && $remainder >= 0) {
								
								if (0 < $row['waitingRemainder']) {
									
									$waitingRemainder = $row['waitingRemainder'] - $applicantCount;
									
								}
								
								array_push($updateArray, array('remainder' => intval($remainder), 'waitingRemainder' => intval($waitingRemainder), 'key' => intval($row['key'])));
								
							} else {
								
								$rollback = true;
								$error = array('status' => 'error', 'error' => '9503', 'message' => __('There is a problem with the remaining capacity in the schedules.', $this->pluginName));
								throw new Exception(json_encode($error));
								break;
								
							}
							
						}
						
						$table_name = $wpdb->prefix."booking_package_schedule";
						for ($a = 0; $a < count($updateArray); $a++) {
							
							$data = $updateArray[$a];
							$bool = $wpdb->update(
								$table_name,
								array('remainder' => $data['remainder'], 'waitingRemainder' => $data['waitingRemainder']),
								array('key' => $data['key'], 'status' => 'open'),
								array('%d', '%d'),
								array('%d', '%s')
							);
							/**
							$update = array(
								'value' => array('remainder' => $data['remainder'], 'waitingRemainder' => $data['waitingRemainder']),
								'key' => array('key' => $data['key']),
								'value_type' => array('%d', '%d'),
								'key_type' => array('%d'),
							);
							array_push($updateList, $update);
							**/
							array_push($updateSchedule, $bool);
							
						}
						
					} else {
						
						$table_name = $wpdb->prefix."booking_package_schedule";
						$sql = $wpdb->prepare($sql, $valueArray);
						$rows = $wpdb->get_results($sql, ARRAY_A);
						foreach ((array) $rows as $row) {
							
							$remainder = intval($row['remainder']) + $applicantCount;
							if (intval($row['capacity']) < $remainder) {
								
								$rollback = true;
								$error = array('status' => 'error', 'error' => '9503', 'message' => __('There is a problem with the remaining capacity in the schedules.', $this->pluginName), "data" => $row);
								throw new Exception(json_encode($error));
								break;
								
							}
							
							$wpdb->update(
								$table_name,
								array('remainder' => intval($remainder)),
								array('key' => intval($row['key']), 'status' => 'open'),
								array('%d'),
								array('%d', '%s')
							);
							/**
							$update = array(
								'value' => array('remainder' => intval($remainder)),
								'key' => array('key' => intval($row['key'])),
								'value_type' => array('%d'),
								'key_type' => array('%d'),
							);
							array_push($updateList, $update);
							**/	
							array_push($updateSchedule, $row['hour'].":".$row['min']." ".$remainder);
							
						}
						
					}
					
				}
				
				$wpdb->query('COMMIT');
				$wpdb->query('UNLOCK TABLES');
				
			} catch (Exception $e) {
				
				$wpdb->query('ROLLBACK');
				$wpdb->query('UNLOCK TABLES');
				$error = json_decode($e->getMessage(), true);
				return $error;
				
			}
    		/** finally {
    			
    			$wpdb->query('UNLOCK TABLES');
    			
    		}
    		**/
			
			
			
			return $updateSchedule;
			
    	}
    	
		public function getUserList($unixTime, $accountKey = 1){
				
			global $wpdb;
            $table_name = $wpdb->prefix."booking_package_userPraivateData";
			$sql = $wpdb->prepare(
				"SELECT `key`,`scheduleUnixTime`,`scheduleKey`,`courseTime`,`status`,`applicantCount`,`praivateData`,`iCalIDforGoogleCalendar`,`resultOfGoogleCalendar`,`praivateData`,`checkIn`,`checkOut`,`accommodationDetails` FROM ".$table_name." WHERE `iCalIDforGoogleCalendar` IS NOT NULL AND `accountKey` = %d AND `scheduleUnixTime` > %d ORDER BY `key` ASC;", 
				array(intval($accountKey), intval($unixTime))
			);
            $rows = $wpdb->get_results($sql, ARRAY_A);
			return $rows;
			
		}
		
		private function getUserValues($accountKey, $type, $administrator, $personalInformation = null, $user_id = null) {
			
			global $wpdb;
			$strlen = 0;
			$visitorName = array();
			$emails = array();
			$sms = array();
			$table_name = $wpdb->prefix."booking_package_form";
			$sql = $wpdb->prepare("SELECT * FROM ".$table_name." WHERE `accountKey` = %d;", array(intval($accountKey)));
			$row = $wpdb->get_row($sql, ARRAY_A);
			$form = array();
			$data = json_decode($row['data'], true);
			
			if ($type == 'update' && empty($personalInformation) === false) {
				
				$data = json_decode($personalInformation, true);
				
			}
			
			if (empty($user_id) === false) {
				
				
				
			}
			
			foreach ((array) $data as $key => $value) {
				
				if (is_int($user_id) === true && isset($value['targetCustomers']) && $value['targetCustomers'] == 'visitors') {
					
					$value['active'] = '';
					
				}
				
				if (is_null($user_id) === true && isset($value['targetCustomers']) && $value['targetCustomers'] == 'users') {
					
					$value['active'] = '';
					
				}
				
				array_push($form, $value);
				
			}
			
			for ($i = 0; $i < count($form); $i++) {
				
				if (!isset($form[$i]['active'])) {
					
					$form[$i]['active'] = '';
					
				}
				
				if (!isset($_POST['form' . $i]) && $form[$i]['active'] == 'true') {
					
					$_POST['form' . $i] = '';
					
				}
				
				if (!isset($_POST['form' . $i])) {
					
					continue;
					
				}
				
				$value = $_POST['form' . $i];
				if ($form[$i]['type'] == 'TEXTAREA') {
					
					$value = sanitize_textarea_field($value);
					
				} else if ($form[$i]['type'] == 'CHECK') {
					
					$value = stripslashes($value);
					$value = sanitize_text_field($value);
					$value = json_decode($value, true);
					if (is_null($value) || is_bool($value) === true) {
						
						$value = array();
						
					}
					
					$value = implode(',', $value);
					
				} else {
					
					$value = sanitize_text_field($value);
					
				}
				
				if (isset($_POST['form' . $i])) {
					
					if (($form[$i]['required'] == 'true' || $form[$i]['required'] == 'true_frontEnd') && strlen(preg_replace("/( |　)/", "", $value)) == 0) {
						
						if ($administrator === true && $form[$i]['required'] == 'true') {
							
							return array('status' => 'error', "message" => stripslashes('Invalid value in the "' . $form[$i]['name'] . '".'), 'form' => $form[$i]);
							
						} else if ($administrator === false) {
							
							return array('status' => 'error', "message" => stripslashes('Invalid value in the "' . $form[$i]['name'] . '".'), 'form' => $form[$i]);
							
						}
						
					} else {
						
						if ($form[$i]['isEmail'] == 'true' && strlen($value) != 0 && is_email($value) === false) {
							
							return array('status' => 'error', "message" => __('The format of the email address is incorrect.', $this->pluginName) . "\n" . $form[$i]['name'], 'form' => $form[$i]);
							
						} else {
							
							if ($form[$i]['type'] == 'CHECK') {
								
								$value = stripslashes($_POST['form' . $i]);
								$value = sanitize_text_field($value);
								$value = json_decode($value, true);
								if (is_null($value) || is_bool($value) === true) {
									
									$value = array();
									
								}
								
							}
							
							if ($form[$i]['isEmail'] == 'true') {
								
								$value = sanitize_email($value);
								if (!empty($value)) {
									
									array_push($emails, $value);
									
								}
								
							}
							
							if (isset($form[$i]['isSMS']) && $form[$i]['isSMS'] == 'true') {
								
								$value = sanitize_text_field($value);
								if (!empty($value)) {
									
									array_push($sms, $value);
									
								}
								
							}
							
							if ($form[$i]['isName'] == 'true') {
								
								array_push($visitorName, sanitize_email($value));
								
							}
							
							$form[$i]['value'] = $value;
							
						}
					
					}
					
				}
				
			}
			
			return array('form' => $form, 'emails' => $emails, 'sms' => $sms);
			
		}
		
		private function getExtensionsValid($loadScript = false) {
			
			if (is_null($this->isExtensionsValid)) {
				
				$setting = new booking_package_setting($this->prefix, $this->pluginName);
				$this->isExtensionsValid = $setting->getSiteStatus($loadScript);
				
			}
			
			return $this->isExtensionsValid;
			
		}
		
		public function emailFormat($email, $title = null){
			
			if (empty($email)) {
				
				return null;
				
			}
			
			$email = trim($email);
			$value = $email;
			if (!is_null($title) && strlen($title) != 0) {
				
				$value = sprintf("%s <%s>", $title, $email);
				
			}
			return $value;
			
		}
		
		public function dateFormat($dateFormat, $positionOfWeek, $unixTime, $title, $includingTime, $shortString, $responseType){
			
			$dateFormat = intval($dateFormat);
			$comma = ',';
			$clock = get_option($this->prefix . "clock", '24hours');
			$positionTimeDate = get_option($this->prefix . "positionTimeDate", "dateTime");
			if (is_numeric($clock)) {
				
				if (intval($clock) == 12) {
					
					$clock = '12a.m.p.m';
					
				} else if (intval($clock) == 24) {
					
					$clock = '24hours';
					
				}
				
			}
			
			$monthList = array(__('January'), __('February'), __('March'), __('April'), __('May'), __('June'), __('July'), __('August'), __('September'), __('October'), __('November'), __('December'));
			
			$weekNameList = array(__('Sunday'), __('Monday'), __('Tuesday'), __('Wednesday'), __('Thursday'), __('Friday'), __('Saturday'));
			$weekName = $weekNameList[date('w', $unixTime)];
			
			if ($shortString == true) {
				
				$monthList = array(__('Jan'), __('Feb'), __('Mar'), __('Apr'), __('May'), __('Jun'), __('Jul'), __('Aug'), __('Sep'), __('Oct'), __('Nov'), __('Dec'));
				$weekNameList = array(__('Sun'), __('Mon'), __('Tue'), __('Wed'), __('Thu'), __('Fri'), __('Sat'));
				$weekName = $weekNameList[date('w', $unixTime)];
				
			}
			
			if (empty($title)) {
				
				$title = '';
				
			}
			
			$date = date('d/m/Y ', $unixTime);
			$time = date('H:i', $unixTime);
			$hour = intval(date('G', $unixTime));
    		if ($clock != '24hours') {
    			
    			$print_am_pm = 'a.m.';
    			if ($clock == '12AMPM') {
    				
    				$print_am_pm = 'AM';
    				
    			} else if ($clock == '12ampm') {
    				
    				$print_am_pm = 'am';
    				
    			}
    			
    			if ($hour >= 12) {
    				
    				$print_am_pm = 'p.m.';
    				if ($clock == '12AMPM') {
	    				
	    				$print_am_pm = 'PM';
	    				
	    			} else if ($clock == '12ampm') {
	    				
	    				$print_am_pm = 'pm';
	    				
	    			}
    				
    			}
    			
    			$time = sprintf(__('%s:%s ' . $print_am_pm, $this->pluginName), date('h', $unixTime), date('i', $unixTime));
    			
    		}
			
			if ($includingTime == false) {
				
				$time = "";
				$comma = '';
				
			}
			
			if ($dateFormat == 0) {
				
				$date = date('m/d/Y', $unixTime);
				
			} else if ($dateFormat == 1) {
				
				$date = date('m-d-Y', $unixTime);
				
			} else if ($dateFormat == 2) {
				
				#$date = date('F d, Y', $unixTime);
				$date = $monthList[date('n', $unixTime) - 1] . date(' d, Y', $unixTime);
				
			} else if ($dateFormat == 3) {
				
				$date = date('d/m/Y', $unixTime);
				
			} else if ($dateFormat == 4) {
				
				$date = date('d-m-Y', $unixTime);
				
			} else if ($dateFormat == 5) {
				
				#$date = date('d F, Y ', $unixTime);
				$date = date('d', $unixTime) . ' ' . $monthList[date('n', $unixTime) - 1].date(', Y', $unixTime);
				
			} else if ($dateFormat == 6) {
				
				$date = date('Y/m/d', $unixTime);
				
			} else if ($dateFormat == 7) {
				
				$date = date('Y-m-d', $unixTime);
				
			} else if ($dateFormat == 8 || $dateFormat == 9) {
				
				$date = date('d.m.Y', $unixTime);
				
			} else if ($dateFormat == 10) {
				
				$date = date('d', $unixTime) . '.' . $monthList[date('n', $unixTime) - 1] . date('.Y', $unixTime);
				
			} else if ($dateFormat == 11) {
				
				$date = $monthList[date('n', $unixTime) - 1] . ' ' . date('d', $unixTime) . date(' Y', $unixTime);
				
			} else if ($dateFormat == 12) {
				
				$date = date('d', $unixTime) . ' ' . $monthList[date('n', $unixTime) - 1] . date(' Y', $unixTime);
				
			} else if ($dateFormat == 13) {
				
				#$date = date('F d, Y', $unixTime);
				$date = date('d.m.Y', $unixTime);
				
			} else if ($dateFormat == 14) {
				
				#$date = date('F d, Y', $unixTime);
				$date = date('d.', $unixTime) . $monthList[date('n', $unixTime) - 1] . date('.Y', $unixTime);
				
			} else if ($dateFormat == 15) {
				
				$date = date('Y年m月d日', $unixTime);
				
			}
			
			
			if ($responseType == 'text') {
				
				if ($positionTimeDate == 'dateTime') {
					
					if ($positionOfWeek == 'before') {
						
						$date = $weekName . ' ' . $date . $comma . ' ' . $time . ' ' . $title;
						
					} else {
						
						$date = $date . ' ' . $weekName . $comma . ' ' . $time . ' ' . $title;
						
					}
					
				} else {
					
					if (!empty($title)) {
						
						$title = ' ' . $title;
						
					} else {
						
						$title = '';
						
					}
					
					if ($positionOfWeek == 'before') {
						
						$date = $time . $title . $comma . ' ' . $weekName . ' ' . $date;
						
					} else {
						
						$date = $time . $title . $comma . ' ' . $date . ' ' . $weekName;
						
					}
					
				}
				
				
				
				$date = trim($date);
				return $date;
				
			} else {
				
				if ($positionOfWeek == 'before') {
					
					$date = $weekName . ' ' . $date . ' ';
					
				} else {
					
					$date = $date . ' ' . $weekName . ' ';
					
				}
				
				return array('date' => trim($date), 'time' => (trim($time)), 'title' => trim($title));
				
			}
			
		}
		
		public function formatCost($cost = 0, $currency = 'usd'){
			
			$cost = intval($cost);
			if (strtoupper($currency) == 'USD') {
				
				$cost = 'US\$' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'EUR') {
				
				$cost = '€' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'JPY') {
				
				$cost = '¥' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'TRY') {
				
				$cost = number_format($cost, 0) . '₺';
				
			} else if (strtoupper($currency) == 'KRW') {
				
				$cost = '₩' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'HUF') {
				
				$cost = 'HUF ' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'DKK') {
				
				$cost = number_format(($cost / 100), 2) . 'kr';
				
			} else if (strtoupper($currency) == 'CNY') {
				
				$cost = 'CN¥' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'TWD') {
				
				$cost = 'NT\$' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'THB') {
				
				$cost = 'TH฿' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'COP') {
				
				$cost = 'COP' . number_format($cost, 0);
				
			} else if (strtoupper($currency) == 'CAD') {
				
				$cost = '\$' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'AUD') {
				
				$cost = '\$' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'GBP') {
				
				$cost = '£' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'PHP') {
				
				$cost = 'PHP ' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'CHF') {
				
				$cost = 'CHF ' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'CZK') {
				
				$cost = 'Kč' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'RUB') {
				
				$cost = number_format(($cost / 100), 2) . '₽';
				
			} else if (strtoupper($currency) == 'NZD') {
				
				$cost = 'NZ\$' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'HRK') {
				
				$cost = number_format(($cost / 100), 2) . ' Kn';
				
			} else if (strtoupper($currency) == 'UAH') {
				
				$cost = number_format(($cost / 100), 2) . 'грн.';
				
			} else if (strtoupper($currency) == 'BRL') {
				
				$cost = 'R\$' . number_format(($cost / 100), 2, ',', '.');
				
			} else if (strtoupper($currency) == 'AED') {
				
				$cost = number_format(($cost / 100), 2, ',', '.') . ' AED';
				
			} else if (strtoupper($currency) == 'GTQ') {
				
				$cost = 'Q' . number_format(($cost / 100), 2);
				
			} else if (strtoupper($currency) == 'MXN') {
				
				$cost = '$' . number_format(($cost / 100), 2) . " MXN";
				
			} else if (strtoupper($currency) == 'ARS') {
				
				$cost = '$' . number_format($cost, 0, '.', '.');
				
			} else if (strtoupper($currency) == 'ZAR') {
				
				$cost = 'R' . number_format(($cost / 100), 2);
				
			}
			
			return $cost;
			
		}
		
		public function bookingDetailsForHotel($accountKey, $accommodationDetails, $currency, $mode = 'array'){
			
			if (is_null($accommodationDetails) || $accommodationDetails === false) {
				
				return array();
				
			}
			
			$setting = new booking_package_setting($this->prefix, $this->pluginName);
			$numberKeys = $setting->getObjectOfDaysOfWeek();
			
			$calendarAccount = $this->getCalendarAccount($accountKey);
			$applicantCount = intval($accommodationDetails['applicantCount']);
			$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
			$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
			$formatNigh = __('nights', $this->pluginName);
			$nights = __('nights', $this->pluginName);
    		if (intval($calendarAccount['formatNightDay']) == 1) {
				
				$nights = __('%s nights %s days', $this->pluginName);
				
			}
			
			$lengthOfStay = $accommodationDetails['nights'] . " " . $nights . " (".$this->formatCost($accommodationDetails['accommodationFee'], $currency) . ")";
			if (intval($accommodationDetails['nights']) == 1) {
				
				$formatNigh = __('night', $this->pluginName);
				$nights = __('night', $this->pluginName);
				if (intval($calendarAccount['formatNightDay']) == 1) {
					
					$nights = __('%s night %s days', $this->pluginName);
					
				}
				
			}
			
			$multipleRooms = false;
			$roomStr = __('room', $this->pluginName);
			if ($applicantCount > 1) {
				
				$multipleRooms = true;
				$roomStr = __('rooms', $this->pluginName);
				
			}
			
			$formatNigh = $accommodationDetails['nights'] . " " . $formatNigh;
			$formatNightDay = $accommodationDetails['nights'] . " " . $nights;
			if (intval($calendarAccount['formatNightDay']) == 1) {
				
				$formatNightDay = sprintf($nights, $accommodationDetails['nights'], $accommodationDetails['nights'] + 1);
				
			}
			
			$detailsList = array(__('Total length of stay', $this->pluginName) . ": " . $formatNightDay . " ".$this->formatCost($accommodationDetails['accommodationFee'], $currency) . ", " . $accommodationDetails['applicantCount'] . ' ' . $roomStr);
			#$detailsList = array(__('Total length of stay', $this->pluginName) . ": " . sprintf($nights, $accommodationDetails['nights'], $accommodationDetails['nights'] + 1) . " ".$this->formatCost($accommodationDetails['accommodationFee'], $currency) . ", " . $accommodationDetails['applicantCount'] . ' ' . $roomStr);
			$objectList = array(
				'totalLengthOfStay' => array(
					#'main' => $accommodationDetails['nights'] . " " . $nights . " " . $this->formatCost(($accommodationDetails['accommodationFee']), $currency),
					'main' => $formatNightDay . " " . $this->formatCost(($accommodationDetails['accommodationFee']), $currency), 
					'sub' => array(),
				), 
				'totalLengthOfGuests' => array(
					'main' => array(), 
					'sub' => array(),
				),
				'totalLengthOfTaxes' => array(
					'main' => array(),
					'sub' => array(),
				),
			);
			$scheduleDetails = $accommodationDetails['scheduleDetails'];
			$no = 0;
			foreach ((array) $scheduleDetails as $key => $value) {
				
				$no++;
				$details = "#" . $no . " " . $this->dateFormat($dateFormat, $positionOfWeek, $value['unixTime'], null, false, false, 'text') . " ";
				if (intval($value['cost']) > 0) {
					
					$details .= $this->formatCost($value['cost'] * $applicantCount, $currency);
					
				}
				
				if ($multipleRooms === true) {
					
					$details .= ' (' . $this->formatCost($value['cost'], $currency) . ' * ' . $applicantCount . ' ' . $roomStr . ')';
					
				}
				
				array_push($detailsList, $details);
				array_push($objectList['totalLengthOfStay']['sub'], $details);
				
				if (isset($value['priceKeyByDayOfWeek'])) {
					
					$priceKeyByDayOfWeek = $value['priceKeyByDayOfWeek'];
					if (isset($numberKeys[$priceKeyByDayOfWeek])) {
						
						$numberKeys[$priceKeyByDayOfWeek]++;
						
					}
					
				}
				
			}
			
			if (isset($accommodationDetails['adult']) === false) {
				
				$accommodationDetails['adult'] = 0;
				
			}
			
			if (isset($accommodationDetails['children']) === false) {
				
				$accommodationDetails['children'] = 0;
				
			}
			
			$people = intval($accommodationDetails['adult']) + intval($accommodationDetails['children']);
			$personAmount = 0;
			$additionalFee = 0;
			$people = 0;
			if (isset($accommodationDetails['rooms']) === false) {
				
				$accommodationDetails['rooms'] = array();
				
			}
			$rooms = $accommodationDetails['rooms'];
			foreach ((array) $rooms as $room) {
				
				$personAmount += intval($accommodationDetails['personAmount']);
				$additionalFee += intval($room['additionalFee']) * intval($accommodationDetails['nights']);
				$people += intval($room['person']);
				
			}
			
			if ($people == 1) {
				
				$people = $people . " " . __("person", $this->pluginName) . "";
				
				
			} else {
				
				$people = $people . " " . __("people", $this->pluginName) . "";
				
			}
			
			if ($personAmount > 0) {
				
				$people .= ", " . $this->formatCost($personAmount, $currency) . "";
				
			} else {
				
				if ($additionalFee > 0) {
					
					$people .= ", " . $this->formatCost($additionalFee, $currency) . "";
					
				}
				
			}
			
			array_push($detailsList, "\n" . __('Total number of guests', $this->pluginName) . ": " . $people);
			$objectList['totalLengthOfGuests']['main'] = $people;
			
			$roomNo = 0;
			foreach ((array) $rooms as $room) {
				
				if ($multipleRooms === true) {
					
					$roomNo++;
					array_push($detailsList, __('Room', $this->pluginName) . ': ' . $roomNo);
					array_push($objectList['totalLengthOfGuests']['sub'], __('Room', $this->pluginName) . ': ' . $roomNo);
					
				}
				$guestsList = $room['guestsList'];
				$no = 0;
				foreach ((array) $guestsList as $key => $value) {
					
					$no++;
					$name = $value['name'];
					$guests = $value['json'];
					for ($i = 0; $i < count($guests); $i++) {
						
						if (intval($guests[$i]['selected']) == 1) {
							
							$details = "#" . $no . " " . $name . ": " . $guests[$i]['name'] . "";
							if (intval($guests[$i]['price']) > 0) {
								
								#$details .= ", ".$this->formatCost($guests[$i]['price'], $currency) . " * " . $accommodationDetails['nights']." ".$nights."";
								$details .= ", " . $this->formatCost($guests[$i]['price'], $currency) . " * " . $formatNigh;
								
							}
							
							if (isset($room['personAmount']) && intval($room['personAmount']) > 0) {
								
								$details = "#" . $no . " " . $name . ": " . $guests[$i]['name'] . "";
								$guestPrice = 0;
								foreach ((array) $numberKeys as $nmuberKey => $numberValue) {
									
									if (intval($guests[$i][$nmuberKey]) == 0 && ($nmuberKey == 'priceOnDayBeforeNationalHoliday' || $nmuberKey == 'priceOnNationalHoliday')) {
										
										$changePriceForGuest = function($schedules, $numberKeys, $nmuberKey, $guest) {
											
											$personAmount = 0;
											foreach ((array) $schedules as $schedule) {
												
												if ($schedule['priceKeyByDayOfWeek'] == $nmuberKey) {
													
													$weekKey = intval($schedule['weekKey']);
													if ($weekKey == 0) {
														
														$weekKey = 6;
														
													} else {
														
														$weekKey--;
														
													}
													
													$personAmount += $guest[$numberKeys[$weekKey]];
													
												}
												
											}
											
											return $personAmount;
											
										};
										$guestPrice += $changePriceForGuest($scheduleDetails, array_keys($numberKeys), $nmuberKey, $guests[$i]);
										
									} else {
										
										$guestPrice += $guests[$i][$nmuberKey] * $numberValue;
										
									}
									
									
								}
								
								$details .= ", " . $this->formatCost($guestPrice, $currency);
								
							}
							
							array_push($detailsList, $details);
							array_push($objectList['totalLengthOfGuests']['sub'], $details);
							break;
							
						}
						
					}
					
				}
				
				
			}
			
			$taxes = array();
			$surcharges = array();
			$taxesList = $accommodationDetails['taxes'];
			foreach ((array) $taxesList as $key => $tax) {
				
				$details = $tax['name'] . " " . $this->formatCost($tax['taxValue'], $currency);
				if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_inclusive') {
					
					array_push($taxes, $details);
					
				} else if($tax['type'] == 'tax' && $tax['tax'] == 'tax_exclusive') {
					
					array_push($taxes, $details);
					
				} else if($tax['type'] == 'surcharge') {
					
					array_push($surcharges, $details);
					
				}
				
				#$details = $tax['name']." ".$this->formatCost($tax['taxValue'], $currency);
				#array_push($detailsList, $details);
				array_push($objectList['totalLengthOfTaxes']['sub'], $details);
				
			}
			
			if (count($surcharges) > 0) {
				
				array_push($detailsList, "\n".__('Surcharges', $this->pluginName));
				for ($i = 0; $i < count($surcharges); $i++) {
					
					array_push($detailsList, $surcharges[$i]);
					
				}
				
			}
			
			if (count($taxes) > 0) {
				
				array_push($detailsList, "\n".__('Taxes', $this->pluginName));
				for ($i = 0; $i < count($taxes); $i++) {
					
					array_push($detailsList, $taxes[$i]);
					
				}
				
			}
			
			if ($mode == 'array') {
				
				return $detailsList;
				
			} else {
				
				return $objectList;
				
			}
    		
    	}
		
		
		public function getAmount($bookingID, $calendarAccount, $accommodationDetails, $services = null, $guests = null, $coupon = null) {
			
			$amount = 0;
			$reflectAdditional = 1;
			$reflectAdditionalTitle = null;
			$reflectService = 1;
			$reflectServiceTitle = null;
			$guestsList = array();
			if (is_null($guests) === false && isset($guests['guests'])) {
				
				$reflectAdditional = intval($guests['reflectAdditional']);
				$reflectAdditionalTitle = $guests['reflectAdditionalTitle'];
				$reflectService = intval($guests['reflectService']);
				$reflectServiceTitle = $guests['reflectServiceTitle'];
				$guestsList = $guests['guests'];

			}
			
			if ($reflectAdditional == 0) {
				
				$reflectAdditional = 1;
				
			}
			
			if ($calendarAccount['type'] == 'day') {
				
				if (is_array($services)) {
					
					foreach ((array) $services as $key => $service) {
						
						#$amount += intval($service['cost']) * $reflectService;
						$responseCostInService = $this->getCostsInService($calendarAccount, $service, $guestsList);
						$amount += $responseCostInService['totalCost'];
						foreach ((array) $service['options'] as $option) {
							
							if (intval($option['selected']) == 1) {
								
								#$amount += intval($option['cost']) * $reflectService;
								$responseCostInOption = $this->getCostsInService($calendarAccount, $option, $guestsList);
								$amount += $responseCostInOption['totalCost'];
								
							}
							
						}
						
					}
					
					$amount = $this->getDiscountCostByCoupon($coupon, $amount);
					
				}
				
				$taxes = $this->getTaxesDetailsForVisitor($bookingID, $amount);
				for ($i = 0; $i < count($taxes); $i++) {
					
					$tax = $taxes[$i];
					if ($tax['type'] == 'tax' && $tax['tax'] == 'tax_exclusive') {
						
						$amount += $tax['taxValue'];
						
					} else if ($tax['type'] == 'surcharge') {
						
						$amount += $tax['taxValue'] * $reflectAdditional;
						
					}
					
				}
				
				#$amount = $this->formatCost($amount, $currency);
				
			} else {
				
				#$amount = $this->formatCost((intval($accommodationDetails['accommodationFee']) + intval($accommodationDetails['taxesFee']) + intval($accommodationDetails['additionalFee'])), $currency);
				$amount = (intval($accommodationDetails['accommodationFee']) + intval($accommodationDetails['taxesFee']) + intval($accommodationDetails['additionalFee']));
				if (isset($accommodationDetails['personAmount']) && intval($accommodationDetails['personAmount']) > 0) {
					
					$amount = (intval($accommodationDetails['accommodationFee']) + intval($accommodationDetails['taxesFee']) + intval($accommodationDetails['personAmount']));
					
				}
				
				
			}
			
			return $amount;
			
		}
		
    	private function createEmailMessage($accountKey, $email_id, $form, $accommodationDetails, $options, $bookingID, $unixTime, $timestampForUnixTime, $cancellationUri, $currency = 'usd', $services = null, $payName = null, $payId = null, $scheduleTitle = null, $guests = null, $coupon = null){
			
			global $wpdb;
			
			if (empty($payName)) {
				
				$payName = __('I will pay locally', $this->pluginName);
				
			}
			
			$customerDetailsUrl = admin_url('admin.php?page=booking-package%2Findex.php&key=' . $bookingID . '&calendar=' . $accountKey . '&month=' . date('n', $unixTime) . '&day=' . date('j', $unixTime) . '&year=' . date('Y', $unixTime));
			
			$enableEmail = 0;
			$enableSMS = 0;
			$reflectAdditional = 1;
			$reflectAdditionalTitle = null;
			$reflectService = 1;
			$reflectServiceTitle = null;
			$guestsList = array();
			$positionTimeDate = get_option($this->prefix . "positionTimeDate", "dateTime");
			if (is_null($guests) === false && isset($guests['guests'])) {
				
				$reflectAdditional = intval($guests['reflectAdditional']);
				$reflectAdditionalTitle = $guests['reflectAdditionalTitle'];
				$reflectService = intval($guests['reflectService']);
				$reflectServiceTitle = $guests['reflectServiceTitle'];
				$guestsList = $guests['guests'];

			}
			
			if ($reflectAdditional == 0) {
				
				$reflectAdditional = 1;
				
			}
			
			
			$calendarAccount = $this->getCalendarAccount($accountKey);
			/**
			$to = $calendarAccount['email_to'];
			if (empty($to)) {
				
				$to = get_option($this->prefix . "email_to", null);
				
			}
			**/
			
			$to = get_option($this->prefix . "email_to", null);
			if (!empty($to) || !empty($calendarAccount['email_to'])) {
				
				#$to = explode(',', preg_replace("/( )/", "", $to));
				$to = explode(',', str_replace(" ", "", $to));
				$calendarToEmail = array();
				if (!empty($calendarAccount['email_to'])) {
					
					#$calendarToEmail = explode(',', preg_replace("/( )/", "", $calendarAccount['email_to']));
					$calendarToEmail = explode(',', str_replace(" ", "", $calendarAccount['email_to']));
					
				}
				$to_emails = array_merge($to, $calendarToEmail);
				$to_emails = array_values($to_emails);
				$to_emails = array_unique($to_emails);
				$to = implode(',', $to_emails);
				/**
				for ($i = 0; $i < count($calendarToEmail); $i++) {
					
					$key = array_search($calendarToEmail[$i], $to);
					if ($key !== false) {
						
						array_splice($to, $key, 1);
						
					}
					
				}
				$to = implode(',', $to);
				var_dump($to);
				**/
				
			}
			
			
			if (empty($to)) {
				
				$to = get_bloginfo('admin_email');
				
			}
			
			$from = $this->emailFormat(get_option($this->prefix . "email_from", null), get_option($this->prefix . "email_title_from", null));
			if (!empty($calendarAccount['email_from'])) {
				
				$from = $this->emailFormat($calendarAccount['email_from'], $calendarAccount['email_from_title']);
				
			}
			
			if (empty($from)) {
				
				$from = $this->emailFormat(get_bloginfo('admin_email'), get_bloginfo('name'));
				
			}
			
			$table_name = $wpdb->prefix."booking_package_emailSetting";
			for ($i = 0; $i < count($email_id); $i++) {
				
				$sql = $wpdb->prepare(
					"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `mail_id` = %s;", 
					array(intval($accountKey), $email_id[$i])
				);
				$row = $wpdb->get_row($sql, ARRAY_A);
				
				$emailSubject = $row['subject'];
				$emailBody = $row['content'];
				$emailFormat = $row['format'];
				$enableEmail = intval($row['enable']);
				$enableSMS = intval($row['enableSMS']);
				if (empty($row['subjectForAdmin'])) {
					
					$row['subjectForAdmin'] = $row['subject'];
					
				}
				
				if (empty($row['contentForAdmin'])) {
					
					$row['contentForAdmin'] = $row['content'];
					
				}
				
				#$emailDataValue = "Hello\nBooking Date: [date]\n\nSaasProject";
				$sendEamilList = array(
					'visitor' => array("subject" => $row['subject'], 'content' => $row['content']),
					'admin' => array("subject" => $row['subjectForAdmin'], 'content' => $row['contentForAdmin']),
				);
				
				if ($enableEmail == 0 && $enableSMS == 0) {
					
					return null;
					
				}
				
			}
			
			foreach ((array) $sendEamilList as $emailKey => $target) {
				
				$emailSubject = $target['subject'];
				$emailSubject = stripslashes($emailSubject);
				#$emailSubject = preg_replace('/\\\/u', "", $emailSubject);
				#$emailSubject = str_replace('\\', "", $emailSubject);
				$emailBody = $target['content'];
				#$emailBody = stripslashes($emailBody);
				#$emailBody = preg_replace('/\\\/u', "", $emailBody);
				#$emailBody = str_replace('\\', "", $emailBody);
				
				$emailBody = htmlspecialchars_decode($emailBody, ENT_QUOTES|ENT_HTML5);
				if ($emailFormat != "text") {
					
					$emailBody = str_replace(PHP_EOL, '', $emailBody);
					
				}
				/**
				if (preg_match('/(\[stop_email\])/', $emailBody, $matches)) {
					
					continue;
					
				}
				**/
				if (strpos($emailBody, '[stop_email]') !== false) {
					
					continue;
					
				}
				
				$emailData = array('subject' => $emailSubject, 'body' => $emailBody);
				foreach ((array) $emailData as $emailDataKey => $emailDataValue) {
					
					$site_name = get_option($this->prefix."site_name", "");
					$dateFormat = intval(get_option($this->prefix."dateFormat", 0));
					$positionOfWeek = get_option($this->prefix."positionOfWeek", "before");
					$date = $this->dateFormat($dateFormat, $positionOfWeek, $unixTime, $scheduleTitle, true, false, 'object');
					/**
					if (preg_match('/(\[date\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[date\])/', $date['date'] . $date['time'], $emailDataValue);
						
					}
					
					if (preg_match('/(\[bookingDateAndTime\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[bookingDateAndTime\])/', $date['date'] . $date['time'], $emailDataValue);
						
					}
					
					if (preg_match('/(\[bookingDate\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[bookingDate\])/', $date['date'], $emailDataValue);
						
					}
					
					if (preg_match('/(\[bookingTime\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[bookingTime\])/', $date['time'], $emailDataValue);
						
					}
					**/
					
					$emailDataValue = str_replace('[date]', $date['date'] . ' ' . $date['time'], $emailDataValue);
					
					$emailDataValue = str_replace('[bookingDate]', $date['date'], $emailDataValue);
					$emailDataValue = str_replace('[bookingTime]', $date['time'], $emailDataValue);
					$emailDataValue = str_replace('[bookingTitle]', $date['title'], $emailDataValue);
					
					if ($positionTimeDate == 'dateTime') {
						
						$emailDataValue = str_replace('[bookingDateAndTime]', $date['date'] . ', ' . $date['time'] . ' ' . $date['title'], $emailDataValue);
						
					} else {
						
						if (!empty($date['title'])) {
							
							$date['title'] = ' ' . $date['title'];
							
						}
						$emailDataValue = str_replace('[bookingDateAndTime]', $date['time'] . $date['title'] . ', ' . $date['date'], $emailDataValue);
						
					}
					
					
					$timestamp = $this->dateFormat($dateFormat, $positionOfWeek, $timestampForUnixTime, '', true, false, 'text');
					/**
					if (preg_match('/(\[receptionDate\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[receptionDate\])/', $timestamp, $emailDataValue);
						
					}
					**/
					$emailDataValue = str_replace('[receptionDate]', $timestamp, $emailDataValue);
					$emailDataValue = str_replace('[submissionDate]', $timestamp, $emailDataValue);
					/**
					if (preg_match('/(\[checkIn\])/', $emailDataValue, $matches)) {
						
						$checkInDate = $this->dateFormat($dateFormat, $positionOfWeek, $accommodationDetails['checkIn'], $scheduleTitle, false, false, 'text');
						$emailDataValue = preg_replace('/(\[checkIn\])/', $checkInDate, $emailDataValue);
						
					}
					**/
					
					if ($calendarAccount['type'] == 'hotel') {
						
						$checkInDate = $this->dateFormat($dateFormat, $positionOfWeek, $accommodationDetails['checkIn'], $scheduleTitle, false, false, 'text');
						$emailDataValue = str_replace('[checkIn]', $checkInDate, $emailDataValue);
						/**
						if (preg_match('/(\[checkOut\])/', $emailDataValue, $matches)) {
							
							$checkOutDate = $this->dateFormat($dateFormat, $positionOfWeek, $accommodationDetails['checkOut'], $scheduleTitle, false, false, 'text');
							$emailDataValue = preg_replace('/(\[checkOut\])/', $checkOutDate, $emailDataValue);
							
						}
						**/
						$checkOutDate = $this->dateFormat($dateFormat, $positionOfWeek, $accommodationDetails['checkOut'], $scheduleTitle, false, false, 'text');
						$emailDataValue = str_replace('[checkOut]', $checkOutDate, $emailDataValue);
						
						$detailsList = $this->bookingDetailsForHotel($accountKey, $accommodationDetails, $currency, 'array');
						$emailDataValue = str_replace('[bookingDetails]', implode("\n", $detailsList), $emailDataValue);
						
					}
					
					
					/**
					if (preg_match('/(\[totalPaymentAmount\])/', $emailDataValue, $matches)) {
						
						$amount = $this->getAmount($bookingID, $calendarAccount, $accommodationDetails, $services, $guests, $coupon);
						$amount = $this->formatCost($amount, $currency);
						$emailDataValue = preg_replace('/(\[totalPaymentAmount\])/', $amount, $emailDataValue);
						
					}
					**/
					$amount = $this->getAmount($bookingID, $calendarAccount, $accommodationDetails, $services, $guests, $coupon);
					$amount = $this->formatCost($amount, $currency);
					$emailDataValue = str_replace('[totalPaymentAmount]', $amount, $emailDataValue);
					$emailDataValue = str_replace('[totalAmount]', $amount, $emailDataValue);
					
					if (intval($calendarAccount['cancellationOfBooking']) == 1 && !is_null($cancellationUri)) {
						
						$emailDataValue = str_replace('[cancellationUri]', $cancellationUri, $emailDataValue);
						
					} else {
						
						$emailDataValue = str_replace('[cancellationUri]', "", $emailDataValue);
						
					}
					
					if (!empty($coupon) && is_array($coupon) && isset($coupon['key'])) {
						
						$emailDataValue = str_replace('[couponCode]', $coupon['id'], $emailDataValue);
						
					} else {
						
						$emailDataValue = str_replace('[couponCode]', __('None', $this->pluginName), $emailDataValue);
						
					}
					
					if (!empty($coupon) && is_array($coupon) && isset($coupon['key'])) {
						
						$emailDataValue = str_replace('[couponName]', $coupon['name'], $emailDataValue);
						
					} else {
						
						$emailDataValue = str_replace('[couponName]', __('None', $this->pluginName), $emailDataValue);
						
					}
					
					if (!empty($coupon) && is_array($coupon) && isset($coupon['key'])) {
						
						$discountValue = $this->formatCost($coupon['value'], $currency);
						if ($coupon['method'] == 'multiplication') {
							
							$discountValue = $coupon['value'] . '%';
							
						}
						
						$emailDataValue = str_replace('[couponDiscount]', $discountValue, $emailDataValue);
						
					} else {
						
						$emailDataValue = str_replace('[couponDiscount]', __('None', $this->pluginName), $emailDataValue);
						
					}
					
					if (isset($_POST['receivedUri'])) {
						
						$emailDataValue = str_replace('[receivedUri]', $_POST['receivedUri'], $emailDataValue);
						
					}
					
					$guestsDetails = array();
					if ($calendarAccount['type'] == 'hotel') {
						
						if (isset($accommodationDetails['rooms']) === false) {
							
							$accommodationDetails['rooms'] = array();
							
						}
						$rooms = $accommodationDetails['rooms'];
						if (is_null($rooms)) {
							
							$rooms = array();
							
						}
						
						if (count($rooms) > 0) {
							
							foreach ((array) $rooms as $roomKey => $room) {
								
								if (count($rooms) > 1) {
									
									array_push($guestsDetails, __('Room', $this->pluginName) . ': ' . ($roomKey + 1));
									
								}
								$guestsList = $room['guestsList'];
								foreach ((array) $guestsList as $key => $value) {
									
									$name = $value['name'];
									$guests = $value['json'];
									for ($i = 0; $i < count($guests); $i++) {
										
										if (intval($guests[$i]['selected']) == 1) {
											
											array_push($guestsDetails, $name.": ".$guests[$i]['name']);
											break;
											
										}
										
									}
									
								}
								
							}
							
						} else {
							
							$guestsList = $accommodationDetails['guestsList'];
							foreach ((array) $guestsList as $key => $value) {
								
								$name = $value['name'];
								$guests = $value['json'];
								for($i = 0; $i < count($guests); $i++){
									
									if (intval($guests[$i]['selected']) == 1) {
										
										array_push($guestsDetails, $name.": ".$guests[$i]['name']);
										break;
										
									}
									
								}
								
							}
							
						}
						
					} else if ($calendarAccount['type'] == 'day') {
						
						for ($i = 0; $i < count($guestsList); $i++) {
							
							$guest = $guestsList[$i];
							$index = intval($guest['index']);
							if ($index > 0) {
								
								array_push($guestsDetails, $guest['name'].": ".$guest['json'][$index]['name']);
								
							}
							
						}
						
					}
					
					$guestsDetails = implode("\n", $guestsDetails);
					$emailDataValue = str_replace('[guests]', $guestsDetails, $emailDataValue);
					/**
					if (preg_match('/(\[surcharges\])/', $emailDataValue, $matches)) {
						
						$surchargesDetails = array();
						$surcharges = $accommodationDetails['taxes'];
						#foreach ((array) $surcharges as $key => $tax) {
						for ($i = 0; $i < count($surcharges); $i++) {
							
							$tax = $surcharges[$i];
							if ($tax['type'] == 'surcharge' && $tax['active'] == 'true') {
								
								$cost = $this->formatCost($tax['taxValue'], $currency);
								$details = $tax['name'] . ' ' . $cost;
								if ($reflectAdditional > 1) {
									
									$details .= ' * ' . $reflectAdditionalTitle;
									
								}
								array_push($surchargesDetails, $details);
								
							}
							
						}
						$surchargesDetails = implode("\n", $surchargesDetails);
						$emailDataValue = preg_replace('/(\[surcharges\])/', $surchargesDetails, $emailDataValue);
						
					}
					**/
					$surchargesDetails = array();
					$surcharges = $accommodationDetails['taxes'];
					for ($i = 0; $i < count($surcharges); $i++) {
						
						$tax = $surcharges[$i];
						if ($tax['type'] == 'surcharge' && $tax['active'] == 'true') {
							
							$cost = $this->formatCost($tax['taxValue'], $currency);
							$details = $tax['name'] . ' ' . $cost;
							if ($reflectAdditional > 1) {
								
								$details .= ' * ' . $reflectAdditionalTitle;
								
							}
							array_push($surchargesDetails, $details);
							
						}
						
					}
					$surchargesDetails = implode("\n", $surchargesDetails);
					$emailDataValue = str_replace('[surcharges]', $surchargesDetails, $emailDataValue);
					/**
					if (preg_match('/(\[taxes\])/', $emailDataValue, $matches)) {
						
						$taxesDetails = array();
						$taxes = $accommodationDetails['taxes'];
						#foreach ((array) $taxes as $key => $tax) {
						for ($i = 0; $i < count($taxes); $i++) {
							
							$tax = $taxes[$i];
							if ($tax['type'] == 'tax' && $tax['active'] == 'true') {
								
								$cost = $this->formatCost($tax['taxValue'], $currency);
								array_push($taxesDetails, $tax['name'] . ' ' . $cost);
								
							}
							
						}
						$taxesDetails = implode("\n", $taxesDetails);
						$emailDataValue = preg_replace('/(\[taxes\])/', $taxesDetails, $emailDataValue);
						
					}
					**/
					$taxesDetails = array();
					$taxes = $accommodationDetails['taxes'];
					for ($i = 0; $i < count($taxes); $i++) {
						
						$tax = $taxes[$i];
						if ($tax['type'] == 'tax' && $tax['active'] == 'true') {
							
							$cost = $this->formatCost($tax['taxValue'], $currency);
							array_push($taxesDetails, $tax['name'] . ' ' . $cost);
							
						}
						
					}
					$taxesDetails = implode("\n", $taxesDetails);
					$emailDataValue = str_replace('[taxes]', $taxesDetails, $emailDataValue);
					/**
					if (preg_match('/(\[id\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[id\])/', $bookingID, $emailDataValue);
						
					}
					**/
					$emailDataValue = str_replace('[id]', $bookingID, $emailDataValue);
					/**
					if (preg_match('/(\[site_name\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[site_name\])/', $site_name, $emailDataValue);
						
					}
					**/
					$emailDataValue = str_replace('[site_name]', $site_name, $emailDataValue);
					/**
					if (preg_match('/(\[paymentMethod\])/', $emailDataValue, $matches)) {
						
						$payName = __("I will pay locally", $this->pluginName);
						if ($payId == 'stripe') {
							
							$payName = __("Pay with Credit Card", $this->pluginName);
							
						} else if ($payId == 'paypal') {
							
							$payName = __("Pay with PayPal", $this->pluginName);
							
						}
						
						$emailDataValue = preg_replace('/(\[paymentMethod\])/', $payName, $emailDataValue);
						
					}
					**/
					$payName = __("I will pay locally", $this->pluginName);
					if ($payId == 'stripe') {
						
						$payName = __("Pay with Credit Card", $this->pluginName);
						
					} else if ($payId == 'paypal') {
						
						$payName = __("Pay with PayPal", $this->pluginName);
						
					}
					$emailDataValue = str_replace('[paymentMethod]', $payName, $emailDataValue);
					/**
					if (!is_null($services)) {
						
						if (preg_match('/(\[service\])/', $emailDataValue, $matches)) {
							
							if (is_array($services)) {
								
								$detailsList = array();
								foreach ((array) $services as $key => $service) {
									
									$responseCostInService = $this->getCostsInService($calendarAccount, $service, $guestsList);
									$costs = $responseCostInService['costs'];
									$details = $service['name'];
									if (isset($costs[0]) && is_int(intval($costs[0])) === true && intval($responseCostInService['max']) != 0) {
										
										if ($responseCostInService['hasMultipleCosts'] === true) {
											
											$details .= ' ' . sprintf(__('%s to %s', $this->pluginName), $this->formatCost($responseCostInService['min'], $currency), $this->formatCost($responseCostInService['max'], $currency));
											
										} else {
											
											$details .= ' ' . $this->formatCost($costs[0], $currency);
											
										}
										
									} else {
										
									}
									
									if ($reflectService > 0) {
										
										foreach ($responseCostInService['guests'] as $guestsInServiceKey => $guestsInService) {
											
											if (isset($guestsInService['content'])) {
												
												$details .= "\n " . $guestsInService['content'];
												
											}
											
										}
										
									}
									
									array_push($detailsList, $details);
									
									$no = 0;
									foreach ((array) $service['options'] as $option) {
										
										if (intval($option['selected']) == 1) {
											
											$no++;
											$details = "#".$no." ".$option['name']." ";
											$responseCostInOption = $this->getCostsInService($calendarAccount, $option, $guestsList);
											$costs = $responseCostInOption['costs'];
											if (is_int(intval($costs[0])) === true && intval($costs[0]) != 0) {
												
												#$details .= $this->formatCost($option['cost'], $currency);
												if ($responseCostInOption['hasMultipleCosts'] === true) {
													
													$details .= ' ' . sprintf(__('%s to %s', $this->pluginName), $this->formatCost($responseCostInOption['min'], $currency), $this->formatCost($responseCostInOption['max'], $currency));
													
												} else {
													
													$details .= ' ' . $this->formatCost($costs[0], $currency);
													
												}
												
											}
											
											if ($reflectService > 0) {
												
												foreach ($responseCostInOption['guests'] as $guestsInServiceKey => $guestsInService) {
													
													if (isset($guestsInService['content'])) {
														
														$details .= "\n " . $guestsInService['content'];
														
													}
													
												}
												
											}
											
											array_push($detailsList, $details);
											
										}
										
									}
									
								}
								
								$emailDataValue = preg_replace('/(\[service\])/', implode("\n", $detailsList), $emailDataValue);
								
							} else {
								
								$emailDataValue = preg_replace('/(\[service\])/', $service, $emailDataValue);
								
							}
							
						}
					
					}
					**/
					if (!is_null($services)) {
						
						if (is_array($services)) {
							
							$detailsList = array();
							foreach ((array) $services as $key => $service) {
								
								$responseCostInService = $this->getCostsInService($calendarAccount, $service, $guestsList);
								$costs = $responseCostInService['costs'];
								$details = $service['name'];
								if (isset($costs[0]) && is_int(intval($costs[0])) === true && intval($responseCostInService['max']) != 0) {
									
									if ($responseCostInService['hasMultipleCosts'] === true) {
										
										$details .= ' ' . sprintf(__('%s to %s', $this->pluginName), $this->formatCost($responseCostInService['min'], $currency), $this->formatCost($responseCostInService['max'], $currency));
										
									} else {
										
										$details .= ' ' . $this->formatCost($costs[0], $currency);
										
									}
									
								} else {
									
								}
								
								if ($reflectService > 0) {
									
									foreach ($responseCostInService['guests'] as $guestsInServiceKey => $guestsInService) {
										
										if (isset($guestsInService['content'])) {
											
											$details .= "\n " . $guestsInService['content'];
											
										}
										
									}
									
								}
								
								array_push($detailsList, $details);
								
								$no = 0;
								foreach ((array) $service['options'] as $option) {
									
									if (intval($option['selected']) == 1) {
										
										$no++;
										$details = "#".$no." ".$option['name']." ";
										$responseCostInOption = $this->getCostsInService($calendarAccount, $option, $guestsList);
										$costs = $responseCostInOption['costs'];
										if (is_int(intval($costs[0])) === true && intval($costs[0]) != 0) {
											
											#$details .= $this->formatCost($option['cost'], $currency);
											if ($responseCostInOption['hasMultipleCosts'] === true) {
												
												$details .= ' ' . sprintf(__('%s to %s', $this->pluginName), $this->formatCost($responseCostInOption['min'], $currency), $this->formatCost($responseCostInOption['max'], $currency));
												
											} else {
												
												$details .= ' ' . $this->formatCost($costs[0], $currency);
												
											}
											
										}
										
										if ($reflectService > 0) {
											
											foreach ($responseCostInOption['guests'] as $guestsInServiceKey => $guestsInService) {
												
												if (isset($guestsInService['content'])) {
													
													$details .= "\n " . $guestsInService['content'];
													
												}
												
											}
											
										}
										
										array_push($detailsList, $details);
										
									}
									
								}
								
							}
							
							$emailDataValue = str_replace('[service]', implode("\n", $detailsList), $emailDataValue);
							
						} else {
							
							$emailDataValue = str_replace('[service]', $service, $emailDataValue);
							
						}
					
					}
					
					$visitorEmail = array();
					$visitorSMS = array();
					$content = "";
					for ($i = 0; $i < count($form); $i++) {
						
						if ($form[$i]['active'] == '') {
							
							continue;
							
						}
						
						$value = $form[$i]['value'];
						if (is_array($value)) {
							
							$value = implode("\r\n", $form[$i]['value']);
							
						}
						
						if ($emailFormat == "text") {
							
							$content .= $form[$i]['name'] . "\r\n" . $value . "\r\n";
							
						} else {
							
							$content .= '<div style="width: 100%; display: table;"><div style="width: 30%; display: table-cell; vertical-align: middle;">' . $form[$i]['name'] . '</div><div style="width: 70%; display: table-cell; vertical-align: middle;">' . $value . '</div></div>';
							#$content .= '<div style="width: 30%; display: table-cell; vertical-align: middle;">'.$form[$i]['name'].'</div><div style="width: 70%; display: table-cell; vertical-align: middle;">'.$form[$i]['value'].'</div>';
							
						}
						
						if ($form[$i]['isEmail'] == 'true' && !empty($form[$i]['value'])) {
							
							array_push($visitorEmail, $form[$i]['value']);
							
						}
						
						if (isset($form[$i]['isSMS']) && $form[$i]['isSMS'] == 'true' && !empty($form[$i]['value'])) {
							
							array_push($visitorSMS, $form[$i]['value']);
							
						}
						
					}
					/**
					if (preg_match('/(\[content\])/', $emailDataValue, $matches)) {
						
						$emailDataValue = preg_replace('/(\[content\])/', $content, $emailDataValue);
						
					}
					**/
					$emailDataValue = str_replace('[customerDetails]', $content, $emailDataValue);
					/**
					for($i = 0; $i < count($form); $i++){
						
						$id = '\['.$form[$i]['id'].'\]';
						$value = $form[$i]['value'];
						if (is_array($value)) {
							
							$value = implode("\r\n", $form[$i]['value']);
							
						}
						
						if (preg_match('/('.$id.')/', $emailDataValue, $matches)) {
							
							$emailDataValue = preg_replace('/('.$id.')/', $value, $emailDataValue);
							
						}
						
					}
					**/
					for($i = 0; $i < count($form); $i++){
						
						$id = '[' . $form[$i]['id'] . ']';
						$value = $form[$i]['value'];
						if (is_array($value)) {
							
							$value = implode("\r\n", $form[$i]['value']);
							
						}
						
						$emailDataValue = str_replace($id, $value, $emailDataValue);
						
					}
					
					if ($emailDataKey == 'body' && $emailKey == 'admin' && $email_id != 'mail_deleted') {
						
						//$emailDataValue .= "Customer details\n" . $customerDetailsUrl;
						$emailDataValue = str_replace('[customerDetailsUrl]', $customerDetailsUrl, $emailDataValue);
						
					}
					
					$emailDataValue = stripslashes($emailDataValue);
					
					if ($emailDataKey == 'subject') {
						
						$emailSubject = $emailDataValue;
						
					} else {
						
						$emailBody = $emailDataValue;
						
					}
					
					
					
				}
				unset($emailDataValue);
				//$emailSubject = $emailData['subject'];
				$emailSubject = str_replace(array("\r\n", "\r", "\n"), '', $emailSubject);
				//$emailBody = $emailData['body'];
				
				$headers = array("From: ".$from."\r\n", "Return-Path: ".$from."\r\n", "Reply-To: ".$from."\r\n");
				#$headers = array("From: " . $from . "\r\n", "Reply-To: " . $from . "\r\n");
				if ($emailFormat == "text") {
					
					$emailBody = strip_tags($emailBody);
					
				} else {
					
					array_push($headers, "Content-Type: text/html; charset=UTF-8");
					$bodyStyle = 'word-wrap: break-word; white-space: pre;';
					$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
					$header .= '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Booking email</title></head>';
					$header .= '<body style="'.$bodyStyle.'">';
					#$emailBody = $header.$emailBody."</body></html>";
					
				}
				
				$responseList = array('body' => $emailBody, 'to' => $to, 'from' => $from, 'sendVisitor' => null, 'headers' => $headers, 'visitorEmail' => $visitorEmail, 'response' => array(), 'params' => array(), 'enabledSMS' => $enableSMS);
				if (function_exists('mb_language')) {
					
					mb_language("uni");
					
				}
				
				if (function_exists('mb_internal_encoding')) {
					
					mb_internal_encoding("UTF-8");
					
				}
				
				$mailgun_active = intval(get_option($this->prefix."mailgun_active", 0));
				if ($enableEmail == 1) {
					
					if ($mailgun_active == 1) {
						
						$mailgun_aip_base_url = get_option($this->prefix."mailgun_aip_base_url", 0);
						$mailgun_api_key = get_option($this->prefix."mailgun_api_key", 0);
						//$mailgun_password = get_option($this->prefix."mailgun_password", 0);
						
						$params = array('from' => $from, 'to' => implode(",", $visitorEmail), 'subject' => $emailSubject);
						if ($emailFormat == "text") {
							
							$params['text'] = $emailBody;
							
						} else {
							
							$params['html'] = $emailBody;
							
						}
						$responseList['params']['visitor'] = $params;
						if (count($visitorEmail) != 0 && $emailKey == 'visitor') {
							
							$paramsQuery = http_build_query($params);
							#$params = json_encode($params);
							$context = array(
								'http' => array(
									'method' => 'POST', 
									'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
									"Content-Length: ".strlen($paramsQuery)."\r\n".
									"User-Agent: PHP\r\n".
									"Host: api.mailgun.net\r\n".
									"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
									'content' => $paramsQuery
								)
							);
							
							$context = stream_context_create($context);
							$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
							$responseList['response']['visitor'] = $response;
							
						} else if ($emailKey == 'admin') {
							
							if (!empty($to)) {
								
								$params['to'] = $to;
								$responseList['params']['admin'] = $params;
								$paramsQuery = http_build_query($params);
								$context = array(
									'http' => array(
										'method' => 'POST', 
										'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
										"Content-Length: ".strlen($paramsQuery)."\r\n".
										"User-Agent: PHP\r\n".
										"Host: api.mailgun.net\r\n".
										"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
										'content' => $paramsQuery
									)
								);
								
								$context = stream_context_create($context);
								$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
								$responseList['response']['admin'] = $response;
								
							}
							/**
							if (!empty($calendarAccount['email_to'])) {
								
								$params['to'] = $calendarAccount['email_to'];
								$responseList['params']['calendarAccount'] = $params;
								$paramsQuery = http_build_query($params);
								$context = array(
									'http' => array(
										'method' => 'POST', 
										'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
										"Content-Length: ".strlen($paramsQuery)."\r\n".
										"User-Agent: PHP\r\n".
										"Host: api.mailgun.net\r\n".
										"Authorization: Basic ".base64_encode("api:".$mailgun_api_key),
										'content' => $paramsQuery
									)
								);
								
								$context = stream_context_create($context);
								$response = file_get_contents($mailgun_aip_base_url.'/messages', false, $context);
								$responseList['response']['calendarAccount'] = $response;
								
							}
							**/
						}
						
					} else {
						
						$sendVisitor = false;
						if (count($visitorEmail) != 0 && $emailKey == 'visitor') {
							
							$sendVisitor = wp_mail($visitorEmail, $emailSubject, $emailBody, $headers);
							$responseList['sendVisitor'] = $sendVisitor;
							
						} else if ($emailKey == 'admin') {
							
							if (!empty($to)) {
								
								$sendControl = wp_mail($to, $emailSubject, $emailBody, $headers);
								$responseList['sendControl'] = $sendControl;
								
							}
							/**
							if (!empty($calendarAccount['email_to'])) {
								
								$sendAccount = wp_mail($calendarAccount['email_to'], $emailSubject, $emailBody, $headers);
								$responseList['sendAccount'] = $sendAccount;
								
							}
							**/
						}
						
					}
					
				}
				$responseList['mailgun_active'] = $mailgun_active;
				if ($enableSMS == 1 && $emailKey == 'visitor') {
					
					$responseList['twilioSMS'] = $this->twilioSMS($visitorSMS, $emailBody);
					
				}
				
			}
			
			return $responseList;
			
		}
		
		private function twilioSMS($visitorSMS, $body) {
			
			$isExtensionsValid = $this->getExtensionsValid(false);
			if ($isExtensionsValid === false) {
				
				return false;
				
			} else {
				
				$body = str_replace(PHP_EOL, "\n", $body);
				
				$twilio_active = get_option($this->prefix . "twilio_active", 0);
				$twilio_sendingMethod = get_option($this->prefix . "twilio_sendingMethod", "phoneNumber");
				$twilio_sid = get_option($this->prefix . "twilio_sid", null);
				$twilio_service_sid = get_option($this->prefix . "twilio_service_sid", null);
				$twilio_token = get_option($this->prefix . "twilio_token", null);
				$twilio_countryCode = get_option($this->prefix . "twilio_countryCode", '');
				$twilio_number = get_option($this->prefix . "twilio_number", null);
				if (intval($twilio_active) == 1 && !empty($twilio_sid) && !empty($twilio_token)) {
					
					for ($i = 0; $i < count($visitorSMS); $i++) {
						
						$phoneNumber = $twilio_countryCode . $visitorSMS[$i];
						if (preg_match( '/^\+/', $visitorSMS[$i])) {
							
							$phoneNumber = $visitorSMS[$i];
							
						}
						$phoneNumber = preg_replace('/[- ()]/', '', $phoneNumber);
						
						$send = true;
						$params = array();
						if ($twilio_sendingMethod == 'phoneNumber' && !empty($twilio_number)) {
							
							$twilio_number = preg_replace('/[- ()]/', '', $twilio_number);
							$params = array('Body' => $body, 'From' => $twilio_number, 'To' => $phoneNumber);
							
						} else if ($twilio_sendingMethod == 'senderID') {
							
							$params = array('Body' => $body, 'To' => $phoneNumber, 'MessagingServiceSid' => $twilio_service_sid);
							
						} else {
							
							$send = false;
							
						}
						
						if ($send === true) {
							
							$args = array(
								'method' => 'POST',
								'body' => $params,
								'headers' => array(
									'Authorization' => 'Basic ' . base64_encode($twilio_sid . ':' . $twilio_token)
								)
							);
							$response = wp_remote_request("https://api.twilio.com/2010-04-01/Accounts/". $twilio_sid . "/Messages.json", $args);
							$statusCode = wp_remote_retrieve_response_code($response);
            				$response = json_decode(wp_remote_retrieve_body($response), true);
							
							/**
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, "https://api.twilio.com/2010-04-01/Accounts/" . $twilio_sid . "/Messages.json");
							curl_setopt($ch, CURLOPT_USERPWD, $twilio_sid . ":" . $twilio_token);
							curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
							curl_setopt($ch, CURLOPT_POST, 1);
							
							ob_start();
							$response = curl_exec($ch);
							$response = ob_get_contents();
							ob_end_clean();
							$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close ($ch);
						    $response = json_decode($response, true);
							**/
							
						} else {
							
							#return false;
							
						}
						
					}
					
					return true;
					
				} else {
					
					return false;
					
				}
				
			}
			
		}
		
		public function sendMail($user_email, $subject, $body, $emailFormat = 'text', $accountKey = null){
			
			$to = get_option($this->prefix."email_to", null);
			$from = $this->emailFormat(get_option($this->prefix . "email_from", null), get_option($this->prefix . "email_title_from", null));
			
			if (!is_null($accountKey)) {
				
				$calendarAccount = $this->getCalendarAccount($accountKey);
				if (!empty($calendarAccount['email_to'])) {
					
					$to = $calendarAccount['email_to'];
					
				}
				
				if (!empty($calendarAccount['email_from'])) {
					
					$from = $this->emailFormat($calendarAccount['email_from'], $calendarAccount['email_from_title']);
					
				}
				
			}
			
			if (empty($to)) {
				
				$to = get_bloginfo('admin_email');
				
			}
			
			if (empty($from)) {
				
				$from = $this->emailFormat(get_bloginfo('admin_email'), get_bloginfo('name'));
				
			}
			
			$headers = array("From: ".$from."\r\n", "Return-Path: ".$from."\r\n", "Reply-To: ".$from."\r\n");
			#$headers = array("From: " . $from . "\r\n", "Reply-To: " . $from . "\r\n");
			$responseList = array('body' => $body, 'to' => $to, 'from' => $from, 'sendVisitor' => null, 'headers' => $headers, 'visitorEmail' => null, 'response' => array(), 'params' => array());
			
			if (function_exists('mb_language')) {
				
				mb_language("uni");
				
			}
			
			if (function_exists('mb_internal_encoding')) {
				
				mb_internal_encoding("UTF-8");
				
			}
			
			//$emailFormat = get_option($this->prefix."mail_approved_format", null);
			$mailgun_active = intval(get_option($this->prefix."mailgun_active", 0));
			if ($mailgun_active == 1) {
				
				$mailgun_aip_base_url = get_option($this->prefix."mailgun_aip_base_url", 0);
				$mailgun_api_key = get_option($this->prefix."mailgun_api_key", 0);
				//$mailgun_password = get_option($this->prefix."mailgun_password", 0);
				#var_dump($mailgun_api_key);
				
				$params = array('from' => $from, 'to' => $user_email, 'subject' => $subject);
				if ($emailFormat == "text") {
					
					$body = strip_tags($body);
					$params['text'] = $body;
					
				} else {
					
					array_push($headers, "Content-Type: text/html; charset=UTF-8");
					#$bodyStyle = 'word-wrap: break-word; white-space: pre;';
					#$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
					#$header .= '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Booking email</title></head>';
					#$header .= '<body style="'.$bodyStyle.'">';
					#$body = $header.$body."</body></html>";
					$params['html'] = $body;
					
				}
				$responseList['params']['visitor'] = $params;
				
				$args = array(
					'method' => 'POST',
					'body' => $params,
					'headers' => array(
						'Authorization' => 'Basic ' . base64_encode('api:' . $mailgun_api_key)
					)
				);
				$response = wp_remote_request($mailgun_aip_base_url . '/messages', $args);
				$statusCode = wp_remote_retrieve_response_code($response);
				$response = json_decode(wp_remote_retrieve_body($response), true);
				$responseList['response']['visitor'] = $response;
				
			} else {
				
				$sendVisitor = false;
				$sendVisitor = wp_mail($user_email, $subject, $body, $headers);
				$responseList['sendVisitor'] = $sendVisitor;
				
			}
			
			$responseList['mailgun_active'] = $mailgun_active;
			return $responseList;
			
		}
		
		
		
		public function scriptError($errors) {
			
			global $wpdb;
			$params = array();
			$date = date('U') - (1440 * 60);
			
			$table_name = $wpdb->prefix . "booking_package_error";
			$sql = $wpdb->prepare(
                "SELECT `key` FROM `" . $table_name . "` WHERE `date` > %d AND `message` = %s;", 
                array(intval($date), sanitize_textarea_field($errors['msg']))
            );
			$row = $wpdb->get_row($sql, ARRAY_A);
			
			if (is_null($row)) {
				
				$wpdb->insert(
                    $table_name, 
                    array(
                        'file' => sanitize_text_field($errors['file']), 
                        'url' => sanitize_text_field($errors['url']), 
                        'line' => intval($errors['line']), 
                        'col' => intval($errors['col']), 
                        'code' => sanitize_text_field($errors['code']), 
                        'version' => sanitize_text_field($errors['version']), 
                        'browser' => sanitize_text_field($errors['browser']), 
                        'message' => sanitize_textarea_field($errors['msg']), 
                        'date' => intval(date('U')),
                    ), 
                    array('%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%d')
                );
				
				$url = BOOKING_PACKAGE_EXTENSION_URL;
				$response = array('status' => 'success', 'url' => $url);
				
				$params = array(
					'mode' => 'scriptError',
					'type' => sanitize_text_field($errors['type']), 
					'url' => sanitize_text_field($errors['url']), 
					'file' => sanitize_text_field($errors['file']), 
					'msg' => sanitize_text_field($errors['msg']),
					'line' => sanitize_text_field($errors['line']), 
					'col' => sanitize_text_field($errors['col']),
					'version' => sanitize_text_field($errors['version']),
					'code' => sanitize_text_field($errors['code']),
					'browser' => sanitize_text_field($errors['browser']),
					'source' => sanitize_text_field($errors['source']),
					'page' => $errors['page'],
					'error' => $errors['error'],
				);
				
				if (isset($errors['responseText'])) {
					
					$params['responseText'] = $errors['responseText'];
					
				}
				
				if (isset($params['message'])) {
					
					$params['msg'] = sanitize_text_field($errors['message']);
					
				}
				
				if (isset($errors['name'])) {
					
					$params['name'] = sanitize_text_field($errors['name']);
					
				}
				
				if (isset($errors['values'])) {
					
					$params['values'] = sanitize_text_field($errors['values']);
					
				}
				
				if (intval($params['line']) > 0 && empty($params['file']) === false) {
					
					$response['params'] = $params;
					
					$args = array(
	                    'method' => 'POST',
	                    'body' => $params
	                );
	                $response = wp_remote_request("https://saasproject.net/lib/scriptError.php", $args);
	                $statusCode = wp_remote_retrieve_response_code($response);
					$response = json_decode(wp_remote_retrieve_body($response), true);
					$params['sendStatus'] = true;
					
				}
				
			} else {
				
				$params['sendStatus'] = false;
				
			}
			
    		return $params;
    		
    	}
    	
    	public function changeMaxAccountScheduleDay(){
    		
			global $wpdb;
			$maxAccountScheduleDay = get_option($this->prefix."maxAccountScheduleDay", 14);
			$unavailableDaysFromToday = get_option($this->prefix."unavailableDaysFromToday", 1);
			
        	$table_name = $wpdb->prefix."booking_package_calendarAccount";
			#$sql = $wpdb->prepare("SELECT * FROM `".$table_name."`;", array());
			$rows = $wpdb->get_results("SELECT * FROM `".$table_name."`;", ARRAY_A);
			foreach ((array) $rows as $row) {
				
				$bool = $wpdb->update(
					$table_name,
					array(
						'maxAccountScheduleDay' => intval($maxAccountScheduleDay),
						'unavailableDaysFromToday' => intval($unavailableDaysFromToday),
					),
					array('key' => intval($row['key'])),
					array('%d', '%d'),
					array('%d')
				);
				
			}
    		
    	}
        
		public function booking_notification() {
			
			global $wpdb;
			$calendarAccountList = $this->getCalendarAccountListData();
			for ($i = 0; $i < count($calendarAccountList); $i++) {
				
				$calendarAccount = $calendarAccountList[$i];
				if ($calendarAccount['status'] != 'open') {
					
					continue;
					
				}
				
				date_default_timezone_set($calendarAccount['timezone']);
				$unixTime = date('U') + $calendarAccount['bookingReminder'] * 60;
				$month = date('m', $unixTime);
				$day = date('d', $unixTime);
				$year = date('Y', $unixTime);
				$hour = date('H', $unixTime);
				
				$table_name = $wpdb->prefix . "booking_package_emailSetting";
				$sql = $wpdb->prepare(
					"SELECT * FROM ".$table_name." WHERE `accountKey` = %d AND `mail_id` = %s;", 
					array(intval($calendarAccount['key']), 'mail_reminder')
				);
				$row = $wpdb->get_row($sql, ARRAY_A);
				if (!empty($row) && intval($row['enable']) == 0 && intval($row['enableSMS']) == 0) {
					
					continue;
					
				}
				
				$table_name = $wpdb->prefix . "booking_package_userPraivateData";
				$sql = $wpdb->prepare(
					"SELECT * FROM `".$table_name."` WHERE `status` = 'approved' AND `bookingReminder` = 0 AND `accountKey` = %d AND `scheduleUnixTime` >= %d AND `scheduleUnixTime` <= %d;", 
					array(
						intval($calendarAccount['key']),
						intval(mktime($hour, 0, 0, $month, $day, $year)),
						intval(mktime($hour, 59, 59, $month, $day, $year)),
					)
				);
				$rows = $wpdb->get_results($sql, ARRAY_A);
				if (!is_null($rows)) {
					
					foreach ((array) $rows as $row) {
						
						#var_dump($row);
						$form = json_decode($row['praivateData'], true);
						$options = json_decode($row['options'], true);
						$coupon = null;
						if (isset($row['coupon']) && !empty($row['coupon'])) {
							
							$coupon = json_decode($row['coupon'], true);
							
						}
						
						$accommodationDetails = array();
						if ($calendarAccount['type'] == 'hotel') {
							
							$accommodationDetails = json_decode($row['accommodationDetails'], true);
							
						} else {
							
							$accommodationDetails['taxes'] = json_decode($row['taxes'], true);
							
						}
						
						#$responseGuests = json_decode($row['guests'], true);
						$responseGuests = $this->jsonDecodeForGuests($row['guests']);
						$servicesDetails = $this->getSelectedServices($calendarAccount, json_decode($row['options'], true), $responseGuests['guests'], "options", $coupon, $row['applicantCount']);
						$services = $servicesDetails['object'];
						
						$cancellationUri = null;
						if (!empty($row['permalink']) && !empty($row['cancellationToken'])) {
							
							$cancellationUri = $this->getCancellationUri($row['permalink'], $row['key'], $row['cancellationToken']);
							
						}
						
						$email = $this->createEmailMessage($calendarAccount['key'], array('mail_reminder'), $form, $accommodationDetails, $options, intval($row['key']), intval($row['scheduleUnixTime']), intval($row['reserveTime']), $cancellationUri, $row['currency'], $services, $row['payName'], $row['payId'], $row['scheduleTitle'], $responseGuests, $coupon);
						
						$wpdb->query("START TRANSACTION");
						$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
						try {
							
							$bool = $wpdb->update(
								$table_name,
								array('bookingReminder' => 1),
								array('key' => intval($row['key'])),
								array('%d'),
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
					
				}
				
			}
			
		}
		
		private function jsonDecodeForGuests($json) {
			
			$responseGuests = json_decode($json, true);
			if (isset($responseGuests['guests']) === false) {
				
				$responseGuests['guests'] = null;
				
			}
			
			return $responseGuests;
			
		}
		
		public function deleteCustomers() {
			
			$period = get_option($this->prefix . 'dataRetentionPeriod', 0);
			if (intval($period) <= 0) {
				
				return null;
				
			}
			
			$periodUnixTime = date('U') - ($period * 1440 * 60);
			
			global $wpdb;
			$table_name = $wpdb->prefix . "booking_package_userPraivateData";
			$wpdb->query("START TRANSACTION");
			$wpdb->query("LOCK TABLES `" . $table_name . "` WRITE");
			try {
				
				$sql = $wpdb->prepare(
					"DELETE FROM `" . $table_name . "` WHERE `scheduleUnixTime` <= %d;", 
					array(intval($periodUnixTime))
				);
				$wpdb->query($sql);
				$wpdb->query('COMMIT');
				$wpdb->query('UNLOCK TABLES');
				
			} catch (Exception $e) {
				
				$wpdb->query('ROLLBACK');
				$wpdb->query('UNLOCK TABLES');
				
			}/** finally {
				
				$wpdb->query('UNLOCK TABLES');
				
			}**/
			
		}
		
		public function getOnlyNumbers($value) {
			
			if (function_exists('mb_convert_kana')) {
                
                $value = mb_convert_kana($value, 'n');
                
            }
            $value = preg_replace('/[^0-9]/', '', $value);
            return $value;
		    
		}
        
    }
    
    
    
    
    
    
?>