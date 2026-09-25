SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Daten für Tabelle `tx_scheduler_task`
--

INSERT INTO `tx_scheduler_task` (`uid`, `pid`, `crdate`, `deleted`, `disable`, `serialized_task_object`, `serialized_executions`, `file_storage`, `tasktype`, `task_group`, `priority`, `description`, `parameters`, `execution_details`, `nextexecution`, `lastexecution_time`, `lastexecution_failure`, `lastexecution_context`, `number_of_days`, `selected_tables`, `cache_backends`, `max_file_count`, `ip_mask`, `all_tables`) VALUES
(1, 0, 1790328166, 1, 1, NULL, '', 0, 'fluid:namespaces', 0, 100, '', '{\"options\":{\"json\":\"on\"},\"commandIdentifier\":\"fluid:namespaces\"}', '{\"start\":1790328360,\"end\":0,\"interval\":0,\"multiple\":false,\"cronCmd\":\"\",\"isNewSingleExecution\":false}', 1790328360, 1790328171, '', 'BE', 0, '', NULL, 0, 2, 0),
(2, 0, 1790328500, 0, 0, NULL, NULL, 0, 'TYPO3\\CMS\\Scheduler\\Task\\TableGarbageCollectionTask', 1, 100, '', '[]', '{\"runningType\":\"2\",\"multiple\":false,\"start\":1790328720,\"end\":0,\"frequency\":\"0 2 * * 2\",\"interval\":0,\"cronCmd\":\"0 2 * * 2\",\"isNewSingleExecution\":false}', 1790328720, 0, NULL, '', 60, 'sys_log', NULL, 0, 2, 1),
(3, 0, 1790328550, 0, 0, NULL, NULL, 0, 'TYPO3\\CMS\\Scheduler\\Task\\CachingFrameworkGarbageCollectionTask', 1, 100, '', '[]', '{\"runningType\":\"2\",\"multiple\":false,\"start\":1790328780,\"end\":0,\"frequency\":\"0 3 * * 2\",\"interval\":0,\"cronCmd\":\"0 3 * * 2\",\"isNewSingleExecution\":false}', 1790328780, 0, NULL, '', 0, '', 'TYPO3\\CMS\\Core\\Cache\\Backend\\SimpleFileBackend,TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend,TYPO3\\CMS\\Core\\Cache\\Backend\\TransientMemoryBackend,TYPO3\\CMS\\Core\\Cache\\Backend\\FileBackend', 0, 2, 0),
(4, 0, 1790328575, 0, 0, NULL, NULL, 0, 'TYPO3\\CMS\\Scheduler\\Task\\RecyclerGarbageCollectionTask', 1, 100, '', '[]', '{\"runningType\":\"2\",\"multiple\":false,\"start\":1790328840,\"end\":0,\"frequency\":\"0 4 * * 2\",\"interval\":0,\"cronCmd\":\"0 4 * * 2\",\"isNewSingleExecution\":false}', 1790328840, 0, NULL, '', 60, '', NULL, 0, 2, 0),
(5, 0, 1790328739, 0, 0, NULL, NULL, 0, 'language:update', 2, 100, '', '{\"arguments\":{\"locales\":\"\"},\"optionValues\":{\"skip-extension\":\"\"},\"commandIdentifier\":\"language:update\"}', '{\"runningType\":\"2\",\"multiple\":true,\"start\":1790328960,\"end\":0,\"frequency\":\"0 1 * * 2\",\"interval\":0,\"cronCmd\":\"0 1 * * 2\",\"isNewSingleExecution\":false}', 1790636400, 0, NULL, '', 0, '', NULL, 0, 2, 0),
(6, 0, 1790328807, 0, 0, NULL, NULL, 0, 'referenceindex:update', 2, 100, '', '{\"commandIdentifier\":\"referenceindex:update\"}', '{\"runningType\":\"2\",\"multiple\":false,\"start\":1790329080,\"end\":0,\"frequency\":\"0 4 * * 3\",\"interval\":0,\"cronCmd\":\"0 4 * * 3\",\"isNewSingleExecution\":false}', 1790329080, 0, NULL, '', 0, '', NULL, 0, 2, 0),
(7, 0, 1790328898, 0, 0, NULL, NULL, 0, 'TYPO3\\CMS\\Scheduler\\Task\\OptimizeDatabaseTableTask', 2, 100, '', '[]', '{\"runningType\":\"2\",\"multiple\":false,\"start\":1790329080,\"end\":0,\"frequency\":\"0 0 1 * *\",\"interval\":0,\"cronCmd\":\"0 0 1 * *\",\"isNewSingleExecution\":false}', 1790329080, 0, NULL, '', 0, 'tx_news_domain_model_tag,tx_news_domain_model_news_tag_mm,tx_news_domain_model_news_related_mm,tx_news_domain_model_news,tx_news_domain_model_link,tx_hhttaddressplaces_domain_model_periodoftime,tx_hhsimplejobposts_domain_model_jobpost,sys_category,sys_category_record_mm,sys_csp_resolution,sys_file,sys_file_collection,sys_file_metadata,sys_file_processedfile,sys_file_reference,sys_file_storage,sys_filemounts,sys_history,sys_http_report,sys_lockedrecords,sys_log,cache_news_category_tags,cache_pages,cache_pages_tags,cache_rootline,cache_rootline_tags,cache_ttaddress_category,cache_ttaddress_category_tags,cache_ttaddress_geocoding,cache_ttaddress_geocoding_tags,fe_groups,fe_sessions,fe_users,index_config,index_fulltext,index_grlist,index_phash,index_rel,index_section,index_stat_word,index_words,pages,sys_be_shortcuts,sys_be_shortcuts_group,cache_news_category,sys_messenger_messages,sys_news,sys_refindex,sys_registry,sys_template,tt_address,tt_content,cache_hhsimplejobposts_jobsfromapi_tags,cache_hhsimplejobposts_jobsfromapi,cache_hash_tags,cache_hash,be_users,be_sessions,backend_layout,be_groups,tx_hhaccordion_accordion,tx_hhaccordion_child_content,tx_hhaccordion_content,tx_powermail_domain_model_answer,tx_powermail_domain_model_field,tx_powermail_domain_model_form,tx_powermail_domain_model_mail,tx_powermail_domain_model_page,tx_scheduler_task,tx_scheduler_task_group', NULL, 0, 2, 0);

--
-- Daten für Tabelle `tx_scheduler_task_group`
--

INSERT INTO `tx_scheduler_task_group` (`uid`, `pid`, `tstamp`, `crdate`, `deleted`, `hidden`, `sorting`, `groupName`, `color`, `description`) VALUES
(1, 0, 1790328508, 1790328508, 0, 0, 256, 'cleanup', '', NULL),
(2, 0, 1790328957, 1790328957, 0, 0, 128, 'optimize', '', NULL);
COMMIT;
