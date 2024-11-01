function tfh_new_family(){
	
  $number = Math.floor(Math.random() * 1000) + 1;

  $z = Math.floor(Math.random() * 20) + 1;

  for ($x = 0;  $x <= $z; $x++){

      $y = 250;

      $number = ($number + ($number = Math.floor(Math.random() * 250+$y) + 1 ));

  }

  document.getElementById("family-id-number").innerHTML= 'Fam-' + $number;

  document.getElementById("family-id-hidden").value = 'Fam-' + $number;

  document.getElementById("family-link-person").style.display = "none";
}

function tfh_show_dropdown(){
	
	document.getElementById("family-link-person").style.display = "block";
	
	document.getElementById("family-link-father").style.display = "none";

    document.getElementById("family-link-role-edit").style.display = "none";

}

function tfh_show_dropdown_child(){
    
    document.getElementById("family-link-father").style.display = "block";
	
	document.getElementById("family-link-person").style.display = "none";

    document.getElementById("family-link-role-edit").style.display = "none";

}

/*function obtain_dropdown_value(){
      
    var a = document.getElementById("thedropdown");
    
    var $value = (a.options[a.selectedIndex].value);

    document.getElementById("family-link-hidden").value = $value;
}*/

/*function show_dropdown_edit(){

    document.getElementById("family-link-role-edit").style.display = "block";

    document.getElementById("family-id-new").style.display = "none";

    document.getElementById("family-link-person").style.display = "none";
}*/

function tfh_new_marriage_partner(){
  
  document.getElementById("marriage_partner_table").style.display = "block";

  document.getElementById("marriage-status-label").innerHTML= 'Married to';

}

function tfh_new_divorced_partner(){
  
  document.getElementById("marriage_partner_table").style.display = "block";

  document.getElementById("marriage-status-label").innerHTML= 'Divorced From';

}

function tfh_new_widowed_partner(){
  
  document.getElementById("marriage_partner_table").style.display = "block";

  document.getElementById("marriage-status-label").innerHTML= 'Widow Of';

}

function tfh_new_separated_partner(){
  
  document.getElementById("marriage_partner_table").style.display = "block";

  document.getElementById("marriage-status-label").innerHTML= 'Separated From';

}

function tfh_new_marriage_partner_nm(){
  
  document.getElementById("marriage_partner_table").style.display = "none";
  
}

/*function show_marriage_status(){

  alert();

  document.getElementById("marriage_status_table").style.display = "block";
}*/

function tfh_show_marriage_status_radio(cb){

   if(cb.checked == true){

    document.getElementById("marriage_status_radio").style.display = "block";
  
  }else{

   document.getElementById("marriage_status_radio").style.display = "none";
  }
  
  

}

/* SHOW/HIDE THE DATE OF DEATH DIV DEPENDING ON RADIO BUTTON SELECTED */

function tfh_status_deceased(){
  
  document.getElementById("d-o-d").style.display = "block";

}

function tfh_status_living(){

  document.getElementById("d-o-d").style.display = "none";
}

function tfh_status_unknown(){

  document.getElementById("d-o-d").style.display = "none";
}