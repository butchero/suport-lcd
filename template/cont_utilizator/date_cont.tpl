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
				<table cellpadding="5" cellspacing="0">	
					{*-------------------------------------------------INCLUDE USER MENU-------------------------------------------*}
					<tr><td valign="top" align="center">{include file="cont_utilizator/user_menu.tpl" menu_selectat="date_cont"}</td></tr>
					{*--------------------------------------------------------END--------------------------------------------------*}
					{*-----------------------------------------------INSTRUCTIUNI UTILIZARE----------------------------------------*}
					<tr>
						<td>		
							<ul>
								<li>In aceasta pagina aveti posibilitatea sa editati datele contului dvs. in afara de username.</li>
								<li>Daca doriti sa cumparati produsele pe firma, completati si datele pt. societate.</li>
							</ul>		
						</td>
					</tr>
					<tr><td height="5"></td></tr>
					<tr><td height="1" class="bg_spatiu" style="padding:0px"></td></tr>
					<tr><td height="5"></td></tr>
					{*--------------------------------------------------------END--------------------------------------------------*}
					{*-----------------------------------------------FORMULAR EDITEAZA CONT----------------------------------------*}	
					<tr><td>{include file="cont_utilizator/form_editeaza_date_cont.tpl"}</td></tr>
					{*--------------------------------------------------------END--------------------------------------------------*}
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