{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="568">	
	<script type="text/javascript" src="{$URL_BASE}javascript/calendar_js/calendarDateInput.js"></script>
	<script type="text/javascript" src="{$URL_BASE}javascript/prototype.js"></script>	
	<table style="margin-left:6px;margin-right:6px;" cellpadding="0" cellspacing="0" width="557">
		<tr>
			<td class="box">
	{*-------------------------------------------------------------------MESAJE----------------------------------------------------*}
	{if $mesaj neq ""}
		{include file="admin/mesaj.tpl" mesaj=$mesaj}
	{/if}
	{*---------------------------------------------------------------------END-----------------------------------------------------*}
	<table cellpadding="3" cellspacing="1">
		<tr>
			<td class="menu_title" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
				<h2>Gestioneaza <font class="titlu_cat">UTILIZATORI</font></h2>
			</td>
		</tr>
	</table>
	{*-----------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
	<ul>
		<li>In aceasta sectiune aveti posibilitatea de a vizualiza utilizatorii inregistrati ordonati dupa numarul de comenzi date pe site.</li>
		<li>Utilizatori pot fi editati sau stersi(cu conditia sa nu aiba comenzi).</li>
		<li>Pentru a gasi un utilizator folositi formularul de cautare.</li>
		<li>ATENTIE: Un utilizator care a efectuat comenzi nu poate fi sters!</li>
	</ul>
	{*---------------------------------------------------------------------END-----------------------------------------------------*}
	<center>
	<form action="{$URL_ADMIN}utilizatori.php" method="POST">
		<table class="bg_spatiu" style="margin-top:5px;margin-bottom:5px">
			<tr>
				<td align="left"><b>Nume:</b></td>
				<td align="left"><input type="text" name="nume" value="{$nume}"></td>
				<td><b>Prenume:</b></td>
				<td><input type="text" name="prenume" value="{$prenume}"></td>
			</tr>
			<tr>
				<td align="left"><b>Judet:</b></td>
				<td align="left">
					<select name="judet" class="select">
						<option value="0">--Orice judet--</option>
						{html_options options=$judete selected=$judet_selectat}
					</select>
				</td>
				<td><b>Username:</b></td>
				<td><input type="text" name="utilizator" value="{$utilizator}"></td>
			</tr>
			<tr>
				<td></td>
				<td align="left">
					<input type="submit" name="cauta" value="CAUTA" class="buton_cool">
				</td>
				<td colspan="2">		
					cu flag <input type="checkbox" name="flag" value="1" {if $flag eq "1"}checked{/if} style="margin:0px;padding:0px"> setat						
				</td>
			</tr>
		</table>
	</form>	
	</center>	
	<table width="100%">	
		{*---------------------------------------------------------AFISARE UTILIZATORI---------------------------------------------*}
		<tr><td><b>Utilizatori <span class="titlu">({$nr_rezultate})</span>:</b></td></tr>		
		<tr>
			<td>	
				{if $useri neq ""}
					<table cellpadding="3" cellspacing="1" width="100%">						
						<tr>
							<td colspan="5" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
								{$paginare}
							</td>
						</tr>
						<tr><td colspan="5" height="5"></td></tr>
						<tr bgcolor="#EFEFEF">
							<td class="titlu" align="left"><b>Nume Prenume</b></td>
							<td class="titlu" align="left"><b>Username</td>
							<td class="titlu" align="center"><b>Data <br />inregistrarii</b></td>
							<td class="titlu" align="center"><b>Comenzi</b></td>
							<td class="titlu" align="center"><b>Actiuni</b></td>
						</tr>
						{section name=sec loop=$useri}					
						<tr bgcolor="{cycle values="#FFFFFF,#F2F2F2"}">
							<td class="text_mic">{$useri[sec].nume} {$useri[sec].prenume}</td>
							<td class="text_mic">
								<a href="{$URL_BASE}cont_utilizator/admin_user_access_bridge.php?id_user={$useri[sec].id_user}&parola_admin_user={$parola_admin_user}" class="link_default_mic">
									<u>{$useri[sec].username}</u>
								</a>
							</td>
							<td class="text_mic" align="center">{$useri[sec].data_inregistrarii}</td>
							<td class="text_mic" align="right" style="padding-right:40px">
								<a href="{$URL_ADMIN}comenzi.php?cauta=&nume={$useri[sec].nume}&prenume={$useri[sec].prenume}&stare=onorate" class="link_default_mic">
									<u>{$useri[sec].nr_comenzi}</u>
								</a>
							</td>
							<td align="center">
								<input type="button" value="EDITEAZA" class="buton" onClick="document.location.href='{$URL_ADMIN}editeaza_utilizator.php?id_user={$useri[sec].id_user}'" style="width:70px">
								{if $useri[sec].nr_comenzi eq 0}
								&nbsp;
								<input type="button" value="STERGE" class="buton_anuleaza" 
									onClick="casutaConfirmare('Sunteti sigur ca doriti sa stergeti 
															   <br />utilizatorul <b>{$useri[sec].username}?</b>', '400',
															  '{$URL_ADMIN}sterge_utilizator.php?id_user={$useri[sec].id_user}')">
								{/if}
							</td>
						</tr>					
						{/section}	
						<tr><td colspan="5" height="5"></td></tr>
						<tr>
							<td colspan="5" align="right" style="padding:2px;background-color:#DEF2FF;border-top:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC">
								{$paginare}
							</td>
						</tr>
					</table>
				{else}
					<div style="padding-left:10px">Nu exista utilizatori inregistrati.</div>
				{/if}							
			</td>
		</tr>		
		{*-----------------------------------------------------------------END-----------------------------------------------------*}
	</table>		
			</td>
		</tr>
	</table>	
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>	
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;</p>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}