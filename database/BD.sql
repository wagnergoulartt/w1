SET SQL_MODE = "NO_ENGINE_SUBSTITUTION,NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `comentario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `conteudo` longtext NOT NULL,
  `blog_id` int(11) NOT NULL,
  `ativo` int(1) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `config` (
  `site_url` varchar(255) DEFAULT NULL,
  `base_url` varchar(255) DEFAULT NULL,
  `site_nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `licenca` varchar(255) DEFAULT NULL,
  `paginacao` int(3) DEFAULT 10,
  `versao` varchar(10) DEFAULT '3.4.5',
  `idioma` varchar(50) DEFAULT 'portugues',
  `erro` enum('S','N') DEFAULT 'N',
  `tema` varchar(50) DEFAULT 'tema04',
  `logo` varchar(255) DEFAULT 'logo.png',
  `cor_blocos` varchar(255) DEFAULT '#ffc800',
  `menu` varchar(100) DEFAULT '#00131f',
  `manutencao` enum('S','N') DEFAULT 'N',
  `msg_manutencao` text DEFAULT NULL,
  `smtp_servidor` varchar(255) DEFAULT NULL,
  `smtp_usuario` varchar(255) DEFAULT NULL,
  `smtp_senha` varchar(255) DEFAULT NULL,
  `smtp_porta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

UPDATE config SET menu = '#00131f';

CREATE TABLE `idioma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) NOT NULL,
  `diretorio` varchar(50) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `idioma` (`id`, `titulo`, `diretorio`, `imagem`) VALUES
(1, 'Português - Brasil', 'portugues', 'portugues.png'),
(2, 'English', 'english', 'english.png'),
(3, 'Português - Portugal', 'portugal', 'portugal.png'),
(4, 'Espanhol', 'spanish', 'spanish.png');

CREATE TABLE `modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icone` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `tabela` varchar(255) NOT NULL,
  `cod_head` varchar(255) NOT NULL,
  `data_atualizacao` date NOT NULL,
  `chave` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `modulos` ADD UNIQUE(`url`);


CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `conteudo` longtext NOT NULL,
  `data` date NOT NULL,
  `status` int(1) NOT NULL,
  `categoria` int(11) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `cor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tarefas_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `classe` varchar(255) NOT NULL,
  `ordem` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `nivel` int(1) NOT NULL,
  `permissao` varchar(500) DEFAULT NULL,
  `status` enum('1','2') NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `sobre` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `usuarios`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`);
  
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `usuarios` CHANGE `token` `token` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `tarefas` ADD `created_by` INT NULL DEFAULT '1';
ALTER TABLE `tarefas_categorias` ADD `created_by` INT NULL DEFAULT '1';
ALTER TABLE `usuarios` ADD `created_by` INT NULL DEFAULT '1';
ALTER TABLE `usuarios` CHANGE `permissao` `permissao` INT(11) NULL DEFAULT NULL;
ALTER TABLE `modulos` ADD `acao` text NULL;
ALTER TABLE `modulos` ADD `level` INT(11) NOT NULL DEFAULT '1';
UPDATE `usuarios` SET `permissao` = '1';
ALTER TABLE `config` ADD `site_key` VARCHAR(500) NULL AFTER `smtp_porta`, ADD `secret_key` VARCHAR(500) NULL AFTER `site_key`;
ALTER TABLE `modulos` CHANGE `icone` `icone` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `modulos` CHANGE `data_atualizacao` `data_atualizacao` DATE NULL;
ALTER TABLE `modulos` CHANGE `chave` `chave` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `modulos` CHANGE `ordem` `ordem` INT(11) NULL;
ALTER TABLE `modulos` CHANGE `tabela` `tabela` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

CREATE TABLE `permissions_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `params` text,
  `created_by` int(11) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `permissions_groups` ADD PRIMARY KEY( `id`);

ALTER TABLE `permissions_groups` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `permissions_groups` (`id`, `name`, `params`, `created_by`) VALUES (NULL, 'Super Admin', '{\"configuracoes\":{\"item\":[\"acessar\"],\"menu\":[\"link_suporte\",\"acessar_site\",\"codigo_head\"]},\"usuarios\":{\"item\":[\"adicionar\",\"editar\",\"deletar\"]},\"permissoes\":{\"item\":[\"adicionar\",\"editar\",\"deletar\"]},\"info\":{\"item\":[\"acessar\"]},\"error_log\":{\"item\":[\"acessar\"]},\"modulos\":{\"item\":[\"editar\",\"deletar\"]},\"check_update\":{\"item\":[\"acessar\"]},\"marketplace\":{\"item\":[\"acessar\"]},\"tarefas\":{\"item\":[\"adicionar\",\"editar\",\"deletar\"],\"bloco\":[\"adicionar\",\"editar\",\"deletar\"]},\"estatisticas\":{\"item\":[\"acessar\"]},\"paleta\":{\"item\":[\"acessar\"]}}', '1');

INSERT INTO `modulos` (`id`, `icone`, `nome`, `url`, `tabela`, `acao`, `level`, `cod_head`, `data_atualizacao`, `chave`, `ordem`, `status`) VALUES
(NULL, NULL, 'Configurações', 'configuracoes.php', 'config', '{\"item\":[\"acessar\"]}', 2, '', NULL, NULL, NULL, 1),
(NULL, NULL, 'Usuários', 'usuarios.php', 'usuarios', '{\"item\":[\"adicionar\",\"editar\",\"deletar\",\"ver\"]}', 2, '', NULL, NULL, NULL, 1),
(NULL, NULL, 'Permissões', 'permissoes.php', NULL, '{\"item\":[\"adicionar\",\"editar\",\"deletar\",\"ver\"]}', 2, '', NULL, NULL, NULL, 1),
(NULL, NULL, 'Info. do Sistema', 'info.php', NULL, '{\"item\":[\"acessar\"]}', 2, '', NULL, NULL, NULL, 1),
(NULL, NULL, 'Logs de Erro', 'error_log.php', NULL, '{\"item\":[\"acessar\"]}', 2, '', NULL, NULL, NULL, 1),
(NULL, NULL, 'Gerenciar Módulos', 'modulos.php', 'modulos', '{\"item\":[\"editar\",\"deletar\"]}', 2, '', NULL, NULL, NULL, 1),
-- (NULL, NULL, 'Verificar Atualizações', 'check_update.php', NULL, '{\"item\":[\"acessar\"]}', 2, '', NULL, NULL, NULL, 1),
-- (NULL, NULL, 'Loja de Módulos', 'marketplace.php', NULL, '{\"item\":[\"acessar\"]}', 2, '', NULL, NULL, NULL, 1),
(NULL, NULL, 'Gerenciador de Tarefas', 'tarefas.php', NULL, '{\"item\":[\"adicionar\",\"editar\",\"deletar\",\"ver\"],\"bloco\":[\"adicionar\",\"editar\",\"deletar\",\"ver\"]}', 3, '', NULL, NULL, NULL, 1),
(NULL, NULL, 'Estatísticas', 'estatisticas.php', 'tarefas', '{\"item\":[\"acessar\"]}', 3, '', NULL, NULL, NULL, 1),
(NULL, NULL, 'Cores Prontas', 'paleta.php', NULL, '{\"item\":[\"acessar\"]}', 3, '', NULL, NULL, NULL, 1);
UPDATE `config` SET `versao`='3.4.5' WHERE 1;
UPDATE `modulos` SET `acao` = '{\"item\":[\"adicionar\",\"editar\",\"deletar\",\"ver\"]}' WHERE acao is null;
UPDATE `modulos` SET `acao` = '{\"item\":[\"editar\",\"deletar\"]}' WHERE `modulos`.`url` = 'modulos.php';
ALTER TABLE `usuarios` CHANGE `nivel` `nivel` INT(1) NULL DEFAULT '1';
UPDATE `modulos` SET `acao` = '{\"item\":[\"acessar\"],\"menu\":[\"link_suporte\",\"acessar_site\",\"codigo_head\"]}' WHERE `modulos`.`url` = 'configuracoes.php';
ALTER TABLE `config` ADD `date_update` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `versao`;
UPDATE `config` SET `date_update`= NOW();
