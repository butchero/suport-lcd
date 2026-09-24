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
				<h2>Asociatii produse</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a crea asociatii intre produse si categoriile secundare.</li>		
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}	
	<form action="{$URL_ADMIN}asociatii_produse.php" method="POST">
	<table style="margin-top:20px">
		<tr bgcolor="#efefef">
			<td width="120">ID Produs:</td>
			<td><input type="text" name="id_produs" value="{$id_produs}" size="5"></td>
		</tr>
		<tr>
			<td colspan="2"><b>{$nume_produs}</b></td>			
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="editeaza_produs" value="EDITEAZA PRODUS" class="buton"></td>
		</tr>
	</table>
	{if $id_produs neq ""}
	<table style="margin-top:5px">
		<tr bgcolor="#efefef">
			<td></td>
			<td>Alege:</td>
			<td>				
				<select name="id_cat_sec" onChange="this.form.submit()" class="select">
					<option value="0">Alege categorie</option>
					{html_options options=$combo_cat selected=$id_cat_sec}
				</select>
			</td>
		</tr>
		<tr><td colspan="3" height="5"></td></tr>
		<tr>
			<td>				
				<table cellpadding="0" cellspacing="0">
					<tr><td>Subcategorii asociate produsului</td></tr>
					<tr>
						<td class="box" align="center" valign="middle" style="width:250px;height:185px">
							<div id="box_bloc1">	
								<select name="subcategorii_asociate[]" id="subcategorii_asociate" class="select" size="15" multiple style="width:250px">
									{html_options options=$combo_cat_asociate}
								</select>
							</div>	
						</td>
					</tr>
				</table>
			</td>
			<td align="center" valign="middle" width="50">
				<br />
				<a href="javascript:copyToList('subcategorii_disponibile', 'subcategorii_asociate')"><img src="{$DIR_TEMPLATE}img_admin/arr_left.gif" alt="" class="box"></a>
				<br /><br />
				<a href="javascript:copyToList('subcategorii_asociate', 'subcategorii_disponibile')"><img src="{$DIR_TEMPLATE}img_admin/arr_right.gif" alt="" class="box"></a>
			</td>
			<td>
				<table cellpadding="0" cellspacing="0">
					<tr><td>Subcategorii disponibile</td></tr>
					<tr>
						<td class="box" align="center" valign="middle" style="width:250px;height:185px">
							<div id="box_bloc2">
								<select name="subcategorii_disponibile[]" id="subcategorii_disponibile" class="select" size="15" multiple style="width:250px">									
									{html_options options=$combo_cat_disponibile}
								</select>
							</div>	
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="text_mic">Tip: Ctrl + Click pentru selectie multipla</td>
		</tr>
		<tr>
			<td align="center" colspan="3">
				<input type="button" value="ACTUALIZEAZA ASOCIERE" class="buton" style="width:200px" onClick="document.getElementById('flag_submit').value=1;allSelect(this.form, 'subcategorii_asociate', 'subcategorii_disponibile')">				
			</td>
		</tr>		
	</table>
	<input type="hidden" name="flag_submit" id="flag_submit" value="0">
	{/if}
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