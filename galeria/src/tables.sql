
CREATE TABLE IF NOT EXISTS `album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_nome` varchar(200) DEFAULT NULL,
  `album_albumcat` int(11) NOT NULL,
  `album_desc` longtext NOT NULL,
  `album_fx` varchar(30) NOT NULL,
  PRIMARY KEY (`album_id`,`album_albumcat`),
  KEY `fk_album_albumcat1_idx` (`album_albumcat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Fazendo dump de dados para tabela `album`
--

INSERT INTO `album` (`album_id`, `album_nome`, `album_albumcat`, `album_desc`, `album_fx`) VALUES
(8, 'Paisagens', 1, '<p style="letter-spacing: 0.100000001490116px; line-height: 23.9980010986328px;"><span style="color: rgb(0, 0, 0);">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam&nbsp;</span><span style="color: rgb(99, 99, 99);">nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam&nbsp;</span><span style="color: rgb(156, 156, 148);">erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span></p><div><span style="color: rgb(156, 156, 148);"><br></span></div>', 'randomrot'),
(9, 'Animais', 2, '<p><span style="color: rgb(0, 0, 0);">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam </span><span style="color: rgb(99, 99, 99);">nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam </span><span style="color: rgb(156, 156, 148);">erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span></p><p><span style="color: rgb(156, 156, 148);"><br></span><br></p>', 'randomrot'),
(10, 'Pessoas', 2, '<p style="letter-spacing: 0.100000001490116px; line-height: 23.9980010986328px;"><span style="color: rgb(0, 0, 0);">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam&nbsp;</span><span style="color: rgb(99, 99, 99);">nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam&nbsp;</span><span style="color: rgb(156, 156, 148);">erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span></p><div><span style="color: rgb(156, 156, 148);"><br></span></div>', 'randomrot'),
(11, 'Natureza', 1, '<p style="letter-spacing: 0.100000001490116px; line-height: 23.9980010986328px;"><span style="color: rgb(0, 0, 0);">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam&nbsp;</span><span style="color: rgb(99, 99, 99);">nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam&nbsp;</span><span style="color: rgb(156, 156, 148);">erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</span></p><div><span style="color: rgb(156, 156, 148);"><br></span></div>', 'randomrot');

-- --------------------------------------------------------

--
-- Estrutura para tabela `albumcat`
--

CREATE TABLE IF NOT EXISTS `albumcat` (
  `albumcat_id` int(11) NOT NULL AUTO_INCREMENT,
  `albumcat_nome` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`albumcat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Fazendo dump de dados para tabela `albumcat`
--

INSERT INTO `albumcat` (`albumcat_id`, `albumcat_nome`) VALUES
(1, 'Categoria A'),
(2, 'Categoria B');

-- --------------------------------------------------------

--
-- Estrutura para tabela `foto`
--

CREATE TABLE IF NOT EXISTS `foto` (
  `foto_id` int(11) NOT NULL AUTO_INCREMENT,
  `foto_url` varchar(200) DEFAULT NULL,
  `foto_pos` int(11) DEFAULT '0',
  `foto_album` int(11) NOT NULL,
  `foto_legenda` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`foto_id`,`foto_album`),
  KEY `fk_foto_album1_idx` (`foto_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

--
-- Fazendo dump de dados para tabela `foto`
--

INSERT INTO `foto` (`foto_id`, `foto_url`, `foto_pos`, `foto_album`, `foto_legenda`) VALUES
(104, 'd3fab9c4484db70f8b16e765a63f33e3.jpg', 3, 8, 'legenda 01'),
(105, '4df4568f6714deee429f75e493d46224.jpg', 2, 8, 'legenda 03'),
(106, '575a94f88aed88e840e1728e01eca0cb.jpg', 0, 8, ''),
(107, '35ce89c116e8a4d254600aecee6111a9.jpg', 1, 8, ''),
(109, '3976231b2db304d2a79e74dd8a335416.jpg', 6, 9, 'Urso'),
(110, '3cb89b7bdff4cd9fa0dc43c2b61d49e2.jpg', 7, 9, 'PHPLEFANT'),
(111, '64ad2bdcda9ca7ffb41016c405b40bd1.jpg', 5, 9, 'Cavalo '),
(112, '6fd1e1ec2210fae03206a1e3246a519e.jpg', 0, 9, 'Zebra'),
(113, '915d8acaeac8016cf02e4f59bbabea5a.jpg', 0, 10, NULL),
(114, '84cab7d6c046c8c5274ca7b8e61eed42.jpg', 0, 10, NULL),
(115, '9a85293a21e2ca58fdfe73c2dde50afa.jpg', 0, 10, NULL),
(116, '62174f122458a78925619802eef87500.jpg', 0, 10, NULL),
(117, '72f9eece2e4434509fc4796a6cc806c2.jpg', 0, 11, NULL),
(118, '9cf6433730c82cf4adc349267315093c.jpg', 3, 11, NULL),
(119, '14dc22d9da13686c6cc8541f1bbcda33.jpg', 2, 11, NULL),
(120, '81c7f96a502d8f0ea7577258af4be852.jpg', 1, 11, NULL),
(128, '755b9a4dfe251701dd2178ff899c4393.jpg', 1, 9, NULL),
(129, '71b120fc1bb5ab379d3889e10207b0d3.jpg', 2, 9, NULL),
(130, 'd295aa4ebc2c0ce13e31a23565d8b2ff.jpg', 3, 9, NULL),
(131, 'afd6707c2620f41ad54e3a7f21a5c625.jpg', 4, 9, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `slide_id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_foto` varchar(200) DEFAULT NULL,
  `slide_pos` varchar(200) DEFAULT '0',
  `slide_link` varchar(200) NOT NULL,
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Fazendo dump de dados para tabela `slide`
--

INSERT INTO `slide` (`slide_id`, `slide_foto`, `slide_pos`, `slide_link`) VALUES
(52, 'cce5aa249b82804a83c9c2a44cf12e10.jpg', '0', ''),
(53, '740bc1f7392dfc7c406a5b8dbdaefe13.jpg', '0', ''),
(54, 'efcc9e190d2db804372c110a81f1d335.jpg', '0', ''),
(55, '69ea4ab01a332bf1af1061cf18bf0669.jpg', '0', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nome` varchar(200) DEFAULT NULL,
  `usuario_email` varchar(200) DEFAULT NULL,
  `usuario_senha` varchar(200) DEFAULT NULL,
  `usuario_login` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nome`, `usuario_email`, `usuario_senha`, `usuario_login`) VALUES
(1, 'PHP Staff', 'admin@admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `fk_album_albumcat1` FOREIGN KEY (`album_albumcat`) REFERENCES `albumcat` (`albumcat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `fk_foto_album1` FOREIGN KEY (`foto_album`) REFERENCES `album` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE;

