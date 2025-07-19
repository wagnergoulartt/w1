function AgendaEventos(Categoria, Pagina){
    var UrlPainel = $('#AgendaEventosWA'+Categoria).attr("data-painel");
    
    $.ajax({
        type: "GET",
        cache: false,
        url: UrlPainel+'wa/agenda/agenda.php?id='+Categoria+'&pag='+Pagina,
        beforeSend: function (data){
            //$("#AgendaEventosWA"+Categoria).html("<center><br><img src=\""+UrlPainel+"wa/css_js/loading.gif\"><br>Carregando...<br></center>");
        },
        success: function (data) {
            jQuery('#AgendaEventosWA'+Categoria).html(data);
        },
        error: function (data) {
            setTimeout(function(){ AgendaEventos(Categoria, Pagina); }, 5000);
        },
    });
}
function AbreEvento(Evento, Categoria, Pagina){
    var UrlPainel = $('#AgendaEventosWA'+Categoria).attr("data-painel");
    
    $.ajax({
        type: "GET",
        cache: false,
        url: UrlPainel+'wa/agenda/evento.php?id='+Evento+'&categoria='+Categoria+'&back='+Pagina,
        beforeSend: function (data){
            //$("#AgendaEventosWA"+Categoria).html("<center><br><img src=\""+UrlPainel+"wa/css_js/loading.gif\"><br>Carregando...<br></center>");
        },
        success: function (data) {
            jQuery('#AgendaEventosWA'+Categoria).html(data);
        },
        error: function (data) {
            setTimeout(function(){ AbreEvento(Evento, Categoria, Pagina); }, 5000);
        },
    });
}
function PaginacaoAgenda(Arquivo, Categoria, Pagina){
    var UrlPainel = $('#AgendaEventosWA'+Categoria).attr("data-painel");
    $.ajax({
        type: "GET",
        cache: false,
        url: UrlPainel+'/wa/agenda/'+Arquivo+'?id='+Categoria+'&pag='+Pagina+'',
        beforeSend: function (data){
            //$("#AgendaEventosWA"+Categoria).html("<center><br><img src=\""+UrlPainel+"wa/css_js/loading.gif\"><br>Carregando...<br></center>");
        },
        success: function (data) {
            jQuery('#AgendaEventosWA'+Categoria).html(data);
        },
        error: function (data) {
            setTimeout(function(){ PaginacaoAgenda(Arquivo, Categoria, Pagina); }, 5000);
        },
    });
}