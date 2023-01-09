<?php return 'Usage of /Users/yaozm/Documents/develop/soar-php/bin/soar.darwin-amd64:
  -allow-charsets string
    	AllowCharsets (default "utf8,utf8mb4")
  -allow-collates string
    	AllowCollates
  -allow-drop-index
    	AllowDropIndex, 允许输出删除重复索引的建议
  -allow-engines string
    	AllowEngines (default "innodb")
  -allow-online-as-test
    	AllowOnlineAsTest, 允许线上环境也可以当作测试环境
  -blacklist string
    	指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
  -check-config
    	Check configs
  -cleanup-test-database
    	单次运行清理历史1小时前残余的测试库。
  -column-not-allow-type string
    	ColumnNotAllowType (default "boolean")
  -config string
    	Config file path
  -delimiter string
    	Delimiter, SQL分隔符 (default ";")
  -drop-test-temporary
    	DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
  -dry-run
    	是否在预演环境执行 (default true)
  -explain
    	Explain, 是否开启Explain执行计划分析 (default true)
  -explain-format string
    	ExplainFormat [json, traditional] (default "traditional")
  -explain-max-filtered float
    	ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
  -explain-max-keys int
    	ExplainMaxKeyLength, 最大key_len (default 3)
  -explain-max-rows int
    	ExplainMaxRows, 最大扫描行数警告 (default 10000)
  -explain-min-keys int
    	ExplainMinPossibleKeys, 最小possible_keys警告
  -explain-sql-report-type string
    	ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
  -explain-type string
    	ExplainType [extended, partitions, traditional] (default "extended")
  -explain-warn-access-type string
    	ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
  -explain-warn-extra string
    	ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
  -explain-warn-scalability string
    	ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
  -explain-warn-select-type string
    	ExplainWarnSelectType, 哪些select_type不建议使用
  -ignore-rules string
    	IgnoreRules, 忽略的优化建议规则 (default "COL.011")
  -index-prefix string
    	IdxPrefix (default "idx_")
  -list-heuristic-rules
    	ListHeuristicRules, 打印支持的评审规则列表
  -list-report-types
    	ListReportTypes, 打印支持的报告输出类型
  -list-rewrite-rules
    	ListRewriteRules, 打印支持的重写规则列表
  -list-test-sqls
    	ListTestSqls, 打印测试case用于测试
  -log-level int
    	LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
  -log-output string
    	LogOutput, 日志输出位置 (default "soar.log")
  -log_err_stacks
    	log stack traces for errors
  -log_rotate_max_size uint
    	size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
  -markdown-extensions int
    	MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
  -markdown-html-flags int
    	MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
  -max-column-count int
    	MaxColCount, 单表允许的最大列数 (default 40)
  -max-distinct-count int
    	MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
  -max-group-by-cols-count int
    	MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
  -max-in-count int
    	MaxInCount, IN()最大数量 (default 10)
  -max-index-bytes int
    	MaxIdxBytes, 索引总长度限制 (default 3072)
  -max-index-bytes-percolumn int
    	MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
  -max-index-cols-count int
    	MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
  -max-index-count int
    	MaxIdxCount, 单表最大索引个数 (default 10)
  -max-join-table-count int
    	MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
  -max-pretty-sql-length int
    	MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
  -max-query-cost int
    	MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
  -max-subquery-depth int
    	MaxSubqueryDepth (default 5)
  -max-text-cols-count int
    	MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
  -max-total-rows uint
    	MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
  -max-value-count int
    	MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
  -max-varchar-length int
    	MaxVarcharLength (default 1024)
  -min-cardinality float
    	MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
  -online-dsn string
    	OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
  -only-syntax-check
    	OnlySyntaxCheck, 只做语法检查不输出优化建议
  -print-config
    	Print configs
  -profiling
    	Profiling, 开启数据采样的情况下在测试环境执行Profile
  -query string
    	待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
  -report-css string
    	ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
  -report-javascript string
    	ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
  -report-title string
    	ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
  -report-type string
    	ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
  -rewrite-rules string
    	RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
  -sampling
    	Sampling, 数据采样开关
  -sampling-condition string
    	SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
  -sampling-statistic-target int
    	SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
  -show-last-query-cost
    	ShowLastQueryCost
  -show-warnings
    	ShowWarnings
  -spaghetti-query-length int
    	SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
  -test-dsn string
    	TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
  -trace
    	Trace, 开启数据采样的情况下在测试环境执行Trace
  -unique-key-prefix string
    	UkPrefix (default "uk_")
  -verbose
    	Verbose
  -version
    	Print version info

';
