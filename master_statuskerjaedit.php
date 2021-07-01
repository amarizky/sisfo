<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "master_statuskerjainfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$master_statuskerja_edit = NULL; // Initialize page object first

class cmaster_statuskerja_edit extends cmaster_statuskerja {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{B4ECA7F4-5928-4768-B0FE-A8227431E424}";

	// Table name
	var $TableName = 'master_statuskerja';

	// Page object name
	var $PageObjName = 'master_statuskerja_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (master_statuskerja)
		if (!isset($GLOBALS["master_statuskerja"]) || get_class($GLOBALS["master_statuskerja"]) == "cmaster_statuskerja") {
			$GLOBALS["master_statuskerja"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["master_statuskerja"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'master_statuskerja', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (users)
		if (!isset($UserTable)) {
			$UserTable = new cusers();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("master_statuskerjalist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->StatusKerjaID->SetVisibility();
		$this->Nama->SetVisibility();
		$this->Def->SetVisibility();
		$this->NA->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $master_statuskerja;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($master_statuskerja);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->FormClassName = "ewForm ewEditForm";
		if (ew_IsMobile() || $this->IsModal)
			$this->FormClassName = ew_Concat("form-horizontal", $this->FormClassName, " ");

		// Load key from QueryString
		if (@$_GET["StatusKerjaID"] <> "") {
			$this->StatusKerjaID->setQueryStringValue($_GET["StatusKerjaID"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->StatusKerjaID->CurrentValue == "") {
			$this->Page_Terminate("master_statuskerjalist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("master_statuskerjalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "master_statuskerjalist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->StatusKerjaID->FldIsDetailKey) {
			$this->StatusKerjaID->setFormValue($objForm->GetValue("x_StatusKerjaID"));
		}
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		if (!$this->Def->FldIsDetailKey) {
			$this->Def->setFormValue($objForm->GetValue("x_Def"));
		}
		if (!$this->NA->FldIsDetailKey) {
			$this->NA->setFormValue($objForm->GetValue("x_NA"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->StatusKerjaID->CurrentValue = $this->StatusKerjaID->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
		$this->Def->CurrentValue = $this->Def->FormValue;
		$this->NA->CurrentValue = $this->NA->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->StatusKerjaID->setDbValue($rs->fields('StatusKerjaID'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Def->setDbValue($rs->fields('Def'));
		$this->NA->setDbValue($rs->fields('NA'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->StatusKerjaID->DbValue = $row['StatusKerjaID'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Def->DbValue = $row['Def'];
		$this->NA->DbValue = $row['NA'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// StatusKerjaID
		// Nama
		// Def
		// NA

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// StatusKerjaID
		$this->StatusKerjaID->ViewValue = $this->StatusKerjaID->CurrentValue;
		$this->StatusKerjaID->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// Def
		if (ew_ConvertToBool($this->Def->CurrentValue)) {
			$this->Def->ViewValue = $this->Def->FldTagCaption(1) <> "" ? $this->Def->FldTagCaption(1) : "Y";
		} else {
			$this->Def->ViewValue = $this->Def->FldTagCaption(2) <> "" ? $this->Def->FldTagCaption(2) : "N";
		}
		$this->Def->ViewCustomAttributes = "";

		// NA
		if (ew_ConvertToBool($this->NA->CurrentValue)) {
			$this->NA->ViewValue = $this->NA->FldTagCaption(1) <> "" ? $this->NA->FldTagCaption(1) : "Y";
		} else {
			$this->NA->ViewValue = $this->NA->FldTagCaption(2) <> "" ? $this->NA->FldTagCaption(2) : "N";
		}
		$this->NA->ViewCustomAttributes = "";

			// StatusKerjaID
			$this->StatusKerjaID->LinkCustomAttributes = "";
			$this->StatusKerjaID->HrefValue = "";
			$this->StatusKerjaID->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Def
			$this->Def->LinkCustomAttributes = "";
			$this->Def->HrefValue = "";
			$this->Def->TooltipValue = "";

			// NA
			$this->NA->LinkCustomAttributes = "";
			$this->NA->HrefValue = "";
			$this->NA->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// StatusKerjaID
			$this->StatusKerjaID->EditAttrs["class"] = "form-control";
			$this->StatusKerjaID->EditCustomAttributes = "";
			$this->StatusKerjaID->EditValue = $this->StatusKerjaID->CurrentValue;
			$this->StatusKerjaID->ViewCustomAttributes = "";

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

			// Def
			$this->Def->EditCustomAttributes = "";
			$this->Def->EditValue = $this->Def->Options(FALSE);

			// NA
			$this->NA->EditCustomAttributes = "";
			$this->NA->EditValue = $this->NA->Options(FALSE);

			// Edit refer script
			// StatusKerjaID

			$this->StatusKerjaID->LinkCustomAttributes = "";
			$this->StatusKerjaID->HrefValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";

			// Def
			$this->Def->LinkCustomAttributes = "";
			$this->Def->HrefValue = "";

			// NA
			$this->NA->LinkCustomAttributes = "";
			$this->NA->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->StatusKerjaID->FldIsDetailKey && !is_null($this->StatusKerjaID->FormValue) && $this->StatusKerjaID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->StatusKerjaID->FldCaption(), $this->StatusKerjaID->ReqErrMsg));
		}
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nama->FldCaption(), $this->Nama->ReqErrMsg));
		}
		if ($this->Def->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Def->FldCaption(), $this->Def->ReqErrMsg));
		}
		if ($this->NA->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NA->FldCaption(), $this->NA->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// StatusKerjaID
			// Nama

			$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", $this->Nama->ReadOnly);

			// Def
			$this->Def->SetDbValueDef($rsnew, ((strval($this->Def->CurrentValue) == "Y") ? "Y" : "N"), "N", $this->Def->ReadOnly);

			// NA
			$this->NA->SetDbValueDef($rsnew, ((strval($this->NA->CurrentValue) == "Y") ? "Y" : "N"), "N", $this->NA->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("master_statuskerjalist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($master_statuskerja_edit)) $master_statuskerja_edit = new cmaster_statuskerja_edit();

// Page init
$master_statuskerja_edit->Page_Init();

// Page main
$master_statuskerja_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$master_statuskerja_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fmaster_statuskerjaedit = new ew_Form("fmaster_statuskerjaedit", "edit");

// Validate form
fmaster_statuskerjaedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_StatusKerjaID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statuskerja->StatusKerjaID->FldCaption(), $master_statuskerja->StatusKerjaID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statuskerja->Nama->FldCaption(), $master_statuskerja->Nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Def");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statuskerja->Def->FldCaption(), $master_statuskerja->Def->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NA");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statuskerja->NA->FldCaption(), $master_statuskerja->NA->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fmaster_statuskerjaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmaster_statuskerjaedit.ValidateRequired = true;
<?php } else { ?>
fmaster_statuskerjaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmaster_statuskerjaedit.Lists["x_Def"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmaster_statuskerjaedit.Lists["x_Def"].Options = <?php echo json_encode($master_statuskerja->Def->Options()) ?>;
fmaster_statuskerjaedit.Lists["x_NA"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmaster_statuskerjaedit.Lists["x_NA"].Options = <?php echo json_encode($master_statuskerja->NA->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$master_statuskerja_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $master_statuskerja_edit->ShowPageHeader(); ?>
<?php
$master_statuskerja_edit->ShowMessage();
?>
<form name="fmaster_statuskerjaedit" id="fmaster_statuskerjaedit" class="<?php echo $master_statuskerja_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($master_statuskerja_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $master_statuskerja_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="master_statuskerja">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($master_statuskerja_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if (!ew_IsMobile() && !$master_statuskerja_edit->IsModal) { ?>
<div class="ewDesktop">
<?php } ?>
<?php if (ew_IsMobile() || $master_statuskerja_edit->IsModal) { ?>
<div>
<?php } else { ?>
<div>
<table id="tbl_master_statuskerjaedit" class="table table-bordered table-striped ewDesktopTable">
<?php } ?>
<?php if ($master_statuskerja->StatusKerjaID->Visible) { // StatusKerjaID ?>
<?php if (ew_IsMobile() || $master_statuskerja_edit->IsModal) { ?>
	<div id="r_StatusKerjaID" class="form-group">
		<label id="elh_master_statuskerja_StatusKerjaID" for="x_StatusKerjaID" class="col-sm-2 control-label ewLabel"><?php echo $master_statuskerja->StatusKerjaID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statuskerja->StatusKerjaID->CellAttributes() ?>>
<span id="el_master_statuskerja_StatusKerjaID">
<span<?php echo $master_statuskerja->StatusKerjaID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $master_statuskerja->StatusKerjaID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="master_statuskerja" data-field="x_StatusKerjaID" name="x_StatusKerjaID" id="x_StatusKerjaID" value="<?php echo ew_HtmlEncode($master_statuskerja->StatusKerjaID->CurrentValue) ?>">
<?php echo $master_statuskerja->StatusKerjaID->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_StatusKerjaID">
		<td><span id="elh_master_statuskerja_StatusKerjaID"><?php echo $master_statuskerja->StatusKerjaID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statuskerja->StatusKerjaID->CellAttributes() ?>>
<span id="el_master_statuskerja_StatusKerjaID">
<span<?php echo $master_statuskerja->StatusKerjaID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $master_statuskerja->StatusKerjaID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="master_statuskerja" data-field="x_StatusKerjaID" name="x_StatusKerjaID" id="x_StatusKerjaID" value="<?php echo ew_HtmlEncode($master_statuskerja->StatusKerjaID->CurrentValue) ?>">
<?php echo $master_statuskerja->StatusKerjaID->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statuskerja->Nama->Visible) { // Nama ?>
<?php if (ew_IsMobile() || $master_statuskerja_edit->IsModal) { ?>
	<div id="r_Nama" class="form-group">
		<label id="elh_master_statuskerja_Nama" for="x_Nama" class="col-sm-2 control-label ewLabel"><?php echo $master_statuskerja->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statuskerja->Nama->CellAttributes() ?>>
<span id="el_master_statuskerja_Nama">
<input type="text" data-table="master_statuskerja" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($master_statuskerja->Nama->getPlaceHolder()) ?>" value="<?php echo $master_statuskerja->Nama->EditValue ?>"<?php echo $master_statuskerja->Nama->EditAttributes() ?>>
</span>
<?php echo $master_statuskerja->Nama->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama">
		<td><span id="elh_master_statuskerja_Nama"><?php echo $master_statuskerja->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statuskerja->Nama->CellAttributes() ?>>
<span id="el_master_statuskerja_Nama">
<input type="text" data-table="master_statuskerja" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($master_statuskerja->Nama->getPlaceHolder()) ?>" value="<?php echo $master_statuskerja->Nama->EditValue ?>"<?php echo $master_statuskerja->Nama->EditAttributes() ?>>
</span>
<?php echo $master_statuskerja->Nama->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statuskerja->Def->Visible) { // Def ?>
<?php if (ew_IsMobile() || $master_statuskerja_edit->IsModal) { ?>
	<div id="r_Def" class="form-group">
		<label id="elh_master_statuskerja_Def" class="col-sm-2 control-label ewLabel"><?php echo $master_statuskerja->Def->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statuskerja->Def->CellAttributes() ?>>
<span id="el_master_statuskerja_Def">
<div id="tp_x_Def" class="ewTemplate"><input type="radio" data-table="master_statuskerja" data-field="x_Def" data-value-separator="<?php echo $master_statuskerja->Def->DisplayValueSeparatorAttribute() ?>" name="x_Def" id="x_Def" value="{value}"<?php echo $master_statuskerja->Def->EditAttributes() ?>></div>
<div id="dsl_x_Def" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statuskerja->Def->RadioButtonListHtml(FALSE, "x_Def") ?>
</div></div>
</span>
<?php echo $master_statuskerja->Def->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Def">
		<td><span id="elh_master_statuskerja_Def"><?php echo $master_statuskerja->Def->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statuskerja->Def->CellAttributes() ?>>
<span id="el_master_statuskerja_Def">
<div id="tp_x_Def" class="ewTemplate"><input type="radio" data-table="master_statuskerja" data-field="x_Def" data-value-separator="<?php echo $master_statuskerja->Def->DisplayValueSeparatorAttribute() ?>" name="x_Def" id="x_Def" value="{value}"<?php echo $master_statuskerja->Def->EditAttributes() ?>></div>
<div id="dsl_x_Def" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statuskerja->Def->RadioButtonListHtml(FALSE, "x_Def") ?>
</div></div>
</span>
<?php echo $master_statuskerja->Def->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statuskerja->NA->Visible) { // NA ?>
<?php if (ew_IsMobile() || $master_statuskerja_edit->IsModal) { ?>
	<div id="r_NA" class="form-group">
		<label id="elh_master_statuskerja_NA" class="col-sm-2 control-label ewLabel"><?php echo $master_statuskerja->NA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statuskerja->NA->CellAttributes() ?>>
<span id="el_master_statuskerja_NA">
<div id="tp_x_NA" class="ewTemplate"><input type="radio" data-table="master_statuskerja" data-field="x_NA" data-value-separator="<?php echo $master_statuskerja->NA->DisplayValueSeparatorAttribute() ?>" name="x_NA" id="x_NA" value="{value}"<?php echo $master_statuskerja->NA->EditAttributes() ?>></div>
<div id="dsl_x_NA" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statuskerja->NA->RadioButtonListHtml(FALSE, "x_NA") ?>
</div></div>
</span>
<?php echo $master_statuskerja->NA->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_NA">
		<td><span id="elh_master_statuskerja_NA"><?php echo $master_statuskerja->NA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statuskerja->NA->CellAttributes() ?>>
<span id="el_master_statuskerja_NA">
<div id="tp_x_NA" class="ewTemplate"><input type="radio" data-table="master_statuskerja" data-field="x_NA" data-value-separator="<?php echo $master_statuskerja->NA->DisplayValueSeparatorAttribute() ?>" name="x_NA" id="x_NA" value="{value}"<?php echo $master_statuskerja->NA->EditAttributes() ?>></div>
<div id="dsl_x_NA" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statuskerja->NA->RadioButtonListHtml(FALSE, "x_NA") ?>
</div></div>
</span>
<?php echo $master_statuskerja->NA->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if (ew_IsMobile() || $master_statuskerja_edit->IsModal) { ?>
</div>
<?php } else { ?>
</table>
</div>
<?php } ?>
<?php if (!$master_statuskerja_edit->IsModal) { ?>
<div class="ewDesktopButton">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $master_statuskerja_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fmaster_statuskerjaedit.Init();
</script>
<?php
$master_statuskerja_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$master_statuskerja_edit->Page_Terminate();
?>
