<div id="left">
	<form action="" method="get" id="f_cautare" onsubmit="return cautaProdus();">
		<label for="text_cautat" class="menu_left">Cauta produs</label>
		<input type="text" id="text_cautat" class="cauta-camp" maxlength="40" value="{$cautare_string|default:""|escape}" placeholder="titlu sau EAN">
		<input type="submit" class="cauta-buton" value="Cauta">
	</form>
	<div id="categorii"></div>
	<script type="text/javascript">
	function cautaProdus()
	{ldelim}
		var camp=document.getElementById("text_cautat");
		var text=camp.value.replace(/^\s+|\s+$/g, "");
		if(text.length<3)
		{ldelim}
			alert("Cautarea se face dupa minim 3 caractere!");
			return false;
		{rdelim}
		var slug=text.replace(/[^A-Za-z0-9]+/g, "-").replace(/^-+|-+$/g, "");
		window.location.href="{$URL_BASE}cautare/"+slug;
		return false;
	{rdelim}
	</script>
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