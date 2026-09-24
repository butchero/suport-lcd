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
	<table cellpadding="3" cellspacing="1" class="bg_spatiu" width="100%">
		<tr>
			<td colspan="4" class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Grupeaza filtre</h2>
			</td>
		</tr>
	</table>	
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE---------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea sa grupati filtrele definite pentru o categorie.</li>
		<li>ATENTIE: Un filtru care apartine de un grup, nu poate fi folosit in alt grup, pana cand nu este scos din grupul de care apartine!</li>			
	</ul>
	{*--------------------------------------------------------------------END------------------------------------------------------*}
	<form action="{$URL_ADMIN}grupeaza_produse.php" method="POST">
	<table style="margin-top:20px" bgcolor="#efefef">
		<tr>
			<td>Adauga grup in cat.:</td>
			<td>
				<select name="id_cat" id="id_cat" class="select">
					<option value="0">--ROOT--</option>
					{html_options options=$toate_cat selected=$id_cat}
				</select>
			</td>
		</tr>
		<tr>
			<td>Nume grup nou:</td>
			<td><input type="text" name="nume_grup_nou" size="27"></td>
		</tr>
		<tr>
			<td></td>
			<td align="left"><input type="submit" name="adauga_grup" value="ADAUGA GRUP" class="buton_cool" style="width:150px"></td>
		</tr>
	</table>
	</form>
	<form action="{$URL_ADMIN}grupeaza_produse.php" method="POST">
	<table style="margin-top:20px">
		<tr>
			<td>Afiseaza gruparile, filtrele definite pentru categoria:</td>
		</tr>
		<tr>
			<td>
				<select name="id_cat" id="id_cat" class="select">
					<option value="0">--ROOT--</option>
					{html_options options=$toate_cat selected=$id_cat}
				</select>
			</td>
		</tr>
		<tr>
			<td align="left"><input type="submit" name="afiseaza_filtre" value="AFISEAZA FILTRE" class="buton_cool" style="width:150px"></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<table cellpadding="0" cellspacing="0" style="margin-top:10px">
					<tr><td>Grupuri definite pt categoria selectata</td></tr>
					<tr>
						<td>
							<select name="grupuri" id="grupuri" onChange="refreshGrupuriFiltre('grupuri', 'id_cat')" class="select" size="5" style="width:250px" multiple>
								{html_options options=$grupuri}
							</select>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<ul>
					<li>Click pe un grup pentru a vizualiza filtrele din grup si cele disponibile!</li>
				</ul>
			</td>
		</tr>	
		<tr>
			<td colspan="2"><input type="submit" name="sterge_grup" value="STERGE GRUPUL SELECTAT" class="buton_anuleaza"></td>
		</tr>
	</table>
	<table style="margin-top:10px">
		<tr>
			<td>				
				<table cellpadding="0" cellspacing="0">
					<tr><td>Filtre aflate in grupul selectat</td></tr>
					<tr>
						<td class="box" align="center" valign="middle" style="width:250px;height:185px">
							<div id="box_bloc1">	
								<select name="filtre_grupate[]" id="filtre_grupate" class="select" size="15" multiple style="width:250px">
									{html_options options=$filtre}
								</select>
							</div>	
						</td>
					</tr>
				</table>
			</td>
			<td align="center" valign="middle" width="50">
				<br />
				<a href="javascript:copyToList('filtre_disponibile', 'filtre_grupate')"><img src="{$DIR_TEMPLATE}img_admin/arr_left.gif" alt="" class="box"></a>
				<br /><br />
				<a href="javascript:copyToList('filtre_grupate', 'filtre_disponibile')"><img src="{$DIR_TEMPLATE}img_admin/arr_right.gif" alt="" class="box"></a>
			</td>
			<td>
				<table cellpadding="0" cellspacing="0">
					<tr><td>Filtre disponibile pentru grupare</td></tr>
					<tr>
						<td class="box" align="center" valign="middle" style="width:250px;height:185px">
							<div id="box_bloc2">
								<select name="filtre_disponibile[]" id="filtre_disponibile" class="select" size="15" multiple style="width:250px">
									{html_options options=$filtre}
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
				<input type="button" value="ACTUALIZEAZA GRUPARE" class="buton" style="width:200px" onClick="allSelect(this.form)">				
			</td>
		</tr>		
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