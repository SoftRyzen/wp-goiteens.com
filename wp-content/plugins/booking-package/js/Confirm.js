    function Confirm(debug) {
        
        var object = this;
        this._console = {};
        this._console.log = console.log;
        if (debug != null && typeof debug.getConsoleLog == 'function') {
            
            this._console.log = debug.getConsoleLog();
            
        }
        
    }
    
    Confirm.prototype.alertPanelShow = function(subject, message, through, callback){
        
        var object = this;
        object._console.log("through = " + through);
        if(through === true && callback != null){
            
            callback(false);
            return null;
            
        }
        
        if(document.getElementById("dialogPanel") == null){
            
            var result = confirm(message);
            callback(result);
            
        }else{
            
            var dialogPanel = document.getElementById("dialogPanel");
            dialogPanel.classList.remove("hidden_panel");
            
            var subjectPanel = dialogPanel.getElementsByClassName("subject")[0];
            subjectPanel.textContent = subject;
            object._console.log(subjectPanel);
            
            var messagePanel = dialogPanel.getElementsByClassName("body")[0];
            messagePanel.textContent = message;
            
            var yesButton = document.getElementById("dialogButtonYes");
            yesButton.classList.remove("hidden_panel");
            yesButton.textContent = "OK";
            var noButton = document.getElementById("dialogButtonNo");
            noButton.classList.add("hidden_panel");
            
            var confirmPanel = dialogPanel.getElementsByClassName("confirmPanel")[0];
            var top = (window.innerHeight - confirmPanel.clientHeight) / 2;
            confirmPanel.style.top = top + "px";
            
            yesButton.removeEventListener("click", null);
            noButton.removeEventListener("click", null);
            yesButton.onclick = function(event){
                
                dialogPanel.classList.add("hidden_panel");
                yesButton.textContent = "Yes";
                noButton.classList.remove("hidden_panel");
                if(callback != null){
                    
                    callback(true);
                    
                }
                
            }
            
            noButton.onclick = function(event){
                
                dialogPanel.classList.add("hidden_panel");
                if(callback != null){
                    
                    callback(false);
                    
                }
                
            }
            
        }
        
    }
    
    Confirm.prototype.selectPanelShow = function(subject, list, position, through, callback){
        
        var object = this;
        object._console.log("through = " + through);
        object._console.log("position = " + position);
        if(through === true){
            
            callback(false);
            return null;
            
        }
        
        if(document.getElementById("dialogPanel") == null){
            
            //var result = confirm(message);
            //callback(result);
            
        }else{
            
            var dialogPanel = document.getElementById("dialogPanel");
            dialogPanel.classList.remove("hidden_panel");
            
            var subjectPanel = dialogPanel.getElementsByClassName("subject")[0];
            subjectPanel.textContent = subject;
            object._console.log(subjectPanel);
            
            var messagePanel = dialogPanel.getElementsByClassName("body")[0];
            messagePanel.textContent = null;
            
            for(var i = 0; i < list.length; i++){
                
                var selectPanel = list[i];
                var status = selectPanel.getAttribute("data-status");
                if (position.toUpperCase() != status) {
                    
                    messagePanel.appendChild(selectPanel);
                    selectPanel.onclick = function(){
                        
                        var panel = this;
                        var close = parseInt(panel.getAttribute("data-close"));
                        if (close == 0) {
                            
                            var status = panel.getAttribute("data-status");
                            object._console.log("status = " + status);
                            dialogPanel.classList.add("hidden_panel");
                            callback(status);
                            
                        } else {
                            
                            dialogPanel.classList.add("hidden_panel");
                            callback(false);
                            
                        }
                        
                    }
                    
                }
                
            }
            
            
            
            var yesButton = document.getElementById("dialogButtonYes");
            yesButton.classList.add("hidden_panel");
            var noButton = document.getElementById("dialogButtonNo");
            noButton.classList.add("hidden_panel");
            
            var confirmPanel = dialogPanel.getElementsByClassName("confirmPanel")[0];
            var top = (window.innerHeight - confirmPanel.clientHeight) / 2;
            confirmPanel.style.top = top + "px";
            
            yesButton.removeEventListener("click", null);
            noButton.removeEventListener("click", null);
            yesButton.onclick = function(event){
                
                dialogPanel.classList.add("hidden_panel");
                callback(true);
                
            }
            
            noButton.onclick = function(event){
                
                dialogPanel.classList.add("hidden_panel");
                callback(false);
                
            }
            
        }
        
    }
    
    Confirm.prototype.dialogPanelShow = function(subject, message, through, callback){
        
        //Send email notification to customer and admin about this operation?
        var object = this;
        object._console.log("through = " + through);
        if(through === true){
            
            callback(false);
            return null;
            
        }
        
        if(document.getElementById("dialogPanel") == null){
            
            var result = confirm(message);
            callback(result);
            
        }else{
            
            var dialogPanel = document.getElementById("dialogPanel");
            dialogPanel.classList.remove("hidden_panel");
            
            var subjectPanel = dialogPanel.getElementsByClassName("subject")[0];
            subjectPanel.textContent = subject;
            object._console.log(subjectPanel);
            
            var messagePanel = dialogPanel.getElementsByClassName("body")[0];
            messagePanel.textContent = message;
            
            var yesButton = document.getElementById("dialogButtonYes");
            yesButton.classList.remove("hidden_panel");
            var noButton = document.getElementById("dialogButtonNo");
            noButton.classList.remove("hidden_panel");
            
            var confirmPanel = dialogPanel.getElementsByClassName("confirmPanel")[0];
            var top = (window.innerHeight - confirmPanel.clientHeight) / 2;
            confirmPanel.style.top = top + "px";
            
            yesButton.removeEventListener("click", null);
            noButton.removeEventListener("click", null);
            yesButton.onclick = function(event){
                
                dialogPanel.classList.add("hidden_panel");
                callback(true);
                
            }
            
            noButton.onclick = function(event){
                
                dialogPanel.classList.add("hidden_panel");
                callback(false);
                
            }
            
        }
        
    }
    
    Confirm.prototype.selectListPanel = function(element, title, min, max, interval, horizontalRow, selectedKey, callback){
        
        var object = this;
        var rect = element.getBoundingClientRect();
        var selectedKey = parseInt(selectedKey);
        object._console.log(rect);
        object._console.log("top = " + rect.top + " left = " + rect.left);
        object._console.log("min = " + min + " max = " + max);
        object._console.log("width = " + element.clientWidth + " height = " + element.clientHeight);
        object._console.log("innerHeight = " + window.innerHeight);
        object._console.log("selectedKey = " + selectedKey);
        
        //var dialogPanel = document.getElementById("dialogPanel");
        var dialogPanel = document.getElementById("timeSelectPanel");
        dialogPanel.classList.remove("hidden_panel");
        
        var subjectPanel = dialogPanel.getElementsByClassName("subject")[0];
        subjectPanel.textContent = title;
        object._console.log(subjectPanel);
        
        var messagePanel = document.getElementById("confirm_body")
        //messagePanel.style.height = "300px";
        messagePanel.setAttribute("class", "selectSchedulePanel");
        messagePanel.textContent = null;
        
        var rowWidth = 0;
        var row = 0;
        var horizontalRowPanel = document.createElement("div");
        horizontalRowPanel.classList.add("horizontalRowPanel");
        messagePanel.appendChild(horizontalRowPanel);
        for(var i = min; i < max; i = i + interval){
            
            object._console.log("i = " + i);
            var rowPanel = document.createElement("div");
            //rowPanel.textContent = ("0" + i).slice(-2);
            rowPanel.classList.add("rowPanel");
            horizontalRowPanel.appendChild(rowPanel);
            
            var selectRowPanel = document.createElement("div");
            selectRowPanel.setAttribute("data-key", i);
            selectRowPanel.textContent = ("0" + i).slice(-2);
            if(i > 99){
                
                selectRowPanel.textContent = i;
                
            }
            
            if(i == selectedKey){
                
                selectRowPanel.classList.add("selectedRowPanel");
                
            }else{
                
                selectRowPanel.classList.add("selectRowPanel");
                
            }
            
            rowPanel.appendChild(selectRowPanel);
            row++;
            if(row == parseInt(horizontalRow)){
                
                rowWidth = rowPanel.clientWidth;
                row = 0;
                horizontalRowPanel = document.createElement("div");
                horizontalRowPanel.classList.add("horizontalRowPanel");
                messagePanel.appendChild(horizontalRowPanel);
                
            }
            
            selectRowPanel.onclick = function(){
                
                dialogPanel.classList.add("hidden_panel");
                var key = this.getAttribute("data-key");
                callback(key);
                
            }
            
        }
        
        object._console.log("rowWidth = " + rowWidth);
        
        for(var i = row; i < parseInt(horizontalRow); i++){
            
            var rowPanel = document.createElement("div");
            rowPanel.style.width = rowWidth + "px";
            rowPanel.classList.add("rowPanel");
            horizontalRowPanel.appendChild(rowPanel);
            
        }
        
        
        var selectPanelForConfirm = document.getElementById("selectPanelForConfirm");
        var panelHeight = selectPanelForConfirm.getBoundingClientRect().height;
        var panelWidth = selectPanelForConfirm.getBoundingClientRect().width;
        object._console.log("panelHeight = " + panelHeight + " panelWidth = " + panelWidth);
        
        var arrow = document.getElementById("arror");
        arrow.classList.add("arrowLeft");
        
        if((panelWidth + rect.left) > window.innerWidth){
            
            var left = rect.left - panelWidth - 10;
            selectPanelForConfirm.style.left = left + "px";
            arrow.setAttribute("class", "arrowRigth");
            
        }else{
            
            selectPanelForConfirm.style.left = (rect.left + rect.width + 10) + "px";
            arrow.setAttribute("class", "arrowLeft");
            
        }
        
        var magin_top = 30;
        var top = (rect.top - 34) + "px";
        var arrowTop = "38px";
        if((panelHeight + rect.top + 30) > window.innerHeight){
            
            magin_top = 49;
            top = (window.innerHeight - panelHeight - magin_top) + "px";
            arrowTop = ((panelHeight + rect.top + magin_top) - window.innerHeight) + "px";
            object._console.log("update top = " + top + " new top = " + ((panelHeight + rect.top) - window.innerHeight));
            
        }
        
        
        selectPanelForConfirm.style.top = top;
        arrow.style.top = arrowTop;
        //selectPanelForConfirm.classList.add("arrowLeft");
        
        
        
        
        
        
        var doneButton = document.getElementById("dialogButtonDone");
        doneButton.removeEventListener("click", null);
        doneButton.onclick = function(event){
            
            dialogPanel.classList.add("hidden_panel");
            callback("close");
            
        }
        
        var resetButton = document.getElementById("dialogButtonReset");
        resetButton.removeEventListener("click", null);
        resetButton.onclick = function(event){
            
            dialogPanel.classList.add("hidden_panel");
            callback("--");
            
        }
        
    }
    