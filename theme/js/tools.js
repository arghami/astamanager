function findObj(theObj, theDoc)
{
  var p, i, foundObj;
  
  if(!theDoc) theDoc = document;
  if( (p = theObj.indexOf("?")) > 0 && parent.frames.length)
  {
    theDoc = parent.frames[theObj.substring(p+1)].document;
    theObj = theObj.substring(0,p);
  }
  if(!(foundObj = theDoc[theObj]) && theDoc.all) foundObj = theDoc.all[theObj];
  for (i=0; !foundObj && i < theDoc.forms.length; i++) 
    foundObj = theDoc.forms[i][theObj];
  for(i=0; !foundObj && theDoc.layers && i < theDoc.layers.length; i++) 
    foundObj = findObj(theObj,theDoc.layers[i].document);
  if(!foundObj && document.getElementById) foundObj = document.getElementById(theObj);
  
  return foundObj;
}

function invertiLayer(liv) { 
	if ((obj = findObj(liv)) != null) {
		if(obj.style) obj=obj.style
		obj.visibility=='visible'?obj.visibility='hidden':obj.visibility='visible'
	}
}

function delDefaultValue(elem) {	
elemChange = document.getElementById(elem);	
if (elemChange.value == elemChange.defaultValue) {		
elemChange.value='';	
}	
elemChange.style.color = '#000';
}

function checkEmptyValue(elem) {	
elemChange = document.getElementById(elem);	
if (elemChange.value == '') {		
elemChange.style.color = '#bbb';		
elemChange.value = elemChange.defaultValue;	
}
}


/* AGGIUNGA PUFFIN 27-8-9 */
function abilita() { 
if (document.getElementById('attiva_Det').checked == true){
document.getElementById('anni_contratto').disabled = false; 
document.getElementById('flag_prestito').disabled = false; 
document.getElementById('ruolo').disabled = false;  
document.getElementById('flag_primavera').disabled = false;  
}else{
document.getElementById('anni_contratto').disabled = true;
document.getElementById('flag_prestito').disabled = true;  
document.getElementById('ruolo').disabled = true;  
document.getElementById('flag_primavera').disabled = true;  
}
} 

function popupSquadre(argomento){
window.open(argomento,"Lista Squadre","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,width=207,height=300");
}








