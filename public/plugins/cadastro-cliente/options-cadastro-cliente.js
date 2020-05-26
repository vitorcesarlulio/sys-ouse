/**
 * Opção Cadastro Simples ou Completo 
 */ 
function selTypeRegister() {
    var optionRegisterBasic = document.getElementById("optionRegisterBasic").checked;
    if (optionRegisterBasic) {
      document.getElementById("physicalPerson").style.display = "none";
      document.getElementById("physicalLegal").style.display = "none";
      document.getElementById("optinPerson").style.display = "none";
    } else {
      document.getElementById("physicalPerson").style.display = "block";
      document.getElementById("physicalLegal").style.display = "none";
      document.getElementById("optinPerson").style.display = "block";
    }
  }

/**
 * Opção Casa ou Apartamento
 */ 
  function selTypeResidence() {
    var optionHome = document.getElementById("optionHome").checked;
    if (optionHome) {
      document.getElementById("edifice").style.display = "none";
      document.getElementById("block").style.display = "none";
      document.getElementById("apartment").style.display = "none";
      document.getElementById("number").style.display = "block";
    } else {
      document.getElementById("edifice").style.display = "block";
      document.getElementById("block").style.display = "block";
      document.getElementById("apartment").style.display = "block";
      document.getElementById("number").style.display = "none";
    }
  }

  /**
 * Opção Pessoas Fisica ou Juridica 
 */ 
  function selTypePerson() {
    var physicalPerson = document.getElementById("optionPhysicalPerson").checked;
    if (physicalPerson) {
      document.getElementById("physicalPerson").style.display = "block";
      document.getElementById("physicalLegal").style.display = "none";
    } else {
      document.getElementById("physicalPerson").style.display = "none";
      document.getElementById("physicalLegal").style.display = "block";
    }
  }