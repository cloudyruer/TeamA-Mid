<?php
include __DIR__ . '/partials/init.php';
$title = '登入';

if (isset($_SESSION['user'])) {
    header('Location: index_.php'); // redirect, 直接跳轉到別的頁面
    exit;
}

?>
<?php include __DIR__ . '/partials/html-head.php';?>
<?php include __DIR__ . '/partials/navbar.php';?>
    <style>
        form .form-group small {
            color: red;
            display: none;
        }
        input {
        box-shadow: 0 0 3px black;
    }
    </style>
    <!-- NOTE change mt-3 -->
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">

            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">登入</h5>
                    <form name="form1" onsubmit="sendForm(); return false;">
                        <div class="form-group">
                            <label for="account">帳號</label>
                            <input type="text" class="form-control" id="account" name="account">
                            <small class="form-text">請填寫帳號</small>
                        </div>
                        <div class="form-group">
                            <label for="password">密碼</label>
                            <input type="password" class="form-control mb-2" id="password" name="password">
                            <small class="form-text">請填寫密碼</small>
                            <input type="checkbox" onclick="Password_Function()">   Show Password
                        </div>

                        <button type="submit" class="btn btn-primary">登入</button>
                        <!-- Tommy加的 -->
                        <div class="Tommy_login mt-5">
                            還沒有註冊嗎？點<a href="./002-tommy_signup.php">這裡</a>註冊
                        </div>
                        <!-- Tommy加的 -->
                    </form>
                </div>
            </div>

        </div>
    </div>



</div>
<?php include __DIR__ . '/partials/scripts.php';?>
<script>
    function sendForm(){
        let isPass = true;
        document.form1.account.nextElementSibling.style.display = 'none';
        document.form1.password.nextElementSibling.style.display = 'none';
        if(! document.form1.account.value){
            document.form1.account.nextElementSibling.style.display = 'block';
            isPass = false;
        }
        if(! document.form1.password.value){
            document.form1.password.nextElementSibling.style.display = 'block';
            isPass = false;
        }

        if(isPass) {
            const fd = new FormData(document.form1);

            fetch('login-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r=>r.json())
            .then(obj=>{
                console.log('result:', obj);
                if(obj.success){
                    location.href = 'index_.php'; // 跳轉到別的頁面
                } else {
                    alert(obj.error);
                }
            });
        }

    }

    function Password_Function() {
        var x = document.querySelector("#password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?php include __DIR__ . '/partials/html-foot.php';?>