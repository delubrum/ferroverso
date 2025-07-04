<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="robots" content="noindex">
    <title>Ferroverso</title>
    <link rel="icon" sizes="192x192" href="app/assets/img/logo.png" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="app/assets/css/login.css">
    <noscript>This Site requires JavaScript! Este sitio require JavaScript!
        <style>
        form {display:none;}
        </style>
    </noscript>
</head>

<body>

<div id="loading" style="display:none;pointer-events: none; position: absolute; z-index: 80; height: 100%; width: 100%; top: 0; left: 0; background-color: #f9fafb; text-align: center;">
  <div style="height: 100%; width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; margin: auto;">
    <div style="width: 6rem; height: 6rem; background-repeat: no-repeat; background-position: center; background-image: url('app/assets/img/loader.gif'); background-size: contain; opacity: 0.9;"></div>
  </div>
</div>
     
    <div class="container">
    <div class="img">
    <img src="app/assets/img/intro.png" alt="">
    </div>    
    <div class="login-container">
    <form method="post" id="login_form">
        <img src="app/assets/img/logo2.png" alt="" class="avatar" >
         <h2></h2>
          <div class="input-div one">
           <div class="i">
           <i class="ri-user-line" style="color:#333;font-weight:bold"></i>
        </div>
        <div>
            
            <input type="text" class="input" placeholder="Email" name="email" autofocus required>
        </div>
        </div>
        <div class="input-div two ">
          <div class="i">
            <i class="ri-eye-off-line eye show" style="cursor:pointer;color:#333;font-weight:bold"></i>
          </div>
        <div>
            
            <input type="password" class="input" placeholder="Password" name="pass" id="password">

        </div>

        </div>
        
        <input type="submit" class="btn" style="background:#000" value="Login">
        </form>
    </div>
    
    </div>
    <script>

document.addEventListener('submit', async (e) => {
    e.preventDefault();
    const loginForm = e.target;
    if (loginForm.checkValidity()) {
        $('#loading').show();
        try {
            const formData = new FormData(loginForm);
            const response = await fetch("?c=Home&a=Index&m=Index", {
                method: "POST",
                body: formData,
            });
            if (response.ok) {
                const data = await response.text();
                if (data.trim() !== 'ok') {
                    $('#loading').hide();
                    toastr.error('Error');
                    console.log('Error');
                } else {
                    window.location.href = '/';
                }
            }
        } catch (error) {
            $('#loading').hide();
            console.error("failed");
        }
    }
});

document.querySelector('.eye').addEventListener('click', e => {
    const passwordInput = document.querySelector('#password');
    if (e.target.classList.contains('show')) {
        e.target.classList.remove('show');
        e.target.classList.remove('ri-eye-off-line');
        e.target.classList.add('ri-eye-line');
        passwordInput.type = 'text';
    } else {
        e.target.classList.add('show');
        passwordInput.type = 'password';
        e.target.classList.remove('ri-eye-line');
        e.target.classList.add('ri-eye-off-line');
    }
});

</script>
</body>
</html>
