    function I18n(locale) {
        
        this._locale = locale;
        
    }
    
    I18n.prototype.setLocale = function(locale){
        
        this._locale = locale;
        
    }
    
    I18n.prototype.setDictionary = function(dictionary){
        
        this._dictionary = dictionary;
        
    }
    
    I18n.prototype.get = function(str, args){
        
        var value = str;
        if(this._dictionary == null){
            
            return value;
            
        }
        
        if(this._dictionary[str] != null){
            
            value = this._dictionary[str];
            
        }
        
        if(args != null && typeof args == 'object'){
            
            var ph = true;
            if (value.indexOf('%s', 0) != -1) {
                
                ph = false;
                
            }
            
            if(args.length == 1){
                
                if(ph === true){
                    
                    value = value.replace(/%1$s/g, args[0]);
                    
                }else{
                    
                    value = value.replace(/%s/g, args[0]);
                    
                }
                
            }else{
                
                for(var i = 0; i < args.length; i++){
                    
                    var n = i + 1;
                    if(ph === true){
                        
                        value = value.replace('%' + n + '$s', args[i]);
                        
                    }else{
                        
                        value = value.replace('%s', args[i]);
                        
                    }
                    
                }
                
            }
            
        }
        
        return value;
        
    }
    
