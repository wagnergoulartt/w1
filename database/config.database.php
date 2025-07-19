<?php 	
	//Define TimeZone
	date_default_timezone_set('America/Sao_Paulo');
	//Abre Conexão com Banco de Dados
	function DBConnect(){
		@$MySQLi = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		@mysqli_set_charset($MySQLi, DB_CHARSET) or die (mysqli_error($MySQLi));
		return $MySQLi;
	}
	//Fecha Conexão com Banco de Dados
	function DBClose($MySQLi){
		@mysqli_close($MySQLi) or die (mysqli_error($MySQLi));
	}
	//Protege Contra SQL Injection
	function DBEscape($dados){
		$MySQLi = DBConnect();
		if (!is_array($dados)) {
			$dados = mysqli_real_escape_string($MySQLi, $dados);
		} else {
			$arr = $dados;
			foreach ($arr as $key => $value) {
				$key = mysqli_real_escape_string($MySQLi, $key);
				$value = mysqli_real_escape_string($MySQLi, $value);
				$dados[$key] = $value;
			}
		}
		DBClose($MySQLi);
		return $dados;
	}
	//Deleta Dados do Banco
	function DBDelete($tabela, $parametros = null){
		if (DB_PREFIX != '') { $tabela = DB_PREFIX.'_'.$tabela; }
		$parametros = ($parametros) ? " WHERE {$parametros}" : null;
		$query = "DELETE FROM {$tabela}{$parametros}";
		return DBExecute($query);
	}
	//Altera Dados do Banco
	function DBUpdate($tabela, array $dados, $parametros = null, $insertid = false){
		if (DB_PREFIX != '') { $tabela = DB_PREFIX.'_'.$tabela; }
		$dados = DBEscape($dados);
		foreach ($dados as $key => $value) {
			$campos[] = "{$key} = '{$value}'";
		}
		$campos = implode(', ', $campos);
		$parametros = ($parametros) ? " WHERE {$parametros}" : null;
		$query = "UPDATE {$tabela} SET {$campos}{$parametros}";
		return DBExecute($query, $insertid);
	}
	//Conta Dados da Tabela
	function DBCount($tabela, $campos = '*', $parametros = null){
		if (DB_PREFIX != '') { $tabela = DB_PREFIX.'_'.$tabela; }
		$parametros = ($parametros) ? " {$parametros}" : null;
		$query = "SELECT {$campos} FROM {$tabela}{$parametros}";
		$sql = DBExecute($query);
		$Count = mysqli_num_rows($sql);
		return $Count;
	}
	//Ler Dados do Banco
	function DBRead($tabela, $campos = '*', $parametros = null){
		if (DB_PREFIX != '') { $tabela = DB_PREFIX.'_'.$tabela; }
		$parametros = ($parametros) ? " {$parametros}" : null;
		$query = "SELECT {$campos} FROM {$tabela}{$parametros}";
		$sql = DBExecute($query);
		if(!mysqli_num_rows($sql)) {
			return false;
		} else {
			while ($res = mysqli_fetch_assoc($sql)){
				$dados[] = $res;
			}
			return $dados;
		}
	}
	//Insere Dados no Banco
	function DBCreate($tabela, array $dados, $insertid = false){
		if (DB_PREFIX != '') { $tabela = DB_PREFIX.'_'.$tabela; }
		$dados = DBEscape($dados);
		$campos = implode(', ', array_keys($dados));
		$values = "'".implode("', '", $dados)."'";
		$query = "INSERT INTO {$tabela} ({$campos}) VALUES ({$values})";
		return DBExecute($query, $insertid);
	}
	//Executa Querys
	function DBExecute($query, $insertid = false){
		$MySQLi = DBConnect();
		$sql = @mysqli_query($MySQLi, $query) or die (mysqli_error($MySQLi));
		if ($insertid) {
			$sql = mysqli_insert_id($MySQLi);
		}
		DBClose($MySQLi);
		return $sql;
	}
	//Mensagem Após Execução
	function DBMsg($Query){
		if ($Query) {
			AbreAlerta('Procedimento realizado com sucesso!');
		} else {
			AbreAlerta('Ocorreu um erro, por favor verifique os campos inseridos!');
		}
	}
?>