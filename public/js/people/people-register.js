/* Função para mostrar ou ocultar campo de acordo com seleção (Tipo de residencia) */
function optionTypeResidenceRegister() {
    var optionHomeRegister = document.getElementById("optionHomeRegister").checked;
    var optionCondominiumRegister = document.getElementById("optionCondominiumRegister").checked;
    if (optionHomeRegister) {
        $('#edificeRegister').val("");
        $('#blockRegister').val("");
        $('#apartmentRegister').val("");
        $('#streetCondominiumRegister').val("");
        $('#numberRegister').val("");

        $("#divEdificeRegister").hide();
        $("#divBlockRegister").hide();
        $("#divApartmentRegister").hide();
        $("#divStreetCondominiumRegister").hide();
        $("#divNumberRegister").show();
    } else if (optionCondominiumRegister) {
        $('#edificeRegister').val("");
        $('#blockRegister').val("");
        $('#apartmentRegister').val("");
        $('#streetCondominiumRegister').val("");
        $('#numberRegister').val("");

        $("#divEdificeRegister").hide();
        $("#divBlockRegister").hide();
        $("#divApartmentRegister").hide();
        $("#divStreetCondominiumRegister").show();
        $("#divNumberRegister").show();
    } else {
        $('#edificeRegister').val("");
        $('#blockRegister').val("");
        $('#apartmentRegister').val("");
        $('#streetCondominiumRegister').val("");
        $('#numberRegister').val("");

        $("#divEdificeRegister").show();
        $("#divBlockRegister").show();
        $("#divApartmentRegister").show();
        $("#divStreetCondominiumRegister").hide();
        $("#divNumberRegister").hide();
    }
}

/**
* Opção Pessoas Fisica ou Juridica 
*/
function selTypePerson() {
    var physicalPerson = document.getElementById("optionPhysicalPerson").checked;
    if (physicalPerson) {
        $("#physicalLegal").hide();
        $("#divCompanyNameRegister").hide();
        $("#divFantasyNameRegister").hide();
        
        $("#physicalPerson").show();
        $("#divNameRegister").show();
        $("#divSurnameRegister").show();
    } else {
        $("#physicalPerson").hide();
        $("#divNameRegister").hide();
        $("#divSurnameRegister").hide();

        $("#physicalLegal").show();
        $("#divCompanyNameRegister").show();
        $("#divFantasyNameRegister").show();
    }
}

function nome da função() {
    $("#id do menu").hide();
}

na label ou no input colocar isso: onclick="nome da função();"