/* globals Booking_App_XMLHttp */
/* globals Booking_App_Calendar */
/* globals scriptError */
/* globals I18n */
/* globals FORMAT_COST */
/* globals Booking_Package_Hotel */
/* globals TAXES */
/* globals Confirm */
/* globals Booking_Package_Console */
/* globals Booking_Package_Input */
/* globals Booking_App_ObjectsControl */

var schedule_data = schedule_data;
var booking_package_dictionary = booking_package_dictionary;
var booking_manage = null;

window.addEventListener('load', function(){
    
    if(schedule_data != null && booking_package_dictionary != null){
        
        booking_manage = new Booking_manage(schedule_data, booking_package_dictionary, false);
        booking_manage.start();
        
    }
    
});

window.addEventListener('error', function(event) {
    
    var error = new scriptError(schedule_data, booking_package_dictionary, event.message, event.filename, event.lineno, event.colno, event.error);
    error.send();
    
}, false);

var changeStatusForDashboard = function(button, key, cancellationToken, accountKey, status, month, day, year){
    
    var visitor = {key: key, cancellationToken: cancellationToken, accountKey: accountKey, status: status, date: {month: month, day: day, year: year}};
    
    if(booking_manage != null){
        console.log(visitor);
        booking_manage.changeStatusForDashboard(button, visitor);
        
    }
    
};


function Booking_manage(schedule_data, booking_package_dictionary, webApp) {
    
    var object = this;
    this._debug = new Booking_Package_Console(schedule_data.debug);
    this._console = {};
    this._console.log = this._debug.getConsoleLog();
    object._console.log(booking_package_dictionary);
    
    this._schedule_data = schedule_data;
    this._calendarAccountList = schedule_data.calendarAccountList;
    this._dashboardRequest = schedule_data.dashboardRequest;
    this._webApp = webApp;
    
    this._i18n = new I18n(schedule_data.locale);
    this._i18n.setDictionary(booking_package_dictionary);
    this._format = new FORMAT_COST(this._i18n, this._debug);
    this._hotel = null;
    this._servicesControl = new Booking_App_ObjectsControl(schedule_data, booking_package_dictionary);
    
    this._blockPanel = document.getElementById("blockPanel");
    this._loadingPanel = document.getElementById("loadingPanel");
    
    this._isExtensionsValid = parseInt(schedule_data.isExtensionsValid);
    this._prefix = schedule_data.prefix;
    this._url = schedule_data.url;
    this._nonce = schedule_data.nonce;
    this._nonce_download = schedule_data.nonce_download;
    this._action = schedule_data.action;
    this._currency = schedule_data.currency;
    this._dateFormat = schedule_data.dateFormat;
    this._positionOfWeek = schedule_data.positionOfWeek;
    this._positionTimeDate = schedule_data.positionTimeDate;
    this._courseList = schedule_data.courseList;
    this._formData = schedule_data.formData;
    this._courseName = schedule_data.courseName;
    this._buttonAction = null;
    this._selectedKey = null;
    this._visitors = {};
    this._emailEnableList = schedule_data.emailEnable;
    this._startOfWeek = schedule_data.startOfWeek;
    this._clock = "24hours";
    this._nationalHoliday = {};
    this._preparationTime = 0;
    this._positionPreparationTime = 'before_after';
    this._function = {name: "root", post: {}};
    this._taxes = [];
    this._calendarAccount = [];
    this._services = [];
    this._visitorServices = [];
    this._leftButtonPanel = null;
    this._rightButtonPanel = null;
    this._responseText = "";
    this._userInformation = {};
    this._maxApplicantCount = 0;
    this._guestsList = [];
    this._guestForDayOfTheWeekRates = 0;
    
    if (schedule_data.guestForDayOfTheWeekRates != null) {
            
            this._guestForDayOfTheWeekRates = parseInt(schedule_data.guestForDayOfTheWeekRates);
            
        }
    
    if (schedule_data.clock != null) {
        
        this._clock = schedule_data.clock;
        
    }
    
    this._monthFullName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var weekName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    
    this._calendar = null;
    
    this._htmlTitle = null;
    if (document.getElementsByTagName("title") != null && document.getElementsByTagName("title").length > 0) {
        
        this._htmlTitle = document.getElementsByTagName("title")[0];
        
    }
    
    if (schedule_data.bookingBool == 1) {
        
        this._hotel = new Booking_Package_Hotel(this._currency, weekName, this._dateFormat, this._positionOfWeek, this._positionTimeDate, this._startOfWeek, booking_package_dictionary, this._debug);
        this._hotel.setBooking_App_ObjectsControl(this._servicesControl);
        this._hotel._guestForDayOfTheWeekRates = this._guestForDayOfTheWeekRates;
        this._blockPanel = document.getElementById("blockPanel");
        this._contentPanel = document.getElementById("media_frame_reservation_content");
        this._editPanel = document.getElementById("editPanel");
        this._loadingPanel = document.getElementById("loadingPanel");
        this._buttonPanel = document.getElementById("buttonPanel");
        this._leftButtonPanel = document.getElementById("leftButtonPanel");
        this._rightButtonPanel = document.getElementById("rightButtonPanel");
        
        this._courseBool = false;
        if(schedule_data.courseBool == 'true'){
            
            this._courseBool = true;
            
        }
        
        this._blockPanel.onclick = function(){
            
            object._leftButtonPanel.textContent = null;
            object._rightButtonPanel.textContent = null;
            object.editPanelShow(false);
            
        };
        
        document.getElementById("media_modal_close").onclick = function(){
            
            object._leftButtonPanel.textContent = null;
            object._rightButtonPanel.textContent = null;
            object.editPanelShow(false);
            
        };
        
    } else if (schedule_data.bookedList == 'userBookingDetails') {
        
        this._hotel = new Booking_Package_Hotel(this._currency, weekName, this._dateFormat, this._positionOfWeek, this._positionTimeDate, this._startOfWeek, booking_package_dictionary, this._debug);
        this._hotel.setBooking_App_ObjectsControl(this._servicesControl);
        this._hotel._guestForDayOfTheWeekRates = this._guestForDayOfTheWeekRates;
        
    }
    
    if (schedule_data.bookedList == 1) {
        
        this._hotel = new Booking_Package_Hotel(this._currency, weekName, this._dateFormat, this._positionOfWeek, this._positionTimeDate, this._startOfWeek, booking_package_dictionary, this._debug);
        this._hotel.setBooking_App_ObjectsControl(this._servicesControl);
        this._hotel._guestForDayOfTheWeekRates = this._guestForDayOfTheWeekRates;
        
    }
    
    this.start = function(){
        
        var object = this;
        var accountKey = this.getCookie(this._schedule_data.prefix + "accountKey");
        object._console.log("accountKey = " + accountKey);
        object._console.log(this._schedule_data);
        if (accountKey == null) {
            
            for (var i in this._schedule_data.calendarAccountList) {
                
                accountKey = this._schedule_data.calendarAccountList[i].key;
                break;
                
            }
            
            
        } else {
            
            var status = false;
            //for(var i = 0; i < this._schedule_data.calendarAccountList.length; i++){
            for(var i in this._schedule_data.calendarAccountList){
                
                var calendarAccount = this._schedule_data.calendarAccountList[i];
                if (accountKey == calendarAccount.key) {
                    
                    status = true;
                    break;
                    
                }
                
            }
            
            if (status == false) {
                
                for (var i in this._schedule_data.calendarAccountList) {
                    
                    object._console.log(this._schedule_data.calendarAccountList[i]);
                    accountKey = this._schedule_data.calendarAccountList[i].key;
                    break;
                    
                }
                
            }
            
        }
        
        var dashboardRequest = this._schedule_data.dashboardRequest;
        try {
            
            object._console.log(dashboardRequest);
            if(dashboardRequest == null || dashboardRequest.status == null){
                
                throw "Error dashboardRequest";
                
            }
            
            if (dashboardRequest.status == 1) {
                
                this.getReservationData(parseInt(dashboardRequest.month), parseInt(dashboardRequest.day), parseInt(dashboardRequest.year), accountKey, 1);
                
            } else {
                
                this.getReservationData(parseInt(this._schedule_data.month), parseInt(this._schedule_data.day), parseInt(this._schedule_data.year), accountKey, 1);
                
            }
            
        } catch(error) {
            
            //console.error(error);
            
        }
        
        
    };
    
    this.getCookie = function(c_name){
        
        var object = this;
        object._console.log("c_name = " + c_name);
        if(document.cookie.length > 0){
            
            var st = document.cookie.indexOf(c_name + "=");
            object._console.log(st);
            if(st != -1){
                
                st = st + c_name.length + 1;
                var ed = document.cookie.indexOf(";", st);
                if(ed == -1){
                    
                    ed = document.cookie.length;
                    
                }
                
                var value = unescape(document.cookie.substring(st, ed));
                object._console.log("value = " + value);
                return value;
                
            }else {
                
                return null;
                
            }
            
        }
        
    };
    
    this.setFunction = function(name, post){
        
        this._function = {name: name, post: post};
        
    };
    
    this.getFunction = function(){
        
        return this._function;
        
    };
    
    this.getServices = function() {
        
        return this._services;
        
    };
    
    this.setEmailEnableList = function(emailEnableList) {
        
        this._emailEnableList = emailEnableList;
        
    };
    
    this.lookingForServices = function(service) {
        
        var services = this._services;
        for (var key in services) {
            
            if (parseInt(services[key].key) == parseInt(service.key)) {
                
                return true;
                
            }
            
        }
        
        return false;
        
    };
    
    this.resetServices = function() {
        
        this._services = [];
        
    };
    
    this.setServices = function(updateServices) {
        
        this._services = updateServices;
        
    };
    
    this.addServices = function(service) {
        
        this._services.push(service);
        
    };
    
    this.resetVisitorServices = function() {
        
        this._visitorServices = [];
        
    };
    
    this.setVisitorServices = function(services) {
        
        //this._visitorServices = [];
        if (this._visitorServices.length == 0) {
            
            for (var key in services) {
                
                services[key].selectedOptionsList = services[key].options;
                //this._visitorServices.push(services[key]);
                
            }
            
        }
        
        //this._visitorServices = JSON.parse(JSON.stringify(services));
        object._visitorServices = services.map( list => ({...list}));
        this._console.log(this._visitorServices);
        
    };
    
    this.lookingForVisitorServices = function(target) {
        
        var services = this._visitorServices;
        this._console.log(this._visitorServices);
        for (var key in services) {
            
            if (parseInt(services[key].key) == parseInt(target.key) && parseInt(services[key].selected) == 1) {
                
                return true;
                
            }
            
        }
        
        return false;
        
    };
    
    this.addVisitorServices = function(target) {
        
        var object = this;
        object._console.log(target);
        if (target.selectedOptionsList == null) {
            
            
            
        }
        var hasService = false;
        var services = object._visitorServices;
        object._console.log(services);
        for (var key in services) {
            
            if (parseInt(services[key].key) == parseInt(target.key)) {
                
                hasService = true;
                //services[key] = JSON.parse(JSON.stringify(target));
                services[key] = target;
                //return object._visitorServices;
                
            }
            
        }
        
        if (hasService === false && target.selected == 1) {
            
            //services.push(JSON.parse(JSON.stringify(target)));
            services.push(target);
            
        }
        
        object._console.log(services);
        object._visitorServices = services.map( list => ({...list}));
        //services.push(target);
        return object._visitorServices;
        
    };
    
    this.getVisitorServices = function() {
        
        this._console.log(this._visitorServices);
        return this._visitorServices;
        
    };
    
    this.setResponseText = function(responseText){
        
        this._responseText = responseText;
        
    };
    
    this.getResponseText = function(){
        
        return this._responseText;
        
    };
    
    this.setUserInformation = function(userInformation) {
        
        if (userInformation == null) {
            
            userInformation = {};
            
        }
        
        this._userInformation = userInformation;
        
    };
    
    this.getUserInformation = function() {
        
        return this._userInformation;
        
    };
    
    this.getGuestsList = function(){
        
        return this._guestsList;
        
    };
    
    this.setMaxApplicantCount = function(maxApplicantCount) {
        
        this._maxApplicantCount = maxApplicantCount;
        
    };
    
    this.getMaxApplicantCount = function() {
        
        return this._maxApplicantCount;
        
    };

    this.getReservationData = function(month, day, year, accountKey, createSchedules, callback){
        
        var object = this;
        //object._startOfWeek = object._calendarAccountList[accountKey].startOfWeek;
        object._console.log(object._loadingPanel);
        object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
        var post = {nonce: object._nonce, action: object._action, mode: object._prefix + 'getReservationData', year: year, month: month, day: 1, accountKey: accountKey, createSchedules: parseInt(createSchedules)};
        object.setFunction("getReservationData", post);
        new Booking_App_XMLHttp(object._url, post, object._webApp, function(calendarData){
                
            object._loadingPanel.setAttribute("class", "hidden_panel");
            if (object._isExtensionsValid != 1) {
                
                calendarData.account.maximumNights = 0;
                calendarData.account.minimumNights = 0;
                
            }
            
            object._console.log(calendarData);
            object._preparationTime = parseInt(calendarData.account.preparationTime);
            object._positionPreparationTime = calendarData.account.positionPreparationTime;
            object._calendarAccount = calendarData.account;
            object._hotel.setCalendarAccount(calendarData.account);
            object._hotel.setTaxes(calendarData.taxes);
            object._taxes = calendarData.taxes;
            object._guestsList = calendarData.guestsList;
            object._servicesControl.setNationalHoliday(calendarData.nationalHoliday.calendar);
            if (object._htmlTitle != null) {
                
                object._htmlTitle.textContent = calendarData.account.name;
                
            }
            
            object._console.log(object._taxes);
            object._emailEnableList = calendarData.emailEnableList;
            if (calendarData.courseList != null) {
                
                for (var i = 0; i < calendarData.courseList.length; i++) {
                    
                    var service = calendarData.courseList[i];
                    if (service.stopServiceUnderFollowingConditions != "doNotStop") {
                        
                        object._calendarAccount.hasMultipleServices = 0;
                        break;
                        
                    }
                    
                }
                
                object._courseList = calendarData.courseList;
                object._servicesControl.setServices(calendarData.courseList);
                
            }
            
            object._courseBool = false;
            if (parseInt(calendarData.account.courseBool) == 1) {
                
                object._courseBool = true;
                
            }
            object._console.log("_courseBool = " + object._courseBool);
            
            if (calendarData.formData != null) {
                
                object._formData = calendarData.formData;
                
            }
            
            if (callback == null) {
                
                object.createCalendar(calendarData, month, day, year, accountKey);
                
            } else {
                
                callback(calendarData);
                
            }
            
            
                
        }, function(responseText){
            
            object.setResponseText(responseText);
            
        });
        
    };
    
    

    this.selectCalendarAccount = function(calendarData, month, day, year, selectCalendarAccountPanel, calendarAccountList, accountKey){
        
        var object = this;
        object._console.log("accountKey = " + accountKey);
        object._console.log(calendarAccountList);
        selectCalendarAccountPanel.id = "selectCalendarAccountPanel";
        var select = document.createElement("select");
        selectCalendarAccountPanel.appendChild(select);
        for (var i = 0; i < calendarAccountList.length; i++) {
            
            var calendarAccount = calendarAccountList[i];
            object._console.log(calendarAccount);
            var option = document.createElement("option");
            option.value = calendarAccount.key;
            option.textContent = calendarAccount.name;
            select.appendChild(option);
            if (accountKey == calendarAccount.key) {
                
                select.selectedIndex = i;
                object._startOfWeek = calendarAccount.startOfWeek;
                object._courseBool = false;
                if (parseInt(calendarAccount.courseBool) == 1) {
                    
                    object._courseBool = true;
                    
                }
                
                object._console.log("courseBool = " + object._courseBool);
                object._courseName = calendarAccount.courseTitle;
                
            }
            
        }
        
        select.onchange = function(){
            
            object._console.log("onchange = " + this.selectedIndex);
            var key = this.selectedIndex;
            var accountKey = this.options[key].value;
            object._console.log("accountKey = " + accountKey);
            object.getReservationData(month, day, year, accountKey, 1, null);
            
        };
        
    };
    
    this.createCalendar = function(calendarData, month, day, year, accountKey) {
            
        var object = this;
        this.date = {month: month, day: day, year: year};
        var calendarPanel = document.getElementById("calendarPage");
        calendarPanel.textContent = null;
        object._nationalHoliday = calendarData.nationalHoliday.calendar;
        object._console.log("schedule_data.calendar_account = " + object._schedule_data.calendar_account);
        var selectCalendarAccountPanel = document.createElement("div");
        var calendarAccount = calendarData.account;
        object._console.log(calendarAccount);
        
        calendarPanel.appendChild(selectCalendarAccountPanel);
        object.selectCalendarAccount(calendarData, month, day, year, selectCalendarAccountPanel, object._schedule_data.calendarAccountList, accountKey);
        
        var dayHeight = parseInt(calendarPanel.clientWidth / 7);
        
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
        object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
        object._calendar.setClock(object._clock);
        var datePanel = document.createElement("div");
        datePanel.setAttribute("class", "calendarData");
        datePanel.textContent = object._calendar.formatBookingDate(month, null, year, null, null, null, null, 'text');
        
        var returnLabel = document.createElement("label");
        returnLabel.setAttribute("class", "arrowLeft");
        if (month == 1) {
            
            returnLabel.textContent = "＜" + object._calendar.formatBookingDate(12, null, null, null, null, null, null, 'text');
            
        } else {
            
            returnLabel.textContent = "＜" + object._calendar.formatBookingDate((parseInt(month) - 1), null, null, null, null, null, null, 'text');
            
        }
        
        var returnPanel = document.createElement("div");
        returnPanel.setAttribute("class", "calendarChangeButton");
        returnPanel.appendChild(returnLabel);
        
        var nextLabel = document.createElement("label");
        nextLabel.setAttribute("class", "arrowRight");
        if (month == 12) {
            
            nextLabel.textContent = object._calendar.formatBookingDate(1, null, null, null, null, null, null, 'text') + "＞";
            
        } else {
            
            nextLabel.textContent = object._calendar.formatBookingDate((parseInt(month) + 1), null, null, null, null, null, null, 'text') + "＞";
            
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
        
        var downloadBool = false;
        object._calendar.create(calendarPanel, calendarData, month, day, year, '', function(callback) {
            
            object._console.log(callback);
            var dayPanel = callback.eventPanel;
            var day = parseInt(callback.day);
            var remainderPanel = document.createElement("div");
            remainderPanel.setAttribute("class", "remainderPanel");
            remainderPanel.textContent = "0";
            var approved = 0;
            var pending = 0;
            var canceled = 0;
            if (calendarData.reservation[callback.key] != null) {
                
                var userList = calendarData.reservation[callback.key];
                object._console.log(userList);
                
                for (var key in calendarData.reservation[callback.key]) {
                    
                    object._console.log(calendarData.reservation[callback.key][key]);
                    if (parseInt(calendarData.reservation[callback.key][key].scheduleUnixTime) >= calendarData.date.firstMonth && parseInt(calendarData.reservation[callback.key][key].scheduleUnixTime) <= calendarData.date.endMonth) {
                        
                        downloadBool = true;
                        
                    }
                    
                    if (calendarData.reservation[callback.key][key].status == 'approved') {
                        
                        approved++;
                        
                    } else if (calendarData.reservation[callback.key][key].status == 'pending') {
                        
                        pending++;
                        
                    } else if (calendarData.reservation[callback.key][key].status == 'canceled') {
                        
                        canceled++;
                        
                    }
                    
                }
                
                object._console.log("approved = " + approved + " pending = " + pending);
                var approvedCount = document.createElement("span");
                approvedCount.classList.add("approvedCount");
                approvedCount.textContent = approved;
                
                var pendingCount = document.createElement("span");
                pendingCount.classList.add("pendingCount");
                pendingCount.textContent = pending;
                
                if (parseInt(calendarAccount.displayDetailsOfCanceled) == 0) {
                    
                    remainderPanel.innerHTML = '<div class="approvedCount" style="padding-right: 0.3em;">' + approved + '</div>' + "/" + '<div class="pendingCount" style="padding-left: 0.3em;">' + pending + '</div>';
                    
                } else {
                    
                    remainderPanel.innerHTML = '<div class="approvedCount">' + approved + '</div>' + " " + '<div class="pendingCount">' + pending + '</div>' + " " + '<div class="canceledCount">' + canceled + '</div>';
                    
                }
                
                dayPanel.appendChild(remainderPanel);
                
            }
            
            var total = approved + pending + canceled;
            if (calendarData.schedule[callback.key] != null && calendarData.schedule[callback.key].length != 0 || total != 0) {
                
                if (calendarData.schedule[callback.key].length == 0) {
                    
                    dayPanel.classList.add("closeDay");
                    
                }
                
                dayPanel.onclick = function(){
                    
                    var dayKey = parseInt(this.getAttribute("data-day"));
                    var monthKey = parseInt(this.getAttribute("data-month"));
                    var yearKey = parseInt(this.getAttribute("data-year"));
                    object.setUserInformation(null);
                    object._buttonAction = "reservation_users";
                    document.getElementById("reservation_users").setAttribute("class", "media_menu_item active");
                    document.getElementById("add_reservation").setAttribute("class", "media_menu_item");
                    //setCalendarDate({month: month, day: dayKey, year: year});
                    object.viewUserList(monthKey, dayKey, yearKey, calendarData, accountKey, function(callback){
                        
                        object._console.log("editPublicSchedule callback");
                        
                    });
                    
                };
                
            } else {
                
                object._console.log("delete class");
                dayPanel.classList.remove("pointer");
                dayPanel.classList.add("closeDay");
                
            }
            
        });
        
        returnLabel.onclick = function(){
            
            if (month == 1) {
                
                year--;
                month = 12;
                
            } else {
                
                month--;
                
            }
            object.getReservationData(month, 1, year, accountKey, 0, null);
            
        };
        
        nextLabel.onclick = function(){
            
            if (month == 12) {
                
                year++;
                month = 1;
                
            } else {
                
                month++;
                
            }
            object.getReservationData(month, 1, year, accountKey, 0, null);
            
        };
        
        var timezonePanel = document.createElement("div");
        if (calendarAccount.timezone != 'none') {
            
            timezonePanel.textContent = object._i18n.get("Timezone") + ": " + calendarAccount.timezone;
            calendarPanel.appendChild(timezonePanel);
            
        }
        
        var form = document.createElement("form");
        form.id = 'downloadCsvForMonth';
        object.downloadCSV(month, null, year, accountKey, form, downloadBool, '');
        
        var footerOnCalendar = document.createElement('div');
        footerOnCalendar.classList.add('footerOnCalendar');
        footerOnCalendar.appendChild(timezonePanel);
        footerOnCalendar.appendChild(form);
        calendarPanel.appendChild(footerOnCalendar);
        
        if (object._dashboardRequest.status == 1) {
            
            object.viewUserList(object._dashboardRequest.month, object._dashboardRequest.day, object._dashboardRequest.year, calendarData, accountKey, function(callback){
                
                object._console.log("editPublicSchedule callback");
                
            });
            
    	}
        
    };

    this.viewUserList = function(month, day, year, calendarData, accountKey, callback){
        
        var object = this;
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
    	object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
        object._calendar.setClock(object._clock);
        var calendarKey = object._calendar.getDateKey(month, day, year);
        object._console.log(month + "/" + day + "/" + year);
        object._console.log("buttonAction = " + object._buttonAction);
        object._console.log(calendarData);
        object._console.log(calendarKey);
        
        
        object._hotel.resetCheckDate();
        
        var edit_title = document.getElementById("edit_title");
        edit_title.textContent = object._calendar.formatBookingDate(month, day, year, null, null, null, calendarData.calendar[calendarKey].week, 'text');
        var media_menu = document.getElementById("media_menu");
        media_menu.textContent = null;
        
        object._contentPanel.setAttribute("class", "media_left_zero");
        document.getElementById("menu_panel").setAttribute("class", "media_frame_menu hidden_panel");
        document.getElementById("media_title").setAttribute("class", "media_left_zero");
        document.getElementById("media_router").setAttribute("class", "media_left_zero");
        document.getElementById("frame_toolbar").setAttribute("class", "media_frame_toolbar media_left_zero");
        
        var reservation_users_callback = function(response) {
            
            object._console.log("reservation_users_callback");
            object._console.log("buttonAction = " + object._buttonAction);
            object._console.log(response);
            object._console.log(month + "/" + day + "/" + year);
            if (object._buttonAction == "updateSchedule" && response.month != null && response.day != null && response.year != null) {
                
                object.viewUserList(response.month, response.day, response.year, response.calendarData, accountKey, callback);
                
            } else if (object._buttonAction == "updateSchedule") {
                
                object.viewUserList(month, day, year, response, accountKey, callback);
                
            } else {
                
                if (response.updateDate != null) {
                    
                    if (response.account.type == "day") {
                        
                        object.viewUserList(response.updateDate.month, response.updateDate.day, response.updateDate.year, response, accountKey, callback);
                        
                    } else {
                        
                        object.viewUserList(month, day, year, response, accountKey, callback);
                        
                    }
                    
                } else {
                    
                    object.viewUserList(month, day, year, response, accountKey, callback);
                    
                }
                
            }
            
        };
        
        var add_reservation_callback = function(response){
            
            object._console.log(response);
            object._hotel.resetCheckDate();
            document.getElementById("reservation_users").setAttribute("class", "media_menu_item active");
            document.getElementById("add_reservation").setAttribute("class", "media_menu_item");
            object.viewUserList(month, day, year, response, accountKey, callback);
            
        };
        
        var changeButtonAction = function(buttonAction, mode, month, day, year, calendarData, add_reservationPanel, add_reservation_callback, callback){
            
            month = parseInt(month);
            day = parseInt(day);
            year = parseInt(year);
            //var lastDay = parseInt(calendarData.date.lastDay);
            var lastDay = 0;
            var key = parseInt(year + ("0" + month).slice(-2));
            if (calendarData.calendarList[key] != null) {
                
                object._console.log(calendarData.calendarList[key]);
                lastDay = parseInt(calendarData.calendarList[key].lastDay);
                
            }
            var calendarChange = 0;
            object._hotel.resetCheckDate();
            
            object._console.log("month = " + month + " day = " + day + " year = " + year + " lastDay = " + lastDay);
            if (buttonAction == 'reservation_users' || buttonAction == 'add_reservation' || buttonAction == 'updateSchedule') {
                
                if (mode == 0) {
                    
                    day--;
                    if(day == 0){
                        
                        calendarChange = 1;
                        month--;
                        day = 1;
                        if (month == 0) {
                            month = 12;
                            year--;
                        }
                        
                    }
                    
                } else if (mode == 1) {
                    
                    day++;
                    if (day > lastDay) {
                        
                        calendarChange = 1;
                        month++;
                        day = 1;
                        if (month == 13) {
                            month = 1;
                            year++;
                        }
                        
                    }
                    
                }
                
                object._console.log("calendarChange = " + calendarChange);
                if (calendarChange === 0) {
                    
                    object.viewUserList(month, day, year, calendarData, accountKey, callback);
                    
                } else {
                    
                    object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
                    var post = {nonce: object._nonce, action: object._action, mode: object._prefix + 'getReservationData', year: year, month: month, day: 1, accountKey: accountKey};
                    object.setFunction("viewUserList", post);
                    new Booking_App_XMLHttp(object._url, post, object._webApp, function(calendarData){
                        
                        object._loadingPanel.setAttribute("class", "hidden_panel");
                        object._servicesControl.setNationalHoliday(calendarData.nationalHoliday.calendar);
                        object._console.log(calendarData);
                        object.createCalendar(calendarData, calendarData.date.month, calendarData.date.day, calendarData.date.year, accountKey);
                        var day = 1;
                        if (mode === 0) {day = calendarData.date.lastDay;}
                        object.viewUserList(month, day, year, calendarData, accountKey, callback);
                        object._loadingPanel.setAttribute("class", "hidden_panel");
                        
                    }, function(responseText){
                        
                        object.setResponseText(responseText);
                        
                    });
                    
                }
                
            } else {
                
                object._console.log("month = " + month + " day = " + day + " year = " + year);
                var calendarKey = object._calendar.getDateKey(month, day, year);
                object._console.log(calendarKey);
                object._console.log(calendarData.reservation[calendarKey]);
                
                var reservationList = null;
                var selectedKey = null;
                if (calendarData.account.type == "day") {
                    
                    selectedKey = object.getSelectedKey();
                    if (mode === 0) {
                        
                        selectedKey--;
                        if (selectedKey < 0) {
                            
                            selectedKey = calendarData.reservation[calendarKey].length - 1;
                            
                        }
                        
                    } else {
                        
                        selectedKey++;
                        if (selectedKey == calendarData.reservation[calendarKey].length) {
                            
                            selectedKey = 0;
                            
                        }
                        
                    }
                    object.setSelectedKey(selectedKey);
                    reservationList = calendarData.reservation[calendarKey][selectedKey];
                    object._console.log("selectedKey = " + selectedKey + " count = " + calendarData.reservation[calendarKey].length);
                    
                } else {
                    
                    var key = object.getSelectedKey();
                    var visitorsList = object.getVisitors();
                    var visitorsArray = Object.keys(visitorsList);
                    object._console.log(object.getVisitors());
                    object._console.log(visitorsArray);
                    if (mode === 0) {
                        
                        key--;
                        if (key < 0) {
                            
                            key = visitorsArray.length - 1;
                            
                        }
                        
                    } else {
                        
                        key++;
                        if (key == visitorsArray.length) {
                            
                            key = 0;
                            
                        }
                        
                    }
                    selectedKey = visitorsArray[key];
                    object.setSelectedKey(key);
                    reservationList = calendarData.reservationForHotel[visitorsList[selectedKey].checkIn][selectedKey];
                    object._console.log("selectedKey = " + selectedKey);
                    object._console.log(visitorsList[selectedKey]);
                    object._console.log(calendarData.reservationForHotel[visitorsList[selectedKey].checkIn][selectedKey]);
                    //return null;
                    
                }
                
                object.showUserInfo(selectedKey, calendarData, reservationList, false, accountKey, reservation_users_callback);
                
            }
            
        };
        
        var reservation_usersPanel = null;
        var add_reservationPanel = null;
        if (document.getElementById("reservation_usersPanel") != null && document.getElementById("add_reservationPanel") != null) {
            
            reservation_usersPanel = document.getElementById("reservation_usersPanel");
            reservation_usersPanel.textContent = null;
            add_reservationPanel = document.getElementById("add_reservationPanel");
            add_reservationPanel.textContent = null;
            
        } else {
            
            reservation_usersPanel = document.createElement("div");
            reservation_usersPanel.id = "reservation_usersPanel";
            add_reservationPanel = document.createElement("div");
            add_reservationPanel.id = "add_reservationPanel";
            object._contentPanel.appendChild(reservation_usersPanel);
            object._contentPanel.appendChild(add_reservationPanel);
            
        }
        
        
        
        var menuTabList = {reservation_users: 'Reservation users', add_reservation: 'Add reservation'};
        for (var key in menuTabList) {
            
            var tabPanel = document.getElementById(key);
            tabPanel.setAttribute("data-key", key);
            tabPanel.onclick = function(){
                
                var clickKey = this.getAttribute("data-key");
                for (var key in menuTabList) {
                    
                    var link = document.getElementById(key);
                    
                    if (clickKey == key) {
                        
                        link.setAttribute("class", "media_menu_item active");
                        
                    } else {
                        
                        link.setAttribute("class", "media_menu_item");
                        
                    }
                    
                    if (clickKey == 'reservation_users') {
                        
                        reservation_usersPanel.setAttribute("class", "");
                        add_reservationPanel.setAttribute("class", "hidden_panel");
                        object.reservation_users(reservation_usersPanel, month, day, year, calendarData, accountKey, reservation_users_callback);
                        
                    } else if (clickKey == 'add_reservation') {
                        
                        if (document.getElementById("userInfoPanel") != null) {
                            
                            
                            var userPanel = document.getElementById("userInfoPanel");
                            userPanel.classList.add('hidden_panel');
                            if (userPanel.getAttribute("class") == "show_panel_for_new_booking") {
                                
                                userPanel.setAttribute("class", "return_panel_for_new_booking");
                                
                            }
                            
                        }
                        
                        if (document.getElementById("changePanel") != null) {
                            
                            var changePanel = document.getElementById("changePanel");
                            if (changePanel.getAttribute("class") == "show_change_panel" || changePanel.getAttribute("class") == "return_change_panel") {
                                
                                changePanel.setAttribute("class", "return_panel");
                                
                            }
                            
                        }
                        
                        var blockPanelCount = object._contentPanel.getElementsByClassName("blockPanel");
                        for (var i = 0; i < blockPanelCount.length; i++) {
                            
                            object._contentPanel.removeChild(blockPanelCount[i]);
                            
                        }
                        
                        object._hotel.reset();
                        reservation_usersPanel.setAttribute("class", "hidden_panel");
                        add_reservationPanel.setAttribute("class", "");
                        object.add_reservation(add_reservationPanel, month, day, year, calendarData, accountKey, add_reservation_callback);
                        
                        
                    }
                    
                }
                
            };
            
        }
        
        if (object._buttonAction == 'reservation_users' || object._buttonAction == 'updateSchedule' || object._buttonAction == 'showUserInfo') {
            
            object.reservation_users(reservation_usersPanel, month, day, year, calendarData, accountKey, reservation_users_callback);
            
        } else if (object._buttonAction == 'add_reservation') {
            
            object.add_reservation(add_reservationPanel, month, day, year, calendarData, accountKey, add_reservation_callback);
            
        }
        
        if (object._buttonAction != "updateSchedule") {
            
            object._leftButtonPanel.textContent = null;
            var beforButton = document.createElement("button");
            beforButton.id = "beforButton";
            beforButton.textContent = "navigate_before";
            beforButton.setAttribute("class", "material-icons button media-button button-primary button-large media-button-insert");
            //beforButton.setAttribute("style", "margin-left: 10px;");
            object._leftButtonPanel.appendChild(beforButton);
            
            var nextButton = document.createElement("button");
            nextButton.id = "nextButton";
            nextButton.textContent = "navigate_next";
            nextButton.setAttribute("class", "material-icons button media-button button-primary button-large media-button-insert");
            nextButton.setAttribute("style", "margin-left: 10px;");
            object._leftButtonPanel.appendChild(nextButton);
            
            var form = document.createElement('form');
            form.id = 'downloadCsvForDay';
            //form.setAttribute("class", "material-icons");
            object.downloadCSV(month, day, year, accountKey, form, true, '');
            object._leftButtonPanel.appendChild(form);
            
            var beforChangeButton = document.createElement("button");
            beforChangeButton.id = "beforChangeButton";
            beforChangeButton.setAttribute("class", "beforButton button media-button button-primary button-large media-button-insert hidden_panel");
            object._leftButtonPanel.appendChild(beforChangeButton);
            
            var nextChangeButton = document.createElement("button");
            nextChangeButton.id = "nextChangeButton";
            nextChangeButton.setAttribute("class", "nextButton button media-button button-primary button-large media-button-insert hidden_panel");
            nextChangeButton.setAttribute("style", "margin-left: 10px;");
            object._leftButtonPanel.appendChild(nextChangeButton);
            
            beforButton.onclick = function() {
                
                changeButtonAction(object._buttonAction, 0, month, day, year, calendarData, add_reservationPanel, add_reservation_callback, callback);
                
            };
            
            nextButton.onclick = function() {
                
                changeButtonAction(object._buttonAction, 1, month, day, year, calendarData, add_reservationPanel, add_reservation_callback, callback);
                
            };
            
            object.editPanelShow(true);
                
        }
        
        
        if (object._dashboardRequest.status == 1) {
            
            reservation_usersPanel.setAttribute("class", "");
            add_reservationPanel.setAttribute("class", "hidden_panel");
            object.reservation_users(reservation_usersPanel, month, day, year, calendarData, accountKey, reservation_users_callback);
            
            
        }
        
        
        
        
    };
    
    this.changeStatusForDashboard = function(button, visitor){
        
        var object = this;
        object._console.log("changeStatusForDashboard");
        object._console.log(visitor);
        if (visitor.status == 'canceled') {
            
            return null;
            
        }
        
        object.changeStatus(visitor.accountKey, visitor, true, false, function(response){
            
            object._console.log(response);
            var status = null;
            if (response.bookingStatus.toLowerCase() == 'pending') {
                
                button.setAttribute("class", "status pending");
                status = "pending";
                
            } else if (response.bookingStatus.toLowerCase() == 'approved') {
                
                button.setAttribute("class", "status approved");
                status = "approved";
                
            } else if(response.bookingStatus.toLowerCase() == 'canceled') {
                
                button.setAttribute("class", "status canceled");
                status = "canceled";
                
            }
            
            visitor.status = status;
            button.textContent = object._i18n.get(status.toUpperCase());
            object._console.log(visitor);
            button.setAttribute("onClick", "changeStatusForDashboard(this, " + visitor.key + ", '"  + visitor.cancellationToken + "', " + visitor.accountKey + ", '" + response.bookingStatus.toLowerCase() + "', " + visitor.date.month + ", " + visitor.date.day + ", " + visitor.date.year + ")");
            
        });
        
    };

    this.changeStatus = function(accountKey, reservation, statusClick, reload, callback){
        
        var object = this;
        var enable = false;
        var message = "";
        var confirm = new Confirm(object._debug);
        object._console.log(object._emailEnableList);
        object._console.log(reservation);
        
        var status = reservation.status;
        var approvedButton = document.createElement("div");
        approvedButton.classList.add("approvedLabel");
        approvedButton.textContent = object._i18n.get("approved");
        approvedButton.setAttribute("data-status", "APPROVED");
        approvedButton.setAttribute("data-close", 0);
        
        var pendingButton = document.createElement("div");
        pendingButton.classList.add("pendingLabel");
        pendingButton.textContent = object._i18n.get("pending");
        pendingButton.setAttribute("data-status", "PENDING");
        pendingButton.setAttribute("data-close", 0);
        
        var canceledButton = document.createElement("div");
        canceledButton.classList.add("canceledLabel");
        canceledButton.textContent = object._i18n.get("canceled");
        canceledButton.setAttribute("data-status", "CANCELED");
        canceledButton.setAttribute("data-close", 0);
        
        var closeButton = document.createElement("div");
        closeButton.classList.add("closeLabel");
        closeButton.textContent = object._i18n.get("Close").toUpperCase();
        closeButton.setAttribute("data-status", "CANCELED");
        closeButton.setAttribute("data-close", 1);
        
        var selectButtonList = [approvedButton, pendingButton, canceledButton, closeButton];
        confirm.selectPanelShow(object._i18n.get("Change status"), selectButtonList, status, enable, function(newStatus){
            
            object._console.log(newStatus);
            if (newStatus != false) {
                
                enable = true;
                if (newStatus.toUpperCase() == "APPROVED" && parseInt(object._emailEnableList.mail_approved.enable) == 1) {
                    
                    object._console.log("mail_pending = " + Boolean(parseInt(object._emailEnableList.mail_approved.enable)));
                    enable = false;
                    
                } else if (newStatus.toUpperCase() == "PENDING" && parseInt(object._emailEnableList.mail_pending.enable) == 1) {
                    
                    object._console.log("mail_approved = " + Boolean(parseInt(object._emailEnableList.mail_pending.enable)));
                    enable = false;
                    
                } else if (newStatus.toUpperCase() == "CANCELED" && parseInt(object._emailEnableList.mail_canceled_by_visitor_user.enable) == 1) {
                    
                    object._console.log("mail_approved = " + Boolean(parseInt(object._emailEnableList.mail_canceled_by_visitor_user.enable)));
                    enable = false;
                    
                }
                
                object._console.log("enable = " + enable);
                
                confirm.dialogPanelShow(object._i18n.get("Attention"), object._i18n.get("Do you send e-mail notifications to customers or administrators?"), enable, function(sendEmail){
                    
                    if (reload == true) {
                        reload = 1;
                    } else {
                        reload = 0;
                    }
                    
                    var post = {nonce: object._nonce, action: object._action, mode: 'updateStatus', key: reservation.key, token: reservation.cancellationToken, oldStatus: status, newStatus: newStatus, month: reservation.date.month, year: reservation.date.year, sendEmail: Number(sendEmail), accountKey: reservation.accountKey, reload: reload};
                    object._console.log(post);
                    object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
                    object.setFunction("changeStatus", post);
                    new Booking_App_XMLHttp(object._url, post, object._webApp, function(response){
                        
                        object._loadingPanel.setAttribute("class", "hidden_panel");
                        response.bookingStatus = newStatus;
                        object._console.log(response);
                        if(reload == true){
                            
                            object.createCalendar(response, response.date.month, response.date.day, response.date.year, accountKey);
                            
                        }
                        statusClick = false;
                        callback(response);
                        
                        
                    }, function(responseText){
                        
                        object.setResponseText(responseText);
                        
                    });
                    
                    
                });
                
            } else {
                
                callback({statusClick: false});
                
            }
                
            
            
        });
        
        return null;
        
        
    };

    this.reservation_users = function(reservation_usersPanel, month, day, year, calendarData, accountKey, callback){
        
        var object = this;
        object._console.log(calendarData.account.type);
        object._console.log("buttonAction = " + object._buttonAction);
        if(object._buttonAction != "updateSchedule" && object._buttonAction != "showUserInfo"){
            
            object._rightButtonPanel.textContent = null;
            object._buttonAction = "reservation_users";
            
        }else{
            
            
            
        }
        
        if(document.getElementById("userInfoPanel") != null){
            
            //document.getElementById("userInfoPanel").setAttribute("class", "hidden_panel");
            
        }
        
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
    	object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
        object._calendar.setClock(object._clock);
        var calendarKey = object._calendar.getDateKey(month, day, year);
        
        var reservationList = null;
        if(calendarData.account.type == 'day'){
            
            reservationList = calendarData.reservation[parseInt(calendarKey)];
            
        }else{
            
            reservationList = calendarData.reservationForHotel;
            
        }
        
        //var reservationList = calendarData.reservation[parseInt(calendarKey)];
        object._console.log(object._formData);
        object._console.log(reservationList);
        
        reservation_usersPanel.classList.remove("hidden_panel");
        reservation_usersPanel.textContent = null;
        
        if (reservationList == null) {
            
            var errorPanel = document.createElement("div");
            errorPanel.setAttribute("class", "noReservations");
            errorPanel.textContent = object._i18n.get("No visitors");
            reservation_usersPanel.appendChild(errorPanel);
            return null;
            
        }
        
        var table = document.createElement("table");
        table.setAttribute("class", "wp-list-table widefat fixed striped");
        reservation_usersPanel.appendChild(table);
        
        if (calendarData.account.type == 'day') {
            
            if (reservationList != null) {
                
                for (var i = 0; i < reservationList.length; i++) {
                
                    var userInfo = reservationList[i];
                    object._console.log(userInfo);
                    
                    var tr = document.createElement("tr");
                    tr.setAttribute("valign", "top");
                    tr.setAttribute("data-key", i);
                    table.appendChild(tr);
                    
                    var th = document.createElement("th");
                    th.setAttribute("scope", "row");
                    th.textContent = object._calendar.getPrintTime(userInfo.date.hour, userInfo.date.min);
                    //th.textContent = userInfo.date.hour + ":" + userInfo.date.min;
                    tr.appendChild(th);
                    
                    var bookingId = document.createElement('div');
                    bookingId.textContent = userInfo.key;
                    var bookingIdTd = document.createElement("td");
                    bookingIdTd.setAttribute("scope", "row");
                    bookingIdTd.appendChild(bookingId);
                    tr.appendChild(bookingIdTd);
                    
                    var status = document.createElement("div");
                    status.setAttribute("data-key", i);
                    //object._console.log(object._i18n.get(userInfo.status.toUpperCase()));
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
                    tr.appendChild(td);
                    
                    (function(formData, praivateData, callback) {
                        
                        var sort = [];
                        for (var i = 0; i < formData.length; i++) {
                            
                            if (formData[i].active != 'true') {
                                
                                continue;
                                
                            }
                            
                            if (praivateData != null) {
                                
                                for (var ii = 0; ii < praivateData.length; ii++) {
                                
                                    if (formData[i].id == praivateData[ii].id) {
                                        
                                        sort[i] = praivateData[ii];
                                        break;
                                        
                                    }
                                    
                                }
                                
                                if (sort[i] == null) {
                                    
                                    sort[i] = formData[i];
                                    
                                }
                                
                            } else {
                                
                                break;
                                
                            }
                            
                        }
                        
                        callback(sort);
                        
                    })(object._formData, userInfo.praivateData, function(praivateData) {
                        
                        object._console.log(praivateData);
                        for (var i = 0; i < 5; i++) {
                            
                            if (praivateData[i] != null) {
                                
                                if (typeof praivateData[i].value == "string") {
                                    
                                    praivateData[i].value = praivateData[i].value.replace(/\\/g, "");
                                    
                                }
                                
                                var td = document.createElement("td");
                                td.textContent = praivateData[i].value;
                                tr.appendChild(td);
                                
                            }
                            
                        }
                        
                    });
                    
                    var statusClick = false;
                    if (userInfo.status != "canceled") {
                        
                        status.onclick = function(){
                            
                            var key = parseInt(this.getAttribute("data-key"));
                            object._console.log(key);
                            object._console.log(reservationList[key]);
                            statusClick = true;
                            
                            object._console.log(object._emailEnableList);
                            object._console.log("enable = " + Boolean(parseInt(object._emailEnableList.mail_new_admin.enable)));
                            
                            object.changeStatus(accountKey, reservationList[key], statusClick, true, function(response){
                                
                                object._console.log(response);
                                if(response.statusClick != null){
                                    
                                    statusClick = response.statusClick;
                                    
                                }else{
                                    
                                    callback(response);
                                    
                                }
                                //callback
                                
                            });
                            
                        };
                        
                    }
                    
                    
                    tr.onclick = function(){
                        
                        if(statusClick == false){
                            
                            var key = parseInt(this.getAttribute("data-key"));
                            object._console.log(key);
                            object._console.log(reservationList[key]);
                            object.setSelectedKey(key);
                            object.resetVisitorServices();
                            object.showUserInfo(key, calendarData, reservationList[key], true, accountKey, function(response){
                                
                                object._console.log(response);
                                if(response.status == "returnButton"){
                                    
                                    object.reservation_users(reservation_usersPanel, response.month, response.day, response.year, calendarData, accountKey, callback);
                                    
                                }else{
                                    
                                    callback(response);
                                    
                                }
                                
                            });
                            
                        }
                        
                    };
                    
                }
                
            }
            
        } else {
            
            var calendarArray = Object.keys(calendarData.calendar);
            var startKey = calendarData.calendar[calendarKey].number;
            var endKey = startKey + 7;
            
            if(calendarArray[endKey] == null){
                
                startKey = calendarArray.length - 7;
                endKey = calendarArray.length;
                
            }
            
            object._console.log("startKey = " + startKey + " endKey = " + endKey);
            object._console.log(calendarKey);
            object._console.log(calendarData.calendar);
            object._console.log(calendarArray);
            
            var tr = document.createElement("tr");
            tr.setAttribute("valign", "top");
            table.appendChild(tr);
            
            var visitorTr = document.createElement("tr");
            visitorTr.setAttribute("valign", "top");
            table.appendChild(visitorTr);
            
            var start = 0;
            var nights = 6;
            var end = 0;
            var left = 0;
            var visitors = {};
            object._calendar.setShortWeekNameBool(true);
            for(var i = startKey; i < endKey; i++){
                
                var key = calendarArray[i];
                end = key;
                var calendarInfo = calendarData.calendar[key];
                object._console.log("key = " + key);
                object._console.log(calendarInfo);
                
                
                (function(reservationList, date, start, nights, visitors){
                    
                    object._console.log(reservationList);
                    object._console.log("date = " + date);
                    object._console.log("start = " + start);
                    
                    for(var key in reservationList){
                        
                        var reservation = reservationList[key];
                        var id = reservation.key;
                        //object._console.log(reservation);
                        if(visitors[id] != null){
                            
                            var endDay = start;
                            
                            visitors[id].day++;
                            visitors[id].displayNights--;
                            visitors[id].endDay = endDay;
                            if(visitors[id].checkOut == date){
                                
                                visitors[id].checkOutBool = 1;
                                
                            }
                            object._console.log(visitors[id]);
                            
                        }else{
                            
                            var name = [];
                            for(var i = 0; i < reservation.praivateData.length; i++){
                                
                                var input = reservation.praivateData[i];
                                if(input.isName == "true"){
                                    
                                    name.push(input.value);
                                    
                                }
                                
                            }
                            
                            name = name.join(" ");
                            var startDay = start;
                            if(date == parseInt(reservation.date.checkIn)){
                                
                                startDay = start + 0.5;
                                
                            }
                            
                            var endDay = start;
                            if(date == parseInt(reservation.date.checkIn)){
                                
                                endDay = start - 0.5;
                                
                            }
                            
                            visitors[id] = {key: reservation.key, day: 0, status: reservation.status, nights: reservation.accommodationDetails.nights, displayNights: reservation.accommodationDetails.nights - start, name: name, startDay: startDay, endDay: endDay, checkIn: parseInt(reservation.date.checkIn), checkOut: parseInt(reservation.date.checkOut), checkOutBool: 0};
                            
                        }
                        
                        
                        
                    }
                    
                })(reservationList[key], key, start, nights, visitors);
                start++;
                nights--;
                
                var th = document.createElement("th");
                th.classList.add("text_center");
                th.setAttribute("scope", "row");
                th.textContent = object._calendar.formatBookingDate(null, calendarInfo.day, null, null, null, null, calendarInfo.week, 'text');
                tr.appendChild(th);
                object._console.log(th.clientWidth);
                
                
                var td = document.createElement("td");
                td.setAttribute("data-key", key);
                visitorTr.appendChild(td);
                
                //reservation_usersPanel
                var dayPanel = document.createElement("div");
                dayPanel.classList.add("weekHorizotalPanel");
                dayPanel.setAttribute("style", "left: " + left + "%;");
                reservation_usersPanel.appendChild(dayPanel);
                left += 14.2;
                
            }
            
            object._calendar.setShortWeekNameBool(false);
            
            object._console.log(visitors);
            object.setVisitors(visitors);
            object._console.log("end = " + end);
            
            var visitorListPanel = document.createElement("div");
            visitorListPanel.classList.add("visitorListPanel");
            reservation_usersPanel.appendChild(visitorListPanel);
            
            var i = 0;
            for(var key in visitors){
                
                object._console.log(visitors[key]);
                var width = 14.2 * visitors[key].day;
                var left = 14.2 * visitors[key].startDay;
                if(visitors[key].checkOut > end){
                    
                    width = 14.2 * (visitors[key].day + 0.5);
                    
                    
                }
                
                object._console.log("key = " + key + "width = " + (width + left));
                if(visitors[key].checkOutBool == 0 && visitors[key].day == 6){
                    
                    width = 99.4 - left;
                    
                }else{
                    
                    if(visitors[key].startDay == 0){
                        
                        width += 7.1;
                        
                    }
                    
                }
                
                var visitorPanel = document.createElement("div");
                visitorPanel.setAttribute("style", "width: " + width + "%; left: " + left + "%;");
                visitorPanel.setAttribute("data-index", i);
                visitorPanel.setAttribute("data-key", key);
                visitorPanel.setAttribute("data-checkIn", visitors[key].checkIn);
                visitorPanel.classList.add("visitorPanel");
                visitorPanel.textContent = "ID: " + visitors[key].key + ' ' + visitors[key].name;
                visitorListPanel.appendChild(visitorPanel);
                if (visitors[key].status == "pending") {
                    
                    visitorPanel.classList.add("visitorPendingPanel");
                    
                } else if (visitors[key].status.toLowerCase() == "approved") {
                    
                    visitorPanel.classList.add("visitorApprovedPanel");
                    
                } else if (visitors[key].status.toLowerCase() == "canceled") {
                    
                    visitorPanel.classList.add("visitorCanceledPanel");
                    
                }
                
                visitorPanel.onclick = function(){
                    
                    var key = this.getAttribute("data-key");
                    object._console.log("key = " + key);
                    object._console.log(visitors[key]);
                    var key = parseInt(this.getAttribute("data-key"));
                    var checkIn = parseInt(this.getAttribute("data-checkIn"));
                    var index = parseInt(this.getAttribute("data-index"));
                    object.setSelectedKey(index);
                    object._console.log(key);
                    object._console.log(reservationList[checkIn][key]);
                    object.showUserInfo(key, calendarData, reservationList[checkIn][key], true, accountKey, function(response){
                        
                        object._console.log(response);
                        if(response.status == "returnButton"){
                            
                            object.reservation_users(reservation_usersPanel, response.month, response.day, response.year, calendarData, accountKey, callback);
                            
                        }else{
                            
                            callback(response);
                            
                        }
                        
                    });
                    
                };
                
                i++;
                
            }
            
            
        }
        
        //object._console.log(th.clientWidth);
        
        if(object._dashboardRequest.status == 1){
            
            object._console.log(object._dashboardRequest);
            var key = 0;
            var visitorData = null;
            if (calendarData.account.type == "day") {
                
                for (var i = 0; i < reservationList.length; i++) {
                    
                    var userInfo = reservationList[i];
                    if (parseInt(userInfo.key) == parseInt(object._dashboardRequest.key)) {
                        
                        key = i;
                        visitorData = reservationList[key];
                        break;
                        
                    }
                    
                }
            
            } else {
                
                var checkIn = object._calendar.getDateKey(object._dashboardRequest.month, object._dashboardRequest.day, object._dashboardRequest.year);
                object._console.log("checkIn = " + checkIn);
                object._console.log(reservationList[checkIn]);
                key = object._dashboardRequest.key;
                visitorData = reservationList[checkIn][object._dashboardRequest.key];
                
            }
            
            object.setSelectedKey(key);
            object.showUserInfo(key, calendarData, visitorData, true, accountKey, function(response){
                
                object._console.log(response);
                if (response.status == "returnButton") {
                    
                    object.reservation_users(reservation_usersPanel, response.month, response.day, response.year, calendarData, accountKey, callback);
                    
                } else {
                    
                    callback(response);
                    
                }
                
            });
            object._dashboardRequest.status = 0;
            object._console.log(object._dashboardRequest);
            
        }
        
    };
    
    this.showUserInfo = function(key, calendarData, reservationData, animation, accountKey, callback) {
        
        var object = this;
        var options = "[]";
        object._buttonAction = "showUserInfo";
        object._console.log("key = " + key);
        object._console.log("buttonAction = " + object._buttonAction);
        object._console.log(calendarData);
        object._console.log(reservationData);
        if (reservationData == null) {
            
            object._leftButtonPanel.textContent = null;
            object._rightButtonPanel.textContent = null;
            object.editPanelShow(false);
            return null;
            
        }
        
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
        
        var deleteButton = document.createElement("button");
        deleteButton.id = "deleteButton";
        deleteButton.textContent = object._i18n.get("Delete", []);
        deleteButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
        
        var editButton = document.createElement("button");
        editButton.id = "editButton";
        editButton.textContent = object._i18n.get("Edit");
        editButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
        editButton.setAttribute("style", "margin-left: 10px;");
        if (parseInt(reservationData.accountKey) != parseInt(accountKey)) {
            
            editButton.classList.add('hidden_panel');
            
        }
        
        object._rightButtonPanel.textContent = null;
        object._rightButtonPanel.appendChild(deleteButton);
        object._rightButtonPanel.appendChild(editButton);
        
        //document.getElementById("beforButton").classList.add("hidden_panel");
        
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
    	object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
        object._calendar.setClock(object._clock);
        infoPanel.textContent = null;
        
        var reservationDate = reservationData.date;
        var date = object._calendar.formatBookingDate(reservationDate.month, reservationDate.day, reservationDate.year, reservationDate.hour, reservationDate.min, reservationData.scheduleTitle, reservationData.date.week, 'text');
        
        var month = reservationData.date.month;
        var day = reservationData.date.day;
        var year = reservationData.date.year;
        
        object._console.log(date);
        /**
        var formPanel = document.createElement("div");
        formPanel.id = "inputFormPanel";
        infoPanel.appendChild(formPanel);
        
        var rowPanel = object.createRowPanel("ID", reservationData.key, null, null, null);
        formPanel.appendChild(rowPanel);
        **/
        var bookingTimeChange = document.createElement("div");
        bookingTimeChange.setAttribute("data-status", "1");
        bookingTimeChange.setAttribute("class", "change hidden_panel");
        bookingTimeChange.textContent = object._i18n.get("Change");
        
        var courseChange = document.createElement("div");
        courseChange.setAttribute("data-status", "1");
        courseChange.setAttribute("class", "change hidden_panel");
        courseChange.textContent = object._i18n.get("Change");
        
        var response = object.showUserDetails(key, calendarData, reservationData, accountKey, true, infoPanel, bookingTimeChange, courseChange, function(response){
            
            object._console.log(response);
            callback(response);
            
        });
        
        var userInfoPanel = document.getElementById('userInfoPanel');
        if (typeof userInfoPanel == 'object' && typeof userInfoPanel.scrollTo == 'function') {
            
            userInfoPanel.scrollTo(0, 0);
            
        }
        
        var formPanel = response.formPanel;
        var formPanelList = response.formPanelList;
        var formData = response.formData;
        var totalNumberOfGuestsPanel = response.totalNumberOfGuestsPanel;
        
        var cancelToEdit = function(){
            
            bookingTimeChange.classList.add("hidden_panel");
            bookingTimeChange.setAttribute("data-status", "1");
            bookingTimeChange.textContent = object._i18n.get("Change");
            courseChange.classList.add("hidden_panel");
            courseChange.setAttribute("data-status", "1");
            courseChange.textContent = object._i18n.get("Change");
            
            
            var date = object._calendar.formatBookingDate(reservationData.date.month, reservationData.date.day, reservationData.date.year, reservationData.date.hour, reservationData.date.min, reservationData.scheduleTitle, reservationData.date.week, 'text');
            if(document.getElementById("booking_date") != null){
                
                object._console.log("date = " + date);
                var dateLabel = document.getElementById("booking_date");
                dateLabel.setAttribute("data-key", reservationData.scheduleKey);
                dateLabel.setAttribute("data-unixTime", reservationData.scheduleUnixTime);
                dateLabel.textContent = date;
                
            }
            
            if(reservationData.courseKey != null && reservationData.courseTime != null && document.getElementById("booking_course") != null){
                
                object._console.log(reservationData);
                var courseLabel = document.getElementById("booking_course");
                courseLabel.setAttribute("data-key", reservationData.courseKey);
                courseLabel.setAttribute("data-time", reservationData.courseTime);
                courseLabel.textContent = reservationData.courseName;
                
            }
            
            if(document.getElementById("booking_cost") != null){
                            
                var cost = object._format.formatCost(reservationData.courseCost, reservationData.currency);
                document.getElementById("booking_cost").textContent = cost;
                
            }
            
            document.getElementById("beforButton").classList.remove("hidden_panel");
            document.getElementById("nextButton").classList.remove("hidden_panel");
            document.getElementById('downloadCsvForDay').classList.remove('hidden_panel');
            document.getElementById("beforChangeButton").classList.add("hidden_panel");
            document.getElementById("nextChangeButton").classList.add("hidden_panel");
            
            var responseData = {};
            if (calendarData.account.type == "hotel") {
                
                /** Rooms **/
                var guestsList = object._hotel.getGuestsList();
                var visitorsDetails = object._hotel.verifySchedule(false);
                for (var roomKey in visitorsDetails.rooms) {
                    
                    for (var key in guestsList) {
                        
                        object._console.log(guestsList[key]);
                        var guestsParentPanel = document.getElementById("guests_" + roomKey + '_' + key).parentElement;
                        var guestsPanel = document.getElementById("guests_" + roomKey + '_' + key);
                        var guestsSelectPanel = document.getElementById("select_guests_" + roomKey + '_' + key);
                        guestsPanel.classList.remove("hidden_panel");
                        object._console.log(guestsSelectPanel);
                        if (guestsSelectPanel != null) {
                            
                            guestsParentPanel.removeChild(guestsSelectPanel);
                            
                        }
                        
                    }
                    
                }
                /** Rooms **/
                /**
                var guestsList = object._hotel.getGuestsList();
                for(var key in guestsList){
                    
                    object._console.log(guestsList[key]);
                    var guestsParentPanel = document.getElementById("guests_" + key).parentElement;
                    var guestsPanel = document.getElementById("guests_" + key);
                    var guestsSelectPanel = document.getElementById("select_guests_" + key);
                    guestsPanel.classList.remove("hidden_panel");
                    object._console.log(guestsSelectPanel);
                    if(guestsSelectPanel != null){
                        
                        guestsParentPanel.removeChild(guestsSelectPanel);
                        
                    }
                    
                }
                **/
                
                var totalNumberOfGuests = parseInt(reservationData.accommodationDetails.adult) + parseInt(reservationData.accommodationDetails.children);
                if (totalNumberOfGuestsPanel != null) {
                    
                    totalNumberOfGuestsPanel.classList.remove("errorPanel");
                    document.getElementById("totalGuests").textContent = totalNumberOfGuests;
                    
                }
                
                
            } else {
                
                var edit_title = document.getElementById("edit_title");
                edit_title.textContent = object._calendar.formatBookingDate(reservationData.date.month, reservationData.date.day, reservationData.date.year, null, null, null, reservationData.date.week, 'text');
                
            }
            
            object._console.log(calendarData);
            object._console.log(reservationData);
            
            month = reservationData.date.month;
            day = reservationData.date.day;
            year = reservationData.date.year;
            responseData = {status: "returnButton", month: month, day: day, year: year, calendarData: calendarData};
            
        };
        
        if (blockPanel != null) {
            
            blockPanel.onclick = function(event){
                
                object._console.log("blockPanel click");
                object._buttonAction = "reservation_users";
                object._rightButtonPanel.textContent = null;
                if (document.getElementById("changePanel") != null) {
                    
                    document.getElementById("changePanel").setAttribute("class", "return_panel");
                    
                }
                infoPanel.setAttribute("class", "return_panel");
                object._contentPanel.removeChild(blockPanel);
                
                cancelToEdit();
                
                
            };
            
        }
        
        var object = this;
        editButton.onclick = function(){
            
            options = reservationData.options;
            object.setVisitorServices(options);
            object._console.log(options);
            document.getElementById("beforButton").classList.add("hidden_panel");
            document.getElementById("nextButton").classList.add("hidden_panel");
            document.getElementById('downloadCsvForDay').classList.add('hidden_panel');
            
            bookingTimeChange.classList.remove("hidden_panel");
            courseChange.classList.remove("hidden_panel");
            
            /**
             * var extensionsFunction = new ExtensionsFunction();
            extensionsFunction.edtiBookingUser(object, editButton, deleteButton, rightButtonPanel, formPanel, changePanel, reservationDate, reservationData, formPanelList, formData, function(response){
                
                rightButtonPanel.textContent = null;
                response.action = 'refresh';
                buttonAction = "reservation_users";
                createCalendar(response, response.date.month, response.date.day, response.date.year);
                callback(response);
                
            });
            return null;
            **/
            
            editButton.setAttribute("class", "hidden_panel");
            deleteButton.setAttribute("class", "hidden_panel");
            
            var returnButton = document.createElement("button");
            returnButton.id = "returnButton";
            returnButton.textContent = object._i18n.get("Return");
            returnButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
            returnButton.setAttribute("style", "margin-left: 10px;");
            object._rightButtonPanel.appendChild(returnButton);
            
            var saveButton = document.createElement("button");
            saveButton.id = "saveButton";
            saveButton.textContent = object._i18n.get("Save");
            saveButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
            saveButton.setAttribute("style", "margin-left: 10px;");
            object._rightButtonPanel.appendChild(saveButton);
            
            var inputPanelList = {};
            var inputData = {};
            var input = new Booking_Package_Input(object._debug);
            input.setAdmin(true);
            
            if(calendarData.account.type == "hotel"){
                
                /**
                var value = input.createInput(i, form, inputData, null);
                var rowPanel = createRowPanel(form.name, value, null, form.required, null);
                **/
                var visitorsDetails = object._hotel.verifySchedule(false);
                object._console.log(visitorsDetails);
                if(visitorsDetails.status == true){
                    
                    /** Rooms **/
                    var guestsList = object._hotel.getGuestsList();
                    var rooms = visitorsDetails.rooms;
                    for (var roomKey in visitorsDetails.rooms) {
                        
                        var room = visitorsDetails.rooms[roomKey];
                        var roomNumber = parseInt(roomKey) + 1;
                        object._console.log(room);
                        
                        for(var key in guestsList){
                            
                            object._console.log(key);
                            var guests = guestsList[key];
                            guestsList[key].json = (function(guests, valueGuest){
                                
                                if (valueGuest == null) {
                                    
                                    return guests;
                                    
                                }
                                guests = JSON.parse(guests);
                                for (var key in guests) {
                                    
                                    guests[key].selected = 0;
                                    if (parseInt(guests[key].number) == parseInt(valueGuest.number)) {
                                        
                                        guests[key].selected = 1;
                                        
                                    }
                                    
                                }
                                object._console.log(guests);
                                return JSON.stringify(guests);
                                
                            })(guestsList[key].json, room.guests[key]);
                            
                            guestsList[key].value = (function(valueGuest){
                                
                                if (valueGuest == null) {
                                    
                                    return 0;
                                    
                                } else {
                                    
                                    object._console.log(valueGuest.name);
                                    return valueGuest.name;
                                    
                                }
                                
                            })(room.guests[key]);
                            
                            object._console.log(guestsList[key]);
                            var value = input.createInput(key, guestsList[key], inputData, function(event){
                                
                                var key = this.parentElement.getAttribute("data-guset");
                                var roomKey = this.parentElement.getAttribute('data-room');
                                var index = parseInt(this.selectedIndex);
                                var response = object._hotel.updateSelectedGuests(key, index, roomKey, true);
                                /**
                                var guestsList = object._hotel.getRoom(roomKey);
                                var list = JSON.parse(guestsList[key].json);
                                var selectedGuest = list[index];
                                guestsList[key].index = index;
                                guestsList[key].person = parseInt(selectedGuest.number);
                                object._console.log('roomKey = ' + roomKey);
                                object._console.log('index = ' + index);
                                object._console.log(selectedGuest);
                                **/
                                //var response = object._hotel.setGuests(key, index, list[index].number, parseInt(roomKey));
                                var feeList = object._hotel.getFeeList();
                                var verifyGuests = object._hotel.verifyGuestsInRooms(response.rooms);
                                object._console.log(verifyGuests);
                                var person = 0;
                                for (var key in verifyGuests.rooms) {
                                    
                                    person += parseInt(verifyGuests.rooms[key].person);
                                    
                                }
                                document.getElementById("totalGuests").textContent = person;
                                if(verifyGuests.booking == false || response.nights == 0 || verifyGuests.requiredGuests == false){
                                    
                                    saveButton.disabled = true;
                                    
                                }else{
                                    
                                    saveButton.disabled = false;
                                    
                                }
                                
                                totalNumberOfGuestsPanel.classList.remove("errorPanel");
                                if(verifyGuests.booking == false){
                                    
                                    totalNumberOfGuestsPanel.classList.add("errorPanel");
                                
                                }
                                
                                object._console.log(totalNumberOfGuestsPanel);
                                
                                object._console.log(response);
                                object._console.log(this.selectedIndex);
                                
                            });
                            value.id = "select_guests_" + roomKey + '_' + key;
                            value.setAttribute("data-guset", key);
                            value.setAttribute('data-room', parseInt(roomKey));
                            object._console.log(value);
                            var guestsParentPanel = document.getElementById("guests_" + roomKey + '_' + key).parentElement;
                            var guestsPanel = document.getElementById("guests_" + roomKey + '_' + key);
                            guestsPanel.classList.add("hidden_panel");
                            guestsParentPanel.appendChild(value);
                            object._console.log(guestsPanel);
                            guestsPanel = value;
                            
                        }
                        
                        
                    }
                    /** Rooms **/
                    /**
                    var guestsList = object._hotel.getGuestsList();
                    for(var key in guestsList){
                        
                        object._console.log(guestsList[key]);
                        var value = input.createInput(key, guestsList[key], inputData, function(event){
                            
                            var key = this.parentElement.getAttribute("data-guset");
                            var index = parseInt(this.selectedIndex);
                            var list = JSON.parse(guestsList[key].json);
                            guestsList[key].index = index;
                            var response = object._hotel.setGuests(key, index, list[index].number, 1);
                            var feeList = object._hotel.getFeeList();
                            document.getElementById("totalGuests").textContent = response.person;
                            if(response.booking == false || response.nights == 0 || response.requiredGuests == false){
                                
                                saveButton.disabled = true;
                                
                            }else{
                                
                                saveButton.disabled = false;
                                
                            }
                            
                            totalNumberOfGuestsPanel.classList.remove("errorPanel");
                            if(response.booking == false){
                                
                                totalNumberOfGuestsPanel.classList.add("errorPanel");
                            
                            }
                            
                            object._console.log(totalNumberOfGuestsPanel);
                            
                            object._console.log(response);
                            object._console.log(this.selectedIndex);
                            object._console.log(guestsList[key]);
                            object._console.log(list[index]);
                            
                        });
                        value.id = "select_guests_" + key;
                        value.setAttribute("data-guset", key);
                        object._console.log(value);
                        var guestsParentPanel = document.getElementById("guests_" + key).parentElement;
                        var guestsPanel = document.getElementById("guests_" + key);
                        guestsPanel.classList.add("hidden_panel");
                        guestsParentPanel.appendChild(value);
                        object._console.log(guestsPanel);
                        guestsPanel = value;
                        
                    }
                    **/
                    
                }
                
                
            }
            
            
            for(var i = 0; i < formPanelList.length; i++){
                
                //var key = parseInt(formPanelList[i].getAttribute("data-key"));
                var form = formData[i];
                object._console.log(i + " name = " + form.name);
                formPanel.removeChild(formPanelList[i]);
                var value = input.createInput(i, form, inputData, null);
                var rowPanel = object.createRowPanel(form.name, value, null, form.required, null);
                if(form.active != 'true'){
                    
                    rowPanel.classList.add("hidden_panel");
                    
                }
                inputPanelList[i] = rowPanel;
                //inputPanelList.push(rowPanel);
                formPanel.appendChild(rowPanel);
                
            }
            
            object._console.log(formPanelList);
            saveButton.onclick = function(){
                
                var date = {month: (reservationDate.month + 1), day: reservationDate.day, year: reservationDate.year};
                var schedule = {key: reservationData.scheduleKey, unixTime: reservationData.scheduleUnixTime};
                var course = {key: reservationData.courseKey};
                if(reservationData.courseKey == null){
                    course = null
                }
                
                var valueList = {};
                var post = object.verifyForm("updateBooking", object._nonce, object._action, date, schedule, course, formData, inputPanelList, inputData, valueList, []);
                var booking_date = null;
                if(calendarData.account.type == "day"){
                    
                    booking_date = document.getElementById("booking_date").getAttribute("data-key");
                    
                }else{
                    
                    booking_date = document.getElementById("checkIn").getAttribute("data-id");
                    
                }
                object._console.log(booking_date);
                if(booking_date != reservationData.scheduleKey){
                    
                    post['update_booking_date'] = booking_date;
                    
                }
                
                
                if(calendarData.account.type == "hotel"){
                    
                    post.json = JSON.stringify(object._hotel.verifySchedule(false));
                    
                }
                
                //if (document.getElementById("booking_course") != null && document.getElementById("booking_course").getAttribute("data-key") != reservationData.courseKey) {
                if (document.getElementById("booking_course") != null) {
                    
                    var booking_course = document.getElementById("booking_course").getAttribute("data-key");
                    object._console.log(booking_course);
                    post['update_booking_course'] = booking_course;
                    
                }
                
                post.month = parseInt(month);
                post.day = parseInt(day);
                post.year = year;
                if(options == null) {
                    
                    options = "[]";
                    
                }
                post.options = options;
                object._console.log(typeof options);
                var visitorServices = object.getVisitorServices();
                if (typeof visitorServices == "object") {
                    
                    var services = [];
                    for (var key in object._courseList) {
                        
                        var service = object._courseList[key];
                        for (var visitorKey in visitorServices) {
                            
                            var visitorService = visitorServices[visitorKey];
                            if (parseInt(service.key) == parseInt(visitorService.key) && parseInt(visitorService.selected) == 1) {
                                
                                visitorService.options = visitorService.selectedOptionsList;
                                object._console.log(visitorService);
                                services.push(visitorService);
                                
                            }
                            
                        }
                        
                        
                    }
                    
                    post.options = JSON.stringify(services);
                    
                }
                object._console.log(post);
                //return null;
                
                if (post !== false) {
                    
                    
                    object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
                    post.accountKey = reservationData.accountKey;
                    post.updateKey = reservationData.key;
                    object._console.log(post);
                    new Booking_App_XMLHttp(object._url, post, object._webApp, function(response){
                        
                        object._console.log(response);
                        if (response.status == "success") {
                            
                            object._hotel.reset();
                            object._hotel.setCallback(null);
                            var updateDate = {month: parseInt(month), day: parseInt(day), year: year};
                            response.updateDate = updateDate;
                            
                            object._rightButtonPanel.textContent = null;
                            response.action = 'refresh';
                            object._buttonAction = "reservation_users";
                            object.createCalendar(response, response.date.month, response.date.day, response.date.year, accountKey);
                            callback(response);
                            object._contentPanel.removeChild(blockPanel);
                            infoPanel.setAttribute("class", "return_panel");
                            if (document.getElementById("changePanel") != null) {
                    
                                document.getElementById("changePanel").setAttribute("class", "return_panel");
                                
                            }
                            
                        } else {
                            
                            if (response.message != null) {
                                
                                alert(response.message);
                                
                            } else {
                                
                                alert(response);
                                
                            }
                            
                            
                        }
                        object._loadingPanel.setAttribute("class", "hidden_panel");
                        
                    }, function(responseText){
                        
                        object.setResponseText(responseText);
                        
                    });
                    
                }
                
            }
            
            returnButton.onclick = function(){
                
                var edit_title = document.getElementById("edit_title");
                edit_title.textContent = object._calendar.formatBookingDate(reservationData.date.month, reservationData.date.day, reservationData.date.year, null, null, null, null, 'text');
                
                if(document.getElementById("changePanel") != null && document.getElementById("changePanel").getAttribute("class") != "return_panel"){
                    
                    document.getElementById("changePanel").setAttribute("class", "return_change_panel");
                    
                }
                
                object._rightButtonPanel.removeChild(returnButton);
                object._rightButtonPanel.removeChild(saveButton);
                editButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
                deleteButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
                for(var key in inputPanelList){
                    
                    formPanel.removeChild(inputPanelList[key]);
                    //var form = formData[i];
                    var rowPanel = object.createRowPanel(formData[key]['name'], formData[key]['value'], null, null, null);
                    if(formData[key].active != 'true'){
                        
                        rowPanel.classList.add("hidden_panel");
                        
                    }
                    formPanelList[key] = rowPanel;
                    formPanel.appendChild(rowPanel);
                
                }
                
                cancelToEdit();
                object._buttonAction = "showUserInfo";
                
            }
            
            
        }
        
        deleteButton.onclick = function(){
            
            object._console.log(object._emailEnableList);
            object._console.log("enable = " + Boolean(parseInt(object._emailEnableList.mail_deleted.enable)));
            
            var enable = false;
            if (Boolean(parseInt(object._emailEnableList.mail_deleted.enable)) === false) {
                
                enable = true;
                
            }
            object._console.log("enable = " + enable);
            
            var confirm = new Confirm(object._debug);
            var refoundBool = true;
            if (reservationData.payToken != null && reservationData.payToken.length != 0) {
                
                refoundBool = false;
                
            }
            object._console.log(reservationData.payToken);
            confirm.dialogPanelShow(object._i18n.get("Attention"), object._i18n.get("This booking has been paid by credit card. Do you refund the price to the customer?"), refoundBool, function(refoundValue){
                
                object._console.log("refoundValue = " + refoundValue);
                confirm.dialogPanelShow(object._i18n.get("Attention"), object._i18n.get("Do you send e-mail notifications to customers or administrators?"), enable, function(sendEmail){
                    
                    object._console.log("sendEmail = " + sendEmail);
                    object._console.log("sendEmail = " + parseInt(sendEmail));
                    confirm.dialogPanelShow(object._i18n.get("Warning"), object._i18n.get("Are you sure you want to delete this booking?"), false, function(result){
                        
                        object._console.log(result);
                        if (result == true) {
                            
                            object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
                            var post = {nonce: object._nonce, action: object._action, mode: 'deleteBookingData', key: reservationData.key, token: reservationData.cancellationToken, sendEmail: Number(sendEmail), refound: Number(refoundValue), accountKey: reservationData.accountKey};
                            new Booking_App_XMLHttp(object._url, post, object._webApp, function(response) {
                                
                                object._console.log(response);
                                if (response.status == 'success') {
                                    
                                    object._hotel.reset();
                                    object._hotel.setCallback(null);
                                    object._rightButtonPanel.textContent = null;
                                    object._console.log(blockPanel);
                                    if (blockPanel != null) {
                                        
                                        object._contentPanel.removeChild(blockPanel);
                                        
                                    }
                                    
                                    infoPanel.setAttribute("class", "return_panel");
                                    if (document.getElementById("changePanel") != null) {
                                        
                                        document.getElementById("changePanel").setAttribute("class", "return_panel");
                                        
                                    }
                                    object._buttonAction = "reservation_users";
                                    object.createCalendar(response, response.date.month, response.date.day, response.date.year, accountKey);
                                    callback(response);
                                    
                                } else {
                                    
                                    window.alert(response.message);
                                    
                                }
                                object._loadingPanel.setAttribute("class", "hidden_panel");
                                
                            }, function(responseText){
                                
                                object.setResponseText(responseText);
                                
                            });
                            
                        }
                        
                    });
                    
                });
                
            });
            
        }
        
        var month = reservationData.date.month;
        var day = reservationData.date.day;
        var year = reservationData.date.year;
        var confirm = new Confirm(object._debug);
        
        bookingTimeChange.onclick = function(){
            
            object._console.log(options);
            //if(typeof ExtensionsFunction != "function"){
            if (object._isExtensionsValid == 0) {
                
                confirm.alertPanelShow(object._i18n.get("Warning"), object._i18n.get("Please upgrade your free plan to enable this feature."), false, null);
                return null;
                
            }
            
            var data_status = parseInt(bookingTimeChange.getAttribute("data-status"));
            if(data_status == 1){
                
                data_status = 0;
                bookingTimeChange.textContent = object._i18n.get("Change");
                courseChange.classList.add("hidden_panel");
                object.createToChangePanelForTimeOrCourse(month, day, year, reservationData, calendarData, "date", options, accountKey, function(response){
                    
                    object._console.log("bookingTimeChange.onclick");
                    object._console.log(response);
                    if(response.status == "statusButton"){
                        
                        calendarData = response.calendarData;
                        bookingTimeChange.setAttribute("data-status", response.value);
                        bookingTimeChange.textContent = object._i18n.get("Change");
                        courseChange.classList.remove("hidden_panel");
                        document.getElementById("beforChangeButton").classList.add("hidden_panel");
                        document.getElementById("nextChangeButton").classList.add("hidden_panel");
                        
                    }else if(response.status == "statusButton"){
                        
                        
                        
                    }else{
                        
                        if(response.month != null && response.day != null && response.year != null){
                            
                            month = response.month;
                            day = response.day;
                            year = response.year;
                            
                        }
                        
                        calendarData = response.calendarData;
                        callback(response);
                        
                    }
                    
                    
                });
                
            }else{
                
                data_status = 1;
                bookingTimeChange.textContent = object._i18n.get("Change");
                courseChange.classList.remove("hidden_panel");
                document.getElementById("beforButton").classList.add("hidden_panel");
                document.getElementById("nextButton").classList.add("hidden_panel");
                document.getElementById('downloadCsvForDay').classList.add('hidden_panel');
                document.getElementById("beforChangeButton").classList.remove("hidden_panel");
                document.getElementById("nextChangeButton").classList.remove("hidden_panel");
                document.getElementById("changePanel").setAttribute("class", "return_change_panel");
                
            }
            bookingTimeChange.setAttribute("data-status", data_status);
            
            
        }
        
        
        courseChange.onclick = function(){
            
            object._console.log(options);
            object._console.log(object.getVisitorServices());
            //if(typeof ExtensionsFunction != "function"){
            if (object._isExtensionsValid == 0) {
                
                confirm.alertPanelShow(object._i18n.get("Warning"), object._i18n.get("Please upgrade your free plan to enable this feature."), false, null);
                return null;
                
            }
            
            var data_status = parseInt(courseChange.getAttribute("data-status"));
            if(data_status == 1){
                
                data_status = 0;
                courseChange.textContent = object._i18n.get("Change");
                bookingTimeChange.classList.add("hidden_panel");
                object.createToChangePanelForTimeOrCourse(month, day, year, reservationData, calendarData, "course", options, accountKey, function(response){
                    
                    object._console.log(response);
                    if(response.status == "statusButton"){
                        
                        object._console.log(options);
                        options = response.options;
                        object._console.log(options);
                        calendarData = response.calendarData;
                        courseChange.setAttribute("data-status", response.value);
                        courseChange.textContent = object._i18n.get("Change");
                        bookingTimeChange.classList.remove("hidden_panel");
                        
                    }else if(response.status == "statusButton"){
                        
                        
                        
                    }else{
                        
                        if(response.month != null && response.day != null && response.year != null){
                            
                            month = response.month;
                            day = response.day;
                            year = response.year;
                            
                        }
                        
                        calendarData = response.calendarData;
                        callback(response);
                        
                    }
                    
                    
                });
                
            }else{
                
                data_status = 1;
                courseChange.textContent = object._i18n.get("Change");
                bookingTimeChange.classList.remove("hidden_panel");
                document.getElementById("beforButton").classList.add("hidden_panel");
                document.getElementById("nextButton").classList.add("hidden_panel");
                document.getElementById('downloadCsvForDay').classList.add('hidden_panel');
                document.getElementById("changePanel").setAttribute("class", "return_change_panel");
                
            }
            courseChange.setAttribute("data-status", data_status);
            
        }
        
    }
    
    this.showUserDetails = function(key, calendarData, reservationData, accountKey, showStatusForHotel, infoPanel, bookingTimeChange, courseChange, callback){
        
        var object = this;
        var options = "[]";
        object._courseName = calendarData.account.courseTitle;
        object._console.log("showStatusForHotel = " + showStatusForHotel);
        object._console.log(object._calendarAccount);
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
    	object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
        object._calendar.setClock(object._clock);
        infoPanel.textContent = null;
        
        var reservationDate = reservationData.date;
        var date = object._calendar.formatBookingDate(reservationDate.month, reservationDate.day, reservationDate.year, reservationDate.hour, reservationDate.min, reservationData.scheduleTitle, reservationDate.week, 'text');
        
        var timestampDate = reservationData.timestamp;
        var timestamp = object._calendar.formatBookingDate(timestampDate.month, timestampDate.day, timestampDate.year, timestampDate.hour, timestampDate.min, '', timestampDate.week, 'text');
        
        var month = reservationData.date.month;
        var day = reservationData.date.day;
        var year = reservationData.date.year;
        var expirationDate = parseInt(reservationData.date.key);
        var coupon = reservationData.coupon;
        object._console.log(reservationData);
        object._console.log(date);
        object._console.log(timestamp);
        object._console.log(coupon);
        
        var formPanel = document.createElement("div");
        formPanel.id = "inputFormPanel";
        infoPanel.appendChild(formPanel);
        
        var totalNumberOfGuestsPanel = null;
        
        var rowPanel = object.createRowPanel("ID", reservationData.key, null, null, null);
        formPanel.appendChild(rowPanel);
        
        if (showStatusForHotel === true) {
            
            var statusPanel = object.createRowPanel(object._i18n.get("Status"), "", "status", "false", null);
            formPanel.appendChild(statusPanel);
            var statusLabel = document.getElementById("status");
            var className = "visitorApprovedPanel";
            var status = "approved";
            if (reservationData.status.toLowerCase() == "pending") {
                
                className = "visitorPendingPanel";
                status = "pending";
                
            } else if (reservationData.status.toLowerCase() == "canceled") {
                
                className = "visitorCanceledPanel";
                status = "canceled";
                
            }
            statusLabel.classList.add("visitorStatus");
            statusLabel.classList.add(className);
            statusLabel.textContent = object._i18n.get(status);
            if (status.toUpperCase() != 'CANCELED') {
                
                statusLabel.onclick = function(){
                    
                    object._console.log(this);
                    if (reservationData.status != 'canceled') {
                        
                        object.changeStatus(accountKey, reservationData, null, true, function(response){
                            
                            object._console.log(response);
                            if (response.bookingStatus == null) {
                                
                                return null;
                                
                            }
                            var className = "visitorApprovedPanel";
                            var status = object._i18n.get("approved");
                            reservationData.status = "approved";
                            if (response.bookingStatus.toLowerCase() == "pending") {
                                
                                className = "visitorPendingPanel";
                                status = object._i18n.get("pending");
                                reservationData.status = "pending";
                                
                            } else if (response.bookingStatus.toLowerCase() == "canceled") {
                                
                                className = "visitorCanceledPanel";
                                status = object._i18n.get("canceled");
                                reservationData.status = "canceled";
                                
                            }
                            statusLabel.setAttribute("class", "value visitorStatus " + className);
                            statusLabel.textContent = status;
                            
                            callback(response);
                            
                        });
                        
                    }
                    
                };
                
            }
            
        }
        
        if (calendarData.account.type == "hotel") {
            
            object._console.log(object._hotel);
            object._hotel.reset();
            object._hotel.setCallback(null);
            object._hotel.setCalendarAccount(calendarData.account);
            object._hotel.setNights(parseInt(reservationData.accommodationDetails.nights));
            
            var checkInDate = parseInt(reservationData.date.checkIn);
            var checkOutDate = parseInt(reservationData.date.checkOut);
            object._console.log("checkInDate = " + checkInDate + " checkOutDate = " + checkOutDate);
            
            var visitorsScheduleList = reservationData.accommodationDetails.scheduleDetails;
            var scheduleList = calendarData.schedule;
            for (var key in visitorsScheduleList) {
                
                object._hotel.addSchedule(visitorsScheduleList[key]);
                
            }
            
            if (scheduleList[checkInDate] != null) {
                
                object._hotel.setCheckIn(scheduleList[checkInDate][0]);
                
            }
            
            if (scheduleList[checkOutDate] != null) {
                
                object._hotel.setCheckOut(scheduleList[checkOutDate][0]);
                
            }
            
            object._hotel.setCheckIn(reservationData.accommodationDetails.checkInSchedule);
            object._hotel.setCheckInKey(reservationData.accommodationDetails.checkInSchedule.key);
            object._hotel.setCheckOut(reservationData.accommodationDetails.checkOutSchedule);
            object._hotel.setCheckOutKey(reservationData.accommodationDetails.checkOutSchedule.key);
            
            object._console.log(object._hotel.getCheckDate());
            
            
            
            var visitorsDetails = object._hotel.verifySchedule(false);
            object._console.log(visitorsDetails);
            
            var expressionsCheck = object._calendar.getExpressionsCheck(calendarData.account.expressionsCheck);
            
            var date = object._calendar.formatBookingDate(reservationData.date.checkIn_month, reservationData.date.checkIn_day, reservationData.date.checkIn_year, null, null, null, reservationData.date.checkIn_week, 'text');
            var checkIn = object.createRowPanel(expressionsCheck.arrival, date, "checkIn", "false", null);
            formPanel.appendChild(checkIn);
            document.getElementById("checkIn").setAttribute("data-id", reservationData.scheduleKey);
            
            date = object._calendar.formatBookingDate(reservationData.date.checkOut_month, reservationData.date.checkOut_day, reservationData.date.checkOut_year, null, null, null, reservationData.date.checkOut_week, 'text');
            var checkOut = object.createRowPanel(expressionsCheck.departure, date, "checkOut", "false", null);
            formPanel.appendChild(checkOut);
            
            var nightsValue = reservationData.accommodationDetails.nights + ' ' + object._i18n.get("nights");
            if (parseInt(object._calendarAccount.formatNightDay) == 1) {
                
                nightsValue = object._i18n.get("%s nights %s days", [reservationData.accommodationDetails.nights, reservationData.accommodationDetails.nights + 1]);
                
            }
            
            if (reservationData.accommodationDetails.nights == 1) {
                
                nightsValue = reservationData.accommodationDetails.nights + ' ' + object._i18n.get("night");
                if (parseInt(object._calendarAccount.formatNightDay) == 1) {
                    
                    nightsValue = object._i18n.get("%s night %s days", [reservationData.accommodationDetails.nights, reservationData.accommodationDetails.nights + 1]);
                    
                }
                
            }
            var totalLengthOfStay = object.createRowPanel(object._i18n.get("Total length of stay"), nightsValue, null, null, null);
            formPanel.appendChild(totalLengthOfStay);
            
            /** Rooms **/
            
            var roomListPanel = document.createElement('div');
            roomListPanel.classList.add('row');
            roomListPanel.classList.add('roomListPanel');
            roomListPanel.id = 'roomListPanel';
            formPanel.appendChild(roomListPanel);
            object._console.log(reservationData.accommodationDetails);
            object._console.log(reservationData.accommodationDetails.rooms);
            for (var roomKey in reservationData.accommodationDetails.rooms) {
                
                var roomNumber = parseInt(roomKey);
                var roomPanel = document.createElement('div');
                roomPanel.id = 'roomNo_' + roomNumber;
                roomListPanel.appendChild(roomPanel);
                
                var roomNoLabel = document.createElement('label');
                roomNoLabel.classList.add('roomNoLabel');
                roomNoLabel.textContent = object._i18n.get('room') + ': ' + (roomNumber + 1);
                roomPanel.appendChild(roomNoLabel);
                
                var room = reservationData.accommodationDetails.rooms[roomKey];
                object._console.log(room);
                var guestsList = room.guestsList;
                for (var key in guestsList) {
                    
                    var value = "None";
                    var list = guestsList[key].json;
                    object._console.log(typeof list);
                    if (typeof list == "string") {
                        
                        list = JSON.parse(list);
                        
                    } else {
                        
                        guestsList[key].json = JSON.stringify(list);
                        
                    }
                    
                    guestsList[key].type = "SELECT";
                    guestsList[key].value = 0;
                    guestsList[key].index = 0;
                    guestsList[key].person = 0;
                    object._hotel.addGuests(key, guestsList[key], parseInt(roomKey));
                    var values = [];
                    for (var i = 0; i < list.length; i++) {
                        
                        if (parseInt(list[i].selected) == 1) {
                            
                            object._console.log(list[i].name)
                            value = list[i].name;
                            guestsList[key].value = i;
                            guestsList[key].person = parseInt(list[i].number);
                            var response = object._hotel.setGuests(key, i, list[i].number, parseInt(roomKey));
                            
                        }
                        
                        values.push(list[i].name);
                        
                    }
                    
                    guestsList[key].values = values;
                    //object._hotel.addGuests(key, guestsList[key], 1);
                    var guestsPanel = object.createRowPanel(guestsList[key].name, value, "guests_" + roomKey + '_' + guestsList[key].key, "false", null);
                    guestsPanel.setAttribute('class', 'rowRoom');
                    roomPanel.appendChild(guestsPanel);
                    
                }
                
            }
            
            /** Rooms **/
            
            object._console.log(object._hotel.getGuestsList());
            
            if(reservationData.accommodationDetails.adult != null && reservationData.accommodationDetails.children != null){
                
                var totalNumberOfGuests = parseInt(reservationData.accommodationDetails.adult) + parseInt(reservationData.accommodationDetails.children);
                var totalNumberOfGuestsValue = 0;
                if(totalNumberOfGuests > 1){
                    
                    totalNumberOfGuestsValue = totalNumberOfGuests + " " + object._i18n.get("people");
                    
                }else if(totalNumberOfGuests == 1){
                    
                    totalNumberOfGuestsValue = totalNumberOfGuests + " " + object._i18n.get("person");
                    
                }
                
                totalNumberOfGuestsPanel = object.createRowPanel(object._i18n.get("Total number of guests"), String(totalNumberOfGuestsValue), "totalGuests", null, null);
                formPanel.appendChild(totalNumberOfGuestsPanel);
                
            }
            
            object._hotel.setTaxes(reservationData.accommodationDetails.taxes);
            
            var summaryListPanel = document.createElement("div");
            summaryListPanel.id = "summaryListPanel";
            var summaryPanel = object.createRowPanel(object._i18n.get("Summary"), summaryListPanel, "summaryPanel", null, null);
            formPanel.appendChild(summaryPanel);
            object._hotel.showSummary(summaryListPanel, expressionsCheck);
            
            var taxValue = 0;
            for (var i = 0; i < reservationData.taxes.length; i++) {
                
                var tax = reservationData.taxes[i];
                if (tax.active != 'true') {
                    
                    continue;
                    
                }
                
                if ((tax.type == 'tax' && tax.tax == 'tax_exclusive') || tax.type == 'surcharge') {
                    
                    taxValue += parseInt(tax.taxValue);
                    
                }
                
            }
            
            object._console.log("taxValue = " + taxValue);
            
            //var totalPrice = object._format.formatCost(reservationData.accommodationDetails.additionalFee + reservationData.accommodationDetails.accommodationFee + reservationData.accommodationDetails.taxesFee, object._currency);
            var totalPrice = object._format.formatCost(reservationData.accommodationDetails.totalCost, object._currency);
            object._console.log("totalPrice = " + totalPrice);
            
            var rowPanel = object.createRowPanel(object._i18n.get("Total amount"), totalPrice, "totalPrice", null, null);
            formPanel.appendChild(rowPanel);
            
            var timestampPanel = object.createRowPanel(object._i18n.get("Submission date"), timestamp, "timestamp", null, null);
            formPanel.appendChild(timestampPanel);
            
        } else {
            
            var date = object._calendar.formatBookingDate(reservationDate.month, reservationDate.day, reservationDate.year, reservationDate.hour, reservationDate.min, reservationData.scheduleTitle, reservationData.date.week, 'elements');
            var rowPanel = object.createRowPanel(object._i18n.get("Booking Date"), date.dateAndTime, "booking_date", null, bookingTimeChange);
            formPanel.appendChild(rowPanel);
            document.getElementById("booking_date").setAttribute("data-key", reservationData.scheduleKey);
            document.getElementById("booking_date").setAttribute("data-unixTime", reservationData.scheduleUnixTime);
            var guests = [];
            if (typeof reservationData.guests.guests == 'object') {
                
                guests = reservationData.guests.guests;
                
            }
            object._console.log(guests);
            if (guests.length > 0) {
                
                object.showGuestsPanelForDays(formPanel, guests);
                
            }
            
            var goodsList = [];
            var responseGuests = [];
            var cost = 0;
            if(reservationData.options.length > 0){
                
                var serviceCost = 0;
                var hasMultipleServices = false;
                for (var key in reservationData.options) {
                    
                    var service = reservationData.options[key];
                    if (parseInt(service.service) == 1) {
                        
                        hasMultipleServices = true;
                        cost += parseInt(service.cost);
                        for (var optionKey in service.options) {
                            
                            var option = service.options[optionKey];
                            if (parseInt(option.selected) == 1) {
                                
                                cost += parseInt(option.cost);
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
                if (serviceCost > 0) {
                    
                    //reservationData.courseCost = serviceCost;
                    
                }
                
                object._console.log("serviceCost = " + serviceCost);
                object._console.log("cost = " + cost);
                object._console.log("hasMultipleServices = " + hasMultipleServices);
                var courseCostPanel = null;
                object._console.log(parseInt(reservationData.courseCost));
                if (parseInt(reservationData.courseCost) > 0) {
                    
                    courseCostPanel = document.createElement("span");
                    courseCostPanel.classList.add("planPrice");
                    courseCostPanel.textContent = object._format.formatCost(reservationData.courseCost, reservationData.currency);
                    
                }
                
                var rowPanel = object.createRowPanel(object._courseName, "", "booking_course", null, courseChange);
                var valuePanel = rowPanel.getElementsByClassName("value")[0];
                valuePanel.textContent = null;
                
                var coursePanel = document.createElement("div");
                coursePanel.classList.add("mainPlan");
                valuePanel.appendChild(coursePanel);
                
                var courseNamePanel = document.createElement("span");
                courseNamePanel.classList.add("planName");
                courseNamePanel.textContent = reservationData.courseName;
                coursePanel.appendChild(courseNamePanel);
                if (courseCostPanel != null && hasMultipleServices === false) {
                    
                    coursePanel.appendChild(courseCostPanel);
                    
                }
                
                if (reservationData.options != "") {
                    
                    if (hasMultipleServices == true) {
                        
                        cost = 0;
                        var services = reservationData.options;
                        for (var key in services) {
                            
                            services[key].selected = 1;
                            
                        }
                        object._console.log(services);
                        var guestsBool = 0;
                        if (guests.length > 0) {
                            
                            guestsBool = 1;
                            
                        }
                        var response = object.createServicesPanel(coursePanel, services, "options", guests, guestsBool, goodsList, reservationData.currency);
                        object._console.log(response);
                        goodsList = response.goodsList;
                        cost += response.totalCost;
                        responseGuests = object._servicesControl.getValueReflectGuests(guests);
                        object._console.log(responseGuests);
                        
                    } else {
                        
                        var options = reservationData.options;
                        if (options.length > 0) {
                            
                            var ul = document.createElement("ul");
                            valuePanel.appendChild(ul);
                            for(var i = 0; i < options.length; i++){
                                
                                var option = options[i];
                                if (parseInt(option.selected) == 1) {
                                    
                                    cost += parseInt(option.cost);
                                    
                                    var optionNamePanel = document.createElement("span");
                                    optionNamePanel.classList.add("planName");
                                    optionNamePanel.textContent = option.name;
                                    
                                    var optionPricePanel = document.createElement("span");
                                    optionPricePanel.classList.add("planPrice");
                                    if (parseInt(option.cost) > 0) {
                                        
                                        optionPricePanel.textContent = object._format.formatCost(option.cost, reservationData.currency);
                                        
                                    }
                                    
                                    var li = document.createElement("li");
                                    li.appendChild(optionNamePanel);
                                    li.appendChild(optionPricePanel);
                                    ul.appendChild(li);
                                    
                                }
                                
                            }
                            
                        } else {
                            
                            console.error("option = " + option);
                            
                        }
                        
                    }
                    
                }
                
                object._console.log(reservationData.options);
                formPanel.appendChild(rowPanel);
                document.getElementById("booking_course").setAttribute("data-key", reservationData.courseKey);
                document.getElementById("booking_course").setAttribute("data-time", reservationData.courseTime);
                if (object.getServiceOrOption(reservationData.options) == 'service') {
                    
                    document.getElementById("booking_course").setAttribute("data-key", "multipleServices");
                    
                }
                
                
                
            }
            
            
            if(reservationData.scheduleCost != null){
                
                cost += parseInt(reservationData.scheduleCost);
                
            }
            
            if(reservationData.courseCost != null){
                
                cost += parseInt(reservationData.courseCost);
                
            }
            
            object._console.log('cost = ' + cost);
            if (coupon.key != null) {
                
                var couponPanel = object.createRowPanel("Added a coupon", "", null, null, null);
                formPanel.appendChild(couponPanel);
                
                /** Coupon code **/
                var namePanel = document.createElement('span');
                namePanel.classList.add('planName');
                namePanel.textContent = object._i18n.get('Coupon code');
                var valuePanel = document.createElement('span');
                valuePanel.classList.add('planPrice');
                valuePanel.textContent = coupon.id;
                var couponCodePanel = document.createElement('div');
                couponCodePanel.id = 'added_coupon_code';
                couponCodePanel.classList.add('mainPlan');
                couponCodePanel.appendChild(namePanel);
                couponCodePanel.appendChild(valuePanel);
                
                /** Coupon name **/
                var namePanel = document.createElement('span');
                namePanel.classList.add('planName');
                namePanel.textContent = object._i18n.get('Coupon');
                var valuePanel = document.createElement('span');
                valuePanel.classList.add('planPrice');
                valuePanel.textContent = coupon.name;
                var couponNamePanel = document.createElement('div');
                couponNamePanel.id = 'added_coupon_name';
                couponNamePanel.classList.add('mainPlan');
                couponNamePanel.appendChild(namePanel);
                couponNamePanel.appendChild(valuePanel);
                
                /** Coupon name **/
                var namePanel = document.createElement('span');
                namePanel.classList.add('planName');
                namePanel.textContent = object._i18n.get('Discount');
                var valuePanel = document.createElement('span');
                valuePanel.classList.add('planPrice');
                if (coupon.method == 'subtraction') {
                    
                    valuePanel.textContent = object._format.formatCost(coupon.value, object._currency);
                    cost = object.getDiscountCostByCoupon(coupon, cost);
                    
                } else {
                    
                    valuePanel.textContent = coupon.value + '%';
                    cost = object.getDiscountCostByCoupon(coupon, cost);
                    
                }
                var couponDiscountPanel = document.createElement('div');
                couponDiscountPanel.id = 'added_coupon_discount';
                couponDiscountPanel.classList.add('mainPlan');
                couponDiscountPanel.appendChild(namePanel);
                couponDiscountPanel.appendChild(valuePanel);
                
                couponPanel.appendChild(couponCodePanel);
                couponPanel.appendChild(couponNamePanel);
                couponPanel.appendChild(couponDiscountPanel);
                object._console.log('cost = ' + cost);
                
            }
            
            
            var surchargePanel = object.createRowPanel("Surcharge", "", null, null, null);
            surchargePanel.id = "surchargeTaxTitle";
            var taxePanel = object.createRowPanel("Tax", "", null, null, null);
            object._servicesControl.setExpirationDate(expirationDate);
            var taxes = new TAXES(object._i18n, reservationData.currency, object._debug);
            taxes.setBooking_App_ObjectsControl(object._servicesControl);
            taxes.setTaxes(reservationData.taxes);
            var isTaxes = taxes.taxesDetails(cost, formPanel, surchargePanel, taxePanel, responseGuests);
            object._console.log(isTaxes);
            if (isTaxes.isTaxes === true) {
                
                formPanel.appendChild(isTaxes.surchargePanel);
                /**
                var responseTaxes = taxes.getTaxes();
                object._console.log(responseTaxes);
                for (var key in responseTaxes) {
                    
                    var tax = responseTaxes[key];
                    if (tax.active != 'true') {
                        
                        continue;
                        
                    }
                    
                    if ((tax.type == 'tax' && tax.tax == 'tax_exclusive') || tax.type == 'surcharge') {
                        
                        cost += parseInt(tax.taxValue);
                        
                    }
                    
                }
                **/
                var responseTaxes = taxes.getTaxes();
                var reflectAdditional = 1;
                if (responseGuests.reflectAdditional > 0) {
                    
                    reflectAdditional = responseGuests.reflectAdditional;
                    
                }
                object._console.log('reflectAdditional = ' + reflectAdditional);
                cost += taxes.reflectTaxesInTotalCost(responseTaxes, goodsList, reflectAdditional);
                
            }
            /**
            var responseTaxes = taxes.getTaxes();
            object._console.log(responseTaxes);
            for (var key in responseTaxes) {
                
                var tax = responseTaxes[key];
                if (tax.active != 'true') {
                    
                    continue;
                    
                }
                
                if ((tax.type == 'tax' && tax.tax == 'tax_exclusive') || tax.type == 'surcharge') {
                    
                    cost += parseInt(tax.taxValue);
                    
                }
                
            }
            **/
            
            if(cost != 0){
                
                cost = object._format.formatCost(cost, reservationData.currency);
                var rowPanel = object.createRowPanel(object._i18n.get("Total amount"), cost, "booking_cost", null, null);
                formPanel.appendChild(rowPanel);
                
            }
            
            var timestampPanel = object.createRowPanel(object._i18n.get("Submission date"), timestamp, "timestamp", null, null);
            formPanel.appendChild(timestampPanel);
            
        }
        
        
        
        if(reservationData.payId == "stripe" || reservationData.payId == "paypal"){
            
            var rowPanel = object.createRowPanel("Charge ID of " + reservationData.payName, reservationData.payToken, "booking_cost", null, null);
            formPanel.appendChild(rowPanel);
            
        }
        
        var formPanelList = [];
        var formData = reservationData.praivateData;
        if(formData != null){
            
            for(var i = 0; i < formData.length; i++){
                
                var rowPanel = object.createRowPanel(formData[i]['name'], formData[i]['value'], null, null, null);
                rowPanel.setAttribute("data-key", i);
                if(formData[i].active != null && formData[i].active != 'true'){
                    
                    //continue;
                    rowPanel.classList.add("hidden_panel");
                    
                }
                formPanel.appendChild(rowPanel);
                formPanelList.push(rowPanel);
                
            }
            
        }
        
        return {formPanel: formPanel, formPanelList: formPanelList, totalNumberOfGuestsPanel: totalNumberOfGuestsPanel, formData: formData};
        
    }
    
    this.getDiscountCostByCoupon = function(coupon, totalCost) {
        
        var object = this;
        if (coupon.key == null) {
            
            return totalCost;
            
        }
        
        if (coupon.method == 'subtraction') {
            
            if (totalCost > parseInt(coupon.value)) {
                
                totalCost -= parseInt(coupon.value);
                
            } else {
                
                totalCost = 0;
                
            }
            
        } else {
            
            totalCost -= totalCost - (totalCost * (100 - parseInt(coupon.value)) / 100);
            
        }
        
        return parseInt(totalCost);
        
    }
    
    this.showGuestsPanelForDays = function(formPanel, guests) {
        
        var object = this;
        for (var i = 0; i < guests.length; i++) {
            
            var guest = guests[i];
            object._console.log(guest);
            if (guest.index == null) {
                
                continue;
                
            }
            var value = guest.json[guest.index];
            object._console.log(value);
            var rowPanel = object.createRowPanel(guest.name, value.name, object._prefix + guest.key, null, null);
            formPanel.appendChild(rowPanel);
            
        }
        //var rowPanel = object.createRowPanel(object._i18n.get("Booking Date"), date, "booking_date", null, bookingTimeChange);
        var responseGuests = object._servicesControl.getValueReflectGuests(guests);
        object._console.log(responseGuests);
        if (responseGuests.totalNumberOfGuests > 0) {
            
            var totalNumberOfGuestsPanel = object.createRowPanel(object._i18n.get('Total number of people'), responseGuests.totalNumberOfGuestsTitle, object._prefix + 'totalNumberOfGuests', null, null);
            formPanel.appendChild(totalNumberOfGuestsPanel);
            
        }
        
    }
    
    this.createToChangePanelForTimeOrCourse = function(month, day, year, reservationData, calendarData, changeAction, options, accountKey, callback){
        
        var object = this;
        var preparation = JSON.parse(reservationData.preparation);
        object._console.log("month = " + month + " day = " + day + " year = " + year);
        object._console.log(reservationData);
        object._console.log(reservationData.guests);
        object._console.log(preparation);
        
        var isGuests = 0;
        var guests = [];
        if (reservationData.guests.guests != null) {
            
            isGuests = 1;
            guests = reservationData.guests.guests;
            
        }
        object._console.log(guests);
        
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
    	object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
    	object._calendar.setClock(object._clock);
    	let expirationDate = object._calendar.getDateKey(month, day, year);
    	var calendarKey = object._calendar.getDateKey(month, day, year);
        object._nationalHoliday = calendarData.nationalHoliday.calendar;
        
        var edit_title = document.getElementById("edit_title");
        edit_title.textContent = object._calendar.formatBookingDate(month, day, year, null, null, null, calendarData.calendar[calendarKey].week, 'text');
        
        var changePanel = null;
        if(document.getElementById("changePanel") == null){
            
            changePanel = document.createElement("div");
            changePanel.id = "changePanel";
            object._contentPanel.appendChild(changePanel);
            
        }else{
            
            changePanel = document.getElementById("changePanel");
            
        }
        changePanel.classList.add("hidden_panel");
        document.getElementById("beforButton").classList.add("hidden_panel");
        document.getElementById("nextButton").classList.add("hidden_panel");
        document.getElementById('downloadCsvForDay').classList.add('hidden_panel');
        var beforChangeButton = document.getElementById("beforChangeButton");
        var nextChangeButton = document.getElementById("nextChangeButton");
        if (changeAction == "date") {
            
            object._buttonAction = "updateSchedule";
            beforChangeButton.classList.remove("hidden_panel");
            nextChangeButton.classList.remove("hidden_panel");
            
        } else {
            
            object._buttonAction = "showUserInfo";
            
        }
        
        var changeButtonAction = function(mode, month, day, year, calendarData){
            
            object._console.log("mode = " + mode);
            object._console.log("buttonAction = " + object._buttonAction);
            if(object._buttonAction != 'updateSchedule'){
                
                return null;
                
            }
            
            month = parseInt(month);
            day = parseInt(day);
            year = parseInt(year);
            var lastDay = parseInt(calendarData.date.lastDay);
            
            object._console.log("month = " + month + " day = " + day + " year = " + year + " lastDay = " + lastDay);
            var date = object.verifyCalendar(mode, month, day, year, lastDay);
            if(date.calendarChange === 0){
                
                object.createToChangePanelForTimeOrCourse(date.month, date.day, date.year, reservationData, calendarData, changeAction, JSON.stringify(options), accountKey, callback);
                callback({month: date.month, day: date.day, year: date.year, calendarData: calendarData});
                
            }else{
                
                object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
                var post = {nonce: object._nonce, action: object._action, mode: object._prefix + 'getReservationData', year: date.year, month: date.month, day: 1, accountKey: accountKey};
                new Booking_App_XMLHttp(object._url, post, object._webApp, function(calendarData){
                    
                    object._loadingPanel.setAttribute("class", "hidden_panel");
                    object._console.log(calendarData);
                    object._servicesControl.setNationalHoliday(calendarData.nationalHoliday.calendar);
                    var day = 1;
                    if(mode === 0){day = calendarData.date.lastDay;}
                    object.createToChangePanelForTimeOrCourse(date.month, day, date.year, reservationData, calendarData, changeAction, JSON.stringify(options), accountKey, callback);
                    callback({month: date.month, day: day, year: date.year, calendarData: calendarData});
                    object._loadingPanel.setAttribute("class", "hidden_panel");
                    
                }, function(responseText){
                    
                    object.setResponseText(responseText);
                    
                });
                
            }
            
        }
        
        changePanel.textContent = null;
        changePanel.setAttribute("class", "show_change_panel");
        //var day = reservationData.date.day;
        var dateLabel = document.getElementById("booking_date");
        var courseLabel = document.getElementById("booking_course");
        var selectedService = [];
        var courseTime = null;
        var courseKey = null;
        if(courseLabel != null){
            
            //courseTime = parseInt(courseLabel.getAttribute("data-time"));
            courseKey = parseInt(courseLabel.getAttribute("data-key"));
            
        }
        
        if (options != null) {
            
            if (options.length == 0) {
                
                courseTime = 0;
                
            }
            
            if (object.getServiceOrOption(options) == 'service') {
                
                courseTime = 0;
                //options = object.getVisitorServices();
                
            }
            
            //var options = JSON.parse(options);
            object._console.log(options);
            object._console.log(typeof options);
            if (typeof options == 'string') {
                
                options = JSON.parse(options);
                
            }
            object._console.log("courseTime = " + courseTime);
            for (var key in options) {
                
                var service = options[key];
                object._console.log(service);
                object._console.log("courseTime = " + courseTime);
                if (service.service != null && parseInt(service.service) == 1) {
                    
                    if (parseInt(service.selected) == 1) {
                        
                        selectedService = service;
                        if (courseTime == null) {
                            
                            courseTime = parseInt(service.time);
                            
                        } else {
                            
                            courseTime += parseInt(service.time);
                            
                        }
                        
                        if(typeof service.options == 'string') {
                            
                            service.options = JSON.parse(service.options);
                            
                        }
                        
                        for (var optionKey in service.options) {
                            
                            var option = service.options[optionKey];
                            object._console.log(option);
                            if (parseInt(option.selected) == 1) {
                                
                                if (courseTime == null) {
                                    
                                    courseTime = parseInt(option.time);
                                    
                                } else {
                                    
                                    courseTime += parseInt(option.time);
                                    
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                } else {
                    
                    var option = options[key];
                    if (parseInt(option.selected) == 1) {
                        
                        if (courseTime == null) {
                            
                            courseTime = parseInt(option.time);
                            
                        } else {
                            
                            courseTime += parseInt(option.time);
                            
                        }
                        
                    }
                    
                }
                
            }
            
            
            
        }
        
        object._console.log("courseTime = " + courseTime);
        

        //var extensionsFunction = new ExtensionsFunction();
        //var response = extensionsFunction.preparToUpdateSchedule(reservationData, calendarData, parseInt(courseTime), changeAction);
        var response = object.preparToUpdateSchedule(reservationData, calendarData, parseInt(courseTime), changeAction, preparation);
        var updateSchedule = response.schedule;
        var scheduleAll = response.scheduleAll;
        day = parseInt(day);
        object._console.log(calendarData);
        object._console.log("day = " + parseInt(day));
        object._console.log(updateSchedule);
        object._console.log(updateSchedule[calendarKey]);
        object._console.log(reservationData);
        var timeToProvide = [];
        for(var i = 0; i < object._courseList.length; i++){
            
            if(parseInt(object._courseList[i].key) == courseKey) {
                
                timeToProvide = object._courseList[i].timeToProvide;
                break;
                
            }
            
        }
        object._console.log(timeToProvide);
        
        var dateLabel = document.getElementById("booking_date");
        
        if (changeAction == "date") {
            
            if (options != null) {
                
                updateSchedule[calendarKey] = object._servicesControl.invalidService(updateSchedule[calendarKey], calendarData['bookedServices'], selectedService, courseTime);
                
            }
            
            if (updateSchedule[calendarKey].length == 0) {
                
                console.error("error = schedule zero");
                var errorPanel = document.createElement("div");
                errorPanel.setAttribute("class", "noSchedule");
                errorPanel.textContent = object._i18n.get("No schedules");
                changePanel.appendChild(errorPanel);
                
            }
            
            var calendarKey = object._calendar.getDateKey(month, day, year);
            object._console.log(object._nationalHoliday[calendarKey]);
            var nationalHoliday = false;
            if (object._nationalHoliday[calendarKey] != null && parseInt(object._nationalHoliday[calendarKey].status) == 1) {
                
                nationalHoliday = true;
                
            }
            
            var userScheduleKey = dateLabel.getAttribute("data-key");
            var scheduleListPanel = [];
            for (var i = 0; i < updateSchedule[calendarKey].length; i++) {
                
                var schedule = updateSchedule[calendarKey][i];
                //schedule["select"] = true;
                if (parseInt(schedule["remainder"]) == 0 || schedule["stop"] == 'true') {
                    
                    schedule["select"] = false;
                    
                }
                
                var week = parseInt(schedule.weekKey);
                var minutes = parseInt(schedule.hour) * 60;
                if (nationalHoliday == true) {
                    
                    week = 7;
                    
                }
                
                if (timeToProvide[week] != null && parseInt(timeToProvide[week][minutes]) == 0) {
                    
                    schedule["select"] = false;
                    
                }
                
                object._console.log(schedule);
                
                var schedulePanel = document.createElement("div");
                schedulePanel.textContent = object._calendar.getPrintTime(("0" + schedule["hour"]).slice(-2), ("0" + schedule["min"]).slice(-2)) + schedule['title'];
                //schedulePanel.textContent = ("0" + schedule["hour"]).slice(-2) + ":" + ("0" + schedule["min"]).slice(-2) + " " + schedule['title'];
                schedulePanel.setAttribute("data-key", i);
                scheduleListPanel.push(schedulePanel);
                
                if (schedule["select"] === true) {
                    
                    schedulePanel.setAttribute("data-status", 1);
                    schedulePanel.setAttribute("class", "courseAndScheduleRow");
                    schedulePanel.onclick = function(){
                        
                        this.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                        var key = this.getAttribute("data-key");
                        var schedule = calendarData['schedule'][calendarKey][key];
                        object.unselectPanel(key, scheduleListPanel, "courseAndScheduleRow");
                        object._console.log(schedule);
                        var hour = (0 + schedule["hour"]).slice(-2);
                        var min = (0 + schedule["min"]).slice(-2);
                        var date = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, hour, min, schedule.title, null, 'text');
                        
                        dateLabel.setAttribute("data-key", schedule.key);
                        dateLabel.setAttribute("data-unixTime", schedule.unixTime);
                        dateLabel.textContent = date;
                        
                        document.getElementById("beforChangeButton").classList.add("hidden_panel");
                        document.getElementById("nextChangeButton").classList.add("hidden_panel");
                        document.getElementById("changePanel").setAttribute("class", "return_change_panel");
                        callback({status: "statusButton", value: "1", calendarData: calendarData});
                        
                    }
                    
                    if (userScheduleKey == schedule.key) {
                        
                        object._console.log("onClick");
                        schedulePanel.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                        object.unselectPanel(i, scheduleListPanel, "courseAndScheduleRow");
                        
                    }
                    
                } else {
                    
                    schedulePanel.setAttribute("data-status", 0);
                    schedulePanel.setAttribute("class", "courseAndScheduleRowError");
                    
                }
                
                var table_row = document.createElement("div");
                table_row.appendChild(schedulePanel);
                
                changePanel.appendChild(table_row);
                
            }
            
        } else if (changeAction == 'course') {
            
            var courseLabel = document.getElementById("booking_course");
            var userCourseKey = courseLabel.getAttribute("data-key");
            var userScheduleKey = dateLabel.getAttribute("data-key");
            
            object._console.log(object._courseList);
            var calendarKey = object._calendar.getDateKey(month, day, year);
            var weekKey = parseInt(calendarData.calendar[calendarKey].week);
            object._console.log(object._nationalHoliday[calendarKey]);
            if (object._nationalHoliday[calendarKey] != null && parseInt(object._nationalHoliday[calendarKey].status) == 1) {
                
                weekKey = 7;
                
            }
            
            var minutes = 0;
            for (var i = 0; i < updateSchedule[calendarKey].length; i++) {
                
                var schedule = updateSchedule[calendarKey][i];
                if (parseInt(schedule.key) == parseInt(userScheduleKey)) {
                    
                    object._console.log(schedule);
                    minutes = parseInt(schedule.hour) * 60;
                    break;
                    
                }
                
            }
            
            object._console.log("weekKey = " + weekKey);
            
            for (var i = 0; i < object._courseList.length; i++) {
                
                if (parseInt(object._courseList[i].key) == parseInt(userCourseKey)) {
                    
                    timeToProvide = object._courseList[i].timeToProvide;
                    
                }
                
            }
            object._console.log(timeToProvide);
            
            //var start = parseInt(dateLabel.getAttribute("data-unixTime"));
            var time = parseInt(dateLabel.getAttribute("data-unixTime"));
            for (var i = 0; i < updateSchedule[calendarKey].length; i++) {
                
                var schedule = updateSchedule[calendarKey][i];
                if (time < parseInt(schedule.unixTime) && schedule.remainder <= 0) {
                    
                    object._console.log(schedule);
                    time = (schedule.unixTime - time) / 60;
                    break;
                    
                }
                
            }
            object._console.log("time = " + time);
            
            if (object.getServiceOrOption(options) == "service") {
                
                object.setServices(options);
                
            }
            
            object._console.log(object._courseList);
            object._console.log(object.getVisitorServices());
            var firstService = 0;
            var firstCheckBox = null;
            var checkBoxList = [];
            var courseListPanel = [];
            for (var i = 0; i < object._courseList.length; i++) {
                
                object._courseList[i].service = 1;
                object._courseList[i].selected = 0;
                object._courseList[i].selectedOptionsList = [];
                var courseData = object._courseList[i];
                if (courseData.active != 'true') {
                    
                    continue;
                    
                }
                
                var responseCosts = object._servicesControl.getCostsInService(courseData, guests, isGuests, object._isExtensionsValid);
                object._console.log(responseCosts);
                object._console.log(courseData);
                courseData["select"] = true;
                if (time < courseData.time) {
                    
                    courseData["select"] = false;
                    
                }
                
                timeToProvide = courseData.timeToProvide;
                if (timeToProvide[weekKey] != null && parseInt(timeToProvide[weekKey][minutes]) == 0) {
                    
                    courseData["select"] = false;
                    
                }
                
                object._console.log(courseData);
                object._console.log(object.lookingForVisitorServices(courseData));
                
                var coursePanel = document.createElement("div");
                //coursePanel.textContent = courseData.name;
                coursePanel.setAttribute("data-key", i);
                
                
                var courseNamePanel = document.createElement("span");
                courseNamePanel.textContent = courseData.name;
                //coursePanel.appendChild(courseNamePanel);
                
                var checkBox = document.createElement("input");
                checkBox.setAttribute("data-key", i);
                checkBox.type = "checkbox";
                checkBox.value = "";
                if (firstService == 0) {
                    
                    firstCheckBox = checkBox;
                    //object._courseList[i].selected = 1;
                    //checkBox.checked = true;
                    
                }
                
                if (object.lookingForVisitorServices(courseData) === true) {
                    
                    object._courseList[i].selected = 1;
                    for (var key in options) {
                        
                        if (parseInt(options[key].key) == parseInt(courseData.key)) {
                            
                            //object._courseList[i].selectedOptionsList = options[key].options;
                            break;
                            
                        }
                        
                    }
                    
                    checkBox.checked = true;
                    
                }
                
                
                //checkBox.disabled = true;
                
                checkBox.onclick = function() {
                    
                    if (this.checked == true) {
                        
                        this.checked = false;
                        
                    } else {
                        
                        this.checked = true;
                        
                    }
                    
                };
                
                checkBoxList.push(checkBox);
                
                var label = document.createElement("span");
                label.appendChild(checkBox);
                label.appendChild(courseNamePanel);
                if (parseInt(object._calendarAccount.hasMultipleServices) == 0) {
                    
                    checkBox.classList.add("hidden_panel");
                    
                }
                
                coursePanel.appendChild(label);
                
                if (courseData.cost != null) {
                    
                    var cost = object._format.formatCost(courseData.cost, reservationData.currency);
                    var courseCostPanel = document.createElement("span");
                    courseCostPanel.classList.add("courseCostPanel");
                    courseCostPanel.textContent = cost;
                    coursePanel.appendChild(courseCostPanel);
                    
                }
                
                
                courseListPanel.push(coursePanel);
                
                if (courseData["select"] === true) {
                    
                    coursePanel.setAttribute("data-status", 1);
                    coursePanel.setAttribute("class", "courseAndScheduleRow");
                    coursePanel.onclick = function(){
                        
                        this.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                        var key = this.getAttribute("data-key");
                        var courseData = object._courseList[key];
                        
                        object._console.log("key = " + key);
                        object._console.log(courseData);
                        object._console.log(reservationData);
                        object._console.log(typeof reservationData.options);
                        
                        var options = [];
                        var checkBox = checkBoxList[parseInt(key)];
                        if (checkBox.checked == true) {
                            
                            checkBox.checked = false;
                            this.setAttribute("class", "courseAndScheduleRow");
                            object._courseList[parseInt(key)].selected = 0;
                            
                        } else {
                            
                            checkBox.checked = true;
                            this.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                            object._courseList[parseInt(key)].selected = 1;
                            
                        }
                        
                        if (parseInt(object._calendarAccount.hasMultipleServices) == 0) {
                            
                            var selectedServices = object.getVisitorServices();
                            for (var i in selectedServices) {
                                
                                selectedServices[i].selected = 0;
                                
                            }
                            
                            object._courseList[parseInt(key)].selected = 1;
                            
                        }
                        
                        var service = object._courseList[parseInt(key)];
                        object._console.log(service);
                        var options = service.options;
                        if (typeof service.options == 'string') {
                            
                            options = JSON.parse(service.options);
                            
                        }
                        
                        var valuePanel = document.getElementById("booking_course");
                        valuePanel.textContent = null;
                        
                        var coursePanel = document.createElement("div");
                        coursePanel.classList.add("mainPlan");
                        valuePanel.appendChild(coursePanel);
                        
                        if (options != null && options.length > 0) {
                            
                            if (checkBox.checked == true) {
                                
                                var selectOptionsPanel = document.getElementById("selectOptionsPanel");
                                object.getOptionsPanel(courseData, options, guests, function(response){
                                    
                                    var selectedOptions = response.selectedOptions;
                                    object._courseList[key]["selectedOptionsList"] = selectedOptions;
                                    var selectedServices = object.addVisitorServices(object._courseList[parseInt(key)]);
                                    object._console.log(selectedServices);
                                    object.createServicesPanel(coursePanel, selectedServices, "selectedOptionsList", guests, parseInt(object._calendarAccount.guestsBool), [], reservationData.currency);
                                    if (response.status == "createSchedule") {
                                        
                                        selectOptionsPanel.classList.add("hidden_panel");
                                        //closeCourseWindow(key, courseListPanel, courseData, courseLabel, calendarData, selectedOptions, callback);
                                        
                                    } else if (response.status == "close") {
                                        
                                        selectOptionsPanel.classList.add("hidden_panel");
                                        if (coursePanel != null) {
                                            
                                            coursePanel.setAttribute("class", "courseAndScheduleRow");
                                            
                                        }
                                        
                                    }
                                    
                                });
                                
                            } else {
                                
                                object._console.log(object._courseList[parseInt(key)]);
                                var selectedServices = object.addVisitorServices(object._courseList[parseInt(key)]);
                                object._console.log(selectedServices);
                                object.createServicesPanel(coursePanel, selectedServices, "selectedOptionsList", guests, parseInt(object._calendarAccount.guestsBool), [], reservationData.currency);
                                
                                
                            }
                            
                        } else {
                            
                            object._console.log(service);
                            var selectedServices = object.addVisitorServices(object._courseList[parseInt(key)]);
                            object._console.log(selectedServices);
                            object.createServicesPanel(coursePanel, selectedServices, "selectedOptionsList", guests, parseInt(object._calendarAccount.guestsBool), [], reservationData.currency);
                            
                        }
                        
                        object._console.log(object._courseList);
                        
                        
                    };
                    
                    if (courseData.key == userCourseKey) {
                        
                        object._console.log("onClick");
                        coursePanel.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                        object.unselectPanel(i, courseListPanel, "courseAndScheduleRow");
                        
                    }
                    
                } else {
                    
                    coursePanel.setAttribute("data-status", 0);
                    coursePanel.setAttribute("class", "courseAndScheduleRowError");
                    
                }
                
                
                
                var table_row = document.createElement("div");
                table_row.appendChild(coursePanel);
                
                changePanel.appendChild(table_row);
                firstService++;
                
            }
            
        }
        
        var getSelectedServices = function() {
            
            var selectedServices = [];
            for (var i in object._courseList) {
                
                var service = object._courseList[i];
                if (parseInt(service.selected) == 1) {
                    
                    selectedServices.push(service);
                    
                }
                
            }
            
            return selectedServices;
            
        };
        
        /**
        var closeCourseWindow = function(key, courseListPanel, courseData, courseLabel, calendarData, options, callback){
            
            object.unselectPanel(key, courseListPanel, "courseAndScheduleRow");
            courseLabel.setAttribute("data-key", courseData.key);
            courseLabel.setAttribute("data-time", courseData.time);
            //courseLabel.textContent = courseData.name;
            courseLabel.textContent = null;
            
            var totalCost = 0;
            var coursePanel = document.createElement("div");
            coursePanel.classList.add("mainPlan");
            courseLabel.appendChild(coursePanel);
            
            var courseNamePanel = document.createElement("span");
            courseNamePanel.classList.add("planName");
            courseNamePanel.textContent = courseData.name;
            coursePanel.appendChild(courseNamePanel);
            if (parseInt(courseData.cost) > 0) {
                
                totalCost += parseInt(courseData.cost);
                var courseCostPanel = document.createElement("span");
                courseCostPanel.classList.add("planPrice");
                courseCostPanel.textContent = object._format.formatCost(courseData.cost, reservationData.currency);
                coursePanel.appendChild(courseCostPanel);
                
            }
            
            object._console.log(options);
            if (options != null && options.length > 0) {
                
                var ul = document.createElement("ul");
                courseLabel.appendChild(ul);
                
                for(var i = 0; i < options.length; i++){
                    
                    var option = options[i];
                    object._console.log(option);
                    if (parseInt(option.selected) == 1) {
                        
                        totalCost += parseInt(option.cost);
                        
                        var optionNamePanel = document.createElement("span");
                        optionNamePanel.classList.add("planName");
                        optionNamePanel.textContent = option.name;
                        
                        var optionPricePanel = document.createElement("span");
                        optionPricePanel.classList.add("planPrice");
                        if (parseInt(option.cost) > 0) {
                            
                            optionPricePanel.textContent = object._format.formatCost(option.cost, reservationData.currency);
                            
                        }
                        
                        var li = document.createElement("li");
                        li.appendChild(optionNamePanel);
                        li.appendChild(optionPricePanel);
                        ul.appendChild(li);
                        
                    }
                    
                }
                
            }
            
            if(document.getElementById("booking_cost") != null){
                
                var cost = object._format.formatCost(totalCost, reservationData.currency);
                document.getElementById("booking_cost").textContent = cost;
                
            }
            
            document.getElementById("beforChangeButton").classList.add("hidden_panel");
            document.getElementById("nextChangeButton").classList.add("hidden_panel");
            document.getElementById("changePanel").setAttribute("class", "return_change_panel");
            callback({status: "statusButton", value: "1", calendarData: calendarData, options: JSON.stringify(options)});
            
        }
        **/
        
        beforChangeButton.onclick = function(){
            
            object._console.log("day = " + day);
            changeButtonAction(0, month, day, year, calendarData);
            
        }
        
        nextChangeButton.onclick = function(){
            
            object._console.log("day = " + day);
            changeButtonAction(1, month, day, year, calendarData);
            
        }
        
    }
    
    this.preparToUpdateSchedule = function(reservationData, calendarData, courseTime, changeAction, preparation){
    	
    	var object = this;
    	object._console.log(calendarData);
		object._console.log("changeAction = " + changeAction);
		object._console.log("courseTime = " + courseTime);
		object._console.log(preparation);
		object._console.log(typeof preparation);
		if (preparation == null) {
		    
		    preparation = {position: "before_after", time: 0};
		    object._console.log(preparation);
		    
		}
		var planBool = true;
		var start = parseInt(reservationData.scheduleUnixTime);
		//var end = start + parseInt(reservationData.courseTime) * 60;
		var end = start + parseInt(courseTime) * 60;
		
		if (preparation != null && preparation.time != null && preparation.position != null) {
		    
		    if (preparation.position == 'before_after' || preparation.position == 'before') {
		        
		        start -= preparation.time * 60;
		        
		    }
		    
		    if (preparation.position == 'before_after' || preparation.position == 'after') {
		        
		        end += preparation.time * 60;
		        
		    }
		    
		}
		
		if (start == end) {
        	
        	planBool = false;
			
    	}
		object._console.log("start = " + start + " end = " + end);
		var applicantCount = parseInt(reservationData.applicantCount);
		var schedule = {};
		var scheduleAll = [];
		
		var count = 0;
		for(var key in calendarData.schedule){
        	
        	var daySchedule = [];
			for(var i = 0; i < calendarData.schedule[key].length; i++){
            	
            	var newDate = {};
				Object.assign(newDate , calendarData.schedule[key][i]);
				var unixTime = parseInt(newDate.unixTime);
				if(planBool === true && unixTime >= start && unixTime < end){
                	
                	newDate.remainder = parseInt(newDate.remainder) + applicantCount;
					object._console.log(newDate);
					
            	}else if(planBool === false && unixTime == start){
                	
                	newDate.remainder = parseInt(newDate.remainder) + applicantCount;
					object._console.log(newDate);
					
            	}
				
				if(newDate.stop == "true"){
                	
                	newDate.remainder = 0;
					
            	}
				
				newDate.select = true;
				newDate.count = count;
				scheduleAll.push(newDate);
				daySchedule.push(newDate);
				count++;
				
				if(planBool === true && newDate.remainder <= 0){
                	
                	(function(scheduleAll, unixTime, courseTime, applicantCount, start, end){
                    	
                    	var endTime = parseInt(unixTime) - (parseInt(courseTime) * 60);
						object._console.log("unixTime = " + unixTime + " endTime = " + endTime + " courseTime = " + courseTime + " length = " + scheduleAll.length);
						for(var i = scheduleAll.length; i > 0; i--){
                        	
                        	var schedule = scheduleAll[(i - 1)];
							var time = schedule.year + "/" + schedule.month + "/" + schedule.day + " " + schedule.hour + ":" + schedule.min + " remainder = " + schedule.remainder;
							if(endTime >= schedule.unixTime){
                            	
                            	break;
								
                        	}
							
							if(schedule.remainder > 0 && (unixTime <= start && unixTime > end) && changeAction == 'course'){
                            	
                            	schedule.remainder -= applicantCount;
								
                        	}
							
							if(schedule.remainder > 0 && changeAction == 'date'){
                            	
                            	//schedule.remainder -= applicantCount;
								schedule.remainder = 0;
								
                        	}
							
                    	}
						
                	})(scheduleAll, newDate.unixTime, courseTime, applicantCount, start, end);
					
            	}
				
        	}
			
			schedule[key] = daySchedule;
			
    	}
		
		return {schedule: schedule, scheduleAll: scheduleAll};
		
	}
    
    this.add_reservation = function(add_reservationPanel, month, day, year, calendarData, accountKey, callback){
        
        var object = this;
        object._buttonAction = "add_reservation";
        object._console.log("buttonAction = " + object._buttonAction);
        object._console.log(object._courseList);
        object._console.log(calendarData);
        var calendarKey = object._calendar.getDateKey(month, day, year);
        object._console.log(calendarKey);
        var week = calendarData.calendar[calendarKey].week;
        object._console.log('week = ' + week);
        add_reservationPanel.classList.remove("hidden_panel");
        add_reservationPanel.textContent = null;
        object._rightButtonPanel.textContent = null;
        
        for (var key in object._courseList) {
            
            object._courseList[key].service = 1;
            object._courseList[key].selected = 0;
            object._courseList[key].selectedOptionsList = [];
            
        }
        
        var courseMainPanel = document.createElement("div");
        courseMainPanel.setAttribute("class", "courseListPanel box_shadow");
        
        var scheduleMainPanel = document.createElement("div");
        scheduleMainPanel.setAttribute("class", "scheduleListPanel courseListPanel box_shadow");
        
        var formMainPanel = document.createElement("div");
        formMainPanel.setAttribute("class", "createFormPanel_return");
        
        var mainPanel = document.createElement("div");
        mainPanel.setAttribute("class", "courseAndSchedulePanel");
        mainPanel.appendChild(courseMainPanel);
        mainPanel.appendChild(scheduleMainPanel);
        //mainPanel.appendChild(formMainPanel);
        add_reservationPanel.appendChild(mainPanel);
        add_reservationPanel.appendChild(formMainPanel);
        
        if (calendarData.account.type == 'hotel') {
            
            //hotel.reset();
            object._console.log(calendarData.account);
            object._console.log(calendarData.guestsList);
            mainPanel.removeChild(courseMainPanel);
            
            var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
            var calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
            object._calendar.setClock(object._clock);
            var calendarKey = object._calendar.getDateKey(month, day, year);
            var checkDate = object._hotel.getCheckDate();
            object._console.log(checkDate);
            if(checkDate.checkIn == null && calendarData.schedule[parseInt(calendarKey)] != null && calendarData.schedule[parseInt(calendarKey)][0] != null){
                
                checkDate.checkIn = calendarData.schedule[parseInt(calendarKey)][0];
                object._console.log(object._hotel.getCheckDate());
                
            }
            
            var bookingCalendar = function(calendarData){
                
                var year = parseInt(calendarData.date.year);
                var month = parseInt(calendarData.date.month);
                //hotel.verifySchedule(true);
                
                scheduleMainPanel.textContent = null;
                scheduleMainPanel.setAttribute("style", "animation-name: unset;");
                //scheduleMainPanel.setAttribute("style", "left: 0;");
                scheduleMainPanel.setAttribute("class", "schedulePanel_next");
                
                
                var dayHeight = parseInt(scheduleMainPanel.clientWidth / 7);
    	        object._console.log("dayHeight = " + dayHeight);
                
                var datePanel = document.createElement("div");
                datePanel.setAttribute("class", "calendarData");
                datePanel.textContent = object._calendar.formatBookingDate(month, null, year, null, null, null, null, 'text');
                
                object._console.log(year + "/" + month);
                
                var returnLabel = document.createElement("label");
                returnLabel.setAttribute("class", "arrowLeft");
                if(month == 1){
                    
                    returnLabel.textContent = "＜" + object._calendar.formatBookingDate(12, null, null, null, null, null, null, 'text');
                    
                }else{
                    
                    returnLabel.textContent = "＜" + object._calendar.formatBookingDate((month - 1), null, null, null, null, null, null, 'text');
                
                }
                
                
                var returnPanel = document.createElement("div");
                returnPanel.setAttribute("class", "calendarChangeButton");
                returnPanel.appendChild(returnLabel);
                
                var nextLabel = document.createElement("label");
                nextLabel.setAttribute("class", "arrowRight");
                if(month == 12){
                    
                    nextLabel.textContent = object._calendar.formatBookingDate(1, null, null, null, null, null, null, 'text') + "＞";
                    
                }else{
                    
                    nextLabel.textContent = object._calendar.formatBookingDate((month + 1), null, null, null, null, null, null, 'text') + "＞";
                    
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
                scheduleMainPanel.appendChild(topPanel);
                
                var calendarKey = object._calendar.getDateKey(month, day, year);
                var checkDate = object._hotel.getCheckDate();
                object._console.log(checkDate);
                /**
                if(checkDate.checkIn == null && calendarData.schedule[parseInt(calendarKey)] != null && calendarData.schedule[parseInt(calendarKey)][0] != null){
                    
                    checkDate.checkIn = calendarData.schedule[parseInt(calendarKey)][0];
                    object._console.log(hotel.getCheckDate());
                    
                }
                **/
                
                var scopeOfDay = {start: null, end: null};
                var dayPanelList = {};
                object._calendar.create(scheduleMainPanel, calendarData, month, day, year, '', function(calendarCallback){
                    
                    object._console.log(calendarCallback);
                    var key = parseInt(calendarCallback.key);
                    var dayPanel = calendarCallback['eventPanel'];
                    if(key > 0){
                        
                        dayPanelList[key] = dayPanel;
                        object._hotel.setDayPanelList(dayPanelList);
                        
                    }
                    dayPanel.setAttribute("style", "height: " + (dayHeight) + "px;");
                    dayPanel.setAttribute("data-unixTime", 0);
                    if(calendarData.schedule[key] != null && calendarData.schedule[key][0] != null){
                        
                        dayPanel.setAttribute("data-unixTime", calendarData.schedule[key][0].unixTime);
                        
                        if(calendarData.schedule[key].length != 0){
                            
                            object._hotel.addSchedule(calendarData.schedule[key][0]);
                            
                            if(checkDate.checkIn != null && checkDate.checkIn.unixTime == calendarData.schedule[key][0].unixTime && calendarData.schedule[key][0].remainder > 0){
                                
                                dayPanel.classList.add("selectedDayPanel");
                                
                            }
                            
                            if((checkDate.checkIn != null && checkDate.checkOut != null) && (checkDate.checkIn.unixTime <= calendarData.schedule[key][0].unixTime && checkDate.checkOut.unixTime >= calendarData.schedule[key][0].unixTime)){
                                
                                object._console.log("checkDate.checkIn.unixTime = " + checkDate.checkIn.unixTime);
                                dayPanel.classList.add("selectedDayPanel");
                                
                            }
                            
                            if(parseInt(calendarData.schedule[key][0].remainder) <= 0 || calendarData.schedule[key][0].stop == 'true'){
                                
                                dayPanel.classList.remove("selectedDayPanel");
                                dayPanel.classList.add("closeDay");
                                
                            }
                            
                            dayPanel.onclick = function(){
                                
                                var dateKey = parseInt(this.getAttribute("data-key"));
                                object._console.log("dateKey = " + dateKey);
                                var checkIn = document.getElementById("checkIn").getAttribute("data-check");
                                var checkInUnixTime = parseInt(document.getElementById("checkIn").getAttribute("data-unixTime"));
                                object._console.log("checkIn = " + checkIn + " checkInUnixTime = " + checkInUnixTime);
                                
                                var schedule = calendarData.schedule[dateKey][0];
                                var checkOutUnixTime = parseInt(schedule.unixTime);
                                var checkOutBool = true;
                                if(checkIn == parseInt(schedule.key)){
                                    
                                    //return null;
                                    
                                }
                                
                                var checkDate = object._hotel.getCheckDate();
                                object._console.log(checkDate);
                                
                                if(checkDate.checkIn == null){
                                    
                                    if(schedule.remainder <= 0){
                                        
                                        return null;
                                        
                                    }
                                    
                                    object._hotel.setDayPanelList(dayPanelList);
                                    object._console.log(schedule);
                                    object._console.log(dayPanelList[dateKey]);
                                    dayPanelList[dateKey].classList.add("selectedDayPanel");
                                    object._hotel.setCheckIn(schedule);
                                    object._hotel.setCheckInKey(schedule.key);
                                    
                                    var checkInClearLabel = document.getElementById("checkInClear");
                                    checkInClearLabel.classList.remove("hidden_panel");
                                    
                                    var scheduleList = calendarData.schedule[calendarKey][0];
                                    var date = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, null, null, null, schedule.weekKey, 'text');
                                    //object._console.log("monthKey = " + monthKey + " dayKey = " + dayKey + " yearKey = " + yearKey);
                                    object._console.log(scheduleList);
                                    object._console.log(checkDate);
                                    
                                    var checkInDatePanel = document.getElementById("checkIn");
                                    checkInDatePanel.textContent = date;
                                    
                                }else{
                                    
                                    var checkInUnixTime = parseInt(checkDate.checkIn.unixTime);
                                    var checkInMonth = parseInt(checkDate.checkIn.month);
                                    var chekInDay = parseInt(checkDate.checkIn.day);
                                    var checkInYear = parseInt(checkDate.checkIn.year);
                                    
                                    var verifySchedule = false;
                                    if(checkInUnixTime < checkOutUnixTime){
                                        
                                        object._hotel.setCheckOut(schedule);
                                        object._hotel.setCheckOutKey(schedule.key);
                                        verifySchedule = object._hotel.verifySchedule(true);
                                        object._console.log(verifySchedule);
                                        for(var key in dayPanelList){
                                            
                                            var checkOut = parseInt(dayPanelList[key].getAttribute("data-unixTime"));
                                            if(verifySchedule.status == true && checkInUnixTime <= checkOut && checkOutUnixTime >= checkOut){
                                                
                                                dayPanelList[key].classList.add("selectedDayPanel");
                                                
                                            }else if(checkInUnixTime != checkOut){
                                                
                                                dayPanelList[key].classList.remove("selectedDayPanel");
                                                
                                            }
                                            
                                        }
                                        
                                    }
                                    
                                    var checkOut = document.getElementById("checkOut");
                                    if(verifySchedule.status == true){
                                        
                                        checkOut.setAttribute("data-check", schedule.key);
                                        checkOut.textContent = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, null, null, null, schedule.weekKey, 'text');
                                        object._hotel.setCheckOut(schedule);
                                        object._hotel.setCheckOutKey(schedule.key);
                                        
                                    }else{
                                        
                                        object._hotel.setCheckOut(null);
                                        object._hotel.setCheckOutKey(null);
                                        //checkOut.setAttribute("data-check", null);
                                        //checkOut.textContent = object._i18n.get("Please choose a departure date from the calendar");
                                        
                                    }
                                    
                                    object._hotel.verifySchedule(true);
                                    
                                }
                                
                            }
                            
                        }else{
                            
                            dayPanel.classList.add("closeDay");
                            dayPanel.classList.remove("pointer");
                            
                        }
                        
                    }else{
                        
                        dayPanel.classList.add("closeDay");
                        dayPanel.classList.remove("pointer");
                        
                    }
                    
                });
                
                returnLabel.onclick = function(){
                    
                    if (month == 1) {
                        
                        year--;
                        month = 12;
                        
                    } else {
                        
                        month--;
                        
                    }
                    
                    object.getReservationData(month, 1, year, accountKey, 0, function(calendarData){
                        
                        object._console.log(calendarData);
                        bookingCalendar(calendarData);
                        
                    });
                    
                }
                
                nextLabel.onclick = function(){
                    
                    if (month == 12) {
                        
                        year++;
                        month = 1;
                        
                    } else {
                        
                        month++;
                    
                    }
                    
                    object.getReservationData(month, 1, year, accountKey, 0, function(calendarData){
                        
                        object._console.log(calendarData);
                        bookingCalendar(calendarData);
                        
                    });
                    
                }
                
            }
            
            bookingCalendar(calendarData);
            
            object.createForm(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, course, null, null, accountKey, function(response){
                
                if(response.action == 'refresh'){
                    
                    callback(response);
                    
                }
                
            });
            
            
            
        } else {
            
            if (object._courseBool == true) {
                
                if (object._courseList.length == 0) {
                    
                    var errorMessage = object._i18n.get("Service is not registered. ");
                    errorMessage += object._i18n.get("Please create a service.");
                    var confirm = new Confirm(object._debug);
                    confirm.alertPanelShow(object._i18n.get("Error"), errorMessage, false, function(caalback){
                        
                        
                        
                    });
                    
                    return null;
                    
                }
                var isBooking = object._servicesControl.validateServices(month, day, year, week, true, true);
                object._console.log(isBooking);
                var animationBool = true;
                var checkBoxList = {};
                var coursePanelList = [];
                var courseList = object._courseList;
                var firstCheckBox = null;
                var firstService = 0;
                for (var i = 0; i < object._courseList.length; i++) {
                    
                    var course = object._courseList[i];
                    object._console.log(course);
                    if (course.active != "true" || course.closed == 1) {
                        
                        continue;
                        
                    }
                    
                    if (firstService == 0) {
                        
                        var options = [];
                        if (course.options != null) {
                            
                            options = JSON.parse(course.options);
                            
                        }
                        
                        if (options.length > 0) {
                            
                            object._console.log(options);
                            object.createOptionsPanel(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, coursePanel, month, day, year, calendarData, firstService, course, accountKey, function(response){
                                
                                object._console.log(firstService);
                                object._console.log(course);
                                object._console.log(response);
                                courseList[parseInt(response.key)].selectedOptionsList = response.selectedOptions;
                                object.createSchedule(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, courseList, response.selectedOptions, accountKey, function(response){
                                    
                                    callback(response);
                                    
                                });
                                //callback(response);
                                
                            });
                            
                        }
                        
                    }
                    
                    if (typeof course["name"] == "string") {
                        
                        course["name"] = course["name"].replace(/\\/g, "");
                        
                    }
                    
                    course["status"] = true;
                    
                    var coursePanel = document.createElement("div");
                    coursePanel.setAttribute("data-key", i);
                    coursePanel.setAttribute("data-status", 1);
                    coursePanel.setAttribute("class", "courseAndScheduleRow");
                    
                    
                    var courseNamePanel = document.createElement("span");
                    courseNamePanel.textContent = course["name"];
                    
                    var checkBox = document.createElement("input");
                    checkBox.id = 'service_checkBox_' + i;
                    checkBox.setAttribute("data-key", i);
                    checkBox.type = "checkbox";
                    checkBox.value = "";
                    if (firstService == 0) {
                        
                        firstCheckBox = checkBox;
                        object._courseList[i].selected = 1;
                        checkBox.checked = true;
                        
                    }
                    //checkBox.disabled = true;
                    
                    checkBox.onclick = function() {
                        
                        if (this.checked == true) {
                            
                            this.checked = false;
                            
                        } else {
                            
                            this.checked = true;
                            
                        }
                        
                    };
                    
                    //checkBoxList.push(checkBox);
                    checkBoxList[i] = checkBox;
                    
                    var label = document.createElement("span");
                    label.appendChild(checkBox);
                    label.appendChild(courseNamePanel);
                    if(parseInt(object._calendarAccount.hasMultipleServices) == 0){
                        
                        checkBox.classList.add("hidden_panel");
                        
                    }
                    
                    coursePanel.appendChild(label);
                    /**
                    if(course.cost != null){
                        
                        var cost = object._format.formatCost(course.cost, object._currency);
                        var courseCostPanel = document.createElement("span");
                        courseCostPanel.classList.add("courseCostPanel");
                        courseCostPanel.textContent = cost;
                        coursePanel.appendChild(courseCostPanel);
                        
                    }
                    **/
                    var responseCosts = object._servicesControl.getCostsInService(course, calendarData.guestsList, parseInt(calendarData.account.guestsBool), object._isExtensionsValid);
                    object._console.log(responseCosts);
                    if (responseCosts.max != null && isNaN(parseInt(responseCosts.max)) === false && parseInt(responseCosts.max) != 0) {
                        
                        var cost = object._format.formatCost(responseCosts.max, object._currency);
                        if (responseCosts.hasMultipleCosts === true) {
                            
                            //cost = object._format.formatCost(responseCosts.min, object._currency) + ' ' + object._i18n.get('to') + ' ' + object._format.formatCost(responseCosts.max, object._currency);
                            cost = object._i18n.get('%s to %s', [object._format.formatCost(responseCosts.min, object._currency), object._format.formatCost(responseCosts.max, object._currency)]);

                        }
                        
                        var courseCostPanel = document.createElement("span");
                        courseCostPanel.classList.add("courseCostPanel");
                        courseCostPanel.textContent = cost;
                        coursePanel.appendChild(courseCostPanel);
                        
                    }
                    
                    coursePanelList.push(coursePanel);
                    
                    var table_row = document.createElement("div");
                    table_row.appendChild(coursePanel);
                    
                    courseMainPanel.appendChild(table_row);
                    
                    coursePanel.onclick = function(){
                        
                        var coursePanel = this;
                        coursePanel.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                        var key = coursePanel.getAttribute("data-key");
                        var course = object._courseList[parseInt(key)];
                        object.unselectPanel(key, coursePanelList, "courseAndScheduleRow");
                        object._console.log(course);
                        var options = [];
                        if (course.options != null) {
                            
                            options = JSON.parse(course.options);
                            
                        }
                        object._console.log(options);
                        
                        var checkBox = checkBoxList[parseInt(key)];
                        if(parseInt(object._calendarAccount.hasMultipleServices) == 0){
                            
                            for (var i in courseList) {
                                
                                courseList[i].selected = 0;
                                
                            }
                            
                            courseList[parseInt(key)].selected = 1;
                            checkBox.checked = true;
                            
                        } else {
                            
                            object._console.log(checkBox);
                            if(checkBox.checked == true){
                                
                                checkBox.checked = false;
                                this.setAttribute("class", "courseAndScheduleRow");
                                courseList[parseInt(key)].selected = 0;
                                
                            }else{
                                
                                checkBox.checked = true;
                                this.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                                courseList[parseInt(key)].selected = 1;
                                
                            }
                            
                            var selected = false;
                            for (var i in courseList) {
                                
                                if (courseList[i].selected == 1) {
                                    
                                    selected = true;
                                    break;
                                    
                                }
                                
                            }
                            
                            if (selected === false) {
                                
                                var key = parseInt(firstCheckBox.getAttribute("data-key"));
                                courseList[key].selected = 1;
                                firstCheckBox.checked = true;
                                
                            }
                            
                        }
                        
                        if (options.length <= 0) {
                            
                            object.createSchedule(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, courseList, null, accountKey, function(response){
                                
                                callback(response);
                                
                            });
                            
                        } else {
                            
                            var checkBox = checkBoxList[parseInt(key)];
                            object._console.log(checkBox);
                            if (checkBox.checked == true) {
                                
                                object.createOptionsPanel(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, coursePanel, month, day, year, calendarData, key, course, accountKey, function(response){
                                    
                                    courseList[parseInt(key)].selectedOptionsList = response.selectedOptions;
                                    object.createSchedule(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, courseList, response.selectedOptions, accountKey, function(response){
                                        
                                        callback(response);
                                        
                                    });
                                    
                                });
                                
                            }
                            
                        }
                        
                    }
                    
                    firstService++;
                    
                }
                object._console.log(coursePanelList);
                //coursePanelList[0].setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                if(coursePanelList[0] != null){
                    
                    coursePanelList[0].setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                    
                }
                
                object.createSchedule(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, object._courseList , null, accountKey, function(response){
                    
                    callback(response);
                    
                });
                
            } else {
                
                mainPanel.removeChild(courseMainPanel);
                scheduleMainPanel.setAttribute("style", "left: 0;");
                scheduleMainPanel.setAttribute("class", "schedulePanel");
                
                object.createSchedule(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, null, null, accountKey, function(response){
                    
                    callback(response);
                    
                });
                
            }
            
        }
        
        
        
        
        
    }
    
    this.getOptionsPanel = function(course, options, guestsList, callback){
        
        var object = this;
        var selectedOptions = [];
        var checkBoxList = [];
        var disabledButton = true;
        //var options = JSON.parse(course.options);
        object._console.log(course);
        if (typeof options == "string") {
            
            options = JSON.parse(course.options);
            
        }
        
        var isGuests = 0;
        if (guestsList != null && guestsList.length > 0) {
            
            isGuests = 1;
            
        }
        
        var selectOptionsPanel = document.getElementById("selectOptionsPanel");
        var nextButton = selectOptionsPanel.getElementsByClassName("decisionButton")[0];
        var title = selectOptionsPanel.getElementsByClassName("subject")[0];
        var bodyPanel = selectOptionsPanel.getElementsByClassName("body")[0];
        selectOptionsPanel.classList.remove("hidden_panel");
        title.textContent = course.name;
        bodyPanel.textContent = null;
        bodyPanel.setAttribute("style", "bottom: 56px;");
        nextButton.classList.remove("hidden_panel");
        nextButton.disabled = true;
        if (parseInt(course.selectOptions) == 0) {
            
            bodyPanel.setAttribute("style", "bottom: 0;");
            nextButton.classList.add("hidden_panel");
            
        }
        
        for(var i = 0; i < options.length; i++){
            
            var option = options[i];
            var responseCosts = object._servicesControl.getCostsInService(option, guestsList, isGuests, object._isExtensionsValid);
            object._console.log(responseCosts);
            object._console.log(typeof option.selected);
            if (option.selected == null) {
                
                option.selected = 0;
                
            }
            
            object._console.log(option);
            selectedOptions.push(option);
            var optionPanel = document.createElement("div");
            optionPanel.setAttribute("data-key", i);
            optionPanel.setAttribute("data-status", 1);
            optionPanel.setAttribute("class", "courseAndScheduleRow");
            
            var titleLabel = document.createElement("span");
            titleLabel.textContent = option.name;
            
            var checkBox = document.createElement("input");
            checkBox.setAttribute("data-key", i);
            checkBox.type = "checkbox";
            checkBox.value = 1;
            if(parseInt(option.selected) == 1){
                
                checkBox.checked = true;
                optionPanel.classList.add("courseAndScheduleRowActive");
                disabledButton = false;
                
            }
            checkBoxList.push(checkBox);
            
            var label = document.createElement("label");
            label.appendChild(checkBox);
            label.appendChild(titleLabel);
            if(parseInt(course.selectOptions) == 0){
                
                checkBox.classList.add("hidden_panel");
                
            }
            
            optionPanel.appendChild(label);
            
            if (responseCosts.max != null && isNaN(parseInt(responseCosts.max)) === false && parseInt(responseCosts.max) != 0) {
                
                var cost = object._format.formatCost(responseCosts.max, object._currency);
                if (responseCosts.hasMultipleCosts === true) {
                    
                    //cost = object._format.formatCost(responseCosts.min, object._currency) + ' ' + object._i18n.get(' to ') + ' ' + object._format.formatCost(responseCosts.max, object._currency);
                    cost = object._i18n.get('%s to %s', [object._format.formatCost(responseCosts.min, object._currency), object._format.formatCost(responseCosts.max, object._currency)]);
                    
                }
                var optionCostPanel = document.createElement("span");
                optionCostPanel.classList.add("courseCostPanel");
                optionCostPanel.textContent = cost;
                optionPanel.appendChild(optionCostPanel);
                
            }
            
            bodyPanel.appendChild(optionPanel);
            optionPanel.onclick = function(){
                
                object._console.log(course);
                var key = parseInt(this.getAttribute("data-key"));
                var option = options[key];
                object._console.log(option);
                var checkBox = checkBoxList[key];
                if(checkBox.checked == true){
                    
                    checkBox.checked = false;
                    this.setAttribute("class", "courseAndScheduleRow");
                    selectedOptions[key].selected = 0;
                    
                }else{
                    
                    checkBox.checked = true;
                    this.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                    selectedOptions[key].selected = 1;
                    
                }
                
                object._console.log(selectedOptions);
                nextButton.disabled = true;
                for(var i = 0; i < selectedOptions.length; i++){
                    
                    if(selectedOptions[i].selected == 1){
                        
                        if(parseInt(course.selectOptions) == 0){
                            
                            object._console.log(course);
                            var response = {status: "createSchedule", selectedOptions: selectedOptions};
                            callback(response);
                            /**
                            selectOptionsPanel.classList.add("hidden_panel");
                            object.createSchedule(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, course, selectedOptions, accountKey, function(response){
                                
                                callback(response);
                                
                            });
                            **/
                            
                        }else{
                            
                            nextButton.disabled = false;
                            
                        }
                        
                        break;
                        
                    }
                    
                }
                
            }
            
        }
        
        if (disabledButton == false) {
            
            nextButton.disabled = false;
            
        }
        nextButton.removeEventListener("check", null);
        nextButton.onclick = function(){
            
            var response = {status: "createSchedule", selectedOptions: selectedOptions};
            callback(response);
            /**
            selectOptionsPanel.classList.add("hidden_panel");
            object.createSchedule(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, course, selectedOptions, accountKey, function(response){
                
                callback(response);
                
            });
            **/
            
        }
        
        selectOptionsPanel.getElementsByClassName("blockPanel")[0].onclick = function(){
            
            var response = {status: "close", selectedOptions: selectedOptions};
            callback(response);
            /**
            selectOptionsPanel.classList.add("hidden_panel");
            if (coursePanel != null) {
                
                coursePanel.setAttribute("class", "courseAndScheduleRow");
                
            }
            **/
            
        }
        
        object._console.log(course);
        
    }
    
    this.createOptionsPanel = function(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, coursePanel, month, day, year, calendarData, courseKey, course, accountKey, callback){
        
        var object = this;
        var selectOptionsPanel = document.getElementById("selectOptionsPanel");
        object.getOptionsPanel(course, course.options, calendarData.guestsList, function(response){
            
            if (response.status == "createSchedule") {
                
                var selectedOptions = response.selectedOptions;
                selectOptionsPanel.classList.add("hidden_panel");
                callback({selectedOptions: selectedOptions, key: courseKey});
                /**
                object.createSchedule(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, course, selectedOptions, accountKey, function(response){
                    
                    callback(response);
                    
                });
                **/
                
            } else if (response.status == "close") {
                
                selectOptionsPanel.classList.add("hidden_panel");
                if (coursePanel != null) {
                    
                    coursePanel.setAttribute("class", "courseAndScheduleRow");
                    
                }
                
            }
            
        });
        
    }
    
    this.createBookingCalendar = function(add_reservationPanel, day, calendarData, accountKey, scheduleMainPanel, callback){
        
        var object = this;
        var year = parseInt(calendarData.date.year);
        var month = parseInt(calendarData.date.month);
        
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
        object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
        object._calendar.setClock(object._clock);
        var dayHeight = parseInt(scheduleMainPanel.clientWidth / 7);
    	object._console.log("dayHeight = " + dayHeight);
        
        var datePanel = document.createElement("div");
        datePanel.setAttribute("class", "calendarData");
        datePanel.textContent = object._calendar.formatBookingDate(month, null, year, null, null, null, null, 'text');
        
        object._console.log(year + "/" + month);
        
        var returnLabel = document.createElement("label");
        returnLabel.setAttribute("class", "arrowLeft");
        if(month == 1){
            
            returnLabel.textContent = "＜" + object._calendar.formatBookingDate(12, null, null, null, null, null, null, 'text');
            
        }else{
            
            returnLabel.textContent = "＜" + object._calendar.formatBookingDate((month - 1), null, null, null, null, null, null, 'text');
        
        }
        
        
        var returnPanel = document.createElement("div");
        returnPanel.setAttribute("class", "calendarChangeButton");
        returnPanel.appendChild(returnLabel);
        
        var nextLabel = document.createElement("label");
        nextLabel.setAttribute("class", "arrowRight");
        if(month == 12){
            
            nextLabel.textContent = object._calendar.formatBookingDate(1, null, null, null, null, null, null, 'text') + "＞";
            
        }else{
            
            nextLabel.textContent = object._calendar.formatBookingDate((month + 1), null, null, null, null, null, null, 'text') + "＞";
            
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
        scheduleMainPanel.appendChild(topPanel);
        
        var clickPoint = {start: null, end: null};
        var scopeOfDay = {start: null, end: null};
        var dayPanelList = {};
        object._calendar.create(scheduleMainPanel, calendarData, month, day, year, '', function(callback){
            
            object._console.log(callback);
            var key = parseInt(callback.day);
            var dayPanel = callback['eventPanel'];
            if(key > 0){
                
                dayPanelList[key] = dayPanel;
                
            }
            dayPanel.setAttribute("style", "height: " + (dayHeight / 2) + "px;");
            if(calendarData.schedule[key] != null && calendarData.schedule[key][0] != null){
                
                object._console.log(calendarData.schedule[key]);
                if(calendarData.schedule[key].length != 0){
                    
                    if(key == parseInt(day)){
                        
                        dayPanel.classList.add("selectedDayPanel");
                        
                    }
                    
                    if(parseInt(calendarData.schedule[key][0].remainder) <= 0){
                        
                        dayPanel.classList.add("closeDay");
                        
                    }
                    
                    dayPanel.onclick = function(){
                        
                        var dateKey = parseInt(this.getAttribute("data-key"));
                        object._console.log("dateKey = " + dateKey);
                        var checkIn = document.getElementById("checkIn").getAttribute("data-check");
                        var checkInUnixTime = parseInt(document.getElementById("checkIn").getAttribute("data-unixTime"));
                        object._console.log("checkIn = " + checkIn + " checkInUnixTime = " + checkInUnixTime);
                        
                        var schedule = calendarData.schedule[dateKey][0];
                        var checkOutUnixTime = parseInt(schedule.unixTime);
                        var checkOutBool = true;
                        if(checkInUnixTime < checkOutUnixTime){
                            
                            for(var key in dayPanelList){
                                
                                if(day <= parseInt(key) && dateKey >= parseInt(key)){
                                    
                                    var remainder = parseInt(calendarData.schedule[key][0].remainder);
                                    if(remainder == 0 && parseInt(key) != dateKey){
                                        
                                        (function(){
                                            
                                            object._console.log("remainder = " + remainder);
                                            for(var key in dayPanelList){
                                                
                                                if(day != parseInt(key)){
                                                    
                                                    dayPanelList[key].classList.remove("selectedDayPanel");
                                                    
                                                }
                                                
                                            }
                                            
                                        })();
                                        checkOutBool = false;
                                        break;
                                    }
                                    dayPanelList[key].classList.add("selectedDayPanel");
                                    
                                }else{
                                    
                                    dayPanelList[key].classList.remove("selectedDayPanel");
                                    
                                }
                                
                            }
                            
                        }
                        
                        var checkOut = document.getElementById("checkOut");
                        if(checkOutBool == true){
                            
                            checkOut.setAttribute("data-check", schedule.key);
                            checkOut.textContent = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, null, null, null, schedule.weekKey, 'text');
                            
                        }else{
                            
                            checkOut.setAttribute("data-check", null);
                            checkOut.textContent = object._i18n.get("Please choose a departure date from the calendar");
                            
                        }
                        
                    }
                    
                }else{
                    
                    dayPanel.classList.add("closeDay");
                    dayPanel.classList.remove("pointer");
                    
                }
                
            }else{
                
                dayPanel.classList.add("closeDay");
                dayPanel.classList.remove("pointer");
                
            }
            
        });
        
    }
    
    this.getTotalTimeInOptions = function(options){
        
        var totalTimeInOptions = 0;
        if (options != null) {
            
            for(var i = 0; i < options.length; i++) {
                
                var option = options[i];
                if (parseInt(option.selected) == 1) {
                    
                    totalTimeInOptions += parseInt(option.time);
                    
                }
                
            }
            
        }
        
        object._console.log("totalTimeInOptions = " + totalTimeInOptions);
        return totalTimeInOptions;
        
    }
    
    this.createSchedule = function(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, courseList, selectedOptions, accountKey, callback){
        
        var object = this;
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
        object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
        object._calendar.setClock(object._clock);
        var calendarKey = object._calendar.getDateKey(month, day, year);
        day = parseInt(day);
        object._console.log("day = " + day);
        object._console.log(calendarData);
        object._console.log(courseList);
        object._console.log(selectedOptions);
        var totalTimeInOptions = object.getTotalTimeInOptions(selectedOptions);
        object._console.log(calendarData['schedule'][calendarKey]);
        var timeToProvide = [];
        var course = null;
        var totalTimeInOptions = 0;
        if (object._courseBool == true) {
            
            course = false;
            
        }
        for (var key in courseList) {
            
            if (courseList[key].selected == 1 && courseList[key].timeToProvide != null) {
                
                course = true;
                timeToProvide.push(courseList[key].timeToProvide);
                
            }
            
            if (courseList[key].selected == 1 && courseList[key].selectedOptionsList.length > 0) {
                
                totalTimeInOptions += object.getTotalTimeInOptions(courseList[key].selectedOptionsList);
                
            }
            
        }
        object._console.log(timeToProvide);
        
        scheduleMainPanel.textContent = null;
        
        var closeButton = document.createElement("button");
        closeButton.id = "closeButton";
        closeButton.textContent = object._i18n.get('Close');
        closeButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
        closeButton.setAttribute("style", "margin-left: 10px;");
        object._rightButtonPanel.textContent = null;
        object._rightButtonPanel.appendChild(closeButton);
        closeButton.onclick = function() {
            
            object._console.log("closeButton");
            object._rightButtonPanel.textContent = null;
            object.editPanelShow(false);
            
        };
        
        if (calendarData['schedule'][calendarKey].length == 0) {
            
            console.error("error = schedule zero");
            var errorPanel = document.createElement("div");
            errorPanel.setAttribute("class", "noSchedule");
            errorPanel.textContent = object._i18n.get("No schedules");
            scheduleMainPanel.appendChild(errorPanel);
            return null;
            
        }
        
        var calendarKey = object._calendar.getDateKey(month, day, year);
        object._console.log(object._nationalHoliday[calendarKey]);
        var nationalHoliday = false;
        if (object._nationalHoliday[calendarKey] != null && parseInt(object._nationalHoliday[calendarKey].status) == 1) {
            
            nationalHoliday = true;
            
        }
        
        for (var i = 0; i < calendarData['schedule'][calendarKey].length; i++) {
            
            var schedule = calendarData['schedule'][calendarKey][i];
            schedule["select"] = true;
            if (parseInt(schedule["remainder"]) == 0 || schedule["stop"] == 'true') {
                
                schedule["select"] = false;
                
            }
            
            var week = parseInt(schedule.weekKey);
            var minutes = parseInt(schedule.hour) * 60;
            if (nationalHoliday == true) {
                
                week = 7;
                
            }
            
            for (var key in timeToProvide) {
                
                if (timeToProvide[key][week] != null && parseInt(timeToProvide[key][week][minutes]) == 0) {
                    
                    schedule["select"] = false;
                    
                }
                
            }
            
        }
        
        if (course != null || object._preparationTime > 0) {
            
            var courseTime = 0;
            if (object._positionPreparationTime == 'before_after' || object._positionPreparationTime == 'after') {
                    
                    courseTime = object._preparationTime;
                    
            }
            
            if (course != null) {
                
                //courseTime += parseInt(course["time"]) + totalTimeInOptions;
                var selectedService = [];
                for (var key in courseList) {
                    
                    if (courseList[key].selected == 1) {
                        
                        courseTime += parseInt(courseList[key].time);
                        selectedService = courseList[key];
                        
                    }
                    
                }
                
                courseTime += totalTimeInOptions;
                object._servicesControl.invalidService(calendarData['schedule'][calendarKey], calendarData['bookedServices'], selectedService, courseTime);
                
            }
            
            var afterPreparationTime = 0;
            if (object._positionPreparationTime == 'before_after' || object._positionPreparationTime == 'before') {
                    
                    afterPreparationTime = object._preparationTime;
                    
            }
            //var courseTime = parseInt(course["time"]) + totalTimeInOptions;
            object._console.log("courseTime = " + courseTime);
            for (var i = 0; i < calendarData['schedule'][calendarKey].length; i++) {
                
                var schedule = calendarData['schedule'][calendarKey][i];
                if (parseInt(schedule["remainder"]) == 0 || schedule["stop"] == 'true') {
                    
                    schedule["select"] = false;
                    var rejectionTime = (parseInt(schedule["hour"]) * 60 + parseInt(schedule["min"])) - courseTime;
                    object._console.log("rejectionTime = " + rejectionTime);
                    
                    (function(schedule, key, courseTime, rejectionTime, afterPreparationTime, callback){
                        
                        object._console.log(key);
                        var stopUnixTime = parseInt(schedule[key].unixTime);
                        stopUnixTime += afterPreparationTime * 60;
                        object._console.log("stopUnixTime = " + stopUnixTime);
                        
                        for (var i = 0; i < schedule.length; i++) {
                            
                            var time = parseInt(schedule[i]["hour"]) * 60 + parseInt(schedule[i]["min"]);
                            if (time > rejectionTime && i < key) {
                                
                                object._console.log("i = " + i + " hour = " + schedule[i]["hour"] + " min = " + schedule[i]["min"]);
                                callback(i);
                                
                            } else if (parseInt(schedule[i].unixTime) <= stopUnixTime && i > key) {
                                
                                object._console.log("i = " + i + " hour = " + schedule[i]["hour"] + " min = " + schedule[i]["min"]);
                                callback(i);
                                
                            } else if (parseInt(schedule[i].unixTime) >= stopUnixTime) {
                                
                                break;
                                
                            }
                            
                        }
                        
                    })(calendarData['schedule'][calendarKey], i, courseTime, rejectionTime, afterPreparationTime, function(key){
                        
                        object._console.log("callback key = " + key);
                        calendarData['schedule'][calendarKey][key]["select"] = false;
                        
                    });
                    
                }
                
            }
            
        }
        
        object._console.log("accountKey = " + accountKey);
        object._console.log(object._schedule_data.calendarAccountList);
        var displayRemainingCapacity = 0;
        var calendarAccountList = object._schedule_data.calendarAccountList;
        for (var i = 0; i < calendarAccountList.length; i++) {
            
            if (parseInt(calendarAccountList[i].key) == parseInt(accountKey) && parseInt(calendarAccountList[i].displayRemainingCapacity) == 1) {
                
                displayRemainingCapacity = 1;
                break;
                
            }
            
        }
        object._console.log("displayRemainingCapacity = " + displayRemainingCapacity);
        
        var scheduleListPanel = [];
        for (var i = 0; i < calendarData['schedule'][calendarKey].length; i++) {
            
            var schedule = calendarData['schedule'][calendarKey][i];
            if (typeof schedule['title'] == "string") {
                
                schedule['title'] = schedule['title'].replace(/\\/g, "");
                
            }
            object._console.log(schedule);
            
            var schedulePanel = document.createElement("div");
            schedulePanel.textContent = object._calendar.getPrintTime(("0" + schedule["hour"]).slice(-2), ("0" + schedule["min"]).slice(-2)) + " " + schedule['title'];
            //schedulePanel.textContent = ("0" + schedule["hour"]).slice(-2) + ":" + ("0" + schedule["min"]).slice(-2) + " " + schedule['title'];
            schedulePanel.setAttribute("data-key", i);
            
            
            if (displayRemainingCapacity == 1) {
                
                var displayRemainingCapacityLabel = document.createElement("span");
                displayRemainingCapacityLabel.classList.add("displayRemainingCapacityLabel");
                displayRemainingCapacityLabel.textContent = object._i18n.get("%s remaining", [schedule.remainder]);
                schedulePanel.appendChild(displayRemainingCapacityLabel);
                
            }
            
            scheduleListPanel.push(schedulePanel);
            
            if (schedule["select"] === true) {
                
                schedulePanel.setAttribute("data-status", 1);
                schedulePanel.setAttribute("class", "courseAndScheduleRow");
                schedulePanel.onclick = function(){
                    
                    closeButton.setAttribute("class", "hidden_panel");
                    this.setAttribute("class", "courseAndScheduleRow courseAndScheduleRowActive");
                    var key = this.getAttribute("data-key");
                    var schedule = calendarData['schedule'][calendarKey][key];
                    
                    var startUnixTime = parseInt(schedule.unixTime);
                    var endUnixTime = startUnixTime + (parseInt(courseTime) * 60);
                    object.unselectPanel(key, scheduleListPanel, "selectPanel");
                    object._console.log('courseTime = ' + courseTime);
                    object._console.log('startUnixTime = ' + startUnixTime);
                    object._console.log('endUnixTime = ' + endUnixTime);
                    object._console.log(courseList);
                    if (object.getGuestsList().length > 0) {
                        
                        var remainders = [];
                        for (var scheduleKey in calendarData['schedule'][calendarKey]) {
                            
                            var unixTime = parseInt(calendarData['schedule'][calendarKey][scheduleKey].unixTime);
                            if (startUnixTime <= unixTime && endUnixTime > unixTime) {
                                
                                remainders.push(parseInt(calendarData['schedule'][calendarKey][scheduleKey].remainder));
                                object._console.log(calendarData['schedule'][calendarKey][scheduleKey]);
                                
                            }
                            
                            
                        }
                        object._console.log(remainders);
                        var remainder = parseInt(schedule.remainder);
                        if (remainders.length > 0) {
                            
                            remainder = remainders.reduce(function(a, b) {
                                
                                return Math.min(a, b);
                                
                            });
                            
                        }
                        
                        object._console.log('remainder = ' + remainder);
                        object.setMaxApplicantCount(remainder);
                        
                    }
                    
                    
                    object.unselectPanel(key, scheduleListPanel, "courseAndScheduleRow");
                    object.createForm(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, courseList, schedule, selectedOptions, accountKey, function(response){
                        
                        if (response.action == 'return') {
                            
                            closeButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
                            object._console.log(response.action);
                            
                        } else if (response.action == 'refresh') {
                            
                            callback(response)
                            
                        }
                        
                    });
                    
                }
                
            } else {
                
                schedulePanel.setAttribute("data-status", 0);
                schedulePanel.setAttribute("class", "courseAndScheduleRowError");
                
            }
            
            var table_row = document.createElement("div");
            table_row.appendChild(schedulePanel);
            
            scheduleMainPanel.appendChild(table_row);
            
        }
        
        return scheduleMainPanel;
        
    }
    
    
    this.createForm = function(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, courseList, schedule, selectedOptions, accountKey, callback){
        
        var object = this;
        object._console.log("accountKey = " + accountKey);
        object._console.log(object._formData);
        object._console.log(day);
        object._console.log(calendarData);
        object._console.log(courseList);
        object._console.log(schedule);
        object._console.log(selectedOptions);
        
        var targetCustomers = 'visitors';
        var user = object.getUserInformation();
        object._console.log(user);
        var totalTimeInOptions = object.getTotalTimeInOptions(selectedOptions);
        var input = new Booking_Package_Input(object._debug);
        formMainPanel.textContent = null;
        //buttonPanel.textContent = null;
        var children = object._rightButtonPanel.children;
        for (var i = children.length; i > 0; i--) {
            
            if (children[i - 1].id != 'closeButton') {
                object._rightButtonPanel.removeChild(children[i - 1]);
            }
            
        }
        
        var returnButton = null;
        if (object._courseBool == true) {
            
            mainPanel.setAttribute("class", "courseAndSchedulePanel_next");
            
            returnButton = document.createElement("button");
            returnButton.id = "returnButton";
            returnButton.textContent = object._i18n.get('Return');
            returnButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
            returnButton.setAttribute("style", "margin-left: 10px;");
            object._rightButtonPanel.appendChild(returnButton);
            
            
        } else {
            
            if (calendarData.account.type == "hotel") {
                
                mainPanel.setAttribute("class", "courseAndSchedulePanel_next");
                scheduleMainPanel.setAttribute("class", "schedulePanel_next");
                
            } else {
                
                mainPanel.setAttribute("class", "courseAndSchedulePanel_next_no_course");
                //scheduleMainPanel.setAttribute("class", "schedulePanel_next");
                
            }
            
        }
        
        //formMainPanel.setAttribute("class", "courseListPanel box_shadow show_panel");
        formMainPanel.setAttribute("class", "createFormPanel_show box_shadow show_panel_for_new_booking test");
        /**
        if(calendarData.account.type == "day"){
            
            formMainPanel.setAttribute("class", "createFormPanel_show box_shadow show_panel");
            
        }else{
            
            formMainPanel.setAttribute("class", "createFormPanel_show box_shadow");
            
        }
        **/
        
        var bookingButton = document.createElement("button");
        bookingButton.textContent = object._i18n.get('Booking');
        bookingButton.setAttribute("class", "button media-button button-primary button-large media-button-insert");
        bookingButton.setAttribute("style", "margin-left: 10px;");
        object._rightButtonPanel.appendChild(bookingButton);
        
        var formPanel = document.createElement("div");
        formPanel.id = "inputFormPanel";
        formMainPanel.appendChild(formPanel);
        
        var monthFull = object._monthFullName[parseInt(calendarData.date.month)];
        //var date = monthFull + " " + ("0" + day).slice(-2) + ", " + calendarData.date.year + " " + ("0" + schedule.hour).slice(-2) + ":" + ("0" + schedule.min).slice(-2) + " " + schedule.title;
        
        var weekName = [object._i18n.get('Sun'), object._i18n.get('Mon'), object._i18n.get('Tue'), object._i18n.get('Wed'), object._i18n.get('Thu'), object._i18n.get('Fri'), object._i18n.get('Sat')];
        object._calendar = new Booking_App_Calendar(weekName, object._dateFormat, object._positionOfWeek, object._positionTimeDate, object._startOfWeek, object._i18n, object._debug);
        object._calendar.setClock(object._clock);
        var calendarKey = object._calendar.getDateKey(month, day, year);
        
        if (parseInt(object._isExtensionsValid) == 1) {
            
            var lookForUserIcon = document.createElement('div');
            lookForUserIcon.textContent = 'search';
            
            var lookForUserButton = document.createElement('div');
            lookForUserButton.setAttribute('class', 'material-icons lookForUserButton');
            //lookForUserButton.textContent = 'search supervisor_account';
            lookForUserButton.appendChild(lookForUserIcon);
            formPanel.appendChild(lookForUserButton);
            lookForUserButton.onclick = function() {
                
                object._console.log('onclick');
                object.lookForUser(function(user) {
                    
                    object.setUserInformation(user);
                    object.createForm(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, courseList, schedule, selectedOptions, accountKey, callback);
                    
                });
                
            };
            
        }
        
        var totalCost = 0;
        if(schedule != null){
            
            var date = object._calendar.formatBookingDate(calendarData.date.month, day, calendarData.date.year, schedule.hour, schedule.min, schedule.title, schedule.weekKey, 'text');
            var rowPanel = object.createRowPanel(object._i18n.get("Booking Date"), date, null, null, null);
            formPanel.appendChild(rowPanel);
            totalCost = parseInt(schedule.cost);
            
        }
        
        if (user.meta != null) {
            
            object._console.log(user);
            object._console.log(user.meta);
            targetCustomers = 'users';
            input.setUserEmail(user.user_email);
            input.setUserInformation(user.meta);
            var usernamePanel = object.createRowPanel(object._i18n.get("Username"), user.user_login, null, null, null);
            var deleteUserButton = document.createElement('div');
            deleteUserButton.textContent = 'close';
            deleteUserButton.classList.add('material-icons');
            deleteUserButton.classList.add('deleteUserButton');
            deleteUserButton.onclick = function() {
                
                object.setUserInformation(null);
                object.createForm(mainPanel, courseMainPanel, scheduleMainPanel, formMainPanel, month, day, year, calendarData, courseList, schedule, selectedOptions, accountKey, callback);
                
            };
            usernamePanel.insertAdjacentElement('afterbegin', deleteUserButton);
            formPanel.appendChild(usernamePanel);
            
        }
        object._console.log('targetCustomers = ' + targetCustomers);
        
        if (calendarData.account.type == "hotel") {
            
            formMainPanel.classList.remove("show_panel");
            //scheduleMainPanel.classList.remove("schedulePanel_next");
            scheduleMainPanel.setAttribute("style", "animation-name: unset;");
            mainPanel.setAttribute("style", "animation-name: unset;");
            var schedule = calendarData.schedule[parseInt(calendarKey)][0];
            if (object._hotel.getCheckDate().checkIn != null) {
                
                schedule = object._hotel.getCheckDate().checkIn;
                
            }
            object._console.log(schedule);
            if (schedule == null) {
                
                return null;
                
            }
            bookingButton.disabled = true;
            var style = null;
            var date = object._calendar.formatBookingDate(schedule.month, schedule.day, schedule.year, null, null, null, schedule.weekKey, 'text');
            if (schedule.remainder <= 0) {
                
                style = "color: red;";
                date = object._i18n.get("There is no rooms to booking");
                object._hotel.resetCheckDate();
                
            } else if (schedule.stop == 'true') {
                
                style = "color: red;";
                date = object._i18n.get("The booking reception is suspended");
                object._hotel.resetCheckDate();
                
            } else {
                
                object._hotel.setCheckIn(schedule);
                object._hotel.setCheckInKey(schedule.key);
                
            }
            
            var checkInClear = document.createElement("label");
            checkInClear.textContent = object._i18n.get("Clear");
            checkInClear.classList.add("change");
            checkInClear.id = "checkInClear";
            
            var expressionsCheck = object._calendar.getExpressionsCheck(calendarData.account.expressionsCheck);
            
            var checkIn = object.createRowPanel(expressionsCheck.arrival, date, "checkIn", "true", checkInClear);
            formPanel.appendChild(checkIn);
            document.getElementById("checkIn").setAttribute("data-check", schedule.key);
            document.getElementById("checkIn").setAttribute("data-unixTime", schedule.unixTime);
            document.getElementById("checkIn").setAttribute("style", style);
            
            var checkOutClear = document.createElement("label");
            checkOutClear.textContent = object._i18n.get("Clear");
            checkOutClear.classList.add("change");
            checkOutClear.classList.add("hidden_panel");
            var checkOut = object.createRowPanel(expressionsCheck.departure, expressionsCheck.chooseDeparture, "checkOut", "true", checkOutClear);
            //document.getElementById("checkOut").setAttribute("data-check", "");
            formPanel.appendChild(checkOut);
            
            var totalLengthOfStayValue = document.createElement("div");
            totalLengthOfStayValue.id = "totalLengthOfStayValue";
            totalLengthOfStayValue.textContent = 0;
            
            var totalLengthOfStay = object.createRowPanel(object._i18n.get("Total length of stay"), totalLengthOfStayValue, null, null, null);
            formPanel.appendChild(totalLengthOfStay);
            
            var roomListPanel = document.createElement('div');
            roomListPanel.id = 'roomListPanel';
            roomListPanel.classList.add('roomListPanel');
            formPanel.appendChild(roomListPanel);
            var totalNumberOfGuests = object.createRowPanel(object._i18n.get("Total number of guests"), "0", "totalGuests", null, null);
            object._console.log(calendarData.guestsList);
            var guestsList = calendarData.guestsList;
            var roomPanel = object.addGuestsForRoom(guestsList, input, totalNumberOfGuests, 0, object._calendarAccount.multipleRooms, false, bookingButton);
            roomListPanel.appendChild(roomPanel);
            
            if (parseInt(object._calendarAccount.multipleRooms) == 1) {
                
                roomListPanel.setAttribute('style', 'border-bottom-width: 0;');
                object._console.log('multipleRooms = ' + object._calendarAccount.multipleRooms);
                var addRoomButton = document.createElement('label');
                addRoomButton.id = 'addRoomButton';
                addRoomButton.classList.add('addRoomButton');
                addRoomButton.textContent = object._i18n.get('Add another room');
                addRoomButton.onclick = function(event) {
                    
                    bookingButton.disabled = true;
                    var visitorDetails = object._hotel.getDetails();
                    object._console.log(visitorDetails);
                    if (visitorDetails.applicantCount < visitorDetails.vacancy) {
                        
                        var roomNumber = object._hotel.getNewRoomNumber();
                        object._console.log('roomNumber = ' + roomNumber);
                        var roomPanel = object.addGuestsForRoom(guestsList, input, totalNumberOfGuests, roomNumber, parseInt(object._calendarAccount.multipleRooms), true, bookingButton);
                        roomListPanel.insertAdjacentElement("beforeend", roomPanel);
                        object._hotel.addedRoom();
                        object.updateRoomNumber();
                        
                    }
                    
                };
                
                var addRoomPanel = document.createElement('div');
                addRoomPanel.classList.add('row');
                formPanel.insertAdjacentElement("beforeend", addRoomPanel);
                addRoomPanel.appendChild(addRoomButton);
                
                
            }
            
            var feeList = object._hotel.getFeeList();
            formPanel.appendChild(totalNumberOfGuests);
            
            var summaryListPanel = document.createElement("div");
            summaryListPanel.id = "summaryListPanel";
            var summaryPanel = object.createRowPanel(object._i18n.get("Summary"), summaryListPanel, "summaryPanel", null, null);
            formPanel.appendChild(summaryPanel);
            
            object._console.log("guestsList.length = " + guestsList.length);
            if (guestsList.length == 0) {
                
                totalNumberOfGuests.classList.add("hidden_panel");
                
            }
            
            var formatPrice = object._format.formatCost(0, object._currency);
            var rowPanel = object.createRowPanel(object._i18n.get("Total amount"), formatPrice, "totalPrice", null, null);
            formPanel.appendChild(rowPanel);
            
            object._hotel.setCallback(function(response){
                
                object._console.log(response);
                
                var checkDate = object._hotel.getCheckDate();
                object._console.log(checkDate);
                if (checkDate.checkIn == null) {
                    
                    var checkIn = document.getElementById("checkIn");
                    checkIn.textContent = expressionsCheck.chooseArrival;
                    
                }
                
                if (checkDate.checkOut == null) {
                    
                    var checkOut = document.getElementById("checkOut");
                    checkOut.setAttribute("data-check", null);
                    checkOut.textContent = expressionsCheck.chooseDeparture;
                    if (checkDate.checkIn != null) {
                        
                        var dataKey = object._calendar.getDateKey(checkDate.checkIn.month, checkDate.checkIn.day, checkDate.checkIn.year);
                        var dayPanelList = object._hotel.getDayPanelList();
                        for (var key in dayPanelList) {
                            
                            if (dataKey != key) {
                                
                                dayPanelList[key].classList.remove("selectedDayPanel");
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
                var feeList = object._hotel.getFeeList();
                totalCost = response.amount;
                object._hotel.showSummary(summaryListPanel, expressionsCheck);
                var nightsValue = response.nights + " nights";
                if (parseInt(object._calendarAccount.formatNightDay) == 1) {
                    
                    nightsValue = object._i18n.get("%s nights %s days", [response.nights, response.nights + 1]);
                    
                }
                
                if (response.nights == 1) {
                    
                    nightsValue = response.nights + " night";
                    if (parseInt(object._calendarAccount.formatNightDay) == 1) {
                        
                        nightsValue = object._i18n.get("%s night %s days", [response.nights, response.nights + 1]);
                        
                    }
                    
                }
                document.getElementById("totalLengthOfStayValue").textContent = nightsValue;
                
                var totalNumberOfGuests = 0;
                var additionalFee = 0;
                var personAmount = 0;
                for (var roomKey in response.rooms) {
                    
                    var room = response.rooms[roomKey];
                    totalNumberOfGuests += room.person;
                    additionalFee += room.additionalFee;
                    personAmount += room.personAmount;
                    
                }
                
                var totalNumberOfGuestsValue = 0;
                if (totalNumberOfGuests > 1) {
                    
                    totalNumberOfGuestsValue = totalNumberOfGuests + " " + object._i18n.get("people");
                    
                } else if (totalNumberOfGuests == 1) {
                    
                    totalNumberOfGuestsValue = totalNumberOfGuests + " " + object._i18n.get("person");
                    
                }
                
                document.getElementById("totalGuests").textContent = totalNumberOfGuestsValue;
                
                var taxAmount = 0;
                for (var key in response.taxes) {
                    
                    if ((response.taxes[key].type == 'tax' && response.taxes[key].tax == 'tax_exclusive') || response.taxes[key].type == 'surcharge') {
                    //if (response.taxes[key].tax == 'tax_exclusive') {
                        
                        taxAmount += response.taxes[key].taxValue;
                        
                    }
                    
                }
                
                var totalPrice = (response.amount * response.applicantCount) + taxAmount + (additionalFee * response.nights);
                if (personAmount > 0) {
                    
                    object._console.log('personAmount = ' + personAmount);
                    totalPrice = (response.amount * response.applicantCount) + taxAmount + personAmount;
                    
                }
                
                document.getElementById("totalPrice").textContent = object._format.formatCost(totalPrice, object._currency);
                var verifyGuests = object._hotel.verifyGuestsInRooms(response.rooms);
                if (verifyGuests.booking == false || response.nights == 0 || verifyGuests.requiredGuests == false) {
                    
                    bookingButton.disabled = true;
                    
                } else {
                    
                    bookingButton.disabled = false;
                    
                }
                
            });
            
            checkInClear.onclick = function(){
                
                this.classList.add("hidden_panel");
                var dayPanelList = object._hotel.getDayPanelList();
                for (var key in dayPanelList) {
                    
                    dayPanelList[key].classList.remove("selectedDayPanel");
                    
                }
                
                object._hotel.setCheckIn(null);
                object._hotel.setCheckInKey(null)
                object._hotel.setCheckOut(null);
                object._hotel.setCheckOutKey(null);
                object._hotel.verifySchedule(true);
                
            };
            
            checkOutClear.onclick = function(){
                
                
                
            };
            
        } else {
            
            var goodsList = [];
            if (parseInt(object._calendarAccount.guestsBool) == 1) {
                
                var guestRole = {multipleApplicantCountList: [], reflectService: [], reflectAdditional: []};
                var multipleApplicantCount = 0;
                var multipleApplicantCountList = [];
                var maxApplicantCount = object.getMaxApplicantCount();
                object._console.log(maxApplicantCount);
                var guestsList = object.getGuestsList();
                object._console.log(guestsList);
                for (var key in guestsList) {
                    
                    multipleApplicantCountList.push(0);
                    guestRole.multipleApplicantCountList.push(0);
                    guestRole.reflectService.push(0);
                    guestRole.reflectAdditional.push(0);
                    var guests = guestsList[key];
                    object._console.log(guests);
                    var list = guestsList[key].json;
                    if (typeof guestsList[key].json == 'string') {
                        
                        list = JSON.parse(guestsList[key].json);
                        
                    }
                    
                    var values = {};
                    for (var i = 0; i < list.length; i++) {
                        
                        if (maxApplicantCount >= parseInt(list[i].number) && guests.guestsInCapacity == 'included') {
                            
                            //values.push(list[i].name);
                            values[i] = list[i].name;
                            
                        } else if (guests.guestsInCapacity != 'included') {
                            
                            //values.push(list[i].name);
                            values[i] = list[i].name;
                            
                        }
                        
                    }
                    
                    guestsList[key].id = 'guests_' + guests.key
                    guestsList[key].values = values;
                    guestsList[key].type = "SELECT";
                    guestsList[key].value = 0;
                    guestsList[key].index = 0;
                    guestsList[key].number = 0;
                    guestsList[key].person = 0;
                    object._console.log(list);
                    
                    var guestsInput = new Booking_Package_Input(object._debug);
                    guestsInput.setPrefix(object._prefix);
                    var guestsSelectPanel = guestsInput.createInput(guestsList[key]['name'].replace(/\\/g, ""), guestsList[key], {}, function(event){
                        
                        var selectBox = this;
                        object._console.log(selectBox);
                        multipleApplicantCount = object._servicesControl.getSelectedGuest(guestsList, selectBox, multipleApplicantCountList);
                        /**
                        var selectedGuestsKey = this.parentElement.getAttribute("data-guset");
                        
                        var index = parseInt(this.selectedIndex);
                        var guests = guestsList[selectedGuestsKey];
                        var option = selectBox.options[index];
                        var optionKey = parseInt(option.getAttribute('data-optionsKey'));
                        object._console.log(option);
                        var parentPanel = document.getElementById(object._prefix + 'guests_' + guests.key);
                        parentPanel.classList.remove('rowError');
                        var values = guests.values;
                        var list = guests.json;
                        if (typeof guests.json == 'string') {
                            
                            list = JSON.parse(guests.json);
                            
                        }
                        //guests.index = index;
                        guests.index = optionKey;
                        guests.selectedName = values[optionKey];
                        
                        object._console.log(guests);
                        object._console.log(values);
                        object._console.log(selectedGuestsKey);
                        object._console.log(index);
                        object._console.log(list);
                        guests.number = parseInt(list[optionKey].number);
                        if (guests.guestsInCapacity == 'included') {
                            
                            object._console.log(values[index]);
                            object._console.log(list[index]);
                            multipleApplicantCountList[selectedGuestsKey] = parseInt(list[optionKey].number);
                            
                        }
                        
                        multipleApplicantCount = multipleApplicantCountList.reduce(function(a, b) {
                            
                            return a + b;
                            
                        });
                        **/
                        object._console.log(multipleApplicantCountList);
                        object._console.log(multipleApplicantCount);
                        
                        for (var guestsKey in guestsList) {
                            
                            if (guestsList[guestsKey].guestsInCapacity == 'included') {
                                
                                document.getElementById(object._prefix + 'guests_' + guestsList[guestsKey].key).classList.remove('rowError');
                                var select = document.getElementById(object._prefix + 'input_guests_' + guestsList[guestsKey].key);
                                object._console.log(select);
                                if (multipleApplicantCount >= maxApplicantCount) {
                                    
                                    if (select.selectedIndex == 0) {
                                        
                                        select.disabled = true;
                                        
                                    }
                                    
                                } else {
                                    
                                    select.disabled = false;
                                    
                                }
                                
                            }
                            
                        }
                        if (multipleApplicantCount > maxApplicantCount && guests.guestsInCapacity == 'included') {
                            
                            parentPanel.classList.add('rowError');
                            
                        }
                        
                        goodsList = [];
                        //object.setGoodsList(goodsList);
                        object._console.log(object._courseBool);
                        totalCost = parseInt(schedule.cost);
                        if (object._courseBool == true || object._calendarAccount.flowOfBooking == 'services') {
                            
                            var coursePanel = document.getElementById(object._prefix + 'selectedServicesPanel');
                            coursePanel.textContent = null;
                            //var response = object.selectedServicesPanel(course, courseList, goodsList, totalCost, coursePanel, true);
                            var response = object.createServicesPanel(coursePanel, courseList, "selectedOptionsList", guestsList, parseInt(object._calendarAccount.guestsBool), goodsList, object._currency);
                            object._console.log(response);
                            goodsList = response.goodsList;
                            totalCost += response.totalCost;
                            
                        }
                        
                        var responseGuests = object._servicesControl.getValueReflectGuests(guestsList);
                        object._console.log(responseGuests);
                        
                        var totalNumberOfGuestsPanel = document.getElementById(object._prefix + 'totalNumberOfGuests');
                        var totalNumberOfGuestsValuePanel = totalNumberOfGuestsPanel.getElementsByClassName('value')[0];
                        var totalNumberOfGuestsErrorPanel = totalNumberOfGuestsPanel.getElementsByClassName('errorMessage')[0];
                        totalNumberOfGuestsValuePanel.textContent = responseGuests.totalNumberOfGuestsTitle;
                        var responseLimitGuests = object._servicesControl.verifyToLimitGuests(responseGuests, object._calendarAccount.limitNumberOfGuests, object._calendarAccount.type);
                        object._console.log(responseLimitGuests);
                        if (responseLimitGuests.isGuests === true) {
                            
                            totalNumberOfGuestsPanel.classList.remove('rowError');
                            totalNumberOfGuestsErrorPanel.classList.add('hidden_panel');
                            totalNumberOfGuestsErrorPanel.textContent = null;
                            
                        } else {
                            
                            totalNumberOfGuestsPanel.classList.add('rowError');
                            totalNumberOfGuestsErrorPanel.classList.remove('hidden_panel');
                            totalNumberOfGuestsErrorPanel.textContent = responseLimitGuests.errorMessage;
                            
                        }
                        
                        var surchargePanel = document.getElementById(object._prefix + 'surchargeTaxPanel');
                        var taxes = new TAXES(object._i18n, object._currency, object._debug);
                        taxes.setBooking_App_ObjectsControl(object._servicesControl);
                        taxes.setTaxes(object._taxes);
                        var isTaxes = taxes.taxesDetails(totalCost, formPanel, surchargePanel, null, responseGuests);
                        if (isTaxes.isTaxes === true) {
                            
                            var responseTaxes = taxes.getTaxes();
                            var reflectAdditional = 1;
                            if (responseGuests != null) {
                                
                                reflectAdditional = responseGuests.reflectAdditional;
                                
                            }
                            object._console.log('reflectAdditional = ' + reflectAdditional);
                            totalCost += taxes.reflectTaxesInTotalCost(responseTaxes, goodsList, reflectAdditional);
                            
                        }
                        object._console.log(goodsList);
                        object._console.log('totalCost = ' + totalCost);
                        if (totalCost > 0) {
                            
                            var formatPrice = object._format.formatCost(totalCost, object._currency);
                            var totalCostPanel = document.getElementById(object._prefix + 'totalCost');
                            var valuePanel = totalCostPanel.getElementsByClassName('value')[0];
                            valuePanel.textContent = formatPrice;
                            
                        }
                        
                    });
                    
                    guestsSelectPanel.setAttribute("data-guset", key);
                    var rowPanel = object.createRowPanel(guests.name, guestsSelectPanel, guests.key, parseInt(guests.required), null);
                    rowPanel.id = object._prefix + 'guests_' + guests.key;
                    formPanel.appendChild(rowPanel);
                    
                }
                
                var rowPanel = object.createRowPanel(this._i18n.get("Total number of people"), 0, null, null, null);
                rowPanel.id = object._prefix + 'totalNumberOfGuests';
                rowPanel.classList.add("total_amount");
                var errorMessage = document.createElement('div');
                errorMessage.classList.add('errorMessage');
                errorMessage.classList.add('hidden_panel');
                rowPanel.appendChild(errorMessage);
                formPanel.appendChild(rowPanel);
                
            }
            
            
            if (object._courseBool == true) {
                
                var rowPanel = object.createRowPanel(object._courseName, "", null, null, null);
                var valuePanel = rowPanel.getElementsByClassName("value")[0];
                valuePanel.textContent = null;
                
                var guestsList = object.getGuestsList();
                var coursePanel = document.createElement("div");
                coursePanel.classList.add("mainPlan");
                coursePanel.id = object._prefix + 'selectedServicesPanel';
                valuePanel.appendChild(coursePanel);
                var response = object.createServicesPanel(coursePanel, courseList, "selectedOptionsList", guestsList, parseInt(object._calendarAccount.guestsBool), goodsList, object._currency);
                object._console.log(response);
                goodsList = response.goodsList;
                totalCost += response.totalCost;
                formPanel.appendChild(rowPanel);
                
            }
            
            var surchargePanel = object.createRowPanel("Surcharge", "", null, null, null);
            surchargePanel.id = object._prefix + "surchargeTaxPanel";
            var taxePanel = object.createRowPanel("Tax", "", null, null, null);
            
            var taxes = new TAXES(object._i18n, object._currency, object._debug);
            taxes.setBooking_App_ObjectsControl(object._servicesControl);
            taxes.setTaxes(object._taxes);
            var isTaxes = taxes.taxesDetails(totalCost, formPanel, surchargePanel, taxePanel, null);
            object._console.log(isTaxes);
            if (isTaxes.isTaxes === true) {
                
                formPanel.appendChild(isTaxes.surchargePanel);
                var responseTaxes = taxes.getTaxes();
                totalCost += taxes.reflectTaxesInTotalCost(responseTaxes, goodsList, 1);
                
            }
            
            object._console.log("totalCost = " + totalCost);
            if (totalCost != 0) {
                
                var formatPrice = object._format.formatCost(totalCost, object._currency);
                var rowPanel = object.createRowPanel(object._i18n.get("Total amount"), formatPrice, "bookingFee", null, null);
                rowPanel.id = object._prefix + 'totalCost';
                formPanel.appendChild(rowPanel);
                
            }
            
        }
        
        var formPanelList = {};
        var inputData = {};
        
        for (var i = 0; i < object._formData.length; i++) {
            
            object._formData[i].active = object._formData[i].originalActive;
            if (targetCustomers == 'visitors' && object._formData[i].targetCustomers != null && object._formData[i].targetCustomers == 'users') {
                
                object._formData[i].active = '';
                
            } else if (targetCustomers == 'users' && object._formData[i].targetCustomers != null && object._formData[i].targetCustomers == 'visitors') {
                
                object._formData[i].active = '';
                
            }
            
            
            if (object._formData[i].active != 'true') {
                
                continue;
                
            }
            
            var value = input.createInput(i, object._formData[i], inputData, null);
            var rowPanel = object.createRowPanel(object._formData[i]['name'], value, object._formData[i].id, object._formData[i].required, null);
            formPanelList[i] = rowPanel;
            
            formPanel.appendChild(rowPanel);
            
        }
        
        
        if(returnButton != null){
            
            returnButton.onclick = function(){
                
                object._console.log("returnButton onclick");
                if(returnButton != null){object._rightButtonPanel.removeChild(returnButton);}
                object._rightButtonPanel.removeChild(bookingButton);
                mainPanel.setAttribute("class", "courseAndSchedulePanel_return");
                //formMainPanel.setAttribute("class", "courseListPanel");
                formMainPanel.setAttribute("class", "createFormPanel_return return_panel_for_new_booking");
                callback({action: 'return'});
                var timer = setInterval(function(){
                    
                    formMainPanel.textContent = null;
                    clearInterval(timer);
                    
                }, 500);
                
            };
            
        }
        
        bookingButton.onclick = function(){
            
            object._console.log(object._emailEnableList);
            object._console.log("enable = " + Boolean(parseInt(object._emailEnableList.mail_new_admin.enable)));
            
            var enable = false;
            if (Boolean(parseInt(object._emailEnableList.mail_new_admin.enable)) === false) {
                
                enable = true;
                
            }
            object._console.log("enable = " + enable);
            
            var confirm = new Confirm(object._debug);
            confirm.dialogPanelShow(object._i18n.get("Attention"), object._i18n.get("Do you send e-mail notifications to customers or administrators?"), enable, function(sendEmail){
                
                var valueList = {};
                var post = object.verifyForm("sendBooking", object._nonce, object._action, calendarData.date, schedule, courseList, object._formData, formPanelList, inputData, valueList, object.getGuestsList());
                post.sendEmail = Number(sendEmail);
                
                if (user.ID != null) {
                    
                    post.userId = parseInt(user.ID);
                    
                }
                object._console.log(post);
                
                if (post !== false) {
                    
                    post.accountKey = accountKey;
                    if (calendarData.account.type == "hotel") {
                        
                        var checkDate = object._hotel.getCheckDate();
                        post.timeKey = parseInt(checkDate.checkIn.key);
                        post.unixTime = parseInt(checkDate.checkIn.unixTime);
                        
                        post.json = JSON.stringify(object._hotel.verifySchedule(true));
                        
                    }
                    
                    post.selectedOptions = JSON.stringify([]);
                    if (selectedOptions != null) {
                        
                        post.selectedOptions = JSON.stringify(selectedOptions);
                        
                    }
                    
                    object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
                    new Booking_App_XMLHttp(object._url, post, object._webApp, function(response){
                        
                        object._console.log(response);
                        if (response.status == "success") {
                            
                            object._hotel.reset();
                            object._hotel.setCallback(null);
                            object._rightButtonPanel.textContent = null;
                            response.action = 'refresh';
                            object._buttonAction = "reservation_users";
                            object.createCalendar(response, response.date.month, response.date.day, response.date.year, accountKey);
                            callback(response);
                            
                        } else {
                            
                            alert(response.message);
                            
                        }
                        object._loadingPanel.setAttribute("class", "hidden_panel");
                        
                    }, function(responseText){
                        
                        object.setResponseText(responseText);
                        
                    });
                    
                }
                
            });
            
        };
        
    }
    
    this.addGuestsForRoom = function(guestsList, input, totalNumberOfGuests, roomNo, multipleRooms, deleteRoom, bookingButton){
        
        var object = this;
        object._console.log('addGuestsForRoom');
        object._console.log('multipleRooms = ' + multipleRooms);
        
        var roomPanel = document.createElement('div');
        roomPanel.id = 'roomNo_' + roomNo;
        if (multipleRooms == 1) {
            
            var roomNoLabel = document.createElement('label');
            roomNoLabel.classList.add('roomNoLabel');
            roomNoLabel.textContent = object._i18n.get('Room') + ': ' + (roomNo + 1);
            roomPanel.appendChild(roomNoLabel);
            
        }
        
        if (deleteRoom === true) {
            
            var deleteRoomButton = document.createElement('label');
            deleteRoomButton.classList.add('material-icons');
            deleteRoomButton.classList.add('deleteRoomButton');
            deleteRoomButton.textContent = 'delete';
            deleteRoomButton.setAttribute('data-room', roomNo);
            roomPanel.appendChild(deleteRoomButton);
            deleteRoomButton.onclick = function(event) {
                
                var deleteRoomButton = this;
                var roomNo = parseInt(deleteRoomButton.getAttribute('data-room'));
                object._console.log('roomNo = ' + roomNo);
                var rooms = object._hotel.deleteRoom(roomNo);
                var roomPanel = deleteRoomButton.parentElement;
                document.getElementById('roomListPanel').removeChild(roomPanel);
                object.updateRoomNumber();
                var verifyGuests = object._hotel.verifyGuestsInRooms(response.rooms);
                if (verifyGuests.booking == false || response.nights == 0 || verifyGuests.requiredGuests == false) {
                    
                    bookingButton.disabled = true;
                    
                } else {
                    
                    bookingButton.disabled = false;
                    
                }
                
            };
            
        }
        
        for(var key in guestsList){
            
            var list = JSON.parse(guestsList[key].json);
            object._console.log(list);
            var values = [];
            for(var i = 0; i < list.length; i++){
                
                values.push(list[i].name);
                
            }
            
            object._console.log(values);
            guestsList[key].values = values;
            guestsList[key].type = "SELECT";
            guestsList[key].value = 0;
            guestsList[key].index = 0;
            guestsList[key].person = 0;
            object._hotel.addGuests(key, guestsList[key], roomNo);
            if(list[0] != null){
                
                guestsList[key].person = parseInt(list[0].number);
                var response = object._hotel.setGuests(key, 0, list[0].number, roomNo);
                
            }
            
            var value = input.createInput(guestsList[key]['name'], guestsList[key], {}, function(event){
                
                var key = this.parentElement.getAttribute("data-guset");
                var index = parseInt(this.selectedIndex);
                var roomNo = parseInt(this.parentElement.getAttribute('data-room'));
                var list = JSON.parse(guestsList[key].json);
                guestsList[key].index = index;
                var response = object._hotel.setGuests(key, index, list[index].number, roomNo);
                var feeList = object._hotel.getFeeList();
                var verifyGuests = object._hotel.verifyGuestsInRooms(response.rooms);
                object._hotel.pushCallback();
                
                totalNumberOfGuests.classList.remove("errorPanel");
                if(response.booking == false){
                    
                    totalNumberOfGuests.classList.add("errorPanel");
                    
                }
                
                for (var roomKey in verifyGuests.rooms) {
                    
                    var roomStatus = verifyGuests.rooms[roomKey];
                    var roomPanel = document.getElementById('roomNo_' + roomKey);
                    object._console.log(roomStatus);
                    object._console.log(roomPanel);
                    if (roomStatus.booking === false || roomStatus.requiredGuests === false) {
                        
                        roomPanel.classList.add('errorPanel');
                        
                    } else {
                        
                        roomPanel.classList.remove('errorPanel');
                        
                    }
                    
                }
                
                object._console.log(totalNumberOfGuests);
                object._console.log(response);
                object._console.log(this.selectedIndex);
                object._console.log(guestsList[key]);
                object._console.log(list[index]);
                
            });
            
            value.setAttribute("data-guset", key);
            value.setAttribute("data-room", roomNo);
            var required = parseInt(guestsList[key].required);
            object._console.log("required = " + required);
            var rowPanel = object.createRowPanel(guestsList[key]['name'], value, null, required, null);
            if (multipleRooms == 1) {
                
                rowPanel.setAttribute('class', 'rowRoom');
                
            }
            roomPanel.appendChild(rowPanel);
            
        }
        
        return roomPanel;
        
    };
    
    this.updateRoomNumber = function() {
        
        var object = this;
        var roomNumberLabels = document.getElementById('roomListPanel').getElementsByClassName('roomNoLabel');
        object._console.log(roomNumberLabels);
        for (var i = 0; i < roomNumberLabels.length; i++) {
            
            var roomNoLabel = roomNumberLabels[i];
            object._console.log(roomNoLabel);
            roomNoLabel.textContent = object._i18n.get('Room') + ': ' + (i + 1);
            
        }
        
    };
    
    this.lookForUser = function(callback){
        
        var object = this;
        object._console.log('lookForUser');
        var lookForUserPanel = document.getElementById('lookForUserPanel');
        lookForUserPanel.classList.remove('hidden_panel');
        
        var inputPanel = lookForUserPanel.getElementsByClassName('inputPanel')[0];
        inputPanel.textContent = null;
        object._console.log(inputPanel);
        
        var search_users_text = document.getElementById('search_users_text');
        search_users_text.focus();
        var search_user_button = document.getElementById('search_user_button');
        
        var load_blockPanel = document.getElementById('load_blockPanel');
        load_blockPanel.classList.remove('hidden_panel');
        
        document.getElementById('lookForUserPanel_return_button').onclick = function() {
            
            lookForUserPanel.classList.add('hidden_panel');
            load_blockPanel.classList.add('hidden_panel');
            
        };
        
        load_blockPanel.onclick = function() {
            
            lookForUserPanel.classList.add('hidden_panel');
            load_blockPanel.classList.add('hidden_panel');
            
        };
        
        search_users_text.onkeydown = function(event) {
            
            if (event.key != null && event.key.toLocaleLowerCase() == 'enter') {
                
                getMembers(search_users_text.value);
                
            }
            
        };
        
        search_user_button.onclick = function() {
            
            getMembers(search_users_text.value);
            
        };
        
        function getMembers(text) {
            
            var keywords = text;
            //keywords = keywords.replace(/[\u{20}\u{3000}]/ug ,' ');
            //keywords = keywords.replace(/[\x20\u3000]/g ,' ');
            keywords = keywords.trim(keywords);
            object._console.log(keywords.length);
            if (keywords.length <= 1) {
                
                return null;
                
            }
            
            search_users_text.disabled = true;
            search_user_button.disabled = true;
            object._console.log(keywords);
            var post = {mode: 'getMembers', nonce: object._nonce, action: object._action, keywords: keywords, page: null, number: 20, offset: 0, authority: 'user', meta: 1};
            object._console.log(post);
            object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
            object.setFunction("lookForUser", post);
            new Booking_App_XMLHttp(object._url, post, object._webApp, function(users){
                
                object._loadingPanel.setAttribute("class", "hidden_panel");
                search_users_text.disabled = false;
                search_user_button.disabled = false;
                object._console.log(users);
                
                inputPanel.textContent = null;
                if (users.length == 0) {
                    
                    var noUsers = document.createElement('p');
                    noUsers.classList.add('noUsers');
                    noUsers.textContent = object._i18n.get('The user was not found.');
                    inputPanel.appendChild(noUsers);
                    
                } else {
                    
                    var tbody = document.createElement('tbody');
                    tbody.id = 'member_list_tbody';
                    
                    var table = document.createElement('table');
                    table.id = 'member_list_table';
                    table.appendChild(tbody);
                    table.setAttribute('class', 'wp-list-table widefat fixed striped');
                    inputPanel.appendChild(table);
                    
                    for (var i = 0; i < users.length; i ++) {
                        
                        var user = users[i];
                        object._console.log(user);
                        
                        var tdUserId = document.createElement('td');
                        tdUserId.textContent = user.user_login;
                        var tdEmail = document.createElement('td');
                        tdEmail.textContent = user.user_email;
                        
                        var tr = document.createElement('tr');
                        tr.setAttribute('data-key', i);
                        tr.classList.add('tr_user');
                        tr.appendChild(tdUserId);
                        tr.appendChild(tdEmail);
                        tbody.appendChild(tr);
                        
                        tr.onclick = function() {
                            
                            var key = parseInt(this.getAttribute('data-key'));
                            var user = users[key];
                            var json = JSON.parse(user.value);
                            user.meta = json;
                            object._console.log(user);
                            lookForUserPanel.classList.add('hidden_panel');
                            load_blockPanel.classList.add('hidden_panel');
                            callback(user);
                            
                            
                        };
                        
                    }
                    
                }
                
            });
            
        }
        
    }
    
    this.downloadCSV = function(month, day, year, accountKey, form, downloadBool, style){
        
        var object = this;
        object._console.log("month = " + month + " day = " + day + " year = " + year);
        form.method = "post";
        form.target = "_blank";
        var post = {nonce: object._nonce_download, action: object._action, mode: object._prefix + 'getDownloadCSV', year: year, month: month, accountKey: accountKey};
        
        if(day != null){
            
            post.day = day;
            
        }
        
        for(var key in post){
            
            var hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = key;
            hidden.value = post[key];
            form.appendChild(hidden);
            
        }
        
        var submit = document.createElement("input");
        submit.type = "submit";
        submit.value = this._i18n.get("Download CSV");
        submit.setAttribute("class", "downloadButton button media-button button-primary button-large media-button-insert");
        //submit.setAttribute("style", "padding: 0 0.5em;");
        if(downloadBool == false){
    	    
    	    submit.disabled = true;
    	    
    	}
        form.appendChild(submit);
        form.setAttribute("style", style);
        
    }
    
    /**
    this.downloadCSV = function(month, day, year, accountKey, downloadButton){
        
        var object = this;
        object._console.log("month = " + month + " day = " + day + " year = " + year);
        var object = this;
        
        object._loadingPanel.setAttribute("class", "loading_modal_backdrop");
        var post = {nonce: object._nonce, action: object._action, mode: 'getDownloadCSV', year: year, month: month, accountKey: accountKey};
        if(day != null){
            
            post.day = day;
            
        }
        
        object.setFunction("downloadCSV", post);
        new Booking_App_XMLHttp(object._url, post, object._webApp, function(response){
            
            object._loadingPanel.setAttribute("class", "hidden_panel");
            var bom = new Uint8Array([0xEF, 0xBB, 0xBF]);
            var content = response.csv;
            var blob = new Blob([bom, content], {"type": "application/octet-stream"});
            object._console.log(blob);
            if (window.navigator.msSaveBlob){
                
                object._console.log("msSaveBlob is support");
                window.navigator.msSaveBlob(blob, "list.csv");
                
            }else{
                
                object._console.log("msSaveBlob is not support");
                downloadButton.href = window.URL.createObjectURL(blob);
                window.open(window.URL.createObjectURL(blob), '_blank');
                
            }
            
        }, function(responseText){
            
            object.setResponseText(responseText);
            
        });
        
    }
    **/
    
    this.verifyCalendar = function(mode, month, day, year, lastDay){
        
        var calendarChange = 0;
        if(mode == 0){
        
            day--;
            if(day == 0){
                
                calendarChange = 1;
                month--;
                day = 1;
                if(month == 0){
                    month = 12;
                    year--;
                }
                
            }
            
        }else if(mode == 1){
            
            day++;
            if(day > lastDay){
                
                calendarChange = 1;
                month++;
                day = 1;
                if(month == 13){
                    month = 1;
                    year++;
                }
                
            }
            
        }
        
        var date = {month: month, day: day, year: year, calendarChange: calendarChange};
        return date;
        
    }
    
    this.verifyForm = function(mode, nonce, action, date, schedule, courseList, formData, formPanelList, inputData, valueList, guestsList){
        
        var object = this;
        object._console.log(date);
        object._console.log(schedule);
        object._console.log(courseList);
        var errorPanel = null;
        var sendBool = true;
        var input = new Booking_Package_Input(object._debug);
        for (var key in formData) {
            
            object._console.log(key);
            object._console.log(inputData[key]);
            object._console.log(formData[key]);
            
            if (formData[key].active != 'true') {
                
                continue;
                
            }
            
            if (formPanelList[key] == null) {
                
                continue;
                
            }
            
            var bool = input.inputCheck(key, formData[key], inputData[key], valueList, 'dashboard');
            object._console.log("bool = " + bool);
            if (bool === true) {
                
                formPanelList[key].removeAttribute("data-errorInput");
                formPanelList[key].classList.remove("rowError");
                //formPanelList[key].setAttribute("class", "row");
                
            } else {
                
                sendBool = false;
                formPanelList[key].setAttribute("data-errorInput", 1);
                formPanelList[key].classList.add("rowError");
                //formPanelList[key].setAttribute("class", "row rowError");
                if (errorPanel == null) {
                    
                    errorPanel = formPanelList[key];
                    
                }
                
            }
            
        }
        
        var postGuests = [];
        if (parseInt(object._calendarAccount.guestsBool) == 1) {
            
            if (object._calendarAccount.type == 'day' && guestsList.length > 0) {
                
                for (var key in guestsList) {
                    
                    var guest = guestsList[key];
                    object._console.log(guest);
                    var guestPanel = document.getElementById(object._prefix + guest.id);
                    if (parseInt(guest.required) == 1 && parseInt(guest.index) == 0) {
                        
                        sendBool = false;
                        guestPanel.classList.add('rowError');
                        guestPanel.setAttribute("data-errorInput", 1);
                        if (errorPanel == null) {
                            
                            errorPanel = guestPanel;
                            
                        }
                        
                    } else {
                        
                        guestPanel.classList.remove('rowError');
                        guestPanel.removeAttribute("data-errorInput");
                        var postGuest = {key: guest.key, name: guest.name, selectedName: guest.selectedName, index: guest.index};
                        postGuests.push(postGuest);
                        
                    }
                    
                }
                object._console.log(postGuests);
                
                var responseGuests = object._servicesControl.getValueReflectGuests(guestsList);
                object._console.log(responseGuests);
                var totalNumberOfGuestsPanel = document.getElementById(object._prefix + 'totalNumberOfGuests');
                var totalNumberOfGuestsValuePanel = totalNumberOfGuestsPanel.getElementsByClassName('value')[0];
                var totalNumberOfGuestsErrorPanel = totalNumberOfGuestsPanel.getElementsByClassName('errorMessage')[0];
                totalNumberOfGuestsValuePanel.textContent = responseGuests.totalNumberOfGuestsTitle;
                var responseLimitGuests = object._servicesControl.verifyToLimitGuests(responseGuests, object._calendarAccount.limitNumberOfGuests, object._calendarAccount.type);
                object._console.log(responseLimitGuests);
                if (responseLimitGuests.isGuests === true) {
                    
                    totalNumberOfGuestsPanel.classList.remove('rowError');
                    totalNumberOfGuestsPanel.removeAttribute("data-errorInput");
                    totalNumberOfGuestsErrorPanel.classList.add('hidden_panel');
                    totalNumberOfGuestsErrorPanel.textContent = null;
                    
                } else {
                    
                    sendBool = false;
                    totalNumberOfGuestsPanel.classList.add('rowError');
                    totalNumberOfGuestsPanel.setAttribute("data-errorInput", 1);
                    totalNumberOfGuestsErrorPanel.classList.remove('hidden_panel');
                    totalNumberOfGuestsErrorPanel.textContent = responseLimitGuests.errorMessage;
                    if (errorPanel == null) {
                        
                        errorPanel = totalNumberOfGuestsPanel;
                        
                    }
                    
                }
                
            }
            
        }
        
        object._console.log(valueList);
        if (sendBool === true) {
            
            object._console.log('_courseBool = ' + object._courseBool);
            var post = {nonce: nonce, action: action, mode: mode, month: date.month, day: 1, year: date.year, applicantCount: '1', permission: 'public', timeKey: schedule.key, unixTime: schedule.unixTime};
            if (postGuests.length > 0) {
                
                post.guests = JSON.stringify(postGuests);
                
            }
            
            if (object._courseBool == true && courseList != null) {
                
                var selectedCourseList = [];
                var selectedCourseKeyList = [];
                for (var i in courseList) {
                    
                    if (courseList[i].selected == 1) {
                        
                        object._console.log(courseList[i]);
                        object._console.log(typeof courseList[i].options);
                        var service = {};
                        for (var key in courseList[i]) {
                            
                            service[key] = courseList[i][key];
                            
                        }
                        
                        
                        if (typeof courseList[i].options == 'string') {
                            
                            var options = JSON.parse(courseList[i].options);
                            service.options = options;
                            
                        }
                        
                        selectedCourseList.push(service);
                        selectedCourseKeyList.push(service.key);
                        post.courseKey = courseList[i].key;
                        
                    }
                    
                }
                
                post.selectedCourseList = JSON.stringify(selectedCourseList);
                post.selectedCourseKeyList = JSON.stringify(selectedCourseKeyList);
                //post.courseKey = course.key;
                
            }
            
            for (var key in valueList) {
                
                object._console.log(valueList[key]);
                if (typeof valueList[key].join == 'function') {
                    
                    post['form' + key] = valueList[key].join(",");
                    
                } else {
                    
                    post['form' + key] = valueList[key];
                    
                }
                
                
            }
            
            return post;
            
        } else {
            
            if (errorPanel != null && typeof errorPanel.scrollIntoView == 'function') {
                
                object._console.log(errorPanel);
                errorPanel.scrollIntoView(true);
                
            }
            
            return false;
            
        }
        
    }
    
    this.unselectPanel = function(selectedKey, panelList, styleName){
        
        for(var i = 0; i < panelList.length; i++){
            
            var key = panelList[i].getAttribute("data-key");
            var status = parseInt(panelList[i].getAttribute("data-status"));
            if(key != selectedKey && status === 1){
                
                panelList[i].setAttribute("class", styleName);
                
            }
            
            
        }
        
    }
    
    this.createRowPanel = function(name, value, id, required, actionElement){
        
        var object = this;
        if (typeof name == "string") {
            
            name = name.replace(/\\/g, "");
            
        }
        object._console.log(value);
        if (typeof value == "string") {
            
            value = value.replace(/\\/g, "");
            
        } else if (typeof value == 'object' && typeof value.join == 'function') {
            
            //value = JSON.parse(value);
            //object._console.log(value);
            value = value.join('\n');
            
        }
        object._console.log(value);
        
        var edit = 0;
        if (typeof value == 'object' && typeof value.getAttribute == 'function' && value.getAttribute("data-edit") != null) {
            
            edit = parseInt(value.getAttribute("data-edit"));
            
        }
        
        object._console.log("id = " + id);
        object._console.log("edit = " + edit);
        
        var namePanel = document.createElement("div");
        namePanel.setAttribute("class", "name");
        namePanel.textContent = name;
        //object._console.log("typeof required = " + typeof required);
        if ( (typeof required == "string" && required == 'true') || (typeof required == "number" && required == 1) ) {
            
            namePanel.setAttribute("class", "name required");
            
        }
        
        var inputPanel = null;
        if (typeof value == 'string' || typeof value == 'number') {
            
            inputPanel = document.createElement("div");
            inputPanel.textContent = value;
            if (id != null) {
                
                inputPanel.id = id;
                
            }
            
        } else {
            
            inputPanel = value;
            if (id != null) {
                
                inputPanel.id = id;
                
            }
            
        }
        inputPanel.setAttribute("class", "value");
        
        var rowPanel = document.createElement("div");
        rowPanel.setAttribute("class", "row");
        rowPanel.appendChild(namePanel);
        
        if (edit == 1) {
            
            var editButton = document.createElement("div");
            editButton.setAttribute("data-id", id);
            editButton.classList.add("material-icons");
            editButton.classList.add("editButton");
            editButton.classList.add(object._prefix + "user_information_button");
            editButton.setAttribute("style", "font-family: 'Material Icons' !important;");
            editButton.textContent = "border_color";
            rowPanel.appendChild(editButton);
            
            var doneButton = document.createElement("div");
            doneButton.setAttribute("data-id", id);
            doneButton.classList.add("material-icons");
            doneButton.classList.add("editButton");
            doneButton.classList.add("hidden_panel");
            doneButton.classList.add(object._prefix + "user_information_button");
            doneButton.textContent = "done_outline";
            rowPanel.appendChild(doneButton);
            
            editButton.onclick = function(){
                
                var id = editButton.getAttribute("data-id");
                var valueId = "value_" + id;
                var inputId = "input_" + id;
                editButton.classList.add("hidden_panel");
                doneButton.classList.remove("hidden_panel");
                document.getElementById(valueId).classList.add("hidden_panel");
                document.getElementById(inputId).classList.remove("hidden_panel");
                
            };
            
            doneButton.onclick = function(){
                
                var id = doneButton.getAttribute("data-id");
                var valueId = "value_" + id;
                var inputId = "input_" + id;
                doneButton.classList.add("hidden_panel");
                editButton.classList.remove("hidden_panel");
                document.getElementById(valueId).classList.remove("hidden_panel");
                document.getElementById(inputId).classList.add("hidden_panel");
                
            };
            
        }
        
        
        if (actionElement != null) {
            
            rowPanel.appendChild(actionElement);
            
        }
        rowPanel.appendChild(inputPanel);
        
        return rowPanel;
        
    }
    
    this.editPanelShow = function(showBool){
        
        var object = this;
        var body = document.getElementsByTagName("body")[0];
        object._console.log(body);
        
        
        if (showBool == true) {
            
            body.classList.add("modal-open");
            object._editPanel.setAttribute("class", "edit_modal");
            object._blockPanel.setAttribute("class", "edit_modal_backdrop");
            
        } else {
            
            if( document.getElementById("userInfoPanel") != null) {
                
                document.getElementById("userInfoPanel").setAttribute("class", "hidden_panel");
                
            }
            
            if (document.getElementById("changePanel") != null) {
                
                document.getElementById("changePanel").setAttribute("class", "hidden_panel");
                
            }
            
            if (object._contentPanel != null && document.getElementById("showUserInfo_blockPanel") != null) {
                
                object._contentPanel.removeChild(document.getElementById("showUserInfo_blockPanel"));
                
            }
            
            body.classList.remove("modal-open");
            object._editPanel.setAttribute("class", "hidden_panel");
            object._blockPanel.setAttribute("class", "hidden_panel");
            
        }
        
    }
    
    this.setSelectedKey = function(_selectedKey){
        
        this._selectedKey = _selectedKey;
        
    }
    
    this.getSelectedKey = function(){
        
        return this._selectedKey;
        
    }
    
    this.setVisitors = function(_visitors){
        
        this._visitors = _visitors;
        
    }
    
    this.getVisitors = function(){
        
        return this._visitors;
        
    }
    
    this.getServiceOrOption = function(services) {
        
        var mode = "option";
        for (var key in services) {
            
            if (services[key].service != null && parseInt(services[key].service) == 1) {
                
                return "service";
                
            }
            
        }
        
        return mode;
        
    }
    
    this.createServicesPanel = function(panel, services, optionName, guestsList, guestsBool, goodsList, currency) {
        
        var object = this;
        var totalCost = 0;
        var applicantCount = 1;
        var reflectService = 0;
        var reflectAdditional = 0;
        var reflectServiceTitle = null;
        var hasReflectService = false;
        var defaultAmountForService = 0;
        var defaultAmountForOption = 0;
        var isGuests = 0;
        object._console.log(guestsList);
        if (typeof guestsList == 'object' && guestsList.length > 0) {
            
            isGuests = 1
            var response = object._servicesControl.getValueReflectGuests(guestsList);
            object._console.log(response);
            reflectService = response.reflectService;
            reflectServiceTitle = response.reflectServiceTitle;
            if (reflectService > 0) {
                
                applicantCount = reflectService;
                
            }
            
        }
        
        object._console.log('reflectService = ' + reflectService);
        object._console.log('reflectAdditional = ' + reflectAdditional);
        object._console.log(reflectServiceTitle);
        object._console.log('guestsBool = ' + guestsBool)
        
        if (services.length > 0) {
            
            for (var key in services) {
                
                var service = services[key];
                object._console.log(service);
                
                if (parseInt(service.selected) == 1) {
                    
                    var responseCosts = object._servicesControl.getCostsInService(services[key], guestsList, isGuests, object._isExtensionsValid);
                    object._console.log(responseCosts);
                    var costsWithKey = responseCosts.costsWithKey;
                    var costPerGuests = document.createElement('div');
                    costPerGuests.id = 'costPerGuests_' + key;
                    costPerGuests.classList.add('costPerGuests');
                    costPerGuests.classList.add('hidden_panel');
                    var courseCostPanel = null;
                    if (isNaN(parseInt(responseCosts.max)) === false && parseInt(responseCosts.max) != 0) {
                        
                        courseCostPanel = document.createElement("span");
                        courseCostPanel.classList.add("planPrice");
                        //courseCostPanel.textContent = object._format.formatCost(service.cost, currency);
                        var cost = object._format.formatCost(responseCosts.max, object._currency);
                    
                        if (responseCosts.hasMultipleCosts === true) {
                            
                            //cost = object._format.formatCost(responseCosts.min, object._currency) + ' ' + object._i18n.get('to') + ' ' + object._format.formatCost(responseCosts.max, object._currency);
                            cost = object._i18n.get('%s to %s', [object._format.formatCost(responseCosts.min, object._currency), object._format.formatCost(responseCosts.max, object._currency)]);
                            
                        }
                        courseCostPanel.textContent = cost;
                        
                        var amount1 = parseInt(service.cost_1);
                        var amount2 = parseInt(service.cost_1);
                        if (reflectService > 0) {
                            
                            //amount1 = 0;
                            if (guestsBool == 1) {
                                
                                amount1 = 0;
                                for (var guestKey in guestsList) {
                                    
                                    var guest = guestsList[guestKey];
                                    object._console.log(guest);
                                    if (parseInt(guest.reflectService) == 1) {
                                        
                                        if (guest.number == null) {
                                            
                                            guest.number = parseInt(guest.json[guest.index].number);
                                            
                                        }
                                        
                                        if (guest.selectedName == null) {
                                            
                                            guest.selectedName = guest.json[parseInt(guest.number)].name;
                                            
                                        }
                                        hasReflectService = true;
                                        amount1 += costsWithKey[guest.costInServices] * guest.number;
                                        
                                        if (defaultAmountForService == 0) {
                                            
                                            defaultAmountForService = costsWithKey[guest.costInServices];
                                            
                                        }
                                        
                                        var costInService = document.createElement('div');
                                        costInService.textContent = guest.name + ': ' + object._format.formatCost(costsWithKey[guest.costInServices], object._currency) + ' * ' + guest.selectedName;
                                        if (guest.number > 0) {
                                            
                                            costPerGuests.appendChild(costInService);
                                            
                                        }
                                        
                                    } else {
                                        
                                        if (guest.number != null && guest.number > 0) {
                                            
                                            if (guest.selectedName == null) {
                                                
                                                guest.selectedName = guest.json[parseInt(guest.number)].name;
                                                
                                            }
                                            
                                            //amount2 += costsWithKey[guest.costInServices];
                                            amount2 = costsWithKey['cost_1'];
                                            if (defaultAmountForService == 0) {
                                                
                                                defaultAmountForService = costsWithKey[guest.costInServices];
                                                
                                            }
                                            var costInService = document.createElement('div');
                                            costInService.textContent = guest.name + ': ' + /**object._format.formatCost(costsWithKey[guest.costInServices], object._currency) + ' * ' +**/ guest.selectedName;
                                            costPerGuests.appendChild(costInService);
                                            
                                        }
                                        
                                    }
                                    
                                }
                                
                            } else {
                                
                                //amount1 = costsWithKey['cost_1'];
                                //amount2 = 0;
                                
                            }
                            
                        } else {
                            
                            amount2 = 0;
                            
                        }
                        
                        object._console.log('hasReflectService = ' + hasReflectService);
                        if (hasReflectService === true) {
                            
                            amount2 = 0;
                            
                        }
                        
                        object._console.log('amount1 = ' + amount1);
                        object._console.log('amount2 = ' + amount2);
                        var goods = {label: service.name, amount: amount1 + amount2, applicantCount: applicantCount};
                        goodsList.push(goods);
                        totalCost += amount1 + amount2;
                        
                    }
                    
                    var courseLinePanel = document.createElement("div");
                    courseLinePanel.setAttribute('data-key', key);
                    courseLinePanel.classList.add("courseLinePanel");
                    panel.appendChild(courseLinePanel);
                    panel.appendChild(costPerGuests);
                    
                    var courseNamePanel = document.createElement("span");
                    courseNamePanel.classList.add("planName");
                    courseNamePanel.textContent = service.name;
                    courseLinePanel.appendChild(courseNamePanel);
                    if (courseCostPanel != null) {
                        
                        courseLinePanel.appendChild(courseCostPanel);
                        
                    }
                    
                    if (reflectService > 0) {
                        
                        var reflectServicePanel = document.createElement('span');
                        reflectServicePanel.classList.add('reflectPanel');
                        //reflectServicePanel.textContent = ' * ' + reflectServiceTitle;
                        courseLinePanel.appendChild(reflectServicePanel);
                        
                        courseLinePanel.onclick = function() {
                            
                            var key = parseInt(this.getAttribute('data-key'));
                            var costPerGuests = document.getElementById('costPerGuests_' + key);
                            object._console.log(costPerGuests);
                            object._console.log(costPerGuests.classList.contains('hidden_panel'));
                            if (costPerGuests.classList.contains('hidden_panel') === true) {
                                
                                costPerGuests.classList.remove('hidden_panel');
                                
                            } else {
                                
                                costPerGuests.classList.add('hidden_panel');
                                
                            }
                            
                        };
                        
                    }
                    
                    object._console.log(service);
                    var options = service[optionName];
                    if (options.length > 0) {
                        
                        var ul = document.createElement("ul");
                        panel.appendChild(ul);
                        for(var i = 0; i < options.length; i++){
                            
                            var option = options[i];
                            var responseCosts = object._servicesControl.getCostsInService(option, guestsList, isGuests, object._isExtensionsValid);
                            object._console.log(responseCosts);
                            var costsWithKey = responseCosts.costsWithKey;
                            if (parseInt(option.selected) == 1) {
                                
                                //cost += parseInt(option.cost);
                                
                                var optionPanel = document.createElement('div');
                                optionPanel.setAttribute('data-serviceKey', key);
                                optionPanel.setAttribute('data-optionKey', i);
                                optionPanel.classList.add('courseLinePanelInLink');
                                var costPerOptions = document.createElement('div');
                                costPerOptions.id = 'costPerOptions_' + key + '_' + i;
                                costPerOptions.classList.add('hidden_panel');
                                
                                var optionNamePanel = document.createElement("span");
                                optionNamePanel.classList.add("planName");
                                optionNamePanel.textContent = option.name;
                                
                                var optionPricePanel = document.createElement("span");
                                optionPricePanel.classList.add("planPrice");
                                if (parseInt(responseCosts.max) > 0) {
                                    
                                    optionPricePanel.textContent = object._format.formatCost(responseCosts.max, currency);
                                    if (responseCosts.hasMultipleCosts === true) {
                                        
                                        //cost = object._format.formatCost(responseCosts.min, object._currency) + ' ' + object._i18n.get('to') + ' ' + object._format.formatCost(responseCosts.max, object._currency);
                                        optionPricePanel.textContent = object._i18n.get('%s to %s', [object._format.formatCost(responseCosts.min, object._currency), object._format.formatCost(responseCosts.max, object._currency)]);
                                        
                                    }
                                    var amount1 = parseInt(responseCosts.max);
                                    var amount2 = parseInt(responseCosts.max);
                                    if (reflectService > 0) {
                                        
                                        //amount *= reflectService;
                                        amount1 = 0;
                                        if (guestsBool == 1) {
                                            
                                            for (var guestKey in guestsList) {
                                                
                                                var guest = guestsList[guestKey];
                                                if (parseInt(guest.reflectService) == 1) {
                                                    
                                                    if (guest.selectedName == null) {
                                                        
                                                        guest.selectedName = guest.json[parseInt(guest.number)].name;
                                                        
                                                    }
                                                    
                                                    if (defaultAmountForOption == 0) {
                                                        
                                                        defaultAmountForOption = costsWithKey[guest.costInServices];
                                                        
                                                    }
                                                    
                                                    amount1 += costsWithKey[guest.costInServices] * guest.number;
                                                    var costInOption = document.createElement('div');
                                                    costInOption.textContent = guest.name + ': ' + object._format.formatCost(costsWithKey[guest.costInServices], object._currency) + ' * ' + guest.selectedName;
                                                    if (guest.number > 0) {
                                                        
                                                        costPerOptions.appendChild(costInOption);
                                                        
                                                    }
                                                    
                                                } else {
                                                    
                                                    if (guest.number != null && guest.number > 0) {
                                                        
                                                        if (guest.selectedName == null) {
                                                            
                                                            guest.selectedName = guest.json[parseInt(guest.number)].name;
                                                            
                                                        }
                                                        
                                                        if (defaultAmountForOption == 0) {
                                                            
                                                            defaultAmountForOption = costsWithKey[guest.costInServices];
                                                            
                                                        }
                                                        
                                                        //amount2 += costsWithKey[guest.costInServices];
                                                        amount2 = costsWithKey['cost_1'];
                                                        var costInOption = document.createElement('div');
                                                        costInOption.textContent = guest.name + ': ' + /**object._format.formatCost(costsWithKey[guest.costInServices], object._currency) + ' * ' +**/ guest.selectedName;
                                                        costPerOptions.appendChild(costInOption);
                                                        
                                                    }
                                                    
                                                }
                                                
                                            }
                                            
                                        } else {
                                            
                                            //amount1 = costsWithKey['cost_1'];
                                            //amount2 = 0;
                                            
                                        }
                                        
                                        optionPanel.onclick = function() {
                                            
                                            var serviceKey = this.getAttribute('data-serviceKey');
                                            var optionKey = this.getAttribute('data-optionKey');
                                            var costPerOptions = document.getElementById('costPerOptions_' + serviceKey + '_' + optionKey);
                                            if (costPerOptions.classList.contains('hidden_panel') === true) {
                                                
                                                costPerOptions.classList.remove('hidden_panel');
                                                
                                            } else {
                                                
                                                costPerOptions.classList.add('hidden_panel');
                                                
                                            }
                                            
                                        };
                                        
                                    } else {
                                        
                                        amount2 = 0;
                                        
                                    }
                                    
                                    if (hasReflectService === true) {
                                        
                                        amount2 = 0;
                                        
                                    }
                                    
                                    var goods = {label: option.name, amount: amount1 + amount2, applicantCount: applicantCount};
                                    goodsList.push(goods);
                                    totalCost += amount1 + amount2;
                                    
                                }
                                
                                var reflectServicePanel = document.createElement('span');
                                reflectServicePanel.classList.add('reflectPanel');
                                if (reflectService > 0) {
                                    
                                    //reflectServicePanel.textContent = ' * ' + reflectServiceTitle;
                                    
                                }
                                
                                optionPanel.appendChild(optionNamePanel);
                                optionPanel.appendChild(optionPricePanel);
                                optionPanel.appendChild(reflectServicePanel);
                                
                                var li = document.createElement("li");
                                /**
                                li.appendChild(optionNamePanel);
                                li.appendChild(optionPricePanel);
                                li.appendChild(reflectServicePanel);
                                **/
                                li.appendChild(optionPanel);
                                li.appendChild(costPerOptions);
                                ul.appendChild(li);
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
                
            }
            
        } else {
            
            console.error("option = " + option);
            
        }
        
        if (totalCost == 0) {
            
            totalCost = defaultAmountForService + defaultAmountForOption;
            
        }
        
        return {services: services, goodsList: goodsList, totalCost: totalCost};
        
    };
    
    
    
}