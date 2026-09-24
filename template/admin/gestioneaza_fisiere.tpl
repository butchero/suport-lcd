{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td>
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*---------------------------------------------------------------------END-----------------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Gestioneaza fisiere</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a adauga, sau sterge fisiere(cereri, formulare de retur, garantie).</li>
					<li>Aceste fisiere vor putea fi downloadate de clienti.</li>					
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}		
		<tr>
			<td valign="top">		
				<form action="{$URL_ADMIN}gestioneaza_fisiere.php" method="POST">
					<table>
						<tr><td class="bg_spatiu" height="16" style="padding-left:3px" colspan="2"><b>Creeaza un nou director</b></td></tr>
						<tr>
							<td><input type="text" name="nume_dir" size="40"></td>
							<td><input type="submit" name="adauga_dir" value="ADAUGA DIRECTOR" class="buton_cool" style="width:130px"></td>
						</tr>
					</table>
				</form>								
			</td>
		</tr>
		<tr>
			<td>
				<form action="{$URL_ADMIN}gestioneaza_fisiere.php" method="POST" enctype="multipart/form-data">
					<table>
						<tr><td class="bg_spatiu" height="16" style="padding-left:3px" colspan="3"><b>Upload fisier nou in</b></td></tr>
						<tr>
							<td>
								<select name="dir" class="select">
									{section name=sec loop=$foldere}
										<option value="{$foldere[sec]}">{$foldere[sec]}</option>
									{/section}
								</select>
							</td>
							<td><input type="file" name="fisier" size="40"></td>
							<td><input type="submit" name="upload" value="UPLOAD" class="buton_cool"></td>
						</tr>
					</table>
				</form>
				<table style="margin-top:10px">
					<tr><td class="bg_spatiu" colspan="3" height="16" style="padding-left:3px"><b>Navigare</b></td></tr>
					{section name=sec loop=$foldere}
					<tr>
						<td style="padding-left:5px"><img src="{$DIR_TEMPLATE}img/folder.gif"></td>
						<td width="410"><a href="{$URL_ADMIN}gestioneaza_fisiere.php?folder={$foldere[sec]}&actiune=afiseaza">{$foldere[sec]}</a></td>						
						<td style="padding-left:5px">
							<input type="button" value="STERGE DIR" class="buton_anuleaza" style="width:100px" 
								onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
														   <br />folderul <b>{$foldere[sec]}</b>?
														   <br /><br /><font class=eroare_text>Toate fisierele din acest folder vor fi sterse definitiv!</font>', '400',
														  '{$URL_ADMIN}gestioneaza_fisiere.php?folder={$foldere[sec]}&actiune=sterge_folder')"></td>
					</tr>
						{if $foldere[sec] eq $folder_selectat}
							{section name=subsec loop=$fisiere_dir_selectat}
							<tr>
								<td></td>
								<td>&raquo; <a href="{$URL_BASE}fisiere/{$foldere[sec]}/{$fisiere_dir_selectat[subsec]}"> {$fisiere_dir_selectat[subsec]}</a></td>
								<td style="padding-left:5px">
									<input type="button" value="STERGE FISIER" class="buton" style="width:100px" 
										onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti
																   <br />fisierul <b>{$fisiere_dir_selectat[subsec]}</b>?
																   <br /><br /><font class=eroare_text>Fisierul va fi sters definitiv!</font>', '400',
																  '{$URL_ADMIN}gestioneaza_fisiere.php?fisier={$fisiere_dir_selectat[subsec]}&folder={$foldere[sec]}&actiune=sterge_fisier')"></td>
							</tr>
							{/section}
						{/if}
					{/section}
				</table>
			</td>
		</tr>
	</table>
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}