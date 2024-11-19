FROM mysql:latest

COPY my.cnf /etc/mysql/conf.d/my.cnf

RUN chown -R mysql:mysql /etc/mysql/conf.d/my.cnf

HEALTHCHECK --interval=10s --timeout=5s --retries=5 \
    CMD mysqladmin ping -h localhost -u root -p$MYSQL_ROOT_PASSWORD

CMD ["mysqld", "--character-set-server=utf8mb4", "--collation-server=utf8mb4_unicode_ci"]
