<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use app\themes\adminLTE\components\ThemeNav;

?>
<?php $this->beginContent('@app/themes/adminLTE/layouts/main.php'); ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

     <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo Yii::$app->request->baseUrl; ?>/images/user_accounts.png" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>
                      <?php
                          //$info[] = Yii::t('app','');

                          if(isset(Yii::$app->user->identity->name))
                              echo ucfirst(\Yii::$app->user->identity->name);

                          //echo implode(', ', $info);
                      ?>
                    </p>
                    <a><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
			<!--
			<ul class="sidebar-menu">
				<li class="header">MAIN NAVIGITION</li>
				<li>
					<a href="/">
					<i class="fa fa-dashboard"></i>
					<span>Hlavní</span>
					</a>
				</li>
				<li>
					<a href="/../nabidky">
						<i class="fa fa-cart-plus"></i>
						<span>Nabidky vystavené</span>
					</a>
				</li>
				
				<li id="scrollspy-components" class="treeview">
					<a href="javascript:void(0)">
					<i class="fa fa-circle-o"></i><span>Components </span></a>
					
					<ul class="nav treeview-menu" style="display: none;">
					<li class="">
					<a href="#component-main-header">Main Header</a>
					</li>
					<li class="">
					<a href="#component-sidebar">Sidebar</a>
					</li>
					<li class="">
					<a href="#component-control-sidebar">Control Sidebar</a>
					</li>
					<li class="">
					<a href="#component-info-box">Info Box</a>
					</li>
					<li class="">
					<a href="#component-box">Boxes</a>
					</li>
					<li class="">
					<a href="#component-direct-chat">Direct Chat</a>
				</li>
				
				
			</ul>
			-->
			
            <?php
			/*
                echo Menu::widget([
                  'encodeLabels'=>false,
                  'options' => [
                    'class' => 'sidebar-menu'
                  ],
                  'items' => [
						['label'=>Yii::t('app','MAIN NAVIGITION'), 'options'=>['class'=>'header']],
						['label' => ThemeNav::link('Hlavní', 'fa fa-dashboard'), 'url' => ['site/index'], 'visible'=>!Yii::$app->user->isGuest],
						['label' => ThemeNav::link('Nabidky vystavené', 'fa fa-cart-plus'), 'url' => ['../nabidky'], 'visible'=>!Yii::$app->user->isGuest],
						['label' => ThemeNav::link('Seznam', 'fa fa-navicon'), 'url' => ['../seznam'], 'visible'=>!Yii::$app->user->isGuest],
						['label' => ThemeNav::link('Skladové skupiny', 'fa fa-code-fork'), 'url' => ['../category'], 'visible'=>!Yii::$app->user->isGuest],
						['label' => ThemeNav::link('Zákazníky', 'fa fa-user'), 'url' => ['../zakazniky'], 'visible'=>!Yii::$app->user->isGuest],
						['label' => ThemeNav::link('Způsoby platby', 'fa fa-money'), 'url' => ['../zpusoby-platby'], 'visible'=>!Yii::$app->user->isGuest],
						
						
					],	
                ]);
			*/
            ?>
			
			<!-- New menu -->
			
			<ul class="sidebar-menu">
				<li class="header">Menu</li>
				<li><a href="/"><i class="fa fa-dashboard"></i><span>Hlavní</span></a></li>
				
				<li><a href="<?= Yii::getAlias('@web') ?>/nabidky"><i class="fa fa-shopping-basket"></i><span>Nabidky vystavené</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/seznam"><i class="fa fa-th"></i><span>Katalog zboží</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/ceniky-seznam"><i class="fa fa-money"></i><span>Ceny</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/sklady-seznam"><i class="fa fa-sitemap"></i><span>Sklady</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/zakazniky"><i class="fa fa-users"></i><span>Firmy</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/log"><i class="fa fa-list-ul"></i><span>Logy</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/settings"><i class="fa fa-cogs"></i><span>Nastavení</span></a></li>
				
				<!--
				<li><a href="<?= Yii::getAlias('@web') ?>/faktury-prijate"><i class="fa fa-file-text-o"></i><span>Faktury přijaté</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/dlist-prijaty"><i class="fa fa-file-o"></i><span>Dodací listy přijaté</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/nabidky"><i class="fa fa-shopping-basket"></i><span>Nabidky vystavené</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/faktury-zalohove"><i class="fa fa-file-text-o"></i><span>Faktury zálohové</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/pdoklad-fz"><i class="fa fa-money"></i><span>Pokladní doklady</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/bdoklad-fz"><i class="fa fa-money"></i><span>Bankovní doklady</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/ddoklad-fz"><i class="fa fa-money"></i><span>Daňové doklady</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/objednavky"><i class="fa fa-cart-plus"></i><span>Objednávky vystavené</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/faktury"><i class="fa fa-file-text-o"></i><span>Faktury vystavené</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/dlist"><i class="fa fa-file-o"></i><span>Dodací listy vydané</span></a></li>
				<li><a href="<?= Yii::getAlias('@web') ?>/ucty"><i class="fa fa-credit-card"></i><span>Účty</span></a></li>
				-->
	
				<!--
				<li id="scrollspy-components" class="treeview">
					<a href="javascript:void(0)"><i class="fa fa-navicon"></i><span>Sklad</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span> </a>
					<ul class="nav treeview-menu" style="display: none;">
						<li><a href="/../seznam"><span>Zásoby na skladě</span></a></li>
					</ul>
				</li>
				
				<li id="scrollspy-components" class="treeview">
					<a href="javascript:void(0)"><i class="fa fa-cogs"></i><span>Nastavení</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span> </a>
					
					<ul class="nav treeview-menu" style="display: none;">
						<li><a href="<?= Yii::getAlias('@web') ?>/category"><span>Skladové skupiny</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/typ"><span>Typ zboží</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/modely"><span>Modely</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/rozmer"><span>Rozměry</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/odstin"><span>Odstíny</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/otevirani"><span>Typ otevírání dveří</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/vypln"><span>Výplň</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/typzamku"><span>Typ zámku</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/ventilace"><span>Ventilace</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/norma"><span>Normy</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/zpusoby-platby"><span>Způsoby platby</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/status"><span>Stavy</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/prevzit"><span>Převzít</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/zakazniky-skupina"><span>Skupiny zákazníků</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/klice"><span>Adresní klíče</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/cenova-hladina"><span>Cenová hladina</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/modely-odstin"><span>Odstín modelu</span></a></li>
						<li><a href="<?= Yii::getAlias('@web') ?>/rada"><span>Řada</span></a></li>
					</ul>
				</li>
				-->
				
			</ul>
			
			
			
			
			
			
			
        </section>
  <!-- /.sidebar -->
</aside>

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">

   <!-- Content Header (Page header) -->
   <section class="content-header">
        <h1> <?php echo Html::encode($this->title); ?> </h1>
           <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo $content; ?>
    </section><!-- /.content -->

</div><!-- /.right-side -->
<?php $this->endContent();