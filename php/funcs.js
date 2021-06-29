
src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"



        var validateEmail = function(){
            //if empty print no "error"
            if(document.getElementById('email').value==""){
                document.getElementById('valid-email').innerHTML = "";
                return false;
            }
            
            var re =/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (!re.test(document.getElementById('email').value)){
                //does not match with regular expr
                //invalid email
                document.getElementById('valid-email').style.color = 'red';
                document.getElementById('valid-email').innerHTML = "Invalid email!";
                return false;
            }else{
                document.getElementById('valid-email').innerHTML = "";
                return true;
            }
    
        }
        
        var check=function(){
            //if both empty print "no error"
            //else if both deleted after writing in inputs ...will print that they match without this check
            if(document.getElementById('password').value=="" && document.getElementById('password2').value==""){
                document.getElementById('message').innerHTML = '';
                return false;
            }
            //match
            if (document.getElementById('password').value ==  document.getElementById('password2').value && document.getElementById('password').value!="") {
                document.getElementById('message').innerHTML = '';
                return true;
                } 
            else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Not matching';
                return false;
                }

                
            
        }
        
        function check_reg_form()
        {
            //check if all inputs are filled and then enable submit
            var f = document.forms["form"].elements;
            var cansubmit = true;
            //console.log(f.length)
            for (var i = 0; i < f.length; i++) {
                if (f[i].value.length == 0) cansubmit = false;
            }

            if (cansubmit &&  check() && validateEmail()) {
                document.getElementById('signup').disabled = false;
            }
            else {
                document.getElementById('signup').disabled = 'disabled';
            }
        }
        
        function check_login_form()
        {
            //if all inputs are filled enable login button
            var f = document.forms["loginform"].elements;
            var cansubmit = true;
            //console.log(f.length)
            for (var i = 0; i < f.length; i++) {
                if (f[i].value.length == 0) cansubmit = false;
            }

            if (cansubmit) {
                document.getElementById("login").disabled = false;
            }
            else {
                document.getElementById("login").disabled = 'disabled';
            }
        }

        function validate_date(){
            //end date have to be bigger than start date 
            var start=Date.parse(document.getElementById('start').value);
            var end=Date.parse(document.getElementById('end').value);
            var dif=end-start;
            //console.log(dif);

                if(dif>=0 || isNaN(dif)){
                    document.getElementById('val_date').innerHTML="";
                    document.getElementById('submit').disabled=false;
                }else{
                    document.getElementById('val_date').innerHTML="End date must be greater than start date!";
                    document.getElementById('submit').disabled='disabled';
                }
            

        }

        function text2date(){
            //chech if selected type of search is date then search input "changes" to date input
            var x = document.getElementById("sel").value;
            //console.log(x);
            if(x=="startdate" || x=="enddate" || x=="date"){
                document.getElementById("qu").type='date';
            }else{
                document.getElementById("qu").type='search';
            }
        }
        
       