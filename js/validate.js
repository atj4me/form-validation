// To find if the fields in the array is empty
function is_empty(field)
	{	var flag = 0 ;
		for(i = 0; i<field.length; i++) {

			if(obj	=	document.getElementById(field[i])) {
				if(obj.type == "select-one") {
					if(obj.value == '' || obj.value == '0') {
							obj.className += ' cedar-glow';
							flag = 1;}
				}
				else if(obj.value == '')
						{
							obj.className += ' cedar-glow';
							flag = 1;
						}
						else
						{
							obj.className = '';

						}
					}

				}
		if(flag == 1) { return true; }
		else { return false; }
	}
//To check the fields
function checkfield(fieldID, errCls, condi)
{
	var fieldName = $('#'+fieldID);
	if(fieldName.val() == '' || fieldName.val() == null)
	{
		  fieldName.addClass(errCls);
		  fieldName.focus();
		  return false;
	}
	else if(condi != 0 && !condi.test(fieldName.val()))
	{
		  fieldName.addClass(errCls);
		  fieldName.focus();
		  return false;
	}
	else {
		fieldName.removeClass(errCls);
		return true;}
}

/////  validate/////////.

function validatefrm(fields)
{

 if(is_empty(fields) )
 {
    alert('Please fill the required fields marked in red');
    return false;
  }
  else
    return true;
}
