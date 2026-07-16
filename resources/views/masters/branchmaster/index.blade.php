
<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Check Email Address</title>
    <script language="javascript">
        function checkEmail(inputvalue){
            var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            if(pattern.test(inputvalue)){
                alert("true");
            }else{
                alert("false");
            }
        }
    </script>
</head><body>
<form name="signupform">
    Input your email: <input name="email" type="text" class="inputs" id="email_address"
                             value="any@any.com" size="35" maxlength="255">
    <input name="summit" type="submit" value="Check" onClick="checkEmail(document.signupform.email.value)">
</form></body></html>