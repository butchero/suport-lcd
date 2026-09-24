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
	{*------------------------------------------------------------ORDONEAZA CATEGORII----------------------------------------------*}
	<table cellpadding="0" cellspacing="0" class="menu_container" style="background:url({$DIR_TEMPLATE}img/bg_menu.gif);border-top:1px solid #F2F2F2;border-left:1px solid #F2F2F2;border-right:1px solid #F2F2F2;">
		<tr>
			<td align="left" class="menu_title" height="18" style="padding-left:2px;padding-right:2px">
				<h2>Ordoneaza {if $nume_parinte neq ""}sub{/if}{if $ordoneaza eq "producatori"}producatorii{else}categoriile{/if} {if $nume_parinte neq ""} din: <font class="titlu_cat">{$nume_parinte|upper}</font>{/if}</h2>			
			</td>
		</tr>
	</table>			
	{*---------------INCLUD O VERSIUNE MAI VECHE (nu merge ordonarea pe ultimile versiuni de prototype si scriptaculous)-----------*}
	<script type="text/javascript" src="{$URL_BASE}javascript/scriptaculous-js-1.5.3/prototype.js"></script>
    <script type="text/javascript" src="{$URL_BASE}javascript/scriptaculous-js-1.5.3/scriptaculous.js"></script>    
	<table cellpadding="5" cellspacing="0" class="box" width="557" style="background-color:#F2F2F2">	
		<tr>
		{*-------------------------------------------------------INSTRUCTIUNI UTILIZARE--------------------------------------------*}
			<td colspan="2">		
				<ul>
					<li>In aceasta pagina aveti posibilitatea de a ordona {if $ordoneaza eq "producatori"}producatorii{else}categoriile{/if}.</li>
					<li>Ordonarea se face prin drag & drop.</li>
					<li class="atentie">ATENTIE: Nu exista confirmare pentru ordonarea.</li>
				</ul>		
			</td>				
		</tr>
		{*----------------------------------------------------------------END------------------------------------------------------*}
		<tr>
			<td width="400">
				<ul id="categorii_list" class="sortable-list">
					{section name=sec loop=$categorii}
					<li id="categorie_{$categorii[sec].id_cat}">{$categorii[sec].nume_cat}</li>
					{/section}
				</ul>
				<script type="text/javascript" language="javascript">
			    	var id_parinte={$id_parinte};
			    </script>
				{literal}
				<script type="text/javascript">
					//ordoneazaCategorii() e definita in functii/functii_admin.js
			    	Sortable.create('categorii_list', { onUpdate : ordoneazaCategorii });
			    </script>
			    {/literal}
			    {if $categorii neq ""}
			    <center>
				    <form action="" method="POST">
				    	<input type="submit" name="ordoneaza_alfabetic" value="RESETEAZA LA ORDONAREA ALFABETICA" class="buton_cool" style="width:260px">
				    </form>	
			    </center>
			    {/if}
			</td>
			<td valign="middle" width="157">
				<div id="indicator" style="display:none;margin:10">
					<img src="{$DIR_TEMPLATE}img/loader.gif" alt=""> 
					Ordonez...
				</div>
			</td>
		</tr>
	</table>	
	{*---------------------------------------------------------------END ORDONARE--------------------------------------------------*}		
	<p align="center"><a href="{$link_inapoi}" class="link_default">&laquo; Inapoi</a></p>
	<p align="right"><a href="#top"><img src="{$DIR_TEMPLATE}img/top.gif" alt="top"></a></p>
			</td>
		</tr>
	</table>
</td>
{/strip}
{include file="admin/right.tpl"}
{include file="admin/bottom.tpl"}