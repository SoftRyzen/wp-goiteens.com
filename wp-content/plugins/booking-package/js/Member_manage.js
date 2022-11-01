/* globals scriptError */
/* globals I18n */
/* globals Booking_App_Calendar */
/* globals Booking_App_XMLHttp */
/* globals FORMAT_COST */
/* globals setting_data */
/* globals users_data */
/* globals booking_package_dictionary */
/* globals Booking_Package_Console */
/* globals Booking_Package_Hotel */

window.addEventListener('load', function(){
    
    new Member_manage(setting_data, users_data, booking_package_dictionary);
    
});

window.addEventListener('error', function(event) {
    
    var error = new scriptError(setting_data, booking_package_dictionary, event.message, event.filename, event.lineno, event.colno, event.error);
    error.send();
    
}, false);

/**
window.onerror = function(msg, url, line, col, error){
    
    console.error(url);
    console.error(msg);
    console.error(line);
    console.error(col);
    console.error(error);
    var script_error = new scriptError(setting_data, booking_package_dictionary, msg, url, line, col, error);
    script_error.send();
    
}
**/

function Member_manage(setting_data, users_data, booking_package_dictionary){
    
    var object = this;
    this._setting_data = setting_data;
    this._booking_package_dictionary = booking_package_dictionary;
    this._debug = new Booking_Package_Console(setting_data.debug);
    this._console = {};
    this._console.log = this._debug.getConsoleLog();
    object._console.log(setting_data);
    this._i18n = new I18n(null);
    this._i18n.setDictionary(booking_package_dictionary);
    this._url = setting_data.url;
    this._nonce = setting_data.nonce;
    this._action = setting_data.action;
    this._isExtensionsValid = parseInt(setting_data.isExtensionsValid);
    this._currency = setting_data.currency;
    this._limit = parseInt(setting_data.limit);
    this._offset = 0;
    this._blockPanel = document.getElementById("blockPanel");
    this._loadingPanel = document.getElementById("loadingPanel");
    this._editPanel = document.getElementById("editPanel");
    this._media_modal_close = document.getElementById("media_modal_close");
    this._usersInfo = users_data;
    this._users = {};
    this._authority = "user";
    this._keywords = null;
    this._calendar = null;
    this._selectedKey = null;
    this._dateFormat = setting_data.dateFormat;
    this._startOfWeek = setting_data.startOfWeek;
    this._positionOfWeek = setting_data.positionOfWeek;
    this._positionTimeDate = setting_data.positionTimeDate;
    this._clock = setting_data.clock;
    this._calendarAccountList = {};
    this._emailEnableList = {};
    
    this._weekName = [this._i18n.get('Sun'), this._i18n.get('Mon'), this._i18n.get('Tue'), this._i18n.get('Wed'), this._i18n.get('Thu'), this._i18n.get('Fri'), this._i18n.get('Sat')];
    this._hotel = new Booking_Package_Hotel(this._currency, this._weekName, this._dateFormat, this._positionOfWeek, this._positionTimeDate, this._startOfWeek, booking_package_dictionary, this._debug);
    this._booking_manage = new Booking_manage(setting_data, booking_package_dictionary);
    
    this._contentPanel = document.getElementById("media_frame_reservation_content");
    
    for (var key in setting_data.calendarAccountList) {
        
        var account = setting_data.calendarAccountList[key];
        object._calendarAccountList[parseInt(account.key)] = account;
        
    }
    
    for (var key in setting_data.emailEnableList) {
        
        var account = setting_data.emailEnableList[key];
        object._emailEnableList[parseInt(key)] = account;
        
    }
    
    
    var user_form_close = document.getElementById("booking-package-register_user_return_button");
    var user_edit_form_close = document.getElementById("booking-package-edit_user_return_button");
    user_form_close.classList.remove("hidden_panel");
    user_edit_form_close.classList.remove("hidden_panel");
    
    this._member_list_table_list = document.getElementById("member_list_table").getElementsByTagName("tr");
    object._console.log(this._member_list_table_list);
    for(var i = 0; i < this._member_list_table_list.length; i++){
        
        var tr = this._member_list_table_list[i];
        if(tr.id.length == 0){
            
            continue;
            
        }
        
        this._users[tr.id] = tr;
        object._console.log(tr);
        
    }
    
    user_form_close.onclick = function(){
        
        object._blockPanel.classList.add("hidden_panel");
        document.getElementById("booking-package-user-form").classList.add("hidden_panel");
        document.getElementById("booking-package-user-edit-form").classList.add("hidden_panel");
        var body = document.getElementsByTagName("body")[0];
        body.classList.remove("modal-open");
        
    }
    
    user_edit_form_close.onclick = function(){
        
        object._blockPanel.classList.add("hidden_panel");
        document.getElementById("booking-package-user-form").classList.add("hidden_panel");
        document.getElementById("booking-package-user-edit-form").classList.add("hidden_panel");
        var body = document.getElementsByTagName("body")[0];
        body.classList.remove("modal-open");
        
    }
    
    var add_member = document.getElementById("add_member");
    if(parseInt(this._isExtensionsValid) == 1){
        
        add_member.onclick = function(){
            
            object.userForm();
            
        }
        
    }else{
        
        add_member.disabled = true;
        
    }
    
    this._media_modal_close.onclick = function(event) {
        
        object._editPanel.classList.add("hidden_panel");
        object._blockPanel.classList.add("hidden_panel");
        if (document.getElementById("userInfoPanel") != null) {
            
            document.getElementById("userInfoPanel").remove("show_panel");
            
        }
        
        var body = document.getElementsByTagName("body")[0];
        body.classList.remove("modal-open");
        
    }
    
    this._blockPanel.onclick = function(event){
        
        var close = true;
        object._console.log(event);
        var path = event.path;
        if(path != null){
            
            for(var i = 0; i < path.length; i++){
                
                if(path[i].id == "booking-package-user-form" || path[i].id == "booking-package-user-edit-form"){
                    
                    close = false;
                    break;
                    
                }
                
            }
            
            if(close == true){
                
                this.classList.add("hidden_panel");
                object._editPanel.classList.add("hidden_panel");
                document.getElementById("booking-package-user-form").classList.add("hidden_panel");
                document.getElementById("booking-package-user-edit-form").classList.add("hidden_panel");
                var body = document.getElementsByTagName("body")[0];
                body.classList.remove("modal-open");
                
            }
            
        }
        
    }
    
    var member_limit = document.getElementById("member_limit");
    for(var i = 0; i < member_limit.options.length; i++){
        
        var option = parseInt(member_limit[i].value);
        if(option == this._limit){
            
            member_limit[i].selected = true;
            break;
            
        }
        
    }
    
    var swich_authority = document.getElementById("swich_authority");
    swich_authority.onchange = function(){
        
        var swich_authority = this;
        var value = swich_authority.value;
        object._console.log(value);
        object._authority = value;
        object._offset = 0;
        var index = member_limit.selectedIndex;
        var limit = member_limit.options[index].value;
        object.movePage("before_page", limit, null);
        
    }
    
    document.getElementById("before_page").onclick = function(){
        
        var index = member_limit.selectedIndex;
        var limit = member_limit.options[index].value;
        object.movePage("before_page", limit, null);
        
    }
    
    document.getElementById("next_page").onclick = function(){
        
        var index = member_limit.selectedIndex;
        var limit = member_limit.options[index].value;
        object.movePage("next_page", limit, null);
        
    }
    
    this.loadingPanel(0);
    object._console.log(this._users);
    this.start();
    this.lookingForUsers(member_limit.options[member_limit.selectedIndex].value);
    
}

Member_manage.prototype.loadingPanel = function(mode){
    
    if(mode == 1){
        
        this._loadingPanel.setAttribute("class", "loading_modal_backdrop");
        
    }else{
        
        this._loadingPanel.setAttribute("class", "hidden_panel");
        
    }
    
}

Member_manage.prototype.setUsersInfo = function(userInfo){
    
    this._usersInfo = userInfo;
    
}

Member_manage.prototype.getUsersInfo = function(){
    
    return this._usersInfo;
    
}

Member_manage.prototype.serachUser = function(id){
    
    if(this._usersInfo[id] != null){
        
        return this._usersInfo[id];
        
    }else {
        
        return 0;
        
    }
    
}

Member_manage.prototype.setUsers = function(users){
    
    this._users = users;
    
}

Member_manage.prototype.getUsers = function(){
    
    return this._users;
    
}

Member_manage.prototype.setKeywords = function(keywords) {
    
    this._keywords = keywords;
    
}

Member_manage.prototype.getKeywords = function() {
    
    return this._keywords;
    
}

Member_manage.prototype.setSelectedKey = function(_selectedKey){
    
    this._selectedKey = _selectedKey;
    
}

Member_manage.prototype.getSelectedKey = function(){
    
    return this._selectedKey;
    
}

Member_manage.prototype.start = function(){
    
    var object = this;
    var user_form = document.getElementById("booking-package-user-form");
    var user_edit_form = document.getElementById("booking-package-user-edit-form");
    var users = object.getUsers();
    for(var key in users){
        
        var user = users[key];
        user.onclick = function(){
            
            object._console.log(this);
            var id = this.id;
            var userInfo = object.serachUser(id);
            object._console.log(userInfo);
            if(userInfo != 0){
                
                object.editForm(this, userInfo);
                object._blockPanel.classList.remove("hidden_panel");
                if (object._contentPanel != null && document.getElementById("showUserInfo_blockPanel") != null) {
                    
                    object._contentPanel.removeChild(document.getElementById("showUserInfo_blockPanel"));
                    
                }
                object.bookedList(this, userInfo, 0);
                
                
            }
            
            
        }
        
    }
    
    
}

Member_manage.prototype.movePage = function(page, number, keywords){
    
    var object = this;
    object._console.log(page + " " + number);
    var offset = object._offset;
    number = parseInt(number);
    if(page == 'before_page'){
        
        if(offset > 0){
            
            offset = offset - object._limit;
            
        }
        
    }else if(page == "next_page"){
        
        offset = offset + object._limit;
        
    }
    
    object._console.log("offset = " + offset);
    
    object.loadingPanel(1);
    var user_edit_form = document.getElementById("booking-package-user-edit-form");
    var member_list_table = document.getElementById("member_list_table");
    var member_list_tbody = document.getElementById("member_list_tbody");
    var post = {mode: 'getMembers', nonce: object._nonce, action: object._action, page: page, number: number, offset: offset, authority: object._authority};
    keywords = object.getKeywords();
    if (keywords != null && keywords.length > 0) {
        
        post.keywords = keywords;
        
    }
    
    new Booking_App_XMLHttp(object._url, post, false, function(new_users){
        
        if (new_users.status == null && new_users.length != 0) {
            
            if (page != null) {
                
                object._limit = number;
                object._offset = offset;
                
            }
            
            var users = object.getUsers();
            object._console.log(users);
            for (var key in users) {
                
                var user = users[key];
                object._console.log(user);
                user.textContent = null;
                member_list_tbody.removeChild(user);
                
                
            }
            
            var userInfoList = {};
            var userList = {};
            for(var i = 0; i < new_users.length; i++){
                
                var user = new_users[i];
                userInfoList["user_id_" + user.ID] = user;
                
                var tr = document.createElement("tr");
                tr.id = "user_id_" + user.ID;
                tr.classList.add("tr_user");
                
                var tdId = document.createElement("td");
                //tdId.textContent = user.ID;
                
                var idSpan = document.createElement("span");
                idSpan.textContent = user.ID;
                idSpan.classList.add("userId");
                tdId.appendChild(idSpan);
                object._console.log(user);
                if (parseInt(user.status) == 0) {
                    
                    var priority_highSpan = document.createElement("span");
                    priority_highSpan.textContent = "priority_high";
                    priority_highSpan.setAttribute("class", "material-icons priority_high");
                    tdId.appendChild(priority_highSpan);
                    
                }
                tr.appendChild(tdId);
                
                
                var tdName = document.createElement("td");
                tdName.textContent = user.user_login;
                tr.appendChild(tdName);
                
                var tdEmail = document.createElement("td");
                tdEmail.textContent = user.user_email;
                tr.appendChild(tdEmail);
                
                var tdDate = document.createElement("td");
                tdDate.textContent = user.user_registered;
                tr.appendChild(tdDate);
                
                member_list_tbody.appendChild(tr);
                userList["user_id_" + user.ID] = tr;
                tr.onclick = function(){
                    
                    var id = this.id;
                    var userInfo = object.serachUser(id);
                    object._console.log(userInfo);
                    if(userInfo != 0){
                        
                        object.editForm(this, userInfo);
                        object._blockPanel.classList.remove("hidden_panel");
                        if (object._contentPanel != null && document.getElementById("showUserInfo_blockPanel") != null) {
                            
                            object._contentPanel.removeChild(document.getElementById("showUserInfo_blockPanel"));
                            
                        }
                        object.bookedList(this, userInfo, 0);
                        
                    }
                    
                }
                
            }
            
            object.setUsersInfo(userInfoList);
            object.setUsers(userList);
            
        }
        
        object.loadingPanel(0);
        
    });
    
    
};

Member_manage.prototype.bookedList = function(tr, userAccount, offset) {
    
    var object = this;
    object._console.log(userAccount);
    object._console.log("offset = " + offset);
    object._console.log(object._weekName);
    object._console.log(object._calendarAccountList);
    object._calendar = new Booking_App_Calendar(object._weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, 0, object._i18n, object._debug);
    object._calendar.setClock(object._clock);
    object._editPanel.classList.remove("hidden_panel");
    var edit_title = document.getElementById("edit_title");
    edit_title.textContent = userAccount.user_login;
    
    var reservation_usersPanel = document.getElementById("reservation_usersPanel");
    reservation_usersPanel.classList.remove("hidden_panel");
    reservation_usersPanel.textContent = null;
    
    var user_detail_panel = document.getElementById("user_detail_panel");
    user_detail_panel.classList.add("hidden_panel");
    
    var leftButtonPanel = document.getElementById("leftButtonPanel");
    leftButtonPanel.classList.remove("hidden_panel");
    
    var rightButtonPanel = document.getElementById("rightButtonPanel");
    rightButtonPanel.classList.add("hidden_panel");
    
    var selectedTab = "booked_list";
    var booked_list_tab = document.getElementById("booked_list");
    booked_list_tab.classList.add("active");
    booked_list_tab.removeEventListener("click", null);
    booked_list_tab.onclick = function(){
        
        object._console.log(this.id);
        if (selectedTab != this.id) {
            
            selectedTab = this.id;
            booked_list_tab.classList.add("active");
            edit_user_tab.classList.remove("active");
            reservation_usersPanel.classList.remove("hidden_panel");
            user_detail_panel.classList.add("hidden_panel");
            leftButtonPanel.classList.remove("hidden_panel");
            rightButtonPanel.classList.add("hidden_panel");
            
        }
        
    };
    
    var edit_user_tab = document.getElementById("edit_user");
    edit_user_tab.classList.remove("active");
    edit_user_tab.removeEventListener("click", null);
    edit_user_tab.onclick = function(){
        
        object._console.log(this.id);
        if (selectedTab != this.id) {
            
            selectedTab = this.id;
            booked_list_tab.classList.remove("active");
            edit_user_tab.classList.add("active");
            reservation_usersPanel.classList.add("hidden_panel");
            user_detail_panel.classList.remove("hidden_panel");
            object.editUser(tr, userAccount);
            leftButtonPanel.classList.add("hidden_panel");
            rightButtonPanel.classList.remove("hidden_panel");
            
        }
        
    };
    
    var beforButton = document.getElementById("beforButton");
    beforButton.removeEventListener("click", null);
    
    var nextButton = document.getElementById("nextButton");
    nextButton.removeEventListener("click", null);
    
    var body = document.getElementsByTagName("body")[0];
    body.classList.add("modal-open");
    
    var post = {mode: 'getUsersBookedList', nonce: object._nonce, action: object._action, user_id: userAccount.ID, offset: offset, authority: object._authority};
    object.loadingPanel(1);
    new Booking_App_XMLHttp(object._url, post, false, function(response){
        
        object._console.log(response);
        var responseOffset = 0;
        var responseLimit = 0;
        var nextClick = 0;
        var table = document.createElement("table");
        table.setAttribute("class", "wp-list-table widefat fixed striped");
        reservation_usersPanel.appendChild(table);
        if (response.status == 'success') {
            
            var bookedList = response.bookedList;
            responseOffset = parseInt(response.offset);
            responseLimit = parseInt(response.limit);
            nextClick = parseInt(response.next);
            for(var i = 0; i < bookedList.length; i++) {
            
                var userInfo = bookedList[i];
                object._console.log(userInfo);
                
                var line_tr = document.createElement("tr");
                line_tr.setAttribute("valign", "top");
                line_tr.setAttribute("data-key", i);
                table.appendChild(line_tr);
                
                var th = document.createElement("td");
                th.setAttribute("scope", "row");
                th.textContent = userInfo.key;
                line_tr.appendChild(th);
                
                var dateTd = document.createElement("td");
                dateTd.setAttribute("scope", "row");
                dateTd.textContent = object._calendar.formatBookingDate(userInfo.date.month, userInfo.date.day, userInfo.date.year, userInfo.date.hour, userInfo.date.min, userInfo.scheduleTitle, userInfo.date.week, 'text');
                line_tr.appendChild(dateTd);
                
                var accountTd = document.createElement("td");
                accountTd.setAttribute("scope", "row");
                accountTd.textContent = userInfo.accountKey;
                line_tr.appendChild(accountTd);
                
                if (object._calendarAccountList[parseInt(userInfo.accountKey)] != null) {
                    
                    if (object._calendarAccountList[parseInt(userInfo.accountKey)].type == 'hotel') {
                        
                        dateTd.textContent = object._calendar.formatBookingDate(userInfo.date.month, userInfo.date.day, userInfo.date.year, null, null, null, userInfo.date.week, 'text');
                        
                    } else {
                        
                        dateTd.textContent = object._calendar.formatBookingDate(userInfo.date.month, userInfo.date.day, userInfo.date.year, userInfo.date.hour, userInfo.date.min, userInfo.scheduleTitle, userInfo.date.week, 'text');
                        
                    }
                    
                    accountTd.textContent = object._calendarAccountList[parseInt(userInfo.accountKey)].name;
                    
                }
                
                var status = document.createElement("div");
                status.setAttribute("data-key", i);
                status.textContent = object._i18n.get(userInfo.status.toLowerCase());
                var statusClassName = "pendingLabel";
                if (userInfo.status.toLowerCase() == "approved") {
                    
                    statusClassName = "approvedLabel";
                    
                } else if (userInfo.status.toLowerCase() == "canceled") {
                    
                    statusClassName = "canceledLabel";
                    
                }
                status.classList.add(statusClassName);
                
                var td = document.createElement("td");
                td.setAttribute("scope", "row");
                td.appendChild(status);
                line_tr.appendChild(td);
                
                var statusClick = false;
                status.onclick = function(){
                    
                    var status = this;
                    var key = parseInt(this.getAttribute("data-key"));
                    object._console.log(key);
                    object._console.log(bookedList[key]);
                    if (bookedList[key].status != "canceled") {
                        
                        statusClick = true;
                        var emailEnableList = object._emailEnableList[parseInt(bookedList[key].accountKey)].emailMessageList;
                        object._console.log(emailEnableList);
                        object._console.log("enable = " + Boolean(parseInt(emailEnableList.mail_new_admin.enable)));
                        object._booking_manage.setEmailEnableList(emailEnableList);
                        object._booking_manage.changeStatus(bookedList[key].accountKey, bookedList[key], statusClick, false, function(response){
                            
                            object._console.log(bookedList[key]);
                            object._console.log(response);
                            statusClick = false;
                            if (response.status != null) {
                                
                                bookedList[key].status = response.status.toLowerCase();
                                var statusClassName = "pendingLabel";
                                if (response.status.toLowerCase() == "approved") {
                                    
                                    statusClassName = "approvedLabel";
                                    
                                } else if (response.status.toLowerCase() == "canceled") {
                                    
                                    statusClassName = "canceledLabel";
                                    
                                }
                                status.textContent = object._i18n.get(response.status.toLowerCase());
                                status.setAttribute("class", statusClassName);
                                
                            }
                            
                        });
                        
                    }
                    
                };
                
                line_tr.onclick = function(){
                    
                    if(statusClick == false){
                        
                        var key = parseInt(this.getAttribute("data-key"));
                        object._console.log(key);
                        object._console.log(bookedList[key]);
                        object.setSelectedKey(key);
                        object.showUserInfo(key, bookedList[key], true, bookedList[key].accountKey, function(response){
                            
                            object._console.log(response);
                            if(response.status == "returnButton"){
                                
                                object.reservation_users(reservation_usersPanel, response.month, response.day, response.year, calendarData, accountKey, callback);
                                
                            }else{
                                
                                //callback(response);
                                
                            }
                            
                        });
                        
                    }
                    
                };
                
            }
            
            beforButton.onclick = function() {
                
                offset = responseOffset - responseLimit;
                if (offset <= 0) {
                    
                    offset = 0;
                    
                }
                object._console.log("offset = " + offset);
                object._console.log(userAccount);
                object.bookedList(tr, userAccount, offset);
                
            };
            
            nextButton.onclick = function() {
                
                if (nextClick == 0) {
                    
                    return null;
                    
                }
                offset = responseOffset + responseLimit;
                object._console.log("offset = " + offset);
                object._console.log(userAccount);
                object.bookedList(tr, userAccount, offset);
                
            };
            
        }
        
        object.loadingPanel(0);
        
    });
    
    
}

Member_manage.prototype.showUserInfo = function(key, reservationData, animation, accountKey, callback) {
    
    var object = this;
    var options = "[]";
    object._buttonAction = "showUserInfo";
    object._console.log("key = " + key);
    object._console.log("buttonAction = " + object._buttonAction);
    object._console.log(reservationData);
    object._console.log(object._calendarAccountList);
    
    var calendarAccount = object._calendarAccountList[parseInt(reservationData.accountKey)];
    object._console.log(calendarAccount);
    var infoPanel = null;
    if (document.getElementById("userInfoPanel") == null) {
        
        infoPanel = document.createElement("div");
        infoPanel.id = "userInfoPanel";
        object._contentPanel.appendChild(infoPanel);
        
    } else {
        
        infoPanel = document.getElementById("userInfoPanel");
        
        
    }
    
    var blockPanel = null;
    if (animation === true) {
        
        infoPanel.setAttribute("class", "show_panel");
        
        blockPanel = document.createElement("div");
        blockPanel.id = "showUserInfo_blockPanel";
        blockPanel.setAttribute("class", "blockPanel");
        object._contentPanel.insertBefore(blockPanel, infoPanel);
        
    }
    
    if (blockPanel != null) {
        
        blockPanel.onclick = function(event) {
            
            object._console.log("blockPanel click");
            object._buttonAction = "reservation_users";
            if (document.getElementById("changePanel") != null) {
                
                document.getElementById("changePanel").setAttribute("class", "return_panel");
                
            }
            infoPanel.setAttribute("class", "return_panel");
            object._contentPanel.removeChild(blockPanel);
            
            //cancelToEdit();
            
            
        };
        
    }
    
    var bookingTimeChange = document.createElement("div");
    bookingTimeChange.setAttribute("data-status", "1");
    bookingTimeChange.setAttribute("class", "change hidden_panel");
    bookingTimeChange.textContent = object._i18n.get("Change");
    
    var courseChange = document.createElement("div");
    courseChange.setAttribute("data-status", "1");
    courseChange.setAttribute("class", "change hidden_panel");
    courseChange.textContent = object._i18n.get("Change");
    
    var response = object._booking_manage.showUserDetails(key, {account: calendarAccount, schedule: {}}, reservationData, calendarAccount.key, false, infoPanel, bookingTimeChange, courseChange, function(callback){
        
        object._console.log(callback);
        
    });
    
    
}

Member_manage.prototype.lookingForUsers = function(number) {
    
    var object = this;
    var offset = 0;
    var search_users_text = document.getElementById("search_users_text");
    var search_user_button = document.getElementById("search_user_button");
    var clear_user_button = document.getElementById("clear_user_button");
    var input_bool = true;
    if (search_users_text == null) {
        
        return false;
        
    }
    
    
    search_users_text.onkeydown = function(event) {
        
        object._console.log(event.key);
        var text = this;
        if (event.key != null && event.key.toLocaleLowerCase() == 'enter') {
            
            send(text);
            
        }
        
    };
    
    search_user_button.onclick = function() {
        
        send(search_users_text);
        
    };
    
    clear_user_button.onclick = function() {
        
        search_users_text.value = null;
        var member_limit = document.getElementById("member_limit");
        var index = member_limit.selectedIndex;
        var limit = member_limit.options[index].value;
        object._offset = 0;
        object.setKeywords(null);
        object.movePage(null, limit, null);
        
    }
    
    function send(text) {
        
        var keywords = text.value;
        keywords = keywords.replace(/[\u{20}\u{3000}]/ug ,' ');
        keywords = keywords.replace(/[\x20\u3000]/g ,' ');
        keywords = keywords.trim(keywords);
        if (keywords.length == 0) {
            
            object.setKeywords(null);
            return null;
            
        } else {
            
            var member_limit = document.getElementById("member_limit");
            var index = member_limit.selectedIndex;
            var limit = member_limit.options[index].value;
            object._offset = 0;
            object.setKeywords(keywords);
            object.movePage(null, limit, keywords);
            
        }
        object._console.log(number);
        object._console.log(keywords);
        
        /**
        var post = {mode: 'getMembers', nonce: object._nonce, action: object._action, page: 0, number: number, offset: offset, authority: object._authority, keyword: keywords};
        new Booking_App_XMLHttp(object._url, post, false, function(new_users){
            
            object._console.log(new_users);
            
        });
        **/
        
    };
    
};

Member_manage.prototype.editUser = function(tr, user){
    
    var object = this;
    object._console.log(user);
    object._console.log(tr);
    var user_login = document.getElementById("user_edit_login");
    var user_email = document.getElementById("user_edit_email");
    var user_status = document.getElementById("user_edit_status");
    var user_pass = document.getElementById("user_edit_pass");
    var user_pass_change_button = document.getElementById("user_edit_change_password_button");
    var upload_button = document.getElementById("edit_user_button");
    var delete_button = document.getElementById("edit_user_delete_button");
    
    user_pass.classList.add("hidden_panel");
    user_pass_change_button.classList.remove("hidden_panel");
    
    user_login.textContent = user.user_login;
    user_email.value = user.user_email;
    if (parseInt(user.status) == 1) {
        
        user_status.checked = true;
        
    } else {
        
        user_status.checked = false;
        
    }
    
    user_pass_change_button.onclick = function(event){
        
        user_pass.classList.remove("hidden_panel");
        user_pass_change_button.classList.add("hidden_panel");
        
    };
    
    upload_button.onclick = function(event){
        
        var updata = true;
        user_email.parentElement.classList.remove("errorPanel");
        user_pass.parentElement.classList.remove("errorPanel");
        if(!user_email.value.match(/.+@.+\..+/)){
            
            updata = false;
            user_email.parentElement.classList.add("errorPanel");
            
        }
        
        if(user_pass.value.length > 0 && user_pass.value.length < 8){
            
            updata = false;
            user_pass.parentElement.classList.add("errorPanel");
            
        }
        
        var post = {mode: 'updateUser', nonce: object._nonce, action: object._action, user_login: user.user_login};
        if(user_status.checked == true){
            
            post.status = 1;
            
        }else{
            
            post.status = 0;
            
        }
        object._console.log(post);
        if (updata == true) {
            
            post.user_email = user_email.value;
            if (user_pass.value.length != 0) {
                
                post.user_pass = user_pass.value;
                
            }
            object._console.log(post);
            
            object.loadingPanel(1);
            new Booking_App_XMLHttp(object._url, post, false, function(response){
                
                object._console.log(response);
                if (response.status == 'success') {
                    
                    user.user_email = post.user_email;
                    user.status = post.status;
                    tr.textContent = null;
                    var tdList = ["ID", "user_login", "user_email", "user_registered"];
                    for (var i = 0; i < tdList.length; i++) {
                        
                        var td = document.createElement("td");
                        if (tdList[i] == "ID") {
                            
                            var idSpan = document.createElement("span");
                            idSpan.textContent = user[tdList[i]];
                            idSpan.classList.add("userId");
                            td.appendChild(idSpan);
                            if (parseInt(user.status) == 0) {
                                
                                var priority_highSpan = document.createElement("span");
                                priority_highSpan.textContent = "priority_high";
                                priority_highSpan.setAttribute("class", "material-icons priority_high");
                                td.appendChild(priority_highSpan);
                                
                            }
                            
                        } else {
                            
                            td.textContent = user[tdList[i]];
                            
                        }
                        
                        tr.appendChild(td);
                        
                    }
                    
                }
                
                object.loadingPanel(0);
                
            });
            
        }
        
    };
    
    delete_button.onclick = function(event){
        
        var post = {mode: 'deleteUser', nonce: object._nonce, action: object._action, user_login: user.user_login};
        if(window.confirm(object._i18n.get('Do you delete the "%s"?', [user.user_login]))){
            
            object._console.log(post);
            object.loadingPanel(1);
            new Booking_App_XMLHttp(object._url, post, false, function(response){
                
                object._console.log(response);
                if(response.status == 'success'){
                    
                    object._editPanel.classList.add("hidden_panel");
                    object._blockPanel.classList.add("hidden_panel");
                    var body = document.getElementsByTagName("body")[0];
                    body.classList.remove("modal-open");
                    
                    var member_limit = document.getElementById("member_limit");
                    var index = member_limit.selectedIndex;
                    var limit = member_limit.options[index].value;
                    object.movePage(null, limit, null);
                    
                }else if(response.status == 'error'){
                    
                    window.alert(response.error_messages);
                    
                }
                
                object.loadingPanel(0);
                
            });
            
        }
        
    };
    
};

Member_manage.prototype.editForm = function(tr, user){
    
    var object = this;
    object._console.log(user);
    var tabFrame = document.getElementById("booking-package-tabFrame");
    var user_profile_tab = document.getElementById("booking-package-user_profile_tab");
    var user_subscribed_tab = document.getElementById("booking-package-user_subscribed_tab");
    var user_profile = document.getElementById("booking-package-user-profile");
    var user_subscribed = document.getElementById("booking-package-user-subscribed");
    var user_subscribed_tbody = document.getElementById("booking-package-user_subscribed_tbody");
    
    var user_edit_form = document.getElementById("booking-package-user-edit-form");
    var user_login = document.getElementById("booking-package-user_edit_login");
    var user_email = document.getElementById("booking-package-user_edit_email");
    var user_status = document.getElementById("booking-package-user_edit_status");
    var user_pass = document.getElementById("booking-package-user_edit_pass");
    var user_pass_change_button = document.getElementById("booking-package-user_edit_change_password_button");
    var upload_button = document.getElementById("booking-package-edit_user_button");
    var delete_button = document.getElementById("booking-package-edit_user_delete_button");
    var user_form_close = document.getElementById("booking-package-edit_user_return_button");
    var user_edit_form_close = document.getElementById("booking-package-edit_user_delete_button");
    
    tabFrame.classList.remove("hidden_panel");
    user_profile_tab.classList.add("active");
    user_subscribed_tab.classList.remove("active");
    user_profile.classList.remove("hidden_panel");
    user_subscribed.classList.add("hidden_panel");
    user_form_close.classList.remove("hidden_panel");
    user_edit_form_close.classList.remove("hidden_panel");
    
    user_pass_change_button.setAttribute("class", "w3tc-button-save button-primary");
    upload_button.setAttribute("class", "w3tc-button-save button-primary sendButton");
    user_pass.classList.add("hidden_panel");
    user_pass_change_button.classList.remove("hidden_panel");
    
    delete_button.setAttribute("class", "w3tc-button-save button-primary return_button");
    
    var tabs = {user_profile_tab: {tab: user_profile_tab, panel: user_profile, options: [upload_button, delete_button]}, user_subscribed_tab: {tab: user_subscribed_tab, panel: user_subscribed, options: []}};
    for(var key in tabs){
        
        var menu = tabs[key];
        menu.tab.onclick = function(){
            
            var id = this.id;
            object._console.log(id);
            for(var key in tabs){
                
                var menu = tabs[key];
                var options = menu.options;
                if(menu.tab.id == id){
                    
                    menu.tab.classList.add("active");
                    menu.panel.classList.remove("hidden_panel");
                    for(var i = 0; i < options.length; i++){
                        
                        options[i].classList.remove("hidden_panel");
                        
                    }
                    
                }else{
                    
                    menu.tab.classList.remove("active");
                    menu.panel.classList.add("hidden_panel");
                    for(var i = 0; i < options.length; i++){
                        
                        options[i].classList.add("hidden_panel");
                        
                    }
                    
                }
                
            }
            
        }
        
    }
    
    user_login.value = user.user_login;
    user_email.value = user.user_email;
    if(parseInt(user.status) == 1){
        
        user_status.checked = true;
        
    }else{
        
        user_status.checked = false;
        
    }
    
    user_subscribed_tbody.textContent = null;
    var cost = new FORMAT_COST(object._i18n, object._debug);
    var subscription_list = user.subscription_list;
    if(subscription_list == null){
        
        subscription_list = {};
        
    }
    object._console.log(subscription_list);
    if(Object.keys(subscription_list).length == 0){
        
        user_subscribed_tbody.textContent = object._i18n.get("There are no items subscribed.");
        
    }
    
    for(var key in subscription_list){
        
        var product = subscription_list[key];
        var items = product.items;
        var currency = null;
        var amount = 0;
        object._console.log(product);
        for(var i = 0; i < items.length; i++){
            
            var item = items[i];
            currency = item.currency;
            amount += parseInt(item.amount);
            object._console.log(item);
            
        }
        
        amount = cost.formatCost(amount, currency);
        
        var amountPanel = document.createElement("div");
        amountPanel.textContent = object._i18n.get("%s per month", [amount]);
        
        var expirationDate = document.createElement("div");
        expirationDate.textContent = object._i18n.get("Expiration date: %s", [product.period_end_date]);
        
        //You can reserve 5 more times by the expiration date.
        //You can make a reservation 5 times by the expiration date.
        
        var itemPanel = document.createElement("div");
        itemPanel.textContent = product.name;
        
        var itemTd = document.createElement("td");
        itemTd.appendChild(itemPanel);
        itemTd.appendChild(amountPanel);
        itemTd.appendChild(expirationDate);
        
        var deleteTd = document.createElement("td");
        deleteTd.setAttribute("data-key", key);
        deleteTd.setAttribute("style",  "font-family: 'Material Icons' !important;");
        deleteTd.setAttribute("class", "material-icons delete_icon");
        deleteTd.textContent = "delete";
        
        var tr = document.createElement("tr");
        tr.id = object._prefix + key;
        tr.appendChild(itemTd);
        tr.appendChild(deleteTd);
        if(product.canceled != null && parseInt(product.canceled) == 1){
            
            tr.classList.add("canceled");
            deleteTd.setAttribute("style", "cursor: not-allowed; font-family: 'Material Icons' !important;");
            
        }
        
        
        user_subscribed_tbody.appendChild(tr);
        
        deleteTd.onclick = function(){
            
            var deleteTd = this;
            var key = this.getAttribute("data-key");
            var product = subscription_list[key];
            object._console.log(product);
            if(product.canceled != null && parseInt(product.canceled) == 1){
                
                return null;
                
            }
            
            if(window.confirm(object._i18n.get('If you cancel the "%s" subscription, you can not make a reservation after the deadline of %s. Do you really want to cancel the subscription?', [product.name, product.period_end_date]))){
                
                deleteSubscription(user, product, function(response){
                    
                    var tr = document.getElementById(object._prefix + key);
                    if(response.status == 1){
                        
                        subscription_list[key]['canceled'] = 1;
                        tr.classList.add("canceled");
                        deleteTd.setAttribute("style", "cursor: not-allowed; font-family: 'Material Icons' !important;");
                        
                    }else{
                        
                        window.alert(response.error);
                        delete subscription_list[key];
                        user_subscribed_tbody.removeChild(tr);
                        
                    }
                    
                });
                
            }
            
        }
        
    }
    
    var deleteSubscription = function(user, product, callback){
        
        object._console.log(user);
        object._console.log(product);
        
        var post = {mode: 'deleteSubscription', nonce: object._nonce, action: object._action, userId: user.ID, product: product.product};
        object._console.log(post);
        
        object.loadingPanel(1);
        new Booking_App_XMLHttp(object._url, post, false, function(response){
            
            object._console.log(response);
            if(parseInt(response.status) == 1){
                
                callback({stats: 1, error: null});
                
            }else{
                
                callback({stats: 0, error: response.error});
                
            }
            
            object.loadingPanel(0);
            
        });
        
    }
    
    user_pass_change_button.onclick = function(event){
        
        user_pass.classList.remove("hidden_panel");
        user_pass_change_button.classList.add("hidden_panel");
        
    }
    
    upload_button.onclick = function(event){
        
        var updata = true;
        user_email.parentElement.classList.remove("errorPanel");
        user_pass.parentElement.classList.remove("errorPanel");
        if(!user_email.value.match(/.+@.+\..+/)){
            
            updata = false;
            user_email.parentElement.classList.add("errorPanel");
            
        }
        
        if(user_pass.value.length > 0 && user_pass.value.length < 8){
            
            updata = false;
            user_pass.parentElement.classList.add("errorPanel");
            
        }
        
        var post = {mode: 'updateUser', nonce: object._nonce, action: object._action, user_login: user.user_login};
        if(user_status.checked == true){
            
            post.status = 1;
            
        }else{
            
            post.status = 0;
            
        }
        
        
        if(updata == true){
            
            post.user_email = user_email.value;
            if(user_pass.value.length != 0){
                
                post.user_pass = user_pass.value;
                
            }
            object._console.log(post);
            
            object.loadingPanel(1);
            new Booking_App_XMLHttp(object._url, post, false, function(response){
                
                object._console.log(response);
                if(response.status == 'success'){
                    
                    user.user_email = post.user_email;
                    user.status = post.status;
                    tr.textContent = null;
                    var tdList = ["ID", "user_login", "user_email", "user_registered"];
                    for(var i = 0; i < tdList.length; i++){
                        
                        var td = document.createElement("td");
                        if(tdList[i] == "ID"){
                            
                            var idSpan = document.createElement("span");
                            idSpan.textContent = user[tdList[i]];
                            idSpan.classList.add("userId");
                            td.appendChild(idSpan);
                            if(parseInt(user.status) == 0){
                                
                                var priority_highSpan = document.createElement("span");
                                priority_highSpan.textContent = "priority_high";
                                priority_highSpan.setAttribute("class", "material-icons priority_high");
                                td.appendChild(priority_highSpan);
                                
                            }
                            
                        }else{
                            
                            td.textContent = user[tdList[i]];
                            
                        }
                        
                        //td.textContent = user[tdList[i]];
                        tr.appendChild(td);
                        
                    }
                    
                }
                
                user_edit_form.classList.add("hidden_panel");
                object._blockPanel.classList.add("hidden_panel");
                object.loadingPanel(0);
                
            });
            
        }
        
    }
    
    delete_button.onclick = function(){
        
        var post = {mode: 'deleteUser', nonce: object._nonce, action: object._action, user_login: user.user_login};
        if(window.confirm(object._i18n.get('Do you delete the "%s"?', [user.user_login]))){
            
            object._console.log(post);
            object.loadingPanel(1);
            new Booking_App_XMLHttp(object._url, post, false, function(response){
                
                object._console.log(response);
                if(response.status == 'success'){
                    
                    user_edit_form.classList.add("hidden_panel");
                    object._blockPanel.classList.add("hidden_panel");
                    
                    var member_limit = document.getElementById("member_limit");
                    var index = member_limit.selectedIndex;
                    var limit = member_limit.options[index].value;
                    object.movePage(null, limit, null);
                    
                }else if(response.status == 'error'){
                    
                    window.alert(response.error_messages);
                    
                }
                
                object.loadingPanel(0);
                
            });
            
        }
        
    }
    
}

Member_manage.prototype.userForm = function(){
    
    var object = this;
    object._console.log("userForm");
    if(parseInt(object._isExtensionsValid) == 1){
        
        document.getElementById("booking-package-user_regist_message").textContent = null;
        var user_form = document.getElementById("booking-package-user-form");
        user_form.classList.remove("hidden_panel");
        var user_form_close = document.getElementById("booking-package-edit_user_return_button");
        user_form_close.classList.remove("hidden_panel");
        object._blockPanel.classList.remove("hidden_panel");
        var register_button = document.getElementById("booking-package-register_user_button");
        register_button.setAttribute("class", "w3tc-button-save button-primary sendButton");
        register_button.onclick = function(){
            
            var user_data = {
                user_login: document.getElementById("booking-package-user_login"),
                user_email: document.getElementById("booking-package-user_email"),
                user_pass: document.getElementById("booking-package-user_pass"),
            };
            
            var registering = true;
            var post = {mode: 'createUser', nonce: object._nonce, action: object._action};
            for(var key in user_data){
                
                var panel = user_data[key].parentElement;
                panel.classList.remove("errorPanel");
                object._console.log(panel);
                
                var value = user_data[key].value;
                post[key] = value;
                object._console.log(key + " = " + value);
                
                if(key == 'user_login' && (value.length < 4 || !value.match(/^[A-Za-z0-9.-_]*$/))){
                    
                    registering = false;
                    panel.classList.add("errorPanel");
                    console.error("error key = " + key + " value = " + value);
                    
                }
                
                if(key == 'user_email' && !value.match(/.+@.+\..+/)){
                    
                    registering = false;
                    panel.classList.add("errorPanel");
                    console.error("error key = " + key + " value = " + value);
                    
                }
                
                if(key == 'user_pass' && value.length < 8){
                    
                    registering = false;
                    panel.classList.add("errorPanel");
                    console.error("error key = " + key + " value = " + value);
                    
                }
                
            }
            
            object._console.log(post);
            if(registering == true){
                
                object._console.log(post);
                object.loadingPanel(1);
                new Booking_App_XMLHttp(object._url, post, false, function(response){
                    
                    object._console.log(response);
                    if(response.status == 'success'){
                        
                        user_form.classList.add("hidden_panel");
                        object._blockPanel.classList.add("hidden_panel");
                        
                        var member_limit = document.getElementById("member_limit");
                        var index = member_limit.selectedIndex;
                        var limit = member_limit.options[index].value;
                        object.movePage(null, limit, null);
                        
                    }else if(response.status == 'error'){
                        
                        window.alert(response.error_messages);
                        
                    }
                    
                    object.loadingPanel(0);
                    
                });
                
            }
            
        }
        
    }
    
    
}