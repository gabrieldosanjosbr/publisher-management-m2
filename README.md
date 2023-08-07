# Bis2Bis Project (Technical Assessment Test)
## _Publisher Management Module (Magento 2)_

Publisher Manager

## Features

- List/Create/Delete/Update Publisher
- Assign Product to Publisher
- Publisher Logo Upload

## Tech

Publisher Management uses a number of open source projects to work properly:

- [Docker] - containerization platform to install and deploy without host dependency.
- [Magento 2] - E-commerce platform.
- [Nginx] - Web server that can also be used as a reverse proxy, load balancer, mail proxy and HTTP cache.
- [MariaDB] - Community-developed, commercially supported fork of the MySQL relational database management system.

## Installation

Publisher Management requires [Docker] v20+ and [Docker Compose] v2+ to run.

Install the requirements, clone repository and deploy.

```sh
git clone git@github.com:gabrieldosanjosbr/publisher-management-m2.git bis2bis && cd bis2bis
docker-compose up -d
```

The command bellow will ask magento 2 credentials and whether you want to store in auth.json
choose no because it's creating with wrong permissions and breaking the app
```sh
docker exec -it bis2bis-php-1 composer install
```

```sh
docker exec -it bis2bis-php-1 bin/magento setup:install \
--base-url=http://bis2bis.bookstore \
--db-host=bis2bis-mariadb-1 \
--db-name=magento2 \
--db-user=bis2bis \
--db-password=123123 \
--admin-firstname=admin \
--admin-lastname=admin \
--admin-email=admin@admin.com \
--admin-user=admin \
--admin-password=admin123 \
--language=en_US \
--currency=USD \
--timezone=America/Sao_Paulo \
--use-rewrites=1 \
--search-engine=opensearch \
--opensearch-host=bis2bis-opensearch-1 \
--opensearch-port=9200 

echo "127.0.0.1 bis2bis.bookstore" >> /etc/hosts

docker exec -it bis2bis-php-1 bin/magento module:disable {Magento_AdminAdobeImsTwoFactorAuth,Magento_TwoFactorAuth}
docker exec -it bis2bis-php-1 bin/magento indexer:reindex
docker exec -it bis2bis-php-1 bin/magento s:up
docker exec -it bis2bis-php-1 bin/magento s:d:c
docker exec -it bis2bis-php-1 bin/magento s:s:d -f
docker exec -it bis2bis-php-1 bin/magento c:c

sudo chmod -R 777 var/ generated/ pub/media
```

## Usage

- Menu > Catalog > Publishers

```sh
http://bis2bis.bookstore
```


## License

MIT

[Docker]: <https://www.docker.com/>
[Magento 2]: <https://devdocs.magento.com/>
[Nginx]: <https://www.nginx.com/>
[MariaDB]: <https://mariadb.org/>
[Docker Compose]: <https://docs.docker.com/compose/>
