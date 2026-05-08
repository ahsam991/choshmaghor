<?php
// Memory Context Processing (MCP) for Performance Tracking

class MCP {
    private static $startTime = 0;
    private static $startMemory = 0;
    private static $queryLog = [];

    public static function start() {
        self::$startTime = microtime(true);
        self::$startMemory = memory_get_usage();
    }

    public static function logQuery($query, $duration = 0) {
        self::$queryLog[] = [
            'query' => $query,
            'duration' => $duration
        ];
    }

    public static function getMetrics() {
        $endTime = microtime(true);
        $endMemory = memory_get_usage();

        $executionTimeMs = round(($endTime - self::$startTime) * 1000, 2);
        $memoryUsedMb = round(($endMemory - self::$startMemory) / 1048576, 2);

        return [
            'execution_time_ms' => $executionTimeMs,
            'memory_used_mb' => $memoryUsedMb,
            'total_queries' => count(self::$queryLog),
            'queries' => self::$queryLog
        ];
    }

    public static function saveLog() {
        $metrics = self::getMetrics();
        $logEntry = date('Y-m-d H:i:s') . " | Exec Time: {$metrics['execution_time_ms']}ms | Mem: {$metrics['memory_used_mb']}MB | Queries: {$metrics['total_queries']} | URI: {$_SERVER['REQUEST_URI']}\n";
        
        $logDir = APP_PATH . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        file_put_contents($logDir . '/mcp_performance.log', $logEntry, FILE_APPEND);
    }
}
