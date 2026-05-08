<?php
/**
 * Error Logging System
 * Comprehensive error logging for debugging and monitoring
 */

// Create log directory if it doesn't exist
if (!file_exists(LOG_PATH)) {
    mkdir(LOG_PATH, 0755, true);
}

/**
 * Log levels
 */
define('LOG_LEVEL_ERROR', 1);
define('LOG_LEVEL_WARNING', 2);
define('LOG_LEVEL_INFO', 3);
define('LOG_LEVEL_DEBUG', 4);
define('LOG_LEVEL_ALL', 5);

/**
 * Get numeric log level from string
 * @param string $level The log level string
 * @return int Numeric log level
 */
function getLogLevel($level) {
    switch (strtolower($level)) {
        case 'error': return LOG_LEVEL_ERROR;
        case 'warning': return LOG_LEVEL_WARNING;
        case 'info': return LOG_LEVEL_INFO;
        case 'debug': return LOG_LEVEL_DEBUG;
        default: return LOG_LEVEL_ALL;
    }
}

/**
 * Log a message to the error log file
 * @param string $message The message to log
 * @param string $level The log level (error, warning, info, debug)
 * @param string $context Additional context information
 * @return bool True if logged successfully
 */
function logMessage($message, $level = 'error', $context = '') {
    if (!LOG_ERRORS) {
        return false;
    }
    
    // Check if this level should be logged
    $currentLevel = getLogLevel(LOG_LEVEL);
    $messageLevel = getLogLevel($level);
    
    if ($messageLevel > $currentLevel) {
        return false;
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $userId = $_SESSION['user_id'] ?? 'guest';
    $requestUri = $_SERVER['REQUEST_URI'] ?? 'cli';
    
    // Format the log entry
    $logEntry = sprintf(
        "[%s] [%s] [IP:%s] [User:%s] [%s] %s",
        $timestamp,
        strtoupper($level),
        $ip,
        $userId,
        $requestUri,
        $message
    );
    
    if (!empty($context)) {
        $logEntry .= " | Context: " . (is_array($context) ? json_encode($context) : $context);
    }
    
    $logEntry .= PHP_EOL;
    
    // Determine log file name based on level
    $logFile = LOG_PATH . '/' . date('Y-m-d') . '_' . strtolower($level) . '.log';
    
    // Write to log file
    return error_log($logEntry, 3, $logFile);
}

/**
 * Log an error message
 * @param string $message The error message
 * @param string $context Additional context
 * @return bool True if logged
 */
function logError($message, $context = '') {
    return logMessage($message, 'error', $context);
}

/**
 * Log a warning message
 * @param string $message The warning message
 * @param string $context Additional context
 * @return bool True if logged
 */
function logWarning($message, $context = '') {
    return logMessage($message, 'warning', $context);
}

/**
 * Log an info message
 * @param string $message The info message
 * @param string $context Additional context
 * @return bool True if logged
 */
function logInfo($message, $context = '') {
    return logMessage($message, 'info', $context);
}

/**
 * Log a debug message
 * @param string $message The debug message
 * @param string $context Additional context
 * @return bool True if logged
 */
function logDebug($message, $context = '') {
    return logMessage($message, 'debug', $context);
}

/**
 * Log an exception
 * @param Exception $exception The exception to log
 * @return bool True if logged
 */
function logException($exception) {
    $context = [
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'trace' => $exception->getTraceAsString(),
        'code' => $exception->getCode(),
        'message' => $exception->getMessage()
    ];
    
    return logError(
        'Uncaught Exception: ' . $exception->getMessage(),
        $context
    );
}

/**
 * Set up custom error handler
 */
function setupErrorHandler() {
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        // Respect error_reporting setting
        if (!(error_reporting() & $errno)) {
            return false;
        }
        
        $errorType = '';
        $logLevel = 'error';
        
        switch ($errno) {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                $errorType = 'Fatal Error';
                $logLevel = 'error';
                break;
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                $errorType = 'Warning';
                $logLevel = 'warning';
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                $errorType = 'Notice';
                $logLevel = 'info';
                break;
            case E_STRICT:
                $errorType = 'Strict';
                $logLevel = 'info';
                break;
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                $errorType = 'Deprecated';
                $logLevel = 'warning';
                break;
            default:
                $errorType = 'Unknown Error';
                $logLevel = 'error';
        }
        
        $message = sprintf(
            "%s: %s in %s on line %d",
            $errorType,
            $errstr,
            $errfile,
            $errline
        );
        
        logMessage($message, $logLevel);
        
        // Don't execute PHP internal error handler
        return true;
    });
    
    // Set up exception handler
    set_exception_handler(function($exception) {
        logException($exception);
        
        // In production, show generic error message
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            echo '<pre>' . htmlspecialchars($exception, ENT_QUOTES, 'UTF-8') . '</pre>';
        } else {
            http_response_code(500);
            echo 'An unexpected error occurred. Please try again later.';
        }
    });
}

// Initialize error handler if not in CLI mode
if (php_sapi_name() !== 'cli') {
    setupErrorHandler();
}
