<?php
class Kajoa_Validate_FileUpload extends Zend_Validate_Abstract
{

    const INI_SIZE   = 'iniSize';   // The uploaded file exceeds the upload_max_filesize directive in php.ini
    const FORM_SIZE  = 'formSize';  // The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the form 
    const PARTIAL    = 'partial';   // The uploaded file was only partially uploaded
    const NO_FILE    = 'noFile';    // No file was uploaded
    const NO_TMP_DIR = 'noTmpDir';  // Missing a temporary folder
    const CANT_WRITE = 'cantWrite'; // Failed to write file to disk
    const EXTENSION  = 'extension'; // File upload stopped by extension. (Introduced in PHP 5.2.0) 
    const ERROR      = 'error';     // General error for future proofing against new PHP versions

    protected $_messageTemplates = array(
        self::INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        self::FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the form',
        self::PARTIAL    => 'The uploaded file was only partially uploaded',
        self::NO_FILE    => 'No file was uploaded',
        self::NO_TMP_DIR => 'Missing a temporary folder',
        self::CANT_WRITE => 'Failed to write file to disk',
        self::EXTENSION  => 'File upload stopped by extension',
        self::ERROR      => 'Uknown upload error',
    );
    
    protected $_strictMode;

    public function __construct($strictMode = false)
    {
        $this->_strictMode = $strictMode;
    }
    
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value[error] is equal to UPLOAD_ERR_OK.
     * 
     * @param array $value
     * @return boolean
     */
    public function isValid($value)
    {
        $valueString = '';
        $error       = UPLOAD_ERR_NO_FILE;
        
        if((is_array($value) || $value instanceof ArrayObject) 
            && array_key_exists('error', $value)) {
            // Set the error to the correct value
            $error = $value['error'];
            
            // Set the %value% placeholder to the uploaded filename
            $valueString = $value['name'];
        }
        $this->_setValue($valueString);

        $result = false;
        switch($error) {
            case UPLOAD_ERR_OK:
                $result = true;
                break;

            case UPLOAD_ERR_INI_SIZE:
                $this->_error(self::INI_SIZE);
                break;
                
            case UPLOAD_ERR_FORM_SIZE:
                $this->_error(self::FORM_SIZE);
                break;
                
            case UPLOAD_ERR_PARTIAL:
                $this->_error(self::PARTIAL);
                break;
                
            case UPLOAD_ERR_NO_FILE:
                if ($this->_strictMode) {
                    $this->_error(self::NO_FILE);
                } else {
                    $result = true;
                }
                break;
                
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->_error(self::NO_TMP_DIR);
                break;
                
            case UPLOAD_ERR_CANT_WRITE:
                $this->_error(self::CANT_WRITE);
                break;
                
            case 8: // UPLOAD_ERR_EXTENSION isn't defined in PHP 5.1.4, so use the value
                $this->_error(self::EXTENSION);
                break;
                
            default:
                $this->_error(self::ERROR);
                break;
        }

        return $result;
    }
}
