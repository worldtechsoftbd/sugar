"use strict";
    function deleteRowDebtOpen(e) {
        var t = $("#debtAccVoucher > tbody > tr").length;
        if (1 == t) alert("There only one row you can't delete.");
        else {
            var a = e.parentNode.parentNode;
            a.parentNode.removeChild(a)
        }
        calculationDebtOpen();
        calculationCreditOpen();
    }

    //Add new opening balance option
    "use strict";
    function addaccountOpen(divName){
    var row = $("#debtAccVoucher tbody tr").length;
    var optionval = $("#headoption").val();
    var count = row + 1;
    var limits = 500;
    var tabin = 0;
    if (count == limits) alert("You have reached the limit of adding " + count + " inputs");
    else {
          var newdiv = document.createElement('tr');
          var tabin="cmbCode_"+count;
          var tabindex = count * 2;
          newdiv = document.createElement("tr");

          newdiv.innerHTML ="<td> <select name='opening_balances["+count+ "][coa_id]' id='cmbCode_"+ count +"' class='form-control select-basic-single' onchange='load_subtypeOpen(this.value,"+ count +")'></select></td><td><select name='opening_balances["+count+ "][subcode_id]' id='subtype_"+ count +"' class='form-control select-basic-single' ><option value=''>Please select One</option></select></td><td><input type='number' step='0.01' name='opening_balances["+count+ "][debit]' class='form-control total_dprice text-end' id='txtDebit_"+ count +"' onkeyup='calculationDebtOpen("+ count +")'></td><td><input type='number' step='0.01' name='opening_balances["+count+ "][credit]' class='form-control total_cprice text-end' id='txtCredit_"+ count +"' onkeyup='calculationCreditOpen("+ count +")'><input type='hidden' name='opening_balances["+count+ "][is_subtype]' id='isSubtype_"+ count +"'  value='1'/></td><td><button  class='btn btn-danger-soft btn-sm' type='button' value='delete' onclick='deleteRowDebtOpen(this)'><i class='fa fa-trash'></i></button></td>";
          document.getElementById(divName).appendChild(newdiv);
          $("#cmbCode_"+count).html(optionval);
          $('#subtype_'+count).attr("disabled","disabled");
          document.getElementById(tabin).focus();
          count++;

          $("select.form-control:not(.dont-select-me)").select2({
              placeholder: "Select option",
              allowClear: true
          });

          autoSelect();
          autocompleteOff();
        }
    }
