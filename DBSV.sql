
GO
/****** Object:  Table [dbo].[job_a_01_underlying]    Script Date: 11/18/2014 13:00:40 ******/
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_01_underlying]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
DROP TABLE [dbo].[job_a_01_underlying]
GO
/****** Object:  Table [dbo].[job_a_01_ssf]    Script Date: 11/18/2014 13:00:20 ******/
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_01_ssf]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
DROP TABLE [dbo].[job_a_01_ssf]
GO
/****** Object:  Table [dbo].[job_a_02_all_funds]    Script Date: 11/18/2014 13:00:32 ******/
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_02_all_funds]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
DROP TABLE [dbo].[job_a_02_all_funds]
GO
/****** Object:  Table [dbo].[job_a_03_recommendation_html]    Script Date: 11/18/2014 13:00:59 ******/
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_03_recommendation]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
DROP TABLE [dbo].[job_a_03_recommendation]
GO
/****** Object:  Table [dbo].[job_a_04]    Script Date: 11/18/2014 13:00:51 ******/
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_04_earning_guide]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
DROP TABLE [dbo].[job_a_04_earning_guide]
GO
/****** Object:  Table [dbo].[job_a_05en]    Script Date: 11/18/2014 13:00:43 ******/
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_05_training_en]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
DROP TABLE [dbo].[job_a_05_training_en]
GO
/****** Object:  Table [dbo].[job_a_05th]    Script Date: 11/18/2014 13:00:34 ******/
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_05_training_th]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
DROP TABLE [dbo].[job_a_05_training_th]
GO
/****** Object:  Table [dbo].[job_b_sp_upload_documents_new]    Script Date: 11/18/2014 13:00:54 ******/
IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_b_sp_upload_documents]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
DROP TABLE [dbo].[job_b_sp_upload_documents]
GO

/****** Object:  Table [dbo].[job_a_01_underlying]    Script Date: 11/18/2014 13:00:40 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_01_underlying]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
BEGIN
CREATE TABLE [dbo].[job_a_01_underlying](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sheet_name] [varchar](max) COLLATE Thai_CI_AI NOT NULL,
	[excel_data] [nvarchar](max) COLLATE Thai_CI_AI NOT NULL,
 CONSTRAINT [PK_job_a_01_underlying] PRIMARY KEY CLUSTERED 
(
	[id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[job_a_01_ssf]    Script Date: 11/18/2014 13:00:20 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_01_ssf]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
BEGIN
CREATE TABLE [dbo].[job_a_01_ssf](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[ssf] [varchar](max) COLLATE Thai_CI_AI NULL,
	[mr_or_im] [varchar](max) COLLATE Thai_CI_AI NULL,
	[mr_or_mm] [varchar](max) COLLATE Thai_CI_AI NULL,
	[mr_or_fm] [varchar](max) COLLATE Thai_CI_AI NULL,
	[mr_fm_im] [varchar](max) COLLATE Thai_CI_AI NULL,
	[mr_fm_mm] [varchar](max) COLLATE Thai_CI_AI NULL,
	[mr_fm_fm] [varchar](max) COLLATE Thai_CI_AI NULL,
 CONSTRAINT [PK_job_a_01_ssf] PRIMARY KEY CLUSTERED 
(
	[id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[job_a_02_all_funds]    Script Date: 11/18/2014 13:00:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_02_all_funds]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
BEGIN
CREATE TABLE [dbo].[job_a_02_all_funds](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[parent_fund] [varchar](max) COLLATE Thai_CI_AI NULL,
	[fund] [varchar](max) COLLATE Thai_CI_AI NULL,
	[type] [varchar](max) COLLATE Thai_CI_AI NULL,
	[amc] [varchar](max) COLLATE Thai_CI_AI NULL,
	[fund_code] [varchar](max) COLLATE Thai_CI_AI NULL,
	[nav_date] [varchar](max) COLLATE Thai_CI_AI NULL,
	[nav] [varchar](max) COLLATE Thai_CI_AI NULL,
	[fund_size] [varchar](max) COLLATE Thai_CI_AI NULL,
	[boll_upper] [varchar](max) COLLATE Thai_CI_AI NULL,
	[boll_mid] [varchar](max) COLLATE Thai_CI_AI NULL,
	[boll_lower] [varchar](max) COLLATE Thai_CI_AI NULL,
	[trading_gap] [varchar](max) COLLATE Thai_CI_AI NULL,
	[current_percentage] [varchar](max) COLLATE Thai_CI_AI NULL,
	[upside_grain] [varchar](max) COLLATE Thai_CI_AI NULL,
	[week_1] [varchar](max) COLLATE Thai_CI_AI NULL,
	[month_1] [varchar](max) COLLATE Thai_CI_AI NULL,
	[month_3] [varchar](max) COLLATE Thai_CI_AI NULL,
	[month_6] [varchar](max) COLLATE Thai_CI_AI NULL,
	[year_1] [varchar](max) COLLATE Thai_CI_AI NULL,
	[year_3] [varchar](max) COLLATE Thai_CI_AI NULL,
	[year_5] [varchar](max) COLLATE Thai_CI_AI NULL,
	[sharpe_ratio] [varchar](max) COLLATE Thai_CI_AI NULL,
 CONSTRAINT [PK_job_a_02_all_funds] PRIMARY KEY CLUSTERED 
(
	[id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[job_a_03_recommendation]    Script Date: 11/18/2014 13:00:59 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_03_recommendation]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
BEGIN
CREATE TABLE [dbo].[job_a_03_recommendation](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sheet_name] [varchar](max) COLLATE Thai_CI_AI NOT NULL,
	[excel_data] [nvarchar](max) COLLATE Thai_CI_AI NOT NULL,
 CONSTRAINT [PK_job_a_03_recommendation] PRIMARY KEY CLUSTERED 
(
	[id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[job_a_04_earning_guide]    Script Date: 11/18/2014 13:00:51 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_04_earning_guide]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
BEGIN
CREATE TABLE [dbo].[job_a_04_earning_guide](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[parent] [varchar](max) COLLATE Thai_CI_AI NULL,
	[child] [varchar](max) COLLATE Thai_CI_AI NULL,
	[market_cap_btm] [varchar](max) COLLATE Thai_CI_AI NULL,
	[price_bt_2_sep] [varchar](max) COLLATE Thai_CI_AI NULL,
	[target_price_bt] [varchar](max) COLLATE Thai_CI_AI NULL,
	[percent_upside] [varchar](max) COLLATE Thai_CI_AI NULL,
	[rcmd] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_profit_btm_11a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_profit_btm_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_profit_btm_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_profit_btm_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_profit_btm_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_profit_gth_prcnt_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_profit_gth_prcnt_13f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_profit_gth_prcnt_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_bt_11a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_bt_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_bt_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_bt_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_bt_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_gth_percent_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_gth_percent_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_gth_percent_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[eps_gth_percent_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pe_x_11a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pe_x_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pe_x_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pe_x_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pe_x_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[peg_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[peg_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[peg_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[bps_bt_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[bps_bt_13f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[bps_bt_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[bps_bt_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pbv_x_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pbv_x_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pbv_x_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[pbv_x_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[dps_bt_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[dps_bt_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[dps_bt_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[dps_bt_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[div_yield_percent_12a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[div_yield_percent_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[div_yield_percent_14f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[div_yield_percent_15f] [varchar](max) COLLATE Thai_CI_AI NULL,
	[net_debt_equity_x_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[roe_percent_13a] [varchar](max) COLLATE Thai_CI_AI NULL,
	[set50] [bit] NULL,
	[set100] [bit] NULL,
 CONSTRAINT [PK_job_a_04_earning_guide] PRIMARY KEY CLUSTERED 
(
	[id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[job_a_05_training_en]    Script Date: 11/18/2014 13:00:43 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_05_training_en]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
BEGIN
CREATE TABLE [dbo].[job_a_05_training_en](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[start_date] [varchar](max) COLLATE Thai_CI_AI NULL,
	[start_time_24hrs] [varchar](max) COLLATE Thai_CI_AI NULL,
	[end_date] [varchar](max) COLLATE Thai_CI_AI NULL,
	[end_time_24hrs] [varchar](max) COLLATE Thai_CI_AI NULL,
	[location] [varchar](max) COLLATE Thai_CI_AI NULL,
	[capacity] [varchar](max) COLLATE Thai_CI_AI NULL,
	[fee] [varchar](max) COLLATE Thai_CI_AI NULL,
	[short_course_name] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_name] [varchar](max) COLLATE Thai_CI_AI NULL,
	[category_name] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_code] [varchar](max) COLLATE Thai_CI_AI NULL,
	[objective] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_outline] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_speaker] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_level] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_language] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_status] [varchar](max) COLLATE Thai_CI_AI NULL,
	[keywords] [varchar](max) COLLATE Thai_CI_AI NULL,
	[remarks] [varchar](max) COLLATE Thai_CI_AI NULL,
 CONSTRAINT [PK_job_a_05_training_en] PRIMARY KEY CLUSTERED 
(
	[id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[job_a_05_training_th]    Script Date: 11/18/2014 13:00:34 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_a_05_training_th]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
BEGIN
CREATE TABLE [dbo].[job_a_05_training_th](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[start_date] [varchar](max) COLLATE Thai_CI_AI NULL,
	[start_time_24hrs] [varchar](max) COLLATE Thai_CI_AI NULL,
	[end_date] [varchar](max) COLLATE Thai_CI_AI NULL,
	[end_time_24hrs] [varchar](max) COLLATE Thai_CI_AI NULL,
	[location] [varchar](max) COLLATE Thai_CI_AI NULL,
	[capacity] [varchar](max) COLLATE Thai_CI_AI NULL,
	[fee] [varchar](max) COLLATE Thai_CI_AI NULL,
	[short_course_name] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_name] [varchar](max) COLLATE Thai_CI_AI NULL,
	[category_name] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_code] [varchar](max) COLLATE Thai_CI_AI NULL,
	[objective] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_outline] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_speaker] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_level] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_language] [varchar](max) COLLATE Thai_CI_AI NULL,
	[course_status] [varchar](max) COLLATE Thai_CI_AI NULL,
	[keywords] [varchar](max) COLLATE Thai_CI_AI NULL,
	[remarks] [varchar](max) COLLATE Thai_CI_AI NULL,
 CONSTRAINT [PK_job_a_05_training_th] PRIMARY KEY CLUSTERED 
(
	[id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO


/****** Object:  Table [dbo].[job_b_sp_upload_documents]    Script Date: 11/18/2014 13:00:54 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[dbo].[job_b_sp_upload_documents]') AND OBJECTPROPERTY(id, N'IsUserTable') = 1)
BEGIN
CREATE TABLE [dbo].[job_b_sp_upload_documents](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Type] [varchar](max) COLLATE Thai_CI_AI NULL,
	[Date] [varchar](max) COLLATE Thai_CI_AI NULL,
	[ShareCounter] [varchar](max) COLLATE Thai_CI_AI NULL,
	[SpotPrice] [decimal](18, 0) NULL,
	[P_StrikeofSpot] [varchar](max) COLLATE Thai_CI_AI NULL,
	[StrikePrice] [varchar](max) COLLATE Thai_CI_AI NULL,
	[P_KnockOut] [varchar](max) COLLATE Thai_CI_AI NULL,
	[KnockoutPrice] [decimal](18, 0) NULL,
	[P_ProtectionLevelofSpot] [varchar](max) COLLATE Thai_CI_AI NULL,
	[ProtectionLevelPrice] [varchar](max) COLLATE Thai_CI_AI NULL,
	[P_UpperLevelPrice] [varchar](max) COLLATE Thai_CI_AI NULL,
	[UpperLevelPrice] [varchar](max) COLLATE Thai_CI_AI NULL,
	[TradeDate] [varchar](max) COLLATE Thai_CI_AI NULL,
	[IssueDate] [varchar](max) COLLATE Thai_CI_AI NULL,
	[ValuationDate] [varchar](max) COLLATE Thai_CI_AI NULL,
	[MaturityDate] [varchar](max) COLLATE Thai_CI_AI NULL,
	[NoofDays] [decimal](18, 0) NULL,
	[NominalAmount] [decimal](18, 0) NULL,
	[YieldbeforeTax] [varchar](max) COLLATE Thai_CI_AI NULL,
	[InterestEarn] [decimal](18, 0) NULL,
	[Withholdingtax] [decimal](18, 0) NULL,
	[TotalSettlementAmount_RedemptionAmountinCash_THB] [decimal](18, 0) NULL,
	[YieldAfterTax] [varchar](max) COLLATE Thai_CI_AI NULL,
	[NoOfShare] [decimal](18, 0) NULL,
	[Comments] [varchar](max) COLLATE Thai_CI_AI NULL,
	[LossProtectionAmount] [varchar](max) COLLATE Thai_CI_AI NULL,
 CONSTRAINT [PK_job_b_sp_upload_documents] PRIMARY KEY CLUSTERED 
(
	[id] ASC
) ON [PRIMARY]
) ON [PRIMARY]
END
GO
SET ANSI_PADDING OFF
GO