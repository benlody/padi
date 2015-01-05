<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
			NavBar::begin([
				'brandLabel' => '光隆庫存管理',
				'brandUrl' => Yii::$app->homeUrl,
				'options' => [
					'class' => 'navbar-inverse navbar-fixed-top',
				],
			]);
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					['label' => 'Home', 'url' => ['/site/index']],
					[
						'label' => '庫存',
						'items' => [
							 ['label' => '庫存明細', 'url' => ['/inventory/transaction']],
							 ['label' => '庫存總覽', 'url' => ['/inventory/overview']],
							 ['label' => '庫存調整', 'url' => ['/inventory/adjust']],
							 ['label' => '庫存轉移/郵寄', 'url' => ['/transfer/add']],
							 ['label' => '轉移/郵寄列表', 'url' => ['/transfer/list']],
						],
					],
					[
						'label' => '會員訂單',
						'items' => [
							 ['label' => '訂單列表', 'url' => ['/order/list']],
							 ['label' => '新增訂單', 'url' => ['/order/add']],
							 ['label' => '訂單查詢', 'url' => ['/order/search']],
							 ['label' => '出貨明細', 'url' => ['/order/ship_overview']],
						],
					],
					[
						'label' => '生產',
						'items' => [
							 ['label' => '生產列表', 'url' => ['/purchase-order/list']],
							 ['label' => '新增生產', 'url' => ['/purchase-order/add']],
							 ['label' => '生產查詢', 'url' => ['/purchase-order/search']],
						],
					],
					[
						'label' => '產品與套裝',
						'items' => [
							 '<li class="dropdown-header">產品</li>',
							 ['label' => '產品列表', 'url' => ['/product/index']],
							 ['label' => '新增產品', 'url' => ['/product/create']],
							 '<li class="divider"></li>',
							 '<li class="dropdown-header">套裝</li>',
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
					Yii::$app->user->isGuest ?
						['label' => 'Login', 'url' => ['/site/login']] :
						['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
							'url' => ['/site/logout'],
							'linkOptions' => ['data-method' => 'post']],
				],
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
