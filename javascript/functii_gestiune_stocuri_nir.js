new Ajax.Autocompleter("nume_produs1", "hint", "server/autocomplete_nume_produs.php?id_camp=1", {afterUpdateElement : getSelectionId, indicator : 'indicator1'});																	

function getSelectionId(text, li) 
{
	var id_lista=li.id;    								
	var pieces=id_lista.split("-");
	
	var id_camp=pieces[0];
	var id_produs=pieces[1];
	var cod_produs=pieces[2];
	
	$('cod_produs'+id_camp).value=cod_produs;
	$('id_produs'+id_camp).value=id_produs;
}

function calculeazaValoare(id)
{
	var cantitate=$('cantitate'+id).value;
	var pret_achizitie=$('pret_achizitie'+id).value;

	if(!isNaN(cantitate) && !isNaN(pret_achizitie))
		$('valoare'+id).value=parseFloat(cantitate) * parseFloat(pret_achizitie);	
	
	calculeazaTotalValoare();
}

function removeRowFromTable(tabel)
{
	var tbl=document.getElementById(tabel);
	var lastRow=tbl.rows.length;
	
	if(lastRow>2) 
		tbl.deleteRow(lastRow-1);
		
	calculeazaTotalValoare();	
}

function calculeazaTotalValoare()
{
	var tabel=$("tabel_nir");
	var nr_rows=tabel.rows.length-1;
	var total_valoare=0;
	
	for(var i=1;i<=nr_rows;i++)	
		total_valoare+=parseFloat($('cantitate'+i).value) * parseFloat($('pret_achizitie'+i).value)
		
	$('total_valoare').value=total_valoare;	
}

function addRowToTable(tabel)
{
	var tbl=document.getElementById(tabel);
	var lastRow=tbl.rows.length;
										
	var iteration=lastRow;
	var row=tbl.insertRow(lastRow);
	 
	//-------------------------------------------------- 
	//celula 1
	var celula1=row.insertCell(0);
	
	var el1=document.createElement("input");
	el1.type="text";
	el1.name="cod_produs[]";
	el1.id="cod_produs"+iteration;
	el1.size=12;
	el1.readOnly=true;
	
	celula1.appendChild(el1);
	
	//-------------------------------------------------- 
	//celula 2
	var celula2=row.insertCell(1);
	
	var el2=document.createElement("input");
	el2.type="text";
	el2.name="id_produs[]";
	el2.id="id_produs"+iteration;
	el2.size=4;
	el2.readOnly=true;
	
	var el3=document.createElement("input");
	el3.type="text";
	el3.name="nume_produs[]";
	el3.id="nume_produs"+iteration;
	el3.size=50;									
	
	var spatiere=document.createTextNode(" - ");								
	  									
	celula2.appendChild(el2);	
	celula2.appendChild(spatiere);
	celula2.appendChild(el3);

	//-------------------------------------------------- 
	//celula 3
	var celula3=row.insertCell(2);
	
	var el4=document.createElement("input");
	el4.type="text";
	el4.name="cantitate[]";
	el4.id="cantitate"+iteration;
	el4.size=10;
	el4.onkeyup=function() { calculeazaValoare(iteration); }
										
	celula3.appendChild(el4);	
	
	//-------------------------------------------------- 
	//celula 4
	var celula4=row.insertCell(3);
	
	var el5=document.createElement("input");
	el5.type="text";
	el5.name="pret_achizitie[]";
	el5.id="pret_achizitie"+iteration;
	el5.size=16;
	el5.onkeyup=function() { calculeazaValoare(iteration); }
										
	celula4.appendChild(el5);
	
	//-------------------------------------------------- 
	//celula 5
	var celula5=row.insertCell(4);
	
	var el6=document.createElement("input");
	el6.type="text";
	el6.name="valoare[]";
	el6.id="valoare"+iteration;
	el6.size=15;
	el6.disabled=true;
										
	celula5.appendChild(el6);
	
	//-------------------------------------------------- 
	//celula 6
	var celula6=row.insertCell(5);
	
	var loader=document.createElement('div');
	loader.innerHTML='<img src="'+dir_img+'loader.gif" alt="" id="indicator'+iteration+'" style="display:none">';																		
	celula6.appendChild(loader);
	
	new Ajax.Autocompleter("nume_produs"+iteration, "hint", "server/autocomplete_nume_produs.php?id_camp="+iteration, {afterUpdateElement : getSelectionId, indicator : "indicator"+iteration});							
}