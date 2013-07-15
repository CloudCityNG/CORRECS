// JavaScript Document
window.onload = initForm;

function initForm(){
	/*document.getElementById("college").selectedIndex = 0;
	document.getElementById("college").onchange = populateDepartments;
	document.getElementById("department").selectedIndex = 0;
	document.getElementById("department").onchange = populateProgrammes;*/
	//alert("welcome!");
}

function populateDepartments(){
	var comasDept = new Array("select COMAS department", "Economics and Financial Studies", "Political Science and Public Administration","Department of Sociology", "Business Administration");
	var conasDept = new Array("select CONAS department","Chemical Sciences", "Biological Sciences", "Math. and Computer-Sciences", "Physics With Electronics");
	var comasId = new Array("", 111, 112,115,116 );
	var conasId = new Array("", 113,114,117,118);
	var collegeStr = this.options[this.selectedIndex].value;
	if(collegeStr != ""){
		document.getElementById("department").options.length = 0;
		if(collegeStr == 101){
			for(var i=0; i<conasDept.length;i++){
				document.getElementById("department").options[i] = new Option(conasDept[i]);
				document.getElementById("department").options[i].value = conasId[i];
			}
		}
		if(collegeStr == 102){
			for(var i=0; i<comasDept.length;i++){
				document.getElementById("department").options[i] = new Option(comasDept[i]);
				document.getElementById("department").options[i].value = comasId[i];
				
			}
		}
	
	}
	
}

function populateProgrammes(){
	var deptStr = this.options[this.selectedIndex].value;
	if(deptStr == 111){
		ecoProgramme = new Array("Select Programme", "Economics", "Accounting");
		ecoId = new Array("",122, 123 );
		for(var i=0; i<ecoProgramme.length;i++){
			document.getElementById("programme").options[i] = new Option(ecoProgramme[i]);
			document.getElementById("programme").options[i].value = ecoId[i];
			
		}
		
	}
	if(deptStr == 112){
		ecoProgramme = new Array("Select Programme", "Political Science and Public Administration");
		ecoId = new Array("",129);
		for(var i=0; i<ecoProgramme.length;i++){
			document.getElementById("programme").options[i] = new Option(ecoProgramme[i]);
			document.getElementById("programme").options[i].value = ecoId[i];
			
		}
		
	}
	
	else if(deptStr == "");
}