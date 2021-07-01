<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "master_statusstudentinfo.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$master_statusstudent_add = NULL; // Initialize page object first

class cmaster_statusstudent_add extends cmaster_statusstudent {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{B4ECA7F4-5928-4768-B0FE-A8227431E424}";

	// Table name
	var $TableName = 'master_statusstudent';

	// Page object name
	var $PageObjName = 'master_statusstudent_add';

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

		// Table object (master_statusstudent)
		if (!isset($GLOBALS["master_statusstudent"]) || get_class($GLOBALS["master_statusstudent"]) == "cmaster_statusstudent") {
			$GLOBALS["master_statusstudent"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["master_statusstudent"];
		}

		// Table object (users)
		if (!isset($GLOBALS['users'])) $GLOBALS['users'] = new cusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'master_statusstudent', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("master_statusstudentlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->StatusStudentID->SetVisibility();
		$this->Nama->SetVisibility();
		$this->Nilai->SetVisibility();
		$this->Keluar->SetVisibility();
		$this->Def->SetVisibility();
		$this->Lulus->SetVisibility();
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
		global $EW_EXPORT, $master_statusstudent;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($master_statusstudent);
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
			if (@$_GET["StatusStudentID"] != "") {
				$this->StatusStudentID->setQueryStringValue($_GET["StatusStudentID"]);
				$this->setKey("StatusStudentID", $this->StatusStudentID->CurrentValue); // Set up key
			} else {
				$this->setKey("StatusStudentID", ""); // Clear key
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
					$this->Page_Terminate("master_statusstudentlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "master_statusstudentlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "master_statusstudentview.php")
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
		$this->StatusStudentID->CurrentValue = NULL;
		$this->StatusStudentID->OldValue = $this->StatusStudentID->CurrentValue;
		$this->Nama->CurrentValue = NULL;
		$this->Nama->OldValue = $this->Nama->CurrentValue;
		$this->Nilai->CurrentValue = 0;
		$this->Keluar->CurrentValue = "N";
		$this->Def->CurrentValue = "N";
		$this->Lulus->CurrentValue = "N";
		$this->NA->CurrentValue = "N";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->StatusStudentID->FldIsDetailKey) {
			$this->StatusStudentID->setFormValue($objForm->GetValue("x_StatusStudentID"));
		}
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		if (!$this->Nilai->FldIsDetailKey) {
			$this->Nilai->setFormValue($objForm->GetValue("x_Nilai"));
		}
		if (!$this->Keluar->FldIsDetailKey) {
			$this->Keluar->setFormValue($objForm->GetValue("x_Keluar"));
		}
		if (!$this->Def->FldIsDetailKey) {
			$this->Def->setFormValue($objForm->GetValue("x_Def"));
		}
		if (!$this->Lulus->FldIsDetailKey) {
			$this->Lulus->setFormValue($objForm->GetValue("x_Lulus"));
		}
		if (!$this->NA->FldIsDetailKey) {
			$this->NA->setFormValue($objForm->GetValue("x_NA"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->StatusStudentID->CurrentValue = $this->StatusStudentID->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
		$this->Nilai->CurrentValue = $this->Nilai->FormValue;
		$this->Keluar->CurrentValue = $this->Keluar->FormValue;
		$this->Def->CurrentValue = $this->Def->FormValue;
		$this->Lulus->CurrentValue = $this->Lulus->FormValue;
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
		$this->StatusStudentID->setDbValue($rs->fields('StatusStudentID'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Nilai->setDbValue($rs->fields('Nilai'));
		$this->Keluar->setDbValue($rs->fields('Keluar'));
		$this->Def->setDbValue($rs->fields('Def'));
		$this->Lulus->setDbValue($rs->fields('Lulus'));
		$this->NA->setDbValue($rs->fields('NA'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->StatusStudentID->DbValue = $row['StatusStudentID'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Nilai->DbValue = $row['Nilai'];
		$this->Keluar->DbValue = $row['Keluar'];
		$this->Def->DbValue = $row['Def'];
		$this->Lulus->DbValue = $row['Lulus'];
		$this->NA->DbValue = $row['NA'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("StatusStudentID")) <> "")
			$this->StatusStudentID->CurrentValue = $this->getKey("StatusStudentID"); // StatusStudentID
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
		// StatusStudentID
		// Nama
		// Nilai
		// Keluar
		// Def
		// Lulus
		// NA

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// StatusStudentID
		$this->StatusStudentID->ViewValue = $this->StatusStudentID->CurrentValue;
		$this->StatusStudentID->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// Nilai
		$this->Nilai->ViewValue = $this->Nilai->CurrentValue;
		$this->Nilai->ViewCustomAttributes = "";

		// Keluar
		if (ew_ConvertToBool($this->Keluar->CurrentValue)) {
			$this->Keluar->ViewValue = $this->Keluar->FldTagCaption(1) <> "" ? $this->Keluar->FldTagCaption(1) : "Y";
		} else {
			$this->Keluar->ViewValue = $this->Keluar->FldTagCaption(2) <> "" ? $this->Keluar->FldTagCaption(2) : "N";
		}
		$this->Keluar->ViewCustomAttributes = "";

		// Def
		if (ew_ConvertToBool($this->Def->CurrentValue)) {
			$this->Def->ViewValue = $this->Def->FldTagCaption(1) <> "" ? $this->Def->FldTagCaption(1) : "Y";
		} else {
			$this->Def->ViewValue = $this->Def->FldTagCaption(2) <> "" ? $this->Def->FldTagCaption(2) : "N";
		}
		$this->Def->ViewCustomAttributes = "";

		// Lulus
		if (ew_ConvertToBool($this->Lulus->CurrentValue)) {
			$this->Lulus->ViewValue = $this->Lulus->FldTagCaption(1) <> "" ? $this->Lulus->FldTagCaption(1) : "Y";
		} else {
			$this->Lulus->ViewValue = $this->Lulus->FldTagCaption(2) <> "" ? $this->Lulus->FldTagCaption(2) : "N";
		}
		$this->Lulus->ViewCustomAttributes = "";

		// NA
		if (ew_ConvertToBool($this->NA->CurrentValue)) {
			$this->NA->ViewValue = $this->NA->FldTagCaption(1) <> "" ? $this->NA->FldTagCaption(1) : "Y";
		} else {
			$this->NA->ViewValue = $this->NA->FldTagCaption(2) <> "" ? $this->NA->FldTagCaption(2) : "N";
		}
		$this->NA->ViewCustomAttributes = "";

			// StatusStudentID
			$this->StatusStudentID->LinkCustomAttributes = "";
			$this->StatusStudentID->HrefValue = "";
			$this->StatusStudentID->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";
			$this->Nilai->TooltipValue = "";

			// Keluar
			$this->Keluar->LinkCustomAttributes = "";
			$this->Keluar->HrefValue = "";
			$this->Keluar->TooltipValue = "";

			// Def
			$this->Def->LinkCustomAttributes = "";
			$this->Def->HrefValue = "";
			$this->Def->TooltipValue = "";

			// Lulus
			$this->Lulus->LinkCustomAttributes = "";
			$this->Lulus->HrefValue = "";
			$this->Lulus->TooltipValue = "";

			// NA
			$this->NA->LinkCustomAttributes = "";
			$this->NA->HrefValue = "";
			$this->NA->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// StatusStudentID
			$this->StatusStudentID->EditAttrs["class"] = "form-control";
			$this->StatusStudentID->EditCustomAttributes = "";
			$this->StatusStudentID->EditValue = ew_HtmlEncode($this->StatusStudentID->CurrentValue);
			$this->StatusStudentID->PlaceHolder = ew_RemoveHtml($this->StatusStudentID->FldCaption());

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

			// Nilai
			$this->Nilai->EditAttrs["class"] = "form-control";
			$this->Nilai->EditCustomAttributes = "";
			$this->Nilai->EditValue = ew_HtmlEncode($this->Nilai->CurrentValue);
			$this->Nilai->PlaceHolder = ew_RemoveHtml($this->Nilai->FldCaption());

			// Keluar
			$this->Keluar->EditCustomAttributes = "";
			$this->Keluar->EditValue = $this->Keluar->Options(FALSE);

			// Def
			$this->Def->EditCustomAttributes = "";
			$this->Def->EditValue = $this->Def->Options(FALSE);

			// Lulus
			$this->Lulus->EditCustomAttributes = "";
			$this->Lulus->EditValue = $this->Lulus->Options(FALSE);

			// NA
			$this->NA->EditCustomAttributes = "";
			$this->NA->EditValue = $this->NA->Options(FALSE);

			// Add refer script
			// StatusStudentID

			$this->StatusStudentID->LinkCustomAttributes = "";
			$this->StatusStudentID->HrefValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";

			// Nilai
			$this->Nilai->LinkCustomAttributes = "";
			$this->Nilai->HrefValue = "";

			// Keluar
			$this->Keluar->LinkCustomAttributes = "";
			$this->Keluar->HrefValue = "";

			// Def
			$this->Def->LinkCustomAttributes = "";
			$this->Def->HrefValue = "";

			// Lulus
			$this->Lulus->LinkCustomAttributes = "";
			$this->Lulus->HrefValue = "";

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
		if (!$this->StatusStudentID->FldIsDetailKey && !is_null($this->StatusStudentID->FormValue) && $this->StatusStudentID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->StatusStudentID->FldCaption(), $this->StatusStudentID->ReqErrMsg));
		}
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nama->FldCaption(), $this->Nama->ReqErrMsg));
		}
		if (!$this->Nilai->FldIsDetailKey && !is_null($this->Nilai->FormValue) && $this->Nilai->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nilai->FldCaption(), $this->Nilai->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Nilai->FormValue)) {
			ew_AddMessage($gsFormError, $this->Nilai->FldErrMsg());
		}
		if ($this->Keluar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Keluar->FldCaption(), $this->Keluar->ReqErrMsg));
		}
		if ($this->Def->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Def->FldCaption(), $this->Def->ReqErrMsg));
		}
		if ($this->Lulus->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Lulus->FldCaption(), $this->Lulus->ReqErrMsg));
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

		// StatusStudentID
		$this->StatusStudentID->SetDbValueDef($rsnew, $this->StatusStudentID->CurrentValue, "", FALSE);

		// Nama
		$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", FALSE);

		// Nilai
		$this->Nilai->SetDbValueDef($rsnew, $this->Nilai->CurrentValue, 0, strval($this->Nilai->CurrentValue) == "");

		// Keluar
		$this->Keluar->SetDbValueDef($rsnew, ((strval($this->Keluar->CurrentValue) == "Y") ? "Y" : "N"), "N", strval($this->Keluar->CurrentValue) == "");

		// Def
		$this->Def->SetDbValueDef($rsnew, ((strval($this->Def->CurrentValue) == "Y") ? "Y" : "N"), "N", strval($this->Def->CurrentValue) == "");

		// Lulus
		$this->Lulus->SetDbValueDef($rsnew, ((strval($this->Lulus->CurrentValue) == "Y") ? "Y" : "N"), "N", strval($this->Lulus->CurrentValue) == "");

		// NA
		$this->NA->SetDbValueDef($rsnew, ((strval($this->NA->CurrentValue) == "Y") ? "Y" : "N"), "N", strval($this->NA->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['StatusStudentID']) == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("master_statusstudentlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($master_statusstudent_add)) $master_statusstudent_add = new cmaster_statusstudent_add();

// Page init
$master_statusstudent_add->Page_Init();

// Page main
$master_statusstudent_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$master_statusstudent_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fmaster_statusstudentadd = new ew_Form("fmaster_statusstudentadd", "add");

// Validate form
fmaster_statusstudentadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_StatusStudentID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statusstudent->StatusStudentID->FldCaption(), $master_statusstudent->StatusStudentID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statusstudent->Nama->FldCaption(), $master_statusstudent->Nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statusstudent->Nilai->FldCaption(), $master_statusstudent->Nilai->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nilai");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($master_statusstudent->Nilai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Keluar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statusstudent->Keluar->FldCaption(), $master_statusstudent->Keluar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Def");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statusstudent->Def->FldCaption(), $master_statusstudent->Def->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Lulus");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statusstudent->Lulus->FldCaption(), $master_statusstudent->Lulus->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NA");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $master_statusstudent->NA->FldCaption(), $master_statusstudent->NA->ReqErrMsg)) ?>");

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
fmaster_statusstudentadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmaster_statusstudentadd.ValidateRequired = true;
<?php } else { ?>
fmaster_statusstudentadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmaster_statusstudentadd.Lists["x_Keluar"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmaster_statusstudentadd.Lists["x_Keluar"].Options = <?php echo json_encode($master_statusstudent->Keluar->Options()) ?>;
fmaster_statusstudentadd.Lists["x_Def"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmaster_statusstudentadd.Lists["x_Def"].Options = <?php echo json_encode($master_statusstudent->Def->Options()) ?>;
fmaster_statusstudentadd.Lists["x_Lulus"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmaster_statusstudentadd.Lists["x_Lulus"].Options = <?php echo json_encode($master_statusstudent->Lulus->Options()) ?>;
fmaster_statusstudentadd.Lists["x_NA"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmaster_statusstudentadd.Lists["x_NA"].Options = <?php echo json_encode($master_statusstudent->NA->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$master_statusstudent_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $master_statusstudent_add->ShowPageHeader(); ?>
<?php
$master_statusstudent_add->ShowMessage();
?>
<form name="fmaster_statusstudentadd" id="fmaster_statusstudentadd" class="<?php echo $master_statusstudent_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($master_statusstudent_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $master_statusstudent_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="master_statusstudent">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($master_statusstudent_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if (!ew_IsMobile() && !$master_statusstudent_add->IsModal) { ?>
<div class="ewDesktop">
<?php } ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
<div>
<?php } else { ?>
<div>
<table id="tbl_master_statusstudentadd" class="table table-bordered table-striped ewDesktopTable">
<?php } ?>
<?php if ($master_statusstudent->StatusStudentID->Visible) { // StatusStudentID ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
	<div id="r_StatusStudentID" class="form-group">
		<label id="elh_master_statusstudent_StatusStudentID" for="x_StatusStudentID" class="col-sm-2 control-label ewLabel"><?php echo $master_statusstudent->StatusStudentID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statusstudent->StatusStudentID->CellAttributes() ?>>
<span id="el_master_statusstudent_StatusStudentID">
<input type="text" data-table="master_statusstudent" data-field="x_StatusStudentID" name="x_StatusStudentID" id="x_StatusStudentID" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($master_statusstudent->StatusStudentID->getPlaceHolder()) ?>" value="<?php echo $master_statusstudent->StatusStudentID->EditValue ?>"<?php echo $master_statusstudent->StatusStudentID->EditAttributes() ?>>
</span>
<?php echo $master_statusstudent->StatusStudentID->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_StatusStudentID">
		<td><span id="elh_master_statusstudent_StatusStudentID"><?php echo $master_statusstudent->StatusStudentID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statusstudent->StatusStudentID->CellAttributes() ?>>
<span id="el_master_statusstudent_StatusStudentID">
<input type="text" data-table="master_statusstudent" data-field="x_StatusStudentID" name="x_StatusStudentID" id="x_StatusStudentID" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($master_statusstudent->StatusStudentID->getPlaceHolder()) ?>" value="<?php echo $master_statusstudent->StatusStudentID->EditValue ?>"<?php echo $master_statusstudent->StatusStudentID->EditAttributes() ?>>
</span>
<?php echo $master_statusstudent->StatusStudentID->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statusstudent->Nama->Visible) { // Nama ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
	<div id="r_Nama" class="form-group">
		<label id="elh_master_statusstudent_Nama" for="x_Nama" class="col-sm-2 control-label ewLabel"><?php echo $master_statusstudent->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statusstudent->Nama->CellAttributes() ?>>
<span id="el_master_statusstudent_Nama">
<input type="text" data-table="master_statusstudent" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($master_statusstudent->Nama->getPlaceHolder()) ?>" value="<?php echo $master_statusstudent->Nama->EditValue ?>"<?php echo $master_statusstudent->Nama->EditAttributes() ?>>
</span>
<?php echo $master_statusstudent->Nama->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nama">
		<td><span id="elh_master_statusstudent_Nama"><?php echo $master_statusstudent->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statusstudent->Nama->CellAttributes() ?>>
<span id="el_master_statusstudent_Nama">
<input type="text" data-table="master_statusstudent" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($master_statusstudent->Nama->getPlaceHolder()) ?>" value="<?php echo $master_statusstudent->Nama->EditValue ?>"<?php echo $master_statusstudent->Nama->EditAttributes() ?>>
</span>
<?php echo $master_statusstudent->Nama->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statusstudent->Nilai->Visible) { // Nilai ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
	<div id="r_Nilai" class="form-group">
		<label id="elh_master_statusstudent_Nilai" for="x_Nilai" class="col-sm-2 control-label ewLabel"><?php echo $master_statusstudent->Nilai->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statusstudent->Nilai->CellAttributes() ?>>
<span id="el_master_statusstudent_Nilai">
<input type="text" data-table="master_statusstudent" data-field="x_Nilai" name="x_Nilai" id="x_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($master_statusstudent->Nilai->getPlaceHolder()) ?>" value="<?php echo $master_statusstudent->Nilai->EditValue ?>"<?php echo $master_statusstudent->Nilai->EditAttributes() ?>>
</span>
<?php echo $master_statusstudent->Nilai->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Nilai">
		<td><span id="elh_master_statusstudent_Nilai"><?php echo $master_statusstudent->Nilai->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statusstudent->Nilai->CellAttributes() ?>>
<span id="el_master_statusstudent_Nilai">
<input type="text" data-table="master_statusstudent" data-field="x_Nilai" name="x_Nilai" id="x_Nilai" size="30" placeholder="<?php echo ew_HtmlEncode($master_statusstudent->Nilai->getPlaceHolder()) ?>" value="<?php echo $master_statusstudent->Nilai->EditValue ?>"<?php echo $master_statusstudent->Nilai->EditAttributes() ?>>
</span>
<?php echo $master_statusstudent->Nilai->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statusstudent->Keluar->Visible) { // Keluar ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
	<div id="r_Keluar" class="form-group">
		<label id="elh_master_statusstudent_Keluar" class="col-sm-2 control-label ewLabel"><?php echo $master_statusstudent->Keluar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statusstudent->Keluar->CellAttributes() ?>>
<span id="el_master_statusstudent_Keluar">
<div id="tp_x_Keluar" class="ewTemplate"><input type="radio" data-table="master_statusstudent" data-field="x_Keluar" data-value-separator="<?php echo $master_statusstudent->Keluar->DisplayValueSeparatorAttribute() ?>" name="x_Keluar" id="x_Keluar" value="{value}"<?php echo $master_statusstudent->Keluar->EditAttributes() ?>></div>
<div id="dsl_x_Keluar" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statusstudent->Keluar->RadioButtonListHtml(FALSE, "x_Keluar") ?>
</div></div>
</span>
<?php echo $master_statusstudent->Keluar->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Keluar">
		<td><span id="elh_master_statusstudent_Keluar"><?php echo $master_statusstudent->Keluar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statusstudent->Keluar->CellAttributes() ?>>
<span id="el_master_statusstudent_Keluar">
<div id="tp_x_Keluar" class="ewTemplate"><input type="radio" data-table="master_statusstudent" data-field="x_Keluar" data-value-separator="<?php echo $master_statusstudent->Keluar->DisplayValueSeparatorAttribute() ?>" name="x_Keluar" id="x_Keluar" value="{value}"<?php echo $master_statusstudent->Keluar->EditAttributes() ?>></div>
<div id="dsl_x_Keluar" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statusstudent->Keluar->RadioButtonListHtml(FALSE, "x_Keluar") ?>
</div></div>
</span>
<?php echo $master_statusstudent->Keluar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statusstudent->Def->Visible) { // Def ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
	<div id="r_Def" class="form-group">
		<label id="elh_master_statusstudent_Def" class="col-sm-2 control-label ewLabel"><?php echo $master_statusstudent->Def->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statusstudent->Def->CellAttributes() ?>>
<span id="el_master_statusstudent_Def">
<div id="tp_x_Def" class="ewTemplate"><input type="radio" data-table="master_statusstudent" data-field="x_Def" data-value-separator="<?php echo $master_statusstudent->Def->DisplayValueSeparatorAttribute() ?>" name="x_Def" id="x_Def" value="{value}"<?php echo $master_statusstudent->Def->EditAttributes() ?>></div>
<div id="dsl_x_Def" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statusstudent->Def->RadioButtonListHtml(FALSE, "x_Def") ?>
</div></div>
</span>
<?php echo $master_statusstudent->Def->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Def">
		<td><span id="elh_master_statusstudent_Def"><?php echo $master_statusstudent->Def->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statusstudent->Def->CellAttributes() ?>>
<span id="el_master_statusstudent_Def">
<div id="tp_x_Def" class="ewTemplate"><input type="radio" data-table="master_statusstudent" data-field="x_Def" data-value-separator="<?php echo $master_statusstudent->Def->DisplayValueSeparatorAttribute() ?>" name="x_Def" id="x_Def" value="{value}"<?php echo $master_statusstudent->Def->EditAttributes() ?>></div>
<div id="dsl_x_Def" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statusstudent->Def->RadioButtonListHtml(FALSE, "x_Def") ?>
</div></div>
</span>
<?php echo $master_statusstudent->Def->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statusstudent->Lulus->Visible) { // Lulus ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
	<div id="r_Lulus" class="form-group">
		<label id="elh_master_statusstudent_Lulus" class="col-sm-2 control-label ewLabel"><?php echo $master_statusstudent->Lulus->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statusstudent->Lulus->CellAttributes() ?>>
<span id="el_master_statusstudent_Lulus">
<div id="tp_x_Lulus" class="ewTemplate"><input type="radio" data-table="master_statusstudent" data-field="x_Lulus" data-value-separator="<?php echo $master_statusstudent->Lulus->DisplayValueSeparatorAttribute() ?>" name="x_Lulus" id="x_Lulus" value="{value}"<?php echo $master_statusstudent->Lulus->EditAttributes() ?>></div>
<div id="dsl_x_Lulus" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statusstudent->Lulus->RadioButtonListHtml(FALSE, "x_Lulus") ?>
</div></div>
</span>
<?php echo $master_statusstudent->Lulus->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Lulus">
		<td><span id="elh_master_statusstudent_Lulus"><?php echo $master_statusstudent->Lulus->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statusstudent->Lulus->CellAttributes() ?>>
<span id="el_master_statusstudent_Lulus">
<div id="tp_x_Lulus" class="ewTemplate"><input type="radio" data-table="master_statusstudent" data-field="x_Lulus" data-value-separator="<?php echo $master_statusstudent->Lulus->DisplayValueSeparatorAttribute() ?>" name="x_Lulus" id="x_Lulus" value="{value}"<?php echo $master_statusstudent->Lulus->EditAttributes() ?>></div>
<div id="dsl_x_Lulus" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statusstudent->Lulus->RadioButtonListHtml(FALSE, "x_Lulus") ?>
</div></div>
</span>
<?php echo $master_statusstudent->Lulus->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($master_statusstudent->NA->Visible) { // NA ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
	<div id="r_NA" class="form-group">
		<label id="elh_master_statusstudent_NA" class="col-sm-2 control-label ewLabel"><?php echo $master_statusstudent->NA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $master_statusstudent->NA->CellAttributes() ?>>
<span id="el_master_statusstudent_NA">
<div id="tp_x_NA" class="ewTemplate"><input type="radio" data-table="master_statusstudent" data-field="x_NA" data-value-separator="<?php echo $master_statusstudent->NA->DisplayValueSeparatorAttribute() ?>" name="x_NA" id="x_NA" value="{value}"<?php echo $master_statusstudent->NA->EditAttributes() ?>></div>
<div id="dsl_x_NA" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statusstudent->NA->RadioButtonListHtml(FALSE, "x_NA") ?>
</div></div>
</span>
<?php echo $master_statusstudent->NA->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_NA">
		<td><span id="elh_master_statusstudent_NA"><?php echo $master_statusstudent->NA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $master_statusstudent->NA->CellAttributes() ?>>
<span id="el_master_statusstudent_NA">
<div id="tp_x_NA" class="ewTemplate"><input type="radio" data-table="master_statusstudent" data-field="x_NA" data-value-separator="<?php echo $master_statusstudent->NA->DisplayValueSeparatorAttribute() ?>" name="x_NA" id="x_NA" value="{value}"<?php echo $master_statusstudent->NA->EditAttributes() ?>></div>
<div id="dsl_x_NA" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $master_statusstudent->NA->RadioButtonListHtml(FALSE, "x_NA") ?>
</div></div>
</span>
<?php echo $master_statusstudent->NA->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if (ew_IsMobile() || $master_statusstudent_add->IsModal) { ?>
</div>
<?php } else { ?>
</table>
</div>
<?php } ?>
<?php if (!$master_statusstudent_add->IsModal) { ?>
<div class="ewDesktopButton">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $master_statusstudent_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fmaster_statusstudentadd.Init();
</script>
<?php
$master_statusstudent_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$master_statusstudent_add->Page_Terminate();
?>
