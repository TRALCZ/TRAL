<?php

/* 
 * pdf - шаблон
 */

use app\models\Seznam;
?>

<div style="width: 100%; padding-top: -20px; padding-left: -0px;"><hr style="height:2px; border:none; color:#333; background-color:#333;" /></div>

<div style="font-size: 22px; float:left; width: 100%; font-weight: bold; padding-top: -15px; margin-bottom: 10px;">Bankovní doklad č. <?=$cislo?></div>

<div style="float: left; width: 50%; font-size: 11px; font-weight: bold;">Přijatý doklad:</div>
<div style="float: left; width: 50%; font-size: 11px;">Odběratel</div>
<div style="float: left; width: 50%; font-size: 11px; font-weight: bold;"> &nbsp; </div>
<div style="float: left; width: 50%; padding-top: -20px;"><hr /></div>

<div style="float: left; width: 50%; font-size: 11px; margin-top: 20px;">
	<b>Datum vystavení:</b> <?=$vystaveno?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Pobočka:</b> <br>
	<b>Datum platnosti od:</b> <?=$platnost?><br>
	<b>Datum platnosti do:</b> <br>
	<div style="margin-top: 70px;">
		<div style="width: 50%; float: left; text-align: left;">
			<b>Bankovní účet</b><br />
			<div style="width: 90%; background-color: #d3d3d3; height: 10px; text-align: center;"><b>220330976</b></div>
		</div>
		<div style="width: 25%; float: right; text-align: left; margin-right: 50px;">
			<b>Kod banky</b><br />
			<div style="width: 100%; background-color: #d3d3d3; height: 10px; text-align: center;"><b>0300</b></div>
		</div>
		
	</div>
</div>

<div style="float: left; width: 50%; padding-top: -38px; font-size: 13px;">
	<b><?=$zname?></b><br>
	<div style="margin-top: 10px;">
		IČ: <?=$zico?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DIČ: <?=$zdic?><br>
		<?=$zfulice?><br>
		<?=$zfpsc?> <?=$zfmesto?><br>
		<?=$zfzeme?><br>
		<?=$zphone?> &nbsp;&nbsp;&nbsp; <?=$zmobil?><br>
		<?=$zemail?>
	</div>
	<div style="float: left; width: 100%; padding-top: -15px;"><hr /></div>
	<div style="font-size: 10px; color: red; margin-top: -15px;">
		<b><?=$zname?></b><br>
		<?=$zdulice?><br>
		<?=$zdpsc?> <?=$zdmesto?><br>
		<?=$zdzeme?><br>
		<?=$zphone?><br>
	</div>
	
</div>

<div style="width: 100%; padding-top: -10px;"><hr style="height:3px; border:none; color:#333; background-color:#333;" /></div>
<div style="float: left; padding-top: -15px; font-size: 13px;">
	<div style="float: left; width: 50%;"><b>Označení dodávky</b></div>
	<div style="float: left; width: 10%;"><b>Počet/MJ</b></div>
	<div style="float: left; width: 10%;"><b>Cena/MJ</b></div>
	<div style="float: left; width: 10%;"><b>DPH %</b></div>
	<div style="float: left; width: 10%;"><b>DPH</b></div>
	<div style="float: left; width: 10%;"><b>s DPH</b></div>
</div>
<div style="width: 100%; padding-top: -15px;"><hr style="height:3px; border:none; color:#333; background-color:#333;" /></div>
<div style="float: left; font-size: 12px; padding-top: -10px;">

</div>

<div style="float: left; width: 100%; font-size: 10px; margin-top: 40px;">
	Podepsáním Objednávky zákazník potvrzuje, že zkontroloval typ, barvu a počet kusů zboží a bezvýhradně s objednávkou souhlasí.<br />
	Při podepsání závazné Objednávky nebo úhrady zálohy nelze změnit položky v objednávce!<br />
	Záruka na zboži a služby dodané od ERKADO CZ s. r. o. 24 měsíců.<br />
	Reklamačni řád, všeobecné obchodní podmínky a informace o zboží naleznete na www.dvere-erkado.cz.<br />
	Dodací lhůta:<br /> 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3-6 týdnů na interiérové dveře a obl. zárubně<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5-8 týdnů na vchodové, protipožární dveře a zárubně, dveře řady TWIN a GRAF<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2-5 pracovní dnů na stavební pouzdra a kování<br />
	a platí od data připsání peněz na účet.<br />
	Zbývající částka musí být uhrazena v hotovosti při dodání zboží (popř. montáži), nebo předem na bankovní účet.<br />
	Pokud v objednávce máte jakékoliv úpravy a montážní práce, dodací lhůta se může prodloužit o 1-2 týdny.<br />
	Při převzetí zboží od přepravné společnosti je potřeba řádně zkontrolovat zboží.<br />
	V případě, že obal nebo zboži je poškozené, tuto skutečnost zapsat do předávacího protokolu.<br />
	Na pozdější reklamace v důsledku poškození obalu nebo zboží během přepravy pak nemusí být brán zřetel.
</div>

<div style="margin-top: 60px;">
	<div style="float: left; width: 30%; font-size: 10px; text-align: center;">
		<div style="border-top:1px solid black; width:100%;"></div>
		Razítko a podpis odběratele
	</div>

	<div style="float: right; width: 30%; font-size: 10px; text-align: center;">
		<div style="border-top:1px solid black; width:100%;"></div>
		Razítko a podpis dodavatele
	</div>
</div>

<div style="float: left; margin-top: 20px; font-size: 10px;">
	<div style="float: left; width: 50%;">
		<b>Cena nezahrnuje:</b><br>
		- podřezáváni dveří a zárubní z důvodů nedodržení stav. připravenosti;<br>
		- dodatečná úprava stavebních otvorů;<br>
		- akrylování nerovností zdí včetně materiálu;<br>
		- přípravné stavební / zednické / práce
	</div>

	<div style="float: right; width: 45%; text-align: left;">
		<b>Podmínky:</b><br>
		- maximálni vlhkost (relativní) na stavbě nesmí být vyšši než 50%;<br>
		- minimální teplota v zimních měsícich nejméně 15&deg; C;<br>
		- zajištění el. proudu 220V a zpřístupnění na pracovště
	</div>
</div>
<div style="float: left; width: 100%; font-size: 10px; margin-top: 20px; text-align: center;"><b>Předem děkujeme za Váš zájem a těšíme se na případnou spolupráci!</b></div>

<?
//echo "Nabídka č. " . $id;
?>