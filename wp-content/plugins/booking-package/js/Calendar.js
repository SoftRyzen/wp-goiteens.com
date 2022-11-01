    function Booking_App_Calendar(weekName, dateFormat, positionOfWeek, positionTimeDate, startOfWeek, i18n, debug) {
    	
    	var object = this;
        this._console = {};
        this._console.log = console.log;
        if (debug != null && typeof debug.getConsoleLog == 'function') {
            
            this._console.log = debug.getConsoleLog();
            
        }
        
        this._clock = 24;
    	this._i18n = null;
    	this._stopToCreateCalendar = false;
    	this._startOfWeek = parseInt(startOfWeek);
        if (typeof i18n == 'object') {
            
            this._i18n = i18n;
            
        }
    	
    	this._weekClassName = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
    	//this.setWeekNameList(weekName);
    	this._weekName = weekName;
    	if (dateFormat != null) {
    	    
    	    this._dateFormat = dateFormat;
    	    
    	} else {
    	    
    	    this._dateFormat = 0;
    	    
    	}
    	
    	if (positionOfWeek == null) {
    	    
    	    this._positionOfWeek = "before";
    	    
    	} else {
    	    
    	    this._positionOfWeek = positionOfWeek;
    	    
    	}
    	
    	if (positionTimeDate == null) {
    	    
    	    this._positionTimeDate = "dateTime";
    	    
    	} else {
    	    
    	    this._positionTimeDate = positionTimeDate;
    	    
    	}
    	
    	this._shortWeekNameBool = false;
    	
    	
    }
    
    Booking_App_Calendar.prototype.setClock = function(clock) {
        
        this._clock = clock;
        
    }
    
    Booking_App_Calendar.prototype.setStopToCreateCalendar = function(bool){
        
        this._stopToCreateCalendar = bool;
        
    }
	
	Booking_App_Calendar.prototype.setShortWeekNameBool = function(bool){
	    
	    this._shortWeekNameBool = bool;
	    
	}
	
	Booking_App_Calendar.prototype.setWeekNameList = function(weekName){
	    
	    this._weekName = weekName;
	    
	}
	
	Booking_App_Calendar.prototype.getWeekNameList = function(startOfWeek){
	    
	    var object = this;
	    var weekClassName = []
	    var weekName = [];
	    for (var i = 0; i < this._weekName.length; i++) {
	        
	        weekClassName[i] = this._weekClassName[i];
	        weekName[i] = this._weekName[i];
	        
	    }
	    //Object.assign(weekName, this._weekName);
	    for (var i = 0; i < startOfWeek; i++) {
	        
	        weekClassName.push(weekClassName[i]);
	        weekName.push(weekName[i]);
	        
	    }
	    
	    for (var i = 0; i < startOfWeek; i++) {
	        
	        weekClassName.shift();
	        weekName.shift();
	        
	    }
	    
	    object._console.log(weekName);
	    return {weekName: weekName, weekClassName: weekClassName};
	    
	}
	
	Booking_App_Calendar.prototype.create = function(calendarPanel, calendarData, month, day, year, permission, callback){
	    
	    var object = this;
	    var dayHeight = parseInt(calendarPanel.clientWidth / 7);
	    var nationalHoliday = {};
	    if (calendarData.nationalHoliday != null && calendarData.nationalHoliday.calendar) {
	        
	        nationalHoliday = calendarData.nationalHoliday.calendar;
	        
	    }
	    
	    
	    var weekNamePanel = document.createElement("div");
	    weekNamePanel.setAttribute("class", "calendar");
	    //var weekName = this.getWeekNameList(this._startOfWeek);
	    var getWeekNameList = this.getWeekNameList(this._startOfWeek);
	    var weekName = getWeekNameList.weekName;
	    var weekClassName = getWeekNameList.weekClassName;
	    for (var i = 0; i < 7; i++) {
	  	
            var dayPanel = document.createElement("div");
            dayPanel.setAttribute("class", "dayPanel " + weekClassName[i].toLowerCase());
            dayPanel.textContent = this._i18n.get(weekName[i]);
            weekNamePanel.insertAdjacentElement("beforeend", dayPanel);
            if (i == 6) {
                
                dayPanel.setAttribute("style", "border-width: 1px 1px 0px 1px;")
	            
            }
        }
        
	    calendarPanel.insertAdjacentElement("beforeend", weekNamePanel);
	    
	    if (calendarData['date']['lastDay'] == null || calendarData['date']['startWeek'] == null || calendarData['date']['lastWeek'] == null) {
	        
	        window.alert("There is not enough information to create a calendar.");
	        return null;
	        
	    }
        
        var lastDay = parseInt(calendarData['date']['lastDay']);
        var startWeek = parseInt(calendarData['date']['startWeek']);
        var lastWeek = parseInt(calendarData['date']['lastWeek']);
        
        var weekCount = 0;
        var calendar = calendarData.calendar;
        var scheduleList = calendarData.schedule;
        
        var weekLine = Object.keys(calendar).length / 7;
        object._console.log(calendarData);
        object._console.log(calendar);
        var index = 0;
        for (var key in calendar) {
            var className = 'dayPanel dayPanelHeight';
            var dataKey = parseInt(calendar[key].year + ("0" + calendar[key].month).slice(-2) + ("0" + calendar[key].day).slice(-2));
            var bool = 1;
            
            var textPanel = document.createElement("div");
            textPanel.setAttribute("class", "dayPostion");
            textPanel.textContent = calendar[key].day;
            
            var dayPanel = document.createElement("div");
            dayPanel.id = "booking-package-day-" + index;
            //dayPanel.classList.add(weekName[parseInt(calendar[key].week)]);
            dayPanel.setAttribute("data-select", 1);
            dayPanel.setAttribute("data-day", calendar[key].day);
            dayPanel.setAttribute("data-month", calendar[key].month);
            dayPanel.setAttribute("data-year", calendar[key].year);
            dayPanel.setAttribute("data-key", key);
            dayPanel.setAttribute("data-week", weekCount);
            if (calendar[key].week != null) {
                
                dayPanel.setAttribute("data-week", calendar[key].week);
                
            }
            
            dayPanel.setAttribute("class", className);
            dayPanel.classList.add(weekName[parseInt(calendar[key].week)]);
            dayPanel.insertAdjacentElement("beforeend", textPanel);
            weekNamePanel.insertAdjacentElement("beforeend", dayPanel);
            
            var data = {key: dataKey, week: parseInt(calendar[key].week), month: calendar[key].month, day: calendar[key].day, year: calendar[key].year, eventPanel: dayPanel, status: true, count: i, bool: bool, index: index};
            
            if (calendar[dataKey].status != null) {
                
                data.status = calendar[dataKey].status;
                
            }
            
            if (scheduleList != null) {
                
                (function(data, schedule){
                    
                    var capacity = 0;
                    var remainder = 0;
                    for (var key in schedule) {
                        
                        capacity += parseInt(schedule[key].capacity);
                        remainder += parseInt(schedule[key].remainder);
                        
                    }
                    
                    data.capacity = capacity;
                    data.remainder = remainder;
                    
                })(data, scheduleList[key]);
                
            }
            
            if (this._stopToCreateCalendar == true) {
                
                break;
                
            }
            
            if (calendarData.calendar[dataKey] != null || (calendarData.reservation != null && calendarData.reservation[dataKey])) {
                
                var weekClass = "";
                if (calendar[key].week != null) {
                    
                    weekClass = this._weekClassName[parseInt(calendar[key].week)].toLowerCase()
                    
                }
                
                if (nationalHoliday[key] != null && parseInt(nationalHoliday[key].status) == 1) {
                    
                    weekClass += " nationalHoliday";
                    
                }
                
                dayPanel.setAttribute("class", "dayPanel dayPanelHeight pointer " + weekClass);
                
                if (parseInt(weekLine) == 1) {
                    
                    dayPanel.setAttribute("class", "border_bottom_width dayPanel dayPanelHeight pointer " + weekClass);
                    
                }
                
                data.status = true;
                if (calendar[dataKey].status != null) {
                    
                    data.status = calendar[dataKey].status;
                    
                }
                callback(data);
                
            } else {
                
                dayPanel.setAttribute("class", "dayPanel dayPanelHeight closeDay");
                
                if (parseInt(weekLine) == 1) {
                    
                    dayPanel.setAttribute("class", "border_bottom_width dayPanel dayPanelHeight closeDay");
                    
                }
                
                data.status = false;
                if (calendar[dataKey].status != null) {
                    
                    data.status = calendar[dataKey].status;
                    
                }
                callback(data);
                
            }
            
            if (weekCount == 6) {
                
                //dayPanel.setAttribute("style", "border-width: 1px 1px 0px 1px; height: " + dayHeight + "px;");
                var style = dayPanel.getAttribute("style");
                if (style == null) {
                    
                    style = "";
                    
                }
                dayPanel.setAttribute("style", style + "border-width: 1px 1px 0px 1px;");
                
            }
            
            if (weekCount == 6) {
                	
                weekCount = 0;
                weekLine--;
                
            } else {
                
                weekCount++;
                
            }
            
            index++;
            
        }
        
        return true;
        
    }
    
    Booking_App_Calendar.prototype.getExpressionsCheck = function(expressionsCheck){
        
        /**
        var i18n = new I18n(this._i18n._locale);
        i18n.setDictionary(this._i18n._dictionary);
        **/
        var response = {
            arrival: this._i18n.get("Arrival (Check-in)"), 
            chooseArrival: this._i18n.get("Please choose %s", [this._i18n.get("Arrival (Check-in)")]),
            departure: this._i18n.get("Departure (Check-out)"),
            chooseDeparture: this._i18n.get("Please choose %s", [this._i18n.get("Departure (Check-out)")]),
        
        };
        
        if (expressionsCheck == 1) {
            
            response.arrival = this._i18n.get("Arrival");
            response.departure = this._i18n.get("Departure");
            response.chooseArrival = this._i18n.get("Please choose %s", [response.arrival]);
            response.chooseDeparture = this._i18n.get("Please choose %s", [response.departure]);
            
        } else if (expressionsCheck == 2) {
            
            response.arrival = this._i18n.get("Check-in");
            response.departure = this._i18n.get("Check-out");
            response.chooseArrival = this._i18n.get("Please choose %s", [response.arrival]);
            response.chooseDeparture = this._i18n.get("Please choose %s", [response.departure]);
            
        }
        
        return response;
        
    }
    
    Booking_App_Calendar.prototype.getDateKey = function(month, day, year){
        
        var key = year + ("0" + month).slice(-2) + ("0" + day).slice(-2);
        return key;
        
    }
    
	Booking_App_Calendar.prototype.formatBookingDate = function(month, day, year, hour, min, title, week, responseType){
        
        var object = this;
        var i18n = this._i18n;
        var dateFormat = this._dateFormat;
        var print_am_pm = "";
        if (typeof title == "string") {
            
            title = title.replace(/\\/g, "");
            
        }
        object._console.log("dateFormat = " + dateFormat + " month = " + month + " day = " + day + " year = " + year + " hour = " + hour + " min = " + min + " week = " + week);
        if (month != null) {
            
            month = ("0" + month).slice(-2);
            
        }
        
        if (day != null) {
            
            day = ("0" + day).slice(-2);
            
        }
        
        if (hour != null) {
            
            if (object._clock == "12a.m.p.m") {
                
                print_am_pm = " a.m.";
                if (hour > 12) {
                    
                    print_am_pm = " p.m.";
                    hour -= 12;
                    
                } else if (hour == 12) {
                    
                    print_am_pm = " p.m.";
                    hour = 12;
                    
                } else if (hour == 0) {
                    
                    hour = 12;
                    
                }
                
            } else if (object._clock == "12ampm") {
                
                print_am_pm = " am";
                if (hour > 12) {
                    
                    print_am_pm = " pm";
                    hour -= 12;
                    
                } else if (hour == 12) {
                    
                    print_am_pm = " pm";
                    hour = 12;
                    
                } else if (hour == 0) {
                    
                    hour = 12;
                    
                }
                
            } else if (object._clock == "12AMPM") {
                
                print_am_pm = " AM";
                if (hour > 12) {
                    
                    print_am_pm = " PM";
                    hour -= 12;
                    
                } else if (hour == 12) {
                    
                    print_am_pm = " PM";
                    hour = 12;
                    
                } else if (hour == 0) {
                    
                    hour = 12;
                    
                }
                
            }
            
            hour = ("0" + hour).slice(-2);
            
        }
        
        if (min != null) {
            
            min = ("0" + min).slice(-2);
            
        }
        
        if (week != null) {
            
            week = parseInt(week);
            
        }
        
        if (month != null && day == null && year == null) {
            
            date = month;
            if (dateFormat == 2 || dateFormat == 5 || dateFormat == 9 || dateFormat == 10 || dateFormat == 11  || dateFormat == 12) {
                
                var monthShortName = ['', i18n.get('Jan'), i18n.get('Feb'), i18n.get('Mar'), i18n.get('Apr'), i18n.get('May'), i18n.get('Jun'), i18n.get('Jul'), i18n.get('Aug'), i18n.get('Sep'), i18n.get('Oct'), i18n.get('Nov'), i18n.get('Dec')];
                date = monthShortName[parseInt(month)];
                
            }
            return date;
            
        }
        
        //var weekName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var weekName = [i18n.get('Sunday'), i18n.get('Monday'), i18n.get('Tuesday'), i18n.get('Wednesday'), i18n.get('Thursday'), i18n.get('Friday'), i18n.get('Saturday')];
        //weekName = this._weekName;
        if (this._shortWeekNameBool == true) {
            
            weekName = [i18n.get('Sun'), i18n.get('Mon'), i18n.get('Tue'), i18n.get('Wed'), i18n.get('Thu'), i18n.get('Fri'), i18n.get('Sat')];
            
        }
        var monthFullName = ['', i18n.get('January'), i18n.get('February'), i18n.get('March'), i18n.get('April'), i18n.get('May'), i18n.get('June'), i18n.get('July'), i18n.get('August'), i18n.get('September'), i18n.get('October'), i18n.get('November'), i18n.get('December')];
        var date = monthFullName[parseInt(month)] + " " + day + ", " + year + " ";
        
        if (dateFormat == 0) {
            
            date = month + "/" + day + "/" + year + " ";
            if (day == null) {
                
                date = month + "/" + year;
                
            }
            
        } else if (dateFormat == 1) {
            
            date = month + "-" + day + "-" + year + " ";
            if (day == null) {
                
                date = month + "-" + year;
                
            }
            
        } else if (dateFormat == 2) {
            
            date = monthFullName[parseInt(month)] + " " + day + ", " + year + "";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + ", " + year;
                
            }
            
        } else if (dateFormat == 3) {
            
            date = day + "/" + month + "/" + year + " ";
            if (day == null) {
                
                date = month + "/" + year;
                
            }
            
        } else if (dateFormat == 4) {
            
            date = day + "-" + month + "-" + year + " ";
            if (day == null) {
                
                date = month + "-" + year;
                
            }
            
        } else if (dateFormat == 5) {
            
            date = day + " " + monthFullName[parseInt(month)] + ", " + year + "";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + ", " + year;
                
            }
            
        } else if (dateFormat == 6) {
            
            date = year + "/" + month + "/" + day + " ";
            if (day == null) {
                
                date = year + "/" + month;
                
            }
            
        } else if (dateFormat == 7) {
            
            date = year + "-" + month + "-" + day + " ";
            if (day == null) {
                
                date = year + "-" + month;
                
            }
            
        } else if (dateFormat == 8) {
            
            date = day + "." + month + "." + year + " ";
            if (day == null) {
                
                date = month + "." + year;
                
            }
            
        } else if (dateFormat == 9) {
            
            date = day + "." + month + "." + year + " ";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + "." + year;
                
            }
            
        } else if (dateFormat == 10) {
            
            date = day + "." + monthFullName[parseInt(month)] + "." + year + " ";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + "." + year;
                
            }
            
        } else if (dateFormat == 11) {
            
            date = monthFullName[parseInt(month)] + " " + day + " " + year + "";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + " " + year;
                
            }
            
        } else if (dateFormat == 12) {
            
            date = day + " " + monthFullName[parseInt(month)] + " " + year + "";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + " " + year;
                
            }
            
        } else if (dateFormat == 13) {
            
            date = day + "." + month + "." + year + "";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + " " + year;
                
            }
            
        } else if (dateFormat == 14) {
            
            date = day + "." + monthFullName[parseInt(month)] + "." + year + "";
            if (day == null) {
                
                date = monthFullName[parseInt(month)] + " " + year;
                
            }
            
        } else if (dateFormat == 15) {
            
            date = year + "年" + month + "月" + day + "日 ";
            //date = year + i18n.get('Year') + month +  i18n.get('Month') + day +  i18n.get('Day') + ' ';
            if (day == null) {
                
                date = year + "年" + month + "月";
                //date = year + i18n.get('Year') + month + i18n.get('Month');
                
            }
            
        } else {
            
        }
        
        if (month == null && day != null && year == null) {
            
            date = day;
            
        }
        
        if (this._positionOfWeek == 'before') {
            
            if (dateFormat != 2 && week != null) {
                
                date = this._i18n.get(weekName[week]) + " " + date;
                
            } else if (dateFormat == 2 && week != null) {
                
                date = this._i18n.get(weekName[week]) + " " + date;
                
            }
            
        } else {
            
            if (dateFormat != 2 && week != null) {
                
                date = date + " " + this._i18n.get(weekName[week]) + "";
                
            } else if (dateFormat == 2 && week != null) {
                
                date = date + " " + this._i18n.get(weekName[week]) + "";
                
            }
            
        }
        
        if (responseType == 'elements') {
            
            var dateLabel = document.createElement('span');
            dateLabel.classList.add('bookingDate');
            dateLabel.textContent = date;
            var timeLabel = document.createElement('span');
            timeLabel.classList.add('bookingTime');
            timeLabel.textContent = i18n.get("%s:%s" + print_am_pm, [hour, min]);
            var bookingSubtitleLabel = document.createElement('span');
            bookingSubtitleLabel.classList.add('bookingSubtitle');
            if (title != null) {
                
                bookingSubtitleLabel.textContent = ' ' + title + ' ';
                
            }
            
            var bookingDateAndTime = document.createElement('div');
            if (object._positionTimeDate == 'dateTime') {
                
                dateLabel.textContent = date + ', '
                bookingDateAndTime.appendChild(dateLabel);
                bookingDateAndTime.appendChild(timeLabel);
                bookingDateAndTime.appendChild(bookingSubtitleLabel);
                
            } else {
                
                bookingDateAndTime.appendChild(timeLabel);
                bookingDateAndTime.appendChild(bookingSubtitleLabel);
                bookingSubtitleLabel.textContent = null;
                if (title != null && title.length > 0) {
                    
                    bookingSubtitleLabel.textContent = ' ' + title + ', ';
                    
                } else {
                    
                    bookingSubtitleLabel.textContent = ', '
                    
                }
                bookingDateAndTime.appendChild(dateLabel);
                
            }
            
            
            return {date: dateLabel, time: timeLabel, dateAndTime: bookingDateAndTime};
            
        } else {
            
            if (object._positionTimeDate == 'dateTime') {
                
                if (hour != null && min != null) {
                    
                    date += i18n.get(", %s:%s " + print_am_pm, [hour, min]);
                    
                }
                
                if (title != null) {
                    
                    date += title;
                    
                }
                
            } else {
                
                if (title != null && title.length > 0) {
                    
                    title = ' ' + title;
                    
                }
                
                if (hour != null && min != null) {
                    
                    date = i18n.get("%s:%s" + print_am_pm, [hour, min]) + title + ', ' + date;
                    
                }
                
            }
            
            
            
            return date;
            
        }
        
    }
	
	Booking_App_Calendar.prototype.getPrintTime = function(hour, min) {
	    
	    var object = this;
	    var time = hour + ":" + min;
	    if (object._clock == '12a.m.p.m') {
            
            hour = parseInt(hour);
            var print_am_pm = "a.m.";
            if (hour > 12) {
                
                print_am_pm = "p.m.";
                hour -= 12;
                
            } else if (hour == 12) {
                
                print_am_pm = "p.m.";
                hour = 12;
                
            } else if (hour == 0) {
                
                hour = 12;
                
            }
            
            hour = ("0" + hour).slice(-2);
            time = object._i18n.get("%s:%s " + print_am_pm, [hour, min]);
            
        } else if (object._clock == '12ampm') {
            
            hour = parseInt(hour);
            var print_am_pm = "am";
            if (hour > 12) {
                
                print_am_pm = "pm";
                hour -= 12;
                
            } else if (hour == 12) {
                
                print_am_pm = "pm";
                hour = 12;
                
            } else if (hour == 0) {
                
                hour = 12;
                
            }
            
            hour = ("0" + hour).slice(-2);
            time = object._i18n.get("%s:%s " + print_am_pm, [hour, min]);
            
        } else if (object._clock == '12AMPM') {
            
            hour = parseInt(hour);
            var print_am_pm = "AM";
            if (hour > 12) {
                
                print_am_pm = "PM";
                hour -= 12;
                
            } else if (hour == 12) {
                
                print_am_pm = "PM";
                hour = 12;
                
            } else if (hour == 0) {
                
                hour = 12;
                
            }
            
            hour = ("0" + hour).slice(-2);
            time = object._i18n.get("%s:%s " + print_am_pm, [hour, min]);
            
        }
        
	    object._console.log(time);
	    return time;
	    
	    
	}
	
    Booking_App_Calendar.prototype.adjustmentSchedules = function(calendarData, calendarKey, i, courseTime, rejectionTime, preparationTime){
        
        var object = this;
        (function(schedule, key, courseTime, rejectionTime, preparationTime, callback){
            
            object._console.log(key);
            var stopUnixTime = parseInt(schedule[key].unixTime);
            if (schedule[key].stop == 'false') {
                
                stopUnixTime += preparationTime * 60;
                
            }
            object._console.log("stopUnixTime = " + stopUnixTime);
            
            for(var i = 0; i < schedule.length; i++){
                
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
            
        })(calendarData['schedule'][calendarKey], i, courseTime, rejectionTime, preparationTime, function(key){
            
            object._console.log("callback key = " + key);
            calendarData['schedule'][calendarKey][key]["select"] = false;
            
        });
        
    }
    
    Booking_App_Calendar.prototype.holidayPanel = function(mode, holidayPanel, calendarPanel, month, year, regularHolidays, callback) {
        
        var object = this;
		object._console.log("holidayPanel");
		calendarPanel.textContent = null;
		calendarPanel.classList.remove("hidden_panel");
        holidayPanel.classList.remove("hidden_panel");
		
		var dayHeight = parseInt(calendarPanel.clientWidth / 7);
        object._console.log("dayHeight = " + dayHeight);
        
        var datePanel = document.createElement("div");
        datePanel.setAttribute("class", "calendarData");
        datePanel.textContent = object.formatBookingDate(month, null, year, null, null, null, null, 'text');
        object._console.log(year + "/" + month);
        
        var returnLabel = document.createElement("label");
        returnLabel.setAttribute("class", "arrowLeft");
        if (month == 1) {
            
            returnLabel.textContent = "＜" + object.formatBookingDate(12, null, null, null, null, null, null, 'text');
            
        } else {
            
            returnLabel.textContent = "＜" + object.formatBookingDate((month - 1), null, null, null, null, null, null, 'text');
            
        }
        
        var returnPanel = document.createElement("div");
        returnPanel.setAttribute("class", "calendarChangeButton");
        returnPanel.appendChild(returnLabel);
        
        var nextLabel = document.createElement("label");
        nextLabel.setAttribute("class", "arrowRight");
        if (month == 12) {
            
            nextLabel.textContent = object.formatBookingDate(1, null, null, null, null, null, null, 'text') + "＞";
            
        } else {
            
            nextLabel.textContent = object.formatBookingDate((month + 1), null, null, null, null, null, null, 'text') + "＞";
            
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
        
        object.create(calendarPanel, regularHolidays, month, 1, year, '', function(callbackOnDay){
			
			object._console.log(callbackOnDay);
			var key = callbackOnDay.key;
			var holiday = regularHolidays.calendar[key];
			if (parseInt(holiday.status) == 1) {
				
				callbackOnDay.eventPanel.classList.add("selectedDayPanel");
				
			}
			
			callbackOnDay.eventPanel.onclick = function(){
				
				var dayPanel = this;
				var key = dayPanel.getAttribute("data-key");
				var holiday = regularHolidays.calendar[key];
				object._console.log(key);
				object._console.log(regularHolidays.calendar);
				object._console.log(holiday);
				var postData = {mode: 'updateRegularHolidays', /**nonce: object._nonce, action: object._action,**/ accountKey: mode, day: holiday.day, month: holiday.month, year: holiday.year, month_calendar: regularHolidays.date.month, year_calendar: regularHolidays.date.year, status: 0};
				if (parseInt(holiday.status) == 0) {
					
					postData.status = 1;
					
				}
				object._console.log(postData);
				var loadingPanel = document.getElementById("loadingPanel");
				loadingPanel.classList.remove("hidden_panel");
                callback(postData, function(status, regularHolidays) {
                    
                    object._console.log(close);
                    if (status === true) {
                        
                        loadingPanel.classList.add("hidden_panel");
                        object.holidayPanel(mode, holidayPanel, calendarPanel, month, year, regularHolidays, callback);
                        
                    }
                    
                });
                
			};
			
        });
        
        returnLabel.onclick = function(){
            
            if (month == 1) {
                
                year--;
                month = 12;
                
            } else {
                
                month--;
                
            }
            
            var postData = {mode: 'getRegularHolidays', /**nonce: object._nonce, action: object._action,**/ accountKey: mode, month: month, year: year};
            var loadingPanel = document.getElementById("loadingPanel");
            loadingPanel.classList.remove("hidden_panel");
            callback(postData, function(status, regularHolidays) {
                
                object._console.log(close);
                if (status === true) {
                    
                    loadingPanel.classList.add("hidden_panel");
                    object.holidayPanel(mode, holidayPanel, calendarPanel, month, year, regularHolidays, callback);
                    
                }
                
			});
            	
        };
        
        nextLabel.onclick = function(){
            
            if (month == 12) {
                
                year++;
                month = 1;
                
            } else {
                
                month++;
                
            }
            
            var postData = {mode: 'getRegularHolidays', /**nonce: object._nonce, action: object._action,**/ accountKey: mode, month: month, year: year};
            var loadingPanel = document.getElementById("loadingPanel");
            loadingPanel.classList.remove("hidden_panel");
            callback(postData, function(status, regularHolidays) {
                
                object._console.log(close);
                if (status === true) {
                    
                    loadingPanel.classList.add("hidden_panel");
                    object.holidayPanel(mode, holidayPanel, calendarPanel, month, year, regularHolidays, callback);
                    
                }
                
			});
            
        };
        
    }
	
    function Booking_App_ObjectsControl(data, booking_package_dictionary) {
        
        this._data = data;
        this._prefix = data.prefix;
        this._debug = new Booking_Package_Console(data.debug);
        this._console = {};
        this._console.log = this._debug.getConsoleLog();
        this._console.error = this._debug.getConsoleError();
        this._i18n = new I18n(data.locale);
        this._i18n.setDictionary(booking_package_dictionary);
        this._services = data.courseList;
        this._nationalHoliday = {};
        this._weekName = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        this._calendar = new Booking_App_Calendar(this._weekName, this._data.dateFormat, this._data.positionOfWeek, this._data.positionTimeDate, this._data.startOfWeek, this._i18n, this._debug);
        this._expirationDate = 0;
        this._expirationDateForService = 0;
        
    };
    
    Booking_App_ObjectsControl.prototype.setServices = function(services) {
        
        this._services = services;
        
    };
    
    Booking_App_ObjectsControl.prototype.setExpirationDate = function(expirationDate) {
        
        this._expirationDate = expirationDate;
        
    };
    
    Booking_App_ObjectsControl.prototype.getExpirationDate = function() {
        
        return this._expirationDate;
        
    };
    
    Booking_App_ObjectsControl.prototype.setNationalHoliday = function(nationalHoliday) {
        
        this._nationalHoliday = nationalHoliday;
        
    };
    
    Booking_App_ObjectsControl.prototype.invalidService = function(schedules, bookedServices, service, durationTime) {
        
        var object = this;
        object._console.log('invalidServices');
        object._console.log(schedules);
        object._console.log(bookedServices);
        object._console.log(service);
        object._console.log(durationTime);
        
        if (service.stopServiceUnderFollowingConditions == "isNotEqual") {
            
            var startKey = 0;
            for (var i = 0; i < schedules.length; i++) {
                
                var schedule = schedules[i];
                //object._console.log(schedule);
                if (schedule.select == true && parseInt(schedule.remainder) >= 0) {
                    
                    if (service.stopServiceUnderFollowingConditions == "isNotEqual") {
                        
                        if (parseInt(schedule.capacity) != parseInt(schedule.remainder)) {
                            
                            schedule.select = false;
                            var startUnixTime = parseInt(schedule.unixTime) - (durationTime * 60);
                            var endUnixTime = parseInt(schedule.unixTime);
                            (function(schedules, startKey, endKey, startUnixTime, endUnixTime, service, callback) {
                                
                                object._console.log('startKey = ' + startKey);
                                object._console.log(schedules[startKey]);
                                object._console.log(startUnixTime);
                                object._console.log(endUnixTime);
                                if (startKey == null) {
                                    
                                    return false;
                                    
                                }
                                
                                for (var i = startKey; i < endKey; i++) {
                                    
                                    if (parseInt(schedules[i].unixTime) > startUnixTime && parseInt(schedules[i].unixTime) < endUnixTime) {
                                        
                                        object._console.log(schedules[i]);
                                        callback(i);
                                        
                                    }
                                    
                                }
                                
                            }) (schedules, startKey, i, startUnixTime, endUnixTime, service, function(key) {
                                
                                schedules[key].select = false;
                                
                            });
                            
                            startKey = null;
                            
                        } else {
                            
                            if (startKey == null) {
                                
                                startKey = i;
                                
                            }
                            
                        }
                        
                        if (service.stopServiceUnderFollowingConditions == "isNotEqual" && service.doNotStopServiceAsException == "sameServiceIsNotStopped") {
                            
                            var bookedServicesOnDay = bookedServices[parseInt(schedule.ymd)];
                            var time = ("0" + schedule.hour).slice(-2) + ("0" + schedule.min).slice(-2);
                            if (bookedServicesOnDay != null && bookedServicesOnDay[time] != null) {
                                
                                if (bookedServicesOnDay[time][service.key] != null && bookedServicesOnDay[time][service.key].count != null && parseInt(bookedServicesOnDay[time][service.key].count) > 0) {
                                    
                                    object._console.log("time = " + time);
                                    object._console.log(bookedServicesOnDay[time]);
                                    object._console.log(bookedServicesOnDay[time][service.key]);
                                    schedules[i].select = true;
                                    
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
            }
            
        } else if (service.stopServiceUnderFollowingConditions == "isEqual") {
            
            for (var i = 0; i < schedules.length; i++) {
                    
                var schedule = schedules[i];
                if (schedule.select == true && parseInt(schedule.remainder) >= 0) {
                    
                    if (parseInt(schedule.capacity) != parseInt(schedule.remainder)) {
                        
                        var time = ("0" + schedule.hour).slice(-2) + ("0" + schedule.min).slice(-2);
                        var startSec = (((parseInt(schedule.hour) * 60) + parseInt(schedule.min)) * 60) /** - (durationTime * 60) **/;
                        var endSec = (((parseInt(schedule.hour) * 60) + parseInt(schedule.min)) * 60) + (durationTime * 60);
                        object._console.log(schedule);
                        (function(schedules, time, service, startSec, endSec, callback) {
                            
                            object._console.log(time);
                            object._console.log(service);
                            object._console.log('startSec = ' + startSec);
                            object._console.log('endSec = ' + endSec);
                            var block = false;
                            var blockScedules = {};
                            for (var i = 0; i < schedules.length; i++) {
                                
                                var schedule = schedules[i];
                                var scheduleTime = ("0" + schedule.hour).slice(-2) + ("0" + schedule.min).slice(-2)
                                var sec = ((parseInt(schedule.hour) * 60) + parseInt(schedule.min)) * 60;
                                
                                if (sec >= startSec && sec < endSec) {
                                    
                                    blockScedules[i] = schedule;
                                    if (parseInt(schedule.capacity) == parseInt(schedule.remainder)) {
                                        
                                        block = true;
                                        break;
                                        
                                    }
                                    
                                }
                                
                            }
                            
                            if (block === true) {
                                
                                for (var key in blockScedules) {
                                    
                                    var schedule = blockScedules[key];
                                    object._console.log(schedule.hour + ' : ' + schedule.min);
                                    callback(key, false);
                                    
                                }
                                
                            }
                            
                        }) (schedules, time, service, startSec, endSec, function(key, bool) {
                            
                            schedules[key].select = bool;
                            
                        });
                        
                    } else {
                        
                        schedule.select = false;
                        
                    }
                    
                }
                    
            }
            /**
            for (var i = 0; i < schedules.length; i++) {
                
                var schedule = schedules[i];
                if (schedule.select === true) {
                    
                    object._console.error(schedule.hour + ' : ' + schedule.min);
                    
                }
                
            }
            **/
            
        } else if (service.stopServiceUnderFollowingConditions == "specifiedNumberOfTimes") {
            
            if (service.stopServiceForDayOfTimes == 'timeSlot') {
                
                for (var i = 0; i < schedules.length; i++) {
                    
                    var schedule = schedules[i];
                    if (schedule.select == true && parseInt(schedule.remainder) >= 0) {
                        
                        if (parseInt(schedule.capacity) != parseInt(schedule.remainder)) {
                            
                            var bookedServicesOnDay = bookedServices[parseInt(schedule.ymd)];
                            var time = ("0" + schedule.hour).slice(-2) + ("0" + schedule.min).slice(-2);
                            if (bookedServicesOnDay != null && bookedServicesOnDay[time] != null) {
                                
                                var bookedServicesTimes = bookedServicesOnDay[time];
                                object._console.error(bookedServicesTimes);
                                if (bookedServicesTimes[service.key] != null) {
                                    
                                    var startSec = (((parseInt(schedule.hour) * 60) + parseInt(schedule.min)) * 60) - (durationTime * 60);
                                    /**
                                    var startHour = Math.floor(startSec / 3600);
                                    var startMin = Math.floor(startSec % 3600 / 60);
                                    var startTime = ("0" + startHour).slice(-2) + ("0" + startMin).slice(-2);
                                    **/
                                    
                                    var endSec = (((parseInt(schedule.hour) * 60) + parseInt(schedule.min)) * 60) + (bookedServicesTimes[service.key].maximumDurationTime * 60);
                                    /**
                                    var endHour = Math.floor(endSec / 3600);
                                    var endMin = Math.floor(endSec % 3600 / 60);
                                    var endTime = ("0" + endHour).slice(-2) + ("0" + endMin).slice(-2);
                                    **/
                                    
                                    (function(schedules, time, service, bookedServicesTimes, startSec, endSec, callback) {
                                        
                                        object._console.log(time);
                                        object._console.log(service);
                                        object._console.log(bookedServicesTimes);
                                        object._console.log('startSec = ' + startSec);
                                        object._console.log('endSec = ' + endSec);
                                        for (var i = 0; i < schedules.length; i++) {
                                            
                                            var schedule = schedules[i];
                                            var scheduleTime = ("0" + schedule.hour).slice(-2) + ("0" + schedule.min).slice(-2)
                                            var sec = ((parseInt(schedule.hour) * 60) + parseInt(schedule.min)) * 60;
                                            if (sec > startSec && sec < endSec) {
                                                
                                                object._console.log(schedule.hour + ' : ' + schedule.min);
                                                if (scheduleTime == time && bookedServicesTimes.count < parseInt(service.stopServiceForSpecifiedNumberOfTimes)) {
                                                    
                                                    callback(i, true);
                                                    
                                                } else {
                                                    
                                                    callback(i, false);
                                                    
                                                }
                                                
                                            }
                                            
                                        }
                                        
                                    }) (schedules, time, service, bookedServicesTimes[service.key], startSec, endSec, function(key, bool) {
                                        
                                        schedules[key].select = bool;
                                        
                                    });
                                    
                                    object._console.log(bookedServicesOnDay);
                                    
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
            } else if (service.stopServiceForDayOfTimes == 'day') {
                
                var count = 0;
                var schedule = schedules[0];
                var bookedServicesOnDay = bookedServices[parseInt(schedule.ymd)];
                object._console.log(bookedServicesOnDay);
                for (var time in bookedServicesOnDay) {
                    
                    var bookedServices = bookedServicesOnDay[time];
                    if (bookedServices[parseInt(service.key)] != null) {
                        
                        count += bookedServices[parseInt(service.key)].count;
                        object._console.log(bookedServices[parseInt(service.key)]);
                        
                    }
                    
                }
                
                object._console.log('count = ' + count);
                if (count >= parseInt(service.stopServiceForSpecifiedNumberOfTimes)) {
                    
                    for (var i = 0; i < schedules.length; i++) {
                        
                        schedules[i].select = false;
                        
                    }
                    
                }
                
            }
            
        }
        
        return schedules;
        
    };
    
    Booking_App_ObjectsControl.prototype.validExpirationDate = function(expirationDate, expirationDateFrom, expirationDateTo, name) {
        
        var object = this;
        var isBooking = true;
        if (expirationDateFrom <= expirationDate) {
            
            object._console.error('1 expirationDateFrom = ' + expirationDateFrom + ' ' + name);
            
        }
        
        if (expirationDateTo <= expirationDate) {
            
            object._console.error('1 expirationDateTo = ' + expirationDateTo + ' ' + name);
            
        }
        
        if (expirationDateFrom >= expirationDate) {
            
            object._console.error('2 expirationDateFrom = ' + expirationDateFrom + ' ' + name);
            
        }
        
        if (expirationDateTo >= expirationDate) {
            
            object._console.error('2 expirationDateTo = ' + expirationDateTo + ' ' + name);
            
        }
        
        if (expirationDateFrom != 0 && expirationDateTo != 0 && ((expirationDateFrom <= expirationDate && expirationDateTo < expirationDate) || (expirationDateFrom > expirationDate && expirationDateTo >= expirationDate))) {
            
            isBooking = false;
            
        }
        
        return isBooking;
        
    };
    
    Booking_App_ObjectsControl.prototype.getSelectedBoxOfGuest = function(guestsList, selectBox) {
        
        var selectedGuestsKey = selectBox.parentElement.getAttribute("data-guset");
        var guests = guestsList[selectedGuestsKey];
        return guests;
        
    }
    
    Booking_App_ObjectsControl.prototype.getSelectedGuest = function(guestsList, selectBox, multipleApplicantCountList) {
        
        var object = this;
        object._console.log(selectBox);
        var selectedGuestsKey = selectBox.parentElement.getAttribute("data-guset");
        
        var index = parseInt(selectBox.selectedIndex);
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
        guests.number = parseInt(list[optionKey].number);
        if (guests.guestsInCapacity == 'included') {
            
            object._console.log(values[index]);
            object._console.log(list[optionKey]);
            multipleApplicantCountList[selectedGuestsKey] = parseInt(list[optionKey].number);
            
        }
        
        var multipleApplicantCount = multipleApplicantCountList.reduce(function(a, b) {
            
            return a + b;
            
        });
        
        return multipleApplicantCount;
        
    }
    
    Booking_App_ObjectsControl.prototype.verifyToLimitGuests = function(requestGuests, limitNumberOfGuests, type) {
        
        var object = this;
        object._console.log(requestGuests);
        object._console.log(limitNumberOfGuests);
        var response = {isGuests: true, errorMessage: null};
        if (type == 'day') {
            
            var minimumGuests = limitNumberOfGuests.minimumGuests;
            if (minimumGuests.enabled == 1 && minimumGuests.number > 0) {
                
                if (minimumGuests.included == 1 && minimumGuests.number > (requestGuests.requiredTotalNumberOfGuests + requestGuests.unrequiredTotalNumberOfGuests)) {
                    
                    response.isGuests = false;
                    response.errorMessage = object._i18n.get('The total number of people must be %s or more.', [minimumGuests.number]);
                    
                } else if (minimumGuests.number > requestGuests.requiredTotalNumberOfGuests) {
                    
                    response.isGuests = false;
                    response.errorMessage = object._i18n.get('The required total number of people must be %s or more.', [minimumGuests.number]);
                    
                }
                
                if (response.isGuests === false) {
                    
                    return response;
                    
                }
                
            }
            
            var maximumGuests = limitNumberOfGuests.maximumGuests;
            if (maximumGuests.enabled == 1 && maximumGuests.number > 0) {
                
                if (maximumGuests.included == 1 && maximumGuests.number < (requestGuests.requiredTotalNumberOfGuests + requestGuests.unrequiredTotalNumberOfGuests)) {
                    
                    response.isGuests = false;
                    response.errorMessage = object._i18n.get('The total number of people must be %s or less.', [maximumGuests.number]);
                    
                } else if (maximumGuests.number < requestGuests.requiredTotalNumberOfGuests) {
                    
                    response.isGuests = false;
                    response.errorMessage = object._i18n.get('The required total number of people must be %s or less.', [maximumGuests.number]);
                    
                }
                
            }
            
        }
        
        return response;
        
    };
    
    Booking_App_ObjectsControl.prototype.getCostsInService = function(service, guests, isGuests, isExtensionsValid) {
        
        var object = this;
        object._console.log(service);
        object._console.log('isGuests = ' + isGuests);
        var hasMultipleCosts = false;
        var hasReflectService = false;
        if (service.cost_1 == null) {
            
            service.cost_1 = service.cost;
            service.cost_2 = service.cost;
            service.cost_3 = service.cost;
            service.cost_4 = service.cost;
            service.cost_5 = service.cost;
            service.cost_6 = service.cost;
            
        }
        
        //var costs = [parseInt(service.cost_1), parseInt(service.cost_2), parseInt(service.cost_3), parseInt(service.cost_4), parseInt(service.cost_5), parseInt(service.cost_6)];
        var costsWithKey = {cost_1: parseInt(service.cost_1), cost_2: parseInt(service.cost_2), cost_3: parseInt(service.cost_3), cost_4: parseInt(service.cost_4), cost_5: parseInt(service.cost_5), cost_6: parseInt(service.cost_6)};
        var costs = [];
        if (isGuests == 1 && guests != null && guests.length > 0) {
            
            for (var key in guests) {
                
                var guest = guests[key];
                object._console.log(guest);
                var costInServices = guest.costInServices;
                if (costsWithKey[costInServices] != null && parseInt(guest.reflectService) == 1) {
                    
                    costs.push(costsWithKey[costInServices]);
                    
                }
                
                if (parseInt(guest.reflectService) == 1) {
                    
                    hasReflectService = true;
                    
                }
                
            }
            
        } else {
            
            costs.push(parseInt(service.cost_1));
            
        }
        
        if (hasReflectService === false) {
            
            costs.push(parseInt(service.cost_1));
            
        }
        
        object._console.log(costs);
        const arrayMax = function (a, b) {return Math.max(a, b);}
        const arrayMin = function (a, b) {return Math.min(a, b);}
        var max = costs.reduce(arrayMax);
        var min = costs.reduce(arrayMin);
        if (hasReflectService === false) {
            
            max = service.cost_1;
            min = service.cost_1;
            
        }
        
        /**
        if (min == 0) {
            
            var sortCosts = [parseInt(service.cost_1), parseInt(service.cost_2), parseInt(service.cost_3), parseInt(service.cost_4), parseInt(service.cost_5), parseInt(service.cost_6)];
            sortCosts.sort(function (a, b) {
                
                return a - b;
                
            });
            
            for (var i = 0; i < sortCosts.length; i++) {
                
                if (sortCosts[i] > 0) {
                    
                    min = sortCosts[i];
                    break;
                    
                }
                
            }
            
        }
        **/
        
        if (max != min && isExtensionsValid == 1) {
            
            hasMultipleCosts = true;
            
        }
        
        if (isExtensionsValid != 1) {
            
            max = costs[0];
            
        }
        
        var response = {hasMultipleCosts: hasMultipleCosts, max: max, min: min, costs: costs, costsWithKey: costsWithKey};
        return response;
        
    }
    
    Booking_App_ObjectsControl.prototype.getValueReflectGuests = function(guestsList) {
        
        var object = this;
        var costs = {cost_1: 0, cost_2: 0, cost_3: 0, cost_4: 0, cost_5: 0, cost_6: 0};
        var response = {totalNumberOfGuests: 0, requiredTotalNumberOfGuests: 0, unrequiredTotalNumberOfGuests: 0, reflectService: 0, reflectAdditional: 0, totalNumberOfGuestsTitle: 0, reflectServiceTitle: null, reflectAdditionalTitle: null, costs: costs};
        for (var key in guestsList) {
            
            var guest = guestsList[key];
            object._console.log(guest);
            if (guest.index != null) {
                
                //var selectBox = document.getElementById('booking_package_input_' + guest.id);
                //object._console.log(selectBox);
                var list = guest.json;
                if (typeof guest.json == 'string') {
                    
                    list = JSON.parse(guest.json);
                    
                }
                
                //var option = selectBox.options[guest.index];
                //object._console.log(option);
                //var index = parseInt(option.getAttribute('data-optionsKey'))
                var selected = list[guest.index];
                //var selected = list[index];
                object._console.log(selected);
                var costInServices = guest.costInServices;
                response.totalNumberOfGuests += parseInt(selected.number);
                if (parseInt(guest.required) == 1) {
                    
                    response.requiredTotalNumberOfGuests += parseInt(selected.number);
                    
                } else {
                    
                    response.unrequiredTotalNumberOfGuests += parseInt(selected.number);
                    
                }
                
                if (parseInt(guest.reflectService) == 1 && parseInt(selected.number) > 0) {
                    
                    response.reflectService += parseInt(selected.number);
                    response.costs[costInServices] += parseInt(selected.number);
                    
                }
                
                if (parseInt(guest.reflectAdditional) == 1 && parseInt(selected.number) > 0) {
                    
                    response.reflectAdditional += parseInt(selected.number);
                    
                }
                
            }
            
        }
        
        if (response.totalNumberOfGuests == 1) {
            
            response.totalNumberOfGuestsTitle = response.totalNumberOfGuests + ' ' + object._i18n.get('person');
            
        } else if (response.totalNumberOfGuests > 1) {
            
            response.totalNumberOfGuestsTitle = response.totalNumberOfGuests + ' ' + object._i18n.get('people');
            
        }
        
        if (response.reflectService == 1) {
            
            response.reflectServiceTitle = response.reflectService + ' ' + object._i18n.get('person');
            
        } else if (response.reflectService > 1) {
            
            response.reflectServiceTitle = response.reflectService + ' ' + object._i18n.get('people');
            
        }
        
        if (response.reflectAdditional == 1) {
            
            response.reflectAdditionalTitle = response.reflectAdditional + ' ' + object._i18n.get('person');
            
        } else if (response.reflectAdditional > 1) {
            
            response.reflectAdditionalTitle = response.reflectAdditional + ' ' + object._i18n.get('people');
            
        }
        
        if (response.reflectService == 0) {
            
            response.reflectService = 1;
            if (response.reflectService == 1) {
                
                response.reflectServiceTitle = response.reflectService + ' ' + object._i18n.get('person');
                
            } else if (response.reflectService > 1) {
                
                response.reflectServiceTitle = response.reflectService + ' ' + object._i18n.get('people');
                
            }
            
        }
        
        if (response.reflectAdditional == 0) {
            
            response.reflectAdditional = 1;
            if (response.reflectAdditional == 1) {
                
                response.reflectAdditionalTitle = response.reflectAdditional + ' ' + object._i18n.get('person');
                
            } else if (response.reflectAdditional > 1) {
                
                response.reflectAdditionalTitle = response.reflectAdditional + ' ' + object._i18n.get('people');
                
            }
            
        }
        
        return response;
        
    };
    
    Booking_App_ObjectsControl.prototype.validateServices = function(month, day, year, week, changeSelected, expiration) {
        
        var object = this;
        var isBooking = {status: true, services: {}};
        object._console.log('validateServices');
        object._console.error('expiration = ' + expiration);
        object._console.log(object._services);
        object._console.log('month = ' + month + ' day = ' + day + ' year = ' + year);
        if (month != null && day != null && year != null && week != null) {
            
            var calendarKey = object._calendar.getDateKey(month, day, year);
            object._console.log(object._nationalHoliday[calendarKey]);
            var nationalHoliday = false;
            if (object._nationalHoliday[calendarKey] != null && parseInt(object._nationalHoliday[calendarKey].status) == 1) {
                
                nationalHoliday = true;
                week = 7;
                
            }
            object._console.log('week = ' + week);
            
        } else {
            
            week = null;
            
        }

        //var expirationDate = year + ("0" + month).slice(-2) + ("0" + day).slice(-2);
        var expirationDate = object._calendar.getDateKey(month, day, year);
        if (typeof expirationDate == 'string') {
            
            expirationDate = parseInt(expirationDate);
            
        }
        object._console.log('expirationDate = ' + expirationDate);
        object.setExpirationDate(expirationDate);
        
        for (var key in object._services) {
            
            object._console.log(object._services[key]);
            object._services[key].closed = 0;
            /**
            object._services[key].service = 1;
            object._services[key].selected = 0;
            object._services[key].selectedOptionsList = [];
            **/
            var timeToProvide = object._services[key].timeToProvide;
            if (week != null && timeToProvide != null && 0 < timeToProvide.length) {
                
                object._console.log('week = ' + week);
                var times = timeToProvide[parseInt(week)];
                object._console.log(times);
                var closed = (function(times){
                    
                    var closed = 1;
                    for (var key in times) {
                        
                        var time = parseInt(times[key]);
                        if (time == 1) {
                            
                            closed = 0;
                            break;
                            
                        }
                        
                    }
                    
                    return closed;
                    
                })(times);
                object._services[key].closed = closed;
                object._console.log('closed = ' + closed);
                if (parseInt(object._services[key].selected) == 1 && closed == 1) {
                    
                    if (isBooking.status === true) {
                        
                        isBooking.status = false;
                        
                    }
                    isBooking.services[key] = object._services[key];
                    
                }
                
            }
            
            if (/**(expiration === true || parseInt(object._services[key].selected) == 1) && **/parseInt(object._services[key].expirationDateStatus) == 1) {
                
                var expirationDateFrom = parseInt(object._services[key].expirationDateFrom);
                var expirationDateTo = parseInt(object._services[key].expirationDateTo);
                var expirationDate = object.getExpirationDate();
                object._console.log(expirationDate);
                if (object._services[key].expirationDateTrigger != 'dateBooked') {
                    
                    
                    
                }
                
                if (object.validExpirationDate(expirationDate, expirationDateFrom, expirationDateTo, object._services[key].name) === false) {
                    
                    object._console.error(object._services[key]);
                    if (isBooking.status === true && (expiration === true || parseInt(object._services[key].selected) == 1)) {
                        
                        isBooking.status = false;
                        
                    }
                    object._services[key].closed = 1;
                    isBooking.services[key] = object._services[key];
                    
                }
                /**
                if (expirationDateFrom <= expirationDate) {
                    
                    object._console.error('1 expirationDateFrom = ' + expirationDateFrom + ' ' + object._services[key].name);
                    
                }
                
                if (expirationDateTo <= expirationDate) {
                    
                    object._console.error('1 expirationDateTo = ' + expirationDateTo + ' ' + object._services[key].name);
                    
                }
                
                if (expirationDateFrom >= expirationDate) {
                    
                    object._console.error('2 expirationDateFrom = ' + expirationDateFrom + ' ' + object._services[key].name);
                    
                }
                
                if (expirationDateTo >= expirationDate) {
                    
                    object._console.error('2 expirationDateTo = ' + expirationDateTo + ' ' + object._services[key].name);
                    
                }
                
                if (expirationDateFrom != 0 && expirationDateTo != 0 && ((expirationDateFrom <= expirationDate && expirationDateTo < expirationDate) || (expirationDateFrom > expirationDate && expirationDateTo >= expirationDate))) {
                    
                    object._console.error(object._services[key]);
                    if (isBooking.status === true && (expiration === true || parseInt(object._services[key].selected) == 1)) {
                        
                        isBooking.status = false;
                        
                    }
                    object._services[key].closed = 1;
                    isBooking.services[key] = object._services[key];
                    
                }
                **/
                
            }
            
        }
        
        if (isBooking.status === false && changeSelected === true) {
            
            for (var key in object._services) {
                
                object._services[key].selected = 0;
                var checkBox = document.getElementById('service_checkBox_' + key);
                if (checkBox != null) {
                    
                    checkBox.checked = false;
                    
                }
                
            }
            
        }
        
        return isBooking;
        
    };
    
    Booking_App_ObjectsControl.prototype.sendbookingVerificationCode = function(url, action, nonce, prefix, post, bookingVerificationCode, callback) {
        
        var object = this;
        if (bookingVerificationCode === true) {
            
            post.mode = prefix + 'sendVerificationCode';
            object._console.log(post);
            var bookingBlockPanel = document.getElementById("bookingBlockPanel");
            bookingBlockPanel.classList.remove("hidden_panel");
            new Booking_App_XMLHttp(url, post, false, function(response){
                
                object._console.log(response);
                bookingBlockPanel.classList.add("hidden_panel");
                if (response.status === true) {
                    
                    var verificationCodePanel = document.getElementById(prefix + 'verificationCodePanel');
                    verificationCodePanel.classList.remove('hidden_panel');
                    
                    var verificationCodeContent = document.getElementById(prefix + 'verificationCodeContent');
                    var inputCode = verificationCodeContent.getElementsByTagName('input')[0];
                    inputCode.value = null;
                    var sendButton = verificationCodeContent.getElementsByTagName('button')[0];
                    var address = verificationCodeContent.getElementsByClassName('address')[0];
                    address.textContent = response.notifications;
                    
                    sendButton.onclick = function() {
                        
                        var sendButton = this;
                        sendButton.disabled = true;
                        var verificationCode = inputCode.value;
                        object._console.log('onclick');
                        object._console.log(typeof verificationCode);
                        object._console.log(Number(verificationCode));
                        object._console.log(isNaN(Number(verificationCode)));
                        if (verificationCode.length == 6 && isNaN(Number(verificationCode)) === false) {
                            
                            var checkVerificationCodePost = {nonce: nonce, action: action, mode: prefix + 'checkVerificationCode', verificationCode: verificationCode};
                            object._console.log(post);
                            var bookingBlockPanel = document.getElementById("bookingBlockPanel");
                            bookingBlockPanel.classList.remove("hidden_panel");
                            new Booking_App_XMLHttp(url, checkVerificationCodePost, false, function(response) {
                                
                                object._console.log(response);
                                if (response.status === true) {
                                    
                                    verificationCodePanel.classList.add('hidden_panel');
                                    callback(true);
                                    
                                } else {
                                    
                                    window.alert(response.message);
                                    
                                }
                                sendButton.disabled = false;
                                bookingBlockPanel.classList.add("hidden_panel");
                                
                            });
                            
                        } else {
                            
                            sendButton.disabled = false;
                            
                        }
                        
                    };
                    
                } else {
                    
                    callback(false);
                    window.alert(response.message);
                    
                }
                
                
            });
            
        } else {
            
            callback(true);
            
        }
        
    };
    
    
    function FORMAT_COST(i18n, debug) {
    	
    	this._i18n = null;
        if(typeof i18n == 'object'){
            
            this._i18n = i18n;
            
        }
        
        this._console = {};
        this._console.log = console.log;
        if (debug != null && typeof debug.getConsoleLog == 'function') {
            
            this._console.log = debug.getConsoleLog();
            
        }
        
    }
	
	FORMAT_COST.prototype.formatCost = function(cost, currency){
        
        var object = this;
        var format = function(cost, symbol, currency){
            
            if (symbol == 'comma') {
                
                cost = String(cost).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
                
            } else {
                
                cost = String(cost).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1.');
                
            }
            
            //return new Intl.NumberFormat({ style: 'currency', currency: currency}).format(cost);
            return cost;
            
        }
        
        if (currency.toLocaleUpperCase() == 'USD') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "US$" + cost;
            
        } else if (currency.toLocaleUpperCase() == "EUR") {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "€" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'JPY') {
            
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "¥" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'TRY') {
            
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = cost + "₺";
            
        } else if (currency.toLocaleUpperCase() == 'KRW') {
            
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "₩" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'HUF') {
            
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "HUF " + cost;
            
        } else if (currency.toLocaleUpperCase() == 'DKK') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase()) + "kr";
            
        } else if (currency.toLocaleUpperCase() == "CNY") {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "CN¥" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'TWD') {
            
            cost = Number(cost) / 100;
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "NT$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'THB') {
            
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "TH฿" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'COP') {
            
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "COP" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'CAD') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'AUD') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'GBP') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "£" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'PHP') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "PHP " + cost;
            
        } else if (currency.toLocaleUpperCase() == 'CHF') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "CHF " + cost;
            
        } else if (currency.toLocaleUpperCase() == 'CZK') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "Kč" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'RUB') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = cost + "₽";
            
        } else if (currency.toLocaleUpperCase() == 'NZD') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "NZ$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'HRK') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = cost + " Kn";
            
        } else if (currency.toLocaleUpperCase() == 'UAH') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = cost + "грн.";
            
        } else if (currency.toLocaleUpperCase() == 'BRL') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = cost.replace('.', ',');
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "R$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'AED') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = cost.replace('.', ',');
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = cost + " AED";
            
        } else if (currency.toLocaleUpperCase() == 'GTQ') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "Q" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'MXN') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "$" + cost + " MXN";
            
        } else if (currency.toLocaleUpperCase() == 'ARS') {
            
            cost = format(cost, 'dot', currency.toLocaleUpperCase());
            cost = "$" + cost;
            
        } else if (currency.toLocaleUpperCase() == 'ZAR') {
            
            cost = Number(cost) / 100;
            cost = cost.toFixed(2);
            cost = format(cost, 'comma', currency.toLocaleUpperCase());
            cost = "R" + cost;
            
        }
        
        //new Intl.NumberFormat({ style: 'currency', currency: 'BRL' }).format(cost)
        
        object._console.log("currency = " + currency + " cost = " + cost);
        return cost;
        
    }
    
    function TAXES(i18n, currency, debug) {
        
        this._i18n = null;
        this._applicantCount = 1;
        this._currency = currency;
        this._taxes = [];
        this._visitorsDetails = {};
        this._servicesControl = null;
        if(typeof i18n == 'object'){
            
            this._i18n = i18n;
            
        }
        
        this._debug = null;
        this._console = {};
        this._console.log = console.log;
        if (debug != null && typeof debug.getConsoleLog == 'function') {
            
            this._debug = debug;
            this._console.log = debug.getConsoleLog();
            
        }
        
    };
    
    TAXES.prototype.setBooking_App_ObjectsControl = function(servicesControl) {
        
        this._servicesControl = servicesControl;
        
    };
    
    TAXES.prototype.setApplicantCount = function(applicantCount) {
        
        this._applicantCount = parseInt(applicantCount);
        this._console.log('_applicantCount = ' + this._applicantCount);
        
    };
    
    TAXES.prototype.setTaxes = function(taxes) {
        
        this._taxes = taxes;
        
    }
    
    TAXES.prototype.getTaxes = function() {
        
        return this._taxes;
        
    }
    
    TAXES.prototype.setVisitorsDetails = function(visitorsDetails) {
        
        this._visitorsDetails = visitorsDetails;
        
    }
    
    TAXES.prototype.getVisitorsDetails = function() {
        
        return this._visitorsDetails;
        
    }
    
    TAXES.prototype.getTaxValue = function(taxKey, type, visitorsDetails) {
        
        var object = this;
        object._console.log(visitorsDetails);
        var taxes = this._taxes;
        if (taxes[taxKey] == null) {
            
            return 0;
            
        } else {
            
            var tax = taxes[taxKey];
            var taxValue = 0;
            object._console.log(tax);
            var value = parseInt(tax.value);
            if (tax.method == 'multiplication') {
                
                value = parseFloat(tax.value);
                
            }
            
            object._console.log(value);
            
            if (type == 'day') {
                
                if (tax.method == 'multiplication') {
					
					taxValue =  (tax.value / 100) * visitorsDetails.amount;
					if (tax.tax == 'tax_inclusive') {
						
						taxValue = visitorsDetails.amount * (parseInt(tax.value) / (100 + parseInt(tax.value)));
						taxValue = Math.floor(taxValue);
						
					}
					tax.taxValue = parseInt(taxValue);
					
				} else {
					
					tax.taxValue = parseInt(tax.value);
					taxValue = parseInt(tax.value);
					
				}
                
            } else if (type == 'hotel') {
                
                var applicantCount = object._applicantCount;
                var person = 0;
                var additionalFee = 0;
                var personAmount = 0;
                var nights = visitorsDetails.nights;
                var rooms = visitorsDetails.rooms;
                for (var roomKey in visitorsDetails.rooms) {
                    
                    var room = visitorsDetails.rooms[roomKey];
                    person += room.person;
                    additionalFee += room.additionalFee;
                    personAmount += room.personAmount;
                    
                }
                object._console.log('personAmount = ' + personAmount);
                object._console.log('nights = ' + nights);
                if (parseInt(tax.expirationDateStatus) == 1 && typeof object._servicesControl.validExpirationDate == 'function') {
                    
                    if (tax.expirationDateTrigger != 'dateBooked') {
                        
                        
                        
                    } else {
                        
                        var count = 0;
                        var list = visitorsDetails.list;
                        for (var key in visitorsDetails.list) {
                            
                            var schedule = visitorsDetails.list[key];
                            object._console.log(schedule);
                            var expirationDate = parseInt(schedule.ymd);
                            var isBooking = object._servicesControl.validExpirationDate(expirationDate, parseInt(tax.expirationDateFrom), parseInt(tax.expirationDateTo), tax.name);
                            object._console.log(isBooking);
                            if (isBooking === false || parseInt(expirationDate) == 0) {
                                
                                count++;
                                object._console.log(schedule);
                                
                            }
                            
                        }
                        
                        if (nights == count) {
                            
                            applicantCount = 0;
                            
                        }
                        
                        nights -= count;
                        object._console.log('nights = ' + nights);
                        
                    }
                    
                }
                
                if (tax.target == 'room') {
                    
                    if (tax.scope == 'day') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = (nights * applicantCount) * value;
                            
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * ((visitorsDetails.amount * applicantCount) + (additionalFee * nights));
                            if (personAmount > 0) {
                                
                                taxValue =  (value / 100) * ((visitorsDetails.amount * applicantCount) + personAmount);
                                
                            }
                            
                            if (tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                                
                                var amount = 0;
                                for (var i in visitorsDetails.list) {
                                    
                                    amount += parseInt(visitorsDetails.list[i].cost) * applicantCount;
                                    
                                }
                                /**
                                if (visitorsDetails.additionalFee > 0) {
                                    
                                    taxValue = (amount + (additionalFee * nights)) * (value / (100 + value));
                                    
                                }
                                **/
                                taxValue = (amount + (additionalFee * nights)) * (value / (100 + value));
                                if (personAmount > 0) {
                                    
                                    taxValue = (amount + personAmount) * (value / (100 + value));
                                    
                                }
                                taxValue = Math.floor(taxValue);
                                
                            }
                            
                        }
                        
                    } else if (tax.scope == 'booking') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = applicantCount * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * applicantCount;
                            
                        }
                        
                    } else if (tax.scope == 'bookingEachGuests') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = (person * nights) * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * (person * nights);
                            
                        }
                        
                    }
                    
                    if (tax.method == 'addition' && tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                        
                        visitorsDetails.amount -= taxValue;
                        
                    }
                    
                } else if (tax.target == 'guest') {
                    
                    if (tax.scope == 'day') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = (nights * person) * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * additionalFee;
                            if (personAmount > 0) {
                                
                                taxValue =  (value / 100) * personAmount;
                                
                            }
                            
                            if (tax.type == 'tax' && tax.tax == 'tax_inclusive') {
                                
                                taxValue = additionalFee * (value / (100 + value));
                                if (personAmount > 0) {
                                    
                                    taxValue = personAmount * (value / (100 + value));
                                    
                                }
                                taxValue = Math.floor(taxValue);
                                
                            }
                            
                        }
                        
                    } else if (tax.scope == 'booking') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = 1 * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * 1;
                            
                        }
                        
                    } else if (tax.scope == 'bookingEachGuests') {
                        
                        if (tax.method == 'addition') {
                            
                            taxValue = (person * nights) * value;
                            
                        } else if (tax.method == 'multiplication') {
                            
                            taxValue =  (value / 100) * (person * nights);
                            
                        }
                        
                    }
                    
                }
                
            }
            
            return parseInt(taxValue);
            
        }
        
    }
    
    TAXES.prototype.reflectTaxesInTotalCost = function(responseTaxes, goodsList, applicantCount) {
        
        var deleteKeys = [];
        for (var key in goodsList) {
            
            var goods = goodsList[key];
            if (goods.type == 'tax' || goods.type == 'surcharge') {
                
                key = parseInt(key);
                deleteKeys.push(key);
                
            }
            
        }
        
        deleteKeys.sort(function(a, b) {
            
            return b - a;
            
        });
        
        for (var key in deleteKeys) {
            
            var deleteKey = deleteKeys[key];
            goodsList.splice(deleteKey, 1);
            
        }
        
        var totalCost = 0;
        for (var key in responseTaxes) {
            
            var tax = responseTaxes[key];
            if (tax.active != 'true' || tax.status == 0) {
                
                continue;
                
            }
            
            if ((tax.type == 'tax' && tax.tax == 'tax_exclusive') || tax.type == 'surcharge') {
                
                var cost = parseInt(tax.taxValue);
                var goods = {label: tax.name, amount: cost, applicantCount: 1, type: tax.type};
                if (tax.type == 'surcharge') {
                    
                    cost *= applicantCount;
                    goods = {label: tax.name, amount: cost, applicantCount: applicantCount, type: tax.type};
                    
                }
                totalCost += cost;
                goodsList.push(goods);
                
            }
            
        }
        
        /**
        for (var key in goodsList) {
            
            var goods = goodsList[key];
            console.log(goods);
            
        }
        **/
        
        return totalCost;
        
    }
    
    TAXES.prototype.taxesDetails = function(amount, formPanel, surchargePanel, taxePanel, reflectGuests) {
        
        var object = this;
        var isTaxes = false;
        object._console.log(typeof object._servicesControl);
        var expirationDate = object._servicesControl.getExpirationDate();
        object._console.log(expirationDate);
        object._console.log(reflectGuests);
        var reflectAdditional = 0;
        var reflectAdditionalTitle = null;
        if (reflectGuests != null) {
            
            reflectAdditional = reflectGuests.reflectAdditional;
            reflectAdditionalTitle = reflectGuests.reflectAdditionalTitle;
            object._console.log(reflectAdditional);
            object._console.log(reflectAdditionalTitle);
            
        }
        
        
        var currency = this._currency
        var taxes = this._taxes;
        object._console.log(taxes);
        var surchargeList = [];
        var taxList = [];
        var visitorsDetails = {amount: amount, additionalFee: 0, nights: 0, person: 0, list: []};
        for (var key in taxes) {
            
            var tax = taxes[key];
            tax.status = 1;
            if (tax.active != 'true') {
                
                continue;
                
            }
            
            if (parseInt(tax.expirationDateStatus) == 1 && typeof object._servicesControl.validExpirationDate == 'function') {
                
                if (tax.expirationDateTrigger != 'dateBooked') {
                    
                    
                    
                }
                
                var isBooking = object._servicesControl.validExpirationDate(expirationDate, parseInt(tax.expirationDateFrom), parseInt(tax.expirationDateTo), tax.name);
                object._console.log(isBooking);
                if (isBooking === false || parseInt(expirationDate) == 0) {
                    
                    tax.status = 0;
                    continue;
                    
                }
                
            }
            
            var taxValue = this.getTaxValue(key, 'day', visitorsDetails);
            object._console.log("name = " + tax.name + " taxValue = " + taxValue);
            if (tax.type == 'surcharge') {
                
                surchargeList.push(tax);
                
            } else {
                
                taxList.push(tax);
                
            }
            
        }
        
        var format = new FORMAT_COST(this._i18n, this._debug);
        if(surchargeList.length > 0 || taxList.length > 0) {
            
            var namePanel = surchargePanel.getElementsByClassName("name")[0];
            if(surchargeList.length > 0 && taxList.length > 0) {
                
                namePanel.textContent = this._i18n.get("Surcharge and Tax");
                namePanel.classList.add("surcharge_and_tax");
                
            } else if(surchargeList.length > 0 && taxList.length == 0) {
                
                namePanel.textContent = this._i18n.get("Surcharge");
                namePanel.classList.add("surcharge");
                
            } else if(surchargeList.length == 0 && taxList.length > 0) {
                
                namePanel.textContent = this._i18n.get("Tax");
                namePanel.classList.add("tax");
                
            }
            
            var valuePanel = surchargePanel.getElementsByClassName("value")[0];
            valuePanel.textContent = null;
            for (var i = 0; i < surchargeList.length; i++) {
                
                var surcharge = surchargeList[i];
                var nameSpan = document.createElement("span");
                nameSpan.classList.add("planName");
                nameSpan.textContent = surcharge.name;
                
                var costSpan = document.createElement("span");
                costSpan.classList.add("planPrice");
                if (parseInt(surcharge.taxValue) > 0) {
                    
                    costSpan.textContent = format.formatCost(surcharge.taxValue, currency);
                    
                }
                
                
                
                var reflectAdditionalPanel = document.createElement('span');
                if (reflectAdditional > 1) {
                    
                    //console.error(reflectAdditional);
                    reflectAdditionalPanel.classList.add('reflectPanel');
                    reflectAdditionalPanel.textContent = ' * ' + reflectAdditionalTitle;
                    
                }
                
                var addPanel = document.createElement("div");
                addPanel.classList.add("mainPlan");
                addPanel.appendChild(nameSpan);
                addPanel.appendChild(costSpan);
                addPanel.appendChild(reflectAdditionalPanel);
                valuePanel.appendChild(addPanel);
                
                //formPanel.appendChild(surchargePanel);
                isTaxes = true;
                
            }
            
            for (var i = 0; i < taxList.length; i++) {
                
                var surcharge = taxList[i];
                var nameSpan = document.createElement("span");
                nameSpan.classList.add("planName");
                nameSpan.textContent = surcharge.name;
                
                var costSpan = document.createElement("span");
                costSpan.classList.add("planPrice");
                if (parseInt(surcharge.taxValue) > 0) {
                    
                    costSpan.textContent = format.formatCost(surcharge.taxValue, currency);
                    
                }
                
                
                var addPanel = document.createElement("div");
                addPanel.classList.add("mainPlan");
                addPanel.appendChild(nameSpan);
                addPanel.appendChild(costSpan);
                valuePanel.appendChild(addPanel);
                //formPanel.appendChild(surchargePanel);
                isTaxes = true;
                
            }
            
        }
        
        return {isTaxes: isTaxes, surchargePanel: surchargePanel};
        
    }
    
    function Booking_Package_Console(debug) {
        
        this._debug = parseInt(debug);
        this._consoleExt = {};
        this._consoleExt.originalConsoleLog = console.log;
        this._console = {};
        this._console.log = console.log;
        this._console.error = console.error;
        if (this._debug == 0) {
            
            //console.log = function(message){};
            
        }
        
    }
    
    Booking_Package_Console.prototype.getConsoleLog = function() {
        
        if (this._debug == 0) {
            
            this._console.log = function(message){};
            
        }
        
        return this._console.log;
        
    }
    
    Booking_Package_Console.prototype.getConsoleError = function() {
        
        if (this._debug == 0) {
            
            this._console.error = function(message){};
            
        }
        
        return this._console.error;
        
    }
	
	