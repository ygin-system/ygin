var User = User || {};

User.showPassBind = function(checkBoxId, formId, passFieldName) {
  $("#"+checkBoxId).on("click", function() {
    var $this = $(this);
	var $passField = $("#"+formId+" [name=\""+passFieldName+"\"]:password");
	var $textField;
	if (($textField = $("#"+formId+" [name=\""+$passField.attr("name")+"\"]:text")).length == 0) {
	  $textField = $("<input disabled=\"disabled\" class=\""+$passField.attr("class")+"\" type=\"text\" style=\"display:none\" name=\""+$passField.attr("name")+"\"/>");
	  $textField.insertAfter($passField);
	}
		  
	var $field1, $field2;
	if ($this.prop("checked")) {
	  $field1 = $passField;
	  $field2 = $textField;
	} else {
	  $field1 = $textField;
	  $field2 = $passField;
	}
		  
	var id = $field1.attr("id");
	var value = $field1.val();
	$field1.removeAttr("id").prop("disabled", true).hide();
	$field2.attr("id", id).prop("disabled", false).val(value).show();
  });
} 