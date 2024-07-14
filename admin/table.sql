CREATE TABLE cartes_postales (
  id int(10) NOT NULL auto_increment,
  pays char(3) NOT NULL default '',
  departement char(3) NOT NULL default '0',
  ville varchar(32) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  date int(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
