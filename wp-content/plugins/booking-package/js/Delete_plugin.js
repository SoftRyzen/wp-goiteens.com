/*globals delete_plugin_data */
/*globals booking_package_dictionary */
/*globals I18n */

window.addEventListener('load', function() {
    
    var delete_plugin = new Delete_Plugin(delete_plugin_data, booking_package_dictionary);
    
});

function Delete_Plugin(data, booking_package_dictionary) {
    
    this._i18n = new I18n(data.locale);
    this._i18n.setDictionary(booking_package_dictionary);
    this._isExtensionsValid = parseInt(data.isExtensionsValid);
    this._general_setting_url = data.general_setting_url;
    //this._pluginName = 'google-analytics-test';
    this._pluginName = 'booking-package';
    var plugin_table = document.getElementById('the-list');
    if (plugin_table == null) {
        
        return false;
        
    }
    
    if (this._isExtensionsValid == 1) {
        
        var plugins = plugin_table.getElementsByClassName('deactivate');
        var elements = null;
        var tr_list = plugin_table.getElementsByTagName('tr');
        for (var i = 0; i < tr_list.length; i++) {
            
            var tr = tr_list[i];
            if (tr.getAttribute('data-slug') == this._pluginName) {
                
                elements = tr.getElementsByClassName('deactivate');
                break;
                
            }
            
        }
        
        if (elements != null) {
            
            this.chengeElement(elements[0].getElementsByTagName('a'));
            
        }
        
    }
    
}

Delete_Plugin.prototype.chengeElement = function(elements) {
    
    var object = this;
    for (var i = 0; i < elements.length; i++) {
        
        var deactivateUrl = elements[i].href;
        elements[i].href = '';
        elements[i].onclick = function(event) {
            
            event.preventDefault();
            var message = object._i18n.get('You currently have a valid subscription. Do you want to deactivate the Booking Package?');
            if (confirm(message)) {
                
                window.location.href = deactivateUrl;
                
            } else {
                
                window.location.href = object._general_setting_url;
                
            }
            
        };
        
    }
    
}