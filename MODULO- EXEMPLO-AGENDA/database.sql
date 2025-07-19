SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `dataI` date NOT NULL,
  `horaI` time NOT NULL,
  `local` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `resumo` longtext NOT NULL,
  `url` longtext NOT NULL,
  `status` int(1) NOT NULL,
  `dataT` date NOT NULL,
  `horaT` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `agenda` ADD PRIMARY KEY (`id`);
ALTER TABLE `agenda` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
CREATE TABLE `c_agenda` (
  `id` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `paginacao` int(11) NOT NULL,
  `ordenar_por` varchar(50) NOT NULL,
  `asc_desc` varchar(5) NOT NULL,
  `background` varchar(25) NOT NULL,
  `cor_fonte` varchar(25) NOT NULL,
  `cor_titulo` varchar(25) NOT NULL,
  `cor_btn` varchar(25) NOT NULL,
  `cor_txt_btn` varchar(25) NOT NULL,
  `modelo` varchar(15) NOT NULL,
  `efeito` varchar(255) NOT NULL,
  `matriz` varchar(255) NOT NULL,
  `comentarios` enum('F','N','E') NOT NULL,
  `ativa_paginacao` enum('S','N') NOT NULL,
  `colunas` int(1) NOT NULL,
  `carousel` int(1) NOT NULL,
  `modal` int(1) NOT NULL,
  `cor_carousel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `c_agenda` (`id`, `categoria`, `paginacao`, `ordenar_por`, `asc_desc`, `background`, `cor_fonte`, `cor_titulo`, `cor_btn`, `cor_txt_btn`, `modelo`, `efeito`, `matriz`, `comentarios`, `ativa_paginacao`, `colunas`, `carousel`, `modal`, `cor_carousel`) VALUES
(0, 'Todos os Eventos', 5, 'id', 'ASC', '#000', '#000', '#000', '#000', '', 'modelo-1', 'tc-animation-slide-bottom', '#', 'F', 'S', 4, 2, 1, '#000');

ALTER TABLE `c_agenda` ADD PRIMARY KEY (`id`);

ALTER TABLE `c_agenda` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `modulos` (`nome`, `url`, `icone`, `status`, `ordem`, `tabela`, `cod_head`, `data_atualizacao`, `chave`)
VALUES ('Agenda de Eventos', 'agenda.php', 'icon-calendar', 1, 0, 'agenda', 'agenda/agenda.js', '2019-05-07', '72b4b1d7ce2b514a981a49b1db5790a7');

ALTER TABLE `c_agenda` DROP `modal`;

UPDATE `modulos` SET `acao` = "{\"evento\":[\"adicionar\",\"editar\",\"deletar\"],\"categoria\":[\"adicionar\",\"editar\",\"deletar\"],\"matriz\":[\"acessar\"],\"codigo\":[\"acessar\"]}" WHERE `modulos`.`url` = 'agenda.php';