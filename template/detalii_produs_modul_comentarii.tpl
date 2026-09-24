{strip}
<script type="text/javascript" language="javascript">
	var insert_ok='{$insert_ok}';		
	if(insert_ok=="1")
		alert("Comentariul a fost adaugat si asteapta aprobare !")		
</script>
Ce spun utilizatorii despre <b>{$produs.nume_produs}</b> 
<br /><br />
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td rowspan="2" valign="top">
			<table cellpadding="0" cellspacing="2">
			{section name=sec loop=$procente}
				<tr>
					<td>{$procente[sec].rating}- </td>
					<td width="100" bgcolor="#F2F2F2"><img src="{$DIR_TEMPLATE}img/bara_procent.jpg" width="{$procente[sec].procent}" height="10" alt=""></td>
					<td>{$procente[sec].procent}%</td> 
				</tr>	
			{/section}
			</table>
		</td>
		<td valign="top" align="right" width="250">
			Total comentarii: <b>{$produs.nr_comentarii}</b>&nbsp;
		</td>
		<td valign="top" align="right" width="84">
			{repeat count=$produs.rating[1]}<img src="{$DIR_TEMPLATE}img/flower.gif" alt="">{/repeat}
			{repeat count=$produs.rating[2]}<img src="{$DIR_TEMPLATE}img/flower_gri.gif" alt="">{/repeat}
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right" valign="top" height="80">
			[<a href="#" onClick="
							{if $username eq ""}
								alert('Trebuie sa fiti logat pentru a folosi aceasta optiune!')
							{elseif $nr_user_comentarii neq "0"}
								alert('Aveti deja un comentariu/rating pt acest produs!')
							{else}
								toggle('comentarii_form')
							{/if};return false;" class="link_default">
				<i>Scrie si tu un comentariu</i>
			 </a>]
			{*---------------------FORMULAR ADAUGARE COMENTARIU(REVIEW)-------------------*}												
			<div id="comentarii_form" style="display:none">
				{if $username neq "" && $nr_user_comentarii eq "0"}
				<form action="" method="POST" onSubmit="return checkForm(new Array('titlu','comentariu'), new Array('Nu ati completat campul titlu !','Nu ati completat campul comentariu/review !'));">
				<table cellpadding="2" cellspacing="0" style="margin-top:5px">
					<tr>
						<td>Rating:</td>
						<td align="left"><select name="rating" class="select" onChange="">{html_options options=$rating}</select></td>
					</tr>
					<tr>
						<td>Titlu:</td>
						<td align="left"><input type="text" name="titlu" maxlength="64" size="40" id="titlu"></td>
					</tr>
					<tr>
						<td>Comentariu:</td>
						<td><textarea name="comentariu" rows="5" cols="40" id="comentariu"></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="button" value="ANULEAZA" class="buton_anuleaza" style="width:80px" onClick="toggle('comentarii_form')">
							&nbsp;
							<input type="submit" name="trimite" value="TRIMITE" class="buton" style="width:80px">
						</td>
					</tr>
					<tr><td colspan="2">* 1 comentariu/rating pentru un produs</td></tr>
				</table>
				</form>
				{/if}
			</div>												
			{*-------------------------------------END-----------------------------------*}
		</td>
	</tr>
</table>
<br />
<table cellpadding="0" cellspacing="0" width="100%">
	{section name=sec loop=$comentarii}
	<tr><td><img src="{$DIR_TEMPLATE}img/comentariu.gif" alt=""> <b>{$comentarii[sec].titlu_comentariu}</b></td></tr>
	<tr><td height="1" class="tab_line"></td></tr>
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td><img src="{$DIR_TEMPLATE}img/creion.gif" alt=""> postat de: <b>{$comentarii[sec].autor}</b> ({$comentarii[sec].data_adaugarii})</td>
					<td align="right">
					{repeat count=$comentarii[sec].rating[1]}<img src="{$DIR_TEMPLATE}img/flower.gif" alt="">{/repeat}
					{repeat count=$comentarii[sec].rating[2]}<img src="{$DIR_TEMPLATE}img/flower_gri.gif" alt="">{/repeat}
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td>{$comentarii[sec].comentariu}</td></tr>
	<tr><td height="10"></td></tr>
	{/section}
	<tr><td align="right">{$paginare_comentarii}</td></tr>
</table>
{if $produs.nr_comentarii eq "0"}
	<p align="center">Nu sunt comentarii pentru produsul: <br /> <b>{$produs.nume_produs}</b></p>
	<p align="center" class="special">Fii primul care scrie un comentariu !</p>
{/if}
{/strip}