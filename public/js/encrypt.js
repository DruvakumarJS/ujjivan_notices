$(document).ready(function(){
//alert('dg'); 
    
    $('#loginBtn').on('click',function(){
       // Initialize JSEncrypt object with the public key
        var publicKey = $('#publicKey').val();
        var password = $('#password').val();
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(publicKey);
        var encryptedData = encrypt.encrypt(password);
       // alert(encryptedData);
        var tkn = $('input[name="_token"]').val();
        var employeeId = $('#email').val();
       
       var data = {'_token':tkn, 'email':employeeId, 'password':encryptedData};
        
        $.ajax({
            url:'/login',
            type:'POST',
            data:data,
            success:function(data){
                
                if(data.status== '1'){
                    location.reload();
                }else if(data.status== '0'){
                    $('#invalidCred').css('display','block');
                    $('.invalid-feedback').removeClass('d-none');
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
                
               /* if(data.status== '2'){
                    $('.otp').show();
                    $('.login').hide();
                    $('#loginBtn').text('Validate OTP');
                    $('#otp').val(data.message);
                    decrementTimer();
                }
                else if(data.status== '3')
                {
                    $('#invalidCred').css('display','block');
                    $('#invalidCred').text('Invalid OTP');
                    $('.invalid-feedback').removeClass('d-none');
                }
                else if(data.status== '1'){
                    location.reload();
                }else if(data.status== '0'){
                    $('#invalidCred').css('display','block');
                    $('.invalid-feedback').removeClass('d-none');
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }*/
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
});