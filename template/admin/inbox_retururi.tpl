{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">
	<script src="{$URL_BASE}javascript/scriptaculous-js-1.7.0/lib/prototype.js" type="text/javascript"></script>	
	<script type="text/javascript" src="{$URL_BASE}javascript/EditInPlace.js"></script>
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
				<h2>Inbox retururi</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta sectiune aveti posibilitatea de a vizualiza retururile.</li>
					<li>In momentul cand un formula de retur a fost rezolvat il puteti sterge sau marca ca rezolvat.</li>					
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}				
		<tr>
			<td valign="top" align="center">
				<center>
					<form action="{$URL_ADMIN}inbox_retururi.php" method="POST">
						<table cellpadding="2" class="bg_spatiu" style="margin-top:5px;margin-bottom:5px">
							<tr>
								<td align="left"><b>Username:</b></td>
								<td align="left"><input type="text" name="utilizator" value="{$utilizator}"></td>	
								<td align="left"><b>Status:</b></td>
								<td align="left">
									<select name="status_formulare" class="select">
										<option value="">--Alege--</option>
										{html_options options=$stari selected=$stare_formular_selectat}
									</select>
								</td>
							</tr>							
							<tr>
								<td></td>
								<td align="left" colspan="3">
									<input type="submit" name="cauta" value="CAUTA" class="buton_cool">
								</td>								
							</tr>	
						</table>
					</form>		
				</center>					
				<table width="100%" cellspacing="1" cellpadding="2">
					<tr bgcolor="#EFEFEF">
						<td class="titlu" align="left" style="padding-left:3px" width="70"><b>Stare</b></td>
						<td class="titlu" align="left" style="padding-left:3px" width="70"><b>Data</b></td>
						<td class="titlu" align="left" style="padding-left:3px" width="100"><b>Username</b></td>
						<td class="titlu" align="left" style="padding-left:3px"><b>Nume firma/pers.</b></td>
						<td class="titlu" align="center" style="padding-left:3px" width="90"><b>Actiuni</b></td>
					</tr>
					{section name=sec loop=$f_retur}
					<tr>
						<td align="left" valign="top" height="16">{$f_retur[sec].status}</td>
						<td align="left" valign="top">{$f_retur[sec].data_trimitere}</td>
						<td align="left" valign="top">{$f_retur[sec].username}</td>
						<td align="left" valign="top">{$f_retur[sec].nume}</td>
						<td align="center" valign="top">	
							<a href="{$URL_ADMIN}inbox_retururi.php?id_formular={$f_retur[sec].id_formular}&status=1" title="Marcheaza formular de retur ca rezolvat" class="text_mic">rez.</a>
							&nbsp;-&nbsp;
							<a href="{$URL_ADMIN}f_retur.php?id_formular={$f_retur[sec].id_formular}" title="Vezi formularul de retur" class="text_mic">vezi</a>
							&nbsp;-&nbsp;													
							<a href="#" title="Sterge formularul de retur" class="text_mic"
									onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti <br /> formularul de retur al userului <b>{$f_retur[sec].username}</b>?', '400',
											  				  '{$URL_ADMIN}inbox_retururi.php?id_formular={$f_retur[sec].id_formular}&sterge')">sterge</a>
							<br />
							<a href="{$URL_ADMIN}inbox_retururi.php?id_formular={$f_retur[sec].id_formular}&status=2" title="Marcheaza formular de retur in procesare" class="text_mic">in proc.</a>
							&nbsp;-&nbsp;
							<a href="{$URL_ADMIN}inbox_retururi.php?id_formular={$f_retur[sec].id_formular}&status=3" title="Marcheaza formular de retur in curs de rezolvare" class="text_mic">in curs</a>
						</td>
					</tr>
					{sectionelse}
					<tr>
						<td colspan="5">Nu sunt rezultate!</td>
					</tr>	
					{/section}	
					<tr>
						<td colspan="5" bgcolor="#EFEFEF" style="padding-right:5px" align="right" height="16">{$paginare}</td>
					</tr>				
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