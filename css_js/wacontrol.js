jQuery(document).ready(function(){
  $('#ajax_form').submit(function(){
    var min = 1111;
    var max = 9999;
    var num = Math.floor(Math.random() * (max - min + 1)) + min;

    var dados = $(this).serialize();
    $.ajax({
      type: "POST",
      cache: false,
      url: "https://www.m7admin.com.br/ReportaBug/?ReportarBug&id="+num+"",
      data: dados,
      beforeSend: function(data){
        swal("Aguarde!", "Estamos enviando os dados preechidos acima.\nAguarde a mensagem de sucesso.", "info")
      },
      complete: function( data ){
        $(ajax_form).each(function(){ this.reset(); });
        swal("Bug Reportado!", "Bug Reportado com Sucesso!\nIremos lhe responder o mais rápido possível.\nID do Bug #"+num+"", "success")
      }
    });
    return false;
  });
});

function Copiado(id){
    var clipboard = new Clipboard('#btnCopiar'+ id);
    clipboard.on('success', function(e) {
        document.getElementById('btnCopiar'+id).innerHTML= 'Copiado!';
        document.getElementById("btnCopiar"+id).disabled = true;
    });
}

function CopiadoCodHead(id){
    var clipboard = new Clipboard('#btnCopiarCodHead'+ id);
    clipboard.on('success', function(e) {
        document.getElementById('btnCopiarCodHead'+id).innerHTML= 'Copiado!';
        document.getElementById("btnCopiarCodHead"+id).disabled = true;
    });
}

function CopiadoCodSite(id){
    var clipboard = new Clipboard('#btnCopiarCodSite'+ id);
    clipboard.on('success', function(e) {
        document.getElementById('btnCopiarCodSite'+id).innerHTML= 'Copiado!';
        document.getElementById("btnCopiarCodSite"+id).disabled = true;
    });
}

function CopiadoCodSiteWNoticias(id){
    var clipboard = new Clipboard('#btnCopiarCodSiteWNoticias'+ id);
    clipboard.on('success', function(e) {
        document.getElementById('btnCopiarCodSiteWNoticias'+id).innerHTML= 'Copiado!';
        document.getElementById("btnCopiarCodSiteWNoticias"+id).disabled = true;
    });
}

function CopiadoCodSiteWa4(id){
    var clipboard = new Clipboard('#btnCopiarCodSiteWa4'+ id);
    clipboard.on('success', function(e) {
        document.getElementById('btnCopiarCodSiteWa4'+id).innerHTML= 'Copiado!';
        document.getElementById("btnCopiarCodSiteWa4"+id).disabled = true;
    });
}

function CopiadoCodSiteWa4WNoticias(id){
    var clipboard = new Clipboard('#btnCopiarCodSiteWa4WNoticias'+ id);
    clipboard.on('success', function(e) {
        document.getElementById('btnCopiarCodSiteWa4WNoticias'+id).innerHTML= 'Copiado!';
        document.getElementById("btnCopiarCodSiteWa4WNoticias"+id).disabled = true;
    });
}

// Deletar Item
function DeletarItem(id, get){
  swal({   
    title: "Você tem certeza?",   
    text: "Deseja realmente deletar este item?",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Sim!",   
    cancelButtonText: "Não!",   
    closeOnConfirm: false,   
    closeOnCancel: false }, 
    function(isConfirm){   
      if (isConfirm) {  
        window.location = '?'+get+'='+id;   
      } else {     
        swal("Cancelado", "O procedimento foi cancelado :)", "error");   
      } 
    });
}