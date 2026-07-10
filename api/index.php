<?php
header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');

$APP_VERSION = getenv('APP_VERSION') ?: 'dev';
$DEPLOYED_AT = getenv('DEPLOYED_AT') ?: 'unknown';

switch ($uri) {
    case '':
    case '/api':
        http_response_code(200);
        echo json_encode([
            'message' => 'Windbag REST API',
            'status'  => 'running',
            'environment' => 'cloud',
            'endpoints' => [
                'GET /api/health',
                'GET /api/info',
                'GET /api/status',
                'GET /api/dhcp-renew',
                'GET /api/dhcp-clients',
                'GET /api/bitacora'
            ]
        ], JSON_PRETTY_PRINT);
        break;

    case '/api/health':
        http_response_code(200);
        echo json_encode([
            'status'  => 'ok',
            'uptime'  => shell_exec('uptime -p') ?: 'unavailable',
            'time'    => date('c')
        ], JSON_PRETTY_PRINT);
        break;

    case '/api/info':
        http_response_code(200);
        echo json_encode([
            'service'     => 'windbag-api',
            'version'     => $APP_VERSION,
            'deployed_at' => $DEPLOYED_AT,
            'hostname'    => gethostname(),
            'php_version' => PHP_VERSION,
            'environment' => 'cloud (containerized)'
        ], JSON_PRETTY_PRINT);
        break;

    case '/api/status':
        http_response_code(200);
        echo json_encode(simulatedLog('api-status'), JSON_PRETTY_PRINT);
        break;

    case '/api/dhcp-renew':
        http_response_code(200);
        echo json_encode(simulatedLog('dhcp-renew'), JSON_PRETTY_PRINT);
        break;

    case '/api/dhcp-clients':
        http_response_code(200);
        echo json_encode(simulatedLog('dhcp-clients'), JSON_PRETTY_PRINT);
        break;

    case '/api/bitacora':
        http_response_code(200);
        echo json_encode(simulatedLog('bitacora'), JSON_PRETTY_PRINT);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Route not found', 'code' => 404], JSON_PRETTY_PRINT);
        break;
}

function simulatedLog(string $type): array {
    $samples = [
        'api-status' => [
            '2026-07-02 10:00:12 | OK | HTTP 200',
            '2026-07-02 10:00:42 | OK | HTTP 200',
            '2026-07-02 10:01:12 | OK | HTTP 200'
        ],
        'dhcp-renew' => [
            '2026-07-02 10:00:00 | Reassigned IPs (3): 172.30.40.11 172.30.40.12 172.30.40.13',
            '2026-07-02 10:01:00 | Reassigned IPs (3): 172.30.40.11 172.30.40.12 172.30.40.13'
        ],
        'dhcp-clients' => [
            '2026-07-02 10:00:00 | Connected clients: 3',
            '2026-07-02 10:02:00 | Connected clients: 4'
        ],
        'bitacora' => [
            '2026-07-02 10:00:15 | IP: 172.30.40.11 | MAC: 08:00:27:aa:bb:cc | OS: Ubuntu',
            '2026-07-02 10:00:47 | IP: 172.30.40.12 | MAC: 08:00:27:dd:ee:ff | OS: Unknown'
        ]
    ];
    return [
        'source' => 'simulated',
        'note'   => 'Live data is produced by systemd services on the on-premise server. This cloud endpoint returns representative sample records.',
        'total'  => count($samples[$type] ?? []),
        'records'=> $samples[$type] ?? []
    ];
}