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
				<h2>Inbox(mesaje propuneri produse si contact)</h2>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" class="box" width="557">
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
		<tr>
			<td>
				<ul>
					<li>In aceasta sectiune aveti posibilitatea de a raspunde mesajelor venite pe de site, in cazul in care site-ul e setat sa pastreze mesajele in baza de date, in loc sa le trimita pe e-mail.</li>					
				</ul>
			</td>
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}				
		<tr>
			<td valign="top" align="center">
				{if $detalii_mesaj neq ""}
				<form action="{$URL_ADMIN}inbox.php?id_msg={$detalii_mesaj.id_mesaj}" method="POST">
					<table width="100%" style="margin-bottom:10px" class="box" cellpadding="2">
						<tr><td align="left" colspan="2" class="bg_spatiu"><span class="titlu"><b>DETALII MESAJ</b></span></td></tr>
						<tr><td width="110" align="left"><b>Nume:</b></td><td align="left">{$detalii_mesaj.nume}</td></tr>
						<tr><td align="left"><b>E-mail:</b></td><td align="left">{$detalii_mesaj.email}</td></tr>
						<tr><td align="left"><b>Telefon:</b></td><td align="left">{$detalii_mesaj.telefon}</td></tr>
						<tr><td align="left"><b>Data trimiterii:</b></td><td align="left">{$detalii_mesaj.data_mesaj}</td></tr>
						<tr><td align="left" valign="top"><b>Mesaj:</b></td><td align="left">{$detalii_mesaj.mesaj}</td></tr>
						<tr><td align="left" colspan="2" class="bg_spatiu"><span class="titlu"><b>RASPUNDE</b></span></td></tr>
						<tr><td align="left"><b>Din partea:</b></td><td align="left"><input type="text" name="din_partea" value="{$din_partea}" size="60"></td></tr>
						<tr><td align="left"><b>Raspuns:</b></td><td align="left"><textarea name="raspuns" rows="5" cols="60"></textarea></td></tr>
						<tr>
							<td></td>
							<td align="left">
								<input type="submit" name="raspunde" value="RASPUNDE" class="buton_cool" style="width:100px"> 
								&nbsp;
								<input type="submit" name="sterge" value="STERGE" class="buton_anuleaza" style="width:100px">
							</td>
						</tr>
					</table>
				</form>
				{/if}
				<center>
				<form action="{$URL_ADMIN}inbox.php" method="POST">
					<table cellpadding="2" class="bg_spatiu" style="margin-top:5px;margin-bottom:10px">
						<tr>
							<td align="left"><b>Tip contact:</b></td>
							<td align="left" colspan="2">
								<select name="tip_contact" class="select" style="width:90px">
									<option value="">--Alege--</option>
									<option value="0" {if $tip_contact eq "0"}selected{/if}>Propuneri</option>
									<option value="1" {if $tip_contact eq "1"}selected{/if}>Contact</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="left"><b>Ordoneaza:</b></td>
							<td align="left">
								<select name="ordonare" class="select" style="width:90px">
									<option value="">--Alege--</option>
									<option value="asc" {if $ordonare eq "asc"}selected{/if}>Ascendent</option>
									<option value="desc" {if $ordonare eq "desc"}selected{/if}>Descendent</option>
								</select>
							</td>	
							<td>dupa data</td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2"><input type="submit" name="afiseaza" value="AFISEAZA" class="buton"></td>
						</tr>
					</table>
				</form>		
				<table width="100%" cellspacing="1" cellpadding="1">
					<tr bgcolor="#EFEFEF">
						<td class="titlu" align="left" style="padding-left:3px" width="70"><b>Data</b></td>
						<td class="titlu" align="left" style="padding-left:3px"><b>Nume</b></td>
						<td class="titlu" align="left" style="padding-left:3px"><b>E-mail</b></td>
						<td class="titlu" align="left" style="padding-left:3px"><b>Telefon</b></td>
						<td class="titlu" align="center"><b>Mesaj</b></td>
						<td class="titlu" align="center"><b>Tip</td>
					</tr>
					{section name=sec loop=$mesaje}
					<tr>
						<td align="left" height="16" valign="top">{$mesaje[sec].data}</td>
						<td align="left" valign="top">{$mesaje[sec].nume}</td>
						<td align="left" valign="top">{$mesaje[sec].email}</td>
						<td align="left" valign="top">{$mesaje[sec].telefon}</td>
						<td align="center" valign="top">
							<a href="{$URL_ADMIN}inbox.php?id_mesaj={$mesaje[sec].id_mesaj}" {if $mesaje[sec].citit eq 0}class="atentie"{/if} title="Citeste mesajul">
								citeste
							</a>
							{if $mesaje[sec].citit neq 0}
							-
							<a href="{$URL_ADMIN}inbox.php?id_msg={$mesaje[sec].id_mesaj}&sterge" title="Sterge mesajul">
								x
							</a>
							{/if}
						</td>
						<td align="center">{$mesaje[sec].tip}</td>
					</tr>	
					{/section}	
					<tr>
						<td colspan="6" bgcolor="#EFEFEF" style="padding-right:5px" align="right" height="16">{$paginare}</td>
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