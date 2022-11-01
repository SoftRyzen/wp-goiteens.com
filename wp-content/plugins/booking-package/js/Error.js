    function scriptError(data, dictionary, msg, url, line, col, error) {
        
        this._data = data;
        this._dictionary = dictionary;
        this._msg = msg;
        this._url = url;
        this._line = line;
        this._col = col;
        this._error = error;
        this._function = {};
        this._responseText = null;
        
        var locale = 'en_US';
        if (data != null && data.locale != null) {
            
            locale = data.locale;
            
        }
        
        this._i18n = new I18n(locale);
        this._i18n.setDictionary(dictionary);
        
    }
    
    scriptError.prototype.setResponseText = function(responseText) {
        
        this._responseText = responseText;
        
    }
    
    scriptError.prototype.getResponseText = function() {
        
        return this._responseText;
        
    }
    
    scriptError.prototype.setFunction = function(object) {
        
        this._function = object;
        
    }
    
    scriptError.prototype.send = function() {
        
        var object = this;
        var javascriptFileslist = this._data.javascriptFileslist;
        if (this._error == null) {
            
            this._error = {stack: null};
            
        }
        
        var parser = null;
        var file = "";
        if (this._url.length > 0) {
            
            parser = new URL(this._url);
            file = parser.pathname.split('/').pop();
            var bool = false;
            for (var i = 0; i < javascriptFileslist.length; i++) {
                
                if(javascriptFileslist[i] == file){
                    
                    bool = true;
                    break;
                    
                }
                
            }
            
            if (bool == false) {
                
                return {status: "error", message: "no file"};
                
            }
            
        }
        
        var values = JSON.stringify(this._function.post);
        
        if (parseInt(this._data.javascriptSyntaxErrorNotification) == 1) {
            
            var post = {
                mode: 'scriptError', 
                type: 'JavaScript',
                file: file,
                nonce: this._data.nonce, 
                action: this._data.action, 
                msg: this._msg, 
                url: this._url, 
                line: this._line, 
                col: this._col, 
                error: this._error.stack,
                version: window.navigator.appVersion,
                code: window.navigator.appCodeName,
                browser: window.navigator.userAgent,
                name: this._function.name,
                values: values,
                page: window.location.href,
            };
            
            var responseText = object.getResponseText();
            if (typeof responseText == 'string') {
                
                post.responseText = responseText;
                
            }
            
            fetch(this._url)
                .then(response => response.text()).then(function (text) {
                    
                    var lines = text.split("\n");
                    post.source = lines[object._line - 1];
                    console.error(post.source);
                    var xmlHttp = new Booking_App_XMLHttp(object._data.url, post, 0, function(response){
                        
                        object.setResponseText(null);
                        
                    });
                    
                }
            );
            
            
        } else {
            
        }
        
    }
    
    
