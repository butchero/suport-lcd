<div id="left">
	<div id="categorii"></div>
	<ul>
		{section name=sec loop=$left_menu}
			{if $left_menu[sec].activ eq "1"}
				<li>
					{if $left_menu[sec].nume_cat eq "Serend" or $left_menu[sec].nume_cat eq "Mobuler" or $left_menu[sec].nume_cat eq "Brateck"}
						<span class="menu_left">{$left_menu[sec].nume_cat}</span>
					{else}
					<a href="{$left_menu[sec].link_cat}" title="{$left_menu[sec].nume_cat}" class="{if $left_menu[sec].nivel eq "0"}menu_left{else}submenu_left{/if}{if $left_menu[sec].id_cat eq $cat_selectata} item_selectat{/if}">
						{$left_menu[sec].nume_cat}
					</a>
					{/if}
				</li>
			{/if}
		{/section}	
	</ul>
</div>