{include file="top.tpl" show_promo="1"}
{include file="left.tpl"}

<div id="right">
	<div id="container-ult-prod">
		<div id="ultimele-produse"></div>
		<div class="container-produse">
			{section name=sec loop=$produse}
			<div class="produs{if !$smarty.section.sec.last} produs-border{/if}">
				<h3><a href="{$produse[sec].link_produs}" title="{$produse[sec].nume_produs}">{$produse[sec].nume_produs}</a></h3>
				<a href="{$produse[sec].link_produs}" title="{$produse[sec].nume_produs}" rel="nofollow">
					<img src="{$produse[sec].adresa_poza_produs}" alt="" />
				</a>
				<a href="{$produse[sec].link_produs}" title="{$produse[sec].nume_produs}" class="detalii">{$produse[sec].nume_produs}</a>
			</div>
			{/section}
		</div>
	</div>
	<div id="container-despre-noi">
		<div id="despre-noi"></div>
		{$text_despre_noi}
	</div>
	<div id="container-contact">
		<div id="contact"></div>
		{$text_contact}
		<p><a href="{$LINK_CONTACT}" rel="nofollow" class="citeste">Vezi formular de contact</a></p>
	</div>
</div>	

{include file="bottom.tpl" show_links="1" seo_index="1"}