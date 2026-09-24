{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">	
	<script src="{$URL_BASE}javascript/scriptaculous-js-1.5.3/prototype.js" type="text/javascript"></script>
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>		
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*--------------------------------------------------------------------END------------------------------------------------------*}
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td colspan="4" class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Categorii secundare</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a crea categorii/subcategorii secundare.</li>
		<li>Cu ce difera categoriile secundare de categoriile principale ? Un produs poate sa apartina de mai multe categorii/subcategorii secundare.</li>	
		<li>ATENTIE: Cand se sterge o categorie se sterg doar asocierile intre produse si categoriile secundare, nu si produsul in sine!</li>
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}
	<form action="{$URL_ADMIN}categorii_secundare.php" method="POST">
	<table style="margin-top:20px" bgcolor="#efefef">
		<tr>
			<td width="160">Adauga in:</td>
			<td>
				<select name="id_cat_sec" class="select">
					<option value="0">--ROOT--</option>
					{section name=sec loop=$cat_secundare}
						<option value="{$cat_secundare[sec].id_cat}" {if $cat_secundare[sec].id_cat eq $id_cat_parinte}selected{/if}>
							{$cat_secundare[sec].nume_cat}
						</option>
						{section name=subsec loop=$cat_secundare[sec].subcat}
							<option value="{$cat_secundare[sec].subcat[subsec].id_cat}" {if $cat_secundare[sec].subcat[subsec].id_cat eq $id_cat_parinte}selected{/if}>
								&nbsp;&nbsp; &raquo; {$cat_secundare[sec].subcat[subsec].nume_cat}
							</option>
						{/section}
					{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td>Categorie/subcat noua:</td>
			<td><input type="text" name="cat_sec_noua" size="60"></td>
		</tr>
		<tr>
			<td></td>
			<td align="left">
				<input type="submit" name="adauga_cat_sec" value="ADAUGA CAT/SUBCAT" class="buton_cool" style="width:150px">
				&nbsp;
				<input type="submit" name="sterge_cat_sec" value="STERGE CAT/SUBCAT" class="buton_anuleaza" style="width:150px">
			</td>
		</tr>
	</table>
	</form>
	<form action="{$URL_ADMIN}categorii_secundare.php" method="POST">
	<table style="margin-top:20px" bgcolor="#efefef">
		<tr>
			<td width="160">Editeaza categorie/subcat:</td>
			<td>
				<select name="id_cat_de_edit" onChange="this.form.submit()" class="select">
					<option value="0">--ROOT--</option>
					{section name=sec loop=$cat_secundare}
						<option value="{$cat_secundare[sec].id_cat}" {if $cat_secundare[sec].id_cat eq $id_cat_de_edit}selected{/if}>
							{$cat_secundare[sec].nume_cat}
						</option>
						{section name=subsec loop=$cat_secundare[sec].subcat}
							<option value="{$cat_secundare[sec].subcat[subsec].id_cat}" {if $cat_secundare[sec].subcat[subsec].id_cat eq $id_cat_de_edit}selected{/if}>
								&nbsp;&nbsp; &raquo; {$cat_secundare[sec].subcat[subsec].nume_cat}
							</option>
						{/section}
					{/section}
				</select>
			</td>
		</tr>
		{if $id_cat_de_edit neq 0 && $id_cat_de_edit neq ""}
		<tr>
			<td>Nume categorie:</td>
			<td><input type="text" name="cat_sec_existenta" value="{$cat_de_editat}" size="60"></td>
		</tr>
		<tr>
			<td></td>
			<td align="left">
				<input type="submit" name="modifica_cat_sec" value="MODIFICA CAT/SUBCAT EXISTENTA" class="buton_cool" style="width:304px">				
			</td>
		</tr>
		{/if}
	</table>
	</form>
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;</p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}