{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt="">
			</td>
		</tr>
		<tr>
			<td style="padding:5px">
				<table cellpadding="5" cellspacing="0" width="100%">	
					<tr><td valign="top" align="center">{include file="cont_utilizator/user_menu.tpl"}</td></tr>
					<tr>
						<td align="center">
							<div style="margin-top:20px">
								Bine ai venit <b>{$nume_utilizator}</b>! <br /><br />
								<a href="{$LINK_COSUL_MEU}" class="link_default">Vezi cosul de cumparaturi.</a>
							</div>
						</td>
					</tr>
					<tr>
						<td>
						<div style="margin-top:20px">
							<a href="{$pagina_precedenta}" class="link_default" title="Inapoi la pagina precedenta">
								&laquo; Inapoi la pagina precedenta
							</a>
						</div>
						</td>
					</tr>
				</table>				
				<table width="100%">
					<tr><td align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></td></tr>
				</table>
			</td>
		</tr>	
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt="">
			</td>
		</tr>	
	</table>
</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}