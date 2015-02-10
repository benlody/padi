<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
	<div class="wrap">
		<?php

			if(Yii::$app->user->isGuest) {
				$items = [
					['label' => 'Home', 'url' => ['/site/index']],
					['label' => 'Login', 'url' => ['/site/login']],
				];
			} else if (Yii::$app->user->identity->group === User::GROUP_ADMIN){
				$items = [
					['label' => 'Home', 'url' => ['/site/index']],
					[
						'label' => '庫存',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">庫存</font></li>',
							 ['label' => '庫存明細', 'url' => ['/inventory/transaction']],
							 ['label' => '庫存總覽', 'url' => ['/inventory/overview']],
							 ['label' => '庫存調整', 'url' => ['/inventory/adjust']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">統計</font></li>',
							 ['label' => '工作項目統計', 'url' => ['/inventory/summary']],
						],
					],
					[
						'label' => '訂單',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">會員訂單</font></li>',
							 ['label' => '新增會員訂單', 'url' => ['/order/add']],
							 ['label' => '會員訂單列表', 'url' => ['/order/list', 'sort' => '-date']],
							 ['label' => '出貨明細', 'url' => ['/order/ship_overview']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">內部訂單/轉移</font></li>',
							 ['label' => '新增內部訂單', 'url' => ['/transfer/add']],
							 ['label' => '內部訂單列表', 'url' => ['/transfer/list', 'sort' => '-send_date']],
						],
					],
					[
						'label' => '生產',
						'items' => [
							 ['label' => '新增生產', 'url' => ['/purchase-order/add']],
							 ['label' => '生產列表', 'url' => ['/purchase-order/list', 'sort' => '-date']],
						],
					],
					[
						'label' => '產品與套裝',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">產品</font></li>',
							 ['label' => '產品列表', 'url' => ['/product/index']],
							 ['label' => '新增產品', 'url' => ['/product/create']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">套裝</font></li>',
							 ['label' => '套裝列表', 'url' => ['/crew-pak/index']],
							 ['label' => '新增套裝', 'url' => ['/crew-pak/add']],
						],
					],
					[
						'label' => 'PADI會員',
						'items' => [
							 ['label' => '會員列表', 'url' => ['/customer/index']],
							 ['label' => '新增會員', 'url' => ['/customer/create']],
						],
					],
					[
						'label' => '系統管理',
						'items' => [
							 ['label' => '新增帳號', 'url' => ['/site/signup']],
							 ['label' => '日誌', 'url' => ['/log/index']],
						],
					],
					['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
						'url' => ['/site/logout'],
						'linkOptions' => ['data-method' => 'post']
					],
				];
			} else if (Yii::$app->user->identity->group === User::GROUP_XM || Yii::$app->user->identity->group === User::GROUP_PADI){
				$items = [
					['label' => 'Home', 'url' => ['/site/index']],
					[
						'label' => '庫存',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">庫存</font></li>',
							 ['label' => '庫存明細', 'url' => ['/inventory/transaction']],
							 ['label' => '庫存總覽', 'url' => ['/inventory/overview']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">統計</font></li>',
							 ['label' => '工作項目統計', 'url' => ['/inventory/summary']],
						],
					],
					[
						'label' => '訂單',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">會員訂單</font></li>',
							 ['label' => '會員訂單列表', 'url' => ['/order/list', 'sort' => '-date']],
							 ['label' => '出貨明細', 'url' => ['/order/ship_overview']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">內部訂單/轉移</font></li>',
							 ['label' => '內部訂單列表', 'url' => ['/transfer/list', 'sort' => '-send_date']],
						],
					],
					[
						'label' => '生產',
						'items' => [
							 ['label' => '生產列表', 'url' => ['/purchase-order/list', 'sort' => '-date']],
						],
					],
					[
						'label' => '產品與套裝',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">產品</font></li>',
							 ['label' => '產品列表', 'url' => ['/product/index']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">套裝</font></li>',
							 ['label' => '套裝列表', 'url' => ['/crew-pak/index']],
						],
					],
					[
						'label' => 'PADI會員',
						'items' => [
							 ['label' => '會員列表', 'url' => ['/customer/index']],
						],
					],
					['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
						'url' => ['/site/logout'],
						'linkOptions' => ['data-method' => 'post']
					],
				];
			} else {
				$items = [
					['label' => 'Home', 'url' => ['/site/index']],
					[
						'label' => '庫存',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">庫存</font></li>',
							 ['label' => '庫存明細', 'url' => ['/inventory/transaction']],
							 ['label' => '庫存總覽', 'url' => ['/inventory/overview']],
							 ['label' => '庫存調整', 'url' => ['/inventory/adjust']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">統計</font></li>',
							 ['label' => '工作項目統計', 'url' => ['/inventory/summary']],
						],
					],
					[
						'label' => '訂單',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">會員訂單</font></li>',
							 ['label' => '新增會員訂單', 'url' => ['/order/add']],
							 ['label' => '會員訂單列表', 'url' => ['/order/list', 'sort' => '-date']],
							 ['label' => '出貨明細', 'url' => ['/order/ship_overview']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">內部訂單/轉移</font></li>',
							 ['label' => '新增內部訂單', 'url' => ['/transfer/add']],
							 ['label' => '內部訂單列表', 'url' => ['/transfer/list', 'sort' => '-send_date']],
						],
					],
					[
						'label' => '生產',
						'items' => [
							 ['label' => '新增生產', 'url' => ['/purchase-order/add']],
							 ['label' => '生產列表', 'url' => ['/purchase-order/list', 'sort' => '-date']],
						],
					],
					[
						'label' => '產品與套裝',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">產品</font></li>',
							 ['label' => '產品列表', 'url' => ['/product/index']],
							 ['label' => '新增產品', 'url' => ['/product/create']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">套裝</font></li>',
							 ['label' => '套裝列表', 'url' => ['/crew-pak/index']],
							 ['label' => '新增套裝', 'url' => ['/crew-pak/add']],
						],
					],
					[
						'label' => 'PADI會員',
						'items' => [
							 ['label' => '會員列表', 'url' => ['/customer/index']],
							 ['label' => '新增會員', 'url' => ['/customer/create']],
						],
					],
					['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
						'url' => ['/site/logout'],
						'linkOptions' => ['data-method' => 'post']
					],
				];
			}

			NavBar::begin([
				'brandLabel' => '光隆庫存管理',
				'brandUrl' => Yii::$app->homeUrl,
				'options' => [
					'class' => 'navbar-inverse navbar-fixed-top',
				],
			]);
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => $items
			]);
			NavBar::end();
		?>

		<div class="container">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= $content ?>
		</div>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; 光隆庫存管理 <?= date('Y') ?></p>
			<p class="pull-right"></p>
		</div>
	</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
