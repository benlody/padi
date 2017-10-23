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
						'label' => Yii::t('app', 'Inventory'),
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Inventory').'</font></li>',
							 ['label' => Yii::t('app', 'Inventory Transaction - T'), 'url' => ['/inventory/transaction', 'warehouse' => 'tw']],
							 ['label' => Yii::t('app', 'Inventory Transaction - XDC'), 'url' => ['/inventory/transaction', 'warehouse' => 'xm']],
							 ['label' => Yii::t('app', 'Inventory Overview - T'), 'url' => ['/inventory/overview', 'warehouse' => 'tw']],
							 ['label' => Yii::t('app', 'Inventory Overview - XDC'), 'url' => ['/inventory/overview', 'warehouse' => 'xm']],
							 ['label' => Yii::t('app', 'Inventory Adjust'), 'url' => ['/inventory/adjust']],
							 ['label' => Yii::t('app', 'Low Stock Items'), 'url' => ['/inventory/low_stock']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Statistics').'</font></li>',
							 ['label' => Yii::t('app', 'Working Items'), 'url' => ['/inventory/summary']],
						],
					],
					[
						'label' => Yii::t('app', 'Order'),
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Member Order').'</font></li>',
							 ['label' => Yii::t('app', 'Add Order'), 'url' => ['/order/add']],
							 ['label' => Yii::t('app', 'Order List'), 'url' => ['/order/list', 'sort' => '-date']],
							 ['label' => Yii::t('app', 'Search Order'), 'url' => ['/order/search']],
							 ['label' => Yii::t('app', 'Bill'), 'url' => ['/order/ship_overview']],
							 ['label' => Yii::t('app', 'Order Statistics'), 'url' => ['/order/statistics']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Internal Transfer').'</font></li>',
							 ['label' => Yii::t('app', 'Add Transfer'), 'url' => ['/transfer/add']],
							 ['label' => Yii::t('app', 'Transfer List'), 'url' => ['/transfer/list', 'sort' => '-send_date']],
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Tools').'</font></li>',
							 ['label' => Yii::t('app', 'Invoice Generator'), 'url' => ['/order/invoice']],
							 ['label' => Yii::t('app', 'Packing Generator - 1'), 'url' => ['/padi-transfer/add']],
							 ['label' => Yii::t('app', 'Packing Generator - 2'), 'url' => ['/padi-transfer/list', 'sort' => '-date']],
						],
					],
					[
						'label' => Yii::t('app', 'Production'),
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Production').'</font></li>',
							 ['label' => Yii::t('app', 'Add Production'), 'url' => ['/purchase-order/add']],
							 ['label' => Yii::t('app', 'Production List'), 'url' => ['/purchase-order/list', 'sort' => '-date']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Assemble').'</font></li>',
							 ['label' => Yii::t('app', 'Add Assemble'), 'url' => ['/assemble/add']],
							 ['label' => Yii::t('app', 'Assemble List'), 'url' => ['/assemble/list', 'sort' => '-date']],
							 ['label' => Yii::t('app', 'Assemble Bill'), 'url' => ['/assemble/bill']],
						],
					],
					[
						'label' => Yii::t('app', 'Service'),
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Market').'</font></li>',
							 ['label' => '新增行銷物', 'url' => ['/market/create']],
							 ['label' => '行銷物帳單', 'url' => ['/market/bill']],
						],
					],
					[
						'label' => Yii::t('app', 'Product & Crew-Pak'),
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Product').'</font></li>',
							 ['label' => Yii::t('app', 'Product List'), 'url' => ['/product/index']],
							 ['label' => Yii::t('app', 'Add Product'), 'url' => ['/product/create']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Crew-Pak').'</font></li>',
							 ['label' => Yii::t('app', 'Crew-Pak List'), 'url' => ['/crew-pak/index']],
							 ['label' => Yii::t('app', 'Add Crew-Pak'), 'url' => ['/crew-pak/add']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Assemble').'</font></li>',
							 ['label' => Yii::t('app', 'Assemble Content List'), 'url' => ['/assemble/content-list']],
							 ['label' => Yii::t('app', 'Add Assemble Content'), 'url' => ['/assemble/content-add']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Packing').'</font></li>',
							 ['label' => Yii::t('app', 'Packing Info'), 'url' => ['/packing/index']],
						],
					],
					[
						'label' => Yii::t('app', 'Member'),
						'items' => [
							 ['label' => Yii::t('app', 'Member List'), 'url' => ['/customer/index']],
							 ['label' => Yii::t('app', 'Create Member'), 'url' => ['/customer/index']],
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
			} else if (Yii::$app->user->identity->group === User::GROUP_XM){
				$items = [
					['label' => 'Home', 'url' => ['/site/index']],
					[
						'label' => '庫存',
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">庫存</font></li>',
							 ['label' => '庫存明細', 'url' => ['/inventory/transaction']],
							 ['label' => '庫存總覽', 'url' => ['/inventory/overview']],
							 ['label' => Yii::t('app', 'Low Stock Items'), 'url' => ['/inventory/low_stock']],
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
						],
					],
/*					
					[
						'label' => '生產',
						'items' => [
							 ['label' => '生產列表', 'url' => ['/purchase-order/list', 'sort' => '-date']],
						],
					],
					*/
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
			} else if (Yii::$app->user->identity->group === User::GROUP_PADI){
				$items = [
					['label' => 'Home', 'url' => ['/site/index']],
					[
						'label' => Yii::t('app', 'Inventory'),
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Inventory').'</font></li>',
							 ['label' => Yii::t('app', 'Inventory Transaction - T'), 'url' => ['/inventory/transaction', 'warehouse' => 'tw']],
							 ['label' => Yii::t('app', 'Inventory Transaction - XDC'), 'url' => ['/inventory/transaction', 'warehouse' => 'xm']],
							 ['label' => Yii::t('app', 'Inventory Overview - T'), 'url' => ['/inventory/overview', 'warehouse' => 'tw']],
							 ['label' => Yii::t('app', 'Inventory Overview - XDC'), 'url' => ['/inventory/overview', 'warehouse' => 'xm']],
							 ['label' => Yii::t('app', 'Low Stock Items'), 'url' => ['/inventory/low_stock']],
//							 '<li class="divider"></li>',
//							 '<li class="dropdown-header" align="center"><font color="green">統計</font></li>',
//							 ['label' => '工作項目統計', 'url' => ['/inventory/summary']],
						],
					],
/*					[
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
*/					[
						'label' => Yii::t('app', 'Transfer'),
						'items' => [
							 ['label' => Yii::t('app', 'Transfer Create'), 'url' => ['/padi-transfer/add']],
							 ['label' => Yii::t('app', 'Transfer List'), 'url' => ['/padi-transfer/list', 'sort' => '-date']],
						],
					],
					[
						'label' => Yii::t('app', 'Product & Crew-Pak'),
						'items' => [
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Product').'</font></li>',
							 ['label' => Yii::t('app', 'Product List'), 'url' => ['/product/index']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Crew-Pak').'</font></li>',
							 ['label' => Yii::t('app', 'Crew-Pak List'), 'url' => ['/crew-pak/index']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Packing').'</font></li>',
							 ['label' => Yii::t('app', 'Packing Info'), 'url' => ['/packing/index']],
						],
					],
					[
						'label' => Yii::t('app', 'Member'),
						'items' => [
							 ['label' => Yii::t('app', 'Member List'), 'url' => ['/customer/index']],
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
							 ['label' => Yii::t('app', 'Inventory Transaction - T'), 'url' => ['/inventory/transaction', 'warehouse' => 'tw']],
							 ['label' => Yii::t('app', 'Inventory Transaction- XDC'), 'url' => ['/inventory/transaction', 'warehouse' => 'xm']],
							 ['label' => Yii::t('app', 'Inventory Overview - T'), 'url' => ['/inventory/overview', 'warehouse' => 'tw']],
							 ['label' => Yii::t('app', 'Inventory Overview- XDC'), 'url' => ['/inventory/overview', 'warehouse' => 'xm']],
							 ['label' => '庫存調整', 'url' => ['/inventory/adjust']],
							 ['label' => Yii::t('app', 'Low Stock Items'), 'url' => ['/inventory/low_stock']],
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
							 ['label' => '訂單搜尋', 'url' => ['/order/search']],
							 ['label' => '出貨明細', 'url' => ['/order/ship_overview']],
							 ['label' => Yii::t('app', 'Order Statistics'), 'url' => ['/order/statistics']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">內部訂單/轉移</font></li>',
							 ['label' => '新增內部訂單', 'url' => ['/transfer/add']],
							 ['label' => '內部訂單列表', 'url' => ['/transfer/list', 'sort' => '-send_date']],
							 '<li class="dropdown-header" align="center"><font color="green">發票</font></li>',
							 ['label' => '發票產生器', 'url' => ['/order/invoice']],
							 ['label' => 'Packing產生器-1', 'url' => ['/padi-transfer/add']],
							 ['label' => 'Packing產生器-2', 'url' => ['/padi-transfer/list', 'sort' => '-date']],
						],
					],
					[
						'label' => '生產',
						'items' => [
							 ['label' => '新增生產', 'url' => ['/purchase-order/add']],
							 ['label' => '生產列表', 'url' => ['/purchase-order/list', 'sort' => '-date']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Assemble').'</font></li>',
							 ['label' => Yii::t('app', 'Add Assemble'), 'url' => ['/assemble/add']],
							 ['label' => Yii::t('app', 'Assemble List'), 'url' => ['/assemble/list', 'sort' => '-date']],
							 ['label' => Yii::t('app', 'Assemble Bill'), 'url' => ['/assemble/bill']],
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
							 '<li class="divider"></li>',
							 '<li class="dropdown-header" align="center"><font color="green">'.Yii::t('app', 'Packing').'</font></li>',
							 ['label' => Yii::t('app', 'Packing Info'), 'url' => ['/packing/index']],
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
				'brandLabel' => Yii::t('app', 'Kuang Lung PADI Inventory'),
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
			<p class="pull-left">&copy; <?= Yii::t('app', 'Kuang Lung PADI Inventory').' '.date('Y') ?></p>
			<p class="pull-right"></p>
		</div>
	</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
