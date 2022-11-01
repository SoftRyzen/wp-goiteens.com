/* globals Confirm */
/* globals Booking_App_XMLHttp */
/* globals I18n */
/* globals Booking_Package_Console */

    window.addEventListener('load', function(){
        
        var subscription_manage = new Subscription_manage(subscription_data, booking_package_dictionary);
        subscription_manage.start();
        
    });
    
    
    function Subscription_manage(subscription_data, booking_package_dictionary) {
        
        var object = this;
        this._debug = new Booking_Package_Console(subscription_data.debug);
        this._console = {};
        this._console.log = this._debug.getConsoleLog();
        object._console.log(subscription_data);
        object._console.log(booking_package_dictionary);
        this._subscription_data = subscription_data;
        this._url = subscription_data.url;
        this._nonce = subscription_data.nonce;
        this._action = subscription_data.action;
        this._site = subscription_data.site;
        this._webApp = subscription_data.webApp;
        this._is_owner_site = parseInt(subscription_data.is_owner_site);
        this._is_super_admin = parseInt(subscription_data.is_super_admin);
        this._isExtensionsValid = parseInt(subscription_data.isExtensionsValid);
        
        this._super_customer_id = "";
        if (subscription_data.super_customer_id != null) {
            
            this._super_customer_id = subscription_data.super_customer_id;
            
        }
        
        this._super_email = "";
        if (subscription_data.super_email != null) {
            
            this._super_email = subscription_data.super_email;
            
        }
        
        this._i18n = new I18n(subscription_data.locale);
        this._i18n.setDictionary(booking_package_dictionary);
        this._loadingPanel = document.getElementById("loadingPanel");
        
    }
    
    Subscription_manage.prototype.start = function() {
        
        var object = this;
        object._console.log("_is_owner_site = " + object._is_owner_site);
        var subscriptionDetailsTable = document.getElementById("subscriptionDetailsTable");
        var subscriptionInputTable = document.getElementById("subscriptionInputTable");
        
        //var addSubscription = document.getElementById("addSubscription");
        var cancelSubscription = document.getElementById("cancelSubscription");
        var sendSubscription = document.getElementById("sendSubscription");
        sendSubscription.classList.add("hidden_panel");
        
        if (object._is_super_admin == 1) {
            
            var subscriptionData = {
    			customer_id_for_subscriptions: object._subscription_data.subscriptions.customer_id_for_subscriptions,
    			id_for_subscriptions: object._subscription_data.subscriptions.id_for_subscriptions,
    			/** invoice_id_for_subscriptions: object._subscription_data.subscriptions.invoice_id_for_subscriptions, **/
    			expiration_date_for_subscriptions: object._subscription_data.subscriptions.expiration_date_for_subscriptions,
    			expiration_date: object._subscription_data.subscriptions.expiration_date,
    			customer_email_for_subscriptions: object._subscription_data.subscriptions.customer_email_for_subscriptions
    		};
    		object._console.log(subscriptionData);
            
            if (object._isExtensionsValid == 0) {
                
                document.getElementById("customer_id").textContent = object._super_customer_id;
                document.getElementById("email").textContent = object._super_email;
                /**
                addSubscription.classList.remove("hidden_panel");
                addSubscription.onclick = function(){
                    
                    addSubscription.classList.add("hidden_panel");
                    subscriptionDetailsTable.classList.add("hidden_panel");
                    subscriptionInputTable.classList.remove("hidden_panel");
                    sendSubscription.classList.remove("hidden_panel");
                    object._console.log(subscriptionDetailsTable);
                    
                }
                **/
                
                //addSubscription.classList.add("hidden_panel");
                subscriptionDetailsTable.classList.add("hidden_panel");
                subscriptionInputTable.classList.remove("hidden_panel");
                sendSubscription.classList.remove("hidden_panel");
                object._console.log(subscriptionDetailsTable);
                
            } else {
                
                cancelSubscription.classList.remove("hidden_panel");
                cancelSubscription.onclick = function(){
                    
                    var confirm = new Confirm(object._debug);
                    confirm.dialogPanelShow(object._i18n.get("Confirmation of cancel"), object._i18n.get("Do you really cancel the subscription?"), false, function(response){
        				
        				object._console.log(response);
        				if(response === true){
        				    
        				    var extension_url = object._subscription_data.extension_url + "cancelSubscription/";
        				    var post = {customer_id: subscriptionData.customer_id_for_subscriptions, subscriptions_id: subscriptionData.id_for_subscriptions, delete_customer_id: 0};
        					var xmlHttp = new Booking_App_XMLHttp(extension_url, post, false, function(json){
        						
        						object._console.log(json);
        						if(json.status == "success" || json.status == 0){
        							
        							var post = {mode: "upgradePlan", type: "delete", nonce: object._nonce, action: object._action};
            						var xmlHttp = new Booking_App_XMLHttp(object._url, post, object._webApp, function(json){
        								
        								if(json['status'] != 'error'){
        									
        									window.location.reload();
        									
        								}
        								object._loadingPanel.setAttribute("class", "hidden_panel");
        								
        							});
        							
        						}
        						
        					});
        					
        				}
        				
                    });
                    
                    object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
                    
                }
                
            }
            
            sendSubscription.onclick = function(){
                
                var post = {
                    mode: "payNewSubscriptions", 
                    nonce: object._nonce, 
                    action: object._action, 
                    url: object._url, 
                    site: object._site,
                    customer_id_for_subscriptions: object._super_customer_id,
                    customer_email_for_subscriptions: object._super_email,
                };
                
                
                object._console.log(post);
                object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
                new Booking_App_XMLHttp(object._url, post, false, function(json){
                    
                    object._console.log(json);
                    if (json.status == 'success') {
                        
                        window.location.reload();
                        
                    }
                    object._loadingPanel.setAttribute("class", "hidden_panel");
                    
                });
                
            }
            
        }
        
    }