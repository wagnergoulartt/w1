<?php require_once('includes/funcoes.php'); ?>
<?php require_once('includes/header.php'); ?>
<?php require_once('includes/menu.php'); ?>
<?php require_once('controller/check_update.php'); ?>
<?php $TitlePage = 'Verificar Atualizações'; ?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon icon-refresh"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<div class="row">
			<div class="col-md-12">
				<div id="CheckUpdate"></div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12">
				<div class="card p-3 text-right">
					<textarea class="form-control" id="TextLog" rows="5" readonly></textarea>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once('includes/footer.php'); ?>
<script type="text/javascript">
	function CheckUpdate(Auto){
	    $.ajax({
	        type: "GET",
	        cache: false,
	        url: 'check-update.php',
	        beforeSend: function (data){
	        	$('#TextLog').append('-Verificando Atualizações...<br>\n');
	            $("#CheckUpdate").html("<center><br><img src=\"<?php echo ConfigPainel('base_url'); ?>/wa/css_js/loading.gif\"><br>Verificando Atualizações...<br></center>");
	        },
	        success: function (data) {
	        	$('#TextLog').append('-Verificação Realizada com Sucesso!<br>\n');
	            $('#CheckUpdate').html(data);

	            if (Auto == true) {
	            	document.getElementById('BaixarAtualizacao').click();
	            };
	            
	        }
	    });
	}

	CheckUpdate(null);

	function DownloadUpdate(LinkDownload){
	    $.ajax({
	        type: "GET",
	        cache: false,
	        url: 'check_update.php?Download='+LinkDownload+'',
	        beforeSend: function (data){
	        	$('#TextLog').append('-Baixando Atualizações...<br>\n');
	            $("#CheckUpdate").html("<center><br><img src=\"<?php echo ConfigPainel('base_url'); ?>/wa/css_js/loading.gif\"><br>Baixando Atualizações...<br></center>");
	        },
	        success: function (data) {
	        	$('#TextLog').append('-Download Realizado com Sucesso!<br>\n');
	            $('#CheckUpdate').html(data);
	        }
	    });
	}

	function InstalarPatch(){
	    $.ajax({
	        type: "GET",
	        cache: false,
	        url: 'check_update.php?InstalarPatch',
	        beforeSend: function (data){
	        	$('#TextLog').append('-Instalando Atualizações...<br>\n');
	            $("#CheckUpdate").html("<center><br><img src=\"<?php echo ConfigPainel('base_url'); ?>/wa/css_js/loading.gif\"><br>Instalando Atualizações...<br></center>");
	        },
	        success: function (data) {
	        	$('#TextLog').append('-Instalação Realizada com Sucesso!<br>\n');

	        	CheckUpdate();
	        }
	    });
	}
</script>