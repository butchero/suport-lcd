function NewWindow(mypage, myname, w, h, scroll)
{
	var win = null;
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
	win = window.open(mypage, myname, settings)
}

function $(v) 
{
	return(document.getElementById(v)); 
}

function $S(v) 
{ 
	return($(v).style); 
}

function agent(v) 
{ 
	return(Math.max(navigator.userAgent.toLowerCase().indexOf(v),0)); 
}

function isset(v) 
{ 
	return((typeof(v)=='undefined' || v.length==0)?false:true); 
}

function XYwin(v) 
{ 
	var z=agent('msie')?Array(document.body.clientHeight,document.body.clientWidth):Array(window.innerHeight,window.innerWidth); 
	
	return(isset(v)?z[v]:z); 
}

function toggleBG() 
{ 	
	$S('cover_all').display='none';
	$S('casuta_confirmare').display='none';
}

function casutaConfirmare(v, b, link) 
{ 
	$S('cover_all').height='100%';
	$S('cover_all').display='block';
	$('casuta_confirmare').innerHTML='<div style="padding:5px">'+v+'<\/div><div style="padding:5px"><input type="button" value="DA" class="buton" onClick="window.location.href=\''+link+'\'"> <input type="button" value="NU" class="buton_anuleaza" onClick="toggleBG()"></div>'+'<div class="casuta_ajutor"><b>(Confirma actiunea)</b><\/div>';
	$S('casuta_confirmare').left=Math.round((XYwin(1)-b)/2)+'px';
	$S('casuta_confirmare').width=b+'px';
	$S('casuta_confirmare').display='block'; 	
	window.location.href='#top';	
}

function setComanda(v, b, link) 
{ 
	$S('cover_all').height='100%';
	$S('cover_all').display='block';
	$('casuta_confirmare').innerHTML='<form action='+link+' method=POST><div style="padding:5px">'+v+'<\/div><div style="padding:5px"><input type="button" value="DA" class="buton" onClick="this.form.submit()"> <input type="button" value="NU" class="buton_anuleaza" onClick="toggleBG()"></div>'+'<div class="casuta_ajutor"><b>(Confirma actiunea)</b><\/div></form>';
	$S('casuta_confirmare').left=Math.round((XYwin(1)-b)/2)+'px';
	$S('casuta_confirmare').width=b+'px';
	$S('casuta_confirmare').display='block'; 	
	window.location.href='#top';	
}

function ordoneazaCategorii()
{
	var url='server_ordoneaza_categorii.php';
	$S('indicator').display='block';
	
    var options = {
                    method : 'post',
                    parameters : Sortable.serialize('categorii_list'),
                    onComplete : function(request) 
                    {
                        $S('indicator').display='none';
                    }
                  };
 
    new Ajax.Request(url, options);
}

function ordoneazaFiltre()
{
	var url='server_ordoneaza_filtre.php';
	$S('indicator').display='block';
	
    var options = {
                    method : 'post',
                    parameters : Sortable.serialize('filtre_list'),
                    onComplete : function(request) 
                    {
                        $S('indicator').display='none';
                    }
                  };
 
    new Ajax.Request(url, options);
}

function toggleEnable(id)
{
	if($(id).disabled==true)
		$(id).disabled=false;
	else $(id).disabled=true;
}

function toggleEnableAndShowDiv(id1, id2)
{
	if($(id1).disabled==false)
	{
		$(id1).disabled=true;
		$S(id2).display='block';
	}
	else
	{
		$(id1).disabled=false;
		$S(id2).display='none';
	}
}

function toggleCategoriiActivare(id_cat)
{
	var url='server_toggle_categorii_activare.php';
	var rand=Math.random(9999);
	var value;
	
	if($(id_cat).checked==true)
		value=1;
	else
		value=0;	
	
	var param='id_cat='+id_cat+'&activ='+value+'&rand='+rand;
	
	var options = {
					method : 'get',
					parameters : param,
					onLoading : function()
					{
						$S('indicator_top').display='block';
						$('indicator_top').innerHTML=loader; //loader e definita in top.tpl
					},
					onComplete : showResponse					
				  }
	
	var myAjax=new Ajax.Request(url, options);
}

function showResponse(originalRequest) 
{
	var active=originalRequest.responseText;
	
	if(active=="1")
		$('indicator_top').innerHTML="<font class='mesaj_ajax'>&nbsp;Categoria a fost activata!&nbsp;</font>";
	else if(active=="0")
		$('indicator_top').innerHTML="<font class='mesaj_ajax'>&nbsp;Categoria a fost dezactivata!&nbsp;</font>";
	else 
		$('indicator_top').innerHTML="<font class='mesaj_ajax'>&nbsp;EROARE: Categoria nu a putut fi modificata!&nbsp;</font>";	
}

function submitForm(url, id_form)
{		
	var formular=$(id_form);	
	formular.action=url;
	formular.submit();
}

function addValoareFiltru(id_div)
{
	var formular=$("formular"+id_div);
	var z='Valoare: <input type="text" name="valoare_noua" size="30"> ';
	var x='<input type="submit" value="ADAUGA" class="buton_simplu" style="width:80px"> ';
	var y='<input type="button" value="RENUNTA" class="buton_anuleaza" style="width:80px" onClick="delValoareFiltru('+id_div+')">';
	
	$(id_div).innerHTML=z+x+y;
}

function delValoareFiltru(id_div)
{
	$(id_div).innerHTML='<a href="#" class="link_default" title="Adauga valoare noua" onclick="addValoareFiltru('+id_div+')"><b>[+] ADAUGA VALOARE NOUA</b></a>';
}

//@afisare detalii comenzi noi
function getInfoComanda(id_comanda)
{
	var url='server_get_info_comanda.php';
	var rand=Math.random(9999);
		
	var param='id_comanda='+id_comanda;
	
	var options = {
					method : 'get',
					parameters : param,
					onLoading : function()
					{
						$('comanda_'+id_comanda).innerHTML=loader; //loader e definita in top.tpl
					},
					onComplete : showInfoComanda					
				  }
	
	var myAjax=new Ajax.Request(url, options);
}

function showInfoComanda(originalRequest) 
{
	var info=originalRequest.responseText;
	
	var pieces=info.split("--|x|--");
	
	$('comanda_'+pieces[0]).innerHTML=pieces[2];
	
	if(pieces[1]=="0")
		$('comanda_status_'+pieces[0]).innerHTML='Status: [<b>in procesare</b>]';
	
}

function closeInfoComanda(id_comanda)
{
	$('comanda_'+id_comanda).innerHTML='<input type="button" value="DETALII CUMPARATOR" class="buton" onClick="getInfoComanda('+id_comanda+')" style="width:150px">';
}

function toggleProduseNewsletter(id_produs)
{
	var url='server_toggle_produse_newsletter.php';
	var rand=Math.random(9999);
	var value;
	
	if($(id_produs).checked==true)
		value=1;
	else
		value=0;	
	
	var param='id_produs='+id_produs+'&activ='+value+'&rand='+rand;
	
	var options = {
					method : 'get',
					parameters : param,
					onLoading : function()
					{
						$S('indicator_top').display='block';
						$('indicator_top').innerHTML=loader; //loader e definita in top.tpl
					},
					onComplete : showResponseNewsletter					
				  }
	
	var myAjax=new Ajax.Request(url, options);
}

function showResponseNewsletter(originalRequest) 
{
	var active=originalRequest.responseText;
	
	if(active=="1")
		$('indicator_top').innerHTML="<font class='mesaj_ajax'>&nbsp;Produsul a fost adaugat la newsletter!&nbsp;</font>";
	else if(active=="0")
		$('indicator_top').innerHTML="<font class='mesaj_ajax'>&nbsp;Produsul a fost scos din newsletter!&nbsp;</font>";
	else 
		$('indicator_top').innerHTML="<font class='mesaj_ajax'>&nbsp;EROARE: Produsul nu a putut fi modificat!&nbsp;</font>";	
}

function refreshGrupuriFiltre(param_id_grup, param_id_cat)
{
	//get selected value
	var sel=$(param_id_grup);
	var id_grup=sel.options[sel.selectedIndex].value;
	
	var sel=$(param_id_cat);
	var id_cat=sel.options[sel.selectedIndex].value;

	var url='server_refresh_grupuri_filtre.php';
	var rand=Math.random(9999);
	
	var param='id_grup='+id_grup+'&id_cat='+id_cat+'&rand='+rand;
	
	var options = {
					method : 'get',
					parameters : param,
					onLoading : function()
					{						
						$('box_bloc1').innerHTML=loader;
						$('box_bloc2').innerHTML=loader;						
					},
					onComplete : showResponseGrupuriFiltre					
				  }
	
	new Ajax.Request(url, options);
}

function showResponseGrupuriFiltre(originalRequest)
{
	var stream=originalRequest.responseText;	
	var pieces=stream.split("--|x|--");
	
	$('box_bloc1').innerHTML=pieces[0];
	$('box_bloc2').innerHTML=pieces[1];
}

function copyToList(from, to)
{
	fromList=document.getElementById(from);
	toList=document.getElementById(to);
	
	if(toList.options.length>0 && toList.options[0].value=="temp")
	{
		toList.options.length=0;
	}
	
	var sel = false;
	
	for(i=0;i<fromList.options.length;i++)
	{
		var current=fromList.options[i];
		
		if(current.selected)
		{
			sel=true;
			
			if(current.value == 'temp')
			{
				alert ('Nu puteti muta aceste filtre!');
				return;
			}
			
			txt=current.text;
			val=current.value;
			toList.options[toList.length]=new Option(txt,val);
			fromList.options[i]=null;
			i--;
		}
	}
	
	if(!sel)
	{
		alert('Nu ati selectat nici un filtru!');
	}
}

function allSelect(form, lista1, lista2)
{
	list=document.getElementById(lista1);

	for(i=0;i<list.length;i++)
		list.options[i].selected=true;
		
	list=document.getElementById(lista2);	

	for(i=0;i<list.length;i++)	
		list.options[i].selected=true;
		
	form.submit();	
}

//@afisare produs pt chilipir
function afiseazaProdusChilipir(id_produs, an, luna, ziua)
{
	var url='server_get_chilipir.php';
	var rand=Math.random(9999);
		
	var param='id_produs='+id_produs+'&an='+an+'&luna='+luna+'&ziua='+ziua;
	
	var options = {
					method : 'get',
					parameters : param,
					onLoading : function()
					{
						$('chilipir_container').innerHTML=loader; //loader e definita in top.tpl
					},
					onComplete : showChilipir					
				  }
	
	var myAjax=new Ajax.Request(url, options);
}

function showChilipir(originalRequest) 
{
	var info=originalRequest.responseText;
	
	$('chilipir_container').innerHTML=info;
}

//@afisare produs pt chilipir
function setUserFlag(id_user)
{
	var url='server_set_user_flag.php';
	var rand=Math.random(9999);
		
	if($('flag_user').checked==true)
		flag=1;
	else
		flag=0;
	
	var param='id_user='+id_user+'&flag='+flag+'&rand='+rand;
	
	var options = {
					method : 'get',
					parameters : param,
					onLoading : function()
					{
						$('flag_loader').innerHTML=loader; //loader e definita in top.tpl
					},
					onComplete : showFlagRaspuns					
				  }
	
	var myAjax=new Ajax.Request(url, options);
}

function showFlagRaspuns(originalRequest) 
{
	var info=originalRequest.responseText;
	
	$('flag_loader').innerHTML=info;
}

function setStoc(id_produs, id_stoc)
{
	var url='server_set_stoc.php';
	var rand=Math.random(9999);
		
	var param='id_produs='+id_produs+'&id_stoc='+id_stoc+'&rand='+rand;
	
	var options = {
					method : 'get',
					parameters : param,
					onLoading : function()
					{
						$S('indicator_top').display='block';
						$('indicator_top').innerHTML=loader; //loader e definita in top.tpl
					},
					onComplete : showResponseStoc				
				  }
	
	var myAjax=new Ajax.Request(url, options);
}

function showResponseStoc(originalRequest) 
{
	var info=originalRequest.responseText;
	
	$('indicator_top').innerHTML="<font class='mesaj_ajax'>&nbsp;"+info+"&nbsp;</font>";
}

function getCheckedValue(radioObj) 
{
	if(!radioObj)
		return "";
		
	var radioLength = radioObj.length;
	
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
			
	for(var i = 0; i < radioLength; i++) 
	{
		if(radioObj[i].checked) 
		{
			return radioObj[i].value;
		}
	}
	return "";
}