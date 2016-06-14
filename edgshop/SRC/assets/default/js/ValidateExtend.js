/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//-- validate.extend --//
    jQuery.validator.addMethod("ismobile", function(value, element) {  
     var length = value.length;
     var mobile = /(^13\d{9}$)|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17[6,7,8]\d{8}$)|(^18[0,1,2,5,6,7,8,9]\d{8}$)|(^14[5,7]\d{8}$)/g;
     return (length == 11 && mobile.exec(value))? true:false;
    }, "手机号码格式错误");
    
    //-- validate.extend --//
    jQuery.validator.addMethod("isphone", function(value, element) {  
        if(value.substring(0,1)=='0'){
            var pattern=/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/;
            return pattern.test(value);
        }
     var length = value.length;
     var mobile = /(^13\d{9}$)|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17[6,7,8]\d{8}$)|(^18[0,1,2,5,6,7,8,9]\d{8}$)|(^14[5,7]\d{8}$)/g;
     return (length == 11 && mobile.exec(value))? true:false;
    }, "电话号码格式错误");