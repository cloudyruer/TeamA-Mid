<?php
include __DIR__ . '/partials/init.php';
$title = '賽事列表';
$activeLi = 'leo';

// leo 程式
// 搜尋功能 TODO:
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
if (!empty($keyword)) {
    header('Location: 033-leo-sports-game-search.php?keyword=' . $keyword);
    exit;
}


// 抓出本頁資料
//決定查看賽別，預設值為0
$sportsCat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

//所有的賽別
$allSprtsCat = $pdo->query("SELECT * FROM sportsType where `sportsType`.`rank`=0")
    ->fetchAll();

//用戶查看第幾頁，預設值為1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//每頁幾筆資料
$perpage = 5;

$howManyList = 0;
//算出總共總資料總共幾頁
if ($sportsCat == 0) {
    //全部的資料
    $howManyList = $pdo->query(" SELECT count(1),`sportsGame`.*, `sportsType`.`name`, `stadium`.`gymName`
    FROM `sportsGame`
    JOIN `sportsType`
    ON `sportsGame`.`gameName` = `sportsType`.`sid`
    JOIN `stadium`
    ON `sportsGame`.`gameStadium` = `stadium`.`sid`;")
        ->fetchAll(); //拿到總共幾筆資料的statement
} elseif ($sportsCat > 0) {
    //該賽別的資料
    $howManyList = $pdo->query("
    SELECT count(1),`sportsGame`.*, `sportsType`.`name`, `sportsType`.`rank`, `stadium`.`gymName`
    FROM `sportsType` 
    JOIN `sportsGame` 
    ON `sportsGame`.`gameName` = `sportsType`.`sid` 
    JOIN `stadium`
    ON `sportsGame`.`gameStadium` = `stadium`.`sid`
    where `rank`=$sportsCat")
        ->fetchAll(); //拿到總共幾筆資料的statement
}

$totalList = $howManyList[0]["count(1)"]; //拿到總共幾筆資料的值

//計算總共會需要多少頁面
$howManyPage = ceil($totalList / 5); //

//決定第幾頁要抓第幾筆至第幾筆
$rowLimitStart = ($page - 1) * $perpage; //每一頁第一筆

// 讓 $page 的值在安全的範圍，避免用戶點到第0頁，或是超過資料筆數的頁面
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
if ($page > $howManyPage) {
    header('Location: ?page=' . $howManyPage);
    exit;
}

//取出資料庫中的資料
if ($sportsCat == 0) {
    //全部的資料
    $rows = $pdo->query("SELECT `sportsGame`.*, `sportsType`.`name`, `stadium`.`gymName`
    FROM `sportsGame` 
    JOIN `sportsType`
    ON `sportsGame`.`gameName` = `sportsType`.`sid`
    JOIN `stadium`
    ON `sportsGame`.`gameStadium` = `stadium`.`sid`
    LIMIT $rowLimitStart,$perpage;")
        ->fetchAll();
} elseif ($sportsCat > 0) {
    //該賽別的資料
    $rows = $pdo->query("SELECT `sportsGame`.*, `sportsType`.`name`, `sportsType`.`rank`, `stadium`.`gymName`
    FROM `sportsType` 
    JOIN `sportsGame` 
    ON `sportsGame`.`gameName` = `sportsType`.`sid` 
    JOIN `stadium`
    ON `sportsGame`.`gameStadium` = `stadium`.`sid`
    where `rank`=$sportsCat LIMIT $rowLimitStart,$perpage")
        ->fetchAll();
}


?>
<?php include __DIR__ . '/partials/html-head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<!-- leo css -->
<?php include __DIR__ . '/033-leo-css.php'; ?>
<!-- leo nav -->
<ul class="nav nav-tabs mt-4 pl-5 pr-5">
    <li class="nav-item">
        <a class="nav-link" href="./033-leo-sports-type.php">賽事類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="./033-leo-sports-game.php">賽事</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="./033-leo-stadium-type.php">球場類別</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="./033-leo-stadium-list.php">球場</a>
    </li>
</ul>

<div id="container">
    <h1>賽事列表</h1>
    <div class="button_warp">
        <div>
            <a class="btn btn-primary" href="./033-leo-sports-game-create.php">新增賽事</a>
        </div>
        <div class="button_warp_search">
            <form>
                <input class="form-control" type="" placeholder="請輸入賽事關鍵字" name="keyword">
                <button type="submit" class="btn btn-secondary">搜尋</button>
            </form>
        </div>
    </div>
    <div class="typeWarp">
        <nav class="nav nav-pills">
            <a class="nav-link" id="type0" href="?cat=0&page=1">全部</a>
            <?php foreach ($allSprtsCat as $r) : ?>
                <a class="nav-link" id="type<?= $r['sid'] ?>" href="?cat=<?= $r['sid'] ?>&page=1"><?= $r['name'] ?></a>
            <?php endforeach; ?>
        </nav>
    </div>
    <table class="table table-striped">
        <thead class=" thead-dark">
            <tr>
                <th scope="col">盃賽名稱</th>
                <th scope="col">階段</th>
                <th scope="col">比賽時間</th>
                <th scope="col">對手</th>
                <th scope="col">比賽場地</th>
                <th scope="col">編輯</th>
                <th scope="col">刪除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['gameStatus'] ?></td>
                    <td><?= $r['gameTime'] ?></td>
                    <td><?= $r['player1'] ?> vs <?= $r['player2'] ?></td>
                    <td><?= $r['gymName'] ?></td>
                    <td><a class="btn btn-info" href="033-leo-sports-game-edit.php?sid=<?= $r['sid'] ?>">編輯</a></td>
                    <td><a href="033-leo-sports-game-deleteApi.php?sid=<?= $r['sid'] ?>" class="btn btn-danger">刪除</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&cat=<?= $sportsCat ?>">
                    <i class="fas fa-arrow-circle-left"></i>
                </a>
            </li>
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) : //產生迴圈多少頁數，且每一網頁只能產生前後幾筆
                if ($i >= 1 and $i <= $howManyPage) : ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&cat=<?= $sportsCat ?>"><?= $i ?></a>
                    </li>
            <?php endif;
            endfor; ?>
            <li class="page-item <?= $page >= $howManyPage ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&cat=<?= $sportsCat ?>">
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>
<script>
    //決定哪個賽別要加上active
    var pageCat = <?php echo $sportsCat ?>;
    var whichNeedActive = document.getElementById("type" + pageCat)
    whichNeedActive.classList += " active"
</script>
<?php include __DIR__ . '/partials/scripts.php'; ?>
<?php include __DIR__ . '/partials/html-foot.php'; ?>