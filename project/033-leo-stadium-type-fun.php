<?php
include __DIR__ . '/partials/init.php';
$title = '新增設施類別';
$activeLi = 'leo';


//所有的賽別
$allSprtsCat = $pdo->query("SELECT * FROM stadiumType where `stadiumType`.`rank`=0")
    ->fetchAll();


?>

<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<!-- leo css -->
<?php include __DIR__ . '/033-leo-css.php'; ?>
<!-- leo nav -->
<ul class="nav nav-tabs mt-4 pl-5 pr-5">
    <li class="nav-item">
        <a class="nav-link" href="#">賽事類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">賽事</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">球場類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">球場</a>
    </li>
</ul>
<div id="container">
    <h1>新增設施類別</h1>
    <form class="editForm" name="form1" onsubmit="checkForm(); return false;">
        <div class="form-group">
            <label for="sports_type_cat">選擇運動類別</label>
            <select class="form-control" id="sports_type_cat" name="sports_type_cat">
                <option disabled selected>請選擇</option>
                <?php foreach ($allSprtsCat as $r) : ?>
                    <option value="<?= $r['sid'] ?>"><?= $r['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <small id="sports_type_cat_help" class="form-text text-muted"></small>
        </div>
        <div class="form-group">
            <label for="sports_type_game">新增設施類別</label>
            <input type="text" class="form-control" id="sports_type_game" name="sports_type_game" required placeholder="請輸入中文名稱">
            <small id="sports_type_game_help" class="form-text text-muted"></small>
        </div>
        <button type="submit" class="btn btn-primary">確認新增</button>
    </form>
</div>

<script>
    const sportsTypeCat = document.querySelector('#sports_type_cat');
    const sportsTypeGame = document.querySelector('#sports_type_game');

    function checkForm() {
        // 每次重新送出表單，欄位的外觀要回復原來的狀態
        sportsTypeCat.nextElementSibling.innerHTML = '';
        sportsTypeCat.style.border = '1px #CCCCCC solid';
        //代表可以送出表單
        let isPass = true;
        //送出表單（如果上述檢驗正確）
        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('033-leo-stadium-type-fun-createApi.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        location.href = '033-leo-stadium-type.php'; //如果api回傳true，就跳轉至首頁
                    } else {
                        alert(obj.error);
                    }
                })
                .catch(error => {
                    console.log('error:', error); //如果回傳出錯，就顯示在console
                });
        }
    }
</script>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<?php include __DIR__ . '/partials/html-foot.php'; ?>