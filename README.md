# ARC Proyecto — Infraestructura On-Premise y Cloud

Solución de infraestructura en dos fases para una compañía ficticia de seguros e inversiones en criptomonedas, desarrollada como proyecto final del curso Arquitectura de Computadoras — UCA 2026.

## Fases del proyecto

**Fase 0 — Verificación del entorno local:** Validación de todos los servicios on-premise antes de iniciar la migración a la nube.

**Fase 1 — On-premise:** Servidor Ubuntu en VirtualBox con red segmentada mediante VLSM (172.30.40.0/22), servicios DHCP, DNS, web HTTPS, API REST, FTP, enrutamiento NAT y monitoreo por scripting Bash con systemd.

**Fase 2 — Contenerización:** Los servicios de la Fase 1 empaquetados como imágenes Docker publicadas en Docker Hub.

**Fase 3 — Despliegue en la nube:** Contenedores desplegados en DigitalOcean con Nginx como proxy inverso, dominio DuckDNS y HTTPS real con Let's Encrypt.

**Fase 4 — CI/CD:** Pipeline automatizado con GitHub Actions separado en integración continua y despliegue continuo.

**Fase 5 — Monitoreo:** Uptime Kuma desplegado como contenedor con su propio subdominio y HTTPS.

## Servicios en producción

| Servicio    | URL                                        |
|-------------|--------------------------------------------|
| API REST    | https://arc-proyecto.duckdns.org/api/      |
| Windbag Web | https://arc-proyecto.duckdns.org/windbag/  |
| Crypto Web  | https://arc-proyecto.duckdns.org/crypto/   |
| Monitoreo   | https://status-arc-proyecto.duckdns.org    |

## Estructura del repositorio

- api/ — API REST en PHP (index.php, .htaccess, Dockerfile)
- web-windbag/ — Sitio web Windbag (index.html, Dockerfile)
- web-crypto/ — Sitio web Crypto (index.html, Dockerfile)
- monitoring/ — Documentación del monitoreo con Uptime Kuma
- docker-compose.yml — Orquestación local de desarrollo
- .github/workflows/ci.yml — Integración continua
- .github/workflows/cd.yml — Despliegue continuo

## Pipeline CI/CD

Cada push a `main` dispara automáticamente:

1. **CI** — construye las tres imágenes Docker y las publica en Docker Hub
2. **CD** — se conecta al droplet por SSH, hace pull de las imágenes y redespliega con docker compose

## Stack tecnológico

- **On-premise:** Ubuntu Server, isc-dhcp-server, BIND9, Apache, PHP, vsftpd, iptables, systemd
- **Contenedores:** Docker, Docker Compose, Docker Hub
- **Cloud:** DigitalOcean, Nginx, Let's Encrypt, DuckDNS
- **CI/CD:** GitHub Actions
- **Monitoreo:** Uptime Kuma

## Autores

- Juan Carlos Amaya Hernández 00365123
- Danilo Isaac Iraheta Menjívar 00377223

Universidad Centroamericana (UCA) — Ciclo 01, 2026