<?php
/* ==========================================================================
  Db connectivity
  ========================================================================== */
include 'config.php';
$conn = mssql_jp_connect();
/* ==========================================================================
  #Job-A 01 a  Fetching data from job_a_01_underlying Sql server for Underlying
  ========================================================================== */
if ($_POST['action'] == 'underlying') {
    try {
        $table_name = "job_a_01_underlying";
        $db_array_col = array("excel_data");
        $tsql = "SELECT * FROM $table_name";
        $stmt = sqlsrv_query($conn, $tsql);
        if ($stmt === false) {
            echo "Error in query preparation/execution.\n";
            die(print_r(sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        if ($rows === true) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo $row['excel_data'];
            }
        } else {

            echo 'No Data';
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}
/* ==========================================================================
  #Job-A 01 b Fetching data from job_a_01_ssf Sql server for Single Stock Futures (SSF)
  ========================================================================== */
if ($_POST['action'] == 'ssf') {
    try {
        $table_name = "job_a_01_ssf";
        $db_array_col = array("id", "ssf", "mr_or_im", "mr_or_mm", "mr_or_fm", "mr_fm_im", "mr_fm_mm", "mr_fm_fm");
        $tsql = "SELECT * FROM $table_name order by id";
        $stmt = sqlsrv_query($conn, $tsql);
        if ($stmt === false) {
            echo "Error in query preparation/execution.\n";
            die(print_r(sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        if ($rows === true) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                ?>
                <tr>
                <?php for ($j = 0; $j < count($db_array_col); $j++): ?>
                        <td><?= $row[$db_array_col[$j]] ?></td>
                <?php endfor; ?>
                </tr>
                    <?php
                }
            }
            else {
                ?>
            <tr> <td colspan="<?= count($db_array_col); ?>"> No Data</td></tr>
            <?php
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}
/* ==========================================================================
  #Job-A 02  Fetching data from job_a_02_all_funds Sql server for All Funds
  ========================================================================== */
if ($_POST['action'] == 'all_funds') {
    try {
        $table_name = "job_a_02_all_funds";
        $db_array_col = array("id", "parent_fund", "fund", "type", "amc", "fund_code", "nav_date", "nav"
            , "fund_size", "boll_upper", "boll_mid", "boll_lower", "trading_gap", "current_percentage", "upside_grain",
            "week_1", "month_1", "month_3", "month_6", "year_1", "year_3", "year_5", "sharpe_ratio");
        $tsql = "SELECT * FROM $table_name";
        $stmt = sqlsrv_query($conn, $tsql);
        if ($stmt === false) {
            echo "Error in query preparation/execution.\n";
            die(print_r(sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        ?> <tr>
        <?php
        $array_col = array("S.No.", "Parent Fund", "Fund", "Type", "AMC", "FUND CODE", "NAV Date", "NAV", "Fund Size",
            "Boll Upper", "Boll Mid", "Boll Lower", "Trading Gap", "Current Percent", "Upside Gain", "1 Week", "1 Month", "3 Month", "6 Month", "1 Year", "3 Year", "5 Year", "Sharpe Ratio");
        for ($i = 0; $i < count($array_col); $i++):
            ?>
                <th> <?= $array_col[$i] ?></th>
            <?php endfor; ?>
        </tr> <?php
        if ($rows === true) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    ?>
                <tr>
                <?php for ($j = 0; $j < count($db_array_col); $j++): ?>
                        <td><?= $row[$db_array_col[$j]] ?></td>
                <?php endfor; ?>
                </tr>
                    <?php
                }
            }
            else {
                ?>
            <tr> <td colspan="<?= count($db_array_col); ?>"> No Data</td></tr>
            <?php
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}
/* ==========================================================================
  #Job-A 03  Fetching data from job_a_03_recommendation Sql server for Fund Recommendation
  ========================================================================== */
if ($_POST['action'] == 'fund_recommendation') {
    try {
        $table_name = "job_a_03_recommendation";
        $db_array_col = array("excel_data");
        $tsql = "SELECT * FROM $table_name";
        $stmt = sqlsrv_query($conn, $tsql);
        if ($stmt === false) {
            echo "Error in query preparation/execution.\n";
            die(print_r(sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        if ($rows === true) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo $row['excel_data'];
            }
        } else {

            echo 'No Data';
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}
/* ==========================================================================
  #Job-A 04 Fetching data from job_a_04_earning_guide Sql server for Earning Guide
  ========================================================================== */
if ($_POST['action'] == 'earning_guide') {
    try {
        $table_name = "job_a_04_earning_guide";
        $db_array_col = array("id", "parent", "child", "market_cap_btm", "price_bt_2_sep", "target_price_bt", "percent_upside", "rcmd",
            "net_profit_btm_11a", "net_profit_btm_12a", "net_profit_btm_13a", "net_profit_btm_14f", "net_profit_btm_15f", "net_profit_gth_prcnt_12a", "net_profit_gth_prcnt_13f", "net_profit_gth_prcnt_14f",
            "eps_bt_11a", "eps_bt_12a", "eps_bt_13a", "eps_bt_14f", "eps_bt_15f", "eps_gth_percent_12a", "eps_gth_percent_13a", "eps_gth_percent_14f", "eps_gth_percent_15f", "pe_x_11a", "pe_x_12a", "pe_x_13a", "pe_x_14f"
            , "pe_x_15f", "peg_13a", "peg_14f", "peg_15f", "bps_bt_12a", "bps_bt_13f", "bps_bt_14f", "bps_bt_15f", "pbv_x_12a", "pbv_x_13a"
            , "pbv_x_14f", "pbv_x_15f", "dps_bt_12a", "dps_bt_13a", "dps_bt_14f", "dps_bt_15f", "div_yield_percent_12a", "div_yield_percent_13a", "div_yield_percent_14f", "div_yield_percent_15f"
            , "net_debt_equity_x_13a", "roe_percent_13a", "set50", "set100");
        $tsql = "SELECT * FROM $table_name";
        $stmt = sqlsrv_query($conn, $tsql);
        if ($stmt === false) {
            echo "Error in query preparation/execution.\n";
            die(print_r(sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        if ($rows === true) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                ?>
                <tr>
                <?php for ($j = 0; $j < count($db_array_col); $j++): ?>
                        <td><?= $row[$db_array_col[$j]] ?></td>
                <?php endfor; ?>
                </tr>
                <?php
            }
        }
        else {
            ?>
            <tr> <td colspan="<?= count($db_array_col); ?>"> No Data</td>                        </tr>
                <?php
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    /* ==========================================================================
      #Job-A 05 a&b  Fetching data from Sql server for Traning Center
      ========================================================================== */
    if ($_POST['action'] == 'training_center') {
        try {
            if ($_POST['language'] == 'english') {
                $table_name = "job_a_05_training_en";
            } else {
                $table_name = "job_a_05_training_th";
            }
            $db_array_col = array("id", "start_date", "start_time_24hrs", "end_date", "end_time_24hrs", "location", "capacity", "fee",
                "short_course_name", "course_name", "category_name", "course_code", "objective", "course_outline", "course_speaker", "course_level",
                "course_language", "course_status", "keywords", "remarks");
            $tsql = "SELECT * FROM $table_name"; //order by id DESC
            $stmt = sqlsrv_query($conn, $tsql);
            if ($stmt === false) {
                echo "Error in query preparation/execution.\n";
                die(print_r(sqlsrv_errors(), true));
            }
            $rows = sqlsrv_has_rows($stmt);
            if ($rows === true) {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    ?>
                <tr>
                <?php for ($j = 0; $j < count($db_array_col); $j++): ?>
                        <td><?= $row[$db_array_col[$j]] ?></td>
                <?php endfor; ?>
                </tr>
                <?php
            }
        }
        else {
            ?>
            <tr> <td colspan="<?= count($db_array_col); ?>"> No Data</td>                        </tr>
                <?php
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    /* ==========================================================================
      #Job-B  Fetching data from job_b_sp_upload_documents Sql server for SP Upload Document
      ========================================================================== */
    if ($_POST['action'] == 'sp_upload_documents') {
        try {

            $db_array_col = array("id", "Type", "Date", "ShareCounter", "SpotPrice", "StrikePricePct", "StrikePrice", "KnockOutPricePct", "KnockOutPrice", "ProtectionLevelPricePct", "ProtectionLevelPrice", "UpperLevelPricePct", "UpperLevelPrice", "TradeDate", "IssueDate", "ValuationDate", "MaturityDate", "NoOfDays", "NominalAmount", "YieldBeforeTax", "InterestEarn", "WithHoldingTax", "TotalSettlementAmount", "YieldAfterTax", "NoOfShare", "Comments", "LossProtectionAmount");
            $tsql = "SELECT * FROM job_b_sp_upload_documents";
            $stmt = sqlsrv_query($conn, $tsql);
            if ($stmt === false) {
                echo "Error in query preparation/execution.\n";
                die(print_r(sqlsrv_errors(), true));
            }
            $rows = sqlsrv_has_rows($stmt);
            if ($rows === true) {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    ?>

                <tr>
                <?php for ($j = 1; $j < count($db_array_col); $j++): ?>
                        <td><?= $row[$db_array_col[$j]] ?></td>
                <?php endfor; ?>

                </tr>
                <?php
            }
        }
        else {
            ?>
            <tr> <td colspan="<?= count($db_array_col); ?>"> No Data</td></tr>
            <?php
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}
/* ==========================================================================
  #Job-A 06 a  Fetching data from job_a_06_term_fund_information Sql server for Term Fund Information
  ========================================================================== */
if ($_POST['action'] == 'term_fund_information') {
    try {
        $table_name = "job_a_06_term_fund_information";
        $db_array_col = array("excel_data");
        $tsql = "SELECT * FROM $table_name";
        $stmt = sqlsrv_query($conn, $tsql);
        if ($stmt === false) {
            echo "Error in query preparation/execution.\n";
            die(print_r(sqlsrv_errors(), true));
        }
        $rows = sqlsrv_has_rows($stmt);
        if ($rows === true) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo $row['excel_data'];
            }
        } else {
            echo 'No Data';
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}

    /* ==========================================================================
      #Job-A 07 Fetching data from Sql server for Corporate Bond Yield
      ========================================================================== */
    if ($_POST['action'] == 'corporate_bond_yield') {
        try {
           
            $table_name = "job_a_07_corporate_bond_yield";
            
            $db_array_col = array("id", "ttm", "aaa", "aa_plus", "aa_minus", "aa", "a_plus", "a_minus", "a", "bbb_plus","bbb");
            
            $tsql = "SELECT * FROM $table_name"; //order by id DESC
            $stmt = sqlsrv_query($conn, $tsql);
            if ($stmt === false) {
                echo "Error in query preparation/execution.\n";
                die(print_r(sqlsrv_errors(), true));
            }
            $rows = sqlsrv_has_rows($stmt);
            if ($rows === true) {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    ?>
                <tr>
                <?php for ($j = 0; $j < count($db_array_col); $j++): ?>
                        <td><?= $row[$db_array_col[$j]] ?></td>
                <?php endfor; ?>
                </tr>
                <?php
            }
        }
        else {
            ?>
            <tr> <td colspan="<?= count($db_array_col); ?>"> No Data</td>                        </tr>
                <?php
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    ?> 
