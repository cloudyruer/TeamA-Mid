<?php
include __DIR__ . '/partials/init.php';
$title = '低調的title';

/*
// 錯誤的作法: 可能受到 SQL injection 攻擊
$sql = "INSERT INTO `address_book`(
               `name`, `email`, `mobile`,
               `birthday`, `address`, `created_at`
               ) VALUES (
                    '{$_POST['name']}', '{$_POST['email']}', '{$_POST['mobile']}',
                    '{$_POST['birthday']}', '{$_POST['address']}', NOW()
               )";

$stmt = $pdo->query($sql);
*/
$sql = "SELECT * FROM `members`  ORDER BY id DESC LIMIT 0 , 1";
$r = $pdo->query($sql)->fetch();

?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<style>
    form .form-group small {
        color: red;
    }

    .tying_container {
        height: 10vh;
        /*This part is important for centering*/
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .typing-demo {
        width: 90%;
        animation: typing 2s steps(22), blink .5s step-end infinite alternate;
        white-space: nowrap;
        overflow: hidden;
        border-right: 1px solid;
        font-family: monospace;
        font-size: 1rem;
    }

    @keyframes typing {
        from {
            width: 0
        }
    }

    @keyframes blink {
        50% {
            border-color: transparent
        }
    }
    input {
        box-shadow: 0 0 4px black;
    }
    .w-title {
        font-size: 1.5rem;
    }
</style>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <!-- <h5 class="card-title">註冊</h5> -->
                    <div class="tying_container">
                        <div class="typing-demo">
                            <span class="w-title">W</span>elcome to Group
                            <span class="w-title">A</span>，Let’s begin the adventure<span class="w-title">!</span>
                        </div>
                    </div>
                    <form name="form1" onsubmit="checkForm(); return false;">
                        <div class="form-group">
                            <label for="account">Account *</label>
                            <input type="text" class="form-control" id="account" name="account">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="password">password</label>
                            <input type="password" class="form-control mb-2" id="password" name="password">
                            <small class="form-text"></small>
                            <input type="checkbox" onclick="Password_Function()">   Show Password

                        </div>
                        <div class="form-group">
                            <label for="email">email *</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <small class="form-text "></small>
                        </div>
                        <!-- <div class="form-group">
                            <label for="avatar">avatar</label>
                            <input type="text" class="form-control" id="avatar" name="avatar">
                            <small class="form-text "></small>
                        </div> -->
                        <div class="form-group">
                            <label for="mobile">mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="address">address</label>
                            <input type="text" class="form-control" id="address" name="address">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="birthday">birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <label for="nickname">nickname</label>
                            <input type="text" class="form-control" id="nickname" name="nickname">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <!-- <label for="mem">nickname</label> -->
                            <input type="hidden" class="form-control" id="members_id" name="members_id" value="<?= htmlentities($r['id']) ?>">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <!-- <label for="mem">nickname</label> -->
                            <input type="hidden" class="form-control" id="orders_amount" name="orders_amount" value="0">
                            <small class="form-text "></small>
                        </div>
                        <div class="form-group">
                            <!-- <label for="mem">nickname</label> -->
                            <input type="hidden" class="form-control" id="ranking" name="ranking" value="1">
                            <small class="form-text "></small>
                        </div>
                        <button type="submit" class="btn btn-primary">註冊</button>
                        <div class="login mt-5">
                        已經有帳號了嗎？點<a href="./login.php">這裡</a>登入
                        </div>
                    </form>
                    


                </div>
            </div>
        </div>
    </div>


</div>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<script>

    const account_re = /^[a-zA-Z][a-zA-Z0-9_]{2,15}$/;
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;
    const password_re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/;

    const account = document.querySelector('#account');
    const email = document.querySelector('#email');
    const mobile = document.querySelector('#mobile');
    const password = document.querySelector('#password');



    function checkForm() {
        // 欄位的外觀要回復原來的狀態
        account.nextElementSibling.innerHTML = '';
        account.style.border = '1px #CCCCCC solid';
        email.nextElementSibling.innerHTML = '';
        email.style.border = '1px #CCCCCC solid';
        mobile.nextElementSibling.innerHTML = '';
        mobile.style.border = '1px #CCCCCC solid';
        password.nextElementSibling.innerHTML = '';
        password.style.border = '1px #CCCCCC solid';

        let isPass = true;

        if (!account_re.test(account.value)) {
            isPass = false;
            account.nextElementSibling.innerHTML = '帳號需字母開頭，長度在2-15之間，允許字母數字下劃線';
            account.style.border = '1px red solid';
        }
        // if (account.value.length < 2) {
        //     isPass = false;
        //     account.nextElementSibling.innerHTML = '請填寫正確的帳號名';
        //     account.style.border = '1px red solid';
        // }

        if (!email_re.test(email.value)) {
            isPass = false;
            email.nextElementSibling.innerHTML = '請填寫正確的 Email 格式';
            email.style.border = '1px red solid';
        }

        if (!mobile_re.test(mobile.value)) {
            isPass = false;
            mobile.nextElementSibling.innerHTML = '請填寫正確的 手機號碼 格式';
            mobile.style.border = '1px red solid';
        }
        if (!password_re.test(password.value)) {
            isPass = false;
            password.nextElementSibling.innerHTML = 
            '密碼必須包含大小寫字母和數字的組合，不能使用特殊字符，長度在6-15之間'
            password.style.border = '1px red solid';
        }

        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('002-tommy_signup-api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert('註冊成功，請重新登入')
                        location.href = 'login.php';
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error => {
                    console.log('error:', error);
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
<?php include __DIR__ . '/partials/html-foot.php'; ?>