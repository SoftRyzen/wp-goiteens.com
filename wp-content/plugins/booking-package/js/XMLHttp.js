
	function Booking_App_XMLHttp(url, data, webApp, callback, responseCallback) {
		
		if(webApp == true){
			
			data.app = 'json';
			
		}
		
		this._error = false;
		this._count = 0;
		
		var object = this;
		object.request(url, data, callback, responseCallback);
		
		
		/**
		var xhr = this.requestCreate();
		xhr.onreadystatechange = function(){
			
			console.log(xhr.status);
			
			switch (xhr.readyState) {
			
				case 4:
				if (xhr.status == 0) {
				
					callback({status: "ERROR"});
				
				} else {
				
					if ((200 <= xhr.status && xhr.status < 300) || (xhr.status == 304)) {
						
						
						
					} else {
						
						callback({status: "ERROR"});
						
					}
				
				}
				
				break;
				
			}
			
		};
		
		xhr.onload = function(e){
			
			object.setStatus(xhr.status);
			if(responseCallback != null && typeof responseCallback == "function"){
				
				responseCallback(xhr.responseText);
				
			}
			console.log(xhr.status);
			
			//var bool = object.isJSON(xhr.responseText);
			var bool = true;
			if(bool == true){
				
				var responseJson = JSON.parse(xhr.responseText);
				callback(responseJson);
				
			}else{
				
				callback({status: 0});
				
			}
			
			
		}
		
		xhr.onerror = function(e){
			
			console.log(e);
			
		}
		
		xhr.open("POST", url);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send(this.encodeHTMLForm(data));
		**/
		
	}
	
	Booking_App_XMLHttp.prototype.setError = function(error) {
		
		this._error = error;
		
	}
	
	Booking_App_XMLHttp.prototype.getError = function() {
		
		return this._error;
		
	}
	
	Booking_App_XMLHttp.prototype.addCount = function() {
		
		this._count++;
		
	}
	
	Booking_App_XMLHttp.prototype.getCount = function() {
		
		return this._count;
		
	}
	
	Booking_App_XMLHttp.prototype.setStatus = function(status){
		
		this._status = status;
		
	}
	
	Booking_App_XMLHttp.prototype.getStatus = function(){
		
		return this._status;
		
	}
	
	Booking_App_XMLHttp.prototype.requestCreate = function(){
		
		try{
			
			return new XMLHttpRequest();
			
		}catch(e){}
		
		return null;
			
	}
	
	Booking_App_XMLHttp.prototype.request = function(url, data, callback, responseCallback){
		
		var object = this;
		try {
			
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function(){
				
				switch (xhr.readyState) {
				
					case 4:
					if (xhr.status == 0) {
					
						//callback({status: "ERROR"});
					
					} else {
					
						if ((200 <= xhr.status && xhr.status < 300) || (xhr.status == 304)) {
							
							
							
						} else {
							
							//callback({status: "ERROR"});
							
						}
					
					}
					
					break;
					
				}
				
			};
			
			xhr.onload = function(e){
				
				object.setStatus(xhr.status);
				if (responseCallback != null && typeof responseCallback == "function") {
					
					responseCallback(xhr.responseText);
					
				}
				
				if (xhr.status == 401) {
					
					window.alert("Failed to load resource: the server responded with a status of 401 (Authorization Required). In order to use Booking Package, you need to cancel Basic Authentication. Basic authentication URL: " + url);
					
				}
				
				//var bool = object.isJSON(xhr.responseText);
				var bool = true;
				if (xhr.status == 200 || xhr.status == 304) {
					
					var responseJson = JSON.parse(xhr.responseText);
					callback(responseJson);
					
				} else {
					
					var text = xhr.responseText;
					console.log(text);
					window.alert("Response Error. HTTP Status: " + xhr.status);
					//callback({status: 0, status_code: xhr.status});
					
				}
				
				
			}
			
			xhr.onerror = function(e){
				
				console.log(e);
				object.setError(true);
				var count = object.getCount();
				if (count < 20) {
					
					var timer = setInterval(function() {
                        
                        object.addCount();
						object.request(url, data, callback, responseCallback);
                        clearInterval(timer);
                        
                    }, 500);
					
				} else {
					
					callback({status: "ERROR"});
					
				}
				
			}
			
			xhr.open("POST", url);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send(this.encodeHTMLForm(data));
			
		} catch(e) {
			
		} finally {
			
		}
		
		return null;
			
	}
		
	Booking_App_XMLHttp.prototype.encodeHTMLForm = function(data){
		
    	var params = [];
		
		for( var name in data ){
			
        	var value = data[ name ];
			var param = encodeURIComponent( name ) + '=' + encodeURIComponent( value );
			
			params.push( param );
    	}
		
		return params.join( '&' ).replace( /%20/g, '+' );
		
	}
	
	Booking_App_XMLHttp.prototype.isJSON = function(arg){
		
		arg = (typeof arg === "function") ? arg() : arg;
	    if(typeof arg  !== "string") {
	        return false;
	    }
	    
	    try{
	    	arg = (!JSON) ? eval("(" + arg + ")") : JSON.parse(arg);
			return true;
	    }catch(e){
			return false;
	    }
		
	}
	
	