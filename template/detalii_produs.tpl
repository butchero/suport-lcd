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
				&raquo;
			{/section}	
			{$produs.nume_produs}
		</h2>
	</div>
	<div class="container-detalii">
		<div class="container-galerie">
			<div class="poza-detalii">
				<img src="{$produs.adresa_poza_produs}" alt="{$produs.nume_produs}" id="poza_{$produs.id_produs}" />
			</div>
			<div class="galerie">
				{section name=subsec loop=$produs.poze_sec_mici}
					<div class="galerie-poza-mica">		
						<a href="#" onmouseover="document.getElementById('poza_{$produs.id_produs}').src='{$produs.poze_sec_medii[subsec]}';return false;">
							<img src="{$produs.poze_sec_mici[subsec]}" class="poza-mica" alt="Schimba poza principala" />
						</a>
					</div>			
				{/section}
			</div>
		</div>
		<div class="text-detalii">
			<h3>{$produs.nume_produs}</h3>
			{if $produs.pret_produs neq "0,00"}
			<span class="pret">Pret: {$produs.pret_produs} {$MONEDA}</span>
			{/if}
			<ul>
				<li><strong>Producator</strong>: {$produs.producator}</li>
				{if $produs.cod_produs neq ""}
				<li><strong>EAN</strong>: {$produs.cod_produs}</li>
				{/if}
				{section name=subsec loop=$produs.caracteristici}
				<li><strong>{$produs.caracteristici[subsec].nume_carac}</strong>: {$produs.caracteristici[subsec].val_carac}</li>
				{/section}
			</ul>
			{if $diagonala neq ""}
			<div class="diagonala">{$diagonala}</div>
			{/if}
		</div>
	</div>
	{$produs.descriere_produs}
	<div class="nota">
		Garantie: <strong>{$produs.garantie}</strong> - Preturile contin TVA.
		{if $produs.afiseaza_garan eq "1"}
		<br /><br />
		<a href="{$produs.link_garan_complet}" title="Eticheta GARAN">
			<img src="{$produs.link_garan_nested}" alt="Eticheta GARAN {$produs.garantie}" style="max-width:368px;height:auto;" />
		</a>
		<br />
		<a href="{$produs.link_certificat_garantie}" title="Detalii garantie comerciala" class="link">Detalii garanție comercială</a>
		{/if} 
		<br /><br />
		Pentru informatii suplimentare contactati-ne pe formularul de <a href="{$LINK_CONTACT}" title="Contact" rel="nofollow" class="link">contact</a> sau la unul din telefoanele: <br /><strong>{$TELEFON_COMENZI}</strong>
	</div>
</div>

{include file="bottom.tpl"}