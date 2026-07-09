# Monitoring

Uptime Kuma is deployed as a Docker container on the DigitalOcean droplet.
It is accessible at: https://status-arc-proyecto.duckdns.org

## Monitored services

| Service         | URL                                              | Interval |
|-----------------|--------------------------------------------------|----------|
| Windbag API     | https://arc-proyecto.duckdns.org/api/health      | 60s      |
| Windbag Web     | https://arc-proyecto.duckdns.org/windbag/        | 60s      |
| Crypto Web      | https://arc-proyecto.duckdns.org/crypto/         | 60s      |

## How to deploy

```bash
docker run -d \
  --name uptime-kuma \
  --restart unless-stopped \
  -p 127.0.0.1:3001:3001 \
  -v uptime-kuma:/app/data \
  louislam/uptime-kuma:latest
```

Nginx proxies the dashboard through HTTPS — no direct port exposure.