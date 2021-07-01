<?php

// Global variable for table object
$kurikulum = NULL;

//
// Table class for kurikulum
//
class ckurikulum extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $KurikulumID;
	var $KampusID;
	var $ProdiID;
	var $KurikulumKode;
	var $Nama;
	var $JmlSesi;
	var $CreateDate;
	var $Creator;
	var $EditDate;
	var $Editor;
	var $NA;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'kurikulum';
		$this->TableName = 'kurikulum';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`kurikulum`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 25;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// KurikulumID
		$this->KurikulumID = new cField('kurikulum', 'kurikulum', 'x_KurikulumID', 'KurikulumID', '`KurikulumID`', '`KurikulumID`', 3, -1, FALSE, '`KurikulumID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->KurikulumID->Sortable = TRUE; // Allow sort
		$this->KurikulumID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KurikulumID'] = &$this->KurikulumID;

		// KampusID
		$this->KampusID = new cField('kurikulum', 'kurikulum', 'x_KampusID', 'KampusID', '`KampusID`', '`KampusID`', 200, -1, FALSE, '`KampusID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KampusID->Sortable = TRUE; // Allow sort
		$this->KampusID->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KampusID->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['KampusID'] = &$this->KampusID;

		// ProdiID
		$this->ProdiID = new cField('kurikulum', 'kurikulum', 'x_ProdiID', 'ProdiID', '`ProdiID`', '`ProdiID`', 200, -1, FALSE, '`ProdiID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->ProdiID->Sortable = TRUE; // Allow sort
		$this->ProdiID->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->ProdiID->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['ProdiID'] = &$this->ProdiID;

		// KurikulumKode
		$this->KurikulumKode = new cField('kurikulum', 'kurikulum', 'x_KurikulumKode', 'KurikulumKode', '`KurikulumKode`', '`KurikulumKode`', 200, -1, FALSE, '`KurikulumKode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KurikulumKode->Sortable = TRUE; // Allow sort
		$this->fields['KurikulumKode'] = &$this->KurikulumKode;

		// Nama
		$this->Nama = new cField('kurikulum', 'kurikulum', 'x_Nama', 'Nama', '`Nama`', '`Nama`', 200, -1, FALSE, '`Nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nama->Sortable = TRUE; // Allow sort
		$this->fields['Nama'] = &$this->Nama;

		// JmlSesi
		$this->JmlSesi = new cField('kurikulum', 'kurikulum', 'x_JmlSesi', 'JmlSesi', '`JmlSesi`', '`JmlSesi`', 3, -1, FALSE, '`JmlSesi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JmlSesi->Sortable = TRUE; // Allow sort
		$this->JmlSesi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['JmlSesi'] = &$this->JmlSesi;

		// CreateDate
		$this->CreateDate = new cField('kurikulum', 'kurikulum', 'x_CreateDate', 'CreateDate', '`CreateDate`', ew_CastDateFieldForLike('`CreateDate`', 0, "DB"), 135, 0, FALSE, '`CreateDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CreateDate->Sortable = TRUE; // Allow sort
		$this->CreateDate->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['CreateDate'] = &$this->CreateDate;

		// Creator
		$this->Creator = new cField('kurikulum', 'kurikulum', 'x_Creator', 'Creator', '`Creator`', '`Creator`', 200, -1, FALSE, '`Creator`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Creator->Sortable = TRUE; // Allow sort
		$this->fields['Creator'] = &$this->Creator;

		// EditDate
		$this->EditDate = new cField('kurikulum', 'kurikulum', 'x_EditDate', 'EditDate', '`EditDate`', ew_CastDateFieldForLike('`EditDate`', 0, "DB"), 135, 0, FALSE, '`EditDate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->EditDate->Sortable = TRUE; // Allow sort
		$this->EditDate->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['EditDate'] = &$this->EditDate;

		// Editor
		$this->Editor = new cField('kurikulum', 'kurikulum', 'x_Editor', 'Editor', '`Editor`', '`Editor`', 200, -1, FALSE, '`Editor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Editor->Sortable = TRUE; // Allow sort
		$this->fields['Editor'] = &$this->Editor;

		// NA
		$this->NA = new cField('kurikulum', 'kurikulum', 'x_NA', 'NA', '`NA`', '`NA`', 202, -1, FALSE, '`NA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->NA->Sortable = TRUE; // Allow sort
		$this->NA->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->NA->TrueValue = 'Y';
		$this->NA->FalseValue = 'N';
		$this->NA->OptionCount = 2;
		$this->fields['NA'] = &$this->NA;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "mk") {
			$sDetailUrl = $GLOBALS["mk"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_KurikulumID=" . urlencode($this->KurikulumID->CurrentValue);
			$sDetailUrl .= "&fk_ProdiID=" . urlencode($this->ProdiID->CurrentValue);
			$sDetailUrl .= "&fk_KampusID=" . urlencode($this->KampusID->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "kurikulumlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`kurikulum`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->KurikulumID->setDbValue($conn->Insert_ID());
			$rs['KurikulumID'] = $this->KurikulumID->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();

		// Cascade Update detail table 'mk'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['KurikulumID']) && $rsold['KurikulumID'] <> $rs['KurikulumID'])) { // Update detail field 'KurikulumID'
			$bCascadeUpdate = TRUE;
			$rscascade['KurikulumID'] = $rs['KurikulumID']; 
		}
		if (!is_null($rsold) && (isset($rs['ProdiID']) && $rsold['ProdiID'] <> $rs['ProdiID'])) { // Update detail field 'ProdiID'
			$bCascadeUpdate = TRUE;
			$rscascade['ProdiID'] = $rs['ProdiID']; 
		}
		if (!is_null($rsold) && (isset($rs['KampusID']) && $rsold['KampusID'] <> $rs['KampusID'])) { // Update detail field 'KampusID'
			$bCascadeUpdate = TRUE;
			$rscascade['KampusID'] = $rs['KampusID']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["mk"])) $GLOBALS["mk"] = new cmk();
			$rswrk = $GLOBALS["mk"]->LoadRs("`KurikulumID` = " . ew_QuotedValue($rsold['KurikulumID'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`ProdiID` = " . ew_QuotedValue($rsold['ProdiID'], EW_DATATYPE_STRING, 'DB') . " AND " . "`KampusID` = " . ew_QuotedValue($rsold['KampusID'], EW_DATATYPE_STRING, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'MKID';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$bUpdate = $GLOBALS["mk"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;
				$rswrk->MoveNext();
			}
		}
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'KurikulumID';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('KurikulumID', $rs))
				ew_AddFilter($where, ew_QuotedName('KurikulumID', $this->DBID) . '=' . ew_QuotedValue($rs['KurikulumID'], $this->KurikulumID->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();

		// Cascade delete detail table 'mk'
		if (!isset($GLOBALS["mk"])) $GLOBALS["mk"] = new cmk();
		$rscascade = $GLOBALS["mk"]->LoadRs("`KurikulumID` = " . ew_QuotedValue($rs['KurikulumID'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`ProdiID` = " . ew_QuotedValue($rs['ProdiID'], EW_DATATYPE_STRING, "DB") . " AND " . "`KampusID` = " . ew_QuotedValue($rs['KampusID'], EW_DATATYPE_STRING, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["mk"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`KurikulumID` = @KurikulumID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->KurikulumID->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@KurikulumID@", ew_AdjustSql($this->KurikulumID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "kurikulumlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "kurikulumlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("kurikulumview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("kurikulumview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "kurikulumadd.php?" . $this->UrlParm($parm);
		else
			$url = "kurikulumadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("kurikulumedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("kurikulumedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("kurikulumadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("kurikulumadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("kurikulumdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "KurikulumID:" . ew_VarToJson($this->KurikulumID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->KurikulumID->CurrentValue)) {
			$sUrl .= "KurikulumID=" . urlencode($this->KurikulumID->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["KurikulumID"]))
				$arKeys[] = ew_StripSlashes($_POST["KurikulumID"]);
			elseif (isset($_GET["KurikulumID"]))
				$arKeys[] = ew_StripSlashes($_GET["KurikulumID"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->KurikulumID->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->KurikulumID->setDbValue($rs->fields('KurikulumID'));
		$this->KampusID->setDbValue($rs->fields('KampusID'));
		$this->ProdiID->setDbValue($rs->fields('ProdiID'));
		$this->KurikulumKode->setDbValue($rs->fields('KurikulumKode'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->JmlSesi->setDbValue($rs->fields('JmlSesi'));
		$this->CreateDate->setDbValue($rs->fields('CreateDate'));
		$this->Creator->setDbValue($rs->fields('Creator'));
		$this->EditDate->setDbValue($rs->fields('EditDate'));
		$this->Editor->setDbValue($rs->fields('Editor'));
		$this->NA->setDbValue($rs->fields('NA'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// KurikulumID
		// KampusID
		// ProdiID
		// KurikulumKode
		// Nama
		// JmlSesi
		// CreateDate
		// Creator
		// EditDate
		// Editor
		// NA
		// KurikulumID

		$this->KurikulumID->ViewValue = $this->KurikulumID->CurrentValue;
		$this->KurikulumID->ViewCustomAttributes = "";

		// KampusID
		if (strval($this->KampusID->CurrentValue) <> "") {
			$sFilterWrk = "`KampusID`" . ew_SearchString("=", $this->KampusID->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `KampusID`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `master_kampus`";
		$sWhereWrk = "";
		$this->KampusID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KampusID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KampusID->ViewValue = $this->KampusID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KampusID->ViewValue = $this->KampusID->CurrentValue;
			}
		} else {
			$this->KampusID->ViewValue = NULL;
		}
		$this->KampusID->ViewCustomAttributes = "";

		// ProdiID
		if (strval($this->ProdiID->CurrentValue) <> "") {
			$sFilterWrk = "`ProdiID`" . ew_SearchString("=", $this->ProdiID->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `ProdiID`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `master_prodi`";
		$sWhereWrk = "";
		$this->ProdiID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->ProdiID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `ProdiID` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->ProdiID->ViewValue = $this->ProdiID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->ProdiID->ViewValue = $this->ProdiID->CurrentValue;
			}
		} else {
			$this->ProdiID->ViewValue = NULL;
		}
		$this->ProdiID->CssStyle = "font-weight: bold;";
		$this->ProdiID->ViewCustomAttributes = "";

		// KurikulumKode
		$this->KurikulumKode->ViewValue = $this->KurikulumKode->CurrentValue;
		$this->KurikulumKode->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// JmlSesi
		$this->JmlSesi->ViewValue = $this->JmlSesi->CurrentValue;
		$this->JmlSesi->ViewCustomAttributes = "";

		// CreateDate
		$this->CreateDate->ViewValue = $this->CreateDate->CurrentValue;
		$this->CreateDate->ViewValue = ew_FormatDateTime($this->CreateDate->ViewValue, 0);
		$this->CreateDate->ViewCustomAttributes = "";

		// Creator
		$this->Creator->ViewValue = $this->Creator->CurrentValue;
		$this->Creator->ViewCustomAttributes = "";

		// EditDate
		$this->EditDate->ViewValue = $this->EditDate->CurrentValue;
		$this->EditDate->ViewValue = ew_FormatDateTime($this->EditDate->ViewValue, 0);
		$this->EditDate->ViewCustomAttributes = "";

		// Editor
		$this->Editor->ViewValue = $this->Editor->CurrentValue;
		$this->Editor->ViewCustomAttributes = "";

		// NA
		if (ew_ConvertToBool($this->NA->CurrentValue)) {
			$this->NA->ViewValue = $this->NA->FldTagCaption(1) <> "" ? $this->NA->FldTagCaption(1) : "Y";
		} else {
			$this->NA->ViewValue = $this->NA->FldTagCaption(2) <> "" ? $this->NA->FldTagCaption(2) : "N";
		}
		$this->NA->ViewCustomAttributes = "";

		// KurikulumID
		$this->KurikulumID->LinkCustomAttributes = "";
		$this->KurikulumID->HrefValue = "";
		$this->KurikulumID->TooltipValue = "";

		// KampusID
		$this->KampusID->LinkCustomAttributes = "";
		$this->KampusID->HrefValue = "";
		$this->KampusID->TooltipValue = "";

		// ProdiID
		$this->ProdiID->LinkCustomAttributes = "";
		$this->ProdiID->HrefValue = "";
		$this->ProdiID->TooltipValue = "";

		// KurikulumKode
		$this->KurikulumKode->LinkCustomAttributes = "";
		$this->KurikulumKode->HrefValue = "";
		$this->KurikulumKode->TooltipValue = "";

		// Nama
		$this->Nama->LinkCustomAttributes = "";
		$this->Nama->HrefValue = "";
		$this->Nama->TooltipValue = "";

		// JmlSesi
		$this->JmlSesi->LinkCustomAttributes = "";
		$this->JmlSesi->HrefValue = "";
		$this->JmlSesi->TooltipValue = "";

		// CreateDate
		$this->CreateDate->LinkCustomAttributes = "";
		$this->CreateDate->HrefValue = "";
		$this->CreateDate->TooltipValue = "";

		// Creator
		$this->Creator->LinkCustomAttributes = "";
		$this->Creator->HrefValue = "";
		$this->Creator->TooltipValue = "";

		// EditDate
		$this->EditDate->LinkCustomAttributes = "";
		$this->EditDate->HrefValue = "";
		$this->EditDate->TooltipValue = "";

		// Editor
		$this->Editor->LinkCustomAttributes = "";
		$this->Editor->HrefValue = "";
		$this->Editor->TooltipValue = "";

		// NA
		$this->NA->LinkCustomAttributes = "";
		$this->NA->HrefValue = "";
		$this->NA->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// KurikulumID
		$this->KurikulumID->EditAttrs["class"] = "form-control";
		$this->KurikulumID->EditCustomAttributes = "";
		$this->KurikulumID->EditValue = $this->KurikulumID->CurrentValue;
		$this->KurikulumID->ViewCustomAttributes = "";

		// KampusID
		$this->KampusID->EditAttrs["class"] = "form-control";
		$this->KampusID->EditCustomAttributes = "";

		// ProdiID
		$this->ProdiID->EditAttrs["class"] = "form-control";
		$this->ProdiID->EditCustomAttributes = "";

		// KurikulumKode
		$this->KurikulumKode->EditAttrs["class"] = "form-control";
		$this->KurikulumKode->EditCustomAttributes = "";
		$this->KurikulumKode->EditValue = $this->KurikulumKode->CurrentValue;
		$this->KurikulumKode->PlaceHolder = ew_RemoveHtml($this->KurikulumKode->FldCaption());

		// Nama
		$this->Nama->EditAttrs["class"] = "form-control";
		$this->Nama->EditCustomAttributes = "";
		$this->Nama->EditValue = $this->Nama->CurrentValue;
		$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

		// JmlSesi
		$this->JmlSesi->EditAttrs["class"] = "form-control";
		$this->JmlSesi->EditCustomAttributes = "";
		$this->JmlSesi->EditValue = $this->JmlSesi->CurrentValue;
		$this->JmlSesi->PlaceHolder = ew_RemoveHtml($this->JmlSesi->FldCaption());

		// CreateDate
		// Creator
		// EditDate
		// Editor
		// NA

		$this->NA->EditCustomAttributes = "";
		$this->NA->EditValue = $this->NA->Options(FALSE);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->KurikulumID->Exportable) $Doc->ExportCaption($this->KurikulumID);
					if ($this->KampusID->Exportable) $Doc->ExportCaption($this->KampusID);
					if ($this->ProdiID->Exportable) $Doc->ExportCaption($this->ProdiID);
					if ($this->KurikulumKode->Exportable) $Doc->ExportCaption($this->KurikulumKode);
					if ($this->Nama->Exportable) $Doc->ExportCaption($this->Nama);
					if ($this->JmlSesi->Exportable) $Doc->ExportCaption($this->JmlSesi);
					if ($this->CreateDate->Exportable) $Doc->ExportCaption($this->CreateDate);
					if ($this->Creator->Exportable) $Doc->ExportCaption($this->Creator);
					if ($this->EditDate->Exportable) $Doc->ExportCaption($this->EditDate);
					if ($this->Editor->Exportable) $Doc->ExportCaption($this->Editor);
					if ($this->NA->Exportable) $Doc->ExportCaption($this->NA);
				} else {
					if ($this->KurikulumID->Exportable) $Doc->ExportCaption($this->KurikulumID);
					if ($this->KampusID->Exportable) $Doc->ExportCaption($this->KampusID);
					if ($this->ProdiID->Exportable) $Doc->ExportCaption($this->ProdiID);
					if ($this->KurikulumKode->Exportable) $Doc->ExportCaption($this->KurikulumKode);
					if ($this->Nama->Exportable) $Doc->ExportCaption($this->Nama);
					if ($this->JmlSesi->Exportable) $Doc->ExportCaption($this->JmlSesi);
					if ($this->CreateDate->Exportable) $Doc->ExportCaption($this->CreateDate);
					if ($this->Creator->Exportable) $Doc->ExportCaption($this->Creator);
					if ($this->EditDate->Exportable) $Doc->ExportCaption($this->EditDate);
					if ($this->Editor->Exportable) $Doc->ExportCaption($this->Editor);
					if ($this->NA->Exportable) $Doc->ExportCaption($this->NA);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->KurikulumID->Exportable) $Doc->ExportField($this->KurikulumID);
						if ($this->KampusID->Exportable) $Doc->ExportField($this->KampusID);
						if ($this->ProdiID->Exportable) $Doc->ExportField($this->ProdiID);
						if ($this->KurikulumKode->Exportable) $Doc->ExportField($this->KurikulumKode);
						if ($this->Nama->Exportable) $Doc->ExportField($this->Nama);
						if ($this->JmlSesi->Exportable) $Doc->ExportField($this->JmlSesi);
						if ($this->CreateDate->Exportable) $Doc->ExportField($this->CreateDate);
						if ($this->Creator->Exportable) $Doc->ExportField($this->Creator);
						if ($this->EditDate->Exportable) $Doc->ExportField($this->EditDate);
						if ($this->Editor->Exportable) $Doc->ExportField($this->Editor);
						if ($this->NA->Exportable) $Doc->ExportField($this->NA);
					} else {
						if ($this->KurikulumID->Exportable) $Doc->ExportField($this->KurikulumID);
						if ($this->KampusID->Exportable) $Doc->ExportField($this->KampusID);
						if ($this->ProdiID->Exportable) $Doc->ExportField($this->ProdiID);
						if ($this->KurikulumKode->Exportable) $Doc->ExportField($this->KurikulumKode);
						if ($this->Nama->Exportable) $Doc->ExportField($this->Nama);
						if ($this->JmlSesi->Exportable) $Doc->ExportField($this->JmlSesi);
						if ($this->CreateDate->Exportable) $Doc->ExportField($this->CreateDate);
						if ($this->Creator->Exportable) $Doc->ExportField($this->Creator);
						if ($this->EditDate->Exportable) $Doc->ExportField($this->EditDate);
						if ($this->Editor->Exportable) $Doc->ExportField($this->Editor);
						if ($this->NA->Exportable) $Doc->ExportField($this->NA);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'kurikulum';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'kurikulum';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['KurikulumID'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'kurikulum';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['KurikulumID'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'kurikulum';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['KurikulumID'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserName();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
