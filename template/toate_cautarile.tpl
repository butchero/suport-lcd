{include file="top.tpl"}
{include file="left.tpl"}
{strip}
<td valign="top" align="left">
	<form action="" method="POST">
	<table cellpadding="0" cellspacing="0" width="500" style="margin-top:10px;background:url({$DIR_TEMPLATE}{$POZE_DIR}/middle_chenar.gif);background-repeat:repeat-y">										
		<tr>
			<td colspan="3">
				<img src="{$DIR_TEMPLATE}{$POZE_DIR}/top_chenar.gif" alt="">
			</td>
		</tr>
		<tr>
			<td valign="top" style="padding:5px">				
				<div style="margin-left:2px;margin-top:2px"><h3>{$titlu_pagina}</h3></div>
				<table width="100%" style="margin-top:5px">
					<tr><td colspan="4" style="padding:2px;background-color:#F2F2F2" align="right">{$paginare}</td></tr>
					<tr><td colspan="4" height="2"></td></tr>
					{section name=tr loop=$toate_cautarile step=2}
					<tr>
						{section name=td start=$smarty.section.tr.index loop=$smarty.section.tr.index+2} 
						<td>{if $toate_cautarile[td].cautare neq ""}<a href="{$toate_cautarile[td].link_cautare}" class="link_default">{$toate_cautarile[td].cautare}</a>{/if}</td>
						<td width="50" align="right">{if $toate_cautarile[td].contor neq ""}[{$toate_cautarile[td].contor}]{/if}</td>
						{/section}
					</tr>
					{/section}
					<tr><td colspan="4" height="2"></td></tr>
					<tr><td colspan="4" style="padding:2px;background-color:#F2F2F2" align="right">{$paginare}</td></tr>
				</table>				
			</td>
		</tr>	
		<tr><td><img src="{$DIR_TEMPLATE}{$POZE_DIR}/bottom_chenar.gif" alt=""></td></tr>	
	</table>
	</form>
</td>
{/strip}
{include file="right.tpl"}
{include file="bottom.tpl"}