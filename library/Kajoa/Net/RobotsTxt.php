<?php
/**
This class refers to the following specifications :
    - A Standard for Robot Exclusion (http://www.robotstxt.org/orig.html)
    - A Method for Web Robots Control (http://www.robotstxt.org/norobots-rfc.txt)
*/
class Kajoa_Net_RobotsTxt
{
    const VERSION_ORIGINAL_SPECIFICATION  = 1;
    const VERSION_NON_STANDARD_EXTENSIONS = 2;
    const VERSION_ALL_VERSIONS            = 3;
    
    protected $_errors = array();
    protected $_rawData     = '';
    protected $_records     = array();

    protected function _addError($message, $line, $version)
    {
        $this->_errors[] = array(
            'line'    => $line,
            'message' => $message, 
            'version'   => $version,
        );
    }
    
    protected function _checkAllowValue($value, $lineNumber)
    {
        // Disallow is not part of the original specification
        $this->_addError("'Allow' is not a valid directive", $lineNumber,
                         self::VERSION_ORIGINAL_SPECIFICATION);
    
        // * is not a standard value for Allow directive
        if ('*' == $value) {
            $message  = "'*' is not a standard value for Allow directive,";
            $message .= " value '/' substituted";
            $this->_addError($message, $lineNumber,
                             self::VERSION_NON_STANDARD_EXTENSIONS);
            return '/';
        }

        return $this->_decodePath($value);
    }
    
    protected function _checkCrawlDelayValue($value, $lineNumber)
    {
        // Crawl-delay is not part of the original specification
        $this->_addError("'Crawl-delay' is not a valid directive", $lineNumber,
                         self::VERSION_ORIGINAL_SPECIFICATION);
    
        // Value of Crawl-delay directive should be an integer
        $validator = new Zend_Validate_Int();
        if (!$validator->isValid($value)) {
            $message  = 'Value of Crawl-delay directive should be an integer, ';
            $message .= 'ignoring the directive';
            $this->_addError($message, $lineNumber,
                             self::VERSION_NON_STANDARD_EXTENSIONS);
            return false;
        }

        return (int) $value;
    }
    
    protected function _checkDisallowValue($value, $lineNumber)
    {
        // * is not a standard value for Disallow directive
        if ('*' == $value) {
            $message  = "'*' is not a standard value for Disallow directive, ";
            $message .= "value '/' substituted";
            $this->_addError($message, $lineNumber, self::VERSION_ALL_VERSIONS);
            return '/';
        }

        return $this->_decodePath($value);
    }
    
    protected function _checkSitemapValue($value, $lineNumber)
    {
        // Sitemap is not part of the original specification
        $this->_addError("'Sitemap' is not a valid directive", $lineNumber,
                         self::VERSION_ORIGINAL_SPECIFICATION);
    
        // Value should be a the complete URL to the sitemap
        $urlParts   = @parse_url($value);
        $isUrlValid = (false !== $urlParts)
                      && !empty($urlParts['scheme'])
                      && !empty($urlParts['host'])
                      && !empty($urlParts['path']);
        if ($isUrlValid) {
            require_once 'Zend/Validate/Hostname.php';
            $options    = Zend_Validate_Hostname::ALLOW_DNS |
                          Zend_Validate_Hostname::ALLOW_IP;
            $validator  = new Zend_Validate_Hostname($options);
            $isUrlValid = $validator->isValid($urlParts['host']);
            unset($validator);
        }
                      
        if (!$isUrlValid) {
            $message  = 'Value of Sitemap directive should be a the complete ';
            $message .= 'URL to the sitemap'; 
            $this->_addError($message, $lineNumber,
                             self::VERSION_NON_STANDARD_EXTENSIONS);
        }

        return $value;
    }
    
    protected function _decodePath($path)
    {
        $code  = 'return "%2f" == strtolower($matches[0]) ? $matches[0] : ';
        $code .= 'urldecode($matches[0]);';
        
        $function = create_function('$matches', $code);
    
        return preg_replace_callback('/%[0-9A-Fa-f]{2}/', $function, $path);    
    }
    
    protected function _getDirectives($userAgent)
    {
        $directives          = array();
        $matchingRecordFound = false;
    
        foreach ($this->_records as $record) {
            foreach ($record as $line) {
                if ('user-agent' == strtolower($line['name'])) {
                    if (false !== stripos($line['value'], $userAgent)) {
                        $matchingRecordFound = true; 
                    }
                } elseif ($matchingRecordFound) {
                    $directives[] = $line;
                }
            }
            if ($matchingRecordFound) {
                break;
            }
        }
        
        return $directives;
    }
    
    protected function _parse($data)
    {
        $this->_errors  = array();
        $this->_rawData = $data;
        $this->_records = array();

        // An empty robots.txt file should be ignored
        if (empty($data)) {
            return;
        }
        
        // Substitute newline to carriage return and carriage return/newline
        $data = str_replace(array("\r\n", "\r"), "\n", $data);
        
        // Split the data into lines
        $lines = explode("\n", $data);
        
        // Iterate through the lines
        $record                     = array();
        $nonUserAgentDirectiveFound = false;
        foreach ($lines as $lineNumber => $line) {
        
            // Suppress comments
            $position = strpos($line, '#');
            if (false !== $position) {
                $line = substr($line, 0, $position);    
            }
        
            // Handle empty line
            if (empty($line)) {
                // If inside a record it means its end
                if (!empty($record)) {
                    $this->_records[]           = $record;
                    $record                     = array();
                    $nonUserAgentDirectiveFound = false;
                }
                continue;
            }
            
            // Extract the directive name and value
            $position = strpos($line, ':');
            if (false === $position) {
                $this->_addError("Bad format for line '$line'", $lineNumber,
                                 self::VERSION_ALL_VERSIONS);            
                continue;
            }        

            // Extract and format directive name
            $directiveName = substr($line, 0, $position);
            $directiveName = trim($directiveName);
            $directiveName = strtolower($directiveName);
            $directiveName = ucfirst($directiveName);
            
            // All User-agent directives must appear before any other directives
            if ('User-agent' == $directiveName && $nonUserAgentDirectiveFound) {
                $message  = 'All User-agent directives must appear before any ';
                $message .= 'other directives, ignoring it';
                $this->_addError($message, $lineNumber,
                                 self::VERSION_ALL_VERSIONS);
                continue;            
            }

            // Extract and format value
            $directiveValue = trim(substr($line, $position + 1));
            
            // Has a non User-agent directive been found yet ? 
            if ('User-agent' != $directiveName) {
                $nonUserAgentDirectiveFound = true;
            }
            
            // Check directive name and value
            switch($directiveName) {
                case 'Allow':
                    $directiveValue = $this->_checkAllowValue($directiveValue, $lineNumber);                    
                    break;
                    
                case 'Crawl-delay':
                    $directiveValue = $this->_checkCrawlDelayValue($directiveValue, $lineNumber);                    
                    break;

                case 'Disallow':
                    $directiveValue = $this->_checkDisallowValue($directiveValue, $lineNumber);                    
                    break;
                    
                case 'Sitemap':
                    $directiveValue = $this->_checkSitemapValue($directiveValue, $lineNumber);                    
                    break;
                    
                case 'User-agent':
                    break;
                    
                default:
                    $this->_addError("'$directiveName' is not a valid directive",
                                     $lineNumber, self::VERSION_ALL_VERSIONS);
                    break;
            }
            
            // Ignore the directive if the value is invalide
            if (false === $directiveValue) {
                continue;
            }
            
            // Add the directive to the current record
            $record[] = array(
                'name'  => $directiveName,
                'value' => $directiveValue,
            );
        }
        
        // Add the last record if it is not followed by an empty line
        // and thus has not been added
        if (!empty($record)) {
            $this->_records[] = $record;
        }
    }
    
    public function getApplicableDirectives($userAgent)
    {
        // Look for a user agent specific applicable directives
        $directives = $this->_getDirectives($userAgent);
        
        // Look for default applicable directives
        if (empty($directives)) {
            $directives = $this->_getDirectives('*');
        }
        
        return $directives;
    }
    
    public function getCrawlDelay($userAgent)
    {
        $crawlDelay = 0;
        $directives = $this->getApplicableDirectives($userAgent);
        foreach ($directives as $directive) {
            // Ignore directive other than Allow and Disallow
            if ('Crawl-delay' != $directive['name']) {
                continue;    
            }
            
            $crawlDelay = $directive['value'];
            break;
        }
        return $crawlDelay;
    }    
    
    public function getErrors($version = self::VERSION_ORIGINAL_SPECIFICATION)
    {
        $errors = array();
        foreach ($this->_errors as $error) {
            if ($version & $error['version']) {
                $errors[] = $error;
            }
        }
        return $errors;
    }
    
    public function getRecords()
    {
        return $this->_records;
    }
    
    public function isAccessAllowed($userAgent, $path)
    {
        // /robots.txt is always allowed for logical reasons
        if ('/robots.txt' == $path) {
            return true;
        }
    
        // Decode encoded characters in the path value except slashes
        $path = $this->_decodePath($path);
            
        $directives = $this->getApplicableDirectives($userAgent);
        foreach ($directives as $directive) {
            // Ignore directive other than Allow and Disallow
            if ('Allow' != $directive['name'] &&
                'Disallow' != $directive['name']) {
                continue;    
            }
            
            // In the first specification an empty value for the Disallow
            // directive meant that access to all pages is allowed
            if ('Disallow' == $directive['name'] &&
                empty($directive['value'])) {
                return true;
            }

            // The match evaluates positively if and only if the end of
            // the path from the record is reached before a difference
            // in octets is encountered
            $length = strlen($directive['value']);
            if (substr($directive['value'], 0, $length) == substr($path, 0, $length)) {
                return 'Allow' == $directive['name'];
            }
        }
        
        // No specific directive has been found so access is allowed
        return true;
    }
    
    public function isValid($version = self::VERSION_ORIGINAL_SPECIFICATION)
    {
        if (self::VERSION_ALL_VERSIONS == $version) {
            $message  = 'VERSION_ALL_VERSIONS constant can not be used in ';
            $message .= 'this function';
            throw new Exception($message);
        }
    
        $valid = true;
        foreach ($this->_errors as $error) {
            if ($version & $error['version']) {
                $valid = false;
                break;            
            }
        }
        
        return $valid;
    }
        
    public function loadFromFile($filename)
    {
        $data = file_get_contents($filename);
        
        if (false === $data) {
            throw new Exception("File '$filename'' could not be opened");
        }
    
        $this->_parse($data);
    }
    
    public function loadFromString($data)
    {
        $this->_parse($data);
    }
}