{include file="admin/top.tpl"}
{include file="admin/left.tpl"}
{strip}
<td valign="top" align="left" width="570">
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
						<h2>Administrare site</h2>			
					</td>
				</tr>
			</table>	
			<table cellpadding="5" cellspacing="0" class="box" width="557">	
				<tr>
				{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
					<td>		
						<p><b>Downlodeaza lista produse:</b></p>
						<ul>
						{section name=sec loop=$disponibilitati}													
							<li>
								<a href="{$URL_BASE}oferta_excel.php?id_disponibilitate={$disponibilitati[sec].id_stoc}" title="Click pentru a downloada excelul cu produse '{$disponibilitati[sec].stoc}'">
									Downloadeaza produse <b>"{$disponibilitati[sec].stoc}"</b> - ({$disponibilitati[sec].nr_produse})
								</a>
							</li>
						{/section}
						</ul>						
						<table bgcolor="#EFEFEF" width="100%">
							<tr>
								<td align="center">	
									Ponderea produselor in categorii (cate produse sunt in fiecare categorie procentual)					
								</td>
							</tr>
						</table>		
						<center>
							<img src="{$URL_ADMIN}pondere_produse_in_categorii.php" alt="Pondere produse in categorii">
						</center>
					</td>
				</tr>
			</table>	
			</tr>
		</tr>
	</table>		
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}