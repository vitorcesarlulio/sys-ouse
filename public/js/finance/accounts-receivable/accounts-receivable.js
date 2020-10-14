function showDivPayday() {
    if ($('#remember').is(":checked"))
        $("#divPaydayRegister").show();
    else
        $("#divPaydayRegister").hide();
}




$('#installmentRegister').blur(function () {
    if ($("#installmentRegister").val() === "1") {
        $("#divSettledRegister").show();
    }else{
        $("#divSettledRegister").hide();
    }
});

$(document).ready(function() {
    $("#money").inputmask('decimal', {
        radixPoint: ",",
        groupSeparator: ".",
        autoGroup: true,
        digits: 2,
        digitsOptional: false,
        placeholder: '0',
        rightAlign: false,
        onBeforeMask: function (value, opts){
            return value;
        }
    });
}); 