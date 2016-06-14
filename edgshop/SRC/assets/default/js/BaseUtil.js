/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
String.prototype.trim = function()
{
    //return this.replace(/[ ]/g,"");
    return this.replace(/(^\s*)|(\s*$)/g, "");
}

Number.prototype.toFixed = function(s)
{
    changenum=(parseInt(this * Math.pow( 10, s ) + 0.5)/ Math.pow( 10, s )).toString();
    index=changenum.indexOf(".");
    if(index<0&&s>0){
        changenum=changenum+".";
        for(i=0;i<s;i++){
            changenum=changenum+"0";
        }
    }else {
        index=changenum.length-index;
        for(i=0;i<(s-index)+1;i++){
            changenum=changenum+"0";
        }
    }
    return changenum;
}

String.prototype.substrcount = function(needle)
{
  var r=new RegExp(needle, "gi");
  return this.match(r).length;
} 

Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] == obj) {
            return true;
        }
    }
    return false;
}

/**
 * 时间对象的格式化;
 */
Date.prototype.format = function(format) {
    /*
     * eg:format="YYYY-MM-dd hh:mm:ss";
     */
    var o = {
        "M+" :this.getMonth() + 1, // month
        "d+" :this.getDate(), // day
        "h+" :this.getHours(), // hour
        "m+" :this.getMinutes(), // minute
        "s+" :this.getSeconds(), // second
        "q+" :Math.floor((this.getMonth() + 3) / 3), // quarter
        "S" :this.getMilliseconds()
    // millisecond
    };
    if (/(y+)/.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + "")
                .substr(4 - RegExp.$1.length));
    }

    for ( var k in o) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k]
                    : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;
}

String.prototype.toTime = function(format)
{
    /*
    * eg:format="YYYY-MM-dd hh:mm:ss";
    */
    var dt = Date.parse(this.replace(/-/g,"/"));
    var date = new Date(dt);
    return date.format(format || "yyyy-MM-dd hh:mm:ss");
}

Date.prototype.DateAdd = function(strInterval, Number)  
{   
    var dtTmp = this;
    strInterval = strInterval.toLowerCase();
    Number = Number * 1;
    switch (strInterval) {
        case 's' :return new Date(Date.parse(dtTmp) + (1000 * Number));   
        case 'n' :return new Date(Date.parse(dtTmp) + (60000 * Number));   
        case 'h' :return new Date(Date.parse(dtTmp) + (3600000 * Number));   
        case 'd' :return new Date(Date.parse(dtTmp) + (86400000 * Number));   
        case 'w' :return new Date(Date.parse(dtTmp) + ((86400000 * 7) * Number));   
        case 'q' :return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number*3, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());   
        case 'm' :return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());   
        case 'y' :return new Date((dtTmp.getFullYear() + Number), dtTmp.getMonth(), dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());   
    }
}

String.prototype.toDate = function()
{
    /*
    * eg:format="YYYY-MM-dd hh:mm:ss";
    */
    var dt = Date.parse(this.replace(/-/g,"/"));
    return new Date(dt);
}

BaseUtil = {
    //json length
    getJsonLength:function(jsonData){
        var jsonLength = 0;
        for(var item in jsonData){
            jsonLength++;
        }
        return jsonLength;
    },

   Checkall:function (e,name){
        var ck=$("input[name="+name+"]");
        var e = e || event;
        ck.each(function(){
           if($(this).val()!=''){
                $(this).attr("checked",e.checked?"checked":"");
                //$(this).attr("disabled",e.checked?"disabled":"");
           }
        });
    },

    CheckRadio:function(name,indexval){
        var list = $("input[name="+name+"]");
        list.each(function(){
            if($(this).val()==indexval){
                 $(this).attr("checked","checked");
                 return;
            }
        });
    },

    CheckListBox:function (name,arr){
        if(arr.length<1) return;
        var list = $("input[name="+name+"]");
        list.each(function(){
            if(arr.contains($(this).val())){
                 $(this).attr("checked","checked");
                 return;
            }
        });
    },
    
    InitSelect:function (obj, json, selectValue){
        var select = $(obj);
        var html = '';
        $.each(json, function(key, text){
            html += "<option value='"+key+"' ";
            if(key == selectValue){
                html += " selected='selected'";
            }
            html += ">"+text + "</option>";
        });
        select.html(html);
    },

    //验证数据范围
    NumberLimit:function (val,min,max,mode){
        if(val=="" || isNaN(val)){
            return true;
        }
        if (val<min || val>max){
            //alert("请输入正确的数据。");
            return false;
        }
        for (var i=0;i<val.length;i++){
            var ch = val.charAt(i);
            if ( (ch<"0" || ch>"9") ){
                //alert("数据必须由有效数字组成。");
                return false;
            }
        }
        if(parseInt(val)<=0){
            return false;
        }else if (mode===true && val.indexOf('0')==0){
            return false;
        }
        return true;
    },
    
    BMIvalidate:function(w,h){
        if(w>0 && h>0){
            var h = h/100;
            var bmi = w/(h*h);
            return 18.5<=bmi && bmi<24;
        }
        return false;
    },
    
    //常用正则验证
    validate:function(value,type){
        var regArr = {};
        regArr.email = /^([a-zA-Z0-9_-])+(.)+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/g;
        regArr.mobile = /(^13\d{9}$)|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17[6,7,8]\d{8}$)|(^18[0,1,2,5,6,7,8,9]\d{8}$)|(^14[5,7]\d{8}$)/g;
        regArr.passport = /^1[45][0-9]{7}|G[0-9]{8}|P[0-9]{7}|S[0-9]{7,8}|D[0-9]+$/g; //护照
        regArr.postcode = /^[0-9]{6}$/g;
        var reg =  regArr[type]||'';
        return value!='' && reg != '' && reg.test(value);
    },
 
    //起止时间比较
    isStartEndTime:function(startTime,endTime,startflag){   
        if(startTime.length>0 && endTime.length>0){
           var startDateTemp = startTime.split(" ");   
           var endDateTemp = endTime.split(" ");   
           var arrStartDate = startDateTemp[0].split("-");
           var arrEndDate = endDateTemp[0].split("-");   
           var arrStartTime = startDateTemp[1]?startDateTemp[1].split(":"):null;
           var arrEndTime = endDateTemp[1]?endDateTemp[1].split(":"):null;
           var allStartDate = new Date(arrStartDate[0],arrStartDate[1],arrStartDate[2],arrStartTime[0]||'00',arrStartTime[1]||'00',arrStartTime[2]||'00');   
           var allEndDate = new Date(arrEndDate[0],arrEndDate[1],arrEndDate[2],arrEndTime[0]||'00',arrEndTime[1]||'00',arrEndTime[2]||'00');
           if((startflag && allStartDate.getTime()>allEndDate.getTime()) || (!startflag && allStartDate.getTime()>=allEndDate.getTime())){
                return false;
           }
        }
        return true;   
    },

    //当前服务器的时间
    getServerTime:function(format){
         var xmlHttp = false;  
        //获取服务器时间  
        try {  
         xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");  
        } catch (e) {  
         try {  
          xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");  
         } catch (e2) {  
          xmlHttp = false;  
         }  
        }  

        if (!xmlHttp && typeof XMLHttpRequest != 'undefined') {  
         xmlHttp = new XMLHttpRequest();  
        }  
        var url = "http://"+location.host;
        xmlHttp.open("GET", url+"/null.txt", false);
        xmlHttp.setRequestHeader("Range", "bytes=-1");
        xmlHttp.send(null);  

        var severtime=new Date(xmlHttp.getResponseHeader("Date"));  
        var date = new Date(severtime);  
        var year = date.getFullYear();  
        var month = date.getMonth() + 1;
        var day = date.getDate();  
        var hour = date.getHours();  
        var minutes = date.getMinutes();  
        var second = date.getSeconds();  
        //alert(date + "  |  " + year + "年" + month + "月" + day + "日" + hour + "时" + minutes + "分" + second + "秒");
        var timestr = year + "-" + month + "-" + day + " " + hour + ":" + minutes + ":" + second;
        var ctime = timestr.replace(/-/g,'/'); //为了兼容IE
        var date = new Date(ctime);
        format = null!=format && format.length>0?format:"yyyy-MM-dd hh:mm:ss";
        return date.format(format);
    },
    
    difftime:function(startTime,toTime){
        var st = Date.parse(startTime.replace(/-/g,"/"));
        var tt = Date.parse(toTime.replace(/-/g,"/"));
        var stime = new Date(st);
        var ctime = new Date(tt);
        var difftime = stime - ctime;
        return difftime/1000;//秒
    },
    
    strtotime:function(str,format){
        var dt = Date.parse(str.replace(/-/g,"/"));
        var date = new Date(dt);
        format = null!=format && format.length>0?format:"yyyy-MM-dd hh:mm:ss";
        return date.format(format);
    },
    
    getDate:function(dates){
        var dd = new Date();
        dd.setDate(dd.getDate()+dates);
        var y = dd.getFullYear();
        var m = dd.getMonth()+1;
        var d = dd.getDate();
        return (y+"-"+m+"-"+d).toDate().format('yyyy-MM-dd');
    },
    
    //身份证号验证
    idCardNO:function(num){
        num = num.toUpperCase();
        //身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X。
        if (!(/(^\d{15}$)|(^\d{17}([0-9]|X|x)$)/.test(num)))
        {
            //alert('输入的身份证号长度不对，或者号码不符合规定！\n15位号码应全为数字，18位号码末位可以为数字或X。');
            return false;
        }
        //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
        //下面分别分析出生日期和校验位
        var len, re;
        len = num.length;
        if (len == 15)
        {
            re = new RegExp(/^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/);
            var arrSplit = num.match(re);

            //检查生日日期是否正确
            var dtmBirth = new Date('19' + arrSplit[2] + '/' + arrSplit[3] + '/' + arrSplit[4]);
            var bGoodDay;
            bGoodDay = (dtmBirth.getYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
            if (!bGoodDay)
            {
                //alert('输入的身份证号里出生日期不对！');
                return false;
            }
            else
            {
                //将15位身份证转成18位
                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                var nTemp = 0, i;
                num = num.substr(0, 6) + '19' + num.substr(6, num.length - 6);
                for(i = 0; i < 17; i ++)
                {
                    nTemp += num.substr(i, 1) * arrInt[i];
                }
                num += arrCh[nTemp % 11];
                return true;
            }
        }
        if (len == 18)
        {
            re = new RegExp(/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X|x)$/);
            var arrSplit = num.match(re);

            //检查生日日期是否正确
            var dtmBirth = new Date(arrSplit[2] + "/" + arrSplit[3] + "/" + arrSplit[4]);
            var bGoodDay;
            bGoodDay = (dtmBirth.getFullYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
            if (!bGoodDay)
            {
                //alert('输入的身份证号里出生日期不对！');
                return false;
            }
            else
            {
                //检验18位身份证的校验码是否正确。
                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                var valnum;
                var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                var nTemp = 0, i;
                for(i = 0; i < 17; i ++)
                {
                    nTemp += num.substr(i, 1) * arrInt[i];
                }
                valnum = arrCh[nTemp % 11];
                if (valnum != num.substr(17, 1))
                {
                    //alert('18位身份证的校验码不正确！应该为：' + valnum);
                    return false;
                }
                return true;
            }
        }
        return false;
    },
    //end validate fun

    getSerializeParams:function (params) {
        var result = {};  
        if(params==''){
            params = (window.location.search.split('?')[1] || '').split('&');
        }else{
            params = params.split('&');
        }
        for(var param in params) {  
            if (params.hasOwnProperty(param)) {  
                paramParts = params[param].split('=');  
                result[paramParts[0]] = decodeURIComponent(paramParts[1] || "");  
            }  
        }  
        return result;  
    },
    
        /*
    * 剩余字数统计
    * 注意 最大字数只需要在放数字的节点哪里直接写好即可 如：<var class="word">200</var>
    */
    statInputNum:function (textArea,numItem) {
        var max = numItem.text(),
            curLength;
        textArea[0].setAttribute("maxlength", max);
        curLength = textArea.val().length;
        numItem.text(max - curLength);
        textArea.on('input propertychange', function () {
            numItem.text(max - $(this).val().length);
        });
    }

//
};