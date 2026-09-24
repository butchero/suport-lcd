{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left" width="500">
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt="">
			</td>
		</tr>
		<tr>
			<td valign="top" style="padding:5px">
			{*----------------------------------------------------------------------CAUTARE---------------------------------------------*}	
			<form action="" method="GET" onSubmit="return doSearch('f_cautare2','text_cautat2')" id="f_cautare2">
			<table cellpadding="2" cellspacing="0" align="center">
				<tr>
					<td>Repeta cautarea:</td>
					<td><input type="text" name="s" value="{$cautare_string}" id="text_cautat2" maxlength="30"></td>
					<td><input type="submit" value="CAUTA DIN NOU" class="buton"></td>
				</tr>	
			</table>	
			</form>
			<div style="margin-top:10px">
				Rezultatele cautarii pentru "<b>{$cautare_string}</b>":
			</div>
			{*--------------------------------------------------------------------END CAUTARE-------------------------------------------*}
			{*---------------------------------------------------------------------PAGINARE---------------------------------------------*}
			<table style="margin-top:10px;margin-bottom:10px;width:100%" class="bg_spatiu">
				<tr>
					<td height="18" style="padding-left:10px">{$paginare}</td>
				</tr>
			</table>
			{*-------------------------------------------------------------------END PAGINARE-------------------------------------------*}	
			{if $produse neq ""}
			<table cellpadding="0" cellspacing="0" width="100%" style="margin-top:10px">										
				{section name=tr loop=$produse step=3}
				<tr>	
					{section name=td start=$smarty.section.tr.index loop=$smarty.section.tr.index+3}
					<td valign="top" align="center" width="166" style="padding-left:1px;padding-right:1px">	
						{if $produse[td].nume_produs neq ""}																
							<table cellpadding="2" class="img">
								<tr>
									<td width="95" height="80" align="center">
										<a href="{$produse[td].link_produs}">
											<img src="{$produse[td].adresa_poza_produs}">
										</a>
									</td>
								</tr>
							</table>
							{*------------------------------------------------NUME PRODUS-------------------------------------------*}
							<div style="margin-top:5px;height:30px;display:table;text-align:center">
								{if $produse[td].tip eq "1"}
									<img src="{$DIR_TEMPLATE}img/oferta_speciala.gif" alt="Oferta speciala">
								{/if}
								<a href="{$produse[td].link_produs}" class="produse" style="font-size:10px">
									<b>{$produse[td].nume_produs}</b> {if $produse[td].producator neq ""}- {$produse[td].producator}{/if}
								</a>
								{if $produse[td].pret_vechi neq ""}
									<br />
									<font class="pret_vechi">{$produse[td].pret_vechi} {$MONEDA}</font>
								{/if}											
							</div>					
							{*----------------------------------------------------END-----------------------------------------------*}	
							{*---------------------------------------------------PRET-----------------------------------------------*}					
							<table cellspacing="3">						
								<tr>
									<td width="85" height="14" class="{if $produse[td].tip eq "1"}box_pret_special{else}box_pret{/if}" align="center">
										{$produse[td].pret_produs} {$MONEDA}
									</td>
									<td width="60" class="box_detalii">
										<a href="{$produse[td].link_produs}" class="detalii">
											DETALII
										</a>	
									</td>
								</tr>
							</table>
							{*----------------------------------------------------END-----------------------------------------------*}					
							{*----------------------------------------------CUMPARA PRODUS------------------------------------------*}
					<img src="{$DIR_TEMPLATE}img/b_cumpara.gif" onMouseOver="this.style.cursor='pointer'" onClick="document.location='{$URL_BASE}adauga_produs.php?id_produs={$produse[td].id_produs}'" alt="Cumpara!">
					{*----------------------------------------------------END-----------------------------------------------*}
							
						{/if}												
					</td>
					{/section}				
				</tr>
				{if !$smarty.section.tr.last}
				<tr><td height="15" colspan="3"></td></tr>
				<tr><td height="1" colspan="3" style="background-image:url({$DIR_TEMPLATE}img/dashed_line.gif);background-repeat:repeat-x;padding:0px"></td></tr>
				<tr><td height="15" colspan="3"></td></tr>
				{/if}		
				{*---------------------------------------------------------END AFISARE PRODUSE-------------------------------------*}
				{/section}						
			</table>
			{/if}		
			</td>
		</tr>	
		<tr><td><img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt=""></td></tr>	
	</table>	
	<p align="right">
		<a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a> &nbsp;&nbsp;
	</p>
</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}