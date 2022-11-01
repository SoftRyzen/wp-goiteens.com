/* globals Booking_App_XMLHttp */
/* globals scriptError */
/* globals Booking_App_Calendar */
/* globals FORMAT_COST */
/* globals Booking_Package_Console */
/* globals Booking_Package_Input */

var setting_data = setting_data;
var booking_package_dictionary = booking_package_dictionary;

window.addEventListener('load', function(){
	
	if(setting_data != null && booking_package_dictionary != null){
    	
    	var setting = new SETTING(setting_data, booking_package_dictionary, false);
    	setting.loadTabFrame();
    	
    }
	
});

window.addEventListener('error', function(event) {
    
    var error = new scriptError(setting_data, booking_package_dictionary, event.message, event.filename, event.lineno, event.colno, event.error);
    error.send();
    
}, false);

/**
window.onerror = function(msg, url, line, col, error){
    
    var error = new scriptError(setting_data, booking_package_dictionary, msg, url, line, col, error);
    error.send();
    
}
**/

function SETTING(setting_data, booking_package_dictionary, webApp) {
	
	var object = this;
    this._debug = new Booking_Package_Console(setting_data.debug);
    this._console = {};
    this._console.log = this._debug.getConsoleLog();
	this._webApp = webApp;
	this._setting_data = setting_data;
	this._url = setting_data['url'];
	this._nonce = setting_data['nonce'];
	this._action = setting_data['action'];
	this._settingList = setting_data['list'];
	this._bookingSyncList = setting_data['bookingSyncList'];
	this._isExtensionsValid = parseInt(setting_data.isExtensionsValid);
	this._siteToken = setting_data.siteToken;
	this._startOfWeek = setting_data.startOfWeek;
	this._function = {name: "root", post: {}};
	this._url = setting_data['url'];
	this._is_owner_site = parseInt(setting_data.is_owner_site);
	this._countCssPanel = 0;
	this._countJavascriptPanel = 0;
	this._jsEditor = null;
	this._tab = null;
	this._prefix = setting_data.prefix;
	if (setting_data.tab != null) {
		
		this._tab = setting_data.tab;
		
	}
	
	object._console.log(setting_data);
	
	this._i18n = new I18n(setting_data.locale);
	this._i18n.setDictionary(booking_package_dictionary);
	
	this._blockPanel = document.getElementById("blockPanel");
	this._editPanel = document.getElementById("editPanel");
	this._loadingPanel = document.getElementById("loadingPanel");
	
	
	this._timezoneGroup = document.getElementById("timezone_choice").getElementsByTagName("optgroup");
	this._timezoneGroup = [].slice.call(this._timezoneGroup);
	this._timezoneGroup.pop();
	this._timezoneOptions = document.getElementById("timezone_choice").getElementsByTagName("option");
	
	/**
	this._jsEditor = CodeMirror.fromTextArea(
		document.getElementById("css"), 
		{
			mode: "css",
			lineNumbers: true,
			indentUnit: 4,
		});
	**/
	
	this._blockPanel.onclick = function(){
    	
    	this.editPanelShow(false);
    	
	}
	
	document.getElementById("media_modal_close").onclick = function(){
    	
    	this.editPanelShow(false);
    
	}
	
	this.setFunction = function(name, post){
        
        this._function = {name: name, post: post};
        
    }
    
    this.getFunction = function(){
        
        return this._function;
        
    }
	
	this.loadTabFrame = function(){
		
		var object = this;
		
		
		var menuList = {settingLink: 'settingPanel', holidayLink: 'holidayPanel', nationalHolidayLink: 'nationalHolidayPanel', blockEmailListsLink: 'blockEmailListsPanel', memberLink: "memberPanel", /**formLink: 'formPanel', courseLink: 'coursePanel', emailLink: 'emailPanel',**/ syncLink: "syncPanel", cssLink: "cssPanel", javascriptLink: "javascriptPanel", subscriptionLink: 'subscriptionPanel'};
		
		if (object._is_owner_site == 0) {
			
			delete menuList.subscriptionLink;
			object._tab = null;
			var subscriptionLink = document.getElementById("subscriptionLink");
			subscriptionLink.textContent = null;
			subscriptionLink.setAttribute("class", "");
			
		}
		
		object.createSettingPanel();
		if (object._tab == 'subscriptionLink') {
			
			object.subscriptionDiteilPanel();
			document.getElementById('settingLink').setAttribute('class', 'menuItem');
			document.getElementById('settingPanel').setAttribute('class', 'hidden_panel');
			document.getElementById('subscriptionLink').setAttribute('class', 'menuItem active');
			document.getElementById('subscriptionPanel').classList.remove('hidden_panel');
			
		}
		
		for(var key in menuList){
			
			var button = document.getElementById(key);
			button.classList.remove("hidden_panel");
			button.setAttribute("data-key", key);
			button.onclick = function(event){
				
				var clickKey = this.getAttribute("data-key");
				object._console.log(clickKey);
				for(var key in menuList){
					
					var link = document.getElementById(key);
					var panel = document.getElementById(menuList[key]);
					if (clickKey == key) {
						
						link.setAttribute("class", "menuItem active");
						panel.setAttribute("class", "");
						
						if (clickKey == 'formLink') {
							
							object.createFormPanel();
							
						} else if (clickKey == 'courseLink') {
							
							object.createCoursePanel();
							
						} else if (clickKey == 'emailLink') {
							
							object.emailSettingPanel();
							
						} else if (clickKey == 'subscriptionLink') {
							
							object.subscriptionDiteilPanel();
							
						} else if (clickKey == 'syncLink') {
							
							object.syncPanel();
							
						} else if (clickKey == 'memberLink') {
							
							object.memberPanel();
							
						} else if (clickKey == 'holidayLink') {
							
							object.holidayPanel("share");
							
						} else if (clickKey == 'nationalHolidayLink') {
							
							object.holidayPanel("national");
							
						} else if (clickKey == 'cssLink') {
							
							object.cssPanel();
							
						} else if (clickKey == 'javascriptLink') {
							
							object.javascriptPanel();
							
						} else if (clickKey == 'blockEmailListsLink') {
							
							
							var loadingPanel = document.getElementById("loadingPanel");
							loadingPanel.classList.remove("hidden_panel");
							var postData = {mode: "getBlockEmailLists", nonce: object._nonce, action: object._action};
							var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
								
								object._console.log(json);
								object.blockEmailListsPanel(json);
								loadingPanel.classList.add("hidden_panel");
								
							});
							
						}
						
					}else{
						
						link.setAttribute("class", "menuItem");
						panel.setAttribute("class", "hidden_panel");
						
					}
					
				}
				
			}
			
		}
		
	}
	
	this.subscriptionDiteilPanel = function(){
		
		var object = this;
		//var upgrade = new Upgrade();
		object._console.log(object._setting_data.customer_id_for_subscriptions);
		object._console.log(object._setting_data.id_for_subscriptions);
		object._loadingPanel.classList.add("hidden_panel");
		var showBool = true;
		if (object._setting_data.customer_id_for_subscriptions == null && object._setting_data.id_for_subscriptions == null) {
			
			showBool = false;
			
		}
		/**
		if (
			parseInt(object._setting_data.customer_id_for_subscriptions) == 0 &&
			parseInt(object._setting_data.id_for_subscriptions) == 0
		) {
			
			showBool = false;
			
		}
		**/
		
		var subscriptionData = {
			customer_id_for_subscriptions: object._setting_data.customer_id_for_subscriptions,
			id_for_subscriptions: object._setting_data.id_for_subscriptions,
			/** invoice_id_for_subscriptions: object._setting_data.invoice_id_for_subscriptions, **/
			expiration_date_for_subscriptions: object._setting_data.expiration_date_for_subscriptions,
			expiration_date: object._setting_data.expiration_date,
			customer_email_for_subscriptions: object._setting_data.customer_email_for_subscriptions
		};
		
		var nameList = {
			customer_id_for_subscriptions: object._i18n.get("ID"),
			id_for_subscriptions: object._i18n.get("Subscription ID"),
			customer_email_for_subscriptions: object._i18n.get("Your email"),
			expiration_date: object._i18n.get("Expiration date"),
			
		};
		object._console.log(subscriptionData);
		
		var subscriptionPanel = document.getElementById("subscriptionPanel");
		subscriptionPanel.textContent = null;
		
		var table = document.createElement("table");
		table.id = "subscriptionTable";
		table.setAttribute("class", "emails_table table_option wp-list-table widefat fixed striped")
		subscriptionPanel.appendChild(table);
		
		for (var key in nameList) {
			
			var nameTh = document.createElement("th");
			nameTh.textContent = nameList[key];
			
			var valueTd = document.createElement("td");
			valueTd.textContent = subscriptionData[key];
			if (showBool == false) {
				
				valueTd.textContent = "";
				
			}
			
			var tr = document.createElement("tr");
			tr.appendChild(nameTh);
			tr.appendChild(valueTd);
			table.appendChild(tr);
			
		}
		
		var cancelSubscription = document.createElement("button");
		cancelSubscription.setAttribute("class", "media-button button-primary button-large media-button-insert deleteButton");
		cancelSubscription.textContent = this._i18n.get("Cancel my subscription");
		
		var updateSubscriptionPayments = document.createElement("button");
		updateSubscriptionPayments.setAttribute("style", "margin-left: 10px;");
		updateSubscriptionPayments.setAttribute("class", "w3tc-button-save button-primary")
		updateSubscriptionPayments.textContent = this._i18n.get("My billing");
		
		var updateSubscription = document.createElement("button");
		updateSubscription.setAttribute("style", "margin-left: 10px;");
		updateSubscription.setAttribute("class", "w3tc-button-save button-primary")
		updateSubscription.textContent = this._i18n.get("Update my subscription");
		
		var buttonPanel = document.createElement("div");
		buttonPanel.classList.add("buttonPanel");
		if (showBool == true) {
			
			buttonPanel.appendChild(updateSubscriptionPayments);
			
		}
		buttonPanel.appendChild(updateSubscription);
		subscriptionPanel.appendChild(buttonPanel);
		if (showBool == true) {
			
			buttonPanel.appendChild(cancelSubscription);
			
		}
		
		
		cancelSubscription.onclick = function(event){
			
			object._console.log(subscriptionData);
			
			var confirm = new Confirm(object._debug);
			confirm.dialogPanelShow(object._i18n.get("Attention"), object._i18n.get("Do you really cancel the subscription?"), false, function(response) {
				
				object._console.log(response);
				if (response == true) {
					
					object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
					
					/**
					var extension_url = object._setting_data.extension_url + "cancelSubscription/";
					object._console.log("extension_url = " + extension_url);
					var postData = {customer_id: subscriptionData.customer_id_for_subscriptions, subscriptions_id: subscriptionData.id_for_subscriptions, delete_customer_id: 1, subscription_mode: 'cancelSubscription'};
					object.setFunction("subscriptionDiteilPanel", postData);
					var xmlHttp = new Booking_App_XMLHttp(extension_url, postData, object._webApp, function(json) {
						
						object._console.log(json);
						if (json.status == "success" || json.status == 0) {
							
							var postData = {mode: "upgradePlan", type: "delete", nonce: object._nonce, action: object._action};
    						object.setFunction("subscriptionDiteilPanel", postData);
    						var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
								
								if (json['status'] != 'error') {
									
									object.subscriptionDiteilPanel();
									window.location.reload();
									
								}
								object._loadingPanel.setAttribute("class", "hidden_panel");
								
							});
							
						}
						
					});
					**/
					var postData = {mode: "upgradePlan", type: "delete", nonce: object._nonce, action: object._action, customer_id: subscriptionData.customer_id_for_subscriptions, subscriptions_id: subscriptionData.id_for_subscriptions, delete_customer_id: 1, subscription_mode: 'cancelSubscription'};
					object.setFunction("subscriptionDiteilPanel", postData);
					var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
						
						if (json['status'] != 'error') {
							
							object.subscriptionDiteilPanel();
							window.location.reload();
							
						}
						object._loadingPanel.setAttribute("class", "hidden_panel");
						
					});
					
				}
				
			});
			
		}
		
		updateSubscription.onclick = function() {
			
			updateSubscriptionPayments.classList.add("hidden_panel");
			table.classList.add("hidden_panel");
			updateSubscription.classList.add("hidden_panel");
			cancelSubscription.classList.add("hidden_panel");
			
			var updateTable = document.createElement("table");
			updateTable.setAttribute("class", "emails_table table_option wp-list-table widefat fixed striped")
			subscriptionPanel.appendChild(updateTable);
			
			var subscriptionData = {
				customer_id_for_subscriptions: null,
				subscriptions_id_for_subscriptions: null,
				customer_email_for_subscriptions: null,
			};
			
			var nameList = {
				customer_id_for_subscriptions: object._i18n.get("ID"),
				subscriptions_id_for_subscriptions: object._i18n.get("Subscription ID"),
				customer_email_for_subscriptions: object._i18n.get("Your email"),
			};
			
			for (var key in nameList) {
				
				var nameTh = document.createElement("th");
				nameTh.textContent = nameList[key];
				
				var input = document.createElement("input");
				input.type = "text";
				input.id = key;
				input.classList.add("regular-text");
				
				if (key == 'customer_id_for_subscriptions') {
					
					input.value = object._setting_data.customer_id_for_subscriptions;
					subscriptionData[key] = object._setting_data.customer_id_for_subscriptions;
					
				} else if (key == 'subscriptions_id_for_subscriptions') {
					
					input.value = object._setting_data.id_for_subscriptions;
					subscriptionData[key] = object._setting_data.id_for_subscriptions;
					
				} else if (key == 'customer_email_for_subscriptions') {
					
					input.value = object._setting_data.customer_email_for_subscriptions;
					subscriptionData[key] = object._setting_data.customer_email_for_subscriptions;
					
				}
				
				input.onchange = function() {
					
					var input = this;
					subscriptionData[input.id] = input.value;
					
				};
				
				var valueTd = document.createElement("td");
				valueTd.appendChild(input);
				
				var tr = document.createElement("tr");
				tr.appendChild(nameTh);
				tr.appendChild(valueTd);
				updateTable.appendChild(tr);
				
			}
			
			var updateSubscriptionButton = document.createElement("button");
			updateSubscriptionButton.setAttribute("class", "w3tc-button-save button-primary tokenButton");
			updateSubscriptionButton.setAttribute("style", "margin-top: 1em;");
			updateSubscriptionButton.textContent = object._i18n.get("Update");
			subscriptionPanel.appendChild(updateSubscriptionButton);
			
			updateSubscriptionButton.onclick = function() {
				
				object._console.log(subscriptionData);
				var postData = {mode: "lookingForSubscription", nonce: object._nonce, action: object._action, url: this._url};
				var send = true;
				for (var key in subscriptionData) {
					
					if (subscriptionData[key] == null || subscriptionData[key].length == 0) {
						
						send = false;
						window.alert(object._i18n.get("There are blank fields."));
						break;
						
					} else {
						
						postData[key] = subscriptionData[key];
						
					}
					
				}
				
				if (send == true) {
					
					object._console.log(send);
					object._console.log(postData);
					object.setFunction("subscriptionDiteilPanel", postData);
					object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
					new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json) {
						
						object._console.log(json);
						object._loadingPanel.setAttribute("class", "hidden_panel");
						if (json.status == null) {
							
							window.location.reload();
							
						} else {
							
							window.alert(object._i18n.get("We could not find your information"));
							
						}
						
					});
					
				}
				
			};
			
		};
		
		updateSubscriptionPayments.onclick = function() {
			
			object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
			var form = document.createElement("form");
			form.method = "post";
			//form.action = "https://saasproject.net/update-subscription/";
			form.action = "https://saasproject.net/update-subscription/";
			subscriptionPanel.appendChild(form);
			var subscriptionDiteils = {
				customer_id: object._setting_data.customer_id_for_subscriptions,
				subscriptions_id: object._setting_data.id_for_subscriptions,
				email: object._setting_data.customer_email_for_subscriptions,
				local: object._setting_data.locale,
				return_url: object._setting_data.return_url,
			}
			
			for (var key in subscriptionDiteils) {
				
				var hiddenPanel = document.createElement("input");
				hiddenPanel.type = "hidden";
				hiddenPanel.name = key;
				hiddenPanel.value = subscriptionDiteils[key];
				form.appendChild(hiddenPanel);
				
			}
			form.submit();
			
		};
	
	}
	
	this.sortData = function(key, className, list, panel, mode){
		
		var object = this;
		object._console.log(list);
		var sortBool = false;
		var panelList = panel.getElementsByClassName(className);
		for(var i = 0; i < list.length; i++){
			
			var index = parseInt(panelList[i].getAttribute("data-key"));
			if(i != index){
				
				sortBool = true;
				break;
				
			}
			
		}
		
		var keyList = [];
		var indexList = [];
		if(sortBool === true){
			
			for(var i = 0; i < panelList.length; i++){
				
				keyList.push(list[i][key]);
				var index = parseInt(panelList[i].getAttribute("data-key"));
				indexList.push(index);
				object._console.log(panelList[i]);
				
			}
			
		}
		
		object._console.log(keyList);
		object._console.log(indexList);
		return sortBool;
		
	}
	
	this.changeRank = function(key, className, list, panel, mode, callback){
		
		var object = this;
		object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
		var newList = [];
		var keyList = [];
		var indexList = [];
		
		var panelList = panel.getElementsByClassName(className);
		for(var i = 0; i < panelList.length; i++){
			
			
			var panelKey = parseInt(panelList[i].getAttribute("data-key"));
			newList.push(list[panelKey]);
			keyList.push(list[panelKey][key]);
			
			indexList.push(i);
			object._console.log(panelList[i]);
			
		}
		
		var postData = {mode: mode, nonce: object._nonce, action: object._action, keyList: keyList.join(","), indexList: indexList.join(",")};
		object.setFunction("changeRank", postData);
		var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
			
			callback(json);
			object._loadingPanel.setAttribute("class", "hidden_panel");
			
		});
		
		return newList;
		
	}
	
	this.addNewCourse1 = function(callback){
		
		var object = this;
		var media_frame_content = document.getElementById("media_frame_content")
		media_frame_content.textContent = null;
    	var edit_title = document.getElementById("edit_title");
    	edit_title.textContent = this._i18n.get("New service");
    	
    	document.getElementById("menu_panel").setAttribute("class", "media_frame_menu hidden_panel");
    	document.getElementById("media_title").setAttribute("class", "media_left_zero");
    	document.getElementById("media_router").setAttribute("class", "media_left_zero");
    	document.getElementById("media_frame_content").setAttribute("class", "media_left_zero");
    	document.getElementById("frame_toolbar").setAttribute("class", "media_frame_toolbar media_left_zero");
    	
    	var inputData = {};
    	var courseDataList = object._setting_data['courseData'];
    	var courseTimeList = {};
    	var index = 0;
    	for(var i = 5; i < 1440; i += 5){
    		
    		courseTimeList[i] = i + "min";
    		
    	}
    	
    	courseDataList['time']['valueList'] = courseTimeList;
		object._console.log(courseDataList);
		
		var table = document.createElement("table");
		table.setAttribute("class", "form-table");
		
		for(var key in courseDataList){
			
			object._console.log(key);
        	var courseData = courseDataList[key];
        	
        	var th = document.createElement("th");
        	th.setAttribute("scope", "row");
        	th.textContent = key;
        	
        	var inputPanel = object.createInput(key, courseData, inputData, false, false);
        	var td = document.createElement("td");
        	td.appendChild(inputPanel);
        	
        	var tr = document.createElement("tr");
        	tr.setAttribute("valign", "top");
        	tr.appendChild(th);
        	tr.appendChild(td);
        	table.appendChild(tr);
			
		}
    	
    	media_frame_content.appendChild(table);
    	object.editPanelShow(true);
		
	}
	
	this.isJSON = function(arg) {
		
		arg = (typeof arg === "function") ? arg() : arg;
		if (typeof arg  !== "string") {
			return false;
		}
    	
		try {
			arg = (!JSON) ? eval("(" + arg + ")") : JSON.parse(arg);
			return true;
		} catch (e) {
			return false;
		}
	
	}
	
	this.blockEmailListsPanel = function(emails) {
		
		var object = this;
		object._console.log(emails);
		var blockEmailListsTable = document.getElementById('blockEmailListsTable');
		blockEmailListsTable.textContent = null;
		
		var valueField = document.getElementById(object._prefix + 'newEmail');
		var addButton = document.getElementById(object._prefix + 'addBlockEmail');
		if (object._isExtensionsValid == 0) {
			
			//valueField.placeholder = object._i18n.get('Subscribed users only');
			//valueField.classList.add('extensionsValid');
			valueField.disabled = true;
			addButton.disabled = true;
			
		}
		
		addButton.onclick = function() {
			
			object._console.log(this);
			var value = valueField.value;
			object._console.log(value);
			if (value.length == 0) {
				
				return null;
				
			}
			var loadingPanel = document.getElementById("loadingPanel");
			loadingPanel.classList.remove("hidden_panel");
			var postData = {mode: "addBlockEmail", nonce: object._nonce, action: object._action, email: value};
			var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
				
				object._console.log(json);
				loadingPanel.classList.add("hidden_panel");
				if (json.status == 'error') {
					
					window.alert(json.message);
					
				} else {
					
					document.getElementById(object._prefix + 'newEmail').value = null;
					object.blockEmailListsPanel(json.blocskList);
					
				}
				
			});
			
		};
		
		if (object._isExtensionsValid == 0) {
			
			return null;
			
		}
		
		var emailTd = document.createElement('td');
		emailTd.textContent = object._i18n.get('Email');
		
		var dateTd = document.createElement('td');
		dateTd.textContent = object._i18n.get('Date');
		
		var deleteTd = document.createElement('td');
		deleteTd.classList.add('headerDelete');
		deleteTd.textContent = object._i18n.get('Delete');
		
		var header = document.createElement('tr');
		header.appendChild(emailTd);
		header.appendChild(dateTd);
		header.appendChild(deleteTd);
		
		blockEmailListsTable.appendChild(header);
		
		for (var i = 0; i < emails.length; i++) {
			
			var email = emails[i];
			object._console.log(email);
			var emailTd = document.createElement('td');
			//emailTd.textContent = email.value;
		
			var dateTd = document.createElement('td');
			dateTd.textContent = email.date;
			
			var valueLabel = document.createElement('span');
			valueLabel.textContent = email.value;
			emailTd.appendChild(valueLabel);
			
			var deleteButton = document.createElement('label');
			deleteButton.setAttribute('data-key', email.key);
			deleteButton.setAttribute('class', 'material-icons deleteLink');
			deleteButton.textContent = 'delete';
			
			var deleteTd = document.createElement('td');
			deleteTd.appendChild(deleteButton);
			
			var tr = document.createElement('tr');
			tr.id = 'delete_' + email.key;
			tr.appendChild(emailTd);
			tr.appendChild(dateTd);
			tr.appendChild(deleteTd);
			
			deleteButton.addEventListener('click', function() {
				
				var key = this.getAttribute('data-key');
				var tr = document.getElementById('delete_' + key);
				object._console.log(key);
				object._console.log(tr);
				
				var loadingPanel = document.getElementById("loadingPanel");
				loadingPanel.classList.remove("hidden_panel");
				var postData = {mode: "deleteBlockEmail", nonce: object._nonce, action: object._action, key: parseInt(key)};
				var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
					
					object._console.log(json);
					loadingPanel.classList.add("hidden_panel");
					object.blockEmailListsPanel(json);
					
				});
				
			});
			
			
			blockEmailListsTable.appendChild(tr);
			
		}
		
	};
	
	this.syncPanel = function(){
		
		var object = this;
		var google_calendar_api_panel = function(messagePanel, parse_url, bookingSyncList){
    		
    		object._console.log(bookingSyncList.booking_package_googleCalendar_json);
    		object._console.log(parse_url);
    		var sync_url = parse_url.scheme + "://" + parse_url.host + "/?webhook=google";
    		object._console.log("sync_url = " + sync_url);
    		
    		var client_email = "no value";
    		var booking_package_googleCalendar_json = bookingSyncList.booking_package_googleCalendar_json.value;
    		if(booking_package_googleCalendar_json != null && booking_package_googleCalendar_json.length != 0){
    			
    			if(object.isJSON(booking_package_googleCalendar_json)){
    				
    				var json = JSON.parse(booking_package_googleCalendar_json);
    				client_email = json.client_email;
    				object._console.log(client_email);
    				
    			}
    			
    		}
    		
    		var google_calendar_api = document.getElementById("google_calendar_api").cloneNode(true);
    		google_calendar_api.classList.remove("hidden_panel");
    		google_calendar_api.setAttribute("class", "");
    		messagePanel.appendChild(google_calendar_api);
    		
    		
    	}
		
		object._console.log(object._bookingSyncList);
		var bookingSync_table = document.getElementById("bookingSync_table");
		bookingSync_table.textContent = null;
    	var inputData = {};
    	var messageList = {};
    	//messageList["iCal"] = this._i18n.get("By using iCal you can share calendars and reservations for Google Calendar, Apple Calendar, iCal format.");
    	messageList["Google_Calendar"] = "";
    	
    	for(var i in object._bookingSyncList){
    		
    		var disabled = false;
    		
    		if(i == 'Google_Calendar'){
    			
    			if(typeof ExtensionsFunction != "function"){
    				
    				disabled = true;
    				
    			}
    			
    		}
    		
    		
    		var title = document.createElement("div");
    		title.classList.add("title");
    		//title.textContent = i;
    		title.textContent = 'iCalendar';
    		bookingSync_table.appendChild(title);
    		
    		if(messageList[i] != null){
    			
    			var message = document.createElement("div");
    			message.textContent = messageList[i];
    			bookingSync_table.appendChild(message);
    			if(i == 'Google_Calendar'){
    				
    				//google_calendar_api_panel(message, object._bookingSyncList[i].parse_url, object._bookingSyncList[i]);
    				
    			}
    			
    		}
    		
    		var table = document.createElement("table");
    		table.setAttribute("class", "form-table");
    		bookingSync_table.appendChild(table);
    		for(var key in object._bookingSyncList[i]){
    			
    			object._console.log(object._bookingSyncList[i]);
    			var list = object._bookingSyncList[i][key];
    			var th = document.createElement("th");
    			th.setAttribute("scope", "row");
    			th.textContent = list.name;
				
				var inputPanel = object.createInput(key, list, inputData, disabled, false);
				if(list.inputType == "CUSTOMIZE"){
					
					object._console.log("CUSTOMIZE");
					var tokenDate = list;
					var tokenButton = document.createElement("Button");
					tokenButton.textContent = this._i18n.get("Refresh token");
					tokenButton.setAttribute("data-Key", key);
					tokenButton.setAttribute("class", "w3tc-button-save button-primary tokenButton");
					
					var tokenValue = document.createElement("input");
					tokenValue.type = "text";
					tokenValue.value = tokenDate.home + "?ical=" + tokenDate.value + '&site=' + object._siteToken;
					tokenValue.setAttribute("class", "tokenValue");
					tokenValue.setAttribute("readonly", "readonly");
					tokenValue.style.width = "100%";
					inputPanel.appendChild(tokenValue);
					inputPanel.appendChild(tokenButton);
					tokenValue.onclick = function(){
                        
                        this.focus();
                        this.select();
                        
                    }
					
					tokenButton.onclick = function(){
						
						var key = this.getAttribute("data-key");
						object.refreshToken(key, function(new_token){
							
							object._console.log(new_token);
							tokenValue.value = tokenDate.home + "?ical=" + new_token.token  + '&site=' + object._siteToken;
							
						});
						
					}
					
				}
				
				var td = document.createElement("td");
				td.appendChild(inputPanel);
				
				if(list['type'] == 'radio' || list['type'] == 'check' || list['type'] == 'select'){
					
					object._console.log(list['type']);
					if(typeof list['valueList'] == 'object'){
						
						object._console.log(list['valueList']);
						
					}
				
				}
				
				var tr = document.createElement("tr");
				tr.setAttribute("valign", "top");
				tr.appendChild(th);
				tr.appendChild(td);
				table.appendChild(tr);
    			
    		}
    		
    		
			
		}
		
		object._console.log(inputData);
    	if(inputData.booking_app_googleCalendar_json){
    		
    		object._console.log(inputData.booking_app_googleCalendar_json.textBox);
    		var errorMessage = 'To display "Client ID" here, enter JSON in "Service account".';
    		var client_id_for_google = document.getElementById("client_id_for_google");
    		var value = inputData.booking_app_googleCalendar_json.textBox.value;
    		if(value.length != 0){
    			
    			var value = JSON.parse(value);
    			var client_email = value.client_email;
    			client_id_for_google.value = client_email;
    			object._console.log(client_id_for_google);
    			
    		}else{
    			
    			client_id_for_google.value = errorMessage;
    			
    		}
    		
    		inputData.booking_app_googleCalendar_json.textBox.onchange = function(){
    			
    			var value = inputData.booking_app_googleCalendar_json.textBox.value;
    			var value = JSON.parse(value);
    			if(value.client_email){
    				
    				var client_email = value.client_email;
    				client_id_for_google.value = client_email;
    				object._console.log(client_email);
    				object._console.log(client_id_for_google);
    				
    			}else{
    				
    				client_id_for_google.value = errorMessage;
    				
    			}
    			
   			}
   			
   		}
   		
		document.getElementById("save_bookingSync").onclick = function(){
        	
        	var postData = {mode: 'setting', type: 'bookingSync', nonce: object._nonce, action: object._action};
        	var input = new Booking_Package_Input(object._debug);
        	object._console.log(inputData);
        	var valueList = {};
        	
        	for(var i in object._bookingSyncList){
        		
        		for(var key in object._bookingSyncList[i]){
					
					if(inputData[key] != null){
						
						object._console.log(key);
						object._console.log(object._bookingSyncList[i][key]);
						object._console.log(inputData[key]);
						var bool = input.inputCheck(key, object._bookingSyncList[i][key], inputData[key], valueList);
						var value = valueList[key].join(',');
						if(value.length == 0 && Object.keys(inputData[key]).length == 1 && object._bookingSyncList[i][key].inputType == "CHECK"){
							value = 0;
						}
						
						postData[key] = value;
						
					}
        		
				}
				
        	}
			object._console.log(valueList);
			object._console.log(postData);
			
			if(postData.booking_package_googleCalendar_json != null && postData.booking_package_googleCalendar_json.length != 0 && object.isJSON(postData.booking_package_googleCalendar_json) == false){
				
				var confirm = new Confirm(object._debug);
				confirm.alertPanelShow(object._i18n.get("Error"), object._i18n.get("The Service account must be in JSON format."), false, function(){});
				return null;
				
			}
			
			var loadingPanel = document.getElementById("loadingPanel");
			loadingPanel.classList.remove("hidden_panel");
			var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
				
				object._console.log(json);
				object._console.log(object._bookingSyncList);
				object._bookingSyncList.iCal.booking_package_ical_active.value = json.iCal.booking_package_ical_active;
				object._bookingSyncList.iCal.booking_package_syncPastCustomersForIcal.value = json.iCal.booking_package_syncPastCustomersForIcal;
				loadingPanel.classList.add("hidden_panel");
				
			});
        	
    	}
		
	}
	
	this.holidayPanel = function(mode){
		
		var object = this;
		object._console.log("holidayPanel");
		var holidayPanel = document.getElementById("holidayPanel");
		var regularHolidays = object._setting_data.regularHolidays;
		if (mode == 'national') {
			
			holidayPanel = document.getElementById("nationalHolidayPanel");
			regularHolidays = object._setting_data.nationalHolidays;
			
		}
		var month = parseInt(regularHolidays.date.month);
		var year = parseInt(regularHolidays.date.year);
		object._console.log(regularHolidays);
		var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
        var calendar = new Booking_App_Calendar(weekName, object._setting_data.dateFormat, object._setting_data.positionOfWeek, object._setting_data.positionTimeDate, object._startOfWeek, object._i18n, object._debug);
		
		var calendarPanel = document.getElementById("holidaysCalendarPanel");
		calendarPanel.classList.add("hidden_panel");
		calendarPanel.textContent = null;
		if (mode == 'national') {
			
			calendarPanel = document.getElementById("nationalHolidaysCalendarPanel");
			calendarPanel.classList.add("hidden_panel");
			calendarPanel.textContent = null;
			
		}
		
		calendar.holidayPanel(mode, holidayPanel, calendarPanel, month, year, regularHolidays, function(postData, callback) {
			
			postData.nonce = object._nonce;
			postData.action = object._action;
			object._console.log(postData);
			var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
				
				object._console.log(json);
				if (mode == 'share') {
					
					object._setting_data.regularHolidays = json;
					
				} else if (mode == 'national') {
					
					object._setting_data.nationalHolidays = json;
					
				}
				
				callback(true, json);
				
			});
			
		});
		
		
		/**
		
		calendarPanel.classList.remove("hidden_panel");
        holidayPanel.classList.remove("hidden_panel");
		
		var dayHeight = parseInt(calendarPanel.clientWidth / 7);
        object._console.log("dayHeight = " + dayHeight);
        
        var datePanel = document.createElement("div");
        datePanel.setAttribute("class", "calendarData");
        datePanel.textContent = calendar.formatBookingDate(month, null, year, null, null, null, null, 'text');
        object._console.log(year + "/" + month);
        
        var returnLabel = document.createElement("label");
        returnLabel.setAttribute("class", "arrowLeft");
        if(month == 1){
            
            returnLabel.textContent = "＜" + calendar.formatBookingDate(12, null, null, null, null, null, null, 'text');
            
        }else{
            
            returnLabel.textContent = "＜" + calendar.formatBookingDate((month - 1), null, null, null, null, null, null, 'text');
            
        }
        
        var returnPanel = document.createElement("div");
        returnPanel.setAttribute("class", "calendarChangeButton");
        returnPanel.appendChild(returnLabel);
        
        var nextLabel = document.createElement("label");
        nextLabel.setAttribute("class", "arrowRight");
        if(month == 12){
            
            nextLabel.textContent = calendar.formatBookingDate(1, null, null, null, null, null, null, 'text') + "＞";
	        
        }else{
            
            nextLabel.textContent = calendar.formatBookingDate((month + 1), null, null, null, null, null, null, 'text') + "＞";
            
        }
        
        var nextPanel = document.createElement("div");
        nextPanel.setAttribute("style", "text-align: right;");
        nextPanel.setAttribute("class", "calendarChangeButton");
        nextPanel.appendChild(nextLabel);
        
        var topPanel = document.createElement("div");
        topPanel.setAttribute("class", "calendarPanel");
        topPanel.appendChild(returnPanel);
        topPanel.appendChild(datePanel);
        topPanel.appendChild(nextPanel);
        calendarPanel.appendChild(topPanel);
        
        calendar.create(calendarPanel, regularHolidays, month, 1, year, '', function(callback){
			
			object._console.log(callback);
			var key = callback.key;
			var holiday = regularHolidays.calendar[key];
			if(parseInt(holiday.status) == 1){
				
				callback.eventPanel.classList.add("selectedDayPanel");
				
			}
			
			callback.eventPanel.onclick = function(){
				
				var dayPanel = this;
				var key = dayPanel.getAttribute("data-key");
				var holiday = regularHolidays.calendar[key];
				object._console.log(key);
				object._console.log(regularHolidays.calendar);
				object._console.log(holiday);
				var postData = {mode: 'updateRegularHolidays', nonce: object._nonce, action: object._action, accountKey: mode, day: holiday.day, month: holiday.month, year: holiday.year, month_calendar: regularHolidays.date.month, year_calendar: regularHolidays.date.year, status: 0};
				if(parseInt(holiday.status) == 0){
					
					postData.status = 1;
					
				}
				object._console.log(postData);
				var loadingPanel = document.getElementById("loadingPanel");
				loadingPanel.classList.remove("hidden_panel");
				var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
					
					object._console.log(json);
					if (mode == 'share') {
						
						object._setting_data.regularHolidays = json;
						
					} else if (mode == 'national') {
						
						object._setting_data.nationalHolidays = json;
						
					}
					
					loadingPanel.classList.add("hidden_panel");
					object.holidayPanel(mode);
					
										
				});
			
			}
			
        });
        
        returnLabel.onclick = function(){
            
            if(month == 1){
                
                year--;
                month = 12;
                
            }else{
                
                month--;
                
            }
            
            var postData = {mode: 'getRegularHolidays', nonce: object._nonce, action: object._action, accountKey: mode, month: month, year: year};
            var loadingPanel = document.getElementById("loadingPanel");
        	loadingPanel.classList.remove("hidden_panel");
        	var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
				
				object._console.log(json);
				if (mode == 'share') {
					
					object._setting_data.regularHolidays = json;
					
				} else if (mode == 'national') {
					
					object._setting_data.nationalHolidays = json;
					
				}
				loadingPanel.classList.add("hidden_panel");
				object.holidayPanel(mode);
				
									
			});
        
        }
        
        nextLabel.onclick = function(){
            
            if(month == 12){
                
                year++;
                month = 1;
                
            }else{
                
                month++;
                
            }
            
            var postData = {mode: 'getRegularHolidays', nonce: object._nonce, action: object._action, accountKey: mode, month: month, year: year};
            var loadingPanel = document.getElementById("loadingPanel");
        	loadingPanel.classList.remove("hidden_panel");
        	var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
				
				object._console.log(json);
				if (mode == 'share') {
					
					object._setting_data.regularHolidays = json;
					
				} else if (mode == 'national') {
					
					object._setting_data.nationalHolidays = json;
					
				}
				loadingPanel.classList.add("hidden_panel");
				object.holidayPanel(mode);
				
									
			});
            
        }
		**/
		
	}
	
	this.memberPanel = function(){
		
		var object = this;
		object._console.log("memberPanel");
		var memberSetting = object._setting_data.memberSetting;
		object._console.log(memberSetting);
		var memberPanel = document.getElementById("memberPanel");
		if(parseInt(object._isExtensionsValid) == 1){
			
			var tags = memberPanel.getElementsByClassName("extensionsValid");
			object._console.log(tags);
			for(var i = 0; i < tags.length; i++){
				
				tags[i].classList.add("hidden_panel");
				
			}
			
		}
		//memberPanel.textContent = "Member";
		for(var key in memberSetting){
			
			var data = memberSetting[key];
			if(data.value != null && typeof data.value == "string"){
				
				data.value = data.value.replace(/\\/g, "");
				
			}
			
			object._console.log(data);
			var inputElement = document.getElementById(key);
			object._console.log(inputElement);
			if(inputElement.tagName == "INPUT" && inputElement.type.toLocaleUpperCase() == "CHECKBOX"){
				
				object._console.log(inputElement.type.toLocaleUpperCase());
				if(parseInt(data.value) == 1){
					
					inputElement.checked = true;
					
				}
				
			}else if(inputElement.tagName == "INPUT" && inputElement.type.toLocaleUpperCase() == "TEXT"){
				
				object._console.log(inputElement.type.toLocaleUpperCase());
				inputElement.value = data.value;
				
			}else if(inputElement.tagName == "TEXTAREA"){
				
				inputElement.textContent = data.value;
				
			}
			
		}
		
		var save_member_setting_button = document.getElementById("save_member_setting_button");
		if(parseInt(object._isExtensionsValid) == 1){
			
			save_member_setting_button.removeEventListener("click", null);
			save_member_setting_button.onclick = function(){
				
				var postData = {mode: 'updateMemberSetting', nonce: object._nonce, action: object._action};
				for(var key in memberSetting){
					
					var data = memberSetting[key];
					var inputElement = document.getElementById(key);
					if(data.inputType.toLocaleUpperCase() == "CHECK"){
						
						postData[key] = 0;
						if(inputElement.checked == true){
							
							postData[key] = 1;
							
						}
						
					}else if(data.inputType.toLocaleUpperCase() == "TEXT"){
						
						postData[key] = inputElement.value;
						
					}else if(data.inputType.toLocaleUpperCase() == "TEXTAREA"){
						
						postData[key] = inputElement.value;
						
					}
					
				}
				
				object._console.log(postData);
				var loadingPanel = document.getElementById("loadingPanel");
	        	loadingPanel.classList.remove("hidden_panel");
	        	object.setFunction("memberPanel", postData);
	        	var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
					
					object._console.log(json);
					object._setting_data.memberSetting = json;
					loadingPanel.classList.add("hidden_panel");
										
				});
				
			}
			
		}else{
			
			save_member_setting_button.disabled = true;
			
		}
		
	}
	
	this.cssPanel = function() {
		
		var object = this;
		object._console.log("cssPanel");
		var css_textarea = document.getElementById("css");
		
		if (object._countCssPanel == 0) {
			
			object._jsEditor = CodeMirror.fromTextArea(
				css_textarea, 
				{
					mode: "css",
					lineNumbers: true,
					indentUnit: 4,
				}
			);
			
		}
		
		object._countCssPanel++;
		
		
		document.getElementById("save_css").onclick = function() {
			
			object._jsEditor.save();
			var value = css_textarea.value;
			object._console.log(value);
			var loadingPanel = document.getElementById("loadingPanel");
        	loadingPanel.classList.remove("hidden_panel");
        	
        	var postData = {mode: 'updateCss', nonce: object._nonce, action: object._action, value: value};
			object._console.log(postData);
        	var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
				
				object._console.log(json);	
				loadingPanel.classList.add("hidden_panel");
									
			});
			
		}
		
	}
	
	this.javascriptPanel = function() {
		
		var object = this;
		object._console.log("javascriptPanel");
		object._console.log("_isExtensionsValid = " + object._isExtensionsValid);
		var javascript_textarea = document.getElementById("javascript_booking_package");
		
		if (object._countJavascriptPanel == 0) {
			
			object._jsEditor = CodeMirror.fromTextArea(
				javascript_textarea, 
				{
					mode: "javascript",
					lineNumbers: true,
					indentUnit: 4,
				}
			);
			
		}
		
		object._countJavascriptPanel++;
		
		if (object._isExtensionsValid == 1) {
			
			document.getElementById("save_javascript").onclick = function() {
				
				object._jsEditor.save();
				var value = javascript_textarea.value;
				object._console.log(value);
				var loadingPanel = document.getElementById("loadingPanel");
				loadingPanel.classList.remove("hidden_panel");
				
				var postData = {mode: 'updateJavaScript', nonce: object._nonce, action: object._action, value: value};
				object._console.log(postData);
				var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
					
					object._console.log(json);	
					loadingPanel.classList.add("hidden_panel");
					
				});
				
			}
			
		} else {
			
			/**
			var extensionsValid = document.createElement("div");
			extensionsValid.classList.add("extensionsValid");
			extensionsValid.textContent = object._i18n.get("Subscribed users only");
			javascript_textarea.insertAdjacentElement("beforebegin", extensionsValid);
			**/
			document.getElementById("save_javascript").disabled = true;
			
		}
		
	}
	
	this.createSettingPanel = function() {
		
		var object = this;
		
		var links = {
			Mailgun: "https://www.mailgun.com/",
			twilio: "https://www.twilio.com/",
			Stripe: "https://stripe.com",
			PayPal: "https://developer.paypal.com",
			reCAPTCHA: "https://www.google.com/recaptcha/",
			hCaptcha: "https://www.hcaptcha.com/",
		}
		
		object._loadingPanel.classList.add("hidden_panel");
		object._console.log(object._settingList);
		document.getElementById("settingPanel").classList.remove("hidden_panel");
		var setting_table = document.getElementById("setting_table");
    	var inputData = {};
    	var messageList = {};
    	//messageList["Mailgun"] = this._i18n.get("Mailgun is an email automation service. It offers a complete cloud-based email service for sending, receiving and tracking email sent through your websites and applications.");
    	//messageList["Stripe"] = this._i18n.get('Stripe is the best way to accept payments online and in mobile apps.');
    	
    	for(var i in object._settingList){
    		
    		var disabled = false;
    		if (links[i] != null) {
    			
    			var title = document.createElement("a");
	    		title.classList.add("title");
	    		title.textContent = i;
	    		title.href = links[i];
	    		title.target = "_blank";
	    		setting_table.appendChild(title);
	    		
	    		if (i == 'twilio') {
	    			
	    			title.textContent = i + ' SMS';
	    			
	    		}
    			
    		} else {
    			
    			var title = document.createElement("div");
	    		title.classList.add("title");
	    		//title.textContent = i;
	    		title.textContent = object._i18n.get(i);
	    		setting_table.appendChild(title);
    			
    		}
    		
    		if (messageList[i] != null) {
    			
    			var message = document.createElement("div");
    			message.textContent = messageList[i];
    			setting_table.appendChild(message);
    			
    		}
    		
    		var table = document.createElement("table");
    		table.setAttribute("class", "form-table");
    		setting_table.appendChild(table);
    		for (var key in object._settingList[i]) {
    			
    			var list = object._settingList[i][key];
    			disabled = false;
    			if (object._isExtensionsValid == 0 && parseInt(list.isExtensionsValid) == 1) {
    				
    				disabled = true;
    				
    			}
    			var th = document.createElement("th");
    			th.setAttribute("scope", "row");
    			th.textContent = list.name;
				
				var idBool = false;
				if (i == 'Design') {
					idBool = true;
				}
				
				var inputPanel = object.createInput(key, list, inputData, disabled, idBool);
				var td = document.createElement("td");
				td.appendChild(inputPanel);
				
				if (list['type'] == 'radio' || list['type'] == 'check' || list['type'] == 'select') {
					
					object._console.log(list['type']);
					object._console.log(list.valueList);
					if (typeof list['valueList'] == 'object') {
						
						object._console.log(list['valueList']);
						
					}
				
				}
				
				var tr = document.createElement("tr");
				tr.setAttribute("valign", "top");
				tr.appendChild(th);
				tr.appendChild(td);
				table.appendChild(tr);
				
				if(i == 'Design' && list.js != null){
					
					(function( $ ) {
						
						$(function() {
							
							object._console.log("key = " + key);
							object._console.log($('#' + key));
							object._console.log(typeof $('#' + key).wpColorPicker);
							if (typeof $('#' + key).wpColorPicker == 'function') {
								
								object._console.log(typeof $('#' + key).wpColorPicker());
								$('#' + key).wpColorPicker();
								
							}
							
						});
						
					})( jQuery );
					
				}
    			
    		}
			
		}
		
		document.getElementById('booking_package_googleReCAPTCHA_active_1').onclick = function() {
			
			object._console.log(this);
			var hCaptcha_0 = document.getElementById('booking_package_hCaptcha_active_0');
			var hCaptcha_1 = document.getElementById('booking_package_hCaptcha_active_1');
			if (this.checked === true) {
				
				if (hCaptcha_0 != null) {
					
					hCaptcha_0.checked = true;
					hCaptcha_1.checked = false;
					
				}
				
			}
			
		};
		
		document.getElementById('booking_package_hCaptcha_active_1').onclick = function() {
			
			object._console.log(this);
			var reCaptcha_0 = document.getElementById('booking_package_googleReCAPTCHA_active_0');
			var reCaptcha_1 = document.getElementById('booking_package_googleReCAPTCHA_active_1');
			if (this.checked === true) {
				
				if (reCaptcha_0 != null) {
					
					reCaptcha_0.checked = true;
					reCaptcha_1.checked = false;
					
				}
				
			}
			
		};
    	
    	document.getElementById("save_setting").onclick = function(){
        	
        	var loadingPanel = document.getElementById("loadingPanel");
        	loadingPanel.classList.remove("hidden_panel");
        	
        	var postData = {mode: 'setting', nonce: object._nonce, action: object._action};
        	var input = new Booking_Package_Input(object._debug);
        	object._console.log(inputData);
        	var valueList = {};
        	
        	for(var i in object._settingList){
        		
        		for(var key in object._settingList[i]){
					
					if(inputData[key] != null){
						
						object._console.log(key);
						object._console.log(object._settingList[i][key]);
						object._console.log(inputData[key]);
						var bool = input.inputCheck(key, object._settingList[i][key], inputData[key], valueList);
						object._console.log(typeof valueList[key]);
						var value = [];
						if (typeof valueList[key] == 'object') {
							
							value = valueList[key].join(',');
							
						} else {
							
							value = JSON.parse(valueList[key]);
							
						}
						
						if(value.length == 0 && Object.keys(inputData[key]).length == 1 && object._settingList[i][key].inputType == "CHECK"){
							value = 0;
						}
						
						postData[key] = value;
						
					}
        			
				}
				
        	}
        	
        	object._console.log(valueList);
        	object._console.log(postData);
        	var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
				
				object._console.log(json);	
				loadingPanel.classList.add("hidden_panel");
									
			});
        	
    	}
		
	}
	
	this.getInputData = function(inputTypeList, inputData){
		
		var object = this;
		var postData = {};
		for(var key in inputTypeList){
    		
    		object._console.log(key);
    		var values = [];
    		var inputType = inputTypeList[key];
    		object._console.log(inputType);
    		for(var inputKey in inputData[key]){
    			
    			var bool = true;
    			if(inputType['inputType'] == 'TEXT' || inputType['inputType'] == 'TEXTAREA'){
    				
    				if(inputData[key][inputKey].value.length == 0 && inputType.inputLimit == '1'){
    					
    					bool = false;
    					
    				}else{
    					
    					values.push(inputData[key][inputKey].value);
    					
    				}
    				
    			}else if(inputType['inputType'] == 'CHECK' || inputType['inputType'] == 'RADIO'){
    				
    				if(inputData[key][inputKey].checked == true){
    					
    					values.push(inputData[key][inputKey].getAttribute("data-value"));
    					
    				}
    				
    			}else if(inputType['inputType'] == 'OPTION'){
    				
    				if(inputData[key][inputKey].checked == true){
    					
    					values.push(inputData[key][inputKey].value);
    					
    				}
    				
    			}else if(inputType['inputType'] == 'SELECT'){
    				
    				var index = inputData[key][inputKey].selectedIndex;
    				values.push(inputData[key][inputKey].options[index].value);
    				
    			}
    			
    		}
    		
    		if(bool === true){
    			
    			postData[key] = values.join(",");
    			
    		}else{
    			
    			postData[key] = false;
    			
    		}
    		
    		//postData[key] = false;
    		object._console.log(inputData[key]);
    		
    	}
		
		return postData;
		
	}
	
	this.createInput = function(inputName, input, inputData, disabled, idBool){
		
		var object = this;
		object._console.log("createInput");
		object._console.log(input);
		if(typeof input['value'] == "string" && inputName != 'booking_package_googleCalendar_json'){
			
			input['value'] = input['value'].replace(/\\/g, "");
			
		}
		
		var isExtensionsValid = 0;
		if(input.isExtensionsValid != null){
			
			isExtensionsValid = parseInt(input.isExtensionsValid);
			
		}
		var list = null;
		if(input['valueList'] != null){
	    	
	    	list = input['valueList'];
	    	
		}
		
		object._console.log(list);
		var valuePanel = document.createElement("div");
		valuePanel.classList.add("valuePanel");
		if (isExtensionsValid == 1 && object._isExtensionsValid == 0) {
			
			object._console.log("isExtensionsValid = " + isExtensionsValid);
			var extensionsValidPanel = document.createElement("div");
            extensionsValidPanel.classList.add("extensionsValid");
            extensionsValidPanel.textContent = object._i18n.get("Subscribed users only");
            valuePanel.appendChild(extensionsValidPanel);
			
		}
		
		
		if (input['inputType'] == 'TEXT') {
			
			var textBox = document.createElement("input");
			textBox.setAttribute("class", "regular-text");
			textBox.type = "text";
			textBox.value = input['value'];
			textBox.disabled = disabled;
			if (idBool == true) {
				
				textBox.id = inputName;
				
			}
			
			if (input.placeholder != null) {
				
				textBox.placeholder = input.placeholder;
				
			}
			
			valuePanel.appendChild(textBox);
			inputData[inputName] = {textBox: textBox};
			
		} else if (input['inputType'] == 'SELECT') {
			
			var selectBox = document.createElement("select");
			selectBox.disabled = disabled;
			object._console.log(typeof list);
			object._console.log(list);
			for (var key in list) {
				
				var optionBox = document.createElement("option");
				optionBox.value = key;
				optionBox.textContent = list[key];
				
				//object._console.log("key = " + key + " content = " + list[key]);
				if (key == input['value']) {
					
					//object._console.log("value = " + input['value']);
					optionBox.selected = true;
					
				}
				
				selectBox.appendChild(optionBox);
				
			}
			
			valuePanel.appendChild(selectBox);
			inputData[inputName] = {selectBox: selectBox};
			
		} else if (input['inputType'] == 'SELECT_GROUP') {
			
			var selectBox = document.createElement("select");
			selectBox.disabled = disabled;
			object._console.log(typeof list);
			object._console.log(list);
			
			var selectedvalue = null;
			for (var key in list) {
				
				if(list[key]['alpha-2'] == input['value']){
					
					selectedvalue = key;
					break;
					
				}
				
			}
			
			if (selectedvalue == null) {
				
				selectedvalue = "United States of America";
				
			}
			
			var selectedCountry = list[selectedvalue];
			object._console.log(selectedCountry)
			
			var optionBox = document.createElement("option");
			optionBox.value = selectedCountry['alpha-2'];
			optionBox.textContent = selectedCountry.name;
			
			var optgroup = document.createElement("optgroup");
			optgroup.setAttribute("label", this._i18n.get("Selected country"));
			optgroup.appendChild(optionBox);
			selectBox.appendChild(optgroup);
			
			var frequently = ["Canada", "France", "Germany", "Italy", "Japan", "United Kingdom of Great Britain and Northern Ireland", "United States of America"];
			var optgroup = document.createElement("optgroup");
			optgroup.setAttribute("label", this._i18n.get("Frequently used countries"));
			selectBox.appendChild(optgroup);
			
			object._console.log("selectedvalue = " + selectedvalue);
			for (var i = 0; i < frequently.length; i++) {
				
				var key = frequently[i];
				if (list[key].name != selectedvalue) {
					
					var optionBox = document.createElement("option");
					optionBox.value = list[key]['alpha-2'];
					optionBox.textContent = list[key].name;
					optgroup.appendChild(optionBox);
					
				}
				
			}
			
			var optgroup = document.createElement("optgroup");
			optgroup.setAttribute("label", this._i18n.get("Other countries"));
			selectBox.appendChild(optgroup);
			
			for (var key in list) {
				
				var optionBox = document.createElement("option");
				optionBox.value = list[key]['alpha-2'];
				optionBox.textContent = list[key].name;
				//object._console.log("key = " + key + " content = " + list[key]);
				if (key == input['value']) {
					
					object._console.log("value = " + input['value']);
					optionBox.selected = true;
					
				}
				
				optgroup.appendChild(optionBox);
				
			}
			
			valuePanel.appendChild(selectBox);
			inputData[inputName] = {selectBox: selectBox};
			
		} else if (input['inputType'] == 'SELECT_TIMEZONE') {
			
			var timezoneGroup = object._timezoneGroup;
			var options = [];
			var timezoneSelect = document.createElement("select");
			
			for (var i = 0; i < timezoneGroup.length; i++) {
				
				var group = timezoneGroup[i];
				var optionsInGroup = group.getElementsByTagName("option");
				optionsInGroup = [].slice.call(optionsInGroup);
				options = options.concat(optionsInGroup);
				
				timezoneSelect.appendChild(group);
				
			}
			
			for (var i = 0; i < options.length; i++) {
				
				var option = options[i];
				if (option.value == input.value) {
					
					option.selected = true;
					break;
					
				} else {
					
					option.selected = false;
					
				}
				
			}
			
            valuePanel.appendChild(timezoneSelect);
			inputData[inputName] = {selectBox: timezoneSelect};
			
		} else if (input['inputType'] == 'OPTION') {
			
			object._console.log("inputType = " + input['inputType']);
			object._console.log(input);
			var options = [];
			if(input['value'] != null){
				
				options = input['value'].split(",");
				
			}
			
			object._console.log(options);
			var addButton = document.createElement("label");
			//addButton.setAttribute("class", "w3tc-button-save button-primary");
			addButton.setAttribute("class", "addLink");
			addButton.textContent = this._i18n.get("Add");
			valuePanel.appendChild(addButton);
			
			var table = document.createElement("table");
			table.setAttribute("class", "table_option wp-list-table widefat fixed striped");
			valuePanel.appendChild(table);
			
			inputData[inputName] = {};
			var tr_index = 0;
			var table_tr = {};
			
			for(var i = 0; i < options.length; i++){
				
				create_tr(tr_index, table, options[i]);
				tr_index++;
				
			}
			
			addButton.onclick = function(){
				
				create_tr(tr_index, table, null);
				tr_index++;
				
			}
			
		} else if (input['inputType'] == 'CHECK') {
			
			inputData[inputName] = {};
			for (var key in list) {
				
				object._console.log("key = " + key + " value = " + list[key])
				var valueName = document.createElement("span");
				valueName.setAttribute("class", "radio_title");
				valueName.textContent = list[key];
				
				var checkBox = document.createElement("input");
				checkBox.disabled = disabled;
				checkBox.setAttribute("data-value", key);
				checkBox.name = inputName;
				checkBox.type = "checkbox";
				checkBox.value = list[key];
				if (input['value'] == key) {
					
					checkBox.checked = "checked";
					
				}
				
				var label = document.createElement("label");
				label.appendChild(checkBox);
				label.appendChild(valueName);
				valuePanel.appendChild(label);
				inputData[inputName][key] = checkBox;
				
			}
			
		} else if (input['inputType'] == 'RADIO') {
				
			inputData[inputName] = {};
			for (var key in list) {
				
				object._console.log(key + " = " + list[key]);
				var valueName = document.createElement("span");
				valueName.setAttribute("class", "radio_title");
				valueName.textContent = list[key];
				
				var radioBox = document.createElement("input");
				radioBox.disabled = disabled;
				radioBox.setAttribute("data-value", key);
				radioBox.id = inputName + '_' + key;
				radioBox.name = inputName;
				radioBox.type = "radio";
				radioBox.value = list[key];
				if (input['value'] == key) {
					
					object._console.log("value = " + input['value']);
					radioBox.checked = "checked";
					
				}
				
				var label = document.createElement("label");
				label.appendChild(radioBox);
				label.appendChild(valueName);
				valuePanel.appendChild(label);
				inputData[inputName][key] = radioBox;
				
			}
			
		}else if(input['inputType'] == 'TEXTAREA'){
			
			var textareaBox = document.createElement("textarea");
			textareaBox.value = input['value'];
			textareaBox.disabled = disabled;
			valuePanel.appendChild(textareaBox);
			inputData[inputName] = {textBox: textareaBox};
			
		}
		
		function create_tr(tr_index, table, value){
				
			var textBox = document.createElement("input");
			textBox.setAttribute("data-key", tr_index);
			textBox.setAttribute("class", "regular-text");
			textBox.setAttribute("style", "width: 100%");
			textBox.type = "text";
			
			var filedTd = document.createElement("td");
			filedTd.setAttribute("class", "td_option");
			filedTd.appendChild(textBox);
			
			var deleteButton = document.createElement("label");
			deleteButton.textContent = "delete";
			deleteButton.setAttribute("data-key", tr_index);
			deleteButton.setAttribute("class", "material-icons deleteLink");
			
			var deleteTd = document.createElement("td");
			deleteTd.setAttribute("class", "td_delete td_option");
			deleteTd.appendChild(deleteButton);
			
			var tr = document.createElement("tr");
			tr.setAttribute("class", "tr_option");
			tr.appendChild(filedTd);
			tr.appendChild(deleteTd);
			
			table_tr[tr_index] = tr;
			table.appendChild(tr);
			
			var checkBox = document.createElement("input");
			checkBox.setAttribute("data-value", tr_index);
			checkBox.name = tr_index;
			checkBox.type = "checkbox";
			checkBox.value = null;
			inputData[inputName][tr_index] = checkBox;
			
			if(value != null && value.length != 0){
			
				textBox.value = value;
				checkBox.value = value;
				checkBox.checked = true;
				
			}
			
			textBox.onchange = function(){
				
				var dataKey = this.getAttribute("data-key");
				var value = this.value;
				var bool = false;
				if(value.length != 0){
					bool = true;
				}else{
					value = null;
				}
				
				inputData[inputName][dataKey].value = value;
				inputData[inputName][dataKey].checked = bool;
				object._console.log("dataKey = " + dataKey + " value = " + value + " bool = " + bool);
				
			}
			
			deleteButton.onclick = function(){
				
				var result = false;
				var dataKey = this.getAttribute("data-key");
				var length = inputData[inputName][dataKey].value.length;
				if(length == 0){
					
					result = true;
					
				}
				
				if(result === false){
					
					result = confirm(this._i18n.get("Do you delete the \"%s\"?", [inputData[inputName][dataKey].value]));
					
				}
				
				if(result === true){
					
					var tr = table_tr[parseInt(dataKey)];
					table.removeChild(tr);
					delete table_tr[dataKey];
					delete inputData[inputName][dataKey];
					object._console.log(tr);
					object._console.log(table_tr);
					object._console.log(inputData[inputName]);
					object._console.log("tr_index = " + tr_index);
					
				}
				
			}
			
		}
		
		return valuePanel;
		
	}
	
	this.refreshToken = function(key, callback){
		
		var object = this;
		object._console.log(key);
		var postData = {mode: "refreshToken", nonce: object._nonce, action: object._action, key: key};
		object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
    	var xmlHttp = new Booking_App_XMLHttp(object._url, postData, object._webApp, function(json){
			
			if(json['status'] != 'error'){
				
				callback(json);
				
			}
			object._loadingPanel.setAttribute("class", "hidden_panel");
							
		});
		
	}
	
	this.editPanelShow = function(showBool){
    	
    	var object = this;
    	var body = document.getElementsByTagName("body")[0];
    	object._console.log(body);
    	if(showBool == true){
        	
        	body.classList.add("modal-open");
        	object.editPanel.setAttribute("class", "edit_modal");
        	object.blockPanel.setAttribute("class", "edit_modal_backdrop");
			
    	}else{
        	
        	body.classList.remove("modal-open");
        	object.editPanel.setAttribute("class", "hidden_panel");
        	object.blockPanel.setAttribute("class", "hidden_panel");
			
    	}
		
	}
	
}
