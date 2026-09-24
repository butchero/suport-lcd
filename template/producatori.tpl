{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">	
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr><td><img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt=""></td></tr>	
		<tr><td style="padding-left:10px"><h3>Producatori</h3></td></tr>
		<tr>
			<td style="padding-left:10px">
				{if $catalog neq ""}
				<table cellpadding="5" cellspacing="0">	
					<tr>
						<td valign="top" align="center">
							<table cellpadding="3" cellspacing="0">
							{*-----------------------------------------------------------AFISARE PRODUCATORI------------------------------------------------*}
							{section name=tr loop=$catalog step=5}
								<tr>
									{section name=td start=$smarty.section.tr.index loop=$smarty.section.tr.index+5}
									{if $catalog[td].nume_cat neq ""}												
									<td width="125" align="center" valign="top">
										<table>
											<tr>
												<td height="70">
												<a href="{$catalog[td].link_cat}" title="{$catalog[td].nume_cat}" class="produse">
													<img src="{$catalog[td].poza_cat}" alt="{$catalog[td].nume_cat}">
												</a>
												</tr>
											</tr>
										</table>		
										<br />
										<a href="{$catalog[td].link_cat}" title="{$catalog[td].nume_cat}" class="produse">
											{$catalog[td].nume_cat} <font class="nr_produse">({$catalog[td].nr_produse})</font>
										</a>								
									</td>
									{else}
									<td width="125"></td>
									{/if}
									{/section}
								</tr>
							{/section}
							</table>
							{*-------------------------------------------------------------------END--------------------------------------------------------*}
						</td>
					</tr>			
				</table>	
				{/if}
			</td>
		</tr>
		<tr><td><img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt=""></td></tr>	
	</table>
	<br />
	<table width="100%">
		<tr><td align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></td></tr>
	</table>

</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}