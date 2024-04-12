#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
    layout varchar(255) DEFAULT '' NOT NULL,
    header_size varchar(255) DEFAULT 'default' NOT NULL,
);

#
# Modifying pages table
#
CREATE TABLE pages (
    header_logo int(11) unsigned DEFAULT '0' NOT NULL,
    footer_col1 mediumtext,
    footer_col2 mediumtext,
    footer_col3 mediumtext,
    footer_logo int(11) unsigned DEFAULT '0' NOT NULL,
    footer_links text,
);
