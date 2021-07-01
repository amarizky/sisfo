<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "master_jenjanginfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$master_jenjang_add = NULL; // Initialize page object first

class cmaster_jenjang_add extends cmaster_jenjang {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B4ECA7F4-5928-4768-B0FE-A8227431E424}";

	// Table name
	var $TableName = 'master_jenjang';

	// Page object name
	var $PageObjName = 'master_jenjang_add';

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

		// Table object (master_jenjang)
		if (!isset($GLOBALS["master_jenjang"]) || get_class($GLOBALS["master_jenjang"]) == "cmaster_jenjang") {
			$GLOBALS["master_jenjang"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["master_jenjang"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'master_jenjang', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("master_jenjanglist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->JenjangID->SetVisibility();
		$this->Nama->SetVisibility();
		$this->Nama_en->SetVisibility();
		$this->Keterangan->SetVisibility();
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
		global $EW_EXPORT, $master_jenjang;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($master_jenjang);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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
		$this->FormClassName = "ewForm ewAddForm";
		if (ew_IsMobile() || $this->IsModal)
			$this->FormClassName = ew_Concat("form-horizontal", $this->FormClassName, " ");

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["JenjangID"] != "") {
				$this->JenjangID->setQueryStringValue($_GET["JenjangID"]);
				$this->setKey("JenjangID", $this->JenjangID->CurrentValue); // Set up key
			} else {
				$this->setKey("JenjangID", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("master_jenjanglist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "master_jenjanglist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "master_jenjangview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->JenjangID->CurrentValue = NULL;
		$this->JenjangID->OldValue = $this->JenjangID->CurrentValue;
		$this->Nama->CurrentValue = NULL;
		$this->Nama->OldValue = $this->Nama->CurrentValue;
		$this->Nama_en->CurrentValue = NULL;
		$this->Nama_en->OldValue = $this->Nama_en->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
		$this->Def->CurrentValue = "N";
		$this->NA->CurrentValue = "N";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->JenjangID->FldIsDetailKey) {
			$this->JenjangID->setFormValue($objForm->GetValue("x_JenjangID"));
		}
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		if (!$this->Nama_en->FldIsDetailKey) {
			$this->Nama_en->setFormValue($objForm->GetValue("x_Nama_en"));
		}
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
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
		$this->LoadOldRecord();
		$this->JenjangID->CurrentValue = $this->JenjangID->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
		$this->Nama_en->CurrentValue = $this->Nama_en->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
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
		$this->JenjangID->setDbValue($rs->fields('JenjangID'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Nama_en->setDbValue($rs->fields('Nama_en'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->Def->setDbValue($rs->fields('Def'));
		$this->NA->setDbValue($rs->fields('NA'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->JenjangID->DbValue = $row['JenjangID'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Nama_en->DbValue = $row['Nama_en'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Def->DbValue = $row['Def'];
		$this->NA->DbValue = $row['NA'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("JenjangID")) <> "")
			$this->JenjangID->CurrentValue = $this->getKey("JenjangID"); // JenjangID
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// JenjangID
		// Nama
		// Nama_en
		// Keterangan
		// Def
		// NA

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// JenjangID
		$this->JenjangID->ViewValue = $this->JenjangID->CurrentValue;
		$this->JenjangID->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// Nama_en
		$this->Nama_en->ViewValue = $this->Nama_en->CurrentValue;
		$this->Nama_en->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

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

			// JenjangID
			$this->JenjangID->LinkCustomAttributes = "";
			$this->JenjangID->HrefValue = "";
			$this->JenjangID->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Nama_en
			$this->Nama_en->LinkCustomAttributes = "";
			$this->Nama_en->HrefValue = "";
			$this->Nama_en->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// Def
			$this->Def->LinkCustomAttributes = "";
			$this->Def->HrefValue = "";
			$this->Def->TooltipValue = "";

			// NA
			$this->NA->LinkCustomAttributes = "";
			$this->NA->HrefValue = "";
			$this->NA->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// JenjangID
			$this->JenjangID->EditAttrs["class"] = "form-control";
			$this->JenjangID->EditCustomAttributes = "";
			$this->JenjangID->EditValue = ew_HtmlEncode($this->JenjangID->CurrentValue);
			$this->JenjangID->PlaceHolder = ew_RemoveHtml($this->JenjangID->FldCaption());

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

			// Nama_en
			$this->Nama_en->EditAttrs["class"] = "form-control";
			$this->Nama_en->EditCustomAttributes = "";
			$this->Nama_en->EditValue = ew_HtmlEncode($this->Nama_en->CurrentValue);
			$this->Nama_en->PlaceHolder = ew_RemoveHtml($this->Nama_en->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Def
			$this->Def->EditCustomAttributes = "";
			$this->Def->EditValue = $this->Def->Options(FALSE);

			// NA
			$this->NA->EditCustomAttributes = "";
			$this->NA->EditValue = $this->NA->Options(FALSE);

			// Add refer script
			// JenjangID

			$this->JenjangID->LinkCustomAttributes = "";
			$this->JenjangID->HrefValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";

			// Nama_en
			$this->Nama_en->LinkCustomAttributes = "";
			$this->Nama_en->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

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
		if (!$this->JenjangID->FldIsDetailKey && !is_null($this->JenjangID->FormValue) && $this->JenjangID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->JenjangID->FldCaption(), $this->JenjangID->ReqErrMsg));
		}
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nama->FldCaption(), $this->Nama->ReqErrMsg));
		}
		if (!$this->Nama_en->FldIsDetailKey && !is_null($this->Nama_en->FormValue) && $this->Nama_en->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nama_en->FldCaption(), $this->Nama_en->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// JenjangID
		$this->JenjangID->SetDbValueDef($rsnew, $this->JenjangID->CurrentValue, "", FALSE);

		// Nama
		$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", FALSE);

		// Nama_en
		$this->Nama_en->SetDbValueDef($rsnew, $this->Nama_en->CurrentValue, "", FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// Def
		$this->Def->SetDbValueDef($rsnew, ((strval($this->Def->CurrentValue) == "Y") ? "Y" : "N"), "N", strval($this->Def->CurrentValue) == "");

		// NA
		$this->NA->SetDbValueDef($rsnew, ((strval($this->NA->CurrentValue) == "Y") ? "Y" : "N"), "N", strval($this->NA->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['JenjangID']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("master_jenjanglist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($master_jenjang_add)) $master_jenjang_add = new cmaster_jenjang_add();

// Page init
$master_jenjang_add->Page_Init();

// Page main
$master_jenjang_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$master_jenjang_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fmaster_jenjangadd = new ew_Form("fmaster_jenjangadd", "add");

// Validate form
fmaster_jenjangadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_JenjangID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_jenjang->JenjangID->FldCaption(), $master_jenjang->JenjangID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_jenjang->Nama->FldCaption(), $master_jenjang->Nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nama_en");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_jenjang->Nama_en->FldCaption(), $master_jenjang->Nama_en->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Def");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_jenjang->Def->FldCaption(), $master_jenjang->Def->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NA");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_jenjang->NA->FldCaption(), $master_jenjang->NA->ReqErrMsg)) ?>");

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
fmaster_jenjangadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmaster_jenjangadd.ValidateRequired = true;
<?php } else { ?>
fmaster_jenjangadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmaster_jenjangadd.Lists["x_Def"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmaster_jenjangadd.Lists["x_Def"].Options = <?php echo json_encode($master_jenjang->Def->Options()) ?>;
fmaster_jenjangadd.Lists["x_NA"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmaster_jenjangadd.Lists["x_NA"].Options = <?php echo json_encode($master_jenjang->NA->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$master_jenjang_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $master_jenjang_add->ShowPageHeader(); ?>
<?php
$master_jenjang_add->ShowMessage();
?>
<form name="fmaster_jenjangadd" id="fmaster_jenjangadd" class="<?php echo $master_jenjang_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($master_jenjang_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $master_jenjang_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="master_jenjang">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($master_jenjang_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if (!ew_IsMobile() && !$master_jenjang_add->IsModal) { ?>
<div class="ewDesktop">
<?php } ?>
<?php if (ew_IsMobile() || $master_jenjang_add->IsModal) { ?>
<div>
<?php } else { ?>
<div>
<table id="tbl_master_jenjangadd" class="table table-bordered table-striped ewDesktopTable">
<?php } ?>
<?php if ($master_jenjang->JenjangID->Visible) { // JenjangID ?>
<?php if (ew_IsMobile() || $master_jenjang_add->IsModal) { ?>
	<div id="r_JenjangID" class="form-group">
		<label id="elh_master_jenjang_JenjangID" for="x_JenjangID" class="col-sm-2 control-label ewLabel"><?php echo $master_jenjang->JenjangID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_jenjang->JenjangID->CellAttributes() ?>>
<span id="el_master_jenjang_JenjangID">
<input type="text" data-table="master_jenjang" data-field="x_JenjangID" name="x_JenjangID" id="x_JenjangID" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($master_jenjang->JenjangID->getPlaceHolder()) ?>" value="<?php echo $master_jenjang->JenjangID->EditValue ?>"<?php echo $master_jenjang->JenjangID->EditAttributes() ?>>
</span>
<?php echo $master_jenjang->JenjangID->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_JenjangID">
		<td><span id="elh_master_jenjang_JenjangID"><?php echo $master_jenjang->JenjangID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_jenjang->JenjangID->CellAttributes() ?>>
<span id="el_master_jenjang_JenjangID">
<input type="text" data-table="master_jenjang" data-field="x_JenjangID" name="x_JenjangID" id="x_JenjangID" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($master_jenjang->JenjangID->getPlaceHolder()) ?>" value="<?php echo $master_jenjang->JenjangID->EditValue ?>"<?php echo $master_jenjang->JenjangID->EditAttributes() ?>>
</span>
<?php echo $master_jenjang->JenjangID->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_jenjang->Nama->Visible) { // Nama ?>
<?php if (ew_IsMobile() || $master_jenjang_add->IsModal) { ?>
	<div id="r_Nama" class="form-group">
		<label id="elh_master_jenjang_Nama" for="x_Nama" class="col-sm-2 control-label ewLabel"><?php echo $master_jenjang->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_jenjang->Nama->CellAttributes() ?>>
<span id="el_master_jenjang_Nama">
<input type="text" data-table="master_jenjang" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($master_jenjang->Nama->getPlaceHolder()) ?>" value="<?php echo $master_jenjang->Nama->EditValue ?>"<?php echo $master_jenjang->Nama->EditAttributes() ?>>
</span>
<?php echo $master_jenjang->Nama->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama">
		<td><span id="elh_master_jenjang_Nama"><?php echo $master_jenjang->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_jenjang->Nama->CellAttributes() ?>>
<span id="el_master_jenjang_Nama">
<input type="text" data-table="master_jenjang" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($master_jenjang->Nama->getPlaceHolder()) ?>" value="<?php echo $master_jenjang->Nama->EditValue ?>"<?php echo $master_jenjang->Nama->EditAttributes() ?>>
</span>
<?php echo $master_jenjang->Nama->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_jenjang->Nama_en->Visible) { // Nama_en ?>
<?php if (ew_IsMobile() || $master_jenjang_add->IsModal) { ?>
	<div id="r_Nama_en" class="form-group">
		<label id="elh_master_jenjang_Nama_en" for="x_Nama_en" class="col-sm-2 control-label ewLabel"><?php echo $master_jenjang->Nama_en->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_jenjang->Nama_en->CellAttributes() ?>>
<span id="el_master_jenjang_Nama_en">
<input type="text" data-table="master_jenjang" data-field="x_Nama_en" name="x_Nama_en" id="x_Nama_en" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($master_jenjang->Nama_en->getPlaceHolder()) ?>" value="<?php echo $master_jenjang->Nama_en->EditValue ?>"<?php echo $master_jenjang->Nama_en->EditAttributes() ?>>
</span>
<?php echo $master_jenjang->Nama_en->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama_en">
		<td><span id="elh_master_jenjang_Nama_en"><?php echo $master_jenjang->Nama_en->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_jenjang->Nama_en->CellAttributes() ?>>
<span id="el_master_jenjang_Nama_en">
<input type="text" data-table="master_jenjang" data-field="x_Nama_en" name="x_Nama_en" id="x_Nama_en" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($master_jenjang->Nama_en->getPlaceHolder()) ?>" value="<?php echo $master_jenjang->Nama_en->EditValue ?>"<?php echo $master_jenjang->Nama_en->EditAttributes() ?>>
</span>
<?php echo $master_jenjang->Nama_en->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_jenjang->Keterangan->Visible) { // Keterangan ?>
<?php if (ew_IsMobile() || $master_jenjang_add->IsModal) { ?>
	<div id="r_Keterangan" class="form-group">
		<label id="elh_master_jenjang_Keterangan" for="x_Keterangan" class="col-sm-2 control-label ewLabel"><?php echo $master_jenjang->Keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $master_jenjang->Keterangan->CellAttributes() ?>>
<span id="el_master_jenjang_Keterangan">
<input type="text" data-table="master_jenjang" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($master_jenjang->Keterangan->getPlaceHolder()) ?>" value="<?php echo $master_jenjang->Keterangan->EditValue ?>"<?php echo $master_jenjang->Keterangan->EditAttributes() ?>>
</span>
<?php echo $master_jenjang->Keterangan->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Keterangan">
		<td><span id="elh_master_jenjang_Keterangan"><?php echo $master_jenjang->Keterangan->FldCaption() ?></span></td>
		<td<?php echo $master_jenjang->Keterangan->CellAttributes() ?>>
<span id="el_master_jenjang_Keterangan">
<input type="text" data-table="master_jenjang" data-field="x_Keterangan" name="x_Keterangan" id="x_Keterangan" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($master_jenjang->Keterangan->getPlaceHolder()) ?>" value="<?php echo $master_jenjang->Keterangan->EditValue ?>"<?php echo $master_jenjang->Keterangan->EditAttributes() ?>>
</span>
<?php echo $master_jenjang->Keterangan->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_jenjang->Def->Visible) { // Def ?>
<?php if (ew_IsMobile() || $master_jenjang_add->IsModal) { ?>
	<div id="r_Def" class="form-group">
		<label id="elh_master_jenjang_Def" class="col-sm-2 control-label ewLabel"><?php echo $master_jenjang->Def->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_jenjang->Def->CellAttributes() ?>>
<span id="el_master_jenjang_Def">
<div id="tp_x_Def" class="ewTemplate"><input type="radio" data-table="master_jenjang" data-field="x_Def" data-value-separator="<?php echo $master_jenjang->Def->DisplayValueSeparatorAttribute() ?>" name="x_Def" id="x_Def" value="{value}"<?php echo $master_jenjang->Def->EditAttributes() ?>></div>
<div id="dsl_x_Def" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_jenjang->Def->RadioButtonListHtml(FALSE, "x_Def") ?>
</div></div>
</span>
<?php echo $master_jenjang->Def->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Def">
		<td><span id="elh_master_jenjang_Def"><?php echo $master_jenjang->Def->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_jenjang->Def->CellAttributes() ?>>
<span id="el_master_jenjang_Def">
<div id="tp_x_Def" class="ewTemplate"><input type="radio" data-table="master_jenjang" data-field="x_Def" data-value-separator="<?php echo $master_jenjang->Def->DisplayValueSeparatorAttribute() ?>" name="x_Def" id="x_Def" value="{value}"<?php echo $master_jenjang->Def->EditAttributes() ?>></div>
<div id="dsl_x_Def" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_jenjang->Def->RadioButtonListHtml(FALSE, "x_Def") ?>
</div></div>
</span>
<?php echo $master_jenjang->Def->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_jenjang->NA->Visible) { // NA ?>
<?php if (ew_IsMobile() || $master_jenjang_add->IsModal) { ?>
	<div id="r_NA" class="form-group">
		<label id="elh_master_jenjang_NA" class="col-sm-2 control-label ewLabel"><?php echo $master_jenjang->NA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_jenjang->NA->CellAttributes() ?>>
<span id="el_master_jenjang_NA">
<div id="tp_x_NA" class="ewTemplate"><input type="radio" data-table="master_jenjang" data-field="x_NA" data-value-separator="<?php echo $master_jenjang->NA->DisplayValueSeparatorAttribute() ?>" name="x_NA" id="x_NA" value="{value}"<?php echo $master_jenjang->NA->EditAttributes() ?>></div>
<div id="dsl_x_NA" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_jenjang->NA->RadioButtonListHtml(FALSE, "x_NA") ?>
</div></div>
</span>
<?php echo $master_jenjang->NA->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_NA">
		<td><span id="elh_master_jenjang_NA"><?php echo $master_jenjang->NA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_jenjang->NA->CellAttributes() ?>>
<span id="el_master_jenjang_NA">
<div id="tp_x_NA" class="ewTemplate"><input type="radio" data-table="master_jenjang" data-field="x_NA" data-value-separator="<?php echo $master_jenjang->NA->DisplayValueSeparatorAttribute() ?>" name="x_NA" id="x_NA" value="{value}"<?php echo $master_jenjang->NA->EditAttributes() ?>></div>
<div id="dsl_x_NA" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_jenjang->NA->RadioButtonListHtml(FALSE, "x_NA") ?>
</div></div>
</span>
<?php echo $master_jenjang->NA->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if (ew_IsMobile() || $master_jenjang_add->IsModal) { ?>
</div>
<?php } else { ?>
</table>
</div>
<?php } ?>
<?php if (!$master_jenjang_add->IsModal) { ?>
<div class="ewDesktopButton">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $master_jenjang_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fmaster_jenjangadd.Init();
</script>
<?php
$master_jenjang_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$master_jenjang_add->Page_Terminate();
?>
