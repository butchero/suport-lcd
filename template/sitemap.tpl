{include file="top.tpl"}
{include file="left.tpl"}

<div id="right">
	<h3>{$titlu_pagina}</h3>
	
	{section name=sec loop=$sitemap}
	{if $sitemap[sec].activ eq "1" && $sitemap[sec].nume_cat neq "Mobuler" && $sitemap[sec].nume_cat neq "Serend"}
		{$sitemap[sec].indent}
		<a href="{$sitemap[sec].link_cat}" title="{$sitemap[sec].nume_cat}" class="{if $sitemap[sec].nivel eq "0"}menu_left{else}submenu_left{/if}">
			{$sitemap[sec].nume_cat}	
		</a>
		<br />
	{/if}	
	{/section}

	<br />
	<a href="{$URL_BASE}" class="menu_left">Suport LCD, Suporti LCD, Suporturi LCD</a><br />
	<a href="{$LINK_DESPRE_NOI}" class="menu_left" rel="nofollow">Despre Noi</a><br /> 
	<a href="{$LINK_CONTACT}" class="menu_left" rel="nofollow">Contact</a>
						
</div>

{include file="right.tpl"}
{include file="bottom.tpl"}