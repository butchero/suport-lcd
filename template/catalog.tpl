{include file="top.tpl"}
{include file="left.tpl"}

<div id="right">
	<div class="nume-cat">
		<h2>
			{section name=sec loop=$radacina}
				{if $radacina[sec].nume_radacina eq "Serend" or $radacina[sec].nume_radacina eq "Mobuler"}
						<span class="radacina">{$radacina[sec].nume_radacina}</span>
				{else}
				<a href="{$radacina[sec].link_radacina}" title="{$radacina[sec].nume_radacina}" class="radacina">
					{$radacina[sec].nume_radacina}
				</a>
				{/if} 
				 &nbsp;
				{if !$smarty.section.sec.last}&raquo;{/if}
			{/section}	
		</h2>		
	</div>
	
	<div class="catalog-border"></div>
	{section name=sec loop=$produse}
		<div class="{if $produse[sec].border neq "1"}produs-catalog-border{else}produs-catalog{/if}">
			<h3><a href="{$produse[sec].link_produs}" title="{$produse[sec].nume_produs}">{$produse[sec].nume_produs}</a></h3>
			{if $produse[sec].pret_produs neq "0,00"}
			<span class="pret">Pret: {$produse[sec].pret_produs} {$MONEDA}</span> <br />
			{/if}
			<img src="{$produse[sec].adresa_poza_produs}" alt="{$produse[sec].nume_produs}" />
			<ul>
				{section name=subsec loop=$produse[sec].caracteristici}								
					<li><strong>{$produse[sec].caracteristici[subsec].nume_carac}</strong>: {$produse[sec].caracteristici[subsec].val_carac}</li>			
				{/section}
			</ul>
			<a href="#" onclick="document.location.href='{$produse[sec].link_produs}'" class="detalii"></a>
		</div>
		{if $produse[sec].border eq "1" && !$smarty.section.sec.last}
		<div class="catalog-border"></div>
		{/if}
	{sectionelse}
		<p>{if $cautare_string|default:"" neq ""}Nu am gasit produse pentru "<b>{$cautare_string|escape}</b>".{else}Momentan nu sunt produse in aceasta categorie.{/if}</p>	
	{/section}
	
	{if $produse neq ""}
	<div class="paginare">
		{$paginare}
	</div>
	<div class="nota">
		<strong>Nota:</strong> Preturile contin TVA. Pentru informatii suplimentare contactati-ne pe formularul de <a href="{$LINK_CONTACT}" title="Contact" rel="nofollow" class="link">contact</a> sau la unul din telefoanele: <strong>{$TELEFON_COMENZI}</strong>
	</div>	
	{/if}
</div>				

{include file="bottom.tpl"}