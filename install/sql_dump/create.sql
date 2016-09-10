DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` smallint(6) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `nama` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `user` (`id`, `username`, `password`, `nama`)
VALUES(1, '<USER_NAME>', <PASSWORD>, '<NAMA>');

