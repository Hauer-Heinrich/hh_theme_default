#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
    layout varchar(255) DEFAULT '' NOT NULL,
    background varchar(255) DEFAULT '' NOT NULL,
    row_gap int(11) unsigned DEFAULT '0' NOT NULL,
    column_gap int(11) unsigned DEFAULT '0' NOT NULL,
    filelink_download int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Modifying pages table
#
CREATE TABLE pages (
    header_logo int(11) unsigned DEFAULT '0' NOT NULL,
    footer_logo int(11) unsigned DEFAULT '0' NOT NULL,
    footer_col1 mediumtext,
    footer_links1 text,
    footer_links2 text,
    footer_links3 text,
    footer_links4 text,
    footer_address varchar(50),
);

#
# Modifying news table
#
CREATE TABLE tx_news_domain_model_news (
    custom_media int(11) unsigned DEFAULT '0' NOT NULL,
    custom_media_2 int(11) unsigned DEFAULT '0' NOT NULL,
);

#
# Modifying tt_addres table
#
CREATE TABLE tt_address (
    theme_skills text,
);
